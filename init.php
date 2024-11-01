<?php
/*
Plugin Name:	Widget Area Scroller
Description:	Easily make your widget area scrollable!
Author:			Hassan Derakhshandeh
Version:		0.1
Author URI:		http://tween.ir/


		* 	Copyright (C) 2011  Hassan Derakhshandeh
		*	http://tween.ir/
		*	hassan.derakhshandeh@gmail.com

		This program is free software; you can redistribute it and/or modify
		it under the terms of the GNU General Public License as published by
		the Free Software Foundation; either version 2 of the License, or
		(at your option) any later version.

		This program is distributed in the hope that it will be useful,
		but WITHOUT ANY WARRANTY; without even the implied warranty of
		MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
		GNU General Public License for more details.

		You should have received a copy of the GNU General Public License
		along with this program; if not, write to the Free Software
		Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class Widget_Area_Scroller {

	private $areas;
	private $options;

	function __construct() {
		add_filter( 'dynamic_sidebar_params', array( &$this, 'dynamic_sidebar_params' ), 100000 );
		add_action( 'template_redirect', array( &$this, 'queue' ) );
		add_action( 'widgets_init', array( &$this, 'divider_widget' ) );
		add_action( 'admin_menu', array( &$this, 'admin_menu' ) );
		$this->areas = get_theme_mod( 'widget_area_scroller_areas', array() );
		$this->options = get_theme_mod( 'widget_area_scroller_config', array() );
		// add_action( 'admin_print_styles-widgets.php', array( &$this, 'admin_queue' ) );
	}

	function queue() {
		if( ! empty( $this->areas ) ) {
			wp_enqueue_script( 'area-scroller', plugins_url( 'js/scroller.js', __FILE__), array( 'jquery' ), '0.1', true );
			wp_enqueue_style( 'area-scroller', plugins_url( 'css/scroller.css', __FILE__) );
		}
	}

	function dynamic_sidebar_params( $params ) {
		global $wp_registered_widgets;

		if( is_admin() || ! in_array( $params[0]['id'], $this->areas ) ) return $params;
		$sidebar_widgets = wp_get_sidebars_widgets();

		// first widget in the widget area
		if( $sidebar_widgets[$params[0]['id']][0] == $params[0]['widget_id'] ) {
			$height = ( $this->options[$params[0]['id']]['height'] ) ? ' style="height: ' . $this->options[$params[0]['id']]['height'] . 'px;"' : '';
			$params[0]['before_widget'] = '<div class="scrollable-wrap"><div class="scrollable vertical"'. $height .'><div class="items"><div class="item">' . $params[0]['before_widget'];
		}
		// last widget?
		if( $sidebar_widgets[$params[0]['id']][count($sidebar_widgets[$params[0]['id']])-1] == $params[0]['widget_id'] ) {
			$params[0]['after_widget'] .= '</div></div></div><div class="actions"><a class="prev">&laquo;</a><a class="next">&raquo;</a></div></div>';
		}
		return $params;
	}

	function divider_widget() {
		require_once( dirname( __FILE__ ) . '/includes/widget-divider.php' );
		register_widget( 'Scroller_Widget_Divider' );
	}

	function admin_queue() {
		wp_enqueue_style( 'was-admin', plugins_url( 'css/admin.css', __FILE__ ), array(), '0.1' );
		wp_enqueue_script( 'was-admin', plugins_url( 'js/admin.js', __FILE__ ), array( 'jquery' ) );
		wp_localize_script( 'was-admin', 'scroller', array(
			'areas' => array_keys( $this->options ),
			'icon' => plugins_url( 'images/scroll.gif', __FILE__ ),
		) );
	}

	function admin_menu() {
		$page = add_theme_page( 'Widget Area Scroller', 'Widget Area Scroller', 'edit_theme_options', 'widgetarea-scroller', array( &$this, 'options_page' ) );
		add_action( "load-{$page}", array( &$this, 'admin_actions' ) );
	}

	function options_page() {
		global $wp_registered_sidebars;

		require_once( dirname( __FILE__ ) . '/views/options.php' );
	}

	function admin_actions() {
		if( isset( $_POST['areas'] ) ) {
			set_theme_mod( 'widget_area_scroller_areas', $_POST['areas'] );
			$this->areas = $_POST['areas'];
			set_theme_mod( 'widget_area_scroller_config', $_POST['config'] );
			$this->options = $_POST['config'];
		}
	}
}
new Widget_Area_Scroller;