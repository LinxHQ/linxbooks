/* =========================================================
 * vc.js v1.0.1
 * =========================================================
 * Copyright 2013 Wpbakery
 *
 * Visual composer Frontend backbone/underscore version
 * ========================================================= */
/**
 * Create Unique id for records in storage.
 * Generate a pseudo-GUID by concatenating random hexadecimal.
 * @return {String}
 */
function vc_guid() {
  return (VCS4() + VCS4() + "-" + VCS4());
}

// Generate four random hex digits.
function VCS4() {
  return (((1 + Math.random()) * 0x10000) | 0).toString(16).substring(1);
}
if(_.isUndefined(vc)) var vc = {};
_.extend(vc, {
  no_title_placeholder: '(no title)',
  responsive_disabled: false,
  template_options:{
    evaluate:    /<#([\s\S]+?)#>/g,
    interpolate: /\{\{\{([\s\S]+?)\}\}\}/g,
    escape:      /\{\{([^\}]+?)\}\}(?!\})/g
  },
  post_id: '',
  activity: false,
  clone_index: 1,
  loaded: false,
  path: '',
  admin_ajax: window.ajaxurl,
  filters:{templates:[]},
  title: '',
  $title: false,
  update_title: false,
  $hold_active: false,
  data_changed: false,
  setDataChanged: function() {
    window.jQuery(window).bind('beforeunload.vcSave', function(e){
      return window.i18nLocale.confirm_to_leave;
    });
    this.data_changed = true;
  },
  unsetDataChanged: function() {
    window.jQuery(window).unbind('beforeunload.vcSave');
    this.data_changed = false;
  },
  addTemplateFilter:function (callback) {
    if (_.isFunction(callback)) this.filters.templates.push(callback);
  },
  unsetHoldActive: function() {
    if(this.$hold_active) {
      this.$hold_active.removeClass('vc_hold-active');
      this.$hold_active = false;
    }
  }
});
(function ($) {
  "use strict";
  vc.map = {};
  vc.setFrameSize = function(size) {
    var $vc_navbar = $('#vc_navbar');
    var height = $(window).height() - $vc_navbar.height();
    vc.$frame.width(size);
    vc.$frame_wrapper.css({top: $vc_navbar.height()});
    vc.$frame.height(height);
    // vc.$frame.height(vc.$frame.contents() ? vc.$frame.contents().height() : 1000);
  };
  vc.getDefaults = function (tag) {
    var defaults = {},
      params = _.isArray(vc.getMapped(tag).params) ? vc.getMapped(tag).params : [];
    _.each(params, function (param) {
      if(_.isObject(param)) {
        if(!_.isUndefined(param.std)) {
          defaults[param.param_name] = param.std;
        } else if (!_.isUndefined(param.value)) {
			if( vc.atts[param.type] && vc.atts[param.type].defaults ) {
				defaults[param.param_name] = vc.atts[param.type].defaults(param);
			} else if (_.isObject(param.value) && !_.isArray(param.value) && !_.isString(param.value) ) {
				defaults[param.param_name] = _.values(param.value)[0];
			} else if ( _.isArray(param.value) ) {
				defaults[param.param_name] = param.value[0];
			} else {
				defaults[param.param_name] = param.value;
			}
        }
      }
    });
    return defaults;
  };
  vc.buildRelevance = function () {
    vc.shortcode_relevance = {};
    _.each(vc.map, function (object) {

      if (_.isObject(object.as_parent) && _.isString(object.as_parent.only)) {
        vc.shortcode_relevance['parent_only_' + object.base] = object.as_parent.only.replace(/\s/, '').split(',');
      }
      if (_.isObject(object.as_parent) && _.isString(object.as_parent.except)) {
        vc.shortcode_relevance['parent_except_' + object.base] = object.as_parent.except.replace(/\s/, '').split(',');
      }
      if (_.isObject(object.as_child) && _.isString(object.as_child.only)) {
        vc.shortcode_relevance['child_only_' + object.base] = object.as_child.only.replace(/\s/, '').split(',');
      }
      if (_.isObject(object.as_child) && _.isString(object.as_child.except)) {
        vc.shortcode_relevance['child_except_' + object.base] = object.as_child.except.replace(/\s/, '').split(',');
      }
    });
    /**
     * Check parent/children relationship between two tags
     * @param tag
     * @param related_tag
     * @return boolean - Returns true if relevance is positive
     */
    vc.checkRelevance = function (tag, related_tag) {
      if (_.isArray(vc.shortcode_relevance['parent_only_' + tag]) && !_.contains(vc.shortcode_relevance['parent_only_' + tag], related_tag)) {
        return false;
      }
      if (_.isArray(vc.shortcode_relevance['parent_except_' + tag]) && _.contains(vc.shortcode_relevance['parent_except_' + tag], related_tag)) {
        return false;
      }
      if (_.isArray(vc.shortcode_relevance['child_only_' + related_tag]) && !_.contains(vc.shortcode_relevance['child_only_' + related_tag], tag)) {
        return false;
      }
      if (_.isArray(vc.shortcode_relevance['child_except_' + related_tag]) && _.contains(vc.shortcode_relevance['child_except' + related_tag], tag)) {
        return false;
      }
      return true;
    };
  };

  vc.CloneModel = function (builder, model, parent_id, child_of_clone) {
    // vc.clone_index = vc.clone_index / 10;
    var new_order = _.isBoolean(child_of_clone) && child_of_clone === true ? model.get('order') : parseFloat(model.get('order')) + 1,
        params = _.extend({}, model.get('params')),
        tag = model.get('shortcode'),
        data = {
          shortcode: tag,
          parent_id: parent_id,
          order:new_order,
          cloned:true,
          cloned_from: model.toJSON(),
          params: params
        };
    if(vc['cloneMethod_' + tag]) data = vc['cloneMethod_' + tag](data, model);
    if(!_.isBoolean(child_of_clone) || child_of_clone !== true) data.place_after_id = model.get('id');
    builder.create(data);
    var new_model = builder.last();
    // if(!_.isBoolean(child_of_clone) || child_of_clone !== true) model.view.$el.addClass('vc_place-after');
    _.each(vc.shortcodes.where({parent_id:model.get('id')}), function (shortcode) {
      vc.CloneModel(builder, shortcode, new_model.get('id'), true);
    }, this);
    return new_model;
  };
  vc.getColumnSize = function (column) {
    var mod = 12%column,
        is_odd = function(n) {
          return _.isNumber(n) && (n % 2 == 1);
        };
    if(mod > 0 && is_odd(column) && column%3) {
      return column + '/' + 12;
    }
    if(mod == 0) mod = column;
    return column/mod + '/' + (12/mod);
  };
  vc.showMessage = function(message) {
    if(vc.message_timeout) {
      $('.vc_message').remove();
      window.clearTimeout(vc.message_timeout);
    }
    var $message = $('<div class="vc_message success" style="z-index: 999;">' + message + '</div>').prependTo($('body'));
    $message.fadeIn(500);
    vc.message_timeout = window.setTimeout(function(){
      $message.slideUp(500, function(){$(this).remove();});
      vc.message_timeout = false;
    }, 5500);
  };
  window.InlineShortcodeView = vc.shortcode_view = Backbone.View.extend({
    hold_hover_on: false,
    events: {
      'click > .vc_controls .vc_control-btn-delete': 'destroy',
      'click > .vc_controls .vc_control-btn-edit': 'edit',
      'click > .vc_controls .vc_control-btn-clone': 'clone',
      'mousemove': 'checkControlsPosition'
      //'mousemove': 'setMove',
      // 'mouseenter': 'resetControlPosition',
      // 'mouseleave': 'mouseLeave'
      // 'mouseover .vc_control-btn': 'holdHover',
      // 'mouseout .controls-cc': 'releaseHover'
    },
    controls_set: false,
    $content: false,
    move_timeout: false,
    out_timeout: false,
    hold_active: true,
    builder: false,
    default_controls_template: false,
    initialize: function() {
      // _.bindAll(this, 'setControlPosition', 'unsetControlPosition');
      this.listenTo(this.model, 'destroy', this.removeView);
      this.listenTo(this.model, 'change:params', this.update);
      this.listenTo(this.model, 'change:parent_id', this.changeParentId);
    },
    render: function() {
      this.$el.attr('data-model-id', this.model.get('id'));
      this.$el.attr('data-tag', this.model.get('shortcode'));
      this.$el.addClass('vc_' + this.model.get('shortcode'));
      this.addControls();
      if(_.isBoolean(vc.getMapped(this.model.get('shortcode')).is_container) && vc.getMapped(this.model.get('shortcode')).is_container) this.$el.addClass('vc_container-block');
      this.changed();
      return this;
    },
    checkControlsPosition: function() {
      if(!this.$controls_buttons) return;
      var window_top, control_top, element_position_top, new_position,
        element_height = this.$el.height(),
        frame_height = vc.$frame.height();
      if(element_height > frame_height) {
        window_top = $(vc.frame_window).scrollTop();
        control_top = this.$controls_buttons.offset().top;
        element_position_top = this.$el.offset().top;
        new_position =  (window_top - element_position_top) + vc.$frame.height()/2;
        if(new_position > 40 && new_position < element_height) {
          this.$controls_buttons.css('top',  new_position);
        } else if(new_position > element_height) {
          this.$controls_buttons.css('top',  element_height - 40);

        } else {
          this.$controls_buttons.css('top',  40);
        }
      }
    },
    beforeUpdate: function() {},
    updated: function() {
      _.each(vc.shortcodes.where({parent_id: this.model.get('id')}), function(model){
        model.view.parent_view = this;
        model.view.parentChanged();
      }, this);
    },
    parentChanged: function() {
      this.checkControlsPosition();
    },
    rendered: function() {},
    addControls: function() {
      var $controls_el = $('#vc_controls-template-' + this.model.get('shortcode'));
      var template = $controls_el.length ? $controls_el.html() : this._getDefaultTemplate(),
        parent = vc.shortcodes.get(this.model.get('parent_id')),
        data = {
          name: vc.getMapped(this.model.get('shortcode')).name,
          tag: this.model.get('shortcode'),
          parent_name: parent ? vc.getMapped(parent.get('shortcode')).name : '',
          parent_tag: parent ? parent.get('shortcode') : ''
        };
      this.$controls = $(_.template(template, data, vc.template_options).trim()).addClass('vc_controls');
      this.$controls.appendTo(this.$el);
      this.$controls_buttons = this.$controls.find('> :first');
    },
    content: function() {
      if(this.$content === false) this.$content = this.$el.find('> :first');
      return this.$content;
    },
    changeParentId: function() {
      var parent_id = this.model.get('parent_id'), parent;
      vc.builder.notifyParent(this.model.get('parent_id'));
      if(parent_id === false) {
        app.placeElement(this.$el);
      } else {
        parent = vc.shortcodes.get(parent_id);
        parent && parent.view && parent.view.placeElement(this.$el);
      }
      this.parentChanged();
    },
    _getDefaultTemplate: function() {
      if(_.isUndefined(this.default_controls_template) || ! this.default_controls_template ) {
        this.default_controls_template = $('<div><div>').html($('#vc_controls-template-default').html());
        //Filter controls due to '$control_list' data
        var controls = this.$el.data('shortcode-controls');
        if( !_.isUndefined(controls) ) {
          $('.vc_control-btn[data-control]', this.default_controls_template).each(function(){
            if( $.inArray($(this).data('control'),controls) == -1 ) {
              $(this).remove();
            }
          });
        }
      }

      return this.default_controls_template.html();
    },
    changed: function(){
      this.$el.removeClass('vc_empty-shortcode-element');
      this.$el.height()===0 && this.$el.addClass('vc_empty-shortcode-element');
    },
    edit: function(e) {
      _.isObject(e) && e.preventDefault() && e.stopPropagation();
      if ( !vc.active_panel || vc.active_panel.model.get('id') != this.model.get('id') ) {
        vc.closeActivePanel();
        vc.edit_element_block_view.render(this.model);
      }
    },
    destroy: function(e) {
      _.isObject(e) && e.preventDefault() && e.stopPropagation();
      var answer = confirm(window.i18nLocale.press_ok_to_delete_section);
      if (true !== answer) return false;
      vc.showMessage(window.sprintf(window.i18nLocale.inline_element_deleted, this.model.setting('name')));
      this.model.destroy();
    },
    removeView: function(model) {
      this.remove();
      vc.setDataChanged();
      vc.builder.notifyParent(this.model.get('parent_id'));
      vc.closeActivePanel(model);
      vc.setFrameSize();
    },
    update: function() {
      this.beforeUpdate();
      vc.builder.update(this.model);
    },
    clone: function(e) {
      var new_model, builder = new vc.ShortcodesBuilder();
      _.isObject(e) && e.preventDefault()  && e.stopPropagation();
      if(this.builder && !this.builder.is_build_complete) return false;
      this.builder = builder;
      new_model = vc.CloneModel(builder, this.model, this.model.get('parent_id'));
      builder.setResultMessage(window.sprintf(window.i18nLocale.inline_element_cloned, new_model.setting('name'), new_model.get('id')));
      builder.render();
    },
    getParam: function(param_name) {
      return _.isObject(this.model.get('params')) && !_.isUndefined(this.model.get('params')[param_name]) ? this.model.get('params')[param_name] : null;
    },
    placeElement: function($view, activity) {
      var model = vc.shortcodes.get($view.data('modelId'));
      if(model && model.get('place_after_id')) {
        $view.insertAfter(vc.$page.find('[data-model-id=' + model.get('place_after_id') + ']'));
        model.unset('place_after_id');
      } else if(_.isString(activity) && activity === 'prepend') {
        $view.prependTo(this.content());
      } else {
        $view.appendTo(this.content());
      }
      this.changed();
    }
  });
  vc.FrameView = Backbone.View.extend({
    events: {
      // 'keypress .entry-title': 'updateKeyPress',
      'click .vc_add-element-action': 'addElement',
      'click #vc_no-content-add-text-block': 'addTextBlock',
      'click #vc_templates-more-layouts': 'openTemplatesWindow',
      'click .vc_template[data-template_unique_id] > .wpb_wrapper':'loadDefaultTemplate'

    },
	  openTemplatesWindow: function(e) {
      vc.app.openTemplatesWindow.call(this,e);
    },
    updateKeyPress: function(e) {
      if(e.which===13) {
        e.preventDefault();
        vc.$title.attr('contenteditable', false);
        $('.entry-content').trigger('click');
        return false;
      }
    },
    loadDefaultTemplate: function(e) {
      e && e.preventDefault();
      vc.templates_panel_view.loadTemplate(e);
      $("#vc_no-content-helper").remove();
    },
    setTitle: function(title) {
      if(vc.$title.length) {
        vc.$title.text(title || vc.no_title_placeholder);
      }
      vc.title = title;
      vc.update_title = true;
    },
    initialize: function() {
      vc.frame_window = vc.$frame.get(0).contentWindow;
    },
    setActiveHover: function(e) {
      if(this.$hover_element) this.$hover_element.removeClass('vc_hover');
      this.$hover_element = $(e.currentTarget).addClass('vc_hover');
      e.stopPropagation();
    },
    unsetActiveHover: function(e) {
      if(this.$hover_element) this.$hover_element.removeClass('vc_hover');
    },
    setSortable: function() {
      vc.frame_window.vc_iframe.setSortable(vc.app);
    },
    render: function() {
      vc.$title = $(vc.$frame.get(0).contentWindow.document).find('h1:contains(' + ( vc.title || vc.no_title_placeholder ) + ')');
      vc.$title.click(function(e){
        e.preventDefault();
        vc.post_settings_view.render().show();
      });
      return this;
    },
    noContent: function(no) {
      vc.frame_window.vc_iframe.showNoContent(no);
    },
    addElement: function(e) {
      e && e.preventDefault && e.preventDefault();
      vc.add_element_block_view.render(false);
    },
    addTextBlock: function(e) {
      e && e.preventDefault && e.preventDefault();
      var builder = new vc.ShortcodesBuilder();
      builder.create({shortcode: 'vc_row'})
        .create({shortcode: 'vc_column', parent_id: builder.lastID(), params: {width: '1/1'}})
        .create({shortcode: 'vc_column_text', parent_id: builder.lastID(), params: vc.getDefaults('vc_column_text')})
        .render();
      vc.edit_element_block_view.render(builder.last());
    },
    scrollTo: function(model) {
      vc.frame_window.vc_iframe.scrollTo(model.get('id'));
    },
    addInlineScript: function(script) {
      return vc.frame_window.vc_iframe.addInlineScript(script);
    },
    addInlineScriptBody: function(script) {
        return vc.frame_window.vc_iframe.addInlineScriptBody(script);
    }
  });
  vc.View = Backbone.View.extend({
    el: $('body'),
    mode: 'view',
    current_size: '100%',
    events:{
      'click #vc_add-new-row':'createRow',
      'click #vc_add-new-element':'addElement',
      'click #vc_post-settings-button': 'editSettings',
      // 'click .vc_mode-control': 'switchMode',
      //'click #vc_templates-editor-button': 'openTemplatesEditor', // @deprecated use openTemplatesModal
      'click #vc_templates-editor-button': 'openTemplatesWindow',
      'click #vc_guides-toggle-button': 'toggleMode',
      'click #vc_button-cancel': 'cancel',
      'click #vc_button-edit-admin': 'cancel',
      'click #vc_button-update': 'save',
      'click #vc_button-save-draft, #vc_button-save-as-pending': 'save',
      'click .vc_screen-width': 'resizeFrame',
      'click .vc_edit-cloned': 'editCloned'
    },
    initialize: function() {
      _.bindAll(this, 'saveRowOrder', 'saveElementOrder', 'saveColumnOrder', 'resizeWindow');
      // vc.shortcodes.bind('add', this.addShortcode, this);
      // vc.shortcodes.bind('reset', this.addAll, this);
    },
    render: function() {
      vc.updateSettingsBadge();
      vc.$page = $(vc.$frame.get(0).contentWindow.document).find('#vc_inline-anchor').parent();
      vc.$frame_body = $(vc.$frame.get(0).contentWindow.document).find('body').addClass('vc_editor');
      this.setMode('compose');
      this.$size_control = $('#vc_screen-size-control');
      $(".vc_element-container", vc.frame_window.document).droppable({ accept: ".vc_element_button" });
      $(window).resize(this.resizeWindow);
      /*
      $('.vc_element_button').draggable({
        // iframeFix: true,
        helper: 'clone',
        revert: true,
        cursor:"move",
        start: function(event, ui) {
          vc.frame_window.vc_iframe.initDroppable();
        },
        stop: function(event, ui) {
          vc.frame_window.vc_iframe.killDroppable();
        }
        // connectToSortable: vc.frame_window.jQuery('.vc_element-container')
      });
      */
      // vc.shortcodes.fetch({reset: true});
      /*
      if(getCookie('vc_inline_mode')) {
        var mode = getCookie('vc_inline_mode');
        this.$el.find('.vc_mode-control').removeClass('active');
        this.$el.find('.vc_mode-control[data-mode=' + mode +']').addClass('active');
        this.setMode(mode);
      } else {
        this.$el.find('.vc_mode-control[data-mode=' + this.mode +']').addClass('active');
      }
      */
      return this;
    },
    cancel: function(e) {
      _.isObject(e) && e.preventDefault();
      window.location.href = $(e.currentTarget).data('url');
    },
    save: function(e) {
      _.isObject(e) && e.preventDefault();
      vc.builder.save($(e.currentTarget).data('changeStatus'));
    },
    resizeFrame: function(e) {
      var $control = $(e.currentTarget), current;
      e.preventDefault();
      if($control.hasClass('active')) return false;
      this.$size_control.find('.active').removeClass('active');
      $('#vc_screen-size-current').attr('class', 'vc_icon ' + $control.attr('class'));
      this.current_size = $control.data('size');
      $control.addClass('active');
      vc.setFrameSize(this.current_size);
    },
    editCloned: function(e) {
      e && e.preventDefault();
      var $control = $(e.currentTarget),
          model_id = $control.data('modelId'),
          model = vc.shortcodes.get(model_id);
      vc.edit_element_block_view.render(model);
    },
    resizeWindow: function() {
      vc.setFrameSize(this.current_size);
    },
    switchMode: function(e) {
      var $control = $(e.currentTarget);
      e && e.preventDefault();
      this.setMode($control.data('mode'));
      // setCookie('vc_inline_mode', this.mode);
      $control.siblings('.vc_active').removeClass('vc_active');
      $control.addClass('vc_active');
    },
    toggleMode: function(e) {
      var $control = $(e.currentTarget);
      e && e.preventDefault();
      if(this.mode === 'compose') {
        $control.addClass('vc_off').text(window.i18nLocale.guides_off);
        this.setMode('view');
      } else {
        $control.removeClass('vc_off').text(window.i18nLocale.guides_on);
        this.setMode('compose');
      }
    },
    setMode: function(mode) {
      var $body = $('body').removeClass(this.mode + '-mode');
      vc.$frame_body.removeClass(this.mode + '-mode');
      this.mode = mode;
      $body.addClass(this.mode + '-mode');
      vc.$frame_body.addClass(this.mode + '-mode');
    },
    placeElement: function($view, activity) {
      var model = vc.shortcodes.get($view.data('modelId'));
      if(model && model.get('place_after_id')) {
        $view.insertAfter(vc.$page.find('[data-model-id=' + model.get('place_after_id') + ']'));
        model.unset('place_after_id');
      } else if(_.isString(activity) && activity === 'prepend') {
        $view.prependTo(vc.$page);
      } else {
        $view.insertBefore(vc.$page.find('#vc_no-content-helper'));
      }
    },
    addShortcodes: function(models) {
      _.each(models, function(model){
        this.addShortcode(model);
        this.addShortcodes(vc.shortcodes.where({parent_id: model.get('id')}));
      }, this);
    },
    createShortcodeHtml: function(model) {
      var $template = $('#vc_template-' + model.get('shortcode')),
        template = $template.length ? $template.html() : '<div class="vc_block"></div>';
      return $(_.template(template, model.toJSON(), vc.template_options).trim());
    },
    addAll: function(models) {
      this.addShortcodes(models.where({parent_id: false}));
    },
    createRow: function(e) {
     _.isObject(e) && e.preventDefault();
      // e.stopPropagation();
      var builder = new vc.ShortcodesBuilder();
      builder
        .create({shortcode: 'vc_row'})
        .create({shortcode: 'vc_column', parent_id: builder.lastID(), params: {width: '1/1'}})
        .render();
    },
    addElement: function(e) {
      e && e.preventDefault();
      vc.add_element_block_view.render(false);
    },
    editSettings: function(e) {
      e && e.preventDefault();
      vc.post_settings_view.render().show();
    },
    /**
     * @deprecated Since 4.4 use openTemplatesWindow
     * @param e
     */
    openTemplatesEditor: function(e) {
      e && e.preventDefault && e.preventDefault();
      vc.templates_editor_view.render().show();
    },
    openTemplatesWindow: function(e) {
      e && e.preventDefault && e.preventDefault();
      vc.templates_panel_view.render().show();
    },
    setFrameSize: function() {
      vc.setFrameSize();
    },
    dropButton: function() {
    },
    saveRowOrder: function() {
      _.defer(function (app) {
        var $rows = vc.$page.find('> [data-tag=vc_row]'),
            builder = new vc.ShortcodesBuilder(),
            place_after_id, row_data;
        $rows.each(function (key, value) {
          var $this = $(this);
          if($this.is('.droppable')) {
            $this.remove();
            var row_data = {shortcode: 'vc_row', order: key};
            if(key === 0) {
              vc.activity = 'prepend';
            } else if(key+1 != $rows.length) {
              // vc.$page.find('> [data-tag=vc_row]:eq(' + (key - 1) +')').addClass('vc_place-after')
              row_data.place_after_id = vc.$page.find('> [data-tag=vc_row]:eq(' + (key - 1) +')').data('modelId');
            }
            builder
              .create(row_data)
              .create({shortcode: 'vc_column', parent_id: builder.lastID(), params: {width: '1/1'}})
              .render();
          } else {
            vc.shortcodes.get($this.data('modelId')).save({'order':key}, {silent: true});
          }

        });
	    vc.setDataChanged();
      }, this);
    },
    saveElementOrder: function(event, ui) {
      _.defer(function(app, e, ui) {
        if(_.isNull(ui.sender)) {
          var $column = ui.item.parent(),
              $elements = $column.find('> [data-model-id]');
          $column.find('> [data-model-id]').each(function(key, value){
            var $element = $(this),
                model, prev_parent, current_parent, prepend = false;
            if($element.is('.droppable')) {
              current_parent = vc.shortcodes.get($column.parents('.vc_element[data-tag]:first').data('modelId'));
              $element.remove();
              if(key === 0) {
                prepend = true;
              } else if(key+1 != $elements.length) {
                prepend = $column.find('> [data-tag]:eq(' + (key - 1) +')').data('modelId');
                // $column.find('> [data-tag]:eq(' + (key - 1) +')').addClass('vc_place-after');
              }
              if(current_parent) vc.add_element_block_view.render(current_parent, prepend);
            } else {
              model = vc.shortcodes.get($element.data('modelId'));
              prev_parent = model.get('parent_id');
              current_parent = $column.parents('.vc_element[data-tag]:first').data('modelId');
              model.save({order: key, parent_id: current_parent}, {silent: true});

              if(prev_parent!==current_parent) {
                vc.builder.notifyParent(current_parent);
                vc.builder.notifyParent(prev_parent);
              }
            }

          });
        }
	    vc.setDataChanged();
      }, this, event, ui);
    },
    saveColumnOrder: function(event, ui) {
      _.defer(function(app, e, ui){
        var row = ui.item.parent();
        row.find('> [data-model-id]').each(function(){
          var $element = $(this),
              index = $element.index();
          vc.shortcodes.get($element.data('modelId')).save({order: index});
        });
      }, this, event, ui);
	  vc.setDataChanged();
    }
  });
})(window.jQuery);