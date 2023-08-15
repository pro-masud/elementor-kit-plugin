<?php
class Blog_And_Articles extends \Elementor\Widget_Base {

	public function get_name() {
		return 'taxvi_blog_and_articles';
	}

	public function get_title() {
		return esc_html__( 'Taxvi Blog And Articles', 'taxvi-pro' );
	}

	public function get_icon() {
		return ' eicon-blockquote';
	}

	public function get_categories() {
		return [ 'taxvi_cat' ];
	}

	public function get_keywords() {
		return [ 'Counter', 'taxvi' ];
	}

	protected function register_controls() {

		// blog Tab Start
		$this->start_controls_section(
			'taxvi_blog_and_articles_heading',
			[
				'label' => esc_html__( 'Blog Heading', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		//Blgo Content
		$this->add_control(
			'taxvi_blog_and_articles_head',[
			'label' => esc_html( 'Blog Header', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
			
		]);	

		// blog Sub Title
		$this->add_control(
			'taxvi_blog_and_articles_sub_title',
			[
				'label' => esc_html__( 'Sub Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Blog & Articles', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		// blog Title
		$this->add_control(
			'taxvi_blog_and_articles_title',
			[
				'label' => esc_html__( 'Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Articles daily updated latest articles directly from the blog', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);


		// Select for post type number Title
		$this->add_control(
			'taxvi_blog_and_articles_post_number',
			[
				'label' => esc_html__( 'How Many Post Show', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => esc_html__( '2', 'taxvi-pro' ),
				'options' => [
					'1' => esc_html__( '1', 'taxvi-pro' ),
					'2' => esc_html__( '2', 'taxvi-pro' ),
					'3' => esc_html__( '3', 'taxvi-pro' ),
					'4' => esc_html__( '4', 'taxvi-pro' ),
					'5' => esc_html__( '5', 'taxvi-pro' ),
					'6' => esc_html__( '6', 'taxvi-pro' ),
					'7' => esc_html__( '7', 'taxvi-pro' ),
					'8' => esc_html__( '8', 'taxvi-pro' ),
					'9' => esc_html__( '9', 'taxvi-pro' ),
					'10' => esc_html__( '10', 'taxvi-pro' ),
				],
			]
		);

	
	

		$this->end_controls_section();

		// Content Tab End


		// Style blog_articles Start
		$this->start_controls_section(
			'blog_articles_heading_style',
			[
				'label' => esc_html__( 'blog Heading Style', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// blog heading
		$this->add_control(
			'blog_articles_head',[
			'label' => esc_html( 'Sub Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// Counter number Color
		$this->add_control(
			'blog_articles_sub_title_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .section-title h6' => 'color: {{VALUE}};',
				],
			]
		);


		// sub title type color
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'blog_articles_sub_title_type',
				'selector'	=> '{{WRAPPER}} .section-title h6',
				
				
			]
		);

		// sub title border Color
		$this->add_control(
			'blog_articles_sub_title_border_color',
			[
				'label' => esc_html__( 'Border Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .section-title h6' => 'border-color: {{VALUE}};',
				],
				'separator'		=> 'after'
			]
		);	

		


		// blog Title
		$this->add_control(
			'blog_articles_title',[
			'label' => esc_html( 'Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// Title Color
		$this->add_control(
			'blog_articles_title_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .section-title h2' => 'color: {{VALUE}};',
				],
			]
		);

		// title typography
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'blog_articles_title_type',
				'selector'	=> '{{WRAPPER}} .section-title h2',
			]
		);

		// section background end
		$this->end_controls_section();

		// Style blog_articles Start
		$this->start_controls_section(
			'blog_articles_post_style',
			[
				'label' => esc_html__( 'Blog Box Style', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'blog_articles_cat_and_time_head',[
			'label' => esc_html( 'categorie and Time', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// cat and time Color
		$this->add_control(
			'blog_articles_cat_and_time_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .blog-meta span' => 'color: {{VALUE}};',
				],
			]
		);

		// cat and time typography
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'blog_articles_cat_and_time_type',
				'selector'	=> '{{WRAPPER}}  .blog-meta span',
			]
		);



		$this->add_control(
			'blog_articles_title_color_head',[
			'label' => esc_html( 'Post Box Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// cat and time Color
		$this->add_control(
			'blog_box_articles_title_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .single-blog-item h3 a' => 'color: {{VALUE}};',
				],
			]
		);

		// title typography
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'blog_articles_title_color_type',
				'selector'	=> '{{WRAPPER}}   .single-blog-item h3 a',
			]
		);


		$this->add_control(
			'blog_articles_desc_color_head',[
			'label' => esc_html( 'Post Box Description', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// cat and time Color
		$this->add_control(
			'blog_box_articles_desc_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .single-blog-item p' => 'color: {{VALUE}};',
				],
			]
		);

		// title typography
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'blog_articles_desc_color_type',
				'selector'	=> '{{WRAPPER}}   .single-blog-item p',
			]
		);

		$this->add_control(
			'blog_articles_post_box_head',[
			'label' => esc_html( 'Box Background', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'blog_articles_post_box_bg_color',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}}  .single-blog-item',
			]
		);


		$this->add_control(
			'blog_articles_post_box_border_head',[
			'label' => esc_html( 'Post Box Border', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// cat and time Color
		$this->add_control(
			'blog_articles_post_box_border_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .single-blog-item' => 'border-color: {{VALUE}};',
				],
			]
		);


		

		// section background end
		$this->end_controls_section();


		// Style post box Start
		$this->start_controls_section(
			'blog_articles_post_section_style',
			[
				'label' => esc_html__( 'Post Section Style', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'blog_articles_section_head',[
			'label' => esc_html( 'Section Background', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'blog_articles_section_bg_color',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}}  .white-bg',
			]
		);


		// section background end
		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		 $taxvi_blog_and_articles_sub_title = $settings['taxvi_blog_and_articles_sub_title'];
		 $taxvi_blog_and_articles_title = $settings['taxvi_blog_and_articles_title'];
		 $taxvi_blog_and_articles_post_number = $settings['taxvi_blog_and_articles_post_number'];

		?> 


	<div class="blog-section section-padding pb-90 white-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 text-center">
                    <div class="section-title">
                        <h6><?php echo esc_html( $taxvi_blog_and_articles_sub_title); ?></h6>
                        <h2><?php echo esc_html( $taxvi_blog_and_articles_title); ?></h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php 
						$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
								

							$blog_post = new WP_Query([
								'post_type'		=> 'post',
								'posts_per_page'	=> $taxvi_blog_and_articles_post_number,
								'post_status'		=> 'publish',
								'paged' => $paged,
							]);

							$i = 1;
							if($blog_post){
								while( $blog_post -> have_posts(  )) :  $blog_post -> the_post(); 
									
									$i++;
									if( $i % 2 == 1){
										$time = "400ms";
									}else{
										$time = "200ms";
									}
						?>
						<div class="col-md-6 col-12 text-center wow fadeInLeft animated" data-wow-delay="<?php echo $time; ?>">
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
								<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<p><?php echo wp_trim_words( get_the_content(), 20, null) ?></p>
								<div class="blog-thumb">
									<?php the_post_thumbnail( ); ?>
								</div>
							</div>
						</div>
						
							<?php endwhile;?>

					<?php } ?>
            </div>
        </div>
    </div>
		<?php


	}


	// protected function content_template() {

		
	// }
}
