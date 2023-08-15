<?php
class Taxvi_Chosse_Us extends \Elementor\Widget_Base {

	public function get_name() {
		return 'header_choose_us';
	}

	public function get_title() {
		return esc_html__( 'Taxvi Choose Us', 'taxvi-pro' );
	}

	public function get_icon() {
		return 'eicon-editor-h1';
	}

	public function get_categories() {
		return [ 'choose_us_cat' ];
	}

	public function get_keywords() {
		return [ 'choose', 'us', 'taxvi' ];
	}

	protected function register_controls() {

		
		$this->start_controls_section(
			'section_title',
			[
				'label' => esc_html__( 'Taxvi Choose Us', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		//Header Content
		$this->add_control(
			'heading',[
			'label' => esc_html( 'Heading Content', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
			'separator'	=> 'before'
		]);

		// Heading Sub Title
		$this->add_control(
			'choose_us_sub_title',
			[
				'label' => esc_html__( 'Sub Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'WHY CHOOSE US', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		// Heading Title
		$this->add_control(
			'choose_us_title',
			[
				'label' => esc_html__( 'Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'We Provide High-Quality Accounting & Tax Service', 'taxvi-pro' ),
			]
		);

		
		$this->add_control(
			'choose_us_title_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);


		$repeater = new \Elementor\Repeater();


		$repeater->add_control(
			'choose_us_icons',
			[
				'label' => esc_html__( 'Item Icon', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'far fa-check-square',
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

		$repeater->add_control(
			'choose_us_title',
			[
				'label' => esc_html__( 'Price Heading', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Years Experience' , 'taxvi-pro' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'choose_us_desc',
			[
				'label' => esc_html__( 'Price Description', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Many desktop packages and web page editors now use Lorem' , 'taxvi-pro' ),
				'label_block' => true,
			]
		);


		$this->add_control(
			'choose_us_list',
			[
				'label' => esc_html__( 'Choose Items', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'choose_us_title' => esc_html__( 'Years Experience', 'taxvi-pro' ),
					],
				],
				'title_field' => '{{{ choose_us_title }}}',
			]
		);

		$this->end_controls_section();





		// header Content style start
		$this->start_controls_section(
			'choose_us_section_title_style',
			[
				'label' => esc_html__( 'Taxvi Heading Style', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		//Sub Title Style Heading
		$this->add_control(
			'choose_us_sub_title_color_heading',[
			'label' => esc_html( 'Sub Title Color', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// Sub Title Color Controls
		$this->add_control(
			'choose_us_title_sub_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .section-title p' => 'color: {{VALUE}};',
				],
			]
		);

		//Sub Title Typography
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'choose_us_sub_title_type',
				'selector'	=> '{{WRAPPER}} .section-title p',
			]
		);

		
		$this->add_control(
			'choose_us_title_divider_color',
			[
				'label' => esc_html__( 'Devider Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .section-title p::before' => 'background-color: {{VALUE}};',
				],
				'separator'		=> 'after'
			]
		);



		//Title Style Heading
		$this->add_control(
			'choose_us_title_color_heading',[
			'label' => esc_html( 'Title Color', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);


		$this->add_control(
			'choose_us_title_title_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .section-title h2' => 'color: {{VALUE}};',
				],
			]
		);

		//Sub Title Typography
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'choose_us_title_type',
				'selector'	=> '{{WRAPPER}} .section-title h2',
			]
		);

		
		$this->end_controls_section();



		$this->start_controls_section(
			'choose_us_item_style',
			[
				'label' => esc_html__( 'Taxvi Choose Item', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_control(
			'choose_us_icon_heading',[
			'label' => esc_html( 'Icon ', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'choose_us_icon_type',
				'selector'	=> '{{WRAPPER}} .feature-icon i::before',
			]
		);

		$this->start_controls_tabs(
			'style_tabs_choose_table'
		);

		$this-> start_controls_tab(
			'feature_items_choose_table_normal',
			[
				'label' => esc_html__( 'Normal', 'taxvi-pro' ),
			]

		);

		$this->add_control(
			'choose_us_icon_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .feature-icon i' => 'color: {{VALUE}};',
				],
			]
		);

		// Button BG Color
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[	
				'label' => esc_html__( 'Background Color', 'taxvi-pro' ),
				'name' => 'choose_table_normal_bg',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .feature-icon',
			]
		);		


		$this->end_controls_tab();


		$this-> start_controls_tab(
			'choose_table_hover',
			[
				'label' => esc_html__( 'Hover', 'taxvi-pro' ),
			]

		);

		$this->add_control(
			'choose_us_icon_hover_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .feature-icon i:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[	
				'label' => esc_html__( 'Background Color', 'taxvi-pro' ),
				'name' => 'choose_table_hover_bg',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .choose-us-section .single-feature-item:hover .feature-icon',
			]
		);
		

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'choose_us_item_icons_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
		
		//Sub Title Style Heading
		$this->add_control(
			'choose_us_item_title_color_heading',[
			'label' => esc_html( 'Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// Sub Title Color Controls
		$this->add_control(
			'choose_us_item_title_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .feature-title h4' => 'color: {{VALUE}};',
				],
			]
		);

		//Sub Title Typography
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'choose_us_item_title_type',
				'selector'	=> '{{WRAPPER}} .feature-title h4',
			]
		);

		$this->add_control(
			'choose_us_item_title_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);


		$this->add_control(
			'choose_us_item_desc_color_heading',[
			'label' => esc_html( 'Description', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// Sub Title Color Controls
		$this->add_control(
			'choose_us_item_desc_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .single-feature-item p' => 'color: {{VALUE}};',
				],
				'default'			=> '#000'
			]
		);

		//Sub Title Typography
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'choose_us_item_desc_type',
				'selector'	=> '{{WRAPPER}} .single-feature-item p',
			]
		);

		$this->add_control(
			'choose_us_item_desc_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'choose_us_item_box_heading',[
			'label' => esc_html( 'Choose Background', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);


		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[	
				'label' => esc_html__( 'Background Color', 'taxvi-pro' ),
				'name' => 'choose_box_bg_color',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .choose-us-section .single-feature-item',
			]
		);

		$this->end_controls_section();



		$this->start_controls_section(
			'choose_us_section_style',
			[
				'label' => esc_html__( 'Taxvi Choose Section', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_control(
			'choose_us_section_heading',[
			'label' => esc_html( 'Background ', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[	
				'label' => esc_html__( 'Background Color', 'taxvi-pro' ),
				'name' => 'choose_section_bg_color',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .light-bg-1',
			]
		);

		$this->end_controls_section();



	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		// header information
		$choose_us_sub_title = $settings['choose_us_sub_title'];
		$choose_us_title = $settings['choose_us_title'];

		// priceing repater 
		$choose_us_list = $settings['choose_us_list'];
		?>
			

			<div class="choose-us-section section-padding light-bg-1">
				<div class="container">
					<div class="row">
						<div class="offset-xl-1 col-xl-10 text-center">
							<div class="section-title">
								<p><?php echo esc_html($choose_us_sub_title ); ?></p>
								<h2><?php echo esc_html($choose_us_title ); ?></h2>
							</div>
						</div>
					</div>
					<div class="row mt-60">
						<?php 
							$i = 1;
							
							foreach($choose_us_list as $single_chose_item){ 

							$i++;

							if( $i % 2 == 0){
								$margin_top = 'mt-60';
							}else{
								$margin_top = ' ';
							}
						?>
						<div class="col-xl-3 col-lg-3 col-md-6 col-12">
							<div class="single-feature-item <?php echo esc_html($margin_top); ?>">                        
									<div class="feature-icon">
									<?php \Elementor\Icons_Manager::render_icon( $single_chose_item['choose_us_icons'], [ 'aria-hidden' => 'true' ] ); ?>
									</div>
									<div class="feature-title">
										<h4><?php echo esc_html($single_chose_item['choose_us_title'] ); ?></h4>
									</div>                        
								<p><?php echo esc_html($single_chose_item['choose_us_desc'] ); ?></p>                                                    
							</div>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
			
			

		<?php


	}

}
