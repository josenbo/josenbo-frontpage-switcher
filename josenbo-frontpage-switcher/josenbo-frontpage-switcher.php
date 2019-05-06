<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link       https://github.com/josenbo/josenbo-frontpage-switcher
 * @since      1.0.0
 * @package    Frontpage_Switcher
 *
 * @wordpress-plugin
 * Plugin Name:       Josenbo Frontpage Switcher
 * Plugin URI:        https://github.com/josenbo/josenbo-frontpage-switcher
 * Description:       Display different frontpage for anonymous visitors
 * Version:           1.0.0
 * Author:            Jochen Stein
 * Author URI:        https://github.com/josenbo
 * License:           GPLv3 
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       josenbo-frontpage-switcher
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
  die;
}

if ( !class_exists( 'frontpage_switcher_class' ) ){

	class frontpage_switcher_class {

		const ANONYMOUS_FRONTPAGE = 59;
		
		
		// Init
		function init() {

			// Overriding 'show_on_front' option: always 'page' when user is not logged in
			add_filter( 'option_show_on_front', array( __CLASS__, 'override_option_show_on_front' ) );

			// Overriding 'page_on_front' option: always ANONYMOUS_FRONTPAGE when user is not logged in
			add_filter( 'option_page_on_front', array( __CLASS__, 'override_option_page_on_front' ) );

		}

		// The function must return 'posts' or 'page'. 
		// The parameter $what holds the current setting based on
		// wordpress configuration or previous filters results.
		// In case of an anonymous visitor we need to return 'page'.
		function override_option_show_on_front( $what ) {

			if ( 'posts' == $what ){
				if ( !is_user_logged_in() ){
					$what = 'page';
				}
			}

			return $what;
		}

		// The function returns the front page post id.
		// The parameter $frontpage holds the current setting based
		// on wordpress configuration or previous filters results.
		// In case of an anonymous visitor we need to return ANONYMOUS_FRONTPAGE.
		function override_option_page_on_front( $frontpage ) {

			if ( !is_user_logged_in() ){
				$frontpage = self::ANONYMOUS_FRONTPAGE;
			}

			return $frontpage;
		}
	}

	// Initialize
	add_action( 'init', array( 'frontpage_switcher_class', 'init' ) );
}
