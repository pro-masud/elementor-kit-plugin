<?php
namespace KinboniPro\Widgets;

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
	return;
}

class Widget_Bestsellers extends \Elementor\Widget_Base {

	/* ─── Identity ──────────────────────────────────────────── */

	public function get_name(): string {
		return 'kinboni_bestsellers';
	}

	public function get_title(): string {
		return __( 'KINBONI — Best Sellers Showcase', 'kinboni-pro' );
	}

	public function get_icon(): string {
		return 'eicon-products';
	}

	public function get_categories(): array {
		return [ 'kinboni' ];
	}

	public function get_keywords(): array {
		return [ 'kinboni', 'bestsellers', 'products', 'shop', 'grid', 'filter', 'woocommerce', 'catalog', 'luxury' ];
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
			'default' => __( 'Patron Favorites', 'kinboni-pro' ),
		] );

		$this->add_control( 'title', [
			'label'       => __( 'Main Headline (H2)', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => __( 'The Best Sellers', 'kinboni-pro' ),
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
			'default'     => __( 'Filter our most demanded atelier creations by category, recent arrivals, or archive privileges.', 'kinboni-pro' ),
			'label_block' => true,
		] );

		$this->end_controls_section();


		/* ══════════════════════════════════════════════
		   2. CATEGORY FILTER TABS
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_filter_tabs', [
			'label' => __( 'Category Filter Tabs', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'show_filters', [
			'label'        => __( 'Show Filter Tabs', 'kinboni-pro' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$tab_repeater = new \Elementor\Repeater();

		$tab_repeater->add_control( 'tab_label', [
			'label'   => __( 'Tab Label', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'All Creations',
		] );

		$tab_repeater->add_control( 'filter_key', [
			'label'   => __( 'Filter Slug / Category', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'all',
			'description' => __( 'e.g. all, timepieces, leather, fragrance, jewelry, eyewear, silk, sale, new', 'kinboni-pro' ),
		] );

		$this->add_control( 'filter_tabs', [
			'label'       => __( 'Filter Tabs List', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $tab_repeater->get_controls(),
			'default'     => [
				[ 'tab_label' => 'All Creations',   'filter_key' => 'all' ],
				[ 'tab_label' => 'Timepieces',      'filter_key' => 'timepieces' ],
				[ 'tab_label' => 'Leather Goods',   'filter_key' => 'leather' ],
				[ 'tab_label' => 'Fragrance',       'filter_key' => 'fragrance' ],
				[ 'tab_label' => 'Fine Jewelry',    'filter_key' => 'jewelry' ],
				[ 'tab_label' => 'Eyewear',         'filter_key' => 'eyewear' ],
				[ 'tab_label' => 'Silk & Cashmere', 'filter_key' => 'silk' ],
				[ 'tab_label' => 'Private Sale',    'filter_key' => 'sale' ],
			],
			'title_field' => '{{{ tab_label }}} ({{{ filter_key }}})',
			'condition'   => [ 'show_filters' => 'yes' ],
		] );

		$this->end_controls_section();


		/* ══════════════════════════════════════════════
		   3. CATALOG ENGINE & GRID SETTINGS
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
				'demo' => __( 'Atelier Editorial Demo Catalog (Fast Interactive Filtering)', 'kinboni-pro' ),
				'wc'   => __( 'Live WooCommerce Catalog (Authoritative Storefront)', 'kinboni-pro' ),
			],
		] );

		$this->add_control( 'wc_limit', [
			'label'     => __( 'Products to Display', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::NUMBER,
			'default'   => 8,
			'min'       => 1,
			'max'       => 32,
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

		$this->end_controls_section();


		/* ══════════════════════════════════════════════
		   STYLE TAB: HEADER
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_style_header', [
			'label' => __( 'Section Header', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'tag_color', [
			'label'     => __( 'Subtitle Tag Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-bestseller-tag' => 'color: {{VALUE}} !important;' ],
		] );

		$this->add_control( 'title_color', [
			'label'     => __( 'Headline Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-bestseller-title' => 'color: {{VALUE}} !important;' ],
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typo',
				'label'    => __( 'Headline Typography', 'kinboni-pro' ),
				'selector' => '{{WRAPPER}} .kb-bestseller-title',
			]
		);

		$this->add_control( 'gold_bar_color', [
			'label'     => __( 'Gold Bar Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-bestseller-gold-bar' => 'background-color: {{VALUE}} !important;' ],
		] );

		$this->add_control( 'desc_color', [
			'label'     => __( 'Description Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-bestseller-desc' => 'color: {{VALUE}} !important;' ],
		] );

		$this->end_controls_section();


		/* ══════════════════════════════════════════════
		   STYLE TAB: FILTER BUTTONS
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_style_filters', [
			'label' => __( 'Filter Tabs Buttons', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'filter_active_bg', [
			'label'     => __( 'Active Pill Background', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .bestseller-filter-btn.active' => 'background-color: {{VALUE}} !important;' ],
		] );

		$this->add_control( 'filter_active_text', [
			'label'     => __( 'Active Pill Text Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .bestseller-filter-btn.active' => 'color: {{VALUE}} !important;' ],
		] );

		$this->add_control( 'filter_inactive_border', [
			'label'     => __( 'Inactive Pill Border Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .bestseller-filter-btn:not(.active)' => 'border-color: {{VALUE}} !important;' ],
		] );

		$this->end_controls_section();


		/* ══════════════════════════════════════════════
		   STYLE TAB: PRODUCT CARDS
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_style_cards', [
			'label' => __( 'Product Cards', 'kinboni-pro' ),
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

		$this->end_controls_section();
	}

	/* ─── Render ────────────────────────────────────────────── */

	protected function render(): void {
		$s = $this->get_settings_for_display();

		$widget_id = $this->get_id();
		$tabs      = $s['filter_tabs'] ?? [];
		$has_published_wc = function_exists( 'wc_get_products' ) && ! empty( wc_get_products( [ 'limit' => 1, 'status' => 'publish' ] ) );
		$source           = ( ! empty( $s['catalog_source'] ) ) ? $s['catalog_source'] : ( $has_published_wc ? 'wc' : 'demo' );

		// Grid columns class
		$cols = $s['grid_columns'] ?? '4';
		$col_class = 'xl:grid-cols-4';
		if ( '3' === $cols ) {
			$col_class = 'xl:grid-cols-3';
		} elseif ( '2' === $cols ) {
			$col_class = 'xl:grid-cols-2';
		}
		?>

		<section id="bestsellers" class="kb-bestsellers-section py-16 sm:py-24 scroll-mt-24">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

				<!-- Section Header -->
				<div class="text-center max-w-2xl mx-auto mb-10">
					<?php if ( ! empty( $s['subtitle_tag'] ) ) : ?>
						<span class="kb-bestseller-tag text-xs font-bold uppercase tracking-[0.25em] text-gold-600 dark:text-gold-400">
							<?php echo esc_html( $s['subtitle_tag'] ); ?>
						</span>
					<?php endif; ?>

					<?php if ( ! empty( $s['title'] ) ) : ?>
						<h2 class="kb-bestseller-title font-serif text-3xl sm:text-4xl font-medium text-stone-900 dark:text-white mt-1">
							<?php echo esc_html( $s['title'] ); ?>
						</h2>
					<?php endif; ?>

					<?php if ( 'yes' === ( $s['show_gold_bar'] ?? 'yes' ) ) : ?>
						<div class="kb-bestseller-gold-bar w-12 h-0.5 bg-gold-500 mx-auto mt-3 mb-4"></div>
					<?php endif; ?>

					<?php if ( ! empty( $s['description'] ) ) : ?>
						<p class="kb-bestseller-desc text-sm text-stone-600 dark:text-stone-400 font-light">
							<?php echo esc_html( $s['description'] ); ?>
						</p>
					<?php endif; ?>
				</div>

				<!-- Category Filter Tabs -->
				<?php if ( 'yes' === ( $s['show_filters'] ?? 'yes' ) && ! empty( $tabs ) ) : ?>
					<div class="flex items-center justify-center flex-wrap gap-2 mb-12">
						<?php foreach ( $tabs as $index => $tab ) :
							$filter = ! empty( $tab['filter_key'] ) ? esc_attr( $tab['filter_key'] ) : 'all';
							$label  = ! empty( $tab['tab_label'] ) ? esc_html( $tab['tab_label'] ) : 'All Creations';
							$is_first = ( 0 === $index );
							?>
							<button 
								type="button" 
								class="bestseller-filter-btn px-5 py-2 rounded-full text-xs font-bold uppercase tracking-wider transition-all duration-300 border <?php echo $is_first ? 'bg-stone-900 text-white dark:bg-gold-400 dark:text-stone-950 border-transparent shadow-sm' : 'bg-transparent text-stone-700 dark:text-stone-300 border-stone-300 dark:border-stone-700'; ?>"
								data-filter="<?php echo $filter; ?>"
							>
								<?php echo $label; ?>
							</button>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<!-- Best Sellers Dynamic Grid -->
				<div id="bestsellers-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 <?php echo esc_attr( $col_class ); ?> gap-6 sm:gap-8">
					<?php
					if ( 'wc' === $source && function_exists( 'wc_get_products' ) ) {
						$wc_limit = ! empty( $s['wc_limit'] ) ? absint( $s['wc_limit'] ) : 8;
						$products = wc_get_products( [
							'status'  => 'publish',
							'limit'   => $wc_limit,
							'orderby' => 'total_sales',
							'order'   => 'DESC',
							'return'  => 'objects',
						] );

						if ( ! empty( $products ) ) {
							$curr = function_exists( 'get_woocommerce_currency_symbol' ) ? get_woocommerce_currency_symbol() : '৳';
							foreach ( $products as $product ) {
								$pid = $product->get_id();
								$pname = $product->get_name();
								$raw_price = (float) $product->get_price();
								$reg_price = (float) $product->get_regular_price();
								$discount = ( $reg_price > $raw_price && $reg_price > 0 ) ? round( ( ( $reg_price - $raw_price ) / $reg_price ) * 100 ) : 0;

								$img_id = $product->get_image_id();
								$img_url = $img_id ? wp_get_attachment_image_url( $img_id, 'large' ) : ( function_exists( 'wc_placeholder_img_src' ) ? wc_placeholder_img_src( 'large' ) : '' );
								$gallery_ids = $product->get_gallery_image_ids();
								$hover_url = ! empty( $gallery_ids ) ? wp_get_attachment_image_url( $gallery_ids[0], 'large' ) : $img_url;

								$cats = wp_get_post_terms( $pid, 'product_cat' );
								$cat_name = ( ! empty( $cats ) && ! is_wp_error( $cats ) ) ? $cats[0]->name : __( 'Fine Collection', 'kinboni-pro' );
								$cat_slug = ( ! empty( $cats ) && ! is_wp_error( $cats ) ) ? $cats[0]->slug : 'all';

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
									'rating'        => $product->get_average_rating() ? (float) $product->get_average_rating() : 5.0,
									'reviewsCount'  => $product->get_review_count() ?: 18,
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

										<!-- Quick View Action Button -->
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
									</div>

									<!-- Card Details -->
									<div class="p-4 sm:p-5 flex flex-col flex-grow">
										<div class="flex items-center justify-between gap-2 mb-2 min-w-0">
											<span class="text-[10px] sm:text-[11px] uppercase tracking-wider font-bold text-gold-600 dark:text-gold-400 truncate">
												<?php echo esc_html( $cat_name ); ?>
											</span>
											<div class="flex items-center gap-1 text-[11px] font-bold text-stone-700 dark:text-stone-300 flex-shrink-0">
												<i data-lucide="star" class="w-3.5 h-3.5 fill-amber-400 text-amber-400"></i>
												<span>5.0</span>
											</div>
										</div>

										<h3 class="font-serif text-base sm:text-lg font-medium text-stone-900 dark:text-stone-100 mb-2 truncate">
											<?php echo esc_html( $pname ); ?>
										</h3>

										<div class="flex items-baseline gap-2 mb-4">
											<span class="text-base sm:text-lg font-bold text-stone-900 dark:text-white">
												<?php echo esc_html( $curr . number_format( $raw_price ) ); ?>
											</span>
											<?php if ( $reg_price > $raw_price ) : ?>
												<span class="text-xs text-stone-400 dark:text-stone-500 line-through">
													<?php echo esc_html( $curr . number_format( $reg_price ) ); ?>
												</span>
											<?php endif; ?>
										</div>

										<!-- Add to Cart CTA -->
										<button 
											type="button" 
											onclick="if(window.registerProduct) registerProduct(<?php echo esc_attr( $json_payload ); ?>); if(window.CartController) CartController.add(<?php echo esc_attr( $pid ); ?>, 1);"
											class="w-full mt-auto py-2.5 px-3 rounded-xl bg-stone-100 hover:bg-gold-400 hover:text-stone-950 dark:bg-stone-800 dark:hover:bg-gold-400 dark:hover:text-stone-950 text-stone-900 dark:text-stone-200 text-xs font-bold uppercase tracking-wider transition-all flex items-center justify-center gap-2"
										>
											<i data-lucide="shopping-bag" class="w-3.5 h-3.5"></i>
											<span><?php esc_html_e( 'Add to Bag', 'kinboni-pro' ); ?></span>
										</button>
									</div>

								</div>
								<?php
							}
						}
					}
					?>
				</div>

			</div>
		</section>

		<script>
		(function() {
			function initBestsellers<?php echo esc_attr( str_replace( '-', '_', $widget_id ) ); ?>() {
				<?php if ( 'demo' === $source ) : ?>
					if (typeof ProductRenderer !== 'undefined' && ProductRenderer.renderBestSellers) {
						ProductRenderer.renderBestSellers('all');
					}
				<?php endif; ?>
				if (typeof lucide !== 'undefined' && lucide.createIcons) {
					lucide.createIcons();
				}
			}
			if (document.readyState === 'loading') {
				document.addEventListener('DOMContentLoaded', initBestsellers<?php echo esc_attr( str_replace( '-', '_', $widget_id ) ); ?>);
			} else {
				initBestsellers<?php echo esc_attr( str_replace( '-', '_', $widget_id ) ); ?>();
			}
		})();
		</script>
		<?php
	}
}

