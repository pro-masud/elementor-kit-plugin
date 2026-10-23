<?php
/**
 * AJAX Handlers — All WordPress AJAX endpoints.
 *
 * Each endpoint gets its own method.
 * Add new actions in register_endpoints() as you build features.
 *
 * @package KinboniPro
 */

defined( 'ABSPATH' ) || exit;

class Kinboni_Ajax {

	/**
	 * Register hooks.
	 */
	public static function init(): void {
		self::register_endpoints();
	}

	/**
	 * Register all AJAX action hooks.
	 *
	 * Format:
	 *   wp_ajax_{action}        → logged-in users
	 *   wp_ajax_nopriv_{action} → guests
	 */
	private static function register_endpoints(): void {

		// ── Quick View (product data) ─────────────────────────
		// add_action( 'wp_ajax_kinboni_quick_view',        [ __CLASS__, 'quick_view' ] );
		// add_action( 'wp_ajax_nopriv_kinboni_quick_view', [ __CLASS__, 'quick_view' ] );

		// ── Add to Cart ───────────────────────────────────────
		// add_action( 'wp_ajax_kinboni_add_to_cart',        [ __CLASS__, 'add_to_cart' ] );
		// add_action( 'wp_ajax_nopriv_kinboni_add_to_cart', [ __CLASS__, 'add_to_cart' ] );

		// ── Get Cart ──────────────────────────────────────────
		// add_action( 'wp_ajax_kinboni_get_cart',        [ __CLASS__, 'get_cart' ] );
		// add_action( 'wp_ajax_nopriv_kinboni_get_cart', [ __CLASS__, 'get_cart' ] );

		// ── Checkout ──────────────────────────────────────────
		// add_action( 'wp_ajax_kinboni_checkout',        [ __CLASS__, 'process_checkout' ] );
		// add_action( 'wp_ajax_nopriv_kinboni_checkout', [ __CLASS__, 'process_checkout' ] );
	}

	/**
	 * Verify nonce — reusable helper for all endpoints.
	 *
	 * @return bool
	 */
	private static function verify_nonce(): bool {
		return check_ajax_referer( 'kinboni_nonce', 'nonce', false ) !== false;
	}

	/*
	|--------------------------------------------------------------------------
	| AJAX Endpoint Methods (uncomment & implement as you build)
	|--------------------------------------------------------------------------
	|
	| public static function quick_view(): void {
	|     if ( ! self::verify_nonce() ) {
	|         wp_send_json_error( [ 'message' => 'Security check failed.' ], 403 );
	|     }
	|     $product_id = absint( $_POST['product_id'] ?? 0 );
	|     // ... load product, return JSON
	|     wp_send_json_success( $data );
	| }
	|
	| public static function add_to_cart(): void { ... }
	| public static function get_cart(): void { ... }
	| public static function process_checkout(): void { ... }
	|
	*/
}

