/* =========================================================
 * vc_grid_style_all.js v1.0
 * =========================================================
 * Copyright 2014 Wpbakery
 *
 * Basic Grid Style show all
 * ========================================================= */
var vcGridStyleAll;
(function ($) {
	/**
	 * "Show all items" grid style.
	 * ==============================
	 *
	 * @param grid
	 * @constructor
	 */
	vcGridStyleAll = function (grid) {
		this.grid = grid;
		this.settings = grid.settings;
		this.filterValue = null;
		this.$el = false;
		this.$content = false;
		this.isLoading = false;
		this.$loader = $('<div class="vc_grid-loading"></div>');
		this.init();
	};
	/**
	 * Initialize
	 */
	vcGridStyleAll.prototype.init = function () {
		_.bindAll(this
			, 'addItems'
			, 'showItems'
		);
	};
	/**
	 * Build required content and data.
	 */
	vcGridStyleAll.prototype.render = function () {
		this.$el = this.grid.$el;
		this.$content = this.$el;
		this.setIsLoading();
		this.grid.ajax({}, this.addItems);
	};
	vcGridStyleAll.prototype.setIsLoading = function () {
		this.$content.append(this.$loader);
		this.isLoading = true;
	};

	vcGridStyleAll.prototype.unsetIsLoading = function () {
		this.isLoading = false;
		this.$loader && this.$loader.remove();
	};
	/**
	 * Filter function called by grid object ot filter content.
	 *
	 * @param filter - string parameter with filter settings.
	 */
	vcGridStyleAll.prototype.filter = function (filter) {
		filter = _.isUndefined(filter) || filter === '*' ? '' : filter;
		if( this.filterValue == filter ) {
			return false; // already filtred
		}
		this.$content
			.find('.vc_visible-item')
			.removeClass('vc_visible-item ' + vcGridSettings.addItemsAnimation + ' animated');
		this.filterValue =  filter;
		_.defer(this.showItems); // just only for animation
	};
	vcGridStyleAll.prototype.showItems = function() {
		var $els = this.$content.find('.vc_grid-item' + this.filterValue);
		this.setIsLoading();
		$els.addClass('vc_visible-item ' + (
			vcGridSettings.addItemsAnimation != 'none' ? vcGridSettings.addItemsAnimation + ' animated' : '') );
		this.unsetIsLoading();
	};
	/**
	 * Add new grid elements to content block. Called by ajax in render method.
	 * @param html
	 */
	vcGridStyleAll.prototype.addItems = function (html) {
		this.unsetIsLoading();
		$(html).appendTo(this.$el);
		this.$content = this.$el.find('[data-vc-grid-content="true"]');
		this.grid.initFilter();
		this.filter();
		window.vc_prettyPhoto();
		return false;
	};
})(window.jQuery);