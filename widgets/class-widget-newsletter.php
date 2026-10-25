<?php
namespace KinboniPro\Widgets;

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
	return;
}

class Widget_Newsletter extends \Elementor\Widget_Base {

	/* ─── Identity ──────────────────────────────────────────── */

	public function get_name(): string {
		return 'kinboni_newsletter';
	}

	public function get_title(): string {
		return __( 'KINBONI — VIP Newsletter Circle', 'kinboni-pro' );
	}

	public function get_icon(): string {
		return 'eicon-mail';
	}

	public function get_categories(): array {
		return [ 'kinboni' ];
	}

	public function get_keywords(): array {
		return [ 'kinboni', 'newsletter', 'subscribe', 'email', 'vip', 'circle', 'form', 'mail', 'atelier' ];
	}

	public function get_script_depends(): array {
		return [ 'lucide-icons', 'kinboni-pro', 'kinboni-app' ];
	}

	public function get_style_depends(): array {
		return [ 'kinboni-fonts', 'kinboni-output', 'kinboni-pro' ];
	}

	/* ─── Controls ──────────────────────────────────────────── */

	protected function register_controls(): void {

		/* ══════════════════════════════════════════════
		   1. EDITORIAL COPY & HEADINGS
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_newsletter_copy', [
			'label' => __( 'Editorial Headline & Copy', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'show_badge', [
			'label'        => __( 'Show Badge Tag', 'kinboni-pro' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'badge_text', [
			'label'     => __( 'Badge Text', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::TEXT,
			'default'   => __( 'Private Invitations', 'kinboni-pro' ),
			'condition' => [ 'show_badge' => 'yes' ],
		] );

		$this->add_control( 'badge_icon', [
			'label'     => __( 'Badge Lucide Icon', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::TEXT,
			'default'   => 'mail',
			'condition' => [ 'show_badge' => 'yes' ],
		] );

		$this->add_control( 'headline', [
			'label'       => __( 'Main Headline (H2)', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => __( 'Join The Kinboni Circle', 'kinboni-pro' ),
			'label_block' => true,
		] );

		$this->add_control( 'description', [
			'label'       => __( 'Description Copy', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXTAREA,
			'rows'        => 3,
			'default'     => __( 'Subscribe to receive confidential notifications regarding private archive sales, limited numbered releases, and bespoke salon previews.', 'kinboni-pro' ),
			'label_block' => true,
		] );

		$this->end_controls_section();


		/* ══════════════════════════════════════════════
		   2. FORM SETTINGS & VIP PROMO CODE
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_newsletter_form', [
			'label' => __( 'Form Settings & Promo Code', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'form_mode', [
			'label'   => __( 'Form Mode', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'ajax',
			'options' => [
				'ajax'      => __( 'Built-in KINBONI VIP AJAX Form (Instant Feedback)', 'kinboni-pro' ),
				'external'  => __( 'External Form Action URL (Mailchimp / Klaviyo)', 'kinboni-pro' ),
				'shortcode' => __( 'Custom Plugin Shortcode (MC4WP / Fluent)', 'kinboni-pro' ),
			],
		] );

		$this->add_control( 'external_action_url', [
			'label'       => __( 'External Form Action URL', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'placeholder' => 'https://domain.us1.list-manage.com/subscribe/post?...',
			'condition'   => [ 'form_mode' => 'external' ],
			'label_block' => true,
		] );

		$this->add_control( 'custom_shortcode', [
			'label'       => __( 'Custom Shortcode', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'placeholder' => '[mc4wp_form id="123"]',
			'condition'   => [ 'form_mode' => 'shortcode' ],
			'label_block' => true,
		] );

		$this->add_control( 'input_placeholder', [
			'label'     => __( 'Email Placeholder Text', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::TEXT,
			'default'   => __( 'Enter your confidential email...', 'kinboni-pro' ),
			'condition' => [ 'form_mode!' => 'shortcode' ],
		] );

		$this->add_control( 'button_text', [
			'label'     => __( 'Button Text', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::TEXT,
			'default'   => __( 'Subscribe', 'kinboni-pro' ),
			'condition' => [ 'form_mode!' => 'shortcode' ],
		] );

		$this->add_control( 'promo_code', [
			'label'       => __( 'Privilege Voucher Code', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'LUXE20',
			'description' => __( 'Code shown upon successful VIP subscription.', 'kinboni-pro' ),
			'condition'   => [ 'form_mode' => 'ajax' ],
		] );

		$this->add_control( 'success_message', [
			'label'       => __( 'Success Feedback Message', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXTAREA,
			'rows'        => 2,
			'default'     => __( '✓ Welcome to The Kinboni Circle! Your VIP invitation and private 20% privilege code (<strong>{code}</strong>) have been delivered.', 'kinboni-pro' ),
			'description' => __( 'Use {code} to display the privilege code.', 'kinboni-pro' ),
			'condition'   => [ 'form_mode' => 'ajax' ],
		] );

		$this->add_control( 'privacy_note', [
			'label'       => __( 'Privacy & Discretion Note', 'kinboni-pro' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => __( 'We respect your discretion. You may withdraw membership at any instant.', 'kinboni-pro' ),
			'label_block' => true,
		] );

		$this->end_controls_section();


		/* ══════════════════════════════════════════════
		   STYLE TAB: BACKGROUND & ATMOSPHERE
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_style_bg', [
			'label' => __( 'Background & Container', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'section_bg_color', [
			'label'     => __( 'Section Background Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-newsletter-section' => 'background-color: {{VALUE}} !important;' ],
		] );

		$this->add_control( 'section_border_color', [
			'label'     => __( 'Top Border Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-newsletter-section' => 'border-top-color: {{VALUE}} !important;' ],
		] );

		$this->add_responsive_control( 'section_padding', [
			'label'      => __( 'Padding', 'kinboni-pro' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', '%' ],
			'selectors'  => [ '{{WRAPPER}} .kb-newsletter-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->end_controls_section();


		/* ══════════════════════════════════════════════
		   STYLE TAB: TYPOGRAPHY & COLORS
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_style_typography', [
			'label' => __( 'Typography & Colors', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'badge_color', [
			'label'     => __( 'Badge Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-newsletter-badge' => 'color: {{VALUE}} !important;' ],
		] );

		$this->add_control( 'headline_color', [
			'label'     => __( 'Headline Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-newsletter-title' => 'color: {{VALUE}} !important;' ],
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'headline_typo',
				'label'    => __( 'Headline Typography', 'kinboni-pro' ),
				'selector' => '{{WRAPPER}} .kb-newsletter-title',
			]
		);

		$this->add_control( 'desc_color', [
			'label'     => __( 'Description Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-newsletter-desc' => 'color: {{VALUE}} !important;' ],
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'desc_typo',
				'label'    => __( 'Description Typography', 'kinboni-pro' ),
				'selector' => '{{WRAPPER}} .kb-newsletter-desc',
			]
		);

		$this->end_controls_section();


		/* ══════════════════════════════════════════════
		   STYLE TAB: FORM BUTTON & INPUT
		   ══════════════════════════════════════════════ */
		$this->start_controls_section( 'section_style_form', [
			'label' => __( 'Input & Subscribe Button', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'input_bg_color', [
			'label'     => __( 'Input Background Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-newsletter-input' => 'background-color: {{VALUE}} !important;' ],
		] );

		$this->add_control( 'input_border_color', [
			'label'     => __( 'Input Border Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-newsletter-input' => 'border-color: {{VALUE}} !important;' ],
		] );

		$this->add_control( 'btn_bg_color', [
			'label'     => __( 'Button Background Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-newsletter-btn' => 'background-color: {{VALUE}} !important;' ],
		] );

		$this->add_control( 'btn_text_color', [
			'label'     => __( 'Button Text Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .kb-newsletter-btn' => 'color: {{VALUE}} !important;' ],
		] );

		$this->end_controls_section();
	}

	/* ─── Render ────────────────────────────────────────────── */

	protected function render(): void {
		$s = $this->get_settings_for_display();

		$form_mode = $s['form_mode'] ?? 'ajax';
		$code      = ! empty( $s['promo_code'] ) ? esc_html( $s['promo_code'] ) : 'LUXE20';
		$success_raw = ! empty( $s['success_message'] ) ? $s['success_message'] : '✓ Welcome to The Kinboni Circle! Your VIP invitation and private 20% privilege code (<strong>{code}</strong>) have been delivered.';
		$success_msg = str_replace( '{code}', $code, $success_raw );
		?>

		<section class="kb-newsletter-section py-16 sm:py-20 bg-stone-950 text-stone-100 border-t border-stone-800">
			<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">

				<?php if ( 'yes' === ( $s['show_badge'] ?? 'yes' ) && ! empty( $s['badge_text'] ) ) : ?>
					<span class="kb-newsletter-badge inline-flex items-center gap-2 text-xs uppercase font-bold tracking-[0.25em] text-gold-400 mb-3">
						<i data-lucide="<?php echo esc_attr( $s['badge_icon'] ?: 'mail' ); ?>" class="w-4 h-4"></i>
						<span><?php echo esc_html( $s['badge_text'] ); ?></span>
					</span>
				<?php endif; ?>

				<?php if ( ! empty( $s['headline'] ) ) : ?>
					<h2 class="kb-newsletter-title font-serif text-3xl sm:text-4xl lg:text-5xl font-medium text-white mb-4">
						<?php echo esc_html( $s['headline'] ); ?>
					</h2>
				<?php endif; ?>

				<?php if ( ! empty( $s['description'] ) ) : ?>
					<p class="kb-newsletter-desc text-sm sm:text-base text-stone-400 font-light max-w-xl mx-auto mb-8 leading-relaxed">
						<?php echo esc_html( $s['description'] ); ?>
					</p>
				<?php endif; ?>

				<?php if ( 'shortcode' === $form_mode && ! empty( $s['custom_shortcode'] ) ) : ?>
					<div class="max-w-md mx-auto">
						<?php echo do_shortcode( $s['custom_shortcode'] ); ?>
					</div>
				<?php else : ?>
					<!-- Newsletter Form -->
					<form id="newsletter-form"
						  class="max-w-md mx-auto"
						  <?php if ( 'external' === $form_mode && ! empty( $s['external_action_url'] ) ) : ?>
							action="<?php echo esc_url( $s['external_action_url'] ); ?>" method="POST" target="_blank"
						  <?php endif; ?>
						  data-promo="<?php echo esc_attr( $code ); ?>"
						  data-success="<?php echo esc_attr( $success_msg ); ?>"
						  novalidate>
						<div class="flex flex-col sm:flex-row gap-3">
							<input 
								type="email" 
								id="newsletter-email" 
								name="email"
								placeholder="<?php echo esc_attr( $s['input_placeholder'] ?: __( 'Enter your confidential email...', 'kinboni-pro' ) ); ?>" 
								aria-label="<?php echo esc_attr( $s['input_placeholder'] ?: __( 'Your confidential email address', 'kinboni-pro' ) ); ?>"
								class="kb-newsletter-input flex-grow px-5 py-3.5 rounded-xl bg-stone-900 border border-stone-700 text-stone-100 text-xs placeholder:text-stone-500 focus:outline-none focus:border-gold-500 transition-colors"
								required 
							/>
							<button 
								type="submit" 
								class="kb-newsletter-btn px-7 py-3.5 bg-gold-400 hover:bg-gold-500 text-stone-950 text-xs font-bold uppercase tracking-widest rounded-xl shadow-md transition-all active:scale-95 flex-shrink-0"
							>
								<?php echo esc_html( $s['button_text'] ?: __( 'Subscribe', 'kinboni-pro' ) ); ?>
							</button>
						</div>
						<div id="newsletter-feedback" class="hidden"></div>
					</form>
				<?php endif; ?>

				<?php if ( ! empty( $s['privacy_note'] ) ) : ?>
					<p class="mt-4 text-[11px] text-stone-500">
						<?php echo esc_html( $s['privacy_note'] ); ?>
					</p>
				<?php endif; ?>

			</div>
		</section>
		<?php
	}
}

