<?php
/**
 * Loader — Orchestrates all plugin modules.
 *
 * Handles:
 *  - Dependency checks (WooCommerce, Elementor)
 *  - Proper hook timing via plugins_loaded
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

		// 1. HPOS compatibility declaration (must hook before or during before_woocommerce_init).
		add_action( 'before_woocommerce_init', [ __CLASS__, 'declare_hpos_compat' ] );

		// 2. Load module class files.
		self::load_includes();

		// 3. Frontend & Editor assets.
		Kinboni_Assets::init();

		// 4. AJAX endpoints.
		Kinboni_Ajax::init();

		// 5. Orchestrate WooCommerce & Elementor after all active plugins are loaded.
		add_action( 'plugins_loaded', [ __CLASS__, 'on_plugins_loaded' ], 10 );

		// 6. Dependency admin notices (for administrators).
		add_action( 'admin_notices', [ __CLASS__, 'dependency_notices' ] );
	}

	/**
	 * Run initialization after all active plugins are loaded.
	 * Resolves plugin loading order issues.
	 */
	public static function on_plugins_loaded(): void {

		// ── Elementor Initialization ─────────────────────────
		// If Elementor is active, did_action('elementor/loaded') is already true here.
		if ( did_action( 'elementor/loaded' ) ) {
			Kinboni_Elementor::init();
		} else {
			// In case Elementor loads later on a custom priority.
			add_action( 'elementor/loaded', [ 'Kinboni_Elementor', 'init' ] );
		}

		// ── WooCommerce Initialization ───────────────────────
		if ( self::is_wc_active() ) {
			Kinboni_WooCommerce::init();
		}
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
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		if ( ! self::is_elementor_active() ) {
			printf(
				'<div class="notice notice-warning is-dismissible"><p><strong>KINBONI Pro:</strong> %s</p></div>',
				esc_html__( 'Elementor plugin is required. Please install and activate Elementor to use KINBONI widgets.', 'kinboni-pro' )
			);
		}
		if ( ! self::is_wc_active() ) {
			printf(
				'<div class="notice notice-warning is-dismissible"><p><strong>KINBONI Pro:</strong> %s</p></div>',
				esc_html__( 'WooCommerce plugin is required. Please install and activate WooCommerce for store features.', 'kinboni-pro' )
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
		return did_action( 'elementor/loaded' ) > 0;
	}
}

