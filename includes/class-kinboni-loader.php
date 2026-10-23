<?php
/**
 * Loader — Orchestrates all plugin modules.
 *
 * Handles:
 *  - Dependency checks (WooCommerce, Elementor)
 *  - Loading the right classes at the right hooks
 *  - HPOS compatibility declaration
 *
 * @package KinboniPro
 */

defined( 'ABSPATH' ) || exit;

class Kinboni_Loader {

	/**
	 * Initialize the plugin — called once from kinboni-pro.php.
	 */
	public static function init(): void {

		// HPOS compatibility declaration.
		add_action( 'before_woocommerce_init', [ __CLASS__, 'declare_hpos_compat' ] );

		// Dependency admin notices.
		add_action( 'admin_notices', [ __CLASS__, 'dependency_notices' ] );

		// Load modules on the right hooks.
		self::load_includes();

		// Frontend assets.
		Kinboni_Assets::init();

		// Elementor widgets (only if Elementor is available).
		add_action( 'elementor/loaded', [ 'Kinboni_Elementor', 'init' ] );

		// WooCommerce hooks (only if WC is active).
		if ( self::is_wc_active() ) {
			Kinboni_WooCommerce::init();
		}

		// AJAX endpoints (always register — they do their own WC checks).
		Kinboni_Ajax::init();
	}

	/**
	 * Require all include files.
	 */
	private static function load_includes(): void {
		$dir = KINBONI_DIR . 'includes/';

		require_once $dir . 'class-kinboni-assets.php';
		require_once $dir . 'class-kinboni-elementor.php';
		require_once $dir . 'class-kinboni-woocommerce.php';
		require_once $dir . 'class-kinboni-ajax.php';
	}

	/**
	 * Declare WooCommerce HPOS compatibility.
	 */
	public static function declare_hpos_compat(): void {
		if ( class_exists( '\Automattic\WooCommerce\Utilities\FeaturesUtil' ) ) {
			\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility(
				'custom_order_tables',
				KINBONI_FILE,
				true
			);
		}
	}

	/**
	 * Show admin notices for missing dependencies.
	 */
	public static function dependency_notices(): void {
		if ( ! did_action( 'elementor/loaded' ) ) {
			printf(
				'<div class="notice notice-warning is-dismissible"><p><strong>KINBONI Pro:</strong> %s</p></div>',
				esc_html__( 'Elementor plugin is required. Please install and activate Elementor.', 'kinboni-pro' )
			);
		}
		if ( ! self::is_wc_active() ) {
			printf(
				'<div class="notice notice-warning is-dismissible"><p><strong>KINBONI Pro:</strong> %s</p></div>',
				esc_html__( 'WooCommerce plugin is required. Please install and activate WooCommerce.', 'kinboni-pro' )
			);
		}
	}

	/**
	 * Check if WooCommerce is active.
	 */
	public static function is_wc_active(): bool {
		return class_exists( 'WooCommerce' );
	}

	/**
	 * Check if Elementor is active.
	 */
	public static function is_elementor_active(): bool {
		return did_action( 'elementor/loaded' );
	}
}

