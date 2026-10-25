<?php
/**
 * Plugin Name: KINBONI Pro
 * Plugin URI:  https://kinboni.com
 * Description: KINBONI luxury storefront — Elementor widgets & WooCommerce integration.
 * Version:     2.0.1
 * Author:      KINBONI Atelier
 * Author URI:  https://kinboni.com
 * Text Domain: kinboni-pro
 * Domain Path: /languages
 * Requires at least: 6.0
 * Requires PHP: 8.0
 * License:     GPLv2 or later
 *
 * WC requires at least: 8.0
 * WC tested up to:      9.4
 */

defined( 'ABSPATH' ) || exit;

/* ──────────────────────────────────────────────
 * Constants
 * ────────────────────────────────────────────── */
define( 'KINBONI_VERSION', '2.0.1' );
define( 'KINBONI_FILE',    __FILE__ );
define( 'KINBONI_DIR',     plugin_dir_path( __FILE__ ) );
define( 'KINBONI_URL',     plugin_dir_url( __FILE__ ) );

/* ──────────────────────────────────────────────
 * Autoload includes
 * ────────────────────────────────────────────── */
require_once KINBONI_DIR . 'includes/class-kinboni-loader.php';

/* ──────────────────────────────────────────────
 * Boot
 * ────────────────────────────────────────────── */
Kinboni_Loader::init();


