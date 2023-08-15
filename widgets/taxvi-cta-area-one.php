<?php
class CTA_Area_One extends \Elementor\Widget_Base {

	public function get_name() {
		return 'taxvi_cta_area_one';
	}

	public function get_title() {
		return esc_html__( 'CTA Area Two', 'taxvi-pro' );
	}

	public function get_icon() {
		return 'eicon-slider-vertical';
	}

	public function get_categories() {
		return [ 'taxvi_cat' ];
	}

	public function get_keywords() {
		return [ 'cta', 'area', 'two' ];
	}

	protected function register_controls() {


		$this->start_controls_section(
			'cta_one_heading',
			[
				'label' => esc_html__( 'CTA One Area Content', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);


		// cta one Sub Title
		$this->add_control(
			'cta_one_sub_title',
			[
				'label' => esc_html__( 'Sub Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'GET STARTED', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		// cet one Title
		$this->add_control(
			'cta_one_title',
			[
				'label' => esc_html__( 'Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Changing Your Lives, Changing Your Futures', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		// cet desc Title
		$this->add_control(
			'cta_one_desc',
			[
				'label' => esc_html__( 'Description', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words look even slightly believable. If you are going to use a passage ', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		// cet button text
		$this->add_control(
			'cta_one_btn_text',
			[
				'label' => esc_html__( 'Button Text', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Discover More', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		// cet button url
		$this->add_control(
			'cta_one_btn_url',
			[
				'label' => esc_html__( 'Button URL', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'taxvi-pro' ),
				'options' => [ 'url', 'is_external', 'nofollow' ],
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
					// 'custom_attributes' => '',
				],
				'label_block' => true,
			]
		);


		// cet button url
		$this->add_control(
			'cta_one_btn_youtube',
			[
				'label' => esc_html__( 'YouTube Video Link', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://youtube.com', 'taxvi-pro' ),
				'options' => [ 'url', 'is_external', 'nofollow' ],
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
					// 'custom_attributes' => '',
				],
				'label_block' => true,
			]
		);

		$this->add_control(
			'cta_media_icons',
			[
				'label' => esc_html__( 'Media Icons', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-play',
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

		$this->end_controls_section();




		$this->start_controls_section(
			'cta_section_bg_head',
			[
				'label' => esc_html__( 'Section Background', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		// section background
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'cta_section_background',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .bg-cover',
			]
		);


		
		$this->end_controls_section();


		// Style team Start
		$this->start_controls_section(
			'cta_area_one_heading_style',
			[
				'label' => esc_html__( 'CTA Area Two Style', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// cta sub title
		$this->add_control(
			'cta_one_sub_title_haed',[
			'label' => esc_html( 'Sub Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// cta sub title color
		$this->add_control(
			'team_sub_title_color',
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
				'name'		=> 'team_sub_title_type',
				'selector'	=> '{{WRAPPER}} .section-title p',
				
				
			]
		);

		// cta sub divider color
		$this->add_control(
			'cta_divider_bg_color',
			[
				'label' => esc_html__( 'Divider Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .section-title p::before' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'cta_one_title_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		// cta sub head
		$this->add_control(
			'cta_one_title_head',[
			'label' => esc_html( 'Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// cta sub title color
		$this->add_control(
			'cta_one_title_main_color',
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
				'name'		=> 'cta_one_title_type',
				'selector'	=> '{{WRAPPER}} .section-title h2',
				
				
			]
		);

		$this->add_control(
			'cta_desc_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		// cta sub head
		$this->add_control(
			'cta_one_desc_head',[
			'label' => esc_html( 'Description', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// cta sub title color
		$this->add_control(
			'cta_one_desc_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cta_desc p' => 'color: {{VALUE}}',
				],
			]
		);


		// cta sub title type color
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'cta_one_desc_type',
				'selector'	=> '{{WRAPPER}} .cta_desc p',
				
				
			]
		);

		$this->add_control(
			'team_desc_title_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		// box Job desc head
		$this->add_control(
			'cta_one_btn_head',[
			'label' => esc_html( 'Button', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// job desc typography
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'cta_one_btn_type',
				'selector'	=> '{{WRAPPER}} .main-btn',
				
			]
		);

		// Btn controls Tab Start
		$this->start_controls_tabs(
			'style_tabs_s'
		);

		$this-> start_controls_tab(
			'cta_one_btn_normal',
			[
				'label' => esc_html__( 'Normal', 'taxvi-pro' ),
			]

		);

		//Title Color
		$this->add_control(
			'cta_one_btn_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .main-btn' => 'color:{{VALUE}}',
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
				'selector' => '{{WRAPPER}} .main-btn',
			]
		);

		$this->add_control(
			'team_bg_color_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		//Normal button Margin
		$this-> add_control('normal_margin',[
			'label'		=> esc_html( 'Margin', 'picchi_extrantion'),
			'type'		=> \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'	=> ['px','%','em','rem'],
			'selectors'	=> ['{{WRAPPER}} .main-btn' => 'margin:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'],
		]);

		$this->add_control(
			'team_normal_padding_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		//Normal button Padding
		$this-> add_control('normal_padding',[
			'label'		=> esc_html( 'Padding', 'picchi_extrantion'),
			'type'		=> \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'	=> ['px','%','em','rem'],
			'selectors'	=> ['{{WRAPPER}} .main-btn' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'],
		]);

		$this->end_controls_tab();



		
		// Btn Hover controls Tab Start
		$this-> start_controls_tab(
			'cta_one_btn_hover',
			[
				'label' => esc_html__( 'Hover', 'taxvi-pro' ),
			]

		);

		//Hover Title Color
		$this->add_control(
			'cta_one_hover_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .main-btn:hover' => 'color:{{VALUE}}',
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
				'selector' => '{{WRAPPER}} .main-btn:hover',
			]
		);

		$this->add_control(
			'cta_one_btn_margin_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		//Hover button Margin
		$this-> add_control('hover_margin',[
			'label'		=> esc_html( 'Margin', 'picchi_extrantion'),
			'type'		=> \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'	=> ['px','%','em','rem'],
			'selectors'	=> ['{{WRAPPER}} .main-btn:hover' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'],
		]);

		$this->add_control(
			'hover_padding_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
		//Hover button Padding
		$this-> add_control('hover_padding',[
			'label'		=> esc_html( 'Padding', 'picchi_extrantion'),
			'type'		=> \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'	=> ['px','%','em','rem'],
			'selectors'	=> ['{{WRAPPER}} .main-btn:hover' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'],
		]);



		// Btn controls Tab Start
		$this->end_controls_tabs();

		$this->add_control(
			'cta_youtube_media_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
		// cta sub title
		$this->add_control(
			'cta_one_scope_haed',[
			'label' => esc_html( 'Media Scope Style', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// cta icons color
		$this->add_control(
			'cta_one_scope_icons_color',
			[
				'label' => esc_html__( 'Scope Icon Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pop-up-video a.video-play-btn i' => 'color: {{VALUE}}',
				],
			]
		);

		// cta scope media bg color
		$this->add_control(
			'cta_one_scope_color',
			[
				'label' => esc_html__( 'Scope Background Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pop-up-video a.video-play-btn' => 'background: {{VALUE}}',
				],
			]
		);

		// cta scope border color
		$this->add_control(
			'cta_one_scope_border_color',
			[
				'label' => esc_html__( 'Scope Border Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pop-up-video a.video-play-btn' => 'border-color: {{VALUE}}',
				],
			]
		);

	
		// section background end
		$this->end_controls_section();

		// Style Tab End

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$cta_one_sub_title = $settings['cta_one_sub_title'];
		$cta_one_title = $settings['cta_one_title'];
		$cta_one_desc = $settings['cta_one_desc'];
		$cta_one_btn_text = $settings['cta_one_btn_text'];
		$cta_one_btn_url = $settings['cta_one_btn_url']['url'];
		$cta_one_btn_youtube = $settings['cta_one_btn_youtube']['url'];



		?>
		<div class="cta-area cta-three bg-cover">
			<div class="overlay"></div>
			<div class="cta-area-inner pt-100">
				<div class="container">
					<div class="offset-xl-2 col-xl-6 offset-lg-1 col-lg-6 col-md-8">
						<div class="section-title">
							<p><?php echo esc_html($cta_one_sub_title); ?></p>
							<h2><?php echo esc_html($cta_one_title); ?></h2>
						</div>
						<a href="<?php echo esc_url($cta_one_btn_url); ?>" class="main-btn mt-20"><?php echo esc_html($cta_one_btn_text); ?></a>                    
					</div>
					<div class="offset-xl-4 col-xl-7 offset-lg-4 col-lg-7 offset-md-4 col-md-7 cta_desc">
						<p><?php echo esc_html($cta_one_desc); ?></p>
					</div>
					<div class="pop-up-video">
						<a href="<?php echo esc_url($cta_one_btn_youtube); ?>" class="video-play-btn mfp-iframe">
						<?php \Elementor\Icons_Manager::render_icon( $settings['cta_media_icons'], [ 'aria-hidden' => 'true' ] ); ?> <span></span>
						</a>
					</div>
				</div>
			</div>
		</div>
		<?php


	}


	protected function content_template() {

		?>	


			<div class="cta-area cta-three bg-cover">
				<div class="overlay"></div>
				<div class="cta-area-inner pt-100">
					<div class="container">
						<div class="offset-xl-2 col-xl-6 offset-lg-1 col-lg-6 col-md-8">
							<div class="section-title">
								<p>{{settings.cta_one_sub_title}}</p>
								<h2 >{{settings.cta_one_title}}</h2>
							</div>
							<a href="{{settings.cta_one_btn_url.url}}" class="main-btn mt-20">{{settings.cta_one_btn_text}}</a>                    
						</div>
						<div class="offset-xl-4 col-xl-7 offset-lg-4 col-lg-7 offset-md-4 col-md-7 cta_desc">
							<p>{{settings.cta_one_desc}}</p>
						</div>
						<div class="pop-up-video">
							<a href="{{settings.cta_one_btn_youtube.url}}" class="video-play-btn mfp-iframe">
								<#
									var mediaIcons = elementor.helpers.renderIcon( view, settings.cta_media_icons, { 'aria-hidden': true }, 'i' , 'object' );
								#>
								{{{mediaIcons.value}}} <span></span>
							</a>
						</div>
					</div>
				</div>
			</div>
               
		<?php 
	}
}
