<?php
namespace KinboniPro\Widgets;

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
	return;
}

class Widget_Hero extends \Elementor\Widget_Base {

	/* ─── Identity ──────────────────────────────────────────── */

	public function get_name(): string {
		return 'kinboni_hero';
	}

	public function get_title(): string {
		return __( 'KINBONI — Editorial Hero Section', 'kinboni-pro' );
	}

	public function get_icon(): string {
		return 'eicon-banner';
	}

	public function get_categories(): array {
		return [ 'kinboni' ];
	}

	public function get_keywords(): array {
		return [ 'kinboni', 'hero', 'banner', 'editorial', 'mosaic', 'gallery', 'woocommerce', 'luxury' ];
	}

	public function get_script_depends(): array {
		return [ 'lucide-icons', 'swiper-bundle', 'kinboni-pro', 'kinboni-app' ];
	}

	public function get_style_depends(): array {
		return [ 'kinboni-fonts', 'swiper-bundle', 'kinboni-output', 'kinboni-pro' ];
	}

	/**
	 * Retrieve list of published WooCommerce products for dropdowns.
	 *
	 * @return array<string, string>
	 */
	private function get_wc_products(): array {
		$options = [ '0' => __( '— Default / Luxury Editorial Demo —', 'kinboni-pro' ) ];

		if ( function_exists( 'wc_get_products' ) ) {
			$products = wc_get_products( [
				'status'  => 'publish',
				'limit'   => 80,
				'orderby' => 'date',
				'order'   => 'DESC',
				'return'  => 'objects',
			] );

			if ( ! empty( $products ) ) {
				$curr = function_exists( 'get_woocommerce_currency_symbol' ) ? get_woocommerce_currency_symbol() : '৳';
				foreach ( $products as $product ) {
					$price = $product->get_price();
					$price_str = $price ? ' (' . $curr . number_format( (float) $price ) . ')' : '';
					$options[ (string) $product->get_id() ] = esc_html( $product->get_name() . $price_str );
				}
			}
		}

		return $options;
	}

	/* ─── Controls ──────────────────────────────────────────── */

	protected function register_controls(): void {

		/* ══════════════════════════════════════════════
		   1. EDITORIAL HEADLINE & COPY (LEFT COLUMN)
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_hero_copy', [
			'label' => __( 'Editorial Headline & Copy', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'hero_subtitle_badge', [
			'label'       => __( 'Archive Tag / Subtitle', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => __( 'Autumn / Winter 2026 Archive', 'kinboni-pro' ),
			'placeholder' => __( 'e.g. Autumn / Winter 2026 Archive', 'kinboni-pro' ),
			'label_block' => true,
		] );

		$this->add_control( 'hero_show_gold_bar', [
			'label'        => __( 'Show Gold Accent Line', 'kinboni-pro' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'label_on'     => __( 'Show', 'kinboni-pro' ),
			'label_off'    => __( 'Hide', 'kinboni-pro' ),
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'hero_headline', [
			'label'       => __( 'Main Headline (H1)', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXTAREA,
			'rows'        => 3,
			'default'     => "Objects made<br class=\"hidden sm:block\"> to be kept<br class=\"hidden sm:block\"> for life.",
			'description' => __( 'HTML allowed for line breaks (<br>).', 'kinboni-pro' ),
		] );

		$this->add_control( 'hero_description', [
			'label'       => __( 'Body Description', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXTAREA,
			'rows'        => 4,
			'default'     => __( 'Hand-burnished leather, precision chronographs and rare botanical extraits, made in small batches and delivered across Bangladesh.', 'kinboni-pro' ),
		] );

		$this->end_controls_section();


		/* ══════════════════════════════════════════════
		   2. CALL TO ACTION BUTTONS
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_hero_actions', [
			'label' => __( 'Call to Action Buttons', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'btn_primary_heading', [
			'label'     => __( 'Primary Button (Gold)', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'show_btn_primary', [
			'label'        => __( 'Show Primary Button', 'kinboni-pro' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'btn_primary_text', [
			'label'     => __( 'Button Text', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::TEXT,
			'default'   => __( 'Shop the Collection', 'kinboni-pro' ),
			'condition' => [ 'show_btn_primary' => 'yes' ],
		] );

		$this->add_control( 'btn_primary_url', [
			'label'       => __( 'Button Link', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::URL,
			'placeholder' => __( 'https://your-link.com or #featured', 'kinboni-pro' ),
			'default'     => [
				'url' => '#featured',
			],
			'condition'   => [ 'show_btn_primary' => 'yes' ],
		] );

		$this->add_control( 'btn_secondary_heading', [
			'label'     => __( 'Secondary Button (Outline)', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'show_btn_secondary', [
			'label'        => __( 'Show Secondary Button', 'kinboni-pro' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'btn_secondary_text', [
			'label'     => __( 'Button Text', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::TEXT,
			'default'   => __( 'View Best Sellers', 'kinboni-pro' ),
			'condition' => [ 'show_btn_secondary' => 'yes' ],
		] );

		$this->add_control( 'btn_secondary_url', [
			'label'       => __( 'Button Link', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::URL,
			'placeholder' => __( 'https://your-link.com or #bestsellers', 'kinboni-pro' ),
			'default'     => [
				'url' => '#bestsellers',
			],
			'condition'   => [ 'show_btn_secondary' => 'yes' ],
		] );

		$this->end_controls_section();


		/* ══════════════════════════════════════════════
		   3. PROOF METRICS BAR
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_hero_metrics', [
			'label' => __( 'Proof Metrics Bar', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'show_metrics', [
			'label'        => __( 'Show Metrics Bar', 'kinboni-pro' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'metric_1_val', [
			'label'     => __( 'Metric 1 Value', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::TEXT,
			'default'   => '4.9',
			'condition' => [ 'show_metrics' => 'yes' ],
		] );

		$this->add_control( 'metric_1_label', [
			'label'     => __( 'Metric 1 Label', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::TEXT,
			'default'   => __( 'Patron satisfaction', 'kinboni-pro' ),
			'condition' => [ 'show_metrics' => 'yes' ],
		] );

		$this->add_control( 'metric_2_val', [
			'label'     => __( 'Metric 2 Value', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::TEXT,
			'default'   => '10K+',
			'condition' => [ 'show_metrics' => 'yes' ],
		] );

		$this->add_control( 'metric_2_label', [
			'label'     => __( 'Metric 2 Label', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::TEXT,
			'default'   => __( 'Creations delivered', 'kinboni-pro' ),
			'condition' => [ 'show_metrics' => 'yes' ],
		] );

		$this->add_control( 'metric_3_val', [
			'label'     => __( 'Metric 3 Value', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::TEXT,
			'default'   => '7 Day',
			'condition' => [ 'show_metrics' => 'yes' ],
		] );

		$this->add_control( 'metric_3_label', [
			'label'     => __( 'Metric 3 Label', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::TEXT,
			'default'   => __( 'Easy exchange', 'kinboni-pro' ),
			'condition' => [ 'show_metrics' => 'yes' ],
		] );

		$this->end_controls_section();


		/* ══════════════════════════════════════════════
		   4. MOSAIC GALLERY — 3 FEATURED PRODUCTS
		   ══════════════════════════════════════════════ */
		$wc_product_options = $this->get_wc_products();

		// ── Slot 1: Main Arched Product (Left 7 Cols, 6 Rows) ──
		$this->start_controls_section( 'section_slot_1', [
			'label' => __( 'Mosaic Slot 1 (Arched Main Feature)', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'product_1_wc_id', [
			'label'       => __( 'Select WooCommerce Product', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::SELECT,
			'default'     => '0',
			'options'     => $wc_product_options,
			'label_block' => true,
			'description' => __( 'Selecting a product will automatically load its live price, image, title, and quick-view modal details.', 'kinboni-pro' ),
		] );

		$this->add_control( 'product_1_title', [
			'label'       => __( 'Custom Title Override / Fallback', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'Kyoto Mulberry Silk',
			'placeholder' => __( 'Leave empty to use WooCommerce product title', 'kinboni-pro' ),
			'label_block' => true,
		] );

		$this->add_control( 'product_1_badge', [
			'label'       => __( 'Badge / Category Label', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'Artisanal Weave',
			'placeholder' => __( 'e.g. Artisanal Weave', 'kinboni-pro' ),
		] );

		$this->add_control( 'product_1_price', [
			'label'       => __( 'Custom Price Text Override', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => '৳4,800',
			'placeholder' => __( 'Leave empty to use live WooCommerce price', 'kinboni-pro' ),
		] );

		$this->add_control( 'product_1_image', [
			'label'       => __( 'Custom Image Override', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::MEDIA,
			'default'     => [
				'url' => 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?auto=format&fit=crop&w=900&q=85',
			],
			'description' => __( 'Leave empty or default to use WooCommerce featured product image.', 'kinboni-pro' ),
		] );

		$this->end_controls_section();


		// ── Slot 2: Top Right Stacked (5 Cols, 3 Rows) ──
		$this->start_controls_section( 'section_slot_2', [
			'label' => __( 'Mosaic Slot 2 (Top Right Card)', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'product_2_wc_id', [
			'label'       => __( 'Select WooCommerce Product', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::SELECT,
			'default'     => '0',
			'options'     => $wc_product_options,
			'label_block' => true,
		] );

		$this->add_control( 'product_2_title', [
			'label'       => __( 'Custom Title Override / Fallback', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'Chronos Royale',
			'label_block' => true,
		] );

		$this->add_control( 'product_2_badge', [
			'label'       => __( 'Badge / Category Label', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'Swiss Movement',
		] );

		$this->add_control( 'product_2_price', [
			'label'       => __( 'Custom Price Text Override', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => '৳18,500',
		] );

		$this->add_control( 'product_2_image', [
			'label'       => __( 'Custom Image Override', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::MEDIA,
			'default'     => [
				'url' => 'https://images.unsplash.com/photo-1523293182086-7651a899d37f?auto=format&fit=crop&w=600&q=85',
			],
		] );

		$this->end_controls_section();


		// ── Slot 3: Bottom Right Stacked (5 Cols, 3 Rows) ──
		$this->start_controls_section( 'section_slot_3', [
			'label' => __( 'Mosaic Slot 3 (Bottom Right Card)', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'product_3_wc_id', [
			'label'       => __( 'Select WooCommerce Product', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::SELECT,
			'default'     => '0',
			'options'     => $wc_product_options,
			'label_block' => true,
		] );

		$this->add_control( 'product_3_title', [
			'label'       => __( 'Custom Title Override / Fallback', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'Saddle Briefcase',
			'label_block' => true,
		] );

		$this->add_control( 'product_3_badge', [
			'label'       => __( 'Badge / Category Label', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'Tuscan Leather',
		] );

		$this->add_control( 'product_3_price', [
			'label'       => __( 'Custom Price Text Override', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => '৳14,200',
		] );

		$this->add_control( 'product_3_image', [
			'label'       => __( 'Custom Image Override', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::MEDIA,
			'default'     => [
				'url' => 'https://images.unsplash.com/photo-1524805444758-089113d48a6d?auto=format&fit=crop&w=600&q=85',
			],
		] );

		$this->end_controls_section();


		/* ══════════════════════════════════════════════
		   5. TRUST RIBBON (HERO FOOTER BAR)
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_trust_ribbon', [
			'label' => __( 'Trust Ribbon (Bottom Bar)', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'show_trust_ribbon', [
			'label'        => __( 'Show Trust Ribbon', 'kinboni-pro' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'trust_1_text', [
			'label'     => __( 'Feature 1 Text', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::TEXT,
			'default'   => __( 'Free delivery over ৳2,500', 'kinboni-pro' ),
			'condition' => [ 'show_trust_ribbon' => 'yes' ],
		] );

		$this->add_control( 'trust_1_icon', [
			'label'     => __( 'Feature 1 Lucide Icon', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::TEXT,
			'default'   => 'truck',
			'condition' => [ 'show_trust_ribbon' => 'yes' ],
		] );

		$this->add_control( 'trust_2_text', [
			'label'     => __( 'Feature 2 Text', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::TEXT,
			'default'   => __( 'Authenticity guaranteed', 'kinboni-pro' ),
			'condition' => [ 'show_trust_ribbon' => 'yes' ],
		] );

		$this->add_control( 'trust_2_icon', [
			'label'     => __( 'Feature 2 Lucide Icon', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::TEXT,
			'default'   => 'shield-check',
			'condition' => [ 'show_trust_ribbon' => 'yes' ],
		] );

		$this->add_control( 'trust_3_text', [
			'label'     => __( 'Feature 3 Text', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::TEXT,
			'default'   => __( '7-day easy exchange', 'kinboni-pro' ),
			'condition' => [ 'show_trust_ribbon' => 'yes' ],
		] );

		$this->add_control( 'trust_3_icon', [
			'label'     => __( 'Feature 3 Lucide Icon', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::TEXT,
			'default'   => 'refresh-cw',
			'condition' => [ 'show_trust_ribbon' => 'yes' ],
		] );

		$this->add_control( 'trust_4_text', [
			'label'     => __( 'Feature 4 Text', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::TEXT,
			'default'   => __( 'Cash on delivery available', 'kinboni-pro' ),
			'condition' => [ 'show_trust_ribbon' => 'yes' ],
		] );

		$this->add_control( 'trust_4_icon', [
			'label'     => __( 'Feature 4 Lucide Icon', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::TEXT,
			'default'   => 'banknote',
			'condition' => [ 'show_trust_ribbon' => 'yes' ],
		] );

		$this->end_controls_section();


		/* ══════════════════════════════════════════════
		   STYLE TAB: ATMOSPHERE & BACKGROUND
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_style_atmosphere', [
			'label' => __( 'Atmosphere & Glow', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'show_ambient_glow', [
			'label'        => __( 'Show Ambient Gold Glow', 'kinboni-pro' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'section_bg_color', [
			'label'     => __( 'Section Background Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .kb-hero-section' => 'background-color: {{VALUE}};',
			],
		] );

		$this->end_controls_section();


		/* ══════════════════════════════════════════════
		   STYLE TAB: MOSAIC GALLERY DIMENSIONS
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_style_mosaic', [
			'label' => __( 'Mosaic Dimensions & Height', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'mosaic_height', [
			'label'      => __( 'Mosaic Container Height', 'kinboni-pro' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'vh' ],
			'range'      => [
				'px' => [
					'min' => 250,
					'max' => 900,
				],
				'vh' => [
					'min' => 20,
					'max' => 100,
				],
			],
			'desktop_default' => [
				'size' => 560,
				'unit' => 'px',
			],
			'tablet_default'  => [
				'size' => 480,
				'unit' => 'px',
			],
			'mobile_default'  => [
				'size' => 380,
				'unit' => 'px',
			],
			'selectors'  => [
				'{{WRAPPER}} .kb-hero-mosaic' => 'height: {{SIZE}}{{UNIT}} !important;',
			],
		] );

		$this->add_responsive_control( 'mosaic_max_width', [
			'label'      => __( 'Mosaic Container Max Width', 'kinboni-pro' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range'      => [
				'px' => [
					'min' => 300,
					'max' => 1000,
				],
			],
			'selectors'  => [
				'{{WRAPPER}} .kb-hero-mosaic' => 'max-width: {{SIZE}}{{UNIT}} !important;',
			],
		] );

		$this->end_controls_section();


		/* ══════════════════════════════════════════════
		   STYLE TAB: TYPOGRAPHY & COLORS
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_style_typography', [
			'label' => __( 'Typography & Colors', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'headline_color', [
			'label'     => __( 'Headline Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .kb-hero-title' => 'color: {{VALUE}} !important;',
			],
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'headline_typography',
				'label'    => __( 'Headline Typography', 'kinboni-pro' ),
				'selector' => '{{WRAPPER}} .kb-hero-title',
			]
		);

		$this->add_control( 'description_color', [
			'label'     => __( 'Description Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .kb-hero-desc' => 'color: {{VALUE}} !important;',
			],
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'description_typography',
				'label'    => __( 'Description Typography', 'kinboni-pro' ),
				'selector' => '{{WRAPPER}} .kb-hero-desc',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Build complete product payload data for a specific mosaic slot.
	 * Resolves live WooCommerce product data if selected, with user overrides and luxury fallbacks.
	 *
	 * @param int   $slot     Slot index (1, 2, or 3).
	 * @param array $settings Widget settings.
	 * @return array
	 */
	private function get_slot_product_data( int $slot, array $settings ): array {
		$wc_id = isset( $settings[ "product_{$slot}_wc_id" ] ) ? absint( $settings[ "product_{$slot}_wc_id" ] ) : 0;

		// Editorial presets matching the luxury design system
		$defaults = [
			1 => [
				'id'            => 6,
				'name'          => 'Kyoto Mulberry Silk',
				'badge'         => 'Artisanal Weave',
				'price_raw'     => 4800,
				'price_display' => '৳4,800',
				'image'         => 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?auto=format&fit=crop&w=900&q=85',
				'gallery'       => [
					'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?auto=format&fit=crop&w=900&q=85',
					'https://images.unsplash.com/photo-1509319117193-57bab727e09d?auto=format&fit=crop&w=900&q=85',
				],
				'description'   => 'Hand-spun mulberry silk woven on wooden shuttle looms in Kyoto.',
				'categoryLabel' => 'Artisanal Weave',
				'specs'         => [ '100% Kyoto Mulberry Silk', 'Hand-rolled hem edges', 'Naturally dyed with botanicals' ],
				'rating'        => 5.0,
				'reviewsCount'  => 32,
			],
			2 => [
				'id'            => 1,
				'name'          => 'Chronos Royale',
				'badge'         => 'Swiss Movement',
				'price_raw'     => 18500,
				'price_display' => '৳18,500',
				'image'         => 'https://images.unsplash.com/photo-1523293182086-7651a899d37f?auto=format&fit=crop&w=600&q=85',
				'gallery'       => [
					'https://images.unsplash.com/photo-1523293182086-7651a899d37f?auto=format&fit=crop&w=600&q=85',
					'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?auto=format&fit=crop&w=600&q=85',
				],
				'description'   => 'Automatic mechanical chronometer with 42-hour power reserve.',
				'categoryLabel' => 'Swiss Movement',
				'specs'         => [ 'Swiss Automatic Calibre', 'Sapphire crystal front & back', 'Hand-stitched leather strap' ],
				'rating'        => 4.9,
				'reviewsCount'  => 48,
			],
			3 => [
				'id'            => 2,
				'name'          => 'Saddle Briefcase',
				'badge'         => 'Tuscan Leather',
				'price_raw'     => 14200,
				'price_display' => '৳14,200',
				'image'         => 'https://images.unsplash.com/photo-1524805444758-089113d48a6d?auto=format&fit=crop&w=600&q=85',
				'gallery'       => [
					'https://images.unsplash.com/photo-1524805444758-089113d48a6d?auto=format&fit=crop&w=600&q=85',
					'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?auto=format&fit=crop&w=600&q=85',
				],
				'description'   => 'Vegetable-tanned full grain Tuscan leather tailored for discerning patrons.',
				'categoryLabel' => 'Tuscan Leather',
				'specs'         => [ 'Vegetable-tanned full-grain leather', 'Solid brass hardware', 'Fits 15-inch laptop and folio' ],
				'rating'        => 4.8,
				'reviewsCount'  => 27,
			],
		];

		$data = $defaults[ $slot ] ?? $defaults[1];

		// If a real WooCommerce product is selected
		if ( $wc_id > 0 && function_exists( 'wc_get_product' ) ) {
			$product = wc_get_product( $wc_id );
			if ( $product ) {
				$data['id'] = $product->get_id();
				$data['name'] = $product->get_name();
				$data['price_raw'] = (float) $product->get_price();

				$curr = function_exists( 'get_woocommerce_currency_symbol' ) ? get_woocommerce_currency_symbol() : '৳';
				$data['price_display'] = $curr . number_format( (float) $product->get_price() );

				if ( $product->get_regular_price() && (float) $product->get_regular_price() > (float) $product->get_price() ) {
					$data['originalPrice'] = (float) $product->get_regular_price();
				}

				// Categories
				$cats = wp_get_post_terms( $product->get_id(), 'product_cat' );
				if ( ! empty( $cats ) && ! is_wp_error( $cats ) ) {
					$data['badge'] = $cats[0]->name;
					$data['categoryLabel'] = $cats[0]->name;
				}

				// Featured & Gallery Images
				$img_id = $product->get_image_id();
				if ( $img_id ) {
					$main_img = wp_get_attachment_image_url( $img_id, 'large' );
					if ( $main_img ) {
						$data['image'] = $main_img;
						$data['gallery'] = [ $main_img ];
					}
				}

				foreach ( $product->get_gallery_image_ids() as $gid ) {
					$gurl = wp_get_attachment_image_url( $gid, 'large' );
					if ( $gurl && ! in_array( $gurl, $data['gallery'], true ) ) {
						$data['gallery'][] = $gurl;
					}
				}

				$short_desc = $product->get_short_description();
				if ( ! empty( $short_desc ) ) {
					$data['description'] = wp_strip_all_tags( $short_desc );
				} elseif ( ! empty( $product->get_description() ) ) {
					$data['description'] = wp_strip_all_tags( $product->get_description() );
				}

				if ( $product->get_average_rating() ) {
					$data['rating'] = (float) $product->get_average_rating();
				}
				if ( $product->get_review_count() ) {
					$data['reviewsCount'] = $product->get_review_count();
				}
				$data['inStock'] = $product->is_in_stock();
			}
		}

		// User overrides from Elementor widget controls
		if ( ! empty( $settings[ "product_{$slot}_title" ] ) ) {
			$data['name'] = $settings[ "product_{$slot}_title" ];
		}
		if ( ! empty( $settings[ "product_{$slot}_badge" ] ) ) {
			$data['badge'] = $settings[ "product_{$slot}_badge" ];
			$data['categoryLabel'] = $settings[ "product_{$slot}_badge" ];
		}
		if ( ! empty( $settings[ "product_{$slot}_price" ] ) ) {
			$data['price_display'] = $settings[ "product_{$slot}_price" ];
		}
		if ( ! empty( $settings[ "product_{$slot}_image" ]['url'] ) ) {
			$data['image'] = $settings[ "product_{$slot}_image" ]['url'];
			if ( empty( $data['gallery'] ) ) {
				$data['gallery'] = [ $data['image'] ];
			} else {
				$data['gallery'][0] = $data['image'];
			}
		}

		$data['price'] = $data['price_raw'];
		$data['hoverImage'] = count( $data['gallery'] ) > 1 ? $data['gallery'][1] : $data['image'];

		return $data;
	}

	/* ─── Render ────────────────────────────────────────────── */

	protected function render(): void {
		$settings = $this->get_settings_for_display();

		// Resolve 3 product slots
		$p1 = $this->get_slot_product_data( 1, $settings );
		$p2 = $this->get_slot_product_data( 2, $settings );
		$p3 = $this->get_slot_product_data( 3, $settings );

		$p1_json = wp_json_encode( $p1 );
		$p2_json = wp_json_encode( $p2 );
		$p3_json = wp_json_encode( $p3 );
		?>
		<section id="hero" class="kb-hero-section relative overflow-hidden scroll-mt-24">
			<?php if ( 'yes' === $settings['show_ambient_glow'] ) : ?>
				<!-- Ambient Gold Glow Background -->
				<div class="absolute inset-0 bg-gradient-to-b from-gold-100/60 via-transparent to-transparent dark:from-gold-900/10 pointer-events-none"></div>
				<div class="absolute -top-32 right-1/4 w-96 h-96 bg-gold-400/10 rounded-full blur-3xl pointer-events-none"></div>
			<?php endif; ?>

			<div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-12 sm:pt-12 sm:pb-16 lg:pt-16 lg:pb-20">
				<div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-center">

					<!-- Left Column: Editorial Headline & Actions -->
					<div class="lg:col-span-6 text-center lg:text-left">
						<?php if ( ! empty( $settings['hero_subtitle_badge'] ) ) : ?>
							<p class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-[0.25em] text-gold-700 dark:text-gold-300">
								<?php if ( 'yes' === $settings['hero_show_gold_bar'] ) : ?>
									<span class="w-8 h-px bg-gold-500"></span>
								<?php endif; ?>
								<?php echo esc_html( $settings['hero_subtitle_badge'] ); ?>
							</p>
						<?php endif; ?>

						<?php if ( ! empty( $settings['hero_headline'] ) ) : ?>
							<h1 class="kb-hero-title mt-4 font-serif font-medium text-stone-900 dark:text-white tracking-tight leading-[1.04] text-4xl sm:text-6xl lg:text-[5.15rem]">
								<?php echo wp_kses_post( $settings['hero_headline'] ); ?>
							</h1>
						<?php endif; ?>

						<?php if ( ! empty( $settings['hero_description'] ) ) : ?>
							<p class="kb-hero-desc mt-5 text-base sm:text-lg text-stone-600 dark:text-stone-300 max-w-lg mx-auto lg:mx-0 leading-relaxed font-light">
								<?php echo esc_html( $settings['hero_description'] ); ?>
							</p>
						<?php endif; ?>

						<?php if ( 'yes' === $settings['show_btn_primary'] || 'yes' === $settings['show_btn_secondary'] ) : ?>
							<div class="mt-8 flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-3">
								<?php if ( 'yes' === $settings['show_btn_primary'] && ! empty( $settings['btn_primary_text'] ) ) : ?>
									<a href="<?php echo esc_url( $settings['btn_primary_url']['url'] ?? '#featured' ); ?>"
									   <?php echo ! empty( $settings['btn_primary_url']['is_external'] ) ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>
									   class="btn-primary rounded-full !px-8 w-full sm:w-auto">
										<?php echo esc_html( $settings['btn_primary_text'] ); ?>
									</a>
								<?php endif; ?>

								<?php if ( 'yes' === $settings['show_btn_secondary'] && ! empty( $settings['btn_secondary_text'] ) ) : ?>
									<a href="<?php echo esc_url( $settings['btn_secondary_url']['url'] ?? '#bestsellers' ); ?>"
									   <?php echo ! empty( $settings['btn_secondary_url']['is_external'] ) ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>
									   class="btn-outline rounded-full !px-8 w-full sm:w-auto">
										<?php echo esc_html( $settings['btn_secondary_text'] ); ?>
									</a>
								<?php endif; ?>
							</div>
						<?php endif; ?>

						<!-- Proof Metrics Bar -->
						<?php if ( 'yes' === $settings['show_metrics'] ) : ?>
							<div class="mt-10 pt-7 border-t border-stone-200 dark:border-stone-800 grid grid-cols-3 gap-4 max-w-md mx-auto lg:mx-0 text-left">
								<div>
									<p class="font-serif text-2xl sm:text-3xl font-semibold text-stone-900 dark:text-white"><?php echo esc_html( $settings['metric_1_val'] ); ?></p>
									<p class="text-[11px] sm:text-xs text-stone-500 dark:text-stone-400 mt-0.5"><?php echo esc_html( $settings['metric_1_label'] ); ?></p>
								</div>
								<div>
									<p class="font-serif text-2xl sm:text-3xl font-semibold text-stone-900 dark:text-white"><?php echo esc_html( $settings['metric_2_val'] ); ?></p>
									<p class="text-[11px] sm:text-xs text-stone-500 dark:text-stone-400 mt-0.5"><?php echo esc_html( $settings['metric_2_label'] ); ?></p>
								</div>
								<div>
									<p class="font-serif text-2xl sm:text-3xl font-semibold text-stone-900 dark:text-white"><?php echo esc_html( $settings['metric_3_val'] ); ?></p>
									<p class="text-[11px] sm:text-xs text-stone-500 dark:text-stone-400 mt-0.5"><?php echo esc_html( $settings['metric_3_label'] ); ?></p>
								</div>
							</div>
						<?php endif; ?>
					</div>

					<!-- Right Column: Editorial Mosaic Gallery with 3 Featured Products -->
					<div class="lg:col-span-6">
						<div class="kb-hero-mosaic grid grid-cols-12 grid-rows-6 gap-3 sm:gap-4 h-[380px] sm:h-[480px] lg:h-[560px] max-w-xl mx-auto">

							<!-- Featured Product 1: Main Arched Editorial Image (Silk & Cashmere) -->
							<div class="col-span-7 row-span-6 rounded-t-[999px] rounded-b-2xl overflow-hidden bg-stone-200 dark:bg-stone-900 shadow-xl border border-stone-200/60 dark:border-stone-800 group relative cursor-pointer"
								 data-product="<?php echo esc_attr( $p1_json ); ?>"
								 onclick="if(window.QuickViewController) QuickViewController.openProduct(this);"
								 title="<?php echo esc_attr( sprintf( __( 'Quick view %s', 'kinboni-pro' ), $p1['name'] ) ); ?>">
								<img 
									src="<?php echo esc_url( $p1['image'] ); ?>" 
									alt="<?php echo esc_attr( $p1['name'] ); ?> editorial" 
									class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" 
									style="height: 100% !important; width: 100% !important; object-fit: cover !important;"
								/>
								<div class="absolute inset-0 bg-gradient-to-t from-stone-950/60 via-transparent to-transparent pointer-events-none"></div>

								<!-- Floating Product Feature Card (Product 1) -->
								<button 
									type="button"
									data-product="<?php echo esc_attr( $p1_json ); ?>"
									onclick="event.stopPropagation(); if(window.QuickViewController) QuickViewController.openProduct(this);" 
									class="absolute inset-x-2.5 sm:inset-x-3.5 bottom-2.5 sm:bottom-3.5 rounded-xl bg-white/95 dark:bg-stone-900/95 backdrop-blur-md px-3 py-2 sm:px-3.5 sm:py-2.5 text-left hover:bg-gold-400 dark:hover:bg-gold-400 group/btn transition-all shadow-lg border border-stone-200/50 dark:border-stone-800/50 flex items-center justify-between gap-2"
									title="<?php echo esc_attr( sprintf( __( 'Quick view %s', 'kinboni-pro' ), $p1['name'] ) ); ?>"
								>
									<div class="min-w-0">
										<span class="block text-[9px] sm:text-[10px] font-bold text-gold-700 dark:text-gold-400 group-hover/btn:text-stone-950 transition-colors uppercase tracking-wider">
											<?php echo esc_html( $p1['badge'] ); ?> &bull; <?php echo esc_html( $p1['price_display'] ); ?>
										</span>
										<span class="block font-serif text-xs sm:text-sm font-semibold text-stone-900 dark:text-white group-hover/btn:text-stone-950 truncate transition-colors">
											<?php echo esc_html( $p1['name'] ); ?>
										</span>
									</div>
									<div class="w-6 h-6 sm:w-7 sm:h-7 rounded-full bg-stone-100 dark:bg-stone-800 group-hover/btn:bg-stone-950 group-hover/btn:text-white flex items-center justify-center flex-shrink-0 transition-colors shadow-sm">
										<i data-lucide="arrow-up-right" class="w-3.5 h-3.5"></i>
									</div>
								</button>
							</div>

							<!-- Featured Product 2: Top Right (Chronos Royale Watch) -->
							<div class="col-span-5 row-span-3 rounded-2xl overflow-hidden relative bg-stone-200 dark:bg-stone-900 shadow-md border border-stone-200/60 dark:border-stone-800 group cursor-pointer"
								 data-product="<?php echo esc_attr( $p2_json ); ?>"
								 onclick="if(window.QuickViewController) QuickViewController.openProduct(this);"
								 title="<?php echo esc_attr( sprintf( __( 'Quick view %s', 'kinboni-pro' ), $p2['name'] ) ); ?>">
								<img 
									src="<?php echo esc_url( $p2['image'] ); ?>" 
									alt="<?php echo esc_attr( $p2['name'] ); ?> detail" 
									class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" 
									style="height: 100% !important; width: 100% !important; object-fit: cover !important;"
								/>
								<div class="absolute inset-0 bg-gradient-to-t from-stone-950/50 via-transparent to-transparent pointer-events-none"></div>

								<!-- Floating Product Feature Card (Product 2) -->
								<button 
									type="button"
									data-product="<?php echo esc_attr( $p2_json ); ?>"
									onclick="event.stopPropagation(); if(window.QuickViewController) QuickViewController.openProduct(this);" 
									class="absolute inset-x-2 bottom-2 rounded-xl bg-white/95 dark:bg-stone-900/95 backdrop-blur-md px-2.5 py-1.5 sm:px-3 sm:py-2 text-left hover:bg-gold-400 dark:hover:bg-gold-400 group/btn transition-all shadow-sm border border-stone-200/50 dark:border-stone-800/50 flex items-center justify-between gap-1.5"
									title="<?php echo esc_attr( sprintf( __( 'Quick view %s', 'kinboni-pro' ), $p2['name'] ) ); ?>"
								>
									<div class="min-w-0">
										<span class="block text-[9px] sm:text-[10px] font-bold text-gold-700 dark:text-gold-400 group-hover/btn:text-stone-950 transition-colors uppercase tracking-wider">
											<?php echo esc_html( $p2['badge'] ); ?> &bull; <?php echo esc_html( $p2['price_display'] ); ?>
										</span>
										<span class="block font-serif text-xs sm:text-sm font-semibold text-stone-900 dark:text-white group-hover/btn:text-stone-950 truncate transition-colors">
											<?php echo esc_html( $p2['name'] ); ?>
										</span>
									</div>
									<div class="w-5 h-5 sm:w-6 sm:h-6 rounded-full bg-stone-100 dark:bg-stone-800 group-hover/btn:bg-stone-950 group-hover/btn:text-white flex items-center justify-center flex-shrink-0 transition-colors">
										<i data-lucide="arrow-up-right" class="w-3 h-3"></i>
									</div>
								</button>
							</div>

							<!-- Featured Product 3: Bottom Right (Saddle Leather Briefcase) -->
							<div class="col-span-5 row-span-3 rounded-2xl overflow-hidden relative bg-stone-200 dark:bg-stone-900 shadow-md border border-stone-200/60 dark:border-stone-800 group cursor-pointer"
								 data-product="<?php echo esc_attr( $p3_json ); ?>"
								 onclick="if(window.QuickViewController) QuickViewController.openProduct(this);"
								 title="<?php echo esc_attr( sprintf( __( 'Quick view %s', 'kinboni-pro' ), $p3['name'] ) ); ?>">
								<img 
									src="<?php echo esc_url( $p3['image'] ); ?>" 
									alt="<?php echo esc_attr( $p3['name'] ); ?> detail" 
									class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" 
									style="height: 100% !important; width: 100% !important; object-fit: cover !important;"
								/>
								<div class="absolute inset-0 bg-gradient-to-t from-stone-950/50 via-transparent to-transparent pointer-events-none"></div>

								<!-- Floating Product Feature Card (Product 3) -->
								<button 
									type="button"
									data-product="<?php echo esc_attr( $p3_json ); ?>"
									onclick="event.stopPropagation(); if(window.QuickViewController) QuickViewController.openProduct(this);" 
									class="absolute inset-x-2 bottom-2 rounded-xl bg-white/95 dark:bg-stone-900/95 backdrop-blur-md px-2.5 py-1.5 sm:px-3 sm:py-2 text-left hover:bg-gold-400 dark:hover:bg-gold-400 group/btn transition-all shadow-sm border border-stone-200/50 dark:border-stone-800/50 flex items-center justify-between gap-1.5"
									title="<?php echo esc_attr( sprintf( __( 'Quick view %s', 'kinboni-pro' ), $p3['name'] ) ); ?>"
								>
									<div class="min-w-0">
										<span class="block text-[9px] sm:text-[10px] font-bold text-gold-700 dark:text-gold-400 group-hover/btn:text-stone-950 transition-colors uppercase tracking-wider">
											<?php echo esc_html( $p3['badge'] ); ?> &bull; <?php echo esc_html( $p3['price_display'] ); ?>
										</span>
										<span class="block font-serif text-xs sm:text-sm font-semibold text-stone-900 dark:text-white group-hover/btn:text-stone-950 truncate transition-colors">
											<?php echo esc_html( $p3['name'] ); ?>
										</span>
									</div>
									<div class="w-5 h-5 sm:w-6 sm:h-6 rounded-full bg-stone-100 dark:bg-stone-800 group-hover/btn:bg-stone-950 group-hover/btn:text-white flex items-center justify-center flex-shrink-0 transition-colors">
										<i data-lucide="arrow-up-right" class="w-3 h-3"></i>
									</div>
								</button>
							</div>

						</div>
					</div>

				</div>
			</div>

			<!-- Trust Ribbon Under Hero -->
			<?php if ( 'yes' === $settings['show_trust_ribbon'] ) : ?>
				<div class="border-y border-stone-200 dark:border-stone-800 bg-white/70 dark:bg-stone-950/70 backdrop-blur-sm">
					<ul class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 grid grid-cols-2 lg:grid-cols-4 gap-4 text-xs sm:text-sm font-medium text-stone-700 dark:text-stone-300">
						<?php if ( ! empty( $settings['trust_1_text'] ) ) : ?>
							<li class="flex items-center gap-2.5">
								<i data-lucide="<?php echo esc_attr( $settings['trust_1_icon'] ?: 'truck' ); ?>" class="w-5 h-5 text-gold-600 dark:text-gold-400 flex-shrink-0"></i>
								<span><?php echo esc_html( $settings['trust_1_text'] ); ?></span>
							</li>
						<?php endif; ?>

						<?php if ( ! empty( $settings['trust_2_text'] ) ) : ?>
							<li class="flex items-center gap-2.5">
								<i data-lucide="<?php echo esc_attr( $settings['trust_2_icon'] ?: 'shield-check' ); ?>" class="w-5 h-5 text-gold-600 dark:text-gold-400 flex-shrink-0"></i>
								<span><?php echo esc_html( $settings['trust_2_text'] ); ?></span>
							</li>
						<?php endif; ?>

						<?php if ( ! empty( $settings['trust_3_text'] ) ) : ?>
							<li class="flex items-center gap-2.5">
								<i data-lucide="<?php echo esc_attr( $settings['trust_3_icon'] ?: 'refresh-cw' ); ?>" class="w-5 h-5 text-gold-600 dark:text-gold-400 flex-shrink-0"></i>
								<span><?php echo esc_html( $settings['trust_3_text'] ); ?></span>
							</li>
						<?php endif; ?>

						<?php if ( ! empty( $settings['trust_4_text'] ) ) : ?>
							<li class="flex items-center gap-2.5">
								<i data-lucide="<?php echo esc_attr( $settings['trust_4_icon'] ?: 'banknote' ); ?>" class="w-5 h-5 text-gold-600 dark:text-gold-400 flex-shrink-0"></i>
								<span><?php echo esc_html( $settings['trust_4_text'] ); ?></span>
							</li>
						<?php endif; ?>
					</ul>
				</div>
			<?php endif; ?>
		</section>
		<?php
	}
}
