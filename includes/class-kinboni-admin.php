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

		<style>
			:root {
				--kb-gold: #c5a059;
				--kb-gold-hover: #d4af37;
				--kb-gold-glow: rgba(197, 160, 89, 0.15);
				--kb-dark-bg: #0c0b0e;
				--kb-card-bg: #141318;
				--kb-card-hover: #19181f;
				--kb-border: rgba(255, 255, 255, 0.08);
				--kb-border-gold: rgba(197, 160, 89, 0.3);
				--kb-text-white: #f5f5f7;
				--kb-text-muted: #9e9ba5;
			}
			#wpcontent {
				background: var(--kb-dark-bg) !important;
			}
			.kinboni-admin-wrap {
				max-width: 1240px;
				margin: 25px 20px 40px 0;
				font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
				color: var(--kb-text-white);
			}
			/* Header Brand Bar */
			.kb-admin-header {
				display: flex;
				align-items: center;
				justify-content: space-between;
				padding: 24px 30px;
				background: var(--kb-card-bg);
				border: 1px solid var(--kb-border);
				border-radius: 16px;
				margin-bottom: 24px;
				box-shadow: 0 10px 30px rgba(0,0,0,0.3);
			}
			.kb-brand-box {
				display: flex;
				align-items: center;
				gap: 16px;
			}
			.kb-monogram-badge {
				width: 48px;
				height: 48px;
				border-radius: 50%;
				background: linear-gradient(135deg, #1b1a20, #0c0b0e);
				border: 2px solid var(--kb-gold);
				color: var(--kb-gold);
				display: grid;
				place-items: center;
				font-family: Georgia, serif;
				font-size: 24px;
				font-weight: 700;
				box-shadow: 0 0 15px var(--kb-gold-glow);
			}
			.kb-brand-titles h1 {
				font-family: Georgia, serif;
				font-size: 24px;
				font-weight: 600;
				color: #fff;
				margin: 0;
				line-height: 1.1;
				letter-spacing: 0.15em;
			}
			.kb-brand-titles p {
				margin: 3px 0 0 0;
				font-size: 10px;
				text-transform: uppercase;
				letter-spacing: 0.35em;
				color: var(--kb-gold);
				font-weight: 600;
			}
			.kb-header-actions {
				display: flex;
				align-items: center;
				gap: 12px;
			}
			.kb-btn-save {
				background: linear-gradient(135deg, var(--kb-gold), #aa7c11);
				color: #0c0a09;
				border: none;
				padding: 10px 22px;
				border-radius: 10px;
				font-weight: 700;
				font-size: 12px;
				text-transform: uppercase;
				letter-spacing: 0.1em;
				cursor: pointer;
				transition: all 0.25s ease;
				display: inline-flex;
				align-items: center;
				gap: 8px;
			}
			.kb-btn-save:hover {
				background: linear-gradient(135deg, var(--kb-gold-hover), #c5a059);
				transform: translateY(-1px);
				box-shadow: 0 6px 16px rgba(197, 160, 89, 0.35);
			}
			.kb-btn-secondary {
				background: rgba(255, 255, 255, 0.05);
				border: 1px solid var(--kb-border);
				color: var(--kb-text-white);
				padding: 9px 18px;
				border-radius: 10px;
				font-size: 12px;
				font-weight: 600;
				cursor: pointer;
				transition: all 0.2s;
				text-decoration: none;
				display: inline-flex;
				align-items: center;
				gap: 6px;
			}
			.kb-btn-secondary:hover {
				background: rgba(255, 255, 255, 0.1);
				color: #fff;
				border-color: var(--kb-border-gold);
			}

			/* Tabs Navigation */
			.kb-admin-tabs {
				display: flex;
				gap: 6px;
				border-bottom: 1px solid var(--kb-border);
				margin-bottom: 24px;
				padding-bottom: 1px;
			}
			.kb-tab-btn {
				background: transparent;
				border: none;
				color: var(--kb-text-muted);
				font-size: 13px;
				font-weight: 600;
				padding: 12px 20px;
				border-radius: 10px 10px 0 0;
				cursor: pointer;
				transition: all 0.2s;
				display: flex;
				align-items: center;
				gap: 8px;
				position: relative;
			}
			.kb-tab-btn:hover {
				color: var(--kb-text-white);
				background: rgba(255, 255, 255, 0.03);
			}
			.kb-tab-btn.active {
				color: var(--kb-gold);
				background: var(--kb-card-bg);
				border: 1px solid var(--kb-border);
				border-bottom-color: var(--kb-card-bg);
			}
			.kb-tab-btn.active:after {
				content: "";
				position: absolute;
				bottom: -1px;
				left: 0;
				right: 0;
				height: 2px;
				background: var(--kb-gold);
			}

			/* Tab Content Sections */
			.kb-tab-pane {
				display: none;
			}
			.kb-tab-pane.active {
				display: block;
			}

			/* Stats Row */
			.kb-stats-grid {
				display: grid;
				grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
				gap: 16px;
				margin-bottom: 24px;
			}
			.kb-stat-card {
				background: var(--kb-card-bg);
				border: 1px solid var(--kb-border);
				padding: 20px 22px;
				border-radius: 14px;
				display: flex;
				align-items: center;
				gap: 16px;
				transition: border-color 0.2s;
			}
			.kb-stat-card:hover {
				border-color: var(--kb-border-gold);
			}
			.kb-stat-icon {
				width: 44px;
				height: 44px;
				border-radius: 12px;
				background: var(--kb-gold-glow);
				color: var(--kb-gold);
				display: grid;
				place-items: center;
				font-size: 20px;
				flex-shrink: 0;
			}
			.kb-stat-info h3 {
				font-size: 24px;
				font-weight: 700;
				color: #fff;
				margin: 0;
				line-height: 1.1;
			}
			.kb-stat-info p {
				margin: 3px 0 0 0;
				font-size: 11px;
				text-transform: uppercase;
				letter-spacing: 0.1em;
				color: var(--kb-text-muted);
			}

			/* Section Blocks */
			.kb-card-box {
				background: var(--kb-card-bg);
				border: 1px solid var(--kb-border);
				border-radius: 16px;
				padding: 24px 28px;
				margin-bottom: 24px;
			}
			.kb-box-title {
				font-family: Georgia, serif;
				font-size: 18px;
				font-weight: 600;
				color: #fff;
				margin: 0 0 4px 0;
			}
			.kb-box-desc {
				font-size: 12px;
				color: var(--kb-text-muted);
				margin: 0 0 20px 0;
			}

			/* Widgets Grid */
			.kb-widgets-grid {
				display: grid;
				grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
				gap: 16px;
			}
			.kb-widget-item {
				background: #111014;
				border: 1px solid var(--kb-border);
				border-radius: 14px;
				padding: 18px 20px;
				display: flex;
				align-items: flex-start;
				justify-content: space-between;
				gap: 16px;
				transition: all 0.2s;
			}
			.kb-widget-item:hover {
				border-color: var(--kb-border-gold);
				background: var(--kb-card-hover);
			}
			.kb-w-info {
				display: flex;
				gap: 14px;
			}
			.kb-w-icon {
				width: 36px;
				height: 36px;
				border-radius: 10px;
				background: rgba(255, 255, 255, 0.05);
				color: var(--kb-gold);
				display: grid;
				place-items: center;
				font-size: 18px;
				flex-shrink: 0;
				margin-top: 2px;
			}
			.kb-w-title {
				font-size: 14px;
				font-weight: 600;
				color: #fff;
				margin: 0 0 3px 0;
			}
			.kb-w-desc {
				font-size: 11px;
				color: var(--kb-text-muted);
				margin: 0;
				line-height: 1.4;
			}

			/* Custom Toggle Switch */
			.kb-switch {
				position: relative;
				display: inline-block;
				width: 44px;
				height: 24px;
				flex-shrink: 0;
			}
			.kb-switch input {
				opacity: 0;
				width: 0;
				height: 0;
			}
			.kb-slider {
				position: absolute;
				cursor: pointer;
				inset: 0;
				background-color: #27252f;
				transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
				border-radius: 24px;
				border: 1px solid rgba(255, 255, 255, 0.1);
			}
			.kb-slider:before {
				position: absolute;
				content: "";
				height: 16px;
				width: 16px;
				left: 3px;
				bottom: 3px;
				background-color: #8c8994;
				transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
				border-radius: 50%;
			}
			input:checked + .kb-slider {
				background-color: var(--kb-gold);
				border-color: var(--kb-gold);
			}
			input:checked + .kb-slider:before {
				transform: translateX(20px);
				background-color: #0c0a09;
			}

			/* Form Controls */
			.kb-form-row {
				display: flex;
				flex-direction: column;
				gap: 6px;
				margin-bottom: 18px;
			}
			.kb-form-row label {
				font-size: 12px;
				font-weight: 600;
				text-transform: uppercase;
				letter-spacing: 0.08em;
				color: var(--kb-text-muted);
			}
			.kb-input, .kb-textarea, .kb-select {
				background: #111014 !important;
				border: 1px solid var(--kb-border) !important;
				color: #fff !important;
				padding: 10px 14px !important;
				border-radius: 10px !important;
				font-size: 13px !important;
				max-width: 450px;
				transition: border-color 0.2s;
			}
			.kb-input:focus, .kb-textarea:focus {
				border-color: var(--kb-gold) !important;
				outline: none;
				box-shadow: 0 0 10px var(--kb-gold-glow) !important;
			}

			/* Subscribers Table */
			.kb-table-wrap {
				overflow-x: auto;
				border-radius: 12px;
				border: 1px solid var(--kb-border);
			}
			.kb-admin-table {
				width: 100%;
				border-collapse: collapse;
				font-size: 12px;
				text-align: left;
			}
			.kb-admin-table th {
				background: #100f13;
				color: var(--kb-gold);
				font-weight: 600;
				text-transform: uppercase;
				letter-spacing: 0.08em;
				padding: 12px 16px;
				border-bottom: 1px solid var(--kb-border);
			}
			.kb-admin-table td {
				padding: 12px 16px;
				border-bottom: 1px solid rgba(255, 255, 255, 0.04);
				color: var(--kb-text-white);
			}
			.kb-admin-table tr:hover td {
				background: rgba(255, 255, 255, 0.02);
			}

			/* Toast Notification */
			#kb-admin-toast {
				position: fixed;
				bottom: 25px;
				right: 25px;
				background: #18171d;
				border: 1px solid var(--kb-gold);
				color: #fff;
				padding: 12px 20px;
				border-radius: 12px;
				box-shadow: 0 10px 30px rgba(0,0,0,0.5);
				display: none;
				align-items: center;
				gap: 10px;
				font-size: 13px;
				font-weight: 600;
				z-index: 999999;
			}

			/* Modals & Popups */
			.kb-modal-backdrop {
				position: fixed;
				top: 0;
				left: 0;
				right: 0;
				bottom: 0;
				background: rgba(0, 0, 0, 0.78);
				backdrop-filter: blur(5px);
				z-index: 100000;
				display: none;
				align-items: center;
				justify-content: center;
				padding: 20px;
			}
			.kb-modal-backdrop.is-open {
				display: flex;
			}
			.kb-modal-dialog {
				background: #141318;
				border: 1px solid var(--kb-border-gold);
				border-radius: 16px;
				width: 100%;
				max-width: 960px;
				max-height: 90vh;
				display: flex;
				flex-direction: column;
				box-shadow: 0 25px 60px rgba(0,0,0,0.8);
				overflow: hidden;
			}
			.kb-modal-header {
				padding: 20px 26px;
				border-bottom: 1px solid var(--kb-border);
				display: flex;
				justify-content: space-between;
				align-items: center;
				background: #100f13;
			}
			.kb-modal-close {
				background: transparent;
				border: none;
				color: var(--kb-text-muted);
				font-size: 26px;
				cursor: pointer;
				line-height: 1;
				transition: color 0.2s;
			}
			.kb-modal-close:hover {
				color: #fff;
			}
			.kb-modal-body {
				padding: 24px 26px;
				overflow-y: auto;
				flex: 1;
			}
			.kb-modal-footer {
				padding: 16px 26px;
				border-top: 1px solid var(--kb-border);
				display: flex;
				justify-content: flex-end;
				gap: 12px;
				background: #100f13;
			}
			.kb-modal-grid {
				display: grid;
				grid-template-columns: 1.4fr 1fr;
				gap: 24px;
			}
			@media (max-width: 820px) {
				.kb-modal-grid {
					grid-template-columns: 1fr;
				}
			}
			.kb-box-inner {
				background: #100f13;
				border: 1px solid var(--kb-border);
				border-radius: 12px;
				padding: 16px;
				margin-bottom: 16px;
			}
			.kb-inner-title {
				font-size: 11px;
				font-weight: 700;
				text-transform: uppercase;
				letter-spacing: 0.12em;
				color: var(--kb-gold);
				margin: 0 0 12px 0;
			}
			.kb-media-box {
				width: 100%;
				height: 100px;
				border-radius: 10px;
				border: 1px dashed var(--kb-border);
				background: rgba(255,255,255,0.02);
				display: flex;
				align-items: center;
				justify-content: center;
				cursor: pointer;
				overflow: hidden;
				transition: border-color 0.2s;
				position: relative;
			}
			.kb-media-box:hover {
				border-color: var(--kb-gold);
			}
			.kb-media-box img {
				width: 100%;
				height: 100%;
				object-fit: cover;
			}
			.kb-preview-wrap {
				display: flex;
				flex-direction: column;
				align-items: center;
				color: var(--kb-text-muted);
			}
			.kb-btn-text-danger {
				background: transparent;
				border: none;
				color: #ef4444;
				font-size: 11px;
				cursor: pointer;
				padding: 0;
			}
			.kb-gallery-thumb-item {
				position: relative;
				width: 52px;
				height: 52px;
				border-radius: 8px;
				overflow: hidden;
				border: 1px solid var(--kb-border);
			}
			.kb-gallery-thumb-item img {
				width: 100%;
				height: 100%;
				object-fit: cover;
			}
			.kb-gallery-remove-btn {
				position: absolute;
				top: 2px;
				right: 2px;
				background: rgba(0,0,0,0.75);
				color: #fff;
				border: none;
				border-radius: 50%;
				width: 16px;
				height: 16px;
				font-size: 11px;
				display: flex;
				align-items: center;
				justify-content: center;
				cursor: pointer;
				line-height: 1;
			}
			.kb-badge-pill {
				display: inline-block;
				padding: 2px 7px;
				border-radius: 9999px;
				font-size: 9px;
				font-weight: 700;
				letter-spacing: 0.08em;
				text-transform: uppercase;
			}
			.kb-badge-gold {
				background: rgba(197, 160, 89, 0.15);
				border: 1px solid var(--kb-border-gold);
				color: var(--kb-gold);
			}
			.kb-badge-green {
				background: rgba(16, 185, 129, 0.15);
				border: 1px solid rgba(16, 185, 129, 0.3);
				color: #10b981;
			}
			.kb-badge-red {
				background: rgba(239, 68, 68, 0.15);
				border: 1px solid rgba(239, 68, 68, 0.3);
				color: #ef4444;
			}
			.kb-badge-muted {
				background: rgba(255, 255, 255, 0.05);
				border: 1px solid var(--kb-border);
				color: var(--kb-text-muted);
			}
			.kb-spec-row {
				display: flex;
				align-items: center;
				gap: 8px;
			}
		</style>

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

		<script>
		jQuery(document).ready(function($) {
			const nonce = '<?php echo esc_js( $nonce ); ?>';

			function showToast(msg, isError) {
				const $toast = $('#kb-admin-toast');
				$('#kb-toast-text').text(msg);
				if (isError) {
					$toast.css('border-color', '#ef4444');
				} else {
					$toast.css('border-color', 'var(--kb-gold)');
				}
				$toast.fadeIn(250).delay(3000).fadeOut(300);
			}

			// Tabs Switcher with URL hash preservation
			$('.kb-tab-btn').on('click', function() {
				const tab = $(this).data('tab');
				$('.kb-tab-btn').removeClass('active');
				$(this).addClass('active');
				$('.kb-tab-pane').removeClass('active');
				$('#tab-' + tab).addClass('active');
				window.location.hash = tab;
			});

			if (window.location.hash) {
				const hash = window.location.hash.replace('#', '');
				const $targetBtn = $('.kb-tab-btn[data-tab="' + hash + '"]');
				if ($targetBtn.length) {
					$targetBtn.trigger('click');
				}
			}

			// AJAX Save Settings
			$('#kb-btn-save-all').on('click', function(e) {
				e.preventDefault();
				const $btn = $(this);
				$btn.prop('disabled', true).css('opacity', '0.6');

				const formData = $('#kb-dashboard-form').serializeArray();
				const payload = {};
				formData.forEach(function(item) {
					payload[item.name.replace('settings[', '').replace(']', '')] = item.value;
				});

				// Include unchecked checkboxes as 'no'
				$('#kb-dashboard-form input[type="checkbox"]').each(function() {
					const name = $(this).attr('name').replace('settings[', '').replace(']', '');
					if (!$(this).is(':checked')) {
						payload[name] = 'no';
					}
				});

				$.ajax({
					url: ajaxurl,
					type: 'POST',
					data: {
						action: 'kinboni_save_dashboard_settings',
						nonce: nonce,
						settings: payload
					},
					success: function(resp) {
						$btn.prop('disabled', false).css('opacity', '1');
						if (resp.success) {
							showToast(resp.data.message || 'Saved successfully!');
						} else {
							showToast(resp.data.message || 'Error saving settings', true);
						}
					},
					error: function() {
						$btn.prop('disabled', false).css('opacity', '1');
						showToast('Server communication error', true);
					}
				});
			});

			// AJAX Purge Cache
			$('#kb-btn-purge-cache').on('click', function(e) {
				e.preventDefault();
				const $btn = $(this);
				$btn.prop('disabled', true);
				$.post(ajaxurl, { action: 'kinboni_purge_cache', nonce: nonce }, function(resp) {
					$btn.prop('disabled', false);
					if (resp.success) {
						showToast(resp.data.message);
					}
				});
			});

			// Delete Single Subscriber
			$('.kb-btn-delete-sub').on('click', function(e) {
				e.preventDefault();
				const email = $(this).data('email');
				const $row = $(this).closest('tr');
				if (!confirm('Remove subscriber "' + email + '" from VIP list?')) {
					return;
				}
				$.post(ajaxurl, {
					action: 'kinboni_delete_subscriber',
					nonce: nonce,
					email: email
				}, function(resp) {
					if (resp.success) {
						$row.fadeOut(300, function() { $(this).remove(); });
						showToast('Subscriber removed');
					}
				});
			});

			// Clear All Subscribers
			$('#kb-btn-clear-subs').on('click', function(e) {
				e.preventDefault();
				if (!confirm('Are you sure you want to permanently clear all VIP subscribers? This action cannot be undone.')) {
					return;
				}
				$.post(ajaxurl, {
					action: 'kinboni_clear_subscribers',
					nonce: nonce
				}, function(resp) {
					if (resp.success) {
						location.reload();
					}
				});
			});

			// ══════════════════════════════════════════════════
			// PRODUCTS & INVENTORY ENGINE
			// ══════════════════════════════════════════════════
			let currentProdPage = 1;
			let totalProdPages  = 1;
			let currentGallery  = [];
			let primaryFrame    = null;
			let hoverFrame      = null;
			let galleryFrame    = null;
			let catThumbFrame   = null;
			let searchDebounce  = null;

			function formatMoney(amount) {
				return '৳' + Number(amount || 0).toLocaleString();
			}

			function loadProducts(page) {
				currentProdPage = page || 1;
				const $tbody = $('#kb-products-tbody');
				$tbody.html('<tr><td colspan="8" style="text-align: center; padding: 40px; color: var(--kb-text-muted);"><span class="dashicons dashicons-update spin"></span> Loading catalog...</td></tr>');

				const search = $('#kb-prod-search').val().trim();
				const category = $('#kb-prod-cat-filter').val();
				const status = $('#kb-prod-status-filter').val();

				$.post(ajaxurl, {
					action: 'kinboni_get_products',
					nonce: nonce,
					page: currentProdPage,
					per_page: 10,
					search: search,
					category: category,
					status: status
				}, function(resp) {
					if (!resp.success || !resp.data) {
						$tbody.html('<tr><td colspan="8" style="text-align: center; padding: 30px; color: #ef4444;">Error loading creations.</td></tr>');
						return;
					}

					const data = resp.data;
					currentProdPage = data.current_page;
					totalProdPages  = data.total_pages || 1;

					$('#kb-products-count-badge').text(data.total);
					$('#kb-products-total-label').text('Total: ' + data.total + ' products');
					$('#kb-prod-pagination-info').text('Showing page ' + currentProdPage + ' of ' + totalProdPages + ' (' + data.total + ' creations)');
					$('#kb-pg-page-num').text(currentProdPage + ' / ' + totalProdPages);

					$('#kb-pg-prev').prop('disabled', currentProdPage <= 1);
					$('#kb-pg-next').prop('disabled', currentProdPage >= totalProdPages);

					if (!data.products || data.products.length === 0) {
						$tbody.html('<tr><td colspan="8" style="text-align: center; padding: 40px; color: var(--kb-text-muted);">No atelier creations found matching your filter criteria.</td></tr>');
						return;
					}

					let rowsHtml = '';
					data.products.forEach(function(p) {
						const imgHtml = p.image
							? '<img src="' + p.image + '" style="width: 44px; height: 44px; border-radius: 8px; object-fit: cover; border: 1px solid var(--kb-border);" alt="">'
							: '<div style="width: 44px; height: 44px; border-radius: 8px; background: rgba(255,255,255,0.05); display: flex; align-items: center; justify-content: center; color: var(--kb-text-muted);"><span class="dashicons dashicons-format-image"></span></div>';

						let priceHtml = '';
						if (p.sale_price > 0 && p.sale_price < p.regular_price) {
							priceHtml = '<div style="display: flex; flex-direction: column;"><span style="text-decoration: line-through; color: var(--kb-text-muted); font-size: 11px;">' + formatMoney(p.regular_price) + '</span><span style="color: var(--kb-gold); font-weight: 700;">' + formatMoney(p.sale_price) + '</span></div>';
						} else {
							priceHtml = '<span style="color: #fff; font-weight: 700;">' + formatMoney(p.price) + '</span>';
						}

						let catPills = '';
						if (p.categories && p.categories.length > 0) {
							catPills = p.categories.map(function(c) {
								return '<span class="kb-badge-pill kb-badge-muted" style="margin-right: 4px; margin-bottom: 2px;">' + c.name + '</span>';
							}).join('');
						} else {
							catPills = '<span style="color: var(--kb-text-muted); font-size: 11px;">—</span>';
						}

						const badgeHtml = p.badge
							? '<span class="kb-badge-pill kb-badge-gold" style="margin-left: 6px;">' + p.badge + '</span>'
							: '';

						const stockHtml = p.stock_status === 'instock'
							? '<span class="kb-badge-pill kb-badge-green">In Stock (' + p.stock_quantity + ')</span>'
							: '<span class="kb-badge-pill kb-badge-red">Out of Stock</span>';

						const statusHtml = p.status === 'publish'
							? '<span class="kb-badge-pill kb-badge-green">Published</span>'
							: '<span class="kb-badge-pill kb-badge-muted">Draft</span>';

						rowsHtml += '<tr id="kb-prod-row-' + p.id + '">' +
							'<td>' + imgHtml + '</td>' +
							'<td>' +
								'<div style="font-weight: 600; color: #fff; display: flex; align-items: center; flex-wrap: wrap;">' +
									p.name + badgeHtml +
								'</div>' +
							'</td>' +
							'<td><code>' + p.sku + '</code></td>' +
							'<td>' + catPills + '</td>' +
							'<td>' + priceHtml + '</td>' +
							'<td>' + stockHtml + '</td>' +
							'<td>' + statusHtml + '</td>' +
							'<td style="text-align: right; white-space: nowrap;">' +
								'<button type="button" class="kb-btn-secondary kb-btn-edit-product" data-id="' + p.id + '" style="padding: 4px 8px; font-size: 11px; margin-right: 4px;" title="Edit">' +
									'<span class="dashicons dashicons-edit"></span>' +
								'</button>' +
								'<a href="' + p.view_url + '" target="_blank" class="kb-btn-secondary" style="padding: 4px 8px; font-size: 11px; margin-right: 4px;" title="View in Store">' +
									'<span class="dashicons dashicons-visibility"></span>' +
								'</a>' +
								'<button type="button" class="kb-btn-secondary kb-btn-delete-product" data-id="' + p.id + '" data-name="' + p.name.replace(/"/g, '&quot;') + '" style="padding: 4px 8px; font-size: 11px; color: #ef4444;" title="Delete">' +
									'<span class="dashicons dashicons-trash"></span>' +
								'</button>' +
							'</td>' +
						'</tr>';
					});

					$tbody.html(rowsHtml);
				});
			}

			// Filter toolbar listeners
			$('#kb-prod-search').on('keyup', function() {
				clearTimeout(searchDebounce);
				searchDebounce = setTimeout(function() {
					loadProducts(1);
				}, 350);
			});

			$('#kb-prod-cat-filter, #kb-prod-status-filter').on('change', function() {
				loadProducts(1);
			});

			$('#kb-pg-prev').on('click', function() {
				if (currentProdPage > 1) {
					loadProducts(currentProdPage - 1);
				}
			});

			$('#kb-pg-next').on('click', function() {
				if (currentProdPage < totalProdPages) {
					loadProducts(currentProdPage + 1);
				}
			});

			// Specs repeater helper
			function addSpecRow(value) {
				const val = value || '';
				const $row = $('<div class="kb-spec-row">' +
					'<input type="text" class="kb-input kb-spec-input" style="max-width: 100%; flex: 1;" placeholder="e.g. 316L Surgical Grade Steel" value="' + val.replace(/"/g, '&quot;') + '">' +
					'<button type="button" class="kb-btn-secondary kb-btn-remove-spec" style="color: #ef4444; padding: 8px 10px;" title="Remove">' +
						'<span class="dashicons dashicons-trash"></span>' +
					'</button>' +
				'</div>');
				$('#kb-specs-container').append($row);
			}

			$('#kb-btn-add-spec').on('click', function() {
				addSpecRow('');
			});

			$(document).on('click', '.kb-btn-remove-spec', function() {
				$(this).closest('.kb-spec-row').remove();
			});

			// Manage stock checkbox toggle
			$('#kb-p-manage-stock').on('change', function() {
				if ($(this).is(':checked')) {
					$('#kb-stock-qty-box').slideDown(150);
				} else {
					$('#kb-stock-qty-box').slideUp(150);
				}
			});

			// Gallery rendering
			function renderGallery() {
				const $wrap = $('#kb-gallery-container');
				$wrap.empty();
				if (!currentGallery || currentGallery.length === 0) {
					$wrap.html('<span id="kb-gallery-empty-tip" style="font-size: 11px; color: var(--kb-text-muted); margin: auto;">No gallery images attached</span>');
					return;
				}
				currentGallery.forEach(function(item, idx) {
					const $item = $('<div class="kb-gallery-thumb-item">' +
						'<img src="' + item.url + '" alt="">' +
						'<button type="button" class="kb-gallery-remove-btn" data-index="' + idx + '">&times;</button>' +
					'</div>');
					$wrap.append($item);
				});
			}

			$(document).on('click', '.kb-gallery-remove-btn', function(e) {
				e.stopPropagation();
				const idx = parseInt($(this).data('index'), 10);
				currentGallery.splice(idx, 1);
				renderGallery();
			});

			// Media pickers: Primary Image
			$('#kb-primary-img-box').on('click', function(e) {
				e.preventDefault();
				if (primaryFrame) {
					primaryFrame.open();
					return;
				}
				primaryFrame = wp.media({
					title: 'Select Primary Product Image',
					button: { text: 'Use this Image' },
					multiple: false,
					library: { type: 'image' }
				});
				primaryFrame.on('select', function() {
					const attachment = primaryFrame.state().get('selection').first().toJSON();
					$('#kb-p-image-id').val(attachment.id);
					$('#kb-primary-preview').html('<img src="' + attachment.url + '" style="width: 100%; height: 100%; object-fit: cover;" alt="">');
					$('#kb-primary-remove-btn').show();
				});
				primaryFrame.open();
			});

			$('#kb-primary-remove-btn').on('click', function() {
				$('#kb-p-image-id').val('');
				$('#kb-primary-preview').html('<span class="dashicons dashicons-camera" style="font-size: 24px; width: 24px; height: 24px; color: var(--kb-gold);"></span><span style="font-size: 10px; margin-top: 4px;">Select Image</span>');
				$(this).hide();
			});

			// Media pickers: Hover Image
			$('#kb-hover-img-box').on('click', function(e) {
				e.preventDefault();
				if (hoverFrame) {
					hoverFrame.open();
					return;
				}
				hoverFrame = wp.media({
					title: 'Select Hover / Secondary Image',
					button: { text: 'Use this Image' },
					multiple: false,
					library: { type: 'image' }
				});
				hoverFrame.on('select', function() {
					const attachment = hoverFrame.state().get('selection').first().toJSON();
					$('#kb-p-hover-image-id').val(attachment.id);
					$('#kb-hover-preview').html('<img src="' + attachment.url + '" style="width: 100%; height: 100%; object-fit: cover;" alt="">');
					$('#kb-hover-remove-btn').show();
				});
				hoverFrame.open();
			});

			$('#kb-hover-remove-btn').on('click', function() {
				$('#kb-p-hover-image-id').val('');
				$('#kb-hover-preview').html('<span class="dashicons dashicons-images-alt" style="font-size: 24px; width: 24px; height: 24px; color: var(--kb-text-muted);"></span><span style="font-size: 10px; margin-top: 4px;">Select Image</span>');
				$(this).hide();
			});

			// Media pickers: Gallery Multi-Images
			$('#kb-btn-add-gallery').on('click', function(e) {
				e.preventDefault();
				if (galleryFrame) {
					galleryFrame.open();
					return;
				}
				galleryFrame = wp.media({
					title: 'Add Images to Product Gallery',
					button: { text: 'Add to Gallery' },
					multiple: true,
					library: { type: 'image' }
				});
				galleryFrame.on('select', function() {
					const selection = galleryFrame.state().get('selection');
					selection.map(function(att) {
						const item = att.toJSON();
						currentGallery.push({
							id: item.id,
							url: item.url
						});
					});
					renderGallery();
				});
				galleryFrame.open();
			});

			// Open Product Modal
			function openProductModal(id) {
				const isEdit = (id && id > 0);
				$('#kb-p-id').val(isEdit ? id : 0);
				$('#kb-p-name').val('');
				$('#kb-p-slug').val('');
				$('#kb-p-regular-price').val('');
				$('#kb-p-sale-price').val('');
				$('#kb-p-sku').val('');
				$('#kb-p-badge').val('');
				$('#kb-p-short-desc').val('');
				$('#kb-p-desc').val('');
				$('#kb-specs-container').empty();
				$('input[name="p_status"][value="publish"]').prop('checked', true);
				$('#kb-p-featured').prop('checked', false);
				$('#kb-p-manage-stock').prop('checked', false);
				$('#kb-stock-qty-box').hide();
				$('#kb-p-stock-qty').val('');
				$('#kb-p-stock-status').val('instock');
				$('.kb-modal-cat-checkbox').prop('checked', false);
				$('#kb-primary-remove-btn').trigger('click');
				$('#kb-hover-remove-btn').trigger('click');
				currentGallery = [];
				renderGallery();

				if (!isEdit) {
					$('#kb-modal-product-title').text('Create New Atelier Creation');
					addSpecRow('');
					$('#kb-product-modal').addClass('is-open');
				} else {
					$('#kb-modal-product-title').text('Edit Atelier Creation');
					$('#kb-product-modal').addClass('is-open');

					$.post(ajaxurl, {
						action: 'kinboni_get_product',
						nonce: nonce,
						product_id: id
					}, function(resp) {
						if (!resp.success || !resp.data) {
							showToast('Error loading product data', true);
							return;
						}
						const p = resp.data;
						$('#kb-p-name').val(p.name);
						$('#kb-p-slug').val(p.slug);
						$('#kb-p-regular-price').val(p.regular_price);
						$('#kb-p-sale-price').val(p.sale_price);
						$('#kb-p-sku').val(p.sku);
						$('#kb-p-badge').val(p.badge || '');
						$('#kb-p-short-desc').val(p.short_description);
						$('#kb-p-desc').val(p.description);

						$('input[name="p_status"][value="' + p.status + '"]').prop('checked', true);
						$('#kb-p-featured').prop('checked', p.featured === 'yes');

						if (p.manage_stock === 'yes') {
							$('#kb-p-manage-stock').prop('checked', true);
							$('#kb-stock-qty-box').show();
							$('#kb-p-stock-qty').val(p.stock_quantity);
						}
						$('#kb-p-stock-status').val(p.stock_status || 'instock');

						// Categories
						if (p.categories && Array.isArray(p.categories)) {
							p.categories.forEach(function(cid) {
								$('.kb-modal-cat-checkbox[value="' + cid + '"]').prop('checked', true);
							});
						}

						// Images
						if (p.image_id && p.image_url) {
							$('#kb-p-image-id').val(p.image_id);
							$('#kb-primary-preview').html('<img src="' + p.image_url + '" style="width: 100%; height: 100%; object-fit: cover;" alt="">');
							$('#kb-primary-remove-btn').show();
						}

						if (p.hover_image_id || p.hover_image_url) {
							if (p.hover_image_id) {
								$('#kb-p-hover-image-id').val(p.hover_image_id);
							}
							const hUrl = p.hover_image_url;
							if (hUrl) {
								$('#kb-hover-preview').html('<img src="' + hUrl + '" style="width: 100%; height: 100%; object-fit: cover;" alt="">');
								$('#kb-hover-remove-btn').show();
							}
						}

						// Gallery
						if (p.gallery && Array.isArray(p.gallery)) {
							currentGallery = p.gallery.slice();
							renderGallery();
						}

						// Specs
						if (p.specs && Array.isArray(p.specs)) {
							p.specs.forEach(function(s) {
								addSpecRow(s);
							});
						} else {
							addSpecRow('');
						}
					});
				}
			}

			$('#kb-btn-open-add-product').on('click', function() {
				openProductModal(0);
			});

			$(document).on('click', '.kb-btn-edit-product', function() {
				const id = $(this).data('id');
				openProductModal(id);
			});

			$('#kb-btn-close-product-modal, #kb-btn-cancel-product-modal').on('click', function() {
				$('#kb-product-modal').removeClass('is-open');
			});

			// Save Product Form
			$('#kb-product-edit-form').on('submit', function(e) {
				e.preventDefault();
				const $btn = $('#kb-btn-save-product-submit');
				$btn.prop('disabled', true).css('opacity', '0.6');

				const catIds = [];
				$('.kb-modal-cat-checkbox:checked').each(function() {
					catIds.push($(this).val());
				});

				const specs = [];
				$('.kb-spec-input').each(function() {
					const v = $(this).val().trim();
					if (v) {
						specs.push(v);
					}
				});

				const galleryIds = currentGallery.map(function(g) { return g.id; });

				const payload = {
					id: $('#kb-p-id').val(),
					name: $('#kb-p-name').val().trim(),
					slug: $('#kb-p-slug').val().trim(),
					regular_price: $('#kb-p-regular-price').val(),
					sale_price: $('#kb-p-sale-price').val(),
					sku: $('#kb-p-sku').val().trim(),
					badge: $('#kb-p-badge').val(),
					short_description: $('#kb-p-short-desc').val(),
					description: $('#kb-p-desc').val(),
					status: $('input[name="p_status"]:checked').val() || 'publish',
					featured: $('#kb-p-featured').is(':checked') ? 'yes' : 'no',
					manage_stock: $('#kb-p-manage-stock').is(':checked') ? 'yes' : 'no',
					stock_quantity: $('#kb-p-stock-qty').val(),
					stock_status: $('#kb-p-stock-status').val(),
					categories: catIds,
					image_id: $('#kb-p-image-id').val(),
					hover_image_id: $('#kb-p-hover-image-id').val(),
					gallery_ids: galleryIds,
					specs: specs
				};

				$.post(ajaxurl, {
					action: 'kinboni_save_product',
					nonce: nonce,
					product: payload
				}, function(resp) {
					$btn.prop('disabled', false).css('opacity', '1');
					if (resp.success) {
						showToast(resp.data.message || 'Creation synchronized with WooCommerce');
						$('#kb-product-modal').removeClass('is-open');
						loadProducts(currentProdPage);
					} else {
						showToast(resp.data.message || 'Error saving creation', true);
					}
				}).fail(function() {
					$btn.prop('disabled', false).css('opacity', '1');
					showToast('Server error while saving product', true);
				});
			});

			// Delete Product
			$(document).on('click', '.kb-btn-delete-product', function() {
				const id = $(this).data('id');
				const name = $(this).data('name');
				if (!confirm('Move creation "' + name + '" to trash?')) {
					return;
				}
				$.post(ajaxurl, {
					action: 'kinboni_delete_product',
					nonce: nonce,
					product_id: id
				}, function(resp) {
					if (resp.success) {
						showToast(resp.data.message || 'Product removed');
						loadProducts(currentProdPage);
					} else {
						showToast(resp.data.message || 'Could not delete product', true);
					}
				});
			});

			// Categories Modal
			$('#kb-btn-open-categories').on('click', function() {
				$('#kb-cats-modal').addClass('is-open');
			});

			$('#kb-btn-close-cats-modal, #kb-btn-close-cats-modal-footer').on('click', function() {
				$('#kb-cats-modal').removeClass('is-open');
			});

			$('#kb-btn-pick-cat-thumb').on('click', function(e) {
				e.preventDefault();
				if (catThumbFrame) {
					catThumbFrame.open();
					return;
				}
				catThumbFrame = wp.media({
					title: 'Select Category Thumbnail',
					button: { text: 'Use Image' },
					multiple: false,
					library: { type: 'image' }
				});
				catThumbFrame.on('select', function() {
					const att = catThumbFrame.state().get('selection').first().toJSON();
					$('#kb-cat-thumb-id').val(att.id);
					$('#kb-cat-thumb-label').text(att.filename || 'Image selected');
				});
				catThumbFrame.open();
			});

			$('#kb-category-form').on('submit', function(e) {
				e.preventDefault();
				const $btn = $('#kb-btn-save-cat');
				$btn.prop('disabled', true);

				const name = $('#kb-cat-name').val().trim();
				const slug = $('#kb-cat-slug').val().trim();
				const desc = $('#kb-cat-desc').val().trim();
				const thumbId = $('#kb-cat-thumb-id').val();

				$.post(ajaxurl, {
					action: 'kinboni_save_category',
					nonce: nonce,
					name: name,
					slug: slug,
					description: desc,
					thumbnail_id: thumbId
				}, function(resp) {
					$btn.prop('disabled', false);
					if (resp.success) {
						showToast(resp.data.message || 'Category saved successfully!');
						$('#kb-cat-name').val('');
						$('#kb-cat-slug').val('');
						$('#kb-cat-desc').val('');
						$('#kb-cat-thumb-id').val(0);
						$('#kb-cat-thumb-label').text('No image');
						setTimeout(function() { location.reload(); }, 900);
					} else {
						showToast(resp.data.message || 'Error saving category', true);
					}
				});
			});

			$(document).on('click', '.kb-btn-delete-cat', function() {
				const id = $(this).data('id');
				const name = $(this).data('name');
				if (!confirm('Are you sure you want to delete category "' + name + '"?')) {
					return;
				}
				$.post(ajaxurl, {
					action: 'kinboni_delete_category',
					nonce: nonce,
					term_id: id
				}, function(resp) {
					if (resp.success) {
						$('#kb-cat-row-' + id).fadeOut(250, function() { $(this).remove(); });
						showToast(resp.data.message || 'Category removed');
					} else {
						showToast(resp.data.message || 'Error deleting category', true);
					}
				});
			});

			// Demo Products Migration Modal
			$('#kb-btn-open-demo-import').on('click', function() {
				$('#kb-import-modal').addClass('is-open');
			});

			$('#kb-btn-close-import-modal, #kb-btn-cancel-import').on('click', function() {
				$('#kb-import-modal').removeClass('is-open');
			});

			$('#kb-btn-run-import').on('click', function() {
				const $btn = $(this);
				$btn.prop('disabled', true).css('opacity', '0.6');
				$('#kb-import-progress-box').slideDown(200);

				let progress = 10;
				const timer = setInterval(function() {
					if (progress < 85) {
						progress += Math.floor(Math.random() * 8) + 4;
						$('#kb-import-progress-bar').css('width', progress + '%');
						$('#kb-import-percent-text').text(progress + '%');
					}
				}, 400);

				$.post(ajaxurl, {
					action: 'kinboni_migrate_demo_products',
					nonce: nonce
				}, function(resp) {
					clearInterval(timer);
					$btn.prop('disabled', false).css('opacity', '1');

					if (resp.success) {
						$('#kb-import-progress-bar').css('width', '100%');
						$('#kb-import-percent-text').text('100%');
						$('#kb-import-status-text').text('Import completed successfully!');
						showToast(resp.data.message || 'All 12 demo creations synchronized!');
						setTimeout(function() {
							$('#kb-import-modal').removeClass('is-open');
							$('#kb-import-progress-box').hide();
							$('#kb-import-progress-bar').css('width', '0%');
							loadProducts(1);
						}, 1200);
					} else {
						showToast(resp.data.message || 'Import failed', true);
					}
				}).fail(function() {
					clearInterval(timer);
					$btn.prop('disabled', false).css('opacity', '1');
					showToast('Server communication error during import', true);
				});
			});

			// Initialize products catalog table
			loadProducts(1);
		});
		</script>
		<?php
	}
}

