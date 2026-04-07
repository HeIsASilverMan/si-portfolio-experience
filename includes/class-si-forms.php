<?php
/**
 * SI Forms — AJAX handler, rate limiting, CPT save, email notification.
 * Handles both [si_form_composition] and [si_form_learning_design].
 */
defined( 'ABSPATH' ) || exit;

class SI_Forms {

    /** Max submissions per IP per hour */
    const RATE_LIMIT = 3;

    public static function init() {
        add_action( 'wp_ajax_si_submit_enquiry',        array( __CLASS__, 'handle_submission' ) );
        add_action( 'wp_ajax_nopriv_si_submit_enquiry', array( __CLASS__, 'handle_submission' ) );
    }

    // -------------------------------------------------------
    // AJAX handler
    // -------------------------------------------------------

    public static function handle_submission() {
        // Nonce
        if ( ! isset( $_POST['nonce'] ) ||
             ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'si_form_nonce' ) ) {
            wp_send_json_error( 'Security check failed. Please reload and try again.' );
        }

        // Honeypot — if filled, silently succeed
        if ( ! empty( $_POST['si_honeypot'] ) ) {
            wp_send_json_success();
        }

        // Rate limiting
        if ( ! self::check_rate_limit() ) {
            wp_send_json_error( 'Too many submissions. Please try again later.' );
        }

        // Form type
        $allowed_types = array( 'composition', 'learning_design' );
        $form_type = isset( $_POST['form_type'] ) ? sanitize_key( $_POST['form_type'] ) : '';
        if ( ! in_array( $form_type, $allowed_types, true ) ) {
            wp_send_json_error( 'Invalid form type.' );
        }

        // Contact fields
        $name    = isset( $_POST['contact_name'] )    ? sanitize_text_field( wp_unslash( $_POST['contact_name'] ) )    : '';
        $email   = isset( $_POST['contact_email'] )   ? sanitize_email( wp_unslash( $_POST['contact_email'] ) )        : '';
        $phone   = isset( $_POST['contact_phone'] )   ? sanitize_text_field( wp_unslash( $_POST['contact_phone'] ) )   : '';
        $company = isset( $_POST['contact_company'] ) ? sanitize_text_field( wp_unslash( $_POST['contact_company'] ) ) : '';
        $role    = isset( $_POST['contact_role'] )    ? sanitize_text_field( wp_unslash( $_POST['contact_role'] ) )    : '';

        if ( ! $name || ! is_email( $email ) ) {
            wp_send_json_error( 'Please provide a valid name and email address.' );
        }

        // Full form data (JSON blob)
        $raw_data = isset( $_POST['form_data'] ) ? wp_unslash( $_POST['form_data'] ) : '';
        $form_data = json_decode( $raw_data, true );
        if ( ! is_array( $form_data ) ) {
            $form_data = array();
        }
        // Sanitize each value in the data array
        $clean_data = array();
        foreach ( $form_data as $key => $val ) {
            $clean_data[ sanitize_key( $key ) ] = sanitize_textarea_field( $val );
        }

        // Save as CPT
        $post_id = self::save_enquiry( $form_type, $name, $email, $clean_data );
        if ( ! $post_id ) {
            wp_send_json_error( 'Could not save your enquiry. Please try again.' );
        }

        // Store phone / company / role as meta (contact_* keys already in clean_data
        // but keep them in dedicated meta for the admin view)
        if ( $phone )   update_post_meta( $post_id, '_si_contact_phone',   $phone );
        if ( $company ) update_post_meta( $post_id, '_si_contact_company', $company );
        if ( $role )    update_post_meta( $post_id, '_si_contact_role',    $role );

        // Send email
        self::send_notification( $post_id, $form_type, $name, $email, $clean_data );

        // Record submission for rate limiting
        self::record_submission();

        wp_send_json_success();
    }

    // -------------------------------------------------------
    // Save enquiry CPT
    // -------------------------------------------------------

    private static function save_enquiry( $form_type, $name, $email, $data ) {
        $label  = 'composition' === $form_type ? 'Composition' : 'Learning Design';
        $title  = $label . ' Enquiry — ' . $name;

        $post_id = wp_insert_post( array(
            'post_type'   => 'si_enquiry',
            'post_title'  => $title,
            'post_status' => 'publish',
        ) );

        if ( is_wp_error( $post_id ) || ! $post_id ) {
            return false;
        }

        update_post_meta( $post_id, '_si_enquiry_type',   $form_type );
        update_post_meta( $post_id, '_si_enquiry_status', 'new' );
        update_post_meta( $post_id, '_si_contact_name',   $name );
        update_post_meta( $post_id, '_si_contact_email',  $email );
        update_post_meta( $post_id, '_si_form_data',      $data );

        return $post_id;
    }

    // -------------------------------------------------------
    // Email notification
    // -------------------------------------------------------

    private static function send_notification( $post_id, $form_type, $name, $email, $data ) {
        $admin_email = si_setting( 'notify_email', get_option( 'admin_email' ) );
        $site_name   = get_bloginfo( 'name' );
        $label       = 'composition' === $form_type ? 'Composition Commission' : 'Learning Design Enquiry';
        $admin_url   = admin_url( 'post.php?post=' . $post_id . '&action=edit' );

        $subject = '[' . $site_name . '] New ' . $label . ' from ' . $name;

        $body  = 'You have a new enquiry from ' . $name . ' <' . $email . ">.\n\n";
        $body .= "--- DETAILS ---\n\n";

        foreach ( $data as $key => $val ) {
            if ( ! $val ) continue;
            $body .= ucwords( str_replace( '_', ' ', $key ) ) . ': ' . $val . "\n";
        }

        $body .= "\n--- VIEW IN ADMIN ---\n";
        $body .= $admin_url . "\n\n";
        $body .= "---\nSent from " . $site_name;

        $headers = array(
            'Content-Type: text/plain; charset=UTF-8',
            'Reply-To: ' . $name . ' <' . $email . '>',
        );

        wp_mail( $admin_email, $subject, $body, $headers );
    }

    // -------------------------------------------------------
    // Rate limiting  (transient per IP, 3 per hour)
    // -------------------------------------------------------

    private static function get_rate_key() {
        $ip = '';
        if ( isset( $_SERVER['HTTP_CF_CONNECTING_IP'] ) ) {
            $ip = sanitize_text_field( wp_unslash( $_SERVER['HTTP_CF_CONNECTING_IP'] ) );
        } elseif ( isset( $_SERVER['REMOTE_ADDR'] ) ) {
            $ip = sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) );
        }
        return 'si_form_rate_' . md5( $ip );
    }

    private static function check_rate_limit() {
        $key   = self::get_rate_key();
        $count = (int) get_transient( $key );
        return $count < self::RATE_LIMIT;
    }

    private static function record_submission() {
        $key   = self::get_rate_key();
        $count = (int) get_transient( $key );
        set_transient( $key, $count + 1, HOUR_IN_SECONDS );
    }
}
