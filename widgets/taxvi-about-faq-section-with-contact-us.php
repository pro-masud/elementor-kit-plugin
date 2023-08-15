<?php
class Home_FAQ_And_Contact_Us extends \Elementor\Widget_Base {

	public function get_name() {
		return 'taxvi_faq_and_contact';
	}

	public function get_title() {
		return esc_html__( 'Taxvi FAQ And Contact Form', 'taxvi-pro' );
	}

	public function get_icon() {
		return 'eicon-slider-vertical';
	}

	public function get_categories() {
		return [ 'taxvi_cat' ];
	}

	public function get_keywords() {
		return [ 'faq', 'Contact','taxvi','Form' ];
	}

	protected function register_controls() {

		// Team Tab Start
		$this->start_controls_section(
			'faq_and_contact_left_heading',
			[
				'label' => esc_html__( 'Header Content', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);


		// about faq Sub Title
		$this->add_control(
			'faq_and_contact_sub_title',
			[
				'label' => esc_html__( 'Sub Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'General Questions', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		//  about faq Title
		$this->add_control(
			'faq_and_contact_title',
			[
				'label' => esc_html__( 'Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Frequently Asked Question.', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);


		//  about faq Repeater Section Here now
		$faq_and_contact = new \Elementor\Repeater();

		$faq_and_contact->add_control(
			'faq_and_contact_left_title',
			[
				'label' => esc_html__( 'Service Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'What Is Tax Advisor Services?' , 'taxvi-pro' ),
				'label_block' => true,
			]
		);

		$faq_and_contact->add_control(
			'faq_and_contact_left_desc',
			[
				'label' => esc_html__( 'Service Description', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore in fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident,' , 'taxvi-pro' ),
				'label_block' => true,
			]
		);


		$faq_and_contact->add_control(
			'faq_and_contact_left_desc_hide_show',
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
			'faq_and_contact_left_service_lists',
			[
				'label' => esc_html__( 'Our Service', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $faq_and_contact->get_controls(),
				'default' => [
					[
						'faq_and_contact_left_title' => esc_html__( 'Add New Service', 'taxvi-pro' ),
					],
				],
				'title_field' => '{{{ faq_and_contact_left_title }}}',
			]
		);

		$this->end_controls_section();


		// About Right Side
		$this->start_controls_section(
			'faq_and_contact_us',
			[
				'label' => esc_html__( 'Contact Form', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'faq_and_contact_form_sub_title',
			[
				'label' => esc_html__( 'Contact Sub Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'SEND A MESSAGE' , 'taxvi-pro' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'faq_and_contact_form_title',
			[
				'label' => esc_html__( 'Contact Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Request A Call Back' , 'taxvi-pro' ),
				'label_block' => true,
			]
		);


		$this->add_control(
			'faq_and_contact_shortcode',
			[
				'label' => esc_html__( 'Contact Form Shortcode', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => '[gallery id="123" size="medium"]',
				'default' => '[contact-form-7 id="1979" title="Contact form 1"]',
			]
		);


		


		$this->end_controls_section();



		// Style faq_and_contact Start
		$this->start_controls_section(
			'faq_and_contact_heading_style',
			[
				'label' => esc_html__( 'Header Content', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// cta sub title
		$this->add_control(
			'faq_and_contact_sub_title_haed',[
			'label' => esc_html( 'Sub Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// cta sub title color
		$this->add_control(
			'faq_and_contact_sub_title_color',
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
				'name'		=> 'faq_and_contact_sub_title_type',
				'selector'	=> '{{WRAPPER}} .section-title p',
				
				
			]
		);

		// cta sub divider color
		$this->add_control(
			'faq_and_contact_divider_bg_color',
			[
				'label' => esc_html__( 'Divider Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .section-title p::before' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'faq_and_contact_title_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		// cta sub head
		$this->add_control(
			'faq_and_contact_title_head',[
			'label' => esc_html( 'Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// cta sub title color
		$this->add_control(
			'faq_and_contact_title_main_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .section-title h2' => 'color: {{VALUE}}',
				],
				'default'		=> '#fff'
			]
		);


		// cta sub title type color
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'faq_and_contact_title_type',
				'selector'	=> '{{WRAPPER}} .section-title h2',			
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'faq_and_contact_service_style',
			[
				'label' => esc_html__( 'Service Style', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_control(
			'faq_and_contact_service_title_head',[
			'label' => esc_html( 'Service Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// cta sub title color
		$this->add_control(
			'faq_and_contact_service_title_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .faq-two .accordion.faqs .card .card-header .btn-link' => 'color: {{VALUE}}',
				],
			]
		);


		// cta sub title type color
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'faq_and_contact_service_title_type',
				'selector'	=> '{{WRAPPER}} .faq-two .accordion.faqs .card .card-header .btn-link',
				
				
			]
		);

		$this->add_control(
			'faq_and_contact_service_active_title_head',[
			'label' => esc_html( 'Active Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		$this->add_control(
			'faq_and_contact_service_title_active_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .faq-two .accordion.faqs .card .card-header .btn-link.active' => 'color: {{VALUE}}',
				],
			]
		);

	


		$this->add_control(
			'faq_and_contact_service_desc_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);


		$this->add_control(
			'faq_and_contact_service_desc_head',[
			'label' => esc_html( 'Service Description', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// cta sub title color
		$this->add_control(
			'faq_and_contact_service_desc_main_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .content p' => 'color: {{VALUE}}',
				],
			]
		);


		// cta sub title type color
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'faq_and_contact_service_desc_type',
				'selector'	=> '{{WRAPPER}} .content p',
				
				
			]
		);


		$this->add_control(
			'faq_and_contact_service_border_head',[
			'label' => esc_html( 'Border', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		$this->add_control(
			'faq_and_contact_service_border_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .faq-two .card ' => 'border-color: {{VALUE}}',
				],
			]
		);
		
		
		$this->end_controls_section();
		



		$this->start_controls_section(
			'faq_and_contact_form_style',
			[
				'label' => esc_html__( 'Contect Form Style', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_control(
			'faq_and_contact_form_sub_title_head',[
			'label' => esc_html( 'Form Sub Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);


		$this->add_control(
			'faq_and_contact_form_sub_title_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .contact-form-header p' => 'color: {{VALUE}}',
				],
			]
		);


		// cta sub title type color
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'faq_and_contact_form_sub_title_type',
				'selector'	=> '{{WRAPPER}} .contact-form-header p',
				
				
			]
		);

		$this->add_control(
			'faq_and_contact_form_title_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);


		$this->add_control(
			'faq_and_contact_form_title_head',[
			'label' => esc_html( 'Form Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);


		$this->add_control(
			'faq_and_contact_form_title_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .contact-form-header h2' => 'color: {{VALUE}}',
				],
			]
		);


		// cta sub title type color
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'faq_and_contact_form_title_type',
				'selector'	=> '{{WRAPPER}} .contact-form-header h2',
				
				
			]
		);


		$this->add_control(
			'faq_and_contact_form_input_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);


		$this->add_control(
			'faq_and_contact_form_input_head',[
			'label' => esc_html( 'Form Input', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);
		

		$this->add_control(
			'faq_and_contact_form_input_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .contact-form-inner input, .contact-form-inner textarea' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'faq_and_contact_input_bg',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .contact-form-inner input, .contact-form-inner textarea',
			]
		);


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
				'selector'	=> '{{WRAPPER}}  input[type="submit"] ',
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
					'{{WRAPPER}}  input[type="submit"]' => 'color:{{VALUE}} !important',
				],
			]
		);

		$this->add_control(
			'title_normal_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  input[type="submit"]' => 'background-color:{{VALUE}} !important',
				],
			]
		);


		//Normal button Margin
		$this-> add_control('normal_margin',[
			'label'		=> esc_html( 'Margin', 'taxvi-pro'),
			'type'		=> \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'	=> ['px','%','em','rem'],
			'selectors'	=> ['{{WRAPPER}} input[type="submit"]' => 'margin:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}  !important'],
		]);

		//Normal button Padding
		$this-> add_control('normal_padding',[
			'label'		=> esc_html( 'Padding', 'taxvi-pro'),
			'type'		=> \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'	=> ['px','%','em','rem'],
			'selectors'	=> ['{{WRAPPER}} input[type="submit"]' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}  !important'],
		]);

		//Normal button Padding
		$this-> add_control('normal_border_radius',[
			'label'		=> esc_html( 'Border Radius', 'taxvi-pro'),
			'type'		=> \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'	=> ['px','%','em','rem'],
			'selectors'	=> ['{{WRAPPER}}  input[type="submit"]' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}  !important'],
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
					'{{WRAPPER}} input[type="submit"]:hover ' => 'color:{{VALUE}}  !important',
				],
			]
		);


		$this->add_control(
			'title_hover_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} input[type="submit"]:hover ' => 'background-color:{{VALUE}}  !important',
				],
			]
		);


		$this-> add_control('hover_margin',[
			'label'		=> esc_html( 'Margin', 'taxvi-pro'),
			'type'		=> \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'	=> ['px','%','em','rem'],
			'selectors'	=> ['{{WRAPPER}}  input[type="submit"]:hover' => 'margin:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important'],
		]);

		$this-> add_control('hover_padding',[
			'label'		=> esc_html( 'Padding', 'taxvi-pro'),
			'type'		=> \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'	=> ['px','%','em','rem'],
			'selectors'	=> ['{{WRAPPER}}  input[type="submit"]:hover' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important'],
		]);

		$this-> add_control('hover_border_radius',[
			'label'		=> esc_html( 'Border Radius', 'taxvi-pro'),
			'type'		=> \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'	=> ['px','%','em','rem'],
			'selectors'	=> ['{{WRAPPER}}  input[type="submit"]:hover' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important'],
		]);

		$this->end_controls_tab();

		$this->end_controls_tabs();



		$this->end_controls_section();









		$this->start_controls_section(
			'faq_and_contact_form_bg_style',
			[
				'label' => esc_html__( 'Contect Form Box', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'contact_form_head_bg',[
			'label' => esc_html( 'Header Background', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,			
		]);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[	
				'label' => esc_html__( 'Background Color', 'taxvi-pro' ),
				'name' => 'contact_form_head_bg_color',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .contact-form-header',
			]
		);

		$this->add_control(
			'contact_form_main_head_bg',[
			'label' => esc_html( 'Background', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,			
		]);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[	
				'label' => esc_html__( 'Background Color', 'taxvi-pro' ),
				'name' => 'contact_form_head_main_bg_color',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .contact-form-inner',
			]
		);


		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		//  about faq section left side content
		$faq_and_contact_sub_title = $settings['faq_and_contact_sub_title'];
		$faq_and_contact_title = $settings['faq_and_contact_title'];
		$faq_and_contact_left_service_lists = $settings['faq_and_contact_left_service_lists'];


		// contact form content and shortcode 
		$faq_and_contact_form_sub_title = $settings['faq_and_contact_form_sub_title'];
		$faq_and_contact_form_title = $settings['faq_and_contact_form_title'];


		$contact_shortcode = $this->get_settings_for_display( 'faq_and_contact_shortcode' );

		$contact_shortcode = do_shortcode( shortcode_unautop( $contact_shortcode ) );

		?>

<div class="faq-section faq-two dark-bg section-padding">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-12 wow fadeInDown animated" data-wow-delay="200ms">
                    <div class="section-title">
                        <p><?php echo esc_html($faq_and_contact_sub_title); ?></p>
                        <h2><?php echo esc_html($faq_and_contact_title); ?></h2>            
                    </div>
                    <div class="accordion faqs" id="accordionFaq">
						<?php 
							$i = 1;
							foreach( $faq_and_contact_left_service_lists as $single_service){
							$i++;
						?>
                        <div class="card">
						<?php 

							if( $single_service['faq_and_contact_left_desc_hide_show'] == 'yes'){
								$active = 'active';
								$show = 'show';
							}else{
								$active = ' ';
								$show = ' ';
							}
						?>
                            <div class="card-header" id="heading<?php echo esc_attr($i); ?>">
                                <h5 class="mb-0 subtitle">
                                    <button class="btn btn-link collapsed <?php echo esc_html($active); ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo esc_attr($i); ?>" aria-expanded="true" aria-controls="collapse1">
                                       <?php echo esc_html($single_service['faq_and_contact_left_title']); ?>
                                    </button>
                                </h5>
                            </div>

                            <div id="collapse<?php echo esc_attr($i); ?>" class="collapse <?php echo esc_html($show); ?>" aria-labelledby="heading<?php echo esc_attr($i); ?>" data-parent="#accordionFaq">
                                <div class="card-body">
                                    <div class="content">
                                        <p> <?php echo esc_html($single_service['faq_and_contact_left_desc']); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
						<?php } ?>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-12 wow fadeInUp animated" data-wow-delay="200ms">
                    <div class="contact-form-wrap">
                        <div class="contact-form-header">
                            <p><?php echo esc_html($faq_and_contact_form_sub_title); ?></p>
							<h2><?php echo esc_html($faq_and_contact_form_title); ?></h2>
						</div>
						<div class="contact-form-inner">
							<form action="#">
								<!-- contact form shortcode -->
								<?php echo $contact_shortcode; ?>
							</form>
						</div>
					</div>
                </div>
            </div>
        </div>
    </div>
		<?php


	}
}
