<?php
/**
 * Assets — Handles all CSS & JS enqueue.
 *
 * Enqueues:
 *  - Google Fonts (Cormorant Garamond & Plus Jakarta Sans)
 *  - Swiper CSS & JS CDN
 *  - Lucide Icons CDN
 *  - KINBONI Output CSS (Tailwind styles)
 *  - KINBONI Pro CSS (Component & Modal styles)
 *  - KINBONI Pro JS (Modal & accessible interaction engine)
 *  - KINBONI App JS (Full storefront & e-commerce engine)
 *  - Localized kinboni object for AJAX and currency
 *
 * @package KinboniPro
 */

defined( 'ABSPATH' ) || exit;

class Kinboni_Assets {

	/**
	 * Register hooks for frontend, editor, and Elementor preview.
	 */
	public static function init(): void {
		// Frontend scripts and styles.
		add_action( 'wp_enqueue_scripts', [ __CLASS__, 'enqueue_frontend' ], 20 );

		// Register with Elementor so widgets can depend on them.
		add_action( 'elementor/frontend/after_register_scripts', [ __CLASS__, 'register_scripts' ] );
		add_action( 'elementor/frontend/after_register_styles', [ __CLASS__, 'register_styles' ] );

		// Enqueue inside Elementor preview iframe.
		add_action( 'elementor/preview/enqueue_styles', [ __CLASS__, 'enqueue_styles' ] );
		add_action( 'elementor/preview/enqueue_scripts', [ __CLASS__, 'enqueue_scripts' ] );

		// Enqueue in Elementor editor panel (UI styles and icons only, avoid frontend storefront conflicts).
		add_action( 'elementor/editor/after_enqueue_styles', [ __CLASS__, 'enqueue_styles' ] );
		add_action( 'elementor/editor/after_enqueue_scripts', [ __CLASS__, 'enqueue_editor_scripts' ] );
	}

	/**
	 * Register all script handles so Elementor and WordPress know them.
	 */
	public static function register_scripts(): void {
		// Lucide Icons (prefer local vendor copy to avoid CDN latency & tracking prevention).
		$lucide_src = file_exists( KINBONI_DIR . 'assets/vendor/lucide.min.js' )
			? KINBONI_URL . 'assets/vendor/lucide.min.js'
			: 'https://cdn.jsdelivr.net/npm/lucide@latest/dist/umd/lucide.min.js';

		wp_register_script(
			'lucide-icons',
			$lucide_src,
			[],
			KINBONI_VERSION,
			true
		);

		// Swiper Slider JS (prefer local vendor copy).
		$swiper_js_src = file_exists( KINBONI_DIR . 'assets/vendor/swiper-bundle.min.js' )
			? KINBONI_URL . 'assets/vendor/swiper-bundle.min.js'
			: 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js';

		wp_register_script(
			'swiper-bundle',
			$swiper_js_src,
			[],
			'11.0.0',
			true
		);

		// KINBONI Pro Core JS (Modal & Accessible Interaction).
		wp_register_script(
			'kinboni-pro',
			KINBONI_URL . 'assets/js/kinboni.js',
			[ 'jquery', 'lucide-icons' ],
			KINBONI_VERSION,
			true
		);

		// KINBONI Cart Engine JS (Module 02: Shopping Bag & Cart Drawer).
		wp_register_script(
			'kinboni-cart',
			KINBONI_URL . 'assets/js/modules/cart.js',
			[ 'jquery', 'lucide-icons', 'kinboni-pro' ],
			KINBONI_VERSION,
			true
		);

		// KINBONI Storefront Engine JS (Full eCommerce & UI engine).
		wp_register_script(
			'kinboni-app',
			KINBONI_URL . 'assets/js/app.js',
			[ 'jquery', 'lucide-icons', 'swiper-bundle', 'kinboni-pro', 'kinboni-cart' ],
			KINBONI_VERSION,
			true
		);

		// Localize parameters on handles so 'window.kinboni' is always defined.
		$js_data = self::get_js_data();
		wp_localize_script( 'kinboni-pro', 'kinboni', $js_data );
		wp_localize_script( 'kinboni-cart', 'kinboni', $js_data );
		wp_localize_script( 'kinboni-app', 'kinboni', $js_data );
	}

	/**
	 * Register all style handles.
	 */
	public static function register_styles(): void {
		// Google Fonts.
		wp_register_style(
			'kinboni-fonts',
			'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap',
			[],
			null
		);

		// Swiper Slider CSS (prefer local vendor copy).
		$swiper_css_src = file_exists( KINBONI_DIR . 'assets/vendor/swiper-bundle.min.css' )
			? KINBONI_URL . 'assets/vendor/swiper-bundle.min.css'
			: 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css';

		wp_register_style(
			'swiper-bundle',
			$swiper_css_src,
			[],
			'11.0.0'
		);

		// Compiled Tailwind storefront stylesheet.
		wp_register_style(
			'kinboni-output',
			KINBONI_URL . 'assets/css/output.css',
			[ 'kinboni-fonts', 'swiper-bundle' ],
			KINBONI_VERSION
		);

		// Component & Modal stylesheet.
		wp_register_style(
			'kinboni-pro',
			KINBONI_URL . 'assets/css/kinboni.css',
			[ 'kinboni-output' ],
			KINBONI_VERSION
		);
	}

	/**
	 * Enqueue all styles for the frontend and editor preview.
	 */
	public static function enqueue_styles(): void {
		self::register_styles();

		wp_enqueue_style( 'kinboni-fonts' );
		wp_enqueue_style( 'swiper-bundle' );
		wp_enqueue_style( 'kinboni-output' );
		wp_enqueue_style( 'kinboni-pro' );
	}

	/**
	 * Enqueue all scripts for the frontend and editor preview.
	 */
	public static function enqueue_scripts(): void {
		self::register_scripts();

		wp_enqueue_script( 'lucide-icons' );
		wp_enqueue_script( 'swiper-bundle' );
		wp_enqueue_script( 'kinboni-pro' );
		wp_enqueue_script( 'kinboni-cart' );
		wp_enqueue_script( 'kinboni-app' );
	}

	/**
	 * Scripts for Elementor editor panel (UI styles and icons only).
	 */
	public static function enqueue_editor_scripts(): void {
		self::register_scripts();

		wp_enqueue_script( 'lucide-icons' );
		wp_enqueue_script( 'kinboni-pro' );
	}

	/**
	 * Combined frontend enqueue.
	 */
	public static function enqueue_frontend(): void {
		self::enqueue_styles();
		self::enqueue_scripts();
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

		$products = class_exists( 'Kinboni_Products' ) ? Kinboni_Products::get_storefront_products() : [];
		$cart     = class_exists( 'Kinboni_WooCommerce' ) ? Kinboni_WooCommerce::get_cart_payload() : null;

		return [
			'ajax_url'          => admin_url( 'admin-ajax.php' ),
			'nonce'             => wp_create_nonce( 'kinboni_nonce' ),
			'home_url'          => home_url( '/' ),
			'currency'          => $currency,
			'products'          => $products,
			'has_user_products' => ! empty( $products ),
			'admin_url'         => admin_url( 'admin.php?page=kinboni-pro#products' ),
			'cart'              => $cart,
		];
	}
}
