/* =========================================================
 * vc_grid.js v1.0
 * =========================================================
 * Copyright 2014 Wpbakery
 *
 * Vc Grid
 * ========================================================= */
var VcGrid, vcGridSettings = {
	addItemsAnimation: 'zoomIn',
	mobileWindowWidth: 768,
	itemAnimationSpeed: 1000,
	itemAnimationDelay: [],
	clearAnimationDelays: function() {
		_.each(this.itemAnimationDelay, function(id){
			window.clearTimeout(id);
		});
		this.itemAnimationDelay = [];
	}
};
(function ($) {
	'use strict';
	VcGrid = function (el) {
		this.$el = $(el);
		this.settings = {};
		this.$filter = false;
		this.gridBuilder = false;
		this.init();
	};
	/**
	 * Initialize
	 */
	VcGrid.prototype.init = function () {
		_.bindAll(
			this,
			'filterItems',
			'filterItemsDropdown'
		);
		this.setSettings();
		this.initStyle();
		// this.initFilter();
		this.initHover();
		this.initZoneLink();
	};
	VcGrid.prototype.setSettings = function() {
		this.settings =$.extend({
			visible_pages:5
		},this.$el.data('vcGridSettings') || {}); // Setttings with grid settings for layout.
	};
	/**
	 * Init style object to interact with content of grid.
	 */
	VcGrid.prototype.initStyle = function () {
		var styleObject = this.settings.style ? $.camelCase('vc-grid-style-' + this.settings.style) : false;
		if (styleObject && !_.isUndefined(window[styleObject]) && window[styleObject].prototype.render) {
			this.gridBuilder = new window[styleObject](this);
			this.gridBuilder.render();
		}
	};
	/**
	 * Build filters with a stack of the style grid object.
	 */
	VcGrid.prototype.initFilter = function () {
		this.$filter = this.$el.find('[data-vc-grid-filter]');
		this.$filterDropdown = this.$el.find('[data-vc-grid-filter-select]');
		this.$filter.length && this.$filter
			.find('.vc_grid-filter-item')
			.unbind('click')
			.click(this.filterItems);
		this.$filterDropdown.length && this.$filterDropdown
			.unbind('change')
			.change(this.filterItemsDropdown);
	};
	/**
	 * Set hover css class for animation.
	 *
	 */
	VcGrid.prototype.initHover = function() {
		this.$el
			.on('mouseover', '.vc_grid-item-mini', function(){
				var $this = $(this);
				$this.addClass('vc_is-hover');
				/*
				$this.find('[data-vc-animation]').each(function(){
					var animation = $(this).data('vcAnimation'),
						animationObject = 'VcGridAnimation' + animation;
					window[animationObject] && window[animationObject](this, 'in');
				});
				*/
			}).on('mouseleave', '.vc_grid-item-mini', function(){
				var $this = $(this);
				$this.removeClass('vc_is-hover');
				/*
				$this.find('[data-vc-animation]').each(function(){
					var animation = $(this).data('vcAnimation'),
						animationObject = 'VcGridAnimation' + animation;
					window[animationObject] && window[animationObject](this, 'out');
				});
				*/
			});
	};
	VcGrid.prototype.initZoneLink = function() {
		if(parent && parent.vc && parent.vc.loaded) {
			this.$el.on('click.zonePostLink', '[data-vc-link]', function(){
				var $this = $(this),
					href = $(this).data('vcLink');
				window.open(href);
			});
			this.$el.on('click', '.vc_gitem-link', function(e){
				e.preventDefault();
				window.open($(this).attr('href'));
			});
		} else {
			this.$el.on('click.zonePostLink', '[data-vc-link]', function(){
				var $this = $(this),
					href = $(this).data('vcLink');
				if('_blank' === $this.data('vcTarget')) {
					window.open(href);
				} else {
					window.location.href = href;
				}
			});
		}
	};
	VcGrid.prototype.initHover_old = function () {
		this.$el
			.on('mouseover', '.vc_grid-item', function(){
				var $this = $(this);
				if( $this.hasClass('vc_is-hover') ) return;
				vcGridSettings.clearAnimationDelays();
				$this.addClass('vc_is-hover vc_is-animated');
				$this.find('.vc_grid-item-row-animate').each(function(){
					var $animate = $(this),
						animationIn = $animate.data('animationIn'),
						animationOut = $animate.data('animationOut');
					$animate.removeClass(animationOut).addClass(animationIn);
					vcGridSettings.itemAnimationDelay.push(_.delay(function(){
						$animate.removeClass(animationIn);
						$this.removeClass('vc_is-animated');
					}, vcGridSettings.itemAnimationSpeed));
				});
			}).on('mouseleave', '.vc_grid-item', function(){
				var $this = $(this);
				vcGridSettings.clearAnimationDelays();
				$this.addClass('vc_is-animated').removeClass('vc_is-hover');
				$this.find('.vc_grid-item-row-animate').each(function(){
					var $animate = $this.find('.vc_grid-item-row-animate'),
						animationOut = $animate.data('animationOut'),
						animationIn = $animate.data('animationIn');
						$animate.addClass(animationOut);
					vcGridSettings.itemAnimationDelay.push(_.delay(function(){
							$animate.removeClass(animationOut + ' ' + animationIn);
							$this.removeClass('vc_is-animated');
						}, vcGridSettings.itemAnimationSpeed-1));
				});
			});
	};
	/**
	 * Filter items in the grid. Called as a result of manipulations with filter UI components.
	 * @param e
	 * @return {Boolean}
	 */
	VcGrid.prototype.filterItems = function (e) {
		var filter_method = this.style ? $.camelCase('filter-' + this.style) : 'filterAll',
			$control = $(e.currentTarget).find('[data-vc-grid-filter-value]'),
			filter = $control.data('vcGridFilterValue');
		e && e.preventDefault();
		if ($control.hasClass('vc_active')) return false;
		this.$filter.find('.vc_active').removeClass('vc_active');
		this.$filterDropdown.find('.vc_active').removeClass('vc_active');
		this.$filterDropdown.find('[value="'+filter+'"]').addClass('vc_active').attr('selected','selected');
		$control.parent().addClass('vc_active');
		this.gridBuilder.filter(filter);
	};
	/**
	 * Filter items in the grid. Called as a result of manipulations with filter UI components.
	 * @param e
	 * @return {Boolean}
	 */
	VcGrid.prototype.filterItemsDropdown = function (e) {
		var $control = this.$filterDropdown.find(':selected'),
			filter = $control.val();
		if ($control.hasClass('vc_active')) return false;
		this.$filterDropdown.find('.vc_active').removeClass('vc_active');
		this.$filter.find('.vc_active').removeClass('vc_active');
		this.$filter.find('[data-vc-grid-filter-value="'+filter+'"]').parent().addClass('vc_active');

		$control.addClass('vc_active');
		this.gridBuilder.filter(filter);
	};
	/**
	 * Ajax request to load into Grid.
	 *
	 * @param data
	 * @param callback
	 */
	VcGrid.prototype.ajax = function (data, callback) {
		var requestData;
		if (_.isUndefined(data)) data = {};
		requestData = _.extend({
			action:'vc_get_vc_grid_data',
			vc_action:'vc_get_vc_grid_data',
			tag: this.settings.tag,
			data:this.settings,
			vc_post_id: this.$el.data('vcPostId')
		}, data);

		$.ajax({
			type:'POST',
			dataType:'html',
			url: this.$el.data('vcRequest'),
			data:requestData
		}).done(callback);
	};
	// PLUGIN DEFINITION
	// =====================
	function Plugin(option) {
		return this.each(function () {
			var $this = $(this);
			var data = $this.data('vcGrid');
			if (!data) $this.data('vcGrid', (data = new VcGrid(this)));
			if (typeof option == 'string') data[option]();
		});
	}

	$.fn.vcGrid = Plugin;
	$.fn.vcGrid.Constructor = VcGrid;
	$(document).ready(function(){
		$('[data-vc-grid-settings]').vcGrid();
	});
})(window.jQuery);