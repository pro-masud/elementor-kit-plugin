<?php
class Our_Client extends \Elementor\Widget_Base {

	public function get_name() {
		return 'taxvi_our_client';
	}

	public function get_title() {
		return esc_html__( 'Taxvi Our Client', 'taxvi-pro' );
	}

	public function get_icon() {
		return 'eicon-flow';
	}

	public function get_categories() {
		return [ 'taxvi_cat' ];
	}

	public function get_keywords() {
		return [ 'taxvi', 'clinet' ];
	}

	protected function register_controls() {

		// client Tab Start
		$this->start_controls_section(
			'taxvi_client_section',
			[
				'label' => esc_html__( 'Client Images', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$clients = new \Elementor\Repeater();

		$clients->add_control(
			'taxvi_client_image',
			[
				'label' => esc_html__( 'Choose A Client Image', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'client_images',
			[
				'label' => esc_html__( 'Choose a Client Images', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $clients->get_controls(),
				'default' => [
					[
						'list_title' => esc_html__( 'Add New Image', 'taxvi-pro' ),
					]
				],
				'title_field' => '{{{ list_title }}}',
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

		// box Job desc head
		$this->add_control(
			'team_social_links',[
			'label' => esc_html( 'Button', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// job desc typography
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'team_job_desc_type',
				'selector'	=> '{{WRAPPER}} .social-link a',
				
			]
		);

		// Btn controls Tab Start
		$this->start_controls_tabs(
			'style_tabs_s'
		);

		$this-> start_controls_tab(
			'team_btn_normal',
			[
				'label' => esc_html__( 'Normal', 'taxvi-pro' ),
			]

		);

		// Button BG Color
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[	
				'label' => esc_html__( 'Background Color', 'taxvi-pro' ),
				'name' => 'normal_bg',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .client-logo-wrap img',
			]
		);

		$this->add_control(
			'team_bg_color_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		//Normal button Margin
		$this-> add_control('normal_margin',[
			'label'		=> esc_html( 'Margin', 'picchi_extrantion'),
			'type'		=> \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'	=> ['px','%','em','rem'],
			'selectors'	=> ['{{WRAPPER}} .client-logo-wrap img' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'],
		]);

		$this->add_control(
			'team_normal_padding_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		//Normal button Padding
		$this-> add_control('normal_padding',[
			'label'		=> esc_html( 'Padding', 'picchi_extrantion'),
			'type'		=> \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'	=> ['px','%','em','rem'],
			'selectors'	=> ['{{WRAPPER}} .client-logo-wrap img' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'],
		]);
		// Image border color
		$this->add_control(
			'image_border_color',
			[
				'label' => esc_html__( 'Image Border Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .client-logo-wrap img' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();



		
		// Btn Hover controls Tab Start
		$this-> start_controls_tab(
			'client_btn_hover',
			[
				'label' => esc_html__( 'Hover', 'taxvi-pro' ),
			]

		);

		// Button Hover BG Color
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[	
				'label' => esc_html__( 'Background Color', 'taxvi-pro' ),
				'name' => 'hover_bg',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .client-logo-wrap img:hover',
			]
		);

		$this->add_control(
			'team_margin_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		//Hover button Margin
		$this-> add_control('hover_margin',[
			'label'		=> esc_html( 'Margin', 'picchi_extrantion'),
			'type'		=> \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'	=> ['px','%','em','rem'],
			'selectors'	=> ['{{WRAPPER}} .client-logo-wrap img:hover' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'],
		]);

		$this->add_control(
			'hover_padding_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
		//Hover button Padding
		$this-> add_control('hover_padding',[
			'label'		=> esc_html( 'Padding', 'picchi_extrantion'),
			'type'		=> \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'	=> ['px','%','em','rem'],
			'selectors'	=> ['{{WRAPPER}} .client-logo-wrap img:hover' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'],
		]);

		// hover Image border color
		$this->add_control(
			'hover_image_border_color',
			[
				'label' => esc_html__( 'Image Border Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .client-logo-wrap img' => 'border-color: {{VALUE}}',
				],
			]
		);

		// Btn controls Tab Start
		$this->end_controls_tabs();


		// section background end
		$this->end_controls_section();

		// Style Tab End

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$client_images = $settings['client_images'];

		?>
		<!-- Client Area  -->
		<div class="clients-area section-padding">
            <div class="client-logo-wrap">
				<?php foreach($client_images as $single_client ){ ?>
                	<img src="<?php echo  esc_attr($single_client['taxvi_client_image']['url']); ?>" alt="themeforest-logo">
				<?php } ?>
            </div>
        </div>  
		<?php


	}


	protected function content_template() {

		?>	
		<!-- Client Area  -->
		<div class="clients-area section-padding">
            <div class="client-logo-wrap">
				<# _.each( settings.client_images, function( single_client ) { #>
                	<img src="{{{single_client.taxvi_client_image.url}}}" alt="themeforest-logo">
				<# }); #>    
            </div>
        </div>
               
		<?php 
	}
}
