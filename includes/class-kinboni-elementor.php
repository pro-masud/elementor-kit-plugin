<?php
/**
 * Elementor Integration — Widget category & registration.
 *
 * @package KinboniPro
 */

defined( 'ABSPATH' ) || exit;

class Kinboni_Elementor {

	/**
	 * Register hooks — called only when Elementor is loaded.
	 */
	public static function init(): void {
		add_action( 'elementor/elements/categories_registered', [ __CLASS__, 'register_category' ] );
		add_action( 'elementor/widgets/register', [ __CLASS__, 'register_widgets' ] );
	}

	/**
	 * Register a custom KINBONI widget category.
	 *
	 * @param \Elementor\Elements_Manager $manager Elementor elements manager.
	 */
	public static function register_category( $manager ): void {
		$manager->add_category( 'kinboni', [
			'title' => __( 'KINBONI Pro', 'kinboni-pro' ),
			'icon'  => 'fa fa-gem',
		] );
	}

	/**
	 * Register all KINBONI Elementor widgets.
	 *
	 * @param \Elementor\Widgets_Manager $manager Elementor widgets manager.
	 */
	public static function register_widgets( $manager ): void {

		// Guard — Elementor Widget_Base must exist.
		if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
			return;
		}

		// Load widget files.
		$widgets_dir = KINBONI_DIR . 'widgets/';

		// ── Demo Widget ──────────────────────────────────────
		require_once $widgets_dir . 'class-widget-demo.php';
		$manager->register( new \KinboniPro\Widgets\Widget_Demo() );

		// ── Future widgets (uncomment as you build) ──────────
		// require_once $widgets_dir . 'class-widget-product-card.php';
		// $manager->register( new \KinboniPro\Widgets\Widget_Product_Card() );
		//
		// require_once $widgets_dir . 'class-widget-product-grid.php';
		// $manager->register( new \KinboniPro\Widgets\Widget_Product_Grid() );
		//
		// require_once $widgets_dir . 'class-widget-cart-drawer.php';
		// $manager->register( new \KinboniPro\Widgets\Widget_Cart_Drawer() );
	}
}

