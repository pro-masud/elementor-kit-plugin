<?php
class About_Company_Two extends \Elementor\Widget_Base {

	public function get_name() {
		return 'taxvi_about_company_two';
	}

	public function get_title() {
		return esc_html__( 'Taxvi About Company Two', 'taxvi-pro' );
	}

	public function get_icon() {
		return 'eicon-info-box';
	}

	public function get_categories() {
		return [ 'taxvi_cat' ];
	}

	public function get_keywords() {
		return [ 'About', 'Company','Taxvi' ];
	}

	protected function register_controls() {

	// about company Tab Start
	$this->start_controls_section(
		'taxvi_company_two_heading',
		[
			'label' => esc_html__( 'Company Top Section', 'taxvi-pro' ),
			'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
		]
	);

	//about Left heading
	$this->add_control(
		'company_two_left_heading',[
		'label' => esc_html( 'Left Side', 'taxvi-pro'),
		'type'	=>  \Elementor\Controls_Manager::HEADING,
	]);	

	// about left image 
	$this->add_control(
		'company_two_feature_img_left',
		[
			'label' => esc_html__( 'Choose A About Image', 'taxvi-pro' ),
			'type' => \Elementor\Controls_Manager::MEDIA,
			'default' => [
				'url' => \Elementor\Utils::get_placeholder_image_src(),
			],
		]
	);

	// left image about tag title
	$this->add_control(
		'about_two_img_title',
		[
			'label' => esc_html__( 'Image Tag Title', 'taxvi-pro' ),
			'type' => \Elementor\Controls_Manager::TEXT,
			'default' => esc_html__( 'We Have Than 25 Years of Experience' , 'taxvi-pro' ),
			'label_block' => true,
		]
	);

	$this->add_control(
		'about_two_left_hr',
		[
			'type' => \Elementor\Controls_Manager::DIVIDER,
		]
	);


	//about Left heading
	$this->add_control(
		'company_two_right_heading',[
		'label' => esc_html( 'Right Side', 'taxvi-pro'),
		'type'	=>  \Elementor\Controls_Manager::HEADING,
	]);	

	// company two sub title
	$this->add_control(
		'company_two_sub_title',
		[
			'label' => esc_html__( 'Sub Title', 'taxvi-pro' ),
			'type' => \Elementor\Controls_Manager::TEXT,
			'default' => esc_html__( 'About Company', 'taxvi-pro' ),
			'label_block'	=> true,
		]
	);

	// company two title
	$this->add_control(
		'company_two_title',
		[
			'label' => esc_html__( 'Title', 'taxvi-pro' ),
			'type' => \Elementor\Controls_Manager::TEXT,
			'default' => esc_html__( 'Professional Approach and Quality Services', 'taxvi-pro' ),
			'label_block'	=> true,
		]
	);


	// company two title
	$this->add_control(
		'company_two_desc',
		[
			'label' => esc_html__( 'Description', 'taxvi-pro' ),
			'type' => \Elementor\Controls_Manager::TEXTAREA,
			'default' => esc_html__( "There are many variations of passages of Lorem Ipsum available, but the majority suffered alteration in some form, by injected humour, or randomised which don't look even slightly believable. ", 'taxvi-pro' ),
			'label_block'	=> true,
		]
	);


	$about_feature_item = new \Elementor\Repeater();


	// icons 
	$about_feature_item->add_control(
		'company_two_feature_icon',
		[
			'label' => esc_html__( 'Feature Icon', 'taxvi-pro' ),
			'type' => \Elementor\Controls_Manager::ICONS,
			'default' => [
				'value' => 'far fa-check-circle',
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

	// item title
	$about_feature_item->add_control(
		'company_two_feature_title',
		[
			'label' => esc_html__( 'Feature Title', 'taxvi-pro' ),
			'type' => \Elementor\Controls_Manager::TEXT,
			'default' => esc_html__( 'Best Taxation Service' , 'taxvi-pro' ),
			'label_block' => true,
		]
	);

	$this->add_control(
		'about_two_feature_items',
		[
			'label' => esc_html__( 'About Feature Items', 'taxvi-pro' ),
			'type' => \Elementor\Controls_Manager::REPEATER,
			'fields' => $about_feature_item->get_controls(),
			'default' => [
				[
					'company_two_feature_title' => esc_html__( 'Add New Feature', 'taxvi-pro' ),
				],
			],
			'title_field' => '{{{ company_two_feature_title }}}',
		]
	);	

	$this->end_controls_section();





	// about company Tab Start
	$this->start_controls_section(
		'taxvi_company_buttom_heading',
		[
			'label' => esc_html__( 'Company Bottom Section', 'taxvi-pro' ),
			'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
		]
	);


	//about Left heading
	$this->add_control(
		'company_two_buttom_right_heading',[
		'label' => esc_html( 'Right Side', 'taxvi-pro'),
		'type'	=>  \Elementor\Controls_Manager::HEADING,
	]);	

	// company two sub title
	$this->add_control(
		'company_two_buttom_sub_title',
		[
			'label' => esc_html__( 'Sub Title', 'taxvi-pro' ),
			'type' => \Elementor\Controls_Manager::TEXT,
			'default' => esc_html__( 'Who We Are', 'taxvi-pro' ),
			'label_block'	=> true,
		]
	);

	// company two title
	$this->add_control(
		'company_two_buttom_title',
		[
			'label' => esc_html__( 'Title', 'taxvi-pro' ),
			'type' => \Elementor\Controls_Manager::TEXT,
			'default' => esc_html__( 'Providing Quality Tax Services & Consulting', 'taxvi-pro' ),
			'label_block'	=> true,
		]
	);


	// company two title
	$this->add_control(
		'company_two_buttom_desc_title',
		[
			'label' => esc_html__( 'Description', 'taxvi-pro' ),
			'type' => \Elementor\Controls_Manager::TEXTAREA,
			'default' => esc_html__( "There are many variations of passages of Lorem Ipsum available, but the majority suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable ", 'taxvi-pro' ),
			'label_block'	=> true,
		]
	);


	$circle_progress = new \Elementor\Repeater();

	$circle_progress->add_control(
		'progress_title',
		[
			'label' => esc_html__( 'Progress Title', 'taxvi-pro' ),
			'type' => \Elementor\Controls_Manager::TEXT,
			'default' => esc_html__( 'Financial Advising' , 'taxvi-pro' ),
			'label_block' => true,
		]
	);

	$circle_progress->add_control(
		'progress_number',
		[
			'label' => esc_html__( 'Progress Number', 'taxvi-pro' ),
			'type' => \Elementor\Controls_Manager::NUMBER,
			'default' => esc_html__( '99' , 'taxvi-pro' ),
			'label_block' => true,
		]
	);

	$circle_progress->add_control(
		'progress_type',
		[
			'label' => esc_html__( 'Progress Type', 'taxvi-pro' ),
			'type' => \Elementor\Controls_Manager::TEXT,
			'default' => esc_html__( '%' , 'taxvi-pro' ),
			'label_block' => true,
		]
	);


	$this->add_control(
		'progress_list',
		[
			'label' => esc_html__( 'Circle Progress', 'taxvi-pro' ),
			'type' => \Elementor\Controls_Manager::REPEATER,
			'fields' => $circle_progress->get_controls(),
			'default' => [
				[
					'progress_title' => esc_html__( 'Add New Progress', 'taxvi-pro' ),
				]
			],
			'title_field' => '{{{ progress_title }}}',
		]
	);

	

	$this->add_control(
		'about_two_buttom_right_hr',
		[
			'type' => \Elementor\Controls_Manager::DIVIDER,
		]
	);


	//about right heading
	$this->add_control(
		'company_two_buttom_left_head',[
		'label' => esc_html( 'Left Side', 'taxvi-pro'),
		'type'	=>  \Elementor\Controls_Manager::HEADING,
	]);	

	// about right image 
	$this->add_control(
		'company_two_feature_img_right',
		[
			'label' => esc_html__( 'Choose A About Image', 'taxvi-pro' ),
			'type' => \Elementor\Controls_Manager::MEDIA,
			'default' => [
				'url' => \Elementor\Utils::get_placeholder_image_src(),
			],
		]
	);

	// right image about tag title
	$this->add_control(
		'about_two_buttom_right_img_title',
		[
			'label' => esc_html__( 'Image Tag Title', 'taxvi-pro' ),
			'type' => \Elementor\Controls_Manager::TEXT,
			'default' => esc_html__( '99.9% Customer Satisfaction' , 'taxvi-pro' ),
			'label_block' => true,
		]
	);



	$this->end_controls_section();





	$this->start_controls_section(
		'company_top_experience_style',
		[
			'label' => esc_html__( 'Company Top Style', 'taxvi-pro' ),
			'tab' => \Elementor\Controls_Manager::TAB_STYLE,
		]
	);

	// Team heading
	$this->add_control(
		'company_top_experience_head',[
		'label' => esc_html( 'Sub Title', 'taxvi-pro'),
		'type'	=>  \Elementor\Controls_Manager::HEADING,
	]);

	$this->end_controls_section();


	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		// left side 
		$company_two_feature_img_left  = $settings['company_two_feature_img_left']['url'];
		$about_two_img_title  = $settings['about_two_img_title'];

		// top section 
		$company_two_sub_title  = $settings['company_two_sub_title'];
		$company_two_title  = $settings['company_two_title'];
		$company_two_desc  = $settings['company_two_desc'];
		$about_two_feature_items  = $settings['about_two_feature_items'];


		// Bottom section 

		$company_two_buttom_sub_title  = $settings['company_two_buttom_sub_title'];
		$company_two_buttom_title  = $settings['company_two_buttom_title'];
		$company_two_buttom_desc_title  = $settings['company_two_buttom_desc_title'];
		$progress_list  = $settings['progress_list'];



		$company_two_feature_img_right  = $settings['company_two_feature_img_right']['url'];
		$about_two_buttom_right_img_title  = $settings['about_two_buttom_right_img_title'];


	

		?>

<div class="about-section white-bg section-padding">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-12 wow fadeInLeft animated" data-wow-delay="100ms">
                    <div class="about-bg-one" data-background="<?php echo esc_attr($company_two_feature_img_left); ?>">                        
                        <div class="about-tag-title">
                            <h4><?php echo esc_html($about_two_img_title); ?></h4>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-12 wow fadeInUp animated" data-wow-delay="200ms">
                    <div class="about-content-wrap">
                        <div class="section-title">
                            <h6><?php echo esc_html($company_two_sub_title); ?></h6>
                            <h2><?php echo esc_html($company_two_title); ?></h2>
                        </div>
                        <p><?php echo esc_html($company_two_desc); ?></p>
                        <div class="about-feature-list">
								<?php if($about_two_feature_items){ ?>
								<ul>
									<?php foreach($about_two_feature_items as $single_item){ ?>
									<li><?php \Elementor\Icons_Manager::render_icon( $single_item['company_two_feature_icon'], [ 'aria-hidden' => 'true' ] ); ?> <?php echo esc_html($single_item['company_two_feature_title']); ?></li>
									<?php } ?>
								</ul>
							<?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">                
                <div class="col-xl-6 col-lg-6 col-12 text-end wow fadeInUp animated" data-wow-delay="100ms">
                    <div class="about-content-wrap pr-60">
                        <div class="section-title">
                            <h6><?php echo esc_html($company_two_buttom_sub_title); ?></h6>
                            <h2><?php echo esc_html($company_two_buttom_title); ?></h2>
                        </div>
                        <p><?php echo esc_html($company_two_buttom_desc_title); ?></p>
                        <div class="circle_progress_area">
                            <div class="circle_progress_wrap">
								<?php foreach($progress_list as $single_progress){ ?>
                                <div class="circle_progress_single">
                                    <div class="circle_progress_box">
                                        <div id="circle_progress"></div>
                                        <span><?php echo esc_html($single_progress['progress_number']); ?><?php echo esc_html($single_progress['progress_type']); ?></span>
                                    </div>
                                    <div class="circle_progress_content">
                                        <h6><?php echo esc_html($single_progress['progress_title']); ?></h6>
                                    </div>
                                </div>
								<?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-12 wow fadeInRight animated" data-wow-delay="200ms">
                    <div class="about-bg-two" data-background="<?php echo esc_attr($company_two_feature_img_right); ?>">                        
                        <div class="about-tag-title">
                            <h4><?php echo esc_html($about_two_buttom_right_img_title); ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
			
  
		<?php


	}


}
