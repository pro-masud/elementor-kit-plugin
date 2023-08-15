<?php
class Taxvi_Work_Process extends \Elementor\Widget_Base {

	public function get_name() {
		return 'taxvi_process_two';
	}

	public function get_title() {
		return esc_html__( 'Taxvi Process Two', 'taxvi-pro' );
	}

	public function get_icon() {
		return 'eicon-info-box';
	}

	public function get_categories() {
		return [ 'taxvi_cat' ];
	}

	public function get_keywords() {
		return [ 'process', 'our', 'taxvi','two' ];
	}

	protected function register_controls() {

	// about company Tab Start
	$this->start_controls_section(
		'taxvi_process_section_heading',
		[
			'label' => esc_html__( 'Process Left Side', 'taxvi-pro' ),
			'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
		]
	);
	

	// about left image 
	$this->add_control(
		'process_section_feature_img_left',
		[
			'label' => esc_html__( 'Choose a Process Image', 'taxvi-pro' ),
			'type' => \Elementor\Controls_Manager::MEDIA,
			'default' => [
				'url' => \Elementor\Utils::get_placeholder_image_src(),
			],
		]
	);


	$this->end_controls_section();





	$this->start_controls_section(
		'taxvi_process_right_section_heading',
		[
			'label' => esc_html__( 'Process Right Side', 'taxvi-pro' ),
			'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
		]
	);


	//about Left heading
	$this->add_control(
		'process_section_right_heading',[
		'label' => esc_html( 'Process Right Side', 'taxvi-pro'),
		'type'	=>  \Elementor\Controls_Manager::HEADING,
	]);	

	// company two sub title
	$this->add_control(
		'process_section_sub_title',
		[
			'label' => esc_html__( 'Sub Title', 'taxvi-pro' ),
			'type' => \Elementor\Controls_Manager::TEXT,
			'default' => esc_html__( 'How We Works', 'taxvi-pro' ),
			'label_block'	=> true,
		]
	);

	// company two title
	$this->add_control(
		'process_section_title',
		[
			'label' => esc_html__( 'Title', 'taxvi-pro' ),
			'type' => \Elementor\Controls_Manager::TEXT,
			'default' => esc_html__( 'Easy Steps To Get Our Tax Services', 'taxvi-pro' ),
			'label_block'	=> true,
		]
	);


	// company two title
	$this->add_control(
		'process_section_desc',
		[
			'label' => esc_html__( 'Description', 'taxvi-pro' ),
			'type' => \Elementor\Controls_Manager::TEXTAREA,
			'default' => esc_html__( 'There are many variations of passages of Lorem Ipsum available, but the majority suffered alteration in some form, by injected humour,', 'taxvi-pro' ),
			'label_block'	=> true,
		]
	);


	$service_item = new \Elementor\Repeater();


	$service_item->add_control(
		'process_section_feature_icon',
		[
			'label' => esc_html__( 'Item Icon', 'taxvi-pro' ),
			'type' => \Elementor\Controls_Manager::ICONS,
			'default' => [
				'value' => 'far fa-star',
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

	// item title
	$service_item->add_control(
		'process_section_feature_title',
		[
			'label' => esc_html__( 'Service Title', 'taxvi-pro' ),
			'type' => \Elementor\Controls_Manager::TEXT,
			'default' => esc_html__( '01/ Choose Your Services' , 'taxvi-pro' ),
			'label_block' => true,
		]
	);

	$service_item->add_control(
		'process_section_feature_desc',
		[
			'label' => esc_html__( 'Service Description', 'taxvi-pro' ),
			'type' => \Elementor\Controls_Manager::TEXT,
			'default' => esc_html__( 'There are many variations of passages of Lorem Ipsum available, but the majority ' , 'taxvi-pro' ),
			'label_block' => true,
		]
	);

	$this->add_control(
		'process_section_feature_items',
		[
			'label' => esc_html__( 'Add A Service Items', 'taxvi-pro' ),
			'type' => \Elementor\Controls_Manager::REPEATER,
			'fields' => $service_item->get_controls(),
			'default' => [
				[
					'process_section_feature_title' => esc_html__( 'Add New Service', 'taxvi-pro' ),
				],
			],
			'title_field' => '{{{ process_section_feature_title }}}',
		]
	);	

	$this->end_controls_section();

	


	$this->start_controls_section(
		'taxvi_process_section_bg_heading',
		[
			'label' => esc_html__( 'Process Section Background', 'taxvi-pro' ),
			'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
		]
	);


	$this->add_control(
		'process_section_bg_haed',[
		'label' => esc_html( 'Background', 'taxvi-pro'),
		'type'	=>  \Elementor\Controls_Manager::HEADING,
	]);


	$this->add_group_control(
		\Elementor\Group_Control_Background::get_type(),
		[	
			'label' => esc_html__( 'Background Color', 'taxvi-pro' ),
			'name' => 'consulting_social_bg',
			'types' => [ 'classic', 'gradient', 'video' ],
			'selector' => '{{WRAPPER}} .section-padding',
		]
	);

	$this->end_controls_section();






	$this->start_controls_section(
		'right_side_heading_style',
		[
			'label' => esc_html__( 'Process Right Side Style', 'taxvi-pro' ),
			'tab' => \Elementor\Controls_Manager::TAB_STYLE,
		]
	);

	
	$this->add_control(
		'right_side_sub_title_haed',[
		'label' => esc_html( 'Sub Title', 'taxvi-pro'),
		'type'	=>  \Elementor\Controls_Manager::HEADING,
	]);

	
	$this->add_control(
		'right_side_sub_title_color',
		[
			'label' => esc_html__( 'Color', 'taxvi-pro' ),
			'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .section-title p' => 'color: {{VALUE}}',
			],
		]
	);


	// sub title type color
	$this -> add_group_control(
		\Elementor\Group_Control_Typography::get_type(),
		[
			'name'		=> 'right_side_sub_title_type',
			'selector'	=> '{{WRAPPER}} .section-title p',
			
			
		]
	);

	// cta sub divider color
	$this->add_control(
		'right_side_divider_bg_color',
		[
			'label' => esc_html__( 'Divider Color', 'taxvi-pro' ),
			'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .section-title p::before' => 'background: {{VALUE}}',
			],
		]
	);

	$this->add_control(
		'right_side_sub_title_hr',
		[
			'type' => \Elementor\Controls_Manager::DIVIDER,
		]
	);

	// cta sub head
	$this->add_control(
		'right_side_title_head',[
		'label' => esc_html( 'Title', 'taxvi-pro'),
		'type'	=>  \Elementor\Controls_Manager::HEADING,
	]);

	// cta sub title color
	$this->add_control(
		'right_side_title_main_color',
		[
			'label' => esc_html__( 'Color', 'taxvi-pro' ),
			'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .section-title h2' => 'color: {{VALUE}}',
			],
		]
	);


	
	$this -> add_group_control(
		\Elementor\Group_Control_Typography::get_type(),
		[
			'name'		=> 'right_side_title_type',
			'selector'	=> '{{WRAPPER}} .section-title h2',
			
			
		]
	);


	$this->add_control(
		'right_side_title_hr',
		[
			'type' => \Elementor\Controls_Manager::DIVIDER,
		]
	);

	
	$this->add_control(
		'right_side_desc_head',[
		'label' => esc_html( 'Description', 'taxvi-pro'),
		'type'	=>  \Elementor\Controls_Manager::HEADING,
	]);

	
	$this->add_control(
		'right_side_desc_main_color',
		[
			'label' => esc_html__( 'Color', 'taxvi-pro' ),
			'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .process-content-wrap > p' => 'color: {{VALUE}}',
			],
		]
	);


	
	$this -> add_group_control(
		\Elementor\Group_Control_Typography::get_type(),
		[
			'name'		=> 'right_side_desc_type',
			'selector'	=> '{{WRAPPER}} .process-content-wrap > p',			
		]
	);

	$this->end_controls_section();


	$this->start_controls_section(
		'processing_heading_style',
		[
			'label' => esc_html__( 'Process Service Style', 'taxvi-pro' ),
			'tab' => \Elementor\Controls_Manager::TAB_STYLE,
		]
	);

	
	$this->add_control(
		'process_title_haed',[
		'label' => esc_html( 'Title', 'taxvi-pro'),
		'type'	=>  \Elementor\Controls_Manager::HEADING,
	]);



	$this->add_control(
		'process_title_color',
		[
			'label' => esc_html__( 'Color', 'taxvi-pro' ),
			'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .process-content h4' => 'color: {{VALUE}}',
			],
		]
	);


	// cta sub title type color
	$this -> add_group_control(
		\Elementor\Group_Control_Typography::get_type(),
		[
			'name'		=> 'process_title_type',
			'selector'	=> '{{WRAPPER}} .process-content h4',			
		]
	);

	$this->add_control(
		'process_title_hr',
		[
			'type' => \Elementor\Controls_Manager::DIVIDER,
		]
	);


	$this->add_control(
		'process_desc_haed',[
		'label' => esc_html( 'Description', 'taxvi-pro'),
		'type'	=>  \Elementor\Controls_Manager::HEADING,
	]);



	$this->add_control(
		'process_desc_color',
		[
			'label' => esc_html__( 'Color', 'taxvi-pro' ),
			'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .process-content p' => 'color: {{VALUE}}',
			],
		]
	);


	// cta sub title type color
	$this -> add_group_control(
		\Elementor\Group_Control_Typography::get_type(),
		[
			'name'		=> 'process_desc_type',
			'selector'	=> '{{WRAPPER}}.process-content p',			
		]
	);


	$this->add_control(
		'process_desc_hr',
		[
			'type' => \Elementor\Controls_Manager::DIVIDER,
		]
	);


	$this->add_control(
		'our_pricess_icon_head',[
		'label' => esc_html( 'Icon', 'taxvi-pro'),
		'type'	=>  \Elementor\Controls_Manager::HEADING,
	]);


	$this->add_group_control(
		\Elementor\Group_Control_Typography::get_type(),
		[
			'name'		=> 'pricess_icon_type',
			'selector'	=> '{{WRAPPER}} .process-section.process-two .single-process-item .process-icon i',
		]
	);

	// Btn Normal controls Tab Start
	$this->start_controls_tabs(
		'style_tabs_pricess_icon'
	);

	$this-> start_controls_tab(
		'pricess_icon_normal',
		[
			'label' => esc_html__( 'Normal', 'taxvi-pro' ),
		]

	);

	//icons Color
	$this->add_control(
		'pricess_icon_normal_color',
		[
			'label' => esc_html__( 'Color', 'taxvi-pro' ),
			'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .process-section.process-two .single-process-item .process-icon i' => 'color:{{VALUE}}',
			],
		]
	);

	// Button BG Color
	$this->add_group_control(
		\Elementor\Group_Control_Background::get_type(),
		[	
			'label' => esc_html__( 'Background Color', 'taxvi-pro' ),
			'name' => 'pricess_icon_normal_bg',
			'types' => [ 'classic', 'gradient', 'video' ],
			'selector' => '{{WRAPPER}} .process-section.process-two .single-process-item .process-icon ',
		]
	);



	$this->end_controls_tab();


	// Btn Hover controls Tab Start
	$this-> start_controls_tab(
		'pricess_icon_hover',
		[
			'label' => esc_html__( 'Hover', 'taxvi-pro' ),
		]

	);

	//Hover Title Color
	$this->add_control(
		'pricess_icon_hover_color',
		[
			'label' => esc_html__( 'Color', 'taxvi-pro' ),
			'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .process-section.process-two .single-process-item:hover .process-icon i ' => 'color:{{VALUE}}',
			],
		]
	);
	// Button Hover BG Color
	$this->add_group_control(
		\Elementor\Group_Control_Background::get_type(),
		[	
			'label' => esc_html__( 'Background Color', 'taxvi-pro' ),
			'name' => 'pricess_icon_hover_bg',
			'types' => [ 'classic', 'gradient', 'video' ],
			'selector' => '{{WRAPPER}} .process-section.process-two .single-process-item:hover .process-icon',
		]
	);

	$this->end_controls_tab();

	$this->end_controls_tabs();







	
	$this->add_control(
		'process_service_item_bg_hr',
		[
			'type' => \Elementor\Controls_Manager::DIVIDER,
		]
	);


	$this->add_control(
		'process_service_item_bg_head',[
		'label' => esc_html( 'Service Background', 'taxvi-pro'),
		'type'	=>  \Elementor\Controls_Manager::HEADING,
	]);


	// Btn Normal controls Tab Start
	$this->start_controls_tabs(
		'style_tabs_process_service_item_bg'
	);

	$this-> start_controls_tab(
		'process_service_item_bg_normal',
		[
			'label' => esc_html__( 'Normal', 'taxvi-pro' ),
		]

	);


	$this->add_group_control(
		\Elementor\Group_Control_Background::get_type(),
		[	
			'label' => esc_html__( 'Background Color', 'taxvi-pro' ),
			'name' => 'process_service_item_bg_normal_bg',
			'types' => [ 'classic', 'gradient', 'video' ],
			'selector' => '{{WRAPPER}} .process-section.process-two .single-process-item',
		]
	);



	$this->end_controls_tab();


	// Btn Hover controls Tab Start
	$this-> start_controls_tab(
		'process_service_item_bg_hover',
		[
			'label' => esc_html__( 'Hover', 'taxvi-pro' ),
		]
	);

	$this->add_group_control(
		\Elementor\Group_Control_Background::get_type(),
		[	
			'label' => esc_html__( 'Background Color', 'taxvi-pro' ),
			'name' => 'process_service_item_bg_hover_bg',
			'types' => [ 'classic', 'gradient', 'video' ],
			'selector' => '{{WRAPPER}} .process-section.process-two .single-process-item:hover',
		]
	);

	$this->end_controls_tab();

	$this->end_controls_tabs();

	$this->end_controls_section();




	


	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		// left side 
		$process_section_feature_img_left  = $settings['process_section_feature_img_left']['url'];

		// top section 
		$process_section_sub_title  = $settings['process_section_sub_title'];
		$process_section_title  = $settings['process_section_title'];
		$process_section_desc  = $settings['process_section_desc'];
		$process_section_feature_items  = $settings['process_section_feature_items'];


		?>

			<div class="process-section process-two section-padding ">
				<div class="container">
					<div class="row">
						<div class="col-xl-6 col-lg-6 col-12 wow fadeInLeft animated" data-wow-delay="200ms">
							<div class="process-bg">
								<img src="<?php echo esc_attr($process_section_feature_img_left); ?>" alt="">
							</div>
						</div>
						<div class="col-xl-6 col-lg-6 col-12 wow fadeInUp animated" data-wow-delay="400ms">
							<div class="process-content-wrap">
								<div class="section-title">
									<p><?php echo esc_html($process_section_sub_title); ?></p>
									<h2><?php echo esc_html($process_section_title); ?></h2>
								</div>
								<p><?php echo esc_html($process_section_desc); ?></p>
								<?php foreach( $process_section_feature_items as $single_service ){ ?>                      
									<div class="single-process-item">
										<div class="process-icon">
										<?php \Elementor\Icons_Manager::render_icon( $single_service['process_section_feature_icon'], [ 'aria-hidden' => 'true' ] ); ?>
										</div>
										<div class="process-content">
											<h4><?php echo esc_html($single_service['process_section_feature_title']); ?></h4>
											<p><?php echo esc_html($single_service['process_section_feature_desc']); ?></p>
										</div>
									</div>      
								<?php } ?> 
							</div>                                                                                                                                                                               
						</div>
					</div>
				</div>
			</div>
			
  
		<?php


	}


}
