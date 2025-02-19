<?php
/**
 * @package ShaplaTools
 * @since 2.0.0
 */

/**
 * Customizations to the TinyMCE editor.
 *
 * @since 2.0.0
 */
class ShaplaTools_TinyMCE {

	private $plugin_name;
	private $plugin_url;

	/**
	 * Setup.
	 *
	 * @since  2.0.0.
	 *
	 * @return void
	 */
	public function __construct( $plugin_name, $plugin_url ) {

		$this->plugin_name = $plugin_name;
		$this->plugin_url = $plugin_url;

		// Add the buttons
		add_action( 'admin_init', array( $this, 'add_buttons' ), 11 );

		// Reorder the hr button
		add_filter( 'tiny_mce_before_init', array( $this, 'tiny_mce_before_init' ), 20, 2 );

		// Add translations for plugin
		add_filter( 'wp_mce_translation', array( $this, 'wp_mce_translation' ), 10, 2 );
	}

	/**
	 * Implement the TinyMCE button for creating a button.
	 *
	 * @since  2.0.0.
	 *
	 * @return void
	 */
	public function add_buttons() {
		if ( ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) ) {
			return;
		}

		// The hr button
		add_filter( 'mce_external_plugins', array( $this, 'add_tinymce_plugin' ) );
		add_filter( 'mce_buttons', array( $this, 'register_mce_button' ) );

		// The style formats
		add_filter( 'tiny_mce_before_init', array( $this, 'style_formats' ) );
		add_filter( 'mce_buttons_2', array( $this, 'register_mce_formats' ) );
	}

	/**
	 * Implement the TinyMCE plugin for creating a button.
	 *
	 * @since  2.0.0.
	 *
	 * @param  array    $plugins    The current array of plugins.
	 * @return array                The modified plugins array.
	 */
	public function add_tinymce_plugin( $plugins ) {
		$plugins['shaplatools_mce_hr_button'] = $this->plugin_url . '/assets/mce-button/mce-hr.js';

		return $plugins;
	}

	/**
	 * Implement the TinyMCE button for creating a button.
	 *
	 * @since  2.0.0.
	 *
	 * @param  array     $buttons      The current array of plugins.
	 * @return array                   The modified plugins array.
	 */
	public function register_mce_button( $buttons ) {
		$buttons[] = 'shaplatools_mce_hr_button';

		return $buttons;
	}

	/**
	 * Add styles to the Styles dropdown.
	 *
	 * @since  2.0.0.
	 *
	 * @param  array    $settings    TinyMCE settings array.
	 * @return array                 Modified array.
	 */
	public function style_formats( $settings ) {
		$style_formats = array(
			// Big (big)
			array(
				'title'   => __( 'Run In', 'shaplatools' ),
				'block'   => 'p',
				'classes' => 'shapla-intro-text run-in',
			),
			array(
				'title' => __( 'Alert', 'shaplatools' ),
				'items' => array(
					array(
						'title'      => __( 'Green', 'shaplatools' ),
						'block'      => 'p',
						'attributes' => array(
							'class' => 'shapla-alert shapla-alert--green',
						),
					),
					array(
						'title'      => __( 'Blue', 'shaplatools' ),
						'block'      => 'p',
						'attributes' => array(
							'class' => 'shapla-alert shapla-alert--blue',
						),
					),
					array(
						'title'      => __( 'Red', 'shaplatools' ),
						'block'      => 'p',
						'attributes' => array(
							'class' => 'shapla-alert shapla-alert--red',
						),
					),
					array(
						'title'      => __( 'Yellow', 'shaplatools' ),
						'block'      => 'p',
						'attributes' => array(
							'class' => 'shapla-alert shapla-alert--yellow',
						),
					),
					array(
						'title'      => __( 'Grey', 'shaplatools' ),
						'block'      => 'p',
						'attributes' => array(
							'class' => 'shapla-alert shapla-alert--grey',
						),
					),
				),
			),
		);

		// Combine with existing format definitions
		if ( isset( $settings['style_formats'] ) ) {
			$existing_formats = json_decode( $settings['style_formats'] );
			$style_formats    = array_merge( $existing_formats, $style_formats );
		}

		// Allow styles to be customized
		$style_formats = apply_filters( 'shaplatools_style_formats', $style_formats );

		// Encode
		$settings['style_formats'] = json_encode( $style_formats );

		return $settings;
	}

	/**
	 * Add the Styles dropdown for the Visual editor.
	 *
	 * @since  2.0.0.
	 *
	 * @param  array    $buttons    Array of activated buttons.
	 * @return array                The modified array.
	 */
	public function register_mce_formats( $buttons ) {
		// Add the styles dropdown
		array_unshift( $buttons, 'styleselect' );

		return $buttons;
	}

	/**
	 * Position the new hr button in the place that the old hr usually resides.
	 *
	 * @since  2.0.0.
	 *
	 * @param  array     $mceInit      The configuration for the current editor.
	 * @param  string    $editor_id    The ID for the current editor.
	 * @return array                   The modified configuration array.
	 */
	public function tiny_mce_before_init( $mceInit, $editor_id ) {
		if ( ! empty( $mceInit['toolbar1'] ) ) {
			if ( in_array( 'hr', explode( ',', $mceInit['toolbar1'] ) ) ) {
				// Remove the current positioning of the new hr button
				$mceInit['toolbar1'] = str_replace( ',hr,', ',shaplatools_mce_hr_button,', $mceInit['toolbar1'] );

				// Remove the duplicated new hr button
				$pieces              = explode( ',', $mceInit['toolbar1'] );
				$pieces              = array_unique( $pieces );
				$mceInit['toolbar1'] = implode( ',', $pieces );
			}
		}

		return $mceInit;
	}

	/**
	 * Add translations for plugin.
	 *
	 * @since  2.0.0.
	 *
	 * @param  array     $mce_translation    Key/value pairs of strings.
	 * @param  string    $mce_locale         Locale.
	 * @return array                         The updated translation array.
	 */
	public function wp_mce_translation( $mce_translation, $mce_locale ) {
		$additional_items = array(
			'Insert Horizontal Line' => __( 'Insert Horizontal Line', 'shaplatools' ),
			'Horizontal line'        => __( 'Horizontal line', 'shaplatools' ),
			'Style'                  => __( 'Style', 'shaplatools' ),
			'Plain'                  => __( 'Plain', 'shaplatools' ),
			'Strong'                 => __( 'Strong', 'shaplatools' ),
			'Double'                 => __( 'Double', 'shaplatools' ),
			'Dashed'                 => __( 'Dashed', 'shaplatools' ),
			'Dotted'                 => __( 'Dotted', 'shaplatools' )
		);

		return array_merge( $mce_translation, $additional_items );
	}
}
