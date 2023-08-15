<?php
class Pixvi_Our_Team extends \Elementor\Widget_Base {

	public function get_name() {
		return 'taxvi_our_team';
	}

	public function get_title() {
		return esc_html__( 'Taxvi Team Member', 'taxvi-pro' );
	}

	public function get_icon() {
		return 'eicon-post-slider';
	}

	public function get_categories() {
		return [ 'taxvi_cat' ];
	}

	public function get_keywords() {
		return [ 'Counter', 'taxvi' ];
	}

	protected function register_controls() {

		// Team Tab Start
		$this->start_controls_section(
			'taxvi_team_heading',
			[
				'label' => esc_html__( 'Our Team', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		//Team Content
		$this->add_control(
			'taxvi_team_head',[
			'label' => esc_html( 'Team Header', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
			
		]);	

		// Team Sub Title
		$this->add_control(
			'taxvi_team_sub_title',
			[
				'label' => esc_html__( 'Sub Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Our Team Members', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		// Team Title
		$this->add_control(
			'taxvi_team_title',
			[
				'label' => esc_html__( 'Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Our dedicated tax advisor financial consulting will help you!', 'taxvi-pro' ),
				'label_block'	=> true,
			]
		);

		// Team Repeater Section Here now
		$Teams = new \Elementor\Repeater();

		// Team Image
		$Teams->add_control(
			'team_member_img',
			[
				'label' => esc_html__( 'Choose Member Image', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$Teams->add_control(
			'team_name',
			[
				'label' => esc_html__( 'Member Name', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Debra Harris' , 'taxvi-pro' ),
				'label_block' => true,
			]
		);

		$Teams->add_control(
			'team_job_title',
			[
				'label' => esc_html__( 'Job Title', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'YTax Advisor' , 'taxvi-pro' ),
				'label_block' => true,
			]
		);

		$Teams->add_control(
			'team_desc',
			[
				'label' => esc_html__( 'Description', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Nemo enim ipsam voluptatem quia voluptas sit aspernatur' , 'taxvi-pro' ),
				'label_block' => true,
			]
		);

		//Social Heading Content
		$Teams->add_control(
			'teams_social_links',[
			'label' => esc_html( 'Social Links', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
			
		]);	

		$Teams->add_control(
			'rep_facebook_link',
			[
				'label' => esc_html__( 'Facebook Profile Link', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'taxvi-pro' ),
				'options' => [ 'url' ],
				'default' => [
					'url' => '#',
				],
				'label_block' => true,
			]
		);

		$Teams->add_control(
			'rep_twitter_link',
			[
				'label' => esc_html__( 'Twitter Profile Link', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'taxvi-pro' ),
				'options' => [ 'url' ],
				'default' => [
					'url' => '#',
				],
				'label_block' => true,
			]
		);

		$Teams->add_control(
			'rep_linkedin_link',
			[
				'label' => esc_html__( 'Linkedin Profile Link', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'taxvi-pro' ),
				'options' => [ 'url' ],
				'default' => [
					'url' => '#',
				],
				'label_block' => true,
			]
		);

		$Teams->add_control(
			'rep_debee_link',
			[
				'label' => esc_html__( 'Linkedin Others Link', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'taxvi-pro' ),
				'options' => [ 'url' ],
				'default' => [
					'url' => '#',
				],
				'label_block' => true,
			]
		);

		$this->add_control(
			'team_animation_time_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		//Animation Time
		$Teams->add_control(
			'teams_animation_time',[
			'label' => esc_html( 'Animation Time', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
			
		]);	

		$Teams->add_control(
			'team_animation_time',
			[
				'label' => esc_html__( 'Set Animation Time', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( '200ms' , 'taxvi-pro' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'our_tems',
			[
				'label' => esc_html__( 'Our Teams', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $Teams->get_controls(),
				'default' => [
					[
						'team_name' => esc_html__( 'Add Member', 'taxvi-pro' ),
					],
				],
				'title_field' => '{{{ team_name }}}',
			]
		);

		

	

		$this->end_controls_section();

		// Content Tab End


		// Style team Start
		$this->start_controls_section(
			'team_heading_style',
			[
				'label' => esc_html__( 'Team Heading Style', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// Team heading
		$this->add_control(
			'team_head',[
			'label' => esc_html( 'Sub Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// Counter number Color
		$this->add_control(
			'team_sub_title_color',
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
				'name'		=> 'team_sub_title_type',
				'selector'	=> '{{WRAPPER}} .section-title h6',
				
				
			]
		);

		// sub title border Color
		$this->add_control(
			'team_sub_title_border_color',
			[
				'label' => esc_html__( 'Border Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .section-title h6' => 'border-color: {{VALUE}};',
				],
				'separator'		=> 'after'
			]
		);	

		


		// Team Title
		$this->add_control(
			'team_title',[
			'label' => esc_html( 'Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// Title Color
		$this->add_control(
			'team_title_color',
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
				'name'		=> 'team_title_type',
				'selector'	=> '{{WRAPPER}} .section-title h2',
			]
		);

		// section background end
		$this->end_controls_section();

		// Style Add team Start
		$this->start_controls_section(
			'team_add_member_style',
			[
				'label' => esc_html__( 'Team Member Style', 'taxvi-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// box heading
		$this->add_control(
			'box_bg_color',[
			'label' => esc_html( 'box Background', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// membar box color
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'background',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .team-details',
			]
		);

		$this->add_control(
			'team_bg_img_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);	

		// box member Title color
		$this->add_control(
			'member_title_head',[
			'label' => esc_html( 'Member Name', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// Member Title Color
		$this->add_control(
			'member_title_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .team-details h4' => 'color: {{VALUE}};',
				],
			]
		);

		// Member title typography
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'member_title_type',
				'selector'	=> '{{WRAPPER}} .team-details h4',
				
			]
		);

		$this->add_control(
			'team_title_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		// box Job Title color
		$this->add_control(
			'job_title_head',[
			'label' => esc_html( 'Job Title', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// job Title Color
		$this->add_control(
			'job_title_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .team-details h6' => 'color: {{VALUE}};',
				],
			]
		);

		// job title typography
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'job_title_type',
				'selector'	=> '{{WRAPPER}} .team-details h6',
				
			]
		);

		$this->add_control(
			'team_sub_title_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		// box Job desc head
		$this->add_control(
			'job_desc_head',[
			'label' => esc_html( 'Description', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// job desc Color
		$this->add_control(
			'job_desc_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .team-details p' => 'color: {{VALUE}};',
				],
			]
		);

		// job desc typography
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'job_desc_type',
				'selector'	=> '{{WRAPPER}} .team-details p',
				
			]
		);

		$this->add_control(
			'team_desc_title_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		// box Job desc head
		$this->add_control(
			'team_social_links',[
			'label' => esc_html( 'Button', 'taxvi-pro'),
			'type'	=>  \Elementor\Controls_Manager::HEADING,
		]);

		// job desc typography
		$this -> add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		=> 'team_job_desc_type',
				'selector'	=> '{{WRAPPER}} .social-link a',
				
			]
		);

		// Btn controls Tab Start
		$this->start_controls_tabs(
			'style_tabs_s'
		);

		$this-> start_controls_tab(
			'team_btn_normal',
			[
				'label' => esc_html__( 'Normal', 'taxvi-pro' ),
			]

		);

		//Title Color
		$this->add_control(
			'team_normal_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .social-link a' => 'color:{{VALUE}}',
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
				'selector' => '{{WRAPPER}} .social-link a',
			]
		);

		$this->add_control(
			'team_bg_color_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		//Normal button Margin
		$this-> add_control('normal_margin',[
			'label'		=> esc_html( 'Margin', 'picchi_extrantion'),
			'type'		=> \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'	=> ['px','%','em','rem'],
			'selectors'	=> ['{{WRAPPER}} .social-link a' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'],
		]);

		$this->add_control(
			'team_normal_padding_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		//Normal button Padding
		$this-> add_control('normal_padding',[
			'label'		=> esc_html( 'Padding', 'picchi_extrantion'),
			'type'		=> \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'	=> ['px','%','em','rem'],
			'selectors'	=> ['{{WRAPPER}} .social-link a' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'],
		]);

		$this->end_controls_tab();



		
		// Btn Hover controls Tab Start
		$this-> start_controls_tab(
			'team_btn_hover',
			[
				'label' => esc_html__( 'Hover', 'taxvi-pro' ),
			]

		);

		//Hover Title Color
		$this->add_control(
			'team_hover_color',
			[
				'label' => esc_html__( 'Color', 'taxvi-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .social-link a:hover' => 'color:{{VALUE}}',
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
				'selector' => '{{WRAPPER}} .social-link a:hover',
			]
		);

		$this->add_control(
			'team_margin_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		//Hover button Margin
		$this-> add_control('hover_margin',[
			'label'		=> esc_html( 'Margin', 'picchi_extrantion'),
			'type'		=> \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'	=> ['px','%','em','rem'],
			'selectors'	=> ['{{WRAPPER}} .social-link a:hover' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'],
		]);

		$this->add_control(
			'hover_padding_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
		//Hover button Padding
		$this-> add_control('hover_padding',[
			'label'		=> esc_html( 'Padding', 'picchi_extrantion'),
			'type'		=> \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'	=> ['px','%','em','rem'],
			'selectors'	=> ['{{WRAPPER}} .social-link a:hover' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'],
		]);

		// Btn controls Tab Start
		$this->end_controls_tabs();

		// section background end
		$this->end_controls_section();

		// Style Tab End

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		 $taxvi_team_sub_title = $settings['taxvi_team_sub_title'];
		 $taxvi_team_title = $settings['taxvi_team_title'];
		 $our_tems = $settings['our_tems'];

		?>
	<div class="team-section section-padding light-bg-1 pb-90">
        <div class="container">
            <div class="row">
                <div class="offset-xl-2 col-xl-8 text-center">
                    <div class="section-title">
                        <h6><?php echo esc_html($taxvi_team_sub_title); ?></h6>
                        <h2><?php echo esc_html($taxvi_team_title); ?></h2>
                    </div>                    
                </div>
            </div>
            <div class="row">
				<?php foreach($our_tems as $single_item){ ?>
                <div class="col-xl-4 col-lg-6 col-md-6 col-12 wow fadeInLeft animated" data-wow-delay="<?php echo esc_html($single_item['team_animation_time']); ?>">
                    <div class="single-team-wrap">
                        <div class="team-thumb">                            
                            <img src="<?php echo esc_attr($single_item['team_member_img']['url']); ?>" alt="">
                        </div>
                        <div class="team-details">
                            <h4><?php echo esc_html($single_item['team_name']); ?></h4>
                            <h6><?php echo esc_html($single_item['team_job_title']); ?></h6>
                            <p><?php echo esc_html($single_item['team_desc']); ?></p>
                            <div class="social-link">
                                <a href="<?php echo esc_url($single_item['rep_facebook_link']['url']); ?>">FB</a>
                                <a href="<?php echo esc_url($single_item['rep_twitter_link']['url']); ?>">TW</a>
                                <a href="<?php echo esc_url($single_item['rep_linkedin_link']['url']); ?>">LI</a>
                                <a href="<?php echo esc_url($single_item['rep_debee_link']['url']); ?>">BE</a>
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


	protected function content_template() {

		?>	
	<div class="team-section section-padding light-bg-1 pb-90">
        <div class="container">
            <div class="row">
                <div class="offset-xl-2 col-xl-8 text-center">
                    <div class="section-title">
                        <h6>{{settings.taxvi_team_sub_title}}</h6>
                        <h2>{{settings.taxvi_team_title}}</h2>
                    </div>                    
                </div>
            </div>

			<# if ( settings.our_tems.length ) { #>
            <div class="row">
				<# _.each( settings.our_tems, function( single_item ) { #>
                <div class="col-xl-4 col-lg-6 col-md-6 col-12 wow fadeInLeft animated" data-wow-delay="200ms">
                    <div class="single-team-wrap">
                        <div class="team-thumb">                            
                            <img src="{{{single_item.team_member_img.url}}}" alt="">
                        </div>
                        <div class="team-details">
                            <h4>{{{single_item.team_name}}}</h4>
                            <h6>{{{single_item.team_job_title}}}</h6>
                            <p>{{{single_item.team_desc}}}</p>
                            <div class="social-link">
                                <a href="{{{single_item.rep_facebook_link.url}}}">FB</a>
                                <a href="{{{single_item.rep_twitter_link.url}}}">TW</a>
                                <a href="{{{single_item.rep_linkedin_link.url}}}">LI</a>
                                <a href="{{{single_item.rep_debee_link.url}}}">BE</a>
                            </div>
                        </div>
                    </div>
                </div>
				<# }); #>       
            </div>
			<#	} #>
        </div>
    </div>
               
		<?php 
	}
}
