/* =========================================================
 * vc_grid_style_lazy.js v1.0
 * =========================================================
 * Copyright 2014 Wpbakery
 *
 * Basic Grid Style lazy loading
 * ========================================================= */

var vcGridStyleLazy = null;
(function ($) {
	$.waypoints('extendFn', 'vc_grid-infinite', function(options) {
		var $container, opts;
		var el = this;
		opts = $.extend(
			{},
			$.fn.waypoint.defaults,
			{
				container: 'auto',
				items: '.infinite-item',
				offset: 'bottom-in-view',
				handle: {
					load: function( opts ) { }
				}
			},
			options);
		$container = opts.container === 'auto' ? el : $(opts.container,el);
		opts.handler = function(direction) {
			var $this;
			if (direction === 'down' || direction === 'right') {
				$this = $(this);
				$this.waypoint('destroy');
				opts.handle.load.call(this, opts);
			}
		};
		return this.waypoint(opts);
	});
	/**
	 * "Lazy loading" grid style.
	 * ==============================
	 *
	 * @param grid
	 * @constructor
	 */
	vcGridStyleLazy = function (grid) {
		this.grid = grid;
		this.settings = grid.settings;
		this.$el = false;
		this.filterValue = null;
		this.$content = false;
		this.isLoading = false;
		this.$loader = $('<div class="vc_grid-loading"></div>');
		this.init();
	};

	/**
	 * Initialize
	 */
	vcGridStyleLazy.prototype.setIsLoading = function () {
		this.$content.append(this.$loader);
		this.isLoading = true;
	};

	vcGridStyleLazy.prototype.unsetIsLoading = function () {
		this.isLoading = false;
		this.$loader && this.$loader.remove();
	};
	vcGridStyleLazy.prototype.init = function () {
		_.bindAll(this
			, 'addItems'
			, 'showItems'
		);
	};

	/**
	 * Build required content and data.
	 */
	vcGridStyleLazy.prototype.render = function () {
		this.$el = this.grid.$el;
		this.$content = this.$el;
		this.setIsLoading();
		this.grid.ajax({}, this.addItems);
	};

	vcGridStyleLazy.prototype.showItems = function () {
		var $els = this.$content.find('.vc_grid_filter-item:not(.vc_visible-item):lt('+this.settings.items_per_page+')');
		this.setIsLoading();
		$els.addClass('vc_visible-item ' + vcGridSettings.addItemsAnimation + ' animated');
		this.unsetIsLoading();
	};

	/**
	 * Filter function called by grid object ot filter content.
	 *
	 * @param filter - string parameter with filter settings.
	 */
	vcGridStyleLazy.prototype.filter = function (filter) {
		filter = _.isUndefined(filter) || filter === '*' ? '' : filter;
		if( this.filterValue == filter ) {
			return false; // already filtered
		}
		this.$content.find('.vc_visible-item, .vc_grid_filter-item').removeClass('vc_visible-item vc_grid_filter-item '
			+ ( vcGridSettings.addItemsAnimation != 'none' ? vcGridSettings.addItemsAnimation + ' animated' : '') );
		this.filterValue =  filter;
		this.$content
			.find('.vc_grid-item' + this.filterValue)
			.addClass('vc_grid_filter-item');
		_.defer(this.showItems); // for animation
		this.initScroll();
	};

	/**
	 * Add new grid elements to content block. This request is sent after load more btn click.
	 * @param html
	 */
	vcGridStyleLazy.prototype.addItems = function (html) {
		var els = $(html);
		this.$el.append(els);
		this.unsetIsLoading();
		this.$content = els.find('[data-vc-grid-content="true"]');
		this.grid.initFilter();
		this.filter();
		window.vc_prettyPhoto();
	};

	vcGridStyleLazy.prototype.initScroll = function () {
		var self = this;
		this.$content.unbind('waypoint').waypoint('vc_grid-infinite', {
			container: 'auto',
			items: '.vc_grid-item',
			handle: {
				load: function( opts ) {
					self.showItems();
					self.checkNext( opts );
				}
			}
		});
	};
	vcGridStyleLazy.prototype.checkNext = function ( opts ) {
		if (this.$content.find('.vc_grid_filter-item:not(".vc_visible-item")').length) {
			var fn, self = this;
			fn = function() {
				return self.$content.waypoint(opts);
			};
			_.defer(fn);
		}
	};
})(window.jQuery);