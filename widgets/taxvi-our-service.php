<?php
class Our_Service extends \Elementor\Widget_Base {

	public function get_name() {
		return 'taxvi_our_service';
	}

	public function get_title() {
		return esc_html__( 'Taxvi Our Service', 'taxvi-pro' );
	}

	public function get_icon() {
		return 'eicon-pro-icon';
	}

	public function get_categories() {
		return [ 'taxvi_cat' ];
	}

	public function get_keywords() {
		return [ 'Counter', 'taxvi' ];
	}

	protected function register_controls() {

		// service Tab Start
		$this->start_controls_section(
			'taxvi_service_left_heading',
			[
				'label' => esc_html__( 'Service Left Side', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		//service Content
		$this->add_control(
			'taxvi_service_left_head',[
			'label' => esc_html( 'Services', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
			
		]);	

		// service Repeater Section Here now
		$services = new \Elementor\Repeater();

		$services->add_control(
			'team_service_left_title',
			[
				'label' => esc_html__( 'Service Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Insurance Tax' , 'taxvi-pro' ),
				'label_block' => true,
			]
		);

		$services->add_control(
			'service_left_desc',
			[
				'label' => esc_html__( 'Service Description', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'There are many variations of passages of Lorem Ipsum available, but the majority ' , 'taxvi-pro' ),
				'label_block' => true,
			]
		);

		

		$services->add_control(
			'service_left_icons',
			[
				'label' => esc_html__( 'Feature Icons', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-arrow-right',
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



		$services->add_control(
			'service_left_btn_link',
			[
				'label' => esc_html__( 'Feature Link', 'taxvi-pro' ),
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
			'service_left_lists',
			[
				'label' => esc_html__( 'Our Service', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $services->get_controls(),
				'default' => [
					[
						'team_service_left_title' => esc_html__( 'Insurance Tax', 'taxvi-pro' ),
					],
				],
				'title_field' => '{{{ team_service_left_title }}}',
			]
		);

		$this->end_controls_section();








		// service Tab Start
		$this->start_controls_section(
			'taxvi_service_right_side_heading',
			[
				'label' => esc_html__( 'Service Right Side', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		//service Content
		$this->add_control(
			'taxvi_service_right_head',[
			'label' => esc_html( 'service Header', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
			
		]);	

		// service Sub Title
		$this->add_control(
			'taxvi_service_right_sub_title',
			[
				'label' => esc_html__( 'Sub Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'WHAT WE PROVIDE', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		// service Title
		$this->add_control(
			'taxvi_service_right_title',
			[
				'label' => esc_html__( 'Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Loose And Experienced Tax Preparation', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		// service Description
		$this->add_control(
			'taxvi_service_right_desc',
			[
				'label' => esc_html__( 'Description', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( "There are many variations of passages of Lorem Ipsum available, but the majority suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. ", 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		$this->add_control(
			'right_feature_image',
			[
				'label' => esc_html__( 'Choose Image', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		// button text

		$this->add_control(
			'taxvi_service_right_button_text',
			[
				'label' => esc_html__( 'Feature Button Text', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Explore More Services', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		$this->add_control(
			'taxvi_service_right_button_url',
			[
				'label' => esc_html__( 'Feature Button Link', 'taxvi-pro' ),
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










		// Style team Start
		$this->start_controls_section(
			'team_heading_left_style',
			[
				'label' => esc_html__( 'Service Left Side Style', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// service heading
		$this->add_control(
			'team_left_head',[
			'label' => esc_html( 'Feature Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'feature_title_type',
				'selector'	=> '{{WRAPPER}} .single-service-inner h5 a',
			]
		);

		// feature title Normal controls Tab Start
		$this->start_controls_tabs(
			'style__s'
		);

		$this-> start_controls_tab(
			'feature_icon_normal',
			[
				'label' => esc_html__( 'Normal', 'taxvi-pro' ),
			]

		);

		// feature Title Color
		$this->add_control(
			'feature_normal_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .single-service-inner h5 a ' => 'color:{{VALUE}}',
				],
			]
		);



		$this->end_controls_tab();


		// Btn Hover controls Tab Start
		$this-> start_controls_tab(
			'feature_icon_hover',
			[
				'label' => esc_html__( 'Hover', 'taxvi-pro' ),
			]

		);

		//Hover Title Color
		$this->add_control(
			'feature_hover_title_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .single-service-inner:hover h5 a ' => 'color:{{VALUE}}',
				],
			]
		);
	
		$this->end_controls_tabs();

		$this->add_control(
			'service_title_style_color_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		// service heading
		$this->add_control(
			'section_desc_head',[
			'label' => esc_html( 'Feature Description', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// description color 
		$this->add_control(
			'feature_description_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .single-service-inner p ' => 'color:{{VALUE}}',
				],
			]
		);

		// description type
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'feature_desc_type',
				'selector'	=> '{{WRAPPER}} .single-service-inner p',
			]
		);

		$this->add_control(
			'service_desc_style_color_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);


		$this->add_control(
			'section_icons_head',[
			'label' => esc_html( 'Feature Icons', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// icon size
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'feature_icon_type',
				'selector'	=> '{{WRAPPER}} .single-service-inner .details-link i',
			]
		);

		

		

		// feature title Normal controls Tab Start
		$this->start_controls_tabs(
			'style_tabs_s'
		);

		$this-> start_controls_tab(
			'feature_bg_icon_normal',
			[
				'label' => esc_html__( 'Normal', 'taxvi-pro' ),
			]

		);

		// icon color 
		$this->add_control(
			'feature_icon_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .single-service-inner .details-link i' => 'color:{{VALUE}}',
				],
			]
		);

		//Hover icon bg Color
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'feature_Icon_background_color',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .single-service-inner .details-link',
			]
		);



		$this->end_controls_tab();


		// Btn Hover controls Tab Start
		$this-> start_controls_tab(
			'coll_btn_hover',
			[
				'label' => esc_html__( 'Hover', 'taxvi-pro' ),
			]

		);

		// icon color 
		$this->add_control(
			'feature_icon_hover_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .single-service-inner .details-link i' => 'color:{{VALUE}}',
				],
			]
		);

		//Hover icon bg Color
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'feature_Icon_background_hover_color',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .single-service-inner:hover .details-link',
			]
		);
		
	
		$this->end_controls_tabs();


		$this->end_controls_section();


		// Style team Start
		$this->start_controls_section(
			'taxvi_side_right_heading_style',
			[
				'label' => esc_html__( 'Service Right Side Style', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// service heading
		$this->add_control(
			'taxvi_side_right_head',[
			'label' => esc_html( 'Sub Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// Counter number Color
		$this->add_control(
			'taxvi_side_right_sub_title_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .section-title h6' => 'color: {{VALUE}};',
				],
			]
		);


		// sub title type color
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'taxvi_side_rightsub_title_type',
				'selector'	=> '{{WRAPPER}} .section-title h6',
			]
		);

		// sub title border Color
		$this->add_control(
			'taxvi_side_right_sub_title_border_color',
			[
				'label' => esc_html__( 'Border Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .section-title h6' => 'border-color: {{VALUE}};',
				],
				'separator'		=> 'after'
			]
		);	


		// service Title
		$this->add_control(
			'taxvi_side_right_title',[
			'label' => esc_html( 'Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// Title Color
		$this->add_control(
			'taxvi_side_right_title_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .section-title h2' => 'color: {{VALUE}};',
				],
			]
		);

		// title typography
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'team_title_type',
				'selector'	=> '{{WRAPPER}} .section-title h2',
			]
		);


		$this->add_control(
			'taxvi_side_right_desc_color_head',[
			'label' => esc_html( 'Description', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// Title Color
		$this->add_control(
			'taxvi_side_right_desc_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .service-content-wrap p' => 'color: {{VALUE}};',
				],
			]
		);

		// title typography
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'taxvi_side_right_btn_type',
				'selector'	=> '{{WRAPPER}} .service-content-wrap p',
			]
		);


		$this->add_control(
			'side_right_btn_color_head',[
			'label' => esc_html( 'Button', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// title typography
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'side_right_btn_type',
				'selector'	=> '{{WRAPPER}} .service-bg a',
			]
		);

		
		// feature title Normal controls Tab Start
		$this->start_controls_tabs(
			'style_service_s'
		);

		$this-> start_controls_tab(
			'right_side_btn_text_normal',
			[
				'label' => esc_html__( 'Normal', 'taxvi-pro' ),
			]

		);

		// icon color 
		$this->add_control(
			'right_side_btn_text_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .service-bg a' => 'color:{{VALUE}}',
				],
			]
		);

		//Hover icon bg Color
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'right_side_btn_bg_color',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .service-bg a',
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

		// icon color 
		$this->add_control(
			'right_side_btn_text_hover_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .service-bg a:hover' => 'color:{{VALUE}}',
				],
			]
		);

		//Hover icon bg Color
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'right_side_btn_text_hover_color',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .service-bg a:hover',
			]
		);
		
	
		$this->end_controls_tabs();

		// section background end
		$this->end_controls_section();


		// Style team Start
		$this->start_controls_section(
			'taxvi_service_bg_style',
			[
				'label' => esc_html__( 'Service Section Style', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// service heading
		$this->add_control(
			'taxvi_service_bg_head',[
			'label' => esc_html( 'Background', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'taxvi_service_service_bg_color',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .white-bg',
			]
		);

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		// left section
		  $service_left_lists = $settings['service_left_lists'];


		// Right Sidebar
		 $taxvi_service_right_sub_title = $settings['taxvi_service_right_sub_title'];
		 $taxvi_service_right_title = $settings['taxvi_service_right_title'];
		 $taxvi_service_right_desc = $settings['taxvi_service_right_desc'];
		 $right_feature_image = $settings['right_feature_image']['url'];
		 $taxvi_service_right_button_text = $settings['taxvi_service_right_button_text'];
		 $taxvi_service_right_button_url = $settings['taxvi_service_right_button_url']['url'];

		?>
	<div class="service-section white-bg section-padding">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-12 wow fadeInLeft animated" data-wow-delay="200ms">
					<?php foreach( $service_left_lists as $single_service ){ ?>
						<div class="single-service-wrap">
							<div class="single-service-inner">
								<h5><a href="<?php echo esc_url($single_service['service_left_btn_link']['url']); ?>"><?php echo esc_html($single_service['team_service_left_title']); ?></a></h5>
								<p><?php echo esc_html($single_service['service_left_desc']); ?></p>
								<a href="<?php echo esc_url($single_service['service_left_btn_link']['url']); ?>" class="details-link"><?php \Elementor\Icons_Manager::render_icon( $single_service['service_left_icons'], [ 'aria-hidden' => 'true' ] ); ?></a>
							</div>
						</div>
					<?php } ?>
                </div>
                <div class="col-xl-6 col-lg-6 col-12 wow fadeInUp animated" data-wow-delay="200ms">
                    <div class="service-content-wrap">
                        <div class="section-title">
                            <h6><?php echo esc_html($taxvi_service_right_sub_title); ?></h6>
                            <h2><?php echo esc_html($taxvi_service_right_title); ?></h2>
                        </div>
                        <p><?php echo esc_html($taxvi_service_right_desc); ?></p>
                        <div class="service-bg">
                            <img src="<?php echo esc_attr($right_feature_image) ; ?>" alt="">
                            <a href="<?php echo esc_url($taxvi_service_right_button_url); ?>" class="more-service-btn"><?php echo esc_html($taxvi_service_right_button_text); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  
		<?php


	}


	protected function content_template() {

		?>	

		<#
			if ( settings.right_feature_image.url ) {
				var right_feature_image = {
					id: settings.right_feature_image.id,
					url: settings.right_feature_image.url,
					size: settings.right_feature_image_size,
					dimension: settings.image_custom_dimension,
					model: view.getEditModel()
				};

				var image_url = elementor.imagesManager.getImageUrl( right_feature_image );

				if ( ! image_url ) {
					return;
				}
			}

			
		#>
			<div class="service-section white-bg section-padding">
				<div class="container">
					<div class="row">
						<div class="col-xl-6 col-lg-6 col-12 wow fadeInLeft animated" data-wow-delay="200ms">
							<# _.each( settings.service_left_lists, function( single_item ) { #>
							<div class="single-service-wrap">
								<div class="single-service-inner">
									<h5><a href="{{{single_item.service_left_btn_link.url}}}">{{{single_item.team_service_left_title}}}</a></h5>
									<p>{{{single_item.service_left_desc}}}</p>

									<#
										var featureBoxIcons = elementor.helpers.renderIcon( view, single_item.service_left_icons, { 'aria-hidden': true }, 'i' , 'object' );
									#>
									
									<a href="{{{single_item.service_left_btn_link.url}}}" class="details-link">{{{featureBoxIcons.value}}}</a>
								</div>                        
							</div>
							<# }); #>
						</div>
						<div class="col-xl-6 col-lg-6 col-12 wow fadeInUp animated" data-wow-delay="200ms">
							<div class="service-content-wrap">
								<div class="section-title">
									<h6>{{{settings.taxvi_service_right_sub_title}}}</h6>
									<h2>{{{settings.taxvi_service_right_title}}}</h2>
								</div>
								<p>{{{settings.taxvi_service_right_desc}}}</p>
								<div class="service-bg">
									<img src="{{{image_url}}}" alt="">
									<a href="{{{settings.taxvi_service_right_button_url}}}" class="more-service-btn">{{{settings.taxvi_service_right_button_text}}}</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
               
		<?php 
	}
}
