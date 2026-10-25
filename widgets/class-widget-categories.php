<?php
namespace KinboniPro\Widgets;

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
	return;
}

class Widget_Categories extends \Elementor\Widget_Base {

	/* ─── Identity ──────────────────────────────────────────── */

	public function get_name(): string {
		return 'kinboni_categories';
	}

	public function get_title(): string {
		return __( 'KINBONI — Curated Disciplines (Categories Grid)', 'kinboni-pro' );
	}

	public function get_icon(): string {
		return 'eicon-gallery-grid';
	}

	public function get_categories(): array {
		return [ 'kinboni' ];
	}

	public function get_keywords(): array {
		return [ 'kinboni', 'categories', 'shop', 'disciplines', 'collections', 'grid', 'woocommerce', 'catalog', 'luxury' ];
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
			'default' => __( 'Curated Disciplines', 'kinboni-pro' ),
		] );

		$this->add_control( 'title', [
			'label'       => __( 'Main Headline (H2)', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => __( 'Shop by Category', 'kinboni-pro' ),
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
			'default'     => __( 'Each collection represents years of artisanal devotion, ethically sourced raw elements, and immaculate finishing.', 'kinboni-pro' ),
			'label_block' => true,
		] );

		$this->add_control( 'section_id', [
			'label'       => __( 'Section Anchor ID', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'categories',
			'description' => __( 'Anchor ID for direct smooth scrolling (e.g. #categories).', 'kinboni-pro' ),
		] );

		$this->end_controls_section();


		/* ══════════════════════════════════════════════
		   2. CATEGORIES SOURCE & REPEATER
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_categories_content', [
			'label' => __( 'Categories Content', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'source_mode', [
			'label'   => __( 'Category Source', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'custom',
			'options' => [
				'custom' => __( 'Custom Curated Categories (Repeater)', 'kinboni-pro' ),
				'wc'     => __( 'Live WooCommerce Categories', 'kinboni-pro' ),
			],
		] );

		// Repeater for Custom Categories
		$repeater = new \Elementor\Repeater();

		$repeater->add_control( 'title', [
			'label'       => __( 'Category Title', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'Timepieces',
			'label_block' => true,
		] );

		$repeater->add_control( 'subtitle', [
			'label'       => __( 'Subtitle / Item Count', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => '18 Creations',
			'label_block' => true,
		] );

		$repeater->add_control( 'filter_slug', [
			'label'       => __( 'Filter Slug', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'timepieces',
			'description' => __( 'Slug used to filter the bestsellers catalog (e.g. timepieces, leather, fragrance, jewelry, eyewear, silk).', 'kinboni-pro' ),
		] );

		$repeater->add_control( 'image', [
			'label'   => __( 'Card Image', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::MEDIA,
			'default' => [
				'url' => 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?auto=format&fit=crop&w=600&q=80',
			],
		] );

		$repeater->add_control( 'click_action', [
			'label'   => __( 'Click Action', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'filter_catalog',
			'options' => [
				'filter_catalog' => __( 'Filter Catalog & Smooth Scroll', 'kinboni-pro' ),
				'custom_url'     => __( 'Open Custom URL / Page', 'kinboni-pro' ),
			],
		] );

		$repeater->add_control( 'custom_url', [
			'label'       => __( 'Custom Link URL', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::URL,
			'placeholder' => __( 'https://example.com/collection', 'kinboni-pro' ),
			'condition'   => [ 'click_action' => 'custom_url' ],
		] );

		$this->add_control( 'categories_list', [
			'label'       => __( 'Disciplines List', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'default'     => [
				[
					'title'        => 'Timepieces',
					'subtitle'     => '18 Creations',
					'filter_slug'  => 'timepieces',
					'image'        => [ 'url' => 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?auto=format&fit=crop&w=600&q=80' ],
					'click_action' => 'filter_catalog',
				],
				[
					'title'        => 'Leather Goods',
					'subtitle'     => '24 Creations',
					'filter_slug'  => 'leather',
					'image'        => [ 'url' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&w=600&q=80' ],
					'click_action' => 'filter_catalog',
				],
				[
					'title'        => 'Fine Fragrance',
					'subtitle'     => '12 Extraits',
					'filter_slug'  => 'fragrance',
					'image'        => [ 'url' => 'https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?auto=format&fit=crop&w=600&q=80' ],
					'click_action' => 'filter_catalog',
				],
				[
					'title'        => 'Fine Jewelry',
					'subtitle'     => '15 Pieces',
					'filter_slug'  => 'jewelry',
					'image'        => [ 'url' => 'https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?auto=format&fit=crop&w=600&q=80' ],
					'click_action' => 'filter_catalog',
				],
				[
					'title'        => 'Eyewear',
					'subtitle'     => '10 Models',
					'filter_slug'  => 'eyewear',
					'image'        => [ 'url' => 'https://images.unsplash.com/photo-1511499767150-a48a237f0083?auto=format&fit=crop&w=600&q=80' ],
					'click_action' => 'filter_catalog',
				],
				[
					'title'        => 'Silk & Cashmere',
					'subtitle'     => '14 Weaves',
					'filter_slug'  => 'silk',
					'image'        => [ 'url' => 'https://images.unsplash.com/photo-1601924994987-69e26d50dc26?auto=format&fit=crop&w=600&q=80' ],
					'click_action' => 'filter_catalog',
				],
			],
			'title_field' => '{{{ title }}} ({{{ subtitle }}})',
			'condition'   => [ 'source_mode' => 'custom' ],
		] );

		// WooCommerce Mode Settings
		$this->add_control( 'wc_cat_limit', [
			'label'     => __( 'Max Categories to Display', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::NUMBER,
			'default'   => 6,
			'min'       => 1,
			'max'       => 24,
			'condition' => [ 'source_mode' => 'wc' ],
		] );

		$this->add_control( 'wc_hide_empty', [
			'label'        => __( 'Hide Empty Categories', 'kinboni-pro' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'no',
			'condition'    => [ 'source_mode' => 'wc' ],
		] );

		$this->add_control( 'wc_action', [
			'label'     => __( 'WooCommerce Card Action', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::SELECT,
			'default'   => 'filter_catalog',
			'options'   => [
				'filter_catalog' => __( 'Filter Atelier Catalog & Scroll to Best Sellers', 'kinboni-pro' ),
				'archive_url'    => __( 'Navigate to WooCommerce Category Archive URL', 'kinboni-pro' ),
			],
			'condition' => [ 'source_mode' => 'wc' ],
		] );

		$this->end_controls_section();


		/* ══════════════════════════════════════════════
		   3. GRID & CARD LAYOUT
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_grid_layout', [
			'label' => __( 'Grid & Aspect Ratio', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_responsive_control( 'grid_cols', [
			'label'     => __( 'Columns (Desktop)', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::SELECT,
			'default'   => '6',
			'options'   => [
				'6' => __( '6 Columns (Default)', 'kinboni-pro' ),
				'4' => __( '4 Columns', 'kinboni-pro' ),
				'3' => __( '3 Columns', 'kinboni-pro' ),
				'2' => __( '2 Columns', 'kinboni-pro' ),
			],
		] );

		$this->add_control( 'aspect_ratio', [
			'label'   => __( 'Card Aspect Ratio', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'aspect-[3/4]',
			'options' => [
				'aspect-[3/4]' => __( 'Portrait 3:4 (Default Atelier)', 'kinboni-pro' ),
				'aspect-[4/5]' => __( 'Tall Portrait 4:5', 'kinboni-pro' ),
				'aspect-square'=> __( 'Square 1:1', 'kinboni-pro' ),
			],
		] );

		$this->end_controls_section();


		/* ══════════════════════════════════════════════
		   STYLE TAB: SECTION & BACKGROUND
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_style_general', [
			'label' => __( 'Section Background & Spacing', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'section_bg_color', [
			'label'     => __( 'Section Background Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-categories-section' => 'background-color: {{VALUE}} !important;' ],
		] );

		$this->add_control( 'border_color', [
			'label'     => __( 'Top & Bottom Border Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .kb-categories-section' => 'border-top-color: {{VALUE}} !important; border-bottom-color: {{VALUE}} !important;',
			],
		] );

		$this->add_responsive_control( 'section_padding', [
			'label'      => __( 'Padding', 'kinboni-pro' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', 'rem', '%' ],
			'selectors'  => [
				'{{WRAPPER}} .kb-categories-section' => 'padding-top: {{TOP}}{{UNIT}}; padding-bottom: {{BOTTOM}}{{UNIT}}; padding-left: {{LEFT}}{{UNIT}}; padding-right: {{RIGHT}}{{UNIT}};',
			],
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
			'selectors' => [ '{{WRAPPER}} .kb-cat-tag' => 'color: {{VALUE}} !important;' ],
		] );

		$this->add_control( 'title_color', [
			'label'     => __( 'Headline Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-cat-title' => 'color: {{VALUE}} !important;' ],
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typo',
				'label'    => __( 'Headline Typography', 'kinboni-pro' ),
				'selector' => '{{WRAPPER}} .kb-cat-title',
			]
		);

		$this->add_control( 'gold_bar_color', [
			'label'     => __( 'Gold Accent Bar Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-cat-gold-bar' => 'background-color: {{VALUE}} !important;' ],
		] );

		$this->add_control( 'desc_color', [
			'label'     => __( 'Description Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-cat-desc' => 'color: {{VALUE}} !important;' ],
		] );

		$this->end_controls_section();


		/* ══════════════════════════════════════════════
		   STYLE TAB: CARDS & TYPOGRAPHY
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_style_cards', [
			'label' => __( 'Category Cards & Typography', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'card_border_radius', [
			'label'      => __( 'Border Radius', 'kinboni-pro' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem' ],
			'range'      => [
				'px' => [ 'min' => 0, 'max' => 40 ],
			],
			'default'    => [ 'unit' => 'px', 'size' => 16 ],
			'selectors'  => [ '{{WRAPPER}} .category-card-trigger' => 'border-radius: {{SIZE}}{{UNIT}} !important;' ],
		] );

		$this->add_control( 'card_border_color', [
			'label'     => __( 'Card Border Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .category-card-trigger' => 'border-color: {{VALUE}} !important;' ],
		] );

		$this->add_control( 'item_title_color', [
			'label'     => __( 'Category Item Title Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#ffffff',
			'selectors' => [ '{{WRAPPER}} .kb-cat-item-title' => 'color: {{VALUE}} !important;' ],
		] );

		$this->add_control( 'item_title_hover_color', [
			'label'     => __( 'Category Title Hover Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#c5a059',
			'selectors' => [ '{{WRAPPER}} .category-card-trigger:hover .kb-cat-item-title' => 'color: {{VALUE}} !important;' ],
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'item_title_typo',
				'label'    => __( 'Category Item Title Typography', 'kinboni-pro' ),
				'selector' => '{{WRAPPER}} .kb-cat-item-title',
			]
		);

		$this->add_control( 'item_subtitle_color', [
			'label'     => __( 'Subtitle / Count Text Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#d6d3d1',
			'selectors' => [ '{{WRAPPER}} .kb-cat-item-subtitle' => 'color: {{VALUE}} !important;' ],
		] );

		$this->end_controls_section();
	}

	/* ─── Render ────────────────────────────────────────────── */

	protected function render(): void {
		$s = $this->get_settings_for_display();

		$section_id   = ! empty( $s['section_id'] ) ? esc_attr( $s['section_id'] ) : 'categories';
		$source_mode  = $s['source_mode'] ?? 'custom';
		$aspect_class = ! empty( $s['aspect_ratio'] ) ? esc_attr( $s['aspect_ratio'] ) : 'aspect-[3/4]';

		// Columns mapping for Desktop
		$cols = $s['grid_cols'] ?? '6';
		$lg_col_class = 'lg:grid-cols-6';
		if ( '4' === $cols ) {
			$lg_col_class = 'lg:grid-cols-4';
		} elseif ( '3' === $cols ) {
			$lg_col_class = 'lg:grid-cols-3';
		} elseif ( '2' === $cols ) {
			$lg_col_class = 'lg:grid-cols-2';
		}

		$categories = [];

		if ( 'wc' === $source_mode && taxonomy_exists( 'product_cat' ) ) {
			$wc_limit   = ! empty( $s['wc_cat_limit'] ) ? absint( $s['wc_cat_limit'] ) : 6;
			$hide_empty = ( 'yes' === ( $s['wc_hide_empty'] ?? 'no' ) );
			$action     = $s['wc_action'] ?? 'filter_catalog';

			$terms = get_terms( [
				'taxonomy'   => 'product_cat',
				'hide_empty' => $hide_empty,
				'number'     => $wc_limit,
				'orderby'    => 'count',
				'order'      => 'DESC',
			] );

			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
				$fallback_images = [
					'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?auto=format&fit=crop&w=600&q=80',
					'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&w=600&q=80',
					'https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?auto=format&fit=crop&w=600&q=80',
					'https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?auto=format&fit=crop&w=600&q=80',
					'https://images.unsplash.com/photo-1511499767150-a48a237f0083?auto=format&fit=crop&w=600&q=80',
					'https://images.unsplash.com/photo-1601924994987-69e26d50dc26?auto=format&fit=crop&w=600&q=80',
				];
				$f_index = 0;

				foreach ( $terms as $term ) {
					$thumb_id  = get_term_meta( $term->term_id, 'thumbnail_id', true );
					$img_url   = $thumb_id ? wp_get_attachment_image_url( $thumb_id, 'medium_large' ) : $fallback_images[ $f_index % count( $fallback_images ) ];
					$f_index++;

					$archive_url = get_term_link( $term );
					$url_str     = ( ! is_wp_error( $archive_url ) ) ? $archive_url : '#';

					$categories[] = [
						'title'        => $term->name,
						'subtitle'     => sprintf( _n( '%s Creation', '%s Creations', $term->count, 'kinboni-pro' ), number_format_i18n( $term->count ) ),
						'filter_slug'  => $term->slug,
						'image'        => $img_url,
						'click_action' => ( 'archive_url' === $action ) ? 'custom_url' : 'filter_catalog',
						'custom_url'   => $url_str,
					];
				}
			}
		}

		// Fallback to Custom Repeater Categories
		if ( empty( $categories ) ) {
			$raw_items = $s['categories_list'] ?? [];
			foreach ( $raw_items as $item ) {
				$img_url = ! empty( $item['image']['url'] ) ? esc_url( $item['image']['url'] ) : 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?auto=format&fit=crop&w=600&q=80';
				$categories[] = [
					'title'        => $item['title'] ?? '',
					'subtitle'     => $item['subtitle'] ?? '',
					'filter_slug'  => ! empty( $item['filter_slug'] ) ? $item['filter_slug'] : sanitize_title( $item['title'] ?? '' ),
					'image'        => $img_url,
					'click_action' => $item['click_action'] ?? 'filter_catalog',
					'custom_url'   => ! empty( $item['custom_url']['url'] ) ? esc_url( $item['custom_url']['url'] ) : '#',
					'is_external'  => ! empty( $item['custom_url']['is_external'] ),
				];
			}
		}
		?>

		<section id="<?php echo $section_id; ?>" class="kb-categories-section py-16 sm:py-24 bg-stone-100/60 dark:bg-stone-950/60 border-t border-b border-stone-200/70 dark:border-stone-800/80 scroll-mt-24">
			<div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8">
				
				<!-- Section Header -->
				<div class="text-center max-w-2xl mx-auto mb-12 sm:mb-16">
					<?php if ( ! empty( $s['subtitle_tag'] ) ) : ?>
						<span class="kb-cat-tag text-xs font-bold uppercase tracking-[0.25em] text-gold-600 dark:text-gold-400">
							<?php echo esc_html( $s['subtitle_tag'] ); ?>
						</span>
					<?php endif; ?>

					<?php if ( ! empty( $s['title'] ) ) : ?>
						<h2 class="kb-cat-title font-serif text-3xl sm:text-4xl font-medium text-stone-900 dark:text-white mt-1">
							<?php echo esc_html( $s['title'] ); ?>
						</h2>
					<?php endif; ?>

					<?php if ( 'yes' === ( $s['show_gold_bar'] ?? 'yes' ) ) : ?>
						<div class="kb-cat-gold-bar w-12 h-0.5 bg-gold-500 mx-auto mt-3 mb-4"></div>
					<?php endif; ?>

					<?php if ( ! empty( $s['description'] ) ) : ?>
						<p class="kb-cat-desc text-sm text-stone-600 dark:text-stone-400 font-light">
							<?php echo esc_html( $s['description'] ); ?>
						</p>
					<?php endif; ?>
				</div>

				<!-- Categories Grid -->
				<div class="grid grid-cols-2 md:grid-cols-3 <?php echo esc_attr( $lg_col_class ); ?> gap-4 sm:gap-6">
					<?php foreach ( $categories as $cat ) :
						$title   = $cat['title'];
						$sub     = $cat['subtitle'];
						$slug    = $cat['filter_slug'];
						$img_url = $cat['image'];
						$action  = $cat['click_action'];
						$url     = $cat['custom_url'] ?? '#';
						$ext     = ! empty( $cat['is_external'] );

						if ( 'custom_url' === $action && ! empty( $url ) && '#' !== $url ) {
							$click_handler = 'window.open(\'' . esc_url( $url ) . '\', \'' . ( $ext ? '_blank' : '_self' ) . '\');';
						} else {
							$click_handler = "if(window.ProductRenderer&&ProductRenderer.renderBestSellers){ProductRenderer.renderBestSellers('" . esc_js( $slug ) . "');}const target=document.getElementById('bestsellers');if(target){target.scrollIntoView({behavior:'smooth'});}if(window.showToast){showToast('Filtered by " . esc_js( strtoupper( $title ) ) . "', 'info');}";
						}
						?>
						<div 
							class="category-card-trigger group relative rounded-2xl overflow-hidden <?php echo esc_attr( $aspect_class ); ?> cursor-pointer shadow-sm hover:shadow-xl transition-all duration-500 border border-stone-200/80 dark:border-stone-800"
							data-category="<?php echo esc_attr( $slug ); ?>"
							onclick="<?php echo esc_attr( $click_handler ); ?>"
							role="button"
							tabindex="0"
							aria-label="<?php echo esc_attr( sprintf( __( 'Explore %s category', 'kinboni-pro' ), $title ) ); ?>"
						>
							<img 
								src="<?php echo esc_url( $img_url ); ?>" 
								alt="<?php echo esc_attr( $title ); ?>" 
								loading="lazy"
								class="w-full h-full object-cover object-center group-hover:scale-110 transition-transform duration-700 ease-out" 
								style="height: 100% !important; width: 100% !important; object-fit: cover !important;"
							/>

							<!-- Dark Gradient Ambient Overlay -->
							<div class="absolute inset-0 bg-gradient-to-t from-stone-950/90 via-stone-950/30 to-transparent pointer-events-none"></div>

							<!-- Category Content Details -->
							<div class="absolute inset-x-3 bottom-4 text-center pointer-events-none">
								<?php if ( ! empty( $title ) ) : ?>
									<h3 class="kb-cat-item-title font-serif text-base sm:text-lg font-medium text-white group-hover:text-gold-400 transition-colors">
										<?php echo esc_html( $title ); ?>
									</h3>
								<?php endif; ?>

								<?php if ( ! empty( $sub ) ) : ?>
									<p class="kb-cat-item-subtitle text-[10px] uppercase tracking-wider text-stone-300 mt-0.5">
										<?php echo esc_html( $sub ); ?>
									</p>
								<?php endif; ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>

			</div>
		</section>
		<?php
	}
}

