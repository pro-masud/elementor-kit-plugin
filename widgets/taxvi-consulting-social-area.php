<?php
class Consulting_Social extends \Elementor\Widget_Base {

	public function get_name() {
		return 'taxvi_consulting_social';
	}

	public function get_title() {
		return esc_html__( 'Consulting Social Area', 'taxvi-pro' );
	}

	public function get_icon() {
		return 'eicon-kit-details';
	}

	public function get_categories() {
		return [ 'taxvi_cat' ];
	}

	public function get_keywords() {
		return [ 'consulting', 'social', 'area' ];
	}

	protected function register_controls() {

		// contact us Tab Start
		$this->start_controls_section(
			'consulting_social_us',
			[
				'label' => esc_html__( 'Social Area', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'consulting_social_heading_main',[
			'label' => esc_html( 'Left Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
			
		]);		
		
		$this->add_control(
			'social_title',
			[
				'label' => esc_html__( 'Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Tax Advisor & Financial Consulting' , 'taxvi-pro' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'social_title_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);


		// Team Repeater Section Here now
		$social_links = new \Elementor\Repeater();

		
		$social_links->add_control(
			'social_name',
			[
				'label' => esc_html__( 'Social Name', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Facebook' , 'taxvi-pro' ),
				'label_block' => true,
			]
		);

		$social_links->add_control(
			'social_link',
			[
				'label' => esc_html__( 'Social Link', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'taxvi-pro' ),
				'options' => [ 'url' ],
				'default' => [
					'url' => '#',
				],
				'label_block' => true,
			]
		);


		$this->add_control(
			'our_social_links',
			[
				'label' => esc_html__( 'Add a Social Links', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $social_links->get_controls(),
				'default' => [
					[
						'social_name' => esc_html__( 'Facebook', 'taxvi-pro' ),
					],
				],
				'title_field' => '{{{ social_name }}}',
			]
		);

		$this->end_controls_section();


		// Style Tab Start
		$this->start_controls_section(
			'social_heading_style',
			[
				'label' => esc_html__( 'Social Area Style', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// title heading
		$this->add_control(
			'heading_style',[
			'label' => esc_html( 'Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,			
		]);

		//Title Color
		$this->add_control(
			'social_title_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .consulting-heading h6 ' => 'color:{{VALUE}}',
				],
			]
		);

		
		// Title Typography
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'social_title_type',
				'selector'	=> '{{WRAPPER}} .consulting-heading h6 ',
				'separator'	=> 'after'
			]
		);


		$this->add_control(
			'social_title_color_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);


		$this->add_control(
			'heading_social_text_style',[
			'label' => esc_html( 'Social Text', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,			
		]);

		//Title Color
		$this->add_control(
			'_title_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .social-link a' => 'color:{{VALUE}}',
				],
			]
		);

		
		// Title Typography
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'coll_title_type',
				'selector'	=> '{{WRAPPER}} .social-link a ',
				'separator'	=> 'after'
			]
		);



		$this->end_controls_section();

		$this->start_controls_section(
			'social_heading_bg_style',
			[
				'label' => esc_html__( 'Social Section', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		
		$this->add_control(
			'heading_social_bg_style',[
			'label' => esc_html( 'Background', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,			
		]);


		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[	
				'label' => esc_html__( 'Background Color', 'taxvi-pro' ),
				'name' => 'consulting_social_bg',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .dark-green-bg',
			]
		);
		

		// section background end
		$this->end_controls_section();

		// Style Tab End

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$social_title = $settings['social_title'];
		$our_social_links = $settings['our_social_links'];

		?>	
			<div class="consulting_social_area yellow-bg">
				<div class="container">
					<div class="consulting-social-link-wrap dark-green-bg">
						<div class="consulting-heading">
							<h6><?php echo esc_html($social_title); ?> </h6>
						</div>
						<div class="social-link">
							<?php foreach( $our_social_links as $single_link ){ ?>
							<a href="<?php echo esc_attr($single_link['social_link']['url']); ?>"><?php echo esc_html($single_link['social_name']); ?></a>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>

		<?php
	}

}
