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
		add_action( 'wp_ajax_kinboni_quick_view',        [ __CLASS__, 'quick_view' ] );
		add_action( 'wp_ajax_nopriv_kinboni_quick_view', [ __CLASS__, 'quick_view' ] );

		// ── Newsletter Subscription ───────────────────────────
		add_action( 'wp_ajax_kinboni_subscribe_newsletter',        [ __CLASS__, 'subscribe_newsletter' ] );
		add_action( 'wp_ajax_nopriv_kinboni_subscribe_newsletter', [ __CLASS__, 'subscribe_newsletter' ] );

		// ── Cash on Delivery (COD) Express Order ───────────────
		add_action( 'wp_ajax_kinboni_create_cod_order',        [ __CLASS__, 'create_cod_order' ] );
		add_action( 'wp_ajax_nopriv_kinboni_create_cod_order', [ __CLASS__, 'create_cod_order' ] );

		// ── Cart Operations (Module 02: CartController) ──────
		add_action( 'wp_ajax_kinboni_get_cart',                 [ __CLASS__, 'get_cart' ] );
		add_action( 'wp_ajax_nopriv_kinboni_get_cart',          [ __CLASS__, 'get_cart' ] );

		add_action( 'wp_ajax_kinboni_add_to_cart',             [ __CLASS__, 'add_to_cart' ] );
		add_action( 'wp_ajax_nopriv_kinboni_add_to_cart',      [ __CLASS__, 'add_to_cart' ] );

		add_action( 'wp_ajax_kinboni_update_cart_quantity',    [ __CLASS__, 'update_cart_quantity' ] );
		add_action( 'wp_ajax_nopriv_kinboni_update_cart_quantity', [ __CLASS__, 'update_cart_quantity' ] );

		add_action( 'wp_ajax_kinboni_remove_cart_item',         [ __CLASS__, 'remove_cart_item' ] );
		add_action( 'wp_ajax_nopriv_kinboni_remove_cart_item',  [ __CLASS__, 'remove_cart_item' ] );

		add_action( 'wp_ajax_kinboni_clear_cart',              [ __CLASS__, 'clear_cart' ] );
		add_action( 'wp_ajax_nopriv_kinboni_clear_cart',       [ __CLASS__, 'clear_cart' ] );

		add_action( 'wp_ajax_kinboni_apply_coupon',            [ __CLASS__, 'apply_coupon' ] );
		add_action( 'wp_ajax_nopriv_kinboni_apply_coupon',     [ __CLASS__, 'apply_coupon' ] );

		add_action( 'wp_ajax_kinboni_remove_coupon',           [ __CLASS__, 'remove_coupon' ] );
		add_action( 'wp_ajax_nopriv_kinboni_remove_coupon',    [ __CLASS__, 'remove_coupon' ] );

		// ── Wishlist Operations (Module 03: WishlistController) ──
		add_action( 'wp_ajax_kinboni_get_wishlist',            [ __CLASS__, 'get_wishlist' ] );
		add_action( 'wp_ajax_nopriv_kinboni_get_wishlist',     [ __CLASS__, 'get_wishlist' ] );

		add_action( 'wp_ajax_kinboni_toggle_wishlist',         [ __CLASS__, 'toggle_wishlist' ] );
		add_action( 'wp_ajax_nopriv_kinboni_toggle_wishlist',  [ __CLASS__, 'toggle_wishlist' ] );

		add_action( 'wp_ajax_kinboni_remove_wishlist_item',    [ __CLASS__, 'remove_wishlist_item' ] );
		add_action( 'wp_ajax_nopriv_kinboni_remove_wishlist_item', [ __CLASS__, 'remove_wishlist_item' ] );

		add_action( 'wp_ajax_kinboni_move_wishlist_to_cart',   [ __CLASS__, 'move_wishlist_to_cart' ] );
		add_action( 'wp_ajax_nopriv_kinboni_move_wishlist_to_cart', [ __CLASS__, 'move_wishlist_to_cart' ] );

		// ── Live Product Search (Module 05: SearchController) ──
		add_action( 'wp_ajax_kinboni_search_products',        [ __CLASS__, 'search_products' ] );
		add_action( 'wp_ajax_nopriv_kinboni_search_products', [ __CLASS__, 'search_products' ] );
	}

	/**
	 * Verify nonce — reusable helper for all endpoints.
	 *
	 * @return bool
	 */
	private static function verify_nonce(): bool {
		return check_ajax_referer( 'kinboni_nonce', 'nonce', false ) !== false;
	}

	/**
	 * AJAX endpoint for loading WooCommerce product data for Quick View.
	 */
	public static function quick_view(): void {
		$product_id = sanitize_text_field( wp_unslash( $_REQUEST['product_id'] ?? '' ) );
		if ( empty( $product_id ) ) {
			wp_send_json_error( [ 'message' => __( 'Invalid product ID.', 'kinboni-pro' ) ], 400 );
		}

		if ( ! class_exists( 'Kinboni_WooCommerce' ) ) {
			wp_send_json_error( [ 'message' => __( 'WooCommerce engine is unavailable.', 'kinboni-pro' ) ], 500 );
		}

		try {
			$data = Kinboni_WooCommerce::get_quick_view_data( $product_id );
			wp_send_json_success( $data );
		} catch ( \Exception $e ) {
			wp_send_json_error( [ 'message' => $e->getMessage() ], 404 );
		}
	}

	/**
	 * AJAX endpoint for VIP newsletter subscription.
	 */
	public static function subscribe_newsletter(): void {
		$email = sanitize_email( wp_unslash( $_POST['email'] ?? '' ) );
		if ( ! is_email( $email ) ) {
			wp_send_json_error( [ 'message' => __( 'Please enter a valid email address.', 'kinboni-pro' ) ], 400 );
		}

		$subscribers = get_option( 'kinboni_newsletter_subscribers', [] );
		if ( ! is_array( $subscribers ) ) {
			$subscribers = [];
		}

		$already_subscribed = false;
		foreach ( $subscribers as $sub ) {
			if ( is_array( $sub ) && isset( $sub['email'] ) && strtolower( $sub['email'] ) === strtolower( $email ) ) {
				$already_subscribed = true;
				break;
			}
		}

		if ( ! $already_subscribed ) {
			$subscribers[] = [
				'email'      => $email,
				'subscribed' => current_time( 'mysql' ),
				'ip'         => sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ?? '' ) ),
			];
			update_option( 'kinboni_newsletter_subscribers', $subscribers, false );
			do_action( 'kinboni_vip_subscriber_added', $email );
		}

		wp_send_json_success( [
			'message' => __( 'Subscribed to Kinboni VIP Archive.', 'kinboni-pro' ),
			'promo'   => 'LUXE20',
		] );
	}

	/**
	 * AJAX endpoint for creating Cash on Delivery (COD) order.
	 */
	public static function create_cod_order(): void {
		if ( ! self::verify_nonce() ) {
			wp_send_json_error( [ 'message' => __( 'Security verification failed. Please reload the page.', 'kinboni-pro' ) ], 403 );
		}

		if ( ! class_exists( 'Kinboni_WooCommerce' ) ) {
			wp_send_json_error( [ 'message' => __( 'WooCommerce engine is unavailable.', 'kinboni-pro' ) ], 500 );
		}

		// Rate limiting / duplicate prevention lock (15s per phone + payload)
		$phone     = sanitize_text_field( wp_unslash( $_POST['customer_phone'] ?? '' ) );
		$items_raw = sanitize_text_field( wp_unslash( $_POST['items'] ?? '' ) );
		$lock_key  = 'kb_cod_lock_' . md5( $phone . $items_raw );

		if ( get_transient( $lock_key ) ) {
			wp_send_json_error( [
				'message' => __( 'An order was just submitted. Please wait 15 seconds before submitting again.', 'kinboni-pro' ),
			], 429 );
		}

		try {
			$result = Kinboni_WooCommerce::create_cod_order( $_POST );
			set_transient( $lock_key, 1, 15 );
			wp_send_json_success( $result );
		} catch ( \Exception $e ) {
			wp_send_json_error( [ 'message' => $e->getMessage() ], 400 );
		}
	}

	/**
	 * AJAX endpoint: Get full WooCommerce cart payload.
	 */
	public static function get_cart(): void {
		if ( ! class_exists( 'Kinboni_WooCommerce' ) ) {
			wp_send_json_error( [ 'message' => __( 'WooCommerce engine is unavailable.', 'kinboni-pro' ) ], 500 );
		}

		$payload = Kinboni_WooCommerce::get_cart_payload();
		wp_send_json_success( $payload );
	}

	/**
	 * AJAX endpoint: Add item to WooCommerce cart.
	 */
	public static function add_to_cart(): void {
		if ( ! self::verify_nonce() ) {
			wp_send_json_error( [ 'message' => __( 'Security verification failed. Please reload the page.', 'kinboni-pro' ) ], 403 );
		}

		if ( ! class_exists( 'Kinboni_WooCommerce' ) ) {
			wp_send_json_error( [ 'message' => __( 'WooCommerce engine is unavailable.', 'kinboni-pro' ) ], 500 );
		}

		$product_id = sanitize_text_field( wp_unslash( $_POST['product_id'] ?? '' ) );
		$quantity   = max( 1, absint( $_POST['quantity'] ?? 1 ) );
		$color      = sanitize_text_field( wp_unslash( $_POST['color'] ?? '' ) );
		$size       = sanitize_text_field( wp_unslash( $_POST['size'] ?? '' ) );
		$title      = sanitize_text_field( wp_unslash( $_POST['title'] ?? '' ) );

		if ( empty( $product_id ) ) {
			wp_send_json_error( [ 'message' => __( 'Invalid product selection.', 'kinboni-pro' ) ], 400 );
		}

		try {
			$payload = Kinboni_WooCommerce::add_to_cart_item( $product_id, $quantity, $color, $size, $title );
			wp_send_json_success( $payload );
		} catch ( \Exception $e ) {
			wp_send_json_error( [ 'message' => $e->getMessage() ], 400 );
		}
	}

	/**
	 * AJAX endpoint: Update item quantity in WooCommerce cart.
	 */
	public static function update_cart_quantity(): void {
		if ( ! self::verify_nonce() ) {
			wp_send_json_error( [ 'message' => __( 'Security verification failed. Please reload the page.', 'kinboni-pro' ) ], 403 );
		}

		if ( ! class_exists( 'Kinboni_WooCommerce' ) ) {
			wp_send_json_error( [ 'message' => __( 'WooCommerce engine is unavailable.', 'kinboni-pro' ) ], 500 );
		}

		$key_or_id = sanitize_text_field( wp_unslash( $_POST['key'] ?? ( $_POST['product_id'] ?? '' ) ) );
		$is_delta  = isset( $_POST['delta'] );
		$val       = $is_delta ? intval( $_POST['delta'] ) : intval( $_POST['quantity'] ?? 1 );

		if ( empty( $key_or_id ) ) {
			wp_send_json_error( [ 'message' => __( 'Invalid cart item.', 'kinboni-pro' ) ], 400 );
		}

		try {
			$payload = Kinboni_WooCommerce::update_cart_quantity( $key_or_id, $val, $is_delta );
			wp_send_json_success( $payload );
		} catch ( \Exception $e ) {
			wp_send_json_error( [ 'message' => $e->getMessage() ], 400 );
		}
	}

	/**
	 * AJAX endpoint: Remove item from WooCommerce cart.
	 */
	public static function remove_cart_item(): void {
		if ( ! self::verify_nonce() ) {
			wp_send_json_error( [ 'message' => __( 'Security verification failed. Please reload the page.', 'kinboni-pro' ) ], 403 );
		}

		if ( ! class_exists( 'Kinboni_WooCommerce' ) ) {
			wp_send_json_error( [ 'message' => __( 'WooCommerce engine is unavailable.', 'kinboni-pro' ) ], 500 );
		}

		$key_or_id = sanitize_text_field( wp_unslash( $_POST['key'] ?? ( $_POST['product_id'] ?? '' ) ) );

		if ( empty( $key_or_id ) ) {
			wp_send_json_error( [ 'message' => __( 'Invalid cart item.', 'kinboni-pro' ) ], 400 );
		}

		try {
			$payload = Kinboni_WooCommerce::remove_cart_item( $key_or_id );
			wp_send_json_success( $payload );
		} catch ( \Exception $e ) {
			wp_send_json_error( [ 'message' => $e->getMessage() ], 400 );
		}
	}

	/**
	 * AJAX endpoint: Empty the WooCommerce cart.
	 */
	public static function clear_cart(): void {
		if ( ! self::verify_nonce() ) {
			wp_send_json_error( [ 'message' => __( 'Security verification failed. Please reload the page.', 'kinboni-pro' ) ], 403 );
		}

		if ( ! class_exists( 'Kinboni_WooCommerce' ) ) {
			wp_send_json_error( [ 'message' => __( 'WooCommerce engine is unavailable.', 'kinboni-pro' ) ], 500 );
		}

		try {
			$payload = Kinboni_WooCommerce::clear_cart();
			wp_send_json_success( $payload );
		} catch ( \Exception $e ) {
			wp_send_json_error( [ 'message' => $e->getMessage() ], 400 );
		}
	}

	/**
	 * AJAX endpoint: Apply coupon code to WooCommerce cart.
	 */
	public static function apply_coupon(): void {
		if ( ! self::verify_nonce() ) {
			wp_send_json_error( [ 'message' => __( 'Security verification failed. Please reload the page.', 'kinboni-pro' ) ], 403 );
		}

		if ( ! class_exists( 'Kinboni_WooCommerce' ) ) {
			wp_send_json_error( [ 'message' => __( 'WooCommerce engine is unavailable.', 'kinboni-pro' ) ], 500 );
		}

		$code = sanitize_text_field( wp_unslash( $_POST['code'] ?? '' ) );

		try {
			$payload = Kinboni_WooCommerce::apply_cart_coupon( $code );
			wp_send_json_success( $payload );
		} catch ( \Exception $e ) {
			wp_send_json_error( [ 'message' => $e->getMessage() ], 400 );
		}
	}

	/**
	 * AJAX endpoint: Remove coupon code from WooCommerce cart.
	 */
	public static function remove_coupon(): void {
		if ( ! self::verify_nonce() ) {
			wp_send_json_error( [ 'message' => __( 'Security verification failed. Please reload the page.', 'kinboni-pro' ) ], 403 );
		}

		if ( ! class_exists( 'Kinboni_WooCommerce' ) ) {
			wp_send_json_error( [ 'message' => __( 'WooCommerce engine is unavailable.', 'kinboni-pro' ) ], 500 );
		}

		$code = sanitize_text_field( wp_unslash( $_POST['code'] ?? '' ) );

		try {
			$payload = Kinboni_WooCommerce::remove_cart_coupon( $code );
			wp_send_json_success( $payload );
		} catch ( \Exception $e ) {
			wp_send_json_error( [ 'message' => $e->getMessage() ], 400 );
		}
	}

	/**
	 * AJAX endpoint: Get wishlist items and state.
	 */
	public static function get_wishlist(): void {
		if ( ! class_exists( 'Kinboni_WooCommerce' ) ) {
			wp_send_json_error( [ 'message' => __( 'WooCommerce engine is unavailable.', 'kinboni-pro' ) ], 500 );
		}

		$payload = Kinboni_WooCommerce::get_wishlist_payload();
		wp_send_json_success( $payload );
	}

	/**
	 * AJAX endpoint: Toggle product in wishlist.
	 */
	public static function toggle_wishlist(): void {
		if ( ! self::verify_nonce() ) {
			wp_send_json_error( [ 'message' => __( 'Security verification failed. Please reload the page.', 'kinboni-pro' ) ], 403 );
		}

		if ( ! class_exists( 'Kinboni_WooCommerce' ) ) {
			wp_send_json_error( [ 'message' => __( 'WooCommerce engine is unavailable.', 'kinboni-pro' ) ], 500 );
		}

		$product_id = sanitize_text_field( wp_unslash( $_POST['product_id'] ?? '' ) );
		if ( empty( $product_id ) ) {
			wp_send_json_error( [ 'message' => __( 'Invalid product selection.', 'kinboni-pro' ) ], 400 );
		}

		try {
			$payload = Kinboni_WooCommerce::toggle_wishlist_item( $product_id );
			wp_send_json_success( $payload );
		} catch ( \Exception $e ) {
			wp_send_json_error( [ 'message' => $e->getMessage() ], 400 );
		}
	}

	/**
	 * AJAX endpoint: Remove product from wishlist.
	 */
	public static function remove_wishlist_item(): void {
		if ( ! self::verify_nonce() ) {
			wp_send_json_error( [ 'message' => __( 'Security verification failed. Please reload the page.', 'kinboni-pro' ) ], 403 );
		}

		if ( ! class_exists( 'Kinboni_WooCommerce' ) ) {
			wp_send_json_error( [ 'message' => __( 'WooCommerce engine is unavailable.', 'kinboni-pro' ) ], 500 );
		}

		$product_id = sanitize_text_field( wp_unslash( $_POST['product_id'] ?? '' ) );
		if ( empty( $product_id ) ) {
			wp_send_json_error( [ 'message' => __( 'Invalid product selection.', 'kinboni-pro' ) ], 400 );
		}

		try {
			$payload = Kinboni_WooCommerce::remove_wishlist_item( $product_id );
			wp_send_json_success( $payload );
		} catch ( \Exception $e ) {
			wp_send_json_error( [ 'message' => $e->getMessage() ], 400 );
		}
	}

	/**
	 * AJAX endpoint: Move product from wishlist to cart.
	 */
	public static function move_wishlist_to_cart(): void {
		if ( ! self::verify_nonce() ) {
			wp_send_json_error( [ 'message' => __( 'Security verification failed. Please reload the page.', 'kinboni-pro' ) ], 403 );
		}

		if ( ! class_exists( 'Kinboni_WooCommerce' ) ) {
			wp_send_json_error( [ 'message' => __( 'WooCommerce engine is unavailable.', 'kinboni-pro' ) ], 500 );
		}

		$product_id = sanitize_text_field( wp_unslash( $_POST['product_id'] ?? '' ) );
		$quantity   = max( 1, absint( $_POST['quantity'] ?? 1 ) );

		if ( empty( $product_id ) ) {
			wp_send_json_error( [ 'message' => __( 'Invalid product selection.', 'kinboni-pro' ) ], 400 );
		}

		try {
			$result = Kinboni_WooCommerce::move_wishlist_to_bag( $product_id, $quantity );
			wp_send_json_success( $result );
		} catch ( \Exception $e ) {
			wp_send_json_error( [ 'message' => $e->getMessage() ], 400 );
		}
	}

	/**
	 * AJAX endpoint for live product search (Module 05: SearchController).
	 */
	public static function search_products(): void {
		$query = sanitize_text_field( wp_unslash( $_REQUEST['query'] ?? $_REQUEST['q'] ?? '' ) );
		$limit = isset( $_REQUEST['limit'] ) ? absint( $_REQUEST['limit'] ) : 12;

		if ( ! class_exists( 'Kinboni_WooCommerce' ) ) {
			wp_send_json_error( [ 'message' => __( 'WooCommerce engine is unavailable.', 'kinboni-pro' ) ], 500 );
		}

		try {
			$data = Kinboni_WooCommerce::search_products( $query, $limit );
			wp_send_json_success( $data );
		} catch ( \Exception $e ) {
			wp_send_json_error( [ 'message' => $e->getMessage() ], 500 );
		}
	}
}

