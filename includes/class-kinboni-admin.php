<?php
/**
 * Admin Dashboard & Control Center
 *
 * Provides a luxury Haute Atelier admin dashboard for KINBONI Pro:
 *  - Overview & Real-time Metrics
 *  - Elementor Widget Manager (1-click active/inactive switches)
 *  - Storefront & Modals Settings (Quick View, COD Order, Sales Chimes, WhatsApp Concierge)
 *  - VIP Circle Newsletter & Promo Code Management (Subscriber table & CSV Export)
 *  - System Status & Cache Purge Diagnostics
 *
 * @package KinboniPro
 */

defined( 'ABSPATH' ) || exit;

class Kinboni_Admin {

	const SETTINGS_KEY = 'kinboni_pro_settings';
	const MENU_SLUG    = 'kinboni-pro';

	/**
	 * Initialize Admin module.
	 */
	public static function init(): void {
		add_action( 'admin_menu', [ __CLASS__, 'register_admin_menu' ] );
		add_action( 'admin_enqueue_scripts', [ __CLASS__, 'enqueue_admin_assets' ] );
		add_action( 'wp_ajax_kinboni_save_dashboard_settings', [ __CLASS__, 'ajax_save_settings' ] );
		add_action( 'wp_ajax_kinboni_purge_cache', [ __CLASS__, 'ajax_purge_cache' ] );
		add_action( 'wp_ajax_kinboni_delete_subscriber', [ __CLASS__, 'ajax_delete_subscriber' ] );
		add_action( 'wp_ajax_kinboni_clear_subscribers', [ __CLASS__, 'ajax_clear_subscribers' ] );
		add_action( 'admin_post_kinboni_export_subscribers', [ __CLASS__, 'export_subscribers_csv' ] );
	}

	/**
	 * Default plugin settings.
	 */
	public static function get_default_settings(): array {
		return [
			// Elementor Widgets (all 10 enabled by default)
			'widget_header'          => 'yes',
			'widget_hero'            => 'yes',
			'widget_featured'        => 'yes',
			'widget_categories'      => 'yes',
			'widget_bestsellers'     => 'yes',
			'widget_heritage'        => 'yes',
			'widget_promo_banner'    => 'yes',
			'widget_testimonials'    => 'yes',
			'widget_newsletter'      => 'yes',
			'widget_footer'          => 'yes',

			// Storefront Modals & Features
			'enable_quick_view'      => 'yes',
			'enable_quick_order'     => 'yes',
			'enable_sales_popup'     => 'yes',
			'sales_popup_interval'   => 15,
			'enable_sales_chime'     => 'no',
			'enable_wishlist'        => 'yes',
			'enable_whatsapp'        => 'no',
			'whatsapp_number'        => '+8801700000000',
			'whatsapp_message'       => 'Hello Kinboni Concierge, I would like to inquire about a creation.',

			// VIP Circle & Promo Code
			'vip_promo_code'         => 'LUXE20',
			'vip_discount_percent'   => 20,
		];
	}

	/**
	 * Retrieve saved settings merged with defaults.
	 */
	public static function get_settings(): array {
		$saved = get_option( self::SETTINGS_KEY, [] );
		if ( ! is_array( $saved ) ) {
			$saved = [];
		}
		return array_merge( self::get_default_settings(), $saved );
	}

	/**
	 * Register WordPress Admin Menu & Submenus.
	 */
	public static function register_admin_menu(): void {
		$icon_svg = 'data:image/svg+xml;base64,' . base64_encode(
			'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#c5a059"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>'
		);

		add_menu_page(
			__( 'KINBONI Pro Atelier Dashboard', 'kinboni-pro' ),
			__( 'KINBONI Pro', 'kinboni-pro' ),
			'manage_options',
			self::MENU_SLUG,
			[ __CLASS__, 'render_dashboard_page' ],
			$icon_svg,
			58
		);

		add_submenu_page(
			self::MENU_SLUG,
			__( 'Dashboard Overview', 'kinboni-pro' ),
			__( 'Overview', 'kinboni-pro' ),
			'manage_options',
			self::MENU_SLUG,
			[ __CLASS__, 'render_dashboard_page' ]
		);

		add_submenu_page(
			self::MENU_SLUG,
			__( 'Products & Inventory', 'kinboni-pro' ),
			__( 'Products & Atelier', 'kinboni-pro' ),
			'manage_options',
			self::MENU_SLUG . '#products',
			[ __CLASS__, 'render_dashboard_page' ]
		);

		add_submenu_page(
			self::MENU_SLUG,
			__( 'Elementor Widgets Suite', 'kinboni-pro' ),
			__( 'Elementor Widgets', 'kinboni-pro' ),
			'manage_options',
			self::MENU_SLUG . '#widgets',
			[ __CLASS__, 'render_dashboard_page' ]
		);

		add_submenu_page(
			self::MENU_SLUG,
			__( 'Storefront & Modals Settings', 'kinboni-pro' ),
			__( 'Storefront Settings', 'kinboni-pro' ),
			'manage_options',
			self::MENU_SLUG . '#storefront',
			[ __CLASS__, 'render_dashboard_page' ]
		);

		add_submenu_page(
			self::MENU_SLUG,
			__( 'VIP Circle Newsletter & Codes', 'kinboni-pro' ),
			__( 'VIP Subscribers', 'kinboni-pro' ),
			'manage_options',
			self::MENU_SLUG . '#subscribers',
			[ __CLASS__, 'render_dashboard_page' ]
		);

		add_submenu_page(
			self::MENU_SLUG,
			__( 'System Diagnostics & Cache', 'kinboni-pro' ),
			__( 'System Status', 'kinboni-pro' ),
			'manage_options',
			self::MENU_SLUG . '#system',
			[ __CLASS__, 'render_dashboard_page' ]
		);
	}

	/**
	 * Enqueue Admin Assets only on KINBONI admin screens.
	 */
	public static function enqueue_admin_assets( string $hook ): void {
		if ( false === strpos( $hook, self::MENU_SLUG ) ) {
			return;
		}

		// Enqueue Dashicons and WordPress Media Uploader
		wp_enqueue_style( 'dashicons' );
		wp_enqueue_media();

		// Enqueue Dedicated KINBONI Pro Backend Admin CSS
		wp_enqueue_style(
			'kinboni-admin-css',
			KINBONI_URL . 'assets/admin/css/admin.css',
			[ 'dashicons' ],
			KINBONI_VERSION
		);

		// Enqueue Dedicated KINBONI Pro Backend Admin JS
		wp_enqueue_script(
			'kinboni-admin-js',
			KINBONI_URL . 'assets/admin/js/admin.js',
			[ 'jquery' ],
			KINBONI_VERSION,
			true
		);

		// Pass localized parameters cleanly to admin.js
		wp_localize_script( 'kinboni-admin-js', 'kinboniAdmin', [
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'nonce'    => wp_create_nonce( 'kinboni_admin_nonce' ),
		] );
	}

	/**
	 * AJAX endpoint: Save Dashboard Settings.
	 */
	public static function ajax_save_settings(): void {
		check_ajax_referer( 'kinboni_admin_nonce', 'nonce' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( [ 'message' => __( 'Unauthorized access.', 'kinboni-pro' ) ], 403 );
		}

		$raw_data = $_POST['settings'] ?? [];
		if ( ! is_array( $raw_data ) ) {
			wp_send_json_error( [ 'message' => __( 'Invalid payload.', 'kinboni-pro' ) ], 400 );
		}

		$current = self::get_settings();

		// Sanitize Widget toggles
		$widget_keys = [
			'widget_header', 'widget_hero', 'widget_featured', 'widget_categories',
			'widget_bestsellers', 'widget_heritage', 'widget_promo_banner',
			'widget_testimonials', 'widget_newsletter', 'widget_footer'
		];
		foreach ( $widget_keys as $w ) {
			$current[ $w ] = ( isset( $raw_data[ $w ] ) && 'yes' === $raw_data[ $w ] ) ? 'yes' : 'no';
		}

		// Sanitize Storefront Settings
		$current['enable_quick_view']    = ( isset( $raw_data['enable_quick_view'] ) && 'yes' === $raw_data['enable_quick_view'] ) ? 'yes' : 'no';
		$current['enable_quick_order']   = ( isset( $raw_data['enable_quick_order'] ) && 'yes' === $raw_data['enable_quick_order'] ) ? 'yes' : 'no';
		$current['enable_sales_popup']   = ( isset( $raw_data['enable_sales_popup'] ) && 'yes' === $raw_data['enable_sales_popup'] ) ? 'yes' : 'no';
		$current['enable_sales_chime']   = ( isset( $raw_data['enable_sales_chime'] ) && 'yes' === $raw_data['enable_sales_chime'] ) ? 'yes' : 'no';
		$current['enable_wishlist']      = ( isset( $raw_data['enable_wishlist'] ) && 'yes' === $raw_data['enable_wishlist'] ) ? 'yes' : 'no';
		$current['enable_whatsapp']      = ( isset( $raw_data['enable_whatsapp'] ) && 'yes' === $raw_data['enable_whatsapp'] ) ? 'yes' : 'no';

		$current['sales_popup_interval'] = isset( $raw_data['sales_popup_interval'] ) ? max( 5, min( 120, absint( $raw_data['sales_popup_interval'] ) ) ) : 15;
		$current['whatsapp_number']      = isset( $raw_data['whatsapp_number'] ) ? sanitize_text_field( $raw_data['whatsapp_number'] ) : '+8801700000000';
		$current['whatsapp_message']     = isset( $raw_data['whatsapp_message'] ) ? sanitize_textarea_field( $raw_data['whatsapp_message'] ) : '';

		// VIP Settings
		$current['vip_promo_code']       = isset( $raw_data['vip_promo_code'] ) ? strtoupper( sanitize_text_field( $raw_data['vip_promo_code'] ) ) : 'LUXE20';
		$current['vip_discount_percent'] = isset( $raw_data['vip_discount_percent'] ) ? max( 1, min( 99, absint( $raw_data['vip_discount_percent'] ) ) ) : 20;

		update_option( self::SETTINGS_KEY, $current );

		wp_send_json_success( [
			'message'  => __( 'Atelier configuration updated successfully.', 'kinboni-pro' ),
			'settings' => $current,
		] );
	}

	/**
	 * AJAX endpoint: Purge Cache / Transients.
	 */
	public static function ajax_purge_cache(): void {
		check_ajax_referer( 'kinboni_admin_nonce', 'nonce' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( [ 'message' => __( 'Unauthorized access.', 'kinboni-pro' ) ], 403 );
		}

		// Clear Elementor CSS cache if present
		if ( class_exists( '\Elementor\Plugin' ) ) {
			\Elementor\Plugin::$instance->files_manager->clear_cache();
		}

		// Clear transients
		delete_transient( 'kinboni_cached_bestsellers' );
		delete_transient( 'kinboni_cached_featured' );

		wp_send_json_success( [ 'message' => __( 'KINBONI caches and Elementor assets successfully purged.', 'kinboni-pro' ) ] );
	}

	/**
	 * AJAX endpoint: Delete individual subscriber.
	 */
	public static function ajax_delete_subscriber(): void {
		check_ajax_referer( 'kinboni_admin_nonce', 'nonce' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( [ 'message' => __( 'Unauthorized.', 'kinboni-pro' ) ], 403 );
		}

		$email = sanitize_email( wp_unslash( $_POST['email'] ?? '' ) );
		if ( ! is_email( $email ) ) {
			wp_send_json_error( [ 'message' => __( 'Invalid email address.', 'kinboni-pro' ) ], 400 );
		}

		$subs = get_option( 'kinboni_newsletter_subscribers', [] );
		if ( is_array( $subs ) ) {
			$filtered = array_values( array_filter( $subs, function( $item ) use ( $email ) {
				return strtolower( $item['email'] ?? '' ) !== strtolower( $email );
			} ) );
			update_option( 'kinboni_newsletter_subscribers', $filtered, false );
		}

		wp_send_json_success( [ 'message' => __( 'Subscriber removed.', 'kinboni-pro' ) ] );
	}

	/**
	 * AJAX endpoint: Clear all subscribers.
	 */
	public static function ajax_clear_subscribers(): void {
		check_ajax_referer( 'kinboni_admin_nonce', 'nonce' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( [ 'message' => __( 'Unauthorized.', 'kinboni-pro' ) ], 403 );
		}

		update_option( 'kinboni_newsletter_subscribers', [], false );
		wp_send_json_success( [ 'message' => __( 'All subscribers cleared.', 'kinboni-pro' ) ] );
	}

	/**
	 * Export Subscribers as CSV.
	 */
	public static function export_subscribers_csv(): void {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Unauthorized access.', 'kinboni-pro' ) );
		}

		check_admin_referer( 'kinboni_export_csv', '_wpnonce' );

		$subs = get_option( 'kinboni_newsletter_subscribers', [] );
		if ( ! is_array( $subs ) ) {
			$subs = [];
		}

		$filename = 'kinboni-subscribers-' . gmdate( 'Y-m-d-His' ) . '.csv';

		header( 'Content-Type: text/csv; charset=utf-8' );
		header( 'Content-Disposition: attachment; filename=' . $filename );
		header( 'Pragma: no-cache' );
		header( 'Expires: 0' );

		$output = fopen( 'php://output', 'w' );
		fputcsv( $output, [ 'Email Address', 'Subscription Date', 'IP Address' ] );

		foreach ( $subs as $sub ) {
			fputcsv( $output, [
				$sub['email'] ?? '',
				$sub['subscribed'] ?? '',
				$sub['ip'] ?? '',
			] );
		}

		fclose( $output );
		exit;
	}

	/**
	 * Render the Full Luxury Dashboard Page.
	 */
	public static function render_dashboard_page(): void {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'kinboni-pro' ) );
		}

		$settings     = self::get_settings();
		$subscribers  = get_option( 'kinboni_newsletter_subscribers', [] );
		if ( ! is_array( $subscribers ) ) {
			$subscribers = [];
		}

		$total_subs   = count( $subscribers );
		$wc_active    = class_exists( 'WooCommerce' );
		$el_active    = class_exists( '\Elementor\Plugin' );

		// Count WooCommerce products
		$total_products = 0;
		if ( $wc_active ) {
			$count_posts = wp_count_posts( 'product' );
			$total_products = isset( $count_posts->publish ) ? (int) $count_posts->publish : 0;
		}

		// Retrieve categories & demo products
		$categories    = class_exists( 'Kinboni_Products' ) ? Kinboni_Products::get_categories_dropdown() : [];
		$demo_products = class_exists( 'Kinboni_Products' ) ? Kinboni_Products::DEMO_PRODUCTS : [];

		// Widget list
		$widgets = [
			'widget_header'       => [
				'title' => __( 'Site Header & Navigation', 'kinboni-pro' ),
				'desc'  => __( 'Luxury sticky header with monogram, responsive mobile menu, search, theme switcher, and slide-out drawers.', 'kinboni-pro' ),
				'icon'  => 'dashicons-menu-alt3',
			],
			'widget_hero'         => [
				'title' => __( 'Hero Editorial Mosaic', 'kinboni-pro' ),
				'desc'  => __( '3-product editorial mosaic gallery, trust ribbon, live WooCommerce picker, and headline CTAs.', 'kinboni-pro' ),
				'icon'  => 'dashicons-format-gallery',
			],
			'widget_featured'     => [
				'title' => __( 'Featured Creations Grid', 'kinboni-pro' ),
				'desc'  => __( '8-product featured showcase with instant 0ms quick view, wishlist, and cash-on-delivery order buttons.', 'kinboni-pro' ),
				'icon'  => 'dashicons-star-filled',
			],
			'widget_categories'   => [
				'title' => __( 'Curated Disciplines (Categories)', 'kinboni-pro' ),
				'desc'  => __( '6-column luxury category cards with smooth zoom hover and instant catalog filtering on click.', 'kinboni-pro' ),
				'icon'  => 'dashicons-grid-view',
			],
			'widget_bestsellers'  => [
				'title' => __( 'Best Sellers Showcase', 'kinboni-pro' ),
				'desc'  => __( 'Dynamic bestsellers catalog with 8 filter tabs (timepieces, leather, oud, jewelry, eyewear, silk, sale).', 'kinboni-pro' ),
				'icon'  => 'dashicons-tag',
			],
			'widget_heritage'     => [
				'title' => __( 'Heritage & Brand Story', 'kinboni-pro' ),
				'desc'  => __( 'Editorial brand storytelling section with floating Master Guild guarantee stamp and 3 craftsmanship pillars.', 'kinboni-pro' ),
				'icon'  => 'dashicons-book',
			],
			'widget_promo_banner' => [
				'title' => __( 'Promotional Privilege Banner', 'kinboni-pro' ),
				'desc'  => __( 'Private mid-season archive banner with click-to-copy promo code (LUXE20) and radial gold grid pattern.', 'kinboni-pro' ),
				'icon'  => 'dashicons-megaphone',
			],
			'widget_testimonials' => [
				'title' => __( 'Patron Acclaim (Testimonials)', 'kinboni-pro' ),
				'desc'  => __( 'Touch-enabled Swiper.js carousel with 5-star ratings, verified patron badges, and editorial quotes.', 'kinboni-pro' ),
				'icon'  => 'dashicons-testimonial',
			],
			'widget_newsletter'   => [
				'title' => __( 'VIP Circle Newsletter', 'kinboni-pro' ),
				'desc'  => __( 'Private VIP invitations subscription form with instant AJAX validation and privilege code delivery.', 'kinboni-pro' ),
				'icon'  => 'dashicons-email',
			],
			'widget_footer'       => [
				'title' => __( 'Haute Atelier Footer', 'kinboni-pro' ),
				'desc'  => __( '4-column footer with gold monogram, collection links, concierge care, showroom contacts, and payment badges.', 'kinboni-pro' ),
				'icon'  => 'dashicons-layout',
			],
		];

		$active_widgets = 0;
		foreach ( $widgets as $k => $w ) {
			if ( ( $settings[ $k ] ?? 'yes' ) === 'yes' ) {
				$active_widgets++;
			}
		}

		$nonce = wp_create_nonce( 'kinboni_admin_nonce' );
		?>

		<div class="wrap kinboni-admin-wrap">

			<!-- Top Brand Header Bar -->
			<div class="kb-admin-header">
				<div class="kb-brand-box">
					<div class="kb-monogram-badge">K</div>
					<div class="kb-brand-titles">
						<h1>KINBONI</h1>
						<p>HAUTE ATELIER &middot; PRO SUITE v2.0</p>
					</div>
				</div>
				<div class="kb-header-actions">
					<button type="button" id="kb-btn-purge-cache" class="kb-btn-secondary" title="<?php esc_attr_e( 'Regenerate assets and clear transients', 'kinboni-pro' ); ?>">
						<span class="dashicons dashicons-update" style="font-size: 15px; width: 15px; height: 15px;"></span>
						<span><?php esc_html_e( 'Purge Cache', 'kinboni-pro' ); ?></span>
					</button>
					<button type="button" id="kb-btn-save-all" class="kb-btn-save">
						<span class="dashicons dashicons-saved" style="font-size: 15px; width: 15px; height: 15px;"></span>
						<span><?php esc_html_e( 'Save Changes', 'kinboni-pro' ); ?></span>
					</button>
				</div>
			</div>

			<!-- Navigation Tabs -->
			<div class="kb-admin-tabs">
				<button type="button" class="kb-tab-btn active" data-tab="overview">
					<span class="dashicons dashicons-dashboard"></span>
					<span><?php esc_html_e( 'Overview', 'kinboni-pro' ); ?></span>
				</button>
				<button type="button" class="kb-tab-btn" data-tab="products">
					<span class="dashicons dashicons-archive"></span>
					<span><?php esc_html_e( 'Products & Inventory', 'kinboni-pro' ); ?> (<span id="kb-products-count-badge"><?php echo esc_html( $total_products ); ?></span>)</span>
				</button>
				<button type="button" class="kb-tab-btn" data-tab="widgets">
					<span class="dashicons dashicons-admin-generic"></span>
					<span><?php esc_html_e( 'Elementor Widgets', 'kinboni-pro' ); ?> (<?php echo esc_html( $active_widgets ); ?>/10)</span>
				</button>
				<button type="button" class="kb-tab-btn" data-tab="storefront">
					<span class="dashicons dashicons-cart"></span>
					<span><?php esc_html_e( 'Storefront & Modals', 'kinboni-pro' ); ?></span>
				</button>
				<button type="button" class="kb-tab-btn" data-tab="subscribers">
					<span class="dashicons dashicons-groups"></span>
					<span><?php esc_html_e( 'VIP Circle Subscribers', 'kinboni-pro' ); ?> (<?php echo esc_html( $total_subs ); ?>)</span>
				</button>
				<button type="button" class="kb-tab-btn" data-tab="system">
					<span class="dashicons dashicons-info"></span>
					<span><?php esc_html_e( 'System Status', 'kinboni-pro' ); ?></span>
				</button>
			</div>

			<!-- Main Settings Form Container -->
			<form id="kb-dashboard-form">

				<!-- ══════════════════════════════════════════════════
				     TAB 1: OVERVIEW
				     ══════════════════════════════════════════════════ -->
				<div id="tab-overview" class="kb-tab-pane active">
					
					<!-- 4 Key Stats Cards -->
					<div class="kb-stats-grid">
						<div class="kb-stat-card">
							<div class="kb-stat-icon"><span class="dashicons dashicons-admin-generic"></span></div>
							<div class="kb-stat-info">
								<h3><?php echo esc_html( $active_widgets ); ?>/10</h3>
								<p><?php esc_html_e( 'Active Widgets', 'kinboni-pro' ); ?></p>
							</div>
						</div>
						<div class="kb-stat-card">
							<div class="kb-stat-icon"><span class="dashicons dashicons-cart"></span></div>
							<div class="kb-stat-info">
								<h3><?php echo esc_html( $total_products ); ?></h3>
								<p><?php esc_html_e( 'WooCommerce Products', 'kinboni-pro' ); ?></p>
							</div>
						</div>
						<div class="kb-stat-card">
							<div class="kb-stat-icon"><span class="dashicons dashicons-email-alt"></span></div>
							<div class="kb-stat-info">
								<h3><?php echo esc_html( $total_subs ); ?></h3>
								<p><?php esc_html_e( 'VIP Subscribers', 'kinboni-pro' ); ?></p>
							</div>
						</div>
						<div class="kb-stat-card">
							<div class="kb-stat-icon"><span class="dashicons dashicons-yes-alt"></span></div>
							<div class="kb-stat-info">
								<h3 style="color: #10b981;">100%</h3>
								<p><?php esc_html_e( 'System Health', 'kinboni-pro' ); ?></p>
							</div>
						</div>
					</div>

					<!-- Hero Atelier Welcome Box -->
					<div class="kb-card-box" style="background: linear-gradient(135deg, #18171e, #111014); border-color: var(--kb-border-gold);">
						<div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: gap; gap: 20px;">
							<div>
								<span style="font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.25em; color: var(--kb-gold); display: block; margin-bottom: 6px;">
									Private Haute Horlogerie &amp; Leather Atelier Suite
								</span>
								<h2 style="font-family: Georgia, serif; font-size: 24px; color: #fff; margin: 0 0 10px 0;">
									<?php esc_html_e( 'Welcome to KINBONI Pro Control Center', 'kinboni-pro' ); ?>
								</h2>
								<p style="font-size: 13px; color: var(--kb-text-muted); max-width: 600px; line-height: 1.6; margin: 0;">
									<?php esc_html_e( 'All 10 bespoke Elementor widgets are configured to appear at the very top of your Elementor editor panel. You can toggle widgets, customize storefront modals, manage VIP promo codes, and inspect system performance from this master console.', 'kinboni-pro' ); ?>
								</p>
							</div>
							<div style="display: flex; flex-direction: column; gap: 10px;">
								<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=page' ) ); ?>" class="kb-btn-save" style="text-decoration: none; justify-content: center;">
									<span class="dashicons dashicons-edit"></span>
									<span><?php esc_html_e( 'Edit Pages in Elementor', 'kinboni-pro' ); ?></span>
								</a>
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" target="_blank" class="kb-btn-secondary" style="justify-content: center;">
									<span class="dashicons dashicons-visibility"></span>
									<span><?php esc_html_e( 'Visit Live Storefront', 'kinboni-pro' ); ?></span>
								</a>
							</div>
						</div>
					</div>

				</div>

				<!-- ══════════════════════════════════════════════════
				     TAB: PRODUCTS & INVENTORY
				     ══════════════════════════════════════════════════ -->
				<div id="tab-products" class="kb-tab-pane">
					<div class="kb-card-box">
						<div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; margin-bottom: 22px;">
							<div>
								<h2 class="kb-box-title"><?php esc_html_e( 'Products & Inventory Manager', 'kinboni-pro' ); ?></h2>
								<p class="kb-box-desc" style="margin: 0;"><?php esc_html_e( 'Manage luxury creations, pricing, inventory, gallery imagery, and specs. All records sync automatically with WooCommerce and Elementor widgets.', 'kinboni-pro' ); ?></p>
							</div>
							<div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
								<button type="button" id="kb-btn-open-demo-import" class="kb-btn-secondary" title="<?php esc_attr_e( '1-Click migration of 12 atelier creations with duplicate prevention', 'kinboni-pro' ); ?>">
									<span class="dashicons dashicons-download" style="color: var(--kb-gold);"></span>
									<span><?php esc_html_e( '1-Click Demo Import', 'kinboni-pro' ); ?></span>
								</button>
								<button type="button" id="kb-btn-open-categories" class="kb-btn-secondary">
									<span class="dashicons dashicons-category"></span>
									<span><?php esc_html_e( 'Categories', 'kinboni-pro' ); ?></span>
								</button>
								<button type="button" id="kb-btn-open-add-product" class="kb-btn-save">
									<span class="dashicons dashicons-plus-alt2"></span>
									<span><?php esc_html_e( 'Add New Product', 'kinboni-pro' ); ?></span>
								</button>
							</div>
						</div>

						<!-- Filter & Search Toolbar -->
						<div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; background: #111014; border: 1px solid var(--kb-border); padding: 14px 18px; border-radius: 12px;">
							<div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap; flex: 1;">
								<input type="text" id="kb-prod-search" class="kb-input" style="max-width: 280px; min-width: 220px;" placeholder="<?php esc_attr_e( 'Search by name or SKU...', 'kinboni-pro' ); ?>">
								
								<select id="kb-prod-cat-filter" class="kb-select" style="max-width: 200px;">
									<option value="all"><?php esc_html_e( 'All Categories', 'kinboni-pro' ); ?></option>
									<?php foreach ( $categories as $c ) : ?>
										<option value="<?php echo esc_attr( $c['slug'] ); ?>"><?php echo esc_html( $c['name'] ); ?> (<?php echo esc_html( $c['count'] ); ?>)</option>
									<?php endforeach; ?>
								</select>

								<select id="kb-prod-status-filter" class="kb-select" style="max-width: 150px;">
									<option value="any"><?php esc_html_e( 'All Status', 'kinboni-pro' ); ?></option>
									<option value="publish"><?php esc_html_e( 'Published', 'kinboni-pro' ); ?></option>
									<option value="draft"><?php esc_html_e( 'Draft', 'kinboni-pro' ); ?></option>
								</select>
							</div>

							<div style="color: var(--kb-text-muted); font-size: 12px;" id="kb-products-total-label">
								<?php printf( esc_html__( 'Total: %d products', 'kinboni-pro' ), $total_products ); ?>
							</div>
						</div>

						<!-- Products Table -->
						<div class="kb-table-wrap">
							<table class="kb-admin-table" id="kb-products-table">
								<thead>
									<tr>
										<th style="width: 50px;"><?php esc_html_e( 'Image', 'kinboni-pro' ); ?></th>
										<th><?php esc_html_e( 'Creation Name', 'kinboni-pro' ); ?></th>
										<th style="width: 120px;"><?php esc_html_e( 'SKU', 'kinboni-pro' ); ?></th>
										<th style="width: 140px;"><?php esc_html_e( 'Category', 'kinboni-pro' ); ?></th>
										<th style="width: 130px;"><?php esc_html_e( 'Price', 'kinboni-pro' ); ?></th>
										<th style="width: 110px;"><?php esc_html_e( 'Stock', 'kinboni-pro' ); ?></th>
										<th style="width: 90px;"><?php esc_html_e( 'Status', 'kinboni-pro' ); ?></th>
										<th style="width: 120px; text-align: right;"><?php esc_html_e( 'Actions', 'kinboni-pro' ); ?></th>
									</tr>
								</thead>
								<tbody id="kb-products-tbody">
									<tr>
										<td colspan="8" style="text-align: center; padding: 40px; color: var(--kb-text-muted);">
											<span class="dashicons dashicons-update spin" style="font-size: 20px; width: 20px; height: 20px;"></span>
											<span style="margin-left: 8px;"><?php esc_html_e( 'Loading atelier catalog...', 'kinboni-pro' ); ?></span>
										</td>
									</tr>
								</tbody>
							</table>
						</div>

						<!-- Pagination Bar -->
						<div style="display: flex; justify-content: space-between; align-items: center; margin-top: 18px; color: var(--kb-text-muted); font-size: 13px;">
							<div id="kb-prod-pagination-info"><?php esc_html_e( 'Showing products...', 'kinboni-pro' ); ?></div>
							<div style="display: flex; align-items: center; gap: 8px;">
								<button type="button" id="kb-pg-prev" class="kb-btn-secondary" disabled style="padding: 6px 12px; font-size: 11px;">
									&laquo; <?php esc_html_e( 'Previous', 'kinboni-pro' ); ?>
								</button>
								<span id="kb-pg-page-num" style="padding: 0 10px; font-weight: 600; color: #fff;">1 / 1</span>
								<button type="button" id="kb-pg-next" class="kb-btn-secondary" disabled style="padding: 6px 12px; font-size: 11px;">
									<?php esc_html_e( 'Next', 'kinboni-pro' ); ?> &raquo;
								</button>
							</div>
						</div>

					</div>
				</div>

				<!-- ══════════════════════════════════════════════════
				     TAB 2: ELEMENTOR WIDGETS
				     ══════════════════════════════════════════════════ -->
				<div id="tab-widgets" class="kb-tab-pane">
					<div class="kb-card-box">
						<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px;">
							<div>
								<h2 class="kb-box-title"><?php esc_html_e( 'Elementor Widget Manager', 'kinboni-pro' ); ?></h2>
								<p class="kb-box-desc" style="margin: 0;"><?php esc_html_e( 'Enable or disable any of the 10 atelier widgets. Disabled widgets will not load in the Elementor panel, keeping the editor lean and ultra-responsive.', 'kinboni-pro' ); ?></p>
							</div>
							<div style="display: flex; gap: 8px;">
								<button type="button" class="kb-btn-secondary" onclick="jQuery('.kb-widget-switch').prop('checked', true);"><?php esc_html_e( 'Enable All', 'kinboni-pro' ); ?></button>
								<button type="button" class="kb-btn-secondary" onclick="jQuery('.kb-widget-switch').prop('checked', false);"><?php esc_html_e( 'Disable All', 'kinboni-pro' ); ?></button>
							</div>
						</div>

						<div class="kb-widgets-grid">
							<?php foreach ( $widgets as $key => $data ) :
								$checked = ( ( $settings[ $key ] ?? 'yes' ) === 'yes' );
								?>
								<div class="kb-widget-item">
									<div class="kb-w-info">
										<div class="kb-w-icon">
											<span class="dashicons <?php echo esc_attr( $data['icon'] ); ?>"></span>
										</div>
										<div>
											<h4 class="kb-w-title"><?php echo esc_html( $data['title'] ); ?></h4>
											<p class="kb-w-desc"><?php echo esc_html( $data['desc'] ); ?></p>
										</div>
									</div>
									<label class="kb-switch">
										<input type="checkbox" class="kb-widget-switch" name="settings[<?php echo esc_attr( $key ); ?>]" value="yes" <?php checked( $checked, true ); ?>>
										<span class="kb-slider"></span>
									</label>
								</div>
							<?php endforeach; ?>
						</div>

					</div>
				</div>

				<!-- ══════════════════════════════════════════════════
				     TAB 3: STOREFRONT & MODALS
				     ══════════════════════════════════════════════════ -->
				<div id="tab-storefront" class="kb-tab-pane">
					<div class="kb-card-box">
						<h2 class="kb-box-title"><?php esc_html_e( 'Storefront Modals & Interactive Systems', 'kinboni-pro' ); ?></h2>
						<p class="kb-box-desc"><?php esc_html_e( 'Configure the global drawers, high-conversion modals, and patron concierge tools.', 'kinboni-pro' ); ?></p>

						<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 16px; margin-bottom: 24px;">
							
							<!-- Quick View -->
							<div class="kb-widget-item">
								<div>
									<h4 class="kb-w-title"><?php esc_html_e( 'Zero-Latency Quick View Modal', 'kinboni-pro' ); ?></h4>
									<p class="kb-w-desc"><?php esc_html_e( 'Allows patrons to inspect high-resolution gallery images, pricing, and specs without reloading the page.', 'kinboni-pro' ); ?></p>
								</div>
								<label class="kb-switch">
									<input type="checkbox" name="settings[enable_quick_view]" value="yes" <?php checked( ( $settings['enable_quick_view'] ?? 'yes' ) === 'yes' ); ?>>
									<span class="kb-slider"></span>
								</label>
							</div>

							<!-- COD Quick Order -->
							<div class="kb-widget-item">
								<div>
									<h4 class="kb-w-title"><?php esc_html_e( 'Direct Cash-on-Delivery (COD) Order Modal', 'kinboni-pro' ); ?></h4>
									<p class="kb-w-desc"><?php esc_html_e( 'Fast 3-field direct order checkout modal for Bangladesh cash on delivery purchases.', 'kinboni-pro' ); ?></p>
								</div>
								<label class="kb-switch">
									<input type="checkbox" name="settings[enable_quick_order]" value="yes" <?php checked( ( $settings['enable_quick_order'] ?? 'yes' ) === 'yes' ); ?>>
									<span class="kb-slider"></span>
								</label>
							</div>

							<!-- Live Sales Notification -->
							<div class="kb-widget-item">
								<div>
									<h4 class="kb-w-title"><?php esc_html_e( 'Live Recent Sales Social Proof', 'kinboni-pro' ); ?></h4>
									<p class="kb-w-desc"><?php esc_html_e( 'Displays subtle luxury purchase notifications across Gulshan, Banani, and Dhanmondi.', 'kinboni-pro' ); ?></p>
								</div>
								<label class="kb-switch">
									<input type="checkbox" name="settings[enable_sales_popup]" value="yes" <?php checked( ( $settings['enable_sales_popup'] ?? 'yes' ) === 'yes' ); ?>>
									<span class="kb-slider"></span>
								</label>
							</div>

							<!-- Wishlist Drawer -->
							<div class="kb-widget-item">
								<div>
									<h4 class="kb-w-title"><?php esc_html_e( 'Client Wishlist System', 'kinboni-pro' ); ?></h4>
									<p class="kb-w-desc"><?php esc_html_e( 'Local storage persistent wishlist with heart counter in the header.', 'kinboni-pro' ); ?></p>
								</div>
								<label class="kb-switch">
									<input type="checkbox" name="settings[enable_wishlist]" value="yes" <?php checked( ( $settings['enable_wishlist'] ?? 'yes' ) === 'yes' ); ?>>
									<span class="kb-slider"></span>
								</label>
							</div>

							<!-- WhatsApp Floating Button -->
							<div class="kb-widget-item">
								<div>
									<h4 class="kb-w-title"><?php esc_html_e( 'Floating Concierge WhatsApp Button', 'kinboni-pro' ); ?></h4>
									<p class="kb-w-desc"><?php esc_html_e( 'Adds a floating luxury WhatsApp button for direct client assistance.', 'kinboni-pro' ); ?></p>
								</div>
								<label class="kb-switch">
									<input type="checkbox" name="settings[enable_whatsapp]" value="yes" <?php checked( ( $settings['enable_whatsapp'] ?? 'no' ) === 'yes' ); ?>>
									<span class="kb-slider"></span>
								</label>
							</div>

						</div>

						<h3 style="font-size: 15px; color: #fff; margin: 20px 0 12px 0;"><?php esc_html_e( 'Concierge & Notification Settings', 'kinboni-pro' ); ?></h3>

						<div class="kb-form-row">
							<label><?php esc_html_e( 'Sales Notification Interval (Seconds)', 'kinboni-pro' ); ?></label>
							<input type="number" class="kb-input" name="settings[sales_popup_interval]" value="<?php echo esc_attr( $settings['sales_popup_interval'] ?? 15 ); ?>" min="5" max="120">
						</div>

						<div class="kb-form-row">
							<label><?php esc_html_e( 'Concierge WhatsApp Number (with country code)', 'kinboni-pro' ); ?></label>
							<input type="text" class="kb-input" name="settings[whatsapp_number]" value="<?php echo esc_attr( $settings['whatsapp_number'] ?? '+8801700000000' ); ?>" placeholder="+8801700000000">
						</div>

						<div class="kb-form-row">
							<label><?php esc_html_e( 'Default WhatsApp Inquiring Message', 'kinboni-pro' ); ?></label>
							<textarea class="kb-textarea" rows="2" name="settings[whatsapp_message]"><?php echo esc_textarea( $settings['whatsapp_message'] ?? 'Hello Kinboni Concierge, I would like to inquire about a creation.' ); ?></textarea>
						</div>

					</div>
				</div>

				<!-- ══════════════════════════════════════════════════
				     TAB 4: VIP CIRCLE SUBSCRIBERS
				     ══════════════════════════════════════════════════ -->
				<div id="tab-subscribers" class="kb-tab-pane">
					<div class="kb-card-box">
						<div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px; margin-bottom: 20px;">
							<div>
								<h2 class="kb-box-title"><?php esc_html_e( 'VIP Circle Subscribers & Invitations', 'kinboni-pro' ); ?></h2>
								<p class="kb-box-desc" style="margin: 0;"><?php esc_html_e( 'Manage patrons who subscribed to confidential archive sale invitations and private releases.', 'kinboni-pro' ); ?></p>
							</div>
							<div style="display: flex; gap: 10px;">
								<?php $export_url = wp_nonce_url( admin_url( 'admin-post.php?action=kinboni_export_subscribers' ), 'kinboni_export_csv' ); ?>
								<a href="<?php echo esc_url( $export_url ); ?>" class="kb-btn-save" style="text-decoration: none;">
									<span class="dashicons dashicons-download"></span>
									<span><?php esc_html_e( 'Export CSV', 'kinboni-pro' ); ?></span>
								</a>
								<?php if ( ! empty( $subscribers ) ) : ?>
									<button type="button" id="kb-btn-clear-subs" class="kb-btn-secondary" style="color: #ef4444;">
										<span class="dashicons dashicons-trash"></span>
										<span><?php esc_html_e( 'Clear All', 'kinboni-pro' ); ?></span>
									</button>
								<?php endif; ?>
							</div>
						</div>

						<div style="display: flex; gap: 20px; flex-wrap: wrap; margin-bottom: 24px;">
							<div class="kb-form-row">
								<label><?php esc_html_e( 'Default Privilege Coupon Code', 'kinboni-pro' ); ?></label>
								<input type="text" class="kb-input" name="settings[vip_promo_code]" value="<?php echo esc_attr( $settings['vip_promo_code'] ?? 'LUXE20' ); ?>" style="font-family: monospace; font-weight: 700; letter-spacing: 0.1em; color: var(--kb-gold) !important;">
							</div>
							<div class="kb-form-row">
								<label><?php esc_html_e( 'Discount Percentage (%)', 'kinboni-pro' ); ?></label>
								<input type="number" class="kb-input" name="settings[vip_discount_percent]" value="<?php echo esc_attr( $settings['vip_discount_percent'] ?? 20 ); ?>" min="1" max="99" style="max-width: 150px;">
							</div>
						</div>

						<!-- Subscribers Table -->
						<div class="kb-table-wrap">
							<table class="kb-admin-table">
								<thead>
									<tr>
										<th>#</th>
										<th><?php esc_html_e( 'Patron Email', 'kinboni-pro' ); ?></th>
										<th><?php esc_html_e( 'Subscribed On', 'kinboni-pro' ); ?></th>
										<th><?php esc_html_e( 'IP Address', 'kinboni-pro' ); ?></th>
										<th><?php esc_html_e( 'Actions', 'kinboni-pro' ); ?></th>
									</tr>
								</thead>
								<tbody>
									<?php if ( empty( $subscribers ) ) : ?>
										<tr>
											<td colspan="5" style="text-align: center; padding: 30px; color: var(--kb-text-muted);">
												<?php esc_html_e( 'No subscribers recorded yet. Form submissions from the VIP Newsletter widget will appear here automatically.', 'kinboni-pro' ); ?>
											</td>
										</tr>
									<?php else : ?>
										<?php foreach ( array_reverse( $subscribers ) as $index => $sub ) :
											$email = $sub['email'] ?? '';
											$date  = $sub['subscribed'] ?? '';
											$ip    = $sub['ip'] ?? '';
											?>
											<tr id="sub-row-<?php echo esc_attr( md5( $email ) ); ?>">
												<td><?php echo esc_html( $index + 1 ); ?></td>
												<td><strong style="color: #fff;"><?php echo esc_html( $email ); ?></strong></td>
												<td><?php echo esc_html( $date ); ?></td>
												<td><code><?php echo esc_html( $ip ); ?></code></td>
												<td>
													<button type="button" class="kb-btn-delete-sub" data-email="<?php echo esc_attr( $email ); ?>" style="background: transparent; border: none; color: #ef4444; cursor: pointer;" title="Remove subscriber">
														<span class="dashicons dashicons-no-alt"></span>
													</button>
												</td>
											</tr>
										<?php endforeach; ?>
									<?php endif; ?>
								</tbody>
							</table>
						</div>

					</div>
				</div>

				<!-- ══════════════════════════════════════════════════
				     TAB 5: SYSTEM DIAGNOSTICS
				     ══════════════════════════════════════════════════ -->
				<div id="tab-system" class="kb-tab-pane">
					<div class="kb-card-box">
						<h2 class="kb-box-title"><?php esc_html_e( 'System Status & Environment Diagnostics', 'kinboni-pro' ); ?></h2>
						<p class="kb-box-desc"><?php esc_html_e( 'Diagnostic parameters for server capability, WooCommerce HPOS integration, and asset management.', 'kinboni-pro' ); ?></p>

						<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px;">
							<div class="kb-widget-item">
								<div>
									<h4 class="kb-w-title"><?php esc_html_e( 'PHP Version', 'kinboni-pro' ); ?></h4>
									<p class="kb-w-desc"><?php echo esc_html( phpversion() ); ?> (Required: 7.4+)</p>
								</div>
								<span style="color: #10b981; font-weight: 700;">OK</span>
							</div>

							<div class="kb-widget-item">
								<div>
									<h4 class="kb-w-title"><?php esc_html_e( 'WordPress Core', 'kinboni-pro' ); ?></h4>
									<p class="kb-w-desc">v<?php echo esc_html( get_bloginfo( 'version' ) ); ?></p>
								</div>
								<span style="color: #10b981; font-weight: 700;">OK</span>
							</div>

							<div class="kb-widget-item">
								<div>
									<h4 class="kb-w-title"><?php esc_html_e( 'WooCommerce Storefront', 'kinboni-pro' ); ?></h4>
									<p class="kb-w-desc"><?php echo $wc_active ? 'Active (HPOS Ready)' : 'Not Active'; ?></p>
								</div>
								<span style="color: <?php echo $wc_active ? '#10b981' : '#f59e0b'; ?>; font-weight: 700;">
									<?php echo $wc_active ? 'Active' : 'Optional'; ?>
								</span>
							</div>

							<div class="kb-widget-item">
								<div>
									<h4 class="kb-w-title"><?php esc_html_e( 'Elementor Page Builder', 'kinboni-pro' ); ?></h4>
									<p class="kb-w-desc"><?php echo $el_active ? 'v' . esc_html( ELEMENTOR_VERSION ) . ' (Active)' : 'Not Active'; ?></p>
								</div>
								<span style="color: <?php echo $el_active ? '#10b981' : '#ef4444'; ?>; font-weight: 700;">
									<?php echo $el_active ? 'Connected' : 'Missing'; ?>
								</span>
							</div>

							<div class="kb-widget-item">
								<div>
									<h4 class="kb-w-title"><?php esc_html_e( 'PHP Memory Limit', 'kinboni-pro' ); ?></h4>
									<p class="kb-w-desc"><?php echo esc_html( ini_get( 'memory_limit' ) ); ?></p>
								</div>
								<span style="color: #10b981; font-weight: 700;">OK</span>
							</div>

							<div class="kb-widget-item">
								<div>
									<h4 class="kb-w-title"><?php esc_html_e( 'Max Execution Time', 'kinboni-pro' ); ?></h4>
									<p class="kb-w-desc"><?php echo esc_html( ini_get( 'max_execution_time' ) ); ?>s</p>
								</div>
								<span style="color: #10b981; font-weight: 700;">OK</span>
							</div>
						</div>

					</div>
				</div>

			</form>

			<!-- ══════════════════════════════════════════════════
			     MODAL 1: ADD / EDIT PRODUCT
			     ══════════════════════════════════════════════════ -->
			<div id="kb-product-modal" class="kb-modal-backdrop">
				<div class="kb-modal-dialog">
					<div class="kb-modal-header">
						<div style="display: flex; align-items: center; gap: 10px;">
							<span class="dashicons dashicons-archive" style="color: var(--kb-gold); font-size: 22px; width: 22px; height: 22px;"></span>
							<h2 id="kb-modal-product-title" class="kb-box-title" style="margin: 0;"><?php esc_html_e( 'Create New Atelier Creation', 'kinboni-pro' ); ?></h2>
						</div>
						<button type="button" class="kb-modal-close" id="kb-btn-close-product-modal">&times;</button>
					</div>

					<form id="kb-product-edit-form" style="display: flex; flex-direction: column; flex: 1; min-height: 0;">
						<input type="hidden" id="kb-p-id" name="id" value="0">
						<input type="hidden" id="kb-p-image-id" name="image_id" value="">
						<input type="hidden" id="kb-p-hover-image-id" name="hover_image_id" value="">

						<div class="kb-modal-body">
							<div class="kb-modal-grid">

								<!-- Left Column: Primary Details -->
								<div style="display: flex; flex-direction: column; gap: 16px;">
									
									<div class="kb-form-row">
										<label><?php esc_html_e( 'Product Title', 'kinboni-pro' ); ?> <span style="color: #ef4444;">*</span></label>
										<input type="text" id="kb-p-name" class="kb-input" style="max-width: 100%;" placeholder="<?php esc_attr_e( 'e.g. Chronos Royale Automatic', 'kinboni-pro' ); ?>" required>
									</div>

									<div class="kb-form-row">
										<label><?php esc_html_e( 'Permalink Slug', 'kinboni-pro' ); ?></label>
										<input type="text" id="kb-p-slug" class="kb-input" style="max-width: 100%; font-family: monospace;" placeholder="<?php esc_attr_e( 'leave empty to generate from title', 'kinboni-pro' ); ?>">
									</div>

									<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
										<div class="kb-form-row">
											<label><?php esc_html_e( 'Regular Price (৳)', 'kinboni-pro' ); ?> <span style="color: #ef4444;">*</span></label>
											<input type="number" step="any" id="kb-p-regular-price" class="kb-input" style="max-width: 100%; font-weight: 700;" placeholder="22000" required>
										</div>
										<div class="kb-form-row">
											<label><?php esc_html_e( 'Sale Price (৳)', 'kinboni-pro' ); ?></label>
											<input type="number" step="any" id="kb-p-sale-price" class="kb-input" style="max-width: 100%; color: var(--kb-gold) !important; font-weight: 700;" placeholder="18500 (optional)">
										</div>
									</div>

									<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
										<div class="kb-form-row">
											<label><?php esc_html_e( 'SKU Code', 'kinboni-pro' ); ?></label>
											<input type="text" id="kb-p-sku" class="kb-input" style="max-width: 100%; font-family: monospace;" placeholder="KB-ART-01">
										</div>
										<div class="kb-form-row">
											<label><?php esc_html_e( 'Atelier Ribbon Badge', 'kinboni-pro' ); ?></label>
											<select id="kb-p-badge" class="kb-select" style="max-width: 100%;">
												<option value=""><?php esc_html_e( 'None', 'kinboni-pro' ); ?></option>
												<option value="BESTSELLER">BESTSELLER</option>
												<option value="NEW">NEW</option>
												<option value="LIMITED">LIMITED</option>
												<option value="ARTISANAL">ARTISANAL</option>
												<option value="SIGNATURE">SIGNATURE</option>
											</select>
										</div>
									</div>

									<!-- Short Description -->
									<div class="kb-form-row">
										<label><?php esc_html_e( 'Short Description (Quick View & Highlight)', 'kinboni-pro' ); ?></label>
										<textarea id="kb-p-short-desc" class="kb-textarea" style="max-width: 100%;" rows="2" placeholder="<?php esc_attr_e( 'Brief atelier summary for product cards and quick view modal...', 'kinboni-pro' ); ?>"></textarea>
									</div>

									<!-- Full Description -->
									<div class="kb-form-row">
										<label><?php esc_html_e( 'Full Editorial Narrative', 'kinboni-pro' ); ?></label>
										<textarea id="kb-p-desc" class="kb-textarea" style="max-width: 100%;" rows="4" placeholder="<?php esc_attr_e( 'Detailed craftsmanship narrative, material provenance, and specifications...', 'kinboni-pro' ); ?>"></textarea>
									</div>

									<!-- Specs Repeater -->
									<div class="kb-form-row">
										<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
											<label style="margin: 0;"><?php esc_html_e( 'Technical Specifications', 'kinboni-pro' ); ?></label>
											<button type="button" id="kb-btn-add-spec" class="kb-btn-secondary" style="padding: 3px 10px; font-size: 11px;">
												<span class="dashicons dashicons-plus-alt" style="font-size: 12px; width: 12px; height: 12px;"></span>
												<span><?php esc_html_e( 'Add Spec', 'kinboni-pro' ); ?></span>
											</button>
										</div>
										<div id="kb-specs-container" style="display: flex; flex-direction: column; gap: 8px;">
											<!-- Dynamically populated spec items -->
										</div>
									</div>

								</div>

								<!-- Right Column: Media, Categories, Inventory & Status -->
								<div style="display: flex; flex-direction: column;">
									
									<!-- Catalog Status -->
									<div class="kb-box-inner">
										<h4 class="kb-inner-title"><?php esc_html_e( 'Catalog Status & Visibility', 'kinboni-pro' ); ?></h4>
										<div style="display: flex; gap: 16px; margin-bottom: 12px;">
											<label style="display: flex; align-items: center; gap: 6px; cursor: pointer; font-size: 13px; color: #fff;">
												<input type="radio" name="p_status" value="publish" checked> <?php esc_html_e( 'Published', 'kinboni-pro' ); ?>
											</label>
											<label style="display: flex; align-items: center; gap: 6px; cursor: pointer; font-size: 13px; color: #fff;">
												<input type="radio" name="p_status" value="draft"> <?php esc_html_e( 'Draft', 'kinboni-pro' ); ?>
											</label>
										</div>
										<label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 12px; color: var(--kb-text-muted);">
											<input type="checkbox" id="kb-p-featured" value="yes">
											<span><?php esc_html_e( 'Featured Atelier Creation (Showcase in grids)', 'kinboni-pro' ); ?></span>
										</label>
									</div>

									<!-- Product Images -->
									<div class="kb-box-inner">
										<h4 class="kb-inner-title"><?php esc_html_e( 'Product Imagery', 'kinboni-pro' ); ?></h4>
										
										<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 14px;">
											<!-- Primary Image -->
											<div>
												<span style="font-size: 11px; text-transform: uppercase; color: var(--kb-text-muted); display: block; margin-bottom: 6px;"><?php esc_html_e( 'Primary Image', 'kinboni-pro' ); ?></span>
												<div id="kb-primary-img-box" class="kb-media-box">
													<div id="kb-primary-preview" class="kb-preview-wrap">
														<span class="dashicons dashicons-camera" style="font-size: 24px; width: 24px; height: 24px; color: var(--kb-gold);"></span>
														<span style="font-size: 10px; margin-top: 4px;"><?php esc_html_e( 'Select Image', 'kinboni-pro' ); ?></span>
													</div>
												</div>
												<button type="button" id="kb-primary-remove-btn" class="kb-btn-text-danger" style="display: none; margin-top: 4px;"><?php esc_html_e( 'Remove', 'kinboni-pro' ); ?></button>
											</div>

											<!-- Secondary / Hover Image -->
											<div>
												<span style="font-size: 11px; text-transform: uppercase; color: var(--kb-text-muted); display: block; margin-bottom: 6px;"><?php esc_html_e( 'Hover Image', 'kinboni-pro' ); ?></span>
												<div id="kb-hover-img-box" class="kb-media-box">
													<div id="kb-hover-preview" class="kb-preview-wrap">
														<span class="dashicons dashicons-images-alt" style="font-size: 24px; width: 24px; height: 24px; color: var(--kb-text-muted);"></span>
														<span style="font-size: 10px; margin-top: 4px;"><?php esc_html_e( 'Select Image', 'kinboni-pro' ); ?></span>
													</div>
												</div>
												<button type="button" id="kb-hover-remove-btn" class="kb-btn-text-danger" style="display: none; margin-top: 4px;"><?php esc_html_e( 'Remove', 'kinboni-pro' ); ?></button>
											</div>
										</div>

										<!-- Gallery Multi-Images -->
										<div>
											<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
												<span style="font-size: 11px; text-transform: uppercase; color: var(--kb-text-muted);"><?php esc_html_e( 'Additional Gallery', 'kinboni-pro' ); ?></span>
												<button type="button" id="kb-btn-add-gallery" class="kb-btn-secondary" style="padding: 2px 8px; font-size: 10px;">
													+ <?php esc_html_e( 'Add Images', 'kinboni-pro' ); ?>
												</button>
											</div>
											<div id="kb-gallery-container" style="display: flex; flex-wrap: wrap; gap: 8px; min-height: 52px; background: rgba(0,0,0,0.25); padding: 8px; border-radius: 8px; border: 1px dashed var(--kb-border);">
												<span id="kb-gallery-empty-tip" style="font-size: 11px; color: var(--kb-text-muted); margin: auto;"><?php esc_html_e( 'No gallery images attached', 'kinboni-pro' ); ?></span>
											</div>
										</div>

									</div>

									<!-- Categories -->
									<div class="kb-box-inner">
										<h4 class="kb-inner-title"><?php esc_html_e( 'Disciplines & Categories', 'kinboni-pro' ); ?></h4>
										<div id="kb-modal-cats-list" style="display: flex; flex-direction: column; gap: 8px; max-height: 140px; overflow-y: auto; padding-right: 4px;">
											<?php foreach ( $categories as $cat ) : ?>
												<label style="display: flex; align-items: center; gap: 8px; font-size: 12px; cursor: pointer; color: #fff;">
													<input type="checkbox" class="kb-modal-cat-checkbox" value="<?php echo esc_attr( $cat['id'] ); ?>">
													<span><?php echo esc_html( $cat['name'] ); ?></span>
												</label>
											<?php endforeach; ?>
										</div>
									</div>

									<!-- Inventory Control -->
									<div class="kb-box-inner" style="margin-bottom: 0;">
										<h4 class="kb-inner-title"><?php esc_html_e( 'Inventory Management', 'kinboni-pro' ); ?></h4>
										<div style="margin-bottom: 10px;">
											<label style="display: flex; align-items: center; gap: 8px; font-size: 12px; cursor: pointer; color: #fff;">
												<input type="checkbox" id="kb-p-manage-stock" value="yes">
												<span><?php esc_html_e( 'Track stock quantity for this creation', 'kinboni-pro' ); ?></span>
											</label>
										</div>
										<div id="kb-stock-qty-box" style="display: none; margin-bottom: 10px;">
											<label style="font-size: 11px; text-transform: uppercase; color: var(--kb-text-muted); display: block; margin-bottom: 4px;"><?php esc_html_e( 'Stock Quantity', 'kinboni-pro' ); ?></label>
											<input type="number" id="kb-p-stock-qty" class="kb-input" style="max-width: 100%;" min="0" placeholder="15">
										</div>
										<div>
											<label style="font-size: 11px; text-transform: uppercase; color: var(--kb-text-muted); display: block; margin-bottom: 4px;"><?php esc_html_e( 'Stock Status', 'kinboni-pro' ); ?></label>
											<select id="kb-p-stock-status" class="kb-select" style="max-width: 100%;">
												<option value="instock"><?php esc_html_e( 'In Stock', 'kinboni-pro' ); ?></option>
												<option value="outofstock"><?php esc_html_e( 'Out of Stock', 'kinboni-pro' ); ?></option>
												<option value="onbackorder"><?php esc_html_e( 'On Backorder', 'kinboni-pro' ); ?></option>
											</select>
										</div>
									</div>

								</div>

							</div>
						</div>

						<div class="kb-modal-footer">
							<button type="button" class="kb-btn-secondary" id="kb-btn-cancel-product-modal"><?php esc_html_e( 'Cancel', 'kinboni-pro' ); ?></button>
							<button type="submit" id="kb-btn-save-product-submit" class="kb-btn-save">
								<span class="dashicons dashicons-saved"></span>
								<span><?php esc_html_e( 'Save Creation & Sync', 'kinboni-pro' ); ?></span>
							</button>
						</div>
					</form>
				</div>
			</div>

			<!-- ══════════════════════════════════════════════════
			     MODAL 2: MANAGE CATEGORIES
			     ══════════════════════════════════════════════════ -->
			<div id="kb-cats-modal" class="kb-modal-backdrop">
				<div class="kb-modal-dialog" style="max-width: 650px;">
					<div class="kb-modal-header">
						<div style="display: flex; align-items: center; gap: 10px;">
							<span class="dashicons dashicons-category" style="color: var(--kb-gold); font-size: 22px; width: 22px; height: 22px;"></span>
							<h2 class="kb-box-title" style="margin: 0;"><?php esc_html_e( 'Manage Disciplines & Categories', 'kinboni-pro' ); ?></h2>
						</div>
						<button type="button" class="kb-modal-close" id="kb-btn-close-cats-modal">&times;</button>
					</div>

					<div class="kb-modal-body">
						<!-- Create Category Form -->
						<form id="kb-category-form" style="display: flex; flex-direction: column; gap: 12px; margin-bottom: 22px; padding-bottom: 18px; border-bottom: 1px solid var(--kb-border);">
							<input type="hidden" id="kb-cat-id" value="0">
							<input type="hidden" id="kb-cat-thumb-id" value="0">

							<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
								<div class="kb-form-row" style="margin: 0;">
									<label><?php esc_html_e( 'Category Name', 'kinboni-pro' ); ?> *</label>
									<input type="text" id="kb-cat-name" class="kb-input" style="max-width: 100%;" placeholder="<?php esc_attr_e( 'e.g. Fine Jewelry', 'kinboni-pro' ); ?>" required>
								</div>
								<div class="kb-form-row" style="margin: 0;">
									<label><?php esc_html_e( 'Slug (URL key)', 'kinboni-pro' ); ?></label>
									<input type="text" id="kb-cat-slug" class="kb-input" style="max-width: 100%;" placeholder="<?php esc_attr_e( 'e.g. fine-jewelry', 'kinboni-pro' ); ?>">
								</div>
							</div>

							<div class="kb-form-row" style="margin: 0;">
								<label><?php esc_html_e( 'Description', 'kinboni-pro' ); ?></label>
								<textarea id="kb-cat-desc" class="kb-textarea" style="max-width: 100%;" rows="2" placeholder="<?php esc_attr_e( 'Brief description for category card...', 'kinboni-pro' ); ?>"></textarea>
							</div>

							<div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
								<div style="display: flex; align-items: center; gap: 8px;">
									<button type="button" id="kb-btn-pick-cat-thumb" class="kb-btn-secondary" style="padding: 6px 12px; font-size: 11px;">
										<span class="dashicons dashicons-format-image"></span>
										<span><?php esc_html_e( 'Select Thumbnail', 'kinboni-pro' ); ?></span>
									</button>
									<span id="kb-cat-thumb-label" style="font-size: 11px; color: var(--kb-text-muted);"><?php esc_html_e( 'No image', 'kinboni-pro' ); ?></span>
								</div>
								<button type="submit" id="kb-btn-save-cat" class="kb-btn-save" style="padding: 8px 18px; font-size: 11px;">
									<span class="dashicons dashicons-plus-alt"></span>
									<span><?php esc_html_e( 'Save Category', 'kinboni-pro' ); ?></span>
								</button>
							</div>
						</form>

						<!-- Categories List Table -->
						<h3 style="font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: var(--kb-gold); margin: 0 0 10px 0;">
							<?php esc_html_e( 'Current Categories', 'kinboni-pro' ); ?>
						</h3>
						<div class="kb-table-wrap">
							<table class="kb-admin-table" id="kb-cats-table">
								<thead>
									<tr>
										<th><?php esc_html_e( 'Category Name', 'kinboni-pro' ); ?></th>
										<th><?php esc_html_e( 'Slug', 'kinboni-pro' ); ?></th>
										<th style="width: 70px; text-align: center;"><?php esc_html_e( 'Count', 'kinboni-pro' ); ?></th>
										<th style="width: 70px; text-align: right;"><?php esc_html_e( 'Action', 'kinboni-pro' ); ?></th>
									</tr>
								</thead>
								<tbody id="kb-cats-tbody">
									<?php foreach ( $categories as $cat ) : ?>
										<tr id="kb-cat-row-<?php echo esc_attr( $cat['id'] ); ?>">
											<td><strong style="color: #fff;"><?php echo esc_html( $cat['name'] ); ?></strong></td>
											<td><code><?php echo esc_html( $cat['slug'] ); ?></code></td>
											<td style="text-align: center;"><span class="kb-badge-pill kb-badge-muted"><?php echo esc_html( $cat['count'] ); ?></span></td>
											<td style="text-align: right;">
												<button type="button" class="kb-btn-delete-cat" data-id="<?php echo esc_attr( $cat['id'] ); ?>" data-name="<?php echo esc_attr( $cat['name'] ); ?>" style="background: transparent; border: none; color: #ef4444; cursor: pointer;">
													<span class="dashicons dashicons-trash"></span>
												</button>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>

					<div class="kb-modal-footer">
						<button type="button" class="kb-btn-secondary" id="kb-btn-close-cats-modal-footer"><?php esc_html_e( 'Close', 'kinboni-pro' ); ?></button>
					</div>
				</div>
			</div>

			<!-- ══════════════════════════════════════════════════
			     MODAL 3: 1-CLICK DEMO PRODUCTS IMPORT
			     ══════════════════════════════════════════════════ -->
			<div id="kb-import-modal" class="kb-modal-backdrop">
				<div class="kb-modal-dialog" style="max-width: 680px;">
					<div class="kb-modal-header">
						<div style="display: flex; align-items: center; gap: 10px;">
							<span class="dashicons dashicons-cloud-upload" style="color: var(--kb-gold); font-size: 22px; width: 22px; height: 22px;"></span>
							<h2 class="kb-box-title" style="margin: 0;"><?php esc_html_e( '1-Click Atelier Demo Products Import', 'kinboni-pro' ); ?></h2>
						</div>
						<button type="button" class="kb-modal-close" id="kb-btn-close-import-modal">&times;</button>
					</div>

					<div class="kb-modal-body">
						<p style="color: var(--kb-text-muted); font-size: 13px; line-height: 1.6; margin-top: 0;">
							<?php esc_html_e( 'Import all 12 haute horlogerie, leather, and fine fragrance atelier creations into WooCommerce. This will automatically set up categories, sideload high-resolution imagery, and configure specs.', 'kinboni-pro' ); ?>
						</p>

						<div style="background: rgba(197, 160, 89, 0.08); border: 1px solid var(--kb-border-gold); padding: 14px 18px; border-radius: 12px; margin-bottom: 20px;">
							<div style="display: flex; align-items: center; gap: 8px; color: var(--kb-gold); font-weight: 700; font-size: 13px; margin-bottom: 4px;">
								<span class="dashicons dashicons-shield"></span>
								<span><?php esc_html_e( '100% Duplicate Prevention Guaranteed', 'kinboni-pro' ); ?></span>
							</div>
							<p style="font-size: 12px; color: var(--kb-text-muted); margin: 0; line-height: 1.5;">
								<?php esc_html_e( 'Every creation is tracked by its unique identifier and SKU (KB-DEMO-01 to KB-DEMO-12). Re-running this migration safely updates existing records without creating duplicate items in your store.', 'kinboni-pro' ); ?>
							</p>
						</div>

						<!-- Demo Items Showcase Grid -->
						<div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; max-height: 220px; overflow-y: auto; padding-right: 6px; margin-bottom: 20px;">
							<?php foreach ( $demo_products as $dp ) : ?>
								<div style="background: #111014; border: 1px solid var(--kb-border); padding: 8px 12px; border-radius: 8px; display: flex; align-items: center; gap: 10px;">
									<img src="<?php echo esc_url( $dp['image'] ); ?>" style="width: 34px; height: 34px; border-radius: 6px; object-fit: cover;" alt="">
									<div style="flex: 1; min-width: 0;">
										<div style="font-size: 12px; font-weight: 600; color: #fff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?php echo esc_html( $dp['name'] ); ?></div>
										<div style="font-size: 11px; color: var(--kb-gold);">৳<?php echo esc_html( number_format( $dp['price'] ) ); ?> &middot; <?php echo esc_html( $dp['categoryLabel'] ); ?></div>
									</div>
								</div>
							<?php endforeach; ?>
						</div>

						<!-- Import Progress Bar -->
						<div id="kb-import-progress-box" style="display: none; margin-bottom: 16px;">
							<div style="display: flex; justify-content: space-between; font-size: 12px; color: var(--kb-text-muted); margin-bottom: 6px;">
								<span id="kb-import-status-text"><?php esc_html_e( 'Importing atelier creations and imagery...', 'kinboni-pro' ); ?></span>
								<span id="kb-import-percent-text">0%</span>
							</div>
							<div style="height: 6px; background: #27252f; border-radius: 4px; overflow: hidden;">
								<div id="kb-import-progress-bar" style="height: 100%; width: 0%; background: var(--kb-gold); transition: width 0.4s ease;"></div>
							</div>
						</div>

					</div>

					<div class="kb-modal-footer">
						<button type="button" class="kb-btn-secondary" id="kb-btn-cancel-import"><?php esc_html_e( 'Cancel', 'kinboni-pro' ); ?></button>
						<button type="button" id="kb-btn-run-import" class="kb-btn-save">
							<span class="dashicons dashicons-cloud-upload"></span>
							<span><?php esc_html_e( 'Start 1-Click Import (12 Products)', 'kinboni-pro' ); ?></span>
						</button>
					</div>
				</div>
			</div>

			<!-- Toast Alert Box -->
			<div id="kb-admin-toast">
				<span class="dashicons dashicons-yes" style="color: var(--kb-gold);"></span>
				<span id="kb-toast-text"><?php esc_html_e( 'Configuration updated.', 'kinboni-pro' ); ?></span>
			</div>

		</div>
		<?php
	}
}

