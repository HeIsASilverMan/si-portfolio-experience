<?php
/**
 * SI Forms — AJAX handler, rate limiting, CPT save, email notification.
 * Handles [si_form_composition], [si_form_learning_design], the game-music
 * landing page's [si_thread_contact] enquiry form, the standalone
 * [si_thread_finder] questionnaire, and the [si_lead_magnet] email capture
 * widget.
 */
defined( 'ABSPATH' ) || exit;

class SI_Forms {

    /** Max submissions per IP per hour */
    const RATE_LIMIT = 3;

    public static function init() {
        add_action( 'wp_ajax_si_submit_enquiry',        array( __CLASS__, 'handle_submission' ) );
        add_action( 'wp_ajax_nopriv_si_submit_enquiry', array( __CLASS__, 'handle_submission' ) );

        add_action( 'wp_ajax_si_lead_magnet_signup',        array( __CLASS__, 'handle_lead_magnet_signup' ) );
        add_action( 'wp_ajax_nopriv_si_lead_magnet_signup', array( __CLASS__, 'handle_lead_magnet_signup' ) );
    }

    // -------------------------------------------------------
    // Enquiry type labels — shared by CPT titles, admin columns,
    // and the default email subject/label.
    // -------------------------------------------------------

    public static function type_label( $form_type ) {
        $labels = array(
            'composition'        => 'Composition',
            'learning_design'    => 'Learning Design',
            'game_music_contact' => 'Game Music',
            'thread_finder'      => 'Thread Finder',
        );
        return isset( $labels[ $form_type ] ) ? $labels[ $form_type ] : 'Enquiry';
    }

    // -------------------------------------------------------
    // Thread Finder — question bank
    // Single source of truth shared by the [si_thread_finder]
    // template (renders the steps) and send_notification() below
    // (formats the email body in the same order).
    // -------------------------------------------------------

    public static function thread_finder_steps() {
        return array(
            array(
                'label'     => 'World &amp; Feeling',
                'questions' => array(
                    'world_pulse'    => "If your world had a pulse, is it fast or slow, steady or erratic?",
                    'first_feeling'  => "What's the one feeling you want a player to have in the very first thirty seconds &mdash; before they understand anything about the plot?",
                    'world_fear'     => 'What is your world afraid of, underneath everything else?',
                    'one_image'      => 'If you had to lose every other detail of the game and keep just one image, sound, or moment &mdash; what would it be?',
                ),
            ),
            array(
                'label'     => 'Contrast &amp; Tension',
                'questions' => array(
                    'two_forces'          => 'What are the two forces pulling against each other in your world? (Order vs chaos, nature vs machine, memory vs forgetting &mdash; whatever it is for you.)',
                    'beautiful_and_wrong' => 'Where does your world feel most beautiful, and where does it feel most wrong?',
                    'hope'                => 'Is there a version of hope in this world, or is it deliberately absent?',
                ),
            ),
            array(
                'label'     => 'Character &amp; Culture',
                'questions' => array(
                    'protagonist_theme' => 'If your protagonist had a personal theme, would it be triumphant, haunted, curious, or something else entirely?',
                    'culture_root'      => 'What culture, era, or place &mdash; real or invented &mdash; are you drawing from, even loosely? What do you want to honour about it, and what do you want to avoid getting wrong?',
                    'existing_sound'    => "Is there a sound, instrument, or piece of music (yours or someone else's) that already feels like it belongs in this world?",
                ),
            ),
            array(
                'label'     => 'Player Experience',
                'questions' => array(
                    'credits_feeling' => "What should a player feel in the credits that they didn't feel at the start?",
                    'music_role'      => 'Where in the game does the music need to get out of the way, and where does it need to carry the whole moment?',
                    'dreaded_moment'  => "Is there a moment you're already dreading getting the music wrong for?",
                ),
            ),
            array(
                'label'     => 'Practical Anchors',
                'questions' => array(
                    'distinct_identities'   => 'Roughly how many distinct settings, characters, or states need their own musical identity?',
                    'technical_constraints' => 'Are there any hard technical constraints &mdash; looping points, adaptive/layered music, engine limitations &mdash; I need to know from the start?',
                ),
            ),
        );
    }

    /** Flat key => plain-text question, in submission order (used for the email body). */
    private static function thread_finder_question_map() {
        $map = array();
        foreach ( self::thread_finder_steps() as $step ) {
            foreach ( $step['questions'] as $key => $question ) {
                $map[ $key ] = html_entity_decode( wp_strip_all_tags( $question ), ENT_QUOTES );
            }
        }
        return $map;
    }

    // -------------------------------------------------------
    // AJAX handler — enquiry forms
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
        $allowed_types = array( 'composition', 'learning_design', 'game_music_contact', 'thread_finder' );
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

        // Per-type required fields the generic name/email check above doesn't cover.
        if ( 'game_music_contact' === $form_type && empty( $clean_data['message'] ) ) {
            wp_send_json_error( 'Please tell me a bit about your project.' );
        }
        if ( 'thread_finder' === $form_type && ! $company ) {
            wp_send_json_error( 'Please let me know your game or studio name.' );
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
        self::send_notification( $post_id, $form_type, $name, $email, $clean_data, $company );

        // Record submission for rate limiting
        self::record_submission();

        wp_send_json_success();
    }

    // -------------------------------------------------------
    // Save enquiry CPT
    // -------------------------------------------------------

    private static function save_enquiry( $form_type, $name, $email, $data ) {
        $title = self::type_label( $form_type ) . ' Enquiry &mdash; ' . $name;
        $title = html_entity_decode( $title, ENT_QUOTES );

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

    private static function send_notification( $post_id, $form_type, $name, $email, $data, $company = '' ) {
        $admin_email = si_setting( 'notify_email', get_option( 'admin_email' ) );
        $site_name   = get_bloginfo( 'name' );
        $label       = self::type_label( $form_type );
        $admin_url   = admin_url( 'post.php?post=' . $post_id . '&action=edit' );
        $dash        = "\u{2014}"; // em dash, built at runtime so no raw Unicode sits in this file

        // Game music contact form and Thread Finder use the subject formats
        // called for in the game-music spec; the older forms keep their
        // original "[Site] New X from Name" style so nothing about them changes.
        if ( 'game_music_contact' === $form_type ) {
            $subject = 'New composition enquiry ' . $dash . ' ' . $name;
        } elseif ( 'thread_finder' === $form_type ) {
            $subject = 'Thread Finder submission ' . $dash . ' ' . ( $company ? $company : $name );
        } else {
            $subject = '[' . $site_name . '] New ' . $label . ' from ' . $name;
        }

        if ( 'thread_finder' === $form_type ) {
            $body  = 'New Thread Finder submission from ' . $name . ' <' . $email . '>';
            $body .= $company ? ' (' . $company . ")\n\n" : "\n\n";
            $body .= "--- ANSWERS ---\n\n";
            foreach ( self::thread_finder_question_map() as $key => $question ) {
                if ( empty( $data[ $key ] ) ) {
                    continue; // skip blanks rather than showing an empty answer
                }
                $body .= $question . "\n" . $data[ $key ] . "\n\n";
            }
        } else {
            $body  = 'You have a new enquiry from ' . $name . ' <' . $email . ">.\n\n";
            $body .= "--- DETAILS ---\n\n";

            if ( $company ) {
                $body .= 'Game / studio name: ' . $company . "\n";
            }

            $field_labels = array(
                'project_link'    => 'Link',
                'message'         => 'Message',
                'referral_source' => 'How did you hear about this?',
            );

            foreach ( $data as $key => $val ) {
                if ( ! $val ) continue;
                $key_label = isset( $field_labels[ $key ] ) ? $field_labels[ $key ] : ucwords( str_replace( '_', ' ', $key ) );
                $body .= $key_label . ': ' . $val . "\n";
            }
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
    // Lead magnet — email capture ([si_lead_magnet])
    // -------------------------------------------------------

    /**
     * Per-magnet config, editable from Settings > SI Portfolio without a
     * code push. `$slug` matches the `magnet` attribute on [si_lead_magnet].
     */
    public static function lead_magnet_config( $slug ) {
        $slug = $slug ? sanitize_key( $slug ) : 'default';
        $name = si_setting( 'lead_magnet_' . $slug . '_name', '' );
        $file = si_setting( 'lead_magnet_' . $slug . '_file', '' );

        if ( '' === $name && 'default' !== $slug ) {
            $name = si_setting( 'lead_magnet_default_name', '' );
        }
        if ( '' === $file && 'default' !== $slug ) {
            $file = si_setting( 'lead_magnet_default_file', '' );
        }

        return array(
            'name' => $name ? $name : 'Free guide',
            'file' => $file,
        );
    }

    public static function handle_lead_magnet_signup() {
        if ( ! isset( $_POST['nonce'] ) ||
             ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'si_form_nonce' ) ) {
            wp_send_json_error( 'Security check failed. Please reload and try again.' );
        }

        // Honeypot — if filled, silently succeed
        if ( ! empty( $_POST['si_honeypot'] ) ) {
            wp_send_json_success();
        }

        if ( ! self::check_rate_limit() ) {
            wp_send_json_error( 'Too many submissions. Please try again later.' );
        }

        $email = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
        $name  = isset( $_POST['name'] )  ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
        $magnet_slug = isset( $_POST['magnet'] ) ? sanitize_key( $_POST['magnet'] ) : 'default';

        if ( ! is_email( $email ) ) {
            wp_send_json_error( 'Please enter a valid email address.' );
        }

        $config = self::lead_magnet_config( $magnet_slug );

        $post_id = self::save_subscriber( $email, $name, $magnet_slug, $config['name'] );
        if ( ! $post_id ) {
            wp_send_json_error( 'Could not save your details. Please try again.' );
        }

        self::send_lead_magnet_emails( $email, $name, $config );

        self::record_submission();

        wp_send_json_success();
    }

    /** Insert or update the subscriber CPT, keyed by email (no duplicates). */
    private static function save_subscriber( $email, $name, $magnet_slug, $magnet_name ) {
        $existing = get_posts( array(
            'post_type'      => 'si_subscriber',
            'post_status'    => 'any',
            'posts_per_page' => 1,
            'meta_key'       => '_si_subscriber_email',
            'meta_value'     => $email,
        ) );

        if ( $existing ) {
            $post_id = $existing[0]->ID;
        } else {
            $post_id = wp_insert_post( array(
                'post_type'   => 'si_subscriber',
                'post_title'  => $email,
                'post_status' => 'publish',
            ) );
        }

        if ( is_wp_error( $post_id ) || ! $post_id ) {
            return false;
        }

        update_post_meta( $post_id, '_si_subscriber_email',  $email );
        if ( $name ) {
            update_post_meta( $post_id, '_si_subscriber_name', $name );
        }
        update_post_meta( $post_id, '_si_subscriber_magnet',      $magnet_slug );
        update_post_meta( $post_id, '_si_subscriber_magnet_name', $magnet_name );
        update_post_meta( $post_id, '_si_subscriber_date',        current_time( 'mysql' ) );

        return $post_id;
    }

    /**
     * Single delivery email to the subscriber (the lead magnet itself, if a
     * file link is configured) plus one short notice to Shane. This is the
     * one-off automated response the rest of this build already allows for
     * enquiries -- nothing scheduled, nothing follow-up.
     */
    private static function send_lead_magnet_emails( $email, $name, $config ) {
        $site_name = get_bloginfo( 'name' );

        if ( $config['file'] ) {
            $subject = $config['name'] . ' -- here is your download';
            $body    = ( $name ? 'Hi ' . $name . ',' : 'Hi,' ) . "\n\n";
            $body   .= "Here's your copy of " . $config['name'] . ":\n";
            $body   .= $config['file'] . "\n\n";
            $body   .= "Thanks for the interest.\n\n";
            $body   .= "Reply to this email any time to unsubscribe.\n\n";
            $body   .= '-- ' . $site_name;

            wp_mail( $email, $subject, $body, array( 'Content-Type: text/plain; charset=UTF-8' ) );
        }

        $admin_email = si_setting( 'notify_email', get_option( 'admin_email' ) );
        $admin_subject = '[' . $site_name . '] New subscriber: ' . $config['name'];
        $admin_body  = 'New lead magnet signup.' . "\n\n";
        $admin_body .= 'Email: ' . $email . "\n";
        if ( $name ) {
            $admin_body .= 'Name: ' . $name . "\n";
        }
        $admin_body .= 'Magnet: ' . $config['name'] . "\n";

        wp_mail( $admin_email, $admin_subject, $admin_body, array( 'Content-Type: text/plain; charset=UTF-8' ) );
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
