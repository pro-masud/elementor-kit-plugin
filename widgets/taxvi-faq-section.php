<?php
class Home_FAQ_Section extends \Elementor\Widget_Base {

	public function get_name() {
		return 'taxvi_faq_section';
	}

	public function get_title() {
		return esc_html__( 'Taxvi FAQ Section', 'taxvi-pro' );
	}

	public function get_icon() {
		return 'eicon-post-slider';
	}

	public function get_categories() {
		return [ 'taxvi_cat' ];
	}

	public function get_keywords() {
		return [ 'Service', 'two' ];
	}

	protected function register_controls() {

		// Collaboration Tab Start
		$this->start_controls_section(
			'section_service',
			[
				'label' => esc_html__( 'Service', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		//Collaboration Content
		$this->add_control(
			'service_heading_main',[
			'label' => esc_html( 'Service Content', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
			
		]);	

		// Title
		$this->add_control(
			'service_title',
			[
				'label' => esc_html__( 'Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Solutions: All Your Questions Answered', 'taxvi-pro' ),
				'label_block'	=> true,
				'separator'	=> 'after'
			]
		);

		$this->add_control(
			'service_two_title_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);


		$service_items = new \Elementor\Repeater();

		//service Content
		$service_items->add_control(
			'service_slider',[
			'label' => esc_html( 'Service Items', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
			
		]);	

		$service_items->add_control(
			'service_item_service_active',
			[
				'label' => esc_html__( 'Service Active', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'taxvi-pro' ),
				'label_off' => esc_html__( 'Hide', 'taxvi-pro' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$service_items->add_control(
			'service_item_title',
			[
				'label' => esc_html__( 'Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'What Is Tax Advisor Services?', 'taxvi-pro' ),
				'label_block'	=> true,
				'separator'	=> 'after'
			]
		);

		$service_items->add_control(
			'service_item_desc',
			[
				'label' => esc_html__( 'Description', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( "There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum,", 'taxvi-pro' ),
				'label_block'	=> true,
				'separator'	=> 'after'
			]
		);
		

		$this->add_control(
			'service_repeater',
			[
				'label' => esc_html__( 'Add A Services', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $service_items->get_controls(),
				'default' => [
					[
						'service_item_title' => esc_html__( 'What Is Tax Advisor Services?', 'taxvi-pro' ),
					],
				],
				'title_field' => '{{{ service_item_title }}}',
			]
		);


		$this->end_controls_section();

		// Style Tab Start
		$this->start_controls_section(
			'service_heading_style',
			[
				'label' => esc_html__( 'Service Style', 'taxvi-pro' ),
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
			'service_title_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .section-title h2 ' => 'color:{{VALUE}}',
				],
			]
		);

		
	
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'service_title_type',
				'selector'	=> '{{WRAPPER}} .section-title h2 ',
				'separator'	=> 'after'
			]
		);


		$this->add_control(
			'service_title_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);


		
		$this->add_control(
			'service_items_style',[
			'label' => esc_html( 'Service Item Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,			
		]);

		
		
		$this->add_control(
			'service_item_normal_color',
			[
				'label' => esc_html__( 'Title Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .card .card-header .btn-link' => 'color:{{VALUE}}',
				],
			]
		);

		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'service_title_types',
				'selector'	=> '{{WRAPPER}} .card .card-header .btn-link ',
				'separator'	=> 'after'
			]
		);





		$this->add_control(
			'service_item_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);


		$this->add_control(
			'heading_desc_style',[
			'label' => esc_html( 'Service Description', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,			
		]);

		//Title Color
		$this->add_control(
			'service_desc_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .content p ' => 'color:{{VALUE}}',
				],
			]
		);

		
	
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'service_desc_type',
				'selector'	=> '{{WRAPPER}} .content p ',
				'separator'	=> 'after'
			]
		);

		$this->add_control(
			'service_border_color',
			[
				'label' => esc_html__( 'Border Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .card-body ' => 'border-color:{{VALUE}}',
				],
			]
		);

		$this->add_control(
			'service_desc_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);


		// Button 
		$this->add_control(
			'service_icons_style',[
			'label' => esc_html( 'Service Item Background', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,			
		]);


		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'service_item_bg_color',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .accordion.faqs .card, .accordion.faqs .card .card-header, .accordion.faqs .card .card-header .btn-link',
			]
		);


		$this->add_control(
			'service_item_border_color',
			[
				'label' => esc_html__( 'Border Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .card ' => 'border-color:{{VALUE}}',
				],
			]
		);

		
		
		$this->end_controls_section();

		$this->start_controls_section(
			'service_section_style',
			[
				'label' => esc_html__( 'Service Section', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// sub title heading
		$this->add_control(
			'service_section_head',[
			'label' => esc_html( 'Background', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
			
			
		]);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[	
				'label' => esc_html__( 'Background Color', 'taxvi-pro' ),
				'name' => 'section_bg_style',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .section-padding',
			]
		);

		$this->end_controls_section();



	}

	protected function render() {
		$settings = $this->get_settings_for_display();

	
		$service_title = $settings['service_title'];
		$service_repeater = $settings['service_repeater'];



		?>
				
	<div class="solution-section section-padding pb-0">
        <div class="container">
			<div class="row">
				<div class="offset-xl-2 col-xl-8 text-center">
					<div class="section-title">
						<h2><?php echo esc_html($service_title ); ?></h2>
					</div>                
				</div>
			</div>
			<div class="row">
            <div class="offset-xl-1 col-xl-10 mt-50">
                <div class="accordion faqs" id="accordionFaq2">
				<?php 	
						$i = 1;
						foreach($service_repeater as $single_service){ 
						$i++;
				?>
                    <div class="card">
					<?php 
						if( $single_service['service_item_service_active'] == 'yes'){
							$active = 'active';
							$show = 'show';
						}else{
							$active = ' ';
							$show = ' ';
						}
					?>
                        <div class="card-header" id="heading<?php echo esc_attr($i); ?>">
                            <h5 class="mb-0 subtitle">
                                <button class="btn btn-link collapsed <?php echo esc_html($active); ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo esc_attr($i); ?>" aria-expanded="true" aria-controls="collapse<?php echo esc_attr($i); ?>">
									<?php echo esc_html( $single_service['service_item_title']); ?>
                                </button>
                            </h5>
                        </div>

                        <div id="collapse<?php echo esc_attr($i); ?>" class="collapse <?php echo esc_html($show); ?>" aria-labelledby="heading<?php echo esc_attr($i); ?>" data-parent="#accordionFaq2">
                            <div class="card-body">
                                <div class="content">
                                    <p><?php echo esc_html( $single_service['service_item_desc']); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
					<?php } ?>   
                </div>
            </div>
        </div>
    </div>



		<?php


	}


}
