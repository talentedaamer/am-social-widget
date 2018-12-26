<?php
/**
 * Plugin Name: AM Social Widget
 * Plugin URI: https://github.com/talentedaamer/am-social-widget
 * Description: WordPress plugin that allows user to link to their social profiles like facebook, twitter, linkedIn, youtube etc
 * Version: 1.0.1
 * Author: Aamer Shahzad
 * Author URI: http://wpthemecraft.com
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License version 2, as published by the
 * Free Software Foundation. You may NOT assume that you can use any other
 * version of the GPL.
 *
 * This plugin, like WordPress, is licensed under the GPL. You can redistribute it and/or modify
 * it to make something cool, have fun, and share what you've learned with others.
 *
 * @package    AMSocialWidget
 * @since      1.0.1
 * @copyright  Copyright (c) 2019, Aamer Shahzad
 * @license    GPL-2.0.
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * AM Social Widget Class
 *
 * @since 1.0.1
 */
class AM_Social_Widget extends WP_Widget {

	/**
	 * plugin constants
	 */
	const name = 'AM Social Widget';
	const locale = 'am-social-widget';
	const slug = 'am-social-widget';

	/**
	 * Class Constructor
	 *
	 * @since 1.0.1
	 */
	function __construct() {
		// load plugin text-domain
		load_plugin_textdomain(self::locale, false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );

		// widget options
		$widget_ops = array(
			'classname'   => self::slug,
			'description' => __('Social Profiles Widget.', self::locale),
			'customize_selective_refresh' => true,
		);
		// widget controls
		$control_ops = array(
			'id_base' => 'am-social-widget',
		);
		// load widget
		parent::__construct(self::slug, __(self::name, self::locale), $widget_ops, $control_ops );
	}

	/**
	 * Outputs the content of the widget on frontend
	 *
	 * @since 1.0.1
	 *
	 * @param array $args array of standard parameters for widget area in active theme.
	 * @param array $instance array of settings for this widget.
	 */
	public function widget( $args, $instance ) {
		// before widget markup from widget area args.
		echo $args['before_widget'];

		// title of widget wrapped in before/after title from widget area args.
		echo $args['before_title'] . 'Widget Title' . $args['after_title'];

		// after widget markup from widget area args.
		echo $args['after_widget'];
	}

	/**
	 * Saving & Updating of widget admin settigns are handled here.
	 *
	 * @since 1.0.1
	 *
	 * @param array $new_instance array of new settings submitted by admin
	 * @param array $old_instance array of the old settings.
	 * @return array Updated settings to save.
	 */
	public function update( $new_instance, $old_instance ) {
		return $new_instance;
	}

	/**
	 * Outputs the settings form of the widget on admin area.
	 *
	 * @since 1.0.1
	 *
	 * @param array $instance array of current settings for this widget
	 */
	public function form( $instance ) {
		echo '<p>Widget Form...</p>';
	}
}

/**
 * register widget class on widgets_init
 *
 * @since 1.0.1
 */
add_action( 'widgets_init', function () {
	register_widget('AM_Social_Widget' );
} );