<?php
namespace KinboniPro\Widgets;

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
	return;
}

class Widget_Heritage extends \Elementor\Widget_Base {

	/* ─── Identity ──────────────────────────────────────────── */

	public function get_name(): string {
		return 'kinboni_heritage';
	}

	public function get_title(): string {
		return __( 'KINBONI — Heritage & Brand Story', 'kinboni-pro' );
	}

	public function get_icon(): string {
		return 'eicon-history';
	}

	public function get_categories(): array {
		return [ 'kinboni' ];
	}

	public function get_keywords(): array {
		return [ 'kinboni', 'heritage', 'story', 'brand', 'about', 'craftsmanship', 'pillars', 'luxury', 'atelier' ];
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
		   1. EDITORIAL IMAGERY & FLOATING STAMP
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_heritage_image', [
			'label' => __( 'Editorial Imagery & Floating Stamp', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'layout_direction', [
			'label'   => __( 'Layout Order', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'img_left',
			'options' => [
				'img_left'  => __( 'Image Left, Text Right (Default)', 'kinboni-pro' ),
				'img_right' => __( 'Text Left, Image Right', 'kinboni-pro' ),
			],
		] );

		$this->add_control( 'main_image', [
			'label'   => __( 'Main Studio Image', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::MEDIA,
			'default' => [
				'url' => 'https://images.unsplash.com/photo-1558769132-cb1aea458c5e?auto=format&fit=crop&w=1000&q=85',
			],
		] );

		$this->add_control( 'image_alt', [
			'label'   => __( 'Image Alt Text', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => __( 'Artisan craftsmanship leather studio', 'kinboni-pro' ),
		] );

		$this->add_control( 'show_floating_stamp', [
			'label'        => __( 'Show Floating Guarantee Stamp', 'kinboni-pro' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'stamp_icon', [
			'label'     => __( 'Stamp Lucide Icon', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::TEXT,
			'default'   => 'shield-check',
			'condition' => [ 'show_floating_stamp' => 'yes' ],
		] );

		$this->add_control( 'stamp_title', [
			'label'     => __( 'Stamp Title', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::TEXT,
			'default'   => __( 'Master Guild', 'kinboni-pro' ),
			'condition' => [ 'show_floating_stamp' => 'yes' ],
		] );

		$this->add_control( 'stamp_subtitle', [
			'label'     => __( 'Stamp Subtitle', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::TEXT,
			'default'   => __( 'Unconditional Lifetime Guarantee', 'kinboni-pro' ),
			'condition' => [ 'show_floating_stamp' => 'yes' ],
		] );

		$this->end_controls_section();


		/* ══════════════════════════════════════════════
		   2. EDITORIAL STORY COPY
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_heritage_copy', [
			'label' => __( 'Editorial Story Copy', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'tag_text', [
			'label'   => __( 'Section Tag', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => __( 'Our Heritage', 'kinboni-pro' ),
		] );

		$this->add_control( 'headline', [
			'label'       => __( 'Main Headline (H2)', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => __( 'Where Ancient Mastery Meets Contemporary Refinement', 'kinboni-pro' ),
			'label_block' => true,
		] );

		$this->add_control( 'show_gold_bar', [
			'label'        => __( 'Show Gold Accent Line', 'kinboni-pro' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'paragraph_1', [
			'label'       => __( 'Story Paragraph 1', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXTAREA,
			'rows'        => 3,
			'default'     => __( 'Founded with a singular vision to resist the ephemeral nature of fast consumption, <strong class="font-semibold text-stone-900 dark:text-stone-100">KINBONI Atelier</strong> crafts enduring artifacts designed to acquire character with age.', 'kinboni-pro' ),
			'label_block' => true,
		] );

		$this->add_control( 'paragraph_2', [
			'label'       => __( 'Story Paragraph 2', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXTAREA,
			'rows'        => 3,
			'default'     => __( 'Every stitch is cast with waxed French linen thread; every horological movement is individually tuned by master watchmakers; and each perfume is compounded in small batches using sustainably harvested natural botanical extraits.', 'kinboni-pro' ),
			'label_block' => true,
		] );

		$this->end_controls_section();


		/* ══════════════════════════════════════════════
		   3. CRAFTSMANSHIP PILLARS REPEATER
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_heritage_pillars', [
			'label' => __( 'Craftsmanship Pillars', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$repeater = new \Elementor\Repeater();

		$repeater->add_control( 'pillar_number', [
			'label'   => __( 'Number (e.g. 01, 02)', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => '01',
		] );

		$repeater->add_control( 'pillar_title', [
			'label'   => __( 'Pillar Title', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'Ethical Origin',
		] );

		$repeater->add_control( 'pillar_description', [
			'label'   => __( 'Pillar Description', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::TEXTAREA,
			'rows'    => 2,
			'default' => 'Traceable Tuscan leathers & certified metals.',
		] );

		$this->add_control( 'pillars', [
			'label'       => __( 'Pillars List', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'default'     => [
				[
					'pillar_number'      => '01',
					'pillar_title'       => 'Ethical Origin',
					'pillar_description' => 'Traceable Tuscan leathers & certified metals.',
				],
				[
					'pillar_number'      => '02',
					'pillar_title'       => 'Zero Plastic',
					'pillar_description' => '100% biodegradable luxury gift packaging.',
				],
				[
					'pillar_number'      => '03',
					'pillar_title'       => 'Bespoke Care',
					'pillar_description' => 'Lifetime complimentary refurbishment.',
				],
			],
			'title_field' => '{{{ pillar_number }}} — {{{ pillar_title }}}',
		] );

		$this->end_controls_section();


		/* ══════════════════════════════════════════════
		   4. CALL TO ACTION LINK
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_heritage_cta', [
			'label' => __( 'Call to Action Link', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'show_cta', [
			'label'        => __( 'Show CTA Link', 'kinboni-pro' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'cta_text', [
			'label'     => __( 'Link Text', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::TEXT,
			'default'   => __( 'Explore The Atelier Archive', 'kinboni-pro' ),
			'condition' => [ 'show_cta' => 'yes' ],
		] );

		$this->add_control( 'cta_url', [
			'label'       => __( 'Link URL', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::URL,
			'default'     => [ 'url' => '#featured' ],
			'placeholder' => '#featured or https://...',
			'condition'   => [ 'show_cta' => 'yes' ],
		] );

		$this->add_control( 'cta_icon', [
			'label'     => __( 'Link Lucide Icon', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::TEXT,
			'default'   => 'arrow-right',
			'condition' => [ 'show_cta' => 'yes' ],
		] );

		$this->end_controls_section();


		/* ══════════════════════════════════════════════
		   STYLE TAB: BACKGROUND & SECTION
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_style_section', [
			'label' => __( 'Background & Padding', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'section_bg_color', [
			'label'     => __( 'Background Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-heritage-section' => 'background-color: {{VALUE}} !important;' ],
		] );

		$this->add_control( 'section_border_color', [
			'label'     => __( 'Top & Bottom Border Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .kb-heritage-section' => 'border-top-color: {{VALUE}} !important; border-bottom-color: {{VALUE}} !important;',
			],
		] );

		$this->add_responsive_control( 'section_padding', [
			'label'      => __( 'Padding', 'kinboni-pro' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', '%' ],
			'selectors'  => [ '{{WRAPPER}} .kb-heritage-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->end_controls_section();


		/* ══════════════════════════════════════════════
		   STYLE TAB: TYPOGRAPHY & COLORS
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_style_typography', [
			'label' => __( 'Typography & Colors', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'tag_color', [
			'label'     => __( 'Tag Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-heritage-tag' => 'color: {{VALUE}} !important;' ],
		] );

		$this->add_control( 'headline_color', [
			'label'     => __( 'Headline Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-heritage-title' => 'color: {{VALUE}} !important;' ],
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'headline_typo',
				'label'    => __( 'Headline Typography', 'kinboni-pro' ),
				'selector' => '{{WRAPPER}} .kb-heritage-title',
			]
		);

		$this->add_control( 'gold_bar_color', [
			'label'     => __( 'Gold Accent Bar Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-heritage-gold-bar' => 'background-color: {{VALUE}} !important;' ],
		] );

		$this->add_control( 'body_text_color', [
			'label'     => __( 'Paragraph Text Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-heritage-p' => 'color: {{VALUE}} !important;' ],
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'body_typo',
				'label'    => __( 'Paragraph Typography', 'kinboni-pro' ),
				'selector' => '{{WRAPPER}} .kb-heritage-p',
			]
		);

		$this->end_controls_section();


		/* ══════════════════════════════════════════════
		   STYLE TAB: CRAFTSMANSHIP PILLARS
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_style_pillars', [
			'label' => __( 'Pillars Cards', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'pillar_card_bg', [
			'label'     => __( 'Card Background Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-pillar-card' => 'background-color: {{VALUE}} !important;' ],
		] );

		$this->add_control( 'pillar_card_border', [
			'label'     => __( 'Card Border Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-pillar-card' => 'border-color: {{VALUE}} !important;' ],
		] );

		$this->add_control( 'pillar_num_color', [
			'label'     => __( 'Pillar Number Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-pillar-num' => 'color: {{VALUE}} !important;' ],
		] );

		$this->add_control( 'pillar_title_color', [
			'label'     => __( 'Pillar Title Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-pillar-title' => 'color: {{VALUE}} !important;' ],
		] );

		$this->add_control( 'pillar_desc_color', [
			'label'     => __( 'Pillar Description Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-pillar-desc' => 'color: {{VALUE}} !important;' ],
		] );

		$this->end_controls_section();
	}

	/* ─── Render ────────────────────────────────────────────── */

	protected function render(): void {
		$s = $this->get_settings_for_display();

		$img_url       = ! empty( $s['main_image']['url'] ) ? esc_url( $s['main_image']['url'] ) : 'https://images.unsplash.com/photo-1558769132-cb1aea458c5e?auto=format&fit=crop&w=1000&q=85';
		$img_alt       = ! empty( $s['image_alt'] ) ? esc_attr( $s['image_alt'] ) : __( 'Artisan craftsmanship leather studio', 'kinboni-pro' );
		$is_img_right  = ( 'img_right' === ( $s['layout_direction'] ?? 'img_left' ) );
		$order_img     = $is_img_right ? 'lg:order-2' : '';
		$order_text    = $is_img_right ? 'lg:order-1' : '';

		$pillars       = $s['pillars'] ?? [];

		$cta_url       = ! empty( $s['cta_url']['url'] ) ? esc_url( $s['cta_url']['url'] ) : '#featured';
		$cta_target    = ! empty( $s['cta_url']['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
		?>

		<section id="heritage" class="kb-heritage-section py-16 sm:py-24 bg-stone-100/60 dark:bg-stone-950/60 border-t border-b border-stone-200/70 dark:border-stone-800/80 scroll-mt-24">
			<div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8">
				<div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">

					<!-- Layered Editorial Imagery -->
					<div class="lg:col-span-6 relative <?php echo esc_attr( $order_img ); ?>">
						<div class="aspect-[4/3] rounded-2xl overflow-hidden shadow-2xl border border-stone-200/80 dark:border-stone-800 bg-stone-200 dark:bg-stone-900">
							<img 
								src="<?php echo $img_url; ?>" 
								alt="<?php echo $img_alt; ?>" 
								class="w-full h-full object-cover object-center" 
								style="height: 100% !important; width: 100% !important; object-fit: cover !important;"
							/>
						</div>

						<!-- Master Guild Floating Stamp -->
						<?php if ( 'yes' === ( $s['show_floating_stamp'] ?? 'yes' ) ) : ?>
							<div class="absolute -bottom-6 -right-6 hidden sm:block p-5 rounded-2xl bg-white dark:bg-stone-900 shadow-xl border border-stone-200 dark:border-stone-800 max-w-[200px] text-center">
								<i data-lucide="<?php echo esc_attr( $s['stamp_icon'] ?: 'shield-check' ); ?>" class="w-8 h-8 text-gold-500 mx-auto mb-1"></i>
								<?php if ( ! empty( $s['stamp_title'] ) ) : ?>
									<p class="font-serif text-sm font-bold text-stone-900 dark:text-white">
										<?php echo esc_html( $s['stamp_title'] ); ?>
									</p>
								<?php endif; ?>
								<?php if ( ! empty( $s['stamp_subtitle'] ) ) : ?>
									<p class="text-[10px] uppercase tracking-wider text-stone-500 dark:text-stone-400">
										<?php echo esc_html( $s['stamp_subtitle'] ); ?>
									</p>
								<?php endif; ?>
							</div>
						<?php endif; ?>
					</div>

					<!-- Editorial Story Text -->
					<div class="lg:col-span-6 space-y-6 <?php echo esc_attr( $order_text ); ?>">
						<?php if ( ! empty( $s['tag_text'] ) ) : ?>
							<span class="kb-heritage-tag text-xs font-bold uppercase tracking-[0.25em] text-gold-600 dark:text-gold-400">
								<?php echo esc_html( $s['tag_text'] ); ?>
							</span>
						<?php endif; ?>

						<?php if ( ! empty( $s['headline'] ) ) : ?>
							<h2 class="kb-heritage-title font-serif text-3xl sm:text-4xl lg:text-5xl font-medium text-stone-900 dark:text-white leading-tight">
								<?php echo esc_html( $s['headline'] ); ?>
							</h2>
						<?php endif; ?>

						<?php if ( 'yes' === ( $s['show_gold_bar'] ?? 'yes' ) ) : ?>
							<div class="kb-heritage-gold-bar w-12 h-0.5 bg-gold-500"></div>
						<?php endif; ?>

						<?php if ( ! empty( $s['paragraph_1'] ) ) : ?>
							<p class="kb-heritage-p text-stone-600 dark:text-stone-300 text-sm sm:text-base leading-relaxed font-light">
								<?php echo wp_kses_post( $s['paragraph_1'] ); ?>
							</p>
						<?php endif; ?>

						<?php if ( ! empty( $s['paragraph_2'] ) ) : ?>
							<p class="kb-heritage-p text-stone-600 dark:text-stone-300 text-sm sm:text-base leading-relaxed font-light">
								<?php echo wp_kses_post( $s['paragraph_2'] ); ?>
							</p>
						<?php endif; ?>

						<!-- 3 Pillars -->
						<?php if ( ! empty( $pillars ) ) : ?>
							<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2">
								<?php foreach ( $pillars as $pillar ) : ?>
									<div class="kb-pillar-card p-4 rounded-xl bg-white dark:bg-stone-900/80 border border-stone-200/80 dark:border-stone-800 shadow-sm">
										<?php if ( ! empty( $pillar['pillar_number'] ) ) : ?>
											<span class="kb-pillar-num text-gold-600 font-serif text-xl font-bold">
												<?php echo esc_html( $pillar['pillar_number'] ); ?>
											</span>
										<?php endif; ?>
										<?php if ( ! empty( $pillar['pillar_title'] ) ) : ?>
											<h4 class="kb-pillar-title text-xs font-bold uppercase tracking-wider text-stone-900 dark:text-white mt-1">
												<?php echo esc_html( $pillar['pillar_title'] ); ?>
											</h4>
										<?php endif; ?>
										<?php if ( ! empty( $pillar['pillar_description'] ) ) : ?>
											<p class="kb-pillar-desc text-[11px] text-stone-500 dark:text-stone-400 mt-1">
												<?php echo esc_html( $pillar['pillar_description'] ); ?>
											</p>
										<?php endif; ?>
									</div>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>

						<!-- Call to Action Link -->
						<?php if ( 'yes' === ( $s['show_cta'] ?? 'yes' ) && ! empty( $s['cta_text'] ) ) : ?>
							<div class="pt-2">
								<a href="<?php echo $cta_url; ?>"<?php echo $cta_target; ?> class="group inline-flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-gold-600 dark:text-gold-400 hover:text-gold-700 dark:hover:text-gold-300 transition-colors">
									<span><?php echo esc_html( $s['cta_text'] ); ?></span>
									<i data-lucide="<?php echo esc_attr( $s['cta_icon'] ?: 'arrow-right' ); ?>" class="w-4 h-4 transition-transform group-hover:translate-x-1"></i>
								</a>
							</div>
						<?php endif; ?>

					</div>

				</div>
			</div>
		</section>
		<?php
	}
}

