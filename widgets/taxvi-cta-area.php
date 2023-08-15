<?php
class Pixvi_CTA_Area extends \Elementor\Widget_Base {

	public function get_name() {
		return 'cta_area_two';
	}

	public function get_title() {
		return esc_html__( 'CTA Area One', 'taxvi-pro' );
	}

	public function get_icon() {
		return 'eicon-text-area';
	}

	public function get_categories() {
		return [ 'taxvi_cat' ];
	}

	public function get_keywords() {
		return [ 'CTA', 'area','one' ];
	}

	protected function register_controls() {

		// Content Tab Start
		$this->start_controls_section(
			'section_title',
			[
				'label' => esc_html__( 'Taxvi CTA', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		//Header Content
		$this->add_control(
			'heading',[
			'label' => esc_html( 'CTA Content', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
			
		]);

		$this->add_control(
			'lsection_bg_image',[
			'label' => esc_html( 'Section Background Image', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
			
		]);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'bg_image',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .cta-two',
			]
		);		

		// Text One
		$this->add_control(
			'text_one',
			[
				'label' => esc_html__( 'Text One', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( '1K+ Satisfied Clients', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		// Text Two
		$this->add_control(
			'text_two',
			[
				'label' => esc_html__( 'Text Two', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( '120+EXPERT TEAM', 'taxvi-pro' ),
				'label_block'		=> true,
				'separator'	=> 'after'
			]
		);

		$this->end_controls_section();

		// Content Tab End


		// Style Tab Start
		$this->start_controls_section(
			'section_bg_style',
			[
				'label' => esc_html__( 'CTA Area Style', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		//Section Background
		$this->add_control(
			'left_sub_color',[
			'label' => esc_html( 'Left Side Text', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
			
		]);

		$this->add_control(
			'text_one_color_one',
			[
				'label' => esc_html__( 'Color One', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .text-left h2.text-white ' => '-webkit-text-stroke: {{{.5px}}} {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'text_one_color_two',
			[
				'label' => esc_html__( 'Color One', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .text-left h2.text-white ' => '-webkit-text-fill-color: {{VALUE}};',
				],
			]
		);

		//Text One Typography
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'left_type',
				'selector'	=> '{{WRAPPER}} .text-left h2.text-white',
				'separator'	=> 'after'
			]
		);

		//Section Headeing
		$this->add_control(
			'right_side_section',[
			'label' => esc_html( 'Right Side Text', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
			'separator'	=> 'before'
		]);

		$this->add_control(
			'text_two_color_one',
			[
				'label' => esc_html__( 'Color Two', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .text-right h2.text-white ' => '-webkit-text-stroke: {{{.5px}}} {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'text_two_color_two',
			[
				'label' => esc_html__( 'Color Two', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .text-right h2.text-white ' => '-webkit-text-fill-color: {{VALUE}};',
				],
			]
		);

		//Sub Title Typography
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'right_type',
				'selector'	=> '{{WRAPPER}} .text-right h2.text-white',
				'separator'	=> 'after'
			]
		);

		// section background end
		$this->end_controls_section();

		// Style Tab End

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$text_one = $settings['text_one'];
		$text_two = $settings['text_two'];
		?>
			<div class="cta-area cta-two">        
				<div class="cta-inner-text">
					<div class="text-left">
						<h2 class="text-white"><?php echo $text_one; ?></h2>
					</div>
					<div class="text-right">
						<h2 class="text-white"><?php echo $text_two; ?></h2>
					</div>
				</div>
			</div>
		<?php


	}


	protected function content_template() {

		?>	
		
			<div class="cta-area cta-two">        
				<div class="cta-inner-text">
					<div class="text-left">
						<h2 class="text-white">{{{settings.text_one}}}</h2>
					</div>
					<div class="text-right">
						<h2 class="text-white">{{{settings.text_two}}}</h2>
					</div>
				</div>
			</div>
		<?php 
	}
}
