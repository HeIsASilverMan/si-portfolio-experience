<?php defined( 'ABSPATH' ) || exit; ?>

<section
    class="si-scope si-thread-contact-form"
    data-form-type="game_music_contact"
    id="si-thread-contact"
    aria-label="<?php esc_attr_e( 'Game music enquiry form', 'si-portfolio' ); ?>"
>

    <div class="si-thread-contact-form__inner">

        <div class="si-thread-contact-form__fields">

            <h2 class="si-thread-contact-form__heading"><?php esc_html_e( 'Get in touch', 'si-portfolio' ); ?></h2>
            <p class="si-thread-contact-form__intro">
                <?php esc_html_e( "Not ready for the full Thread Finder? Tell me a bit about your project and I'll get back to you.", 'si-portfolio' ); ?>
            </p>

            <div class="si-form__field">
                <label class="si-form__label" for="si-tc-name"><?php esc_html_e( 'Name', 'si-portfolio' ); ?></label>
                <input id="si-tc-name" class="si-form__input" type="text" name="contact_name" required autocomplete="name" aria-describedby="si-tc-name-error">
                <span class="si-form__error" id="si-tc-name-error" aria-live="polite"></span>
            </div>

            <div class="si-form__field">
                <label class="si-form__label" for="si-tc-email"><?php esc_html_e( 'Email', 'si-portfolio' ); ?></label>
                <input id="si-tc-email" class="si-form__input" type="email" name="contact_email" required autocomplete="email" aria-describedby="si-tc-email-error">
                <span class="si-form__error" id="si-tc-email-error" aria-live="polite"></span>
            </div>

            <div class="si-form__field">
                <label class="si-form__label" for="si-tc-company"><?php esc_html_e( 'Game / studio name', 'si-portfolio' ); ?></label>
                <input id="si-tc-company" class="si-form__input" type="text" name="contact_company" autocomplete="organization">
            </div>

            <div class="si-form__field">
                <label class="si-form__label" for="si-tc-link"><?php esc_html_e( 'Link to game, trailer, or Steam page', 'si-portfolio' ); ?></label>
                <input id="si-tc-link" class="si-form__input" type="url" name="project_link" placeholder="https://" aria-describedby="si-tc-link-error">
                <span class="si-form__error" id="si-tc-link-error" aria-live="polite"></span>
            </div>

            <div class="si-form__field">
                <label class="si-form__label" for="si-tc-message"><?php esc_html_e( 'Message', 'si-portfolio' ); ?></label>
                <textarea
                    id="si-tc-message"
                    class="si-form__textarea si-thread-contact-form__textarea"
                    name="message"
                    rows="5"
                    required
                    aria-describedby="si-tc-message-error"
                    placeholder="<?php esc_attr_e( "Tell me about your project, your timeline, and what you're looking for.", 'si-portfolio' ); ?>"
                ></textarea>
                <span class="si-form__error" id="si-tc-message-error" aria-live="polite"></span>
            </div>

            <div class="si-form__field">
                <label class="si-form__label" for="si-tc-referral"><?php esc_html_e( 'How did you hear about this?', 'si-portfolio' ); ?></label>
                <select id="si-tc-referral" class="si-form__input si-form__select" name="referral_source">
                    <option value=""><?php esc_html_e( 'Select an option', 'si-portfolio' ); ?></option>
                    <option value="Reddit"><?php esc_html_e( 'Reddit', 'si-portfolio' ); ?></option>
                    <option value="Indie DB"><?php esc_html_e( 'Indie DB', 'si-portfolio' ); ?></option>
                    <option value="A catalogue track"><?php esc_html_e( 'A catalogue track', 'si-portfolio' ); ?></option>
                    <option value="Somewhere else"><?php esc_html_e( 'Somewhere else', 'si-portfolio' ); ?></option>
                </select>
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

            <button class="si-form__submit-btn si-thread-contact-form__submit-btn" type="button">
                <?php esc_html_e( 'Send', 'si-portfolio' ); ?>
                <svg class="si-form__submit-arrow" width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                    <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="si-form__submit-spinner" aria-hidden="true"></span>
            </button>
            <p class="si-form__error si-thread-contact-form__form-error" aria-live="polite"></p>

        </div>

        <div class="si-thread-contact-form__success" role="status">
            <div class="si-form__success-icon" aria-hidden="true">
                <svg width="44" height="44" viewBox="0 0 44 44" fill="none">
                    <path class="si-form__success-check" d="M10 22l9 9 15-18" stroke="#D4A853" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <h2 class="si-form__success-heading" tabindex="-1"><?php esc_html_e( 'Thanks', 'si-portfolio' ); ?></h2>
            <p class="si-form__success-sub"><?php echo esc_html( si_setting( 'form_thread_contact_success', "Thanks - I'll read this properly and get back to you within a couple of days." ) ); ?></p>
        </div>

    </div>

</section>
