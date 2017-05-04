jQuery(document).ready(function ($) {

	"use strict";

	$.browser={};(function(){$.browser.msie=false;
	$.browser.version=0;if(navigator.userAgent.match(/MSIE ([0-9]+)\./)){
	$.browser.msie=true;$.browser.version=RegExp.$1;}})();

	// Superfish
	if ($(".sf-menu")[0]) {
		$('.sf-menu').superfish({
			delay: 100,
			animation: {
				opacity: 'none', height: 'show'
			},
			speed: 300
		});
		$('.sf-menu li li a').prepend('<i class="fa-caret-right"></i>');
		$('.sf-menu li li .sf-sub-indicator i').removeClass('fa-chevron-down').addClass('fa-chevron-right');
	}
	// Responsive
	$("#header nav").before('<div id="mobilepro"><i class="fa-bars fa-times"></i></div>');
	$("#header .sf-menu a.sf-with-ul").before('<div class="subarrow"><i class="fa-angle-down"></i></div>');
	$('.subarrow').click(function () {
		$(this).parent().toggleClass("xpopdrop");
	});
	$('#mobilepro').click(function () {
		$('#header .sf-menu').slideToggle('slow', 'easeInOutExpo').toggleClass("xactive");
		$("#mobilepro i").toggleClass("fa-bars");
	});
	$("body").click(function() {
		$('#header .xactive').slideUp('slow', 'easeInOutExpo').removeClass("xactive");
		$("#mobilepro i").addClass("fa-bars");
	});
	$('#mobilepro, .sf-menu').click(function(e) {
		e.stopPropagation();
	});
	function checkWindowSize() {
		if ($(window).width() >= 959) {
			$('#header .sf-menu').css('display', 'block').removeClass("xactive");
		} else {
			$('#header .sf-menu').css('display', 'none');
		}
	}
	$(window).load(checkWindowSize);
	$(window).resize(checkWindowSize);

	// ToTop
	$('#toTop').click(function () {
		$('body,html').animate({
			scrollTop: 0
		}, 1000);
	});

	// ShopCart
	$(".shopping_bag").hover(function() {
		$('.view_cart_mini').stop(true, true).fadeIn(400);
	}, function() {
		$('.view_cart_mini').stop(true, true).fadeOut(400);
	});

	// Languages
	$(".languages").hover(function() {
		$('.other_languages').stop(true, true).slideDown('fast');
	}, function() {
		$('.other_languages').stop(true, true).slideUp('fast');
	});

	// Search
	$(".search_icon").click(function() {
		if ($(this).hasClass('opened')) {
			$(this).removeClass('opened');
			$('.icon_close').addClass('icon_search');
			$('.s_form').fadeOut('slow').removeClass('animated fadeInUp').addClass('animated fadeOutUp');
		} else {
			$(this).addClass('opened');
			$('.icon_close').removeClass('icon_search');
			$(".s_form").fadeIn('slow').removeClass('animated fadeOutUp').addClass('animated fadeInUp');
			$('#inputhead').focus();
		}
	});

	$("body").click(function() {
		$('.search_icon').removeClass('opened');
		$('.icon_close').addClass('icon_search');
		$('.s_form').fadeOut('slow').removeClass('animated fadeInUp').addClass('animated fadeOutUp');
	});
	$('.search').click(function(e) {
		e.stopPropagation();
	});

	// Notification
	$(".notification-close").click(function () {
		$(this).parent().slideUp("slow");
		return false;
	});


	if ($(".projectslider")[0]) {
		$('.projectslider').flexslider({
			animation: "slide",
			direction: "horizontal",
			slideshowSpeed: 8000,
			animationSpeed: 1000,
			animationLoop: false,
			directionNav: true,
			controlNav: false,
			pauseOnHover: true,
			initDelay: 0,
			randomize: false,
			smoothHeight: true,
			sync: "#thumbnails",
			keyboardNav: false
		});
	}
	

	// Parallax on Touchable Divices
	var isMobile = 'ontouchstart' in document.documentElement;
	if (isMobile) {
	    $('.parallax').css({'background-attachment':'scroll'});
	}
	// jCarousel
	$(".prev-holder").addClass('disabled');
    if ($(".portfolio_carousel")[0]) {
        
        $(".portfolio_carousel").imagesLoaded(function(){



            $(".portfolio_carousel").each(function(){
                var carouselContainer = $(this).closest('.f_portfolio');
                var carouselPrev = carouselContainer.find('.prev-holder').attr('class').split(" ")[1];
                var carouselNext = carouselContainer.find('.next-holder').attr('class').split(" ")[1];
                
                $(this).jCarouselLite({
                    btnNext: ".f_portfolio ." + carouselNext,
                    btnPrev: ".f_portfolio ." + carouselPrev,
                    easing: "easeOutExpo",
                    circular: false,
                    visible: 3,
                    scroll: 1,
                    speed: 800
                });
            });

    });  
    }  

	// prettyPhoto
	if ($("a[data-gal^='lightbox']")[0]) {
		$("a[data-gal^='lightbox']").prettyPhoto({
			animation_speed: 'normal',
			theme: 'dark_rounded',
			autoplay_slideshow: false,
			overlay_gallery: true,
			show_title: false
		});
	}
	// quicksand
	if ($(".filter")[0]) {
		var $portfolioClone = $(".portfolio").clone();
		$(".filter a").click(function (e) {
			$(".filter li").removeClass("current");
			var $filterClass = $(this).parent().attr("class");
			if ($filterClass === "all") {
				var $filteredPortfolio = $portfolioClone.find("li");
			} else {
				var $filteredPortfolio = $portfolioClone.find("li[data-type~=" + $filterClass + "]");
			}
			// Call quicksand
			$(".portfolio").quicksand($filteredPortfolio, {
				duration: 800,
				useScaling: 'true',
				easing: 'easeInOutCubic',
				adjustHeight: 'dynamic'
			}, function () {
				$(".portfolio a[data-gal^='lightbox']").prettyPhoto({
					animation_speed: 'normal',
					theme: 'dark_rounded',
					autoplay_slideshow: false,
					overlay_gallery: true,
					show_title: false
				});
			});
			$(this).parent().addClass("current");
			e.preventDefault();
		});
	}

	// Tipsy
	$('.toptip').tipsy({fade: true,gravity: 's'});
	$('.bottomtip').tipsy({fade: true,gravity: 'n'});
	$('.righttip').tipsy({fade: true,gravity: 'w'});
	$('.lefttip').tipsy({fade: true,gravity: 'e'});

	// Custom
	var isDesktop = (function() {
		return !('ontouchstart' in window) // works on most browsers 
		|| !('onmsgesturechange' in window); // works on ie10
	})();

	window.isDesktop = isDesktop;
	if( isDesktop ){
		if ($(".animated")[0]) {
			$('.animated').css('opacity', '0');
		}
		$('.animt').each(function () {
			var $curr = $(this);
			var $currOffset = $curr.attr('data-gen-offset');
			if ($currOffset === '' || $currOffset === 'undefined' || $currOffset === undefined) {
				$currOffset = 'bottom-in-view';
			}
			$curr.waypoint(function () {
				$curr.trigger('animt');
			}, {
				triggerOnce: true,
				offset: $currOffset
			});
		});
		$('.animated').each(function () {
			var $curr = $(this);
			$curr.bind('animt', function () {
				$curr.css('opacity', '');
				$curr.addClass($curr.data('gen'));
			});
		});
		$('.animated').each(function () {
			var $curr = $(this);
			var $currOffset = $curr.attr('data-gen-offset');
			if ($currOffset === '' || $currOffset === 'undefined' || $currOffset === undefined) {
				$currOffset = 'bottom-in-view';
			}
			$curr.waypoint(function () {
				$curr.trigger('animt');
			}, {
				triggerOnce: true,
				offset: $currOffset
			});
		});

		$.stellar({
			horizontalScrolling: false,
			verticalOffset: 0
		});
	}
	
	// MinusMargin for Slider and Breadcrumb
		var headdown_h = $('.headdown').height();
		var intro_p_h = $('.intro_p').height();
		$('.sliderr').css('top', - headdown_h + 'px').css('margin-bottom', - (intro_p_h + headdown_h) + 'px');
	
	// Sticky
	if ($(".my_sticky")[0]){
		$('.my_sticky').before('<div class="Corpse_Sticky"></div>');
		$(window).scroll(function(){
			var wind_scr = $(window).scrollTop();
			var window_width = $(window).width();
			var head_w = $('.my_sticky').height();
			if (window_width >= 959) {
				if(wind_scr < 120){
					if($('.my_sticky').data('sticky') === true){
						$('.my_sticky').data('sticky', false);
						$('.my_sticky').stop(true).animate({opacity : 0}, 300, function(){
							$('.my_sticky').removeClass('sticky');
							$('.my_sticky').stop(true).animate({opacity : 1}, 300);
							$('.Corpse_Sticky').css('padding-top', '').css('border-bottom', '0');
						});
					}
				} else {
					if($('.my_sticky').data('sticky') === false || typeof $('.my_sticky').data('sticky') === 'undefined'){
						$('.my_sticky').data('sticky', true);
						$('.my_sticky').stop(true).animate({opacity : 0},300,function(){
							$('.my_sticky').addClass('sticky');
							$('.my_sticky.sticky').stop(true).animate({opacity : 1}, 300);
							$('.Corpse_Sticky').css('padding-top', head_w + 'px').css('border-bottom', '2px solid #F5F5F5');
						});
					}
				}
			}
		});
		$(window).resize(function(){
			var window_width = $(window).width();
			if (window_width <= 959) {
				if($('.my_sticky').hasClass('sticky')){
					$('.my_sticky').removeClass('sticky');
					$('.my_sticky').stop(true).animate({opacity : 0}, 300, function(){
						$('.my_sticky').removeClass('sticky');
						$('.my_sticky').stop(true).animate({opacity : 1}, 300);
						$('.Corpse_Sticky').css('padding-top', '');
					});
				}
			}
		});
	}
	// HoverSlide
	$('.fancy-features').each(function (){
		var fList = $(this).find('.fancy-features-list');
		var fImages = $(this).find('.fancy-features-image');
		$(this).find('.fancy-features-list ul li:first-child').addClass('active');
		$(this).find('.fancy-features-image .h_slider:first-child').addClass('showme');
		fList.find('ul li a').mouseover(function (e) {
			e.preventDefault();
			var slide_id = $(this).attr('href');
			var slide_post_id = slide_id.replace('#', '');
			$(this).closest('ul').find('li').removeClass('active');
			$(this).parent().addClass('active');
			fImages.find('.h_slider').removeClass('showme');
			fImages.find('.h_slider'+' .'+slide_post_id).parent().addClass('showme').stop(true, true);
	});

	});
	$('.fancy_testimonial ul li:first-child').addClass('active');
	$('.fancy_testimonial_testimonial .h_slider:first-child').addClass('showme');

	// HoverTestimonials
	$('.fancy_testimonial ul li a').mouseover(function (e) {
		e.preventDefault();
		var slide_id = $(this).attr('href');
		var slide_post_id = slide_id.replace('#', '');
		$(this).closest('ul').find('li').removeClass('active');
		$(this).parent().addClass('active');
		$('.fancy_testimonial_testimonial .h_slider').removeClass('showme');
		$('.fancy_testimonial_testimonial .h_slider'+' .'+slide_post_id).parent().addClass('showme').stop(true, true);
	});

	// add icon to reply link
	$('.thumb .reply .comment-reply-link').prepend('<i class="fa-reply mi"></i> ');

	// hover image for shop images
	if( $('.woocommerce .products .thumbnail-container')[0] ) {
		var thumbContainer = $('.woocommerce .products .thumbnail-container');
		thumbContainer.each(function(){
			var firstThumb = $(this).find('img.attachment-shop_catalog');
			var secImage = $(this).find('img.product_img_hover');

			if( secImage.length > 0 ){
				$(this).hover(function(){
					firstThumb.hide();
					secImage.show();
				}, 
				function(){
					firstThumb.show();
					secImage.hide();

				});
			}

		});
	}


	//Masonry Portfolio
	var $masonrytt = $('#masonry-container');
	$masonrytt.imagesLoaded( function(){
		$masonrytt.masonry({
			itemSelector: '.post',
			isAnimated: true,
			columnWidth: 1
		});
	});

	$("#layout").fitVids();

	// Content Box clear fix
	function contentBoxClearFix() {
		var bodyWidth = $('body').width();
		$('.content-boxes .clear.cbcf').remove(); // .cbcf = Content Box Clear Fix
		if (bodyWidth < 1220) {
			$('.content-boxes.child6 .content-box:nth-child(3), .content-boxes.child5 .content-box:nth-child(3), .content-boxes.child4 .content-box:nth-child(3)').after('<div class="clear cbcf">');
		}
	}
	contentBoxClearFix();
	$(window).resize(contentBoxClearFix);

	// remove empty p
	$('p:empty').remove(); 

	// google map full width
    function fullScreenMap() {

                var fullscreenMap = $('.full-screen-gmap'),
                    container = $('#layout .row').first(),
                    mapOffset = container.offset().left,
                    $window = $(window),
                    windowWidth = $window.width();

                if (windowWidth > 768) {
                    mapOffset = mapOffset;
                } 
                
                if ($('#layout').hasClass('boxed')) {
                    windowWidth = $('#layout').width();
                    mapOffset = ( windowWidth - container.width() ) /2 ;
                }
                            
                fullscreenMap.css('width', windowWidth);
                fullscreenMap.css('margin-left', '-' + mapOffset + 'px');
                
    }
    fullScreenMap();
    $(window).resize(fullScreenMap);
});



function mycarousel4_initCallback(e){e.buttonNext.hover(function(){e.stopAuto()},function(){e.startAuto()});e.buttonPrev.hover(function(){e.stopAuto()},function(){e.startAuto()});e.clip.hover(function(){e.stopAuto()},function(){e.startAuto()})};
/* jQuery Waypoints - Copyright (c) 2011-2013 Caleb Troughton - https://github.com/imakewebthings/jquery-waypoints/blob/master/licenses.txt */
(function(){var t=[].indexOf||function(t){for(var e=0,n=this.length;e<n;e++){if(e in this&&this[e]===t)return e}return-1},e=[].slice;(function(t,e){if(typeof define==="function"&&define.amd){return define("waypoints",["jquery"],function(n){return e(n,t)})}else{return e(t.jQuery,t)}})(this,function(n,r){var i,o,l,s,f,u,a,c,h,d,p,y,v,w,g,m;i=n(r);c=t.call(r,"ontouchstart")>=0;s={horizontal:{},vertical:{}};f=1;a={};u="waypoints-context-id";p="resize.waypoints";y="scroll.waypoints";v=1;w="waypoints-waypoint-ids";g="waypoint";m="waypoints";o=function(){function t(t){var e=this;this.$element=t;this.element=t[0];this.didResize=false;this.didScroll=false;this.id="context"+f++;this.oldScroll={x:t.scrollLeft(),y:t.scrollTop()};this.waypoints={horizontal:{},vertical:{}};t.data(u,this.id);a[this.id]=this;t.bind(y,function(){var t;if(!(e.didScroll||c)){e.didScroll=true;t=function(){e.doScroll();return e.didScroll=false};return r.setTimeout(t,n[m].settings.scrollThrottle)}});t.bind(p,function(){var t;if(!e.didResize){e.didResize=true;t=function(){n[m]("refresh");return e.didResize=false};return r.setTimeout(t,n[m].settings.resizeThrottle)}})}t.prototype.doScroll=function(){var t,e=this;t={horizontal:{newScroll:this.$element.scrollLeft(),oldScroll:this.oldScroll.x,forward:"right",backward:"left"},vertical:{newScroll:this.$element.scrollTop(),oldScroll:this.oldScroll.y,forward:"down",backward:"up"}};if(c&&(!t.vertical.oldScroll||!t.vertical.newScroll)){n[m]("refresh")}n.each(t,function(t,r){var i,o,l;l=[];o=r.newScroll>r.oldScroll;i=o?r.forward:r.backward;n.each(e.waypoints[t],function(t,e){var n,i;if(r.oldScroll<(n=e.offset)&&n<=r.newScroll){return l.push(e)}else if(r.newScroll<(i=e.offset)&&i<=r.oldScroll){return l.push(e)}});l.sort(function(t,e){return t.offset-e.offset});if(!o){l.reverse()}return n.each(l,function(t,e){if(e.options.continuous||t===l.length-1){return e.trigger([i])}})});return this.oldScroll={x:t.horizontal.newScroll,y:t.vertical.newScroll}};t.prototype.refresh=function(){var t,e,r,i=this;r=n.isWindow(this.element);e=this.$element.offset();this.doScroll();t={horizontal:{contextOffset:r?0:e.left,contextScroll:r?0:this.oldScroll.x,contextDimension:this.$element.width(),oldScroll:this.oldScroll.x,forward:"right",backward:"left",offsetProp:"left"},vertical:{contextOffset:r?0:e.top,contextScroll:r?0:this.oldScroll.y,contextDimension:r?n[m]("viewportHeight"):this.$element.height(),oldScroll:this.oldScroll.y,forward:"down",backward:"up",offsetProp:"top"}};return n.each(t,function(t,e){return n.each(i.waypoints[t],function(t,r){var i,o,l,s,f;i=r.options.offset;l=r.offset;o=n.isWindow(r.element)?0:r.$element.offset()[e.offsetProp];if(n.isFunction(i)){i=i.apply(r.element)}else if(typeof i==="string"){i=parseFloat(i);if(r.options.offset.indexOf("%")>-1){i=Math.ceil(e.contextDimension*i/100)}}r.offset=o-e.contextOffset+e.contextScroll-i;if(r.options.onlyOnScroll&&l!=null||!r.enabled){return}if(l!==null&&l<(s=e.oldScroll)&&s<=r.offset){return r.trigger([e.backward])}else if(l!==null&&l>(f=e.oldScroll)&&f>=r.offset){return r.trigger([e.forward])}else if(l===null&&e.oldScroll>=r.offset){return r.trigger([e.forward])}})})};t.prototype.checkEmpty=function(){if(n.isEmptyObject(this.waypoints.horizontal)&&n.isEmptyObject(this.waypoints.vertical)){this.$element.unbind([p,y].join(" "));return delete a[this.id]}};return t}();l=function(){function t(t,e,r){var i,o;r=n.extend({},n.fn[g].defaults,r);if(r.offset==="bottom-in-view"){r.offset=function(){var t;t=n[m]("viewportHeight");if(!n.isWindow(e.element)){t=e.$element.height()}return t-n(this).outerHeight()}}this.$element=t;this.element=t[0];this.axis=r.horizontal?"horizontal":"vertical";this.callback=r.handler;this.context=e;this.enabled=r.enabled;this.id="waypoints"+v++;this.offset=null;this.options=r;e.waypoints[this.axis][this.id]=this;s[this.axis][this.id]=this;i=(o=t.data(w))!=null?o:[];i.push(this.id);t.data(w,i)}t.prototype.trigger=function(t){if(!this.enabled){return}if(this.callback!=null){this.callback.apply(this.element,t)}if(this.options.triggerOnce){return this.destroy()}};t.prototype.disable=function(){return this.enabled=false};t.prototype.enable=function(){this.context.refresh();return this.enabled=true};t.prototype.destroy=function(){delete s[this.axis][this.id];delete this.context.waypoints[this.axis][this.id];return this.context.checkEmpty()};t.getWaypointsByElement=function(t){var e,r;r=n(t).data(w);if(!r){return[]}e=n.extend({},s.horizontal,s.vertical);return n.map(r,function(t){return e[t]})};return t}();d={init:function(t,e){var r;if(e==null){e={}}if((r=e.handler)==null){e.handler=t}this.each(function(){var t,r,i,s;t=n(this);i=(s=e.context)!=null?s:n.fn[g].defaults.context;if(!n.isWindow(i)){i=t.closest(i)}i=n(i);r=a[i.data(u)];if(!r){r=new o(i)}return new l(t,r,e)});n[m]("refresh");return this},disable:function(){return d._invoke(this,"disable")},enable:function(){return d._invoke(this,"enable")},destroy:function(){return d._invoke(this,"destroy")},prev:function(t,e){return d._traverse.call(this,t,e,function(t,e,n){if(e>0){return t.push(n[e-1])}})},next:function(t,e){return d._traverse.call(this,t,e,function(t,e,n){if(e<n.length-1){return t.push(n[e+1])}})},_traverse:function(t,e,i){var o,l;if(t==null){t="vertical"}if(e==null){e=r}l=h.aggregate(e);o=[];this.each(function(){var e;e=n.inArray(this,l[t]);return i(o,e,l[t])});return this.pushStack(o)},_invoke:function(t,e){t.each(function(){var t;t=l.getWaypointsByElement(this);return n.each(t,function(t,n){n[e]();return true})});return this}};n.fn[g]=function(){var t,r;r=arguments[0],t=2<=arguments.length?e.call(arguments,1):[];if(d[r]){return d[r].apply(this,t)}else if(n.isFunction(r)){return d.init.apply(this,arguments)}else if(n.isPlainObject(r)){return d.init.apply(this,[null,r])}else if(!r){return n.error("jQuery Waypoints needs a callback function or handler option.")}else{return n.error("The "+r+" method does not exist in jQuery Waypoints.")}};n.fn[g].defaults={context:r,continuous:true,enabled:true,horizontal:false,offset:0,triggerOnce:false};h={refresh:function(){return n.each(a,function(t,e){return e.refresh()})},viewportHeight:function(){var t;return(t=r.innerHeight)!=null?t:i.height()},aggregate:function(t){var e,r,i;e=s;if(t){e=(i=a[n(t).data(u)])!=null?i.waypoints:void 0}if(!e){return[]}r={horizontal:[],vertical:[]};n.each(r,function(t,i){n.each(e[t],function(t,e){return i.push(e)});i.sort(function(t,e){return t.offset-e.offset});r[t]=n.map(i,function(t){return t.element});return r[t]=n.unique(r[t])});return r},above:function(t){if(t==null){t=r}return h._filter(t,"vertical",function(t,e){return e.offset<=t.oldScroll.y})},below:function(t){if(t==null){t=r}return h._filter(t,"vertical",function(t,e){return e.offset>t.oldScroll.y})},left:function(t){if(t==null){t=r}return h._filter(t,"horizontal",function(t,e){return e.offset<=t.oldScroll.x})},right:function(t){if(t==null){t=r}return h._filter(t,"horizontal",function(t,e){return e.offset>t.oldScroll.x})},enable:function(){return h._invoke("enable")},disable:function(){return h._invoke("disable")},destroy:function(){return h._invoke("destroy")},extendFn:function(t,e){return d[t]=e},_invoke:function(t){var e;e=n.extend({},s.vertical,s.horizontal);return n.each(e,function(e,n){n[t]();return true})},_filter:function(t,e,r){var i,o;i=a[n(t).data(u)];if(!i){return[]}o=[];n.each(i.waypoints[e],function(t,e){if(r(i,e)){return o.push(e)}});o.sort(function(t,e){return t.offset-e.offset});return n.map(o,function(t){return t.element})}};n[m]=function(){var t,n;n=arguments[0],t=2<=arguments.length?e.call(arguments,1):[];if(h[n]){return h[n].apply(null,t)}else{return h.aggregate.call(null,n)}};n[m].settings={resizeThrottle:100,scrollThrottle:30};return i.load(function(){return n[m]("refresh")})})}).call(this);