<?php
class Taxvi_Priceing extends \Elementor\Widget_Base {

	public function get_name() {
		return 'header_priceing';
	}

	public function get_title() {
		return esc_html__( 'Our Priceing', 'taxvi-pro' );
	}

	public function get_icon() {
		return 'eicon-editor-h1';
	}

	public function get_categories() {
		return [ 'our_priceing_cat' ];
	}

	public function get_keywords() {
		return [ 'priceing', 'our', 'our_priceing' ];
	}

	protected function register_controls() {

		
		$this->start_controls_section(
			'section_title',
			[
				'label' => esc_html__( 'Taxvi Priceing Heading', 'taxvi-pro' ),
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
			'our_priceing_sub_title',
			[
				'label' => esc_html__( 'Sub Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Our Pricing PLANS', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		// Heading Title
		$this->add_control(
			'our_priceing_title',
			[
				'label' => esc_html__( 'Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Simple, Transparent And Great pricing.', 'taxvi-pro' ),
			]
		);

		
		$this->add_control(
			'our_priceing_title_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);


		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'priceing_table_title',
			[
				'label' => esc_html__( 'Price Heading', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Basic' , 'taxvi-pro' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'priceing_table_desc',
			[
				'label' => esc_html__( 'Price Description', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Duis aute irure dolor in reprehenderit voluptate velit esse cillum dolore eu fugiat ' , 'taxvi-pro' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'priceing_table_price',
			[
				'label' => esc_html__( 'Price', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( '$44.9' , 'taxvi-pro' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'priceing_table_period',
			[
				'label' => esc_html__( 'Period', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( '/ Month' , 'taxvi-pro' ),
				'label_block' => true,
			]
		);

		$nested_repeater = new \Elementor\Repeater();

		$nested_repeater->add_control(
			'price_item_title',
			[
				'label' => esc_html__( 'Item Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Free Consultation' , 'taxvi-pro' ),
				'label_block' => true,
			]
		 );

		 $nested_repeater->add_control(
			'price_item_icons',
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
	  
		 // Add the nested repeater to the main repeater
		 $repeater->add_control(
			'priceing_items',
			[
			   'label' => 'Price Items',
			   'type' => \Elementor\Controls_Manager::REPEATER,
			   'fields' => $nested_repeater->get_controls(),
			   'default' => [
					[
						'price_item_title' => esc_html__( 'Add New Item', 'taxvi-pro' ),
					],
				],
				'title_field' => '{{{ price_item_title }}}',
			]
		 );
	

		$repeater->add_control(
			'priceing_table_button_text',
			[
				'label' => esc_html__( 'Button Text', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Purchase Now' , 'taxvi-pro' ),
				'label_block' => true,
			]
		);


		$repeater->add_control(
			'priceing_table_button_url',
			[
				'label' => esc_html__( 'Button URL', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'textdomain' ),
				'options' => [ 'url', 'is_external', 'nofollow' ],
				'default' => [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
				],
				'label_block' => true,
			]
		);

		$this->add_control(
			'priceing_tables',
			[
				'label' => esc_html__( 'Price Tables', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'priceing_table_title' => esc_html__( 'Basic', 'taxvi-pro' ),
					],
				],
				'title_field' => '{{{ priceing_table_title }}}',
			]
		);



		$this->end_controls_section();


		$this->start_controls_section(
			'section_priceing',
			[
				'label' => esc_html__( 'Priceing Section', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);


		$this->add_control(
			'priceing_bg_header',[
			'label' => esc_html( 'Background', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'priceing_bg',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .light-bg-1',
			]
		);


		$this->end_controls_section();


		// header Content style start
		$this->start_controls_section(
			'our_priceing_section_title_style',
			[
				'label' => esc_html__( 'Taxvi Heading Style', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		//Sub Title Style Heading
		$this->add_control(
			'our_priceing_sub_title_color_heading',[
			'label' => esc_html( 'Sub Title Color', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// Sub Title Color Controls
		$this->add_control(
			'our_priceing_title_sub_color',
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
				'name'		=> 'our_priceing_sub_title_type',
				'selector'	=> '{{WRAPPER}} .section-title p',
			]
		);

		
		$this->add_control(
			'our_priceing_title_divider_color',
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
			'our_priceing_title_color_heading',[
			'label' => esc_html( 'Title Color', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);


		$this->add_control(
			'our_priceing_title_title_color',
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
				'name'		=> 'our_priceing_title_type',
				'selector'	=> '{{WRAPPER}} .section-title h2',
			]
		);

		
		$this->end_controls_section();



		$this->start_controls_section(
			'our_priceing_item_style',
			[
				'label' => esc_html__( 'Taxvi Price Table', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		//Sub Title Style Heading
		$this->add_control(
			'our_priceing_item_title_color_heading',[
			'label' => esc_html( 'Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// Sub Title Color Controls
		$this->add_control(
			'our_priceing_item_title_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .price-heading h4' => 'color: {{VALUE}};',
				],
			]
		);

		//Sub Title Typography
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'our_priceing_item_title_type',
				'selector'	=> '{{WRAPPER}} .price-heading h4',
			]
		);

		$this->add_control(
			'our_priceing_item_title_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);


		$this->add_control(
			'our_priceing_item_desc_color_heading',[
			'label' => esc_html( 'Description', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// Sub Title Color Controls
		$this->add_control(
			'our_priceing_item_desc_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .price-heading p' => 'color: {{VALUE}};',
				],
			]
		);

		//Sub Title Typography
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'our_priceing_item_desc_type',
				'selector'	=> '{{WRAPPER}} .price-heading p',
			]
		);

		$this->add_control(
			'our_priceing_item_desc_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		
		$this->add_control(
			'our_priceing_item_price_color_heading',[
			'label' => esc_html( 'Price', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// Sub Title Color Controls
		$this->add_control(
			'our_priceing_item_price_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .price-amount > h2' => 'color: {{VALUE}};',
				],
			]
		);

		//Sub Title Typography
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'our_priceing_item_price_type',
				'selector'	=> '{{WRAPPER}} .price-amount > h2',
			]
		);

		$this->add_control(
			'our_priceing_item_price_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);


		$this->add_control(
			'our_priceing_item_period_color_heading',[
			'label' => esc_html( 'Period', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// Sub Title Color Controls
		$this->add_control(
			'our_priceing_item_period_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .price-amount h2 > span' => 'color: {{VALUE}};',
				],
			]
		);

		//Sub Title Typography
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'our_priceing_item_period_type',
				'selector'	=> '{{WRAPPER}} .price-amount h2 > span',
			]
		);

		$this->add_control(
			'our_priceing_item_period_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'our_priceing_bg_color_heading',[
			'label' => esc_html( 'Price Table Background', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		$this->start_controls_tabs(
			'style_tabs_price_table'
		);

		$this-> start_controls_tab(
			'feature_items_price_table_normal',
			[
				'label' => esc_html__( 'Normal', 'taxvi-pro' ),
			]

		);

		// Button BG Color
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[	
				'label' => esc_html__( 'Background Color', 'taxvi-pro' ),
				'name' => 'price_table_normal_bg',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .single-price-item',
			]
		);		


		$this->end_controls_tab();


		$this-> start_controls_tab(
			'price_table_hover',
			[
				'label' => esc_html__( 'Hover', 'taxvi-pro' ),
			]

		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[	
				'label' => esc_html__( 'Background Color', 'taxvi-pro' ),
				'name' => 'price_table_hover_bg',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .single-price-item:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();





		$this->start_controls_section(
			'our_price_items__style',
			[
				'label' => esc_html__( 'Taxvi Price Item', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		//Sub Title Style Heading
		$this->add_control(
			'our_priceing_item_icon_color_heading',[
			'label' => esc_html( 'Item Icon', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);


		$this->add_control(
			'our_priceing_item_icon_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .price-feature-list ul li i' => 'color: {{VALUE}};',
				],
			]
		);

		//Sub Title Typography
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'our_priceing_item_icon_type',
				'selector'	=> '{{WRAPPER}} .price-feature-list ul li i',
			]
		);

		$this->add_control(
			'our_priceing_item_icons_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);


		$this->add_control(
			'our_priceing_items_title_color_heading',[
			'label' => esc_html( 'Item Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);


		$this->add_control(
			'our_priceing_items_title_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .price-feature-list ul li' => 'color: {{VALUE}};',
				],
			]
		);

		//Sub Title Typography
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'our_priceing_items_title_type',
				'selector'	=> '{{WRAPPER}} .price-feature-list ul li',
			]
		);


		$this->add_control(
			'our_priceing_items_btn_head',[
			'label' => esc_html( 'Button', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);


		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'features_items_btn_type',
				'selector'	=> '{{WRAPPER}} .main-btn',
			]
		);

		// Btn Normal controls Tab Start
		$this->start_controls_tabs(
			'style_tabs_s'
		);

		$this-> start_controls_tab(
			'feature_items_btn_normal',
			[
				'label' => esc_html__( 'Normal', 'taxvi-pro' ),
			]

		);

		//icons Color
		$this->add_control(
			'items_btn_normal_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .main-btn.white' => 'color:{{VALUE}}',
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
				'selector' => '{{WRAPPER}} .main-btn.white',
			]
		);

		//Normal button Margin
		$this-> add_control('normal_margin',[
			'label'		=> esc_html( 'Margin', 'taxvi-pro'),
			'type'		=> \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'	=> ['px','%','em','rem'],
			'selectors'	=> ['{{WRAPPER}} .main-btn.white' => 'margin:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'],
		]);

		//Normal button Padding
		$this-> add_control('normal_padding',[
			'label'		=> esc_html( 'Padding', 'taxvi-pro'),
			'type'		=> \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'	=> ['px','%','em','rem'],
			'selectors'	=> ['{{WRAPPER}} .main-btn.white' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'],
		]);



		$this->end_controls_tab();


		// Btn Hover controls Tab Start
		$this-> start_controls_tab(
			'items_btn_hover',
			[
				'label' => esc_html__( 'Hover', 'taxvi-pro' ),
			]

		);

		//Hover Title Color
		$this->add_control(
			'items_btn_hover_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .single-price-item:hover .main-btn.white ' => 'color:{{VALUE}}',
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
				'selector' => '{{WRAPPER}} .single-price-item:hover .main-btn.white',
			]
		);

		//Hover button Margin
		$this-> add_control('hover_margin',[
			'label'		=> esc_html( 'Margin', 'taxvi-pro'),
			'type'		=> \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'	=> ['px','%','em','rem'],
			'selectors'	=> ['{{WRAPPER}} .single-price-item:hover .main-btn.white' => 'margin:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'],
		]);

		//Hover button Padding
		$this-> add_control('hover_padding',[
			'label'		=> esc_html( 'Padding', 'taxvi-pro'),
			'type'		=> \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'	=> ['px','%','em','rem'],
			'selectors'	=> ['{{WRAPPER}} .single-price-item:hover .main-btn.white' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'],
		]);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'our_priceing_btn_bg_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'our_priceing_items_bg_head',[
			'label' => esc_html( 'Item Background', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[	
				'label' => esc_html__( 'Background Color', 'taxvi-pro' ),
				'name' => 'items_bg_color',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .price-feature-list',
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		// header information
		$our_priceing_sub_title = $settings['our_priceing_sub_title'];
		$our_priceing_title = $settings['our_priceing_title'];

		// priceing repater 
		$priceing_tables = $settings['priceing_tables'];
		?>
			

	<div class="pricing-section section-padding pb-90 light-bg-1">
        <div class="container">
            <div class="row">
                <div class="offset-xl-3 col-xl-6 text-center">
                    <div class="section-title">
                        <p><?php echo esc_html($our_priceing_sub_title); ?></p>
                        <h2><?php echo esc_html($our_priceing_title); ?></h2>
                    </div>
                </div>
            </div>
            <div class="row">
				<?php foreach($priceing_tables as $single_price){ ?>
                <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                    <div class="single-price-item">
                        <div class="price-heading">
                            <h4><?php echo esc_html($single_price['priceing_table_title']); ?></h4>
                            <p><?php echo esc_html($single_price['priceing_table_desc']); ?></p>
                        </div>
                        <div class="price-amount">
                            <h2><?php echo esc_html($single_price['priceing_table_price']); ?> <span><?php echo esc_html($single_price['priceing_table_period']); ?></span></h2>
                        </div>
                        <div class="price-feature-list">
                            <ul>
								<?php foreach($single_price['priceing_items'] as $single_item){ ?>
                                <li><?php \Elementor\Icons_Manager::render_icon( $single_item['price_item_icons'], [ 'aria-hidden' => 'true' ] ); ?><?php echo esc_html($single_item['price_item_title']); ?></li>  
								<?php } ?>                              
                            </ul>
                            <div class="price-btn">
                                <a href="<?php echo esc_url($single_price['priceing_table_button_url']['url']); ?>" class="main-btn white"><?php echo esc_html($single_price['priceing_table_button_text']); ?></a>
                            </div>
                        </div>
                        
                    </div>
                </div>
				<?php } ?>
            </div>
        </div>
    </div>

		<?php


	}

}
