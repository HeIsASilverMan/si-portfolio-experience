<?php
defined( 'ABSPATH' ) || exit;

class SI_CPTs {

    public static function init() {
        add_action( 'init',       array( __CLASS__, 'register_portfolio' ) );
        add_action( 'init',       array( __CLASS__, 'register_testimonials' ) );
        add_action( 'init',       array( __CLASS__, 'register_enquiries' ) );
        add_action( 'add_meta_boxes', array( __CLASS__, 'add_meta_boxes' ) );
        add_action( 'save_post',  array( __CLASS__, 'save_meta' ) );
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
            'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
            'rewrite'      => array( 'slug' => 'portfolio' ),
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
            'name'          => 'Enquiries',
            'singular_name' => 'Enquiry',
            'all_items'     => 'All Enquiries',
        );
        register_post_type( 'si_enquiry', array(
            'labels'       => $labels,
            'public'       => false,
            'show_ui'      => true,
            'show_in_menu' => 'edit.php?post_type=si_portfolio',
            'supports'     => array( 'title' ),
        ) );
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
            'si_testimonial_details',
            'Testimonial Details',
            array( __CLASS__, 'render_testimonial_meta_box' ),
            'si_testimonial',
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
                'si_client_name'  => '_si_client_name',
                'si_year'         => '_si_year',
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
    }
}
