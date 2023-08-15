<?php
class Home_Slider_Two extends \Elementor\Widget_Base {

	public function get_name() {
		return 'taxvi_homee_slider_two';
	}

	public function get_title() {
		return esc_html__( 'Taxvi Home Slider', 'taxvi-pro' );
	}

	public function get_icon() {
		return 'eicon-slider-vertical';
	}

	public function get_categories() {
		return [ 'taxvi_cat' ];
	}

	public function get_keywords() {
		return [ 'homee', 'slider','taxvi' ];
	}

	protected function register_controls() {

		
		$this->start_controls_section(
			'home_slider_two_heading',
			[
				'label' => esc_html__( 'Home Slider', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);


		$home_slider = new \Elementor\Repeater();

		// cta one Sub Title
		$home_slider->add_control(
			'home_slider_two_sub_title',
			[
				'label' => esc_html__( 'Sub Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Make Your Taxes Easy', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		$home_slider->add_control(
			'home_slider_two_sub_title_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		// cet one Title
		$home_slider->add_control(
			'home_slider_two_title',
			[
				'label' => esc_html__( 'Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Reliable & Trusted <br> Advice', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		$home_slider->add_control(
			'home_slider_two_title_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		// cet desc Title
		$home_slider->add_control(
			'home_slider_two_desc',
			[
				'label' => esc_html__( 'Description', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'There are many variations of passages of Lorem available, but the majority have suffered alteration in some form, by injected humour, or randomised words', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		$home_slider->add_control(
			'home_slider_two_desc_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		// cet button text
		$home_slider->add_control(
			'home_slider_two_btn_text',
			[
				'label' => esc_html__( 'Button Text', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Make an Appointment', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		// cet button url
		$home_slider->add_control(
			'home_slider_two_btn_url',
			[
				'label' => esc_html__( 'Button URL', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'taxvi-pro' ),
				'options' => [ 'url', 'is_external', 'nofollow' ],
				'default' => [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
					// 'custom_attributes' => '',
				],
				'label_block' => true,
			]
		);

		$home_slider->add_control(
			'home_slider_two_social_links _hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);


		$home_slider->add_control(
			'home_slider_two_social_head',[
			'label' => esc_html( 'Social Links', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		$home_slider->add_control(
			'home_slider_two_fb_link',
			[
				'label' => esc_html__( 'Facebook Link', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://youtube.com', 'taxvi-pro' ),
				'options' => [ 'url', 'is_external', 'nofollow' ],
				'default' => [
					'url' => 'facebook.com',
					'is_external' => true,
					'nofollow' => true,
					// 'custom_attributes' => '',
				],
				'label_block' => true,
			]
		);

		$home_slider->add_control(
			'home_slider_two_bnb_link',
			[
				'label' => esc_html__( 'Behance Link', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://youtube.com', 'taxvi-pro' ),
				'options' => [ 'url', 'is_external', 'nofollow' ],
				'default' => [
					'url' => 'behance.com',
					'is_external' => true,
					'nofollow' => true,
					// 'custom_attributes' => '',
				],
				'label_block' => true,
			]
		);

		$home_slider->add_control(
			'home_slider_two_telegram_link',
			[
				'label' => esc_html__( 'Telegram Link', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://youtube.com', 'taxvi-pro' ),
				'options' => [ 'url', 'is_external', 'nofollow' ],
				'default' => [
					'url' => 'telegram.com',
					'is_external' => true,
					'nofollow' => true,
					// 'custom_attributes' => '',
				],
				'label_block' => true,
			]
		);

		$home_slider->add_control(
			'home_slider_two_bribbble_link',
			[
				'label' => esc_html__( 'Bribbble Link', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://youtube.com', 'taxvi-pro' ),
				'options' => [ 'url', 'is_external', 'nofollow' ],
				'default' => [
					'url' => 'bribbble.com',
					'is_external' => true,
					'nofollow' => true,
					// 'custom_attributes' => '',
				],
				'label_block' => true,
			]
		);

		$home_slider->add_control(
			'home_slider_two_media_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);


		$home_slider->add_control(
			'home_slider_icons',
			[
				'label' => esc_html__( 'Media Icons', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-play',
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


		$home_slider->add_control(
			'home_slider_two_btn_youtube',
			[
				'label' => esc_html__( 'YouTube Video Link', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://youtube.com', 'taxvi-pro' ),
				'options' => [ 'url', 'is_external', 'nofollow' ],
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
					// 'custom_attributes' => '',
				],
				'label_block' => true,
			]
		);

		$home_slider->add_control(
			'home_slider_two_slider_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);


		$home_slider->add_control(
			'home_slider_two_slider_head',[
			'label' => esc_html( 'Choose a Slider Image', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);




		$home_slider->add_control(
			'home_slider_two_slider_image',
			[
				'label' => esc_html__( 'Choose Image', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);



		$this->add_control(
			'home_slider_items',
			[
				'label' => esc_html__( 'Slider', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $home_slider->get_controls(),
				'default' => [
					[
						'home_slider_two_title' => esc_html__( 'Reliable & Trusted Advice', 'taxvi-pro' ),
					],
				],
				'title_field' => '{{{ home_slider_two_title }}}',
			]
		);



		$this->end_controls_section();





		$this->start_controls_section(
			'home_slider_two_founder_year_heading',
			[
				'label' => esc_html__( 'Founder Year', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);


		$this->add_control(
			'home_slider_founder_title',
			[
				'label' => esc_html__( 'Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Since 1990', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);


		$this->add_control(
			'home_slider_founder_button_text',
			[
				'label' => esc_html__( 'Button Text', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Contact With Us', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		$this->add_control(
			'home_slider_two_founder_button_url',
			[
				'label' => esc_html__( 'Button URL', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://youtube.com', 'taxvi-pro' ),
				'options' => [ 'url', 'is_external', 'nofollow' ],
				'default' => [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
					// 'custom_attributes' => '',
				],
				'label_block' => true,
			]
		);	
	
		

		$this->end_controls_section();





		// Style team Start
		$this->start_controls_section(
			'home_slider_two_heading_style',
			[
				'label' => esc_html__( 'Home Slider Two', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// cta sub title
		$this->add_control(
			'home_slider_two_sub_title_haed',[
			'label' => esc_html( 'Sub Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// cta sub title color
		$this->add_control(
			'team_sub_title_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .hero-area-content h3' => 'color: {{VALUE}}',
				],
			]
		);


		// sub title type color
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'team_sub_title_type',
				'selector'	=> '{{WRAPPER}} .hero-area-content h3',
				
				
			]
		);

		$this->add_control(
			'home_slider_two_title_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		// cta sub head
		$this->add_control(
			'home_slider_two_title_head',[
			'label' => esc_html( 'Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// cta sub title color
		$this->add_control(
			'home_slider_two_title_main_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .hero-area-content h1' => 'color: {{VALUE}}',
				],
			]
		);


		// cta sub title type color
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'home_slider_two_title_type',
				'selector'	=> '{{WRAPPER}} .hero-area-content h1',
				
				
			]
		);

		$this->add_control(
			'cta_desc_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		// cta sub head
		$this->add_control(
			'home_slider_two_desc_head',[
			'label' => esc_html( 'Description', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// cta sub title color
		$this->add_control(
			'home_slider_two_desc_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .hero-area-content p' => 'color: {{VALUE}}',
				],
				'default'		=>  '#fff'
			]
		);


		// cta sub title type color
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'home_slider_two_desc_type',
				'selector'	=> '{{WRAPPER}} .hero-area-content p',
				
				
			]
		);

		$this->add_control(
			'team_desc_title_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);


		$this->add_control(
			'home_slider_two_social_text_head',[
			'label' => esc_html( 'Social Text', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// job desc typography
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'home_slider_two_social_type',
				'selector'	=> '{{WRAPPER}} .social-link a',
				
			]
		);
		

		// Btn controls Tab Start
		$this->start_controls_tabs(
			'style_social_tabs_s'
		);

		$this-> start_controls_tab(
			'home_slider_two_social_normal',
			[
				'label' => esc_html__( 'Normal', 'taxvi-pro' ),
			]

		);

		//Title Color
		$this->add_control(
			'home_slider_two_social_text_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .social-link a' => 'color:{{VALUE}}',
				],
			]
		);



		$this->end_controls_tab();



		
		// Btn Hover controls Tab Start
		$this-> start_controls_tab(
			'home_slider_two_social_hover',
			[
				'label' => esc_html__( 'Hover', 'taxvi-pro' ),
			]

		);

		//Hover Title Color
		$this->add_control(
			'home_slider_two_social_hover_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .social-link a:hover' => 'color:{{VALUE}}',
				],
			]
		);



		// Btn controls Tab Start
		$this->end_controls_tabs();

		$this->add_control(
			'cta_youtube_social_color_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		





		$this->add_control(
			'home_slider_two_btn_head',[
			'label' => esc_html( 'Button', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// job desc typography
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'home_slider_two_btn_type',
				'selector'	=> '{{WRAPPER}} .hero-area-content a',
				
			]
		);

		// Btn controls Tab Start
		$this->start_controls_tabs(
			'style_tabs_s'
		);

		$this-> start_controls_tab(
			'home_slider_two_btn_normal',
			[
				'label' => esc_html__( 'Normal', 'taxvi-pro' ),
			]

		);

		//Title Color
		$this->add_control(
			'home_slider_two_btn_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .main-btn' => 'color:{{VALUE}}',
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
			'home_slider_two_btn_hover',
			[
				'label' => esc_html__( 'Hover', 'taxvi-pro' ),
			]

		);

		//Hover Title Color
		$this->add_control(
			'home_slider_two_hover_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .main-btn:hover' => 'color:{{VALUE}}',
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


		// Btn controls Tab Start
		$this->end_controls_tabs();

		$this->add_control(
			'cta_youtube_media_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
		// cta sub title
		$this->add_control(
			'home_slider_two_scope_haed',[
			'label' => esc_html( 'Media Scope Style', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// cta icons color
		$this->add_control(
			'home_slider_two_scope_icons_color',
			[
				'label' => esc_html__( 'Scope Icon Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pop-up-video a.video-play-btn i' => 'color: {{VALUE}}',
				],
			]
		);

		// cta scope media bg color
		$this->add_control(
			'home_slider_two_scope_color',
			[
				'label' => esc_html__( 'Scope Background Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pop-up-video a.video-play-btn' => 'background: {{VALUE}}',
				],
			]
		);

		// cta scope border color
		$this->add_control(
			'home_slider_two_scope_border_color',
			[
				'label' => esc_html__( 'Scope Border Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pop-up-video a.video-play-btn' => 'border-color: {{VALUE}}',
				],
			]
		);



		$this->add_control(
			'home_slider_two_bullet_haed',[
			'label' => esc_html( 'Bullet Style', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);


		$this->add_control(
			'home_slider_two_bullet_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .homepage-slides .owl-dots button' => 'background-color:{{VALUE}}',
				],
			]
		);

		$this->add_control(
			'home_slider_two_bullet_active_color',
			[
				'label' => esc_html__( 'Active Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .homepage-slides .owl-dots button.active' => 'background-color:{{VALUE}}',
				],
			]
		);

	
		// section background end
		$this->end_controls_section();

		$this->start_controls_section(
			'home_slider_two_founder_style',
			[
				'label' => esc_html__( 'Founter Style', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// cta sub title
		$this->add_control(
			'home_slider_two_founder_haed',[
			'label' => esc_html( 'Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);


		$this->add_control(
			'home_slider_two_founder_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .founder-year h2' => '-webkit-text-fill-color:{{VALUE}}',
				],
			]
		);

		$this->add_control(
			'founder_title_color_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);


		$this->add_control(
			'home_slider_two_founder_button_haed',[
			'label' => esc_html( 'Button', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		$this->add_control(
			'home_slider_two_founder_btn_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .founder-year a' => 'color:{{VALUE}}',
				],
			]
		);

		$this->add_control(
			'founder_btn_color_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);


		$this->add_control(
			'home_slider_two_founder_bg_haed',[
			'label' => esc_html( 'Founder Background', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);


		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[	
				'label' => esc_html__( 'Background Color', 'taxvi-pro' ),
				'name' => 'founter_bg_color',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .founder-year',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();


		$home_slider_items = $settings['home_slider_items'];


		$home_slider_founder_title = $settings['home_slider_founder_title'];
		$home_slider_founder_button_text = $settings['home_slider_founder_button_text'];
		$home_slider_two_founder_button_url = $settings['home_slider_two_founder_button_url']['url'];



		?>
		


	<div class="hero-area hero-area-two">        
        <div class="homepage-slides owl-carousel">
		<?php foreach( $home_slider_items as $single_slider ){ ?>
            <div class="single-slide-item">
                <div class="slider-bg bg-cover" data-background="<?php echo esc_attr($single_slider['home_slider_two_slider_image']['url']); ?>" >                                                            
                    <div class="overlay-2"></div>
                    <div class="container">
                        <div class="hero-area-content">            
                            <h3><?php echo esc_html($single_slider['home_slider_two_sub_title']); ?></h3>
                            <h1><?php echo $single_slider['home_slider_two_title']; ?></h1>            
                            <p><?php echo esc_html($single_slider['home_slider_two_desc']); ?></p>                    
                            <a class="main-btn" href="<?php echo esc_url($single_slider['home_slider_two_btn_url']['url']); ?>"><?php echo esc_html($single_slider['home_slider_two_btn_text']); ?></a>
                        </div>
                        <div class="social-link">
							<?php if($single_slider['home_slider_two_fb_link']){ ?>
                            <a href="<?php echo esc_url($single_slider['home_slider_two_fb_link']['url']); ?>">.FACEBOOK</a>
							<?php } ?>
							<?php if($single_slider['home_slider_two_bnb_link']){ ?>
                            <a href="<?php echo esc_url($single_slider['home_slider_two_bnb_link']['url']); ?>">.BEHANCE</a>
							<?php } ?>
							<?php if($single_slider['home_slider_two_telegram_link']){ ?>
                            <a href="<?php echo esc_url($single_slider['home_slider_two_telegram_link']['url']); ?>">.TELEGRAM</a>
							<?php } ?>
							<?php if($single_slider['home_slider_two_bribbble_link']){ ?>
                            <a href="<?php echo esc_url($single_slider['home_slider_two_bribbble_link']['url']); ?>">.DRIBBLE</a>
							<?php } ?>
                        </div>
                    </div>
                </div>  
                <div class="pop-up-video">
                    <a href="<?php echo esc_url($single_slider['home_slider_two_btn_youtube']['url']); ?>" class="video-play-btn mfp-iframe">
					<?php \Elementor\Icons_Manager::render_icon( $single_slider['home_slider_icons'], [ 'aria-hidden' => 'true' ] ); ?> <span></span>
                    </a>
                </div>
            </div>     
			<?php } ?>                                               
        </div> 
        <div class="founder-year">
            <h2><?php echo esc_html($home_slider_founder_title); ?></h2>
            <a href="<?php echo esc_url($home_slider_two_founder_button_url); ?>"><?php echo esc_html($home_slider_founder_button_text); ?></a>
        </div>                 
    </div>
		<?php


	}

}
