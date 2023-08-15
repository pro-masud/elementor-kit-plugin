<?php
class Taxvi_About_FAQ_Two extends \Elementor\Widget_Base {

	public function get_name() {
		return 'taxvi_about_faq_two';
	}

	public function get_title() {
		return esc_html__( 'Taxvi About FAQ Two', 'taxvi-pro' );
	}

	public function get_icon() {
		return 'eicon-slider-vertical';
	}

	public function get_categories() {
		return [ 'taxvi_cat' ];
	}

	public function get_keywords() {
		return [ 'about', 'faq','taxvi','section','two' ];
	}

	protected function register_controls() {



		$this->start_controls_section(
			'about_faq_two_top_heading',
			[
				'label' => esc_html__( 'About FAQ Heading', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);


		// about faq Sub Title
		$this->add_control(
			'about_faq_top_sub_title',
			[
				'label' => esc_html__( 'Heading Sub Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Frequently Asked Questions', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		$this->add_control(
			'about_faq_top_title_title',
			[
				'label' => esc_html__( 'Heading Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'How Can We Help You?', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);


		$this->end_controls_section();

		// Team Tab Start
		$this->start_controls_section(
			'about_faq_left_heading',
			[
				'label' => esc_html__( 'About FAQ Left Side', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);


		// about faq Sub Title
		$this->add_control(
			'about_faq_sub_title',
			[
				'label' => esc_html__( 'Sub Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Helpful Faq', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		//  about faq Title
		$this->add_control(
			'about_faq_title',
			[
				'label' => esc_html__( 'Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'We Always Answer Your Doubts ', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);


		//  about faq Repeater Section Here now
		$about_faq = new \Elementor\Repeater();

		$about_faq->add_control(
			'about_faq_left_title',
			[
				'label' => esc_html__( 'Service Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( ' What Is Tax Advisor Services?' , 'taxvi-pro' ),
				'label_block' => true,
			]
		);

		$about_faq->add_control(
			'about_faq_left_desc',
			[
				'label' => esc_html__( 'Service Description', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore in fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident,' , 'taxvi-pro' ),
				'label_block' => true,
			]
		);


		$about_faq->add_control(
			'about_faq_left_desc_hide_show',
			[
				'label' => esc_html__( 'Description Show and Hide', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'taxvi-pro' ),
				'label_off' => esc_html__( 'Hide', 'taxvi-pro' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->add_control(
			'about_faq_left_service_lists',
			[
				'label' => esc_html__( 'Our Service', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $about_faq->get_controls(),
				'default' => [
					[
						'about_faq_left_title' => esc_html__( 'Add New Service', 'taxvi-pro' ),
					],
				],
				'title_field' => '{{{ about_faq_left_title }}}',
			]
		);

		$this->end_controls_section();


		// About Right Side
		$this->start_controls_section(
			'about_faq_right_heading',
			[
				'label' => esc_html__( 'About FAQ Right Side', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);


		$this->add_control(
			'about_faq_right_image_one',
			[
				'label' => esc_html__( 'Choose A One Image', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'about_faq_right_image_two',
			[
				'label' => esc_html__( 'Choose A Two Image', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'about_faq_right_image_three',
			[
				'label' => esc_html__( 'Choose A Three Image', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);


		$this->end_controls_section();






		// section background head
		$this->start_controls_section(
			'about_faq_section_bg_head',
			[
				'label' => esc_html__( 'FAQ Section', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'about_faq_bg_haed',[
			'label' => esc_html( 'Background', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// section background
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'about_faq_section_background',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .section_bg',
			]
		);


		
		$this->end_controls_section();

	






		// Style about_faq Start
		$this->start_controls_section(
			'about_faq_heading_style',
			[
				'label' => esc_html__( 'FAQ Heading', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// cta sub title
		$this->add_control(
			'about_faq_sub_title_haed',[
			'label' => esc_html( 'Sub Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// cta sub title color
		$this->add_control(
			'about_faq_sub_title_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .header_top_info h6' => 'color: {{VALUE}}',
				],
			]
		);


		// sub title type color
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'about_faq_sub_title_type',
				'selector'	=> '{{WRAPPER}} .header_top_info h6',
				
				
			]
		);

		// cta sub divider color
		$this->add_control(
			'about_faq_divider_bg_color',
			[
				'label' => esc_html__( 'Divider Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .header_top_info h6' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'about_faq_title_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		// cta sub head
		$this->add_control(
			'about_faq_title_head',[
			'label' => esc_html( 'Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// cta sub title color
		$this->add_control(
			'about_faq_title_main_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .header_top_info h2' => 'color: {{VALUE}}',
				],
			]
		);


		// cta sub title type color
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'about_faq_title_type',
				'selector'	=> '{{WRAPPER}} .header_top_info h2',
				
				
			]
		);
	
		// section background end
		$this->end_controls_section();








		$this->start_controls_section(
			'about_faq_left_heading_style',
			[
				'label' => esc_html__( 'FAQ Left Side', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// cta sub title
		$this->add_control(
			'about_faq_left_sub_title_haed',[
			'label' => esc_html( 'Sub Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// cta sub title color
		$this->add_control(
			'about_faq_left_sub_title_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #faq-page .section-title p' => 'color: {{VALUE}}',
				],
			]
		);


		// sub title type color
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'about_faq_sub_title_left_type',
				'selector'	=> '{{WRAPPER}} #faq-page .section-title p',
				
				
			]
		);

		// cta sub divider color
		$this->add_control(
			'about_faq_left_divider_bg_color',
			[
				'label' => esc_html__( 'Divider Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  #faq-page .section-title p::before' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'about_faq_title_left_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		// cta sub head
		$this->add_control(
			'about_faq_title_left_head',[
			'label' => esc_html( 'Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// cta sub title color
		$this->add_control(
			'about_faq_title_left_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .section_left_info h2' => 'color: {{VALUE}}',
				],
			]
		);


		// cta sub title type color
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'about_faq_left_title_type',
				'selector'	=> '{{WRAPPER}} .section_left_info h2',
				
				
			]
		);
	
		// section background end
		$this->end_controls_section();



		$this->start_controls_section(
			'about_faq_left_item_style',
			[
				'label' => esc_html__( 'FAQ Service Items', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		
		$this->add_control(
			'about_faq_left_item_haed',[
			'label' => esc_html( 'Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);


		$this->add_control(
			'about_faq_item_title_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .accordion.faqs .card .card-header .btn-link' => 'color: {{VALUE}}',
				],
			]
		);


		// cta sub title type color
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'about_faq_left_item_title_type',
				'selector'	=> '{{WRAPPER}} .accordion.faqs .card .card-header .btn-link',
			]
		);


		$this->add_control(
			'about_faq_left_item_desc_haed',[
			'label' => esc_html( 'Description', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		$this->add_control(
			'about_faq_item_desc_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .accordion.faqs .card-body p' => 'color: {{VALUE}}',
				],
			]
		);


		// cta sub title type color
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'about_faq_left_item_desc_type',
				'selector'	=> '{{WRAPPER}} .accordion.faqs .card-body p',
			]
		);

		$this->add_control(
			'about_faq_left_item_bg_haed',[
			'label' => esc_html( 'Background', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'about_faq_item_background',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .accordion.faqs, .accordion.faqs .card, .accordion.faqs .card .card-header, .accordion.faqs .card .card-header .btn-link ',
			]
		);


		$this->add_control(
			'about_faq_item_border_color',
			[
				'label' => esc_html__( 'Border Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .accordion.faqs .card' => 'border-color: {{VALUE}}',
				],
			]
		);


		$this->end_controls_section();
		

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		// about faq top header
		$about_faq_top_sub_title = $settings['about_faq_top_sub_title'];
		$about_faq_top_title_title = $settings['about_faq_top_title_title'];


		//  about faq section left side content
		
		$about_faq_sub_title = $settings['about_faq_sub_title'];
		$about_faq_title = $settings['about_faq_title'];
		$about_faq_left_service_lists = $settings['about_faq_left_service_lists'];


		// about faq section right side content
		$about_faq_right_image_one = $settings['about_faq_right_image_one']['url'];
		$about_faq_right_image_two = $settings['about_faq_right_image_two']['url'];
		$about_faq_right_image_three = $settings['about_faq_right_image_three']['url'];

	

		?>

    <div id="faq-page" class="faq-section section-padding section_bg">
        <div class="container">
            <div class="row mb-60">
                <div class="offset-xl-3 col-xl-6 offset-lg-3 col-lg-6 text-center">
                    <div class="section-title header_top_info">
                        <h6><?php echo esc_html($about_faq_top_sub_title); ?></h6>
                        <h2><?php echo esc_html($about_faq_top_title_title); ?></h2>
                    </div>
                </div>
            </div>
            <div class="row">                
                <div class="col-xl-6 col-lg-6 col-12 wow fadeInUp animated" data-wow-delay="200ms">    
                    <div class="section-title section_left_info">
                        <p class="paragarp"><?php echo esc_html($about_faq_sub_title); ?></p>
                        <h2><?php echo esc_html($about_faq_title); ?></h2>
                    </div>                
                    <div class="accordion faqs" id="accordionFaq">
						<?php 	
							$i = 1;
							foreach($about_faq_left_service_lists as $single_item): 
							$i++;
						?>
                        <div class="card">
							<?php 
								if( $single_item['about_faq_left_desc_hide_show'] == 'yes'){
									$active = 'active';
									$show = 'show';
								}else{
									$active = ' ';
									$show = ' ';
								}							
							?>
                            <div class="card-header" id="heading<?php echo esc_attr($i); ?>">
                                <h5 class="mb-0 subtitle">
                                    <button class="btn btn-link collapsed <?php echo $active; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo esc_attr($i); ?>" aria-expanded="true" aria-controls="collapse1">
										<?php echo esc_html($single_item['about_faq_left_title']); ?>
                                    </button>
                                </h5>
                            </div>

                            <div id="collapse<?php echo esc_attr($i); ?>" class="collapse <?php echo $show; ?>" aria-labelledby="heading<?php echo esc_attr($i); ?>" data-parent="#accordionFaq">
                                <div class="card-body">
                                    <div class="content">
                                        <p><?php echo esc_html($single_item['about_faq_left_desc']); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
						<?php endforeach; ?>
					</div>
                </div>
                <div class="col-xl-6 col-lg-6 col-12">
                    <div class="faq-section-gallery">
                        <div class="faq-img-one wow fadeInDown animated" data-wow-delay="200ms">
                            <img src="<?php echo esc_attr($about_faq_right_image_one); ?>" alt="">
                        </div>
                        <div class="faq-img-two wow fadeInRight animated" data-wow-delay="300ms">
                            <img src="<?php echo esc_attr($about_faq_right_image_two); ?>" alt="">
                        </div>
                        <div class="faq-img-three wow fadeInUp animated" data-wow-delay="400ms">
                            <img src="<?php echo esc_attr($about_faq_right_image_three); ?>" alt="">
                        </div>
                    </div>
                </div>
            </div>            
        </div>        
    </div>
		<?php


	}
}



