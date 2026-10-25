<?php
/**
 * Elementor Integration — Widget category & registration.
 *
 * Configures the KINBONI Pro category to always appear at the very top of the Elementor panel,
 * with full backward and forward compatibility, fail-safe class loading, and optimized editor styling.
 *
 * @package KinboniPro
 */

defined( 'ABSPATH' ) || exit;

class Kinboni_Elementor {

	/**
	 * Track initialization to prevent duplicate hook binding.
	 *
	 * @var bool
	 */
	private static bool $initialized = false;

	/**
	 * Register hooks — called only when Elementor is loaded.
	 */
	public static function init(): void {
		if ( self::$initialized ) {
			return;
		}
		self::$initialized = true;

		// 1. Categories Registration (Priority 9999 ensures it runs after all other categories)
		add_action( 'elementor/elements/categories_registered', [ __CLASS__, 'register_category' ], 9999 );

		// 2. Widgets Registration (Modern Elementor 3.5+ and legacy fallback)
		add_action( 'elementor/widgets/register', [ __CLASS__, 'register_widgets' ] );
		add_action( 'elementor/widgets/widgets_registered', [ __CLASS__, 'register_widgets_legacy' ] );

		// 3. Editor Visual & Script Priorities
		add_action( 'elementor/editor/after_enqueue_styles', [ __CLASS__, 'enqueue_editor_styles' ] );
		add_action( 'elementor/editor/after_enqueue_scripts', [ __CLASS__, 'enqueue_editor_scripts' ] );
		add_action( 'elementor/editor/footer', [ __CLASS__, 'print_editor_fallback_script' ] );
	}

	/**
	 * Register a custom KINBONI widget category and prepend it to the very top.
	 *
	 * @param \Elementor\Elements_Manager|null $manager Elementor elements manager.
	 */
	public static function register_category( $manager = null ): void {
		if ( ! $manager && class_exists( '\Elementor\Plugin' ) && isset( \Elementor\Plugin::$instance->elements_manager ) ) {
			$manager = \Elementor\Plugin::$instance->elements_manager;
		}

		if ( ! $manager || ! method_exists( $manager, 'add_category' ) ) {
			return;
		}

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
				if ( null === $this->categories && method_exists( $this, 'get_categories' ) ) {
					$this->get_categories();
				}
				if ( is_array( $this->categories ) && isset( $this->categories['kinboni'] ) ) {
					$kinboni = [ 'kinboni' => $this->categories['kinboni'] ];
					unset( $this->categories['kinboni'] );
					$this->categories = $kinboni + $this->categories;
				}
			}, $manager, $manager )->__invoke();
		} catch ( \Throwable $e ) {
			try {
				$reflection = new \ReflectionClass( $manager );
				if ( $reflection->hasProperty( 'categories' ) ) {
					$prop = $reflection->getProperty( 'categories' );
					$prop->setAccessible( true );
					$categories = $prop->getValue( $manager );
					if ( is_array( $categories ) && isset( $categories['kinboni'] ) ) {
						$kinboni = [ 'kinboni' => $categories['kinboni'] ];
						unset( $categories['kinboni'] );
						$prop->setValue( $manager, $kinboni + $categories );
					}
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
				position: relative !important;
			}
			#elementor-panel-category-kinboni .elementor-panel-category-title,
			.elementor-panel-category[data-category="kinboni"] .elementor-panel-category-title {
				color: #c5a059 !important;
				font-weight: 700 !important;
				letter-spacing: 0.05em !important;
			}
			#elementor-panel-category-kinboni .elementor-panel-category-title:before {
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
						promoteKinboniCategory();
						setTimeout(promoteKinboniCategory, 100);
						setTimeout(promoteKinboniCategory, 500);
						setTimeout(promoteKinboniCategory, 1200);
					});
				}
			});
			$(document).ready(function() {
				var attempts = 0;
				var timer = setInterval(function() {
					promoteKinboniCategory();
					attempts++;
					if (attempts >= 10) {
						clearInterval(timer);
					}
				}, 500);
			});
		})(jQuery);
		';

		if ( wp_script_is( 'elementor-editor', 'registered' ) ) {
			wp_add_inline_script( 'elementor-editor', $custom_js );
		} elseif ( wp_script_is( 'elementor-editor-loader', 'registered' ) ) {
			wp_add_inline_script( 'elementor-editor-loader', $custom_js );
		}
	}

	/**
	 * Fallback footer script for Elementor Editor in case inline scripts are restricted.
	 */
	public static function print_editor_fallback_script(): void {
		?>
		<script>
		(function($) {
			if (!$) return;
			function ensureKinboniTop() {
				var $kinboni = $('#elementor-panel-category-kinboni');
				var $catContainer = $('#elementor-panel-categories');
				if ($kinboni.length && $catContainer.length && $catContainer.children().first().attr('id') !== 'elementor-panel-category-kinboni') {
					$catContainer.prepend($kinboni);
				}
			}
			setTimeout(ensureKinboniTop, 300);
			setTimeout(ensureKinboniTop, 1000);
		})(window.jQuery);
		</script>
		<?php
	}

	/**
	 * Legacy widgets registration fallback for Elementor < 3.5.0.
	 *
	 * @param \Elementor\Widgets_Manager $manager Widgets manager.
	 */
	public static function register_widgets_legacy( $manager ): void {
		if ( did_action( 'elementor/widgets/register' ) ) {
			return;
		}
		self::register_widgets( $manager );
	}

	/**
	 * Register all KINBONI Elementor widgets with fail-safe file and class guards.
	 *
	 * @param \Elementor\Widgets_Manager $manager Elementor widgets manager.
	 */
	public static function register_widgets( $manager ): void {

		if ( ! $manager ) {
			return;
		}

		// Guard — Elementor Widget_Base must exist.
		if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
			return;
		}

		$widgets_dir = KINBONI_DIR . 'widgets/';

		// Widget map: [ file_name => class_name ]
		$widgets = [
			'class-widget-header.php'       => '\KinboniPro\Widgets\Widget_Header',
			'class-widget-hero.php'         => '\KinboniPro\Widgets\Widget_Hero',
			'class-widget-featured.php'     => '\KinboniPro\Widgets\Widget_Featured',
			'class-widget-categories.php'   => '\KinboniPro\Widgets\Widget_Categories',
			'class-widget-bestsellers.php'  => '\KinboniPro\Widgets\Widget_Bestsellers',
			'class-widget-heritage.php'     => '\KinboniPro\Widgets\Widget_Heritage',
			'class-widget-promo-banner.php' => '\KinboniPro\Widgets\Widget_Promo_Banner',
			'class-widget-testimonials.php' => '\KinboniPro\Widgets\Widget_Testimonials',
			'class-widget-newsletter.php'   => '\KinboniPro\Widgets\Widget_Newsletter',
			'class-widget-footer.php'       => '\KinboniPro\Widgets\Widget_Footer',
		];

		$settings = class_exists( 'Kinboni_Admin' ) ? Kinboni_Admin::get_settings() : [];

		foreach ( $widgets as $file => $class_name ) {
			// Check if widget is disabled in KINBONI Dashboard
			$slug = str_replace( [ 'class-widget-', '.php' ], '', $file );
			$setting_key = 'widget_' . str_replace( '-', '_', $slug );

			if ( isset( $settings[ $setting_key ] ) && 'no' === $settings[ $setting_key ] ) {
				continue; // Disabled by site administrator
			}

			$file_path = $widgets_dir . $file;
			if ( file_exists( $file_path ) ) {
				require_once $file_path;
			}
			if ( class_exists( $class_name ) ) {
				if ( method_exists( $manager, 'register' ) ) {
					$manager->register( new $class_name() );
				} elseif ( method_exists( $manager, 'register_widget_type' ) ) {
					$manager->register_widget_type( new $class_name() );
				}
			}
		}

		// Re-affirm category order after all widgets register
		self::reorder_categories_to_top();
	}
}
