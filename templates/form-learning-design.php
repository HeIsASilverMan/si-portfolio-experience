<?php defined( 'ABSPATH' ) || exit; ?>

<section
    class="si-scope si-form si-form--learning-design"
    data-form-type="learning_design"
    id="si-form-learning-design"
    aria-label="<?php esc_attr_e( 'Learning design project enquiry form', 'si-portfolio' ); ?>"
>

    <!-- Subtle background lines -->
    <div class="si-form__bg" aria-hidden="true">
        <div class="si-form__bg-lines"></div>
    </div>

    <!-- Progress bar -->
    <div class="si-form__progress" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="12">
        <div class="si-form__progress-fill"></div>
    </div>

    <!-- Top bar -->
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
            <span class="si-form__step-total">8</span>
        </p>
    </div>

    <div class="si-form__steps-wrap">

        <!-- ── Step 1: What do you need (multi-select) ────── -->
        <div class="si-form__step" data-step="1" data-field="services" data-multi="true" data-review-label="<?php esc_attr_e( 'Services needed', 'si-portfolio' ); ?>">
            <h2 class="si-form__question"><?php esc_html_e( 'What do you need?', 'si-portfolio' ); ?></h2>
            <p class="si-form__question-sub"><?php esc_html_e( 'Select all that apply.', 'si-portfolio' ); ?></p>
            <div class="si-form__options" role="group" aria-label="<?php esc_attr_e( 'Services needed', 'si-portfolio' ); ?>">
                <?php
                $services = array(
                    'E-Learning Course',
                    'Animation / Video',
                    'Consultation',
                    'Full Programme Design',
                    'Other',
                );
                foreach ( $services as $svc ) :
                ?>
                <button
                    class="si-form__option"
                    data-value="<?php echo esc_attr( $svc ); ?>"
                    role="checkbox"
                    aria-checked="false"
                    type="button"
                ><?php echo esc_html( $svc ); ?></button>
                <?php endforeach; ?>
            </div>
            <div class="si-form__nav">
                <button class="si-form__continue-btn" type="button">
                    <?php esc_html_e( 'Continue', 'si-portfolio' ); ?>
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                        <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
            <p class="si-form__error" aria-live="polite"></p>
        </div>

        <!-- ── Step 2: Tools / platforms (multi-select) ───── -->
        <div class="si-form__step" data-step="2" data-field="tools" data-multi="true" data-review-label="<?php esc_attr_e( 'Tools / platforms', 'si-portfolio' ); ?>">
            <h2 class="si-form__question"><?php esc_html_e( "What tools or platforms are you using?", 'si-portfolio' ); ?></h2>
            <p class="si-form__question-sub"><?php esc_html_e( 'Select all that apply, or skip if unsure.', 'si-portfolio' ); ?></p>
            <div class="si-form__options" role="group" aria-label="<?php esc_attr_e( 'Tools and platforms', 'si-portfolio' ); ?>">
                <?php
                $tools = array(
                    'Articulate 360',
                    'Articulate Rise',
                    'LMS (specify below)',
                    'No preference',
                    'Not sure',
                );
                foreach ( $tools as $tool ) :
                ?>
                <button
                    class="si-form__option"
                    data-value="<?php echo esc_attr( $tool ); ?>"
                    role="checkbox"
                    aria-checked="false"
                    type="button"
                ><?php echo esc_html( $tool ); ?></button>
                <?php endforeach; ?>
            </div>
            <div class="si-form__nav">
                <button class="si-form__continue-btn" type="button">
                    <?php esc_html_e( 'Continue', 'si-portfolio' ); ?>
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                        <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                <button class="si-form__skip-btn" type="button"><?php esc_html_e( 'Skip', 'si-portfolio' ); ?></button>
            </div>
        </div>

        <!-- ── Step 3: Project brief ─────────────────────── -->
        <div class="si-form__step" data-step="3" data-field="brief" data-review-label="<?php esc_attr_e( 'Project brief', 'si-portfolio' ); ?>">
            <h2 class="si-form__question"><?php esc_html_e( 'Tell me about the project', 'si-portfolio' ); ?></h2>
            <p class="si-form__question-sub"><?php esc_html_e( 'Audience, topic, goals &mdash; as much or as little as you know.', 'si-portfolio' ); ?></p>
            <div class="si-form__textarea-wrap">
                <textarea
                    class="si-form__textarea"
                    placeholder="<?php esc_attr_e( 'e.g. Compliance training for 200 customer service reps. We need something engaging that people will actually remember...', 'si-portfolio' ); ?>"
                    rows="5"
                    aria-label="<?php esc_attr_e( 'Project brief', 'si-portfolio' ); ?>"
                ></textarea>
                <span class="si-form__textarea-hint"><?php esc_html_e( 'Shift + Enter to continue', 'si-portfolio' ); ?></span>
            </div>
            <div class="si-form__nav">
                <button class="si-form__continue-btn" type="button">
                    <?php esc_html_e( 'Continue', 'si-portfolio' ); ?>
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                        <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
            <p class="si-form__error" aria-live="polite"></p>
        </div>

        <!-- ── Step 4: Learner count ─────────────────────── -->
        <div class="si-form__step" data-step="4" data-field="learner_count" data-review-label="<?php esc_attr_e( 'Learner count', 'si-portfolio' ); ?>">
            <h2 class="si-form__question"><?php esc_html_e( 'How many learners will this reach?', 'si-portfolio' ); ?></h2>
            <div class="si-form__options si-form__options--radio" role="radiogroup" aria-label="<?php esc_attr_e( 'Learner count', 'si-portfolio' ); ?>">
                <?php
                $counts = array( 'Under 50', '50 - 500', '500 - 5k', '5k+', 'Not sure' );
                foreach ( $counts as $count ) :
                ?>
                <button
                    class="si-form__option"
                    data-value="<?php echo esc_attr( $count ); ?>"
                    role="radio"
                    aria-checked="false"
                    type="button"
                >
                    <span class="si-form__option-radio" aria-hidden="true"></span>
                    <?php echo esc_html( $count ); ?>
                </button>
                <?php endforeach; ?>
            </div>
            <p class="si-form__error" aria-live="polite"></p>
        </div>

        <!-- ── Step 5: Timeline ──────────────────────────── -->
        <div class="si-form__step" data-step="5" data-field="timeline" data-review-label="<?php esc_attr_e( 'Timeline', 'si-portfolio' ); ?>">
            <h2 class="si-form__question"><?php esc_html_e( 'Timeline?', 'si-portfolio' ); ?></h2>
            <div class="si-form__options si-form__options--radio" role="radiogroup" aria-label="<?php esc_attr_e( 'Timeline', 'si-portfolio' ); ?>">
                <?php
                $timelines = array( 'ASAP', '2 - 4 weeks', '1 - 2 months', 'Flexible' );
                foreach ( $timelines as $tl ) :
                ?>
                <button
                    class="si-form__option"
                    data-value="<?php echo esc_attr( $tl ); ?>"
                    role="radio"
                    aria-checked="false"
                    type="button"
                >
                    <span class="si-form__option-radio" aria-hidden="true"></span>
                    <?php echo esc_html( $tl ); ?>
                </button>
                <?php endforeach; ?>
            </div>
            <p class="si-form__error" aria-live="polite"></p>
        </div>

        <!-- ── Step 6: Budget ────────────────────────────── -->
        <div class="si-form__step" data-step="6" data-field="budget" data-review-label="<?php esc_attr_e( 'Budget', 'si-portfolio' ); ?>">
            <h2 class="si-form__question"><?php esc_html_e( 'Budget range?', 'si-portfolio' ); ?></h2>
            <p class="si-form__question-sub"><?php esc_html_e( 'This helps me scope the project appropriately.', 'si-portfolio' ); ?></p>
            <div class="si-form__options si-form__options--radio" role="radiogroup" aria-label="<?php esc_attr_e( 'Budget', 'si-portfolio' ); ?>">
                <?php
                $budgets = array(
                    'Under &pound;2k',
                    '&pound;2k - &pound;5k',
                    '&pound;5k - &pound;10k',
                    '&pound;10k+',
                    "Let's discuss",
                );
                foreach ( $budgets as $budget ) :
                ?>
                <button
                    class="si-form__option"
                    data-value="<?php echo esc_attr( wp_strip_all_tags( $budget ) ); ?>"
                    role="radio"
                    aria-checked="false"
                    type="button"
                >
                    <span class="si-form__option-radio" aria-hidden="true"></span>
                    <?php echo $budget; ?>
                </button>
                <?php endforeach; ?>
            </div>
            <p class="si-form__error" aria-live="polite"></p>
        </div>

        <!-- ── Step 7: Contact details ───────────────────── -->
        <div class="si-form__step" data-step="7" data-field="contact" data-review-label="<?php esc_attr_e( 'Your details', 'si-portfolio' ); ?>">
            <h2 class="si-form__question"><?php esc_html_e( 'Your details', 'si-portfolio' ); ?></h2>
            <p class="si-form__question-sub"><?php esc_html_e( "I'll only use these to get back to you.", 'si-portfolio' ); ?></p>
            <div class="si-form__fields">
                <div class="si-form__field">
                    <label class="si-form__label" for="si-ld-name"><?php esc_html_e( 'Name', 'si-portfolio' ); ?></label>
                    <input
                        id="si-ld-name"
                        class="si-form__input"
                        type="text"
                        name="contact_name"
                        placeholder="<?php esc_attr_e( 'Your full name', 'si-portfolio' ); ?>"
                        required
                        autocomplete="name"
                    >
                </div>
                <div class="si-form__field">
                    <label class="si-form__label" for="si-ld-email"><?php esc_html_e( 'Email', 'si-portfolio' ); ?></label>
                    <input
                        id="si-ld-email"
                        class="si-form__input"
                        type="email"
                        name="contact_email"
                        placeholder="<?php esc_attr_e( 'you@company.com', 'si-portfolio' ); ?>"
                        required
                        autocomplete="email"
                    >
                </div>
                <div class="si-form__field">
                    <label class="si-form__label" for="si-ld-company"><?php esc_html_e( 'Company / Organisation (optional)', 'si-portfolio' ); ?></label>
                    <input
                        id="si-ld-company"
                        class="si-form__input"
                        type="text"
                        name="contact_company"
                        placeholder="<?php esc_attr_e( 'Acme Corp', 'si-portfolio' ); ?>"
                        autocomplete="organization"
                    >
                </div>
                <div class="si-form__field">
                    <label class="si-form__label" for="si-ld-role"><?php esc_html_e( 'Your role (optional)', 'si-portfolio' ); ?></label>
                    <input
                        id="si-ld-role"
                        class="si-form__input"
                        type="text"
                        name="contact_role"
                        placeholder="<?php esc_attr_e( 'e.g. L&D Manager', 'si-portfolio' ); ?>"
                        autocomplete="organization-title"
                    >
                </div>
            </div>
            <div class="si-form__nav">
                <button class="si-form__continue-btn" type="button">
                    <?php esc_html_e( 'Review &amp; Submit', 'si-portfolio' ); ?>
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                        <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
            <p class="si-form__error" aria-live="polite"></p>
        </div>

        <!-- ── Step 8: Review & Submit ───────────────────── -->
        <div class="si-form__step si-form__step--review" data-step="8">
            <h2 class="si-form__question"><?php esc_html_e( 'Looks good?', 'si-portfolio' ); ?></h2>
            <p class="si-form__question-sub"><?php esc_html_e( 'Check everything below, then send it over.', 'si-portfolio' ); ?></p>
            <div class="si-form__review-list" aria-label="<?php esc_attr_e( 'Your answers', 'si-portfolio' ); ?>">
                <!-- Populated by JS -->
            </div>
            <button class="si-form__submit-btn" type="button">
                <?php esc_html_e( 'Send Enquiry', 'si-portfolio' ); ?>
                <svg class="si-form__submit-arrow" width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                    <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="si-form__submit-spinner" aria-hidden="true"></span>
            </button>
            <p class="si-form__error" aria-live="polite"></p>
        </div>

    </div><!-- .si-form__steps-wrap -->

    <!-- Success overlay -->
    <div class="si-form__success" aria-hidden="true" role="status">
        <div class="si-form__success-icon" aria-hidden="true">
            <svg width="44" height="44" viewBox="0 0 44 44" fill="none">
                <path
                    class="si-form__success-check"
                    d="M10 22l9 9 15-18"
                    stroke="#D4A853"
                    stroke-width="2.5"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />
            </svg>
        </div>
        <h2 class="si-form__success-heading" tabindex="-1"><?php esc_html_e( "You're in.", 'si-portfolio' ); ?></h2>
        <p class="si-form__success-sub"><?php esc_html_e( "Thanks for reaching out. I'll review your brief and be in touch within 2 working days.", 'si-portfolio' ); ?></p>
    </div>

    <!-- Honeypot -->
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
