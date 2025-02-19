<?php

class Shapla_Shortcodes {

	var	$conf;
	var	$popup;
	var	$params;
	var	$shortcode;
	var $cparams;
	var $cshortcode;
	var $popup_title;
	var $no_preview;
	var $has_child;
	var	$output;
	var	$errors;

	function __construct( $popup ) {
		if ( file_exists( dirname( __FILE__ ) . '/config.php' ) ) {
			$this->conf = dirname( __FILE__ ) . '/config.php';
			$this->popup = $popup;

			$this->format_shortcode();
		} else {
			$this->append_error( __( 'Config file does not exist', 'shaplatools' ) );
		}
	}

	function append_output( $output ) {
		$this->output = $this->output . "\n" . $output;
	}

	function reset_output( $output ) {
		$this->output = '';
	}

	function append_error( $error ) {
		$this->errors = $this->errors . "\n" . $error;
	}

	function format_shortcode() {
		global $shaplatools;
		require_once( $this->conf );

		if ( isset( $shapla_shortcodes[$this->popup]['child_shortcode'] ) ) {
			$this->has_child = true;
		}

		if ( isset( $shapla_shortcodes ) && is_array( $shapla_shortcodes ) ) {
			$this->params = $shapla_shortcodes[$this->popup]['params'];
			$this->shortcode = $shapla_shortcodes[$this->popup]['shortcode'];
			$this->popup_title = $shapla_shortcodes[$this->popup]['popup_title'];

			$this->append_output( "\n" . '<div id="_shapla_shortcode" class="hidden">' . $this->shortcode . '</div>' );
			$this->append_output( "\n" . '<div id="_shapla_popup" class="hidden">' . $this->popup . '</div>' );

			if ( isset( $shapla_shortcodes[$this->popup]['no_preview'] ) && $shapla_shortcodes[$this->popup]['no_preview'] ) {
				$this->no_preview = true;
			}

			foreach ( $this->params as $pkey => $param ) {

				// prefix the name and id with shapla_
				$pkey = 'shapla_' . $pkey;

				$row_start  = '<tbody>' . "\n";
				$row_start .= '<tr class="form-row">' . "\n";
				$row_start .= '<td class="label">' . $param['label'] . '</td>' . "\n";
				$row_start .= '<td class="field">' . "\n";

				$row_end	= '<span class="shapla-form-desc">' . $param['desc'] . '</span>' . "\n";
				$row_end   .= '</td>' . "\n";
				$row_end   .= '</tr>' . "\n";
				$row_end   .= '</tbody>' . "\n";

				switch ( $param['type'] ) {

					case 'text' :
						$output = $row_start;
						$output .= '<input type="text" class="shapla-form-text shapla-input" name="' . $pkey . '" id="' . $pkey . '" value="' . $param['std'] . '" />'."\n";
						$output .= $row_end;
						$this->append_output( $output );
					break;

					case 'textarea' :
						$output = $row_start;
						$output .= '<textarea rows="8" cols="30" class="shapla-form-textarea shapla-input" name="' . $pkey . '" id="' . $pkey . '">' . $param['std'] . '</textarea>'."\n";
						$output .= $row_end;
						$this->append_output( $output );
					break;

					case 'select' :
						$output = $row_start;
						$output .= '<select name="' . $pkey . '" id="' . $pkey . '" class="shapla-form-select shapla-input">' . "\n";

						ksort( $param['options'] );

						if ( ! isset( $param['std'] ) ) $param['std'] = '';

						foreach ( $param['options'] as $value => $option ) {
							$output .= "<option value='$value' ". selected( $value, $param['std'], false ) .">$option</option>";
						}

						$output .= '</select>' . "\n";
						$output .= $row_end;
						$this->append_output( $output );
					break;

					case 'buttonset' :
						$output = $row_start;

						ksort( $param['options'] );

						$output .= "<div class='shapla-control-buttonset'>";

						if ( ! isset( $param['std'] ) ) $param['std'] = '';

						foreach ( $param['options'] as $value => $option ) {
							$output .= "<input data-key='$pkey' id='{$pkey}_{$value}' name='$pkey' type='radio' value='$value' ". checked( $value, $param['std'], false ) ." />";
							$output .= "<label data-key='$pkey' for='{$pkey}_{$value}'>$option</label>";
						}

						$output .= '</div>';
						$output .= '<input class="shapla-input" type="hidden" name="' . $pkey . '" id="' . $pkey . '" value="' . $param['std'] . '" />';
						$output .= $row_end;
						$this->append_output( $output );
					break;

					case 'checkbox' :
						$output = $row_start;
						$output .= '<label for="' . $pkey . '" class="shapla-form-checkbox">' . "\n";
						$output .= '<input type="checkbox" class="shapla-input" name="' . $pkey . '" id="' . $pkey . '" ' . ( $param['std'] ? 'checked' : '' ) . ' />' . "\n";
						$output .= ' ' . $param['checkbox_text'] . '</label>' . "\n";
						$output .= $row_end;
						$this->append_output( $output );
					break;

					case 'image';
						$output = $row_start;
						$output .= '<a href="#" data-type="image" data-text="Insert Image" class="shapla-open-media button" title="' . esc_attr__( 'Choose Image', 'shaplatools' ) . '">' . __( 'Choose Image', 'shaplatools' ) . '</a>';
						$output .= '<input class="shapla-input" type="text" name="' . $pkey . '" id="' . $pkey . '" value="' . $param['std'] . '" />';
						$output .= $row_end;
						$this->append_output( $output );
					break;

					case 'video';
						$output = $row_start;
						$output .= '<a href="#" data-type="video" data-text="Insert Video" class="shapla-open-media button" title="' . esc_attr__( 'Choose Video', 'shaplatools' ) . '">' . __( 'Choose Video', 'shaplatools' ) . '</a>';
						$output .= '<input class="shapla-input" type="text" name="' . $pkey . '" id="' . $pkey . '" value="' . $param['std'] . '" />';
						$output .= $row_end;
						$this->append_output( $output );
					break;

					case 'icons':
						$output = $row_start;
						$output .= '<div class="shapla-all-icons">';

						$output .= '</div>';
						$output .= '<input class="shapla-input" type="hidden" name="' . $pkey . '" id="' . $pkey . '" value="' . $param['std'] . '" />';
						$output .= $row_end;
						$this->append_output( $output );
					break;

					case 'widget_area':
						if ( $shaplatools->is_scs_active() ){
							$output = $row_start;

							$output .= '<p>Hello Custom Widget Area</p>';

							$output .= $row_end;
							$this->append_output( $output );
						} else {
							return false;
						}
					break;

				}
			}

			if ( isset( $shapla_shortcodes[$this->popup]['child_shortcode'] ) ) {
				$this->cparams = $shapla_shortcodes[$this->popup]['child_shortcode']['params'];
				$this->cshortcode = $shapla_shortcodes[$this->popup]['child_shortcode']['shortcode'];

				$prow_start  = '<tbody>' . "\n";
				$prow_start .= '<tr class="form-row has-child">' . "\n";
				$prow_start .= '<td><a href="#" id="form-child-add" class="button-secondary">' . $shapla_shortcodes[$this->popup]['child_shortcode']['clone_button'] . '</a>' . "\n";
				$prow_start .= '<div class="child-clone-rows">' . "\n";

				// for js use
				$prow_start .= '<div id="_shapla_cshortcode" class="hidden">' . $this->cshortcode . '</div>' . "\n";

				// start the default row
				$prow_start .= '<div class="child-clone-row">' . "\n";
				$prow_start .= '<ul class="child-clone-row-form">' . "\n";

				$this->append_output( $prow_start );

				foreach ( $this->cparams as $cpkey => $cparam ) {
					$cpkey = 'shapla_' . $cpkey;

					$crow_start  = '<li class="child-clone-row-form-row">' . "\n";
					$crow_start .= '<div class="child-clone-row-label">' . "\n";
					$crow_start .= '<label>' . $cparam['label'] . '</label>' . "\n";
					$crow_start .= '</div>' . "\n";
					$crow_start .= '<div class="child-clone-row-field">' . "\n";

					$crow_end	  = '<span class="child-clone-row-desc">' . $cparam['desc'] . '</span>' . "\n";
					$crow_end   .= '</div>' . "\n";
					$crow_end   .= '</li>' . "\n";

					switch ( $cparam['type'] ) {

						case 'text':
							$coutput  = $crow_start;
							$coutput .= '<input type="text" class="shapla-form-text shapla-cinput" name="' . $cpkey . '" id="' . $cpkey . '" value="' . $cparam['std'] . '" />' . "\n";
							$coutput .= $crow_end;
							$this->append_output( $coutput );
						break;

						case 'textarea':
							$coutput  = $crow_start;
							$coutput .= '<textarea rows="10" cols="30" name="' . $cpkey . '" id="' . $cpkey . '" class="shapla-form-textarea shapla-cinput">' . $cparam['std'] . '</textarea>' . "\n";
							$coutput .= $crow_end;
							$this->append_output( $coutput );
						break;

						case 'select' :
							$coutput  = $crow_start;
							$coutput .= '<select name="' . $cpkey . '" id="' . $cpkey . '" class="shapla-form-select shapla-cinput">' . "\n";

							foreach ( $cparam['options'] as $value => $option ) {
								$coutput .= '<option value="' . $value . '">' . $option . '</option>' . "\n";
							}

							$coutput .= '</select>' . "\n";
							$coutput .= $crow_end;
							$this->append_output( $coutput );
						break;

						case 'checkbox' :
							$coutput  = $crow_start;
							$coutput .= '<label for="' . $cpkey . '" class="shapla-form-checkbox">' . "\n";
							$coutput .= '<input type="checkbox" class="shapla-cinput" name="' . $cpkey . '" id="' . $cpkey . '" ' . ( $cparam['std'] ? 'checked' : '' ) . ' />' . "\n";
							$coutput .= ' ' . $cparam['checkbox_text'] . '</label>' . "\n";
							$coutput .= $crow_end;
							$this->append_output( $coutput );
						break;

					}
				}

				$prow_end    = '</ul>' . "\n";
				$prow_end   .= '<a href="#" class="child-clone-row-remove">Remove</a>' . "\n";
				$prow_end   .= '</div>' . "\n";
				$prow_end   .= '</div>' . "\n";
				$prow_end   .= '</td>' . "\n";
				$prow_end   .= '</tr>' . "\n";
				$prow_end   .= '</tbody>' . "\n";

				$this->append_output( $prow_end );
			}
		}
	}
}
