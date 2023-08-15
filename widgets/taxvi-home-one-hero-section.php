<?php
class Home_One_Hero extends \Elementor\Widget_Base {

	public function get_name() {
		return 'taxvi_home_one_Hero';
	}

	public function get_title() {
		return esc_html__( 'Taxvi Header One', 'taxvi-pro' );
	}

	public function get_icon() {
		return 'eicon-banner';
	}

	public function get_categories() {
		return [ 'taxvi_cat' ];
	}

	public function get_keywords() {
		return [ 'Header One', 'taxvi','Hero' ];
	}

	protected function register_controls() {

		// about Tab Start
		$this->start_controls_section(
			'taxvi_hero_area_one_section',
			[
				'label' => esc_html__( 'Head Content', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		//Textimonial Content head
		$this->add_control(
			'hero_area_one_heading',[
			'label' => esc_html( 'Heading ', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
			
		]);	

		// Sub Title
		$this->add_control(
			'hero_area_one_sub_title',
			[
				'label' => esc_html__( 'Sub Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Your Trusted Tax Advisor.', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		// Title
		$this->add_control(
			'hero_area_one_title_main',
			[
				'label' => esc_html__( 'Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Trustworthy Tax Advice', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		// description
		$this->add_control(
			'hero_area_one_desc',
			[
				'label' => esc_html__( 'Description', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint sunt in culpa qui officia deserunt Discover More', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		$this->end_controls_section();

		// about Tab Start
		$this->start_controls_section(
			'taxvi_hero_area_one_slider',
			[
				'label' => esc_html__( 'Header Slider', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$header_img_slider = new \Elementor\Repeater();

		$header_img_slider->add_control(
			'hero_area_one_slider_images',[
			'label' => esc_html( 'Slider Image ', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
			
		]);	

		$header_img_slider->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'header_slider_img',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .bg-cover',
			]
		);


		// testimonial Description
		$header_img_slider->add_control(
			'hero_area_one_btn_text',
			[
				'label' => esc_html__( 'Button Text', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Play', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		$header_img_slider->add_control(
			'hero_area_one_btn_link',
			[
				'label' => esc_html__( 'YouTube Video Link', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'taxvi-pro' ),
				'options' => [ 'url', 'is_external', 'nofollow' ],
				'default' => [
					'url' => 'https://www.youtube.com/watch?v=HJMfsYHBLKs&feature=youtu.be',
					'is_external' => true,
					'nofollow' => true,
					// 'custom_attributes' => '',
				],
				'label_block' => true,
			]
		);


		$this->add_control(
			'header_slider_lists',
			[
				'label' => esc_html__( 'Hero Slider', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $header_img_slider->get_controls(),
				'default' => [
					[
						'list_title' => esc_html__( 'Add New Slider', 'taxvi-pro' ),
					],
				],
				'title_field' => '{{{ list_title }}}',
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'taxvi_hero_area_client_section',
			[
				'label' => esc_html__( 'Clients', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		//Textimonial Content head
		$this->add_control(
			'taxvi_hero_area_client_heading',[
			'label' => esc_html( 'Client Images', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
			
		]);	

		// testimonial image
		$this->add_control(
			'taxvi_hero_client_one',
			[
				'label' => esc_html__( 'Client Image One', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		// testimonial image
		$this->add_control(
			'taxvi_hero_client_two',
			[
				'label' => esc_html__( 'Client Image Two', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		// testimonial image
		$this->add_control(
			'taxvi_hero_client_three',
			[
				'label' => esc_html__( 'Client Image Three', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		// Title
		$this->add_control(
			'taxvi_hero_client_title',
			[
				'label' => esc_html__( 'Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Trusted Over 240+ Client Accorss Country', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		$this->add_control(
			'taxvi_hero_client_question_title',
			[
				'label' => esc_html__( 'Question Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'How can we help you?', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		// Content Tab End
		$this->end_controls_section();


		// testimonial section us Start
		$this->start_controls_section(
			'taxvi_hero_section_style',
			[
				'label' => esc_html__( 'Home Header Section', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// testimonial section heading
		$this->add_control(
			'taxvi_hero_section_head',[
			'label' => esc_html( 'Section Background', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'taxvi_hero_section_bacground',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .light-bg-2',
			]
		);

		$this->end_controls_section();

		// testimonial section us Start
		$this->start_controls_section(
			'taxvi_hero_content_style',
			[
				'label' => esc_html__( 'Header Content Style', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// sub Title heading
		$this->add_control(
			'taxvi_hero_sub_title_head',[
			'label' => esc_html( 'Sub Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// sub title Color
		$this->add_control(
			'taxvi_hero_sub_title_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .home_one h3' => 'color: {{VALUE}};',
				],
			]
		);


		// name type
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'taxvi_hero_sub_title_type',
				'selector'	=> '{{WRAPPER}} .home_one h3',
			]
		);

		$this->add_control(
			'taxvi_hero_sub_title_divider_color',
			[
				'label' => esc_html__( 'Divider Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .hero-area-content h3::before,.hero-area-content h3::after' => 'background: {{VALUE}};',
				],
			]
		);

		// title
		$this->add_control(
			'taxvi_hero_title_head',[
			'label' => esc_html( 'Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// title Color
		$this->add_control(
			'taxvi_hero_title_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .home_one h1' => 'color: {{VALUE}};',
				],
			]
		);


		// title type
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'taxvi_hero_title_type',
				'selector'	=> '{{WRAPPER}} .home_one h1',
			]
		);

		// title
		$this->add_control(
			'taxvi_hero_desc_head',[
			'label' => esc_html( 'Description', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// sub title Color
		$this->add_control(
			'taxvi_hero_desc_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .home_one p' => 'color: {{VALUE}};',
				],
			]
		);


		// name type
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'taxvi_hero_desc_type',
				'selector'	=> '{{WRAPPER}} .home_one p',
			]
		);

		$this->end_controls_section();

	
		$this->start_controls_section(
			'taxvi_hero_slider_style',
			[
				'label' => esc_html__( 'Slider Content Style', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// button heading
		$this->add_control(
			'taxvi_hero_slider_btn_head',[
			'label' => esc_html( 'Button', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// button Color
		$this->add_control(
			'taxvi_hero_slider_btn_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .play-btn a' => 'color: {{VALUE}};',
				],
			]
		);

		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'taxvi_slider_btn_type',
				'selector'	=> '{{WRAPPER}} .play-btn a',
			]
		);

		$this->add_control(
			'taxvi_hero_slider_btn_border_color',
			[
				'label' => esc_html__( 'Border Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .play-btn' => 'border-color: {{VALUE}};',
				],
			]
		);

		// button heading
		$this->add_control(
			'taxvi_hero_slider_button_normal_dots_head',[
			'label' => esc_html( 'Slider Dos Color', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);


		$this->add_control(
			'taxvi_hero_slider_button_normal_dots_color',
			[
				'label' => esc_html__( 'Slider Dot Regular Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .homepage-slides .owl-dots button' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'taxvi_hero_slider_button_active_dots_color',
			[
				'label' => esc_html__( 'Slider Dot Active Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .homepage-slides .owl-dots button.active' => 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();



		$this->start_controls_section(
			'taxvi_hero_clients_style',
			[
				'label' => esc_html__( 'Clients Content Style', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// button heading
		$this->add_control(
			'taxvi_hero_clients_bg_head',[
			'label' => esc_html( 'Clients Background', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'taxvi_hero_clients_bacground',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .client-area',
			]
		);

		// button Color
		$this->add_control(
			'taxvi_hero_clients_color',
			[
				'label' => esc_html__( 'Client Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .client-area-title h6' => 'color: {{VALUE}};',
				],
			]
		);

		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'taxvi_clients_type',
				'selector'	=> '{{WRAPPER}} .client-area-title h6',
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		
		$hero_area_one_sub_title = $settings['hero_area_one_sub_title'];
		$hero_area_one_title_main = $settings['hero_area_one_title_main'];
		$hero_area_one_desc = $settings['hero_area_one_desc'];
		$hero_area_one_desc = $settings['hero_area_one_desc'];

		// header slider list
		$header_slider_lists = $settings['header_slider_lists'];


		// Client about and image
		$taxvi_hero_client_one = $settings['taxvi_hero_client_one']['url'];
		$taxvi_hero_client_two = $settings['taxvi_hero_client_two']['url'];
		$taxvi_hero_client_three = $settings['taxvi_hero_client_three']['url'];

		$taxvi_hero_client_title = $settings['taxvi_hero_client_title'];
		$taxvi_hero_client_question_title = $settings['taxvi_hero_client_question_title'];

		?>
			<div class="hero-area light-bg-2">
				<div class="container">                
					<div class="hero-area-content wow fadeInUp animated home_one" data-wow-delay="200ms">            
						<h3><?php echo esc_html($hero_area_one_sub_title); ?></h3>
						<h1><?php echo $hero_area_one_title_main ?></h1>            
						<?php echo $hero_area_one_desc; ?>            
					</div>
						<div class="homepage-slides owl-carousel">
							<?php foreach($header_slider_lists as $single_slider){ ?>
							<div class="single-slide-item">
								<div class="slider-bg bg-cover" >                                                            
									<div class="overlay"></div>                            
								</div>    
								
								<div class="play-btn">
									<a href="<?php echo esc_url( $single_slider['hero_area_one_btn_link']['url']); ?>" class="video-play-btn mfp-iframe"><?php echo esc_html( $single_slider['hero_area_one_btn_text']); ?></a>
								</div>                          
							</div>
							<?php } ?>
					</div>
					<div class="client-area wow fadeInUp animated" data-wow-delay="200ms">
						<div class="client-area-inner">
							<div class="client-thumb">
								<img class="client-one" src="<?php echo esc_attr( $taxvi_hero_client_one); ?>" alt="">
								<img class="client-two" src="<?php echo esc_attr( $taxvi_hero_client_two); ?>" alt="">
								<img class="client-three" src="<?php echo esc_attr( $taxvi_hero_client_three); ?>" alt="">                            
							</div>
							<div class="client-area-title">
								<h6><?php echo esc_html( $taxvi_hero_client_title); ?></h6>
							</div>
						</div>
						<div class="help-btn"><?php echo esc_html( $taxvi_hero_client_question_title); ?></div>
					</div>
				</div>
			</div>
  
		<?php


	}


	protected function content_template() {

		?>	
			<div class="hero-area light-bg-2">
				<div class="container">                
					<div class="hero-area-content wow fadeInUp animated home_one" data-wow-delay="200ms">            
						<h3>{{{settings.hero_area_one_sub_title}}}</h3>
						<h1>{{{settings.hero_area_one_title_main}}}</h1>            
						<p>{{{settings.hero_area_one_desc}}}   </p>
					</div>
						<div class="homepage-slides owl-carousel">
							<# _.each( settings.header_slider_lists, function( header_slider_list ) { #>
								<div class="single-slide-item">
									<div class="slider-bg bg-cover">                                                            
										<div class="overlay"></div>                            
									</div>    
									
									<div class="play-btn">
										<a href="{{{header_slider_list.hero_area_one_btn_link.url}}}" class="video-play-btn mfp-iframe">{{{header_slider_list.hero_area_one_btn_text}}}</a>
									</div>                          
								</div>
							<# }); #>
					</div>
					<div class="client-area wow fadeInUp animated" data-wow-delay="200ms">
						<div class="client-area-inner">
							<div class="client-thumb">
								<img class="client-one" src="{{{settings.taxvi_hero_client_one}}}" alt="">
								<img class="client-two" src="{{{settings.taxvi_hero_client_two}}}" alt="">
								<img class="client-three" src="{{{settings.taxvi_hero_client_three}}}" alt="">                            
							</div>
							<div class="client-area-title">
								<h6>{{{settings.taxvi_hero_client_title}}}</h6>
							</div>
						</div>
						<div class="help-btn">{{{settings.taxvi_hero_client_question_title}}}</div>
					</div>
				</div>
			</div>
  
               
		<?php 
	}
}
