<?php
namespace KinboniPro\Widgets;

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
	return;
}

class Widget_Testimonials extends \Elementor\Widget_Base {

	/* ─── Identity ──────────────────────────────────────────── */

	public function get_name(): string {
		return 'kinboni_testimonials';
	}

	public function get_title(): string {
		return __( 'KINBONI — Patron Acclaim Testimonials', 'kinboni-pro' );
	}

	public function get_icon(): string {
		return 'eicon-testimonial-carousel';
	}

	public function get_categories(): array {
		return [ 'kinboni' ];
	}

	public function get_keywords(): array {
		return [ 'kinboni', 'testimonials', 'reviews', 'patron', 'carousel', 'slider', 'swiper', 'rating', 'luxury' ];
	}

	public function get_script_depends(): array {
		return [ 'lucide-icons', 'swiper-bundle', 'kinboni-pro', 'kinboni-app' ];
	}

	public function get_style_depends(): array {
		return [ 'kinboni-fonts', 'swiper-bundle', 'kinboni-output', 'kinboni-pro' ];
	}

	/* ─── Controls ──────────────────────────────────────────── */

	protected function register_controls(): void {

		/* ══════════════════════════════════════════════
		   1. SECTION HEADER
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_header_content', [
			'label' => __( 'Section Header', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'subtitle_tag', [
			'label'   => __( 'Subtitle Tag', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => __( 'Patron Acclaim', 'kinboni-pro' ),
		] );

		$this->add_control( 'title', [
			'label'       => __( 'Main Headline (H2)', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => __( 'Words from the Discerning', 'kinboni-pro' ),
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
			'rows'        => 3,
			'default'     => __( 'Trusted by connoisseurs, collectors, and taste-makers across Dhaka, London, Zurich, and Dubai.', 'kinboni-pro' ),
			'label_block' => true,
		] );

		$this->add_control( 'show_arrows', [
			'label'        => __( 'Show Navigation Arrows', 'kinboni-pro' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->end_controls_section();


		/* ══════════════════════════════════════════════
		   2. TESTIMONIALS REPEATER
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_testimonials_items', [
			'label' => __( 'Testimonials List', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$repeater = new \Elementor\Repeater();

		$repeater->add_control( 'quote', [
			'label'       => __( 'Testimonial Quote', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXTAREA,
			'rows'        => 4,
			'default'     => __( '"The Chronos Royale feels indistinguishable from Swiss timepieces four times its price. The weight, the sapphire anti-reflection, and the hand-finished indices are sublime."', 'kinboni-pro' ),
			'label_block' => true,
		] );

		$repeater->add_control( 'author_name', [
			'label'   => __( 'Author Name', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'Tahmid Rahman',
		] );

		$repeater->add_control( 'author_meta', [
			'label'       => __( 'Location & Role', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'Dhaka • Collector',
			'description' => __( 'e.g. London • Creative Director', 'kinboni-pro' ),
		] );

		$repeater->add_control( 'acquired_product', [
			'label'       => __( 'Acquired Product Tag', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'Acquired: Chronos Royale',
			'description' => __( 'e.g. Acquired: Saddle Briefcase', 'kinboni-pro' ),
		] );

		$repeater->add_control( 'author_avatar', [
			'label'   => __( 'Author Avatar / Photo', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::MEDIA,
			'default' => [
				'url' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=150&q=80',
			],
		] );

		$repeater->add_control( 'rating', [
			'label'   => __( 'Star Rating (1 - 5)', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::NUMBER,
			'min'     => 1,
			'max'     => 5,
			'step'    => 1,
			'default' => 5,
		] );

		$repeater->add_control( 'is_verified', [
			'label'        => __( 'Show Verified Badge', 'kinboni-pro' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'testimonials', [
			'label'       => __( 'Patron Testimonials', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'default'     => [
				[
					'author_name'      => 'Tahmid Rahman',
					'author_meta'      => 'Dhaka • Collector',
					'acquired_product' => 'Acquired: Chronos Royale',
					'rating'           => 5,
					'is_verified'      => 'yes',
					'author_avatar'    => [ 'url' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=150&q=80' ],
					'quote'            => '"The Chronos Royale feels indistinguishable from Swiss timepieces four times its price. The weight, the sapphire anti-reflection, and the hand-finished indices are sublime."',
				],
				[
					'author_name'      => 'Elena Rostova',
					'author_meta'      => 'London • Creative Director',
					'acquired_product' => 'Acquired: Saddle Briefcase',
					'rating'           => 5,
					'is_verified'      => 'yes',
					'author_avatar'    => [ 'url' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&q=80' ],
					'quote'            => '"The Atelier Saddle Briefcase has accompanied me to board meetings in London and Singapore. The patina it has developed over six months is utterly breathtaking."',
				],
				[
					'author_name'      => 'Zayd Al-Mansoor',
					'author_meta'      => 'Dubai • Connoisseur',
					'acquired_product' => 'Acquired: Nocturne Oud 100ml',
					'rating'           => 5,
					'is_verified'      => 'yes',
					'author_avatar'    => [ 'url' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=150&q=80' ],
					'quote'            => '"Nocturne Oud is pure alchemy. The projection is commanding yet never suffocating. The presentation box arrived with white-glove courier precision."',
				],
				[
					'author_name'      => 'Farhana Chowdhury',
					'author_meta'      => 'Chittagong • Architect',
					'acquired_product' => 'Acquired: Aurelia Solis',
					'rating'           => 5,
					'is_verified'      => 'yes',
					'author_avatar'    => [ 'url' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=150&q=80' ],
					'quote'            => '"The Aurelia Solis shades are a masterclass in Italian acetate craftsmanship. The packaging, engraved authenticity card, and cash-on-delivery service were unmatched."',
				],
				[
					'author_name'      => 'Jean-Luc Mercier',
					'author_meta'      => 'Geneva • Horology Specialist',
					'acquired_product' => 'Acquired: Bifold Wallet',
					'rating'           => 5,
					'is_verified'      => 'yes',
					'author_avatar'    => [ 'url' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=150&q=80' ],
					'quote'            => '"Exquisite attention to detail. The saddle stitching on the French calfskin matches the precision of heritage Genevan watchmakers. Truly quiet luxury."',
				],
				[
					'author_name'      => 'Nusrat Jahan',
					'author_meta'      => 'Sylhet • Verified Patron',
					'acquired_product' => 'Acquired: Cashmere Wrap',
					'rating'           => 5,
					'is_verified'      => 'yes',
					'author_avatar'    => [ 'url' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=150&q=80' ],
					'quote'            => '"The Cashmere wrap is unimaginably soft and ethereal. Ordered with 3 simple details and received in Sylhet in under 48 hours in a silk-lined atelier box."',
				],
			],
			'title_field' => '{{{ author_name }}} ({{{ author_meta }}})',
		] );

		$this->end_controls_section();


		/* ══════════════════════════════════════════════
		   3. SLIDER SETTINGS
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_slider_settings', [
			'label' => __( 'Slider Settings', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'autoplay', [
			'label'        => __( 'Autoplay', 'kinboni-pro' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'autoplay_delay', [
			'label'     => __( 'Autoplay Delay (ms)', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::NUMBER,
			'default'   => 4500,
			'condition' => [ 'autoplay' => 'yes' ],
		] );

		$this->add_control( 'loop', [
			'label'        => __( 'Infinite Loop', 'kinboni-pro' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->end_controls_section();


		/* ══════════════════════════════════════════════
		   STYLE TAB: HEADER
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_style_header', [
			'label' => __( 'Section Header', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'subtitle_color', [
			'label'     => __( 'Subtitle Tag Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-testi-tag' => 'color: {{VALUE}} !important;' ],
		] );

		$this->add_control( 'title_color', [
			'label'     => __( 'Headline Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-testi-title' => 'color: {{VALUE}} !important;' ],
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typo',
				'label'    => __( 'Headline Typography', 'kinboni-pro' ),
				'selector' => '{{WRAPPER}} .kb-testi-title',
			]
		);

		$this->add_control( 'gold_bar_color', [
			'label'     => __( 'Gold Bar Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-testi-gold-bar' => 'background-color: {{VALUE}} !important;' ],
		] );

		$this->add_control( 'desc_color', [
			'label'     => __( 'Description Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-testi-desc' => 'color: {{VALUE}} !important;' ],
		] );

		$this->end_controls_section();


		/* ══════════════════════════════════════════════
		   STYLE TAB: TESTIMONIAL CARDS
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_style_cards', [
			'label' => __( 'Testimonial Cards', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'card_bg_color', [
			'label'     => __( 'Card Background Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-testi-card' => 'background-color: {{VALUE}} !important;' ],
		] );

		$this->add_control( 'card_border_color', [
			'label'     => __( 'Card Border Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-testi-card' => 'border-color: {{VALUE}} !important;' ],
		] );

		$this->add_control( 'quote_color', [
			'label'     => __( 'Quote Text Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-testi-quote' => 'color: {{VALUE}} !important;' ],
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'quote_typo',
				'label'    => __( 'Quote Typography', 'kinboni-pro' ),
				'selector' => '{{WRAPPER}} .kb-testi-quote',
			]
		);

		$this->add_control( 'author_name_color', [
			'label'     => __( 'Author Name Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-testi-author' => 'color: {{VALUE}} !important;' ],
		] );

		$this->add_control( 'star_color', [
			'label'     => __( 'Star Rating Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .kb-testi-stars svg' => 'color: {{VALUE}} !important; fill: {{VALUE}} !important;',
			],
		] );

		$this->end_controls_section();


		/* ══════════════════════════════════════════════
		   STYLE TAB: NAVIGATION ARROWS
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_style_nav', [
			'label' => __( 'Navigation Arrows', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'nav_btn_bg', [
			'label'     => __( 'Button Background Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-testi-arrow' => 'background-color: {{VALUE}} !important;' ],
		] );

		$this->add_control( 'nav_btn_color', [
			'label'     => __( 'Icon Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-testi-arrow' => 'color: {{VALUE}} !important;' ],
		] );

		$this->add_control( 'nav_btn_border', [
			'label'     => __( 'Border Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-testi-arrow' => 'border-color: {{VALUE}} !important;' ],
		] );

		$this->end_controls_section();
	}

	/* ─── Render ────────────────────────────────────────────── */

	protected function render(): void {
		$s = $this->get_settings_for_display();
		$testimonials = $s['testimonials'] ?? [];
		if ( empty( $testimonials ) ) {
			return;
		}

		$widget_id = $this->get_id();
		?>

		<section id="testimonials" class="kb-testimonials-section py-16 sm:py-24 scroll-mt-24 overflow-hidden">
			<div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8">

				<!-- Section Header with Swiper Navigation Arrows -->
				<div class="flex flex-col md:flex-row md:items-end justify-between mb-10 sm:mb-14 gap-6">
					<div>
						<?php if ( ! empty( $s['subtitle_tag'] ) ) : ?>
							<span class="kb-testi-tag text-xs font-bold uppercase tracking-[0.25em] text-gold-600 dark:text-gold-400">
								<?php echo esc_html( $s['subtitle_tag'] ); ?>
							</span>
						<?php endif; ?>

						<?php if ( ! empty( $s['title'] ) ) : ?>
							<h2 class="kb-testi-title font-serif text-3xl sm:text-4xl font-medium text-stone-900 dark:text-white mt-1">
								<?php echo esc_html( $s['title'] ); ?>
							</h2>
						<?php endif; ?>

						<?php if ( 'yes' === ( $s['show_gold_bar'] ?? 'yes' ) ) : ?>
							<div class="kb-testi-gold-bar w-12 h-0.5 bg-gold-500 mt-3 mb-3"></div>
						<?php endif; ?>

						<?php if ( ! empty( $s['description'] ) ) : ?>
							<p class="kb-testi-desc text-sm text-stone-600 dark:text-stone-400 font-light max-w-xl">
								<?php echo esc_html( $s['description'] ); ?>
							</p>
						<?php endif; ?>
					</div>

					<!-- Swiper Navigation Controls -->
					<?php if ( 'yes' === ( $s['show_arrows'] ?? 'yes' ) ) : ?>
						<div class="flex items-center gap-3">
							<button 
								id="testimonial-prev-btn" 
								type="button" 
								class="kb-testi-arrow w-11 h-11 rounded-full border border-stone-300 dark:border-stone-700 bg-white dark:bg-stone-900 flex items-center justify-center text-stone-700 dark:text-stone-300 hover:border-gold-500 hover:text-gold-600 dark:hover:border-gold-400 dark:hover:text-gold-400 hover:scale-105 active:scale-95 transition-all shadow-sm"
								aria-label="<?php esc_attr_e( 'Previous testimonial', 'kinboni-pro' ); ?>"
							>
								<i data-lucide="chevron-left" class="w-5 h-5"></i>
							</button>
							<button 
								id="testimonial-next-btn" 
								type="button" 
								class="kb-testi-arrow w-11 h-11 rounded-full border border-stone-300 dark:border-stone-700 bg-white dark:bg-stone-900 flex items-center justify-center text-stone-700 dark:text-stone-300 hover:border-gold-500 hover:text-gold-600 dark:hover:border-gold-400 dark:hover:text-gold-400 hover:scale-105 active:scale-95 transition-all shadow-sm"
								aria-label="<?php esc_attr_e( 'Next testimonial', 'kinboni-pro' ); ?>"
							>
								<i data-lucide="chevron-right" class="w-5 h-5"></i>
							</button>
						</div>
					<?php endif; ?>
				</div>

				<!-- Swiper Slider Container -->
				<div class="relative">
					<div class="swiper testimonial-swiper">
						<div class="swiper-wrapper">
							<?php foreach ( $testimonials as $item ) :
								$rating     = ! empty( $item['rating'] ) ? min( 5, max( 1, absint( $item['rating'] ) ) ) : 5;
								$avatar_url = ! empty( $item['author_avatar']['url'] ) ? esc_url( $item['author_avatar']['url'] ) : '';
								?>
								<div class="swiper-slide h-auto">
									<div class="kb-testi-card w-full h-full p-7 sm:p-8 rounded-2xl bg-white dark:bg-stone-900 border border-stone-200/80 dark:border-stone-800 shadow-sm hover:shadow-xl hover:border-gold-500/50 dark:hover:border-gold-500/40 transition-all duration-300 flex flex-col justify-between group">
										<div>
											<div class="flex items-center justify-between mb-4">
												<!-- Stars -->
												<div class="kb-testi-stars flex text-amber-400">
													<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
														<i data-lucide="star" class="w-4 h-4 <?php echo $i <= $rating ? 'fill-amber-400' : 'text-stone-300 dark:text-stone-700'; ?>"></i>
													<?php endfor; ?>
												</div>

												<!-- Verified Badge -->
												<?php if ( 'yes' === ( $item['is_verified'] ?? 'yes' ) ) : ?>
													<span class="inline-flex items-center gap-1 text-[10px] uppercase font-bold tracking-wider text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/40 px-2 py-0.5 rounded-full border border-emerald-200 dark:border-emerald-800">
														<i data-lucide="check" class="w-3 h-3"></i> <?php esc_html_e( 'Verified', 'kinboni-pro' ); ?>
													</span>
												<?php endif; ?>
											</div>

											<!-- Quote -->
											<?php if ( ! empty( $item['quote'] ) ) : ?>
												<p class="kb-testi-quote font-serif text-base sm:text-lg italic text-stone-800 dark:text-stone-200 leading-relaxed mb-6 font-normal">
													<?php echo esc_html( $item['quote'] ); ?>
												</p>
											<?php endif; ?>
										</div>

										<!-- Author & Meta -->
										<div class="flex items-center gap-4 pt-4 border-t border-stone-100 dark:border-stone-800">
											<?php if ( ! empty( $avatar_url ) ) : ?>
												<div class="w-12 h-12 rounded-full ring-2 ring-gold-400/40 overflow-hidden flex-shrink-0">
													<img src="<?php echo $avatar_url; ?>" alt="<?php echo esc_attr( $item['author_name'] ?? '' ); ?>" class="w-full h-full object-cover" />
												</div>
											<?php endif; ?>

											<div class="min-w-0">
												<?php if ( ! empty( $item['author_name'] ) ) : ?>
													<h4 class="kb-testi-author text-xs font-bold uppercase tracking-wider text-stone-900 dark:text-white truncate">
														<?php echo esc_html( $item['author_name'] ); ?>
													</h4>
												<?php endif; ?>

												<?php if ( ! empty( $item['author_meta'] ) ) : ?>
													<p class="text-[11px] text-gold-600 dark:text-gold-400 font-medium">
														<?php echo esc_html( $item['author_meta'] ); ?>
													</p>
												<?php endif; ?>

												<?php if ( ! empty( $item['acquired_product'] ) ) : ?>
													<span class="text-[10px] text-stone-400 dark:text-stone-500 block truncate">
														<?php echo esc_html( $item['acquired_product'] ); ?>
													</span>
												<?php endif; ?>
											</div>
										</div>

									</div>
								</div>
							<?php endforeach; ?>
						</div>

						<!-- Swiper Custom Pagination -->
						<div class="swiper-pagination"></div>
					</div>
				</div>

			</div>
		</section>

		<script>
		(function() {
			function initSwiper<?php echo esc_attr( str_replace( '-', '_', $widget_id ) ); ?>() {
				if (typeof TestimonialSliderController !== 'undefined' && TestimonialSliderController.init) {
					TestimonialSliderController.init();
				}
				if (typeof lucide !== 'undefined' && lucide.createIcons) {
					lucide.createIcons();
				}
			}
			if (document.readyState === 'loading') {
				document.addEventListener('DOMContentLoaded', initSwiper<?php echo esc_attr( str_replace( '-', '_', $widget_id ) ); ?>);
			} else {
				initSwiper<?php echo esc_attr( str_replace( '-', '_', $widget_id ) ); ?>();
			}
		})();
		</script>
		<?php
	}
}

