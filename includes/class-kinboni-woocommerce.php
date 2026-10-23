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
}

