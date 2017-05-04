/* =========================================================
 * vc_grid_style_lazy_masonry.js v1.0
 * =========================================================
 * Copyright 2014 Wpbakery
 *
 * Basic Grid Style show all
 * ========================================================= */
var vcGridStyleLoadMoreMasonry;
(function ($) {
	// vcGridStyleAllMasonry = vcGridStyleAll.bind(); // IE 8 not supported
	vcGridStyleLoadMoreMasonry = function (grid) {
		this.grid = grid;
		this.settings = grid.settings;
		this.$loadMoreBtn = false;
		this.$el = false;
		this.filterValue = null;
		this.$content = false;
		this.isLoading = false;
		this.filtered = false;
		this.$loader = $('<div class="vc_grid-loading"></div>');
		this.masonryEnabled = false;
		_.bindAll(this, 'setMasonry');
		this.init();
	};
	vcGridStyleLoadMoreMasonry.prototype = _.extend({}, vcGridStyleLoadMore.prototype, {
		showItems: function () {
			if (this.isLoading === true) return false;
			this.setIsLoading();
			var $els = this.$content.find('.vc_grid_filter-item:not(.vc_visible-item):lt('+this.settings.items_per_page+')');
			var self = this;
			$els.imagesLoaded(function(){
				$els.addClass('vc_visible-item');
				self.setItems($els);
				if(self.filtered) {
					self.filtered = false;
					self.setMasonry();
					window.vc_prettyPhoto();
				}
				self.unsetIsLoading();
			});
		},
		filter: function(filter) {
			filter = _.isUndefined(filter) || filter === '*' ? '' : filter;
			if( this.filterValue == filter ) {
				return false; // already filtred
			}
			this.$content.data('masonry') && this.$content.masonry('destroy');
			this.masonryEnabled = false;
			this.$content.find('.vc_visible-item, .vc_grid_filter-item').removeClass('vc_visible-item vc_grid_filter-item '
				+ ( vcGridSettings.addItemsAnimation != 'none' ? vcGridSettings.addItemsAnimation + ' animated' : '') );
			this.filterValue =  filter;
			this.$content
				.find('.vc_grid-item' + this.filterValue)
				.addClass('vc_grid_filter-item');
			this.filtered = true;
			$(window).resize(this.setMasonry);
			this.setMasonry();
			this.showItems();
		},
		setIsLoading: function () {
			this.$el.append(this.$loader);
			this.$loadMoreBtn && this.$loadMoreBtn.hide();
			this.isLoading = true;
		},
		unsetIsLoading: function () {
			this.isLoading = false;
			this.$loader && this.$loader.remove();
			this.setLoadMoreBtn();
		},
		setItems: function(els) {
			if( this.masonryEnabled ) {
				this.$content.masonry('appended',els);
			} else {
				this.setMasonry();
			}
		},
		setMasonry: function() {
			var windowWidth = window.innerWidth;
			if(windowWidth < vcGridSettings.mobileWindowWidth) {
				this.$content.data('masonry') && this.$content.masonry('destroy');
				this.masonryEnabled = false;
			} else if(this.masonryEnabled) {
				this.$content.masonry('reloadItems');
				this.$content.masonry('layout');
			} else {
				this.$content.masonry({itemSelector: ".vc_visible-item", isResizeBound: false});
				this.masonryEnabled = true;
			}
		}
	});


})(window.jQuery);