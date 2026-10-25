<?php
namespace KinboniPro\Widgets;

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
	return;
}

class Widget_Header extends \Elementor\Widget_Base {

	/* ─── Identity ──────────────────────────────────────────── */

	public function get_name(): string {
		return 'kinboni_header';
	}

	public function get_title(): string {
		return __( 'KINBONI — Header', 'kinboni-pro' );
	}

	public function get_icon(): string {
		return 'eicon-header';
	}

	public function get_categories(): array {
		return [ 'kinboni' ];
	}

	public function get_keywords(): array {
		return [ 'kinboni', 'header', 'menu', 'navigation', 'navbar', 'logo', 'cart' ];
	}

	public function get_script_depends(): array {
		return [ 'lucide-icons', 'swiper-bundle', 'kinboni-pro', 'kinboni-app' ];
	}

	public function get_style_depends(): array {
		return [ 'kinboni-fonts', 'swiper-bundle', 'kinboni-output', 'kinboni-pro' ];
	}

	/**
	 * Get list of available WordPress navigation menus.
	 *
	 * @return array<string, string>
	 */
	private function get_nav_menus(): array {
		$menus = wp_get_nav_menus();
		$options = [ '' => __( '— Select a Menu —', 'kinboni-pro' ) ];

		if ( ! empty( $menus ) && ! is_wp_error( $menus ) ) {
			foreach ( $menus as $menu ) {
				$options[ (string) $menu->term_id ] = $menu->name;
			}
		}

		return $options;
	}

	/* ─── Controls ──────────────────────────────────────────── */

	protected function register_controls(): void {

		/* ══════════════════════════════════════════════
		   1. LOGO & BRANDING
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_header_brand', [
			'label' => __( 'Logo & Branding', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'header_sticky', [
			'label'        => __( 'Sticky Header', 'kinboni-pro' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'label_on'     => __( 'Sticky', 'kinboni-pro' ),
			'label_off'    => __( 'Static', 'kinboni-pro' ),
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'logo_type', [
			'label'   => __( 'Logo Type', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'monogram',
			'options' => [
				'monogram' => __( 'Text & Monogram Badge (Luxury Atelier)', 'kinboni-pro' ),
				'image'    => __( 'Custom Image Logo', 'kinboni-pro' ),
			],
		] );

		// Custom Image Logo
		$this->add_control( 'logo_image', [
			'label'     => __( 'Upload Logo Image', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::MEDIA,
			'default'   => [ 'url' => '' ],
			'condition' => [ 'logo_type' => 'image' ],
		] );

		$this->add_responsive_control( 'logo_image_width', [
			'label'      => __( 'Logo Width', 'kinboni-pro' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem', '%' ],
			'range'      => [
				'px' => [ 'min' => 40, 'max' => 400, 'step' => 2 ],
			],
			'default'    => [ 'unit' => 'px', 'size' => 140 ],
			'condition'  => [ 'logo_type' => 'image' ],
			'selectors'  => [
				'{{WRAPPER}} .kb-logo-img' => 'width: {{SIZE}}{{UNIT}} !important; max-width: {{SIZE}}{{UNIT}} !important;',
			],
		] );

		$this->add_responsive_control( 'logo_image_height', [
			'label'      => __( 'Logo Max Height', 'kinboni-pro' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [
				'px' => [ 'min' => 20, 'max' => 120, 'step' => 2 ],
			],
			'default'    => [ 'unit' => 'px', 'size' => 42 ],
			'condition'  => [ 'logo_type' => 'image' ],
			'selectors'  => [
				'{{WRAPPER}} .kb-logo-img' => 'max-height: {{SIZE}}{{UNIT}} !important;',
			],
		] );

		// Monogram letter
		$this->add_control( 'logo_monogram', [
			'label'       => __( 'Monogram Badge Letter', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'K',
			'placeholder' => 'K',
			'condition'   => [ 'logo_type' => 'monogram' ],
		] );

		// Wordmark Title
		$this->add_control( 'logo_title', [
			'label'       => __( 'Brand Name / Title', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'KINBONI',
			'placeholder' => 'KINBONI',
			'condition'   => [ 'logo_type' => 'monogram' ],
		] );

		// Wordmark Subtitle
		$this->add_control( 'logo_subtitle', [
			'label'       => __( 'Brand Subtitle / Tagline', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'HAUTE ATELIER',
			'placeholder' => 'HAUTE ATELIER',
			'condition'   => [ 'logo_type' => 'monogram' ],
		] );

		// Logo URL
		$this->add_control( 'logo_url', [
			'label'       => __( 'Logo Target Link', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::URL,
			'default'     => [ 'url' => home_url( '/' ) ],
			'placeholder' => home_url( '/' ),
		] );

		$this->end_controls_section();

		/* ══════════════════════════════════════════════
		   2. NAVIGATION MENU
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_header_nav', [
			'label' => __( 'Navigation Menu', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'menu_type', [
			'label'   => __( 'Menu Source', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'default',
			'options' => [
				'default' => __( 'Default Template Links', 'kinboni-pro' ),
				'wp_menu' => __( 'WordPress Navigation Menu (Appearance > Menus)', 'kinboni-pro' ),
				'custom'  => __( 'Custom Links (Elementor Repeater)', 'kinboni-pro' ),
			],
		] );

		// WordPress Menu Selector
		$this->add_control( 'wp_menu_id', [
			'label'       => __( 'Select WordPress Menu', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::SELECT,
			'options'     => $this->get_nav_menus(),
			'default'     => '',
			'description' => __( 'Manage your menus under WP Admin > Appearance > Menus.', 'kinboni-pro' ),
			'condition'   => [ 'menu_type' => 'wp_menu' ],
		] );

		// Custom Menu Repeater
		$repeater = new \Elementor\Repeater();

		$repeater->add_control( 'item_title', [
			'label'       => __( 'Navigation Label', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => __( 'Menu Item', 'kinboni-pro' ),
			'label_block' => true,
		] );

		$repeater->add_control( 'item_link', [
			'label'       => __( 'Link URL', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::URL,
			'default'     => [ 'url' => '#' ],
			'placeholder' => 'https://example.com or #section',
			'label_block' => true,
		] );

		$this->add_control( 'custom_menu_items', [
			'label'       => __( 'Custom Menu Links', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'default'     => [
				[ 'item_title' => 'Home', 'item_link' => [ 'url' => '#hero' ] ],
				[ 'item_title' => 'Collections', 'item_link' => [ 'url' => '#categories' ] ],
				[ 'item_title' => 'Featured', 'item_link' => [ 'url' => '#featured' ] ],
				[ 'item_title' => 'Best Sellers', 'item_link' => [ 'url' => '#bestsellers' ] ],
				[ 'item_title' => 'Our Story', 'item_link' => [ 'url' => '#heritage' ] ],
				[ 'item_title' => 'Patrons', 'item_link' => [ 'url' => '#testimonials' ] ],
			],
			'title_field' => '{{{ item_title }}}',
			'condition'   => [ 'menu_type' => 'custom' ],
		] );

		$this->end_controls_section();

		/* ══════════════════════════════════════════════
		   3. RIGHT ACTIONS (ON / OFF SWITCHES)
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_header_actions', [
			'label' => __( 'Right Actions (ON / OFF)', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		// 1. Search Button
		$this->add_control( 'show_search', [
			'label'        => __( 'Search Button', 'kinboni-pro' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'label_on'     => __( 'Show', 'kinboni-pro' ),
			'label_off'    => __( 'Hide', 'kinboni-pro' ),
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'search_placeholder', [
			'label'       => __( 'Search Button Text', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => __( 'Search creations...', 'kinboni-pro' ),
			'condition'   => [ 'show_search' => 'yes' ],
		] );

		// 2. Dark/Light Theme Switcher
		$this->add_control( 'show_theme_toggle', [
			'label'        => __( 'Dark/Light Theme Toggle', 'kinboni-pro' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'label_on'     => __( 'Show', 'kinboni-pro' ),
			'label_off'    => __( 'Hide', 'kinboni-pro' ),
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		// 3. Patron Account Concierge
		$this->add_control( 'show_account', [
			'label'        => __( 'Patron Account Button', 'kinboni-pro' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'label_on'     => __( 'Show', 'kinboni-pro' ),
			'label_off'    => __( 'Hide', 'kinboni-pro' ),
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'account_url', [
			'label'       => __( 'Custom Account Link (Optional)', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::URL,
			'placeholder' => __( 'Leave empty for WooCommerce My Account', 'kinboni-pro' ),
			'condition'   => [ 'show_account' => 'yes' ],
		] );

		// 4. Saved Wishlist Drawer Button
		$this->add_control( 'show_wishlist', [
			'label'        => __( 'Wishlist Button & Badge', 'kinboni-pro' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'label_on'     => __( 'Show', 'kinboni-pro' ),
			'label_off'    => __( 'Hide', 'kinboni-pro' ),
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		// 5. Shopping Bag Drawer Button
		$this->add_control( 'show_cart', [
			'label'        => __( 'Shopping Bag Button & Badge', 'kinboni-pro' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'label_on'     => __( 'Show', 'kinboni-pro' ),
			'label_off'    => __( 'Hide', 'kinboni-pro' ),
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'cart_label', [
			'label'       => __( 'Bag Button Label (Desktop)', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => __( 'Bag', 'kinboni-pro' ),
			'condition'   => [ 'show_cart' => 'yes' ],
		] );

		$this->end_controls_section();

		/* ══════════════════════════════════════════════
		   STYLE TAB — HEADER STYLING
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_header_style', [
			'label' => __( 'Header Style & Colors', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'header_bg_color', [
			'label'     => __( 'Header Background', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} #site-header' => 'background-color: {{VALUE}} !important;' ],
		] );

		$this->add_control( 'header_border_color', [
			'label'     => __( 'Bottom Border Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} #site-header' => 'border-color: {{VALUE}} !important;' ],
		] );

		$this->add_control( 'header_nav_color', [
			'label'     => __( 'Menu Links Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} #site-header nav a, {{WRAPPER}} .kb-nav-link' => 'color: {{VALUE}} !important;' ],
		] );

		$this->add_control( 'header_nav_hover_color', [
			'label'     => __( 'Menu Links Hover Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} #site-header nav a:hover, {{WRAPPER}} .kb-nav-link:hover' => 'color: {{VALUE}} !important;',
				'{{WRAPPER}} #site-header nav a:after, {{WRAPPER}} .kb-nav-link:after' => 'background-color: {{VALUE}} !important;',
			],
		] );

		$this->add_control( 'header_icons_color', [
			'label'     => __( 'Action Icons Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} #site-header .open-search-btn, {{WRAPPER}} #site-header .theme-toggle-btn, {{WRAPPER}} #site-header .open-account-btn, {{WRAPPER}} #site-header .open-wishlist-btn, {{WRAPPER}} #site-header #mobile-menu-btn' => 'color: {{VALUE}} !important;',
			],
		] );

		$this->add_control( 'header_bag_btn_bg', [
			'label'     => __( 'Shopping Bag Button Background', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} #site-header .open-cart-btn' => 'background-color: {{VALUE}} !important;' ],
		] );

		$this->add_control( 'header_bag_btn_color', [
			'label'     => __( 'Shopping Bag Button Text/Icon', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} #site-header .open-cart-btn' => 'color: {{VALUE}} !important;' ],
		] );

		$this->end_controls_section();
	}

	/* ─── Render ─────────────────────────────────────────────── */

	protected function render(): void {
		$s = $this->get_settings_for_display();

		// Header Settings
		$is_sticky      = ( 'yes' === ( $s['header_sticky'] ?? 'yes' ) );
		$header_classes = $is_sticky
			? 'sticky top-0 z-40 w-full transition-all duration-300 bg-[#FAF8F5]/90 dark:bg-[#0E0E10]/90 backdrop-blur-md border-b border-stone-200/70 dark:border-stone-800/70'
			: 'relative z-40 w-full transition-all duration-300 bg-[#FAF8F5]/90 dark:bg-[#0E0E10]/90 backdrop-blur-md border-b border-stone-200/70 dark:border-stone-800/70';

		$logo_type      = $s['logo_type'] ?? 'monogram';
		$logo_img_url   = ! empty( $s['logo_image']['url'] ) ? esc_url( $s['logo_image']['url'] ) : '';
		$logo_monogram  = isset( $s['logo_monogram'] ) ? esc_html( $s['logo_monogram'] ) : 'K';
		$logo_title     = ! empty( $s['logo_title'] ) ? esc_html( $s['logo_title'] ) : 'KINBONI';
		$logo_subtitle  = ! empty( $s['logo_subtitle'] ) ? esc_html( $s['logo_subtitle'] ) : 'HAUTE ATELIER';
		$logo_url       = ! empty( $s['logo_url']['url'] ) ? esc_url( $s['logo_url']['url'] ) : home_url( '/' );
		$logo_target    = ! empty( $s['logo_url']['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';

		// Right Action Switches
		$show_search       = ( 'yes' === ( $s['show_search'] ?? 'yes' ) );
		$search_text       = ! empty( $s['search_placeholder'] ) ? esc_html( $s['search_placeholder'] ) : __( 'Search creations...', 'kinboni-pro' );
		$show_theme_toggle = ( 'yes' === ( $s['show_theme_toggle'] ?? 'yes' ) );
		$show_account      = ( 'yes' === ( $s['show_account'] ?? 'yes' ) );
		$account_url       = ! empty( $s['account_url']['url'] ) ? esc_url( $s['account_url']['url'] ) : '';
		if ( empty( $account_url ) && function_exists( 'wc_get_page_permalink' ) ) {
			$account_url = get_permalink( get_option( 'woocommerce_myaccount_page_id' ) );
		}
		$show_wishlist     = ( 'yes' === ( $s['show_wishlist'] ?? 'yes' ) );
		$show_cart         = ( 'yes' === ( $s['show_cart'] ?? 'yes' ) );
		$cart_label        = ! empty( $s['cart_label'] ) ? esc_html( $s['cart_label'] ) : __( 'Bag', 'kinboni-pro' );

		// Menu Source
		$menu_type         = $s['menu_type'] ?? 'default';
		?>

		<header id="site-header" class="<?php echo esc_attr( $header_classes ); ?>">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<div class="flex items-center justify-between h-[72px] gap-4 sm:gap-6">
				
				<!-- Mobile Menu Hamburger Button -->
				<div class="flex items-center lg:hidden">
					<button id="mobile-menu-btn" type="button" class="w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center text-stone-700 dark:text-stone-300 hover:text-gold-600 dark:hover:text-gold-400 hover:bg-stone-200/60 dark:hover:bg-stone-800/60 transition-colors" aria-label="<?php esc_attr_e( 'Open mobile navigation menu', 'kinboni-pro' ); ?>">
						<i data-lucide="menu" class="w-5 h-5"></i>
					</button>
				</div>

				<!-- Brand Monogram & Wordmark Logo -->
				<?php if ( 'image' === $logo_type && ! empty( $logo_img_url ) ) : ?>
					<a href="<?php echo esc_url( $logo_url ); ?>"<?php echo $logo_target; ?> class="group flex items-center gap-2 sm:gap-3 flex-shrink-0" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
						<img src="<?php echo esc_url( $logo_img_url ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" class="kb-logo-img object-contain transition-transform group-hover:scale-105" />
					</a>
				<?php else : ?>
					<a href="<?php echo esc_url( $logo_url ); ?>"<?php echo $logo_target; ?> class="group flex items-center gap-2 sm:gap-3 flex-shrink-0" aria-label="<?php echo esc_attr( $logo_title ); ?>">
						<?php if ( ! empty( $logo_monogram ) ) : ?>
							<span class="kb-logo-monogram hidden sm:grid place-items-center w-10 h-10 rounded-full bg-stone-900 dark:bg-gold-400 text-gold-300 dark:text-stone-950 font-serif text-xl font-semibold shadow-sm transition-transform group-hover:scale-105">
								<?php echo $logo_monogram; ?>
							</span>
						<?php endif; ?>
						<span class="flex flex-col leading-none">
							<span class="kb-logo-title font-serif text-xl sm:text-[26px] font-semibold tracking-[0.2em] sm:tracking-[0.22em] text-stone-900 dark:text-white group-hover:text-gold-600 dark:group-hover:text-gold-400 transition-colors">
								<?php echo $logo_title; ?>
							</span>
							<?php if ( ! empty( $logo_subtitle ) ) : ?>
								<span class="kb-logo-subtitle text-[8px] sm:text-[9px] tracking-[0.35em] sm:tracking-[0.4em] text-gold-600 dark:text-gold-400 font-semibold mt-0.5 sm:mt-1">
									<?php echo $logo_subtitle; ?>
								</span>
							<?php endif; ?>
						</span>
					</a>
				<?php endif; ?>

				<!-- Desktop Navigation Links -->
				<nav class="hidden lg:flex items-center gap-8 xl:gap-9" aria-label="<?php esc_attr_e( 'Main navigation', 'kinboni-pro' ); ?>">
					<?php
					if ( 'wp_menu' === $menu_type && ! empty( $s['wp_menu_id'] ) ) {
						// WordPress Menu rendering
						$wp_items = wp_get_nav_menu_items( (int) $s['wp_menu_id'] );
						if ( ! empty( $wp_items ) && ! is_wp_error( $wp_items ) ) {
							foreach ( $wp_items as $item ) {
								if ( empty( $item->menu_item_parent ) || 0 === (int) $item->menu_item_parent ) {
									$target = ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '" rel="noopener noreferrer"' : '';
									$active = in_array( 'current-menu-item', (array) $item->classes, true ) ? ' text-gold-600 dark:text-gold-400' : '';
									?>
									<a href="<?php echo esc_url( $item->url ); ?>"<?php echo $target; ?> class="kb-nav-link relative text-[13px] font-semibold tracking-wide text-stone-700 dark:text-stone-300 hover:text-gold-600 dark:hover:text-gold-400 transition-colors after:absolute after:left-0 after:-bottom-1.5 after:h-0.5 after:w-0 after:bg-gold-500 after:transition-all hover:after:w-full<?php echo esc_attr( $active ); ?>">
										<?php echo esc_html( $item->title ); ?>
									</a>
									<?php
								}
							}
						}
					} elseif ( 'custom' === $menu_type && ! empty( $s['custom_menu_items'] ) ) {
						// Custom Repeater rendering
						foreach ( $s['custom_menu_items'] as $item ) {
							$item_title = ! empty( $item['item_title'] ) ? esc_html( $item['item_title'] ) : '';
							$item_url   = ! empty( $item['item_link']['url'] ) ? esc_url( $item['item_link']['url'] ) : '#';
							$target     = ! empty( $item['item_link']['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
							?>
							<a href="<?php echo $item_url; ?>"<?php echo $target; ?> class="kb-nav-link relative text-[13px] font-semibold tracking-wide text-stone-700 dark:text-stone-300 hover:text-gold-600 dark:hover:text-gold-400 transition-colors after:absolute after:left-0 after:-bottom-1.5 after:h-0.5 after:w-0 after:bg-gold-500 after:transition-all hover:after:w-full">
								<?php echo $item_title; ?>
							</a>
							<?php
						}
					} else {
						// Default Luxury Links
						?>
						<a href="#hero" class="kb-nav-link relative text-[13px] font-semibold tracking-wide text-stone-700 dark:text-stone-300 hover:text-gold-600 dark:hover:text-gold-400 transition-colors after:absolute after:left-0 after:-bottom-1.5 after:h-0.5 after:w-0 after:bg-gold-500 after:transition-all hover:after:w-full"><?php esc_html_e( 'Home', 'kinboni-pro' ); ?></a>
						<a href="#categories" class="kb-nav-link relative text-[13px] font-semibold tracking-wide text-stone-700 dark:text-stone-300 hover:text-gold-600 dark:hover:text-gold-400 transition-colors after:absolute after:left-0 after:-bottom-1.5 after:h-0.5 after:w-0 after:bg-gold-500 after:transition-all hover:after:w-full"><?php esc_html_e( 'Collections', 'kinboni-pro' ); ?></a>
						<a href="#featured" class="kb-nav-link relative text-[13px] font-semibold tracking-wide text-stone-700 dark:text-stone-300 hover:text-gold-600 dark:hover:text-gold-400 transition-colors after:absolute after:left-0 after:-bottom-1.5 after:h-0.5 after:w-0 after:bg-gold-500 after:transition-all hover:after:w-full"><?php esc_html_e( 'Featured', 'kinboni-pro' ); ?></a>
						<a href="#bestsellers" class="kb-nav-link relative text-[13px] font-semibold tracking-wide text-stone-700 dark:text-stone-300 hover:text-gold-600 dark:hover:text-gold-400 transition-colors after:absolute after:left-0 after:-bottom-1.5 after:h-0.5 after:w-0 after:bg-gold-500 after:transition-all hover:after:w-full"><?php esc_html_e( 'Best Sellers', 'kinboni-pro' ); ?></a>
						<a href="#heritage" class="kb-nav-link relative text-[13px] font-semibold tracking-wide text-stone-700 dark:text-stone-300 hover:text-gold-600 dark:hover:text-gold-400 transition-colors after:absolute after:left-0 after:-bottom-1.5 after:h-0.5 after:w-0 after:bg-gold-500 after:transition-all hover:after:w-full"><?php esc_html_e( 'Our Story', 'kinboni-pro' ); ?></a>
						<a href="#testimonials" class="kb-nav-link relative text-[13px] font-semibold tracking-wide text-stone-700 dark:text-stone-300 hover:text-gold-600 dark:hover:text-gold-400 transition-colors after:absolute after:left-0 after:-bottom-1.5 after:h-0.5 after:w-0 after:bg-gold-500 after:transition-all hover:after:w-full"><?php esc_html_e( 'Patrons', 'kinboni-pro' ); ?></a>
						<?php
					}
					?>
				</nav>

				<!-- Right Action Icons (Configurable ON / OFF) -->
				<div class="flex items-center gap-1 sm:gap-2">
				
					<!-- 1. Search Button -->
					<?php if ( $show_search ) : ?>
						<button type="button" class="open-search-btn hidden md:flex items-center gap-2 pl-3.5 pr-4 py-2 rounded-full border border-stone-300 dark:border-stone-700 text-xs text-stone-500 dark:text-stone-400 hover:border-gold-500 hover:text-gold-600 dark:hover:text-gold-400 transition-colors" aria-label="<?php esc_attr_e( 'Search creations', 'kinboni-pro' ); ?>">
							<i data-lucide="search" class="w-3.5 h-3.5"></i>
							<span class="font-medium"><?php echo $search_text; ?></span>
						</button>
						<button type="button" class="open-search-btn md:hidden w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center text-stone-700 dark:text-stone-300 hover:text-gold-600 dark:hover:text-gold-400 hover:bg-stone-200/60 dark:hover:bg-stone-800/60 transition-colors" aria-label="<?php esc_attr_e( 'Search creations', 'kinboni-pro' ); ?>">
							<i data-lucide="search" class="w-4 h-4 sm:w-5 sm:h-5"></i>
						</button>
					<?php endif; ?>

					<!-- 2. Dark/Light Theme Toggle -->
					<?php if ( $show_theme_toggle ) : ?>
						<button type="button" class="theme-toggle-btn w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center text-stone-700 dark:text-stone-300 hover:text-gold-600 dark:hover:text-gold-400 hover:bg-stone-200/60 dark:hover:bg-stone-800/60 transition-colors" aria-label="<?php esc_attr_e( 'Toggle dark and light mode', 'kinboni-pro' ); ?>">
							<i data-lucide="sun" class="theme-sun-icon w-4 h-4 sm:w-5 sm:h-5 hidden"></i>
							<i data-lucide="moon" class="theme-moon-icon w-4 h-4 sm:w-5 sm:h-5"></i>
						</button>
					<?php endif; ?>

					<!-- 3. Patron Account Concierge -->
					<?php if ( $show_account ) : ?>
						<?php if ( ! empty( $account_url ) ) : ?>
							<a href="<?php echo esc_url( $account_url ); ?>" class="hidden sm:flex w-10 h-10 rounded-full items-center justify-center text-stone-700 dark:text-stone-300 hover:text-gold-600 dark:hover:text-gold-400 hover:bg-stone-200/60 dark:hover:bg-stone-800/60 transition-colors" aria-label="<?php esc_attr_e( 'Patron Account Concierge', 'kinboni-pro' ); ?>">
								<i data-lucide="user" class="w-5 h-5"></i>
							</a>
						<?php else : ?>
							<button type="button" class="open-account-btn hidden sm:flex w-10 h-10 rounded-full items-center justify-center text-stone-700 dark:text-stone-300 hover:text-gold-600 dark:hover:text-gold-400 hover:bg-stone-200/60 dark:hover:bg-stone-800/60 transition-colors" aria-label="<?php esc_attr_e( 'Patron Account Concierge', 'kinboni-pro' ); ?>">
								<i data-lucide="user" class="w-5 h-5"></i>
							</button>
						<?php endif; ?>
					<?php endif; ?>

					<!-- 4. Wishlist Button with Badge -->
					<?php if ( $show_wishlist ) : ?>
						<button type="button" class="open-wishlist-btn relative w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center text-stone-700 dark:text-stone-300 hover:text-gold-600 dark:hover:text-gold-400 hover:bg-stone-200/60 dark:hover:bg-stone-800/60 transition-colors" aria-label="<?php esc_attr_e( 'View Saved Wishlist', 'kinboni-pro' ); ?>">
							<i data-lucide="heart" class="w-4 h-4 sm:w-5 sm:h-5"></i>
							<span class="wishlist-count-badge absolute top-0.5 right-0.5 transform scale-0 transition-transform duration-300 flex items-center justify-center min-w-[16px] h-[16px] sm:min-w-[18px] sm:h-[18px] px-1 text-[9px] sm:text-[10px] font-bold text-white bg-rose-600 rounded-full shadow-sm">0</span>
						</button>
					<?php endif; ?>

					<!-- 5. Shopping Bag Button with Live Item Counter -->
					<?php if ( $show_cart ) : ?>
						<button type="button" class="open-cart-btn relative w-8 h-8 sm:w-auto p-0 sm:pl-3.5 sm:pr-4 sm:py-2 rounded-full bg-stone-900 dark:bg-gold-400 text-white dark:text-stone-950 hover:bg-gold-600 dark:hover:bg-gold-300 transition-all shadow-sm active:scale-95 flex items-center justify-center sm:gap-2 flex-shrink-0" aria-label="<?php esc_attr_e( 'Open Shopping Bag', 'kinboni-pro' ); ?>">
							<i data-lucide="shopping-bag" class="cart-badge-icon w-4 h-4 transition-transform duration-200"></i>
							<span class="hidden sm:inline text-xs font-bold tracking-wide"><?php echo $cart_label; ?></span>
							<span class="cart-count-badge absolute -top-1 -right-1 sm:-top-1.5 sm:-right-1.5 transform scale-0 transition-transform duration-300 flex items-center justify-center min-w-[18px] h-[18px] sm:min-w-[20px] sm:h-[20px] px-1 text-[10px] sm:text-[11px] font-bold text-stone-950 bg-gold-400 dark:bg-white rounded-full shadow-md">0</span>
						</button>
					<?php endif; ?>

				</div>
			</div>
			</div>
		</header>

		<?php
	}
}

