<?php
class Taxvi_Address_And_Contact_Us extends \Elementor\Widget_Base {

	public function get_name() {
		return 'taxvi_address_and_contact_us';
	}

	public function get_title() {
		return esc_html__( 'Taxvi Address And Contact Us', 'taxvi-pro' );
	}

	public function get_icon() {
		return 'eicon-slider-vertical';
	}

	public function get_categories() {
		return [ 'taxvi_cat' ];
	}

	public function get_keywords() {
		return [ 'address', 'Contact','taxvi','and', 'us', ];
	}

	protected function register_controls() {



		// About left Side
		$this->start_controls_section(
			'address_and_contact_us',
			[
				'label' => esc_html__( 'Contact Form', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'address_and_contact_us_form_title',
			[
				'label' => esc_html__( 'Contact Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'SEND A MESSAGE' , 'taxvi-pro' ),
				'label_block' => true,
			]
		);


		$this->add_control(
			'address_and_contact_us_shortcode',
			[
				'label' => esc_html__( 'Contact Form Shortcode', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => '[gallery id="123" size="medium"]',
				'default' => '[contact-form-7 id="2826" title="contact_us_two"]',
			]
		);


		


		$this->end_controls_section();

		// Team Tab Start
		$this->start_controls_section(
			'address_and_contact_us_right_heading',
			[
				'label' => esc_html__( 'Right Side Content', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);


		// about faq Sub Title
		$this->add_control(
			'address_and_contact_us_sub_title',
			[
				'label' => esc_html__( 'Sub Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'QUICK CONTACT', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		//  about faq Title
		$this->add_control(
			'address_and_contact_us_title',
			[
				'label' => esc_html__( 'Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Have Questions? Get in Touch!', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		$this->add_control(
			'address_and_contact_us_desc',
			[
				'label' => esc_html__( 'Description', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit fugit, sed quia consequuntur magni dolores eos qui ratione', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);


		//  about faq Repeater Section Here now
		$address_and_contact_us = new \Elementor\Repeater();



		$address_and_contact_us->add_control(
			'address_and_contact_us_icon',
			[
				'label' => esc_html__( 'Icon', 'taxvi-pro' ),
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

		$address_and_contact_us->add_control(
			'address_and_contact_us_left_title',
			[
				'label' => esc_html__( 'Service Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'What Is Tax Advisor Services?' , 'taxvi-pro' ),
				'label_block' => true,
			]
		);

		$address_and_contact_us->add_control(
			'address_and_contact_us_left_desc',
			[
				'label' => esc_html__( 'Service Description', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Free +88 (7900) 3322' , 'taxvi-pro' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'address_and_contact_us_left_service_lists',
			[
				'label' => esc_html__( 'Our Service', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $address_and_contact_us->get_controls(),
				'default' => [
					[
						'address_and_contact_us_left_title' => esc_html__( 'What Is Tax Advisor Services?', 'taxvi-pro' ),
					],
				],
				'title_field' => '{{{ address_and_contact_us_left_title }}}',
			]
		);

		$this->end_controls_section();






		
		



		$this->start_controls_section(
			'address_and_contact_us_form_style',
			[
				'label' => esc_html__( 'Contect Form Style', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_control(
			'address_and_contact_us_form_title_head',[
			'label' => esc_html( 'Form Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);


		$this->add_control(
			'address_and_contact_us_form_title_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .contact-form-wrapper h3' => 'color: {{VALUE}}',
				],
			]
		);


		// cta sub title type color
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'address_and_contact_us_form_title_type',
				'selector'	=> '{{WRAPPER}} .contact-form-wrapper h3',
				
				
			]
		);


		$this->add_control(
			'address_and_contact_us_form_input_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);


		$this->add_control(
			'address_and_contact_us_form_input_head',[
			'label' => esc_html( 'Form Input', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);
		

		$this->add_control(
			'address_and_contact_us_form_input_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .contact-form-wrapper input, .contact-form-wrapper textarea' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'address_and_contact_us_input_bg',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .contact-form-wrapper input, .contact-form-wrapper textarea',
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








		// Style address_and_contact_us Start
		$this->start_controls_section(
			'address_and_contact_us_heading_style',
			[
				'label' => esc_html__( 'Right Side Content', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// cta sub title
		$this->add_control(
			'address_and_contact_us_sub_title_haed',[
			'label' => esc_html( 'Sub Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// cta sub title color
		$this->add_control(
			'address_and_contact_us_sub_title_color',
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
				'name'		=> 'address_and_contact_us_sub_title_type',
				'selector'	=> '{{WRAPPER}} .section-title p',
				
				
			]
		);

		// cta sub divider color
		$this->add_control(
			'address_and_contact_us_divider_bg_color',
			[
				'label' => esc_html__( 'Divider Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .section-title p::before' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'address_and_contact_us_title_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		// cta sub head
		$this->add_control(
			'address_and_contact_us_title_head',[
			'label' => esc_html( 'Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// cta sub title color
		$this->add_control(
			'address_and_contact_us_title_main_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .section-title h2' => 'color: {{VALUE}}',
				],
			]
		);


		// cta sub title type color
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'address_and_contact_us_title_type',
				'selector'	=> '{{WRAPPER}} .section-title h2',			
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'address_and_contact_us_service_style',
			[
				'label' => esc_html__( 'Service Style', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_control(
			'address_and_contact_us_service_icons_head',[
			'label' => esc_html( 'Service Icon', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// cta sub title color
		$this->add_control(
			'address_and_contact_us_service_icon_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .contact-icon i' => 'color: {{VALUE}}',
				],
			]
		);


		// cta sub title type color
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'address_and_contact_us_service_icon_type',
				'selector'	=> '{{WRAPPER}} .contact-icon i',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[	
				'label' => esc_html__( 'Background Color', 'taxvi-pro' ),
				'name' => 'contact_form_head_service_icon_color',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .contact-icon',
			]
		);



		$this->add_control(
			'address_and_contact_us_icons_color_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);




		$this->add_control(
			'address_and_contact_us_service_desc_head',[
			'label' => esc_html( 'Service Description', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// cta sub title color
		$this->add_control(
			'address_and_contact_us_service_desc_main_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .contact-info p' => 'color: {{VALUE}}',
				],
			]
		);


		// cta sub title type color
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'address_and_contact_us_service_desc_type',
				'selector'	=> '{{WRAPPER}} .contact-info p',
				
				
			]
		);	

	


		$this->add_control(
			'address_and_contact_us_service_desc_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);	




		$this->add_control(
			'address_and_contact_us_service_title_head',[
			'label' => esc_html( 'Service Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// cta sub title color
		$this->add_control(
			'address_and_contact_us_service_title_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .contact-info h5' => 'color: {{VALUE}}',
				],
			]
		);


		// cta sub title type color
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'address_and_contact_us_service_title_type',
				'selector'	=> '{{WRAPPER}} .contact-info h5',
			]
		);


		
		$this->end_controls_section();









		$this->start_controls_section(
			'address_and_contact_us_form_bg_style',
			[
				'label' => esc_html__( 'Contect Form Box', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'contact_form_head_bg',[
			'label' => esc_html( 'Contact Box Background', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,			
		]);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[	
				'label' => esc_html__( 'Background Color', 'taxvi-pro' ),
				'name' => 'contact_form_head_bg_color',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .white-bg',
			]
		);

		$this->add_control(
			'contact_form_box_border_color',[
			'label' => esc_html( 'Contact Box Border', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,			
		]);


		$this->add_control(
			'address_and_contact_us_service_border_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .contact-page-inner' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'contact_form_box_showdow_bg',[
			'label' => esc_html( 'Contact Box Background', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,			
		]);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[	
				'label' => esc_html__( 'Background Color', 'taxvi-pro' ),
				'name' => 'contact_form_head_main_bg_color',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .contact-page-inner::after',
			]
		);

		$this->add_control(
			'contact_us_service_box_bg_color_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);


		$this->add_control(
			'contact_section_bg_colors',[
			'label' => esc_html( 'Contact Section Background', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,			
		]);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[	
				'label' => esc_html__( 'Background Color', 'taxvi-pro' ),
				'name' => 'contact_secion_main_bg_color',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .contact_bg',
			]
		);


		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();


		// contact form content and shortcode 
		$address_and_contact_us_form_title = $settings['address_and_contact_us_form_title'];




		// right content
		$address_and_contact_us_sub_title = $settings['address_and_contact_us_sub_title'];
		$address_and_contact_us_title = $settings['address_and_contact_us_title'];
		$address_and_contact_us_desc = $settings['address_and_contact_us_desc'];


		$address_and_contact_us_left_service_lists = $settings['address_and_contact_us_left_service_lists'];


		

		$contact_shortcode = $this->get_settings_for_display( 'address_and_contact_us_shortcode' );

		$contact_shortcode = do_shortcode( shortcode_unautop( $contact_shortcode ) );

		?>

	<div class="contact-page section-padding light-bg-1 contact_bg">
        <div class="container">            
            <div class="contact-page-inner white-bg">
                <div class="row">                
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="contact-form-wrapper contact_us_form">
                            <h3><?php echo esc_html($address_and_contact_us_form_title); ?></h3>
                            <form action="#">
								<?php echo $contact_shortcode; ?>
                            </form>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="contact-details-wrapper">
                            <div class="section-title">
                                <p><?php echo esc_html($address_and_contact_us_sub_title ); ?></p>
                                <h2><?php echo esc_html($address_and_contact_us_title ); ?></h2>
                            </div>
                            <p><?php echo esc_html($address_and_contact_us_desc ); ?></p>
                            <div class="contact-details">
								<?php 
									foreach( $address_and_contact_us_left_service_lists as $single_service){
								?>
									<div class="single-contact-info">
										<div class="contact-icon">
										<?php \Elementor\Icons_Manager::render_icon( $single_service['address_and_contact_us_icon'], [ 'aria-hidden' => 'true' ] ); ?>
										</div>
										<div class="contact-info">
											<p><?php echo esc_html($single_service['address_and_contact_us_left_title'] ); ?></p>
											<h5><?php echo esc_html($single_service['address_and_contact_us_left_desc']); ?></h5>
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
}
