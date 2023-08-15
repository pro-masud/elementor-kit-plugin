<?php
class Pixvi_Collaboration extends \Elementor\Widget_Base {

	public function get_name() {
		return 'taxvi_collaboration';
	}

	public function get_title() {
		return esc_html__( 'Taxvi Collaboration', 'taxvi-pro' );
	}

	public function get_icon() {
		return 'eicon-post-slider';
	}

	public function get_categories() {
		return [ 'taxvi_cat' ];
	}

	public function get_keywords() {
		return [ 'Collaboration', 'section' ];
	}

	protected function register_controls() {

		// Collaboration Tab Start
		$this->start_controls_section(
			'section_collaboration',
			[
				'label' => esc_html__( 'Collaboration Heading', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		//Collaboration Content
		$this->add_control(
			'collaboration_heading_main',[
			'label' => esc_html( 'Header Content', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
			
		]);	

		// Sub Title
		$this->add_control(
			'coll_sub_title',
			[
				'label' => esc_html__( 'Sub Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( "Let's Collaboration", 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		// Title
		$this->add_control(
			'coll_title',
			[
				'label' => esc_html__( 'Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( "This Could Be The Start Of Something Special Let's Work Together!", 'taxvi-pro' ),
				'label_block'		=> true,
				'separator'	=> 'after'
			]
		);

		// Button Text
		$this->add_control(
			'coll_btn_text',
			[
				'label' => esc_html__( 'Button Text', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Get In Touch', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);
		// Button URL
		$this->add_control(
			'coll_btn_url',
			[
				'label' => esc_html__( 'Button URL', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'taxvi-pro' ),
				'options' => [ 'url' ],
				'default' => [
					'url' => '#',
				],
				'label_block' => true,
			]
		);

		$this->end_controls_section();

		// Content Tab Start
		$this->start_controls_section(
			'collaboration_slider',
			[
				'label' => esc_html__( 'Collaboration Slider', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$coll_slider_repeater = new \Elementor\Repeater();

		//Collaboration Content
		$coll_slider_repeater->add_control(
			'coll_slider',[
			'label' => esc_html( 'Collaboration Slider', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
			
		]);	

		$coll_slider_repeater->add_control(
			'repeater_img',
			[
				'label' => esc_html__( 'Choose Slider Image', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
		$coll_slider_repeater->add_control(
			'rep_insta_url',
			[
				'label' => esc_html__( 'Instagram Link', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'taxvi-pro' ),
				'options' => [ 'url' ],
				'default' => [
					'url' => '',
				],
				'label_block' => true,
			]
		);

		$this->add_control(
			'coll_repeater',
			[
				'label' => esc_html__( 'Add A Collaboration Slider', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $coll_slider_repeater->get_controls(),
				'default' => [
					[
						'coll_slider' => esc_html__( 'Add Slider', 'taxvi-pro' ),
						'list_content' => esc_html__( 'Item content. Click the edit button to change this text.', 'taxvi-pro' ),
					],
				],
				'title_field' => '{{{ coll_slider }}}',
			]
		);

		$this->end_controls_section();


		
		$this->start_controls_section(
			'coll_section_head',
			[
				'label' => esc_html__( 'Collaboration Section', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'coll_section_bg',[
			'label' => esc_html( 'Background Image', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,			
		]);


		$this->add_control(
			'coll_section_bg_img',
			[
				'label' => esc_html__( 'Choose a Background Image', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => '',
				],
			]
		);

		

		$this->end_controls_section();



		// Style Tab Start
		$this->start_controls_section(
			'coll_heading_style',
			[
				'label' => esc_html__( 'Collaboration Heading Style', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// sub title heading
		$this->add_control(
			'heading_con',[
			'label' => esc_html( 'Sub Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
			
			
		]);

		//Sub Title Color
		$this->add_control(
			'coll_sub_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .section-title p ' => 'color:{{VALUE}}',
				],
			]
		);

		
		//Sub Title Typography
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'coll_sub_type',
				'selector'	=> '{{WRAPPER}} .section-title p ',
			]
		);

		// Divider Color
		$this->add_control(
			'coll_divider_color',
			[
				'label' => esc_html__( 'Divider Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .section-title p::before' => 'background-color: {{VALUE}};',
				],
				'separator'	=> 'after'
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
			'coll_title_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .section-title h2 ' => 'color:{{VALUE}}',
				],
			]
		);

		
		// Title Typography
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'coll_title_type',
				'selector'	=> '{{WRAPPER}} .section-title h2 ',
				'separator'	=> 'after'
			]
		);

		// Button 
		$this->add_control(
			'heading_btn',[
			'label' => esc_html( 'Button', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,			
		]);

		// Button Typography
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'coll_btn_type',
				'selector'	=> '{{WRAPPER}} .main-btn ',
			]
		);

		// Btn Normal controls Tab Start
		$this->start_controls_tabs(
			'style_tabs_s'
		);

		$this-> start_controls_tab(
			'coll_btn_normal',
			[
				'label' => esc_html__( 'Normal', 'taxvi-pro' ),
			]

		);

		//Title Color
		$this->add_control(
			'title_normal_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .main-btn ' => 'color:{{VALUE}}',
				],
			]
		);

		// Button BG Color
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[	
				'label' => esc_html__( 'Background Color', 'taxvi-pro' ),
				'name' => 'normal_bg',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .main-btn',
			]
		);

		//Normal button Margin
		$this-> add_control('normal_margin',[
			'label'		=> esc_html( 'Margin', 'taxvi-pro'),
			'type'		=> \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'	=> ['px','%','em','rem'],
			'selectors'	=> ['{{WRAPPER}} .main-btn' => 'margin:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'],
		]);

		//Normal button Padding
		$this-> add_control('normal_padding',[
			'label'		=> esc_html( 'Padding', 'taxvi-pro'),
			'type'		=> \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'	=> ['px','%','em','rem'],
			'selectors'	=> ['{{WRAPPER}} .main-btn' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'],
		]);

		//Normal button Padding
		$this-> add_control('normal_border_radius',[
			'label'		=> esc_html( 'Border Radius', 'taxvi-pro'),
			'type'		=> \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'	=> ['px','%','em','rem'],
			'selectors'	=> ['{{WRAPPER}} .main-btn' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'],
		]);

		$this->end_controls_tab();


		// Btn Hover controls Tab Start
		$this-> start_controls_tab(
			'coll_btn_hover',
			[
				'label' => esc_html__( 'Hover', 'taxvi-pro' ),
			]

		);

		//Hover Title Color
		$this->add_control(
			'title_hover_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .main-btn:hover ' => 'color:{{VALUE}}',
				],
			]
		);
		// Button Hover BG Color
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[	
				'label' => esc_html__( 'Background Color', 'taxvi-pro' ),
				'name' => 'hover_bg',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .main-btn:hover',
			]
		);

		//Hover button Margin
		$this-> add_control('hover_margin',[
			'label'		=> esc_html( 'Margin', 'taxvi-pro'),
			'type'		=> \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'	=> ['px','%','em','rem'],
			'selectors'	=> ['{{WRAPPER}} .main-btn:hover' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'],
		]);

		//Hover button Padding
		$this-> add_control('hover_padding',[
			'label'		=> esc_html( 'Padding', 'taxvi-pro'),
			'type'		=> \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'	=> ['px','%','em','rem'],
			'selectors'	=> ['{{WRAPPER}} .main-btn:hover' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'],
		]);

		//Hover button Padding
		$this-> add_control('hover_border_radius',[
			'label'		=> esc_html( 'Border Radius', 'taxvi-pro'),
			'type'		=> \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'	=> ['px','%','em','rem'],
			'selectors'	=> ['{{WRAPPER}} .main-btn:hover' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'],
		]);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		// section background end
		$this->end_controls_section();

		// Style slider Start
		$this->start_controls_section(
			'coll_slider_style',
			[
				'label' => esc_html__( 'Collaboration Slider Style', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// Button 
		$this->add_control(
			'slider_btn',[
			'label' => esc_html( 'Button', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,			
		]);

		// Button Typography
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'slider_btn_type',
				'selector'	=> '{{WRAPPER}} .instagram-item a::before ',
			]
		);

		// Btn Normal controls Tab Start
		$this->start_controls_tabs(
			'slider_style_s'
		);

		$this-> start_controls_tab(
			'btn_normal',
			[
				'label' => esc_html__( 'Normal', 'taxvi-pro' ),
			]

		);

		//Title Color
		$this->add_control(
			'slider_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .instagram-item a::before ' => 'color:{{VALUE}}',
				],
			]
		);

		// Button BG Color
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[	
				'label' => esc_html__( 'Background Color', 'taxvi-pro' ),
				'name' => 'normal_slider_btn_bg',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .instagram-item a::before',
			]
		);

		//Normal button Margin
		$this-> add_control('normal_slider_margin',[
			'label'		=> esc_html( 'Margin', 'taxvi-pro'),
			'type'		=> \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'	=> ['px','%','em','rem'],
			'selectors'	=> ['{{WRAPPER}} .instagram-item a::before' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'],
		]);

		//Normal button Padding
		$this-> add_control('normal_padding_padding',[
			'label'		=> esc_html( 'Padding', 'taxvi-pro'),
			'type'		=> \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'	=> ['px','%','em','rem'],
			'selectors'	=> ['{{WRAPPER}} .instagram-item a::before' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'],
		]);

		//Normal button Padding
		$this-> add_control('normal_slider_border_radius',[
			'label'		=> esc_html( 'Border Radius', 'taxvi-pro'),
			'type'		=> \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'	=> ['px','%','em','rem'],
			'selectors'	=> ['{{WRAPPER}} .instagram-item a::before' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'],
		]);

		$this->end_controls_tab();


		// Btn Hover controls Tab Start
		$this-> start_controls_tab(
			'slider_btn_hover',
			[
				'label' => esc_html__( 'Hover', 'taxvi-pro' ),
			]

		);

		//Hover Btn Color
		$this->add_control(
			'btn_hover_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .instagram-item a::before:hover ' => 'color:{{VALUE}}',
				],
			]
		);
		// Button Hover BG Color
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[	
				'label' => esc_html__( 'Background Color', 'taxvi-pro' ),
				'name' => 'hover_slider_bg',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .instagram-item a::before:hover',
			]
		);

		//Hover button Margin
		$this-> add_control('hover_slider_margin',[
			'label'		=> esc_html( 'Margin', 'taxvi-pro'),
			'type'		=> \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'	=> ['px','%','em','rem'],
			'selectors'	=> ['{{WRAPPER}} .instagram-item a::before:hover' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'],
		]);

		//Hover button Padding
		$this-> add_control('hover_slider_padding',[
			'label'		=> esc_html( 'Padding', 'taxvi-pro'),
			'type'		=> \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'	=> ['px','%','em','rem'],
			'selectors'	=> ['{{WRAPPER}} .instagram-item a::before:hover' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'],
		]);

		//Hover button Padding
		$this-> add_control('hover_slider_border_radius',[
			'label'		=> esc_html( 'Border Radius', 'taxvi-pro'),
			'type'		=> \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'	=> ['px','%','em','rem'],
			'selectors'	=> ['{{WRAPPER}} .instagram-item a::before:hover' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'],
		]);

		$this->end_controls_tab();

		$this->end_controls_tabs();
		


		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		// $bg_image = $settings['bg_image']['url'];
		$coll_sub_title = $settings['coll_sub_title'];
		$coll_title = $settings['coll_title'];
		$coll_btn_text = $settings['coll_btn_text'];
		$coll_btn_url = $settings['coll_btn_url'];

		// slider repeater
		$coll_repeater = $settings['coll_repeater'];

		// background image
		$coll_section_bg_img = $settings['coll_section_bg_img']['url'];

		?>
				
			 <div class="collaboration-section section-padding">
				<div class="container">
					<div class="row">
						<div class="offset-xl-1 col-xl-10 offset-lg-1 col-lg-10 text-center">
							<div class="section-title">
								<p><?php echo esc_html($coll_sub_title); ?></p>
								<h2><?php echo esc_html($coll_title); ?></h2>
							</div>
							<a href="<?php echo esc_url($coll_btn_url['url']); ?>" class="main-btn"><?php echo esc_html($coll_btn_text); ?></a>
						</div>
					</div>
					<div class="row">
						<?php if($coll_repeater){ ?>
						<div class="instragram-wrapper mt-60">
							<div class="instragram-inner owl-carousel">
								<?php foreach($coll_repeater as $single_item){ ?>
									<div class="instagram-item">
										<a class="insta_btn" href="<?php echo $single_item['rep_insta_url']['url']; ?>">
											<img src="<?php echo esc_attr($single_item['repeater_img']['url']); ?>" alt="">
										</a>
									</div>
								<?php } ?>                  
							</div>
						</div>
						<?php } ?>
					</div>            
				</div> 
				<?php if($coll_section_bg_img){ ?>
					<div class="instagram-shape">
						<img src="<?php echo esc_attr($coll_section_bg_img ); ?>" alt="">
					</div>  
				<?php } ?>   
			</div>
		<?php


	}


	protected function content_template() {

		?>	
			 <div class="collaboration-section section-padding">
				<div class="container">
					<div class="row">
						<div class="offset-xl-1 col-xl-10 offset-lg-1 col-lg-10 text-center">
							<div class="section-title">
								<p>{{{settings.coll_sub_title}}}</p>
								<h2>{{{settings.coll_title}}}</h2>
							</div>
							<a href="{{{settings.coll_btn_url.url}}}" class="main-btn">{{{settings.coll_btn_text}}}</a>
						</div>
					</div>
					<div class="row">
					<# if ( settings.coll_repeater.length ) { #>
						<div class="instragram-wrapper mt-60">
							<div class="instragram-inner owl-carousel">
							<# _.each( settings.coll_repeater, function( single_item ) { #>
								<div class="instagram-item">
									<a href="{{{single_item.rep_insta_url.url}}}">
										
										<img src="{{{single_item.repeater_img.url}}}" alt="">
									</a>
								</div> 
							<# }); #>             
							</div>
						</div>
					<#	} #>
					</div>          
				</div>  
				<div class="instagram-shape">
					<img src="{{{settings.coll_section_bg_img.url}}}" alt="">
				</div>   
			</div>
		<?php 
	}
}
