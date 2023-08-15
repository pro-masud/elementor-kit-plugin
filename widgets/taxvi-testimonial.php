<?php
class Testimonial_Section extends \Elementor\Widget_Base {

	public function get_name() {
		return 'taxvi_testimonial_section';
	}

	public function get_title() {
		return esc_html__( 'Taxvi Testimonial', 'taxvi-pro' );
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
				'default' => esc_html__( 'Testimonials', 'taxvi-pro' ),
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
			'testimonial_image',
			[
				'label' => esc_html__( 'Choose A Image', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		// testimonial icons 
		$testimonial->add_control(
			'testimonial_icon',
			[
				'label' => esc_html__( 'Icon', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-quote-left',
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

		// testimonial Description
		$testimonial->add_control(
			'our_textimonial_desc',
			[
				'label' => esc_html__( 'Testimonial Description', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Duis aute irure dolor in voluptate velit cillum dolore eu fugiat nulla pariatur. sint occaecat cupidatat non proident, ', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		// testimonial User Name
		$testimonial->add_control(
			'our_textimonial_name',
			[
				'label' => esc_html__( 'Name', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Shawn Beltran ', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		// testimonial Job Title
		$testimonial->add_control(
			'our_textimonial_job_title',
			[
				'label' => esc_html__( 'Job Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Entrepreneur', 'taxvi-pro' ),
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
						'list_title' => esc_html__( 'Add New Testimonial', 'taxvi-pro' ),
					],
				],
				'title_field' => '{{{ list_title }}}',
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
					'{{WRAPPER}} .section-title p' => 'color: {{VALUE}};',
				],
			]
		);


		// sub title type
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'testimonial_sub_title_type',
				'selector'	=> '{{WRAPPER}} .section-title p',
			]
		);

		// sub title divider Color
		$this->add_control(
			'testimonial_divider_color',
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
					'{{WRAPPER}} .section-title h2' => 'color: {{VALUE}};',
				],
				'default'		=> '#fff'
			]
		);


		// sub title type
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'testimonial_title_type',
				'selector'	=> '{{WRAPPER}} .section-title h2',
			]
		);

		
		// section background end
		$this->end_controls_section();

		// Style Tab End





		
		// Style about us middle Start
		$this->start_controls_section(
			'testimonial_style_head',
			[
				'label' => esc_html__( 'Testimonial Style', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// testimonial icons heading
		$this->add_control(
			'testimonial_icons_head',[
			'label' => esc_html( 'Icon', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// icon Color
		$this->add_control(
			'testimonial_icons_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .quote-sign i' => 'color: {{VALUE}};',
				],
			]
		);


		// icons type
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'testimonial_icons_type',
				'selector'	=> '{{WRAPPER}} .quote-sign i',
			]
		);






		

		// testimonial description heading
		$this->add_control(
			'testimonial_desc_head',[
			'label' => esc_html( 'Description', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// testimonial Color
		$this->add_control(
			'testimonial_desc_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .testimonial-content p' => 'color: {{VALUE}};',
				],
				'default'		=> '#1D1730'
			]
		);


		// testimonial type
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'testimonial_desc_type',
				'selector'	=> '{{WRAPPER}} .testimonial-content p',
			]
		);






		// testimonial name heading
		$this->add_control(
			'testimonial_name_head_color',[
			'label' => esc_html( 'Name', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// name Color
		$this->add_control(
			'testimonial_name_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .testimonial-content h5' => 'color: {{VALUE}};',
				],
			]
		);


		// name type
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'testimonial_name_type',
				'selector'	=> '{{WRAPPER}} .testimonial-content h5',
			]
		);


		// testimonial job title heading
		$this->add_control(
			'testimonial_job_title_head_color',[
			'label' => esc_html( 'Job Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// job title Color
		$this->add_control(
			'testimonial_job_title_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} span.job_title' => 'color: {{VALUE}};',
				],
			]
		);


		// job title type
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'testimonial_job_title_type',
				'selector'	=> '{{WRAPPER}} span.job_title',
			]
		);

		// testimonial job title heading
		$this->add_control(
			'testimonial_box_bg',[
			'label' => esc_html( 'Testimonial Box Background', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'testimonial_box_bg',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .single-testimonal-item',
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
				'name' => 'testimonial_section_bacground',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .green-bg',
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
			 <div class="testimonial-section testimonial-two green-bg section-padding pb-30">
				<div class="row">
					<div class="offset-xl-2 col-xl-8 text-center">
						<div class="section-title">
							<p><?php echo esc_html($our_textimonial_sub_title); ?></p>
							<h2><?php echo esc_html($our_textimonial_title_main); ?></h2>
						</div>
					</div>
				</div>
				<div class="container">
					<div class="testimonial-carousel owl-carousel">
						<?php foreach($testimonial_list as $single_testimonial){ ?>
						<div class="single-testimonal-item">
							<div class="testimonial-img">
								<img src="<?php echo esc_attr($single_testimonial['testimonial_image']['url']); ?>" alt="">
							</div>
							<div class="testimonial-content">
								<div class="quote-sign">
									<?php \Elementor\Icons_Manager::render_icon( $single_testimonial['testimonial_icon'], [ 'aria-hidden' => 'true' ] ); ?>
								</div>
								<p><?php echo esc_html($single_testimonial['our_textimonial_desc']); ?></p>
								<h5><?php echo esc_html($single_testimonial['our_textimonial_name']); ?></h5>
								<span class="job_title"><?php echo esc_html($single_testimonial['our_textimonial_job_title']); ?></span>
								<div class="testimonal-review-wrap">
									<i class="las la-star"></i>
									<i class="las la-star"></i>
									<i class="las la-star"></i>
									<i class="las la-star"></i>
									<i class="las la-star"></i>                        
								</div>
							</div>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
  
		<?php


	}


	protected function content_template() {

		?>	
			<div class="testimonial-section testimonial-two green-bg section-padding pb-30">
				<div class="row">
					<div class="offset-xl-2 col-xl-8 text-center">
						<div class="section-title">
							<p>{{{settings.our_textimonial_sub_title}}}</p>
							<h2 class="text-white">{{{settings.our_textimonial_title_main}}}</h2>
						</div>
					</div>
				</div>
				<div class="container">
					<div class="testimonial-carousel owl-carousel">
						<# _.each( settings.testimonial_list, function( single_testimonial ) { #>
							<div class="single-testimonal-item">
								<div class="testimonial-img">
									<img src="{{{single_testimonial.testimonial_image.url}}}" alt="">
								</div>
								<div class="testimonial-content">
									<div class="quote-sign">
										<#
											var testimonial_icons= elementor.helpers.renderIcon( view, settings.testimonial_icon, { 'aria-hidden': true }, 'i' , 'object' );
										#>	
										{{{testimonial_icons.value}}}
									</div>
									<p class="text-black">{{{single_testimonial.our_textimonial_desc}}}</p>
									<h5 class="testimonial-title">{{{single_testimonial.our_textimonial_name}}}<span>{{{single_testimonial.our_textimonial_job_title}}}</span></h5>
									<div class="testimonal-review-wrap">
										<i class="las la-star"></i>
										<i class="las la-star"></i>
										<i class="las la-star"></i>
										<i class="las la-star"></i>
										<i class="las la-star"></i>                        
									</div>
								</div>
							</div>
						<# }); #>
					</div>
				</div>
			</div>
               
		<?php 
	}
}
