<?php defined( 'ABSPATH' ) || exit; ?>
 
<header class="si-scope si-site-header" role="banner">
    <div class="si-site-header__inner">

        <a href="/" class="si-site-header__logo" aria-label="Shane Ivers — Home">
            <?php
            $logo_file = SI_PLUGIN_DIR . 'assets/svg/shane-ivers-logo.svg';
            if ( file_exists( $logo_file ) ) {
                // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
                echo file_get_contents( $logo_file );
            }
            ?>
        </a>

        <button class="si-nav-toggle" aria-label="Open navigation" aria-expanded="false" aria-controls="si-nav">
            <span></span><span></span><span></span>
        </button>
 
        <nav class="si-nav" id="si-nav" role="navigation" aria-label="Primary navigation">
 
            <div class="si-nav__overlay-bg" aria-hidden="true">
                <svg class="si-nav__swirl-canvas" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid slice">
                    <defs>
                        <filter id="si-nav-glow" x="-50%" y="-50%" width="200%" height="200%">
                            <feGaussianBlur stdDeviation="1.5" result="blur"/>
                            <feMerge>
                                <feMergeNode in="blur"/>
                                <feMergeNode in="SourceGraphic"/>
                            </feMerge>
                        </filter>
                    </defs>
                    <!-- Left S-curve (logo organic form) -->
                    <g class="si-swirl-a">
                        <path d="M22,110 C-10,90 50,70 22,55 C-10,40 50,20 22,-20" fill="none" stroke="#D4A853" stroke-width="0.5" opacity="0.22" filter="url(#si-nav-glow)"/>
                        <path d="M16,110 C-15,86 44,64 16,48 C-15,32 44,10 16,-25" fill="none" stroke="#E8C675" stroke-width="0.28" opacity="0.11"/>
                    </g>
                    <!-- Right S-curve (mirrored) -->
                    <g class="si-swirl-b">
                        <path d="M78,110 C110,90 50,70 78,55 C110,40 50,20 78,-20" fill="none" stroke="#D4A853" stroke-width="0.5" opacity="0.18" filter="url(#si-nav-glow)"/>
                        <path d="M84,110 C115,86 56,64 84,48 C115,32 56,10 84,-25" fill="none" stroke="#E8C675" stroke-width="0.28" opacity="0.09"/>
                    </g>
                    <!-- Central S-curve -->
                    <g class="si-swirl-c">
                        <path d="M50,115 C18,90 82,65 50,40 C18,15 82,-10 50,-35" fill="none" stroke="#D4A853" stroke-width="0.32" opacity="0.10"/>
                    </g>
                    <!-- Right vertical bar cluster (logo bar motif) -->
                    <g class="si-swirl-bars">
                        <line x1="91.5" y1="-5" x2="91.5" y2="105" stroke="#D4A853" stroke-width="0.35" opacity="0.40"/>
                        <line x1="93.8" y1="-5" x2="93.8" y2="105" stroke="#D4A853" stroke-width="0.22" opacity="0.26"/>
                        <line x1="95.8" y1="-5" x2="95.8" y2="105" stroke="#D4A853" stroke-width="0.35" opacity="0.40"/>
                        <line x1="97.5" y1="-5" x2="97.5" y2="105" stroke="#E8C675" stroke-width="0.22" opacity="0.24"/>
                        <line x1="99.2" y1="-5" x2="99.2" y2="105" stroke="#D4A853" stroke-width="0.30" opacity="0.32"/>
                    </g>
                    <!-- Left vertical bar cluster (subtler) -->
                    <g class="si-swirl-bars-l">
                        <line x1="0.5" y1="-5" x2="0.5" y2="105" stroke="#D4A853" stroke-width="0.28" opacity="0.22"/>
                        <line x1="2.5" y1="-5" x2="2.5" y2="105" stroke="#D4A853" stroke-width="0.18" opacity="0.14"/>
                        <line x1="4.2" y1="-5" x2="4.2" y2="105" stroke="#D4A853" stroke-width="0.28" opacity="0.20"/>
                    </g>
                </svg>
            </div>
 
            <div class="si-nav__inner">
                <ul class="si-nav__list" role="list">
                    <li><a href="/composition" class="si-nav__link">Composition</a></li>
                    <li><a href="/learning-design" class="si-nav__link">Learning Design</a></li>
                    <li><a href="/about" class="si-nav__link">About</a></li>
                </ul>
            </div>
 
        </nav>

    </div>

</header>
