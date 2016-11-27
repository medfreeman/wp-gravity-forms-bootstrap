<?php
/**
 * Gravity forms bootstrap scaffolding support.
 *
 * @package gravity-forms-bootstrap
 * @author  Mehdi Lahlou <mehdi.lahlou@free.fr>
 * @since   1.0.0
 */

namespace MedFreeman\WP\GravityFormsBootstrap;

use MedFreeman\WP\Dev\Hooks;

use MedFreeman\WP\GravityFormsBootstrap\Fields\GFFieldRowBreak;

/**
 * Gravity forms bootstrap scaffolding class.
 */
class GFBootstrapScaffolding {
	const FIELDS_PATH = __DIR__ . '/Fields/';

	use Hooks;

	/**
	 * Store gravity forms fields instances.
	 *
	 * @access private
	 * @var array \MedFreeman\WP\GravityFormsBootstrap\Fields (GF_Field)
	 */
	private $fields_instances;

	/**
	 * Find gravity forms fields.
	 *
	 * @return void
	 */
	function __construct() {
		$this->fields_instances = array();

		$this->fields_instances[] = new GFFieldRowBreak;
	}

	/**
	 * Initialize gravity forms bootstrap scaffolding.
	 *
	 * @return void
	 */
	public function init() {
		$this->add_action( 'init', 'register_gf_fields', 20 );
		$this->add_action( 'gform_field_standard_settings', 'add_gf_fields_settings', 10, 2);
		$this->add_filter( 'gform_field_container', 'filter_gf_field_containers', 10, 6);
		// $this->add_action( 'gform_enqueue_scripts', 'enqueue_gf_multi_column_scripts', 10, 2);
	}

	private function register_gf_fields() {
		foreach ( $this->fields_instances as $instance ) {
			\GF_Fields::register( $instance );
		}
	}

	private function add_gf_fields_settings( $position, $form_id ) {
		if( 0 === $position ) {
			$description = 'Row breaks should be placed between fields to split form into separate rows. You do not need to place any row breaks at the beginning or end of the form, only in the middle.';
			echo '<li class="row_break_description field_setting">' . $description . '</li>';
		}
	}

	private function filter_gf_field_containers( $field_container, $field, $form, $css_class, $style, $field_content ) {
		if( IS_ADMIN ) {
			return $field_container;
		}

		if ( 'row_break' === $field->type ) {
			return '</ul><ul class="' . \GFCommon::get_ul_classes( $form ) . $field['cssClass'] . '">';
		}
		return $field_container;
	}

	private static function enqueue_gf_multi_column_scripts( $form, $ajax ) {
		if ( ! get_option('rg_gforms_disable_css') ) {
			wp_enqueue_style( 'gforms-bootstrap', GRAVITY_BOOT_URL . "/assets/css/gravity-forms-bootstrap.css", array(), GRAVITY_BOOT_VERSION, 'all' );
		}
	}
}
