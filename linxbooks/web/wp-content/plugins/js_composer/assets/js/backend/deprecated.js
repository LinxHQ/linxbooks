(function($){
  if(_.isUndefined(window.vc)) window.vc = {};
  /**
   * Post custom css
   * @type {Number}
   * @deprecated
   */
  var PostCustomCssBlockView = vc.post_custom_css_block_view = Backbone.View.extend({
    tagName:'div',
    className:'wpb_bootstrap_modals',
    template:_.template($('#wpb-post-custom-css-modal-template').html() || '<div></div>'),
    events: {
      'click .wpb_save_edit_form': 'save'
    },
    initialize: function() {

    },
    render: function() {
      //remove previous modal!!!
      //$("div.wpb_bootstrap_modals[style$='display: none;']").remove();
      $("div.wpb_bootstrap_modals").filter(function() { return $(this).css("display") == "none" }).remove();
      this.$field = $('#wpb_custom_post_css_field');
      $('body').append(this.$el.html(this.template()));
      $('#wpb_csseditor').html(this.$field.val());
      this.$editor = ace.edit("wpb_csseditor");
      //this.$editor.setTheme("ace/theme/dreamweaver");
      var session = this.$editor.getSession();
      session.setMode("ace/mode/css");
      this.$editor.setValue(this.$field.val());
      this.$editor.clearSelection();
      this.$editor.focus();
//Get the number of lines
      var count = session.getLength();
//Go to end of the last line
      this.$editor.gotoLine(count, session.getLine(count-1).length);
    },
    setSize: function () {
      var height = $(window).height() - 250; // @fix ACE editor
      var $css_editor = $("#wpb_csseditor");
      $css_editor.css({'height': height, 'minHeight': height});
    },
    save: function() {
      this.setAlertOnDataChange();
      this.$field.val(this.$editor.getValue());
      this.close();
    },
    show:function () {
      this.render();
      $(window).bind('resize.vcPropertyPanel', this.setSize);
      this.setSize();
      this.$el.modal('show');
    },
    close:function () {
      this.$el.modal('hide');
    },
    /**
     * Set alert if custom css data differs from saved data.
     */
    setAlertOnDataChange: function() {
      if(vc.saved_custom_css !== this.$editor.getValue() && window.tinymce) {
		window.switchEditors.go('content', 'tmce');
        window.tinymce.get('content').isNotDirty = false;
      }
    }
  });

  /**
   * Templates List
   * @deprecated
   */
  vc.element_start_index = 0;
  var TemplatesBlockView = vc.add_templates_block_view = Backbone.View.extend({
    tagName:'div',
    className:'wpb_bootstrap_modals',
    template:_.template($('#wpb-add-templates-modal-template').html() || '<div></div>'),
    events:{
      //'click [data-element]':'createElement',
      'click .close':'close',
      'hidden':'removeView'
    },
    initialize:function () {

    },
    render:function () {
      $('body').append(this.$el.html(this.template()));
      $("#vc_tabs-templates").tabs();
      this.$name = $('#vc_template-name');
      this.data_rendered = true;
      return this;
    },
    removeView:function () {
      this.remove();
    },
    show:function (container) {
      this.container = container;
      this.render();
      this.$el.modal('show');
    },
    close:function () {
      this.$el.modal('hide');
    }
  });
  /**
   * Elements list
   * @type {*}
   */
  var ElementBlockView = vc.element_block_view = Backbone.View.extend({
    tagName:'div',
    className:'wpb_bootstrap_modals',
    template:_.template($('#wpb-elements-list-modal-template').html() || '<div></div>'),
    data_saved:false,
    events:{
      'click [data-element]':'createElement',
      'click .close':'close',
      'hidden':'removeView',
      'shown':'setupShown',
      'click .wpb-content-layouts-container .isotope-filter a':'filterElements',
      'keyup #vc_elements_name_filter':'filterElements'
    },
    initialize:function () {
      if (_.isUndefined(this.model)) this.model = {position_to_add:'end'};
    },
    render:function () {
      var that = this,
        $container = this.container.$content,
        item_selector,
        $list,
        tag,
        not_in;
      $('body').append(this.$el.html(this.template()));
      $list = this.$el.find('.wpb-elements-list'),
        item_selector = '.wpb-layout-element-button',
        tag = this.container.model ? this.container.model.get('shortcode') : 'vc_column',
        not_in = this._getNotIn(tag);
      // New vision
      var as_parent = tag && !_.isUndefined(vc.map[tag].as_parent) ? vc.map[tag].as_parent : false;
      if (_.isObject(as_parent)) {
        var parent_selector = [];
        if (_.isString(as_parent.only)) {
          parent_selector.push(_.reduce(as_parent.only.replace(/\s/, '').split(','), function (memo, val) {
            return memo + ( _.isEmpty(memo) ? '' : ',') + '[data-element="' + val.trim() + '"]';
          }, ''));
        }
        if (_.isString(as_parent.except)) {
          parent_selector.push(_.reduce(as_parent.except.replace(/\s/, '').split(','), function (memo, val) {
            return memo  + ':not([data-element="' + val.trim() + '"])';
          }, ''));
        }
        item_selector += parent_selector.join(',');
      } else {
        if(not_in) item_selector = not_in;
      }
      // OLD fashion
      if (tag !== false && tag !== false && !_.isUndefined(vc.map[tag].allowed_container_element)) {
        if (vc.map[tag].allowed_container_element === false) {
          item_selector += ':not([data-is-container=true])';
        } else if (_.isString(vc.map[tag].allowed_container_element)) {
          item_selector += ':not([data-is-container=true]), [data-element="' + vc.map[tag].allowed_container_element + '"]';
        }
      }
      $('.wpb-content-layouts', $list).isotope({
        itemSelector:item_selector,
        layoutMode:'fitRows',
        filter:null
      });
      $(item_selector, $list).addClass('isotope-item');
      $('.wpb-content-layouts', $list).isotope('reloadItems');
      $('.wpb-content-layouts-container .isotope-filter a:first', $list).trigger('click');
      $('[data-filter]', this.$el).each(function () {
        if (!$($(this).data('filter') + ':visible', $list).length) {
          $(this).parent().hide();
        } else {
          $(this).parent().show();
        }
      });
      return this;
    },
    _getNotIn:_.memoize(function (tag) {
      var selector = _.reduce(vc.map, function (memo, shortcode) {
        var separator = _.isEmpty(memo) ? '' : ',';
        if (_.isObject(shortcode.as_child)) {
          if (_.isString(shortcode.as_child.only)) {
            if (!_.contains(shortcode.as_child.only.replace(/\s/, '').split(','), tag)) {
              memo += separator + '.wpb-layout-element-button:not([data-element="' + shortcode.base + '"])';
            }
          }
          if (_.isString(shortcode.as_child.except)) {
            if (_.contains(shortcode.as_child.except.replace(/\s/, '').split(','), tag)) {
              memo += separator + '.wpb-layout-element-button:not([data-element="' + shortcode.base + '"])';
            }
          }
        } else if (shortcode.as_child === false) {
          memo += separator + '.wpb-layout-element-button:not([data-element="' + shortcode.base + '"])';
        }
        return memo;
      }, '');
      return selector;
    }),
    filterElements:function (e) {
      e.stopPropagation();
      var $list = this.$el.find('.wpb-elements-list'),
        $control = $(e.currentTarget),
        filter = '',
        $name_filter = $('#vc_elements_name_filter'),
        name_filter = $name_filter.val();
      if ($control.is('[data-filter]')) {
        $('.wpb-content-layouts-container .isotope-filter .active', $list).removeClass('active');
        $control.parent().addClass('active');
        filter = $control.data('filter');
        $name_filter.val('');
      } else if (name_filter.length > 0) {
        filter = ":containsi('" + name_filter + "')";
        $('.wpb-content-layouts-container .isotope-filter .active', $list).removeClass('active');
      } else if(name_filter.length == 0) {
        $('.wpb-content-layouts-container .isotope-filter [data-filter="*"]').parent().addClass('active');
      }
      $('.wpb-content-layouts', $list).isotope({ filter:filter });
    },
    createElement:function (e) {
      var model, column, row;
      if (_.isObject(e)) e.preventDefault();
      var $button = $(e.currentTarget);
      if (this.container.$content.is('#visual_composer_content')) {
        row = Shortcodes.create({shortcode:'vc_row'});
        column = Shortcodes.create({shortcode:'vc_column', params:{width:'1/1'}, parent_id:row.id, root_id:row.id });
        if ($button.data('element') != 'vc_row') {
          model = Shortcodes.create({
            shortcode:$button.data('element'),
            parent_id:column.id,
            params:vc.getDefaults($button.data('element')),
            root_id:row.id
          });
        } else {
          model = row;
        }
      } else {
        if ($button.data('element') == 'vc_row') {
          row = model = Shortcodes.create({
            shortcode:'vc_row_inner',
            parent_id:this.container.model.id,
            order:(this.model.position_to_add == 'start' ? this.getFirstPositionIndex() : Shortcodes.getNextOrder())
          });
          Shortcodes.create({shortcode:'vc_column_inner', params:{width:'1/1'}, parent_id:row.id, root_id:row.id });
        } else {
          model = Shortcodes.create({
            shortcode:$button.data('element'),
            parent_id:this.container.model.id,
            order:(this.model.position_to_add == 'start' ? this.getFirstPositionIndex() : Shortcodes.getNextOrder()),
            params:vc.getDefaults($button.data('element')),
            root_id:this.container.model.get('root_id')
          });
        }
      }
      this.selected_model = _.isBoolean(vc.map[$button.data('element')].show_settings_on_create) && vc.map[$button.data('element')].show_settings_on_create === false ? false : model;
      this.$el.modal('hide');
      this.close();

    },
    getFirstPositionIndex:function () {
      vc.element_start_index -= 1;
      return vc.element_start_index;
    },
    removeView:function () {
      if (this.selected_model && this.selected_model.get('shortcode') != 'vc_row' && this.selected_model.get('shortcode') != 'vc_row_inner') {
        vc.edit_element_block_view = new SettingsView({model:this.selected_model});
        vc.edit_element_block_view.show();
      }
      this.remove();
    },
    setupShown:function () {
      if(!vc.is_mobile) $('#vc_elements_name_filter').focus();
    },
    show:function (container) {
      this.container = container;
      this.render();
      $(window).bind('resize.ModalView', this.setSize);
      this.setSize();
      this.$el.modal('show');
    },
    close:function () {
      $(window).unbind('resize.ModalView');
      this.$el.modal('hide');
    },
    setSize: function() {
      var height = $(window).height() - 143;
      this.$el.find('.modal-body').css('maxHeight', height);
    }
  });
  /**
   * Edit form
   *
   * @deprecated
   * @type {*}
   */
  var SettingsView = Backbone.View.extend({
    tagName:'div',
    className:'wpb_bootstrap_modals',
    template:_.template($('#wpb-element-settings-modal-template').html() || '<div></div>'),
    textarea_html_checksum:'',
    dependent_elements:{},
    mapped_params:{},
    events:{
      'click .wpb_save_edit_form':'save',
      // 'click .close':'close',
      'hidden':'remove',
      'hide':'askSaveData',
      'shown':'loadContent'
    },
    content: function() {
      return this.$content;
    },
    window: function() {
      return window;
    },
    initialize:function () {
      var tag = this.model.get('shortcode'),
        params = _.isObject(vc.map[tag]) && _.isArray(vc.map[tag].params) ? vc.map[tag].params : [];
      _.bindAll(this, 'hookDependent');
      this.dependent_elements = {};
      this.mapped_params = {};
      _.each(params, function (param) {
        this.mapped_params[param.param_name] = param;
      }, this);
    },
    render:function () {
      $('body').append(this.$el.html(this.template()));
      this.$content = this.$el.find('.modal-body > div');
      return this;
    },
    initDependency:function () {
      // setup dependencies
      _.each(this.mapped_params, function (param) {
        if (_.isObject(param) && _.isObject(param.dependency) && _.isString(param.dependency.element)) {
          var $masters = $('[name=' + param.dependency.element + '].wpb_vc_param_value', this.$content),
            $slave = $('[name= ' + param.param_name + '].wpb_vc_param_value', this.$content);
          _.each($masters, function (master) {
            var $master = $(master),
              rules = param.dependency;
            if (!_.isArray(this.dependent_elements[$master.attr('name')])) this.dependent_elements[$master.attr('name')] = [];
            this.dependent_elements[$master.attr('name')].push($slave);
            $master.bind('keyup change', this.hookDependent);
            this.hookDependent({currentTarget:$master}, [$slave]);
            if (_.isString(rules.callback)) {
              window[rules.callback].call(this);
            }
          }, this);
        }
      }, this);
    },
    hookDependent:function (e, dependent_elements) {
      var $master = $(e.currentTarget),
        $master_container = $master.closest('.vc_row-fluid'),
        master_value,
        is_empty;
      dependent_elements = _.isArray(dependent_elements) ? dependent_elements : this.dependent_elements[$master.attr('name')],
        master_value = $master.is(':checkbox') ? _.map(this.$content.find('[name=' + $(e.currentTarget).attr('name') + '].wpb_vc_param_value:checked'),
          function (element) {
            return $(element).val();
          })
          : $master.val();
      is_empty = $master.is(':checkbox') ? !this.$content.find('[name=' + $master.attr('name') + '].wpb_vc_param_value:checked').length
        : !master_value.length;
      if($master_container.hasClass('vc_dependent-hidden')) {
        _.each(dependent_elements, function($element) {
          $element.closest('.vc_row-fluid').addClass('vc_dependent-hidden');
        });
      } else {
        _.each(dependent_elements, function ($element) {
          var param_name = $element.attr('name'),
            rules = _.isObject(this.mapped_params[param_name]) && _.isObject(this.mapped_params[param_name].dependency) ? this.mapped_params[param_name].dependency : {},
            $param_block = $element.closest('.vc_row-fluid');
          if (_.isBoolean(rules.not_empty) && rules.not_empty === true && !is_empty) { // Check is not empty show dependent Element.
            $param_block.removeClass('vc_dependent-hidden');
          } else if (_.isBoolean(rules.is_empty) && rules.is_empty === true && is_empty) {
            $param_block.removeClass('vc_dependent-hidden');
          } else if (_.intersection((_.isArray(rules.value) ? rules.value : [rules.value]), (_.isArray(master_value) ? master_value : [master_value])).length) {
            $param_block.removeClass('vc_dependent-hidden');
          } else {
            $param_block.addClass('vc_dependent-hidden')
          }
          $element.trigger('change');
        }, this);
      }
      return this;
    },
    loadContent:function () {
      $.ajax({
        type:'POST',
        url:window.ajaxurl,
        data:{
          action:'wpb_show_edit_form',
          element:this.model.get('shortcode'),
          post_id: $('#post_ID').val(),
          shortcode:store.createShortcodeString(this.model.toJSON()) // TODO: do it on server-side
        },
        context:this
      }).done(function (data) {
          this.$content.html(data);
          this.$el.find('h3').text(this.$content.find('> [data-title]').data('title'));
          this.initDependency();
        });
    },
    save:function (e) {
      if (_.isObject(e)) e.preventDefault();
      var params = this.getParams();
      this.model.save({params:params});
      if(parseInt(Backbone.VERSION)=== 0) {
        this.model.trigger('change:params', this.model);
      }
      this.data_saved = true;
      this.close();
      return this;
    },
    getParams: function() {
      var attributes_settings = this.mapped_params;
      this.params = jQuery.extend(true, {}, this.model.get('params'));
      _.each(attributes_settings, function (param) {
        this.params[param.param_name] = vc.atts.parse.call(this, param);
      }, this);
      _.each(vc.edit_form_callbacks, function(callback){
        callback.call(this);
      }, this);
      return this.params;
    },
    getCurrentParams: function() {
      var attributes_settings = this.mapped_params,
        params = jQuery.extend(true, {}, this.model.get('params'));
      _.each(attributes_settings, function (param) {
        if(_.isUndefined(params[param.param_name])) params[param.param_name] = '';
        if(param.type === "textarea_html") params[param.param_name] = params[param.param_name].replace(/\n/g, '');
      }, this);
      return params;
    },
    show:function () {
      this.render();
      $(window).bind('resize.ModalView', this.setSize);
      this.setSize();
      this.$el.modal('show');
    },
    _killEditor:function () {
      if(!_.isUndefined(window.tinyMCE)) {
        $('textarea.textarea_html', this.$el).each(function () {
          var id = $(this).attr('id');
          if(tinymce.majorVersion === "4") {
            window.tinyMCE.execCommand('mceRemoveEditor', true, id);
          } else {
            window.tinyMCE.execCommand("mceRemoveControl", true, id);
          }
          // window.tinyMCE.execCommand('mceAddEditor', false, id);
          // window.tinymce.activeEditor = tinymce.get('content');
          // $('#wp-fullscreen-save .button').attr('onclick', 'wp.editor.fullscreen.save()').addClass('button-primary');
        });
      }
    },
    dataNotChanged: function() {
      var current_params = this.getCurrentParams(),
        new_params = this.getParams();
      return _.isEqual(current_params, new_params);
    },
    askSaveData:function () {
      if (this.data_saved || this.dataNotChanged() || confirm(window.i18nLocale.if_close_data_lost)) {
        this._killEditor();
        this.data_saved = true;
        $(window).unbind('resize.ModalView');
        return true;
      }
      return false;
    },
    close:function () {
      if (this.askSaveData()) {
        this.$el.modal('hide');
      }
    },
    setSize: function() {
      var height = $(window).height() - 250;
      this.$el.find('.modal-body').css('maxHeight', height);
    }
  });

})(window.jQuery);