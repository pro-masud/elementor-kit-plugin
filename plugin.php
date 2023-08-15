<?php
namespace Elementor_Test_Addon;
/**
 * Class Plugin
 *
 * Main Plugin class
 * @since 1.2.0
 */
class Plugin {

	/**
	 * Instance
	 *
	 * @since 1.2.0
	 * @access private
	 * @static
	 *
	 * @var Plugin The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.2.0
	 * @access public
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * widget_scripts
	 *
	 * Load required plugin core files.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function widget_scripts() {
		wp_register_script( 'elementor-hello-world', plugins_url( '/assets/js/hello-world.js', __FILE__ ), [ 'jquery' ], false, true );
	}

	/**
	 * Editor scripts
	 *
	 * Enqueue plugin javascripts integrations for Elementor editor.
	 *
	 * @since 1.2.1
	 * @access public
	 */
	public function editor_scripts() {
		add_filter( 'script_loader_tag', [ $this, 'editor_scripts_as_a_module' ], 10, 2 );

		wp_enqueue_script(
			'elementor-hello-world-editor',
			plugins_url( '/assets/js/editor/editor.js', __FILE__ ),
			[
				'elementor-editor',
			],
			'1.2.1',
			true
		);
	}

	/**
	 * Force load editor script as a module
	 *
	 * @since 1.2.1
	 *
	 * @param string $tag
	 * @param string $handle
	 *
	 * @return string
	 */
	public function editor_scripts_as_a_module( $tag, $handle ) {
		if ( 'elementor-hello-world-editor' === $handle ) {
			$tag = str_replace( '<script', '<script type="module"', $tag );
		}

		return $tag;
	}

	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 1.2.0
	 * @access public
	 *
	 * @param Widgets_Manager $widgets_manager Elementor widgets manager.
	 */
	public function register_widgets( $widgets_manager ) {
		require_once( __DIR__ . '/widgets/taxvi-header-two.php' );
		require_once( __DIR__ . '/widgets/taxvi-blog-page.php' );
		require_once( __DIR__ . '/widgets/taxvi-cta-area.php' );
		require_once( __DIR__ . '/widgets/taxvi-collaboration.php' );
		require_once( __DIR__ . '/widgets/taxvi-counter.php' );
		require_once( __DIR__ . '/widgets/taxvi-our-team.php' );
		require_once( __DIR__ . '/widgets/taxvi-cta-area-one.php' );
		require_once( __DIR__ . '/widgets/taxvi-our-client.php' );
		require_once( __DIR__ . '/widgets/taxvi-contact-us.php' );
		require_once( __DIR__ . '/widgets/taxvi-more-about-us.php' );
		require_once( __DIR__ . '/widgets/taxvi-testimonial.php' );
		require_once( __DIR__ . '/widgets/taxvi-about-company.php' );
		require_once( __DIR__ . '/widgets/taxvi-about-experience.php' );
		require_once( __DIR__ . '/widgets/taxvi-home-one-hero-section.php' );
		require_once( __DIR__ . '/widgets/taxvi-home-feature-box.php' );
		require_once( __DIR__ . '/widgets/taxvi-our-service.php' );
		require_once( __DIR__ . '/widgets/taxvi-our-blog-and-articles.php' );
		require_once( __DIR__ . '/widgets/taxvi-cta-area-three.php' );
		require_once( __DIR__ . '/widgets/taxvi-case-study.php' );
		require_once( __DIR__ . '/widgets/taxvi-about-faq-section.php' );
		require_once( __DIR__ . '/widgets/taxvi-testimonial-two.php' );
		require_once( __DIR__ . '/widgets/taxvi-about-company-two.php' );
		require_once( __DIR__ . '/widgets/taxvi-home-feature-box-two.php' );
		require_once( __DIR__ . '/widgets/taxvi-service-two.php' );
		require_once( __DIR__ . '/widgets/taxvi-our-project.php' );
		require_once( __DIR__ . '/widgets/taxvi-contect-section.php' );
		require_once( __DIR__ . '/widgets/taxvi-our-blog.php' );
		require_once( __DIR__ . '/widgets/taxvi-consulting-social-area.php' );
		require_once( __DIR__ . '/widgets/taxvi-process.php' );
		require_once( __DIR__ . '/widgets/taxvi-home-slider-two.php' );
		require_once( __DIR__ . '/widgets/taxvi-about-faq-section-with-contact-us.php' );
		require_once( __DIR__ . '/widgets/taxvi-faq-section.php' );
		require_once( __DIR__ . '/widgets/taxvi-priceing.php' );
		require_once( __DIR__ . '/widgets/taxvi-about-faq-two.php' );
		require_once( __DIR__ . '/widgets/taxvi-process-two.php' );
		require_once( __DIR__ . '/widgets/taxvi-address-with-contact-us.php' );
		require_once( __DIR__ . '/widgets/taxvi-map.php' );
		require_once( __DIR__ . '/widgets/taxvi-single-service.php' );
		require_once( __DIR__ . '/widgets/taxvi-choose-us.php' );
		require_once( __DIR__ . '/widgets/taxvi-single-project.php' );
		require_once( __DIR__ . '/widgets/taxvi-project-details.php' );
		

		$widgets_manager->register( new \Pixvi_Header() );
		$widgets_manager->register( new \Pixvi_Blog() );
		$widgets_manager->register( new \Pixvi_CTA_Area() );
		$widgets_manager->register( new \Pixvi_Collaboration() );
		$widgets_manager->register( new \Pixvi_Counter() );
		$widgets_manager->register( new \Pixvi_Our_Team() );
		$widgets_manager->register( new \CTA_Area_One() );
		$widgets_manager->register( new \Our_Client() );
		$widgets_manager->register( new \Contact_Us() );
		$widgets_manager->register( new \About_Us() );
		$widgets_manager->register( new \Testimonial_Section() );
		$widgets_manager->register( new \About_Company() );
		$widgets_manager->register( new \About_Experience() );
		$widgets_manager->register( new \Home_One_Hero() );
		$widgets_manager->register( new \Feature_Box() );
		$widgets_manager->register( new \Our_Service() );
		$widgets_manager->register( new \Blog_And_Articles() );
		$widgets_manager->register( new \CTA_Area_Three() );
		$widgets_manager->register( new \Case_Study() );
		$widgets_manager->register( new \About_Faq_section() );
		$widgets_manager->register( new \Testimonial_Two() );
		$widgets_manager->register( new \About_Company_Two() );
		$widgets_manager->register( new \About_Feature_Box_Two() );
		$widgets_manager->register( new \Service_Two() );
		$widgets_manager->register( new \Our_Project() );
		$widgets_manager->register( new \Contact_Section() );
		$widgets_manager->register( new \Our_Blog() );
		$widgets_manager->register( new \Consulting_Social() );
		$widgets_manager->register( new \Our_Process() );
		$widgets_manager->register( new \Home_Slider_Two() );
		$widgets_manager->register( new \Home_FAQ_And_Contact_Us() );
		$widgets_manager->register( new \Home_FAQ_Section() );
		$widgets_manager->register( new \Taxvi_Priceing() );
		$widgets_manager->register( new \Taxvi_About_FAQ_Two() );
		$widgets_manager->register( new \Taxvi_Work_Process() );
		$widgets_manager->register( new \Taxvi_Address_And_Contact_Us() );
		$widgets_manager->register( new \Taxvi_Map() );
		$widgets_manager->register( new \Taxvi_Single_Service() );
		$widgets_manager->register( new \Taxvi_Chosse_Us() );
		$widgets_manager->register( new \Taxvi_Single_Project() );
		$widgets_manager->register( new \Taxvi_Project_Details() );

		
		
	}

	// Register Categories here now
	function add_elementor_widget_categories( $elements_manager ) {

		$elements_manager->add_category(
			'taxvi_cat',
			[
				'title' => esc_html__( 'Taxvi Pro', 'textdomain' ),
				'icon' => 'fa fa-plug',
			]
		);	
	}

	/**
	 * Add page settings controls
	 *
	 * Register new settings for a document page settings.
	 *
	 * @since 1.2.1
	 * @access private
	 */
	// private function add_page_settings_controls() {
	// 	require_once( __DIR__ . '/page-settings/manager.php' );
	// 	new Page_Settings();
	// }

	/**
	 *  Plugin class constructor
	 *
	 * Register plugin action hooks and filters
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function __construct() {

		// Register widget scripts
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );

		// Register widgets
		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );

		// Register Categories 
		add_action( 'elementor/elements/categories_registered', [ $this, 'add_elementor_widget_categories' ] );

		// Register editor scripts
		add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'editor_scripts' ] );
		
		//$this->add_page_settings_controls();
	}

	
}

// Instantiate Plugin Class
Plugin::instance();
