<?php
namespace KinboniPro\Widgets;

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
	return;
}

class Widget_Promo_Banner extends \Elementor\Widget_Base {

	/* ─── Identity ──────────────────────────────────────────── */

	public function get_name(): string {
		return 'kinboni_promo_banner';
	}

	public function get_title(): string {
		return __( 'KINBONI — Promotional Privilege Banner', 'kinboni-pro' );
	}

	public function get_icon(): string {
		return 'eicon-call-to-action';
	}

	public function get_categories(): array {
		return [ 'kinboni' ];
	}

	public function get_keywords(): array {
		return [ 'kinboni', 'promo', 'banner', 'privilege', 'code', 'coupon', 'discount', 'sale', 'archive', 'luxury' ];
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
		   1. EDITORIAL COPY & HEADLINE
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_promo_content', [
			'label' => __( 'Editorial Headline & Copy', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'show_badge', [
			'label'        => __( 'Show Privilege Badge', 'kinboni-pro' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'badge_text', [
			'label'       => __( 'Badge Text', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => __( 'Private Mid-Season Archive', 'kinboni-pro' ),
			'label_block' => true,
			'condition'   => [ 'show_badge' => 'yes' ],
		] );

		$this->add_control( 'headline', [
			'label'       => __( 'Main Headline (H2)', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXTAREA,
			'rows'        => 2,
			'default'     => __( 'Claim 20% Privilege on Exceptional Handcrafted Goods', 'kinboni-pro' ),
			'label_block' => true,
		] );

		$this->add_control( 'description', [
			'label'       => __( 'Description Copy', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::WYSIWYG,
			'default'     => __( 'Enter private code <strong class="text-gold-400 font-bold tracking-wider">LUXE20</strong> at checkout to redeem complimentary discount privileges across all full-grain leather pieces and Swiss chronographs.', 'kinboni-pro' ),
		] );

		$this->add_control( 'section_id', [
			'label'       => __( 'Section Anchor ID', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'promotional-banner',
			'description' => __( 'ID used for direct anchor links and smooth scrolling.', 'kinboni-pro' ),
		] );

		$this->end_controls_section();

		/* ══════════════════════════════════════════════
		   2. PRIVILEGE CODE & ACTION CARD
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_promo_code_box', [
			'label' => __( 'Privilege Code Card', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'box_title', [
			'label'   => __( 'Card Header Title', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => __( 'Privilege Code', 'kinboni-pro' ),
		] );

		$this->add_control( 'promo_code', [
			'label'       => __( 'Coupon / Privilege Code', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'LUXE20',
			'description' => __( 'The exact coupon code copied when patrons click the button.', 'kinboni-pro' ),
		] );

		$this->add_control( 'copy_tooltip', [
			'label'   => __( 'Copy Tooltip Text', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => __( 'Click to copy code', 'kinboni-pro' ),
		] );

		$this->add_control( 'copy_icon', [
			'label'   => __( 'Copy Button Lucide Icon', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'copy',
		] );

		$this->add_control( 'cta_button_text', [
			'label'       => __( 'CTA Button Text', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => __( 'Shop Private Archive', 'kinboni-pro' ),
			'label_block' => true,
		] );

		$this->add_control( 'cta_action', [
			'label'   => __( 'CTA Button Action', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'filter_sale',
			'options' => [
				'filter_sale' => __( 'Filter Best Sellers & Scroll to Catalog', 'kinboni-pro' ),
				'custom_url'  => __( 'Navigate to Custom URL / Shop Page', 'kinboni-pro' ),
				'scroll_only' => __( 'Smooth Scroll to Section ID Only', 'kinboni-pro' ),
			],
		] );

		$this->add_control( 'custom_link', [
			'label'       => __( 'Custom Link URL', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::URL,
			'placeholder' => __( 'https://example.com/shop', 'kinboni-pro' ),
			'condition'   => [ 'cta_action' => 'custom_url' ],
		] );

		$this->add_control( 'bestsellers_section_id', [
			'label'       => __( 'Catalog Section ID', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'bestsellers',
			'condition'   => [ 'cta_action' => 'filter_sale' ],
		] );

		$this->add_control( 'sale_filter_slug', [
			'label'       => __( 'Catalog Filter Category', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'sale',
			'description' => __( 'Category tab slug to activate (e.g. sale, watches, leather).', 'kinboni-pro' ),
			'condition'   => [ 'cta_action' => 'filter_sale' ],
		] );

		$this->add_control( 'scroll_target_id', [
			'label'       => __( 'Scroll Target Section ID', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'bestsellers',
			'condition'   => [ 'cta_action' => 'scroll_only' ],
		] );

		$this->end_controls_section();

		/* ══════════════════════════════════════════════
		   3. BACKGROUND & VISUAL EFFECTS
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_visual_effects', [
			'label' => __( 'Background & Ambient Glow', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'show_dot_pattern', [
			'label'        => __( 'Show Gold Radial Dot Pattern', 'kinboni-pro' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'pattern_color', [
			'label'     => __( 'Pattern Dot Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#D4AF37',
			'condition' => [ 'show_dot_pattern' => 'yes' ],
		] );

		$this->add_control( 'pattern_opacity', [
			'label'      => __( 'Pattern Opacity', 'kinboni-pro' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [
				'px' => [ 'min' => 0.05, 'max' => 1, 'step' => 0.05 ],
			],
			'default'    => [ 'unit' => 'px', 'size' => 0.20 ],
			'selectors'  => [
				'{{WRAPPER}} .kb-promo-pattern' => 'opacity: {{SIZE}} !important;',
			],
			'condition'  => [ 'show_dot_pattern' => 'yes' ],
		] );

		$this->add_control( 'show_ambient_glow', [
			'label'        => __( 'Show Ambient Gold Glow', 'kinboni-pro' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'glow_color', [
			'label'     => __( 'Ambient Glow Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'rgba(212, 175, 55, 0.10)',
			'selectors' => [
				'{{WRAPPER}} .kb-promo-glow' => 'background-color: {{VALUE}} !important;',
			],
			'condition' => [ 'show_ambient_glow' => 'yes' ],
		] );

		$this->end_controls_section();

		/* ══════════════════════════════════════════════
		   4. STYLE: SECTION & LAYOUT
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_style_general', [
			'label' => __( 'Section Background & Spacing', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'section_bg_color', [
			'label'     => __( 'Background Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#1c1917',
			'selectors' => [ '{{WRAPPER}} .kb-promo-section' => 'background-color: {{VALUE}} !important;' ],
		] );

		$this->add_responsive_control( 'section_padding', [
			'label'      => __( 'Section Padding', 'kinboni-pro' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', 'rem', '%' ],
			'default'    => [
				'top'      => '5',
				'bottom'   => '5',
				'left'     => '0',
				'right'    => '0',
				'unit'     => 'rem',
				'isLinked' => false,
			],
			'selectors'  => [
				'{{WRAPPER}} .kb-promo-section' => 'padding-top: {{TOP}}{{UNIT}}; padding-bottom: {{BOTTOM}}{{UNIT}}; padding-left: {{LEFT}}{{UNIT}}; padding-right: {{RIGHT}}{{UNIT}};',
			],
		] );

		$this->end_controls_section();

		/* ══════════════════════════════════════════════
		   5. STYLE: BADGE & HEADLINE
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_style_typography', [
			'label' => __( 'Badge, Headline & Description', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'badge_color', [
			'label'     => __( 'Badge Text Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-promo-badge' => 'color: {{VALUE}} !important;' ],
		] );

		$this->add_control( 'badge_bg_color', [
			'label'     => __( 'Badge Background Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-promo-badge' => 'background-color: {{VALUE}} !important;' ],
		] );

		$this->add_control( 'badge_border_color', [
			'label'     => __( 'Badge Border Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-promo-badge' => 'border-color: {{VALUE}} !important;' ],
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'badge_typography',
				'label'    => __( 'Badge Typography', 'kinboni-pro' ),
				'selector' => '{{WRAPPER}} .kb-promo-badge',
			]
		);

		$this->add_control( 'headline_heading', [
			'label'     => __( 'Headline', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'headline_color', [
			'label'     => __( 'Headline Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#ffffff',
			'selectors' => [ '{{WRAPPER}} .kb-promo-headline' => 'color: {{VALUE}} !important;' ],
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'headline_typography',
				'label'    => __( 'Headline Typography', 'kinboni-pro' ),
				'selector' => '{{WRAPPER}} .kb-promo-headline',
			]
		);

		$this->add_control( 'desc_heading', [
			'label'     => __( 'Description', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'desc_color', [
			'label'     => __( 'Description Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#a8a29e',
			'selectors' => [ '{{WRAPPER}} .kb-promo-desc' => 'color: {{VALUE}} !important;' ],
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'desc_typography',
				'label'    => __( 'Description Typography', 'kinboni-pro' ),
				'selector' => '{{WRAPPER}} .kb-promo-desc',
			]
		);

		$this->end_controls_section();

		/* ══════════════════════════════════════════════
		   6. STYLE: PRIVILEGE CODE CARD & BUTTONS
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_style_code_card', [
			'label' => __( 'Privilege Card & CTA Buttons', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'card_bg_color', [
			'label'     => __( 'Card Background Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-promo-box' => 'background-color: {{VALUE}} !important;' ],
		] );

		$this->add_control( 'card_border_color', [
			'label'     => __( 'Card Border Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-promo-box' => 'border-color: {{VALUE}} !important;' ],
		] );

		$this->add_control( 'card_title_color', [
			'label'     => __( 'Card Title Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-promo-box-title' => 'color: {{VALUE}} !important;' ],
		] );

		$this->add_control( 'code_btn_heading', [
			'label'     => __( 'Promo Code Button', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'code_text_color', [
			'label'     => __( 'Code Text Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#c5a059',
			'selectors' => [ '{{WRAPPER}} .kb-promo-code-btn' => 'color: {{VALUE}} !important;' ],
		] );

		$this->add_control( 'code_bg_color', [
			'label'     => __( 'Code Background Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-promo-code-btn' => 'background-color: {{VALUE}} !important;' ],
		] );

		$this->add_control( 'code_border_color', [
			'label'     => __( 'Code Border Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-promo-code-btn' => 'border-color: {{VALUE}} !important;' ],
		] );

		$this->add_control( 'cta_btn_heading', [
			'label'     => __( 'CTA Action Button', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'cta_btn_bg', [
			'label'     => __( 'Button Background Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#c5a059',
			'selectors' => [ '{{WRAPPER}} .kb-promo-cta-btn' => 'background-color: {{VALUE}} !important;' ],
		] );

		$this->add_control( 'cta_btn_hover_bg', [
			'label'     => __( 'Button Hover Background', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#d4af37',
			'selectors' => [ '{{WRAPPER}} .kb-promo-cta-btn:hover' => 'background-color: {{VALUE}} !important;' ],
		] );

		$this->add_control( 'cta_btn_text_color', [
			'label'     => __( 'Button Text Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#0c0a09',
			'selectors' => [ '{{WRAPPER}} .kb-promo-cta-btn' => 'color: {{VALUE}} !important;' ],
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'cta_btn_typography',
				'label'    => __( 'Button Typography', 'kinboni-pro' ),
				'selector' => '{{WRAPPER}} .kb-promo-cta-btn',
			]
		);

		$this->end_controls_section();
	}

	/* ─── Render ────────────────────────────────────────────── */

	protected function render(): void {
		$s = $this->get_settings_for_display();

		$section_id    = ! empty( $s['section_id'] ) ? esc_attr( $s['section_id'] ) : 'promotional-banner';
		$promo_code    = ! empty( $s['promo_code'] ) ? trim( $s['promo_code'] ) : 'LUXE20';
		$copy_tooltip  = ! empty( $s['copy_tooltip'] ) ? esc_attr( $s['copy_tooltip'] ) : __( 'Click to copy code', 'kinboni-pro' );
		$copy_icon     = ! empty( $s['copy_icon'] ) ? esc_attr( $s['copy_icon'] ) : 'copy';
		$pattern_color = ! empty( $s['pattern_color'] ) ? esc_attr( $s['pattern_color'] ) : '#D4AF37';

		$cta_action    = $s['cta_action'] ?? 'filter_sale';
		$catalog_id    = ! empty( $s['bestsellers_section_id'] ) ? esc_attr( $s['bestsellers_section_id'] ) : 'bestsellers';
		$filter_slug   = ! empty( $s['sale_filter_slug'] ) ? esc_attr( $s['sale_filter_slug'] ) : 'sale';
		$scroll_id     = ! empty( $s['scroll_target_id'] ) ? esc_attr( $s['scroll_target_id'] ) : 'bestsellers';

		$custom_link   = $s['custom_link'] ?? [];
		$custom_url    = ! empty( $custom_link['url'] ) ? esc_url( $custom_link['url'] ) : '#';
		$custom_target = ! empty( $custom_link['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
		$widget_id     = $this->get_id();
		?>

		<section id="<?php echo $section_id; ?>" class="kb-promo-section relative py-20 bg-stone-900 text-stone-100 overflow-hidden scroll-mt-24">
			
			<!-- Luxury Radial Dot Pattern Overlay -->
			<?php if ( 'yes' === ( $s['show_dot_pattern'] ?? 'yes' ) ) : ?>
				<div 
					class="kb-promo-pattern absolute inset-0 pointer-events-none"
					style="opacity: 0.20; background-image: radial-gradient(<?php echo $pattern_color; ?> 1px, transparent 1px); background-size: 16px 16px;"
				></div>
			<?php endif; ?>

			<!-- Ambient Gold Glow Accent -->
			<?php if ( 'yes' === ( $s['show_ambient_glow'] ?? 'yes' ) ) : ?>
				<div class="kb-promo-glow absolute top-0 right-0 w-80 h-80 bg-gold-500/10 rounded-full blur-3xl pointer-events-none"></div>
			<?php endif; ?>

			<div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
					
					<!-- Left Editorial Column -->
					<div class="lg:col-span-8 text-center lg:text-left space-y-4">
						<?php if ( 'yes' === ( $s['show_badge'] ?? 'yes' ) && ! empty( $s['badge_text'] ) ) : ?>
							<span class="kb-promo-badge inline-block px-3 py-1 rounded-full bg-gold-500/20 border border-gold-500/40 text-gold-300 text-[10px] font-bold uppercase tracking-widest">
								<?php echo esc_html( $s['badge_text'] ); ?>
							</span>
						<?php endif; ?>

						<?php if ( ! empty( $s['headline'] ) ) : ?>
							<h2 class="kb-promo-headline font-serif text-3xl sm:text-4xl lg:text-5xl font-medium text-white leading-tight">
								<?php echo esc_html( $s['headline'] ); ?>
							</h2>
						<?php endif; ?>

						<?php if ( ! empty( $s['description'] ) ) : ?>
							<div class="kb-promo-desc text-stone-400 text-sm sm:text-base max-w-2xl font-light">
								<?php echo wp_kses_post( $s['description'] ); ?>
							</div>
						<?php endif; ?>
					</div>

					<!-- Right Privilege Card Column -->
					<div class="lg:col-span-4 flex flex-col items-center lg:items-end justify-center">
						<div class="kb-promo-box p-6 sm:p-7 rounded-2xl bg-stone-800/90 backdrop-blur-md border border-stone-700/80 text-center w-full max-w-sm shadow-2xl">
							
							<?php if ( ! empty( $s['box_title'] ) ) : ?>
								<span class="kb-promo-box-title text-xs uppercase tracking-widest text-stone-400 font-semibold block mb-2">
									<?php echo esc_html( $s['box_title'] ); ?>
								</span>
							<?php endif; ?>

							<!-- Click to Copy Promo Code Button -->
							<?php if ( ! empty( $promo_code ) ) : ?>
								<button 
									type="button" 
									onclick="if(window.copyPromoCode){window.copyPromoCode('<?php echo esc_js( $promo_code ); ?>');}else if(navigator.clipboard){navigator.clipboard.writeText('<?php echo esc_js( $promo_code ); ?>');}" 
									class="kb-promo-code-btn w-full py-3 px-4 rounded-xl bg-stone-950 border border-gold-500/60 text-gold-400 font-mono text-lg font-bold tracking-widest mb-4 flex items-center justify-center gap-2 hover:bg-stone-900 hover:border-gold-400 transition-all group active:scale-98"
									title="<?php echo $copy_tooltip; ?>"
								>
									<span><?php echo esc_html( $promo_code ); ?></span>
									<i data-lucide="<?php echo $copy_icon; ?>" class="w-4 h-4 text-stone-500 group-hover:text-gold-400 transition-colors"></i>
								</button>
							<?php endif; ?>

							<!-- CTA Action Button -->
							<?php if ( ! empty( $s['cta_button_text'] ) ) : ?>
								<?php if ( 'custom_url' === $cta_action ) : ?>
									<a 
										href="<?php echo $custom_url; ?>"<?php echo $custom_target; ?> 
										class="kb-promo-cta-btn w-full inline-block py-3 px-6 bg-gold-400 hover:bg-gold-500 text-stone-950 text-xs font-bold uppercase tracking-widest rounded-xl shadow-md hover:shadow-gold-500/25 transition-all text-center active:scale-95"
									>
										<?php echo esc_html( $s['cta_button_text'] ); ?>
									</a>
								<?php elseif ( 'scroll_only' === $cta_action ) : ?>
									<button 
										type="button" 
										onclick="const target=document.getElementById('<?php echo esc_js( $scroll_id ); ?>');if(target){target.scrollIntoView({behavior:'smooth'});}"
										class="kb-promo-cta-btn w-full inline-block py-3 px-6 bg-gold-400 hover:bg-gold-500 text-stone-950 text-xs font-bold uppercase tracking-widest rounded-xl shadow-md hover:shadow-gold-500/25 transition-all text-center active:scale-95"
									>
										<?php echo esc_html( $s['cta_button_text'] ); ?>
									</button>
								<?php else : ?>
									<button 
										type="button" 
										onclick="if(window.ProductRenderer&&ProductRenderer.renderBestSellers){ProductRenderer.renderBestSellers('<?php echo esc_js( $filter_slug ); ?>');}const target=document.getElementById('<?php echo esc_js( $catalog_id ); ?>');if(target){target.scrollIntoView({behavior:'smooth'});}"
										class="kb-promo-cta-btn w-full inline-block py-3 px-6 bg-gold-400 hover:bg-gold-500 text-stone-950 text-xs font-bold uppercase tracking-widest rounded-xl shadow-md hover:shadow-gold-500/25 transition-all text-center active:scale-95"
									>
										<?php echo esc_html( $s['cta_button_text'] ); ?>
									</button>
								<?php endif; ?>
							<?php endif; ?>

						</div>
					</div>

				</div>
			</div>
		</section>

		<script>
		(function() {
			function initPromoBanner<?php echo esc_attr( str_replace( '-', '_', $widget_id ) ); ?>() {
				if (typeof lucide !== 'undefined' && lucide.createIcons) {
					lucide.createIcons();
				}
			}
			if (document.readyState === 'loading') {
				document.addEventListener('DOMContentLoaded', initPromoBanner<?php echo esc_attr( str_replace( '-', '_', $widget_id ) ); ?>);
			} else {
				initPromoBanner<?php echo esc_attr( str_replace( '-', '_', $widget_id ) ); ?>();
			}
		})();
		</script>
		<?php
	}
}

