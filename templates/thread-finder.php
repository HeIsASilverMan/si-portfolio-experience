<?php defined( 'ABSPATH' ) || exit;

$tf_steps = SI_Forms::thread_finder_steps();
$total    = count( $tf_steps );
?>

<section
    class="si-scope si-tf"
    data-form-type="thread_finder"
    data-started="false"
    id="si-thread-finder"
    aria-label="<?php esc_attr_e( 'The Thread Finder questionnaire', 'si-portfolio' ); ?>"
>

    <!-- Subtle background lines (reuses the multi-step form chrome) -->
    <div class="si-form__bg" aria-hidden="true">
        <div class="si-form__bg-lines"></div>
    </div>

    <!-- Intro screen -->
    <div class="si-tf__intro">
        <h2 class="si-form__question"><?php esc_html_e( 'The Thread Finder', 'si-portfolio' ); ?></h2>
        <p class="si-tf__intro-body">
            <?php echo wp_kses( __( "Before I write a single note, I need to find the thread that holds your world together. These questions aren't a brief template &mdash; they're designed to get at the thing underneath the brief. Answer as much or as little as you like. There are no wrong answers, and you can leave and come back &mdash; your answers are saved on this device as you go.", 'si-portfolio' ), array() ); ?>
        </p>
        <button class="si-form__continue-btn si-tf__begin-btn" type="button">
            <?php esc_html_e( 'Begin', 'si-portfolio' ); ?>
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
    </div>

    <!-- Gold progress bar at top -->
    <div class="si-form__progress" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
        <div class="si-form__progress-fill"></div>
    </div>

    <!-- Top bar: back button + step counter -->
    <div class="si-form__topbar">
        <button class="si-form__back-btn" hidden aria-label="<?php esc_attr_e( 'Go to previous step', 'si-portfolio' ); ?>">
            <svg class="si-form__back-arrow" viewBox="0 0 18 18" fill="none" aria-hidden="true">
                <path d="M11 4l-5 5 5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <?php esc_html_e( 'Back', 'si-portfolio' ); ?>
        </button>
        <p class="si-form__step-indicator">
            <?php esc_html_e( 'Step', 'si-portfolio' ); ?>
            <span class="si-form__step-current">1</span>
            <?php esc_html_e( 'of', 'si-portfolio' ); ?>
            <span class="si-form__step-total"><?php echo esc_html( $total ); ?></span>
        </p>
    </div>

    <div class="si-form__steps-wrap">

        <?php foreach ( $tf_steps as $i => $step ) : ?>
        <div class="si-tf__step si-form__step" data-step="<?php echo esc_attr( $i ); ?>">
            <h2 class="si-form__question"><?php echo wp_kses( $step['label'], array() ); ?></h2>

            <div class="si-tf__questions">
                <?php foreach ( $step['questions'] as $key => $question ) : ?>
                <div class="si-tf__question-block">
                    <label class="si-tf__question-label" for="si-tf-<?php echo esc_attr( $key ); ?>">
                        <?php echo wp_kses( $question, array() ); ?>
                    </label>
                    <textarea
                        id="si-tf-<?php echo esc_attr( $key ); ?>"
                        class="si-form__textarea si-tf__textarea"
                        name="<?php echo esc_attr( $key ); ?>"
                        rows="3"
                    ></textarea>
                </div>
                <?php endforeach; ?>
            </div>

            <?php if ( $i < $total - 1 ) : ?>
            <div class="si-form__nav">
                <button class="si-form__continue-btn si-tf__continue-btn" type="button">
                    <?php esc_html_e( 'Continue', 'si-portfolio' ); ?>
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                        <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
            <?php else : ?>

            <!-- Final step: contact details, required to submit -->
            <div class="si-form__fields si-tf__contact-fields">
                <div class="si-form__field">
                    <label class="si-form__label" for="si-tf-name"><?php esc_html_e( 'Name', 'si-portfolio' ); ?></label>
                    <input id="si-tf-name" class="si-form__input" type="text" name="contact_name" required autocomplete="name" aria-describedby="si-tf-name-error">
                    <span class="si-form__error" id="si-tf-name-error" aria-live="polite"></span>
                </div>
                <div class="si-form__field">
                    <label class="si-form__label" for="si-tf-email"><?php esc_html_e( 'Email', 'si-portfolio' ); ?></label>
                    <input id="si-tf-email" class="si-form__input" type="email" name="contact_email" required autocomplete="email" aria-describedby="si-tf-email-error">
                    <span class="si-form__error" id="si-tf-email-error" aria-live="polite"></span>
                </div>
                <div class="si-form__field">
                    <label class="si-form__label" for="si-tf-company"><?php esc_html_e( 'Game / studio name', 'si-portfolio' ); ?></label>
                    <input id="si-tf-company" class="si-form__input" type="text" name="contact_company" required autocomplete="organization" aria-describedby="si-tf-company-error">
                    <span class="si-form__error" id="si-tf-company-error" aria-live="polite"></span>
                </div>
            </div>

            <button class="si-form__submit-btn si-tf__submit-btn" type="button">
                <?php esc_html_e( 'Send my answers', 'si-portfolio' ); ?>
                <svg class="si-form__submit-arrow" width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                    <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="si-form__submit-spinner" aria-hidden="true"></span>
            </button>
            <p class="si-form__error si-tf__form-error" aria-live="polite"></p>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>

    </div><!-- .si-form__steps-wrap -->

    <!-- Success overlay -->
    <div class="si-form__success" aria-hidden="true" role="status">
        <div class="si-form__success-icon" aria-hidden="true">
            <svg width="44" height="44" viewBox="0 0 44 44" fill="none">
                <path class="si-form__success-check" d="M10 22l9 9 15-18" stroke="#D4A853" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
        <h2 class="si-form__success-heading" tabindex="-1"><?php esc_html_e( 'Got it', 'si-portfolio' ); ?></h2>
        <p class="si-form__success-sub"><?php echo esc_html( si_setting( 'form_thread_finder_success', "Got it - I'll read through this properly and get back to you." ) ); ?></p>
    </div>

    <!-- Honeypot (hidden from humans) -->
    <input
        class="si-form__honeypot"
        name="si_honeypot"
        type="text"
        tabindex="-1"
        autocomplete="off"
        aria-hidden="true"
        style="position:absolute;left:-9999px;opacity:0;pointer-events:none;"
    >

</section>
