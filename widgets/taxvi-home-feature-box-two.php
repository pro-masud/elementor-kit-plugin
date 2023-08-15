<?php
class About_Feature_Box_Two extends \Elementor\Widget_Base {

	public function get_name() {
		return 'taxvi_feature_box_two';
	}

	public function get_title() {
		return esc_html__( 'Taxvi Feature Two Box', 'taxvi-pro' );
	}

	public function get_icon() {
		return 'eicon-image-before-after';
	}

	public function get_categories() {
		return [ 'taxvi_cat' ];
	}

	public function get_keywords() {
		return [ 'feature', 'taxvi','box' ];
	}

	protected function register_controls() {

	

		$this->start_controls_section(
			'section_taxvi_feature_box',
			[
				'label' => esc_html__( 'Feature Box', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		
		$feature_box = new \Elementor\Repeater();

		$feature_box->add_control(
			'feature_box_icons',
			[
				'label' => esc_html__( 'Feature Icons', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'flaticon-money-2',
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

		$feature_box->add_control(
			'feature_boxs_two_title',
			[
				'label' => esc_html__( 'Feature Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Best Taxation Service' , 'taxvi-pro' ),
				'label_block' => true,
			]
		);

		$feature_box->add_control(
			'feature_boxs_two_desc',
			[
				'label' => esc_html__( 'Feature Description', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks' , 'taxvi-pro' ),
				'label_block' => true,
			]
		);

		$feature_box->add_control(
			'feature_boxs_two_link',
			[
				'label' => esc_html__( 'Link', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'taxvi-pro' ),
				'options' => [ 'url' ],
				'default' => [
					'url' => '#',
				],
				'label_block' => true,
			]
		);


		$feature_box->add_control(
			'feature_boxs_two_time_head',[
			'label' => esc_html( 'Animation Time', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
			
		]);	

		$feature_box->add_control(
			'feature_boxs_two_time',
			[
				'label' => esc_html__( 'Set Animation Time', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( '200ms' , 'taxvi-pro' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'feature_box_lists',
			[
				'label' => esc_html__( 'Feature Box', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $feature_box->get_controls(),
				'default' => [
					[
						'feature_boxs_two_title' => esc_html__( 'Add New Feature', 'taxvi-pro' ),
					],
				],
				'title_field' => '{{{ feature_boxs_two_title }}}',
			]
		);

		

		$this->end_controls_section();



		$this->start_controls_section(
			'features_icon_style',
			[
				'label' => esc_html__( 'Feature ', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// icons heading
		$this->add_control(
			'features_icon_head',[
			'label' => esc_html( 'Icons', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);


		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'features_icon_type',
				'selector'	=> '{{WRAPPER}} .feature-icon i::before',
			]
		);

		// Btn Normal controls Tab Start
		$this->start_controls_tabs(
			'style_tabs_s'
		);

		$this-> start_controls_tab(
			'feature_icon_normal',
			[
				'label' => esc_html__( 'Normal', 'taxvi-pro' ),
			]

		);

		//icons Color
		$this->add_control(
			'title_normal_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .feature-icon i ' => 'color:{{VALUE}}',
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
				'selector' => '{{WRAPPER}} .single-feature-item .feature-icon',
			]
		);

		//Normal button Margin
		$this-> add_control('normal_margin',[
			'label'		=> esc_html( 'Margin', 'taxvi-pro'),
			'type'		=> \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'	=> ['px','%','em','rem'],
			'selectors'	=> ['{{WRAPPER}} .single-feature-item .feature-icon' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'],
		]);

		//Normal button Padding
		$this-> add_control('normal_padding',[
			'label'		=> esc_html( 'Padding', 'taxvi-pro'),
			'type'		=> \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'	=> ['px','%','em','rem'],
			'selectors'	=> ['{{WRAPPER}} .single-feature-item .feature-icon' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'],
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
					'{{WRAPPER}} .single-feature-item:hover .feature-icon i ' => 'color:{{VALUE}}',
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
				'selector' => '{{WRAPPER}} .single-feature-item:hover .feature-icon',
			]
		);

		//Hover button Margin
		$this-> add_control('hover_margin',[
			'label'		=> esc_html( 'Margin', 'taxvi-pro'),
			'type'		=> \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'	=> ['px','%','em','rem'],
			'selectors'	=> ['{{WRAPPER}} .single-feature-item:hover .feature-icon' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'],
		]);

		//Hover button Padding
		$this-> add_control('hover_padding',[
			'label'		=> esc_html( 'Padding', 'taxvi-pro'),
			'type'		=> \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'	=> ['px','%','em','rem'],
			'selectors'	=> ['{{WRAPPER}} .single-feature-item:hover .feature-icon' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'],
		]);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'fuature_icon_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		// title heading
		$this->add_control(
			'features_title_head',[
			'label' => esc_html( 'Box Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);


		$this->add_control(
			'features_title_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .feature-title h4' => 'color:{{VALUE}}',
				],
				'default'		=> '#fff'
			]
		);

		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'features_title_type',
				'selector'	=> '{{WRAPPER}} .feature-title h4',
			]
		);


		$this->add_control(
			'fuature_title_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		// title heading
		$this->add_control(
			'features_desc_head',[
			'label' => esc_html( 'Box Description', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		$this->add_control(
			'features_desc_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .single-feature-item p' => 'color:{{VALUE}}',
				],
			]
		);

		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'features_desc_type',
				'selector'	=> '{{WRAPPER}} .single-feature-item p',
			]
		);

		$this->add_control(
			'fuature_desc_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		// title heading
		$this->add_control(
			'features_button_icon_head',[
			'label' => esc_html( 'Box Button Icon', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		$this->add_control(
			'features_button_icon_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .service-details-link i' => 'color:{{VALUE}}',
				],
			]
		);

		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'features_button_icon_type',
				'selector'	=> '{{WRAPPER}} .service-details-link i',
			]
		);


		$this->add_control(
			'fuature_button_icon_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);


		$this->add_control(
			'features_box_head',[
			'label' => esc_html( 'Box Background', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);



		// Btn Normal controls Tab Start
		$this->start_controls_tabs(
			'feature_section_tabs_s'
		);

		$this-> start_controls_tab(
			'feature_section_normal',
			[
				'label' => esc_html__( 'Normal', 'taxvi-pro' ),
			]

		);

		// Button BG Color
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[	
				'label' => esc_html__( 'Background Color', 'taxvi-pro' ),
				'name' => 'feature_section_normal_bg',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .single-feature-item',
			]
		);

		$this->end_controls_tab();


		$this-> start_controls_tab(
			'feature_section_hover',
			[
				'label' => esc_html__( 'Hover', 'taxvi-pro' ),
			]

		);

		// Button Hover BG Color
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[	
				'label' => esc_html__( 'Background Color', 'taxvi-pro' ),
				'name' => 'feature_section_hover_bg',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .single-feature-item:hover',
			]
		);


		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();


		$this->start_controls_section(
			'features_section_style',
			[
				'label' => esc_html__( 'Feature Background ', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// icons heading
		$this->add_control(
			'features_section_head',[
			'label' => esc_html( 'Background', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[	
				'label' => esc_html__( 'Background Color', 'taxvi-pro' ),
				'name' => 'feature_section_bg',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .section-padding',
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$feature_box_lists = $settings['feature_box_lists'];

		?>
			<div class="feature-section feature-two section-padding">
				<div class="container">
					<div class="row">
						<?php foreach($feature_box_lists as $single_box){ ?>
						<div class="col-xl-4 col-lg-4 col-md-6 col-12 wow fadeInLeft animated" data-wow-delay="<?php echo esc_html($single_box['feature_boxs_two_time']); ?>">
							<div class="single-feature-item">
								<div class="feature-item-inner">
									<div class="feature-icon">
									<?php \Elementor\Icons_Manager::render_icon( $single_box['feature_box_icons'], [ 'aria-hidden' => 'true' ] ); ?>
									</div>
									<div class="feature-title">
										<h4><?php echo esc_html($single_box['feature_boxs_two_title']); ?></h4>
									</div>
								</div>
								<p><?php echo esc_html($single_box['feature_boxs_two_desc']); ?></p>                            
								<a href="<?php echo esc_url($single_box['feature_boxs_two_link']['url']); ?>" class="service-details-link">
									<i class="las la-arrow-right"></i>
								</a>
							</div>
						</div>
						<?php } ?>
					</div>
				</div>
			</div> 
  
		<?php


	}
}
