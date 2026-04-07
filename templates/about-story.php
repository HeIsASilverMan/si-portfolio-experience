<?php defined( 'ABSPATH' ) || exit; ?>

<section class="si-scope si-about-story" aria-label="About Shane Ivers">

    <div class="si-about-story__bg" aria-hidden="true">
        <div class="si-about-story__orb"></div>
    </div>

    <div class="si-about-story__inner">

        <!-- Photo column -->
        <div class="si-about-story__photo-col si-reveal">
            <div class="si-about-story__photo-frame">
                <div class="si-about-story__photo-placeholder" aria-label="<?php esc_attr_e( 'Photo of Shane Ivers', 'si-portfolio' ); ?>">
                    <svg width="64" height="64" viewBox="0 0 64 64" fill="none" aria-hidden="true">
                        <circle cx="32" cy="24" r="12" stroke="#D4A853" stroke-width="1.5" stroke-opacity="0.4"/>
                        <path d="M8 56c0-13.255 10.745-24 24-24s24 10.745 24 24" stroke="#D4A853" stroke-width="1.5" stroke-opacity="0.4" stroke-linecap="round"/>
                    </svg>
                    <p class="si-about-story__photo-hint"><?php esc_html_e( 'Add a headshot via Featured Image', 'si-portfolio' ); ?></p>
                </div>
            </div>
            <div class="si-about-story__credentials" role="list" aria-label="<?php esc_attr_e( 'Credentials', 'si-portfolio' ); ?>">
                <span class="si-badge" role="listitem"><?php esc_html_e( "Master's &mdash; Electronic Composition", 'si-portfolio' ); ?></span>
                <span class="si-badge" role="listitem"><?php esc_html_e( 'L5 Digital Learning Design &mdash; Distinction', 'si-portfolio' ); ?></span>
                <span class="si-badge" role="listitem"><?php esc_html_e( 'ACMALT (in progress)', 'si-portfolio' ); ?></span>
                <span class="si-badge si-badge--gold" role="listitem"><?php esc_html_e( 'Gold Stevie Award Winner', 'si-portfolio' ); ?></span>
            </div>
        </div>

        <!-- Bio column -->
        <div class="si-about-story__bio-col">

            <p class="si-about-story__label si-reveal"><?php esc_html_e( 'The Human', 'si-portfolio' ); ?></p>

            <h1 class="si-about-story__headline si-reveal">
                <?php esc_html_e( 'Composer. Learning Designer. Obsessive Perfectionist.', 'si-portfolio' ); ?>
            </h1>

            <div class="si-about-story__body si-reveal">
                <p>
                    <?php esc_html_e( 'I grew up surrounded by music and art &mdash; spending hours in galleries as a kid, watching how a single piece could change the atmosphere in a room. That early obsession never left. It just evolved.', 'si-portfolio' ); ?>
                </p>
            </div>

            <blockquote class="si-about-story__pull si-reveal">
                <p><?php esc_html_e( 'I took out a student loan on equipment before I had a single client. That&rsquo;s how certain I was that this was worth doing properly.', 'si-portfolio' ); ?></p>
            </blockquote>

            <div class="si-about-story__body si-reveal">
                <p>
                    <?php esc_html_e( 'Composition came first &mdash; a Master&rsquo;s in Electronic Composition from the University of Liverpool, a studio built piece by piece, and years of work across film, games, and commercial media. Every project composed from scratch. No templates. No stock.', 'si-portfolio' ); ?>
                </p>
                <p>
                    <?php esc_html_e( 'Learning design followed naturally. The same principles apply: understand your audience, craft something that connects, and measure whether it actually works. A Gold Stevie Award for the CHATS Programme at Raytheon is the kind of validation you don&rsquo;t ignore.', 'si-portfolio' ); ?>
                </p>
                <p>
                    <?php esc_html_e( 'Now I do both &mdash; deliberately. Because a composer who understands cognition, and a learning designer who understands emotion, is a rare thing. Based in Didcot, UK. Available worldwide.', 'si-portfolio' ); ?>
                </p>
            </div>

            <!-- Career milestones -->
            <div class="si-about-story__timeline si-reveal" role="list" aria-label="<?php esc_attr_e( 'Career milestones', 'si-portfolio' ); ?>">

                <?php
                $milestones = array(
                    array(
                        'year' => '2010s',
                        'text' => __( 'Began composing professionally &mdash; film, games, commercial', 'si-portfolio' ),
                    ),
                    array(
                        'year' => '2018',
                        'text' => __( "Master's in Electronic Composition, University of Liverpool", 'si-portfolio' ),
                    ),
                    array(
                        'year' => '2021',
                        'text' => __( 'Gold Stevie Award &mdash; CHATS Programme, Raytheon', 'si-portfolio' ),
                    ),
                    array(
                        'year' => '2023',
                        'text' => __( 'L5 Digital Learning Design Apprenticeship &mdash; Distinction', 'si-portfolio' ),
                    ),
                    array(
                        'year' => 'Now',
                        'text' => __( 'Dual-discipline practice: bespoke composition + learning design', 'si-portfolio' ),
                    ),
                );
                foreach ( $milestones as $m ) :
                ?>
                <div class="si-about-story__milestone" role="listitem">
                    <span class="si-about-story__milestone-year"><?php echo esc_html( $m['year'] ); ?></span>
                    <span class="si-about-story__milestone-text"><?php echo esc_html( $m['text'] ); ?></span>
                </div>
                <?php endforeach; ?>

            </div>

        </div>

    </div>

</section>
