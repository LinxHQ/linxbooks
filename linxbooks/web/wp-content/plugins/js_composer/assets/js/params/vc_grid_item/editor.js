/* =========================================================
 * lib/panels.js v0.5.0
 * =========================================================
 * Copyright 2014 Wpbakery
 *
 * Visual composer panels & modals for frontend editor
 *
 * ========================================================= */
(function ($) {
	vc.Storage.prototype.getContent = function () {
		var content;
		if (_.isObject(window.tinymce) && tinymce.editors.content) {
			// window.switchEditors.go('content', 'html');
			tinymce.editors.content.save();
		}
		content = window.vc_wpnop($('#content').val());
		return !content.length ? vcDefaultGridItemContent : content;
	};
	vc.visualComposerView.prototype.rowSortableSelector = "> [data-element_type]";
	vc.visualComposerView.prototype.events = {
		'click #vc_templates-editor-button': 'openTemplatesWindow',
		'click [data-vc-navbar-control="edit"]': 'openVcGitemEditForm',
		'click [data-vc-navbar-control="preview"]': 'renderGitemPreview',
		'change [data-vc-navbar-control="preview_width"]': 'setPreviewItemWidth',
		'click #wpb-save-post': 'save',
		'change [data-vc-navbar-control="animation"]': 'changeAnimation'
	};
	vc.visualComposerView.previewActivated = false;
	vc.visualComposerView.prototype.renderGitemPreview = function (e) {
		e && e.preventDefault();
		if (this.previewActivated) {
			this.hidePreview();
		} else {
			vc.showSpinner();
			$('[data-vc-grid-item="preview"]').addClass('vc_visible').html('<iframe src="'
			+ window.ajaxurl + '?action=vc_gitem_preview&shortcodes_string='
			+ window.encodeURIComponent(vc.storage.getContent())
			+ '&post_id=' + window.encodeURIComponent($('#post_ID').val())
			+ '"></iframe>');
		}
	};
	vc.visualComposerView.prototype.showPreview = function (e) {
		$('#visual_composer_content').hide();
		$('[data-vc-grid-item="preview"]').addClass('vc_visible');
		if (_.isString(e)) {
			$('[data-vc-grid-item="navbar_preview_width"] select').val(e);
		}
		$('[data-vc-grid-item="navbar_preview_width"]').addClass('vc_visible');
		vc.hideSpinner();
		$('[data-vc-navbar-control="preview"]').text(i18nLocaleGItem.builder);
		this.previewActivated = true;
	};
	vc.visualComposerView.prototype.hidePreview = function () {
		$('#visual_composer_content').show();
		$('[data-vc-grid-item="preview"]').removeClass('vc_visible').html('');
		$('[data-vc-grid-item="navbar_preview_width"]').removeClass('vc_visible');
		this.previewActivated = false;
		$('[data-vc-navbar-control="preview"]').text(i18nLocaleGItem.preview);
	};
	vc.visualComposerView.prototype.setPreviewItemWidth = function (e) {
		var iframeWindow = $('#vc_gitem-preview iframe').get(0).contentWindow;
		if (_.isString(e)) {
			$('[data-vc-grid-item="navbar_preview_width"] select').val(e);
		} else if (e && e.currentTarget) {
			iframeWindow.vcSetItemWidth($(e.currentTarget).val());
		}
	}
	vc.visualComposerView.prototype.openVcGitemEditForm = function (e) {
		e && e.preventDefault();
		var vcGitemModel = vc.shortcodes.findWhere({shortcode: 'vc_gitem'});
		this.previewActivated && this.hidePreview();
		vcGitemModel && vc.edit_element_block_view.render(vcGitemModel);
	};
	vc.visualComposerView.prototype.setSortable = function () {
		// 1st level sorting (rows). work also in wp41.

		// 2st level sorting (elements).
		$('.wpb_column_container').sortable({
			forcePlaceholderSize: true,
			forceHelperSize: false,
			connectWith: ".wpb_column_container",
			placeholder: "vc_placeholder",
			items: "> .wpb_sortable.wpb_content_element", //wpb_sortablee
			helper: this.renderPlaceholder,
			distance: 3,
			scroll: true,
			scrollSensitivity: 70,
			cursor: 'move',
			cursorAt: {top: 20, left: 16},
			tolerance: 'intersect', // this helps with dragging textblock into tabs
			start: function () {
				$('#visual_composer_content').addClass('vc_sorting-started');
				$('.vc_not_inner_content').addClass('dragging_in');
			},
			stop: function (event, ui) {
				$('#visual_composer_content').removeClass('vc_sorting-started');
				$('.dragging_in').removeClass('dragging_in');
				var tag = ui.item.data('element_type'),
					parent_tag = ui.item.parent().closest('[data-element_type]').data('element_type'),
					allowed_container_element = !_.isUndefined(vc.map[parent_tag].allowed_container_element) ? vc.map[parent_tag].allowed_container_element : true;
				if (!vc.check_relevance(parent_tag, tag)) {
					$(this).sortable('cancel');
				}
				if (vc.map[ui.item.data('element_type')].is_container && !(allowed_container_element === true || allowed_container_element === ui.item.data('element_type').replace(/_inner$/, ''))) { // && ui.item.hasClass('wpb_container_block')
					$(this).sortable('cancel');
				}
				$('.vc_sorting-empty-container').removeClass('vc_sorting-empty-container');
			},
			update: this.updateElementsSorting,
			over: function (event, ui) {
				var tag = ui.item.data('element_type'),
					parent_tag = ui.placeholder.closest('[data-element_type]').data('element_type'),
					allowed_container_element = !_.isUndefined(vc.map[parent_tag].allowed_container_element) ? vc.map[parent_tag].allowed_container_element : true;
				if (!vc.check_relevance(parent_tag, tag)) {
					ui.placeholder.addClass('vc_hidden-placeholder');
					return false;
				}
				if (vc.map[ui.item.data('element_type')].is_container && !(allowed_container_element === true || allowed_container_element === ui.item.data('element_type').replace(/_inner$/, ''))) {
					ui.placeholder.addClass('vc_hidden-placeholder');
					return false;
				}
				if (ui.sender && ui.sender.length && !ui.sender.find('[data-element_type]:visible').length) {
					ui.sender.addClass('vc_sorting-empty-container');
				}
				ui.placeholder.removeClass('vc_hidden-placeholder'); // .parent().removeClass('vc_empty-container');
				ui.placeholder.css({maxWidth: ui.placeholder.parent().width()});
			}
		});
		return this;
	};
	vc.visualComposerView.prototype.changeAnimation = function (e) {
		var $dropdown, params, model, prevAnimation;
		model = vc.shortcodes.findWhere({shortcode: 'vc_gitem_animated_block'});
		if (!model) return false;
		$dropdown = $(e.currentTarget);
		params = $.extend({}, model.get('params'));
		params.animation = $dropdown.val();
		model.save({params: params});
		this.previewActivated && this.changePreviewAnimation(params.animation);
	};
	vc.visualComposerView.prototype.changePreviewAnimation = function (animation) {
		var iframeWindow = $('#vc_gitem-preview iframe').get(0).contentWindow;
		iframeWindow && iframeWindow.changeAnimation(animation);
	};
	// @todo optimize this function defer or change sometimes to slow.
	vc.AddElementBlockViewBackendEditor.prototype.createElement = function (e) {
		var model, tag, parent_id = false, cZone, cZoneRow, cZoneCol;
		this.do_render = true;
		_.isObject(e) && e.preventDefault();
		tag = $(e.currentTarget).data('tag');
		if (false !== this.model && 'vc_gitem_add_c_zone' === this.model.get('shortcode')) {
			this.model.view.setCZonePosition(this.model.getParam('position'));
			vc.storage.lock();
			cZone = vc.shortcodes.create({
				shortcode: 'vc_gitem_zone_c',
				parent_id: this.model.get('parent_id'),
				params: _.extend({}, vc.getDefaults('vc_gitem_zone_c')),
				order: this.model.getParam('cZonePosition')
			});
			this.model.view.cZone = cZone;
			vc.storage.lock();
			cZoneRow = vc.shortcodes.create({
				shortcode: 'vc_gitem_row',
				params: _.extend({}, vc.getDefaults('vc_gitem_row')),
				parent_id: cZone.get('id')
			});
			vc.storage.lock();
			cZoneCol = vc.shortcodes.create({
				shortcode: 'vc_gitem_col',
				params: _.extend({width: '1/1'}, vc.getDefaults('vc_gitem_col')),
				parent_id: cZoneRow.get('id')
			});
			parent_id = cZoneCol.get('id');
			cZone = null;
			cZoneCol = null;
		} else if (false !== this.model) {
			parent_id = this.model.get('id');
		}
		model = vc.shortcodes.create({
			shortcode: tag,
			parent_id: parent_id,
			params: vc.getDefaults(tag),
			root_id: vc.shortcodes.findWhere({shortcode: 'vc_gitem'}) || false
		});
		if (tag === 'vc_gitem_row') {
			vc.shortcodes.create({
				shortcode: 'vc_gitem_col',
				params: {width: '1/1'},
				parent_id: model.get('id'),
				root_id: model.get('id')
			});
		}
		this.show_settings = _.isBoolean(vc.getMapped(tag).show_settings_on_create) && vc.getMapped(tag).show_settings_on_create === false ? false : true;
		this.model = model;
		this.$el.modal('hide');
	};
	vc.EditElementPanelView.prototype.ajaxData = function () {
		return {
			action: 'vc_edit_form',
			vc_grid_item_editor: 'true',
			tag: this.model.get('shortcode'),
			post_id: $('#post_ID').val(),
			params: this.model.get('params')
		};
	};
	window.VcGitemView = window.VcColumnView.extend({
		animatedBlock: false,
		cZone: false,
		events: {
			'click > .vc_controls [data-vc-control="delete"]': 'deleteShortcode',
			'click > .vc_controls [data-vc-control="add"]': 'addElement',
			'click > .vc_controls [data-vc-control="edit"]': 'editElement',
			'click > .vc_controls [data-vc-control="clone"]': 'clone',
			'click [data-vc-gitem="add-c"]': 'addCZone',
			'click > .vc_empty [data-vc-gitem="add-ab"]': 'addAnimatedBlock'
		},
		initialize: function (options) {
			window.VcColumnView.__super__.initialize.call(this, options);
			vc.shortcodes.on('all', this.setCZoneHeight);
		},
		setContent: function () {
			this.$content = this.$el.find('> .vc_gitem-content');
			_.bindAll(this, 'savePositionC', 'startCDragging', 'stopCDragging');
		},
		setCEmpty: function () {
			this.$content.addClass('vc_empty-c');
		},
		unsetCEmpty: function () {
			this.$content.removeClass('vc_empty-c');
		},
		setEmpty: function () {
			this.$content.addClass('vc_empty');
		},
		unsetEmpty: function () {
			this.$content.removeClass('vc_empty');
		},
		checkIsEmpty: function () {
			// Check for C zone
			if (vc.shortcodes.where({parent_id: this.model.id, shortcode: 'vc_gitem_zone_c'}).length) {
				this.unsetCEmpty();
			} else {
				this.setCEmpty();
			}
			// Check for Animated block
			if (vc.shortcodes.where({parent_id: this.model.if, shortcode: 'vc_gitem_animated_block'}).length) {
				this.unsetEmpty();
			} else {
				this.setEmpty();
			}
			window.VcColumnView.__super__.checkIsEmpty.call(this);
		},
		addAnimatedBlock: function (e) {
			var animatedBlock;
			e && e.preventDefault();
			if (this.animatedBlock) return;
			vc.storage.lock();
			animatedBlock = vc.shortcodes.create({
				shortcode: 'vc_gitem_animated_block',
				parent_id: this.model.get('id'),
				order: 1,
				params: vc.getDefaults('vc_gitem_animated_block'),
				root_id: this.model.get('id')
			});
			vc.storage.lock();
			animatedBlock.view.addZone('a');
			animatedBlock.view.addZone('b');
		},
		addCZone: function (e) {
			var $column = $(e.currentTarget),
				position = $column.data('vcPosition'), model
			if (this.cZone) {
				this.updateCZonePosition($column, position);
				return false;
			}
			model = new vc.shortcode({
				shortcode: 'vc_gitem_add_c_zone',
				params: {
					cZonePosition: this.getCZoneModelOrder(position),
					position: position
				},
				parent_id: this.model.get('id')
			});
			model.view = this;
			vc.add_element_block_view.render(model);
		},
		updateCZonePosition: function ($column, position) {
			this.setCZonePosition(position);
			this.setCZoneOrder(position);
			this.changeCZonePosition($column);
			this.setCssPosition($column);
		},
		setCZoneOrder: function (position) {
			this.cZone.save({order: this.getCZoneModelOrder(position)});
		},
		changeCZonePosition: function ($column) {
			this.cZone.view.$el.appendTo($column);
		},
		setCZonePosition: function (position) {
			this.model.save({
				params: _.extend({}, this.model.get('params') || {}, {
					c_zone_position: position
				})
			});
		},
		setCZoneHeight: function () {
			var $left = $('[data-vc-gitem="add-c"][data-vc-position="left"]'),
				$animated = $('[data-element_type="vc_gitem_animated_block"]'),
				$right = $('[data-vc-gitem="add-c"][data-vc-position="right"]'),
				max_height;
			$left.height('auto');
			$right.height('auto');
			max_height = Math.max($left.height(), $animated.height(), $right.height());
			$left.css('height', max_height);
			$right.css('height', max_height);
		},
		getCZoneModelOrder: function (position) {
			var animatedBlockOrder = this.animatedBlock.get('order');
			return position === 'top' || position === 'left' ? animatedBlockOrder - 1 : animatedBlockOrder + 1
		},
		cZoneRemoved: function () {
			this.cZone = false;
			this.$content.find('.vc_zone-added').removeClass('vc_zone-added');
			this.setCZonePosition('');
		},
		setDraggableC: function () {
			this.$content.find('[data-vc-gitem="add-c"]').sortable({
				items: '[data-element_type="vc_gitem_zone_c"]',
				connectWith: '[data-vc-gitem="add-c"]',
				forcePlaceholderSize: true,
				forceHelperSize: false,
				placeholder: 'vc_placeholder',
				update: this.savePositionC,
				start: this.startCDragging,
				stop: this.stopCDragging
			}).disableSelection();
		},
		startCDragging: function (event, ui) {
			this.$el.addClass('vc_sorting');
		},
		stopCDragging: function (event, ui) {
			this.$el.removeClass('vc_sorting');
		},
		savePositionC: function (event, ui) {
			var cBlockContainer = ui.item.parent(),
				position = cBlockContainer.data('vcPosition') || 'bottom';
			vc.storage.lock();
			this.cZone && this.cZone.save({
				order: this.getCZoneModelOrder(position)
			});
			this.setCZonePosition(position);
			this.setCssPosition(cBlockContainer);
		},
		setCssPosition: function ($container) {
			this.$content
				.find('[data-vc-gitem="add-c"].vc_zone-added')
				.removeClass('vc_zone-added');
			$container.addClass('vc_zone-added');
		},
		addShortcode: function (view) {
			var tag = view.model.get('shortcode'),
				position, $zone;
			view.render();
			if (tag === 'vc_gitem_zone_c') {
				position = this.model.getParam('c_zone_position') || 'bottom';
				$zone = this.$content.find('[data-vc-gitem="add-c"][data-vc-position="' + position + '"]');
				view.$el.appendTo($zone.addClass('vc_zone-added'));
				this.setDraggableC();
				this.cZone = view.model;
			} else if (tag === 'vc_gitem_animated_block') {
				view.$el.appendTo($('[data-vc-gitem="add-ab"]'));
				this.animatedBlock = view.model;
			}
		}
	});
	window.VcGitemAnimatedBlockView = window.VcColumnView.extend({
		aZone: false,
		bZone: false,
		currentAnimation: '',
		events: {
			'click > .vc_controls [data-vc-control="delete"]': 'deleteShortcode',
			'click > .vc_controls [data-vc-control="add"]': 'addElement',
			'click > .vc_controls [data-vc-control="edit"]': 'editElement',
			'click > .vc_controls [data-vc-control="clone"]': 'clone',
			'click > .vc_empty-a [data-vc-gitem-animated-block="add-a"]': 'addAZone',
			'click > .vc_empty-b [data-vc-gitem-animated-block="add-b"]': 'addBZone',
			'click > .vc_gitem-animated-block-content [data-vc-gitem-tab-link]': 'activateZone',
			'click > .vc_gitem-animated-block-content [data-vc-control="edit"]': 'showEditForm'
		},
		render: function () {
			var animation;
			window.VcGitemAnimatedBlockView.__super__.render.call(this);
			animation = this.model.getParam('animation');
			if (animation) {
				$('[data-vc-navbar-control="animation"]').val(animation);
			}
			return this;
		},
		setContent: function () {
			this.$content = this.$el.find('> .vc_gitem-animated-block-content');
		},
		buildDesignHelpers: function () {
			window.VcGitemAnimatedBlockView.__super__.buildDesignHelpers.call(this);
			this.setAnimationDropDown();
			this.setAnimationClassToBlock();
		},
		changeShortcodeParams: function (model) {
			window.VcGitemAnimatedBlockView.__super__.changeShortcodeParams.call(this, model);
		},
		setAnimationClassToBlock: function () {
			var animation = this.model.getParam('animation') || 'single';
			if (this.currentAnimation) {
				this.$el.removeClass('vc_gitem-animation-' + this.currentAnimation);
			}
			this.$el.addClass('vc_gitem-animation vc_gitem-animation-' + animation);
			this.currentAnimation = animation;
		},
		setAnimationDropDown: function () {
			var animation = this.model.getParam('animation');
			if (animation) {
				$('[data-vc-gitem-animated-block="animation-dropdown"]').val(animation);
			}
			if ('' === animation) {
				this.activateZone({currentTarget: $('.vc_gitem-tab-a').get(0)})
			}
		},
		addAZone: function (e) {
			e && e.preventDefault();
			this.addZone('a');
		},
		addBZone: function (e) {
			e && e.preventDefault();
			this.addZone('b');
		},
		addZone: function (zone) {
			if (this[zone + 'Zone']) return;
			vc.shortcodes.create({
				shortcode: 'vc_gitem_zone_' + zone,
				parent_id: this.model.get('id'),
				params: vc.getDefaults('vc_gitem_zone_' + zone)
			});
		},
		addTab: function (zone, id) {
			var $zone = $('<li class="vc_gitem-animated-block-tab vc_gitem-tab-'
			+ zone + '"><a href="#" data-vc-gitem-tab-link="' + zone + '"><span class="vc_label">' + this.getZoneLabel(zone)
			+ '</span></a><a class="vc_control column_edit" data-vc-control="edit" data-vc-zone-model-id="' + id + '"><span class="vc_icon"></span></a></li>');
			$zone.appendTo('[data-vc-gitem-animated-block="tabs"]');
			zone === 'a' && this.switchZone($zone.find('a'));
		},
		getZoneLabel: function (zone) {
			var zoneSettings = vc.map['vc_gitem_zone_' + zone] ? vc.map['vc_gitem_zone_' + zone] : false;
			return zoneSettings && zoneSettings.name ? zoneSettings.name : zone;
		},
		activateZone: function (e) {
			var $control = $(e.currentTarget);
			e && e.preventDefault && e.preventDefault();
			!$control.hasClass('vc_active') && this.switchZone($control);
		},
		showEditForm: function (e) {
			var model_id;
			e && e.preventDefault();
			model_id = $(e.currentTarget).data('vcZoneModelId');
			model_id && vc.app.views[model_id] && vc.app.views[model_id].editElement();
		},
		switchZone: function ($zone) {
			this.$el.find('[data-vc-gitem-animated-block="tabs"] .vc_active, [data-vc-gitem-animated-block].vc_active')
				.removeClass('vc_active');
			$zone.parent().addClass('vc_active');
			this.$el.find('[data-vc-gitem-animated-block="add-' + $zone.data('vcGitemTabLink') + '"]')
				.addClass('vc_active');
		},
		setAEmpty: function () {
			this.$content.addClass('vc_empty-a');
		},
		unsetAEmpty: function () {
			this.$content.removeClass('vc_empty-a');
		},
		setBEmpty: function () {
			this.$content.addClass('vc_empty-b');
		},
		unsetBEmpty: function () {
			this.$content.removeClass('vc_empty-b');
		},
		setEmpty: function () {
			this.setAEmpty();
			this.setBEmpty();
		},
		checkIsEmpty: function () {
			// Check for A zone
			if (vc.shortcodes.where({parent_id: this.model.get('id'), shortcode: 'vc_gitem_zone_a'}).length) {
				this.unsetAEmpty();
			} else {
				this.setAEmpty();
			}
			// Check for B zone
			if (vc.shortcodes.where({parent_id: this.model.get('id'), shortcode: 'vc_gitem_zone_b'}).length) {
				this.unsetBEmpty();
			} else {
				this.setBEmpty();
			}
		},
		addShortcode: function (view) {
			var tag = view.model.get('shortcode');
			view.render();
			if (tag === 'vc_gitem_zone_a') {
				view.$el.appendTo(this.$el.find('[data-vc-gitem-animated-block="add-a"]'));
				this.aZone = view.model;
				this.addTab('a', view.model.get('id'));
			} else if (tag === 'vc_gitem_zone_b') {
				view.$el.appendTo(this.$el.find('[data-vc-gitem-animated-block="add-b"]'));
				this.bZone = view.model;
				this.addTab('b', view.model.get('id'));
			}
		}
	});
	window.VcGitemZoneView = window.VcColumnView.extend({
		addElement: function (e) {
			var row;
			e && e.preventDefault();
			vc.storage.lock();
			row = vc.shortcodes.create({
				shortcode: 'vc_gitem_row',
				params: _.extend({}, vc.getDefaults('vc_gitem_row')),
				parent_id: this.model.get('id')
			});
			vc.shortcodes.create({
				shortcode: 'vc_gitem_col',
				params: _.extend({width: '1/1'}, vc.getDefaults('vc_gitem_col')),
				parent_id: row.get('id')
			});
		},
		buildDesignHelpers: function () {
			var featuredImage, css = this.model.getParam('css'),
				$before = this.$el.find('> .vc_controls').get(0),
				image, color;
			featuredImage = this.model.getParam('featured_image');
			this.$el.find('> [data-vc-helper="color"]').remove();
			this.$el.find('> [data-vc-helper="image"]').remove();
			this.$el.find('> [data-vc-helper="image-featured"]').remove();
			var matches = css.match(/background\-image:\s*url\(([^\)]+)\)/)
			if (matches && !_.isUndefined(matches[1])) {
				image = matches[1];
			}
			var matches = css.match(/background\-color:\s*([^\s\;]+)\b/)
			if (matches && !_.isUndefined(matches[1])) {
				color = matches[1];
			}
			var matches = css.match(/background:\s*([^\s]+)\b\s*url\(([^\)]+)\)/)
			if (matches && !_.isUndefined(matches[1])) {
				color = matches[1];
				image = matches[2];
			}
			if (image) {
				$('<span class="vc_css-helper vc_image-helper" data-vc-helper="image" style="background-image: url(' + image + ');" title="'
				+ i18nLocale.column_background_image + '"></span>')
					.insertBefore($before);
			}
			if (color) {
				$('<span class="vc_css-helper vc_color-helper" data-vc-helper="color" style="background-color: ' + color + '" title="'
				+ i18nLocale.column_background_color + '"></span>')
					.insertBefore($before);
			}
			if ('yes' === featuredImage) {
				$('<span class="vc_css-helper vc_featured" data-vc-helper="image-featured"></span>')
					.insertBefore($before);
			}
		}
	});
	window.VcGitemZoneCView = window.VcGitemZoneView.extend({
		removeView: function () {
			window.VcGitemZoneCView.__super__.removeView.call(this);
			var parentModel = vc.shortcodes.get(this.model.get('parent_id'));
			if (parentModel && vc.app.views[parentModel.get('id')]) {
				vc.app.views[parentModel.get('id')].cZoneRemoved();
			}
		}
	});
	window.VcGitemRowView = window.VcRowView.extend({
		zone: '',
		getChildTag: function () {
			return 'vc_gitem_col';
		},
		addElement: function (e) {
			e && e.preventDefault();
			vc.shortcodes.create({shortcode: this.getChildTag(), params: {}, parent_id: this.model.id});
			this.setActiveLayoutButton();
		},
		buildDesignHelpers: function () {
			/*
			 window.VcGitemRowView.__super__.buildDesignHelpers.call(this);
			 var $column_move = this.$el.find('> .controls .column_move'),
			 zone = this.model.getParam('zone');
			 if (this.zone != zone) {
			 this.$el.find('> .controls .vc_row-zone').remove();
			 $('<span class="vc_control vc_row-zone">' + zone.toUpperCase() + '</span>')
			 .insertAfter($column_move);
			 !_.isEmpty(this.zone) && this.$el.removeClass('vc_gitem-zone-' + this.zone);
			 this.zone = zone;
			 this.$el.removeClass('wpb_sortable').addClass(' vc_gitem-zone-' + this.zone);
			 }
			 */
		}
	});
	window.VcGitemColView = window.VcColumnView.extend({
		events: {
			'click > .vc_controls [data-vc-control="delete"]': 'deleteShortcode',
			'click > .vc_controls [data-vc-control="add"]': 'addElement',
			'click > .vc_controls [data-vc-control="edit"]': 'editElement',
			'click > .vc_controls [data-vc-control="clone"]': 'clone',
			'click > .vc_controls [data-vc-align]': 'changeTextAlign',
			'click > .wpb_element_wrapper > .vc_empty-container': 'addToEmpty'
		},
		designHelpersSelector: '> .vc_controls .column_edit',
		changeTextAlign: function (e) {
			var $control;
			if (e) {
				e.preventDefault();
				$control = $(e.currentTarget);
				// Set controls settings
				if ($control.hasClass('vc_active')) return false;
				$control.parent().find('.vc_active').removeClass('vc_active');
				$control.addClass('vc_active');
				// Change param align.
				_.defer(this.setTextAlign, ($control.data('vcAlign') || 'left'));
			} else {
				this.$el.find('> .vc_controls [data-vc-align="'
				+ (this.model.getParam('align') || 'left') + '"]')
					.addClass('vc_active');
			}
		},
		setTextAlign: function (align) {
			var params = _.extend({}, this.model.get('params'), {align: align});
			this.model.save({params: params});
		},
		render: function () {
			_.bindAll(this, 'setTextAlign');
			window.VcGitemColView.__super__.render.call(this);
			this.changeTextAlign(undefined);
			return this;
		}
	});

	vc.TemplatesPanelViewBackend.prototype.renderTemplate = function (html) {
		// Render template for backend
		_.each(vc.filters.templates, function (callback) {
			html = callback(html);
		});
		vc.storage.setContent(html);
		vc.shortcodes.fetch({reset: true});
		this.hide();
		// todo show message
	};
	// Show on one column
	$(document).ready(function () {
		$('[name="screen_columns"][value="1"]').trigger('click');
		$('#screen-meta-links, #screen-meta').hide();
	});

})(window.jQuery);