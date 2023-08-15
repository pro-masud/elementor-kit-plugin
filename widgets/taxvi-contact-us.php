<?php
class Contact_Us extends \Elementor\Widget_Base {

	public function get_name() {
		return 'taxvi_contact_us';
	}

	public function get_title() {
		return esc_html__( 'Taxvi Contact Us Area', 'taxvi-pro' );
	}

	public function get_icon() {
		return 'eicon-kit-details';
	}

	public function get_categories() {
		return [ 'taxvi_cat' ];
	}

	public function get_keywords() {
		return [ 'contact us', 'area' ];
	}

	protected function register_controls() {

		

		// contact us Tab Start
		$this->start_controls_section(
			'taxvi_contact_us_head',
			[
				'label' => esc_html__( 'Contact Us Content', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		// Title
		$this->add_control(
			'taxvi_contact_us_title',
			[
				'label' => esc_html__( 'Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Want to work with us?', 'taxvi-pro' ),
				'label_block'		=> true,
				'separator'	=> 'after'
			]
		);

		// Sub Title
		$this->add_control(
			'taxvi_contact_us_sub_title',
			[
				'label' => esc_html__( 'Sub Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Meet our people. See our work. Join our team.', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		// Button Text
		$this->add_control(
			'taxvi_contact_us_btn_text',
			[
				'label' => esc_html__( 'Button Text', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Contact With Us', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);
		// Button URL
		$this->add_control(
			'taxvi_contact_us_btn_url',
			[
				'label' => esc_html__( 'Button URL', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'taxvi-pro' ),
				'options' => [ 'url' ],
				'default' => [
					'url' => '#',
				],
				'label_block' => true,
			]
		);

		$this->end_controls_section();


		// contact us Tab Start
		$this->start_controls_section(
			'section_contact_us',
			[
				'label' => esc_html__( 'Section background', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		//contact us Content
		$this->add_control(
			'contact_us_heading_main',[
			'label' => esc_html( 'Background', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
			
		]);	

		// Section Background
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[	
				'label' => esc_html__( 'Background Color', 'taxvi-pro' ),
				'name' => 'contact_us_bg',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .contact-section-inner',
			]
		);

		$this->end_controls_section();


		// Style Tab Start
		$this->start_controls_section(
			'coll_heading_style',
			[
				'label' => esc_html__( 'Contact Us Area Style', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// title heading
		$this->add_control(
			'heading_style',[
			'label' => esc_html( 'Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,			
		]);

		//Title Color
		$this->add_control(
			'coll_title_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .contact_info h2 ' => 'color:{{VALUE}}',
				],
			]
		);

		
		// Title Typography
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'coll_title_type',
				'selector'	=> '{{WRAPPER}} .contact_info h2 ',
				'separator'	=> 'after'
			]
		);


		// sub title heading
		$this->add_control(
			'sub_title_con',[
			'label' => esc_html( 'Sub Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,			
		]);

		//Sub Title Color
		$this->add_control(
			'contact_sub_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .contact_info h5 ' => 'color:{{VALUE}}',
				],
			]
		);

		
		//Sub Title Typography
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'contact_sub_type',
				'selector'	=> '{{WRAPPER}} .contact_info h5 ',
			]
		);

		// Button 
		$this->add_control(
			'contact_btn',[
			'label' => esc_html( 'Button', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,			
		]);

		// Button Typography
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'contact_btn_type',
				'selector'	=> '{{WRAPPER}} .con_btn ',
			]
		);

		// Btn Normal controls Tab Start
		$this->start_controls_tabs(
			'style_tabs_s'
		);

		$this-> start_controls_tab(
			'contact_btn_normal',
			[
				'label' => esc_html__( 'Normal', 'taxvi-pro' ),
			]

		);

		//Title Color
		$this->add_control(
			'contact_normal_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .con_btn ' => 'color:{{VALUE}}',
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
				'selector' => '{{WRAPPER}} .con_btn',
			]
		);

		//Normal button Margin
		$this-> add_control('normal_margin',[
			'label'		=> esc_html( 'Margin', 'taxvi-pro'),
			'type'		=> \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'	=> ['px','%','em','rem'],
			'selectors'	=> ['{{WRAPPER}} .con_btn' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'],
		]);

		//Normal button Padding
		$this-> add_control('normal_padding',[
			'label'		=> esc_html( 'Padding', 'taxvi-pro'),
			'type'		=> \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'	=> ['px','%','em','rem'],
			'selectors'	=> ['{{WRAPPER}} .con_btn' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'],
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
			'contact_btn_hover_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .con_btn:hover ' => 'color:{{VALUE}}',
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
				'selector' => '{{WRAPPER}} .con_btn:hover',
			]
		);

		//Hover button Margin
		$this-> add_control('hover_margin',[
			'label'		=> esc_html( 'Margin', 'taxvi-pro'),
			'type'		=> \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'	=> ['px','%','em','rem'],
			'selectors'	=> ['{{WRAPPER}} .con_btn:hover' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'],
		]);

		//Hover button Padding
		$this-> add_control('hover_padding',[
			'label'		=> esc_html( 'Padding', 'taxvi-pro'),
			'type'		=> \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'	=> ['px','%','em','rem'],
			'selectors'	=> ['{{WRAPPER}} .con_btn:hover' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'],
		]);

		$this->end_controls_tabs();
		

		// section background end
		$this->end_controls_section();

		// Style Tab End

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$taxvi_contact_us_title = $settings['taxvi_contact_us_title'];
		$taxvi_contact_us_sub_title = $settings['taxvi_contact_us_sub_title'];
		$taxvi_contact_us_btn_text = $settings['taxvi_contact_us_btn_text'];
		$taxvi_contact_us_btn_url = $settings['taxvi_contact_us_btn_url']['url'];

		?>	
			<div class="contact-area section-padding pt-0">
				<div class="container">
					<div class="contact-section-inner dark-bg">
						<div class="contact-section-content contact_info">
							<h2><?php echo esc_html($taxvi_contact_us_title); ?></h2>
							<h5><?php echo esc_html($taxvi_contact_us_sub_title); ?></h5>
							<a href="<?php echo esc_url($taxvi_contact_us_btn_url); ?>" class="main-btn con_btn"><?php echo esc_html($taxvi_contact_us_btn_text); ?></a>
						</div>
					</div>
				</div>
			</div>
		<?php
	}


	protected function content_template() {

		?>	
			<div class="contact-area section-padding pt-0">
				<div class="container">
					<div class="contact-section-inner dark-bg">
						<div class="contact-section-content contact_info">
							<h2>{{settings.taxvi_contact_us_title}}</h2>
							<h5>{{settings.taxvi_contact_us_sub_title}}</h5>
							<a href="{{settings.taxvi_contact_us_btn_url.url}}" class="main-btn con_btn">{{settings.taxvi_contact_us_btn_text}}</a>
						</div>
					</div>
				</div>
			</div>
		<?php 
	}
}
