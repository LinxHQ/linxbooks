/* =========================================================
 * vc_grid_style_all_masonry.js v1.0
 * =========================================================
 * Copyright 2014 Wpbakery
 *
 * Basic Grid Style show all with masonry grid
 * ========================================================= */
var vcGridStyleAllMasonry;
(function ($) {
	// vcGridStyleAllMasonry = vcGridStyleAll.bind(); // IE 8 not supported
	vcGridStyleAllMasonry = function (grid) {
		this.grid = grid;
		this.settings = grid.settings;
		this.filterValue = null;
		this.$el = false;
		this.$content = false;
		this.isLoading = false;
		this.filtered = false;
		this.$loader = $('<div class="vc_grid-loading"></div>');
		this.masonryEnabled = false;
		_.bindAll(this, 'setMasonry');
		this.init();
	};
	vcGridStyleAllMasonry.prototype = _.extend({}, vcGridStyleAll.prototype, {
		showItems: function() {
			var $els = this.$content.find('.vc_grid-item' + this.filterValue);
			var self = this;
			this.setIsLoading();
			$els.imagesLoaded(function(){
				$els.addClass('vc_visible-item');
				self.setItems($els);
				if(self.filtered) {
					self.filtered = false;
					self.setMasonry();
				}
				self.unsetIsLoading();
				window.vc_prettyPhoto();
			});
		},
		filter: function(filter) {
			filter = _.isUndefined(filter) || filter === '*' ? '' : filter;
			if( this.filterValue == filter ) {
				return false; // already filtred
			}
			this.filterValue =  filter;
			this.$content.data('masonry') && this.$content.masonry('destroy');
			this.masonryEnabled = false;
			this.$content
				.find('.vc_visible-item')
				.removeClass('vc_visible-item');
			this.$content
				.find('.vc_grid-item' + this.filterValue);
			this.filtered = true;
			$(window).resize(this.setMasonry);
			this.setMasonry();
			this.showItems();
		},
		setIsLoading: function () {
			this.$el.append(this.$loader);
			this.isLoading = true;
		},
		unsetIsLoading: function () {
			this.isLoading = false;
			this.$loader && this.$loader.remove();
		},
		setItems: function(els) {
			if( this.masonryEnabled ) {
				this.$content.masonry('appended', els);
			}
			else {
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