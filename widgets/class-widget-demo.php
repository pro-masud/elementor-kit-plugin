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

	/* ─── Controls ──────────────────────────────────────────── */

	protected function register_controls(): void {

		/* ── Content Tab ─────────────────────────────── */
		$this->start_controls_section( 'section_content', [
			'label' => __( 'Card Content', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'image', [
			'label'   => __( 'Image', 'kinboni-pro' ),
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
	}

	/* ─── Render ─────────────────────────────────────────────── */

	protected function render(): void {
		$s = $this->get_settings_for_display();

		$uid          = 'kb-modal-' . $this->get_id();
		$img          = ! empty( $s['image']['url'] ) ? esc_url( $s['image']['url'] ) : '';
		$title        = esc_html( $s['title'] );
		$desc         = nl2br( esc_html( $s['description'] ) );
		$price        = esc_html( $s['price'] );
		$badge        = esc_html( $s['badge_text'] );
		$btn          = esc_html( $s['button_text'] );
		$modal        = wp_kses_post( $s['modal_description'] );
		$accent_color = ! empty( $s['accent_color'] ) ? sanitize_hex_color( $s['accent_color'] ) : '#C5A028';
		$card_bg      = ! empty( $s['card_bg'] ) ? sanitize_hex_color( $s['card_bg'] ) : '#ffffff';
		$title_color  = ! empty( $s['title_color'] ) ? sanitize_hex_color( $s['title_color'] ) : '#1a1a1a';

		$modal_styles = sprintf(
			'--kb-gold: %s; --kb-surface: %s; --kb-text: %s;',
			$accent_color,
			$card_bg,
			$title_color
		);
		?>

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

		<?php
	}
}

