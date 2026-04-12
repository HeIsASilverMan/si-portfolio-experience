<?php
defined( 'ABSPATH' ) || exit;

class SI_CPTs {

    public static function init() {
        add_action( 'init',       array( __CLASS__, 'register_portfolio' ) );
        add_action( 'init',       array( __CLASS__, 'register_portfolio_taxonomy' ) );
        add_action( 'init',       array( __CLASS__, 'register_testimonials' ) );
        add_action( 'init',       array( __CLASS__, 'register_enquiries' ) );
        add_action( 'add_meta_boxes', array( __CLASS__, 'add_meta_boxes' ) );
        add_action( 'save_post',  array( __CLASS__, 'save_meta' ) );
        // Enquiry admin columns
        add_filter( 'manage_si_enquiry_posts_columns',       array( __CLASS__, 'enquiry_columns' ) );
        add_action( 'manage_si_enquiry_posts_custom_column', array( __CLASS__, 'enquiry_column_content' ), 10, 2 );
        add_filter( 'manage_edit-si_enquiry_sortable_columns', array( __CLASS__, 'enquiry_sortable_columns' ) );
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
    }
}
