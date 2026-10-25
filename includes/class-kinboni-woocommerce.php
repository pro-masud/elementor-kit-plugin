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
		// Future: add WC-specific hooks here.
		// Example:
		// add_filter( 'woocommerce_add_to_cart_fragments', [ __CLASS__, 'cart_fragments' ] );
	}

	/**
	 * Ensure WooCommerce cart & session are loaded (needed in AJAX context).
	 */
	public static function ensure_cart_loaded(): void {
		if ( ! function_exists( 'WC' ) ) {
			return;
		}

		if ( ! did_action( 'woocommerce_init' ) || ! did_action( 'woocommerce_after_register_taxonomy' ) ) {
			return;
		}

		if ( is_null( WC()->session ) ) {
			WC()->session = new \WC_Session_Handler();
			WC()->session->init();
		}
		if ( is_null( WC()->customer ) ) {
			WC()->customer = new \WC_Customer( get_current_user_id(), true );
		}
		if ( is_null( WC()->cart ) ) {
			WC()->cart = new \WC_Cart();
			WC()->cart->get_cart();
		}
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

			$product = wc_get_product( $product_id );

			// Intelligent Fallback 1: Resolve by Demo SKU if ID is a demo index (1..12)
			if ( ! $product && $product_id <= 12 && function_exists( 'wc_get_product_id_by_sku' ) ) {
				$demo_sku  = sprintf( 'KB-DEMO-%02d', $product_id );
				$mapped_id = wc_get_product_id_by_sku( $demo_sku );
				if ( $mapped_id ) {
					$product    = wc_get_product( $mapped_id );
					$product_id = $mapped_id;
				}
			}

			// Intelligent Fallback 2: Resolve by Product Title
			if ( ! $product && ! empty( $raw_item['name'] ) ) {
				$matched_post = get_page_by_title( sanitize_text_field( $raw_item['name'] ), OBJECT, 'product' );
				if ( $matched_post ) {
					$product    = wc_get_product( $matched_post->ID );
					$product_id = $matched_post->ID;
				}
			}

			// Intelligent Fallback 3: Resolve by index among published WooCommerce products
			if ( ! $product && function_exists( 'wc_get_products' ) ) {
				$available_products = wc_get_products( [ 'limit' => 12, 'status' => 'publish' ] );
				if ( ! empty( $available_products ) ) {
					$target_index = ( $product_id > 0 && $product_id <= count( $available_products ) )
						? ( $product_id - 1 )
						: 0;
					$product    = $available_products[ $target_index ];
					$product_id = $product->get_id();
				}
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

