/* =========================================================
 * vc_grid_style_pagination.js v1.0
 * =========================================================
 * Copyright 2014 Wpbakery
 *
 * Basic Grid Style pagination
 * ========================================================= */
var vcGridStylePagination = null;
(function ($) {
	/**
	 * "Paginator" grid style.
	 * ==============================
	 *
	 * @param grid
	 * @constructor
	 */
	vcGridStylePagination = function (grid) {
		this.grid = grid;
		this.settings = grid.settings;

		this.$el = false;
		this.$content = false;
        this.filterValue = null;
		this.isLoading = false;
		this.htmlCache = false;
		this.$loader = $('<div class="vc_grid-loading"></div>');
		this.$firstSlideItems; //todo check this? Expression statement is not assignment or call (at line 27)
		this.init();
	};
	/**
	 * Initialize
	 */
	vcGridStylePagination.prototype.init = function () {
		_.bindAll(this,
			'addItems',
			'initCarousel'
		);
	};
	vcGridStylePagination.prototype.setIsLoading = function () {
		this.$loader.show();
		this.isLoading = true;
	};

	vcGridStylePagination.prototype.unsetIsLoading = function () {
		this.isLoading = false;
		this.$loader.hide();
	};
	/**
	 * Build required content and data.
	 */
	vcGridStylePagination.prototype.render = function () {
        this.$el = this.grid.$el;
        this.$content = this.$el;
        this.$content.append(this.$loader);
        this.setIsLoading();
        this.grid.ajax({}, this.addItems);
	};
	/**
	 * Filter function called by grid object ot filter content.
	 *
	 * @param filter - string parameter with filter settings.
	 */
	vcGridStylePagination.prototype.filter = function (filter) {
        filter = _.isUndefined(filter) || filter === '*' ? '' : filter;
        if( this.filterValue == filter ) {
            return false; // already filtred
        }
		var $html;
		if (this.$content.data('owl.carousel')) {
			this.$content.off('initialized.owl.carousel');
			this.$content.off('changed.owl.carousel');
			this.$content.data('vcPagination') && this.$content.data('vcPagination').twbsPagination('destroy');
			this.$content.data('owl.carousel').destroy();
		}
		this.$content.html('');
		$html = $('.vc_grid-item',this.htmlCache);
		if (filter !== '') {
            $html = $html.filter(filter);
        }
        this.filterValue = filter;
		this.buildSlides($html.addClass('vc_visible-item'));
		// 	( vcGridSettings.addItemsAnimation != 'none' ? vcGridSettings.addItemsAnimation + ' animated' : '') ) );

	};
	/**
	 * Create slides from list of elements for grid.
	 *
	 * @param $html
	 */
	vcGridStylePagination.prototype.buildSlides = function ($html) {
		var i, j, tempArray, chunk = parseInt(this.settings.items_per_page);
		//this.settings.total_items = $html.length;
		for (i = 0, j = $html.length; i < j; i += chunk) {
			tempArray = $html.slice(i, i + chunk);
			$('<div class="vc_pageable-slide-wrapper">')
				.append($(tempArray))
				.appendTo(this.$content);
		}
		this.$content
			.find('.vc_pageable-slide-wrapper:first')
			.imagesLoaded(this.initCarousel);
	};
	/**
	 * Add new grid elements to content block. Called by ajax in render method.
	 * @param html
	 */
	vcGridStylePagination.prototype.addItems = function (html) {
        this.unsetIsLoading();
        $(html).appendTo(this.$el);
        if (this.htmlCache === false) this.htmlCache = html;
        this.$content = this.$el.find('[data-vc-pageable-content="true"]');
        this.$content.addClass('owl-carousel vc_grid-owl-theme');
        this.grid.initFilter();
        this.filter();
		window.vc_prettyPhoto();
        return false;

	};
	/**
	 * initialize Carousel. owl plugin used
	 */
	vcGridStylePagination.prototype.initCarousel = function () {
		// If owlCarousel
		if ($.fn.owlCarousel) {
			var that = this;
			this.$content.on('initialized.owl.carousel', function (event) {
				if (that.settings.paging_design.indexOf('pagination') > -1) {
					var $carousel = event.relatedTarget;
					var items = $carousel.items().length;
					var $pagination = $('<div></div>').addClass('vc_grid-pagination').appendTo(that.$el);
					$pagination.twbsPagination({
						totalPages: items,
						visiblePages: that.settings.visible_pages,
						onPageClick: function (event, page) {
							$carousel.to(page - 1);
						},
						paginationClass: 'vc_grid-pagination-list' + ' vc_grid-'
						+ that.settings.paging_design
						+ ' vc_grid-pagination-color-' + that.settings.paging_color,
						nextClass: 'vc_grid-next',
						first: items > 20 ? ' ' : false,
						last: items > 20 ? ' ' : false,
						prev: items > 5 ? ' ' : false,
						next: items > 5 ? ' ' : false, // window.vcGrid_i18nLocale.next : false,
						prevClass: 'vc_grid-prev',
						lastClass: 'vc_grid-last',
						loop: that.settings.loop,
						firstClass: 'vc_grid-first',
						pageClass: 'vc_grid-page',
						activeClass: 'vc_grid-active',
						disabledClass: 'vc_grid-disabled'
					});
					$(this).data('vcPagination', $pagination);
					// let's synchronize the pagination and arrows
					that.$content.on('changed.owl.carousel', function (event) {
						var $pagination = $(this).data('vcPagination'),
							$pag_object = $pagination.data('twbsPagination');
						$pag_object.render($pag_object.getPages(1 + event.page.index));
						$pag_object.setupEvents();
					});
					window.vc_prettyPhoto();
				}
			}).owlCarousel({
				items: 1,
				loop: this.settings.loop,
				margin: 10,
				nav: true,
				navText: ['', ''],
				navContainerClass: 'vc_grid-owl-nav' + ' vc_grid-owl-nav-color-' + this.settings.arrows_color,
				dotClass: 'vc_grid-owl-dot',
				dotsClass: 'vc_grid-owl-dots' + ' vc_grid-' + this.settings.paging_design + ' vc_grid-owl-dots-color-' + this.settings.paging_color,
				navClass: [
					'vc_grid-owl-prev' + ' '
						+ this.settings.arrows_design + ' vc_grid-nav-prev-' + this.settings.arrows_position,
					'vc_grid-owl-next' + ' '
						+ this.settings.arrows_design.replace('_left', '_right') + ' vc_grid-nav-next-' + this.settings.arrows_position
				],
				animateIn: this.settings.animation_in != 'none' ? this.settings.animation_in : false,
				animateOut: this.settings.animation_out != 'none' ? this.settings.animation_out : false,
				autoHeight: true,
				autoplay: this.settings.auto_play === true,
				autoplayTimeout: this.settings.speed,
				callbacks: true
			});
			// set key up.
			/*$(document).off('keyup').on('keyup', function (e) {
				var $el;
				if (e.which == 39) {
					$el = $('.vc_hook_hover.vc_grid-owl-theme.vc_is-hover');
					if ($el.is(':visible')) {
						$el.data('owl.carousel').next();
					}
				} else if (e.which == 37) {
					$el = $('.vc_hook_hover.vc_grid-owl-theme.vc_is-hover');
					if ($el.is(':visible')) {
						$el.data('owl.carousel').prev();
					}
				}
			});*/
		}
	};
})(window.jQuery);