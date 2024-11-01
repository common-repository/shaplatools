<?php

if ( ! class_exists( 'ShaplaShortcodes' ) ):

class ShaplaShortcodes {

	private $plugin_url;
	private $plugin_path;

	public function __construct( $plugin_url, $plugin_path ) {
		$this->plugin_url = $plugin_url;
		$this->plugin_path = $plugin_path;

		add_action( 'init', array( &$this, 'shortcodes_init' ) );
		add_filter( 'mce_external_languages', array( &$this, 'add_tinymce_lang' ), 10, 1 );
		add_action( 'wp_ajax_popup', array( &$this, 'shortcode_popup_callback' ) );
	}

	public function shortcodes_init() {
		if ( ( current_user_can( 'edit_posts' ) || current_user_can( 'edit_pages' ) ) && get_user_option( 'rich_editing' ) ) {
			add_filter( 'mce_external_plugins', array( &$this, 'add_rich_plugins' ) );
			add_filter( 'mce_buttons', array( &$this, 'register_rich_buttons' ) );
		}
	}

	public function add_tinymce_lang( $arr ) {
		$arr['shaplaShortcodes'] = $this->plugin_path . '/assets/js/plugin-lang.php';
		return $arr;
	}

	public function add_rich_plugins( $plugin_array ) {
		global $tinymce_version;

		if ( version_compare( $tinymce_version , '400', '<' ) ) {
			$plugin_array['shaplaShortcodes'] = $this->plugin_url . '/assets/js/editor_plugin.js';
		} else {
			$plugin_array['shaplaShortcodes'] = $this->plugin_url . '/assets/js/plugin.js';
		}

		return $plugin_array;
	}

	public function register_rich_buttons( $buttons ) {
		array_push( $buttons, 'shaplaShortcodes' );
		return $buttons;
	}

	public function shortcode_popup_callback(){
		require_once( 'shortcode-class.php' );
		$shortcode = new Shapla_Shortcodes( $_REQUEST['popup'] );

		?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head></head>
		<body>

		<div id="shapla-popup">

			<div id="shapla-sc-wrap">

				<div id="shapla-sc-form-wrap">
					<h2 id="shapla-sc-form-head"><?php echo $shortcode->popup_title; ?></h2>
					<span id="close-popup"></span>
				</div><!-- /#shapla-sc-form-wrap -->

				<form method="post" id="shapla-sc-form">

					<table id="shapla-sc-form-table">

						<?php echo $shortcode->output; ?>

						<tbody>
							<tr class="form-row">
								<?php if ( ! $shortcode->has_child ) : ?><td class="label">&nbsp;</td><?php endif; ?>
								<!-- <td class="field insert-field"> -->

								<!-- </td> -->
							</tr>
						</tbody>

					</table><!-- /#shapla-sc-form-table -->

					<div class="insert-field">
						<a href="#" class="button button-primary button-large shapla-insert"><?php _e( 'Insert Shortcode', 'shaplatools' ); ?></a>
					</div>

				</form><!-- /#shapla-sc-form -->

			</div><!-- /#shapla-sc-wrap -->

			<div class="clear"></div>

		</div><!-- /#popup -->

		</body>
		</html>
		<?php

		die();
	}

}

endif;
