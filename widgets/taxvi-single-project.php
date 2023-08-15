<?php
class Taxvi_Single_Project extends \Elementor\Widget_Base {

	public function get_name() {
		return 'taxvi_single_project';
	}

	public function get_title() {
		return esc_html__( 'Taxvi Single Project', 'taxvi-pro' );
	}

	public function get_icon() {
		return 'eicon-slider-vertical';
	}

	public function get_categories() {
		return [ 'taxvi_cat' ];
	}

	public function get_keywords() {
		return [ 'single', 'project','taxvi' ];
	}

	protected function register_controls() {


		$this->start_controls_section(
			'our_project_items_head',
			[
				'label' => esc_html__( 'Project Items', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$our_project = new \Elementor\Repeater();

		$our_project->add_control(
			'our_project_items_img',
			[
				'label' => esc_html__( 'Choose A Project Image', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		// project title
		$our_project->add_control(
			'our_project_items_title',
			[
				'label' => esc_html__( 'Project Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Short-Range Tax Planning' , 'taxvi-pro' ),
				'label_block' => true,
			]
		);

		$our_project->add_control(
			'our_project_items_desc',
			[
				'label' => esc_html__( 'Project Description', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Project' , 'taxvi-pro' ),
				'label_block' => true,
			]
		);
		

		$our_project->add_control(
			'our_project_items_url',
			[
				'label' => esc_html__( 'Project Link', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'taxvi-pro' ),
				'options' => [ 'url' ],
				'default' => [
					'url' => '#',
				],
				'label_block' => true,
			]
		);


		$our_project->add_control(
			'our_project_time',
			[
				'label' => esc_html__( 'Project Animation Time', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( '200ms' , 'taxvi-pro' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'our_projects_items',
			[
				'label' => esc_html__( 'About Feature Items', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $our_project->get_controls(),
				'default' => [
					[
						'company_two_feature_title' => esc_html__( 'Add New Project', 'taxvi-pro' ),
					],
				],
				'title_field' => '{{{ our_project_items_title }}}',
			]
		);	
			$this->end_controls_section();





		// section background head
		$this->start_controls_section(
			'our_project_section_bg_head',
			[
				'label' => esc_html__( 'Project Section', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'our_project_bg_haed',[
			'label' => esc_html( 'Background', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// section background
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'our_project_section_background',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .project-two',
			]
		);


		
		$this->end_controls_section();

		



		
		$this->start_controls_section(
			'our_projects_icon_heading_style',
			[
				'label' => esc_html__( 'Project Style', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_control(
			'projects_section_icons_head',[
			'label' => esc_html( 'Feature Icons', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// icon size
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'project_icons_type',
				'selector'	=> '{{WRAPPER}} .details-link i',
			]
		);

		

		

		// title Normal controls Tab Start
		$this->start_controls_tabs(
			'project_style_icon_tabs_s'
		);

		$this-> start_controls_tab(
			'project_bg_icon_normal',
			[
				'label' => esc_html__( 'Normal', 'taxvi-pro' ),
			]

		);

		// icon color 
		$this->add_control(
			'project_icon_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .details-link i' => 'color:{{VALUE}}',
				],
			]
		);

		//Hover icon bg Color
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'project_Icon_background_color',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .details-link',
			]
		);



		$this->end_controls_tab();


		// Btn Hover controls Tab Start
		$this-> start_controls_tab(
			'project_btn_hover',
			[
				'label' => esc_html__( 'Hover', 'taxvi-pro' ),
			]

		);

		// icon color 
		$this->add_control(
			'project_icon_hover_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .details-link:hover i' => 'color:{{VALUE}}',
				],
			]
		);

		//Hover icon bg Color
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'project_Icon_background_hover_color',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .details-link:hover',
			]
		);
		
	
		$this->end_controls_tabs();

		$this->add_control(
			'project_service_icon_color_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'project_section_desc_head',[
			'label' => esc_html( 'Project Description', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);
		

		$this->add_control(
			'project_desc_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .project-content p' => 'color:{{VALUE}}',
				],
			]
		);

		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'project_desc_type',
				'selector'	=> '{{WRAPPER}} .project-content p',
			]
		);

		$this->add_control(
			'project_border_color',
			[
				'label' => esc_html__( 'Border Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .project-content p::before' => 'background-color:{{VALUE}}',
				],
			]
		);

		$this->add_control(
			'service_desc_color_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);


		$this->add_control(
			'project_section_icons_head',[
			'label' => esc_html( 'Project Icons', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// icon size
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'project_icon_type',
				'selector'	=> '{{WRAPPER}} .details-link i',
			]
		);

		

		

		// feature title Normal controls Tab Start
		$this->start_controls_tabs(
			'style_title_tabs_s'
		);

		$this-> start_controls_tab(
			'project_bg_title_normal',
			[
				'label' => esc_html__( 'Normal', 'taxvi-pro' ),
			]

		);

		// icon color 
		$this->add_control(
			'project_title_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .single-project-item .project-content a' => 'color:{{VALUE}}',
				],
			]
		);




		$this->end_controls_tab();


		// Btn Hover controls Tab Start
		$this-> start_controls_tab(
			'project_title_hover',
			[
				'label' => esc_html__( 'Hover', 'taxvi-pro' ),
			]

		);

		// icon color 
		$this->add_control(
			'project_title_hover_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .single-project-item:hover .project-content a' => 'color:{{VALUE}}',
				],
			]
		);

		
	
		$this->end_controls_tabs();

		

		$this->end_controls_section();

		

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		// main case study content
		$our_projects_items = $settings['our_projects_items'];

		?>


	<div class="project-section project-two section-padding pb-60">
        <div class="container">
            <div class="row">
				<?php foreach($our_projects_items as $single_item){ ?>
				<div class="col-xl-4 col-lg-4 col-md-6 col-12 wow fadeInLeft animated" data-wow-delay="<?php echo esc_html($single_item['our_project_time']); ?>">
                    <div class="single-project-item">
                        <div class="project-thumb">                            
                            <img src="<?php echo esc_attr($single_item['our_project_items_img']['url']); ?>" alt="">
                            <a href="<?php echo esc_url($single_item['our_project_items_url']['url']); ?>" class="details-link"><i class="las la-arrow-right"></i></a>
                        </div>
                        <div class="project-content">
                            <p><?php echo esc_html($single_item['our_project_items_desc']); ?></p>
                            <h4><a href="<?php echo esc_url($single_item['our_project_items_url']['url']); ?>"><?php echo esc_html($single_item['our_project_items_title']); ?></a></h4>
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
