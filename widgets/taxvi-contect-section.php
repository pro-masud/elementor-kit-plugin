<?php
class Contact_Section extends \Elementor\Widget_Base {

	public function get_name() {
		return 'taxvi_contact_section';
	}

	public function get_title() {
		return esc_html__( 'Contact Two', 'taxvi-pro' );
	}

	public function get_icon() {
		return 'eicon-slider-vertical';
	}

	public function get_categories() {
		return [ 'taxvi_cat' ];
	}

	public function get_keywords() {
		return [ 'contact', 'section','taxvi' ];
	}

	protected function register_controls() {

		
		$this->start_controls_section(
			'contact_two_heading',
			[
				'label' => esc_html__( 'Project Content', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);


		$this->add_control(
			'contact_two_title_one',
			[
				'label' => esc_html__( 'Title One', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'New to tax advisor services', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		$this->add_control(
			'contact_two_icon',
			[
				'label' => esc_html__( 'Icon', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-phone-alt',
					'library' => 'fa-solid',
				],
				'recommended' => [
					'fa-solid' => [
						'circle',
						'dot-circle',
						'square-full',
					],
					'fa-regular' => [
						'circle',
						'dot-circle',
						'square-full',
					],
				],
			]
		);


		
		$this->add_control(
			'contact_two_title_two',
			[
				'label' => esc_html__( 'Title Two', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Talk to our expert +1 (234) 567 890', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);
		
		$this->end_controls_section();



		
		$this->start_controls_section(
			'contact_two_heading_style',
			[
				'label' => esc_html__( 'Contact Style', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		
		$this->add_control(
			'contact_two_title_one_haed',[
			'label' => esc_html( 'Title One', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		
		$this->add_control(
			'contact_two_title_one_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .text-left h3' => 'color: {{VALUE}}',
				],
			]
		);


		
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'contact_two_title_one_type',
				'selector'	=> '{{WRAPPER}} .text-left h3',
				
				
			]
		);


		$this->add_control(
			'contact_two_title_one_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'contact_two_icon_haed',[
			'label' => esc_html( 'Icon', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		$this->add_control(
			'contact_two_icon_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .contact-icon i' => 'color: {{VALUE}}',
				],
			]
		);

		
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'contact_two_icon_type',
				'selector'	=> '{{WRAPPER}} .contact-icon i',
				
				
			]
		);

		$this->add_control(
			'contact_two_icon_bg_haed',[
			'label' => esc_html( 'Background', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'icons_bg',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .contact-icon',
			]
		);

		$this->add_control(
			'contact_two_icon
			_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'contact_two_title_two_haed',[
			'label' => esc_html( 'Title Two', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		$this->add_control(
			'contact_two_title_two_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .text-right h3' => 'color: {{VALUE}}',
				],
			]
		);


		
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'contact_two_title_two_type',
				'selector'	=> '{{WRAPPER}} .text-right h3',
				
				
			]
		);


	

		$this->end_controls_section();


		$this->start_controls_section(
			'contact_two_section_style',
			[
				'label' => esc_html__( 'Contact Section', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_control(
			'contact_two_section_haed',[
			'label' => esc_html( 'Background', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);


		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'contact_two_section',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .green-bg',
			]
		);


		$this->end_controls_section();

		

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		// main case study content
		$contact_two_title_one = $settings['contact_two_title_one'];
		$contact_two_icon = $settings['contact_two_icon'];
		$contact_two_title_two = $settings['contact_two_title_two'];


		?>


				<div class="contact-section contact-two">
					<div class="container">
						<div class="contact-innner green-bg d-flex align-items-center justify-content-center">
							<div class="text-left">
								<h3><?php echo esc_html($contact_two_title_one); ?></h3>
							</div>
							<div class="contact-icon">
								<?php \Elementor\Icons_Manager::render_icon( $contact_two_icon, [ 'aria-hidden' => 'true' ] ); ?>
							</div>
							<div class="text-right">
								<h3><?php echo esc_html($contact_two_title_two); ?></h3>
							</div>
						</div>
					</div>
				</div>
		<?php


	}
	
}
