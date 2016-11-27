<?php
/**
 * Gravity forms bootstrap field - row start.
 *
 * @package gravity-forms-bootstrap
 * @author  Mehdi Lahlou <mehdi.lahlou@free.fr>
 * @since   1.0.0
 */

namespace MedFreeman\WP\GravityFormsBootstrap\Fields;

class GFFieldRowBreak extends \GF_Field {
	public $type = 'row_break';

	public function get_form_editor_field_title() {
		return esc_attr__( 'Row break', 'gravity-bootstrap' );
	}

	public function is_conditional_logic_supported() {
		return false;
	}

	function get_form_editor_field_settings() {
		return array(
			'row_break_description',
			'css_class_setting'
		);
	}

	public function get_field_input( $form, $value = '', $entry = null ) {
		return '';
	}

	public function get_field_content( $value, $force_frontend_label, $form ) {
		$is_entry_detail = $this->is_entry_detail();
		$is_form_editor = $this->is_form_editor();
		$is_admin = $is_entry_detail || $is_form_editor;
		if( $is_admin ) {
			$admin_buttons = $this->get_admin_buttons();
			return $admin_buttons.'<label class=\'gfield_label\'>' . $this->get_form_editor_field_title() . '</label>{FIELD}<hr>';
		}
		return '';
	}
}
