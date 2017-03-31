<?php
/**
 * Initializes the plugin.
 *
 * @package gravity-forms-bootstrap
 * @author  Mehdi Lahlou <mehdi.lahlou@free.fr>
 * @since   1.0.0
 */

namespace MedFreeman\WP\GravityFormsBootstrap;

use MedFreeman\WP\GravityFormsBootstrap\GFBootstrapScaffolding;

/**
 * Plugin initialization class
 */
class Plugin {

	/**
	 * The instance of the gf bootstrap scaffolding.
	 *
	 * @access private
	 * @var \MedFreeman\WP\GravityFormsBootstrap\GFBootstrapScaffolding
	 */
	private $gf_bootstrap_scaffolding;

	/**
	 * Setup the plugin's main functionality.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'i18n' ) );
		add_action( 'init', array( $this, 'init' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'styles' ) );

	}

	/**
	 * Initializes the plugin and fires an action other plugins can hook into.
	 *
	 * @author Allen Moore, 10up
	 * @return void
	 */
	public function init() {
		// Check if Gravity Forms is installed.
		if ( ! class_exists( 'GFForms' ) ) {
			// Display notice that Visual Compser is required.
			add_action( 'admin_notices', array( $this, 'gf_install_notice' ) );

			return;
		}

		$this->gf_bootstrap_scaffolding = new GFBootstrapScaffolding();
		$this->gf_bootstrap_scaffolding->init();

		do_action( 'gravityboot_init' );
	}

	/**
	 * Register and/or Enqueue
	 * Styles for the plugin
	 *
	 * @since 1.0
	 */
	public function styles() {
		$theme_dir = get_stylesheet_directory_uri();

		// wp_enqueue_style( 'gravity-bootstrap', GRAVITY_BOOT_URL . "/assets/css/gravity-forms-bootstrap.css", array(), null, 'all' );.
	}

	/**
	 * Prints a notice when gravity forms is not installed and activated.
	 *
	 * @uses get_plugin_data()
	 *
	 * @prints notice
	 * @return void
	 */
	public function gf_install_notice() {
		?>
		<div class="updated">
		  <p>
		  	<?php _esc_html_e( '<strong>Gravity forms bootstrap</strong> requires <strong><a href="http://www.gravityforms.com/" target="_blank">Gravity Forms</a><strong> plugin to be installed and activated on your site.', 'gravity-bootstrap', 'gravity-bootstrap' ); ?>
		  </p>
		</div>
		<?php
	}

	/**
	 * Sets up the text domain.
	 *
	 * @return void
	 */
	public function i18n() {
		$locale = apply_filters( 'plugin_locale', get_locale(), 'gravity-bootstrap' );
		load_textdomain( 'gravity-bootstrap', WP_LANG_DIR . '/gravity-bootstrap/gravity-bootstrap-' . $locale . '.mo' );
		load_plugin_textdomain( 'gravity-bootstrap', false, plugin_basename( GRAVITY_BOOT_PATH ) . '/languages/' );
	}
}

