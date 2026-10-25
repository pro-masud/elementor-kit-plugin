<?php
/**
 * WooCommerce Integration — Helpers & hooks.
 *
 * This class is loaded ONLY when WooCommerce is active.
 * Add WC-specific helpers, product queries, cart helpers here.
 *
 * @package KinboniPro
 */

defined( 'ABSPATH' ) || exit;

class Kinboni_WooCommerce {

	/**
	 * Register hooks.
	 */
	public static function init(): void {
		// Sync guest wishlist to customer meta upon login
		add_action( 'wp_login', [ __CLASS__, 'sync_guest_wishlist_on_login' ], 10, 2 );
	}

	/**
	 * Get current customer wishlist product IDs (from user meta or guest cookie).
	 *
	 * @return int[]
	 */
	public static function get_wishlist_ids(): array {
		$ids = [];

		if ( is_user_logged_in() ) {
			$meta = get_user_meta( get_current_user_id(), '_kinboni_wishlist', true );
			if ( is_array( $meta ) ) {
				$ids = array_map( 'absint', $meta );
			}
		} else {
			if ( ! empty( $_COOKIE['kinboni_wishlist'] ) ) {
				$cookie_raw = sanitize_text_field( wp_unslash( $_COOKIE['kinboni_wishlist'] ) );
				$decoded    = json_decode( $cookie_raw, true );
				if ( is_array( $decoded ) ) {
					$ids = array_map( 'absint', $decoded );
				}
			}
		}

		return array_values( array_filter( array_unique( $ids ) ) );
	}

	/**
	 * Save wishlist product IDs to user meta or guest cookie.
	 *
	 * @param int[] $ids
	 */
	public static function save_wishlist_ids( array $ids ): void {
		$clean_ids = array_values( array_filter( array_unique( array_map( 'absint', $ids ) ) ) );

		if ( is_user_logged_in() ) {
			update_user_meta( get_current_user_id(), '_kinboni_wishlist', $clean_ids );
		}

		// Also set cookie so guest state or quick client hydration persists
		if ( ! headers_sent() ) {
			setcookie(
				'kinboni_wishlist',
				wp_json_encode( $clean_ids ),
				time() + ( 30 * DAY_IN_SECONDS ),
				COOKIEPATH,
				COOKIE_DOMAIN,
				is_ssl(),
				false
			);
		}
		$_COOKIE['kinboni_wishlist'] = wp_json_encode( $clean_ids );
	}

	/**
	 * Synchronize guest wishlist to user meta when customer logs in.
	 *
	 * @param string   $user_login
	 * @param \WP_User $user
	 */
	public static function sync_guest_wishlist_on_login( string $user_login, \WP_User $user ): void {
		if ( empty( $_COOKIE['kinboni_wishlist'] ) ) {
			return;
		}

		$cookie_raw = sanitize_text_field( wp_unslash( $_COOKIE['kinboni_wishlist'] ) );
		$guest_ids  = json_decode( $cookie_raw, true );
		if ( ! is_array( $guest_ids ) || empty( $guest_ids ) ) {
			return;
		}

		$user_ids = get_user_meta( $user->ID, '_kinboni_wishlist', true );
		if ( ! is_array( $user_ids ) ) {
			$user_ids = [];
		}

		$merged = array_values( array_filter( array_unique( array_merge( $user_ids, array_map( 'absint', $guest_ids ) ) ) ) );
		update_user_meta( $user->ID, '_kinboni_wishlist', $merged );
	}

	/**
	 * Get full wishlist payload with live WooCommerce product details.
	 *
	 * @return array<string, mixed>
	 */
	public static function get_wishlist_payload(): array {
		$ids   = self::get_wishlist_ids();
		$items = [];

		foreach ( $ids as $id ) {
			$product = self::resolve_product( $id );
			if ( ! $product || ! is_a( $product, '\WC_Product' ) ) {
				continue;
			}

			$image_id  = $product->get_image_id();
			$image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'medium' ) : ( function_exists( 'wc_placeholder_img_src' ) ? wc_placeholder_img_src( 'medium' ) : '' );
			$raw_price = (float) $product->get_price();

			$cats           = wp_get_post_terms( $product->get_id(), 'product_cat' );
			$category_label = ( ! empty( $cats ) && ! is_wp_error( $cats ) ) ? $cats[0]->name : __( 'Atelier Creation', 'kinboni-pro' );

			$items[] = [
				'id'             => $product->get_id(),
				'name'           => $product->get_name(),
				'price'          => $raw_price,
				'formattedPrice' => self::format_price( $raw_price ),
				'regularPrice'   => (float) $product->get_regular_price(),
				'image'          => $image_url,
				'permalink'      => $product->get_permalink(),
				'categoryLabel'  => $category_label,
				'inStock'        => $product->is_in_stock(),
			];
		}

		return [
			'items'    => $items,
			'item_ids' => array_column( $items, 'id' ),
			'count'    => count( $items ),
			'is_empty' => empty( $items ),
		];
	}

	/**
	 * Toggle product in wishlist (adds if absent, removes if present).
	 *
	 * @param int|string $product_id
	 * @return array<string, mixed>
	 * @throws \Exception
	 */
	public static function toggle_wishlist_item( $product_id ): array {
		$product = self::resolve_product( $product_id );
		if ( ! $product ) {
			throw new \Exception( sprintf( __( 'Product #%d could not be found.', 'kinboni-pro' ), $product_id ) );
		}

		$real_id = $product->get_id();
		$ids     = self::get_wishlist_ids();

		$pos = array_search( $real_id, $ids, true );
		if ( false !== $pos ) {
			// Remove from wishlist
			unset( $ids[ $pos ] );
			$action  = 'removed';
			$message = sprintf( __( 'Removed "%s" from wishlist', 'kinboni-pro' ), $product->get_name() );
		} else {
			// Add to wishlist
			$ids[]   = $real_id;
			$action  = 'added';
			$message = sprintf( __( 'Saved "%s" to wishlist', 'kinboni-pro' ), $product->get_name() );
		}

		self::save_wishlist_ids( $ids );

		$payload              = self::get_wishlist_payload();
		$payload['action']    = $action;
		$payload['message']   = $message;
		$payload['target_id'] = $real_id;

		return $payload;
	}

	/**
	 * Remove a product from the wishlist.
	 *
	 * @param int|string $product_id
	 * @return array<string, mixed>
	 */
	public static function remove_wishlist_item( $product_id ): array {
		$product   = self::resolve_product( $product_id );
		$target_id = $product ? $product->get_id() : absint( $product_id );

		$ids = self::get_wishlist_ids();
		$ids = array_diff( $ids, [ $target_id ] );

		self::save_wishlist_ids( $ids );

		$payload              = self::get_wishlist_payload();
		$payload['action']    = 'removed';
		$payload['message']   = __( 'Item removed from wishlist.', 'kinboni-pro' );
		$payload['target_id'] = $target_id;

		return $payload;
	}

	/**
	 * Move item from wishlist to cart.
	 *
	 * @param int|string $product_id
	 * @param int        $quantity
	 * @return array<string, mixed>
	 */
	public static function move_wishlist_to_bag( $product_id, int $quantity = 1 ): array {
		// 1. Add to cart
		$cart_payload = self::add_to_cart_item( $product_id, $quantity );

		// 2. Remove from wishlist
		$wishlist_payload = self::remove_wishlist_item( $product_id );

		return [
			'cart'     => $cart_payload,
			'wishlist' => $wishlist_payload,
			'message'  => __( 'Moved creation to your shopping bag!', 'kinboni-pro' ),
		];
	}

	/**
	 * Get comprehensive Quick View product payload for WooCommerce product.
	 *
	 * @param int|string $product_id
	 * @return array<string, mixed>
	 * @throws \Exception
	 */
	public static function get_quick_view_data( $product_id ): array {
		$product = self::resolve_product( $product_id );
		if ( ! $product ) {
			throw new \Exception( sprintf( __( 'Product #%s could not be found.', 'kinboni-pro' ), $product_id ) );
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

		$cats     = wp_get_post_terms( $product->get_id(), 'product_cat' );
		$cat_name = ! empty( $cats ) && ! is_wp_error( $cats ) ? $cats[0]->name : __( 'Fine Collection', 'kinboni-pro' );

		$raw_price     = (float) $product->get_price();
		$regular_price = (float) $product->get_regular_price();
		$is_on_sale    = $product->is_on_sale() || ( $regular_price > $raw_price && $raw_price > 0 );
		$discount_pct  = ( $is_on_sale && $regular_price > 0 ) ? (int) round( ( ( $regular_price - $raw_price ) / $regular_price ) * 100 ) : 0;

		$rating        = $product->get_average_rating() ? (float) $product->get_average_rating() : 5.0;
		$reviews_count = $product->get_review_count() ?: 18;

		$short_desc = wp_strip_all_tags( $product->get_short_description() ?: $product->get_description() );
		if ( empty( $short_desc ) ) {
			$short_desc = __( 'Mastercrafted with the utmost precision and artisanal heritage.', 'kinboni-pro' );
		}

		$specs = [
			__( 'Authentic Certified Craftsmanship', 'kinboni-pro' ),
			__( 'Complimentary Insured Shipping', 'kinboni-pro' ),
			__( '7-Day Return Guarantee', 'kinboni-pro' ),
			__( 'Kinboni Atelier Serial Verification', 'kinboni-pro' ),
		];

		return [
			'id'                     => $product->get_id(),
			'name'                   => $product->get_name(),
			'price'                  => $raw_price,
			'formattedPrice'         => self::format_price( $raw_price ),
			'originalPrice'          => $is_on_sale ? $regular_price : null,
			'formattedOriginalPrice' => $is_on_sale ? self::format_price( $regular_price ) : '',
			'discountPercent'        => $discount_pct,
			'badge'                  => $cat_name,
			'categoryLabel'          => $cat_name,
			'image'                  => $gallery[0] ?? $main_img,
			'hoverImage'             => count( $gallery ) > 1 ? $gallery[1] : ( $gallery[0] ?? $main_img ),
			'gallery'                => $gallery,
			'description'            => $short_desc,
			'permalink'              => $product->get_permalink(),
			'rating'                 => $rating,
			'reviewsCount'           => $reviews_count,
			'inStock'                => $product->is_in_stock(),
			'stockQuantity'          => $product->managing_stock() ? (int) $product->get_stock_quantity() : null,
			'specs'                  => $specs,
		];
	}

	/**
	 * Ensure WooCommerce cart & session are loaded (needed in AJAX context).
	 */
	public static function ensure_cart_loaded(): void {
		if ( ! function_exists( 'WC' ) ) {
			return;
		}

		if ( is_null( WC()->session ) ) {
			$session_class = apply_filters( 'woocommerce_session_handler', '\WC_Session_Handler' );
			if ( class_exists( $session_class ) ) {
				WC()->session = new $session_class();
				WC()->session->init();
			}
		}

		if ( is_null( WC()->customer ) && class_exists( '\WC_Customer' ) ) {
			WC()->customer = new \WC_Customer( get_current_user_id(), true );
		}

		if ( is_null( WC()->cart ) && class_exists( '\WC_Cart' ) ) {
			WC()->cart = new \WC_Cart();
			WC()->cart->get_cart_from_session();
		}
	}

	/**
	 * Smart product resolver: resolves product by ID, demo SKU, or title.
	 *
	 * @param int|string $product_id Product ID or demo ID.
	 * @param string     $title      Optional product name fallback.
	 * @return \WC_Product|null
	 */
	public static function resolve_product( $product_id, string $title = '' ): ?\WC_Product {
		$product_id = absint( $product_id );
		$product    = $product_id ? wc_get_product( $product_id ) : null;

		// Intelligent Fallback 1: Resolve by Demo SKU if ID is 1..12
		if ( ! $product && $product_id <= 12 && function_exists( 'wc_get_product_id_by_sku' ) ) {
			$demo_sku  = sprintf( 'KB-DEMO-%02d', $product_id );
			$mapped_id = wc_get_product_id_by_sku( $demo_sku );
			if ( $mapped_id ) {
				$product = wc_get_product( $mapped_id );
			}
		}

		// Intelligent Fallback 2: Resolve by Product Title
		if ( ! $product && ! empty( $title ) ) {
			$matched_post = get_page_by_title( sanitize_text_field( $title ), OBJECT, 'product' );
			if ( $matched_post ) {
				$product = wc_get_product( $matched_post->ID );
			}
		}

		// Intelligent Fallback 3: Resolve by index for demo IDs 1..12 among published WooCommerce products
		if ( ! $product && $product_id > 0 && $product_id <= 12 && function_exists( 'wc_get_products' ) ) {
			$available_products = wc_get_products( [ 'limit' => 12, 'status' => 'publish' ] );
			if ( ! empty( $available_products ) ) {
				$target_index = ( $product_id - 1 ) % count( $available_products );
				$product      = $available_products[ $target_index ] ?? null;
			}
		}

		return $product;
	}

	/**
	 * Ensure default Atelier VIP privilege coupons exist in WooCommerce.
	 *
	 * @param string $code
	 */
	public static function ensure_atelier_coupon_exists( string $code ): void {
		if ( ! function_exists( 'wc_get_coupon_id_by_code' ) ) {
			return;
		}

		$clean_code  = strtoupper( sanitize_text_field( trim( $code ) ) );
		$existing_id = wc_get_coupon_id_by_code( $clean_code );
		if ( $existing_id ) {
			return;
		}

		$promos = [
			'LUXE20'    => 20,
			'KINBONI10' => 10,
			'WELCOME'   => 15,
		];

		if ( isset( $promos[ $clean_code ] ) && class_exists( '\WC_Coupon' ) ) {
			$coupon = new \WC_Coupon();
			$coupon->set_code( $clean_code );
			$coupon->set_discount_type( 'percent' );
			$coupon->set_amount( $promos[ $clean_code ] );
			$coupon->set_description( __( 'Kinboni Atelier VIP Privilege Voucher', 'kinboni-pro' ) );
			$coupon->set_individual_use( true );
			$coupon->save();
		}
	}

	/**
	 * Get the full authoritative WooCommerce Cart payload for KINBONI frontend.
	 *
	 * @return array<string, mixed>
	 */
	public static function get_cart_payload(): array {
		self::ensure_cart_loaded();

		$wc_cart = function_exists( 'WC' ) ? WC()->cart : null;
		if ( ! $wc_cart ) {
			return [
				'items'                   => [],
				'item_count'              => 0,
				'subtotal'                => 0,
				'subtotal_formatted'      => self::format_price( 0 ),
				'discount_total'          => 0,
				'discount_formatted'      => self::format_price( 0 ),
				'total'                   => 0,
				'total_formatted'         => self::format_price( 0 ),
				'free_shipping_threshold' => 2500,
				'free_shipping_unlocked'  => false,
				'free_shipping_remaining' => 2500,
				'free_shipping_progress'  => 0,
				'coupons'                 => [],
				'is_empty'                => true,
			];
		}

		$items    = [];
		$subtotal = 0.0;

		foreach ( $wc_cart->get_cart() as $cart_item_key => $cart_item ) {
			/** @var \WC_Product $product */
			$product = $cart_item['data'] ?? null;
			if ( ! $product || ! is_a( $product, '\WC_Product' ) ) {
				continue;
			}

			$product_id = $product->get_id();
			$quantity   = (int) ( $cart_item['quantity'] ?? 1 );
			$price      = (float) $product->get_price();
			$line_total = (float) ( $cart_item['line_total'] ?? ( $price * $quantity ) );
			$subtotal  += $line_total;

			$image_id  = $product->get_image_id();
			$image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'medium' ) : ( function_exists( 'wc_placeholder_img_src' ) ? wc_placeholder_img_src( 'medium' ) : '' );

			$cats           = wp_get_post_terms( $product_id, 'product_cat' );
			$category_label = ( ! empty( $cats ) && ! is_wp_error( $cats ) ) ? $cats[0]->name : __( 'Atelier Creation', 'kinboni-pro' );

			$items[] = [
				'key'                  => $cart_item_key,
				'id'                   => $product_id,
				'name'                 => $product->get_name(),
				'price'                => $price,
				'price_formatted'      => self::format_price( $price ),
				'quantity'             => $quantity,
				'line_total'           => $line_total,
				'line_total_formatted' => self::format_price( $line_total ),
				'image'                => $image_url,
				'categoryLabel'        => $category_label,
				'color'                => $cart_item['kinboni_color'] ?? '',
				'size'                 => $cart_item['kinboni_size'] ?? '',
				'in_stock'             => $product->is_in_stock(),
				'max_quantity'         => $product->managing_stock() ? (int) $product->get_stock_quantity() : 99,
			];
		}

		$free_shipping_threshold = 2500.0;
		$wc_subtotal             = (float) $wc_cart->get_subtotal();
		if ( 0.0 === $wc_subtotal ) {
			$wc_subtotal = $subtotal;
		}

		$wc_discount = (float) $wc_cart->get_discount_total();
		$wc_total    = (float) $wc_cart->get_total( 'edit' );
		if ( 0.0 === $wc_total && $subtotal > 0 ) {
			$wc_total = max( 0.0, $subtotal - $wc_discount );
		}

		$applied_coupons = [];
		foreach ( $wc_cart->get_applied_coupons() as $coupon_code ) {
			$coupon_obj = new \WC_Coupon( $coupon_code );
			$applied_coupons[] = [
				'code'     => $coupon_code,
				'amount'   => (float) $coupon_obj->get_amount(),
				'type'     => $coupon_obj->get_discount_type(),
				'discount' => self::format_price( $wc_discount ),
			];
		}

		$is_free   = $wc_subtotal >= $free_shipping_threshold;
		$remaining = max( 0.0, $free_shipping_threshold - $wc_subtotal );
		$progress  = min( 100, (int) round( ( $wc_subtotal / $free_shipping_threshold ) * 100 ) );

		return [
			'items'                   => $items,
			'item_count'              => (int) $wc_cart->get_cart_contents_count(),
			'subtotal'                => $wc_subtotal,
			'subtotal_formatted'      => self::format_price( $wc_subtotal ),
			'discount_total'          => $wc_discount,
			'discount_formatted'      => self::format_price( $wc_discount ),
			'total'                   => $wc_total,
			'total_formatted'         => self::format_price( $wc_total ),
			'free_shipping_threshold' => $free_shipping_threshold,
			'free_shipping_unlocked'  => $is_free,
			'free_shipping_remaining' => $remaining,
			'free_shipping_progress'  => $progress,
			'coupons'                 => $applied_coupons,
			'is_empty'                => empty( $items ),
		];
	}

	/**
	 * Add product to WooCommerce cart.
	 *
	 * @param int|string $product_id Product ID or demo ID.
	 * @param int        $quantity   Quantity to add.
	 * @param string     $color      Selected color variation/option.
	 * @param string     $size       Selected size option.
	 * @param string     $title      Optional title fallback.
	 * @return array<string, mixed> Updated cart payload.
	 * @throws \Exception When product cannot be added.
	 */
	public static function add_to_cart_item( $product_id, int $quantity = 1, string $color = '', string $size = '', string $title = '' ): array {
		self::ensure_cart_loaded();

		$product = self::resolve_product( $product_id, $title );
		if ( ! $product ) {
			throw new \Exception( sprintf( __( 'Product #%d could not be found.', 'kinboni-pro' ), $product_id ) );
		}

		if ( ! $product->is_purchasable() ) {
			throw new \Exception( sprintf( __( 'Product "%s" is not currently purchasable.', 'kinboni-pro' ), $product->get_name() ) );
		}

		if ( ! $product->is_in_stock() ) {
			throw new \Exception( sprintf( __( 'Product "%s" is out of stock.', 'kinboni-pro' ), $product->get_name() ) );
		}

		$quantity = max( 1, $quantity );
		if ( $product->managing_stock() && $product->get_stock_quantity() < $quantity ) {
			throw new \Exception( sprintf( __( 'Only %d units available for "%s".', 'kinboni-pro' ), $product->get_stock_quantity(), $product->get_name() ) );
		}

		$cart_item_data = [];
		if ( ! empty( $color ) && 'Standard' !== $color ) {
			$cart_item_data['kinboni_color'] = sanitize_text_field( $color );
		}
		if ( ! empty( $size ) ) {
			$cart_item_data['kinboni_size'] = sanitize_text_field( $size );
		}

		if ( WC()->session && ! WC()->session->has_session() ) {
			WC()->session->set_customer_session_cookie( true );
		}

		$cart_item_key = WC()->cart->add_to_cart( $product->get_id(), $quantity, 0, [], $cart_item_data );

		if ( ! $cart_item_key ) {
			throw new \Exception( sprintf( __( 'Failed to add "%s" to shopping bag.', 'kinboni-pro' ), $product->get_name() ) );
		}

		WC()->cart->calculate_totals();

		$payload               = self::get_cart_payload();
		$payload['added_item'] = [
			'id'   => $product->get_id(),
			'name' => $product->get_name(),
			'key'  => $cart_item_key,
		];
		$payload['message']    = sprintf( __( '"%s" added to shopping bag!', 'kinboni-pro' ), $product->get_name() );

		return $payload;
	}

	/**
	 * Update quantity of an item in the WooCommerce cart.
	 *
	 * @param string|int $key_or_id Cart item key or Product ID.
	 * @param int        $delta_or_quantity Quantity value or delta.
	 * @param bool       $is_delta True if updating by delta (+1/-1), false if setting absolute quantity.
	 * @return array<string, mixed> Updated cart payload.
	 * @throws \Exception
	 */
	public static function update_cart_quantity( $key_or_id, int $delta_or_quantity, bool $is_delta = false ): array {
		self::ensure_cart_loaded();

		$cart = WC()->cart;
		if ( ! $cart ) {
			throw new \Exception( __( 'WooCommerce cart unavailable.', 'kinboni-pro' ) );
		}

		$target_key  = null;
		$current_qty = 0;

		// Check if $key_or_id is a valid cart item key
		if ( is_string( $key_or_id ) && isset( $cart->get_cart()[ $key_or_id ] ) ) {
			$target_key  = $key_or_id;
			$current_qty = $cart->get_cart()[ $key_or_id ]['quantity'];
		} else {
			// Find by product id or demo id
			$resolved_product = self::resolve_product( $key_or_id );
			$pid              = $resolved_product ? $resolved_product->get_id() : absint( $key_or_id );

			foreach ( $cart->get_cart() as $k => $item ) {
				$item_pid     = (int) ( $item['product_id'] ?? 0 );
				$item_data_id = ( isset( $item['data'] ) && is_a( $item['data'], '\WC_Product' ) ) ? $item['data']->get_id() : 0;
				if ( $item_pid === $pid || $item_data_id === $pid ) {
					$target_key  = $k;
					$current_qty = $item['quantity'];
					break;
				}
			}
		}

		if ( ! $target_key ) {
			throw new \Exception( __( 'Item not found in shopping bag.', 'kinboni-pro' ) );
		}

		$new_quantity = $is_delta ? ( $current_qty + $delta_or_quantity ) : $delta_or_quantity;

		if ( $new_quantity <= 0 ) {
			$cart->remove_cart_item( $target_key );
			$message = __( 'Item removed from shopping bag.', 'kinboni-pro' );
		} else {
			$cart->set_quantity( $target_key, $new_quantity );
			$message = __( 'Shopping bag updated.', 'kinboni-pro' );
		}

		$cart->calculate_totals();

		$payload            = self::get_cart_payload();
		$payload['message'] = $message;

		return $payload;
	}

	/**
	 * Remove an item from the WooCommerce cart.
	 *
	 * @param string|int $key_or_id Cart item key or Product ID.
	 * @return array<string, mixed> Updated cart payload.
	 * @throws \Exception
	 */
	public static function remove_cart_item( $key_or_id ): array {
		self::ensure_cart_loaded();

		$cart = WC()->cart;
		if ( ! $cart ) {
			throw new \Exception( __( 'WooCommerce cart unavailable.', 'kinboni-pro' ) );
		}

		$target_key = null;

		if ( is_string( $key_or_id ) && isset( $cart->get_cart()[ $key_or_id ] ) ) {
			$target_key = $key_or_id;
		} else {
			$resolved_product = self::resolve_product( $key_or_id );
			$pid              = $resolved_product ? $resolved_product->get_id() : absint( $key_or_id );

			foreach ( $cart->get_cart() as $k => $item ) {
				$item_pid     = (int) ( $item['product_id'] ?? 0 );
				$item_data_id = ( isset( $item['data'] ) && is_a( $item['data'], '\WC_Product' ) ) ? $item['data']->get_id() : 0;
				if ( $item_pid === $pid || $item_data_id === $pid ) {
					$target_key = $k;
					break;
				}
			}
		}

		if ( $target_key ) {
			$cart->remove_cart_item( $target_key );
			$cart->calculate_totals();
		}

		$payload            = self::get_cart_payload();
		$payload['message'] = __( 'Item removed from bag.', 'kinboni-pro' );

		return $payload;
	}

	/**
	 * Empty the WooCommerce cart.
	 *
	 * @return array<string, mixed>
	 */
	public static function clear_cart(): array {
		self::ensure_cart_loaded();
		if ( WC()->cart ) {
			WC()->cart->empty_cart();
		}

		$payload            = self::get_cart_payload();
		$payload['message'] = __( 'Shopping bag cleared.', 'kinboni-pro' );

		return $payload;
	}

	/**
	 * Apply coupon to WooCommerce cart.
	 *
	 * @param string $code
	 * @return array<string, mixed>
	 * @throws \Exception
	 */
	public static function apply_cart_coupon( string $code ): array {
		self::ensure_cart_loaded();

		$clean_code = strtoupper( sanitize_text_field( trim( $code ) ) );
		if ( empty( $clean_code ) ) {
			throw new \Exception( __( 'Please enter a voucher code (try "LUXE20").', 'kinboni-pro' ) );
		}

		self::ensure_atelier_coupon_exists( $clean_code );

		$cart = WC()->cart;
		if ( ! $cart ) {
			throw new \Exception( __( 'WooCommerce cart unavailable.', 'kinboni-pro' ) );
		}

		if ( $cart->has_discount( $clean_code ) ) {
			throw new \Exception( sprintf( __( 'Coupon "%s" has already been applied.', 'kinboni-pro' ), $clean_code ) );
		}

		$result = $cart->apply_coupon( $clean_code );
		if ( ! $result && ! $cart->has_discount( $clean_code ) ) {
			$notices = function_exists( 'wc_get_notices' ) ? wc_get_notices( 'error' ) : [];
			$err_msg = ! empty( $notices ) ? wp_strip_all_tags( $notices[0]['notice'] ?? '' ) : sprintf( __( 'Coupon "%s" is invalid.', 'kinboni-pro' ), $clean_code );
			if ( function_exists( 'wc_clear_notices' ) ) {
				wc_clear_notices();
			}
			throw new \Exception( $err_msg );
		}

		if ( function_exists( 'wc_clear_notices' ) ) {
			wc_clear_notices();
		}

		$cart->calculate_totals();

		$payload            = self::get_cart_payload();
		$payload['message'] = sprintf( __( 'Promo code "%s" applied successfully!', 'kinboni-pro' ), $clean_code );

		return $payload;
	}

	/**
	 * Remove coupon from WooCommerce cart.
	 *
	 * @param string $code
	 * @return array<string, mixed>
	 */
	public static function remove_cart_coupon( string $code ): array {
		self::ensure_cart_loaded();

		$clean_code = strtoupper( sanitize_text_field( trim( $code ) ) );
		$cart       = WC()->cart;

		if ( $cart && ! empty( $clean_code ) ) {
			$cart->remove_coupon( $clean_code );
			$cart->calculate_totals();
		}

		$payload            = self::get_cart_payload();
		$payload['message'] = __( 'Promo code removed.', 'kinboni-pro' );

		return $payload;
	}

	/**
	 * Get product card data as an array.
	 *
	 * @param \WC_Product $product WooCommerce product object.
	 * @return array<string, mixed>
	 */
	public static function get_product_card_data( \WC_Product $product ): array {
		return [
			'id'            => $product->get_id(),
			'title'         => $product->get_name(),
			'price'         => $product->get_price_html(),
			'regular_price' => $product->get_regular_price(),
			'sale_price'    => $product->get_sale_price(),
			'image'         => wp_get_attachment_image_url( $product->get_image_id(), 'medium' ),
			'permalink'     => $product->get_permalink(),
			'short_desc'    => $product->get_short_description(),
			'in_stock'      => $product->is_in_stock(),
			'on_sale'       => $product->is_on_sale(),
			'type'          => $product->get_type(),
		];
	}

	/**
	 * Query products by various criteria.
	 *
	 * @param array<string, mixed> $args Query arguments.
	 * @return \WC_Product[]
	 */
	public static function query_products( array $args = [] ): array {
		$defaults = [
			'status'  => 'publish',
			'limit'   => 8,
			'orderby' => 'date',
			'order'   => 'DESC',
		];

		$query_args = wp_parse_args( $args, $defaults );
		$products   = wc_get_products( $query_args );

		return is_array( $products ) ? $products : [];
	}

	/**
	 * Format price with currency symbol.
	 *
	 * @param float $amount Price amount.
	 * @return string Formatted price.
	 */
	public static function format_price( float $amount ): string {
		if ( function_exists( 'wc_price' ) ) {
			return wc_price( $amount );
		}
		return '৳' . number_format( $amount, 0 );
	}

	/**
	 * Create an authoritative Cash on Delivery (COD) order in WooCommerce.
	 *
	 * @param array<string, mixed> $data Order data from request.
	 * @return array<string, mixed> Result data including order ID, totals, customer details, and WhatsApp link.
	 * @throws \Exception When validation fails or order creation fails.
	 */
	public static function create_cod_order( array $data ): array {
		if ( ! function_exists( 'wc_create_order' ) || ! function_exists( 'wc_get_product' ) ) {
			throw new \Exception( __( 'WooCommerce engine is not active.', 'kinboni-pro' ) );
		}

		// 1. Sanitize & validate customer details
		$customer_name    = sanitize_text_field( $data['customer_name'] ?? '' );
		$customer_phone   = sanitize_text_field( $data['customer_phone'] ?? '' );
		$customer_address = sanitize_textarea_field( $data['customer_address'] ?? '' );
		$delivery_zone    = sanitize_text_field( $data['delivery_zone'] ?? 'inside' );
		$promo_code       = strtoupper( sanitize_text_field( $data['promo_code'] ?? '' ) );

		if ( mb_strlen( $customer_name ) < 2 ) {
			throw new \Exception( __( 'Please enter your full name (at least 2 characters).', 'kinboni-pro' ) );
		}

		// BD phone validation (e.g. 017XXXXXXXX, +88017XXXXXXXX, 88017XXXXXXXX)
		$clean_phone = preg_replace( '/[\s\-]/', '', $customer_phone );
		if ( ! preg_match( '/^(?:\+88|88)?01[3-9]\d{8}$/', $clean_phone ) ) {
			throw new \Exception( __( 'Please provide a valid 11-digit mobile number (e.g., 017XXXXXXXX).', 'kinboni-pro' ) );
		}

		if ( mb_strlen( $customer_address ) < 5 ) {
			throw new \Exception( __( 'Please provide your full delivery address (House, Road, Area, District).', 'kinboni-pro' ) );
		}

		if ( ! in_array( $delivery_zone, [ 'inside', 'outside' ], true ) ) {
			$delivery_zone = 'inside';
		}

		// 2. Parse & validate items
		$raw_items = $data['items'] ?? [];
		if ( is_string( $raw_items ) ) {
			$raw_items = json_decode( stripslashes( $raw_items ), true );
		}

		if ( ! is_array( $raw_items ) || empty( $raw_items ) ) {
			throw new \Exception( __( 'Your shopping bag is empty. Please select a product before checking out.', 'kinboni-pro' ) );
		}

		$validated_items = [];
		$order_subtotal  = 0.0;

		foreach ( $raw_items as $raw_item ) {
			if ( ! is_array( $raw_item ) ) {
				continue;
			}

			$product_id = absint( $raw_item['id'] ?? 0 );
			$quantity   = max( 1, absint( $raw_item['quantity'] ?? 1 ) );
			$color      = sanitize_text_field( $raw_item['color'] ?? '' );
			$size       = sanitize_text_field( $raw_item['size'] ?? '' );

			if ( ! $product_id ) {
				continue;
			}

			$product = self::resolve_product( $product_id, $raw_item['name'] ?? '' );
			if ( $product ) {
				$product_id = $product->get_id();
			}

			if ( ! $product ) {
				throw new \Exception( sprintf( __( 'Product #%d could not be found.', 'kinboni-pro' ), $product_id ) );
			}

			if ( ! $product->is_purchasable() ) {
				throw new \Exception( sprintf( __( 'Product "%s" is not currently purchasable.', 'kinboni-pro' ), $product->get_name() ) );
			}

			if ( ! $product->is_in_stock() ) {
				throw new \Exception( sprintf( __( 'Product "%s" is out of stock.', 'kinboni-pro' ), $product->get_name() ) );
			}

			if ( $product->managing_stock() && $product->get_stock_quantity() < $quantity ) {
				throw new \Exception( sprintf( __( 'Only %d units available for "%s".', 'kinboni-pro' ), $product->get_stock_quantity(), $product->get_name() ) );
			}

			// Authoritative price directly from WooCommerce
			$price          = (float) $product->get_price();
			$line_subtotal  = $price * $quantity;
			$order_subtotal += $line_subtotal;

			$validated_items[] = [
				'product'       => $product,
				'product_id'    => $product_id,
				'name'          => $product->get_name(),
				'quantity'      => $quantity,
				'price'         => $price,
				'line_subtotal' => $line_subtotal,
				'color'         => $color,
				'size'          => $size,
			];
		}

		if ( empty( $validated_items ) ) {
			throw new \Exception( __( 'No valid products in your selection.', 'kinboni-pro' ) );
		}

		// 3. Shipping Fee calculation (Free over ৳2,500 threshold)
		$free_shipping_threshold = 2500.0;
		$is_free_shipping        = $order_subtotal >= $free_shipping_threshold;

		if ( $is_free_shipping ) {
			$delivery_fee   = 0.0;
			$shipping_title = ( 'inside' === $delivery_zone )
				? __( 'Inside Dhaka Express (Complimentary Privilege)', 'kinboni-pro' )
				: __( 'Outside Dhaka Express (Complimentary Privilege)', 'kinboni-pro' );
		} else {
			if ( 'outside' === $delivery_zone ) {
				$delivery_fee   = 120.0;
				$shipping_title = __( 'Outside Dhaka City Express Delivery', 'kinboni-pro' );
			} else {
				$delivery_fee   = 60.0;
				$shipping_title = __( 'Inside Dhaka City Express Delivery', 'kinboni-pro' );
			}
		}

		// 4. Promo code / Privilege voucher discount
		$discount_amount = 0.0;
		$applied_coupon  = '';

		if ( ! empty( $promo_code ) ) {
			// Check if WooCommerce has a native coupon with this code
			$wc_coupon_id = function_exists( 'wc_get_coupon_id_by_code' ) ? wc_get_coupon_id_by_code( $promo_code ) : 0;
			if ( $wc_coupon_id ) {
				$wc_coupon = new \WC_Coupon( $promo_code );
				if ( $wc_coupon->is_valid() ) {
					$applied_coupon = $wc_coupon->get_code();
					if ( 'percent' === $wc_coupon->get_discount_type() ) {
						$discount_amount = round( ( $order_subtotal * (float) $wc_coupon->get_amount() ) / 100 );
					} else {
						$discount_amount = min( $order_subtotal, (float) $wc_coupon->get_amount() );
					}
				}
			}

			// Built-in Atelier VIP Privilege Vouchers fallback
			if ( 0.0 === $discount_amount ) {
				$atelier_promos = [
					'LUXE20'    => 0.20,
					'KINBONI10' => 0.10,
					'WELCOME'   => 0.15,
				];
				if ( isset( $atelier_promos[ $promo_code ] ) ) {
					$applied_coupon  = $promo_code;
					$discount_amount = round( $order_subtotal * $atelier_promos[ $promo_code ] );
				}
			}

			$discount_amount = min( $discount_amount, $order_subtotal );
		}

		// 5. Initialize WooCommerce Order
		$order = wc_create_order( [
			'status'        => 'pending',
			'customer_note' => sprintf(
				__( 'Kinboni Express COD Order. Zone: %s.', 'kinboni-pro' ),
				( 'inside' === $delivery_zone ? 'Inside Dhaka' : 'Outside Dhaka' )
			),
		] );

		if ( is_wp_error( $order ) || ! $order ) {
			throw new \Exception( __( 'Failed to generate WooCommerce order record.', 'kinboni-pro' ) );
		}

		// 6. Add line items to order
		foreach ( $validated_items as $v_item ) {
			$item_id = $order->add_product( $v_item['product'], $v_item['quantity'], [
				'subtotal' => $v_item['line_subtotal'],
				'total'    => $v_item['line_subtotal'],
			] );

			if ( $item_id && is_numeric( $item_id ) ) {
				if ( ! empty( $v_item['color'] ) && 'Standard' !== $v_item['color'] ) {
					wc_add_order_item_meta( $item_id, __( 'Color', 'kinboni-pro' ), $v_item['color'] );
				}
				if ( ! empty( $v_item['size'] ) ) {
					wc_add_order_item_meta( $item_id, __( 'Size', 'kinboni-pro' ), $v_item['size'] );
				}
			}
		}

		// 7. Add Shipping line item
		$shipping_item = new \WC_Order_Item_Shipping();
		$shipping_item->set_method_title( $shipping_title );
		$shipping_item->set_method_id( 'kinboni_cod_flat_rate' );
		$shipping_item->set_total( $delivery_fee );
		$order->add_item( $shipping_item );

		// 8. Add Coupon / Privilege Discount line item
		if ( $discount_amount > 0 && ! empty( $applied_coupon ) ) {
			$coupon_item = new \WC_Order_Item_Coupon();
			$coupon_item->set_code( $applied_coupon );
			$coupon_item->set_discount( $discount_amount );
			$order->add_item( $coupon_item );
		}

		// 9. Billing & Shipping Address
		$city = ( 'inside' === $delivery_zone ) ? 'Dhaka' : 'Outside Dhaka';
		$address_fields = [
			'first_name' => $customer_name,
			'phone'      => $customer_phone,
			'address_1'  => $customer_address,
			'city'       => $city,
			'country'    => 'BD',
		];
		$order->set_address( $address_fields, 'billing' );
		$order->set_address( $address_fields, 'shipping' );

		// 10. Payment Method: Cash on Delivery (COD)
		$order->set_payment_method( 'cod' );
		$order->set_payment_method_title( __( 'Cash on Delivery (COD)', 'kinboni-pro' ) );

		// 11. Calculate final totals & save
		$order->calculate_totals();

		$final_total = max( 0.0, ( $order_subtotal - $discount_amount ) + $delivery_fee );
		$order->set_total( $final_total );

		// Set status to processing
		$order->set_status( 'processing', __( 'Order placed via Kinboni Express COD Checkout.', 'kinboni-pro' ) );
		$order->save();

		// 12. Reduce stock levels
		if ( function_exists( 'wc_reduce_stock_levels' ) ) {
			wc_reduce_stock_levels( $order->get_id() );
		}

		// 13. Build WhatsApp confirmation link
		$settings  = class_exists( 'Kinboni_Admin' ) ? Kinboni_Admin::get_settings() : [];
		$wa_raw    = ! empty( $settings['whatsapp_number'] ) ? $settings['whatsapp_number'] : '+8801700000000';
		$wa_clean  = preg_replace( '/[^0-9]/', '', $wa_raw );
		if ( empty( $wa_clean ) ) {
			$wa_clean = '8801700000000';
		}

		$items_text_list = [];
		foreach ( $validated_items as $vi ) {
			$items_text_list[] = sprintf( '%s (Qty: %d)', $vi['name'], $vi['quantity'] );
		}
		$items_summary = implode( "\n", $items_text_list );

		$formatted_total_str = self::format_price( $final_total );
		$plain_total_str     = html_entity_decode( wp_strip_all_tags( $formatted_total_str ), ENT_QUOTES, 'UTF-8' );

		$wa_msg = sprintf(
			"Hello Kinboni Atelier! I have placed a Cash on Delivery order:\n\nOrder Reference: #%s\nName: %s\nPhone: %s\nAddress: %s\nDelivery Zone: %s\nItems:\n%s\nTotal Payable: %s (Cash on Delivery)\n\nPlease confirm and dispatch promptly.",
			$order->get_order_number(),
			$customer_name,
			$customer_phone,
			$customer_address,
			( 'inside' === $delivery_zone ? 'Inside Dhaka' : 'Outside Dhaka' ),
			$items_summary,
			$plain_total_str
		);

		$whatsapp_url = 'https://wa.me/' . $wa_clean . '?text=' . rawurlencode( $wa_msg );

		return [
			'success'          => true,
			'order_id'         => $order->get_id(),
			'order_number'     => $order->get_order_number(),
			'customer_name'    => $customer_name,
			'customer_phone'   => $customer_phone,
			'customer_address' => $customer_address,
			'delivery_zone'    => $delivery_zone,
			'subtotal'         => $order_subtotal,
			'delivery_fee'     => $delivery_fee,
			'discount'         => $discount_amount,
			'total'            => $final_total,
			'formatted_total'  => $plain_total_str,
			'whatsapp_url'     => $whatsapp_url,
			'message'          => sprintf( __( 'Order #%s placed successfully! Thank you for choosing Kinboni.', 'kinboni-pro' ), $order->get_order_number() ),
		];
	}
}

