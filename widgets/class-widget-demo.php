<?php
/**
 * Widget: Demo Card
 *
 * A styled card with Quick View modal button.
 * Demonstrates the KINBONI widget architecture.
 *
 * @package KinboniPro\Widgets
 */

namespace KinboniPro\Widgets;

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
	return;
}

class Widget_Demo extends \Elementor\Widget_Base {

	/* ─── Identity ──────────────────────────────────────────── */

	public function get_name(): string {
		return 'kinboni_demo';
	}

	public function get_title(): string {
		return __( 'KINBONI — Demo Card', 'kinboni-pro' );
	}

	public function get_icon(): string {
		return 'eicon-image-box';
	}

	public function get_categories(): array {
		return [ 'kinboni' ];
	}

	public function get_keywords(): array {
		return [ 'kinboni', 'demo', 'card', 'modal', 'product' ];
	}

	public function get_script_depends(): array {
		return [ 'lucide-icons', 'swiper-bundle', 'kinboni-pro', 'kinboni-app' ];
	}

	public function get_style_depends(): array {
		return [ 'kinboni-fonts', 'swiper-bundle', 'kinboni-output', 'kinboni-pro' ];
	}

	/* ─── Controls ──────────────────────────────────────────── */

	protected function register_controls(): void {

		/* ── Content Tab ─────────────────────────────── */
		$this->start_controls_section( 'section_content', [
			'label' => __( 'Showcase & Content', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'layout_view', [
			'label'   => __( 'Showcase Layout', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'all',
			'options' => [
				'all'  => __( 'Hero + Product Demo Card', 'kinboni-pro' ),
				'hero' => __( 'Hero Section Only', 'kinboni-pro' ),
				'card' => __( 'Product Demo Card Only', 'kinboni-pro' ),
			],
		] );

		$this->add_control( 'image', [
			'label'   => __( 'Product Card Image', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::MEDIA,
			'default' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
		] );

		$this->add_control( 'title', [
			'label'   => __( 'Title', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => __( 'Luxury Product', 'kinboni-pro' ),
		] );

		$this->add_control( 'description', [
			'label'   => __( 'Short Description', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::TEXTAREA,
			'default' => __( 'Handcrafted with premium materials. Limited edition.', 'kinboni-pro' ),
			'rows'    => 3,
		] );

		$this->add_control( 'price', [
			'label'   => __( 'Price', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => '৳ 4,500',
		] );

		$this->add_control( 'badge_text', [
			'label'   => __( 'Badge Text', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => __( 'New', 'kinboni-pro' ),
		] );

		$this->add_control( 'button_text', [
			'label'   => __( 'Button Text', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => __( 'Quick View', 'kinboni-pro' ),
		] );

		$this->end_controls_section();

		/* ── Modal Content ───────────────────────────── */
		$this->start_controls_section( 'section_modal', [
			'label' => __( 'Modal Content', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'modal_description', [
			'label'   => __( 'Full Description', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::WYSIWYG,
			'default' => '<p>This is the detailed product description shown inside the modal. Features, materials, sizing, etc.</p>',
		] );

		$this->end_controls_section();

		/* ── Style Tab ───────────────────────────────── */
		$this->start_controls_section( 'section_style', [
			'label' => __( 'Card Style', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'card_bg', [
			'label'     => __( 'Card Background', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#ffffff',
			'selectors' => [ '{{WRAPPER}} .kb-card' => 'background-color: {{VALUE}}' ],
		] );

		$this->add_control( 'accent_color', [
			'label'     => __( 'Accent Color (Gold)', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#C5A028',
			'selectors' => [
				'{{WRAPPER}} .kb-card__price' => 'color: {{VALUE}}',
				'{{WRAPPER}} .kb-card__badge' => 'background-color: {{VALUE}}',
				'{{WRAPPER}} .kb-btn'         => 'background-color: {{VALUE}}',
			],
		] );

		$this->add_control( 'title_color', [
			'label'     => __( 'Title Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#1a1a1a',
			'selectors' => [ '{{WRAPPER}} .kb-card__title' => 'color: {{VALUE}}' ],
		] );

		$this->end_controls_section();

		/* ── Image & Gallery Sizing ──────────────────── */
		$this->start_controls_section( 'section_image_style', [
			'label' => __( 'Image & Gallery Sizing', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		// Card Image Height (Responsive: Desktop, Tablet, Mobile)
		$this->add_responsive_control( 'image_height', [
			'label'      => __( 'Card Image Height', 'kinboni-pro' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'vh', 'rem' ],
			'range'      => [
				'px'  => [ 'min' => 150, 'max' => 800, 'step' => 5 ],
				'vh'  => [ 'min' => 15,  'max' => 90,  'step' => 1 ],
				'rem' => [ 'min' => 10,  'max' => 50,  'step' => 1 ],
			],
			'default'    => [ 'unit' => 'px', 'size' => 320 ],
			'selectors'  => [
				'{{WRAPPER}} .kb-card__image-wrap' => 'height: {{SIZE}}{{UNIT}} !important; min-height: {{SIZE}}{{UNIT}} !important;',
				'{{WRAPPER}} .kb-card__image'      => 'height: 100% !important; min-height: {{SIZE}}{{UNIT}} !important;',
			],
		] );

		// Hero Mosaic Gallery Height (Responsive: Desktop, Tablet, Mobile)
		$this->add_responsive_control( 'hero_gallery_height', [
			'label'      => __( 'Hero Mosaic Gallery Height', 'kinboni-pro' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'vh' ],
			'range'      => [
				'px' => [ 'min' => 250, 'max' => 900, 'step' => 10 ],
				'vh' => [ 'min' => 25,  'max' => 95,  'step' => 1 ],
			],
			'desktop_default' => [ 'unit' => 'px', 'size' => 560 ],
			'tablet_default'  => [ 'unit' => 'px', 'size' => 480 ],
			'mobile_default'  => [ 'unit' => 'px', 'size' => 380 ],
			'selectors'       => [
				'{{WRAPPER}} .kb-hero-gallery' => 'height: {{SIZE}}{{UNIT}} !important; min-height: {{SIZE}}{{UNIT}} !important;',
			],
		] );

		// Object Fit Control
		$this->add_control( 'image_fit', [
			'label'     => __( 'Image Object Fit', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::SELECT,
			'default'   => 'cover',
			'options'   => [
				'cover'      => __( 'Cover (Preserve aspect, fill container)', 'kinboni-pro' ),
				'contain'    => __( 'Contain (Show entire image)', 'kinboni-pro' ),
				'fill'       => __( 'Fill (Stretch to fit)', 'kinboni-pro' ),
				'scale-down' => __( 'Scale Down', 'kinboni-pro' ),
			],
			'selectors' => [
				'{{WRAPPER}} .kb-card__image'      => 'object-fit: {{VALUE}} !important;',
				'{{WRAPPER}} .kb-hero-gallery img' => 'object-fit: {{VALUE}} !important;',
			],
		] );

		// Image Border Radius Control
		$this->add_responsive_control( 'image_border_radius', [
			'label'      => __( 'Card Image Border Radius', 'kinboni-pro' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'rem' ],
			'selectors'  => [
				'{{WRAPPER}} .kb-card__image-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				'{{WRAPPER}} .kb-card__image'      => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
			],
		] );

		$this->end_controls_section();
	}

	/* ─── Render ─────────────────────────────────────────────── */

	protected function render(): void {
		$s = $this->get_settings_for_display();

		$uid          = 'kb-modal-' . $this->get_id();
		$img          = ! empty( $s['image']['url'] ) ? esc_url( $s['image']['url'] ) : 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?auto=format&fit=crop&w=800&q=80';
		$title        = esc_html( $s['title'] );
		$desc         = nl2br( esc_html( $s['description'] ) );
		$price        = esc_html( $s['price'] );
		$badge        = esc_html( $s['badge_text'] );
		$btn          = esc_html( $s['button_text'] );
		$modal        = wp_kses_post( $s['modal_description'] );
		$accent_color = ! empty( $s['accent_color'] ) ? sanitize_hex_color( $s['accent_color'] ) : '#C5A028';
		$card_bg      = ! empty( $s['card_bg'] ) ? sanitize_hex_color( $s['card_bg'] ) : '#ffffff';
		$title_color  = ! empty( $s['title_color'] ) ? sanitize_hex_color( $s['title_color'] ) : '#1a1a1a';
		$layout_view  = ! empty( $s['layout_view'] ) ? $s['layout_view'] : 'all';
		$show_hero    = in_array( $layout_view, [ 'all', 'hero' ], true );
		$show_card    = in_array( $layout_view, [ 'all', 'card' ], true );

		$modal_styles = sprintf(
			'--kb-gold: %s; --kb-surface: %s; --kb-text: %s;',
			$accent_color,
			$card_bg,
			$title_color
		);
		?>

		<?php if ( $show_hero ) : ?>
		<header id="site-header" class="sticky top-0 z-40 w-full transition-all duration-300 bg-[#FAF8F5]/90 dark:bg-[#0E0E10]/90 backdrop-blur-md border-b border-stone-200/70 dark:border-stone-800/70">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<div class="flex items-center justify-between h-[72px] gap-4 sm:gap-6">
				
				<!-- Mobile Menu Hamburger Button -->
				<div class="flex items-center lg:hidden">
				<button id="mobile-menu-btn" type="button" class="w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center text-stone-700 dark:text-stone-300 hover:text-gold-600 dark:hover:text-gold-400 hover:bg-stone-200/60 dark:hover:bg-stone-800/60 transition-colors" aria-label="Open mobile navigation menu">
					<i data-lucide="menu" class="w-5 h-5"></i>
				</button>
				</div>

				<!-- Brand Monogram & Wordmark Logo -->
				<a href="#hero" class="group flex items-center gap-2 sm:gap-3 flex-shrink-0" aria-label="Kinboni home">
				<span class="hidden sm:grid place-items-center w-10 h-10 rounded-full bg-stone-900 dark:bg-gold-400 text-gold-300 dark:text-stone-950 font-serif text-xl font-semibold shadow-sm transition-transform group-hover:scale-105">K</span>
				<span class="flex flex-col leading-none">
					<span class="font-serif text-xl sm:text-[26px] font-semibold tracking-[0.2em] sm:tracking-[0.22em] text-stone-900 dark:text-white group-hover:text-gold-600 dark:group-hover:text-gold-400 transition-colors">KINBONI</span>
					<span class="text-[8px] sm:text-[9px] tracking-[0.35em] sm:tracking-[0.4em] text-gold-600 dark:text-gold-400 font-semibold mt-0.5 sm:mt-1">HAUTE ATELIER</span>
				</span>
				</a>

				<!-- Desktop Navigation Links -->
				<nav class="hidden lg:flex items-center gap-8 xl:gap-9" aria-label="Main navigation">
				<a href="#hero" class="relative text-[13px] font-semibold tracking-wide text-stone-700 dark:text-stone-300 hover:text-gold-600 dark:hover:text-gold-400 transition-colors after:absolute after:left-0 after:-bottom-1.5 after:h-0.5 after:w-0 after:bg-gold-500 after:transition-all hover:after:w-full">Home</a>
				<a href="#categories" class="relative text-[13px] font-semibold tracking-wide text-stone-700 dark:text-stone-300 hover:text-gold-600 dark:hover:text-gold-400 transition-colors after:absolute after:left-0 after:-bottom-1.5 after:h-0.5 after:w-0 after:bg-gold-500 after:transition-all hover:after:w-full">Collections</a>
				<a href="#featured" class="relative text-[13px] font-semibold tracking-wide text-stone-700 dark:text-stone-300 hover:text-gold-600 dark:hover:text-gold-400 transition-colors after:absolute after:left-0 after:-bottom-1.5 after:h-0.5 after:w-0 after:bg-gold-500 after:transition-all hover:after:w-full">Featured</a>
				<a href="#bestsellers" class="relative text-[13px] font-semibold tracking-wide text-stone-700 dark:text-stone-300 hover:text-gold-600 dark:hover:text-gold-400 transition-colors after:absolute after:left-0 after:-bottom-1.5 after:h-0.5 after:w-0 after:bg-gold-500 after:transition-all hover:after:w-full">Best Sellers</a>
				<a href="#heritage" class="relative text-[13px] font-semibold tracking-wide text-stone-700 dark:text-stone-300 hover:text-gold-600 dark:hover:text-gold-400 transition-colors after:absolute after:left-0 after:-bottom-1.5 after:h-0.5 after:w-0 after:bg-gold-500 after:transition-all hover:after:w-full">Our Story</a>
				<a href="#testimonials" class="relative text-[13px] font-semibold tracking-wide text-stone-700 dark:text-stone-300 hover:text-gold-600 dark:hover:text-gold-400 transition-colors after:absolute after:left-0 after:-bottom-1.5 after:h-0.5 after:w-0 after:bg-gold-500 after:transition-all hover:after:w-full">Patrons</a>
				</nav>

				<!-- Right Action Icons (Search, Theme, Account, Wishlist, Bag) -->
				<div class="flex items-center gap-1 sm:gap-2">
				
				<!-- Search Button (Pill on Desktop, Icon on Mobile) -->
				<button type="button" class="open-search-btn hidden md:flex items-center gap-2 pl-3.5 pr-4 py-2 rounded-full border border-stone-300 dark:border-stone-700 text-xs text-stone-500 dark:text-stone-400 hover:border-gold-500 hover:text-gold-600 dark:hover:text-gold-400 transition-colors" aria-label="Search creations">
					<i data-lucide="search" class="w-3.5 h-3.5"></i>
					<span class="font-medium">Search creations...</span>
				</button>
				<button type="button" class="open-search-btn md:hidden w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center text-stone-700 dark:text-stone-300 hover:text-gold-600 dark:hover:text-gold-400 hover:bg-stone-200/60 dark:hover:bg-stone-800/60 transition-colors" aria-label="Search creations">
					<i data-lucide="search" class="w-4 h-4 sm:w-5 sm:h-5"></i>
				</button>

				<!-- Dark/Light Theme Toggle -->
				<button type="button" class="theme-toggle-btn w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center text-stone-700 dark:text-stone-300 hover:text-gold-600 dark:hover:text-gold-400 hover:bg-stone-200/60 dark:hover:bg-stone-800/60 transition-colors" aria-label="Toggle dark and light mode">
					<i data-lucide="sun" class="theme-sun-icon w-4 h-4 sm:w-5 sm:h-5 hidden"></i>
					<i data-lucide="moon" class="theme-moon-icon w-4 h-4 sm:w-5 sm:h-5"></i>
				</button>

				<!-- Patron Account Concierge -->
				<button type="button" class="open-account-btn hidden sm:flex w-10 h-10 rounded-full items-center justify-center text-stone-700 dark:text-stone-300 hover:text-gold-600 dark:hover:text-gold-400 hover:bg-stone-200/60 dark:hover:bg-stone-800/60 transition-colors" aria-label="Patron Account Concierge">
					<i data-lucide="user" class="w-5 h-5"></i>
				</button>

				<!-- Wishlist Button with Badge -->
				<button type="button" class="open-wishlist-btn relative w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center text-stone-700 dark:text-stone-300 hover:text-gold-600 dark:hover:text-gold-400 hover:bg-stone-200/60 dark:hover:bg-stone-800/60 transition-colors" aria-label="View Saved Wishlist">
					<i data-lucide="heart" class="w-4 h-4 sm:w-5 sm:h-5"></i>
					<span class="wishlist-count-badge absolute top-0.5 right-0.5 transform scale-0 transition-transform duration-300 flex items-center justify-center min-w-[16px] h-[16px] sm:min-w-[18px] sm:h-[18px] px-1 text-[9px] sm:text-[10px] font-bold text-white bg-rose-600 rounded-full shadow-sm">0</span>
				</button>

				<!-- Shopping Bag Button with Live Item Counter -->
				<button type="button" class="open-cart-btn relative w-8 h-8 sm:w-auto p-0 sm:pl-3.5 sm:pr-4 sm:py-2 rounded-full bg-stone-900 dark:bg-gold-400 text-white dark:text-stone-950 hover:bg-gold-600 dark:hover:bg-gold-300 transition-all shadow-sm active:scale-95 flex items-center justify-center sm:gap-2 flex-shrink-0" aria-label="Open Shopping Bag">
					<i data-lucide="shopping-bag" class="cart-badge-icon w-4 h-4 transition-transform duration-200"></i>
					<span class="hidden sm:inline text-xs font-bold tracking-wide">Bag</span>
					<span class="cart-count-badge absolute -top-1 -right-1 sm:-top-1.5 sm:-right-1.5 transform scale-0 transition-transform duration-300 flex items-center justify-center min-w-[18px] h-[18px] sm:min-w-[20px] sm:h-[20px] px-1 text-[10px] sm:text-[11px] font-bold text-stone-950 bg-gold-400 dark:bg-white rounded-full shadow-md">0</span>
				</button>

				</div>
			</div>
			</div>
		</header>
		  <section id="hero" class="relative overflow-hidden scroll-mt-24">
			<!-- Ambient Gold Glow Background -->
			<div class="absolute inset-0 bg-gradient-to-b from-gold-100/60 via-transparent to-transparent dark:from-gold-900/10 pointer-events-none"></div>
			<div class="absolute -top-32 right-1/4 w-96 h-96 bg-gold-400/10 rounded-full blur-3xl pointer-events-none"></div>

			<div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-12 sm:pt-12 sm:pb-16 lg:pt-16 lg:pb-20">
			<div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-center">

				<!-- Left Column: Editorial Headline & Actions -->
				<div class="lg:col-span-6 text-center lg:text-left">
				<p class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-[0.25em] text-gold-700 dark:text-gold-300">
					<span class="w-8 h-px bg-gold-500"></span>Autumn / Winter 2026 Archive
				</p>
				<h1 class="mt-4 font-serif font-medium text-stone-900 dark:text-white tracking-tight leading-[1.04] text-4xl sm:text-6xl lg:text-[5.15rem]">
					Objects made<br class="hidden sm:block"> to be kept<br class="hidden sm:block"> for life.
				</h1>
				<p class="mt-5 text-base sm:text-lg text-stone-600 dark:text-stone-300 max-w-lg mx-auto lg:mx-0 leading-relaxed font-light">
					Hand-burnished leather, precision chronographs and rare botanical extraits, made in small batches and delivered across Bangladesh.
				</p>
				
				<div class="mt-8 flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-3">
					<a href="#featured" class="btn-primary rounded-full !px-8 w-full sm:w-auto">
					Shop the Collection
					</a>
					<a href="#bestsellers" class="btn-outline rounded-full !px-8 w-full sm:w-auto">
					View Best Sellers
					</a>
				</div>

				<!-- Proof Metrics Bar -->
				<div class="mt-10 pt-7 border-t border-stone-200 dark:border-stone-800 grid grid-cols-3 gap-4 max-w-md mx-auto lg:mx-0 text-left">
					<div>
					<p class="font-serif text-2xl sm:text-3xl font-semibold text-stone-900 dark:text-white">4.9</p>
					<p class="text-[11px] sm:text-xs text-stone-500 dark:text-stone-400 mt-0.5">Patron satisfaction</p>
					</div>
					<div>
					<p class="font-serif text-2xl sm:text-3xl font-semibold text-stone-900 dark:text-white">10K+</p>
					<p class="text-[11px] sm:text-xs text-stone-500 dark:text-stone-400 mt-0.5">Creations delivered</p>
					</div>
					<div>
					<p class="font-serif text-2xl sm:text-3xl font-semibold text-stone-900 dark:text-white">7 Day</p>
					<p class="text-[11px] sm:text-xs text-stone-500 dark:text-stone-400 mt-0.5">Easy exchange</p>
					</div>
				</div>
				</div>

				<!-- Right Column: Editorial Mosaic Gallery with 3 Featured Products -->
				<div class="lg:col-span-6">
				<div class="kb-hero-gallery grid grid-cols-12 grid-rows-6 gap-3 sm:gap-4 h-[380px] sm:h-[480px] lg:h-[560px] max-w-xl mx-auto">
					
					<!-- Featured Product 1: Main Arched Editorial Image (Silk & Cashmere) -->
					<div class="col-span-7 row-span-6 rounded-t-[999px] rounded-b-2xl overflow-hidden bg-stone-200 dark:bg-stone-900 shadow-xl border border-stone-200/60 dark:border-stone-800 group relative" style="height:100% !important;">
					<img 
						src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?auto=format&fit=crop&w=900&q=85" 
						alt="Kyoto Mulberry Silk Foulard editorial" 
						class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" 
						style="height:100% !important; width:100% !important; object-fit:cover !important;"
					/>
					<div class="absolute inset-0 bg-gradient-to-t from-stone-950/60 via-transparent to-transparent pointer-events-none"></div>
					
					<!-- Floating Product Feature Card (Product ID 6) -->
					<button 
						type="button"
						onclick="QuickViewController.open(6)" 
						class="absolute inset-x-2.5 sm:inset-x-3.5 bottom-2.5 sm:bottom-3.5 rounded-xl bg-white/95 dark:bg-stone-900/95 backdrop-blur-md px-3 py-2 sm:px-3.5 sm:py-2.5 text-left hover:bg-gold-400 dark:hover:bg-gold-400 group/btn transition-all shadow-lg border border-stone-200/50 dark:border-stone-800/50 flex items-center justify-between gap-2"
						title="Quick view Kyoto Mulberry Silk Foulard"
					>
						<div class="min-w-0">
						<span class="block text-[9px] sm:text-[10px] font-bold text-gold-700 dark:text-gold-400 group-hover/btn:text-stone-950 transition-colors uppercase tracking-wider">Artisanal Weave &bull; ৳4,800</span>
						<span class="block font-serif text-xs sm:text-sm font-semibold text-stone-900 dark:text-white group-hover/btn:text-stone-950 truncate transition-colors">Kyoto Mulberry Silk</span>
						</div>
						<div class="w-6 h-6 sm:w-7 sm:h-7 rounded-full bg-stone-100 dark:bg-stone-800 group-hover/btn:bg-stone-950 group-hover/btn:text-white flex items-center justify-center flex-shrink-0 transition-colors shadow-sm">
						<i data-lucide="arrow-up-right" class="w-3.5 h-3.5"></i>
						</div>
					</button>
					</div>

					<!-- Featured Product 2: Top Right (Chronos Royale Watch) -->
					<div class="col-span-5 row-span-3 rounded-2xl overflow-hidden relative bg-stone-200 dark:bg-stone-900 shadow-md border border-stone-200/60 dark:border-stone-800 group" style="height:100% !important;">
					<img 
						src="https://images.unsplash.com/photo-1523293182086-7651a899d37f?auto=format&fit=crop&w=600&q=85" 
						alt="Chronos Royale Automatic detail" 
						class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" 
						style="height:100% !important; width:100% !important; object-fit:cover !important;"
					/>
					<div class="absolute inset-0 bg-gradient-to-t from-stone-950/50 via-transparent to-transparent pointer-events-none"></div>

					<!-- Floating Product Feature Card (Product ID 1) -->
					<button 
						type="button"
						onclick="QuickViewController.open(1)" 
						class="absolute inset-x-2 bottom-2 rounded-xl bg-white/95 dark:bg-stone-900/95 backdrop-blur-md px-2.5 py-1.5 sm:px-3 sm:py-2 text-left hover:bg-gold-400 dark:hover:bg-gold-400 group/btn transition-all shadow-sm border border-stone-200/50 dark:border-stone-800/50 flex items-center justify-between gap-1.5"
						title="Quick view Chronos Royale Automatic"
					>
						<div class="min-w-0">
						<span class="block text-[9px] sm:text-[10px] font-bold text-gold-700 dark:text-gold-400 group-hover/btn:text-stone-950 transition-colors uppercase tracking-wider">Swiss Movement &bull; ৳18,500</span>
						<span class="block font-serif text-xs sm:text-sm font-semibold text-stone-900 dark:text-white group-hover/btn:text-stone-950 truncate transition-colors">Chronos Royale</span>
						</div>
						<div class="w-5 h-5 sm:w-6 sm:h-6 rounded-full bg-stone-100 dark:bg-stone-800 group-hover/btn:bg-stone-950 group-hover/btn:text-white flex items-center justify-center flex-shrink-0 transition-colors">
						<i data-lucide="arrow-up-right" class="w-3 h-3"></i>
						</div>
					</button>
					</div>

					<!-- Featured Product 3: Bottom Right (Saddle Leather Briefcase) -->
					<div class="col-span-5 row-span-3 rounded-2xl overflow-hidden relative bg-stone-200 dark:bg-stone-900 shadow-md border border-stone-200/60 dark:border-stone-800 group" style="height:100% !important;">
					<img 
						src="https://images.unsplash.com/photo-1524805444758-089113d48a6d?auto=format&fit=crop&w=600&q=85" 
						alt="Atelier Saddle Leather Briefcase detail" 
						class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" 
						style="height:100% !important; width:100% !important; object-fit:cover !important;"
					/>
					<div class="absolute inset-0 bg-gradient-to-t from-stone-950/50 via-transparent to-transparent pointer-events-none"></div>

					<!-- Floating Product Feature Card (Product ID 2) -->
					<button 
						type="button"
						onclick="QuickViewController.open(2)" 
						class="absolute inset-x-2 bottom-2 rounded-xl bg-white/95 dark:bg-stone-900/95 backdrop-blur-md px-2.5 py-1.5 sm:px-3 sm:py-2 text-left hover:bg-gold-400 dark:hover:bg-gold-400 group/btn transition-all shadow-sm border border-stone-200/50 dark:border-stone-800/50 flex items-center justify-between gap-1.5"
						title="Quick view Saddle Leather Briefcase"
					>
						<div class="min-w-0">
						<span class="block text-[9px] sm:text-[10px] font-bold text-gold-700 dark:text-gold-400 group-hover/btn:text-stone-950 transition-colors uppercase tracking-wider">Tuscan Leather &bull; ৳14,200</span>
						<span class="block font-serif text-xs sm:text-sm font-semibold text-stone-900 dark:text-white group-hover/btn:text-stone-950 truncate transition-colors">Saddle Briefcase</span>
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
			<div class="border-y border-stone-200 dark:border-stone-800 bg-white/70 dark:bg-stone-950/70 backdrop-blur-sm">
			<ul class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 grid grid-cols-2 lg:grid-cols-4 gap-4 text-xs sm:text-sm font-medium text-stone-700 dark:text-stone-300">
				<li class="flex items-center gap-2.5">
				<i data-lucide="truck" class="w-5 h-5 text-gold-600 dark:text-gold-400 flex-shrink-0"></i>
				<span>Free delivery over ৳2,500</span>
				</li>
				<li class="flex items-center gap-2.5">
				<i data-lucide="shield-check" class="w-5 h-5 text-gold-600 dark:text-gold-400 flex-shrink-0"></i>
				<span>Authenticity guaranteed</span>
				</li>
				<li class="flex items-center gap-2.5">
				<i data-lucide="refresh-cw" class="w-5 h-5 text-gold-600 dark:text-gold-400 flex-shrink-0"></i>
				<span>7-day easy exchange</span>
				</li>
				<li class="flex items-center gap-2.5">
				<i data-lucide="banknote" class="w-5 h-5 text-gold-600 dark:text-gold-400 flex-shrink-0"></i>
				<span>Cash on delivery available</span>
				</li>
			</ul>
			</div>
		</section>
		<?php endif; ?>

		<?php if ( $show_card ) : ?>
		<!-- Dedicated Elementor Demo Card & Modal Showcase -->
		<section class="kb-product-showcase py-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
			<div class="text-center mb-8">
				<p class="text-xs font-bold uppercase tracking-[0.25em] text-gold-600 dark:text-gold-400 mb-2"><?php esc_html_e( 'Interactive Product Widget', 'kinboni-pro' ); ?></p>
				<h2 class="font-serif text-2xl sm:text-3xl font-medium text-stone-900 dark:text-white"><?php esc_html_e( 'Curated Creation Showcase', 'kinboni-pro' ); ?></h2>
			</div>

			<div class="flex justify-center">
				<div class="kb-card w-full max-w-sm" style="--kb-surface: <?php echo esc_attr( $card_bg ); ?>; --kb-text: <?php echo esc_attr( $title_color ); ?>; --kb-gold: <?php echo esc_attr( $accent_color ); ?>;">
					<div class="kb-card__image-wrap">
						<img 
							src="<?php echo esc_url( $img ); ?>" 
							alt="<?php echo esc_attr( $title ); ?>" 
							class="kb-card__image" 
							loading="lazy" 
						/>
						<?php if ( ! empty( $badge ) ) : ?>
							<span class="kb-card__badge"><?php echo esc_html( $badge ); ?></span>
						<?php endif; ?>
					</div>
					<div class="kb-card__body">
						<h3 class="kb-card__title"><?php echo esc_html( $title ); ?></h3>
						<?php if ( ! empty( $desc ) ) : ?>
							<p class="kb-card__desc"><?php echo esc_html( $desc ); ?></p>
						<?php endif; ?>
						<div class="kb-card__footer">
							<span class="kb-card__price"><?php echo esc_html( $price ); ?></span>
							<button type="button" class="kb-btn" data-modal="<?php echo esc_attr( $uid ); ?>">
								<i data-lucide="eye" class="w-4 h-4"></i>
								<span><?php echo esc_html( $btn ); ?></span>
							</button>
						</div>
					</div>
				</div>
			</div>

			<!-- Accessible Quick View Modal Dialog -->
			<div id="<?php echo esc_attr( $uid ); ?>" class="kb-modal" role="dialog" aria-modal="true" aria-labelledby="<?php echo esc_attr( $uid ); ?>-title" style="<?php echo esc_attr( $modal_styles ); ?>">
				<div class="kb-modal__backdrop" data-close-modal></div>
				<div class="kb-modal__box">
					<button type="button" class="kb-modal__close" data-close-modal aria-label="<?php esc_attr_e( 'Close dialog', 'kinboni-pro' ); ?>">
						<i data-lucide="x" class="w-5 h-5"></i>
					</button>
					<div class="kb-modal__inner">
						<div class="kb-modal__media">
							<img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $title ); ?>" loading="lazy" />
						</div>
						<div class="kb-modal__content">
							<?php if ( ! empty( $badge ) ) : ?>
								<span class="inline-block text-xs font-bold uppercase tracking-wider text-gold-600 dark:text-gold-400"><?php echo esc_html( $badge ); ?></span>
							<?php endif; ?>
							<h3 id="<?php echo esc_attr( $uid ); ?>-title" class="kb-modal__title"><?php echo esc_html( $title ); ?></h3>
							<p class="kb-modal__price"><?php echo esc_html( $price ); ?></p>
							<div class="kb-modal__desc">
								<?php echo $modal; ?>
							</div>
							<div class="pt-4 mt-auto border-t border-stone-200 dark:border-stone-800 flex items-center gap-3">
								<button type="button" class="kb-btn kb-btn--lg kb-btn--full" onclick="showToast('<?php echo esc_js( sprintf( __( 'Added %s to bag', 'kinboni-pro' ), $title ) ); ?>', 'success')">
									<i data-lucide="shopping-bag" class="w-4 h-4"></i>
									<span><?php esc_html_e( 'Add to Bag', 'kinboni-pro' ); ?></span>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<?php endif; ?>

		<?php
	}
}

