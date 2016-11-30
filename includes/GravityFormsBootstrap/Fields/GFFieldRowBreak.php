<?php
/**
 * Gravity forms bootstrap field - row start.
 *
 * @package gravity-forms-bootstrap
 * @author  Mehdi Lahlou <mehdi.lahlou@free.fr>
 * @since   1.0.0
 */

namespace MedFreeman\WP\GravityFormsBootstrap\Fields;

/**
 * Class that deals with row breaks to allow forms responsive layout.
 */
class GFFieldRowBreak extends \GF_Field {

	/**
	 * The type of gravity forms field.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'row_break';

	/**
	 * Returns the gravity form field title.
	 *
	 * @return string field title
	 */
	public function get_form_editor_field_title() {
		return esc_attr__( 'Row break', 'gravity-bootstrap' );
	}

	/**
	 * Enables or disables field conditional logic.
	 * There's no need since it's only a layout element.
	 *
	 * @return boolean
	 */
	public function is_conditional_logic_supported() {
		return false;
	}

	/**
	 * Sets the fields supported by this form element.
	 *
	 * @return array Array of field parameters
	 */
	function get_form_editor_field_settings() {
		return array(
			'row_break_description',
			'css_class_setting',
		);
	}

	/**
	 * Disales the fields input tag.
	 * There's no need since it's only a layout element.
	 *
	 * @param array   $form  Gravity Form array.
	 * @param string  $value Field initial value.
	 * @param integer $entry When executed from the entry detail screen, $lead_id will be populated with the Entry ID.
	 * Otherwise, it will be 0.
	 *
	 * @return string Field html markup.
	 */
	public function get_field_input( $form, $value = '', $entry = null ) {
		return '';
	}

	/**
	 * Sets the fields content in admin form creation.
	 *
	 * @param string  $value field value.
	 * @param boolean $force_frontend_label ?.
	 * @param array   $form  Gravity Form array.
	 *
	 * @return array html markup
	 */
	public function get_field_content( $value, $force_frontend_label, $form ) {
		$is_entry_detail = $this->is_entry_detail();
		$is_form_editor = $this->is_form_editor();
		$is_admin = $is_entry_detail || $is_form_editor;
		if ( $is_admin ) {
			$admin_buttons = $this->get_admin_buttons();
			return $admin_buttons . '<label class=\'gfield_label\'>' . $this->get_form_editor_field_title() . '</label>{FIELD}<hr>';
		}
		return '';
	}
}
