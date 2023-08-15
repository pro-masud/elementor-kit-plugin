<?php
class About_Us extends \Elementor\Widget_Base {

	public function get_name() {
		return 'taxvi_about_us';
	}

	public function get_title() {
		return esc_html__( 'Taxvi About Us', 'taxvi-pro' );
	}

	public function get_icon() {
		return 'eicon-captcha';
	}

	public function get_categories() {
		return [ 'taxvi_cat' ];
	}

	public function get_keywords() {
		return [ 'about', 'taxvi','us' ];
	}

	protected function register_controls() {

		// about Tab Start
		$this->start_controls_section(
			'taxvi_our_about_us',
			[
				'label' => esc_html__( 'About Head', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		//about Content head
		$this->add_control(
			'about_us_heading',[
			'label' => esc_html( 'Heading', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
			
		]);	

		// Sub Title
		$this->add_control(
			'about_sub_title',
			[
				'label' => esc_html__( 'Sub Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'More About Us', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		// Title
		$this->add_control(
			'about_title',
			[
				'label' => esc_html__( 'Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'We Provide The Best Service For Your Convenience', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		$this->end_controls_section();

		// Content Tab End

		$this->start_controls_section(
			'section_middle_about_us',
			[
				'label' => esc_html__( 'About Middle', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		//about meddle left
		$this->add_control(
			'about_us_middle_left',[
			'label' => esc_html( 'middle Left', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
			
		]);	

		// about us left images upload
		$this->add_control(
			'about_us_left_image',
			[
				'label' => esc_html__( 'Choose a Right Image', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'about_us_left_right_divider',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		//about meddle right
		$this->add_control(
			'about_us_middle_right',[
			'label' => esc_html( 'middle right', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
			
		]);	

		// right Title
		$this->add_control(
			'about_right_title',
			[
				'label' => esc_html__( 'Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Our History & Goal.', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		// right Title
		$this->add_control(
			'about_right_desc',
			[
				'label' => esc_html__( 'Description', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, uncover many web sites still in infancy. various versions have evolved over the years, sometimes by sometimes on purpose injected humour and the like', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_bottom_about_us',
			[
				'label' => esc_html__( 'About Bottom', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		//about meddle left
		$this->add_control(
			'section_bottom_left',[
			'label' => esc_html( 'Bottom Image', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
			
		]);	

		// about us left images upload
		$this->add_control(
			'about_us_bottom_image',
			[
				'label' => esc_html__( 'Choose a Bottom Image', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->end_controls_section();


		// Style about us Start
		$this->start_controls_section(
			'about_us_style',
			[
				'label' => esc_html__( 'About Head Style', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// about us heading
		$this->add_control(
			'about_us_head',[
			'label' => esc_html( 'Sub Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// sub title Color
		$this->add_control(
			'about_sub_title_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .section-title p' => 'color: {{VALUE}};',
				],
			]
		);


		// sub title type
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'about_us_sub_title_type',
				'selector'	=> '{{WRAPPER}} .section-title p',
			]
		);

		// sub title divider Color
		$this->add_control(
			'about_us_divider_color',
			[
				'label' => esc_html__( 'Divider Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .section-title p::before' => 'background: {{VALUE}};',
				],
			]
		);


		// about us Title
		$this->add_control(
			'about_title_head',[
			'label' => esc_html( 'Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// sub title Color
		$this->add_control(
			'about_title_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .section-title h2' => 'color: {{VALUE}};',
				],
			]
		);


		// sub title type
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'about_title_type',
				'selector'	=> '{{WRAPPER}} .section-title h2',
			]
		);

		
		// section background end
		$this->end_controls_section();

		// Style Tab End

		// Style about us middle Start
		$this->start_controls_section(
			'about_us_middle_style',
			[
				'label' => esc_html__( 'About Middle Style', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// about us right heading
		$this->add_control(
			'about_us_middle_head',[
			'label' => esc_html( 'Right Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// sub title Color
		$this->add_control(
			'about_right_title_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .about_info h3' => 'color: {{VALUE}};',
				],
			]
		);


		// sub title type
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'about_right_title_type',
				'selector'	=> '{{WRAPPER}} .about_info h3',
			]
		);



		// about us right heading
		$this->add_control(
			'about_us_middle_desc',[
			'label' => esc_html( 'Right Description', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// sub title Color
		$this->add_control(
			'about_right_desc_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .about_info p' => 'color: {{VALUE}};',
				],
			]
		);


		// sub title type
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'about_right_desc_type',
				'selector'	=> '{{WRAPPER}} .about_info p',
			]
		);

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		 $about_sub_title = $settings['about_sub_title'];
		 $about_title = $settings['about_title'];
		 $about_us_left_image = $settings['about_us_left_image']['url'];
		 $about_right_title = $settings['about_right_title'];
		 $about_right_desc = $settings['about_right_desc'];
		 $about_us_bottom_image = $settings['about_us_bottom_image']['url'];

		?>
			<div class="breadcrumb-area section-padding light-bg-1 pb-0">
				<div class="container">
					<div class="row">
						<div class="col-xl-9 col-lg-9 col-md-9 col-12">
							<div class="section-title">
								<p><?php echo esc_html( $about_sub_title ); ?></p>
								<h2><?php echo esc_html( $about_title ); ?></h2>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xl-6 col-lg-6 col-md-6 col-12">
							<div class="direction-img">
								<img src="<?php echo esc_attr( $about_us_left_image ); ?>" alt="">
							</div>
						</div>
						<div class="col-xl-6 col-lg-6 col-md-6 col-12 about_info">
							<h3><?php echo esc_html( $about_right_title ); ?></h3>
							<p><?php echo esc_html( $about_right_desc ); ?></p>
						</div>
					</div>
					<div class="row mt-90">
						<div class="col-12">
							<div class="bread-bg">
								<img src="<?php echo esc_attr( $about_us_bottom_image ); ?>" alt="">
							</div>
						</div>
					</div>
				</div>
			</div>
  
		<?php


	}


	protected function content_template() {

		?>	
			<div class="breadcrumb-area section-padding light-bg-1 pb-0">
				<div class="container">
					<div class="row">
						<div class="col-xl-9 col-lg-9 col-md-9 col-12">
							<div class="section-title">
								<p>{{settings.about_sub_title}}</p>
								<h2>{{settings.about_title}}</h2>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xl-6 col-lg-6 col-md-6 col-12">
							<div class="direction-img">
								<img src="{{{settings.about_us_left_image.url}}}" alt="">
							</div>
						</div>
						<div class="col-xl-6 col-lg-6 col-md-6 col-12">
							<h3{{{settings.about_right_title}}}</h3>
							<p>{{{settings.about_right_desc}}}</p>
						</div>
					</div>
					<div class="row mt-90">
						<div class="col-12">
							<div class="bread-bg">
								<img src="{{{settings.about_us_bottom_image.url}}}" alt="">
							</div>
						</div>
					</div>
				</div>
			</div>

               
		<?php 
	}
}
