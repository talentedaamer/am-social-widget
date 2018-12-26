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
}

/**
 * register widget class on widgets_init
 *
 * @since 1.0.1
 */
add_action( 'widgets_init', function () {
	register_widget('AM_Social_Widget' );
} );