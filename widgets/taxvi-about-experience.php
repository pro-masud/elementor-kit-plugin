<?php
class About_Experience extends \Elementor\Widget_Base {

	public function get_name() {
		return 'taxvi_about_experience';
	}

	public function get_title() {
		return esc_html__( 'Taxvi About Experience', 'taxvi-pro' );
	}

	public function get_icon() {
		return 'eicon-kit-details';
	}

	public function get_categories() {
		return [ 'taxvi_cat' ];
	}

	public function get_keywords() {
		return [ 'Experience', 'taxvi', 'about' ];
	}

	protected function register_controls() {

		// Team Tab Start
		$this->start_controls_section(
			'taxvi_about_experience_heading',
			[
				'label' => esc_html__( 'Left Side', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		//Team Content
		$this->add_control(
			'taxvi_about_experience_head',[
			'label' => esc_html( 'Left Image', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
			
		]);	

		$this->add_control(
			'about_experience_left_image',
			[
				'label' => esc_html__( 'Choose A Image', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->end_controls_section();


		// Team Tab Start
		$this->start_controls_section(
			'taxvi_about_experience_right_heading',
			[
				'label' => esc_html__( 'Right Side', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		//Team Content
		$this->add_control(
			'taxvi_about_experience_right_head',[
				'label' => esc_html( 'Right Content', 'taxvi-pro'),
				'type'	=>  \Elementor\Controls_Manager::HEADING,
			]
		);	

		// sub title 
		$this->add_control(
			'taxvi_about_experience_right_sub_title',
			[
				'label' => esc_html__( 'Sub Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'ABOUT Experience', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);
		
		// title 
		$this->add_control(
			'taxvi_about_experience_title',
			[
				'label' => esc_html__( 'Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Helping You Put Systems in Place that Work', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		// title 
		$this->add_control(
			'taxvi_about_experience_desc',
			[
				'label' => esc_html__( 'Description', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, ', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		$circle_progress = new \Elementor\Repeater();

		$circle_progress->add_control(
			'progress_title',
			[
				'label' => esc_html__( 'Progress Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'List Title' , 'taxvi-pro' ),
				'label_block' => true,
			]
		);

		$circle_progress->add_control(
			'progress_number',
			[
				'label' => esc_html__( 'Progress Number', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => esc_html__( '99' , 'taxvi-pro' ),
				'label_block' => true,
			]
		);

		$circle_progress->add_control(
			'progress_type',
			[
				'label' => esc_html__( 'Progress Type', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( '%' , 'taxvi-pro' ),
				'label_block' => true,
			]
		);


		$this->add_control(
			'progress_list',
			[
				'label' => esc_html__( 'Circle Progress', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $circle_progress->get_controls(),
				'default' => [
					[
						'progress_title' => esc_html__( 'Add New Progress', 'taxvi-pro' ),
					]
				],
				'title_field' => '{{{ progress_title }}}',
			]
		);

		$this->end_controls_section();



		// Style team Start
		$this->start_controls_section(
			'team_about_experience_style',
			[
				'label' => esc_html__( 'Right Style', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// Team heading
		$this->add_control(
			'about_experience_head',[
			'label' => esc_html( 'Sub Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// Counter number Color
		$this->add_control(
			'about_experience_sub_title_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .section-title p' => 'color: {{VALUE}};',
				],
			]
		);


		// sub title type color
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'about_experience_sub_title_type',
				'selector'	=> '{{WRAPPER}} .section-title p',
				
				
			]
		);

		// Counter number Color
		$this->add_control(
			'about_experience_devider_color',
			[
				'label' => esc_html__( 'Divider Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .section-title p::before' => 'background: {{VALUE}};',
				],
			]
		);
		


		// Team Title
		$this->add_control(
			'about_experience_title',[
			'label' => esc_html( 'Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// Title Color
		$this->add_control(
			'about_experience_title_color',
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
				'name'		=> 'about_experience_title_type',
				'selector'	=> '{{WRAPPER}} .section-title h2',
			]
		);


		$this->add_control(
			'about_experience_desc_head',[
			'label' => esc_html( 'Description', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// Counter number Color
		$this->add_control(
			'about_experience_desc_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .about-right-wrap > p' => 'color: {{VALUE}};',
				],
			]
		);


		// sub title type color
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'about_experience_desc_type',
				'selector'	=> '{{WRAPPER}} .about-right-wrap p',			
			]
		);

		$this->add_control(
			'circle_progress_box',[
			'label' => esc_html( 'Progress Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// Counter number Color
		$this->add_control(
			'circle_progress_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .circle_progress_content h6' => 'color: {{VALUE}};',
				],
			]
		);


		// sub title type color
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'circle_progress_type',
				'selector'	=> '{{WRAPPER}} .circle_progress_content h6',			
			]
		);

		$this->add_control(
			'circle_progress_number_box',[
			'label' => esc_html( 'Progress Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// Counter number Color
		$this->add_control(
			'circle_progress_number_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .circle_progress_box span' => 'color: {{VALUE}};',
				],
			]
		);


		// sub title type color
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'circle_progress_number_type',
				'selector'	=> '{{WRAPPER}} .circle_progress_box span',			
			]
		);

		// section background end
		$this->end_controls_section();


	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		// right side
		 $about_experience_left_image = $settings['about_experience_left_image']['url'];

		// left side
		 $taxvi_about_experience_right_sub_title = $settings['taxvi_about_experience_right_sub_title'];
		 $taxvi_about_experience_title = $settings['taxvi_about_experience_title'];
		 $taxvi_about_experience_desc = $settings['taxvi_about_experience_desc'];

		 $progress_list = $settings['progress_list'];

		?>
	<div class="about-section about-two section-padding">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-12 wow fadeInLeft animated" data-wow-delay="200ms">
                    <div class="about-left-wrap">
                        <img src="<?php echo esc_url($about_experience_left_image); ?>" alt="">
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-12 wow fadeInUp animated" data-wow-delay="400ms">
                    <div class="about-right-wrap">
                        <div class="section-title">
                            <p><?php echo esc_html($taxvi_about_experience_right_sub_title); ?></p>
                            <h2><?php echo esc_html($taxvi_about_experience_title); ?></h2>
                        </div>
                        <p><?php echo esc_html($taxvi_about_experience_desc); ?></p>
                        <div class="circle_progress_area pt-30">
                            <div class="circle_progress_wrap">
								<?php foreach($progress_list as $progress_single){ ?>
									<div class="circle_progress_single">
										<div class="circle_progress_box">
											<div id="circle_progress"></div>
											<span><?php echo esc_html($progress_single['progress_number']); ?><?php echo esc_html($progress_single['progress_type']); ?></span>
										</div>
										<div class="circle_progress_content">
											<h6><?php echo esc_html($progress_single['progress_title']); ?></h6>
										</div>
									</div>
								<?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
		<?php


	}


	// protected function content_template() {

	// }
}
