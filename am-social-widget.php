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

		// load styles
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

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
	    // set widget id
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}
        // widget title
		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Social Profiles', self::locale );
		// apply filter widget_title.
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		// link target
		$link_target = isset( $instance['link_target'] ) ? $instance['link_target'] : false;

		// before widget markup from widget area args.
		echo $args['before_widget'];

		// title of widget wrapped in before/after title from widget area args.
        if ( $title !== '' ) {
	        echo $args['before_title'] . $title . $args['after_title'];
        }

		echo '<p class="am-social-profiles-wrap">';
		$social_profiles = array(
			'facebook' => 'Facebook',
			'twitter' => 'Twitter',
			'linkedin' => 'LinkedIn',
			'pinterest' => 'Pinterest',
			'gplus' => 'Google Plus',
			'youtube' => 'Youtube',
			'rss' => 'RSS',
		);
		foreach( $social_profiles as $social => $title ) {
			$url = esc_url( $instance[$social] );
			$target = $link_target ? 'target="_blank"' : '';
			if( $url ) {
				echo '<a href="' . $url . '" ' . $target . '>' . $this->get_icon_svg($social) . '<span class="sr-only screen-reader-text">' . $title . '</span></a> ';
			}
		}
		echo '</p>';

		// after widget markup from widget area args.
		echo $args['after_widget'];
	}

	/**
	 * Saving & Updating of widget admin settings are handled here.
	 *
	 * @since 1.0.1
	 *
	 * @param array $new_instance array of new settings submitted by admin
	 * @param array $old_instance array of the old settings.
	 * @return array Updated settings to save.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		// widget title
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		// social profiles
		$social_profiles = array(
			'facebook' => 'Facebook URL',
			'twitter' => 'Twitter URL',
			'linkedin' => 'LinkedIn URL',
			'pinterest' => 'Pinterest URL',
			'gplus' => 'Google Plus URL',
			'youtube' => 'Youtube URL',
			'rss' => 'RSS URL',
		);
		foreach( $social_profiles as $social => $title ) {
			$instance[$social] = sanitize_text_field( $new_instance[$social] );
		}
		// link target
		$instance['link_target'] = isset( $new_instance['link_target'] ) ? (bool) $new_instance['link_target'] : false;

		return $instance;
	}

	/**
	 * Outputs the settings form of the widget on admin area.
	 *
	 * @since 1.0.1
	 *
	 * @param array $instance array of current settings for this widget
	 */
	public function form( $instance ) {
		// widget title
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		// social profiles for creating inputs.
		$social_profiles = array(
			'facebook' => 'Facebook URL:',
			'twitter' => 'Twitter URL:',
			'linkedin' => 'LinkedIn URL:',
			'pinterest' => 'Pinterest URL:',
			'gplus' => 'Google Plus URL:',
			'youtube' => 'Youtube URL:',
			'rss' => 'RSS URL:',
		);
		$link_target = isset( $instance['link_target'] ) ? (bool) $instance['link_target'] : false;
		?>
		<div class="am-social-widget-form-controls">
			<!-- widget title -->
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>">
					<?php _e( 'Widget Title:' ) ?>
				</label>
				<input
					type="text"
					class="widefat"
					id="<?php echo $this->get_field_id( 'title' ); ?>"
					name="<?php echo $this->get_field_name( 'title' ); ?>"
					value="<?php echo esc_attr( $title ); ?>"/>
			</p>
			<!-- social profiles inputs -->
			<?php
				foreach( $social_profiles as $social => $title ) {
					echo '<p>';
					$social_val = isset( $instance[$social] ) ? $instance[$social] : '';
					$html = '<label for="' . $this->get_field_id( $social ) . '">' . $title . '</label>';
					$html .= '<input type="text" class="widefat" id="' . $this->get_field_id( $social ) . '" name="' . $this->get_field_name( $social ) . '" value="' . esc_attr( $social_val ) . '"/>';
					echo $html;
					echo '</p>';
				} // end foreach $social_profiles
			?>
			<!-- open likn in new tab -->
			<p>
				<input
					type="checkbox"
					class="checkbox"
					id="<?php echo $this->get_field_id( 'link_target' ); ?>"
					name="<?php echo $this->get_field_name( 'link_target' ); ?>"
					<?php checked( $link_target ); ?>/>
				<label for="<?php echo $this->get_field_id( 'link_target' ); ?>">
					<?php _e( 'Open link in new tab?' ); ?>
				</label>
			</p>
		</div>
		<?php
	}

	/**
	 * Gets the SVG code for a given social icon.
	 *
	 * @since 1.0.1
	 *
	 * @param $icon name of the icon
	 * @param int $size icon size default is 24px
	 *
	 * @return null|string icon or null if wrong name is passed
	 */
	public function get_icon_svg( $icon, $size = 24 ) {
		return AM_SVG_Icons::get_svg( $icon, $size );
	}

	/**
	 * Load plugin styles for frontend.
	 */
	public function enqueue_scripts() {
	    wp_enqueue_style( self::slug . '-styles', plugin_dir_url( __FILE__ ) . 'assets/css/style.min.css' );
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

/**
 * Loads svg icons class
 */
include_once( 'inc/class-svg-icons.php' );