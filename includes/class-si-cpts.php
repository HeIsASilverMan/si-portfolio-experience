<?php
defined( 'ABSPATH' ) || exit;

class SI_CPTs {

    public static function init() {
        add_action( 'init',       array( __CLASS__, 'register_portfolio' ) );
        add_action( 'init',       array( __CLASS__, 'register_portfolio_taxonomy' ) );
        add_action( 'init',       array( __CLASS__, 'register_testimonials' ) );
        add_action( 'init',       array( __CLASS__, 'register_enquiries' ) );
        add_action( 'init',       array( __CLASS__, 'register_pricing_services' ) );
        add_action( 'init',       array( __CLASS__, 'register_pricing_tiers' ) );
        add_action( 'add_meta_boxes', array( __CLASS__, 'add_meta_boxes' ) );
        add_action( 'save_post',  array( __CLASS__, 'save_meta' ) );
        // Enquiry admin columns
        add_filter( 'manage_si_enquiry_posts_columns',       array( __CLASS__, 'enquiry_columns' ) );
        add_action( 'manage_si_enquiry_posts_custom_column', array( __CLASS__, 'enquiry_column_content' ), 10, 2 );
        add_filter( 'manage_edit-si_enquiry_sortable_columns', array( __CLASS__, 'enquiry_sortable_columns' ) );
        // Pricing service admin columns
        add_filter( 'manage_si_pricing_service_posts_columns',       array( __CLASS__, 'pricing_service_columns' ) );
        add_action( 'manage_si_pricing_service_posts_custom_column', array( __CLASS__, 'pricing_service_column_content' ), 10, 2 );
        // Pricing tier admin columns
        add_filter( 'manage_si_pricing_tier_posts_columns',       array( __CLASS__, 'pricing_tier_columns' ) );
        add_action( 'manage_si_pricing_tier_posts_custom_column', array( __CLASS__, 'pricing_tier_column_content' ), 10, 2 );
        add_action( 'admin_init', array( __CLASS__, 'maybe_seed_pricing_defaults' ) );
    }

    public static function register_portfolio() {
        $labels = array(
            'name'          => 'Portfolio Projects',
            'singular_name' => 'Portfolio Project',
            'add_new_item'  => 'Add New Project',
            'edit_item'     => 'Edit Project',
            'all_items'     => 'All Projects',
        );
        register_post_type( 'si_portfolio', array(
            'labels'       => $labels,
            'public'       => true,
            'has_archive'  => false,
            'show_in_menu' => true,
            'menu_icon'    => 'dashicons-portfolio',
            'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
            'rewrite'      => array( 'slug' => 'portfolio' ),
        ) );
    }

    public static function register_portfolio_taxonomy() {
        $labels = array(
            'name'          => 'Project Categories',
            'singular_name' => 'Project Category',
            'all_items'     => 'All Categories',
            'edit_item'     => 'Edit Category',
            'add_new_item'  => 'Add New Category',
        );
        register_taxonomy( 'si_portfolio_cat', 'si_portfolio', array(
            'labels'            => $labels,
            'public'            => false,
            'show_ui'           => true,
            'show_in_menu'      => true,
            'hierarchical'      => false,
            'show_admin_column' => true,
            'rewrite'           => false,
        ) );
    }

    public static function register_testimonials() {
        $labels = array(
            'name'          => 'Testimonials',
            'singular_name' => 'Testimonial',
            'add_new_item'  => 'Add New Testimonial',
            'all_items'     => 'All Testimonials',
        );
        register_post_type( 'si_testimonial', array(
            'labels'       => $labels,
            'public'       => false,
            'show_ui'      => true,
            'show_in_menu' => 'edit.php?post_type=si_portfolio',
            'supports'     => array( 'title', 'editor' ),
        ) );
    }

    public static function register_enquiries() {
        $labels = array(
            'name'               => 'Enquiries',
            'singular_name'      => 'Enquiry',
            'all_items'          => 'All Enquiries',
            'view_item'          => 'View Enquiry',
            'search_items'       => 'Search Enquiries',
            'not_found'          => 'No enquiries yet.',
            'not_found_in_trash' => 'No enquiries in trash.',
        );
        register_post_type( 'si_enquiry', array(
            'labels'       => $labels,
            'public'       => false,
            'show_ui'      => true,
            'show_in_menu' => 'edit.php?post_type=si_portfolio',
            'supports'     => array( 'title' ),
            'capabilities' => array(
                'create_posts' => 'do_not_allow',
            ),
            'map_meta_cap' => true,
        ) );
    }

    public static function register_pricing_services() {
        $labels = array(
            'name'          => 'Pricing Services',
            'singular_name' => 'Pricing Service',
            'add_new_item'  => 'Add New Service',
            'edit_item'     => 'Edit Service',
            'all_items'     => 'Pricing Services',
            'menu_name'     => 'Pricing Services',
        );
        register_post_type( 'si_pricing_service', array(
            'labels'       => $labels,
            'public'       => false,
            'show_ui'      => true,
            'show_in_menu' => 'edit.php?post_type=si_portfolio',
            'supports'     => array( 'title', 'page-attributes' ),
        ) );
    }

    public static function register_pricing_tiers() {
        $labels = array(
            'name'          => 'Complexity Tiers',
            'singular_name' => 'Complexity Tier',
            'add_new_item'  => 'Add New Tier',
            'edit_item'     => 'Edit Tier',
            'all_items'     => 'Complexity Tiers',
        );
        register_post_type( 'si_pricing_tier', array(
            'labels'       => $labels,
            'public'       => false,
            'show_ui'      => true,
            'show_in_menu' => 'edit.php?post_type=si_portfolio',
            'supports'     => array( 'title', 'page-attributes' ),
        ) );
    }

    // -------------------------------------------------------
    // Enquiry admin columns
    // -------------------------------------------------------

    public static function enquiry_columns( $cols ) {
        return array(
            'cb'              => $cols['cb'],
            'title'           => 'Subject',
            'si_enq_type'     => 'Type',
            'si_enq_name'     => 'Name',
            'si_enq_email'    => 'Email',
            'si_enq_status'   => 'Status',
            'date'            => 'Received',
        );
    }

    public static function enquiry_column_content( $col, $post_id ) {
        switch ( $col ) {
            case 'si_enq_type':
                $type = get_post_meta( $post_id, '_si_enquiry_type', true );
                echo 'composition' === $type ? 'Composition' : 'Learning Design';
                break;
            case 'si_enq_name':
                echo esc_html( get_post_meta( $post_id, '_si_contact_name', true ) );
                break;
            case 'si_enq_email':
                $e = get_post_meta( $post_id, '_si_contact_email', true );
                if ( $e ) {
                    echo '<a href="mailto:' . esc_attr( $e ) . '">' . esc_html( $e ) . '</a>';
                }
                break;
            case 'si_enq_status':
                $status = get_post_meta( $post_id, '_si_enquiry_status', true );
                $labels = array(
                    'new'     => '<span style="color:#D4A853;font-weight:600;">New</span>',
                    'replied' => '<span style="color:#7DC97D;">Replied</span>',
                    'closed'  => '<span style="color:#888;">Closed</span>',
                );
                if ( isset( $labels[ $status ] ) ) {
                    echo wp_kses( $labels[ $status ], array( 'span' => array( 'style' => array() ) ) );
                } else {
                    echo esc_html( $status );
                }
                break;
        }
    }

    public static function enquiry_sortable_columns( $cols ) {
        $cols['si_enq_status'] = 'si_enq_status';
        $cols['si_enq_type']   = 'si_enq_type';
        return $cols;
    }

    // -------------------------------------------------------
    // Pricing service admin columns
    // -------------------------------------------------------

    public static function pricing_service_columns( $cols ) {
        return array(
            'cb'            => $cols['cb'],
            'title'         => 'Service',
            'si_svc_rate'   => 'Rate',
            'si_svc_unit'   => 'Unit',
            'si_svc_scale'  => 'Complexity-scaled',
            'si_svc_order'  => 'Order',
        );
    }

    public static function pricing_service_column_content( $col, $post_id ) {
        switch ( $col ) {
            case 'si_svc_rate':
                $rate = get_post_meta( $post_id, '_si_rate', true );
                echo '&pound;' . esc_html( number_format_i18n( (float) $rate ) );
                break;
            case 'si_svc_unit':
                echo esc_html( get_post_meta( $post_id, '_si_unit', true ) );
                break;
            case 'si_svc_scale':
                echo get_post_meta( $post_id, '_si_scalable', true ) ? 'Yes' : '&mdash;';
                break;
            case 'si_svc_order':
                $post = get_post( $post_id );
                echo esc_html( $post->menu_order );
                break;
        }
    }

    // -------------------------------------------------------
    // Pricing tier admin columns
    // -------------------------------------------------------

    public static function pricing_tier_columns( $cols ) {
        return array(
            'cb'                => $cols['cb'],
            'title'             => 'Tier',
            'si_tier_mult'      => 'Multiplier',
            'si_tier_order'     => 'Order (low = simplest)',
        );
    }

    public static function pricing_tier_column_content( $col, $post_id ) {
        switch ( $col ) {
            case 'si_tier_mult':
                $mult = get_post_meta( $post_id, '_si_tier_multiplier', true );
                echo 'x ' . esc_html( number_format_i18n( (float) $mult, 2 ) );
                break;
            case 'si_tier_order':
                $post = get_post( $post_id );
                echo esc_html( $post->menu_order );
                break;
        }
    }

    // -------------------------------------------------------
    // Meta boxes
    // -------------------------------------------------------

    public static function add_meta_boxes() {
        add_meta_box(
            'si_project_details',
            'Project Details',
            array( __CLASS__, 'render_project_meta_box' ),
            'si_portfolio',
            'side',
            'high'
        );
        add_meta_box(
            'si_ld_details',
            'Learning Design Details',
            array( __CLASS__, 'render_ld_meta_box' ),
            'si_portfolio',
            'normal',
            'high'
        );
        add_meta_box(
            'si_testimonial_details',
            'Testimonial Details',
            array( __CLASS__, 'render_testimonial_meta_box' ),
            'si_testimonial',
            'normal',
            'high'
        );
        add_meta_box(
            'si_enquiry_status',
            'Status',
            array( __CLASS__, 'render_enquiry_status_box' ),
            'si_enquiry',
            'side',
            'high'
        );
        add_meta_box(
            'si_enquiry_details',
            'Enquiry Details',
            array( __CLASS__, 'render_enquiry_details_box' ),
            'si_enquiry',
            'normal',
            'high'
        );
        add_meta_box(
            'si_pricing_service_details',
            'Service Details',
            array( __CLASS__, 'render_pricing_service_meta_box' ),
            'si_pricing_service',
            'normal',
            'high'
        );
        add_meta_box(
            'si_pricing_tier_details',
            'Tier Details',
            array( __CLASS__, 'render_pricing_tier_meta_box' ),
            'si_pricing_tier',
            'normal',
            'high'
        );
    }

    public static function render_project_meta_box( $post ) {
        wp_nonce_field( 'si_save_project_meta', 'si_project_nonce' );

        $project_type = get_post_meta( $post->ID, '_si_project_type', true );
        if ( ! $project_type ) {
            $project_type = 'composition';
        }

        $types = array(
            'composition'    => 'Composition',
            'learning_design' => 'Learning Design',
        );

        echo '<p><strong>Project Type</strong></p>';
        echo '<p style="margin-top:4px;">';
        foreach ( $types as $value => $label ) {
            $checked = checked( $project_type, $value, false );
            echo '<label style="display:block;margin-bottom:6px;">';
            echo '<input type="radio" name="si_project_type" value="' . esc_attr( $value ) . '" ' . $checked . '> ';
            echo esc_html( $label );
            echo '</label>';
        }
        echo '</p>';

        echo '<hr style="margin:12px 0;">';
        echo '<p><strong>Client Name</strong></p>';
        $client = get_post_meta( $post->ID, '_si_client_name', true );
        echo '<input type="text" name="si_client_name" value="' . esc_attr( $client ) . '" style="width:100%">';

        echo '<p style="margin-top:10px;"><strong>Year</strong></p>';
        $year = get_post_meta( $post->ID, '_si_year', true );
        echo '<input type="number" name="si_year" value="' . esc_attr( $year ) . '" style="width:100%" placeholder="' . esc_attr( date( 'Y' ) ) . '">';

        echo '<p style="margin-top:10px;"><strong>External URL (optional)</strong></p>';
        $url = get_post_meta( $post->ID, '_si_external_url', true );
        echo '<input type="url" name="si_external_url" value="' . esc_attr( $url ) . '" style="width:100%" placeholder="https://">';

        echo '<p style="margin-top:10px;"><strong>Audio File URL (composition only)</strong></p>';
        $audio = get_post_meta( $post->ID, '_si_audio_file', true );
        echo '<input type="url" name="si_audio_file" value="' . esc_attr( $audio ) . '" style="width:100%" placeholder="https://">';

        echo '<p style="margin-top:10px;"><strong>Genre / Style Tag</strong> <span style="color:#666;font-weight:normal;">(composition only, e.g. Cinematic, Corporate)</span></p>';
        $genre = get_post_meta( $post->ID, '_si_project_genre', true );
        echo '<input type="text" name="si_project_genre" value="' . esc_attr( $genre ) . '" style="width:100%" placeholder="e.g. Cinematic, Corporate, Ambient">';

        echo '<p style="margin-top:10px;"><strong>Brief / Context</strong> <span style="color:#666;font-weight:normal;">(composition only &mdash; shown in the audio showcase)</span></p>';
        echo '<p style="color:#666;font-size:12px;margin:-4px 0 6px;">Describe the use-case this piece was composed for. e.g. &ldquo;Perfect for YouTube reviews that need a modern, funky background track.&rdquo;</p>';
        $brief = get_post_meta( $post->ID, '_si_brief', true );
        echo '<textarea name="si_brief" style="width:100%;height:80px;">' . esc_textarea( $brief ) . '</textarea>';
    }

    public static function render_ld_meta_box( $post ) {
        wp_nonce_field( 'si_save_ld_meta', 'si_ld_nonce' );

        $challenge  = get_post_meta( $post->ID, '_si_challenge', true );
        $approach   = get_post_meta( $post->ID, '_si_approach', true );
        $outcome    = get_post_meta( $post->ID, '_si_outcome', true );
        $tools_used = get_post_meta( $post->ID, '_si_tools_used', true );

        $ta_style = 'width:100%;height:80px;';

        echo '<p style="color:#666;font-size:12px;margin-bottom:12px;">Used in the project modal on the Learning Design page. Leave blank if not applicable.</p>';

        echo '<p><strong>The Challenge</strong></p>';
        echo '<textarea name="si_challenge" style="' . esc_attr( $ta_style ) . '">' . esc_textarea( $challenge ) . '</textarea>';

        echo '<p style="margin-top:10px;"><strong>The Approach</strong></p>';
        echo '<textarea name="si_approach" style="' . esc_attr( $ta_style ) . '">' . esc_textarea( $approach ) . '</textarea>';

        echo '<p style="margin-top:10px;"><strong>The Outcome</strong></p>';
        echo '<textarea name="si_outcome" style="' . esc_attr( $ta_style ) . '">' . esc_textarea( $outcome ) . '</textarea>';

        echo '<p style="margin-top:10px;"><strong>Tools Used</strong> <span style="color:#666;font-weight:normal;">(comma-separated, e.g. Articulate Storyline, Rise, After Effects)</span></p>';
        echo '<input type="text" name="si_tools_used" value="' . esc_attr( $tools_used ) . '" style="width:100%" placeholder="Articulate Storyline, Rise, After Effects">';
    }

    public static function render_testimonial_meta_box( $post ) {
        wp_nonce_field( 'si_save_testimonial_meta', 'si_testimonial_nonce' );

        $client_name = get_post_meta( $post->ID, '_si_client_name', true );
        $client_role = get_post_meta( $post->ID, '_si_client_role', true );

        echo '<p><strong>Client Name</strong></p>';
        echo '<input type="text" name="si_client_name" value="' . esc_attr( $client_name ) . '" style="width:100%">';

        echo '<p style="margin-top:10px;"><strong>Project / Role</strong></p>';
        echo '<input type="text" name="si_client_role" value="' . esc_attr( $client_role ) . '" style="width:100%" placeholder="e.g. The Violet Fire">';

        echo '<p style="margin-top:10px;color:#666;font-size:12px;">The quote text goes in the main editor above.</p>';
    }

    public static function render_enquiry_status_box( $post ) {
        wp_nonce_field( 'si_save_enquiry_status', 'si_enquiry_status_nonce' );
        $status  = get_post_meta( $post->ID, '_si_enquiry_status', true );
        $options = array(
            'new'     => 'New',
            'replied' => 'Replied',
            'closed'  => 'Closed',
        );
        echo '<select name="si_enquiry_status" style="width:100%;">';
        foreach ( $options as $val => $label ) {
            $sel = selected( $status, $val, false );
            echo '<option value="' . esc_attr( $val ) . '" ' . $sel . '>' . esc_html( $label ) . '</option>';
        }
        echo '</select>';
    }

    public static function render_enquiry_details_box( $post ) {
        $name    = get_post_meta( $post->ID, '_si_contact_name',    true );
        $email   = get_post_meta( $post->ID, '_si_contact_email',   true );
        $phone   = get_post_meta( $post->ID, '_si_contact_phone',   true );
        $company = get_post_meta( $post->ID, '_si_contact_company', true );
        $role    = get_post_meta( $post->ID, '_si_contact_role',    true );
        $data    = get_post_meta( $post->ID, '_si_form_data',       true );

        echo '<table style="width:100%;border-collapse:collapse;font-size:13px;">';

        $contact_rows = array(
            'Name'    => $name,
            'Email'   => $email ? '<a href="mailto:' . esc_attr( $email ) . '">' . esc_html( $email ) . '</a>' : '',
            'Phone'   => $phone,
            'Company' => $company,
            'Role'    => $role,
        );

        foreach ( $contact_rows as $label => $val ) {
            if ( ! $val ) continue;
            echo '<tr style="border-bottom:1px solid #eee;">';
            echo '<th style="text-align:left;padding:8px 4px;color:#666;font-weight:normal;width:110px;">' . esc_html( $label ) . '</th>';
            echo '<td style="padding:8px 4px;">' . wp_kses( $val, array( 'a' => array( 'href' => array() ) ) ) . '</td>';
            echo '</tr>';
        }

        if ( is_array( $data ) ) {
            echo '<tr><td colspan="2" style="padding:12px 0 4px;font-weight:600;color:#333;">Form Answers</td></tr>';
            foreach ( $data as $key => $val ) {
                if ( ! $val ) continue;
                $key_label = ucwords( str_replace( '_', ' ', $key ) );
                echo '<tr style="border-bottom:1px solid #eee;">';
                echo '<th style="text-align:left;padding:8px 4px;color:#666;font-weight:normal;vertical-align:top;">' . esc_html( $key_label ) . '</th>';
                echo '<td style="padding:8px 4px;">' . nl2br( esc_html( $val ) ) . '</td>';
                echo '</tr>';
            }
        }

        echo '</table>';
    }

    /**
     * Icon options shown in the pricing service editor. Keys must match the
     * ICONS map in assets/js/si-pricing-estimator.js.
     */
    public static function pricing_icon_options() {
        return array(
            'instructional' => 'Instructional design (map)',
            'build'         => 'Build (box)',
            'consulting'    => 'Consulting (people)',
            'multimedia'    => 'Multimedia (play)',
            'audit'         => 'Audit (magnifier)',
            'interactive'   => 'Interactive / gamified (game pad)',
            'general'       => 'General (spark)',
        );
    }

    public static function render_pricing_service_meta_box( $post ) {
        wp_nonce_field( 'si_save_pricing_service', 'si_pricing_service_nonce' );

        $rate      = get_post_meta( $post->ID, '_si_rate', true );
        $unit      = get_post_meta( $post->ID, '_si_unit', true );
        $desc      = get_post_meta( $post->ID, '_si_desc', true );
        $icon      = get_post_meta( $post->ID, '_si_icon', true );
        $step      = get_post_meta( $post->ID, '_si_step', true );
        $max       = get_post_meta( $post->ID, '_si_max', true );
        $is_fixed  = get_post_meta( $post->ID, '_si_fixed', true );
        $scalable  = get_post_meta( $post->ID, '_si_scalable', true );

        if ( '' === $step ) $step = '1';
        if ( '' === $max )  $max  = '40';
        if ( ! $icon )      $icon = 'general';

        echo '<p style="color:#666;font-size:12px;margin-bottom:14px;">This becomes one selectable line item on the front-end Build Sheet. The title shown here is the service name.</p>';

        echo '<p><strong>Description</strong> <span style="color:#666;font-weight:normal;">(shown under the service name)</span></p>';
        echo '<input type="text" name="si_desc" value="' . esc_attr( $desc ) . '" style="width:100%" placeholder="e.g. Storyboards, learning blueprints, structural design">';

        echo '<div style="display:flex;gap:16px;margin-top:14px;flex-wrap:wrap;">';

        echo '<div style="flex:1;min-width:140px;"><p><strong>Rate (&pound;)</strong></p>';
        echo '<input type="number" step="0.01" min="0" name="si_rate" value="' . esc_attr( $rate ) . '" style="width:100%"></div>';

        echo '<div style="flex:1;min-width:140px;"><p><strong>Unit label</strong> <span style="color:#666;font-weight:normal;">(e.g. day, finished hr, fixed)</span></p>';
        echo '<input type="text" name="si_unit" value="' . esc_attr( $unit ) . '" style="width:100%" placeholder="day"></div>';

        echo '</div>';

        echo '<div style="display:flex;gap:16px;margin-top:14px;flex-wrap:wrap;">';

        echo '<div style="flex:1;min-width:140px;"><p><strong>Step</strong> <span style="color:#666;font-weight:normal;">(quantity increment)</span></p>';
        echo '<input type="number" step="0.5" min="0.5" name="si_step" value="' . esc_attr( $step ) . '" style="width:100%"></div>';

        echo '<div style="flex:1;min-width:140px;"><p><strong>Max quantity</strong></p>';
        echo '<input type="number" step="0.5" min="0" name="si_max" value="' . esc_attr( $max ) . '" style="width:100%"></div>';

        echo '<div style="flex:1;min-width:180px;"><p><strong>Icon</strong></p>';
        echo '<select name="si_icon" style="width:100%;">';
        foreach ( self::pricing_icon_options() as $val => $label ) {
            $sel = selected( $icon, $val, false );
            echo '<option value="' . esc_attr( $val ) . '" ' . $sel . '>' . esc_html( $label ) . '</option>';
        }
        echo '</select></div>';

        echo '</div>';

        echo '<div style="margin-top:16px;">';
        echo '<label style="display:block;margin-bottom:8px;"><input type="checkbox" name="si_fixed" value="1" ' . checked( $is_fixed, '1', false ) . '> ';
        echo '<strong>Fixed-price item</strong> <span style="color:#666;">&mdash; shown as an Include toggle instead of a quantity stepper (e.g. a one-off audit)</span></label>';

        echo '<label style="display:block;"><input type="checkbox" name="si_scalable" value="1" ' . checked( $scalable, '1', false ) . '> ';
        echo '<strong>Scales with project complexity</strong> <span style="color:#666;">&mdash; the complexity slider multiplier applies to this line item (tick for build/development-type services)</span></label>';
        echo '</div>';

        echo '<p style="margin-top:14px;color:#666;font-size:12px;">Use the <strong>Order</strong> field in the Attributes box (right-hand side) to control the order services appear in on the front end.</p>';
    }

    public static function render_pricing_tier_meta_box( $post ) {
        wp_nonce_field( 'si_save_pricing_tier', 'si_pricing_tier_nonce' );

        $desc = get_post_meta( $post->ID, '_si_tier_desc', true );
        $mult = get_post_meta( $post->ID, '_si_tier_multiplier', true );
        if ( '' === $mult ) $mult = '1';

        echo '<p style="color:#666;font-size:12px;margin-bottom:14px;">Tiers become stops on the front-end complexity slider, from simplest to most complex. The title is the short label shown above the slider (e.g. &ldquo;Fully gamified&rdquo;).</p>';

        echo '<p><strong>Description</strong> <span style="color:#666;font-weight:normal;">(shown under the label when this tier is selected)</span></p>';
        echo '<textarea name="si_tier_desc" style="width:100%;height:80px;">' . esc_textarea( $desc ) . '</textarea>';

        echo '<p style="margin-top:12px;"><strong>Price multiplier</strong> <span style="color:#666;font-weight:normal;">(applied to services flagged &ldquo;Scales with project complexity&rdquo;; 1 = no change, 2 = double)</span></p>';
        echo '<input type="number" step="0.05" min="0" name="si_tier_multiplier" value="' . esc_attr( $mult ) . '" style="width:160px;">';

        echo '<p style="margin-top:14px;color:#666;font-size:12px;">Use the <strong>Order</strong> field in the Attributes box (right-hand side) to arrange tiers from simplest (lowest number) to most complex (highest number).</p>';
    }

    // -------------------------------------------------------
    // Save meta
    // -------------------------------------------------------

    public static function save_meta( $post_id ) {
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

        // Portfolio project
        if ( isset( $_POST['si_project_nonce'] ) &&
             wp_verify_nonce( $_POST['si_project_nonce'], 'si_save_project_meta' ) ) {

            if ( isset( $_POST['si_project_type'] ) ) {
                $allowed = array( 'composition', 'learning_design' );
                $type    = sanitize_text_field( $_POST['si_project_type'] );
                if ( in_array( $type, $allowed, true ) ) {
                    update_post_meta( $post_id, '_si_project_type', $type );
                }
            }

            $text_fields = array(
                'si_client_name'   => '_si_client_name',
                'si_year'          => '_si_year',
                'si_project_genre' => '_si_project_genre',
            );
            foreach ( $text_fields as $input => $meta_key ) {
                if ( isset( $_POST[ $input ] ) ) {
                    update_post_meta( $post_id, $meta_key, sanitize_text_field( $_POST[ $input ] ) );
                }
            }

            $url_fields = array(
                'si_external_url' => '_si_external_url',
                'si_audio_file'   => '_si_audio_file',
            );
            foreach ( $url_fields as $input => $meta_key ) {
                if ( isset( $_POST[ $input ] ) ) {
                    update_post_meta( $post_id, $meta_key, esc_url_raw( $_POST[ $input ] ) );
                }
            }

            if ( isset( $_POST['si_brief'] ) ) {
                update_post_meta( $post_id, '_si_brief', sanitize_textarea_field( $_POST['si_brief'] ) );
            }
        }

        // Learning Design details
        if ( isset( $_POST['si_ld_nonce'] ) &&
             wp_verify_nonce( $_POST['si_ld_nonce'], 'si_save_ld_meta' ) ) {

            $textarea_fields = array(
                'si_challenge'  => '_si_challenge',
                'si_approach'   => '_si_approach',
                'si_outcome'    => '_si_outcome',
            );
            foreach ( $textarea_fields as $input => $meta_key ) {
                if ( isset( $_POST[ $input ] ) ) {
                    update_post_meta( $post_id, $meta_key, sanitize_textarea_field( $_POST[ $input ] ) );
                }
            }

            if ( isset( $_POST['si_tools_used'] ) ) {
                update_post_meta( $post_id, '_si_tools_used', sanitize_text_field( $_POST['si_tools_used'] ) );
            }
        }

        // Testimonial
        if ( isset( $_POST['si_testimonial_nonce'] ) &&
             wp_verify_nonce( $_POST['si_testimonial_nonce'], 'si_save_testimonial_meta' ) ) {

            $fields = array(
                'si_client_name' => '_si_client_name',
                'si_client_role' => '_si_client_role',
            );
            foreach ( $fields as $input => $meta_key ) {
                if ( isset( $_POST[ $input ] ) ) {
                    update_post_meta( $post_id, $meta_key, sanitize_text_field( $_POST[ $input ] ) );
                }
            }
        }

        // Enquiry status
        if ( isset( $_POST['si_enquiry_status_nonce'] ) &&
             wp_verify_nonce( $_POST['si_enquiry_status_nonce'], 'si_save_enquiry_status' ) ) {

            if ( isset( $_POST['si_enquiry_status'] ) ) {
                $allowed = array( 'new', 'replied', 'closed' );
                $status  = sanitize_key( $_POST['si_enquiry_status'] );
                if ( in_array( $status, $allowed, true ) ) {
                    update_post_meta( $post_id, '_si_enquiry_status', $status );
                }
            }
        }

        // Pricing service
        if ( isset( $_POST['si_pricing_service_nonce'] ) &&
             wp_verify_nonce( $_POST['si_pricing_service_nonce'], 'si_save_pricing_service' ) ) {

            if ( isset( $_POST['si_desc'] ) ) {
                update_post_meta( $post_id, '_si_desc', sanitize_text_field( $_POST['si_desc'] ) );
            }
            if ( isset( $_POST['si_unit'] ) ) {
                update_post_meta( $post_id, '_si_unit', sanitize_text_field( $_POST['si_unit'] ) );
            }
            if ( isset( $_POST['si_rate'] ) ) {
                update_post_meta( $post_id, '_si_rate', floatval( $_POST['si_rate'] ) );
            }
            if ( isset( $_POST['si_step'] ) ) {
                update_post_meta( $post_id, '_si_step', floatval( $_POST['si_step'] ) );
            }
            if ( isset( $_POST['si_max'] ) ) {
                update_post_meta( $post_id, '_si_max', floatval( $_POST['si_max'] ) );
            }
            if ( isset( $_POST['si_icon'] ) ) {
                $allowed_icons = array_keys( self::pricing_icon_options() );
                $icon = sanitize_key( $_POST['si_icon'] );
                if ( in_array( $icon, $allowed_icons, true ) ) {
                    update_post_meta( $post_id, '_si_icon', $icon );
                }
            }
            update_post_meta( $post_id, '_si_fixed',    isset( $_POST['si_fixed'] )    ? '1' : '' );
            update_post_meta( $post_id, '_si_scalable', isset( $_POST['si_scalable'] ) ? '1' : '' );
        }

        // Pricing tier
        if ( isset( $_POST['si_pricing_tier_nonce'] ) &&
             wp_verify_nonce( $_POST['si_pricing_tier_nonce'], 'si_save_pricing_tier' ) ) {

            if ( isset( $_POST['si_tier_desc'] ) ) {
                update_post_meta( $post_id, '_si_tier_desc', sanitize_textarea_field( $_POST['si_tier_desc'] ) );
            }
            if ( isset( $_POST['si_tier_multiplier'] ) ) {
                update_post_meta( $post_id, '_si_tier_multiplier', floatval( $_POST['si_tier_multiplier'] ) );
            }
        }
    }

    // -------------------------------------------------------
    // Default data seeding — runs once so the front end isn't empty
    // -------------------------------------------------------

    public static function maybe_seed_pricing_defaults() {
        if ( get_option( 'si_pricing_seeded' ) ) {
            return;
        }

        $services = array(
            array(
                'title' => 'Instructional Design',
                'desc'  => 'Storyboards, learning blueprints, structural design',
                'rate'  => 500,
                'unit'  => 'day',
                'icon'  => 'instructional',
                'step'  => 1,
                'max'   => 40,
                'fixed' => false,
                'scale' => false,
            ),
            array(
                'title' => 'Module Build',
                'desc'  => 'Interactive e-learning development, priced per finished hour',
                'rate'  => 2200,
                'unit'  => 'finished hr',
                'icon'  => 'build',
                'step'  => 0.5,
                'max'   => 20,
                'fixed' => false,
                'scale' => true,
            ),
            array(
                'title' => 'Behaviour-Change Consulting',
                'desc'  => 'Performance &amp; behaviour-change programme design',
                'rate'  => 650,
                'unit'  => 'day',
                'icon'  => 'consulting',
                'step'  => 1,
                'max'   => 40,
                'fixed' => false,
                'scale' => false,
            ),
            array(
                'title' => 'Multimedia Production',
                'desc'  => 'Video, audio and asset production',
                'rate'  => 550,
                'unit'  => 'day',
                'icon'  => 'multimedia',
                'step'  => 1,
                'max'   => 40,
                'fixed' => false,
                'scale' => false,
            ),
            array(
                'title' => 'UX Audit',
                'desc'  => 'Structured review of existing learning content',
                'rate'  => 950,
                'unit'  => 'fixed',
                'icon'  => 'audit',
                'step'  => 1,
                'max'   => 1,
                'fixed' => true,
                'scale' => false,
            ),
        );

        foreach ( $services as $i => $svc ) {
            $post_id = wp_insert_post( array(
                'post_type'   => 'si_pricing_service',
                'post_title'  => $svc['title'],
                'post_status' => 'publish',
                'menu_order'  => $i,
            ) );
            if ( $post_id && ! is_wp_error( $post_id ) ) {
                update_post_meta( $post_id, '_si_desc',      $svc['desc'] );
                update_post_meta( $post_id, '_si_rate',      $svc['rate'] );
                update_post_meta( $post_id, '_si_unit',      $svc['unit'] );
                update_post_meta( $post_id, '_si_icon',      $svc['icon'] );
                update_post_meta( $post_id, '_si_step',      $svc['step'] );
                update_post_meta( $post_id, '_si_max',       $svc['max'] );
                update_post_meta( $post_id, '_si_fixed',     $svc['fixed'] ? '1' : '' );
                update_post_meta( $post_id, '_si_scalable',  $svc['scale'] ? '1' : '' );
            }
        }

        $tiers = array(
            array(
                'title' => 'Linear &amp; static',
                'desc'  => 'Text and next &mdash; page-turner content with minimal interactivity. Read, click, continue.',
                'mult'  => 1,
            ),
            array(
                'title' => 'Basic interactions',
                'desc'  => 'Click-reveals, simple knowledge checks, and basic drag-and-drop.',
                'mult'  => 1.25,
            ),
            array(
                'title' => 'Scenario-based',
                'desc'  => 'Branching scenarios, decision points, and custom visuals or animation.',
                'mult'  => 1.6,
            ),
            array(
                'title' => 'Advanced interactive',
                'desc'  => 'Simulations, complex branching logic, and bespoke custom-built interactions.',
                'mult'  => 2,
            ),
            array(
                'title' => 'Fully gamified',
                'desc'  => 'Game mechanics, scoring, leaderboards &mdash; a fully immersive, bespoke build.',
                'mult'  => 2.5,
            ),
        );

        foreach ( $tiers as $i => $tier ) {
            $post_id = wp_insert_post( array(
                'post_type'   => 'si_pricing_tier',
                'post_title'  => $tier['title'],
                'post_status' => 'publish',
                'menu_order'  => $i,
            ) );
            if ( $post_id && ! is_wp_error( $post_id ) ) {
                update_post_meta( $post_id, '_si_tier_desc',       $tier['desc'] );
                update_post_meta( $post_id, '_si_tier_multiplier', $tier['mult'] );
            }
        }

        update_option( 'si_pricing_seeded', 1 );
    }

    // -------------------------------------------------------
    // Front-end data helpers
    // -------------------------------------------------------

    public static function get_pricing_services() {
        $posts = get_posts( array(
            'post_type'      => 'si_pricing_service',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
        ) );

        $out = array();
        foreach ( $posts as $post ) {
            $out[] = array(
                'id'     => 'svc-' . $post->ID,
                'name'   => get_the_title( $post ),
                'desc'   => get_post_meta( $post->ID, '_si_desc', true ),
                'rate'   => (float) get_post_meta( $post->ID, '_si_rate', true ),
                'unit'   => get_post_meta( $post->ID, '_si_unit', true ) ? get_post_meta( $post->ID, '_si_unit', true ) : 'day',
                'icon'   => get_post_meta( $post->ID, '_si_icon', true ) ? get_post_meta( $post->ID, '_si_icon', true ) : 'general',
                'step'   => (float) ( get_post_meta( $post->ID, '_si_step', true ) ? get_post_meta( $post->ID, '_si_step', true ) : 1 ),
                'max'    => (float) ( get_post_meta( $post->ID, '_si_max', true ) ? get_post_meta( $post->ID, '_si_max', true ) : 40 ),
                'fixed'  => (bool) get_post_meta( $post->ID, '_si_fixed', true ),
                'scale'  => (bool) get_post_meta( $post->ID, '_si_scalable', true ),
            );
        }
        return $out;
    }

    public static function get_pricing_tiers() {
        $posts = get_posts( array(
            'post_type'      => 'si_pricing_tier',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
        ) );

        $out = array();
        foreach ( $posts as $post ) {
            $out[] = array(
                'label' => get_the_title( $post ),
                'desc'  => get_post_meta( $post->ID, '_si_tier_desc', true ),
                'mult'  => (float) ( get_post_meta( $post->ID, '_si_tier_multiplier', true ) ? get_post_meta( $post->ID, '_si_tier_multiplier', true ) : 1 ),
            );
        }
        return $out;
    }
}
