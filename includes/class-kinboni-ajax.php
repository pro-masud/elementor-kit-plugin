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

	/**
	 * AJAX endpoint for loading WooCommerce product data for Quick View.
	 */
	public static function quick_view(): void {
		$product_id = absint( $_REQUEST['product_id'] ?? 0 );
		if ( ! $product_id ) {
			wp_send_json_error( [ 'message' => __( 'Invalid product ID.', 'kinboni-pro' ) ], 400 );
		}

		if ( ! function_exists( 'wc_get_product' ) ) {
			wp_send_json_error( [ 'message' => __( 'WooCommerce is not active.', 'kinboni-pro' ) ], 400 );
		}

		$product = wc_get_product( $product_id );
		if ( ! $product ) {
			wp_send_json_error( [ 'message' => __( 'Product not found.', 'kinboni-pro' ) ], 404 );
		}

		$image_id = $product->get_image_id();
		$main_img = $image_id ? wp_get_attachment_image_url( $image_id, 'large' ) : ( function_exists( 'wc_placeholder_img_src' ) ? wc_placeholder_img_src( 'large' ) : '' );

		$gallery = [ $main_img ];
		foreach ( $product->get_gallery_image_ids() as $gid ) {
			$gurl = wp_get_attachment_image_url( $gid, 'large' );
			if ( $gurl && ! in_array( $gurl, $gallery, true ) ) {
				$gallery[] = $gurl;
			}
		}

		$cats = wp_get_post_terms( $product->get_id(), 'product_cat' );
		$cat_name = ! empty( $cats ) && ! is_wp_error( $cats ) ? $cats[0]->name : __( 'Fine Collection', 'kinboni-pro' );

		$currency_symbol = function_exists( 'get_woocommerce_currency_symbol' ) ? get_woocommerce_currency_symbol() : '৳';
		$raw_price = $product->get_price();
		$regular_price = $product->get_regular_price();

		$data = [
			'id'            => $product->get_id(),
			'name'          => $product->get_name(),
			'price'         => (float) $raw_price,
			'formattedPrice'=> $currency_symbol . number_format( (float) $raw_price ),
			'originalPrice' => $regular_price && (float) $regular_price > (float) $raw_price ? (float) $regular_price : null,
			'badge'         => $cat_name,
			'categoryLabel' => $cat_name,
			'image'         => $gallery[0],
			'hoverImage'    => count( $gallery ) > 1 ? $gallery[1] : $gallery[0],
			'gallery'       => $gallery,
			'description'   => wp_strip_all_tags( $product->get_short_description() ?: $product->get_description() ),
			'permalink'     => $product->get_permalink(),
			'rating'        => $product->get_average_rating() ? (float) $product->get_average_rating() : 5.0,
			'reviewsCount'  => $product->get_review_count() ?: 18,
			'inStock'       => $product->is_in_stock(),
			'specs'         => [ 'Authentic Certified Craftsmanship', 'Complimentary Insured Shipping', '7-Day Return Guarantee' ],
		];

		wp_send_json_success( $data );
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
}

