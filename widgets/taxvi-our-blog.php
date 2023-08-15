<?php
class Our_Blog extends \Elementor\Widget_Base {

	public function get_name() {
		return 'taxvi_our_blog';
	}

	public function get_title() {
		return esc_html__( 'Our Blog', 'taxvi-pro' );
	}

	public function get_icon() {
		return 'eicon-post-slider';
	}

	public function get_categories() {
		return [ 'taxvi_cat' ];
	}

	public function get_keywords() {
		return [ 'blog', 'our' ];
	}

	protected function register_controls() {

		// Team Tab Start
		$this->start_controls_section(
			'our_blog_heading',
			[
				'label' => esc_html__( 'Our Blog', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		//Team Content
		$this->add_control(
			'our_blog_head',[
			'label' => esc_html( 'Blog Head', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
			
		]);	

		// Team Sub Title
		$this->add_control(
			'our_blog_sub_title',
			[
				'label' => esc_html__( 'Sub Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'VISITING OUR BLOG', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		// Team Title
		$this->add_control(
			'our_blog_title',
			[
				'label' => esc_html__( 'Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Latest News And Articles From The Blog Posts', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

	

		$this->end_controls_section();


		// Style our_blog Start
		$this->start_controls_section(
			'our_blog_heading_style',
			[
				'label' => esc_html__( 'Blog Heading Style', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// Team heading
		$this->add_control(
			'our_blog_sub_title_head',[
			'label' => esc_html( 'Sub Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// Counter number Color
		$this->add_control(
			'our_blog_sub_title_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .section-title p' => 'color: {{VALUE}};',
				],
			]
		);


		// sub title type color
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'our_blog_sub_title_type',
				'selector'	=> '{{WRAPPER}} .section-title p',
				
				
			]
		);

		// sub title border Color
		$this->add_control(
			'our_blog_sub_title_border_color',
			[
				'label' => esc_html__( 'Divider Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .section-title p::before' => 'background: {{VALUE}};',
				],
				'separator'		=> 'after'
			]
		);	

		

		$this->add_control(
			'our_blog_title_head',[
			'label' => esc_html( 'Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		$this->add_control(
			'our_blog_title_color',
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
				'name'		=> 'our_blog_title_type',
				'selector'	=> '{{WRAPPER}} .section-title h2',
			]
		);

		// section background end
		$this->end_controls_section();



		$this->start_controls_section(
			'our_blog_post_style',
			[
				'label' => esc_html__( 'Blog Style', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_control(
			'our_blog_post_head',[
			'label' => esc_html( 'Category', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);


		$this->add_control(
			'our_blog_category_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .blog-meta span' => 'color: {{VALUE}};',
				],
			]
		);

		// title typography
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'our_blog_category_type',
				'selector'	=> '{{WRAPPER}} .blog-meta span',
			]
		);


		$this->add_control(
			'blog_post_cat_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		
		$this->add_control(
			'our_blog_title_heading',[
			'label' => esc_html( 'Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'our_blog_post_title_type',
				'selector'	=> '{{WRAPPER}}  .single-blog-item h3 a',
			]
		);

		
		$this->start_controls_tabs(
			'style_tabs_s'
		);

		$this-> start_controls_tab(
			'our_blog_title_normal',
			[
				'label' => esc_html__( 'Normal', 'taxvi-pro' ),
			]

		);

	
		$this->add_control(
			'our_blog_title_normal_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .single-blog-item h3 a' => 'color:{{VALUE}}',
				],
			]
		);



		$this->end_controls_tab();



		
		// Btn Hover controls Tab Start
		$this-> start_controls_tab(
			'our_blog_title_hover',
			[
				'label' => esc_html__( 'Hover', 'taxvi-pro' ),
			]

		);

		//Hover Title Color
		$this->add_control(
			'our_blog_title_hover_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .single-blog-item h3 a:hover' => 'color:{{VALUE}}',
				],
			]
		);


		// Btn controls Tab Start
		$this->end_controls_tabs();

		$this->add_control(
			'blog_post_title_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);


		$this->add_control(
			'our_blog_post_desc_head',[
			'label' => esc_html( 'Description', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);


		$this->add_control(
			'our_blog_desc_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .single-blog-item p' => 'color: {{VALUE}};',
				],
			]
		);

		
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'our_blog_desc_type',
				'selector'	=> '{{WRAPPER}} .single-blog-item p',
			]
		);

		$this->add_control(
			'blog_post_desc_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);



		
		$this->add_control(
			'our_blog_Icons_heading',[
			'label' => esc_html( 'Icons', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'our_blog_post_Icon_type',
				'selector'	=> '{{WRAPPER}}  .single-blog-item h3 a',
			]
		);

		
		$this->start_controls_tabs(
			'style_icon_tabs_s'
		);

		$this-> start_controls_tab(
			'our_blog_icon_normal',
			[
				'label' => esc_html__( 'Normal', 'taxvi-pro' ),
			]

		);

	
		$this->add_control(
			'our_blog_icon_normal_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .single-blog-item .details-link i' => 'color:{{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[	
				'label' => esc_html__( 'Background Color', 'taxvi-pro' ),
				'name' => 'icon_normal_bg',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .single-blog-item .details-link',
			]
		);



		$this->end_controls_tab();



		
		// Btn Hover controls Tab Start
		$this-> start_controls_tab(
			'our_blog_icon_hover',
			[
				'label' => esc_html__( 'Hover', 'taxvi-pro' ),
			]

		);

		//Hover Title Color
		$this->add_control(
			'our_blog_icon_hover_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .single-blog-item:hover .details-link i' => 'color:{{VALUE}}',
				],
			]
		);

		
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[	
				'label' => esc_html__( 'Background Color', 'taxvi-pro' ),
				'name' => 'icon_hover_bg',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .single-blog-item:hover .details-link',
			]
		);


		// Btn controls Tab Start
		$this->end_controls_tabs();


		$this->add_control(
			'blog_post_icon_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'our_blog_post_bg_heading',[
			'label' => esc_html( 'Blog Box', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		$this->add_control(
			'our_blog_post_border_color',
			[
				'label' => esc_html__( 'Border Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .single-blog-item' => 'border-color:{{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[	
				'label' => esc_html__( 'Background', 'taxvi-pro' ),
				'name' => 'blog_bg_color',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .single-blog-item',
			]
		);


		$this->end_controls_section();

		
		$this->start_controls_section(
			'our_blog_section_bg_style',
			[
				'label' => esc_html__( 'Blog Section', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_control(
			'our_blog_section_post_head',[
			'label' => esc_html( 'Background', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[	
				'label' => esc_html__( 'Background', 'taxvi-pro' ),
				'name' => 'blog_section_bg_color',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .white-bg',
			]
		);

		$this->end_controls_section();




	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		 $our_blog_sub_title = $settings['our_blog_sub_title'];
		 $our_blog_title = $settings['our_blog_title'];

		?>
	<div class="blog-section section-padding white-bg pb-0">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 text-center">
                    <div class="section-title">
                        <p><?php echo esc_html($our_blog_sub_title); ?></p>
                        <h2><?php echo esc_html($our_blog_title); ?></h2>
                    </div>
                </div>
            </div>
            <div class="row mt-30">
                <div class="col-lg-6 col-12 wow fadeInUp animated" data-wow-delay="200ms">
					<?php 
						$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
								

						$blog_post = new WP_Query([
							'post_type'		=> 'post',
							'posts_per_page'	=> 1,
							'post_status'		=> 'publish',
							'paged' => $paged,
						]);

						
						while( $blog_post -> have_posts(  )) :  $blog_post -> the_post(); 
					
					?>
                    <div class="single-blog-item">
                        <div class="blog-meta">
							<span>
								<?php 
									// post categories output
									$post_id = get_the_ID();
									$categories =  wp_get_post_categories($post_id); 

									foreach ($categories as $category_id) {
										$cat_name = get_cat_name($category_id);
										echo  $cat_name ;
									}       
								?>
							</span> . <span><?php the_time('j F Y'); ?></span>
						</div>
						<h3><a href="<?php the_permalink(); ?>"><?php echo esc_html(the_title()); ?></a></h3>
						<p><?php echo wp_trim_words( get_the_content(), 16, null) ?></p>
						<div class="blog-thumb">
							<?php the_post_thumbnail( ); ?>
						</div>
                    </div>

					<?php endwhile; ?>
                </div>
                <div class="col-lg-6 col-12 wow fadeInDown animated" data-wow-delay="200ms">

					<?php 
						$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
								
						$blog_post = new WP_Query([
							'post_type'		=> 'post',
							'posts_per_page'	=> 3,
							'post_status'		=> 'publish',
							'paged' => $paged,
						]);

						while( $blog_post -> have_posts(  )) :  $blog_post -> the_post(); 
					?>
						<div class="single-blog-item w-thumb">
							<div class="blog-meta">
								<span>
									<?php 
										// post categories output
										$post_id = get_the_ID();
										$categories =  wp_get_post_categories($post_id); 

										foreach ($categories as $category_id) {
											$cat_name = get_cat_name($category_id);
											echo  $cat_name ;
										}       
									?>
								</span> . <span><?php the_time('j F Y'); ?></span>
							</div>
							<h3><a href="<?php the_permalink(); ?>"><?php echo esc_html(the_title()); ?></a></h3>
							<a href="<?php the_permalink(); ?>" class="details-link"><i class="las la-arrow-right"></i></a>
						</div>
					<?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>
		<?php


	}


}
