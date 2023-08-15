<?php
class About_Company extends \Elementor\Widget_Base {

	public function get_name() {
		return 'taxvi_about_company';
	}

	public function get_title() {
		return esc_html__( 'Taxvi About Company', 'taxvi-pro' );
	}

	public function get_icon() {
		return 'eicon-captcha';
	}

	public function get_categories() {
		return [ 'taxvi_cat' ];
	}

	public function get_keywords() {
		return [ 'About', 'Company','Taxvi' ];
	}

	protected function register_controls() {

		// about company Tab Start
		$this->start_controls_section(
			'taxvi_company_heading',
			[
				'label' => esc_html__( 'Company Left Side', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		//about Content head
		$this->add_control(
			'company_heading',[
			'label' => esc_html( 'Heading', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
			
		]);	

		// Sub Title
		$this->add_control(
			'company_sub_title',
			[
				'label' => esc_html__( 'Sub Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'About Company', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		// Title
		$this->add_control(
			'company_title',
			[
				'label' => esc_html__( 'Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'We Are The Best Solution For Your Tax Services', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		// funder image
		$this->add_control(
			'company_founder_image',
			[
				'label' => esc_html__( 'Choose A Funder Image', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		// founder name 
		$this->add_control(
			'company_founder_name',
			[
				'label' => esc_html__( 'Founder Name', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Jhon Richard,', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		// job Title
		$this->add_control(
			'company_founder_job',
			[
				'label' => esc_html__( 'Job Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( ' Founder', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		// descritption
		$this->add_control(
			'company_founder_desc',
			[
				'label' => esc_html__( 'Description', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore in fugiat nulla pariatur.', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		// Bottom image
		$this->add_control(
			'company_bottom_image',
			[
				'label' => esc_html__( 'Choose Bottom A Image', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		// job Title
		$this->add_control(
			'company_buttom_text',
			[
				'label' => esc_html__( 'Button Text', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Discover More', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		// Bottom image
		$this->add_control(
			'company_buttom_link',
			[
				'label' => esc_html__( 'Button Link', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'taxvi-pro' ),
				'options' => [ 'url', 'is_external', 'nofollow' ],
				'default' => [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
				],
				'label_block' => true,
			]
		);

		$this->end_controls_section();

		// about company Tab Start
		$this->start_controls_section(
			'taxvi_company_right_heading',
			[
				'label' => esc_html__( 'Company Right Side', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		//about Content head
		$this->add_control(
			'company_heading_right',[
			'label' => esc_html( 'Right Image', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);	

		// Bottom image
		$this->add_control(
			'company_right_image',
			[
				'label' => esc_html__( 'Choose A Image', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		// Sub Title
		$this->add_control(
			'company_right_desc',
			[
				'label' => esc_html__( 'Description', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( "There are many variations of passages of Lorem Ipsum available, but the majority suffered alteration in some form, by injected humour, or randomised which don't look even slightly believable. ", 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		$feature_item = new \Elementor\Repeater();


		// icons 
		$feature_item->add_control(
			'feature_icon_left',
			[
				'label' => esc_html__( 'Feature Icon', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'far fa-check-circle',
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

		// item title
		$feature_item->add_control(
			'feature_title_left',
			[
				'label' => esc_html__( 'Feature Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( ' Best Taxation Service' , 'taxvi-pro' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'feature_items_left',
			[
				'label' => esc_html__( 'Feature Items Left', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $feature_item->get_controls(),
				'default' => [
					[
						'feature_title_left' => esc_html__( 'Add New Feature', 'taxvi-pro' ),
					],
				],
				'title_field' => '{{{ feature_title_left }}}',
			]
		);

		$feature_item_right = new \Elementor\Repeater();


		// icons 
		$feature_item_right->add_control(
			'feature_icon_right',
			[
				'label' => esc_html__( 'Feature Icon', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'far fa-check-circle',
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

		// item title
		$feature_item_right->add_control(
			'feature_title_right',
			[
				'label' => esc_html__( 'Feature Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Highly Dedicated Worker' , 'taxvi-pro' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'feature_items_right',
			[
				'label' => esc_html__( 'Feature Items Rights', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $feature_item_right->get_controls(),
				'default' => [
					[
						'feature_title_right' => esc_html__( 'Add New Feature', 'taxvi-pro' ),
					],
				],
				'title_field' => '{{{ feature_title_right }}}',
			]
		);






	$this->end_controls_section();


	// Style testimonial us Start
	$this->start_controls_section(
		'about_company_style',
		[
			'label' => esc_html__( 'Testimonial Content Style', 'taxvi-pro' ),
			'tab' => \Elementor\Controls_Manager::TAB_STYLE,
		]
	);

	// testimonial us heading
	$this->add_control(
		'about_company_head',[
			'label' => esc_html( 'Sub Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]
	);

	// sub title Color
	$this->add_control(
		'about_company_sub_title_color',
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
			'name'		=> 'about_company_sub_title_type',
			'selector'	=> '{{WRAPPER}} .section-title p',
		]
	);

	// sub title divider Color
	$this->add_control(
		'about_company_divider_color',
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
		'about_company_title_head',[
		'label' => esc_html( 'Title', 'taxvi-pro'),
		'type'	=>  \Elementor\Controls_Manager::HEADING,
	]);

	// sub title Color
	$this->add_control(
		'about_company_title_color',
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
			'name'		=> 'about_company_title_type',
			'selector'	=> '{{WRAPPER}} .section-title h2',
		]
	);

	
	// section background end
	$this->end_controls_section();


	// Style testimonial us Start
	$this->start_controls_section(
		'company_author_style',
		[
			'label' => esc_html__( 'Author Style', 'taxvi-pro' ),
			'tab' => \Elementor\Controls_Manager::TAB_STYLE,
		]
	);

	// testimonial us heading
	$this->add_control(
		'author_name_head',[
			'label' => esc_html( 'Author Background', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]
	);

	// author bg color 
	$this->add_group_control(
		\Elementor\Group_Control_Background::get_type(),
		[
			'name' => 'background',
			'types' => [ 'classic', 'gradient', 'video' ],
			'selector' => '{{WRAPPER}} .light-bg-2',
		]
	);

	// name heading
	$this->add_control(
		'company_author_name_head',[
			'label' => esc_html( 'Author Name', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]
	);

	// Name Color
	$this->add_control(
		'company_author_name_color',
		[
			'label' => esc_html__( 'Color', 'taxvi-pro' ),
			'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .founder-title h5' => 'color: {{VALUE}};',
			],
		]
	);

	// name type
	$this -> add_group_control(
		\Elementor\Group_Control_Typography::get_type(),
		[
			'name'		=> 'company_author_name_type',
			'selector'	=> '{{WRAPPER}} .founder-title h5',
		]
	);

	// description heading
	$this->add_control(
		'company_author_desc_head',[
			'label' => esc_html( 'Author Description', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]
	);

	// Name Color
	$this->add_control(
		'company_author_desc_color',
		[
			'label' => esc_html__( 'Color', 'taxvi-pro' ),
			'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .founder-content p' => 'color: {{VALUE}};',
			],
		]
	);

	// name type
	$this -> add_group_control(
		\Elementor\Group_Control_Typography::get_type(),
		[
			'name'		=> 'company_author_desc_type',
			'selector'	=> '{{WRAPPER}} .founder-content p',
		]
	);

	// button heading
	$this->add_control(
		'company_author_button_head',[
			'label' => esc_html( 'Button', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]
	);

	// Name Color
	$this->add_control(
		'company_author_button_color',
		[
			'label' => esc_html__( 'Color', 'taxvi-pro' ),
			'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .about-left-wrap a' => 'color: {{VALUE}};',
			],
		]
	);

	// name type
	$this -> add_group_control(
		\Elementor\Group_Control_Typography::get_type(),
		[
			'name'		=> 'company_author_button_type',
			'selector'	=> '{{WRAPPER}} .about-left-wrap a',
		]
	);

	$this->end_controls_section();

	// Style testimonial us Start
	$this->start_controls_section(
		'feature_section_style',
		[
			'label' => esc_html__( 'Feature Section', 'taxvi-pro' ),
			'tab' => \Elementor\Controls_Manager::TAB_STYLE,
		]
	);

	// testimonial us heading
	$this->add_control(
		'feature_desc_head',[
			'label' => esc_html( 'Description', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]
	);

	// Name Color
	$this->add_control(
		'feature_desc_color',
		[
			'label' => esc_html__( 'Color', 'taxvi-pro' ),
			'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .feature_desc' => 'color: {{VALUE}};',
			],
		]
	);

	// name type
	$this -> add_group_control(
		\Elementor\Group_Control_Typography::get_type(),
		[
			'name'		=> 'feature_desc_type',
			'selector'	=> '{{WRAPPER}} .feature_desc',
		]
	);


	$this->add_control(
		'feature_icon_head',[
			'label' => esc_html( 'Icon', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]
	);

	// Name Color
	$this->add_control(
		'feature_icon_color',
		[
			'label' => esc_html__( 'Color', 'taxvi-pro' ),
			'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .about-feature-list ul li i' => 'color: {{VALUE}};',
			],
		]
	);

	// name type
	$this -> add_group_control(
		\Elementor\Group_Control_Typography::get_type(),
		[
			'name'		=> 'feature_icon_type',
			'selector'	=> '{{WRAPPER}} .about-feature-list ul li i',
		]
	);

	$this->add_control(
		'feature_feature_title_head',[
			'label' => esc_html( 'Feature Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]
	);

	// Name Color
	$this->add_control(
		'feature_feature_title_color',
		[
			'label' => esc_html__( 'Color', 'taxvi-pro' ),
			'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .about-feature-list ul li' => 'color: {{VALUE}};',
			],
		]
	);

	// name type
	$this -> add_group_control(
		\Elementor\Group_Control_Typography::get_type(),
		[
			'name'		=> 'feature_feature_title_type',
			'selector'	=> '{{WRAPPER}} .about-feature-list ul li',
		]
	);


	

	$this->end_controls_section();


	}

	protected function render() {
		$settings = $this->get_settings_for_display();


		// left side contect
		 $company_sub_title = $settings['company_sub_title'];
		 $company_title = $settings['company_title'];
		 $company_founder_image = $settings['company_founder_image']['url'];
		 $company_founder_name = $settings['company_founder_name'];
		 $company_founder_job = $settings['company_founder_job'];
		 $company_founder_desc = $settings['company_founder_desc'];
		 $company_bottom_image = $settings['company_bottom_image']['url'];
		 $company_buttom_text = $settings['company_buttom_text'];
		 $company_buttom_link = $settings['company_buttom_link']['url'];


		//  right side contect
		$company_right_image = $settings['company_right_image']['url'];
		$company_right_desc = $settings['company_right_desc'];
		$feature_items_left = $settings['feature_items_left'];
		$feature_items_right = $settings['feature_items_right'];

		?>
			<div class="about-section about-two section-padding">
				<div class="container">
					<div class="row">
						<div class="col-xl-6 col-lg-6 col-12 wow fadeInDown animated" data-wow-delay="200ms">
							<div class="about-left-wrap">
								<div class="section-title">
									<p><?php echo esc_html($company_sub_title); ?></p>
									<h2><?php echo esc_html($company_title); ?></h2>
								</div>
								<div class="fouder-wrap light-bg-2">
									<div class="fouder-thumb">
										<img src="<?php echo esc_html($company_founder_image); ?>" alt="">
									</div>
									<div class="founder-content">
										<div class="founder-title">
											<h5><?php echo esc_html($company_founder_name); ?><span><?php echo esc_html($company_founder_job); ?></span></h5>
										</div>
										<p><?php echo esc_html($company_founder_desc); ?></p>
									</div>
								</div>
								<div class="about-left-img wow fadeInUp animated" data-wow-delay="400ms">
									<img src="<?php echo esc_html($company_bottom_image); ?>" alt="">
									<a href="<?php echo esc_url($company_buttom_link); ?>"><?php echo esc_html($company_buttom_text); ?></a>
								</div>
							</div>
						</div>
						<div class="col-xl-6 col-lg-6 col-12 wow fadeInRight animated" data-wow-delay="200ms">
							<div class="about-right-wrap">
								<div class="about-right-img">
									<img src="<?php echo esc_attr($company_right_image); ?>" alt="">
								</div>
								<p class="feature_desc"><?php echo esc_html($company_right_desc); ?></p>
								<div class="about-feature-list">
									<div class="row">
										<div class="col-md-6 col-12">
											<ul>
												<?php foreach($feature_items_left as $feature_item) { ?>
													<li><?php \Elementor\Icons_Manager::render_icon( $feature_item['feature_icon_left'], [ 'aria-hidden' => 'true' ] ); ?> <?php echo esc_html($feature_item['feature_title_left']); ?></li>
												<?php } ?>                               
											</ul>
										</div>
										<div class="col-md-6 col-12">
											<ul>
												<?php foreach($feature_items_right as $feature_item) { ?>
													<li><?php \Elementor\Icons_Manager::render_icon( $feature_item['feature_icon_right'], [ 'aria-hidden' => 'true' ] ); ?> <?php echo esc_html($feature_item['feature_title_right']); ?></li>
												<?php } ?> 
											</ul>
										</div>
									</div>
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
			<div class="about-section about-two section-padding">
				<div class="container">
					<div class="row">
						<div class="col-xl-6 col-lg-6 col-12 wow fadeInDown animated" data-wow-delay="200ms">
							<div class="about-left-wrap">
								<div class="section-title">
									<p>{{{settings.company_sub_title}}}</p>
									<h2>{{{settings.company_title}}}</h2>
								</div>
								<div class="fouder-wrap light-bg-2">
									<div class="fouder-thumb">
										<img src="{{{settings.company_founder_image.url}}}" alt="">
									</div>
									<div class="founder-content">
										<div class="founder-title">
											<h5>{{{settings.company_founder_name}}}<span>{{{settings.company_founder_job}}}</span></h5>
										</div>
										<p>{{{settings.company_founder_desc}}}</p>
									</div>
								</div>
								<div class="about-left-img wow fadeInUp animated" data-wow-delay="400ms">
									<img src="{{{settings.company_sub_title}}}" alt="">
									<a href="{{{settings.company_buttom_link}}}">{{{settings.company_buttom_text}}}</a>
								</div>
							</div>
						</div>
						<div class="col-xl-6 col-lg-6 col-12 wow fadeInRight animated" data-wow-delay="200ms">
							<div class="about-right-wrap">
								<div class="about-right-img">
									<img src="{{{settings.company_right_image.url}}}" alt="">
								</div>
								<p>{{{settings.company_right_desc}}}</p>
								<div class="about-feature-list">
									<div class="row">
										<div class="col-md-6 col-12">
											<ul>
														
												<# _.each( settings.feature_items_left, function( feature_item_left ) { #>
													<#
														var feature_item = elementor.helpers.renderIcon( view, settings.selected_icon, { 'aria-hidden': true }, 'i' , 'object' );
													#>
														<li>{{{feature_item_left.feature_item}}} {{{feature_item_left.feature_title_left}}} </li>
												<# }); #>
											</ul>
										</div>
										<div class="col-md-6 col-12">
											<ul>
														
												<# _.each( settings.feature_items_right, function( feature_single_right ) { #>
													<#
														var feature_item_right = elementor.helpers.renderIcon( view, settings.selected_icon, { 'aria-hidden': true }, 'i' , 'object' );
													#>
														<li>{{{feature_single_right.feature_item_right}}} {{{feature_single_right.feature_title_left}}} </li>
												<# }); #>
											</ul>
										</div>
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
