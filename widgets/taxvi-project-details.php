<?php
class Taxvi_Project_Details extends \Elementor\Widget_Base {

	public function get_name() {
		return 'taxvi_project_details';
	}

	public function get_title() {
		return esc_html__( 'Taxvi Project Details', 'taxvi-pro' );
	}

	public function get_icon() {
		return 'eicon-info-box';
	}

	public function get_categories() {
		return [ 'taxvi_cat' ];
	}

	public function get_keywords() {
		return [ 'project', 'taxvi', 'details' ];
	}

	protected function register_controls() {

	// about company Tab Start
	$this->start_controls_section(
		'taxvi_process_section_heading',
		[
			'label' => esc_html__( 'Process Left Side', 'taxvi-pro' ),
			'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
		]
	);
	

	// about left image 
	$this->add_control(
		'process_section_feature_img_left',
		[
			'label' => esc_html__( 'Choose a Process Image', 'taxvi-pro' ),
			'type' => \Elementor\Controls_Manager::MEDIA,
			'default' => [
				'url' => \Elementor\Utils::get_placeholder_image_src(),
			],
		]
	);



	$this->end_controls_section();
	


	}

	protected function render() {
		$settings = $this->get_settings_for_display();



		?>

		<div class="project-details-page pb-120">
				<div class="container">
					<?php

						$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
								

						$project_details = new WP_Query([
							'post_type'		=> 'project_gallery',
							'posts_per_page'	=> 1,
							'post_status'		=> 'publish',
							'paged' => $paged,
						]);
					
					
					while( $project_details -> have_posts()) : $project_details -> the_post(); ?>
					<div class="row">
						<div class="col-12">
							<div class="bread-bg">
								<?php  the_post_thumbnail(); ?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xl-12">
							<div class="project-details">
								<?php  the_content(); ?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="pagination-wrap">
							<?php $previous_post = get_previous_post(); // Retrieve the previous post object
									if ($previous_post) {
							?>
							<a href="<?php echo get_permalink($previous_post); ?>"><i class="las la-long-arrow-alt-left"></i>Previous</a>
							<?php 
                                }
                            ?>

							<?php $next_post = get_next_post(); // Retrieve the previous post object
									if ($next_post) {
								?>
									<a href="<?php echo get_permalink($next_post); ?>"><i class="las la-long-arrow-alt-right"></i>Next</a>
								<?php 
                                }
                           	 ?>
						</div>
					</div>
					<?php  endwhile; ?>
				</div>
			</div>
			
  
		<?php


	}


}
