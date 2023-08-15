<?php
class Service_Two extends \Elementor\Widget_Base {

	public function get_name() {
		return 'taxvi_service_two';
	}

	public function get_title() {
		return esc_html__( 'Taxvi Service Two', 'taxvi-pro' );
	}

	public function get_icon() {
		return 'eicon-post-slider';
	}

	public function get_categories() {
		return [ 'taxvi_cat' ];
	}

	public function get_keywords() {
		return [ 'Service', 'two' ];
	}

	protected function register_controls() {

		// Collaboration Tab Start
		$this->start_controls_section(
			'section_service',
			[
				'label' => esc_html__( 'Service', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		//Collaboration Content
		$this->add_control(
			'service_heading_main',[
			'label' => esc_html( 'Service Content', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
			
		]);	

		// Sub Title
		$this->add_control(
			'service_sub_title',
			[
				'label' => esc_html__( 'Sub Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Our Services', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		// Title
		$this->add_control(
			'service_title',
			[
				'label' => esc_html__( 'Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( "We're Give A Full Service About All Your Kind Of Tax", 'taxvi-pro' ),
				'label_block'	=> true,
				'separator'	=> 'after'
			]
		);

		$this->add_control(
			'service_two_title_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);


		$service_items = new \Elementor\Repeater();

		//service Content
		$service_items->add_control(
			'service_slider',[
			'label' => esc_html( 'Service Items', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
			
		]);	

		$service_items->add_control(
			'service_item_title',
			[
				'label' => esc_html__( 'Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( '01/ Insurance Tax', 'taxvi-pro' ),
				'label_block'	=> true,
				'separator'	=> 'after'
			]
		);

		$service_items->add_control(
			'service_item_desc',
			[
				'label' => esc_html__( 'Description', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'There are many variations of passages of Lorem Ipsum available, but the majority ', 'taxvi-pro' ),
				'label_block'	=> true,
				'separator'	=> 'after'
			]
		);

		$service_items->add_control(
			'service_img',
			[
				'label' => esc_html__( 'Choose Image Image', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
		
		$service_items->add_control(
			'service_item_url',
			[
				'label' => esc_html__( 'Button Link', 'taxvi-pro' ),
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
			'service_repeater',
			[
				'label' => esc_html__( 'Add A Services', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $service_items->get_controls(),
				'default' => [
					[
						'service_item_title' => esc_html__( 'Add New Service', 'taxvi-pro' ),
					],
				],
				'title_field' => '{{{ service_item_title }}}',
			]
		);

		$this->add_control(
			'service_two_items_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		// Button Text
		$this->add_control(
			'service_btn_text',
			[
				'label' => esc_html__( 'Button Text', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'View All Services', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);
		// Button URL
		$this->add_control(
			'service_btn_url',
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

		// Style Tab Start
		$this->start_controls_section(
			'service_heading_style',
			[
				'label' => esc_html__( 'Service Style', 'taxvi-pro' ),
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
			'service_sub_color',
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
				'name'		=> 'service_sub_type',
				'selector'	=> '{{WRAPPER}} .section-title p ',
			]
		);

		// Divider Color
		$this->add_control(
			'service_divider_color',
			[
				'label' => esc_html__( 'Divider Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .section-title p::before' => 'background-color: {{VALUE}};',
				],
				'separator'	=> 'after'
			]
		);

		$this->add_control(
			'service_sub_title_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
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
			'service_title_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .section-title h2 ' => 'color:{{VALUE}}',
				],
			]
		);

		
	
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'service_title_type',
				'selector'	=> '{{WRAPPER}} .section-title h2 ',
				'separator'	=> 'after'
			]
		);


		$this->add_control(
			'service_title_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);


		
		$this->add_control(
			'service_items_style',[
			'label' => esc_html( 'Service Item Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,			
		]);

		
		$this->start_controls_tabs(
			'service_tabs_s'
		);

		$this-> start_controls_tab(
			'service_item_normal',
			[
				'label' => esc_html__( 'Normal', 'taxvi-pro' ),
			]

		);

		
		$this->add_control(
			'service_item_normal_color',
			[
				'label' => esc_html__( 'Title Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .single-service-inner h5 a' => 'color:{{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();


		// Btn Hover controls Tab Start
		$this-> start_controls_tab(
			'service_item_hover',
			[
				'label' => esc_html__( 'Hover', 'taxvi-pro' ),
			]

		);

		//Hover Title Color
		$this->add_control(
			'service_hover_color',
			[
				'label' => esc_html__( 'Title Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .single-service-inner:hover h5 a ' => 'color:{{VALUE}}',
				],
			]
		);


		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'service_item_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);


		$this->add_control(
			'heading_desc_style',[
			'label' => esc_html( 'Service Description', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,			
		]);

		//Title Color
		$this->add_control(
			'service_desc_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .single-service-inner p ' => 'color:{{VALUE}}',
				],
			]
		);

		
	
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'service_desc_type',
				'selector'	=> '{{WRAPPER}} .single-service-inner p ',
				'separator'	=> 'after'
			]
		);

		$this->add_control(
			'service_border_color',
			[
				'label' => esc_html__( 'Border Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .single-service-inner ' => 'border-color:{{VALUE}}',
				],
			]
		);

		$this->add_control(
			'service_desc_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);


		// Button 
		$this->add_control(
			'service_icons_style',[
			'label' => esc_html( 'Service Item Icon', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,			
		]);

		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'service_icon_size_style',
				'selector'	=> '{{WRAPPER}} .single-service-inner .details-link i::before',
				
				
			]
		);

		// Btn Normal controls Tab Start
		$this->start_controls_tabs(
			'service_icon_tabs_s'
		);

		$this-> start_controls_tab(
			'service_icon_normal',
			[
				'label' => esc_html__( 'Normal', 'taxvi-pro' ),
			]

		);

		//Title Color
		$this->add_control(
			'service_icon_normal_color',
			[
				'label' => esc_html__( 'Icon Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .single-service-inner .details-link i' => 'color:{{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'service_icon_bg_normal_color',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .single-service-inner .details-link',
			]
		);

		$this->end_controls_tab();


		// Btn Hover controls Tab Start
		$this-> start_controls_tab(
			'service_icon_hover',
			[
				'label' => esc_html__( 'Hover', 'taxvi-pro' ),
			]

		);

		//Hover Title Color
		$this->add_control(
			'service_icon_hover_color',
			[
				'label' => esc_html__( 'Icon Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .single-service-inner:hover .details-link i ' => 'color:{{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'service_icon_hober_bg_normal_color',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .single-service-inner:hover .details-link',
			]
		);



		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'service_icon_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
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
				'name'		=> 'service_btn_type',
				'selector'	=> '{{WRAPPER}} .main-btn ',
			]
		);

		// Btn Normal controls Tab Start
		$this->start_controls_tabs(
			'style_tabs_s'
		);

		$this-> start_controls_tab(
			'service_btn_normal',
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

		$this->end_controls_tab();


		// Btn Hover controls Tab Start
		$this-> start_controls_tab(
			'service_btn_hover',
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



		$this->end_controls_tab();

		$this->end_controls_tabs();

		// section background end
		$this->end_controls_section();

		$this->start_controls_section(
			'service_section_style',
			[
				'label' => esc_html__( 'Service Section', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// sub title heading
		$this->add_control(
			'service_section_head',[
			'label' => esc_html( 'Background', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
			
			
		]);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[	
				'label' => esc_html__( 'Background Color', 'taxvi-pro' ),
				'name' => 'section_bg_style',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .service-two',
			]
		);

		$this->end_controls_section();



	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$service_sub_title = $settings['service_sub_title'];
		$service_title = $settings['service_title'];
		$service_repeater = $settings['service_repeater'];


		$service_btn_text = $settings['service_btn_text'];
		$service_btn_url = $settings['service_btn_url']['url'];


		?>
				
	<div class="service-section service-two section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-8 text-center">
                    <div class="section-title">
                        <p><?php echo esc_html($service_sub_title ); ?></p>
                        <h2><?php echo esc_html($service_title ); ?></h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
					<?php foreach($service_repeater as $single_service){ ?>
                    <div class="single-service-item mt-30">
                        <div class="single-service-inner">
                            <h5><a href="<?php echo esc_url($single_service['service_item_url']['url']); ?>"><?php echo esc_html($single_service['service_item_title']); ?></a></h5>
                            <p><?php echo esc_html($single_service['service_item_desc']); ?></p>
                            <a href="<?php echo esc_url($single_service['service_item_url']['url']); ?>" class="details-link"><i class="las la-arrow-right"></i></a>
                        </div>  
                        <div class="service-img">
                            <img src="<?php echo esc_attr($single_service['service_img']['url']); ?>" alt="">
                        </div>                      
                    </div>      
					<?php } ?>             
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12 text-center mt-60">
                    <a class="main-btn" href="<?php echo esc_url($service_btn_url); ?>"><?php echo esc_html($service_btn_text ); ?></a>                   
                </div>
            </div>
        </div>
    </div>

		<?php


	}


}
