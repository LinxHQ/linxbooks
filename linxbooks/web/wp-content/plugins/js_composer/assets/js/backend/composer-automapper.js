/* =========================================================
 * composer-automapper.js v0.2.1
 * =========================================================
 * Copyright 2013 Wpbakery
 *
 * Visual composer automapper for shortcodes
 * ========================================================= */
var vc_am = {
  current_form: false
};
(function ($) {
  "use strict";
  _.extend( wp.shortcode.prototype, {
    taggedString: function() {
      var text    = '[<span class="vc_preview-tag">' + this.tag + '</span>';

      _.each( this.attrs.numeric, function( value ) {
        if ( /\s/.test( value ) ) {
          text += ' <span class="vc_preview-param">"' + value + '"</span>';
        } else {
          text += ' <span class="vc_preview-param">' + value + '</span>';
        }
      });

      _.each( this.attrs.named, function( value, name ) {
        text += ' <span class="vc_preview-param">' + name + '="' + value + '"</span>';
      });

      // If the tag is marked as `single` or `self-closing`, close the
      // tag and ignore any additional content.
      if ( 'single' === this.type ) {
        return text + ']';
      } else if ( 'self-closing' === this.type ) {
        return text + ' /]';
      }

      // Complete the opening tag.
      text += ']';

      if ( this.content ) {
        text += '<span class="vc_preview-content">' + this.content + '</span>';
      }

      // Add the closing tag.
      return text + '[/<span class="vc_preview-tag">' + this.tag + '</span>]';
    }});
  wp.shortcode.atmPreview = function(options) {
    return new wp.shortcode( options ).taggedString();
  };
  var message_timer, show_message = function(text, type) {
    if(message_timer) {
      window.clearTimeout(message_timer);
      $('.vc_settings-automapper').remove();
      message_timer = false;
    }
    var $message = $('<div class="vc_atm-message updated' + (type ? ' vc_message-' + type : '') + '" style="display: none;"></div>');
    $message.text(text);
    $message.prependTo($('#vc_settings-automapper')).fadeIn(500, function(){
        var $message = $(this);
        window.setTimeout(function(){
          $message.remove();
        }, 2000);
      });
    },
    template_options = {
        evaluate:    /<#([\s\S]+?)#>/g,
        interpolate: /\{\{\{([\s\S]+?)\}\}\}/g,
        escape:      /\{\{([^\}]+?)\}\}(?!\})/g
    },
    to_title = function(string) {
      string = string.replace(/_|-/, ' ');
      return string.charAt(0).toUpperCase() + string.slice(1);
    };
  var request_url = window.ajaxurl + '?vc_action=automapper',
      sync_callback = function(method, model, options) {
        var data;
        if(method === 'create') {
          model.set('id', window.vc_guid());
          data = {
            vc_action: 'create',
            data: model.toJSON()
          };
        } else if(method === 'update') {
          data = {
            vc_action: 'update',
            id: model.get('id'),
            data: model.toJSON()
          };
        } else if(method === 'delete') {
          data = {
            vc_action: 'delete',
            id: model.get('id')
          };
        } else {
          data = {
            vc_action: 'read'
          };
        }
        $.ajax({
          method: 'POST',
          url: request_url,
          dataType: 'json',
          data:_.extend(data, {action: 'vc_automapper'}),
          context: this
        }).done(function(data){
            var result = model;
            if(data && method === 'read') result =  data;
            // Response
            if (result) {
              (method === 'read') && options.success(result);
            } else {
              options.error("Not found");
            }
          }).error(function(data){
          });
      };
  var ShortcodeModel = Backbone.Model.extend({
    defaults:function () {
      return {
        tag: '',
        name: '',
        category: '',
        description: '',
        params: []
      };
    },
    sync: sync_callback
  });
  var ShortcodesCollection = Backbone.Collection.extend({
    model: ShortcodeModel,
    sync: sync_callback
  });
  vc_am.shortcodes = new ShortcodesCollection;

  var ShortcodeView = Backbone.View.extend({
    tagName: 'li',
    // className: 'vc_automapper-item',
    className: 'widget',
    events: {
      'click .vc_automapper-edit-btn': 'edit',
      'click h4, widget-action': 'edit',
      'click .vc_automapper-delete-btn': 'clear'
    },
    template_html: $('#vc_automapper-item-tpl').html() || '<span>{{ tag }}</span>',
    initialize: function() {
      this.listenTo(this.model, 'change', this.render);
      this.listenTo(this.model, 'destroy', this.removeView)
    },
    render: function() {
      this.$el.html(_.template(this.template_html, this.model.toJSON(), template_options)).attr('data-item-id', this.model.get('id'));
      return this;
    },
    edit: function(e) {
      e && e.preventDefault();
      new EditFormView({model: this.model}).render();
    },
    clear: function(e) {
      e && e.preventDefault();
      if(confirm(window.i18nLocaleVcAutomapper.are_you_sure_delete)) {
        this.model.destroy();
      }
    },
    removeView: function() {
      this.$el.remove();
    }
  });
  var FormView = Backbone.View.extend({
    render: function() {
      vc_am.current_form && vc_am.current_form.close();
      vc_am.current_form = this;
      return this;
    },
    getType: function() {
      return 'form';
    },
    validate: function(attrs) {
      var result = false;
      if(!attrs.name) {
        return window.i18nLocaleVcAutomapper.error_shortcode_name_is_required;
      }
      if (!attrs.tag || !attrs.tag.match(/^\S+$/)) {
        return window.i18nLocaleVcAutomapper.error_enter_valid_shortcode_tag;
      }
      var fields_required = ['param_name', 'heading', 'type'];
      _.each(attrs.params, function(param){
        _.each(fields_required, function(field){
          if(param[field] === '') {
            result = window.i18nLocaleVcAutomapper.error_enter_required_fields // '';
          } else if(field == 'param_name' && !param[field].match(/^[a-z0-9_]+$/g)) {
            result = window.i18nLocaleVcAutomapper.error_enter_required_fields;
          }
        }, this);
      }, this);
      return result || null;
    },
    isValid: function (data) {
      this.validationError = this.validate(data);
      return this.validationError ? false : true;
    },
    close: function(e) {
      e && e.preventDefault();
      vc_am.current_form = false;
      this.remove();
    }
  });
  var ComplexShortcodeView = Backbone.View.extend({
    _$widget_title: false,
    _$form_view: false,
    edit_view: false,
    tagName: 'li',
    className: 'widget',
    events: {
      'click .vc_automapper-edit-btn': 'edit',
      'click h4, .widget-action': 'edit'
    },
    template_html: $('#vc_automapper-item-complex-tpl').html() || '<span>{{ tag }}</span>',
    header_template_html: '<h4>{{ name }}<span class="in-widget-title"></span></h4>',
    initialize: function() {
      _.bindAll(this, 'removeEditForm');
      // this.listenTo(this.model, 'change', this.renderTitle);
      this.listenTo(this.model, 'destroy', this.removeView);
      this.model.view = this;
    },
    render: function() {
      this.$el.html(_.template(this.template_html, this.model.toJSON(), template_options)).attr('data-item-id', this.model.get('id'));
      return this;
    },
    renderTitle: function() {
      this.$widgetTitle().html(_.template(this.header_template_html, this.model.toJSON(), template_options));
    },
    edit: function(e) {
      e && e.preventDefault();
      if(this.$editForm().is(':animated')) return false;
      this.$el.addClass('vc_opened');
      if(this.edit_view) {
        this.close();
      } else {
        this.edit_view = new EditFormInnerView({model: this.model}).render();
      }
    },
    $widgetTitle: function() {
      if(!this._$widget_title) this._$widget_title = this.$el.find('.widget-title');
      return this._$widget_title;
    },
    $editForm: function() {
      if(!this._$edit_form) this._$edit_form = this.$el.find('.widget-inside');
      return this._$edit_form;
    },
    removeEditForm: function() {
      this.edit_view && this.edit_view.remove();
      this.edit_view = false;
    },
    beforeSave: function() {
      this.$el.find('#vc_atm-name').val($('#vc_atm-header-name').val());
    },
    close: function() {
      vc_am.current_form = false;
      this.$el.removeClass('vc_opened');
      this.renderTitle();
      this.$editForm().slideUp(100, this.removeEditForm);
    },
    clear: function(e) {
      e && e.preventDefault();
      this.model.destroy();
    },
    removeView: function() {
      this.remove();
    }
  });

  var AddFormView = FormView.extend({
    className: 'vc_add-form-atm',
    template_html: $('#vc_automapper-add-form-tpl').html(),
    events: {
      'click #vc_atm-parse-string': 'parseShortcode',
      'click .vc_atm-cancel': 'close'
    },
    getType: function() {
      return 'create';
    },
    render: function() {
      AddFormView.__super__.render.call(this);
      this.$el.html(_.template(this.template_html, {}, template_options));
      this.$el.insertAfter('.vc_automapper-toolbar');
      return this;
    },
    parseShortcode: function(e) {
      e && e.preventDefault && e.preventDefault();
      var string = $('#vc_atm-shortcode-string').val(), matches, data, params = [], attr;
      if(_.isEmpty(string)) return alert(window.i18nLocaleVcAutomapper.error_enter_valid_shortcode);
      matches = string.match(vc_regexp_shortcode());
      if(!matches) return alert(window.i18nLocaleVcAutomapper.error_enter_valid_shortcode);
      attr = wp.shortcode.attrs(matches[3]);
      _.each(attr.named, function(value, key){
        params.push({param_name: key, type: "textfield", heading: to_title(key), description: 'Example: ' + value , value: value});
      }, this);
      if(matches[5]) params.push({param_name: 'content', type: "textarea", heading: 'Content', description: '', value: matches[5]});
      data = {
        tag: matches[2],
        name: to_title(matches[2]),
        category: window.i18nLocaleVcAutomapper.my_shortcodes_category,
        params: params
      };
      if(this.isValid(data)) {
        vc_am.shortcodes.create(data);
        show_message(window.i18nLocaleVcAutomapper.new_shortcode_mapped, 'success');
        // new EditFormView({model: vc_am.shortcodes.last()}).render();
        vc_am.shortcodes.last().view.edit();
      }  else {
        alert(this.validationError);
      }
    }
  });
  var EditFormView = FormView.extend({
    className: 'vc_edit-form',
    active_preview: false,
    events: {
      'click #vc_atm-save': 'save',
      'click .vc_atm-cancel': 'close',
      'click .vc_atm-delete': 'clear',
      'click #vc_atm-add-param': 'addParam',
      'click .vc_delete-param': 'deleteParam',
      'change #vc_atm-is-container': 'setContentParam',
      'keyup .vc_param-name, .vc_param-value, #vc_atm-tag': 'setPreview',
      'focus #vc_atm-tag': 'setTagFieldActive',
      'focus .vc_params input, .vc_params textarea': 'setParamFieldActive',
      'focus .vc_param.vc_content input, .vc_param.vc_content textarea': 'setContentParamFieldActive',
      'blur #vc_atm-tag, vc_param input': 'unsetFieldActive'
    },
    new: false,
    template_html: $('#vc_automapper-form-tpl').html(),
    param_template_html: $('#vc_atm-form-param-tpl').html(),
    getType: function() {
      return 'edit';
    },
    render: function() {
      EditFormView.__super__.render.call(this);
      this.$el.html(_.template(this.template_html, this.model.toJSON(), template_options));
      this.$el.insertAfter($('[data-item-id=' + this.model.id +']').hide());
      this.addAllParams();
      return this;
    },
    setTagFieldActive: function(e) {
      this.active_preview && $(this.active_preview).removeClass('vc_active');
      this.active_preview = '#vc_shortcode-preview .vc_preview-tag';
      $(this.active_preview).addClass('vc_active');
    },
    setParamFieldActive: function(e) {
      var $control = $(e.currentTarget),
          index = $control.parents('.vc_param:first').index();
      this.active_preview && $(this.active_preview).removeClass('vc_active');
      this.active_preview = '#vc_shortcode-preview .vc_preview-param:eq(' + index + ')';
      $(this.active_preview).addClass('vc_active');
    },
    setContentParamFieldActive: function(e) {
      this.active_preview && $(this.active_preview).removeClass('vc_active');
      this.active_preview = '#vc_shortcode-preview .vc_preview-content';
      $(this.active_preview).addClass('vc_active');
    },
    unsetFieldActive: function(e) {
      $(this.active_preview).removeClass('vc_active');
      this.active_preview = false;
    },
    /***
     * Escape double quotes in params value.
     * @param value
     * @return {*}
     */
    escapeParam:function (value) {
      return value.replace(/"/g, '``');
    },
    getPreview: function(data) {
      var params = data.params,
          content = false,
          params_to_string = {};
      _.each(params, function (value, key) {
        if (value.param_name !== 'content') {
          params_to_string[value.param_name] = this.escapeParam(value.value);
        } else {
          content = value.value;
        }

      }, this);

      return wp.shortcode.atmPreview({
            tag: data.tag,
            attrs: params_to_string,
            content: content,
            type: content === false ? 'single' : ''
          });
    },
    setPreview: function() {
      var data = {
        params: this.getParams(),
        tag: $('#vc_atm-tag').val()
      };
      $('#vc_shortcode-preview').html(this.getPreview(data));
      this.active_preview && $(this.active_preview).addClass('vc_active');
    },
    save: function(e) {
      e && e.preventDefault && e.preventDefault();
      this.$el.find('.vc_error').removeClass('vc_error');
      var data = {
        tag: $('#vc_atm-tag').val(),
        name: $('#vc_atm-name').val(),
        category: $('#vc_atm-category').val(),
        description: $('#vc_atm-description').val(),
        params: this.getParams()
        };
      if(this.isValid(data)) {
          this.model.save(data);
          show_message(window.i18nLocaleVcAutomapper.shortcode_updated, 'success');
        this.close();
      } else {
        alert(this.validationError);
      }
    },
    validate: function(attrs) {
      var result = false, added_param_names = {};
      if(!attrs.name) {
        $('#vc_atm-name').addClass('vc_error');
        return window.i18nLocaleVcAutomapper.error_shortcode_name_is_required;
      }
      if (!attrs.tag || !attrs.tag.match(/^\S+$/)) {
        $('#vc_atm-tag').addClass('vc_error');
        return window.i18nLocaleVcAutomapper.error_enter_valid_shortcode_tag;
      }
      var fields_required = ['param_name', 'heading', 'type'];
      _.each(attrs.params, function(param, index){
        var $field_el = $('#vc_atm-params-list [name=param_name]:eq(' + index +')');
        if(param.param_name === 'content' && !$field_el.data('system')) {
          result = window.i18nLocaleVcAutomapper.error_content_param_not_manually;
          $field_el.addClass('vc_error');
          return;
        }
        if(_.isBoolean(added_param_names[param.param_name]) && added_param_names[param.param_name] == true) {
          $field_el.addClass('vc_error');
          if(!result) result = window.i18nLocaleVcAutomapper.error_param_already_exists.replace(/\%s/, param.param_name);
        }
        added_param_names[param.param_name] = true;
        _.each(fields_required, function(field){
          if(param[field] === '') {
            $('#vc_atm-params-list [name=' + field +']:eq(' + index +')').addClass('vc_error');
            if(!result) result = window.i18nLocaleVcAutomapper.error_enter_required_fields;
          } else if(field == 'param_name' && !param[field].match(/^[a-z0-9_]+$/g)) {
            $field_el.addClass('vc_error');
            if(!result) result = window.i18nLocaleVcAutomapper.error_wrong_param_name;
          }
        }, this);
      }, this);
      return result || null;
    },
    setContentParam: function(e) {
      var $control = $(e.currentTarget);
      if($control.is(':checked')) {
          this.addParamField({type: 'textarea', heading: 'Content', description: '', param_name: 'content', value: ''});
          this.setParamSorting();
      } else {
          this.removeParamField('content');
      }
      this.setPreview();
    },
    addAllParams: function() {
      _.each(this.model.get('params'), function(param){
        this.addParamField(param);
        if(param.param_name === 'content') $('#vc_atm-is-container').prop('checked', true);
      }, this);
      this.setParamSorting();
    },
    getParams: function() {
      var params = [];
      _.each($('.vc_param'), function(param){
        var $param = $(param);
        params.push({
          param_name: $param.find('[name=param_name]').val(),
          type: $param.find('[name=type]').val(),
          description: $param.find('[name=description]').val(),
          heading: $param.find('[name=heading]').val(),
          value: $param.find('[name=value]').val()
        });
      }, this);
      return params;
    },
    addParam: function(e) {
      e && e.preventDefault();
      this.addParamField({type: '', heading: '', description: '', param_name: '', value: ''});
      this.setPreview();
    },
    removeParamField: function(name) {
      $('.vc_param-name[value="' + name + '"]').parents('.vc_param').remove();
    },
    addParamField: function(attr) {
      var $block = $('<div class="vc_param' + ( attr.param_name === 'content' ? ' vc_content' : '' ) + '"/>').appendTo('#vc_atm-params-list');
      $block.html(_.template(this.param_template_html, attr, template_options));
    },
    setParamSorting: function() {
      $('#vc_atm-params-list').sortable({
        items: '> .vc_param',
        tolerance: "pointer",
        handle: '.vc_move-param',
        update: this.setPreview,
        placeholder: "vc_sortable-placeholder"});
    },
    deleteParam: function(e) {
      var $control;
      e && e.preventDefault();
      if(confirm(window.i18nLocaleVcAutomapper.are_you_sure_delete_param)) {
        $control =$(e.currentTarget);
        $control.parents('.vc_param').remove();
        this.setPreview();
      }
    },
    close: function(e) {
      e && e.preventDefault();
      this.model && $('[data-item-id=' + this.model.get('id') +']').show();
      vc_am.current_form = false;
      this.remove();
    },
    clear: function(e) {
      e && e.preventDefault();
      if(confirm(window.i18nLocaleVcAutomapper.are_you_sure_delete)) {
        this.model.destroy();
        this.close();
      }
    }
  });
  var EditFormInnerView = EditFormView.extend({
    template_html: $('#vc_automapper-form-tpl').html(),
    getType: function() {
      return 'edit';
    },
    initialize: function() {
      _.bindAll(this, 'setPreview');
    },
    render: function() {
      var params, content,
          parent = this.model.view;
      params = this.model.get('params');
      EditFormView.__super__.render.call(this);
      this.$el.html(_.template(this.template_html, _.extend({shortcode_preview: this.getPreview(this.model.toJSON())}, this.model.toJSON()), template_options));
      this.$el.appendTo(parent.$editForm());
      parent.$widgetTitle().html('<span class="vc_atm-header"><input type="text" name="name" value="" id="vc_atm-header-name" class="vc_header-name"></span><span class="in-widget-title"></span>');
      $('#vc_atm-header-name').val(this.model.get('name'));
      this.addAllParams();
      parent.$editForm().slideDown();
      return this;
    },
    save: function(e) {
      e && e.preventDefault();
      this.model.view.beforeSave();
      EditFormInnerView.__super__.save.call(this);
    },
    close: function(e) {
      e && e.preventDefault();
      vc_am.current_form = false;
      this.model.view.close();
    },
    clear: function(e) {
      e && e.preventDefault();
      if(confirm(window.i18nLocaleVcAutomapper.are_you_sure_delete)) {
        this.model.view.clear();
        this.remove();
      }
    }
  });
  var AppView = Backbone.View.extend({
    events: {
      'click #vc_automapper-add-btn': 'create'
    },
    className: 'vc_atm-form',
    initialize: function() {
      this.listenTo(vc_am.shortcodes, 'add', this.addOne);
      this.listenTo(vc_am.shortcodes, 'reset', this.addAll);
      this.listenTo(vc_am.shortcodes, 'all', this.render);
      this.$list = $('.vc_automapper-list');
      vc_am.shortcodes.fetch();
    },
    addAll: function(models) {
      models.each(function(model){
        this.addOne(model);
      }, this);
    },
    addOne: function(model) {
      var view = new ComplexShortcodeView({model: model});
      this.$list.append(view.render().el);
    },
    create: function(e) {
      e && e.preventDefault();
      if(!vc_am.current_form || vc_am.current_form.getType() !== 'create') {
        new AddFormView().render();
      }
    },
    render: function() {
    }
  });
  new AppView({el: $('#vc_settings-automapper')});
})(window.jQuery);