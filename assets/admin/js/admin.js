/**
 * KINBONI Pro — Haute Atelier Admin Dashboard Scripts
 * Dedicated Backend JavaScript
 *
 * @package KinboniPro
 */

jQuery(document).ready(function($) {
	'use strict';

	const nonce = (window.kinboniAdmin && window.kinboniAdmin.nonce) || '';
	const ajaxurl = (window.kinboniAdmin && window.kinboniAdmin.ajax_url) || window.ajaxurl || '/wp-admin/admin-ajax.php';

	function showToast(msg, isError) {
		const $toast = $('#kb-admin-toast');
		$('#kb-toast-text').text(msg);
		if (isError) {
			$toast.css('border-color', '#ef4444');
		} else {
			$toast.css('border-color', 'var(--kb-gold)');
		}
		$toast.fadeIn(250).delay(3000).fadeOut(300);
	}

	// ── Dark & Light Mode Switcher ──
	const THEME_STORAGE_KEY = 'kinboni_admin_dashboard_theme';
	function applyAdminTheme(theme) {
		if (theme === 'light') {
			$('body').addClass('kb-admin-light-mode');
			$('.kinboni-admin-wrap').addClass('kb-light-theme');
			$('.kb-moon-icon').hide();
			$('.kb-sun-icon').show();
			$('.kb-theme-label').text('Light Mode');
		} else {
			$('body').removeClass('kb-admin-light-mode');
			$('.kinboni-admin-wrap').removeClass('kb-light-theme');
			$('.kb-moon-icon').show();
			$('.kb-sun-icon').hide();
			$('.kb-theme-label').text('Dark Mode');
		}
	}

	const savedAdminTheme = localStorage.getItem(THEME_STORAGE_KEY) || 'dark';
	applyAdminTheme(savedAdminTheme);

	$(document).on('click', '#kb-theme-toggle-btn', function(e) {
		e.preventDefault();
		const currentTheme = $('body').hasClass('kb-admin-light-mode') ? 'light' : 'dark';
		const newTheme = currentTheme === 'light' ? 'dark' : 'light';
		applyAdminTheme(newTheme);
		localStorage.setItem(THEME_STORAGE_KEY, newTheme);
		showToast(newTheme === 'light' ? 'Light mode activated' : 'Dark mode activated');
	});

	// Tabs Switcher with URL hash preservation
	$('.kb-tab-btn').on('click', function() {
		const tab = $(this).data('tab');
		$('.kb-tab-btn').removeClass('active');
		$(this).addClass('active');
		$('.kb-tab-pane').removeClass('active');
		$('#tab-' + tab).addClass('active');
		window.location.hash = tab;
	});

	if (window.location.hash) {
		const hash = window.location.hash.replace('#', '');
		const $targetBtn = $('.kb-tab-btn[data-tab="' + hash + '"]');
		if ($targetBtn.length) {
			$targetBtn.trigger('click');
		}
	}

	// AJAX Save Settings
	$('#kb-btn-save-all').on('click', function(e) {
		e.preventDefault();
		const $btn = $(this);
		$btn.prop('disabled', true).css('opacity', '0.6');

		const formData = $('#kb-dashboard-form').serializeArray();
		const payload = {};
		formData.forEach(function(item) {
			payload[item.name.replace('settings[', '').replace(']', '')] = item.value;
		});

		// Include unchecked checkboxes as 'no'
		$('#kb-dashboard-form input[type="checkbox"]').each(function() {
			const name = $(this).attr('name').replace('settings[', '').replace(']', '');
			if (!$(this).is(':checked')) {
				payload[name] = 'no';
			}
		});

		$.ajax({
			url: ajaxurl,
			type: 'POST',
			data: {
				action: 'kinboni_save_dashboard_settings',
				nonce: nonce,
				settings: payload
			},
			success: function(resp) {
				$btn.prop('disabled', false).css('opacity', '1');
				if (resp.success) {
					showToast(resp.data.message || 'Saved successfully!');
				} else {
					showToast(resp.data.message || 'Error saving settings', true);
				}
			},
			error: function() {
				$btn.prop('disabled', false).css('opacity', '1');
				showToast('Server communication error', true);
			}
		});
	});

	// AJAX Purge Cache
	$('#kb-btn-purge-cache').on('click', function(e) {
		e.preventDefault();
		const $btn = $(this);
		$btn.prop('disabled', true);
		$.post(ajaxurl, { action: 'kinboni_purge_cache', nonce: nonce }, function(resp) {
			$btn.prop('disabled', false);
			if (resp.success) {
				showToast(resp.data.message);
			}
		});
	});

	// Delete Single Subscriber
	$('.kb-btn-delete-sub').on('click', function(e) {
		e.preventDefault();
		const email = $(this).data('email');
		const $row = $(this).closest('tr');
		if (!confirm('Remove subscriber "' + email + '" from VIP list?')) {
			return;
		}
		$.post(ajaxurl, {
			action: 'kinboni_delete_subscriber',
			nonce: nonce,
			email: email
		}, function(resp) {
			if (resp.success) {
				$row.fadeOut(300, function() { $(this).remove(); });
				showToast('Subscriber removed');
			}
		});
	});

	// Clear All Subscribers
	$('#kb-btn-clear-subs').on('click', function(e) {
		e.preventDefault();
		if (!confirm('Are you sure you want to permanently clear all VIP subscribers? This action cannot be undone.')) {
			return;
		}
		$.post(ajaxurl, {
			action: 'kinboni_clear_subscribers',
			nonce: nonce
		}, function(resp) {
			if (resp.success) {
				location.reload();
			}
		});
	});

	// ══════════════════════════════════════════════════
	// PRODUCTS & INVENTORY ENGINE
	// ══════════════════════════════════════════════════
	let currentProdPage = 1;
	let totalProdPages  = 1;
	let currentGallery  = [];
	let primaryFrame    = null;
	let hoverFrame      = null;
	let galleryFrame    = null;
	let catThumbFrame   = null;
	let searchDebounce  = null;

	function formatMoney(amount) {
		return '৳' + Number(amount || 0).toLocaleString();
	}

	function loadProducts(page) {
		currentProdPage = page || 1;
		const $tbody = $('#kb-products-tbody');
		$tbody.html('<tr><td colspan="8" style="text-align: center; padding: 40px; color: var(--kb-text-muted);"><span class="dashicons dashicons-update spin"></span> Loading catalog...</td></tr>');

		const search = $('#kb-prod-search').val().trim();
		const category = $('#kb-prod-cat-filter').val();
		const status = $('#kb-prod-status-filter').val();

		$.post(ajaxurl, {
			action: 'kinboni_get_products',
			nonce: nonce,
			page: currentProdPage,
			per_page: 10,
			search: search,
			category: category,
			status: status
		}, function(resp) {
			if (!resp.success || !resp.data) {
				$tbody.html('<tr><td colspan="8" style="text-align: center; padding: 30px; color: #ef4444;">Error loading creations.</td></tr>');
				return;
			}

			const data = resp.data;
			currentProdPage = data.current_page;
			totalProdPages  = data.total_pages || 1;

			$('#kb-products-count-badge').text(data.total);
			$('#kb-products-total-label').text('Total: ' + data.total + ' products');
			$('#kb-prod-pagination-info').text('Showing page ' + currentProdPage + ' of ' + totalProdPages + ' (' + data.total + ' creations)');
			$('#kb-pg-page-num').text(currentProdPage + ' / ' + totalProdPages);

			$('#kb-pg-prev').prop('disabled', currentProdPage <= 1);
			$('#kb-pg-next').prop('disabled', currentProdPage >= totalProdPages);

			if (!data.products || data.products.length === 0) {
				$tbody.html('<tr><td colspan="8" style="text-align: center; padding: 40px; color: var(--kb-text-muted);">No atelier creations found matching your filter criteria.</td></tr>');
				return;
			}

			let rowsHtml = '';
			data.products.forEach(function(p) {
				const imgHtml = p.image
					? '<img src="' + p.image + '" style="width: 44px; height: 44px; border-radius: 8px; object-fit: cover; border: 1px solid var(--kb-border);" alt="">'
					: '<div style="width: 44px; height: 44px; border-radius: 8px; background: rgba(255,255,255,0.05); display: flex; align-items: center; justify-content: center; color: var(--kb-text-muted);"><span class="dashicons dashicons-format-image"></span></div>';

				let priceHtml = '';
				if (p.sale_price > 0 && p.sale_price < p.regular_price) {
					priceHtml = '<div style="display: flex; flex-direction: column;"><span style="text-decoration: line-through; color: var(--kb-text-muted); font-size: 11px;">' + formatMoney(p.regular_price) + '</span><span style="color: var(--kb-gold); font-weight: 700;">' + formatMoney(p.sale_price) + '</span></div>';
				} else {
					priceHtml = '<span style="color: #fff; font-weight: 700;">' + formatMoney(p.price) + '</span>';
				}

				let catPills = '';
				if (p.categories && p.categories.length > 0) {
					catPills = p.categories.map(function(c) {
						return '<span class="kb-badge-pill kb-badge-muted" style="margin-right: 4px; margin-bottom: 2px;">' + c.name + '</span>';
					}).join('');
				} else {
					catPills = '<span style="color: var(--kb-text-muted); font-size: 11px;">—</span>';
				}

				const badgeHtml = p.badge
					? '<span class="kb-badge-pill kb-badge-gold" style="margin-left: 6px;">' + p.badge + '</span>'
					: '';

				const stockHtml = p.stock_status === 'instock'
					? '<span class="kb-badge-pill kb-badge-green">In Stock (' + p.stock_quantity + ')</span>'
					: '<span class="kb-badge-pill kb-badge-red">Out of Stock</span>';

				const statusHtml = p.status === 'publish'
					? '<span class="kb-badge-pill kb-badge-green">Published</span>'
					: '<span class="kb-badge-pill kb-badge-muted">Draft</span>';

				rowsHtml += '<tr id="kb-prod-row-' + p.id + '">' +
					'<td>' + imgHtml + '</td>' +
					'<td>' +
						'<div style="font-weight: 600; color: #fff; display: flex; align-items: center; flex-wrap: wrap;">' +
							p.name + badgeHtml +
						'</div>' +
					'</td>' +
					'<td><code>' + p.sku + '</code></td>' +
					'<td>' + catPills + '</td>' +
					'<td>' + priceHtml + '</td>' +
					'<td>' + stockHtml + '</td>' +
					'<td>' + statusHtml + '</td>' +
					'<td style="text-align: right; white-space: nowrap;">' +
						'<button type="button" class="kb-btn-secondary kb-btn-edit-product" data-id="' + p.id + '" style="padding: 4px 8px; font-size: 11px; margin-right: 4px;" title="Edit">' +
							'<span class="dashicons dashicons-edit"></span>' +
						'</button>' +
						'<a href="' + p.view_url + '" target="_blank" class="kb-btn-secondary" style="padding: 4px 8px; font-size: 11px; margin-right: 4px;" title="View in Store">' +
							'<span class="dashicons dashicons-visibility"></span>' +
						'</a>' +
						'<button type="button" class="kb-btn-secondary kb-btn-delete-product" data-id="' + p.id + '" data-name="' + p.name.replace(/"/g, '&quot;') + '" style="padding: 4px 8px; font-size: 11px; color: #ef4444;" title="Delete">' +
							'<span class="dashicons dashicons-trash"></span>' +
						'</button>' +
					'</td>' +
				'</tr>';
			});

			$tbody.html(rowsHtml);
		});
	}

	// Filter toolbar listeners
	$('#kb-prod-search').on('keyup', function() {
		clearTimeout(searchDebounce);
		searchDebounce = setTimeout(function() {
			loadProducts(1);
		}, 350);
	});

	$('#kb-prod-cat-filter, #kb-prod-status-filter').on('change', function() {
		loadProducts(1);
	});

	$('#kb-pg-prev').on('click', function() {
		if (currentProdPage > 1) {
			loadProducts(currentProdPage - 1);
		}
	});

	$('#kb-pg-next').on('click', function() {
		if (currentProdPage < totalProdPages) {
			loadProducts(currentProdPage + 1);
		}
	});

	// Specs repeater helper
	function addSpecRow(value) {
		const val = value || '';
		const $row = $('<div class="kb-spec-row">' +
			'<input type="text" class="kb-input kb-spec-input" style="max-width: 100%; flex: 1;" placeholder="e.g. 316L Surgical Grade Steel" value="' + val.replace(/"/g, '&quot;') + '">' +
			'<button type="button" class="kb-btn-secondary kb-btn-remove-spec" style="color: #ef4444; padding: 8px 10px;" title="Remove">' +
				'<span class="dashicons dashicons-trash"></span>' +
			'</button>' +
		'</div>');
		$('#kb-specs-container').append($row);
	}

	$('#kb-btn-add-spec').on('click', function() {
		addSpecRow('');
	});

	$(document).on('click', '.kb-btn-remove-spec', function() {
		$(this).closest('.kb-spec-row').remove();
	});

	// Manage stock checkbox toggle
	$('#kb-p-manage-stock').on('change', function() {
		if ($(this).is(':checked')) {
			$('#kb-stock-qty-box').slideDown(150);
		} else {
			$('#kb-stock-qty-box').slideUp(150);
		}
	});

	// Gallery rendering
	function renderGallery() {
		const $wrap = $('#kb-gallery-container');
		$wrap.empty();
		if (!currentGallery || currentGallery.length === 0) {
			$wrap.html('<span id="kb-gallery-empty-tip" style="font-size: 11px; color: var(--kb-text-muted); margin: auto;">No gallery images attached</span>');
			return;
		}
		currentGallery.forEach(function(item, idx) {
			const $item = $('<div class="kb-gallery-thumb-item">' +
				'<img src="' + item.url + '" alt="">' +
				'<button type="button" class="kb-gallery-remove-btn" data-index="' + idx + '">&times;</button>' +
			'</div>');
			$wrap.append($item);
		});
	}

	$(document).on('click', '.kb-gallery-remove-btn', function(e) {
		e.stopPropagation();
		const idx = parseInt($(this).data('index'), 10);
		currentGallery.splice(idx, 1);
		renderGallery();
	});

	// Media pickers: Primary Image
	$('#kb-primary-img-box').on('click', function(e) {
		e.preventDefault();
		if (primaryFrame) {
			primaryFrame.open();
			return;
		}
		primaryFrame = wp.media({
			title: 'Select Primary Product Image',
			button: { text: 'Use this Image' },
			multiple: false,
			library: { type: 'image' }
		});
		primaryFrame.on('select', function() {
			const attachment = primaryFrame.state().get('selection').first().toJSON();
			$('#kb-p-image-id').val(attachment.id);
			$('#kb-primary-preview').html('<img src="' + attachment.url + '" style="width: 100%; height: 100%; object-fit: cover;" alt="">');
			$('#kb-primary-remove-btn').show();
		});
		primaryFrame.open();
	});

	$('#kb-primary-remove-btn').on('click', function() {
		$('#kb-p-image-id').val('');
		$('#kb-primary-preview').html('<span class="dashicons dashicons-camera" style="font-size: 24px; width: 24px; height: 24px; color: var(--kb-gold);"></span><span style="font-size: 10px; margin-top: 4px;">Select Image</span>');
		$(this).hide();
	});

	// Media pickers: Hover Image
	$('#kb-hover-img-box').on('click', function(e) {
		e.preventDefault();
		if (hoverFrame) {
			hoverFrame.open();
			return;
		}
		hoverFrame = wp.media({
			title: 'Select Hover / Secondary Image',
			button: { text: 'Use this Image' },
			multiple: false,
			library: { type: 'image' }
		});
		hoverFrame.on('select', function() {
			const attachment = hoverFrame.state().get('selection').first().toJSON();
			$('#kb-p-hover-image-id').val(attachment.id);
			$('#kb-hover-preview').html('<img src="' + attachment.url + '" style="width: 100%; height: 100%; object-fit: cover;" alt="">');
			$('#kb-hover-remove-btn').show();
		});
		hoverFrame.open();
	});

	$('#kb-hover-remove-btn').on('click', function() {
		$('#kb-p-hover-image-id').val('');
		$('#kb-hover-preview').html('<span class="dashicons dashicons-images-alt" style="font-size: 24px; width: 24px; height: 24px; color: var(--kb-text-muted);"></span><span style="font-size: 10px; margin-top: 4px;">Select Image</span>');
		$(this).hide();
	});

	// Media pickers: Gallery Multi-Images
	$('#kb-btn-add-gallery').on('click', function(e) {
		e.preventDefault();
		if (galleryFrame) {
			galleryFrame.open();
			return;
		}
		galleryFrame = wp.media({
			title: 'Add Images to Product Gallery',
			button: { text: 'Add to Gallery' },
			multiple: true,
			library: { type: 'image' }
		});
		galleryFrame.on('select', function() {
			const selection = galleryFrame.state().get('selection');
			selection.map(function(att) {
				const item = att.toJSON();
				currentGallery.push({
					id: item.id,
					url: item.url
				});
			});
			renderGallery();
		});
		galleryFrame.open();
	});

	// Open Product Modal
	function openProductModal(id) {
		const isEdit = (id && id > 0);
		$('#kb-p-id').val(isEdit ? id : 0);
		$('#kb-p-name').val('');
		$('#kb-p-slug').val('');
		$('#kb-p-regular-price').val('');
		$('#kb-p-sale-price').val('');
		$('#kb-p-sku').val('');
		$('#kb-p-badge').val('');
		$('#kb-p-short-desc').val('');
		$('#kb-p-desc').val('');
		$('#kb-specs-container').empty();
		$('input[name="p_status"][value="publish"]').prop('checked', true);
		$('#kb-p-featured').prop('checked', false);
		$('#kb-p-manage-stock').prop('checked', false);
		$('#kb-stock-qty-box').hide();
		$('#kb-p-stock-qty').val('');
		$('#kb-p-stock-status').val('instock');
		$('.kb-modal-cat-checkbox').prop('checked', false);
		$('#kb-primary-remove-btn').trigger('click');
		$('#kb-hover-remove-btn').trigger('click');
		currentGallery = [];
		renderGallery();

		if (!isEdit) {
			$('#kb-modal-product-title').text('Create New Atelier Creation');
			addSpecRow('');
			$('#kb-product-modal').addClass('is-open');
		} else {
			$('#kb-modal-product-title').text('Edit Atelier Creation');
			$('#kb-product-modal').addClass('is-open');

			$.post(ajaxurl, {
				action: 'kinboni_get_product',
				nonce: nonce,
				product_id: id
			}, function(resp) {
				if (!resp.success || !resp.data) {
					showToast('Error loading product data', true);
					return;
				}
				const p = resp.data;
				$('#kb-p-name').val(p.name);
				$('#kb-p-slug').val(p.slug);
				$('#kb-p-regular-price').val(p.regular_price);
				$('#kb-p-sale-price').val(p.sale_price);
				$('#kb-p-sku').val(p.sku);
				$('#kb-p-badge').val(p.badge || '');
				$('#kb-p-short-desc').val(p.short_description);
				$('#kb-p-desc').val(p.description);

				$('input[name="p_status"][value="' + p.status + '"]').prop('checked', true);
				$('#kb-p-featured').prop('checked', p.featured === 'yes');

				if (p.manage_stock === 'yes') {
					$('#kb-p-manage-stock').prop('checked', true);
					$('#kb-stock-qty-box').show();
					$('#kb-p-stock-qty').val(p.stock_quantity);
				}
				$('#kb-p-stock-status').val(p.stock_status || 'instock');

				// Categories
				if (p.categories && Array.isArray(p.categories)) {
					p.categories.forEach(function(cid) {
						$('.kb-modal-cat-checkbox[value="' + cid + '"]').prop('checked', true);
					});
				}

				// Images
				if (p.image_id && p.image_url) {
					$('#kb-p-image-id').val(p.image_id);
					$('#kb-primary-preview').html('<img src="' + p.image_url + '" style="width: 100%; height: 100%; object-fit: cover;" alt="">');
					$('#kb-primary-remove-btn').show();
				}

				if (p.hover_image_id || p.hover_image_url) {
					if (p.hover_image_id) {
						$('#kb-p-hover-image-id').val(p.hover_image_id);
					}
					const hUrl = p.hover_image_url;
					if (hUrl) {
						$('#kb-hover-preview').html('<img src="' + hUrl + '" style="width: 100%; height: 100%; object-fit: cover;" alt="">');
						$('#kb-hover-remove-btn').show();
					}
				}

				// Gallery
				if (p.gallery && Array.isArray(p.gallery)) {
					currentGallery = p.gallery.slice();
					renderGallery();
				}

				// Specs
				if (p.specs && Array.isArray(p.specs)) {
					p.specs.forEach(function(s) {
						addSpecRow(s);
					});
				} else {
					addSpecRow('');
				}
			});
		}
	}

	$('#kb-btn-open-add-product').on('click', function() {
		openProductModal(0);
	});

	$(document).on('click', '.kb-btn-edit-product', function() {
		const id = $(this).data('id');
		openProductModal(id);
	});

	$('#kb-btn-close-product-modal, #kb-btn-cancel-product-modal').on('click', function() {
		$('#kb-product-modal').removeClass('is-open');
	});

	// Save Product Form
	$('#kb-product-edit-form').on('submit', function(e) {
		e.preventDefault();
		const $btn = $('#kb-btn-save-product-submit');
		$btn.prop('disabled', true).css('opacity', '0.6');

		const catIds = [];
		$('.kb-modal-cat-checkbox:checked').each(function() {
			catIds.push($(this).val());
		});

		const specs = [];
		$('.kb-spec-input').each(function() {
			const v = $(this).val().trim();
			if (v) {
				specs.push(v);
			}
		});

		const galleryIds = currentGallery.map(function(g) { return g.id; });

		const payload = {
			id: $('#kb-p-id').val(),
			name: $('#kb-p-name').val().trim(),
			slug: $('#kb-p-slug').val().trim(),
			regular_price: $('#kb-p-regular-price').val(),
			sale_price: $('#kb-p-sale-price').val(),
			sku: $('#kb-p-sku').val().trim(),
			badge: $('#kb-p-badge').val(),
			short_description: $('#kb-p-short-desc').val(),
			description: $('#kb-p-desc').val(),
			status: $('input[name="p_status"]:checked').val() || 'publish',
			featured: $('#kb-p-featured').is(':checked') ? 'yes' : 'no',
			manage_stock: $('#kb-p-manage-stock').is(':checked') ? 'yes' : 'no',
			stock_quantity: $('#kb-p-stock-qty').val(),
			stock_status: $('#kb-p-stock-status').val(),
			categories: catIds,
			image_id: $('#kb-p-image-id').val(),
			hover_image_id: $('#kb-p-hover-image-id').val(),
			gallery_ids: galleryIds,
			specs: specs
		};

		$.post(ajaxurl, {
			action: 'kinboni_save_product',
			nonce: nonce,
			product: payload
		}, function(resp) {
			$btn.prop('disabled', false).css('opacity', '1');
			if (resp.success) {
				showToast(resp.data.message || 'Creation synchronized with WooCommerce');
				$('#kb-product-modal').removeClass('is-open');
				loadProducts(currentProdPage);
			} else {
				showToast(resp.data.message || 'Error saving creation', true);
			}
		}).fail(function() {
			$btn.prop('disabled', false).css('opacity', '1');
			showToast('Server error while saving product', true);
		});
	});

	// Delete Product
	$(document).on('click', '.kb-btn-delete-product', function() {
		const id = $(this).data('id');
		const name = $(this).data('name');
		if (!confirm('Move creation "' + name + '" to trash?')) {
			return;
		}
		$.post(ajaxurl, {
			action: 'kinboni_delete_product',
			nonce: nonce,
			product_id: id
		}, function(resp) {
			if (resp.success) {
				showToast(resp.data.message || 'Product removed');
				loadProducts(currentProdPage);
			} else {
				showToast(resp.data.message || 'Could not delete product', true);
			}
		});
	});

	// Categories Modal
	$('#kb-btn-open-categories').on('click', function() {
		$('#kb-cats-modal').addClass('is-open');
	});

	$('#kb-btn-close-cats-modal, #kb-btn-close-cats-modal-footer').on('click', function() {
		$('#kb-cats-modal').removeClass('is-open');
	});

	$('#kb-btn-pick-cat-thumb').on('click', function(e) {
		e.preventDefault();
		if (catThumbFrame) {
			catThumbFrame.open();
			return;
		}
		catThumbFrame = wp.media({
			title: 'Select Category Thumbnail',
			button: { text: 'Use Image' },
			multiple: false,
			library: { type: 'image' }
		});
		catThumbFrame.on('select', function() {
			const att = catThumbFrame.state().get('selection').first().toJSON();
			$('#kb-cat-thumb-id').val(att.id);
			$('#kb-cat-thumb-label').text(att.filename || 'Image selected');
		});
		catThumbFrame.open();
	});

	$('#kb-category-form').on('submit', function(e) {
		e.preventDefault();
		const $btn = $('#kb-btn-save-cat');
		$btn.prop('disabled', true);

		const name = $('#kb-cat-name').val().trim();
		const slug = $('#kb-cat-slug').val().trim();
		const desc = $('#kb-cat-desc').val().trim();
		const thumbId = $('#kb-cat-thumb-id').val();

		$.post(ajaxurl, {
			action: 'kinboni_save_category',
			nonce: nonce,
			name: name,
			slug: slug,
			description: desc,
			thumbnail_id: thumbId
		}, function(resp) {
			$btn.prop('disabled', false);
			if (resp.success) {
				showToast(resp.data.message || 'Category saved successfully!');
				$('#kb-cat-name').val('');
				$('#kb-cat-slug').val('');
				$('#kb-cat-desc').val('');
				$('#kb-cat-thumb-id').val(0);
				$('#kb-cat-thumb-label').text('No image');
				setTimeout(function() { location.reload(); }, 900);
			} else {
				showToast(resp.data.message || 'Error saving category', true);
			}
		});
	});

	$(document).on('click', '.kb-btn-delete-cat', function() {
		const id = $(this).data('id');
		const name = $(this).data('name');
		if (!confirm('Are you sure you want to delete category "' + name + '"?')) {
			return;
		}
		$.post(ajaxurl, {
			action: 'kinboni_delete_category',
			nonce: nonce,
			term_id: id
		}, function(resp) {
			if (resp.success) {
				$('#kb-cat-row-' + id).fadeOut(250, function() { $(this).remove(); });
				showToast(resp.data.message || 'Category removed');
			} else {
				showToast(resp.data.message || 'Error deleting category', true);
			}
		});
	});

	// Demo Products Migration Modal
	$('#kb-btn-open-demo-import').on('click', function() {
		$('#kb-import-modal').addClass('is-open');
	});

	$('#kb-btn-close-import-modal, #kb-btn-cancel-import').on('click', function() {
		$('#kb-import-modal').removeClass('is-open');
	});

	$('#kb-btn-run-import').on('click', function() {
		const $btn = $(this);
		$btn.prop('disabled', true).css('opacity', '0.6');
		$('#kb-import-progress-box').slideDown(200);

		let progress = 10;
		const timer = setInterval(function() {
			if (progress < 85) {
				progress += Math.floor(Math.random() * 8) + 4;
				$('#kb-import-progress-bar').css('width', progress + '%');
				$('#kb-import-percent-text').text(progress + '%');
			}
		}, 400);

		$.post(ajaxurl, {
			action: 'kinboni_migrate_demo_products',
			nonce: nonce
		}, function(resp) {
			clearInterval(timer);
			$btn.prop('disabled', false).css('opacity', '1');

			if (resp.success) {
				$('#kb-import-progress-bar').css('width', '100%');
				$('#kb-import-percent-text').text('100%');
				$('#kb-import-status-text').text('Import completed successfully!');
				showToast(resp.data.message || 'All 12 demo creations synchronized!');
				setTimeout(function() {
					$('#kb-import-modal').removeClass('is-open');
					$('#kb-import-progress-box').hide();
					$('#kb-import-progress-bar').css('width', '0%');
					loadProducts(1);
				}, 1200);
			} else {
				showToast(resp.data.message || 'Import failed', true);
			}
		}).fail(function() {
			clearInterval(timer);
			$btn.prop('disabled', false).css('opacity', '1');
			showToast('Server communication error during import', true);
		});
	});

	// Initialize products catalog table
	loadProducts(1);
});

