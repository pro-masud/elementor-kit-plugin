<?php
/**
 * Assets — Handles all CSS & JS enqueue.
 *
 * @package KinboniPro
 */

defined( 'ABSPATH' ) || exit;

class Kinboni_Assets {

	/**
	 * Register hooks.
	 */
	public static function init(): void {
		add_action( 'wp_enqueue_scripts', [ __CLASS__, 'enqueue_frontend' ] );
		add_action( 'elementor/editor/after_enqueue_styles', [ __CLASS__, 'enqueue_editor' ] );
	}

	/**
	 * Enqueue frontend styles and scripts.
	 */
	public static function enqueue_frontend(): void {

		// Main stylesheet.
		wp_enqueue_style(
			'kinboni-pro',
			KINBONI_URL . 'assets/css/kinboni.css',
			[],
			KINBONI_VERSION
		);

		// Main script.
		wp_enqueue_script(
			'kinboni-pro',
			KINBONI_URL . 'assets/js/kinboni.js',
			[ 'jquery' ],
			KINBONI_VERSION,
			true
		);

		// Localize — pass PHP data to JS.
		wp_localize_script( 'kinboni-pro', 'kinboni', self::get_js_data() );
	}

	/**
	 * Enqueue styles inside Elementor editor preview.
	 */
	public static function enqueue_editor(): void {
		wp_enqueue_style(
			'kinboni-pro-editor',
			KINBONI_URL . 'assets/css/kinboni.css',
			[],
			KINBONI_VERSION
		);
	}

	/**
	 * Data passed to frontend JS via wp_localize_script.
	 *
	 * @return array<string, mixed>
	 */
	private static function get_js_data(): array {
		$data = [
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'nonce'    => wp_create_nonce( 'kinboni_nonce' ),
			'home_url' => home_url( '/' ),
		];

		// Add WooCommerce data only if available.
		if ( Kinboni_Loader::is_wc_active() ) {
			$data['currency'] = get_woocommerce_currency_symbol();
		}

		return $data;
	}
}

