<?php
class Pixvi_Header extends \Elementor\Widget_Base {

	public function get_name() {
		return 'header_title';
	}

	public function get_title() {
		return esc_html__( 'Taxvi Title', 'taxvi-pro' );
	}

	public function get_icon() {
		return 'eicon-editor-h1';
	}

	public function get_categories() {
		return [ 'taxvi_cat' ];
	}

	public function get_keywords() {
		return [ 'title', 'heading' ];
	}

	protected function register_controls() {

		// Content Tab Start
		$this->start_controls_section(
			'section_title',
			[
				'label' => esc_html__( 'Taxvi Heading', 'taxvi-pro' ),
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
			'taxvi_sub_title',
			[
				'label' => esc_html__( 'Sub Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Sub Title', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		// Heading Title
		$this->add_control(
			'taxvi_title',
			[
				'label' => esc_html__( 'Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'This is a Title', 'taxvi-pro' ),
			]
		);

		$this->add_control(
			'taxvi_image',
			[
				'label' => esc_html__( 'Choose Image', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => '',
				],
			]
		);


		$this->end_controls_section();

		// Content Tab End


		// Style Tab Start

	

		// header Content style start
		$this->start_controls_section(
			'section_title_style',
			[
				'label' => esc_html__( 'Taxvi Heading Style', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		//Sub Title Style Heading
		$this->add_control(
			'sub_title_color_heading',[
			'label' => esc_html( 'Sub Title Color', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// Sub Title Color Controls
		$this->add_control(
			'title_sub_color',
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
				'name'		=> 'sub_title_type',
				'selector'	=> '{{WRAPPER}} .section-title p',
			]
		);

		
		$this->add_control(
			'title_divider_color',
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
			'title_color_heading',[
			'label' => esc_html( 'Title Color', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);


		$this->add_control(
			'title_title_color',
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
				'name'		=> 'title_type',
				'selector'	=> '{{WRAPPER}} .section-title h2',
			]
		);


		
		$this->end_controls_section();

		$this->start_controls_section(
			'section_bg_style',
			[
				'label' => esc_html__( 'Section Background', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		//Section Background
		$this->add_control(
			'section_bg_header',[
			'label' => esc_html( 'Background', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'section_bg',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .light-bg-1',
			]
		);

		// section background end
		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$taxvi_sub_title = $settings['taxvi_sub_title'];
		$taxvi_title = $settings['taxvi_title'];
		$taxvi_image = $settings['taxvi_image']['url'];
		?>
		<div class="breadcrumb-area services section-padding light-bg-1">
				<div class="container">
					<div class="row justify-content-center">
						<div class="text-center">
							<div class="section-title">
								<p><?php echo esc_html($taxvi_sub_title); ?></p>
								<h2><?php echo esc_html($taxvi_title); ?></h2>
							</div>
						</div>
					</div> 
					<?php if($taxvi_image){ ?>
					<div class="row mt-90">
						<div class="col-12">
							<div class="bread-bg">
								<img src="<?php echo esc_attr($taxvi_image); ?>" alt="">
							</div>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>

		<?php


	}


	protected function content_template() {

		?>		

		<#
			if ( settings.taxvi_image.url ) {
				var taxvi_image = {
					id: settings.taxvi_image.id,
					url: settings.taxvi_image.url,
					size: settings.taxvi_image_size,
					dimension: settings.taxvi_image_custom_dimension,
					model: view.getEditModel()
				};

				var taxvi_image_url = elementor.imagesManager.getImageUrl( taxvi_image );

				if ( ! taxvi_image_url ) {
					return;
				}
			}
		#>
			<div class="breadcrumb-area services section-padding light-bg-1">
				<div class="container">
					<div class="row justify-content-center">
						<div class="text-center">
							<div class="section-title">
								<p>{{{settings.taxvi_sub_title}}}</p>
								<h2>{{{settings.taxvi_title}}}</h2>
							</div>
						</div>
					</div> 
					<div class="row mt-90">
						<div class="col-12">
							<div class="bread-bg">
								<img src="{{taxvi_image_url}}" alt="">
							</div>
						</div>
					</div>           
				</div>
			</div>
		<?php 
	}
}
