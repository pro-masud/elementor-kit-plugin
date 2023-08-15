<?php
class Taxvi_Map extends \Elementor\Widget_Base {

	public function get_name() {
		return 'taxvi_map';
	}

	public function get_title() {
		return esc_html__( 'Taxvi Map', 'taxvi-pro' );
	}

	public function get_icon() {
		return 'eicon-info-box';
	}

	public function get_categories() {
		return [ 'taxvi_cat' ];
	}

	public function get_keywords() {
		return [ 'map', 'Taxvi' ];
	}

	protected function register_controls() {

	// about company Tab Start
	$this->start_controls_section(
		'taxvi_company_two_heading',
		[
			'label' => esc_html__( 'Company Top Section', 'taxvi-pro' ),
			'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
		]
	);

	//about Left heading
	$this->add_control(
		'company_two_left_heading',[
		'label' => esc_html( 'Maps Links', 'taxvi-pro'),
		'type'	=>  \Elementor\Controls_Manager::HEADING,
	]);	


	$this->add_control(
		'google_maps_links',
		[
			'label' => esc_html__( 'Google Map Links', 'taxvi-pro' ),
			'type' => \Elementor\Controls_Manager::TEXTAREA,
			'default' => esc_html__( 'https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d3690.404245521138!2d91.80989606467384!3d22.338360085303748!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sdewanhat%20near%20Chattogram!5e0!3m2!1sen!2sbd!4v1677069314806!5m2!1sen!2sbd' , 'taxvi-pro' ),
			'label_block' => true,
		]
	);



	$this->end_controls_section();





	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$google_maps_links  = $settings['google_maps_links'];

		?>

			<div class="contact-page google-map">
				<iframe src="<?php echo esc_attr($google_maps_links); ?>" width="600" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
			</div>
			
		<?php


	}


}
