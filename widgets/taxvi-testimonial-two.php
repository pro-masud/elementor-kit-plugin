<?php
class Testimonial_Two extends \Elementor\Widget_Base {

	public function get_name() {
		return 'taxvi_testimonial_two';
	}

	public function get_title() {
		return esc_html__( 'Taxvi Testimonial Two', 'taxvi-pro' );
	}

	public function get_icon() {
		return 'eicon-testimonial';
	}

	public function get_categories() {
		return [ 'taxvi_cat' ];
	}

	public function get_keywords() {
		return [ 'Testimonial', 'taxvi','section' ];
	}

	protected function register_controls() {

		// about Tab Start
		$this->start_controls_section(
			'taxvi_our_textimonial',
			[
				'label' => esc_html__( 'Textimonial Head', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		//Textimonial Content head
		$this->add_control(
			'our_textimonial_heading',[
			'label' => esc_html( 'Heading', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
			
		]);	

		// Sub Title
		$this->add_control(
			'our_textimonial_sub_title',
			[
				'label' => esc_html__( 'Sub Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Our Testimonials', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		// Title
		$this->add_control(
			'our_textimonial_title_main',
			[
				'label' => esc_html__( 'Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'A Satisfied Customer Is The Best Business Strategy Of All', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		// testimonial section start now

		$testimonial = new \Elementor\Repeater();

		// testimonial image
		$testimonial->add_control(
			'testimonial_user_image',
			[
				'label' => esc_html__( 'Choose A User Image', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		// testimonial User Name
		$testimonial->add_control(
			'our_textimonial_name',
			[
				'label' => esc_html__( 'Author Name', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Shawn Beltran', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		// testimonial Job Title
		$testimonial->add_control(
			'our_textimonial_designation',
			[
				'label' => esc_html__( 'Designation', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Entrepreneur', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		// testimonial Description
		$testimonial->add_control(
			'our_textimonial_desc',
			[
				'label' => esc_html__( 'Description', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Nemo enim ipsam voluptatem quia voluptas aut odit aut fugit sed quia consequuntur magni eos voluptatem sequi nesciunts Neque porro quisquam est, qui dolorem dolor', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		$this->add_control(
			'testimonial_list',
			[
				'label' => esc_html__( 'Testimonial', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $testimonial->get_controls(),
				'default' => [
					[
						'our_textimonial_name' => esc_html__( 'Add New Testimonial', 'taxvi-pro' ),
					],
				],
				'title_field' => '{{{ our_textimonial_name }}}',
			]
		);

		$this->end_controls_section();

		// Content Tab End






		// Style testimonial us Start
		$this->start_controls_section(
			'testimonial_style',
			[
				'label' => esc_html__( 'Testimonial Content Style', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// testimonial us heading
		$this->add_control(
			'testimonial_head',[
			'label' => esc_html( 'Sub Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
			]);

		// sub title Color
		$this->add_control(
			'testimonial_sub_title_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .section-title > h6' => 'color: {{VALUE}};',
				],
			]
		);


		// sub title type
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'testimonial_sub_title_type',
				'selector'	=> '{{WRAPPER}} .section-title > h6',
			]
		);

		// sub title divider Color
		$this->add_control(
			'testimonial_divider_color',
			[
				'label' => esc_html__( 'Divider Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .section-title h6' => 'border-color: {{VALUE}};',
				],
			]
		);


		// about us Title
		$this->add_control(
			'testimonial_title_head',[
			'label' => esc_html( 'Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// sub title Color
		$this->add_control(
			'testimonial_title_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .section-title > h2' => 'color: {{VALUE}};',
				],
			]
		);


		// sub title type
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'testimonial_title_type',
				'selector'	=> '{{WRAPPER}} .section-title > h2',
			]
		);

		
		// section background end
		$this->end_controls_section();

		// Style Tab End





		
		// Style single testimonia   Start
		$this->start_controls_section(
			'single_testimonial_style_head',
			[
				'label' => esc_html__( 'Testimonial Style', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_control(
			'single_testimonial_name_head',[
			'label' => esc_html( 'Author Name', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// name Color
		$this->add_control(
			'single_testimonial_name_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .testimonial-content h6' => 'color: {{VALUE}};',
				],
			]
		);


		// name title type
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'single_testimonial_name_type',
				'selector'	=> '{{WRAPPER}} .testimonial-content h6',
			]
		);

		//name hr
		$this->add_control(
			'testimonial_two_name_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);


		// designation head
		$this->add_control(
			'single_testimonial_designation_head',[
			'label' => esc_html( 'Designation', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// designation Color
		$this->add_control(
			'single_testimonial_designation_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .testimonial-content p' => 'color: {{VALUE}};',
				],
			]
		);

		// designation type
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'single_testimonial_designation_type',
				'selector'	=> '{{WRAPPER}} .testimonial-content p',
			]
		);

		//designation hr
		$this->add_control(
			'testimonial_two_designation_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);


		$this->add_control(
			'single_testimonial_div_bg',[
			'label' => esc_html( 'Single Testimonial Background', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'single_testimonial_background',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .single-testimonial-author',
			]
		);

		//designation hr
		$this->add_control(
			'single_testimonial_two_background_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'single_testimonial_div_active_bg',[
			'label' => esc_html( 'Single Testimonial Active Background', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'single_testimonial_active_background',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .single-testimonial-author.slick-current',
			]
		);

		$this->end_controls_section();









		// Style single testimonia   Start
		$this->start_controls_section(
			'slider_testimonial_style_head',
			[
				'label' => esc_html__( 'Testimonail Slider Style', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_control(
			'slider_testimonial_name_head',[
			'label' => esc_html( 'Author Name', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);


		$this->add_control(
			'slider_testimonial_name_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .testimonal-slider-content h6' => 'color: {{VALUE}};',
				],
			]
		);


		// name title type
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'single_testimonial_author_name_type',
				'selector'	=> '{{WRAPPER}} .testimonal-slider-content h6',
			]
		);


		$this->add_control(
			'slider_testimonial_author_name_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
		

		// author designation type
		$this->add_control(
			'slider_testimonial_designation_head',[
			'label' => esc_html( 'Author Desgination', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// author designation type
		$this->add_control(
			'slider_testimonial_designation_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} p.designation' => 'color: {{VALUE}};',
				],
			]
		);


		// name designation type
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'slider_testimonial_designation_type',
				'selector'	=> '{{WRAPPER}} p.designation',
			]
		);



		$this->add_control(
			'slider_testimonial_designation_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
		

		// author designation type
		$this->add_control(
			'slider_testimonial_description_head',[
			'label' => esc_html( 'Author Description', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// author designation type
		$this->add_control(
			'slider_testimonial_description_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} p.desc' => 'color: {{VALUE}};',
				],
			]
		);


		// name designation type
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'slider_testimonial_description_type',
				'selector'	=> '{{WRAPPER}} p.desc',
			]
		);

		$this->add_control(
			'slider_testimonial_desc_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'slider_testimonial_dots_head',[
			'label' => esc_html( 'Bullet', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		$this->add_control(
			'slider_testimonial_dots_bg_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .presentation button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'slider_testimonial_dots_border_color',
			[
				'label' => esc_html__( 'Border Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .presentation button' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'slider_testimonial_dots_active_color',
			[
				'label' => esc_html__( 'Active Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .slick-dots li.slick-active button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'slider_testimonial_button_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);


		$this->add_control(
			'slider_testimonial_bg_head',[
			'label' => esc_html( 'Slider Background', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);


		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'slider_testimonial_bg_section',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .testimonial-slide-inner',
			]
		);

		$this->end_controls_section();






		// testimonial section us Start
		$this->start_controls_section(
			'testimonial_section_style',
			[
				'label' => esc_html__( 'Testimonial Section', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// testimonial section heading
		$this->add_control(
			'testimonial_section_head',[
			'label' => esc_html( 'Section Background', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'testimonial_section_background',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .testimonial-bg',
			]
		);

		$this->end_controls_section();




	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$our_textimonial_sub_title = $settings['our_textimonial_sub_title'];
		$our_textimonial_title_main = $settings['our_textimonial_title_main'];
		$testimonial_list = $settings['testimonial_list'];


		?>
	<div class="testimonial-section section-padding testimonial-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 text-center">
                    <div class="section-title">
                        <h6><?php echo esc_html($our_textimonial_sub_title); ?></h6>
                        <h2><?php echo esc_html($our_textimonial_title_main); ?></h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-xl-12">
                    <div class="testimonial-wrapper-one">
                        <div class="testimonial-author-wrap">
							<?php foreach($testimonial_list as $single_testimonial ){ ?>
                            <div class="single-testimonial-author d-flex align-items-center">
                                <div class="testimonial-thumb">
                                    <img src="<?php echo esc_attr($single_testimonial['testimonial_user_image']['url']); ?>" alt="client-5">
                                </div>
                                <div class="testimonial-content">
                                    <h6><?php echo esc_html($single_testimonial['our_textimonial_name']); ?></h6>
                                    <p><?php echo esc_html($single_testimonial['our_textimonial_designation']); ?></p>
                                </div>
                            </div>
							<?php } ?>
                        </div>
        
                        <div class="testimonial-slider-wrap">
						<?php foreach($testimonial_list as $single_testimonial ){ ?>
                            <div class="testimonial-slide-inner">
                                <div class="testimonal-thumb">
                                    <img src="<?php echo esc_attr($single_testimonial['testimonial_user_image']['url']); ?>" alt="client-1">
                                </div>
                                <div class="testimonal-slider-content">
                                    <h6><?php echo esc_html($single_testimonial['our_textimonial_name']); ?></h6>
                                    <p class="designation"><?php echo esc_html($single_testimonial['our_textimonial_designation']); ?></p>
                                    <p class="desc"><?php echo esc_html($single_testimonial['our_textimonial_desc']); ?></p>
                                    <div class="testimonal-review-wrap">
                                        <i class="las la-star"></i>
                                        <i class="las la-star"></i>
                                        <i class="las la-star"></i>
                                        <i class="las la-star"></i>
                                        <i class="las la-star"></i>
                                        <span>3.4</span>
                                    </div>
                                </div>
                            </div>  
							<?php } ?>        
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
	<div class="testimonial-section section-padding testimonial-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 text-center">
                    <div class="section-title">
                        <h6>{{{settings.our_textimonial_sub_title}}}</h6>
                        <h2>{{{settings.our_textimonial_title_main}}}l</h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-xl-12">
                    <div class="testimonial-wrapper-one">
                        <div class="testimonial-author-wrap">
						<# _.each( settings.testimonial_list, function( single_testimonial ) { #>
                            <div class="single-testimonial-author d-flex align-items-center">
                                <div class="testimonial-thumb">
                                    <img src="{{{single_testimonial.testimonial_user_image.url}}}" alt="client-5">
                                </div>
                                <div class="testimonial-content">
                                    <h6>{{{single_testimonial.our_textimonial_name}}}</h6>
                                    <p>{{{single_testimonial.our_textimonial_designation}}}</p>
                                </div>
                            </div>
							<# }); #>
                        </div>
        
                        <div class="testimonial-slider-wrap">
							<# _.each( settings.testimonial_list, function( single_testimonial ) { #>
								<div class="testimonial-slide-inner">
									<div class="testimonal-thumb">
										<img src="{{{single_testimonial.testimonial_user_image.url}}}" alt="client-1">
									</div>
									<div class="testimonal-slider-content">
										<h6>{{{single_testimonial.our_textimonial_name}}}</h6>
										<p class="designation">{{{single_testimonial.our_textimonial_designation}}}</p>
										<p class="desc">{{{single_testimonial.our_textimonial_desc}}}</p>
										<div class="testimonal-review-wrap">
											<i class="las la-star"></i>
											<i class="las la-star"></i>
											<i class="las la-star"></i>
											<i class="las la-star"></i>
											<i class="las la-star"></i>
											<span>3.4</span>
										</div>
									</div>
								</div>    
							<# }); #>          
                        </div>  
                    </div>              
                </div>
            </div>
        </div>
    </div>

               
		<?php 
	}
}
