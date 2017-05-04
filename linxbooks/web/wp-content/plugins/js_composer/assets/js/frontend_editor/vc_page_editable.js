var vc_iframe = {
  scripts_to_wait: 0,
  time_to_call: false,
  ajax: false,
  activities_list: [],
  scripts_to_load: false,
  loaded_script: {},
  loaded_styles: {},
  inline_scripts: [],
  inline_scripts_body: []
};
(function($) {
  vc_iframe.showNoContent = function(show) {
    var $vc_no_content_helper_el = $('#vc_no-content-helper');
    (show === false && $vc_no_content_helper_el.addClass('vc_not-empty')) || $vc_no_content_helper_el.removeClass('vc_not-empty');
  };
  vc_iframe.scrollTo = function(id) {
    var $el, el_height, hidden = true, position_y, position,
        window_height = $(window).height(),
        window_scroll_top = $(window).scrollTop();
    if(id && ($el = $('[data-model-id=' + id +']'))) {
      position = $el.offset();
      if((position_y = position ? position.top : false) === false) return false;
      el_height = $el.height();
      if((position_y > window_scroll_top + window_height) ||
        (position_y + el_height < window_scroll_top)) {
        $.scrollTo($el, 500, {offset:-50});
      }
    }
  };
  vc_iframe.startSorting = function() {
    $('body').addClass('vc_sorting');
  };
  vc_iframe.stopSorting = function() {
    $('body').removeClass('vc_sorting')
  };
  vc_iframe.initDroppable = function() {
    $('body').addClass('vc_dragging');
    $('.vc_container-block').bind('mouseenter.vcDraggable', function(){
      $(this).addClass('vc_catcher');
    }).bind('mouseout.vcDraggable', function(){
      $(this).removeClass('vc_catcher');
    });
  };
  vc_iframe.killDroppable = function() {
    $('body').removeClass('vc_dragging');
    $('.vc_container-block').unbind('mouseover.vcDraggable mouseleave.vcDraggable');
  };
  vc_iframe.addActivity = function(callback) {
    this.activities_list.push(callback);
  };
  vc_iframe.renderPlaceholder = function(event, element) {
    var tag = $(element).data('tag'),
      $helper = $('<div class="vc_helper vc_helper-' + tag + '"><i class="vc_element-icon'
        + ( parent.vc.map[tag].icon ? ' ' + parent.vc.map[tag].icon : '' )
        + '"'
        + ( parent.vc.map[tag].is_container ? ' data-is-container="true"' : '' )
        + '></i> ' + parent.vc.map[tag].name + '</div>').prependTo('body');
    return $helper;
  };
  vc_iframe.setSortable = function(app){
	var $vc_row_el = $('[data-tag=vc_row]');
	$vc_row_el.parent().sortable({
      forcePlaceholderSize: false,
      items: '[data-tag=vc_row]',
      handle: '.vc_move-vc_row',
      cursor: 'move',
      cursorAt: {top: 20, left: 16},
      placeholder: "vc_placeholder-row",
      helper: this.renderPlaceholder,
      start: function(event, ui){
        vc_iframe.startSorting();
        ui.placeholder.height(30);
      },
      stop: this.stopSorting,
      tolerance: "pointer",
      update: function(event, ui) {
        parent.vc.app.saveRowOrder();
      }
    });
    $('.vc_element-container').sortable({
      forcePlaceholderSize: true,
      helper: this.renderPlaceholder,
      distance: 3,
      scroll: true,
      scrollSensitivity: 70,
      cursor: 'move',
      cursorAt: {top: 20, left: 16},
      connectWith:'.vc_element-container',
      items: '> [data-model-id]',
      handle: '.vc_element-move',
      start: this.startSorting,
      update: app.saveElementOrder,
      change: function(event, ui) {
        ui.placeholder.height(30);
        ui.placeholder.width(ui.placeholder.parent().width());
      },
      placeholder: 'vc_placeholder',
      tolerance: "pointer",
      over:function (event, ui) {
        var tag = ui.item.data('tag'),
            vc_map = window.parent.vc.map || false,
            parent_tag = ui.placeholder.closest('[data-tag]').data('tag'),
            allowed_container_element = vc_map[parent_tag].allowed_container_element === undefined ? true : vc_map[parent_tag].allowed_container_element;
        ui.placeholder.removeClass('vc_hidden-placeholder');
        ui.placeholder.css({maxWidth:ui.placeholder.parent().width()});
        if(tag && vc_map) {
          if (!window.parent.vc.checkRelevance(parent_tag, tag)) {
            ui.placeholder.addClass('vc_hidden-placeholder');
          }
          if(ui.sender) {
            var $sender_column = ui.sender.closest('.vc_element').removeClass('vc_sorting-over');
            $sender_column.find('.vc_element').length < 1 && $sender_column.addClass('vc_empty');
          }
          ui.placeholder.closest('.vc_element').addClass('vc_sorting-over');
          if (vc_map[tag].is_container && !(allowed_container_element === true || allowed_container_element === tag.replace(/_inner$/, ''))) {
            ui.placeholder.addClass('vc_hidden-placeholder');
          }
        }
      },
      out: function(event, ui) {
        ui.placeholder.removeClass('vc_hidden-placeholder');
        // $(this).closest('.vc_element').removeClass('vc_sorting-over');
      },
      stop:function (event, ui) {
        var tag = ui.item.data('tag'),
            vc_map = window.parent.vc.map || false,
            parent_tag = ui.item.parents('[data-tag]:first').data('tag'),
            allowed_container_element = vc_map[parent_tag].allowed_container_element ? vc_map[parent_tag].allowed_container_element : true,
            trig_changed = true,
            item_model;
        if (!window.parent.vc.checkRelevance(parent_tag, tag)) {
          ui.placeholder.removeClass('vc_hidden-placeholder');
          $(this).sortable('cancel');
          trig_changed = false;
        }
        if (vc_map[tag].is_container && !(allowed_container_element === true || allowed_container_element === tag.replace(/_inner$/, ''))) { // && ui.item.hasClass('wpb_container_block')
          ui.placeholder.removeClass('vc_hidden-placeholder');
          $(this).sortable('cancel');
          trig_changed = false
        }
        if(trig_changed) {
          item_model = parent.vc.shortcodes.get(ui.item.data('modelId'));
          item_model.view.parentChanged();
        }
        vc_iframe.stopSorting();
      }
    });
    $('.wpb_row').sortable({
      forcePlaceholderSize: true,
      tolerance: "pointer",
      items: '> [data-tag=vc_column], > [data-tag=vc_column_inner]',
      handle: '> .vc_controls .vc_move-vc_column',
      start: function(event, ui) {
        vc_iframe.startSorting();
        var id = ui.item.data('modelId'),
            model = parent.vc.shortcodes.get(id),
            css_class = model.view.convertSize(model.getParam('width'));
        // ui.item.removeClass(css_class).data('removedClass', css_class);
        ui.item.appendTo(ui.item.parent().parent());
        ui.placeholder.addClass(css_class);
        ui.placeholder.width(ui.placeholder.width()-4);
      },
      cursor: 'move',
      cursorAt: {top: 20, left: 16},
      stop: function(event, ui){
        // ui.item.addClass(ui.item.data('removedClass'));
        vc_iframe.stopSorting(event, ui);
      },
      update: app.saveColumnOrder,
      placeholder: 'vc_placeholder-column',
      helper: this.renderPlaceholder
    });
  /*
    $('.vc_element_button', parent.document).draggable({
      // connectToSortable: '.vc_element-container',
      helper: 'clone',
      revert: true,
      cursor:"move"
    });
    */
    /*
    $('.vc_row_button', parent.document).draggable({
      connectToSortable: $('.entry-content'),
      helper: 'clone',
      revert: 'invalid',
      iframeFix: true
      // appendTo: "body"
    });
 /* .mouseup(function(){
        $(this).draggable( "disable" );
        $('.wpb_column > .wpb_wrapper').sortable('disable');
        $('.vc_placeholder', parent.document).remove();
        // $('.vc_placeholder').remove();
        $(this).draggable( "enable" );
      });
      */
	 $vc_row_el.disableSelection();
	 $vc_row_el.delegate('select','mouseenter',function(){$vc_row_el.enableSelection();} );
	 $vc_row_el.delegate('select','mouseleave',function(){$vc_row_el.disableSelection();} );
	 $vc_row_el.delegate('input[type="text"],textarea', "focus", function () {
		 $vc_row_el.enableSelection();
	 });
	 $vc_row_el.delegate('input[type="text"],textarea', "blur", function () {
		 $vc_row_el.disableSelection();
	 });

    app.setFrameSize();
    $('#vc_load-new-js-block').appendTo('body');
  };
  vc_iframe.loadCustomCss = function(css) {
    if(!vc_iframe.$custom_style) {
      $('[data-type=vc_custom-css]').remove();
      vc_iframe.$custom_style = $('<style class="vc_post_custom_css_style"></style>').appendTo('body');
    }
    vc_iframe.$custom_style.html(css);
  };
  vc_iframe.setCustomShortcodeCss = function(css) {
    this.$shortcodes_custom_css = $('body > [data-type=vc_shortcodes-custom-css]');
    if(!this.$shortcodes_custom_css.length) {
      this.$shortcodes_custom_css = $('<style data-type="vc_shortcodes-custom-css"></style>').prependTo('body');
    }
    this.$shortcodes_custom_css.append(css);
  };
  vc_iframe.addInlineScript = function(script) {
    return this.inline_scripts.push(script)-1;
  };
  vc_iframe.addInlineScriptBody = function(script) {
    return this.inline_scripts_body.push(script)-1;
  };
  vc_iframe.loadInlineScripts = function() {
    var i = 0;
    while(this.inline_scripts[i]) {
      $(this.inline_scripts[i]).insertAfter('.js_placeholder_' + i);
      $('.js_placeholder_' + i).remove();
      i++;
    }
    this.inline_scripts = [];
  };
  vc_iframe.loadInlineScriptsBody = function() {
    var i = 0;
    while(this.inline_scripts_body[i]) {
      $(this.inline_scripts_body[i]).insertAfter('.js_placeholder_inline_' + i);
      $('.js_placeholder_inline_' + i).remove();
      i++;
    }
    this.inline_scripts_body = [];
  };
  vc_iframe.allowedLoadScript = function(src) {
    var script_url, i, scripts_string, scripts = [], scripts_to_add = [], ls_rc;
    if(src.match(/load\-scripts\.php/)) {
      scripts_string = src.match(/load%5B%5D=([^&]+)/)[1];
      if(scripts_string) scripts = scripts_string.split(',');
      for(i in scripts) {
        ls_rc = 'load-script:' + scripts[i];
        if(!vc_iframe.loaded_script[window.md5(ls_rc)]) {
          vc_iframe.loaded_script[window.md5(ls_rc)] = ls_rc;
          scripts_to_add.push(scripts[i]);
        }
      }
      return !scripts_to_add.length ? false : src.replace(/load%5B%5D=[^&]+/, 'load%5B%5D=' + scripts_to_add.join(','));
    } else if(!vc_iframe.loaded_script[window.md5(src)]) {
      vc_iframe.loaded_script[window.md5(src)] = src;
      return src;
    }
    return false;
  };
  vc_iframe.collectScriptsData = function() {
    $('script[src]').each(function(){
      vc_iframe.allowedLoadScript($(this).attr('src'));
    });
    $('link[href]').each(function(){
      var href = $(this).attr('href');
      vc_iframe.loaded_styles[window.md5(href)] = href;
    });
  };
  $('body').removeClass('admin-bar');
  $(document).ready(function(){
    $('#wpadminbar').hide();
    $('.edit-link').hide();
    window.parent.vc && !window.parent.vc.loaded && window.parent.vc.build && window.parent.vc.build();
  });
  vc_iframe.reload = function() {
    vc_iframe.reload_safety_call = false;
    $('a:not(.control-btn),form').each(function(){
        if(!$(this).attr('target') || $(this).attr('target').length==0){
            $(this).attr('target','_blank');
        }
    });

    window.vc_twitterBehaviour();
    window.vc_teaserGrid();
    window.vc_carouselBehaviour();
    window.vc_prettyPhoto();
    window.vc_googleplus();
    window.vc_pinterest();
    window.vc_progress_bar();
    window.vc_waypoints();

    window.vc_google_fonts();

	window.vc_gridBehaviour();

    this.collectScriptsData();
    this.loadInlineScripts();
    this.loadInlineScriptsBody();
    for(var i in this.activities_list) {
       this.activities_list[i].call(window);
    }
    this.activities_list = [];
    $(window).trigger('vc_reload');
    $(window).trigger('resize');
    return true;
  };
  vc_iframe.addScripts = function($elements) {
    vc_iframe.scripts_to_wait = $elements.length;
    vc_iframe.scripts_to_load = $elements;
  };
  vc_iframe.loadScripts = function() {
    if(!vc_iframe.scripts_to_wait || !vc_iframe.scripts_to_load) {
      vc_iframe.reload();
      return;
    }
    vc_iframe.scripts_to_load.each(function(){
      var $element = $(this);
      vc_iframe.reload_safety_call = true;
      if($element.is('script')) {
        var src = $element.attr('src');
        src = vc_iframe.allowedLoadScript(src);
        if(src) {
          $.getScript(src, function() {
            vc_iframe.scripts_to_wait -=1;
            vc_iframe.scripts_to_wait < 1 && vc_iframe.reload()
          });
        } else {
          vc_iframe.scripts_to_wait -=1;
          vc_iframe.scripts_to_wait < 1 && vc_iframe.reload()
        }
      } else {
        var href = $element.attr('href');
        if(!vc_iframe.loaded_styles[window.md5(href)]) {
          $('<link/>', {
            rel: 'stylesheet',
            type: 'text/css',
            href: href
          }).appendTo('body');
        }
        vc_iframe.scripts_to_wait -=1;
        vc_iframe.scripts_to_wait < 1 && vc_iframe.reload();
      }
    });
    vc_iframe.scripts_to_load = false;
    $( document ).ajaxComplete(function(e) {
      $(e.currentTarget).unbind('ajaxComplete');
      !vc_iframe.scripts_to_wait && vc_iframe.reload();
    });
    window.setTimeout(function(){
      vc_iframe.reload_safety_call === true && vc_iframe.reload();
    }, 14000);
  };
  vc_iframe.destroyTabs = function($tabs) {
    $tabs.each(function(){
      var $t = $(this).find('.wpb_tour_tabs_wrapper');
      $t.tabs('destroy');
    });
  };
  vc_iframe.buildTabs = function($tab, active) {
    var ver = $.ui.version.split('.'),
       old_version = parseInt(ver[0])==1 &&  parseInt(ver[1]) < 9;
    // if($call.hasClass('ui-widget')) $call.tabs('destroy');
    $tab.each(function(index) {
    var $tabs,
      interval = $(this).attr("data-interval"),
      tabs_array = [],
      $wrapper = $(this).find('.wpb_tour_tabs_wrapper');
    if($wrapper.hasClass('ui-widget')) {
      active = active!==false ? active : $wrapper.tabs('option', 'active');
      $tabs = $wrapper.tabs('refresh');
      $wrapper.tabs('option', 'active', active);
    } else {
      $tabs = $(this).find('.wpb_tour_tabs_wrapper').tabs({
        active: 0,
        show: function(event, ui) {wpb_prepare_tab_content(event, ui);},
        activate: function(event, ui) {wpb_prepare_tab_content(event, ui);}
      }); // .tabs('rotate', interval*1000);
    }
    $(this).find('.vc_element').each(function(){ tabs_array.push(this.id); });
    $(this).find('.wpb_prev_slide a, .wpb_next_slide a').unbind('click').click(function(e) {
      e.preventDefault();
      if(old_version) {
        var index = $tabs.tabs('option', 'selected');
        if ( $(this).parent().hasClass('wpb_next_slide') ) { index++; }
        else { index--; }
        if ( index < 0 ) { index = $tabs.tabs("length") - 1; }
        else if ( index >= $tabs.tabs("length") ) { index = 0; }
        $tabs.tabs("select", index);
      } else {
        var index = $tabs.tabs( "option", "active"),
          length = $tabs.find('.wpb_tab').length;

        if ( $(this).parent().hasClass('wpb_next_slide') ) {
          index = (index+1) >=length ? 0 : index+1;
        } else {
          index = index-1 < 0 ? length -1 : index-1;
        }
        $tabs.tabs( "option", "active", index );
      }
    });

    });
    return true;
  };
  vc_iframe.setActiveTab = function($tabs, index) {
    $tabs.each(function(){
      $(this).find('.wpb_tour_tabs_wrapper').tabs('refresh');
      $(this).find('.wpb_tour_tabs_wrapper').tabs('option', 'active', index);
    });
  };
  vc_iframe.setTabsSorting = function(view) {
    var $controls = $(view.tabsControls().get(0));
    if($controls.hasClass('ui-sortable')) {
      $controls.sortable('destroy');
    }
    $controls.sortable({
      axis:(view.model.get('shortcode') === 'vc_tour' ? 'y' : 'x'),
      update: view.stopSorting,
      items:"> li:not(.add_tab_block)"/*,
        start: function (event, ui) { ui.item.css('margin-top', $(window).scrollTop() ); },
        beforeStop: function (event, ui) { ui.item.css('margin-top', 0 ); }*/
    });
      // fix: #1019, from http://stackoverflow.com/questions/2451528/jquery-ui-sortable-scroll-helper-element-offset-firefox-issue
    var userAgent = navigator.userAgent.toLowerCase();

    if(userAgent.match(/firefox/)) {
        $controls.bind("sortstart", function (event, ui) {
            ui.helper.css('margin-top', $(window).scrollTop());
        });
        $controls.bind("sortbeforestop", function (event, ui) {
            ui.helper.css('margin-top', 0);
        });
    }
  };
  vc_iframe.buildAccordion = function($el, active) {
    $el.each(function(index) {
      var $this = $(this),
        $tabs,
        $wrapper = $this.find('.wpb_accordion_wrapper'),
        interval = $this.attr("data-interval"),
        active_tab = !isNaN($this.data('active-tab')) && parseInt($this.data('active-tab')) >  0 ? parseInt($this.data('active-tab'))-1 : false,
        collapsible =  active_tab === false || $this.data('collapsible') === 'yes';
      //
      if($wrapper.hasClass('ui-widget')) {
       if(active===false) active = $wrapper.accordion("option", 'active');
        $wrapper.accordion("refresh");
        $wrapper.accordion('option', 'active', active);
      } else {
        $tabs = $this.find('.wpb_accordion_wrapper').accordion({
          create: function(event, ui){
              ui.panel.parent().parent().addClass('vc_active-accordion-tab');
          },
          header: "> .vc_element > div > h3",
          autoHeight: false,
          heightStyle: "content",
          active: active_tab,
          collapsible: collapsible,
          navigation: true,
          activate: function(event, ui){
              vc_accordionActivate(event, ui);
              ui.oldPanel.parent().parent().removeClass('vc_active-accordion-tab');
              ui.newPanel.parent().parent().addClass('vc_active-accordion-tab');
          },
          change: function(event, ui){
            if($.fn.isotope!=undefined) {
              ui.newContent.find('.isotope').isotope("layout");
            }
            window.vc_carouselBehaviour();
          }

        });
      }
      //.tabs().tabs('rotate', interval*1000, true);
    });
  };
  vc_iframe.setAccordionSorting = function(view) {
    $(view.$accordion.find('> .wpb_accordion_wrapper').get(0)).sortable({
      handle: '.vc_move-vc_accordion_tab',
      update: view.stopSorting
    });
  };
  vc_iframe.vc_imageCarousel = function(model_id) {
    var $el = $('[data-model-id=' + model_id + ']'),
        images_count = $el.find('img').length,
        $carousel = $el.find('[data-ride="vc_carousel"]');
    if(!$carousel.find('img:first').length) {
      $carousel.carousel($carousel.data());
      return;
    }
    if(!$carousel.find('img:first').prop('complete')) {
      window.setTimeout(function(){
        vc_iframe.vc_imageCarousel(model_id);
      }, 500);
      return;
    }
    $carousel.carousel($carousel.data());
  };
  vc_iframe.vc_gallery = function(model_id) {
    var $el = $('[data-model-id=' + model_id +']'),
      $gallery = $el.find('.wpb_gallery_slides');
    if(!$gallery.find('img:first').prop('complete')) {
      window.setTimeout(function(){
        vc_iframe.vc_gallery(model_id);
      }, 500);
      return;
    }
    this.gallerySlider($gallery);
  };
  vc_iframe.vc_postsSlider = function(model_id) {
    var $el = $('[data-model-id=' + model_id +']'),
      $gallery = $el.find('.wpb_gallery_slides');
    this.gallerySlider($gallery);
  };
  vc_iframe.gallerySlider = function($gallery) {
    if($gallery.hasClass('wpb_flexslider')) {
      var sliderSpeed = 800,
        sliderTimeout = parseInt($gallery.attr('data-interval'))*1000,
        sliderFx = $gallery.attr('data-flex_fx'),
        slideshow = true;
      if ( sliderTimeout == 0 ) slideshow = false;
      $gallery.flexslider({
        animation: sliderFx,
        slideshow: slideshow,
        slideshowSpeed: sliderTimeout,
        sliderSpeed: sliderSpeed,
        smoothHeight: true
      });
      $gallery.addClass('loaded');
    } else if ( $gallery.hasClass('wpb_slider_nivo') ) {
      var sliderSpeed = 800,
        sliderTimeout = $gallery.attr('data-interval')*1000;

      if ( sliderTimeout == 0 ) sliderTimeout = 9999999999;

      $gallery.find('.nivoSlider').nivoSlider({
        effect: 'boxRainGrow,boxRain,boxRainReverse,boxRainGrowReverse', // Specify sets like: 'fold,fade,sliceDown'
        slices: 15, // For slice animations
        boxCols: 8, // For box animations
        boxRows: 4, // For box animations
        animSpeed: sliderSpeed, // Slide transition speed
        pauseTime: sliderTimeout, // How long each slide will show
        startSlide: 0, // Set starting Slide (0 index)
        directionNav: true, // Next & Prev navigation
        directionNavHide: true, // Only show on hover
        controlNav: true, // 1,2,3... navigation
        keyboardNav: false, // Use left & right arrows
        pauseOnHover: true, // Stop animation while hovering
        manualAdvance: false, // Force manual transitions
        prevText: 'Prev', // Prev directionNav text
        nextText: 'Next' // Next directionNav text
      });
    } else if ( $gallery.hasClass('wpb_image_grid') ) {
      var isotope = $gallery.find('.wpb_image_grid_ul');
      isotope.isotope({
        // options
        itemSelector : '.isotope-item',
        layoutMode : 'fitRows'
      });
      isotope.isotope("layout");
    }
  };
  vc_iframe.vc_Flickr = function($placeholder) {
    var link = $placeholder.data('link');
    // $('<script type="text/javascript" src="' + link + '"></script>').prependTo($placeholder);
    $.getScript(link, function() {
      $(window.b_txt).insertAfter($placeholder);
    });
  };
  vc_iframe.vc_toggle = function(model_id) {
    var $el = $('[data-model-id=' + model_id +']');
	window.vc_toggleBehaviour($el);
  };
	vc_iframe.gridInit = function(model_id) {
		var $grid = $('[data-model-id=' + model_id +'] > [data-vc-grid-settings]');
		$grid.data('vcGrid', undefined);
		$grid.vcGrid();
	};
  $(window).ready(function(){
    if(!parent.vc.loaded) {
	    window.setTimeout(function() {parent.vc.build()},10);
    }
  });
  // vc_iframe.setSortable(window.parent.vc.app);
})(window.jQuery);