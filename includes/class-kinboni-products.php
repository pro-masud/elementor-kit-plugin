<?php
/**
 * Custom Product & Inventory Management Engine
 *
 * Provides a dedicated product management layer that synchronizes seamlessly with
 * native WooCommerce products, lookup tables, and Elementor components.
 *
 * @package KinboniPro
 */

defined( 'ABSPATH' ) || exit;

class Kinboni_Products {

	/**
	 * Demo products specification matching app.js database.
	 */
	const DEMO_PRODUCTS = [
		[
			'id'            => 1,
			'name'          => 'Chronos Royale Automatic',
			'category'      => 'timepieces',
			'categoryLabel' => 'Timepieces',
			'price'         => 18500,
			'originalPrice' => 22000,
			'badge'         => 'BESTSELLER',
			'image'         => 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?auto=format&fit=crop&w=800&q=80',
			'hoverImage'    => 'https://images.unsplash.com/photo-1524805444758-089113d48a6d?auto=format&fit=crop&w=800&q=80',
			'short_desc'    => 'Swiss-precision automatic movement encased in 316L brushed surgical steel with 18k champagne gold indices.',
			'description'   => 'Handcrafted Swiss-precision automatic movement encased in 316L brushed surgical steel with 18k champagne gold indices, exhibition sapphire caseback, and water resistance to 50 meters. Individually numbered in small atelier batches.',
			'specs'         => [ '316L Surgical Grade Steel', 'Double-Domed Sapphire Crystal', '50m Water Resistance', '42-Hour Power Reserve' ],
			'featured'      => true,
			'bestSeller'    => true,
			'onSale'        => true,
		],
		[
			'id'            => 2,
			'name'          => 'Atelier Saddle Leather Briefcase',
			'category'      => 'leather',
			'categoryLabel' => 'Leather Goods',
			'price'         => 14200,
			'originalPrice' => 16800,
			'badge'         => 'NEW',
			'image'         => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&w=800&q=80',
			'hoverImage'    => 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?auto=format&fit=crop&w=800&q=80',
			'short_desc'    => 'Constructed from full-grain Tuscan vegetable-tanned bridle leather with hand-burnished edges.',
			'description'   => 'Constructed from full-grain Tuscan vegetable-tanned bridle leather. Features hand-burnished beveled edges, solid antiqued brass hardware, and dedicated suede-lined 16" laptop sleeve.',
			'specs'         => [ 'Vegetable-Tanned Tuscan Leather', 'Solid Antiqued Brass Hardware', 'Fits up to 16" MacBook Pro', 'Lifetime Craftsmanship Warranty' ],
			'featured'      => true,
			'bestSeller'    => true,
			'onSale'        => true,
		],
		[
			'id'            => 3,
			'name'          => 'Nocturne Oud Extrait De Parfum',
			'category'      => 'fragrance',
			'categoryLabel' => 'Fine Fragrance',
			'price'         => 8900,
			'originalPrice' => 8900,
			'badge'         => 'SIGNATURE',
			'image'         => 'https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?auto=format&fit=crop&w=800&q=80',
			'hoverImage'    => 'https://images.unsplash.com/photo-1523293182086-7651a899d37f?auto=format&fit=crop&w=800&q=80',
			'short_desc'    => 'Wild Cambodian agarwood, Damascus rose absolute, and smoky Bourbon vanilla in 30% concentration extrait.',
			'description'   => 'An intoxicating olfactory voyage featuring wild Cambodian agarwood, Damascus rose absolute, smoky amber resin, and velvety Bourbon vanilla in a 30% concentration extrait decanted in a heavy faceted flacon.',
			'specs'         => [ '30% Oil Concentration (Extrait)', 'Aged Wild Cambodian Oud', '100ml Heavy Faceted Decanter', '12+ Hours Longevity' ],
			'featured'      => true,
			'bestSeller'    => true,
			'onSale'        => false,
		],
		[
			'id'            => 4,
			'name'          => 'Aethelgard 18K Minimalist Cuff',
			'category'      => 'jewelry',
			'categoryLabel' => 'Fine Jewelry',
			'price'         => 6400,
			'originalPrice' => 7500,
			'badge'         => 'LIMITED',
			'image'         => 'https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?auto=format&fit=crop&w=800&q=80',
			'hoverImage'    => 'https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?auto=format&fit=crop&w=800&q=80',
			'short_desc'    => 'Open-cuff silhouette cast in certified 925 sterling silver dipped in 5 microns of 18k yellow gold.',
			'description'   => 'An understated open-cuff silhouette cast in certified recycled 925 sterling silver dipped in 5 microns of 18k yellow gold with a hand-satin brushed finish and polished ergonomic tips.',
			'specs'         => [ '18k Gold Vermeil over 925 Silver', 'Satin Matte with Polished Tips', 'Flexible Ergonomic Fit', 'Hypoallergenic & Nickel-Free' ],
			'featured'      => true,
			'bestSeller'    => true,
			'onSale'        => true,
		],
		[
			'id'            => 5,
			'name'          => 'Monaco Polarized Acetate Shades',
			'category'      => 'eyewear',
			'categoryLabel' => 'Eyewear',
			'price'         => 5200,
			'originalPrice' => 5200,
			'badge'         => '',
			'image'         => 'https://images.unsplash.com/photo-1511499767150-a48a237f0083?auto=format&fit=crop&w=800&q=80',
			'hoverImage'    => 'https://images.unsplash.com/photo-1572635196237-14b3f281503f?auto=format&fit=crop&w=800&q=80',
			'short_desc'    => 'Custom bio-acetate frames hand-cut and tumbled in Japan for 72 hours with Barberini mineral polarized lenses.',
			'description'   => 'Custom bio-acetate frames hand-cut and tumbled in Japan for 72 hours. Fitted with Barberini mineral glass polarized lenses for supreme optical clarity and UV protection.',
			'specs'         => [ 'Japanese Mazzucchelli Bio-Acetate', 'UVA/UVB 400 Polarized Lenses', 'Five-Barrel Teflon Hinges', 'Hand-Stamped Gold Serial Number' ],
			'featured'      => true,
			'bestSeller'    => false,
			'onSale'        => false,
		],
		[
			'id'            => 6,
			'name'          => 'Kyoto Mulberry Silk Foulard',
			'category'      => 'silk',
			'categoryLabel' => 'Silk & Cashmere',
			'price'         => 4800,
			'originalPrice' => 5600,
			'badge'         => 'ARTISANAL',
			'image'         => 'https://images.unsplash.com/photo-1601924994987-69e26d50dc26?auto=format&fit=crop&w=800&q=80',
			'hoverImage'    => 'https://images.unsplash.com/photo-1584917865442-de89df76afd3?auto=format&fit=crop&w=800&q=80',
			'short_desc'    => 'Woven from Grade-6A 100% long-strand mulberry silk in a 16-momme twill weave with hand-rolled edges.',
			'description'   => 'Woven from Grade-6A 100% long-strand mulberry silk in a 16-momme twill weave. Features hand-rolled and hand-stitched edges by master Japanese artisans.',
			'specs'         => [ '100% 6A Mulberry Raw Silk', '16-Momme Heavyweight Twill', '90cm x 90cm Dimensions', 'Hand-Rolled & Stitched Edges' ],
			'featured'      => true,
			'bestSeller'    => true,
			'onSale'        => true,
		],
		[
			'id'            => 7,
			'name'          => 'Heritage Bi-Fold Card Wallet',
			'category'      => 'leather',
			'categoryLabel' => 'Leather Goods',
			'price'         => 3200,
			'originalPrice' => 3900,
			'badge'         => 'BESTSELLER',
			'image'         => 'https://images.unsplash.com/photo-1627123424574-724758594e93?auto=format&fit=crop&w=800&q=80',
			'hoverImage'    => 'https://images.unsplash.com/photo-1607604276583-eef5d076aa5f?auto=format&fit=crop&w=800&q=80',
			'short_desc'    => 'Slimline minimalist card wallet with 6 card slots, currency sleeves, and hand-stitched French linen thread.',
			'description'   => 'Slimline minimalist card wallet with 6 quick-access card slots, two hidden currency sleeves, and hand-stitched French linen thread in full-grain shell cordovan leather.',
			'specs'         => [ 'Full-Grain Shell Cordovan Leather', 'Linen Thread Hand-Stitched', 'Holds 10-12 Cards Comfortably', 'RFID Shielding Layer' ],
			'featured'      => true,
			'bestSeller'    => true,
			'onSale'        => true,
		],
		[
			'id'            => 8,
			'name'          => 'Sylvan Vetiver Botanical Parfum',
			'category'      => 'fragrance',
			'categoryLabel' => 'Fine Fragrance',
			'price'         => 9500,
			'originalPrice' => 9500,
			'badge'         => 'NEW',
			'image'         => 'https://images.unsplash.com/photo-1547887537-6158d64c35b3?auto=format&fit=crop&w=800&q=80',
			'hoverImage'    => 'https://images.unsplash.com/photo-1594035910387-fea47794261f?auto=format&fit=crop&w=800&q=80',
			'short_desc'    => 'Earthy, invigorating composition balancing Haitian vetiver root, bergamot rind, and cedarwood.',
			'description'   => 'An earthy, invigorating fragrance balancing Haitian vetiver root, bergamot rind, crisp cedarwood heart, and sparkling pink peppercorn with magnetic heavy metal closure.',
			'specs'         => [ 'Organic French Extraction', 'Sustainably Harvested Vetiver', 'Magnetic Heavy Metal Cap', 'Unisex Composition' ],
			'featured'      => true,
			'bestSeller'    => false,
			'onSale'        => false,
		],
		[
			'id'            => 9,
			'name'          => 'Vanguard Skeleton Dial Watch',
			'category'      => 'timepieces',
			'categoryLabel' => 'Timepieces',
			'price'         => 24500,
			'originalPrice' => 28000,
			'badge'         => 'LIMITED',
			'image'         => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=800&q=80',
			'hoverImage'    => 'https://images.unsplash.com/photo-1509042239860-f550ce710b93?auto=format&fit=crop&w=800&q=80',
			'short_desc'    => 'Architectural open-worked skeleton movement with Geneva stripes and bespoke alligator leather strap.',
			'description'   => 'An architectural tour-de-force showcasing an open-worked skeleton movement with Geneva stripes, blued screws, and a bespoke alligator leather strap.',
			'specs'         => [ 'Exhibition Caseback with Sapphire', 'Skeletonized 28,800 VPH Calibre', 'Louisiana Alligator Leather Band', 'Individual Serialized Run of 100' ],
			'featured'      => false,
			'bestSeller'    => true,
			'onSale'        => true,
		],
		[
			'id'            => 10,
			'name'          => 'Cypress Minimalist Leather Tote',
			'category'      => 'leather',
			'categoryLabel' => 'Leather Goods',
			'price'         => 11800,
			'originalPrice' => 11800,
			'badge'         => '',
			'image'         => 'https://images.unsplash.com/photo-1590874103328-eac38a683ce7?auto=format&fit=crop&w=800&q=80',
			'hoverImage'    => 'https://images.unsplash.com/photo-1591561954557-26941169b49e?auto=format&fit=crop&w=800&q=80',
			'short_desc'    => 'Unstructured day tote crafted from pebble-grain calfskin with reinforced double-handle drop.',
			'description'   => 'Unstructured day tote crafted from pebble-grain calfskin with reinforced double-handle drop, magnetic top closure, and removable zip pouch.',
			'specs'         => [ 'Soft Grain Italian Calfskin', 'Reinforced Base with Metal Feet', 'Internal Key Leash & Zip Pouch', 'Generous 25L Capacity' ],
			'featured'      => false,
			'bestSeller'    => true,
			'onSale'        => false,
		],
		[
			'id'            => 11,
			'name'          => 'Celeste Pearl Pendant Necklace',
			'category'      => 'jewelry',
			'categoryLabel' => 'Fine Jewelry',
			'price'         => 7800,
			'originalPrice' => 9200,
			'badge'         => 'NEW',
			'image'         => 'https://images.unsplash.com/photo-1599643477877-530eb83abc8e?auto=format&fit=crop&w=800&q=80',
			'hoverImage'    => 'https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?auto=format&fit=crop&w=800&q=80',
			'short_desc'    => 'Luminous AAA South Sea baroque freshwater pearl suspended from a 18k solid gold wheat chain.',
			'description'   => 'A luminous AAA South Sea baroque freshwater pearl suspended from a delicate 18-karat solid gold wheat chain with lobster clasp.',
			'specs'         => [ 'Natural AAA South Sea Baroque Pearl', '18-Inch 18k Solid Gold Chain', 'Each Pearl Uniquely Formed', 'Luxury Velvet Presentation Box' ],
			'featured'      => false,
			'bestSeller'    => true,
			'onSale'        => true,
		],
		[
			'id'            => 12,
			'name'          => 'Soleil Aviator Titanium Shades',
			'category'      => 'eyewear',
			'categoryLabel' => 'Eyewear',
			'price'         => 6800,
			'originalPrice' => 6800,
			'badge'         => '',
			'image'         => 'https://images.unsplash.com/photo-1508296695146-257a814070b4?auto=format&fit=crop&w=800&q=80',
			'hoverImage'    => 'https://images.unsplash.com/photo-1577803645773-f96470509666?auto=format&fit=crop&w=800&q=80',
			'short_desc'    => 'Featherlight aerospace-grade Japanese beta-titanium wire frames with custom teardrop silhouettes.',
			'description'   => 'Featherlight aerospace-grade Japanese beta-titanium wire frames with custom teardrop silhouettes and gradient warm-sepia scratchproof lenses.',
			'specs'         => [ 'Aerospace Grade Beta-Titanium', 'Weight: Only 18 Grams', 'Hypoallergenic Ceramic Nose Pads', '100% Polarization with Anti-Glare' ],
			'featured'      => false,
			'bestSeller'    => true,
			'onSale'        => false,
		],
	];

	/**
	 * Initialize AJAX hooks.
	 */
	public static function init(): void {
		add_action( 'wp_ajax_kinboni_get_products',          [ __CLASS__, 'ajax_get_products' ] );
		add_action( 'wp_ajax_kinboni_get_product',           [ __CLASS__, 'ajax_get_product' ] );
		add_action( 'wp_ajax_kinboni_save_product',          [ __CLASS__, 'ajax_save_product' ] );
		add_action( 'wp_ajax_kinboni_delete_product',        [ __CLASS__, 'ajax_delete_product' ] );
		add_action( 'wp_ajax_kinboni_save_category',         [ __CLASS__, 'ajax_save_category' ] );
		add_action( 'wp_ajax_kinboni_delete_category',       [ __CLASS__, 'ajax_delete_category' ] );
		add_action( 'wp_ajax_kinboni_migrate_demo_products', [ __CLASS__, 'ajax_migrate_demo_products' ] );
	}

	/**
	 * Check administrative capabilities.
	 */
	private static function check_auth(): void {
		check_ajax_referer( 'kinboni_admin_nonce', 'nonce' );
		if ( ! current_user_can( 'manage_woocommerce' ) && ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( [ 'message' => __( 'Permission denied.', 'kinboni-pro' ) ], 403 );
		}
	}

	/**
	 * AJAX: Get paginated list of products for Dashboard table.
	 */
	public static function ajax_get_products(): void {
		self::check_auth();

		$page     = max( 1, absint( $_POST['page'] ?? 1 ) );
		$per_page = max( 5, min( 100, absint( $_POST['per_page'] ?? 10 ) ) );
		$search   = sanitize_text_field( wp_unslash( $_POST['search'] ?? '' ) );
		$category = sanitize_text_field( wp_unslash( $_POST['category'] ?? '' ) );
		$status   = sanitize_text_field( wp_unslash( $_POST['status'] ?? 'any' ) );

		$args = [
			'status'   => 'any' === $status ? [ 'publish', 'draft', 'pending' ] : [ $status ],
			'limit'    => $per_page,
			'page'     => $page,
			'paginate' => true,
			'orderby'  => 'date',
			'order'    => 'DESC',
		];

		if ( ! empty( $search ) ) {
			$args['s'] = $search;
		}

		if ( ! empty( $category ) && 'all' !== $category ) {
			$args['category'] = [ $category ];
		}

		if ( ! function_exists( 'wc_get_products' ) ) {
			wp_send_json_error( [ 'message' => __( 'WooCommerce is not active.', 'kinboni-pro' ) ], 400 );
		}

		$results  = wc_get_products( $args );
		$products = [];
		$curr     = function_exists( 'get_woocommerce_currency_symbol' ) ? get_woocommerce_currency_symbol() : '৳';

		foreach ( $results->products as $p ) {
			$pid      = $p->get_id();
			$img_id   = $p->get_image_id();
			$img_url  = $img_id ? wp_get_attachment_image_url( $img_id, 'thumbnail' ) : ( function_exists( 'wc_placeholder_img_src' ) ? wc_placeholder_img_src( 'thumbnail' ) : '' );
			
			// Categories list
			$terms    = wp_get_post_terms( $pid, 'product_cat' );
			$cat_list = [];
			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
				foreach ( $terms as $t ) {
					$cat_list[] = [ 'id' => $t->term_id, 'name' => $t->name, 'slug' => $t->slug ];
				}
			}

			$products[] = [
				'id'             => $pid,
				'name'           => $p->get_name(),
				'sku'            => $p->get_sku() ?: '—',
				'price'          => (float) $p->get_price(),
				'regular_price'  => (float) $p->get_regular_price(),
				'sale_price'     => (float) $p->get_sale_price(),
				'formatted_price'=> $curr . number_format( (float) $p->get_price() ),
				'stock_status'   => $p->get_stock_status(),
				'stock_quantity' => $p->get_stock_quantity() !== null ? $p->get_stock_quantity() : '∞',
				'status'         => $p->get_status(),
				'featured'       => $p->is_featured(),
				'image'          => $img_url,
				'categories'     => $cat_list,
				'badge'          => get_post_meta( $pid, '_kinboni_badge', true ) ?: '',
				'view_url'       => get_permalink( $pid ),
				'edit_post_url'  => get_edit_post_link( $pid ),
			];
		}

		wp_send_json_success( [
			'products'    => $products,
			'total'       => $results->total,
			'total_pages' => $results->max_num_pages,
			'current_page'=> $page,
		] );
	}

	/**
	 * AJAX: Get full single product data for Edit form.
	 */
	public static function ajax_get_product(): void {
		self::check_auth();

		$product_id = absint( $_POST['product_id'] ?? 0 );
		if ( ! $product_id || ! function_exists( 'wc_get_product' ) ) {
			wp_send_json_error( [ 'message' => __( 'Invalid product ID.', 'kinboni-pro' ) ], 400 );
		}

		$p = wc_get_product( $product_id );
		if ( ! $p ) {
			wp_send_json_error( [ 'message' => __( 'Product not found.', 'kinboni-pro' ) ], 404 );
		}

		$img_id = $p->get_image_id();
		$img_url = $img_id ? wp_get_attachment_image_url( $img_id, 'medium_large' ) : '';

		$gallery_ids = $p->get_gallery_image_ids();
		$gallery = [];
		foreach ( $gallery_ids as $gid ) {
			$gallery[] = [
				'id'  => $gid,
				'url' => wp_get_attachment_image_url( $gid, 'thumbnail' ),
			];
		}

		$hover_id = get_post_meta( $product_id, '_kinboni_hover_image_id', true );
		$hover_url = $hover_id ? wp_get_attachment_image_url( $hover_id, 'medium_large' ) : ( get_post_meta( $product_id, '_kinboni_hover_image_url', true ) ?: '' );

		$cat_ids = $p->get_category_ids();
		$specs   = get_post_meta( $product_id, '_kinboni_specs', true );
		if ( ! is_array( $specs ) ) {
			$specs = ! empty( $specs ) ? (array) json_decode( $specs, true ) : [];
		}

		wp_send_json_success( [
			'id'               => $product_id,
			'name'             => $p->get_name(),
			'slug'             => $p->get_slug(),
			'description'      => $p->get_description(),
			'short_description'=> $p->get_short_description(),
			'regular_price'    => $p->get_regular_price(),
			'sale_price'       => $p->get_sale_price(),
			'sku'              => $p->get_sku(),
			'status'           => $p->get_status(),
			'stock_status'     => $p->get_stock_status(),
			'manage_stock'     => $p->get_manage_stock() ? 'yes' : 'no',
			'stock_quantity'   => $p->get_stock_quantity() !== null ? $p->get_stock_quantity() : '',
			'featured'         => $p->is_featured() ? 'yes' : 'no',
			'categories'       => $cat_ids,
			'badge'            => get_post_meta( $product_id, '_kinboni_badge', true ) ?: '',
			'image_id'         => $img_id,
			'image_url'        => $img_url,
			'hover_image_id'   => $hover_id,
			'hover_image_url'  => $hover_url,
			'gallery'          => $gallery,
			'specs'            => $specs,
		] );
	}

	/**
	 * AJAX: Save or Update Product.
	 */
	public static function ajax_save_product(): void {
		self::check_auth();

		$data = $_POST['product'] ?? [];
		if ( empty( $data ) || ! is_array( $data ) ) {
			wp_send_json_error( [ 'message' => __( 'Invalid product data.', 'kinboni-pro' ) ], 400 );
		}

		$pid = absint( $data['id'] ?? 0 );

		if ( ! class_exists( '\WC_Product_Simple' ) ) {
			wp_send_json_error( [ 'message' => __( 'WooCommerce is not active.', 'kinboni-pro' ) ], 400 );
		}

		if ( $pid > 0 ) {
			$product = wc_get_product( $pid );
			if ( ! $product ) {
				$product = new \WC_Product_Simple();
			}
		} else {
			$product = new \WC_Product_Simple();
		}

		// Core fields
		$name = sanitize_text_field( $data['name'] ?? '' );
		if ( empty( $name ) ) {
			wp_send_json_error( [ 'message' => __( 'Product name is required.', 'kinboni-pro' ) ], 400 );
		}

		$product->set_name( $name );

		if ( ! empty( $data['slug'] ) ) {
			$product->set_slug( sanitize_title( $data['slug'] ) );
		}

		$product->set_description( wp_kses_post( $data['description'] ?? '' ) );
		$product->set_short_description( wp_kses_post( $data['short_description'] ?? '' ) );

		// Status
		$status = sanitize_key( $data['status'] ?? 'publish' );
		$product->set_status( in_array( $status, [ 'publish', 'draft', 'pending' ], true ) ? $status : 'publish' );

		// Pricing
		$regular_price = sanitize_text_field( $data['regular_price'] ?? '' );
		$sale_price    = sanitize_text_field( $data['sale_price'] ?? '' );

		$product->set_regular_price( $regular_price );
		if ( '' !== $sale_price && (float) $sale_price < (float) $regular_price ) {
			$product->set_sale_price( $sale_price );
			$product->set_price( $sale_price );
		} else {
			$product->set_sale_price( '' );
			$product->set_price( $regular_price );
		}

		// SKU & Stock
		if ( isset( $data['sku'] ) ) {
			$sku = sanitize_text_field( $data['sku'] );
			try {
				$product->set_sku( $sku );
			} catch ( \Exception $e ) {
				// Duplicate SKU catch
			}
		}

		$stock_status = in_array( $data['stock_status'] ?? 'instock', [ 'instock', 'outofstock', 'onbackorder' ], true ) ? $data['stock_status'] : 'instock';
		$product->set_stock_status( $stock_status );

		$manage_stock = ( 'yes' === ( $data['manage_stock'] ?? 'no' ) );
		$product->set_manage_stock( $manage_stock );
		if ( $manage_stock && isset( $data['stock_quantity'] ) && '' !== $data['stock_quantity'] ) {
			$product->set_stock_quantity( absint( $data['stock_quantity'] ) );
		}

		// Featured flag
		$product->set_featured( 'yes' === ( $data['featured'] ?? 'no' ) );

		// Categories
		if ( isset( $data['categories'] ) && is_array( $data['categories'] ) ) {
			$cat_ids = array_map( 'absint', $data['categories'] );
			$product->set_category_ids( $cat_ids );
		}

		// Featured Image
		if ( ! empty( $data['image_id'] ) ) {
			$product->set_image_id( absint( $data['image_id'] ) );
		}

		// Gallery
		if ( isset( $data['gallery_ids'] ) && is_array( $data['gallery_ids'] ) ) {
			$gallery_ids = array_map( 'absint', $data['gallery_ids'] );
			$product->set_gallery_image_ids( $gallery_ids );
		}

		// Save WooCommerce product
		$saved_id = $product->save();

		// Custom Atelier Meta
		if ( isset( $data['badge'] ) ) {
			update_post_meta( $saved_id, '_kinboni_badge', sanitize_text_field( $data['badge'] ) );
		}

		if ( ! empty( $data['hover_image_id'] ) ) {
			update_post_meta( $saved_id, '_kinboni_hover_image_id', absint( $data['hover_image_id'] ) );
		} elseif ( ! empty( $data['hover_image_url'] ) ) {
			update_post_meta( $saved_id, '_kinboni_hover_image_url', esc_url_raw( $data['hover_image_url'] ) );
		}

		if ( isset( $data['specs'] ) && is_array( $data['specs'] ) ) {
			$specs = array_map( 'sanitize_text_field', array_filter( $data['specs'] ) );
			update_post_meta( $saved_id, '_kinboni_specs', $specs );
		}

		wp_send_json_success( [
			'message'    => __( 'Product saved and synchronized with WooCommerce.', 'kinboni-pro' ),
			'product_id' => $saved_id,
		] );
	}

	/**
	 * AJAX: Trash / Delete Product.
	 */
	public static function ajax_delete_product(): void {
		self::check_auth();

		$product_id = absint( $_POST['product_id'] ?? 0 );
		if ( ! $product_id || ! function_exists( 'wc_get_product' ) ) {
			wp_send_json_error( [ 'message' => __( 'Invalid product ID.', 'kinboni-pro' ) ], 400 );
		}

		$product = wc_get_product( $product_id );
		if ( ! $product ) {
			wp_send_json_error( [ 'message' => __( 'Product not found.', 'kinboni-pro' ) ], 404 );
		}

		// Move to trash
		$product->delete( false );

		wp_send_json_success( [ 'message' => __( 'Product moved to trash.', 'kinboni-pro' ) ] );
	}

	/**
	 * AJAX: Create or Update Category.
	 */
	public static function ajax_save_category(): void {
		self::check_auth();

		$name = sanitize_text_field( $_POST['name'] ?? '' );
		if ( empty( $name ) ) {
			wp_send_json_error( [ 'message' => __( 'Category name is required.', 'kinboni-pro' ) ], 400 );
		}

		$slug     = sanitize_title( $_POST['slug'] ?? $name );
		$desc     = sanitize_textarea_field( $_POST['description'] ?? '' );
		$thumb_id = absint( $_POST['thumbnail_id'] ?? 0 );
		$cat_id   = absint( $_POST['cat_id'] ?? 0 );

		if ( $cat_id > 0 ) {
			// Update existing
			$res = wp_update_term( $cat_id, 'product_cat', [
				'name'        => $name,
				'slug'        => $slug,
				'description' => $desc,
			] );
			if ( is_wp_error( $res ) ) {
				wp_send_json_error( [ 'message' => $res->get_error_message() ], 400 );
			}
			$term_id = $cat_id;
		} else {
			// Create new
			$res = wp_insert_term( $name, 'product_cat', [
				'slug'        => $slug,
				'description' => $desc,
			] );
			if ( is_wp_error( $res ) ) {
				wp_send_json_error( [ 'message' => $res->get_error_message() ], 400 );
			}
			$term_id = $res['term_id'];
		}

		if ( $thumb_id > 0 ) {
			update_term_meta( $term_id, 'thumbnail_id', $thumb_id );
		}

		wp_send_json_success( [
			'message' => __( 'Product category saved.', 'kinboni-pro' ),
			'term_id' => $term_id,
		] );
	}

	/**
	 * AJAX: Delete Category.
	 */
	public static function ajax_delete_category(): void {
		self::check_auth();

		$term_id = absint( $_POST['term_id'] ?? 0 );
		if ( ! $term_id ) {
			wp_send_json_error( [ 'message' => __( 'Invalid category ID.', 'kinboni-pro' ) ], 400 );
		}

		$res = wp_delete_term( $term_id, 'product_cat' );
		if ( is_wp_error( $res ) || ! $res ) {
			wp_send_json_error( [ 'message' => __( 'Could not delete category.', 'kinboni-pro' ) ], 400 );
		}

		wp_send_json_success( [ 'message' => __( 'Category removed successfully.', 'kinboni-pro' ) ] );
	}

	/**
	 * AJAX: 1-Click Migration of 12 Demo Products from app.js to WooCommerce.
	 */
	public static function ajax_migrate_demo_products(): void {
		self::check_auth();

		if ( ! class_exists( 'WooCommerce' ) || ! class_exists( '\WC_Product_Simple' ) ) {
			wp_send_json_error( [ 'message' => __( 'WooCommerce must be active to import creations.', 'kinboni-pro' ) ], 400 );
		}

		require_once ABSPATH . 'wp-admin/includes/media.php';
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/image.php';

		$category_map = [
			'timepieces' => [ 'name' => 'Timepieces',      'slug' => 'timepieces', 'desc' => 'High horology chronographs & automatic watches.' ],
			'leather'    => [ 'name' => 'Leather Goods',   'slug' => 'leather',    'desc' => 'Tuscan vegetable-tanned full-grain leather goods.' ],
			'fragrance'  => [ 'name' => 'Fine Fragrance',  'slug' => 'fragrance',  'desc' => 'Artisanal extraits de parfum and natural oud decanters.' ],
			'jewelry'    => [ 'name' => 'Fine Jewelry',    'slug' => 'jewelry',    'desc' => '18k gold vermeil and solid precious metal jewelry.' ],
			'eyewear'    => [ 'name' => 'Eyewear',         'slug' => 'eyewear',    'desc' => 'Japanese bio-acetate and beta-titanium shades.' ],
			'silk'       => [ 'name' => 'Silk & Cashmere', 'slug' => 'silk',       'desc' => 'Grade-6A mulberry silk twill and luxury foulards.' ],
		];

		// 1. Ensure Categories exist
		$cat_term_ids = [];
		foreach ( $category_map as $slug => $cdata ) {
			$term = get_term_by( 'slug', $slug, 'product_cat' );
			if ( ! $term ) {
				$new_term = wp_insert_term( $cdata['name'], 'product_cat', [
					'slug'        => $slug,
					'description' => $cdata['desc'],
				] );
				if ( ! is_wp_error( $new_term ) ) {
					$cat_term_ids[ $slug ] = $new_term['term_id'];
				}
			} else {
				$cat_term_ids[ $slug ] = $term->term_id;
			}
		}

		$created_count = 0;
		$updated_count = 0;
		$skipped_count = 0;

		// 2. Import Products with duplicate prevention
		foreach ( self::DEMO_PRODUCTS as $item ) {
			$demo_id = $item['id'];
			$sku     = sprintf( 'KB-DEMO-%02d', $demo_id );

			// Check duplicate by _kinboni_demo_id or SKU
			$existing = wc_get_products( [
				'meta_key'   => '_kinboni_demo_id',
				'meta_value' => $demo_id,
				'limit'      => 1,
			] );

			if ( empty( $existing ) ) {
				$existing = wc_get_products( [
					'sku'   => $sku,
					'limit' => 1,
				] );
			}

			if ( ! empty( $existing ) ) {
				$product = reset( $existing );
				$is_update = true;
			} else {
				$product = new \WC_Product_Simple();
				$is_update = false;
			}

			$product->set_name( $item['name'] );
			$product->set_sku( $sku );
			$product->set_status( 'publish' );
			$product->set_short_description( $item['short_desc'] );
			$product->set_description( $item['description'] );

			// Pricing
			$price = $item['price'];
			$orig  = $item['originalPrice'];
			if ( $orig && $orig > $price ) {
				$product->set_regular_price( $orig );
				$product->set_sale_price( $price );
				$product->set_price( $price );
			} else {
				$product->set_regular_price( $price );
				$product->set_sale_price( '' );
				$product->set_price( $price );
			}

			// Stock
			$product->set_stock_status( 'instock' );
			$product->set_manage_stock( true );
			$product->set_stock_quantity( 15 );

			// Featured
			$product->set_featured( ! empty( $item['featured'] ) );

			// Category
			$cat_slug = $item['category'];
			if ( isset( $cat_term_ids[ $cat_slug ] ) ) {
				$product->set_category_ids( [ $cat_term_ids[ $cat_slug ] ] );
			}

			// Save to generate ID
			$saved_id = $product->save();

			// Custom Meta
			update_post_meta( $saved_id, '_kinboni_demo_id', $demo_id );
			update_post_meta( $saved_id, '_kinboni_badge', $item['badge'] );
			update_post_meta( $saved_id, '_kinboni_specs', $item['specs'] );
			update_post_meta( $saved_id, '_kinboni_hover_image_url', $item['hoverImage'] );

			// Attach images if not already attached
			if ( ! $product->get_image_id() && ! empty( $item['image'] ) ) {
				if ( ! function_exists( 'media_sideload_image' ) ) {
					require_once ABSPATH . 'wp-admin/includes/media.php';
					require_once ABSPATH . 'wp-admin/includes/file.php';
					require_once ABSPATH . 'wp-admin/includes/image.php';
				}
				// Sideload or attach image
				$att_id = media_sideload_image( $item['image'], $saved_id, $item['name'], 'id' );
				if ( ! is_wp_error( $att_id ) && $att_id ) {
					$product->set_image_id( $att_id );
					
					// Sideload hover image as gallery
					if ( ! empty( $item['hoverImage'] ) ) {
						$hover_att = media_sideload_image( $item['hoverImage'], $saved_id, $item['name'] . ' Alternate', 'id' );
						if ( ! is_wp_error( $hover_att ) && $hover_att ) {
							$product->set_gallery_image_ids( [ $hover_att ] );
							update_post_meta( $saved_id, '_kinboni_hover_image_id', $hover_att );
						}
					}
					$product->save();
				}
			}

			if ( $is_update ) {
				$updated_count++;
			} else {
				$created_count++;
			}
		}

		wp_send_json_success( [
			'message' => sprintf(
				__( 'Migration complete: %d created, %d updated. Duplicate prevention guaranteed.', 'kinboni-pro' ),
				$created_count,
				$updated_count
			),
			'created' => $created_count,
			'updated' => $updated_count,
		] );
	}

	/**
	 * Retrieve all product categories for select dropdowns.
	 */
	public static function get_categories_dropdown(): array {
		if ( ! taxonomy_exists( 'product_cat' ) ) {
			return [];
		}

		$terms = get_terms( [
			'taxonomy'   => 'product_cat',
			'hide_empty' => false,
		] );

		$list = [];
		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
			foreach ( $terms as $t ) {
				$list[] = [
					'id'    => $t->term_id,
					'name'  => $t->name,
					'slug'  => $t->slug,
					'count' => $t->count,
				];
			}
		}

		return $list;
	}

	/**
	 * Retrieve all active published storefront products formatted for app.js and storefront widgets.
	 *
	 * @return array<int, array<string, mixed>>
	 */
	public static function get_storefront_products(): array {
		if ( ! function_exists( 'wc_get_products' ) ) {
			return [];
		}

		$products = wc_get_products( [
			'status'   => 'publish',
			'limit'    => 100,
			'orderby'  => 'date',
			'order'    => 'DESC',
		] );

		if ( empty( $products ) ) {
			return [];
		}

		$list = [];
		foreach ( $products as $p ) {
			$pid = $p->get_id();

			// Primary Image
			$img_id = $p->get_image_id();
			$img_url = $img_id ? wp_get_attachment_image_url( $img_id, 'large' ) : ( function_exists( 'wc_placeholder_img_src' ) ? wc_placeholder_img_src( 'large' ) : '' );

			// Hover Image
			$hover_id = get_post_meta( $pid, '_kinboni_hover_image_id', true );
			$hover_url = $hover_id ? wp_get_attachment_image_url( $hover_id, 'large' ) : ( get_post_meta( $pid, '_kinboni_hover_image_url', true ) ?: '' );

			$gallery_ids = $p->get_gallery_image_ids();
			$gallery_urls = [];
			if ( ! empty( $gallery_ids ) ) {
				foreach ( $gallery_ids as $gid ) {
					$g_url = wp_get_attachment_image_url( $gid, 'large' );
					if ( $g_url ) {
						$gallery_urls[] = $g_url;
					}
				}
			}

			if ( empty( $hover_url ) && ! empty( $gallery_urls ) ) {
				$hover_url = $gallery_urls[0];
			}
			if ( empty( $hover_url ) ) {
				$hover_url = $img_url;
			}

			// Ensure combined gallery includes main and hover images for rich multi-thumbnail Quick View
			$combined_gallery = [];
			if ( ! empty( $img_url ) ) {
				$combined_gallery[] = $img_url;
			}
			foreach ( $gallery_urls as $gu ) {
				if ( ! in_array( $gu, $combined_gallery, true ) ) {
					$combined_gallery[] = $gu;
				}
			}
			if ( ! empty( $hover_url ) && ! in_array( $hover_url, $combined_gallery, true ) ) {
				$combined_gallery[] = $hover_url;
			}

			// Categories
			$terms = wp_get_post_terms( $pid, 'product_cat' );
			$cat_slug  = 'all';
			$cat_name  = 'Atelier Collection';
			$cat_slugs = [];
			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
				$first = reset( $terms );
				$cat_slug = $first->slug;
				$cat_name = $first->name;
				foreach ( $terms as $t ) {
					$cat_slugs[] = $t->slug;
				}
			}

			// Prices
			$raw_price  = (float) $p->get_price();
			$reg_price  = (float) $p->get_regular_price();
			$orig_price = ( $reg_price > $raw_price && $reg_price > 0 ) ? $reg_price : null;

			// Badge & Specs
			$badge = get_post_meta( $pid, '_kinboni_badge', true ) ?: ( $p->is_featured() ? 'FEATURED' : '' );
			$specs = get_post_meta( $pid, '_kinboni_specs', true );
			if ( is_string( $specs ) ) {
				$specs = json_decode( $specs, true ) ?: [];
			}
			if ( ! is_array( $specs ) || empty( $specs ) ) {
				$specs = [ 'Certified Atelier Craftsmanship', 'Hand-Inspected Batch', 'White-Glove Dispatch' ];
			}

			$list[] = [
				'id'            => $pid,
				'name'          => $p->get_name(),
				'sku'           => $p->get_sku() ?: 'KB-' . $pid,
				'category'      => $cat_slug,
				'categoryLabel' => $cat_name,
				'categories'    => $cat_slugs,
				'price'         => $raw_price,
				'originalPrice' => $orig_price,
				'rating'        => (float) ( $p->get_average_rating() ?: 5.0 ),
				'reviewsCount'  => (int) ( $p->get_review_count() ?: 18 ),
				'badge'         => $badge,
				'image'         => $img_url,
				'hoverImage'    => $hover_url,
				'gallery'       => $combined_gallery,
				'description'   => $p->get_description() ?: $p->get_short_description(),
				'short_desc'    => $p->get_short_description(),
				'specs'         => array_values( array_filter( $specs ) ),
				'inStock'       => $p->is_in_stock(),
				'featured'      => $p->is_featured(),
				'bestSeller'    => ( 'BESTSELLER' === $badge || $p->is_featured() || (int) $p->get_total_sales() > 0 ),
				'onSale'        => $p->is_on_sale(),
				'permalink'     => get_permalink( $pid ),
			];
		}

		return $list;
	}
}

