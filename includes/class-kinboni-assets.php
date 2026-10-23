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
			'font-cormorant', 'fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap',
			[],
			KINBONI_VERSION
		);
		wp_enqueue_style(
			'swiper-bundle', '//cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
			[],
			KINBONI_VERSION
		);

		wp_enqueue_style(
			'kinboni-pro-output',
			KINBONI_URL . 'assets/css/output.css',
			[],
			KINBONI_VERSION
		);

		wp_enqueue_style(
			'kinboni-pro',
			KINBONI_URL . 'assets/css/kinboni.css',
			[],
			KINBONI_VERSION
		);

		// Main script.
		wp_enqueue_script(
			'app-pro',
			KINBONI_URL . 'assets/js/app.js',
			[  ],
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

		// Main stylesheet.
		wp_enqueue_style(
			'kinboni-pro-output', '//cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
			[],
			KINBONI_VERSION
		);

		wp_enqueue_style(
			'kinboni-pro-output',
			KINBONI_URL . 'assets/css/output.css',
			[],
			KINBONI_VERSION
		);

		wp_enqueue_style(
			'kinboni-pro',
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
		$currency = '৳';
		if ( function_exists( 'get_woocommerce_currency_symbol' ) ) {
			$currency = get_woocommerce_currency_symbol();
		}

		return [
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'nonce'    => wp_create_nonce( 'kinboni_nonce' ),
			'home_url' => home_url( '/' ),
			'currency' => $currency,
		];
	}
}

