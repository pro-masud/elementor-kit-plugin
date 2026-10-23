<?php
/**
 * Widget: Demo Card
 *
 * A styled card with Quick View modal button.
 * Demonstrates the KINBONI widget architecture.
 *
 * @package KinboniPro\Widgets
 */

namespace KinboniPro\Widgets;

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
	return;
}

class Widget_Demo extends \Elementor\Widget_Base {

	/* ─── Identity ──────────────────────────────────────────── */

	public function get_name(): string {
		return 'kinboni_demo';
	}

	public function get_title(): string {
		return __( 'KINBONI — Demo Card', 'kinboni-pro' );
	}

	public function get_icon(): string {
		return 'eicon-image-box';
	}

	public function get_categories(): array {
		return [ 'kinboni' ];
	}

	public function get_keywords(): array {
		return [ 'kinboni', 'demo', 'card', 'modal', 'product' ];
	}

	/* ─── Controls ──────────────────────────────────────────── */

	protected function register_controls(): void {

		/* ── Content Tab ─────────────────────────────── */
		$this->start_controls_section( 'section_content', [
			'label' => __( 'Card Content', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'image', [
			'label'   => __( 'Image', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::MEDIA,
			'default' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
		] );

		$this->add_control( 'title', [
			'label'   => __( 'Title', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => __( 'Luxury Product', 'kinboni-pro' ),
		] );

		$this->add_control( 'description', [
			'label'   => __( 'Short Description', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::TEXTAREA,
			'default' => __( 'Handcrafted with premium materials. Limited edition.', 'kinboni-pro' ),
			'rows'    => 3,
		] );

		$this->add_control( 'price', [
			'label'   => __( 'Price', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => '৳ 4,500',
		] );

		$this->add_control( 'badge_text', [
			'label'   => __( 'Badge Text', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => __( 'New', 'kinboni-pro' ),
		] );

		$this->add_control( 'button_text', [
			'label'   => __( 'Button Text', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => __( 'Quick View', 'kinboni-pro' ),
		] );

		$this->end_controls_section();

		/* ── Modal Content ───────────────────────────── */
		$this->start_controls_section( 'section_modal', [
			'label' => __( 'Modal Content', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'modal_description', [
			'label'   => __( 'Full Description', 'kinboni-pro' ),
			'type'    => \Elementor\Controls_Manager::WYSIWYG,
			'default' => '<p>This is the detailed product description shown inside the modal. Features, materials, sizing, etc.</p>',
		] );

		$this->end_controls_section();

		/* ── Style Tab ───────────────────────────────── */
		$this->start_controls_section( 'section_style', [
			'label' => __( 'Card Style', 'kinboni-pro' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'card_bg', [
			'label'     => __( 'Card Background', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#ffffff',
			'selectors' => [ '{{WRAPPER}} .kb-card' => 'background-color: {{VALUE}}' ],
		] );

		$this->add_control( 'accent_color', [
			'label'     => __( 'Accent Color (Gold)', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#C5A028',
			'selectors' => [
				'{{WRAPPER}} .kb-card__price' => 'color: {{VALUE}}',
				'{{WRAPPER}} .kb-card__badge' => 'background-color: {{VALUE}}',
				'{{WRAPPER}} .kb-btn'         => 'background-color: {{VALUE}}',
			],
		] );

		$this->add_control( 'title_color', [
			'label'     => __( 'Title Color', 'kinboni-pro' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#1a1a1a',
			'selectors' => [ '{{WRAPPER}} .kb-card__title' => 'color: {{VALUE}}' ],
		] );

		$this->end_controls_section();
	}

	/* ─── Render ─────────────────────────────────────────────── */

	protected function render(): void {
		$s = $this->get_settings_for_display();

		$uid   = 'kb-modal-' . $this->get_id();
		$img   = ! empty( $s['image']['url'] ) ? esc_url( $s['image']['url'] ) : '';
		$title = esc_html( $s['title'] );
		$desc  = esc_html( $s['description'] );
		$price = esc_html( $s['price'] );
		$badge = esc_html( $s['badge_text'] );
		$btn   = esc_html( $s['button_text'] );
		$modal = wp_kses_post( $s['modal_description'] );
		?>

		<!-- ── Card ──────────────────────────────────── -->
		<div class="kb-card">
			<?php if ( $img ) : ?>
			<div class="kb-card__image-wrap">
				<img src="<?php echo $img; ?>" alt="<?php echo $title; ?>" class="kb-card__image" loading="lazy">
				<?php if ( $badge ) : ?>
					<span class="kb-card__badge"><?php echo $badge; ?></span>
				<?php endif; ?>
			</div>
			<?php endif; ?>

			<div class="kb-card__body">
				<h3 class="kb-card__title"><?php echo $title; ?></h3>
				<p class="kb-card__desc"><?php echo $desc; ?></p>
				<div class="kb-card__footer">
					<span class="kb-card__price"><?php echo $price; ?></span>
					<button class="kb-btn" data-modal="<?php echo esc_attr( $uid ); ?>">
						<?php echo $btn; ?>
					</button>
				</div>
			</div>
		</div>

		<!-- ── Modal ─────────────────────────────────── -->
		<div id="<?php echo esc_attr( $uid ); ?>" class="kb-modal" role="dialog" aria-modal="true" aria-label="<?php echo $title; ?>">
			<div class="kb-modal__backdrop" data-close-modal></div>
			<div class="kb-modal__box">
				<button class="kb-modal__close" data-close-modal aria-label="<?php esc_attr_e( 'Close', 'kinboni-pro' ); ?>">
					<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
				</button>

				<div class="kb-modal__inner">
					<?php if ( $img ) : ?>
					<div class="kb-modal__media">
						<img src="<?php echo $img; ?>" alt="<?php echo $title; ?>">
					</div>
					<?php endif; ?>

					<div class="kb-modal__content">
						<h2 class="kb-modal__title"><?php echo $title; ?></h2>
						<p class="kb-modal__price"><?php echo $price; ?></p>
						<div class="kb-modal__desc"><?php echo $modal; ?></div>

						<button class="kb-btn kb-btn--lg kb-btn--full" disabled>
							<?php esc_html_e( 'Add to Cart — Coming Soon', 'kinboni-pro' ); ?>
						</button>

						<p class="kb-modal__note">
							<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
							<?php esc_html_e( '100% Authentic · Free Returns', 'kinboni-pro' ); ?>
						</p>
					</div>
				</div>
			</div>
		</div>

		<?php
	}
}

