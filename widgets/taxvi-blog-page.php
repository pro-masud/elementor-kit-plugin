<?php
class Pixvi_Blog extends \Elementor\Widget_Base {

	public function get_name() {
		return 'paxvi_blog';
	}

	public function get_title() {
		return esc_html__( 'Taxvi Blog', 'taxvi-pro' );
	}

	public function get_icon() {
		return 'eicon-post-content';
	}

	public function get_categories() {
		return [ 'taxvi_cat' ];
	}

	public function get_keywords() {
		return [ 'blog', 'page' ];
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
				'default' => esc_html__( '', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		// Heading Title
		$this->add_control(
			'taxvi_title',
			[
				'label' => esc_html__( 'Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( '', 'taxvi-pro' ),
			]
		);


		$this->end_controls_section();

		// Content Tab End


		// Style Tab Start

		$this->start_controls_section(
			'section_bg_style',
			[
				'label' => esc_html__( 'Section Background', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		//Section Background
		$this->add_control(
			'section_bg',[
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
			'sub_title_color',[
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

		// Style Tab End

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		// $taxvi_sub_title = $settings['taxvi_sub_title'];
		// $taxvi_title = $settings['taxvi_title'];
		?>
		<!-- Blog Page  -->
			<div class="blog-page pb-120">
				<div class="container">
					<div class="row">
						<div class="col-xl-12">
							<?php 
								$single_post = new WP_Query([
									'post_type'		=> 'post',
									'posts_per_page'	=> 1
								]);

								while( $single_post -> have_posts(  )) :  $single_post -> the_post(); 
							?>
							<div class="blog-slider-item">
								<?php the_post_thumbnail(); ?>
								<div class="blog-content">
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
										<h3><a href="<?php the_permalink( ); ?>"><?php the_title(); ?></a></h3>
										<p><?php echo wp_trim_words( get_the_content(), 25, null) ?></p>                                
									</div>
								</div>
							</div>
							<?php endwhile; ?>
						</div>
					</div>
					<div class="row justify-content-center mt-120">
						<div class="col-xl-6">
							<div class="blog-search-wrap">
								<h2>Check our inside News</h2>
							<div class="row justify-content-center">
								<div class="col-xl-6">
									<div class="search-bar mt-40">
										<form action="GET">
											<input id="search" type="text" placeholder="Search in Blog" name="s" >
											<div class="search-icon">
												<i id="search" class="fal fa-search"></i>
											</div>
										</form>
									</div>
								</div>
							</div>
							</div>
						</div>
					</div>
					<div class="row mt-60">
						<?php 

							$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

							$blog_post = new WP_Query([
								'post_type'		=> 'post',
								'posts_per_page'	=> 2,
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
						
						<ul class="pagination">                                        
								<?php 
									// Add the pagination links
									echo paginate_links(array(
										'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
										'format' => '?paged=%#%',
										'type'	=> 'list',
										'current' => max(1, $paged),
										'total' => $blog_post->max_num_pages,
										'prev_text' => __('<i class="las la-angle-left"></i>', 'taxvi'),
										'next_text' => __('<i class="las la-angle-right"></i>', 'taxvi'),
									));
						 		 ?>
						</ul>
						<?php } ?>
					</div>
				</div>
			</div>
		<?php


	}


	// protected function content_template() {


	// }
}
