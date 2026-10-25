<?php
namespace KinboniPro\Widgets;

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
	return;
}

if ( class_exists( '\KinboniPro\Widgets\Widget_Footer' ) ) {
	return;
}

class Widget_Footer extends \Elementor\Widget_Base {

	/* ─── Identity ──────────────────────────────────────────── */

	public function get_name(): string {
		return 'kinboni_footer';
	}

	public function get_title(): string {
		return __( 'KINBONI — Luxury Footer', 'kinboni-pro' );
	}

	public function get_icon(): string {
		return 'eicon-footer';
	}

	public function get_categories(): array {
		return [ 'kinboni' ];
	}

	public function get_keywords(): array {
		return [ 'kinboni', 'footer', 'atelier', 'social', 'contact', 'copyright', 'payments', 'luxury' ];
	}

	public function get_script_depends(): array {
		return [ 'lucide-icons', 'kinboni-pro', 'kinboni-app' ];
	}

	public function get_style_depends(): array {
		return [ 'kinboni-fonts', 'kinboni-output', 'kinboni-pro' ];
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

	/**
	 * Return clean SVG for social media platforms.
	 *
	 * @param string $platform
	 * @return string
	 */
	private function get_social_svg( string $platform ): string {
		switch ( strtolower( trim( $platform ) ) ) {
			case 'instagram':
				return '<svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>';

			case 'facebook':
				return '<svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>';

			case 'youtube':
				return '<svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>';

			case 'twitter':
			case 'x':
				return '<svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>';

			case 'whatsapp':
				return '<svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>';

			case 'linkedin':
				return '<svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>';

			default:
				return '<svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg>';
		}
	}

	/* ─── Controls ──────────────────────────────────────────── */

	protected function register_controls(): void {

		/* ══════════════════════════════════════════════
		   1. BRAND IDENTITY & BIO (COLUMN 1)
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_brand', [
			'label' => __( 'Brand Identity & Bio', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
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

		$this->add_control( 'logo_monogram', [
			'label'     => __( 'Monogram Letter', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::TEXT,
			'default'   => 'K',
			'condition' => [ 'logo_type' => 'monogram' ],
		] );

		$this->add_control( 'logo_title', [
			'label'     => __( 'Brand Title', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::TEXT,
			'default'   => 'KINBONI',
			'condition' => [ 'logo_type' => 'monogram' ],
		] );

		$this->add_control( 'logo_subtitle', [
			'label'     => __( 'Brand Subtitle', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::TEXT,
			'default'   => 'HAUTE ATELIER',
			'condition' => [ 'logo_type' => 'monogram' ],
		] );

		$this->add_control( 'logo_image', [
			'label'     => __( 'Upload Logo Image', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::MEDIA,
			'default'   => [ 'url' => '' ],
			'condition' => [ 'logo_type' => 'image' ],
		] );

		$this->add_responsive_control( 'logo_image_width', [
			'label'      => __( 'Logo Image Width', 'kinboni-pro' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range'      => [ 'px' => [ 'min' => 40, 'max' => 260 ] ],
			'selectors'  => [ '{{WRAPPER}} .kb-footer-logo-img' => 'width: {{SIZE}}{{UNIT}};' ],
			'condition'  => [ 'logo_type' => 'image' ],
		] );

		$this->add_control( 'logo_url', [
			'label'       => __( 'Logo Link', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::URL,
			'placeholder' => home_url( '/' ),
			'default'     => [ 'url' => '#hero' ],
		] );

		$this->add_control( 'brand_bio', [
			'label'       => __( 'Brand Bio / Description', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXTAREA,
			'rows'        => 3,
			'default'     => __( 'Fine chronographs, Tuscan leather goods and artisanal extraits, made in small batches for people who keep what they buy.', 'kinboni-pro' ),
			'label_block' => true,
		] );

		// Social Links Repeater
		$social_repeater = new \Elementor\Repeater();

		$social_repeater->add_control( 'platform', [
			'label'   => __( 'Platform', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'instagram',
			'options' => [
				'instagram' => __( 'Instagram', 'kinboni-pro' ),
				'facebook'  => __( 'Facebook', 'kinboni-pro' ),
				'youtube'   => __( 'YouTube', 'kinboni-pro' ),
				'twitter'   => __( 'Twitter / X', 'kinboni-pro' ),
				'whatsapp'  => __( 'WhatsApp', 'kinboni-pro' ),
				'linkedin'  => __( 'LinkedIn', 'kinboni-pro' ),
			],
		] );

		$social_repeater->add_control( 'url', [
			'label'       => __( 'Link URL', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::URL,
			'placeholder' => 'https://instagram.com/yourbrand',
			'default'     => [ 'url' => 'javascript:void(0)' ],
		] );

		$social_repeater->add_control( 'aria_label', [
			'label'       => __( 'Aria Label (Accessibility)', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => __( 'Social Profile', 'kinboni-pro' ),
		] );

		$this->add_control( 'social_links', [
			'label'       => __( 'Social Media Links', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $social_repeater->get_controls(),
			'default'     => [
				[ 'platform' => 'instagram', 'aria_label' => 'Instagram', 'url' => [ 'url' => 'javascript:void(0)' ] ],
				[ 'platform' => 'facebook',  'aria_label' => 'Facebook',  'url' => [ 'url' => 'javascript:void(0)' ] ],
				[ 'platform' => 'youtube',   'aria_label' => 'YouTube',   'url' => [ 'url' => 'javascript:void(0)' ] ],
			],
			'title_field' => '{{{ aria_label || platform }}}',
		] );

		$this->end_controls_section();


		/* ══════════════════════════════════════════════
		   2. COLLECTIONS (COLUMN 2)
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_col_collections', [
			'label' => __( 'Column 2 — Collections', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'collections_title', [
			'label'   => __( 'Column Heading', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => __( 'Collections', 'kinboni-pro' ),
		] );

		$this->add_control( 'collections_source', [
			'label'   => __( 'Navigation Source', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'custom',
			'options' => [
				'custom'   => __( 'Custom Atelier Filter Links (Default)', 'kinboni-pro' ),
				'wc_cats'  => __( 'Live WooCommerce Categories', 'kinboni-pro' ),
				'wp_menu'  => __( 'WordPress Navigation Menu', 'kinboni-pro' ),
			],
		] );

		$this->add_control( 'collections_menu_id', [
			'label'     => __( 'Select WordPress Menu', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::SELECT,
			'options'   => $this->get_nav_menus(),
			'condition' => [ 'collections_source' => 'wp_menu' ],
		] );

		$col_repeater = new \Elementor\Repeater();

		$col_repeater->add_control( 'label', [
			'label'   => __( 'Link Label', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'Chronographs',
		] );

		$col_repeater->add_control( 'link_url', [
			'label'   => __( 'Link URL', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => '#bestsellers',
		] );

		$col_repeater->add_control( 'bestseller_filter', [
			'label'   => __( 'Filter Category (On Click)', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'timepieces',
			'options' => [
				'timepieces' => __( 'Chronographs (timepieces)', 'kinboni-pro' ),
				'leather'    => __( 'Leather Goods (leather)', 'kinboni-pro' ),
				'fragrance'  => __( 'Fine Fragrance (fragrance)', 'kinboni-pro' ),
				'jewelry'    => __( 'Fine Jewelry (jewelry)', 'kinboni-pro' ),
				'eyewear'    => __( 'Eyewear (eyewear)', 'kinboni-pro' ),
				'silk'       => __( 'Silk & Cashmere (silk)', 'kinboni-pro' ),
				'all'        => __( 'All Products (all)', 'kinboni-pro' ),
				'none'       => __( 'None (Standard URL Navigation)', 'kinboni-pro' ),
			],
		] );

		$this->add_control( 'collections_items', [
			'label'       => __( 'Collection Links', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $col_repeater->get_controls(),
			'default'     => [
				[ 'label' => 'Chronographs',     'link_url' => '#bestsellers', 'bestseller_filter' => 'timepieces' ],
				[ 'label' => 'Leather Goods',    'link_url' => '#bestsellers', 'bestseller_filter' => 'leather' ],
				[ 'label' => 'Fine Fragrance',   'link_url' => '#bestsellers', 'bestseller_filter' => 'fragrance' ],
				[ 'label' => 'Fine Jewelry',     'link_url' => '#bestsellers', 'bestseller_filter' => 'jewelry' ],
				[ 'label' => 'Eyewear',          'link_url' => '#bestsellers', 'bestseller_filter' => 'eyewear' ],
				[ 'label' => 'Silk & Cashmere',  'link_url' => '#bestsellers', 'bestseller_filter' => 'silk' ],
			],
			'title_field' => '{{{ label }}}',
			'condition'   => [ 'collections_source' => 'custom' ],
		] );

		$this->end_controls_section();


		/* ══════════════════════════════════════════════
		   3. CUSTOMER CARE (COLUMN 3)
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_col_care', [
			'label' => __( 'Column 3 — Customer Care', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'care_title', [
			'label'   => __( 'Column Heading', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => __( 'Customer care', 'kinboni-pro' ),
		] );

		$this->add_control( 'care_source', [
			'label'   => __( 'Navigation Source', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'custom',
			'options' => [
				'custom'   => __( 'Custom Concierge Links (Default)', 'kinboni-pro' ),
				'wp_menu'  => __( 'WordPress Navigation Menu', 'kinboni-pro' ),
			],
		] );

		$this->add_control( 'care_menu_id', [
			'label'     => __( 'Select WordPress Menu', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::SELECT,
			'options'   => $this->get_nav_menus(),
			'condition' => [ 'care_source' => 'wp_menu' ],
		] );

		$care_repeater = new \Elementor\Repeater();

		$care_repeater->add_control( 'label', [
			'label'   => __( 'Link Label', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'Delivery and charges',
		] );

		$care_repeater->add_control( 'link_url', [
			'label'       => __( 'Link URL', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'javascript:void(0)',
			'placeholder' => 'javascript:void(0) or https://...',
		] );

		$care_repeater->add_control( 'toast_message', [
			'label'       => __( 'Interactive Toast Notice', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'Free delivery on all orders over ৳2,500.',
			'description' => __( 'Appears when clicking the link if URL is javascript:void(0).', 'kinboni-pro' ),
		] );

		$this->add_control( 'care_items', [
			'label'       => __( 'Customer Care Links', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $care_repeater->get_controls(),
			'default'     => [
				[ 'label' => 'Delivery and charges', 'link_url' => 'javascript:void(0)', 'toast_message' => 'Free delivery on all orders over ৳2,500.' ],
				[ 'label' => 'Track your order',     'link_url' => 'javascript:void(0)', 'toast_message' => 'Track your order: Contact concierge with order ID.' ],
				[ 'label' => 'Exchange policy',      'link_url' => 'javascript:void(0)', 'toast_message' => 'Exchange within 7 days of delivery, unused and in original packaging.' ],
				[ 'label' => 'Product care',         'link_url' => 'javascript:void(0)', 'toast_message' => 'Care guides for leather and watches are available on request.' ],
			],
			'title_field' => '{{{ label }}}',
			'condition'   => [ 'care_source' => 'custom' ],
		] );

		$this->end_controls_section();


		/* ══════════════════════════════════════════════
		   4. VISIT OR CONTACT (COLUMN 4)
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_col_contact', [
			'label' => __( 'Column 4 — Visit & Contact', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'contact_title', [
			'label'   => __( 'Column Heading', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => __( 'Visit or contact', 'kinboni-pro' ),
		] );

		// Address
		$this->add_control( 'contact_address', [
			'label'   => __( 'Showroom Address', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'Avenue 4, Road 11, Gulshan-2, Dhaka 1212',
		] );

		$this->add_control( 'contact_address_icon', [
			'label'   => __( 'Address Lucide Icon', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'map-pin',
		] );

		// Phone
		$this->add_control( 'contact_phone', [
			'label'   => __( 'Concierge Phone', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => '+880 1711 000000',
		] );

		$this->add_control( 'contact_phone_icon', [
			'label'   => __( 'Phone Lucide Icon', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'phone',
		] );

		// Email
		$this->add_control( 'contact_email', [
			'label'   => __( 'Concierge Email', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'concierge@kinboni.com',
		] );

		$this->add_control( 'contact_email_icon', [
			'label'   => __( 'Email Lucide Icon', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'mail',
		] );

		// Operating Hours
		$this->add_control( 'contact_hours', [
			'label'   => __( 'Operating Hours / Notice', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'Mon to Sat, 10 AM to 9 PM',
		] );

		$this->end_controls_section();


		/* ══════════════════════════════════════════════
		   5. FOOTER BOTTOM (COPYRIGHT & PAYMENTS)
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_footer_bottom', [
			'label' => __( 'Bottom Bar — Copyright & Badges', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'copyright_text', [
			'label'       => __( 'Copyright Text', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXTAREA,
			'rows'        => 2,
			'default'     => '&copy; {year} KINBONI Atelier. All rights reserved.',
			'description' => __( 'Use {year} to dynamically output the current year.', 'kinboni-pro' ),
		] );

		$this->add_control( 'show_payment_badges', [
			'label'        => __( 'Show Payment Badges', 'kinboni-pro' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$payment_repeater = new \Elementor\Repeater();

		$payment_repeater->add_control( 'badge_name', [
			'label'   => __( 'Badge Name', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'bKash',
		] );

		$this->add_control( 'payment_badges', [
			'label'       => __( 'Payment Badges List', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $payment_repeater->get_controls(),
			'default'     => [
				[ 'badge_name' => 'VISA' ],
				[ 'badge_name' => 'MASTERCARD' ],
				[ 'badge_name' => 'bKash' ],
				[ 'badge_name' => 'Nagad' ],
				[ 'badge_name' => 'Cash on delivery' ],
			],
			'title_field' => '{{{ badge_name }}}',
			'condition'   => [ 'show_payment_badges' => 'yes' ],
		] );

		$this->end_controls_section();


		/* ══════════════════════════════════════════════
		   STYLE TAB: BACKGROUND & ACCENTS
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_style_bg', [
			'label' => __( 'Background & Accent Border', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'footer_bg_color', [
			'label'     => __( 'Footer Background', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-footer' => 'background-color: {{VALUE}} !important;' ],
		] );

		$this->add_control( 'footer_top_border_color', [
			'label'     => __( 'Top Gold Border Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-footer' => 'border-top-color: {{VALUE}} !important;' ],
		] );

		$this->add_responsive_control( 'footer_padding', [
			'label'      => __( 'Footer Padding', 'kinboni-pro' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', '%' ],
			'selectors'  => [ '{{WRAPPER}} .kb-footer-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->end_controls_section();


		/* ══════════════════════════════════════════════
		   STYLE TAB: TYPOGRAPHY & LINKS
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_style_typography', [
			'label' => __( 'Headings & Links', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'footer_heading_color', [
			'label'     => __( 'Columns Heading Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-footer-col-title' => 'color: {{VALUE}} !important;' ],
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'footer_heading_typo',
				'label'    => __( 'Heading Typography', 'kinboni-pro' ),
				'selector' => '{{WRAPPER}} .kb-footer-col-title',
			]
		);

		$this->add_control( 'footer_link_color', [
			'label'     => __( 'Links & Text Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .kb-footer-link' => 'color: {{VALUE}} !important;',
				'{{WRAPPER}} .kb-footer-text' => 'color: {{VALUE}} !important;',
			],
		] );

		$this->add_control( 'footer_link_hover_color', [
			'label'     => __( 'Links Hover Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .kb-footer-link:hover' => 'color: {{VALUE}} !important;',
			],
		] );

		$this->add_control( 'footer_gold_icon_color', [
			'label'     => __( 'Contact Icons & Monogram Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .kb-footer-contact-icon' => 'color: {{VALUE}} !important;',
				'{{WRAPPER}} .kb-footer-monogram'     => 'background-color: {{VALUE}} !important;',
			],
		] );

		$this->end_controls_section();
	}

	/* ─── Render ────────────────────────────────────────────── */

	protected function render(): void {
		$s = $this->get_settings_for_display();

		// Brand & Logo
		$logo_type     = $s['logo_type'] ?? 'monogram';
		$logo_monogram = $s['logo_monogram'] ?? 'K';
		$logo_title    = $s['logo_title'] ?? 'KINBONI';
		$logo_subtitle = $s['logo_subtitle'] ?? 'HAUTE ATELIER';
		$logo_url      = ! empty( $s['logo_url']['url'] ) ? esc_url( $s['logo_url']['url'] ) : '#hero';
		$logo_target   = ! empty( $s['logo_url']['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
		$logo_image    = ! empty( $s['logo_image']['url'] ) ? esc_url( $s['logo_image']['url'] ) : '';

		// Dynamic Copyright
		$raw_copy = $s['copyright_text'] ?? '&copy; {year} KINBONI Atelier. All rights reserved.';
		$clean_copy = str_replace( '{year}', date( 'Y' ), $raw_copy );
		?>

		<footer class="kb-footer bg-stone-950 text-stone-400 border-t-2 border-gold-500/70">
			<div class="kb-footer-inner max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-8">
				<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 pb-12 border-b border-stone-800">
					
					<!-- Column 1: Brand Atelier & Social Profiles -->
					<div class="lg:col-span-4 space-y-5">
						<a href="<?php echo esc_url( $logo_url ); ?>"<?php echo $logo_target; ?> class="inline-flex items-center gap-3 group" aria-label="<?php echo esc_attr( $logo_title ); ?>">
							<?php if ( 'image' === $logo_type && ! empty( $logo_image ) ) : ?>
								<img src="<?php echo esc_url( $logo_image ); ?>" alt="<?php echo esc_attr( $logo_title ); ?>" class="kb-footer-logo-img object-contain" />
							<?php else : ?>
								<span class="kb-footer-monogram grid place-items-center w-11 h-11 rounded-full bg-gold-400 text-stone-950 font-serif text-xl font-semibold shadow-sm transition-transform group-hover:scale-105">
									<?php echo esc_html( $logo_monogram ); ?>
								</span>
								<span class="flex flex-col leading-none">
									<span class="font-serif text-2xl font-semibold tracking-[0.22em] text-white transition-colors group-hover:text-gold-400">
										<?php echo esc_html( $logo_title ); ?>
									</span>
									<span class="text-[9px] tracking-[0.4em] text-gold-400 font-semibold mt-1">
										<?php echo esc_html( $logo_subtitle ); ?>
									</span>
								</span>
							<?php endif; ?>
						</a>

						<?php if ( ! empty( $s['brand_bio'] ) ) : ?>
							<p class="kb-footer-text text-sm leading-relaxed max-w-sm font-light text-stone-400">
								<?php echo esc_html( $s['brand_bio'] ); ?>
							</p>
						<?php endif; ?>

						<!-- Social Profiles -->
						<?php if ( ! empty( $s['social_links'] ) && is_array( $s['social_links'] ) ) : ?>
							<div class="flex items-center gap-2.5">
								<?php foreach ( $s['social_links'] as $item ) :
									$plat_url = ! empty( $item['url']['url'] ) ? esc_url( $item['url']['url'] ) : 'javascript:void(0)';
									$plat_target = ! empty( $item['url']['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
									$aria = ! empty( $item['aria_label'] ) ? esc_attr( $item['aria_label'] ) : esc_attr( $item['platform'] );
									?>
									<a href="<?php echo $plat_url; ?>"<?php echo $plat_target; ?>
									   class="w-9 h-9 rounded-full border border-stone-800 flex items-center justify-center hover:bg-gold-400 hover:text-stone-950 hover:border-gold-400 transition-colors text-stone-400"
									   aria-label="<?php echo $aria; ?>">
										<?php echo $this->get_social_svg( $item['platform'] ); ?>
									</a>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</div>

					<!-- Column 2: Collections -->
					<div class="lg:col-span-2">
						<?php if ( ! empty( $s['collections_title'] ) ) : ?>
							<h4 class="kb-footer-col-title text-sm font-semibold text-white mb-4">
								<?php echo esc_html( $s['collections_title'] ); ?>
							</h4>
						<?php endif; ?>

						<ul class="space-y-3 text-sm">
							<?php
							$c_source = $s['collections_source'] ?? 'custom';

							if ( 'wp_menu' === $c_source && ! empty( $s['collections_menu_id'] ) ) {
								$items = wp_get_nav_menu_items( $s['collections_menu_id'] );
								if ( ! empty( $items ) && ! is_wp_error( $items ) ) {
									foreach ( $items as $m ) {
										printf(
											'<li><a href="%s" class="kb-footer-link block text-stone-400 hover:text-gold-400 transition-colors">%s</a></li>',
											esc_url( $m->url ),
											esc_html( $m->title )
										);
									}
								}
							} elseif ( 'wc_cats' === $c_source && function_exists( 'get_terms' ) ) {
								$terms = get_terms( [
									'taxonomy'   => 'product_cat',
									'hide_empty' => false,
									'number'     => 6,
								] );
								if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
									foreach ( $terms as $cat ) {
										printf(
											'<li><a href="%s" class="kb-footer-link block text-stone-400 hover:text-gold-400 transition-colors">%s</a></li>',
											esc_url( get_term_link( $cat ) ),
											esc_html( $cat->name )
										);
									}
								}
							} else {
								// Default custom atelier links
								$col_items = $s['collections_items'] ?? [];
								foreach ( $col_items as $c_item ) {
									$filter = $c_item['bestseller_filter'] ?? 'none';
									$click_attr = '';
									if ( 'none' !== $filter && ! empty( $filter ) ) {
										$click_attr = sprintf( ' onclick="if(window.ProductRenderer) ProductRenderer.renderBestSellers(\'%s\');"', esc_attr( $filter ) );
									}
									$url = ! empty( $c_item['link_url'] ) ? esc_url( $c_item['link_url'] ) : '#bestsellers';
									printf(
										'<li><a href="%s"%s class="kb-footer-link block text-stone-400 hover:text-gold-400 transition-colors">%s</a></li>',
										$url,
										$click_attr,
										esc_html( $c_item['label'] ?? '' )
									);
								}
							}
							?>
						</ul>
					</div>

					<!-- Column 3: Customer Care -->
					<div class="lg:col-span-3">
						<?php if ( ! empty( $s['care_title'] ) ) : ?>
							<h4 class="kb-footer-col-title text-sm font-semibold text-white mb-4">
								<?php echo esc_html( $s['care_title'] ); ?>
							</h4>
						<?php endif; ?>

						<ul class="space-y-3 text-sm">
							<?php
							$care_source = $s['care_source'] ?? 'custom';

							if ( 'wp_menu' === $care_source && ! empty( $s['care_menu_id'] ) ) {
								$c_items = wp_get_nav_menu_items( $s['care_menu_id'] );
								if ( ! empty( $c_items ) && ! is_wp_error( $c_items ) ) {
									foreach ( $c_items as $m ) {
										printf(
											'<li><a href="%s" class="kb-footer-link block text-stone-400 hover:text-gold-400 transition-colors">%s</a></li>',
											esc_url( $m->url ),
											esc_html( $m->title )
										);
									}
								}
							} else {
								$care_items = $s['care_items'] ?? [];
								foreach ( $care_items as $item ) {
									$url   = ! empty( $item['link_url'] ) ? esc_url( $item['link_url'] ) : 'javascript:void(0)';
									$toast = ! empty( $item['toast_message'] ) ? esc_js( $item['toast_message'] ) : '';
									$click = ! empty( $toast ) ? ' onclick="if(window.showToast) showToast(\'' . $toast . '\', \'info\');"' : '';

									printf(
										'<li><a href="%s"%s class="kb-footer-link block text-stone-400 hover:text-gold-400 transition-colors">%s</a></li>',
										$url,
										$click,
										esc_html( $item['label'] ?? '' )
									);
								}
							}
							?>
						</ul>
					</div>

					<!-- Column 4: Visit or Contact -->
					<div class="lg:col-span-3">
						<?php if ( ! empty( $s['contact_title'] ) ) : ?>
							<h4 class="kb-footer-col-title text-sm font-semibold text-white mb-4">
								<?php echo esc_html( $s['contact_title'] ); ?>
							</h4>
						<?php endif; ?>

						<div class="space-y-3 text-sm">
							<?php if ( ! empty( $s['contact_address'] ) ) : ?>
								<p class="flex items-start gap-2.5">
									<i data-lucide="<?php echo esc_attr( $s['contact_address_icon'] ?: 'map-pin' ); ?>" class="kb-footer-contact-icon w-4 h-4 text-gold-400 flex-shrink-0 mt-0.5"></i>
									<span class="kb-footer-text text-stone-400"><?php echo esc_html( $s['contact_address'] ); ?></span>
								</p>
							<?php endif; ?>

							<?php if ( ! empty( $s['contact_phone'] ) ) : ?>
								<p class="flex items-center gap-2.5">
									<i data-lucide="<?php echo esc_attr( $s['contact_phone_icon'] ?: 'phone' ); ?>" class="kb-footer-contact-icon w-4 h-4 text-gold-400 flex-shrink-0"></i>
									<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $s['contact_phone'] ) ); ?>" class="kb-footer-link text-stone-400 hover:text-gold-400 transition-colors">
										<?php echo esc_html( $s['contact_phone'] ); ?>
									</a>
								</p>
							<?php endif; ?>

							<?php if ( ! empty( $s['contact_email'] ) ) : ?>
								<p class="flex items-center gap-2.5">
									<i data-lucide="<?php echo esc_attr( $s['contact_email_icon'] ?: 'mail' ); ?>" class="kb-footer-contact-icon w-4 h-4 text-gold-400 flex-shrink-0"></i>
									<a href="mailto:<?php echo esc_attr( $s['contact_email'] ); ?>" class="kb-footer-link text-stone-400 hover:text-gold-400 transition-colors">
										<?php echo esc_html( $s['contact_email'] ); ?>
									</a>
								</p>
							<?php endif; ?>

							<?php if ( ! empty( $s['contact_hours'] ) ) : ?>
								<p class="text-xs text-stone-500 pl-6.5">
									<?php echo esc_html( $s['contact_hours'] ); ?>
								</p>
							<?php endif; ?>
						</div>
					</div>

				</div>

				<!-- Bottom Row: Dynamic Copyright & Payment Badges -->
				<div class="pt-7 flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-stone-500">
					<p class="kb-footer-copyright">
						<?php echo wp_kses_post( $clean_copy ); ?>
					</p>

					<?php if ( 'yes' === ( $s['show_payment_badges'] ?? 'yes' ) && ! empty( $s['payment_badges'] ) ) : ?>
						<div class="flex flex-wrap items-center justify-center gap-2">
							<?php foreach ( $s['payment_badges'] as $badge ) :
								$name = ! empty( $badge['badge_name'] ) ? esc_html( $badge['badge_name'] ) : '';
								if ( ! $name ) continue;
								?>
								<span class="px-2.5 py-1 rounded border border-stone-800 text-[10px] font-bold text-stone-300">
									<?php echo $name; ?>
								</span>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</footer>
		<?php
	}
}

