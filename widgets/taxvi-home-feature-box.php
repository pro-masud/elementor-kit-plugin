<?php
class Feature_Box extends \Elementor\Widget_Base {

	public function get_name() {
		return 'taxvi_feature_box';
	}

	public function get_title() {
		return esc_html__( 'Taxvi Feature Box', 'taxvi-pro' );
	}

	public function get_icon() {
		return 'eicon-checkbox';
	}

	public function get_categories() {
		return [ 'taxvi_cat' ];
	}

	public function get_keywords() {
		return [ 'feature', 'taxvi','box' ];
	}

	protected function register_controls() {

		// about Tab Start
		$this->start_controls_section(
			'taxvi_feature_box_heading',
			[
				'label' => esc_html__( 'Feature Head', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		// Title
		$this->add_control(
			'taxvi_feature_box_main_title',
			[
				'label' => esc_html__( 'Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'We Have Than More 25 Years of Experience
				in Tax Advisor & Financial Consulting
				Services', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		$this->end_controls_section();

		// Content Tab End

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
					'value' => 'far fa-star',
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
			'feature_boxs_title',
			[
				'label' => esc_html__( 'Feature Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Quality Services' , 'taxvi-pro' ),
				'label_block' => true,
			]
		);

		$feature_box->add_control(
			'feature_boxs_desc',
			[
				'label' => esc_html__( 'Feature Description', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit magni' , 'taxvi-pro' ),
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
						'feature_boxs_title' => esc_html__( 'Add New Feature', 'taxvi-pro' ),
					],
				],
				'title_field' => '{{{ feature_boxs_title }}}',
			]
		);

		

		$this->end_controls_section();


		// feature Head Start
		$this->start_controls_section(
			'features_head_style',
			[
				'label' => esc_html__( 'Feature Head Style', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// title heading
		$this->add_control(
			'features_title_head',[
			'label' => esc_html( 'Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// title Color
		$this->add_control(
			'features_box_main_title_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .section-title h2' => 'color: {{VALUE}};',
				],
			]
		);

		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'features_box_main_title_type',
				'selector'	=> '{{WRAPPER}} .section-title h2',
			]
		);
		

		$this->end_controls_section();


		$this->start_controls_section(
			'features_icon_style',
			[
				'label' => esc_html__( 'Feature Content', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// title heading
		$this->add_control(
			'features_icon_head',[
			'label' => esc_html( 'Icon', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// title Color
		$this->add_control(
			'features_box_icon_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .feature-icon i' => 'color: {{VALUE}};',
				],
			]
		);

		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'features_box_icon_type',
				'selector'	=> '{{WRAPPER}} .feature-icon i',
			]
		);

		// title Color
		$this->add_control(
			'features_box_icon_border_color',
			[
				'label' => esc_html__( 'Icon Border Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .feature-item-wrap .feature-icon::after' => 'background: {{VALUE}};',
				],
			]
		);

		// title heading
		$this->add_control(
			'features_box_title_head',[
			'label' => esc_html( 'Feature Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// title Color
		$this->add_control(
			'features_box_title_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .feature-content h4' => 'color: {{VALUE}};',
				],
			]
		);

		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'features_box_title_type',
				'selector'	=> '{{WRAPPER}} .feature-content h4',
			]
		);

		// title heading
		$this->add_control(
			'features_box_desc_head',[
			'label' => esc_html( 'Feature Description', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// title Color
		$this->add_control(
			'features_box_desc_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .feature-content p' => 'color: {{VALUE}};',
				],
			]
		);

		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'features_box_desc_type',
				'selector'	=> '{{WRAPPER}} .feature-content p',
			]
		);

		$this->add_control(
			'features_box_icon_bg_head',[
			'label' => esc_html( 'Icon Background', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'features_box_icon_bg_section',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .feature-item-wrap .feature-icon',
			]
		);

		$this->add_control(
			'features_box_icon_hover_bg_head',[
			'label' => esc_html( 'Icon Hover Background', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'features_box_icon_hover_bg_section',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .feature-item-wrap:hover .feature-icon',
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'features_box_bg_style',
			[
				'label' => esc_html__( 'Box Background', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// title heading
		$this->add_control(
			'features_box_bg_head',[
			'label' => esc_html( 'Section Background Color', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'features_box_bg_section',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .feature-item-wrap',
			]
		);

		// title heading
		$this->add_control(
			'features_box_hover_bg_head',[
			'label' => esc_html( 'Section Hover Background Color', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'features_box_hover_bg_section',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .feature-item-wrap::after',
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		 $taxvi_feature_box_main_title = $settings['taxvi_feature_box_main_title'];
		 $feature_box_lists = $settings['feature_box_lists'];

		?>
				<div class="feature-section section-padding pb-0">
					<div class="container">
						<div class="row">
							<div class="col-xl-12 text-center">
								<div class="section-title">
									<h2><?php echo $taxvi_feature_box_main_title ; ?></h2>
								</div>
							</div>
						</div>
						<div class="row mt-60">
							<?php foreach($feature_box_lists as $feature_single ){ ?>
								<div class="col-xl-4 col-lg-4 col-md-6 col-12 wow fadeInUp animated" data-wow-delay="100ms">
									
									<div class="feature-item-wrap">
										<div class="feature-icon">
											<?php \Elementor\Icons_Manager::render_icon( $feature_single['feature_box_icons'], [ 'aria-hidden' => 'true' ] ); ?>
										</div>
										<div class="feature-content">
											<h4><?php echo esc_html($feature_single['feature_boxs_title']); ?></h4>
											<p><?php echo esc_html($feature_single['feature_boxs_desc']); ?></p>
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
	<div class="feature-section section-padding pb-0">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 text-center">
                    <div class="section-title">
                        <h2>{{{settings.taxvi_feature_box_main_title}}}</h2>
                    </div>
                </div>
            </div>
            <div class="row mt-60">
				<# _.each( settings.feature_box_lists, function( single_feature_box ) {

					var featureBoxIcons = elementor.helpers.renderIcon( view, settings.feature_box_icons, { 'aria-hidden': true }, 'i' , 'object' );
					
					#>
					<div class="col-xl-4 col-lg-4 col-md-6 col-12 wow fadeInUp animated" data-wow-delay="100ms">
						<div class="feature-item-wrap">
							<div class="feature-icon">
								{{{featureBoxIcons.value}}}
							</div>
							<div class="feature-content">
								<h4>{{{single_feature_box.feature_boxs_title}}}</h4>
								<p>{{{single_feature_box.feature_boxs_desc}}}</p>
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
