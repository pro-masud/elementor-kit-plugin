<?php
/**
 * Elementor Integration — Widget category & registration.
 *
 * Configures the KINBONI Pro category to always appear at the very top of the Elementor panel.
 *
 * @package KinboniPro
 */

defined( 'ABSPATH' ) || exit;

class Kinboni_Elementor {

	/**
	 * Register hooks — called only when Elementor is loaded.
	 */
	public static function init(): void {
		// Priority 9999 ensures our category registration and reordering runs after all core/3rd party categories.
		add_action( 'elementor/elements/categories_registered', [ __CLASS__, 'register_category' ], 9999 );
		add_action( 'elementor/widgets/register', [ __CLASS__, 'register_widgets' ] );
		add_action( 'elementor/editor/after_enqueue_styles', [ __CLASS__, 'enqueue_editor_styles' ] );
		add_action( 'elementor/editor/after_enqueue_scripts', [ __CLASS__, 'enqueue_editor_scripts' ] );
	}

	/**
	 * Register a custom KINBONI widget category and prepend it to the very top.
	 *
	 * @param \Elementor\Elements_Manager $manager Elementor elements manager.
	 */
	public static function register_category( $manager ): void {
		$manager->add_category( 'kinboni', [
			'title'  => __( '★ KINBONI Pro', 'kinboni-pro' ),
			'icon'   => 'fa fa-gem',
			'active' => true,
		] );

		self::reorder_categories_to_top( $manager );
	}

	/**
	 * Prepend 'kinboni' category to the very top of Elementor's category stack.
	 *
	 * @param \Elementor\Elements_Manager|null $manager Elements manager instance.
	 */
	public static function reorder_categories_to_top( $manager = null ): void {
		if ( ! $manager && class_exists( '\Elementor\Plugin' ) && isset( \Elementor\Plugin::$instance->elements_manager ) ) {
			$manager = \Elementor\Plugin::$instance->elements_manager;
		}

		if ( ! $manager ) {
			return;
		}

		// Reorder categories array so 'kinboni' is placed at index 0 (very top).
		try {
			\Closure::bind( function() {
				if ( is_array( $this->categories ) && isset( $this->categories['kinboni'] ) ) {
					$kinboni = [ 'kinboni' => $this->categories['kinboni'] ];
					unset( $this->categories['kinboni'] );
					$this->categories = $kinboni + $this->categories;
				}
			}, $manager, $manager )->__invoke();
		} catch ( \Throwable $e ) {
			try {
				$reflection = new \ReflectionClass( $manager );
				$prop       = $reflection->getProperty( 'categories' );
				$prop->setAccessible( true );
				$categories = $prop->getValue( $manager );
				if ( is_array( $categories ) && isset( $categories['kinboni'] ) ) {
					$kinboni = [ 'kinboni' => $categories['kinboni'] ];
					unset( $categories['kinboni'] );
					$prop->setValue( $manager, $kinboni + $categories );
				}
			} catch ( \Throwable $ex ) {
				// Silent fallback
			}
		}
	}

	/**
	 * Enqueue styling for the Elementor Editor panel to visually prioritize KINBONI Pro.
	 */
	public static function enqueue_editor_styles(): void {
		$custom_css = '
			#elementor-panel-category-kinboni {
				order: -9999 !important;
			}
			#elementor-panel-category-kinboni .elementor-panel-category-title,
			.elementor-panel-category[data-category="kinboni"] .elementor-panel-category-title {
				color: #c5a059 !important;
				font-weight: 700 !important;
				letter-spacing: 0.05em !important;
			}
			#elementor-panel-category-kinboni:before {
				content: "";
				position: absolute;
				left: 0;
				top: 0;
				bottom: 0;
				width: 4px;
				background: linear-gradient(180deg, #d4af37, #aa7c11);
			}
		';
		wp_add_inline_style( 'elementor-editor', $custom_css );
	}

	/**
	 * Enqueue script for Elementor Editor to guarantee the KINBONI category is at the top of the DOM.
	 */
	public static function enqueue_editor_scripts(): void {
		$custom_js = '
		(function($) {
			function promoteKinboniCategory() {
				var $kinboni = $("#elementor-panel-category-kinboni");
				var $categories = $("#elementor-panel-categories");
				if ($kinboni.length && $categories.length) {
					if ($categories.children().first().attr("id") !== "elementor-panel-category-kinboni") {
						$categories.prepend($kinboni);
					}
				}
			}
			$(window).on("elementor:init", function() {
				if (window.elementor) {
					elementor.on("panel:init", function() {
						setTimeout(promoteKinboniCategory, 100);
						setTimeout(promoteKinboniCategory, 500);
						setTimeout(promoteKinboniCategory, 1500);
					});
				}
			});
			$(document).ready(function() {
				setInterval(promoteKinboniCategory, 2000);
			});
		})(jQuery);
		';
		wp_add_inline_script( 'elementor-editor', $custom_js );
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

		// ── Widgets ──────────────────────────────────────────
		require_once $widgets_dir . 'class-widget-header.php';
		require_once $widgets_dir . 'class-widget-hero.php';
		require_once $widgets_dir . 'class-widget-featured.php';
		require_once $widgets_dir . 'class-widget-categories.php';
		require_once $widgets_dir . 'class-widget-bestsellers.php';
		require_once $widgets_dir . 'class-widget-heritage.php';
		require_once $widgets_dir . 'class-widget-promo-banner.php';
		require_once $widgets_dir . 'class-widget-testimonials.php';
		require_once $widgets_dir . 'class-widget-newsletter.php';
		require_once $widgets_dir . 'class-widget-footer.php';

		$manager->register( new \KinboniPro\Widgets\Widget_Header() );
		$manager->register( new \KinboniPro\Widgets\Widget_Hero() );
		$manager->register( new \KinboniPro\Widgets\Widget_Featured() );
		$manager->register( new \KinboniPro\Widgets\Widget_Categories() );
		$manager->register( new \KinboniPro\Widgets\Widget_Bestsellers() );
		$manager->register( new \KinboniPro\Widgets\Widget_Heritage() );
		$manager->register( new \KinboniPro\Widgets\Widget_Promo_Banner() );
		$manager->register( new \KinboniPro\Widgets\Widget_Testimonials() );
		$manager->register( new \KinboniPro\Widgets\Widget_Newsletter() );
		$manager->register( new \KinboniPro\Widgets\Widget_Footer() );

		// Re-affirm category order after all widgets register
		self::reorder_categories_to_top();
	}
}
