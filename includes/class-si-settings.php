<?php
defined( 'ABSPATH' ) || exit;

/**
 * SI_Settings — admin options page + getter for front-end text.
 *
 * All text that appears on the front end can be overridden here.
 * Stored under a single wp_options key: 'si_options'.
 */
class SI_Settings {

	const OPTION_KEY = 'si_options';

	/* ── Bootstrap ───────────────────────────────────────── */

	public static function init() {
		add_action( 'admin_menu', [ __CLASS__, 'add_page' ] );
		add_action( 'admin_init', [ __CLASS__, 'register' ] );
	}

	/* ── Defaults ─────────────────────────────────────────── */

	public static function defaults() {
		return [
			// General
			'contact_email'      => 'shane@shaneivers.com',
			'spotify_url'        => '',
			'soundcloud_url'     => '',
			'linkedin_url'       => '',
			'patreon_url'        => '',

			// Composition Hero
			'comp_hero_label'    => 'Bespoke Composition',
			'comp_hero_headline' => 'Every Project Deserves Its Own Sound',
			'comp_hero_sub'      => "I don't do templates, stock music, or \"that kind of thing.\" Every piece is composed from scratch -- shaped to your story, your audience, and the feeling you need to leave behind. Whether it's a 30-second sting or a feature-length score, it'll be yours entirely.",
			'comp_hero_cta1'     => 'Hear the Work',
			'comp_hero_cta2'     => 'How it works',

			// Benefits List
			'benefits_label'     => 'What You Get',
			'benefits_heading'   => 'Music built for your project, not borrowed from a library',
			'benefit_1_text'     => 'Music that complements, never overpowers',
			'benefit_1_detail'   => 'The score should serve your story -- not compete with it. I compose with your project playing, not in isolation.',
			'benefit_2_text'     => 'Music that makes people remember your story',
			'benefit_2_detail'   => "The best scores are invisible in the moment and unforgettable afterwards. That's the target.",
			'benefit_3_text'     => 'Music that enhances professionalism',
			'benefit_3_detail'   => 'Broadcast-ready masters in every format you need -- stems, sync-ready mixes, the lot.',
			'benefit_4_text'     => 'Music that just sounds awesome',
			'benefit_4_detail'   => "Life's too short for music that's merely adequate.",

			// Process Timeline
			'process_label'      => 'The Process',
			'process_heading'    => 'How we get from brief to brilliant',
			'step_1_title'       => 'Brief',
			'step_1_body'        => "Tell me your vision, your audience, and the feeling you're after. The more I know, the better the music.",
			'step_2_title'       => 'Research',
			'step_2_body'        => "I immerse myself in your project -- watching cuts, studying references, absorbing the world you're building.",
			'step_3_title'       => 'Compose',
			'step_3_body'        => 'Iterative drafts with your feedback woven in. Nothing goes forward without your sign-off.',
			'step_4_title'       => 'Refine',
			'step_4_body'        => "We tighten, polish, and finesse until the music feels inevitable -- like it could never have been anything else.",
			'step_5_title'       => 'Deliver',
			'step_5_body'        => 'Master-quality files in every format you need: stems, mixes, sync-ready tracks, whatever the brief requires.',

			// Audio Showcase
			'audio_label'        => 'Portfolio',
			'audio_heading'      => 'Hear the Work',

			// CTA Band
			'cta_heading'        => "Let's create something extraordinary",
			'cta_sub'            => "Whether it's a score, a course, or something in between -- get in touch.",
			'cta_btn'            => 'Get in Touch',
		];
	}

	/* ── Public getter ────────────────────────────────────── */

	/**
	 * Retrieve a single setting value, falling back to the default.
	 *
	 * @param string $key
	 * @return string
	 */
	public static function get( $key ) {
		$options  = (array) get_option( self::OPTION_KEY, [] );
		$defaults = self::defaults();
		if ( isset( $options[ $key ] ) && '' !== $options[ $key ] ) {
			return $options[ $key ];
		}
		return isset( $defaults[ $key ] ) ? $defaults[ $key ] : '';
	}

	/* ── Admin menu ───────────────────────────────────────── */

	public static function add_page() {
		add_options_page(
			'SI Portfolio Settings',
			'SI Portfolio',
			'manage_options',
			'si-portfolio',
			[ __CLASS__, 'render_page' ]
		);
	}

	public static function register() {
		register_setting(
			'si_options_group',
			self::OPTION_KEY,
			[ __CLASS__, 'sanitize' ]
		);
	}

	/* ── Sanitise on save ─────────────────────────────────── */

	public static function sanitize( $input ) {
		$clean    = [];
		$defaults = self::defaults();
		foreach ( $defaults as $key => $default ) {
			$raw = isset( $input[ $key ] ) ? wp_unslash( $input[ $key ] ) : '';
			$clean[ $key ] = sanitize_textarea_field( $raw );
		}
		return $clean;
	}

	/* ── Page renderer ────────────────────────────────────── */

	public static function render_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$tabs = [
			'general'     => 'General',
			'composition' => 'Composition Page',
			'cta'         => 'CTA Band',
		];

		$active = 'general';
		if ( isset( $_GET['tab'] ) && array_key_exists( sanitize_key( $_GET['tab'] ), $tabs ) ) {
			$active = sanitize_key( $_GET['tab'] );
		}
		?>
		<div class="wrap">
			<h1>SI Portfolio Settings</h1>

			<nav class="nav-tab-wrapper" style="margin-bottom:1.5rem;">
				<?php foreach ( $tabs as $slug => $label ) : ?>
				<a href="<?php echo esc_url( admin_url( 'options-general.php?page=si-portfolio&tab=' . $slug ) ); ?>"
				   class="nav-tab<?php echo $active === $slug ? ' nav-tab-active' : ''; ?>">
					<?php echo esc_html( $label ); ?>
				</a>
				<?php endforeach; ?>
			</nav>

			<?php if ( isset( $_GET['settings-updated'] ) ) : ?>
			<div class="notice notice-success is-dismissible">
				<p><strong>Settings saved.</strong></p>
			</div>
			<?php endif; ?>

			<form method="post" action="options.php">
				<?php settings_fields( 'si_options_group' ); ?>
				<input type="hidden"
				       name="<?php echo esc_attr( self::OPTION_KEY ); ?>[_tab]"
				       value="<?php echo esc_attr( $active ); ?>">

				<?php self::render_tab( $active ); ?>

				<?php submit_button( 'Save Settings' ); ?>
			</form>
		</div>
		<?php
	}

	/* ── Tab renderers ────────────────────────────────────── */

	private static function render_tab( $tab ) {
		echo '<table class="form-table" role="presentation"><tbody>';

		if ( 'general' === $tab ) {
			self::section_heading( 'Contact &amp; Links' );
			self::field( 'contact_email', 'Contact Email', 'email',
				'Used as the mailto: address in the CTA Band button.' );
			self::field( 'spotify_url',    'Spotify URL',    'url' );
			self::field( 'soundcloud_url', 'SoundCloud URL', 'url' );
			self::field( 'linkedin_url',   'LinkedIn URL',   'url' );
			self::field( 'patreon_url',    'Patreon URL',    'url' );

		} elseif ( 'composition' === $tab ) {
			self::section_heading( 'Hero Section' );
			self::field( 'comp_hero_label',    'Label',    'text' );
			self::field( 'comp_hero_headline', 'Headline', 'text' );
			self::field( 'comp_hero_sub',      'Subtitle', 'textarea' );
			self::field( 'comp_hero_cta1',     'Primary Button Text', 'text' );
			self::field( 'comp_hero_cta2',     'Secondary Button Text', 'text' );

			self::section_heading( 'Benefits List', true );
			self::field( 'benefits_label',   'Label',   'text' );
			self::field( 'benefits_heading', 'Heading', 'text' );
			for ( $i = 1; $i <= 4; $i++ ) {
				self::field( 'benefit_' . $i . '_text',   'Benefit ' . $i . ' &mdash; Title',  'text' );
				self::field( 'benefit_' . $i . '_detail', 'Benefit ' . $i . ' &mdash; Detail', 'textarea' );
			}

			self::section_heading( 'Process Timeline', true );
			self::field( 'process_label',   'Label',   'text' );
			self::field( 'process_heading', 'Heading', 'text' );
			for ( $i = 1; $i <= 5; $i++ ) {
				self::field( 'step_' . $i . '_title', 'Step ' . $i . ' &mdash; Title', 'text' );
				self::field( 'step_' . $i . '_body',  'Step ' . $i . ' &mdash; Body',  'textarea' );
			}

			self::section_heading( 'Audio Showcase', true );
			self::field( 'audio_label',   'Label',   'text' );
			self::field( 'audio_heading', 'Heading', 'text' );

		} elseif ( 'cta' === $tab ) {
			self::section_heading( 'CTA Band' );
			self::field( 'cta_heading', 'Heading',     'text' );
			self::field( 'cta_sub',     'Subtext',     'textarea' );
			self::field( 'cta_btn',     'Button Text', 'text' );
		}

		echo '</tbody></table>';
	}

	/* ── Helpers ──────────────────────────────────────────── */

	private static function section_heading( $label, $spaced = false ) {
		$style = $spaced ? 'padding-top:2rem;' : '';
		echo '<tr><th colspan="2" style="' . esc_attr( $style ) . '">';
		echo '<h2 style="margin:0 0 0.25rem;font-size:1.1rem;">' . $label . '</h2>';
		echo '<hr style="margin:0;border-color:#ddd;">';
		echo '</th></tr>';
	}

	private static function field( $key, $label, $type = 'text', $note = '' ) {
		$value = self::get( $key );
		$name  = self::OPTION_KEY . '[' . $key . ']';
		echo '<tr>';
		echo '<th scope="row">';
		echo '<label for="si_opt_' . esc_attr( $key ) . '">' . $label . '</label>';
		echo '</th>';
		echo '<td>';
		if ( 'textarea' === $type ) {
			echo '<textarea name="' . esc_attr( $name ) . '"'
			   . ' id="si_opt_' . esc_attr( $key ) . '"'
			   . ' rows="3" class="large-text">'
			   . esc_textarea( $value )
			   . '</textarea>';
		} else {
			echo '<input type="' . esc_attr( $type ) . '"'
			   . ' name="' . esc_attr( $name ) . '"'
			   . ' id="si_opt_' . esc_attr( $key ) . '"'
			   . ' value="' . esc_attr( $value ) . '"'
			   . ' class="regular-text">';
		}
		if ( $note ) {
			echo '<p class="description">' . esc_html( $note ) . '</p>';
		}
		echo '</td>';
		echo '</tr>';
	}
}
