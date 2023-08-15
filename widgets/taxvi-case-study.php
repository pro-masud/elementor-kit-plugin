<?php
class Case_Study extends \Elementor\Widget_Base {

	public function get_name() {
		return 'taxvi_case_study';
	}

	public function get_title() {
		return esc_html__( 'Taxvi Case Study', 'taxvi-pro' );
	}

	public function get_icon() {
		return 'eicon-slider-vertical';
	}

	public function get_categories() {
		return [ 'taxvi_cat' ];
	}

	public function get_keywords() {
		return [ 'case', 'study','taxvi' ];
	}

	protected function register_controls() {

		// Team Tab Start
		$this->start_controls_section(
			'case_study_heading',
			[
				'label' => esc_html__( 'Case Study Content', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);


		// cta three Sub Title
		$this->add_control(
			'case_study_sub_title',
			[
				'label' => esc_html__( 'Sub Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Case Studies', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		// cet three Title
		$this->add_control(
			'case_study_title',
			[
				'label' => esc_html__( 'Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Delivering our clients more project clarity, greater insight, and less chaos.', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		// cet button text
		$this->add_control(
			'case_study_btn_text',
			[
				'label' => esc_html__( 'Button Text', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'View All Projects', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		// cet button url
		$this->add_control(
			'case_study_btn_url',
			[
				'label' => esc_html__( 'Button URL', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'taxvi-pro' ),
				'options' => [ 'url', 'is_external', 'nofollow' ],
				'default' => [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
					// 'custom_attributes' => '',
				],
				'label_block' => true,
			]
		);

		$this->end_controls_section();











		// section background head
		$this->start_controls_section(
			'case_study_left_side_head',
			[
				'label' => esc_html__( 'Case Study Left Side', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'case_study_left_side_haed',[
			'label' => esc_html( 'Left Content', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		$this->add_control(
			'case_study_left_title',
			[
				'label' => esc_html__( 'Hover Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Short-Range Tax Planning', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		$this->add_control(
			'case_study_left_desc',
			[
				'label' => esc_html__( 'Hover Description', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'There are many variations of passages Lorem Ipsum available', 'taxvi-pro' ),
				'placeholder' => esc_html__( 'Type your description here', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		// left hover button text
		$this->add_control(
			'case_study_left_btn_text',
			[
				'label' => esc_html__( 'Hover Button Text', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Read More', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		// left hover button url
		$this->add_control(
			'case_study_left_btn_url',
			[
				'label' => esc_html__( 'Hover Button URL', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'taxvi-pro' ),
				'options' => [ 'url', 'is_external', 'nofollow' ],
				'default' => [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
					// 'custom_attributes' => '',
				],
				'label_block' => true,
			]
		);

		$this->add_control(
			'case_study_left_image',
			[
				'label' => esc_html__( 'Choose A Left Image', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);


		$this->end_controls_section();



		// section background head
		$this->start_controls_section(
			'case_study_right_side_head',
			[
				'label' => esc_html__( 'Case Study Right Side', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'case_study_right_side_haed',[
			'label' => esc_html( 'Right Side Content', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		$this->add_control(
			'case_study_right_title',
			[
				'label' => esc_html__( 'Hover Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Short-Range Tax Planning', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		$this->add_control(
			'case_study_right_desc',
			[
				'label' => esc_html__( 'Hover Description', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'There are many variations of passages Lorem Ipsum available', 'taxvi-pro' ),
				'placeholder' => esc_html__( 'Type your description here', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		// left hover button text
		$this->add_control(
			'case_study_right_btn_text',
			[
				'label' => esc_html__( 'Hover Button Text', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Read More', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		// left hover button url
		$this->add_control(
			'case_study_right_btn_url',
			[
				'label' => esc_html__( 'Hover Button URL', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'taxvi-pro' ),
				'options' => [ 'url', 'is_external', 'nofollow' ],
				'default' => [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
					// 'custom_attributes' => '',
				],
				'label_block' => true,
			]
		);

		$this->add_control(
			'case_study_right_image',
			[
				'label' => esc_html__( 'Choose A Right Image', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);


		$this->end_controls_section();








		// section background head
		$this->start_controls_section(
			'case_study_section_bg_head',
			[
				'label' => esc_html__( 'Case Study Section', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'case_study_bg_haed',[
			'label' => esc_html( 'Background', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// section background
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'case_study_section_background',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .white-bg',
			]
		);


		
		$this->end_controls_section();

		

	

	

		// Content Tab End


		// Style case_study Start
		$this->start_controls_section(
			'cta_area_three_heading_style',
			[
				'label' => esc_html__( 'Case Study Content Style', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// cta sub title
		$this->add_control(
			'case_study_sub_title_haed',[
			'label' => esc_html( 'Sub Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// cta sub title color
		$this->add_control(
			'case_study_sub_title_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .section-title h6' => 'color: {{VALUE}}',
				],
			]
		);


		// sub title type color
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'case_study_sub_title_type',
				'selector'	=> '{{WRAPPER}} .section-title h6',
				
				
			]
		);

		// cta sub divider color
		$this->add_control(
			'case_study_divider_bg_color',
			[
				'label' => esc_html__( 'Divider Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .section-title h6' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'case_study_title_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		// cta sub head
		$this->add_control(
			'case_study_title_head',[
			'label' => esc_html( 'Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// cta sub title color
		$this->add_control(
			'case_study_title_main_color',
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
				'name'		=> 'case_study_title_type',
				'selector'	=> '{{WRAPPER}} .section-title h2',
				
				
			]
		);

		$this->add_control(
			'case_study_desc_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		// box Job desc head
		$this->add_control(
			'case_study_btn_head',[
			'label' => esc_html( 'Button', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// job desc typography
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'case_study_btn_type',
				'selector'	=> '{{WRAPPER}} .explore-btn a',
				
			]
		);

		// Btn controls Tab Start
		$this->start_controls_tabs(
			'style_tabs_s'
		);

		$this-> start_controls_tab(
			'case_study_btn_normal',
			[
				'label' => esc_html__( 'Normal', 'taxvi-pro' ),
			]

		);

		//Title Color
		$this->add_control(
			'case_study_btn_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .explore-btn a' => 'color:{{VALUE}}',
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
				'selector' => '{{WRAPPER}} .explore-btn',
			]
		);

		$this->add_control(
			'case_study_btn_border_color',
			[
				'label' => esc_html__( 'Border Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .explore-btn' => 'border-color:{{VALUE}}',
				],
			]
		);

		$this->add_control(
			'case_study_bg_color_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		//Normal button Margin
		$this-> add_control('normal_margin',[
			'label'		=> esc_html( 'Margin', 'picchi_extrantion'),
			'type'		=> \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'	=> ['px','%','em','rem'],
			'selectors'	=> ['{{WRAPPER}} .explore-btn' => 'margin:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'],
		]);

		$this->add_control(
			'case_study_normal_padding_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		//Normal button Padding
		$this-> add_control('normal_padding',[
			'label'		=> esc_html( 'Padding', 'picchi_extrantion'),
			'type'		=> \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'	=> ['px','%','em','rem'],
			'selectors'	=> ['{{WRAPPER}} .explore-btn' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'],
		]);

		$this->end_controls_tab();



		
		// Btn Hover controls Tab Start
		$this-> start_controls_tab(
			'case_study_btn_hover',
			[
				'label' => esc_html__( 'Hover', 'taxvi-pro' ),
			]

		);

		//Hover Title Color
		$this->add_control(
			'case_study_hover_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .explore-btn:hover a' => 'color:{{VALUE}}',
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
				'selector' => '{{WRAPPER}} .explore-btn:hover',
			]
		);

		$this->add_control(
			'case_study_btn_border_hover_color',
			[
				'label' => esc_html__( 'Border Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .explore-btn:hover' => 'border-color:{{VALUE}}',
				],
			]
		);

		$this->add_control(
			'case_study_btn_margin_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		//Hover button Margin
		$this-> add_control('hover_margin',[
			'label'		=> esc_html( 'Margin', 'picchi_extrantion'),
			'type'		=> \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'	=> ['px','%','em','rem'],
			'selectors'	=> ['{{WRAPPER}} .explore-btn:hover' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'],
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
			'selectors'	=> ['{{WRAPPER}} .explore-btn:hover' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'],
		]);



		// Btn controls Tab Start
		$this->end_controls_tabs();

	
		// section background end
		$this->end_controls_section();

		// Style Tab End




		// Style case_study Start
		$this->start_controls_section(
			'study_info_left_heading_style',
			[
				'label' => esc_html__( 'Case Study Left Style', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// cta sub title
		$this->add_control(
			'study_info_left_title_haed',[
			'label' => esc_html( 'Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// cta sub title color
		$this->add_control(
			'study_info_left_title_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .study_info_left h3' => 'color: {{VALUE}}',
				],
			]
		);


		// sub title type color
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'study_info_left_title_type',
				'selector'	=> '{{WRAPPER}} .study_info_left h3',
			]
		);


		$this->add_control(
			'study_info_left_title_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		// cta sub head
		$this->add_control(
			'study_info_left_desc_head',[
			'label' => esc_html( 'Description', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// cta sub title color
		$this->add_control(
			'study_info_left_desc_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .study_info_left p' => 'color: {{VALUE}}',
				],
			]
		);


		// cta sub title type color
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'study_info_left_desc_type',
				'selector'	=> '{{WRAPPER}} .study_info_left p',
				
				
			]
		);

		$this->add_control(
			'study_info_left_desc_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		// box Job desc head
		$this->add_control(
			'study_info_left_btn_head',[
			'label' => esc_html( 'Button', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// job desc typography
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'study_info_left_btn_type',
				'selector'	=> '{{WRAPPER}} .study_info_left a',
				
			]
		);

		// Btn controls Tab Start
		$this->start_controls_tabs(
			'style_study_info_left_s'
		);

		$this-> start_controls_tab(
			'study_info_left_btn_normal',
			[
				'label' => esc_html__( 'Normal', 'taxvi-pro' ),
			]

		);

		//Title Color
		$this->add_control(
			'study_info_left_btn_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .study_info_left a' => 'color:{{VALUE}}',
				],
			]
		);

		// Button BG Color
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[	
				'label' => esc_html__( 'Background Color', 'taxvi-pro' ),
				'name' => 'study_info_left_normal_bg',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .study_info_left a',
			]
		);


		$this->add_control(
			'study_info_left_bg_color_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		//Normal button Margin
		$this-> add_control('study_info_left_normal_margin',[
			'label'		=> esc_html( 'Margin', 'picchi_extrantion'),
			'type'		=> \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'	=> ['px','%','em','rem'],
			'selectors'	=> ['{{WRAPPER}} .study_info_left a' => 'margin:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'],
		]);

		$this->add_control(
			'case_study_left_normal_padding_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		//Normal button Padding
		$this-> add_control('study_info_left_normal_padding',[
			'label'		=> esc_html( 'Padding', 'picchi_extrantion'),
			'type'		=> \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'	=> ['px','%','em','rem'],
			'selectors'	=> ['{{WRAPPER}} .study_info_left a' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'],
		]);

		$this->end_controls_tab();



		
		// Btn Hover controls Tab Start
		$this-> start_controls_tab(
			'study_info_left_btn_hover',
			[
				'label' => esc_html__( 'Hover', 'taxvi-pro' ),
			]

		);

		//Hover Title Color
		$this->add_control(
			'study_info_left_hover_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .study_info_left a:hover' => 'color:{{VALUE}}',
				],
			]
		);
		// Button Hover BG Color
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[	
				'label' => esc_html__( 'Background Color', 'taxvi-pro' ),
				'name' => 'study_info_left_hover_bg',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .study_info_left a:hover',
			]
		);


		$this->add_control(
			'study_info_left_btn_margin_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		//Hover button Margin
		$this-> add_control('study_info_left_hover_margin',[
			'label'		=> esc_html( 'Margin', 'picchi_extrantion'),
			'type'		=> \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'	=> ['px','%','em','rem'],
			'selectors'	=> ['{{WRAPPER}} .study_info_left a:hover' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'],
		]);

		$this->add_control(
			'study_info_left_hover_padding_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
		//Hover button Padding
		$this-> add_control('study_info_left_hover_padding',[
			'label'		=> esc_html( 'Padding', 'picchi_extrantion'),
			'type'		=> \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'	=> ['px','%','em','rem'],
			'selectors'	=> ['{{WRAPPER}} .study_info_left a:hover' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'],
		]);



		// Btn controls Tab Start
		$this->end_controls_tabs();

		$this->add_control(
			'study_info_left_section_bg',[
			'label' => esc_html( 'Section Background', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[	
				'label' => esc_html__( 'Background', 'taxvi-pro' ),
				'name' => 'study_info_left_section_bg_color',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .study_info_left',
			]
		);

	
		// section background end
		$this->end_controls_section();


		// Style case_study Start
		$this->start_controls_section(
			'study_info_right_heading_style',
			[
				'label' => esc_html__( 'Case Study Right Style', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// cta sub title
		$this->add_control(
			'study_info_right_title_haed',[
			'label' => esc_html( 'Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// cta sub title color
		$this->add_control(
			'study_info_right_title_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .study_info_right h3' => 'color: {{VALUE}}',
				],
			]
		);


		// sub title type color
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'study_info_right_title_type',
				'selector'	=> '{{WRAPPER}} .study_info_right h3',
			]
		);


		$this->add_control(
			'study_info_right_title_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		// cta sub head
		$this->add_control(
			'study_info_right_desc_head',[
			'label' => esc_html( 'Description', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// cta sub title color
		$this->add_control(
			'study_info_right_desc_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .study_info_right p' => 'color: {{VALUE}}',
				],
			]
		);


		// cta sub title type color
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'study_info_right_desc_type',
				'selector'	=> '{{WRAPPER}} .study_info_right p',
				
				
			]
		);

		$this->add_control(
			'study_info_right_desc_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		// box Job desc head
		$this->add_control(
			'study_info_right_btn_head',[
			'label' => esc_html( 'Button', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// job desc typography
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'study_info_right_btn_type',
				'selector'	=> '{{WRAPPER}} .study_info_right a',
				
			]
		);

		// Btn controls Tab Start
		$this->start_controls_tabs(
			'style_study_info_right_s'
		);

		$this-> start_controls_tab(
			'study_info_right_btn_normal',
			[
				'label' => esc_html__( 'Normal', 'taxvi-pro' ),
			]

		);

		//Title Color
		$this->add_control(
			'study_info_right_btn_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .study_info_right a' => 'color:{{VALUE}}',
				],
			]
		);

		// Button BG Color
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[	
				'label' => esc_html__( 'Background Color', 'taxvi-pro' ),
				'name' => 'study_info_right_normal_bg',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .study_info_right a',
			]
		);


		$this->add_control(
			'study_info_right_bg_color_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		//Normal button Margin
		$this-> add_control('study_info_right_normal_margin',[
			'label'		=> esc_html( 'Margin', 'picchi_extrantion'),
			'type'		=> \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'	=> ['px','%','em','rem'],
			'selectors'	=> ['{{WRAPPER}} .study_info_right a' => 'margin:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'],
		]);

		$this->add_control(
			'case_study_right_normal_padding_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		//Normal button Padding
		$this-> add_control('study_info_right_normal_padding',[
			'label'		=> esc_html( 'Padding', 'picchi_extrantion'),
			'type'		=> \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'	=> ['px','%','em','rem'],
			'selectors'	=> ['{{WRAPPER}} .study_info_right a' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'],
		]);

		$this->end_controls_tab();



		
		// Btn Hover controls Tab Start
		$this-> start_controls_tab(
			'study_info_right_btn_hover',
			[
				'label' => esc_html__( 'Hover', 'taxvi-pro' ),
			]

		);

		//Hover Title Color
		$this->add_control(
			'study_info_right_hover_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .study_info_right a:hover' => 'color:{{VALUE}}',
				],
			]
		);
		// Button Hover BG Color
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[	
				'label' => esc_html__( 'Background Color', 'taxvi-pro' ),
				'name' => 'study_info_right_hover_bg',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .study_info_right a:hover',
			]
		);


		$this->add_control(
			'study_info_right_btn_margin_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		//Hover button Margin
		$this-> add_control('study_info_right_hover_margin',[
			'label'		=> esc_html( 'Margin', 'picchi_extrantion'),
			'type'		=> \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'	=> ['px','%','em','rem'],
			'selectors'	=> ['{{WRAPPER}} .study_info_right a:hover' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'],
		]);

		$this->add_control(
			'study_info_right_hover_padding_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
		//Hover button Padding
		$this-> add_control('study_info_right_hover_padding',[
			'label'		=> esc_html( 'Padding', 'picchi_extrantion'),
			'type'		=> \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'	=> ['px','%','em','rem'],
			'selectors'	=> ['{{WRAPPER}} .study_info_right a:hover' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'],
		]);



		// Btn controls Tab Start
		$this->end_controls_tabs();
		

		$this->add_control(
			'study_info_right_section_bg',[
			'label' => esc_html( 'Section Background', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[	
				'label' => esc_html__( 'Background', 'taxvi-pro' ),
				'name' => 'study_info_right_section_bg_color',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .study_info_right',
			]
		);
	
		// section background end
		$this->end_controls_section();
		

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		// main case study content
		$case_study_sub_title = $settings['case_study_sub_title'];
		$case_study_title = $settings['case_study_title'];
		$case_study_btn_text = $settings['case_study_btn_text'];
		$case_study_btn_url = $settings['case_study_btn_url']['url'];

		// case left side content

		$case_study_left_title = $settings['case_study_left_title'];
		$case_study_left_desc = $settings['case_study_left_desc'];
		$case_study_left_btn_text = $settings['case_study_left_btn_text'];
		$case_study_left_btn_url = $settings['case_study_left_btn_url']['url'];
		$case_study_left_image = $settings['case_study_left_image']['url'];


		// case right side content

		$case_study_right_title = $settings['case_study_right_title'];
		$case_study_right_desc = $settings['case_study_right_desc'];
		$case_study_right_btn_text = $settings['case_study_right_btn_text'];
		$case_study_right_btn_url = $settings['case_study_right_btn_url']['url'];
		$case_study_right_image = $settings['case_study_right_image']['url'];


		?>

		<div class="case-study section-padding white-bg">
			<div class="container">
				<div class="row">
					<div class="col-xl-7 col-lg-7">
						<div class="section-title">
							<h6><?php echo esc_html($case_study_sub_title); ?></h6>
							<h2><?php echo esc_html($case_study_title); ?></h2>                            
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xl-8 col-lg-7 col-md-6 wow fadeInLeft animated" data-wow-delay="200ms">
						<div class="single-case-wrapper" data-background="<?php echo esc_attr($case_study_left_image); ?>">
							<div class="case-info-wrap study_info_left">
								<h3><?php echo esc_html($case_study_left_title); ?></h3>
								<?php echo $case_study_left_desc; ?>
								<a href="<?php echo esc_url($case_study_left_btn_url); ?>" class="main-btn"><?php echo esc_html($case_study_left_btn_text); ?></a>
							</div>
						</div>
					</div>
					<div class="col-xl-4 col-lg-5 col-md-6 wow fadeInLeft animated" data-wow-delay="300ms">
						<div class="single-case-wrapper" data-background="<?php echo esc_attr($case_study_right_image); ?>">
							<div class="case-info-wrap study_info_right">
								<h3><?php echo esc_html($case_study_right_title); ?></h3>
								<?php echo $case_study_right_desc; ?>
								<a href="<?php echo esc_url($case_study_right_btn_url); ?>" class="main-btn"><?php echo esc_html($case_study_right_btn_text); ?></a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="explore-btn">
				<a href="<?php echo esc_html($case_study_btn_url); ?>"><?php echo esc_html($case_study_btn_text); ?><i class="las la-arrow-right"></i></a>
			</div>
		</div>
		<?php


	}


	protected function content_template() {

		?>	
			<div class="case-study section-padding white-bg">
				<div class="container">
					<div class="row">
						<div class="col-xl-7 col-lg-7">
							<div class="section-title">
								<h6>{{{settings.case_study_sub_title}}}</h6>
								<h2>{{{settings.case_study_title}}}</h2>                            
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xl-8 col-lg-7 col-md-6 wow fadeInLeft animated" data-wow-delay="200ms">
							<div class="single-case-wrapper" data-background="{{{settings.case_study_left_image.url}}}">
								<div class="case-info-wrap study_info_left">
									<h3>{{{settings.case_study_left_title}}}</h3>
									{{{settings.case_study_left_desc}}}
									<a href="{{{settings.case_study_left_btn_url.url}}}" class="main-btn">{{{settings.case_study_left_btn_text}}}</a>
								</div>
							</div>
						</div>
						<div class="col-xl-4 col-lg-5 col-md-6 wow fadeInLeft animated" data-wow-delay="300ms">
							<div class="single-case-wrapper" data-background="{{{settings.case_study_right_image.url}}}">
								<div class="case-info-wrap study_info_right">
									<h3>{{{settings.case_study_right_title}}}</h3>
									{{{settings.case_study_right_desc}}}
									<a href="{{{settings.case_study_right_btn_url.url}}}" class="main-btn">{{{settings.case_study_right_btn_text}}}</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="explore-btn">
					<a href="{{{settings.case_study_btn_url.url}}}">{{{settings.case_study_btn_text}}}<i class="las la-arrow-right"></i></a>
				</div>
			</div>
               
		<?php 
	}		
}
