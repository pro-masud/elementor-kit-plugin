<?php
/**
 * Plugin Name: Taxvi Pro Addon
 * Description: Taxvi Pro Addon
 * Plugin URI:  https://elementor.com/
 * Version:     1.0.0
 * Author:      Pro Masud
 * Author URI:  https://developers.elementor.com/
 * Text Domain: taxvi-pro
 * 
 * Elementor tested up to: 3.13.0
 * Elementor Pro tested up to: 3.7.0
 * 
 * 
 */if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function elementor_test_addon() {

	// Load plugin file
	require_once( __DIR__ . '/plugin.php' );

	// Run the plugin
	\Elementor_Test_Addon\Plugin::instance();

}
add_action( 'plugins_loaded', 'elementor_test_addon' );