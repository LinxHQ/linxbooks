/* =========================================================
 * composer-view.js v0.2.1
 * =========================================================
 * Copyright 2013 Wpbakery
 *
 * Visual composer backbone/underscore version
 * ========================================================= */

 (function ($) {
    var i18n = window.i18nLocale,
        store = vc.storage,
        Shortcodes = vc.shortcodes;
   vc.builder = {
       toString: function(model, type) {
           var params = model.get('params'),
               content = _.isString(params.content) ? params.content : '';
           return wp.shortcode.string({
               tag: model.get('shortcode'),
               attrs: _.omit(params, 'content'),
               content: content,
               type:_.isString(type) ? type : ''
           });
       }
   };
    /**
     * Default view for shortcode as block inside Visual composer design mode.
     * @type {*}
     */
    vc.clone_index = 1;
    vc.saved_custom_css = false;
    var ShortcodeView = vc.shortcode_view = Backbone.View.extend({
        tagName:'div',
        $content:'',
        use_default_content:false,
        params:{},
        events:{
            'click .column_delete,.vc_control-btn-delete':'deleteShortcode',
            'click .column_add,.vc_control-btn-prepend':'addElement',
            'click .column_edit,.vc_control-btn-edit, .column_edit_trigger':'editElement',
            'click .column_clone,.vc_control-btn-clone':'clone',
            'mousemove': 'checkControlsPosition'
        },
        removeView:function () {
          vc.closeActivePanel(this.model);
            this.remove();
        },
        checkControlsPosition: function() {
            if(!this.$controls_buttons) return;
            var window_top, element_position_top, new_position,
                element_height = this.$el.height(),
                window_height = $(window).height();
            if(element_height > window_height) {
                window_top = $(window).scrollTop();
                // control_top = this.$controls_buttons.offset().top;
                element_position_top = this.$el.offset().top;
                new_position =  (window_top - element_position_top) + $(window).height()/2;
                if(new_position > 40 && new_position < element_height) {
                    this.$controls_buttons.css('top',  new_position);
                } else if(new_position > element_height) {
                    this.$controls_buttons.css('top',  element_height - 40);
                } else {
                    this.$controls_buttons.css('top',  40);
                }
            }
        },
        initialize:function () {
            this.model.bind('destroy', this.removeView, this);
            this.model.bind('change:params', this.changeShortcodeParams, this);
            this.model.bind('change_parent_id', this.changeShortcodeParent, this);
            this.createParams();
        },
        createParams:function () {
            var tag = this.model.get('shortcode'),
                params = _.isObject(vc.map[tag]) && _.isArray(vc.map[tag].params) ? vc.map[tag].params : [];
            this.params = {};
            _.each(params, function (param) {
                this.params[param.param_name] = param;
            }, this);
        },
        setContent:function () {
            this.$content = this.$el.find('> .wpb_element_wrapper > .vc_container_for_children,'
				+ ' > .vc_element-wrapper > .vc_container_for_children');
        },
        setEmpty:function () {
        },
        unsetEmpty:function () {

        },
        checkIsEmpty:function () {
            if (this.model.get('parent_id')) {
                vc.app.views[this.model.get('parent_id')].checkIsEmpty();
            }
        },

        /**
         * Convert html into correct element
         * @param html
         */
        html2element:function (html) {
            var attributes = {},
                $template;
            if (_.isString(html)) {
                this.template = _.template(html);
                $template = $(this.template(this.model.toJSON()).trim());
            } else {
                this.template = html;
                $template = html;
            }
            _.each($template.get(0).attributes, function (attr) {
                attributes[attr.name] = attr.value;
            });
            this.$el.attr(attributes).html($template.html());
            this.setContent();
            this.renderContent();
        },
        render:function () {
            var $shortcode_template_el = $('#vc_shortcode-template-' + this.model.get('shortcode'));
            if ($shortcode_template_el.is('script')) {
                this.html2element(_.template($shortcode_template_el.html(), this.model.toJSON()));
            } else {
                var params = this.model.get('params');
                $.ajax({
                    type:'POST',
                    url:window.ajaxurl,
                    data:{
                        action:'wpb_get_element_backend_html',
                        data_element:this.model.get('shortcode'),
                        data_width:_.isUndefined(params.width) ? '1/1' : params.width
                    },
                    dataType:'html',
                    context:this
                }).done(function (html) {
                    this.html2element(html);
                });
            }
            this.model.view = this;
            this.$controls_buttons = this.$el.find('.vc_controls > :first');
            return this;
        },
        renderContent:function () {
            this.$el.attr('data-model-id', this.model.get('id'));
            this.$el.data('model', this.model);
            return this;
        },
        changedContent:function (view) {
        },
        _loadDefaults:function () {
            var tag = this.model.get('shortcode');
            if (this.use_default_content === true && _.isObject(vc.map[tag]) && _.isString(vc.map[tag].default_content) && vc.map[tag].default_content.length) {
                this.use_default_content = false;
                Shortcodes.createFromString(vc.map[tag].default_content, this.model);
            }
        },
        _callJsCallback:function () {
            //Fire INIT callback if it is defined
            var tag = this.model.get('shortcode');
            if (_.isObject(vc.map[tag]) && _.isObject(vc.map[tag].js_callback) && !_.isUndefined(vc.map[tag].js_callback.init)) {
                var fn = vc.map[tag].js_callback.init;
                window[fn](this.$el);
            }
        },
        ready:function (e) {
            this._loadDefaults();
            this._callJsCallback();
            if (this.model.get('parent_id') && _.isObject(vc.app.views[this.model.get('parent_id')])) {
                vc.app.views[this.model.get('parent_id')].changedContent(this);
            }
            return this;
        },
        // View utils {{
        addShortcode:function (view, method) {
			var before_shortcode;
			before_shortcode = _.last(vc.shortcodes.filter(function (shortcode) {
				return shortcode.get('parent_id') === this.get('parent_id') && parseFloat(shortcode.get('order')) < parseFloat(this.get('order'));
			}, view.model));
			if(before_shortcode) {
				view.render().$el.insertAfter('[data-model-id=' + before_shortcode.id + ']');
			} else if( method === 'append') {
				this.$content.append(view.render().el);
			} else {
				this.$content.prepend(view.render().el);
			}
        },
        changeShortcodeParams:function (model) {
            var params = model.get('params'),
                settings = vc.map[model.get('shortcode')],
                inverted_value;
            if (_.isArray(settings.params)) {
                _.each(settings.params, function (p) {
                    var name = p.param_name,
                        value = params[name],
                        $wrapper = this.$el.find('> .wpb_element_wrapper, > .vc_element-wrapper'),
                        label_value = value,
                        $admin_label = $wrapper.children('.admin_label_' + name);
                    if (_.isObject(vc.atts[p.type]) && _.isFunction(vc.atts[p.type].render)) {
                        value = vc.atts[p.type].render.call(this, p, value);
                    }
                    if ($wrapper.children('.' + p.param_name).is('input,textarea,select')) {
                      $wrapper.children('[name=' + p.param_name + ']').val(value);
                    } else if ($wrapper.children('.' + p.param_name).is('iframe')) {
                        $wrapper.children('[name=' + p.param_name + ']').attr('src', value);
                    } else if ($wrapper.children('.' + p.param_name).is('img')) {
                      var $img = $wrapper.children('[name=' + p.param_name + ']');
                      if(value && value.match(/^\d+$/)) {
                        $.ajax({
                          type:'POST',
                          url:window.ajaxurl,
                          data:{
                            action:'wpb_single_image_src',
                            content: value,
                            size: 'thumbnail'
                          },
                          dataType:'html',
                          context:this
                        }).done(function (url) {
                            $img.attr('src', url);
                          });
                      } else if(value) {
                        $img.attr('src', value);
                      }
                    } else {
                      $wrapper.children('[name=' + p.param_name + ']').html(value ? value : '');
                    }
                    if ($admin_label.length) {
                        if(value === '' || _.isUndefined(value)) {
                          $admin_label.hide().addClass('hidden-label');
                        } else {
                          if (_.isObject(p.value) && !_.isArray(p.value) && p.type == 'checkbox') {
                            inverted_value = _.invert(p.value);
                            label_value = _.map(value.split(/[\s]*\,[\s]*/),function (val) {
                              return _.isString(inverted_value[val]) ? inverted_value[val] : val;
                            }).join(', ');
                          } else if (_.isObject(p.value) && !_.isArray(p.value)) {
                            inverted_value = _.invert(p.value);
                            label_value = _.isString(inverted_value[value]) ? inverted_value[value] : value;
                          }
                          $admin_label.html('<label>' + $admin_label.find('label').text() + '</label>: ' + label_value);
                          $admin_label.show().removeClass('hidden-label');
                        }
                    }
                }, this);
            }
            var view = vc.app.views[this.model.get('parent_id')];
            if (this.model.get('parent_id') !== false && _.isObject(view)) {
                view.checkIsEmpty();
            }
        },
        changeShortcodeParent:function (model) {
            if (this.model.get('parent_id') === false) return model;
            var $parent_view = $('[data-model-id=' + this.model.get('parent_id') + ']'),
                view = vc.app.views[this.model.get('parent_id')];
            this.$el.appendTo($parent_view.find('> .wpb_element_wrapper > .wpb_column_container,'
				+ ' > .vc_element-wrapper > .wpb_column_container'));
            view.checkIsEmpty();
        },
        // }}
        // Event Actions {{
        deleteShortcode:function (e) {
            if (_.isObject(e)) e.preventDefault();
            var answer = confirm(i18n.press_ok_to_delete_section);
            if (answer === true) this.model.destroy();
        },
        addElement:function (e) {
            _.isObject(e) && e.preventDefault();
            // new ElementBlockView({model:{position_to_add:!_.isObject(e) || !$(e.currentTarget).closest('.bottom-controls').hasClass('bottom-controls') ? 'start' : 'end'}}).show(this);
          vc.add_element_block_view.render(this.model, !_.isObject(e) || !$(e.currentTarget).closest('.bottom-controls').hasClass('bottom-controls'));
        },
        editElement: function (e) {
            if (_.isObject(e)) e.preventDefault();
            if ( !vc.active_panel || !vc.active_panel.model || !this.model || ( vc.active_panel.model && this.model && vc.active_panel.model.get('id') != this.model.get('id') ) ) {
                vc.closeActivePanel();
                vc.edit_element_block_view.render(this.model);
            }
        },
        clone:function (e) {
            if (_.isObject(e)) e.preventDefault();
            vc.clone_index = vc.clone_index / 10;
            return this.cloneModel(this.model, this.model.get('parent_id'));
        },
        cloneModel:function (model, parent_id, save_order) {
            var shortcodes_to_resort = [],
                new_order = _.isBoolean(save_order) && save_order === true ? model.get('order') : parseFloat(model.get('order')) + vc.clone_index,
                model_clone = Shortcodes.create({shortcode:model.get('shortcode'), id: window.vc_guid(), parent_id:parent_id, order:new_order, cloned:true, cloned_from:model.toJSON(), params:_.extend({}, model.get('params'))});
            _.each(Shortcodes.where({parent_id:model.id}), function (shortcode) {
                this.cloneModel(shortcode, model_clone.get('id'), true);
            }, this);
            return model_clone;
        }
        // }}
    });

    var VisualComposer = vc.visualComposerView = Backbone.View.extend({
        el:$('#wpb_visual_composer'),
        views:{},
        disableFixedNav: false,
        events:{
            "click #wpb-add-new-row":'createRow',
            'click #vc_post-settings-button': 'editSettings',
            'click #vc_add-new-element, .vc_add-element-button, .vc_add-element-not-empty-button':'addElement',
            'click .vc_add-text-block-button':'addTextBlock',
            'click .wpb_switch-to-composer':'switchComposer',
            'click #vc_templates-editor-button': 'openTemplatesWindow',
            'click #vc_templates-more-layouts': 'openTemplatesWindow',
            'click .vc_template[data-template_unique_id] > .wpb_wrapper':'loadDefaultTemplate',
            'click #wpb-save-post':'save',
            'click .vc_control-preview':'preview'
        },
        initialize:function () {
            this.accessPolicy = $('.vc_js_composer_group_access_show_rule').val();
            if (this.accessPolicy == 'no') return false;
            this.buildRelevance();
            _.bindAll(this, 'switchComposer', 'dropButton', 'processScroll', 'updateRowsSorting', 'updateElementsSorting');
            Shortcodes.bind('add', this.addShortcode, this);
            Shortcodes.bind('destroy', this.checkEmpty, this);
            Shortcodes.bind('reset', this.addAll, this);
            this.render();
        },
        render:function () {
            var front = '';
            if (this.accessPolicy !== 'only') {
                if(vc_frontend_enabled) front = '<span class="vc_spacer"></span><a class="wpb_switch-to-front-composer" href="' + $('#wpb-edit-inline').attr('href') +'">' + window.i18nLocale.main_button_title_frontend_editor + '</a>';
                this.$buttonsContainer = $('<div class="composer-switch"><span class="logo-icon"></span><span class="vc_spacer"></span><a class="wpb_switch-to-composer" href="#">' + window.i18nLocale.main_button_title_backend_editor + '</a>' + front + '</div>').insertAfter('div#titlediv');
                // this.$switchButton = $('<a class="wpb_switch-to-composer button-primary" href="#">' + window.i18nLocale.main_button_title + '</a>').insertAfter('div#titlediv').wrap('<p class="composer-switch" />');
                this.$switchButton = this.$buttonsContainer.find('.wpb_switch-to-composer');
                this.$switchButton.click(this.switchComposer);
            }
            this.$metablock_content = $('.metabox-composer-content');
            this.$content = $("#visual_composer_content");
            this.$post = $('#postdivrich');
            this.$vcStatus = $('#wpb_vc_js_status');
            this.$loading_block = $('#vc_logo');
            vc.add_element_block_view = new vc.AddElementBlockViewBackendEditor({el: '#vc_add-element-dialog'});
            vc.edit_element_block_view = new vc.EditElementPanelView({el: '#vc_properties-panel'});
	        /**
	         * @deprecated since 4.4
	         * @type {vc.TemplatesEditorPanelViewBackendEditor}
	         */
	          vc.templates_editor_view = new vc.TemplatesEditorPanelViewBackendEditor({el: '#vc_templates-editor'});
            vc.templates_panel_view = new vc.TemplatesPanelViewBackend({el: '#vc_templates-panel'});
            vc.post_settings_view = new vc.PostSettingsPanelViewBackendEditor({el: '#vc_post-settings-panel'});
            this.setSortable();
            this.setDraggable();
            vc.is_mobile = $('body.mobile').length > 0;
            vc.saved_custom_css = $('#wpb_custom_post_css_field').val();
            vc.updateSettingsBadge();
            return this;
        },
        addAll:function () {
            this.views = {};
            this.$content.removeClass('loading').html('');
            this.addChild(false);
            this.checkEmpty();
            this.$loading_block.removeClass('vc_ajax-loading');
            this.$metablock_content.removeClass('vc_loading-shortcodes');
        },
        addChild: function(parent_id) {
            _.each(vc.shortcodes.where({parent_id: parent_id}), function (shortcode) {
                this.appendShortcode(shortcode);
                this.setSortable();
                this.addChild(shortcode.get('id'));
            }, this);
        },
        getView:function (model) {
            var view;
            if (_.isObject(vc.map[model.get('shortcode')]) && _.isString(vc.map[model.get('shortcode')].js_view) && vc.map[model.get('shortcode')].js_view.length) {
                view = new window[window.vc.map[model.get('shortcode')].js_view]({model:model});
            } else {
                view = new ShortcodeView({model:model});
            }
            model.set({view: view});
            return view;
        },
        setDraggable:function () {
            $('#wpb-add-new-element, #wpb-add-new-row').draggable({
                helper:function () {
                    return $('<div id="drag_placeholder"></div>').appendTo('body');
                },
                zIndex:99999,
                // cursorAt: { left: 10, top : 20 },
                cursor:"move",
                // appendTo: "body",
                revert:"invalid",
                start:function (event, ui) {
                    $("#drag_placeholder").addClass("column_placeholder").html(window.i18nLocale.drag_drop_me_in_column);
                }
            });
            this.$content.droppable({
                greedy:true,
                accept:".dropable_el,.dropable_row",
                hoverClass:"wpb_ui-state-active",
                drop:this.dropButton
            });
        },
        dropButton:function (event, ui) {
            if (ui.draggable.is('#wpb-add-new-element')) {
                this.addElement();
            } else if (ui.draggable.is('#wpb-add-new-row')) {
                this.createRow();
            }
        },
        appendShortcode:function (model) {
            var view = this.getView(model),
				parentModelView =  model.get('parent_id') !== false ?
					this.views[model.get('parent_id')] : false;
            this.views[model.id] = view;
            if (model.get('parent_id')) {
                var parent_view = this.views[model.get('parent_id')];
                parent_view.unsetEmpty();
            }
			if(parentModelView) {
				parentModelView.addShortcode(view, 'append');
			} else {
				this.$content.append(view.render().el);
			}
            view.ready();
            view.changeShortcodeParams(model); // Refactor
            view.checkIsEmpty();
            this.setNotEmpty();
        },
        addShortcode: function (model) {
            var view, parentModelView;
            view = this.getView(model);
            parentModelView =  model.get('parent_id') !== false ?
                    this.views[model.get('parent_id')] : false;
            view.use_default_content = model.get('cloned') !== true;
            this.views[model.id] = view;
            if(parentModelView) {
                parentModelView.addShortcode(view);
                parentModelView.checkIsEmpty();
                model.trigger('change:params', model);
                view.ready();
                this.setSortable();
                this.setNotEmpty();
            } else {
                this.addRow(view);
				model.trigger('change:params', model);
			}
        },
        addRow: function(view) {
            var before_shortcode;
            before_shortcode = _.last(vc.shortcodes.filter(function (shortcode) {
                return shortcode.get('parent_id') === false && parseFloat(shortcode.get('order')) < parseFloat(this.get('order'));
            }, view.model));
            if(before_shortcode) {
                view.render().$el.insertAfter('[data-model-id=' + before_shortcode.id + ']');
            } else {
                this.$content.append(view.render().el);
            }
        },
        addTextBlock:function (e) {
            e.preventDefault();
            var row = Shortcodes.create({shortcode:'vc_row'}),
                column = Shortcodes.create({shortcode:'vc_column', params:{width:'1/1'}, parent_id:row.id, root_id:row.id }),
                text_block = Shortcodes.create({shortcode:'vc_column_text', params:vc.getDefaults('vc_column_text'), parent_id:column.id, root_id:row.id });
            return text_block;
        },
        /**
         * Create row
         */
        createRow:function () {
            var row = Shortcodes.create({shortcode:'vc_row'});
            Shortcodes.create({shortcode:'vc_column', params:{width:'1/1'}, parent_id:row.id, root_id:row.id });
            return row;
        },
        /**
         * Add Element with a help of modal view.
         */
        addElement:function (e) {
          _.isObject(e) && e.preventDefault();
          vc.add_element_block_view.render(false);
        },
        /**
         * @deprecated since 4.4 use openTemplatesWindow
         * @param e
         */
        openTemplatesEditor: function(e) {
          e && e.preventDefault();
          vc.templates_editor_view.render().show();
        },
        openTemplatesWindow: function(e) {
          e && e.preventDefault();
          vc.templates_panel_view.render().show();
        },
        loadDefaultTemplate: function(e) {
          e && e.preventDefault();
          vc.templates_panel_view.loadTemplate(e);
        },
        editSettings: function(e) {
          e && e.preventDefault();
          vc.post_settings_view.render().show();
        },
        sortingStarted:function (event, ui) {
            $('#visual_composer_content').addClass('vc_sorting-started');
        },
        sortingStopped:function (event, ui) {
            $('#visual_composer_content').removeClass('vc_sorting-started');
        },
        updateElementsSorting:function (event, ui) {
            _.defer(function (app, event, ui) {
                var $current_container = ui.item.parent().closest('[data-model-id]'),
                    parent = $current_container.data('model'),
                    model = ui.item.data('model'),
                    models = app.views[parent.id].$content.find('> [data-model-id]'),
                    i = 0;
                // Change parent if block moved to another container.
                if (!_.isNull(ui.sender)) {
                    var old_parent_id = model.get('parent_id');
                    store.lock();
                    model.save({parent_id:parent.id});
                    app.views[old_parent_id].checkIsEmpty();
                    app.views[parent.id].checkIsEmpty();
                }
                models.each(function () {
                    var shortcode = $(this).data('model');
                    store.lock();
                    shortcode.save({'order':i++});
                });
                model.save();
            }, this, event, ui);

        },
        updateRowsSorting:function () {
            _.defer(function (app) {
                var $rows = app.$content.find(app.rowSortableSelector);
                $rows.each(function () {
                    var index = $(this).index();
                    if ($rows.length - 1 > index) store.lock();
                    $(this).data('model').save({'order':index});
                });
            }, this);
        },
        renderPlaceholder: function(event, element) {
          var tag = $(element).data('element_type'),
            $helper = $('<div class="vc_helper vc_helper-' + tag + '"><i class="vc_element-icon'
              + ( vc.map[tag].icon ? ' ' + vc.map[tag].icon : '' )
              + '"'
              + ( vc.map[tag].is_container ? ' data-is-container="true"' : '' )
              + '></i> ' + vc.map[tag].name + '</div>').prependTo('body');
          return $helper;
        },
		rowSortableSelector: "> .wpb_vc_row",
        setSortable:function () {
            var that = this;
            // 1st level sorting (rows). work also in wp41.
            $('.wpb_main_sortable').sortable({
                forcePlaceholderSize:true,
                placeholder:"widgets-placeholder",
                // cursorAt: { left: 10, top : 20 },
                cursor:"move",
                items: this.rowSortableSelector, // wpb_sortablee
                handle:'.column_move',
                distance:0.5,
                start:this.sortingStarted,
                stop:this.sortingStopped,
                update:this.updateRowsSorting,
                over:function (event, ui) {
                    ui.placeholder.css({maxWidth:ui.placeholder.parent().width()});
                }
            });
            // 2st level sorting (elements).
            $('.wpb_column_container').sortable({
                forcePlaceholderSize: true,
                forceHelperSize: false,
                connectWith:".wpb_column_container",
                placeholder:"vc_placeholder",
                items:"> div.wpb_sortable", //wpb_sortablee
                helper: this.renderPlaceholder,
                distance: 3,
                scroll: true,
                scrollSensitivity: 70,
                cursor: 'move',
                cursorAt: {top: 20, left: 16},
                tolerance:'intersect', // this helps with dragging textblock into tabs
                start:function () {
                    $('#visual_composer_content').addClass('vc_sorting-started');
                    $('.vc_not_inner_content').addClass('dragging_in');
                },
                stop:function (event, ui) {
                    $('#visual_composer_content').removeClass('vc_sorting-started');
                    $('.dragging_in').removeClass('dragging_in');
                    var tag = ui.item.data('element_type'),
                        parent_tag = ui.item.parent().closest('[data-element_type]').data('element_type'),
                        allowed_container_element = !_.isUndefined(vc.map[parent_tag].allowed_container_element) ? vc.map[parent_tag].allowed_container_element : true;
                    if (!vc.check_relevance(parent_tag, tag)) {
                        $(this).sortable('cancel');
                    }
                    if (vc.map[ui.item.data('element_type')].is_container && !(allowed_container_element === true || allowed_container_element === ui.item.data('element_type').replace(/_inner$/, ''))) { // && ui.item.hasClass('wpb_container_block')
                        $(this).sortable('cancel');
                    }
                    $('.vc_sorting-empty-container').removeClass('vc_sorting-empty-container');
                },
                update:this.updateElementsSorting,
                over:function (event, ui) {
                    var tag = ui.item.data('element_type'),
                        parent_tag = ui.placeholder.closest('[data-element_type]').data('element_type'),
                        allowed_container_element = !_.isUndefined(vc.map[parent_tag].allowed_container_element) ? vc.map[parent_tag].allowed_container_element : true;
                    if (!vc.check_relevance(parent_tag, tag)) {
                        ui.placeholder.addClass('vc_hidden-placeholder');
                        return false;
                    }
                    if (vc.map[ui.item.data('element_type')].is_container && !(allowed_container_element === true || allowed_container_element === ui.item.data('element_type').replace(/_inner$/, ''))) {
                        ui.placeholder.addClass('vc_hidden-placeholder');
                        return false;
                    }
                    if( !_.isNull(ui.sender) && ui.sender.length && !ui.sender.find('[data-element_type]:visible').length) {
                      ui.sender.addClass('vc_sorting-empty-container');
                    }
                    ui.placeholder.removeClass('vc_hidden-placeholder'); // .parent().removeClass('vc_empty-container');
                    ui.placeholder.css({maxWidth:ui.placeholder.parent().width()});
                }
            });
            return this;
        },
        setNotEmpty:function () {
            // this.$metablock_content.removeClass('empty-composer');
            $('#vc_no-content-helper').addClass('vc_not-empty');
        },
        setIsEmpty:function () {
            // this.$metablock_content.addClass('empty-composer');
            $('#vc_no-content-helper').removeClass('vc_not-empty')
        },
        checkEmpty:function (model) {
            if (_.isObject(model) && model.get('parent_id') !== false && model.get('parent_id') != model.id) {
                var parent_view = this.views[model.get('parent_id')];
                parent_view.checkIsEmpty();
            }
            if ( Shortcodes.length === 0 ) {
                this.setIsEmpty();
            } else {
                this.setNotEmpty();
            }
        },
        switchComposer:function (e) {
            if (_.isObject(e)) e.preventDefault();
            if (this.status == 'shown') {
              if (this.accessPolicy !== 'only') {
                !_.isUndefined(this.$switchButton) && this.$switchButton.text(window.i18nLocale.main_button_title_backend_editor);
                !_.isUndefined(this.$buttonsContainer) && this.$buttonsContainer.removeClass('vc_backend-status');
              }
              this.close();
              this.status = 'closed';
            } else {
              if (this.accessPolicy !== 'only') {
                !_.isUndefined(this.$switchButton) && this.$switchButton.text(window.i18nLocale.main_button_title_revert);
                !_.isUndefined(this.$buttonsContainer) && this.$buttonsContainer.addClass('vc_backend-status');
              }
              this.show();
                this.status = 'shown';

            }
        },
        show:function () {
            this.$el.show();
            this.$post.hide();
            this.$vcStatus.val("true");
            this.navOnScroll();
            if (vc.storage.isContentChanged()) {
                vc.app.setLoading();
                vc.app.views = {};

                window.setTimeout(function () {
                    Shortcodes.fetch({reset: true});
                }, 100);
            }
        },
        setLoading:function () {
            this.setNotEmpty();
            this.$loading_block.addClass('vc_ajax-loading');
            this.$metablock_content.addClass('vc_loading-shortcodes');
        },
        close:function () {
            this.$vcStatus.val("false");
            // if (this.$switchButton !== undefined) this.$switchButton.html(window.i18nLocale.main_button_title);
            this.$el.hide();
            this.$post.show();
        },
        checkVcStatus:function () {
            if (this.$vcStatus.val() === 'true' || this.accessPolicy === 'only') {
                this.switchComposer();
            }
        },
        setNavTop:function () {
          this.navTop = this.$nav.length && this.$nav.offset().top - 28;
        },
        save:function () {
            $('#wpb-save-post').text(window.i18nLocale.loading);
            $('#publish').click();
        },
        preview:function() {
            $('#post-preview').click();
        },
        navOnScroll:function () {
            var $win = $(window);
            this.$nav = $('#vc_navbar'); // $('#wpb_visual_composer-elements');
            this.setNavTop();
            this.processScroll();
            $win.unbind('scroll.composer').on('scroll.composer', this.processScroll);
        },
        processScroll:function (e) {
            if(true === this.disableFixedNav) {
                this.$nav.removeClass('vc_subnav-fixed');
                return;
            }
            if( !this.navTop || this.navTop < 0) {
                this.setNavTop();
            }
            this.scrollTop = $(window).scrollTop() + 80;
            if ( this.navTop > 0 && this.scrollTop >= this.navTop && !this.isFixed) {
                this.isFixed = 1;
                this.$nav.addClass('vc_subnav-fixed');
            } else if ( this.scrollTop <= this.navTop && this.isFixed) {
                this.isFixed = 0;
                this.$nav.removeClass('vc_subnav-fixed');
            }
        },
        buildRelevance:function () {
            vc.shortcode_relevance = {};
            _.map(vc.map, function (object) {
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
            vc.check_relevance = function (tag, related_tag) {
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
        }
    });
    $(function(){
        if ($('#wpb_visual_composer').is('div')) {
            var app = vc.app = new VisualComposer();
            vc.app.checkVcStatus();
        }
    });


})(window.jQuery);