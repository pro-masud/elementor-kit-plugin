<?php
namespace KinboniPro\Widgets;

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
	return;
}

class Widget_Featured extends \Elementor\Widget_Base {

	/* ─── Identity ──────────────────────────────────────────── */

	public function get_name(): string {
		return 'kinboni_featured';
	}

	public function get_title(): string {
		return __( 'KINBONI — Featured Creations Showcase', 'kinboni-pro' );
	}

	public function get_icon(): string {
		return 'eicon-featured-image';
	}

	public function get_categories(): array {
		return [ 'kinboni' ];
	}

	public function get_keywords(): array {
		return [ 'kinboni', 'featured', 'products', 'shop', 'grid', 'showcase', 'woocommerce', 'catalog', 'atelier', 'luxury' ];
	}

	public function get_script_depends(): array {
		return [ 'lucide-icons', 'kinboni-pro', 'kinboni-app' ];
	}

	public function get_style_depends(): array {
		return [ 'kinboni-fonts', 'kinboni-output', 'kinboni-pro' ];
	}

	/* ─── Controls ──────────────────────────────────────────── */

	protected function register_controls(): void {

		/* ══════════════════════════════════════════════
		   1. SECTION HEADER
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_header', [
			'label' => __( 'Section Header', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'subtitle_tag', [
			'label'   => __( 'Subtitle Tag', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => __( 'Atelier Curations', 'kinboni-pro' ),
		] );

		$this->add_control( 'title', [
			'label'       => __( 'Main Headline (H2)', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => __( 'Featured Creations', 'kinboni-pro' ),
			'label_block' => true,
		] );

		$this->add_control( 'show_gold_bar', [
			'label'        => __( 'Show Gold Accent Line', 'kinboni-pro' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'description', [
			'label'       => __( 'Description Copy', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXTAREA,
			'rows'        => 2,
			'default'     => __( 'Hand-inspected, individually serial-numbered, and ready for complimentary white-glove dispatch.', 'kinboni-pro' ),
			'label_block' => true,
		] );

		$this->add_control( 'section_id', [
			'label'       => __( 'Section Anchor ID', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'featured',
			'description' => __( 'ID used for direct anchor links and smooth scrolling (e.g. #featured).', 'kinboni-pro' ),
		] );

		$this->end_controls_section();


		/* ══════════════════════════════════════════════
		   2. CATALOG ENGINE & GRID SETTINGS
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_catalog_settings', [
			'label' => __( 'Catalog Engine & Grid Settings', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'catalog_source', [
			'label'   => __( 'Product Source', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'demo',
			'options' => [
				'demo' => __( 'Atelier Editorial Demo Catalog (Instant 0ms, 8 Handcrafted Pieces)', 'kinboni-pro' ),
				'wc'   => __( 'Live WooCommerce Catalog (Authoritative Storefront)', 'kinboni-pro' ),
			],
		] );

		$this->add_control( 'wc_featured_only', [
			'label'        => __( 'Only Show Featured Products', 'kinboni-pro' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
			'description'  => __( 'Filters WooCommerce products marked as Featured in Products > All Products.', 'kinboni-pro' ),
			'condition'    => [ 'catalog_source' => 'wc' ],
		] );

		$this->add_control( 'wc_limit', [
			'label'     => __( 'Products to Display', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::NUMBER,
			'default'   => 8,
			'min'       => 1,
			'max'       => 32,
			'condition' => [ 'catalog_source' => 'wc' ],
		] );

		$this->add_control( 'wc_orderby', [
			'label'     => __( 'Order By', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::SELECT,
			'default'   => 'date',
			'options'   => [
				'date'       => __( 'Date (Newest First)', 'kinboni-pro' ),
				'popularity' => __( 'Popularity / Total Sales', 'kinboni-pro' ),
				'rating'     => __( 'Average Rating', 'kinboni-pro' ),
				'rand'       => __( 'Random', 'kinboni-pro' ),
			],
			'condition' => [ 'catalog_source' => 'wc' ],
		] );

		$this->add_responsive_control( 'grid_columns', [
			'label'     => __( 'Grid Columns (Desktop)', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::SELECT,
			'default'   => '4',
			'options'   => [
				'2' => __( '2 Columns', 'kinboni-pro' ),
				'3' => __( '3 Columns', 'kinboni-pro' ),
				'4' => __( '4 Columns (Default)', 'kinboni-pro' ),
			],
		] );

		$this->add_control( 'show_rating', [
			'label'        => __( 'Show Rating Stars', 'kinboni-pro' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'show_wishlist', [
			'label'        => __( 'Show Wishlist Button', 'kinboni-pro' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'show_quick_view', [
			'label'        => __( 'Show Quick View Button', 'kinboni-pro' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'show_buy_now', [
			'label'        => __( 'Show Direct "Order Now" Button', 'kinboni-pro' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->end_controls_section();


		/* ══════════════════════════════════════════════
		   STYLE TAB: SECTION HEADER
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_style_header', [
			'label' => __( 'Section Header', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'tag_color', [
			'label'     => __( 'Subtitle Tag Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-featured-tag' => 'color: {{VALUE}} !important;' ],
		] );

		$this->add_control( 'title_color', [
			'label'     => __( 'Headline Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-featured-title' => 'color: {{VALUE}} !important;' ],
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typo',
				'label'    => __( 'Headline Typography', 'kinboni-pro' ),
				'selector' => '{{WRAPPER}} .kb-featured-title',
			]
		);

		$this->add_control( 'gold_bar_color', [
			'label'     => __( 'Gold Bar Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-featured-gold-bar' => 'background-color: {{VALUE}} !important;' ],
		] );

		$this->add_control( 'desc_color', [
			'label'     => __( 'Description Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-featured-desc' => 'color: {{VALUE}} !important;' ],
		] );

		$this->end_controls_section();


		/* ══════════════════════════════════════════════
		   STYLE TAB: PRODUCT CARDS
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_style_cards', [
			'label' => __( 'Product Cards & Action Buttons', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'card_bg', [
			'label'     => __( 'Card Background Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-product-card' => 'background-color: {{VALUE}} !important;' ],
		] );

		$this->add_control( 'card_border', [
			'label'     => __( 'Card Border Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-product-card' => 'border-color: {{VALUE}} !important;' ],
		] );

		$this->add_control( 'product_title_color', [
			'label'     => __( 'Product Title Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-product-title' => 'color: {{VALUE}} !important;' ],
		] );

		$this->add_control( 'product_price_color', [
			'label'     => __( 'Product Price Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-product-price' => 'color: {{VALUE}} !important;' ],
		] );

		$this->add_control( 'cta_btn_bg', [
			'label'     => __( 'Order Now Button Background', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#c5a059',
			'selectors' => [ '{{WRAPPER}} .kb-btn-ordernow' => 'background-color: {{VALUE}} !important;' ],
		] );

		$this->add_control( 'cta_btn_text', [
			'label'     => __( 'Order Now Button Text Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#0c0a09',
			'selectors' => [ '{{WRAPPER}} .kb-btn-ordernow' => 'color: {{VALUE}} !important;' ],
		] );

		$this->end_controls_section();
	}

	/* ─── Render ────────────────────────────────────────────── */

	protected function render(): void {
		$s = $this->get_settings_for_display();

		$section_id = ! empty( $s['section_id'] ) ? esc_attr( $s['section_id'] ) : 'featured';
		$source     = $s['catalog_source'] ?? 'demo';
		$widget_id  = $this->get_id();

		// Grid columns class
		$cols = $s['grid_columns'] ?? '4';
		$col_class = 'xl:grid-cols-4';
		if ( '3' === $cols ) {
			$col_class = 'xl:grid-cols-3';
		} elseif ( '2' === $cols ) {
			$col_class = 'xl:grid-cols-2';
		}

		$show_rating     = ( 'yes' === ( $s['show_rating'] ?? 'yes' ) );
		$show_wishlist   = ( 'yes' === ( $s['show_wishlist'] ?? 'yes' ) );
		$show_quick_view = ( 'yes' === ( $s['show_quick_view'] ?? 'yes' ) );
		$show_buy_now    = ( 'yes' === ( $s['show_buy_now'] ?? 'yes' ) );
		?>

		<section id="<?php echo $section_id; ?>" class="kb-featured-section py-16 sm:py-24 scroll-mt-24">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				
				<!-- Section Header -->
				<div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
					<div>
						<?php if ( ! empty( $s['subtitle_tag'] ) ) : ?>
							<span class="kb-featured-tag text-xs font-bold uppercase tracking-[0.25em] text-gold-600 dark:text-gold-400">
								<?php echo esc_html( $s['subtitle_tag'] ); ?>
							</span>
						<?php endif; ?>

						<?php if ( ! empty( $s['title'] ) ) : ?>
							<h2 class="kb-featured-title font-serif text-3xl sm:text-4xl font-medium text-stone-900 dark:text-white mt-1">
								<?php echo esc_html( $s['title'] ); ?>
							</h2>
						<?php endif; ?>

						<?php if ( 'yes' === ( $s['show_gold_bar'] ?? 'yes' ) ) : ?>
							<div class="kb-featured-gold-bar w-12 h-0.5 bg-gold-500 mt-3"></div>
						<?php endif; ?>
					</div>

					<?php if ( ! empty( $s['description'] ) ) : ?>
						<p class="kb-featured-desc mt-4 md:mt-0 text-sm text-stone-600 dark:text-stone-400 max-w-md font-light">
							<?php echo esc_html( $s['description'] ); ?>
						</p>
					<?php endif; ?>
				</div>

				<!-- Responsive Grid for 8 Featured Products -->
				<div id="featured-products-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 <?php echo esc_attr( $col_class ); ?> gap-6 sm:gap-8">
					<?php
					if ( 'wc' === $source && function_exists( 'wc_get_products' ) ) {
						$wc_limit = ! empty( $s['wc_limit'] ) ? absint( $s['wc_limit'] ) : 8;
						$orderby  = ! empty( $s['wc_orderby'] ) ? sanitize_key( $s['wc_orderby'] ) : 'date';

						$query_args = [
							'status'  => 'publish',
							'limit'   => $wc_limit,
							'return'  => 'objects',
						];

						if ( 'yes' === ( $s['wc_featured_only'] ?? 'yes' ) ) {
							$query_args['featured'] = true;
						}

						if ( 'popularity' === $orderby ) {
							$query_args['orderby'] = 'total_sales';
							$query_args['order']   = 'DESC';
						} elseif ( 'rating' === $orderby ) {
							$query_args['orderby'] = 'meta_value_num';
							$query_args['meta_key'] = '_wc_average_rating';
							$query_args['order']   = 'DESC';
						} elseif ( 'rand' === $orderby ) {
							$query_args['orderby'] = 'rand';
						} else {
							$query_args['orderby'] = 'date';
							$query_args['order']   = 'DESC';
						}

						$products = wc_get_products( $query_args );

						// Fallback if no featured products found
						if ( empty( $products ) && 'yes' === ( $s['wc_featured_only'] ?? 'yes' ) ) {
							unset( $query_args['featured'] );
							$products = wc_get_products( $query_args );
						}

						if ( ! empty( $products ) ) {
							$curr = function_exists( 'get_woocommerce_currency_symbol' ) ? get_woocommerce_currency_symbol() : '৳';
							foreach ( $products as $product ) {
								$pid       = $product->get_id();
								$pname     = $product->get_name();
								$raw_price = (float) $product->get_price();
								$reg_price = (float) $product->get_regular_price();
								$discount  = ( $reg_price > $raw_price && $reg_price > 0 ) ? round( ( ( $reg_price - $raw_price ) / $reg_price ) * 100 ) : 0;

								$img_id      = $product->get_image_id();
								$img_url     = $img_id ? wp_get_attachment_image_url( $img_id, 'large' ) : ( function_exists( 'wc_placeholder_img_src' ) ? wc_placeholder_img_src( 'large' ) : '' );
								$gallery_ids = $product->get_gallery_image_ids();
								$hover_url   = ! empty( $gallery_ids ) ? wp_get_attachment_image_url( $gallery_ids[0], 'large' ) : $img_url;

								$cats     = wp_get_post_terms( $pid, 'product_cat' );
								$cat_name = ( ! empty( $cats ) && ! is_wp_error( $cats ) ) ? $cats[0]->name : __( 'Fine Collection', 'kinboni-pro' );
								$cat_slug = ( ! empty( $cats ) && ! is_wp_error( $cats ) ) ? $cats[0]->slug : 'all';

								$avg_rating = $product->get_average_rating() ? (float) $product->get_average_rating() : 5.0;
								$rev_count  = $product->get_review_count() ?: 24;

								$product_payload = [
									'id'            => $pid,
									'name'          => $pname,
									'price'         => $raw_price,
									'formattedPrice'=> $curr . number_format( $raw_price ),
									'originalPrice' => $reg_price > $raw_price ? $reg_price : null,
									'badge'         => $cat_name,
									'categoryLabel' => $cat_name,
									'image'         => $img_url,
									'hoverImage'    => $hover_url,
									'description'   => wp_strip_all_tags( $product->get_short_description() ?: $product->get_description() ),
									'rating'        => $avg_rating,
									'reviewsCount'  => $rev_count,
								];
								$json_payload = wp_json_encode( $product_payload );
								?>
								<div class="kb-product-card group relative flex flex-col bg-white dark:bg-stone-900 border border-stone-200/80 dark:border-stone-800 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl hover:border-gold-500/40 dark:hover:border-gold-500/40 transition-all duration-500"
									 data-product-id="<?php echo esc_attr( $pid ); ?>"
									 data-category="<?php echo esc_attr( $cat_slug ); ?>">

									<!-- Image Container -->
									<div class="relative w-full aspect-[4/5] bg-stone-100 dark:bg-stone-950 overflow-hidden cursor-pointer"
										 data-product="<?php echo esc_attr( $json_payload ); ?>"
										 onclick="if(window.QuickViewController) QuickViewController.openProduct(this);">
										<img 
											src="<?php echo esc_url( $img_url ); ?>" 
											alt="<?php echo esc_attr( $pname ); ?>" 
											loading="lazy"
											class="w-full h-full object-cover object-center transition-all duration-700 ease-out group-hover:scale-105"
											style="height: 100% !important; width: 100% !important; object-fit: cover !important;"
										/>
										<img 
											src="<?php echo esc_url( $hover_url ); ?>" 
											alt="<?php echo esc_attr( $pname ); ?> alternate" 
											loading="lazy"
											class="absolute inset-0 w-full h-full object-cover object-center opacity-0 transition-opacity duration-700 ease-out group-hover:opacity-100 group-hover:scale-105 pointer-events-none"
											style="height: 100% !important; width: 100% !important; object-fit: cover !important;"
										/>

										<!-- Badges -->
										<div class="absolute top-3 left-3 flex flex-col gap-1.5 z-10 pointer-events-none">
											<span class="inline-block px-2.5 py-1 text-[9px] font-bold uppercase tracking-[0.2em] rounded-full bg-stone-950/90 text-stone-100 dark:bg-white/95 dark:text-stone-950 shadow-md backdrop-blur-sm border border-white/10 dark:border-stone-900/10">
												<?php echo esc_html( $cat_name ); ?>
											</span>
											<?php if ( $discount > 0 ) : ?>
												<span class="inline-block px-2 py-0.5 text-[9px] font-bold tracking-wider rounded-full bg-rose-600 text-white shadow-md">
													-<?php echo esc_html( $discount ); ?>%
												</span>
											<?php endif; ?>
										</div>

										<!-- Wishlist Button -->
										<?php if ( $show_wishlist ) : ?>
											<button 
												type="button"
												onclick="event.stopPropagation(); if(window.WishlistController) WishlistController.toggle(<?php echo esc_attr( $pid ); ?>);"
												aria-label="<?php esc_attr_e( 'Save to wishlist', 'kinboni-pro' ); ?>"
												class="absolute top-3 right-3 z-10 w-9 h-9 rounded-full bg-white/90 dark:bg-stone-900/90 backdrop-blur-md border border-stone-200/80 dark:border-stone-700/80 flex items-center justify-center text-stone-700 dark:text-stone-200 hover:text-rose-500 dark:hover:text-rose-400 hover:scale-110 active:scale-90 transition-all shadow-sm group/wishbtn"
											>
												<svg class="w-4 h-4 fill-transparent transition-colors" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
													<path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
												</svg>
											</button>
										<?php endif; ?>

										<!-- Quick View Action Button (Desktop Hover) -->
										<?php if ( $show_quick_view ) : ?>
											<div class="absolute inset-x-3 bottom-3 z-10 opacity-0 translate-y-3 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300 hidden sm:block">
												<button 
													type="button" 
													data-product="<?php echo esc_attr( $json_payload ); ?>"
													onclick="event.stopPropagation(); if(window.QuickViewController) QuickViewController.openProduct(this);"
													class="w-full py-2.5 px-4 bg-white/95 dark:bg-stone-900/95 backdrop-blur-md hover:bg-gold-400 hover:text-stone-950 dark:hover:bg-gold-400 dark:hover:text-stone-950 text-stone-900 dark:text-stone-100 text-[11px] font-bold uppercase tracking-widest rounded-xl shadow-lg transition-all flex items-center justify-center gap-2"
												>
													<i data-lucide="eye" class="w-4 h-4"></i>
													<span><?php esc_html_e( 'Quick View', 'kinboni-pro' ); ?></span>
												</button>
											</div>
										<?php endif; ?>
									</div>

									<!-- Card Details -->
									<div class="p-4 sm:p-5 flex flex-col flex-grow">
										<!-- Category & Rating -->
										<div class="flex items-center justify-between gap-2 mb-2 min-w-0">
											<span class="text-[10px] sm:text-[11px] uppercase tracking-wider font-bold text-gold-600 dark:text-gold-400 truncate">
												<?php echo esc_html( $cat_name ); ?>
											</span>
											<?php if ( $show_rating ) : ?>
												<div class="flex items-center gap-1 text-[11px] font-bold text-stone-700 dark:text-stone-300 flex-shrink-0">
													<i data-lucide="star" class="w-3.5 h-3.5 fill-amber-400 text-amber-400"></i>
													<span><?php echo number_format( $avg_rating, 1 ); ?></span>
												</div>
											<?php endif; ?>
										</div>

										<!-- Title -->
										<h3 class="kb-product-title font-serif text-sm sm:text-base font-medium text-stone-900 dark:text-stone-100 leading-snug line-clamp-2 min-h-[2.5rem] sm:min-h-[2.75rem] mb-2 group-hover:text-gold-600 dark:group-hover:text-gold-400 transition-colors">
											<a href="javascript:void(0)" onclick="if(window.QuickViewController) QuickViewController.openProduct(this.closest('.kb-product-card').querySelector('[data-product]'));">
												<?php echo esc_html( $pname ); ?>
											</a>
										</h3>

										<!-- Price Container -->
										<div class="flex items-baseline gap-2 mb-3">
											<span class="kb-product-price font-serif text-base sm:text-lg font-bold text-stone-900 dark:text-white">
												<?php echo esc_html( $curr . number_format( $raw_price ) ); ?>
											</span>
											<?php if ( $reg_price > $raw_price ) : ?>
												<span class="text-xs text-stone-400 dark:text-stone-500 line-through font-normal">
													<?php echo esc_html( $curr . number_format( $reg_price ) ); ?>
												</span>
												<span class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400 ml-auto">
													<?php echo esc_html( sprintf( __( 'Save %s', 'kinboni-pro' ), $curr . number_format( $reg_price - $raw_price ) ) ); ?>
												</span>
											<?php endif; ?>
										</div>

										<!-- Action Buttons Flex Layout -->
										<div class="flex items-center gap-2 mt-auto pt-3 border-t border-stone-100 dark:border-stone-800/80">
											<button 
												type="button" 
												onclick="if(window.registerProduct) registerProduct(<?php echo esc_attr( $json_payload ); ?>); if(window.CartController) CartController.add(<?php echo esc_attr( $pid ); ?>, 1);"
												class="flex-1 py-2.5 px-2 rounded-xl bg-stone-100 dark:bg-stone-800 hover:bg-stone-200 dark:hover:bg-stone-700 text-stone-900 dark:text-stone-100 text-xs font-semibold transition-all duration-200 flex items-center justify-center gap-1.5 active:scale-95"
												title="<?php esc_attr_e( 'Add to shopping bag', 'kinboni-pro' ); ?>"
											>
												<i data-lucide="shopping-bag" class="w-3.5 h-3.5 flex-shrink-0 text-stone-600 dark:text-stone-300"></i>
												<span class="whitespace-nowrap"><?php esc_html_e( 'Add to Bag', 'kinboni-pro' ); ?></span>
											</button>

											<?php if ( $show_buy_now ) : ?>
												<button 
													type="button" 
													onclick="if(window.registerProduct) registerProduct(<?php echo esc_attr( $json_payload ); ?>); if(window.CartController) CartController.buyNow(<?php echo esc_attr( $pid ); ?>);"
													class="kb-btn-ordernow flex-1 py-2.5 px-2 rounded-xl bg-gold-400 hover:bg-gold-500 text-stone-950 text-xs font-bold transition-all duration-200 flex items-center justify-center gap-1.5 shadow-sm hover:shadow-gold-500/25 active:scale-95"
													title="<?php esc_attr_e( 'Direct Order with Cash on Delivery', 'kinboni-pro' ); ?>"
												>
													<i data-lucide="zap" class="w-3.5 h-3.5 fill-stone-950 flex-shrink-0"></i>
													<span class="whitespace-nowrap"><?php esc_html_e( 'Order Now', 'kinboni-pro' ); ?></span>
												</button>
											<?php endif; ?>
										</div>

									</div>

								</div>
								<?php
							}
						}
					} else {
						// Fallback Server-Side Demo Output (Pre-Hydrated for 0ms SEO & Instant Visual Load)
						$demo_featured = [
							[
								'id' => 1, 'name' => 'Chronos Royale Automatic', 'cat' => 'Timepieces', 'price' => '৳18,500', 'orig' => '৳22,000', 'badge' => 'BESTSELLER',
								'img' => 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?auto=format&fit=crop&w=800&q=80',
								'hover' => 'https://images.unsplash.com/photo-1524805444758-089113d48a6d?auto=format&fit=crop&w=800&q=80',
							],
							[
								'id' => 2, 'name' => 'Atelier Saddle Leather Briefcase', 'cat' => 'Leather Goods', 'price' => '৳14,200', 'orig' => '৳16,800', 'badge' => 'NEW',
								'img' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&w=800&q=80',
								'hover' => 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?auto=format&fit=crop&w=800&q=80',
							],
							[
								'id' => 3, 'name' => 'Nocturne Oud Extrait De Parfum', 'cat' => 'Fine Fragrance', 'price' => '৳8,900', 'orig' => null, 'badge' => 'SIGNATURE',
								'img' => 'https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?auto=format&fit=crop&w=800&q=80',
								'hover' => 'https://images.unsplash.com/photo-1523293182086-7651a899d37f?auto=format&fit=crop&w=800&q=80',
							],
							[
								'id' => 4, 'name' => 'Aethelgard 18K Minimalist Cuff', 'cat' => 'Fine Jewelry', 'price' => '৳6,400', 'orig' => '৳7,500', 'badge' => 'LIMITED',
								'img' => 'https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?auto=format&fit=crop&w=800&q=80',
								'hover' => 'https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?auto=format&fit=crop&w=800&q=80',
							],
							[
								'id' => 5, 'name' => 'Monaco Polarized Acetate Shades', 'cat' => 'Eyewear', 'price' => '৳5,200', 'orig' => null, 'badge' => null,
								'img' => 'https://images.unsplash.com/photo-1511499767150-a48a237f0083?auto=format&fit=crop&w=800&q=80',
								'hover' => 'https://images.unsplash.com/photo-1572635196237-14b3f281503f?auto=format&fit=crop&w=800&q=80',
							],
							[
								'id' => 6, 'name' => 'Kyoto Mulberry Silk Foulard', 'cat' => 'Silk & Cashmere', 'price' => '৳4,800', 'orig' => '৳5,600', 'badge' => 'ARTISANAL',
								'img' => 'https://images.unsplash.com/photo-1601924994987-69e26d50dc26?auto=format&fit=crop&w=800&q=80',
								'hover' => 'https://images.unsplash.com/photo-1584917865442-de89df76afd3?auto=format&fit=crop&w=800&q=80',
							],
							[
								'id' => 7, 'name' => 'Heritage Bi-Fold Card Wallet', 'cat' => 'Leather Goods', 'price' => '৳3,200', 'orig' => '৳3,900', 'badge' => 'BESTSELLER',
								'img' => 'https://images.unsplash.com/photo-1627123424574-724758594e93?auto=format&fit=crop&w=800&q=80',
								'hover' => 'https://images.unsplash.com/photo-1607604276583-eef5d076aa5f?auto=format&fit=crop&w=800&q=80',
							],
							[
								'id' => 8, 'name' => 'Sylvan Vetiver Botanical Parfum', 'cat' => 'Fine Fragrance', 'price' => '৳9,500', 'orig' => null, 'badge' => 'NEW',
								'img' => 'https://images.unsplash.com/photo-1547887537-6158d64c35b3?auto=format&fit=crop&w=800&q=80',
								'hover' => 'https://images.unsplash.com/photo-1594035910387-fea47794261f?auto=format&fit=crop&w=800&q=80',
							],
						];

						foreach ( $demo_featured as $item ) {
							?>
							<div class="kb-product-card group relative flex flex-col bg-white dark:bg-stone-900 border border-stone-200/80 dark:border-stone-800 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl hover:border-gold-500/40 dark:hover:border-gold-500/40 transition-all duration-500" data-product-id="<?php echo esc_attr( $item['id'] ); ?>">
								
								<!-- Image Container -->
								<div class="relative w-full aspect-[4/5] bg-stone-100 dark:bg-stone-950 overflow-hidden cursor-pointer" onclick="if(window.QuickViewController) QuickViewController.open(<?php echo esc_attr( $item['id'] ); ?>);">
									<img 
										src="<?php echo esc_url( $item['img'] ); ?>" 
										alt="<?php echo esc_attr( $item['name'] ); ?>" 
										loading="lazy"
										class="w-full h-full object-cover object-center transition-all duration-700 ease-out group-hover:scale-105"
										style="height: 100% !important; width: 100% !important; object-fit: cover !important;"
									/>
									<img 
										src="<?php echo esc_url( $item['hover'] ); ?>" 
										alt="<?php echo esc_attr( $item['name'] ); ?> alternate" 
										loading="lazy"
										class="absolute inset-0 w-full h-full object-cover object-center opacity-0 transition-opacity duration-700 ease-out group-hover:opacity-100 group-hover:scale-105 pointer-events-none"
										style="height: 100% !important; width: 100% !important; object-fit: cover !important;"
									/>

									<!-- Badges -->
									<div class="absolute top-3 left-3 flex flex-col gap-1.5 z-10 pointer-events-none">
										<?php if ( ! empty( $item['badge'] ) ) : ?>
											<span class="inline-block px-2.5 py-1 text-[9px] font-bold uppercase tracking-[0.2em] rounded-full bg-stone-950/90 text-stone-100 dark:bg-white/95 dark:text-stone-950 shadow-md backdrop-blur-sm border border-white/10 dark:border-stone-900/10">
												<?php echo esc_html( $item['badge'] ); ?>
											</span>
										<?php endif; ?>
									</div>

									<!-- Wishlist Button -->
									<?php if ( $show_wishlist ) : ?>
										<button 
											type="button"
											onclick="event.stopPropagation(); if(window.WishlistController) WishlistController.toggle(<?php echo esc_attr( $item['id'] ); ?>);"
											aria-label="<?php esc_attr_e( 'Save to wishlist', 'kinboni-pro' ); ?>"
											class="absolute top-3 right-3 z-10 w-9 h-9 rounded-full bg-white/90 dark:bg-stone-900/90 backdrop-blur-md border border-stone-200/80 dark:border-stone-700/80 flex items-center justify-center text-stone-700 dark:text-stone-200 hover:text-rose-500 dark:hover:text-rose-400 hover:scale-110 active:scale-90 transition-all shadow-sm group/wishbtn"
										>
											<svg class="w-4 h-4 fill-transparent transition-colors" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
												<path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
											</svg>
										</button>
									<?php endif; ?>

									<!-- Quick View Button -->
									<?php if ( $show_quick_view ) : ?>
										<div class="absolute inset-x-3 bottom-3 z-10 opacity-0 translate-y-3 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300 hidden sm:block">
											<button 
												type="button" 
												onclick="event.stopPropagation(); if(window.QuickViewController) QuickViewController.open(<?php echo esc_attr( $item['id'] ); ?>);"
												class="w-full py-2.5 px-4 bg-white/95 dark:bg-stone-900/95 backdrop-blur-md hover:bg-gold-400 hover:text-stone-950 dark:hover:bg-gold-400 dark:hover:text-stone-950 text-stone-900 dark:text-stone-100 text-[11px] font-bold uppercase tracking-widest rounded-xl shadow-lg transition-all flex items-center justify-center gap-2"
											>
												<i data-lucide="eye" class="w-4 h-4"></i>
												<span><?php esc_html_e( 'Quick View', 'kinboni-pro' ); ?></span>
											</button>
										</div>
									<?php endif; ?>
								</div>

								<!-- Card Details -->
								<div class="p-4 sm:p-5 flex flex-col flex-grow">
									<div class="flex items-center justify-between gap-2 mb-2 min-w-0">
										<span class="text-[10px] sm:text-[11px] uppercase tracking-wider font-bold text-gold-600 dark:text-gold-400 truncate">
											<?php echo esc_html( $item['cat'] ); ?>
										</span>
										<?php if ( $show_rating ) : ?>
											<div class="flex items-center gap-1 text-[11px] font-bold text-stone-700 dark:text-stone-300 flex-shrink-0">
												<i data-lucide="star" class="w-3.5 h-3.5 fill-amber-400 text-amber-400"></i>
												<span>4.9</span>
											</div>
										<?php endif; ?>
									</div>

									<h3 class="kb-product-title font-serif text-sm sm:text-base font-medium text-stone-900 dark:text-stone-100 leading-snug line-clamp-2 min-h-[2.5rem] sm:min-h-[2.75rem] mb-2 group-hover:text-gold-600 dark:group-hover:text-gold-400 transition-colors">
										<a href="javascript:void(0)" onclick="if(window.QuickViewController) QuickViewController.open(<?php echo esc_attr( $item['id'] ); ?>);">
											<?php echo esc_html( $item['name'] ); ?>
										</a>
									</h3>

									<div class="flex items-baseline gap-2 mb-3">
										<span class="kb-product-price font-serif text-base sm:text-lg font-bold text-stone-900 dark:text-white">
											<?php echo esc_html( $item['price'] ); ?>
										</span>
										<?php if ( ! empty( $item['orig'] ) ) : ?>
											<span class="text-xs text-stone-400 dark:text-stone-500 line-through font-normal">
												<?php echo esc_html( $item['orig'] ); ?>
											</span>
										<?php endif; ?>
									</div>

									<div class="flex items-center gap-2 mt-auto pt-3 border-t border-stone-100 dark:border-stone-800/80">
										<button 
											type="button" 
											onclick="if(window.CartController) CartController.add(<?php echo esc_attr( $item['id'] ); ?>, 1);"
											class="flex-1 py-2.5 px-2 rounded-xl bg-stone-100 dark:bg-stone-800 hover:bg-stone-200 dark:hover:bg-stone-700 text-stone-900 dark:text-stone-100 text-xs font-semibold transition-all duration-200 flex items-center justify-center gap-1.5 active:scale-95"
											title="<?php esc_attr_e( 'Add to shopping bag', 'kinboni-pro' ); ?>"
										>
											<i data-lucide="shopping-bag" class="w-3.5 h-3.5 flex-shrink-0 text-stone-600 dark:text-stone-300"></i>
											<span class="whitespace-nowrap"><?php esc_html_e( 'Add to Bag', 'kinboni-pro' ); ?></span>
										</button>

										<?php if ( $show_buy_now ) : ?>
											<button 
												type="button" 
												onclick="if(window.CartController) CartController.buyNow(<?php echo esc_attr( $item['id'] ); ?>);"
												class="kb-btn-ordernow flex-1 py-2.5 px-2 rounded-xl bg-gold-400 hover:bg-gold-500 text-stone-950 text-xs font-bold transition-all duration-200 flex items-center justify-center gap-1.5 shadow-sm hover:shadow-gold-500/25 active:scale-95"
												title="<?php esc_attr_e( 'Direct Order with Cash on Delivery', 'kinboni-pro' ); ?>"
											>
												<i data-lucide="zap" class="w-3.5 h-3.5 fill-stone-950 flex-shrink-0"></i>
												<span class="whitespace-nowrap"><?php esc_html_e( 'Order Now', 'kinboni-pro' ); ?></span>
											</button>
										<?php endif; ?>
									</div>
								</div>

							</div>
							<?php
						}
					}
					?>
				</div>

			</div>
		</section>

		<script>
		(function() {
			function initFeatured<?php echo esc_attr( str_replace( '-', '_', $widget_id ) ); ?>() {
				<?php if ( 'demo' === $source ) : ?>
					if (typeof ProductRenderer !== 'undefined' && ProductRenderer.renderFeatured) {
						ProductRenderer.renderFeatured();
					}
				<?php endif; ?>
				if (typeof lucide !== 'undefined' && lucide.createIcons) {
					lucide.createIcons();
				}
			}
			if (document.readyState === 'loading') {
				document.addEventListener('DOMContentLoaded', initFeatured<?php echo esc_attr( str_replace( '-', '_', $widget_id ) ); ?>);
			} else {
				initFeatured<?php echo esc_attr( str_replace( '-', '_', $widget_id ) ); ?>();
			}
		})();
		</script>
		<?php
	}
}

