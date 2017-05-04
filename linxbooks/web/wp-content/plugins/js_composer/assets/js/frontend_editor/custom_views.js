/* =========================================================
 * custom_views.js v1.1
 * =========================================================
 * Copyright 2013 Wpbakery
 *
 * Visual composer ViewModel objects for shortcodes with custom
 * functionality.
 * ========================================================= */


(function ($) {
  if(_.isUndefined(window.vc)) window.vc = {};
  // Custom vc_column shortcode
  window.InlineShortcodeViewContainer = window.InlineShortcodeView.extend({
    controls_selector: '#vc_controls-template-container',
    events: {
      'click > .vc_controls .vc_element .vc_control-btn-delete': 'destroy',
      'click > .vc_controls .vc_element .vc_control-btn-edit': 'edit',
      'click > .vc_controls .vc_element .vc_control-btn-clone': 'clone',
      'click > .vc_controls .vc_element .vc_control-btn-prepend': 'prependElement',
      'click > .vc_controls .vc_control-btn-append': 'appendElement',
      'click > .vc_empty-element': 'appendElement',
      'mouseenter': 'resetActive',
      'mouseleave': 'holdActive'
    },
    hold_active: false,
    initialize: function(params) {
      _.bindAll(this, 'holdActive');
      window.InlineShortcodeViewContainer.__super__.initialize.call(this, params);
      this.parent_view = vc.shortcodes.get(this.model.get('parent_id')).view;
    },
    resetActive: function(e) {
      this.hold_active && window.clearTimeout(this.hold_active);
    },
    holdActive: function(e) {
      this.resetActive();
      this.$el.addClass('vc_hold-active');
      var view = this;
      this.hold_active = window.setTimeout(function(){
        view.hold_active && window.clearTimeout(view.hold_active);
        view.hold_active = false;
        view.$el.removeClass('vc_hold-active');
      }, 700);
    },
    content: function() {
      if(this.$content === false) {
        this.$content = this.$el.find('.vc_container-anchor:first').parent();
        this.$el.find('.vc_container-anchor:first').remove();
      }
      return this.$content;
    },
    render: function() {
      window.InlineShortcodeViewContainer.__super__.render.call(this);
      this.content().addClass('vc_element-container');
      this.$el.addClass('vc_container-block');
      return this;
    },
    changed: function() {
      (this.$el.find('.vc_element[data-tag]').length == 0 && this.$el.addClass('vc_empty').find('> :first').addClass('vc_empty-element'))
      || this.$el.removeClass('vc_empty').find('> .vc_empty-element').removeClass('vc_empty-element');
    },
    prependElement: function(e) {
      _.isObject(e) && e.preventDefault();
      this.prepend = true;
      vc.add_element_block_view.render(this.model, true);
    },
    appendElement: function(e) {
      _.isObject(e) && e.preventDefault();
      vc.add_element_block_view.render(this.model);
    },
    addControls: function() {
      var template = $(this.controls_selector).html(),
        parent = vc.shortcodes.get(this.model.get('parent_id')),
        data = {
          name: vc.getMapped(this.model.get('shortcode')).name,
          tag: this.model.get('shortcode'),
          parent_name: vc.getMapped(parent.get('shortcode')).name,
          parent_tag: parent.get('shortcode')
        };
      this.$controls = $(_.template(template, data, vc.template_options).trim()).addClass('vc_controls');
      this.$controls.appendTo(this.$el);
    },
    multi_edit: function(e) {
      var models = [], parent, children;
      _.isObject(e) && e.preventDefault();
      if(this.model.get('parent_id')) parent = vc.shortcodes.get(this.model.get('parent_id'));
      if(parent) {
        models.push(parent);
        children = vc.shortcodes.where({parent_id: parent.get('id')});
        vc.multi_edit_element_block_view.render(models.concat(children), this.model.get('id'));
      } else {
        vc.edit_element_block_view.render(this.model);
      }
    }
  });
  window.InlineShortcodeViewContainerWithParent = window.InlineShortcodeViewContainer.extend({
    controls_selector: '#vc_controls-template-container-with-parent',
    events: {
      'click > .vc_controls .vc_element .vc_control-btn-delete': 'destroy',
      'click > .vc_controls .vc_element .vc_control-btn-edit': 'edit',
      'click > .vc_controls .vc_element .vc_control-btn-clone': 'clone',
      'click > .vc_controls .vc_element .vc_control-btn-prepend': 'prependElement',
      'click > .vc_controls .vc_control-btn-append': 'appendElement',
      'click > .vc_controls .vc_parent .vc_control-btn-delete': 'destroyParent',
      'click > .vc_controls .vc_parent .vc_control-btn-edit': 'editParent',
      'click > .vc_controls .vc_parent .vc_control-btn-clone': 'cloneParent',
      'click > .vc_controls .vc_parent .vc_control-btn-prepend': 'addSibling',
      'click > .vc_controls .vc_parent .vc_control-btn-layout': 'changeLayout',
      'click > .vc_empty-element': 'appendElement',
      'click > .vc_controls .vc_control-btn-switcher': 'switchControls',
      'mouseenter': 'resetActive',
      'mouseleave': 'holdActive'
    },
    destroyParent: function(e) {
      e && e.preventDefault();
      this.parent_view.destroy(e);
    },
    cloneParent: function(e) {
      e && e.preventDefault();
      this.parent_view.clone(e);
    },
    editParent: function(e) {
      e && e.preventDefault();
      this.parent_view.edit(e);
    },
    addSibling: function(e) {
      e && e.preventDefault();
      this.parent_view.addElement(e);
    },
    changeLayout: function(e) {
      e && e.preventDefault();
      this.parent_view.changeLayout(e);
    },
    switchControls: function(e) {
      e && e.preventDefault();
      vc.unsetHoldActive();
      var $control = $(e.currentTarget),
        $parent = $control.parent(),
        $current;
      $parent.addClass('vc_active');
      $current = $parent.siblings('.vc_active').removeClass('vc_active');
      !$current.hasClass('vc_element') && window.setTimeout(this.holdActive, 500);
    }
  });
  window.InlineShortcodeView_vc_column_text = window.InlineShortcodeView.extend({
    initialize: function(options) {
      window.InlineShortcodeView_vc_column_text.__super__.initialize.call(this, options);
      _.bindAll(this, 'setupEditor', 'updateContent');
    },
    render: function() {
      window.InlineShortcodeView_vc_column_text.__super__.render.call(this);
      // Here
      return this;
    },
    setupEditor: function(ed) {
      ed.on('keyup', this.updateContent)
    },
    updateContent: function() {
      var params = this.model.get('params');
      params.content = tinyMCE.activeEditor.getContent();
      this.model.save({params: params}, {silent: true});
    }
  });
  window.InlineShortcodeView_vc_row = window.InlineShortcodeView.extend({
    column_tag: 'vc_column',
    events: {
      'mouseenter': 'removeHoldActive'
    },
    layout: 1,
    addControls: function() {
      this.$controls = $('<div class="no-controls"></div>');
      this.$controls.appendTo(this.$el);
      return this;
    },
    removeHoldActive: function() {
      vc.unsetHoldActive();
    },
    addColumn: function() {
      vc.builder.create({
        shortcode: this.column_tag,
        parent_id: this.model.get('id')
      }).render();
    },
    addElement: function(e) {
      e && e.preventDefault();
      this.addColumn();
    },
    changeLayout: function(e) {
      e && e.preventDefault();
      this.layoutEditor().render(this.model).show();
    },
    layoutEditor: function() {
      if(_.isUndefined(vc.row_layout_editor)) vc.row_layout_editor = new vc.RowLayoutEditorPanelView({el: $('#vc_row-layout-panel')});
      return vc.row_layout_editor;
    },
    convertToWidthsArray: function(string) {
      return _.map(string.split(/_/), function(c){
        var w = c.split('');
        w.splice(Math.floor(c.length/2), 0, '/');
        return w.join('');
      });
    },
    changed: function() {
      window.InlineShortcodeView_vc_row.__super__.changed.call(this);
      this.addLayoutClass();
    },
    content: function() {
      if(this.$content === false) this.$content = this.$el.find('.vc_container-anchor:first').parent();
      this.$el.find('.vc_container-anchor:first').remove();
      return this.$content;
    },
    addLayoutClass: function() {
      this.$el.removeClass('vc_layout_' + this.layout);
      this.layout = _.reject(vc.shortcodes.where({parent_id: this.model.get('id')}), function(model){return model.get('deleted')}).length;
      this.$el.addClass('vc_layout_' + this.layout);
    },
    convertRowColumns: function(layout, builder) {
      if(!layout) return false;
      var view = this, columns_contents = [], new_model,
        columns = this.convertToWidthsArray(layout);
      vc.layout_change_shortcodes = [];
      vc.layout_old_columns = vc.shortcodes.where({parent_id: this.model.get('id')});
      _.each(vc.layout_old_columns, function(column){
        column.set('deleted' , true);
        columns_contents.push({shortcodes: vc.shortcodes.where({parent_id: column.get('id')}), params: column.get('params')});
      });
      _.each(columns, function(column){
        var prev_settings = columns_contents.shift();
        if(_.isObject(prev_settings)) {
          new_model = builder.create({shortcode: this.column_tag, parent_id: this.model.get('id'), order: vc.shortcodes.nextOrder(), params: _.extend({}, prev_settings.params, {width: column})}).last();
          _.each(prev_settings.shortcodes, function(shortcode){
            shortcode.save({parent_id: new_model.get('id'), order: vc.shortcodes.nextOrder()}, {silent: true});
            vc.layout_change_shortcodes.push(shortcode);
          }, this);
        } else {
          new_model = builder.create({shortcode: this.column_tag, parent_id: this.model.get('id'), order: vc.shortcodes.nextOrder(), params: {width: column}}).last();
        }
      }, this);
      _.each(columns_contents, function(column) {
        _.each(column.shortcodes, function(shortcode){
          shortcode.save({parent_id: new_model.get('id'), order: vc.shortcodes.nextOrder()}, {silent: true});
          vc.layout_change_shortcodes.push(shortcode);
          shortcode.view.rowsColumnsConverted && shortcode.view.rowsColumnsConverted()
        }, this);
      },this);
      builder.render(function(){
        _.each(vc.layout_change_shortcodes, function(shortcode){
          shortcode.trigger('change:parent_id');
          shortcode.view.rowsColumnsConverted && shortcode.view.rowsColumnsConverted();
        });
        _.each(vc.layout_old_columns, function(column){
          column.destroy();
        });
        vc.layout_old_columns = [];
        vc.layout_change_shortcodes = [];
      });
      return columns;
    }
  });
  window.InlineShortcodeView_vc_column = window.InlineShortcodeViewContainerWithParent.extend({
    controls_selector: '#vc_controls-template-vc_column',
    resizeDomainName: 'columnSize',
    _x: 0,
    css_width: 12,
    prepend: false,
    initialize: function(params) {
      window.InlineShortcodeView_vc_column.__super__.initialize.call(this, params);
      _.bindAll(this, 'startChangeSize', 'stopChangeSize', 'resize');
    },
    render: function() {
      var width;
      window.InlineShortcodeView_vc_column.__super__.render.call(this);
      this.prepend = false;
      // Here goes width logic
      $('<div class="vc_resize-bar"></div>')
        .appendTo(this.$el)
        .mousedown(this.startChangeSize);
      this.setColumnClasses();
      this.customCssClassReplace();
      return this;
    },
    destroy: function(e) {
      var parent_id = this.model.get('parent_id');
      window.InlineShortcodeView_vc_column.__super__.destroy.call(this, e);
      if( !vc.shortcodes.where({parent_id: parent_id}).length ) {
        vc.shortcodes.get(parent_id).destroy();
      }
    },
    customCssClassReplace: function() {
      var css_classes, css_regex, class_match;
      css_classes = this.$el.find('.wpb_column').attr('class');
      if(!class_match) return false;
      css_regex = /.*(vc_custom_\d+).*/;
      class_match = css_classes.match(css_regex);
      if(class_match && class_match[1]) {
        this.$el.addClass(class_match[1]);
        this.$el.find('.wpb_column').attr('class', css_classes.replace(class_match[1], '').trim());
      }
    },
    setColumnClasses: function() {
      var offset = this.getParam('offset') || '',
          width = this.getParam('width') || '1/1',
          $content = this.$el.find('> .wpb_column');
      this.css_class_width = this.convertSize(width).replace(/[^\d]/g, '');
      $content.removeClass('vc_col-sm-' + this.css_class_width);
      if(!offset.match(/vc_col\-sm\-\d+/)) {
        this.$el.addClass('vc_col-sm-' + this.css_class_width);
      }
      if(vc.responsive_disabled) {
        offset = offset.replace(/vc_col\-(lg|md|xs)[^\s]*/g, '');
      }
      if(!_.isEmpty(offset)) {
        $content.removeClass(offset);
        this.$el.addClass(offset);
      }
    },
    startChangeSize: function(e) {
      var width = this.getParam(width) || 12;
      this._grid_step = this.parent_view.$el.width() / width;
      vc.frame_window.jQuery('body').addClass('vc_column-dragging').disableSelection();
      this._x = parseInt(e.pageX);
      vc.$page.bind('mousemove.' + this.resizeDomainName, this.resize);
      $(vc.frame_window.document).mouseup(this.stopChangeSize);
    },
    stopChangeSize: function() {
      this._x = 0;
      vc.frame_window.jQuery('body').removeClass('vc_column-dragging').enableSelection();
      vc.$page.unbind('mousemove.' + this.resizeDomainName);
    },
    resize: function(e) {
      var width, old_width, diff, params = this.model.get('params');
      diff = e.pageX - this._x;
      if(Math.abs(diff) < this._grid_step) return;
      this._x = parseInt(e.pageX);
      old_width = '' + this.css_class_width;
      if(diff > 0) {
        this.css_class_width += 1;
      } else if(diff < 0) {
        this.css_class_width -= 1;
      }
      if(this.css_class_width > 12) this.css_class_width = 12;
      if(this.css_class_width < 1) this.css_class_width = 1;
      params.width = vc.getColumnSize(this.css_class_width);
      this.model.save({params: params}, {silent: true});
      this.$el.removeClass('vc_col-sm-' + old_width).addClass('vc_col-sm-' + this.css_class_width);
    },
    convertSize: function(width) {
      var prefix = 'vc_col-sm-',
        numbers = width ? width.split('/') : [1,1],
        range = _.range(1,13),
        num = !_.isUndefined(numbers[0]) && _.indexOf(range, parseInt(numbers[0], 10)) >=0 ? parseInt(numbers[0], 10) : false,
        dev = !_.isUndefined(numbers[1]) && _.indexOf(range, parseInt(numbers[1], 10)) >=0 ? parseInt(numbers[1], 10) : false;
      if(num!==false && dev!==false) {
        return prefix + (12*num/dev);
      }
      return prefix + '12';
    }
  });
  window.InlineShortcodeView_vc_row_inner = window.InlineShortcodeView_vc_row.extend({
    column_tag: 'vc_column_inner'
  });
  window.InlineShortcodeView_vc_column_inner = window.InlineShortcodeView_vc_column.extend({
  });
  window.InlineShortcodeView_vc_tabs = window.InlineShortcodeView_vc_row.extend({
    events: {
      'click > :first > .vc_empty-element': 'addElement',
      'click > :first > .wpb_wrapper > .ui-tabs-nav > li': 'setActiveTab'
    },
    already_build: false,
    active_model_id: false,
    $tabsNav: false,
    active: 0,
    render: function() {
      _.bindAll(this, 'stopSorting');
      this.$tabs = this.$el.find('> .wpb_tabs');
      window.InlineShortcodeView_vc_tabs.__super__.render.call(this);
      this.buildNav();
      return this;
    },
    buildNav: function() {
      var $nav = this.tabsControls();
      this.$tabs.find('> .wpb_wrapper > .vc_element[data-tag="vc_tab"]').each(function(key){
        $('li:eq('+key+')', $nav).attr('data-m-id', $(this).data('model-id'));
      });
    },
    changed: function() {
      if(this.$el.find('.vc_element[data-tag]').length == 0) {
        this.$el.addClass('vc_empty').find('> :first > div').addClass('vc_empty-element');
      } else {
        this.$el.removeClass('vc_empty').find('> :first > div').removeClass('vc_empty-element');
      }
      this.setSorting();
    },
    setActiveTab: function(e) {
      var $tab = $(e.currentTarget);
      this.active_model_id = $tab.data('m-id');
    },
    tabsControls: function() {
      return this.$tabsNav ? this.$tabsNav : this.$tabsNav = this.$el.find('.wpb_tabs_nav');
    },
    buildTabs: function(active_model) {
      if(active_model) {
        this.active_model_id = active_model.get('id');
        this.active = this.tabsControls().find('[data-m-id=' + this.active_model_id +']').index();
      }
      if(this.active_model_id === false) {
        var active_el = this.tabsControls().find('li:first');
        this.active = active_el.index();
        this.active_model_id = active_el.data('m-id');
      }
      if ( ! this.checkCount() ) vc.frame_window.vc_iframe.buildTabs(this.$tabs, this.active);
    },
    checkCount: function() {
      return this.$tabs.find('> .wpb_wrapper > .vc_element[data-tag="vc_tab"]').length != this.$tabs.find('> .wpb_wrapper > .vc_element.vc_vc_tab').length;
    },
    beforeUpdate: function() {
      this.$tabs.find('.wpb_tabs_heading').remove();
      vc.frame_window.vc_iframe.destroyTabs(this.$tabs);
    },
    updated: function() {
      window.InlineShortcodeView_vc_tabs.__super__.updated.call(this);
      this.$tabs.find('.wpb_tabs_nav:first').remove();
      this.buildNav();
      vc.frame_window.vc_iframe.buildTabs(this.$tabs);
      this.setSorting();
    },
    rowsColumnsConverted: function() {
      _.each(vc.shortcodes.where({parent_id: this.model.get('id')}), function(model){
        model.view.rowsColumnsConverted && model.view.rowsColumnsConverted();
      });
    },
    addTab: function(model) {
      if(this.updateIfExistTab(model)) return false;
      var $control = this.buildControlHtml(model),
          $cloned_tab;
      if(model.get('cloned') && ($cloned_tab = this.tabsControls().find('[data-m-id=' + model.get('cloned_from').id + ']')).length) {
        if( ! model.get('cloned_appended') ) {
          $control.appendTo(this.tabsControls());
          model.set('cloned_appended', true);
        }
      } else {
        $control.appendTo(this.tabsControls());
      }
      this.changed();
      return true;
    },
	cloneTabAfter: function(model) {
		this.$tabs.find('> .wpb_wrapper > .wpb_tabs_nav > div').remove();
		this.buildTabs(model);
	},
    updateIfExistTab: function(model) {
      var $tab = this.tabsControls().find('[data-m-id=' + model.get('id') + ']');
      if($tab.length) {
        $tab.find('a').text(model.getParam('title'));
        return true;
      }
      return false;
    },
    buildControlHtml: function(model) {
      var params = model.get('params'),
          $tab =$('<li data-m-id="' + model.get('id') +'"><a href="#tab-' + model.getParam('tab_id') + '"></a></li>');
      $tab.data('model', model);
      $tab.find('> a').text(model.getParam('title'));
      return $tab;
    },
    addElement: function(e) {
      e && e.preventDefault();
      new vc.ShortcodesBuilder()
            .create({shortcode: 'vc_tab', params: {tab_id: vc_guid() + '-' + this.tabsControls().find('li').length, title: this.getDefaultTabTitle()}, parent_id: this.model.get('id')})
            .render();
    },
    getDefaultTabTitle: function() {
      return window.i18nLocale.tab;
    },
    setSorting: function() {
      vc.frame_window.vc_iframe.setTabsSorting(this);
    },
    stopSorting: function(event, ui) {
      this.tabsControls().find('> li').each(function(key, value){
        var model = $(this).data('model');
        model.save({order: key}, {silent: true});
      });
    },
    placeElement: function($view, activity) {
      var model = vc.shortcodes.get($view.data('modelId'));
      if(model && model.get('place_after_id')) {
        $view.insertAfter(vc.$page.find('[data-model-id=' + model.get('place_after_id') + ']'));
        model.unset('place_after_id');
      } else {
        $view.insertAfter(this.tabsControls());
      }
      this.changed();
    },
    removeTab: function(model) {
      if(vc.shortcodes.where({parent_id: this.model.get('id')}).length == 1) return this.model.destroy();
      var $tab = this.tabsControls().find('[data-m-id=' + model.get('id') + ']'),
          index = $tab.index();
      if( this.tabsControls().find('[data-m-id]:eq(' + (index+1) + ')').length) {
        vc.frame_window.vc_iframe.setActiveTab(this.$tabs, (index+1));
      } else if(this.tabsControls().find('[data-m-id]:eq(' + (index-1) + ')').length) {
        vc.frame_window.vc_iframe.setActiveTab(this.$tabs, (index-1));
      } else {
        vc.frame_window.vc_iframe.setActiveTab(this.$tabs, 0);
      }
      $tab.remove();
    },
    clone: function(e) {
      _.each(vc.shortcodes.where({parent_id: this.model.get('id')}), function(model){
        model.set('active_before_cloned', this.active_model_id === model.get('id'));
      }, this);
      window.InlineShortcodeView_vc_tabs.__super__.clone.call(this, e);
    }
  });
  window.InlineShortcodeView_vc_tour = window.InlineShortcodeView_vc_tabs.extend({
    render: function() {
      _.bindAll(this, 'stopSorting');
      this.$tabs = this.$el.find('> .wpb_tour');
      window.InlineShortcodeView_vc_tabs.__super__.render.call(this);
      this.buildNav();
      return this;
    },
    beforeUpdate: function() {
      this.$tabs.find('.wpb_tour_heading,.wpb_tour_next_prev_nav').remove();
      vc.frame_window.vc_iframe.destroyTabs(this.$tabs);
    },
    updated: function() {
      this.$tabs.find('.wpb_tour_next_prev_nav').appendTo(this.$tabs);
      window.InlineShortcodeView_vc_tour.__super__.updated.call(this);
    }
  });
  window.InlineShortcodeView_vc_tab = window.InlineShortcodeViewContainerWithParent.extend({
    controls_selector: '#vc_controls-template-vc_tab',
    render: function() {
      var tab_id, result, active, params;
      params = this.model.get('params');
      window.InlineShortcodeView_vc_tab.__super__.render.call(this);
      this.$tab = this.$el.find('> :first');
      if(!params.tab_id) {
        params.tab_id = vc_guid() + '-' +  Math.floor(Math.random() * 11);
        this.model.save('params', params);
        tab_id = 'tab-' + params.tab_id;
        this.$tab.attr('id', tab_id);
      } else {
        tab_id = this.$tab.attr('id');
      }
      this.$el.attr('id', tab_id);
      this.$tab.attr('id', tab_id + '-real');
      if(!this.$tab.find('.vc_element[data-tag]').length) this.$tab.html('');
      this.$el.addClass('ui-tabs-panel wpb_ui-tabs-hide');
      this.$tab.removeClass('ui-tabs-panel wpb_ui-tabs-hide');
      if(this.parent_view && this.parent_view.addTab) {
        if(!this.parent_view.addTab(this.model))  this.$el.removeClass('wpb_ui-tabs-hide');
      }
      active = this.doSetAsActive();
      this.parent_view.buildTabs(active);
      return this;
    },
    doSetAsActive: function() {
      var active_before_cloned = this.model.get('active_before_cloned');
      if(!this.model.get('from_content') && !this.model.get('default_content') && _.isUndefined(active_before_cloned)){
        return this.model;
      } else if(!_.isUndefined(active_before_cloned)) {
        this.model.unset('active_before_cloned');
        if(active_before_cloned === true) return this.model;
      }
      return false;
     },
    removeView: function(model) {
      window.InlineShortcodeView_vc_tab.__super__.removeView.call(this, model);
      if(this.parent_view && this.parent_view.removeTab) {
        this.parent_view.removeTab(model);
      }
    },
    clone: function(e) {
      _.isObject(e) && e.preventDefault()  && e.stopPropagation();
      vc.clone_index = vc.clone_index / 10;
      var clone = this.model.clone(),
          params = clone.get('params'),
          builder = new vc.ShortcodesBuilder();
      var newmodel = vc.CloneModel(builder, this.model, this.model.get('parent_id'));
	  var active_model = this.parent_view.active_model_id;
	  var that = this;
	  builder.render(function(){
		  if(that.parent_view.cloneTabAfter) {
			  that.parent_view.cloneTabAfter(newmodel);
		  }
	  });


    },
    rowsColumnsConverted: function() {
      _.each(vc.shortcodes.where({parent_id: this.model.get('id')}), function(model){
        model.view.rowsColumnsConverted && model.view.rowsColumnsConverted();
      });
    }
  });
  window.InlineShortcodeView_vc_accordion = window.InlineShortcodeView_vc_row.extend({
    events: {
      'click > .wpb_accordion > .vc_empty-element': 'addElement'
    },
    render: function() {
      _.bindAll(this, 'stopSorting');
      this.$accordion = this.$el.find('> .wpb_accordion');
      window.InlineShortcodeView_vc_accordion.__super__.render.call(this);
      return this;
    },
    changed: function() {
      if(this.$el.find('.vc_element[data-tag]').length == 0) {
        this.$el.addClass('vc_empty').find('> :first').addClass('vc_empty-element');
      } else {
        this.$el.removeClass('vc_empty').find('> .vc_empty-element').removeClass('vc_empty-element');
        this.setSorting();
      }
    },
    buildAccordion: function(active_model) {
      var active = false;
      if(active_model) {
        active = this.$accordion.find('[data-model-id=' + active_model.get('id') +']').index();
      }
      vc.frame_window.vc_iframe.buildAccordion(this.$accordion, active);
    },
    setSorting: function() {
      vc.frame_window.vc_iframe.setAccordionSorting(this);
    },
    beforeUpdate: function() {
      this.$el.find('.wpb_accordion_heading').remove();
      window.InlineShortcodeView_vc_accordion.__super__.beforeUpdate.call(this);
    },
    stopSorting: function() {
      this.$accordion.find('> .wpb_accordion_wrapper > .vc_element[data-tag]').each(function(){
        var model = vc.shortcodes.get($(this).data('modelId'));
        model.save({order: $(this).index()}, {silent: true});
      });
    },
    addElement: function(e) {
      e && e.preventDefault();
      new vc.ShortcodesBuilder()
            .create({shortcode: 'vc_accordion_tab', params: {title: window.i18nLocale.section}, parent_id: this.model.get('id')})
            .render();
    },
    rowsColumnsConverted: function() {
      _.each(vc.shortcodes.where({parent_id: this.model.get('id')}), function(model){
        model.view.rowsColumnsConverted && model.view.rowsColumnsConverted();
      });
    }
  });
  window.InlineShortcodeView_vc_accordion_tab = window.InlineShortcodeView_vc_tab.extend({
    events: {
      'click > .vc_controls .vc_element .vc_control-btn-delete': 'destroy',
      'click > .vc_controls .vc_element .vc_control-btn-edit': 'edit',
      'click > .vc_controls .vc_element .vc_control-btn-clone': 'clone',
      'click > .vc_controls .vc_element .vc_control-btn-prepend': 'prependElement',
      'click > .vc_controls .vc_control-btn-append': 'appendElement',
      'click > .vc_controls .vc_parent .vc_control-btn-delete': 'destroyParent',
      'click > .vc_controls .vc_parent .vc_control-btn-edit': 'editParent',
      'click > .vc_controls .vc_parent .vc_control-btn-clone': 'cloneParent',
      'click > .vc_controls .vc_parent .vc_control-btn-prepend': 'addSibling',
      'click > .wpb_accordion_section > .vc_empty-element': 'appendElement',
      'click > .vc_controls .vc_control-btn-switcher': 'switchControls',
      'mouseenter': 'resetActive',
      'mouseleave': 'holdActive'
    },
    changed: function() {
      if(this.$el.find('.vc_element[data-tag]').length == 0) {
        this.$el.addClass('vc_empty');
        this.content().addClass('vc_empty-element');
      } else {
        this.$el.removeClass('vc_empty');
        this.content().removeClass('vc_empty-element');
      }
    },
    render: function() {
      window.InlineShortcodeView_vc_tab.__super__.render.call(this);
      if(!this.content().find('.vc_element[data-tag]').length) this.content().html('');
      this.parent_view.buildAccordion(!this.model.get('from_content') && !this.model.get('default_content') ? this.model : false);
      return this;
    },
    rowsColumnsConverted: function() {
      _.each(vc.shortcodes.where({parent_id: this.model.get('id')}), function(model){
        model.view.rowsColumnsConverted && model.view.rowsColumnsConverted();
      });
    },
    destroy: function(e) {
      var parent_id = this.model.get('parent_id');
      window.InlineShortcodeView_vc_accordion_tab.__super__.destroy.call(this, e);
      if(!vc.shortcodes.where({parent_id: parent_id}).length) {
        vc.shortcodes.get(parent_id).destroy();
      }
    }
  });
  vc.cloneMethod_vc_tab = function(data, model) {
    data.params = _.extend({}, data.params);
    data.params.tab_id = vc_guid() + '-cl';
    if(!_.isUndefined(model.get('active_before_cloned'))) data.active_before_cloned = model.get('active_before_cloned');
    return data;
  };
  window.InlineShortcodeView_vc_pie = window.InlineShortcodeView.extend({
    render: function() {
      _.bindAll(this, 'parentChanged');
      window.InlineShortcodeView_vc_pie.__super__.render.call(this);
      vc.frame_window.vc_iframe.addActivity(function(){
        this.vc_pieChart();
      });
      return this;
    },
    parentChanged: function() {
      this.$el.find('.vc_pie_chart').removeClass('vc_ready');
      vc.frame_window.vc_pieChart();
    },
    rowsColumnsConverted: function() {
      window.setTimeout(this.parentChanged, 200);
      this.parentChanged();
    }
  });
  window.InlineShortcodeView_vc_images_carousel = window.InlineShortcodeView.extend({
    render: function() {
      var model_id = this.model.get('id');
      window.InlineShortcodeView_vc_images_carousel.__super__.render.call(this);
      vc.frame_window.vc_iframe.addActivity(function(){
        this.vc_iframe.vc_imageCarousel(model_id);
      });
      return this;
    }
  });
  window.InlineShortcodeView_vc_carousel =  window.InlineShortcodeView_vc_images_carousel.extend({});
  window.InlineShortcodeView_vc_gallery = window.InlineShortcodeView.extend({
    render: function() {
      var model_id = this.model.get('id');
      window.InlineShortcodeView_vc_gallery.__super__.render.call(this);
      vc.frame_window.vc_iframe.addActivity(function(){
        this.vc_iframe.vc_gallery(model_id);
      });
      return this;
    }
  });

  window.InlineShortcodeView_vc_posts_slider = window.InlineShortcodeView.extend({
    render: function() {
      var model_id = this.model.get('id');
      window.InlineShortcodeView_vc_posts_slider.__super__.render.call(this);
      vc.frame_window.vc_iframe.addActivity(function(){
        this.vc_iframe.vc_postsSlider(model_id);
      });
      return this;
    }
  });
  window.InlineShortcodeView_vc_toggle = window.InlineShortcodeView.extend({
    render: function() {
      var model_id = this.model.get('id');
      window.InlineShortcodeView_vc_toggle.__super__.render.call(this);
      vc.frame_window.vc_iframe.addActivity(function(){
        this.vc_iframe.vc_toggle(model_id);
      });
      return this;
    }
  });
  window.InlineShortcodeView_vc_flickr = window.InlineShortcodeView.extend({
    render: function() {
      window.InlineShortcodeView_vc_flickr.__super__.render.call(this);
      var $placeholder = this.$el.find('.vc_flickr-inline-placeholder');
      vc.frame_window.vc_iframe.addActivity(function(){
        this.vc_iframe.vc_Flickr($placeholder);
      });
      return this;
    }
  });
  window.InlineShortcodeView_vc_raw_js = window.InlineShortcodeView.extend({
    render: function() {
      window.InlineShortcodeView_vc_raw_js.__super__.render.call(this);
      var script = this.$el.find('.vc_js_inline_holder').val();
      this.$el.find('.wpb_wrapper').html(script);
      return this;
    }
  });

  vc.addTemplateFilter(function (string) {
    var random_id = VCS4() + '-' + VCS4();
    return string.replace(/tab\_id\=\"([^\"]+)\"/g, 'tab_id="$1' + random_id + '"');
  });
	window.InlineShortcodeView_vc_basic_grid = vc.shortcode_view.extend({
		render:function (e) {
			window.InlineShortcodeView_vc_basic_grid.__super__.render.call(this, e);
			var model_id = this.model.get('id');
			vc.frame_window.vc_iframe.addActivity(function(){
              vc.frame_window.vc_iframe.gridInit(model_id);
			});
			return this;
		}
	});
	window.InlineShortcodeView_vc_masonry_grid = window.InlineShortcodeView_vc_basic_grid.extend();
	window.InlineShortcodeView_vc_media_grid = window.InlineShortcodeView_vc_basic_grid.extend();
	window.InlineShortcodeView_vc_masonry_media_grid = window.InlineShortcodeView_vc_basic_grid.extend();
})(window.jQuery);