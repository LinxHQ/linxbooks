/* =========================================================
 * lib/shortcodes_builder.js v0.5.0
 * =========================================================
 * Copyright 2014 Wpbakery
 *
 * Visual composer shortcode logic backend.
 *
 * ========================================================= */
(function($) {
  if(_.isUndefined(window.vc)) window.vc = {};
  vc.ShortcodesBuilder = function(models) {
    this.models = models || [];
    this.is_build_complete = true;
    return this;
  };
  vc.ShortcodesBuilder.prototype = {
    _ajax: false,
    message: false,
    isBuildComplete: function() {
      return this.is_build_complete;
    },
    create: function(attributes) {
      this.is_build_complete = false;
      this.models.push(vc.shortcodes.create(attributes));
      return this;
    },
    render: function(callback) {
      var shortcodes;
      shortcodes = _.map(this.models, function(model){
        var string = this.toString(model);
        return {id: model.get('id'), string: string, tag: model.get('shortcode')};
      }, this);
      vc.setDataChanged();
      this.build(shortcodes, callback);
    },
    build: function(shortcodes, callback) {
      var that = this;
      this.ajax({action: 'vc_load_shortcode', shortcodes: shortcodes},vc.frame_window.location.href).done(function(html){
        _.each($(html), function(block){
          this._renderBlockCallback(block);
        }, this);
        if(_.isFunction(callback)) callback(html);
        vc.frame.setSortable();
        vc.activity = false;
        this.checkNoContent();
        vc.frame_window.vc_iframe.loadScripts();
	    //vc.frame_window.vc_js(); // causes bug #1499 with tour
        this.last() && vc.frame.scrollTo(this.first());
        this.models = [];
        this.showResultMessage();
        this.is_build_complete = true;
      });
    },
    lastID: function() {
      return this.models.length ? _.last(this.models).get('id') : '';
    },
    last: function() {
      return this.models.length ? _.last(this.models) : false;
    },
    firstID: function() {
      return this.models.length ? _.first(this.models).get('id') : '';
    },
    first: function() {
      return this.models.length ? _.first(this.models) : false;
    },
    buildFromContent: function() {
      /*var content = JSON.parse(vc.frame_window.jQuery('#vc_template-post-content').html())
                      .replace(/\<style([^\>]*)\>\/\*\* vc_js\-placeholder \*\*\//g, '<script$1>')
                      .replace(/\<\/style([^\>]*)\>\<\!\-\- vc_js\-placeholder \-\-\>/g, '</script$1>');
                      */
      var content = decodeURIComponent((vc.frame_window.jQuery('#vc_template-post-content').html()+'').replace(/\+/g, '%20'))
                      .replace(/\<style([^\>]*)\>\/\*\* vc_js\-placeholder \*\*\//g, '<script$1>')
                      .replace(/\<\/style([^\>]*)\>\<\!\-\- vc_js\-placeholder \-\-\>/g, '</script$1>');          
      try {vc.$page.html(content).prepend($('<div class="vc_empty-placeholder"></div>')); } catch(e) {}
      _.each(vc.post_shortcodes, function(data){
	      var shortcode = JSON.parse(decodeURIComponent((data+'').replace(/\+/g,'%20')));
        var $block = vc.$page.find('[data-model-id=' + shortcode.id + ']'),
          $parent = $block.parents('[data-model-id]'),
          params = _.isObject(shortcode.attrs) ? shortcode.attrs : {};
        var model = vc.shortcodes.create({
          id: shortcode.id,
          shortcode: shortcode.tag,
          params: params,
          parent_id: shortcode.parent_id,
          from_content: true
        });
        $block.attr('data-model-id', model.get('id'));
        this._renderBlockCallback($block.get(0));
      }, this);
      vc.frame.setSortable();
      this.checkNoContent();
      vc.frame.render();
	  try { vc.frame_window.vc_iframe.reload(); } catch(e) {}
	  //vc.frame_window.vc_js(); // causes bug #1499 with tour element, added in https://github.com/mmihey/js_composer/commit/1b0efa1460c7336da60530cfa330b9d62e71fa7b
    },
    buildFromTemplate: function(html, data) {
      var $html = $(html);
      _.each($(html), function(block){
        var $block = $(block);
        if($block.is('[data-type=files]')) {
          this._renderBlockCallback(block);
        } else {
          vc.app.placeElement($block);
        }
      }, this);
      _.each(data, function(encoded_shortcode){
	    var shortcode = JSON.parse(decodeURIComponent(encoded_shortcode.replace(/\+/g,'%20')));
        var $block = vc.$page.find('[data-model-id=' + shortcode.id + ']'),
            params = _.isObject(shortcode.attrs) ? shortcode.attrs : {},
            model;
        if(params.content) params.content = $('<div/>').html(params.content).text();
        model = vc.shortcodes.create({
          id: shortcode.id,
          shortcode: shortcode.tag,
          params: params,
          parent_id: shortcode.parent_id,
          from_template: true
        });
        $block.attr('data-model-id', model.get('id'));
        this._renderBlockCallback($block.get(0));

      }, this);
      vc.frame.setSortable();
      vc.activity = false;
      this.checkNoContent();
      vc.frame_window.vc_iframe.loadScripts();
      this.last() && vc.frame.scrollTo(this.first());
      this.models = [];
      this.showResultMessage();
	  vc.frame.render();
	  vc.frame_window.vc_iframe.reload();
      this.is_build_complete = true;
    },
    _renderBlockCallback: function(block) {
      var $this = $(block), $html, model;
      if($this.data('type')==='files') {
        vc.frame_window.vc_iframe.addScripts($this.find('script[src],link'));
      } else {
        model = vc.shortcodes.get($this.data('modelId'));
        $html = $this.is('[data-type=element]') ? $($this.html()) : $this;
        model && model.get('shortcode') && this.renderShortcode($html, model);
      }
      vc.setFrameSize();
    },
    renderShortcode: function($html, model) {
        var match, view_name = this.getView(model), inner_html = $html, update_inner;
        //js_re = /[^\"](<script\b[^>]+src[^>]+>|<script\b[^>]*>([\s\S]*?)<\/script>)/gm;
        vc.last_inner = inner_html.html();
        $('script', inner_html).each(function () {
            if ($(this).attr('src')) {
                var key = vc.frame.addInlineScript($(this));
                $('<span class="js_placeholder_' + key + '"></span>').insertAfter($(this));
                update_inner = true;
            } else {
                var key_inline = vc.frame.addInlineScriptBody($(this));
                //$(this).html('<span class="js_placeholder_inline_' + key_inline + '"></span>');
                $('<span class="js_placeholder_inline_' + key_inline + '"></span>').insertAfter($(this));
                update_inner = true;
            }
            $(this).remove();
        });
        if (update_inner) $html.html(inner_html.html());
        !model.get('from_content') && !model.get('from_template') && this.placeContainer($html, model);
        model.view = new view_name({model: model, el: $html}).render();
        this.notifyParent(model.get('parent_id'));
        model.view.rendered();
    },
    getView: function(model) {
      var view = model.setting('is_container') || model.setting('as_parent') ? InlineShortcodeViewContainer : InlineShortcodeView;
      if(_.isObject(window['InlineShortcodeView' + '_' + model.get('shortcode')])) {
        view = window['InlineShortcodeView' + '_' + model.get('shortcode')];
      }
      return view;
    },
    update: function(model) {
      var shortcode = this.toString(model);
      vc.setDataChanged();
      this.ajax({action: 'vc_load_shortcode', shortcodes: [{id: model.get('id'), string: shortcode, tag: model.get('shortcode')}]},vc.frame_window.location.href)
        .done(function(html){
          var old_view = model.view;
          _.each($(html), function(block){
            this._renderBlockCallback(block);
          }, this);
          if(model.view) {
            model.view.$el.insertAfter(old_view.$el);
            if(vc.shortcodes.where({parent_id: model.get('id')}).length) {
              old_view.content().find('> *').appendTo(model.view.content()); // TODO: refactor for better life. #1151
            }
            old_view.remove();
            vc.frame_window.vc_iframe.loadScripts();
	        //vc.frame_window.vc_js(); // causes bug #1499 with tour! ,added in https://github.com/mmihey/js_composer/commit/1b0efa1460c7336da60530cfa330b9d62e71fa7b
	        model.view.changed();
            vc.frame.setSortable();
            model.view.updated();
          }
        });
    },
    ajax: function(data, url) {
      return this._ajax = $.ajax({
        url: url || vc.admin_ajax,
        type: 'POST',
        dataType: 'html',
        data: _.extend({post_id: vc.post_id, vc_inline: true}, data),
        context: this
      });
    },
    notifyParent: function(parent_id) {
      var parent = vc.shortcodes.get(parent_id);
      parent && parent.view && parent.view.changed();
    },
    remove: function() {
    },
    _getContainer: function(model) {
      var container, parent_model,
        parent_id = model.get('parent_id');
      if(parent_id !== false) {
        parent_model = vc.shortcodes.get(parent_id);
        if(_.isUndefined(parent_model)) return vc.app;
        // parent_model.view === false && this.addShortcode(parent_model);
        container = parent_model.view;
      } else {
        container = vc.app;
      }
      return container;
    },
    placeContainer: function($html, model) {
      var container = this._getContainer(model);
      container && container.placeElement($html, vc.activity);
      return container;
    },
    toString: function(model, type) {
      var params = model.get('params'),
        content = _.isString(params.content) ? params.content : '';
      return wp.shortcode.string({
        tag: model.get('shortcode'),
        attrs: _.omit(params, 'content'),
        content: content,
        type:_.isString(type) ? type : ''
      });
    },
    modelsToString: function(models) {
      var string = '';
      _.each(models, function(model) {
        var tag = model.get('shortcode'),
          params = model.get('params'),
          content = _.isString(params.content) ? params.content : '';
        content += this.modelsToString(vc.shortcodes.where({parent_id: model.get('id')}));
        string += wp.shortcode.string({
          tag: tag,
          attrs: _.omit(params, 'content'),
          content: content,
          type: _.isUndefined(vc.getParamSettings(tag,'content')) && !vc.getMapped(tag).is_container ? 'single' : ''
        });
      }, this);
      return string;
    },
    getContent: function() {
      vc.shortcodes.sort();
      return this.modelsToString(vc.shortcodes.where({parent_id: false}));
    },
	getTitle: function() {
		return vc.title;
	},
    checkNoContent: function() {
      vc.frame.noContent(!vc.shortcodes.length);
    },
    save: function(status) {
      var string = this.getContent(),
        post_data = $('#post').serializeArray();
	    var data = {};
	    for(var x in post_data) {
		    data[post_data[x].name] = post_data[x].value;
	    }
	    data['vc_post_custom_css'] = vc.$custom_css.val();
	    data['content'] = string;
      if(status) {
        data.post_status = status;
        $('.vc_button_save_draft').hide(100) && $('#vc_button-update').text(window.i18nLocale.update_all);
      }
      if(vc.update_title) data.post_title = this.getTitle();
      this.ajax(data, 'post.php')
        .done(function(){
          vc.unsetDataChanged();
          vc.showMessage('Successfully updated!');
        });
    },
    /**
     * Parse shortcode string into objects.
     * @param data
     * @param content
     * @param parent
     * @return {*}
     */
    parse: function (data, content, parent) {
      var tags = _.keys(vc.map).join('|'),
        reg = window.wp.shortcode.regexp(tags),
        matches = content.trim().match(reg);
      if (_.isNull(matches)) return data;
      _.each(matches, function (raw) {
        var sub_matches = raw.match(this.regexp(tags)),
          sub_content = sub_matches[5],
          sub_regexp = new RegExp('^[\\s]*\\[\\[?(' + _.keys(vc.map).join('|') + ')(?![\\w-])'),
          atts_raw = window.wp.shortcode.attrs(sub_matches[3]),
          atts = {},
          shortcode,
          id = vc_guid(),
          map_settings;
        _.each(atts_raw.named, function (value, key) {
          atts[key] = this.unescapeParam(value);
        }, this);
        shortcode = {
          id: id,
          shortcode:sub_matches[2],
          params:_.extend({}, atts),
          parent_id:(_.isObject(parent) ? parent.id : false)
        };
        map_settings = vc.getMapped(shortcode.shortcode);
        data[id] = shortcode;
        if (id == shortcode.root_id) {
          data[id].html = raw;
        }
        if (_.isString(sub_content) && sub_content.match(sub_regexp) &&
          (
            (map_settings.is_container && _.isBoolean(map_settings.is_container) && map_settings.is_container === true) ||
              (!_.isUndefined(map_settings.as_parent) && map_settings.as_parent !== false)
            )) {
          data = this.parseContent(data, sub_content, data[id]);
        } else if (_.isString(sub_content) && sub_content.length && sub_matches[2]==='vc_row') {
          data = this.parseContent(data, '[vc_column width="1/1"][vc_column_text]' + sub_content + '[/vc_column_text][/vc_column]', data[id]);
        } else if (_.isString(sub_content) && sub_content.length && sub_matches[2]==='vc_column') {
          data = this.parseContent(data, '[vc_column_text]' + sub_content + '[/vc_column_text]', data[id]);
        } else if (_.isString(sub_content)) {
          data[id].params.content = sub_content; // sub_content.match(/\n/) && !_.isUndefined(window.switchEditors) ? window.switchEditors.wpautop(sub_content) : sub_content;
        }
      }, this);
      return data;
    },
    regexp:_.memoize(function (tags) {
      return new RegExp('\\[(\\[?)(' + tags + ')(?![\\w-])([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)(?:(\\/)\\]|\\](?:([^\\[]*(?:\\[(?!\\/\\2\\])[^\\[]*)*)(\\[\\/\\2\\]))?)(\\]?)');

    }),
    /**
     * Unescape double quotes in params valus.
     * @param value
     * @return {*}
     */
    unescapeParam:function (value) {
      return value.replace(/(\`{2})/g, '"');
    },
    setResultMessage: function(string) {
      this.message = string;
    },
    showResultMessage: function() {
      if(this.message !== false) vc.showMessage(this.message);
      this.message = false;
    }
  };
  vc.builder = new vc.ShortcodesBuilder();
})(window.jQuery);