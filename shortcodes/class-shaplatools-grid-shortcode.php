<?php

if( ! class_exists('ShaplaTools_Grid_Shortcode') ):

class ShaplaTools_Grid_Shortcode
{
	private $plugin_path;
	private $plugin_name;

	public function __construct( $plugin_name, $plugin_path )
	{
		$this->plugin_name = $plugin_name;
		$this->plugin_path = $plugin_path;

		add_shortcode( 'shapla_row', array( $this, 'shapla_row' ) );
		add_shortcode( 'shapla_row_padding', array( $this, 'shapla_row_padding' ) );
		add_shortcode( 'shapla_col_one', array( $this, 'shapla_col_one' ) );
		add_shortcode( 'shapla_col_two', array( $this, 'shapla_col_two' ) );
		add_shortcode( 'shapla_col_three', array( $this, 'shapla_col_three' ) );
		add_shortcode( 'shapla_col_four', array( $this, 'shapla_col_four' ) );
		add_shortcode( 'shapla_col_five', array( $this, 'shapla_col_five' ) );
		add_shortcode( 'shapla_col_six', array( $this, 'shapla_col_six' ) );
		add_shortcode( 'shapla_col_seven', array( $this, 'shapla_col_seven' ) );
		add_shortcode( 'shapla_col_eight', array( $this, 'shapla_col_eight' ) );
		add_shortcode( 'shapla_col_nine', array( $this, 'shapla_col_nine' ) );
		add_shortcode( 'shapla_col_ten', array( $this, 'shapla_col_ten' ) );
		add_shortcode( 'shapla_col_eleven', array( $this, 'shapla_col_eleven' ) );
		add_shortcode( 'shapla_col_twelve', array( $this, 'shapla_col_twelve' ) );
		
		// Depreciated and merged with new shortcodes since 1.3.0
		add_shortcode( 'shapla_columns', array( $this, 'shapla_row_padding' ) );
		add_shortcode( 'shapla_one_third', array( $this, 'shapla_col_four' ) );
		add_shortcode( 'shapla_one_third_last', array( $this, 'shapla_col_four' ) );
		add_shortcode( 'shapla_two_third', array( $this, 'shapla_col_eight' ) );
		add_shortcode( 'shapla_two_third_last', array( $this, 'shapla_col_eight' ) );
		add_shortcode( 'shapla_one_half', array( $this, 'shapla_col_six' ) );
		add_shortcode( 'shapla_one_half_last', array( $this, 'shapla_col_six' ) );
		add_shortcode( 'shapla_one_fourth', array( $this, 'shapla_col_three' ) );
		add_shortcode( 'shapla_one_fourth_last', array( $this, 'shapla_col_three' ) );
		add_shortcode( 'shapla_three_fourth', array( $this, 'shapla_col_nine' ) );
		add_shortcode( 'shapla_three_fourth_last', array( $this, 'shapla_col_nine' ) );
		add_shortcode( 'shapla_one_sixth', array( $this, 'shapla_col_two' ) );
		add_shortcode( 'shapla_one_sixth_last', array( $this, 'shapla_col_two' ) );
		add_shortcode( 'shapla_five_sixth', array( $this, 'shapla_col_ten' ) );
		add_shortcode( 'shapla_five_sixth_last', array( $this, 'shapla_col_ten' ) );

		// Depreciated and backed up with new shortcodes since 1.3.0
		add_shortcode( 'shapla_one_fifth', array( $this, 'shapla_one_fifth' ) );
		add_shortcode( 'shapla_one_fifth_last', array( $this, 'shapla_one_fifth' ) );
		add_shortcode( 'shapla_two_fifth', array( $this, 'shapla_two_fifth' ) );
		add_shortcode( 'shapla_two_fifth_last', array( $this, 'shapla_two_fifth' ) );
		add_shortcode( 'shapla_three_fifth', array( $this, 'shapla_three_fifth' ) );
		add_shortcode( 'shapla_three_fifth_last', array( $this, 'shapla_three_fifth' ) );
		add_shortcode( 'shapla_four_fifth', array( $this, 'shapla_four_fifth' ) );
		add_shortcode( 'shapla_four_fifth_last', array( $this, 'shapla_four_fifth' ) );
	}

	/**
	 * A shortcode for rendering the shapla row with no padding.
	 */
	public function shapla_row( $atts, $content = null )
	{
		return '<div class="shapla-row">' . do_shortcode( $content ) . '</div>';
	}

	/**
	 * A shortcode for rendering the shapla row with padding.
	 */
	public function shapla_row_padding( $atts, $content = null )
	{
		return '<div class="shapla-row-padding">' . do_shortcode( $content ) . '</div>';
	}

	/**
	 * A shortcode for rendering one column on 12 grid system.
	 */
	public function shapla_col_one( $atts, $content = null ) {
		return '<div class="shapla-col m1 l1">' . do_shortcode( $content ) . '</div>';
	}

	/**
	 * A shortcode for rendering two column on 12 grid system.
	 */
	public function shapla_col_two( $atts, $content = null ) {
		return '<div class="shapla-col m2 l2">' . do_shortcode( $content ) . '</div>';
	}

	/**
	 * A shortcode for rendering three column on 12 grid system.
	 */
	public function shapla_col_three( $atts, $content = null ) {
		return '<div class="shapla-col m3 l3">' . do_shortcode( $content ) . '</div>';
	}

	/**
	 * A shortcode for rendering four column on 12 grid system.
	 */
	public function shapla_col_four( $atts, $content = null ) {
		return '<div class="shapla-col m4 l4">' . do_shortcode( $content ) . '</div>';
	}

	/**
	 * A shortcode for rendering five column on 12 grid system.
	 */
	public function shapla_col_five( $atts, $content = null ) {
		return '<div class="shapla-col m5 l5">' . do_shortcode( $content ) . '</div>';
	}

	/**
	 * A shortcode for rendering six column on 12 grid system.
	 */
	public function shapla_col_six( $atts, $content = null ) {
		return '<div class="shapla-col m6 l6">' . do_shortcode( $content ) . '</div>';
	}

	/**
	 * A shortcode for rendering seven column on 12 grid system.
	 */
	public function shapla_col_seven( $atts, $content = null ) {
		return '<div class="shapla-col m7 l7">' . do_shortcode( $content ) . '</div>';
	}

	/**
	 * A shortcode for rendering eight column on 12 grid system.
	 */
	public function shapla_col_eight( $atts, $content = null ) {
		return '<div class="shapla-col m8 l8">' . do_shortcode( $content ) . '</div>';
	}

	/**
	 * A shortcode for rendering nine column on 12 grid system.
	 */
	public function shapla_col_nine( $atts, $content = null ) {
		return '<div class="shapla-col m9 l9">' . do_shortcode( $content ) . '</div>';
	}

	/**
	 * A shortcode for rendering ten column on 12 grid system.
	 */
	public function shapla_col_ten( $atts, $content = null ) {
		return '<div class="shapla-col m10 l10">' . do_shortcode( $content ) . '</div>';
	}

	/**
	 * A shortcode for rendering eleven column on 12 grid system.
	 */
	public function shapla_col_eleven( $atts, $content = null ) {
		return '<div class="shapla-col m11 l11">' . do_shortcode( $content ) . '</div>';
	}

	/**
	 * A shortcode for rendering twelve column on 12 grid system.
	 */
	public function shapla_col_twelve( $atts, $content = null ) {
		return '<div class="shapla-col m12 l12">' . do_shortcode( $content ) . '</div>';
	}

	/**
	 * A shortcode for rendering two column on 10 grid system.
	 */
	public function shapla_one_fifth( $atts, $content = null ) {
		return '<div class="shapla-col m20 l20">' . do_shortcode( $content ) . '</div>';
	}

	/**
	 * A shortcode for rendering four column on 10 grid system.
	 */
	public function shapla_two_fifth( $atts, $content = null ) {
		return '<div class="shapla-col m40 l40">' . do_shortcode( $content ) . '</div>';
	}

	/**
	 * A shortcode for rendering six column on 10 grid system.
	 */
	public function shapla_three_fifth( $atts, $content = null ) {
		return '<div class="shapla-col m60 l60">' . do_shortcode( $content ) . '</div>';
	}

	/**
	 * A shortcode for rendering eight column on 10 grid system.
	 */
	public function shapla_four_fifth( $atts, $content = null ) {
		return '<div class="shapla-col m80 l80">' . do_shortcode( $content ) . '</div>';
	}
}

endif;
