<?php
class Pixvi_Counter extends \Elementor\Widget_Base {

	public function get_name() {
		return 'taxvi_counter';
	}

	public function get_title() {
		return esc_html__( 'Taxvi Counter', 'taxvi-pro' );
	}

	public function get_icon() {
		return 'eicon-counter-circle';
	}

	public function get_categories() {
		return [ 'taxvi_cat' ];
	}

	public function get_keywords() {
		return [ 'Counter', 'taxvi' ];
	}

	protected function register_controls() {

		// Collaboration Tab Start
		$this->start_controls_section(
			'section_collaboration',
			[
				'label' => esc_html__( 'Counter Content', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		//Collaboration Content
		$this->add_control(
			'collaboration_heading',[
			'label' => esc_html( 'Counter Info', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
			
		]);	

		// Heading Sub Title
		$this->add_control(
			'taxvi_counter_number',
			[
				'label' => esc_html__( 'Counter Number', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => esc_html__( '15', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		// Heading Sub Title
		$this->add_control(
			'taxvi_counter_types',
			[
				'label' => esc_html__( 'Counter Types', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'k+', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		// Heading Title
		$this->add_control(
			'taxvi_counter_title',
			[
				'label' => esc_html__( 'Counter Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Project Completed', 'taxvi-pro' ),
				'label_block'	=> true
			]
		);


		

	

		$this->end_controls_section();

		// Content Tab End


		// Style Tab Start
		$this->start_controls_section(
			'counter_style',
			[
				'label' => esc_html__( 'Counter Styleing', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// Counter heading
		$this->add_control(
			'counter_head',[
			'label' => esc_html( 'Number', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// Counter number Color
		$this->add_control(
			'counter_number_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .counter-number span' => 'color: {{VALUE}};',
				],
			]
		);

		// Counter type color
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'counter_number_type',
				'selector'	=> '{{WRAPPER}} .counter-number span',
				
			]
		);

		// Counter heading
		$this->add_control(
			'counter_type',[
			'label' => esc_html( 'Type Color', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
			'separator'		=> 'before'
		]);

		// Counter number Color
		$this->add_control(
			'counter_type_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .counter-number' => 'color: {{VALUE}};',
				],
			]
		);

		// Counter type color
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'counter_type_type',
				'selector'	=> '{{WRAPPER}} .counter-number',
			]
		);

		// Counter title haeding
		$this->add_control(
			'counter_title',[
			'label' => esc_html( 'Counter Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
			'separator'		=> 'before'
		]);

		// Counter number Color
		$this->add_control(
			'counter_title_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .single-counter-box h6' => 'color: {{VALUE}};',
				],
			]
		);

		// Counter type color
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'counter_title_type',
				'selector'	=> '{{WRAPPER}} .single-counter-box h6',
			]
		);

		

		

		
		

		// section background end
		$this->end_controls_section();

		// Style Tab End

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$taxvi_counter_number = $settings['taxvi_counter_number'];
		$taxvi_counter_types = $settings['taxvi_counter_types'];
		$taxvi_counter_title = $settings['taxvi_counter_title'];

		?>
			<div class="single-counter-box">
				<p class="counter-number"><span><?php echo esc_html($taxvi_counter_number); ?></span><?php echo esc_html($taxvi_counter_types); ?></p>
				<h6><?php echo esc_html($taxvi_counter_title); ?></h6>
			</div>   
		<?php


	}


	protected function content_template() {

		?>	
			<div class="single-counter-box">
				<p class="counter-number"><span>{{settings.taxvi_counter_number}}</span>{{settings.taxvi_counter_types}}</p>
				<h6>{{settings.taxvi_counter_title}}</h6>
			</div>
               
		<?php 
	}
}
