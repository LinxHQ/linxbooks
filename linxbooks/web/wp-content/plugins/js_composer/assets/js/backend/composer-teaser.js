/* =========================================================
 * composer-teaser.js v1.1
 * =========================================================
 * Copyright 2013 Wpbakery
 *
 * Visual composer custom teaser block control meta box.
 * ========================================================= */
(function ($) {
    wp.media.controller.VcTeaserCustomImage = wp.media.controller.FeaturedImage.extend({
        defaults:_.defaults({
            id:'vc_teaser-custom-image',
            filterable:'uploaded',
            multiple:false,
            toolbar:'vc_single-image',
            title:i18nLocale.set_image,
            priority:60,
            syncSelection:false
        }, wp.media.controller.Library.prototype.defaults),
        updateSelection:function () {
            var selection = this.get('selection'),
                id = wp.media.VcTeaserCustomImage.getData(),
                attachment;
            if ('' !== id && -1 !== id) {
                attachment = wp.media.model.Attachment.get(id);
                attachment.fetch();
            }
            selection.reset(attachment ? [ attachment ] : []);
        }
    });
    window.wp.media.VcTeaserCustomImage = {
        getData:function () {
            return '';
        },
        set:function (selection) {
            return false;
        },
        frame:function (element) {
            this.element = element;
            if (this._frame)
                return this._frame;
            this._frame = wp.media({
                state:'vc_teaser-custom-image',
                states:[ new wp.media.controller.VcTeaserCustomImage() ]
            });
            this._frame.on('toolbar:create:vc_single-image', function (toolbar) {
                this.createSelectToolbar(toolbar, {
                    text:window.i18nLocale.set_image
                });
            }, this._frame);

            this._frame.state('vc_teaser-custom-image').on('select', this.select);
            return this._frame;
        },
        select:function () {
            var selection = this.get('selection').single();
            wp.media.VcTeaserCustomImage.set(selection ? selection : -1);
        }
    };
    var template_options = {
        evaluate:    /<#([\s\S]+?)#>/g,
        interpolate: /\{\{\{([\s\S]+?)\}\}\}/g,
        escape:      /\{\{([^\}]+?)\}\}(?!\})/g
    };
    var VCTeaser = Backbone.View.extend({
        el:$('#vc_teaser'),
        events: {
            'click #vc_teaser-checkbox': 'toggle',
            'change .vc_teaser-button': 'updateList',
            'click .vc_teaser-image-custom': 'setImageMode',
            'click .vc_teaser-image-featured': 'setImageMode',
            'click .vc_teaser_add_custom_image': 'showMediaEditor',
            'click .vc_teaser-text-control': 'setTextMode',
            'click .vc_link-control': 'setLinkControl',
            'keyup #vc_teaser-text-custom': 'setCustomText'
        },
        controls: [
            'title', 'image', 'text', 'link'
        ],
        // Image {{
        current_image_mode: '',
        featured_image_trigger: false,
        custom_image_attributes: '',
        // }}
        // Text {{
        current_text_mode: '',
        custom_text: '',
        // }}
        initialize: function() {
            _.bindAll(this, 'save', 'parse',
                            'updateColorPicker', 'clearColorPicker', 'updateTitle',
                            'triggerFeaturedImageChanges', 'setCustomTeaserImage', 'getCustomTeaserImage');
            _.extend(window.wp.media.VcTeaserCustomImage, {
                getData: this.getCustomTeaserImage,
                set: this.setCustomTeaserImage
            });
            this.render();
        },
        render: function(){
            this.$contructor_container = this.$el.find('.vc_teaser-constructor');
            this.$data_field = this.$el.find('.vc_teaser-data-field');
            this.$bgcolor = this.$el.find('.vc_teaser-bgcolor');
            this.$toolbar = this.$contructor_container.find('.vc_toolbar');
            this.$spinner = this.$contructor_container.find('.vc_teaser_loading_block')
            this.renderButtons(this.controls);
            this.$list = this.$contructor_container.find('.vc_teaser-list');
            this.$list.sortable({
                update: this.save,
                handle: '.vc_move',
                forcePlaceholderSize:true,
                placeholder:"widgets-placeholder",
                over:function (event, ui) {
                  ui.placeholder.css({maxWidth:ui.placeholder.parent().width()});
                }
            });
            this.$contructor_container.find('.vc_teaser-bgcolor').wpColorPicker({
                change:this.updateColorPicker,
                clear: this.clearColorPicker
            });
            if(!_.isEmpty(this.$bgcolor.val())) this.$list.css('backgroundColor', this.$bgcolor.val());
            this.$spinner.show();
            _.delay(this.parse, 200);
            this.toggle({currentTarget: '#vc_teaser-checkbox'});
        },
        renderButtons: function(controls) {
            _.each(controls, function(button){
                var html = _.template($('#vc_teaser-button').html(), {label: window.i18nVcTeaser[button + '_label'], value: button}, template_options);
                this.$toolbar.append(html);
            }, this);
        },
        toggle: function(e) {
            var $target = $(e.currentTarget);
            if($target.is(':checked')) {
                this.$contructor_container.show();
            } else {
                this.$contructor_container.hide();
            }
        },
        updateColorPicker: function(e, ui){
            var color = ui ? ui.color.toString() : '';
            this.$list.css('backgroundColor', color);
        },
        clearColorPicker: function() {
            this.$list.css('backgroundColor', '');
        },
        updateList: function(e) {
            var $control = $(e.currentTarget),
                data = {
                    name: $control.val(),
                    link: 'none'
                };
            if(data.name === 'image') {
                data.mode = 'featured';
            } else if(data.name === 'text') {
                data.mode = 'excerpt';
            }
            if($control.is(':checked')) {
                this.createControl(data);
            } else {
                this.$list.find('[data-control=' + data.name + ']').remove();
                this.removeData(data);
                this.save();
            }
        },
        setLinkControl: function(e) {
            e.preventDefault();
            var $button = $(e.currentTarget),
                $control = $button.closest('.vc_link-controls'),
                link_type = $button.data('link');
            $control.find('.vc_active-link').removeClass('vc_active-link');
            $button.addClass('vc_active-link');
            this.save();
        },
        createControl: function(data) {
            var default_data = {
              name: '',
              link: 'none'
            };
            var html = _.template($('#vc_teaser-' + data.name).html(), _.extend(default_data, data), template_options);
            this.$list.append(html);
            this.updateContent(data);
        },
        removeData: function(data) {
            if(data.name === 'title') {
                $('#title').unbind('keyup.vcTeaserTitle');
            } else if(data.name === 'text') {
                this.current_text_mode = '';
            } else if(data.name === 'image') {
                this.current_image_mode = '';
            }
        },
        updateContent: function(data) {
            if(data.name === 'title') {
                $('#title').bind('keyup.vcTeaserTitle', this.updateTitle).trigger('keyup.vcTeaserTitle');
                this.save();
            } else if(data.name === 'image') {
                this.setImageMode(data.mode);
            } else if(data.name === 'text') {
                this.setTextMode(data.mode);
            } else if(data.name === 'link') {
                this.save();
            }
        },
        setTextMode: function(e) {
            if(_.isObject(e) && !_.isUndefined(e.currentTarget)) {
                e.preventDefault();
                var $control = $(e.currentTarget),
                    new_mode = $control.data('mode');
            } else {
                var new_mode = e || 'excerpt',
                    $control = $('.vc_teaser-text-' + new_mode, this.$el);
            }
            var $vc_text = $('.vc_text', this.$el);
            $control.siblings('.vc_active').removeClass('vc_active');
            $control.addClass('vc_active');
            if(new_mode !== this.current_text_mode) {
                $vc_text.removeClass('vc_text-' + this.current_image_mode).addClass('vc_text-' + new_mode);
                this.current_text_mode = new_mode;
                if(new_mode === 'excerpt') {
                    $vc_text.html('<div class="vc_teaser-text-excerpt">' + this.getExcerpt() + '</div>');
                } else if(new_mode === 'text') {
                    $vc_text.html('<div class="vc_teaser-text-text"></div>').find('.vc_teaser-text-text').html($('#content').val());
                } else if(new_mode === 'custom') {
                    $vc_text.html('<textarea name="vc_teaser_text_custom" id="vc_teaser-text-custom"></textarea>').find('textarea').val(this.custom_text);
                }
            }
            this.save();
        },
        setCustomText: function(e) {
            this.custom_text  = $('#vc_teaser-text-custom').val();
            this.save();
        },
        getExcerpt: function() {
            var excerpt = $('#excerpt').val();
            if(_.isEmpty(excerpt)) {
                excerpt = $('#content').val().substring(0, 150).replace(/\s+\S*$/, "") + ' [...]';
            }
            return excerpt;
        },
        setImageMode: function(e) {
            if(_.isObject(e) && !_.isUndefined(e.currentTarget)) {
                e.preventDefault();
                var $control = $(e.currentTarget),
                    new_mode = $control.data('mode');
            } else {
                var new_mode = e || 'featured',
                    $control = $('.vc_teaser-image-' + new_mode, this.$el);
            }
            $control.siblings('.vc_active').removeClass('vc_active');
            $control.addClass('vc_active');
            if(new_mode !== this.current_image_mode) {
                $('.vc_image', this.$el).removeClass('vc_image-' + this.current_image_mode).addClass('vc_image-' + new_mode);
                this.current_image_mode = new_mode;
                if(new_mode === 'featured') {
                    if(this.featured_image_trigger === false) {
                        $(document).ajaxSuccess(this.triggerFeaturedImageChanges);
                        this.featured_image_trigger = true;
                    }
                    this.setFeaturedImageBlock($('#set-post-thumbnail').parent().html());
                } else if(new_mode === 'custom') {
                    this.setCustomImageBlock();
                }
            }
            this.save();
        },
        showMediaEditor: function(e) {
            e.preventDefault();
            window.wp.media.VcTeaserCustomImage.frame($('.vc_teaser_add_custom_image', this.$el).get(0)).open('vc_editor');
        },
        getCustomTeaserImage: function() {
            return _.isObject(this.custom_image_attributes) && !_.isUndefined(this.custom_image_attributes.id) ? this.custom_image_attributes.id : '';
        },
        setCustomTeaserImage: function(selection) {
            if(_.isObject(selection)) this.custom_image_attributes = selection.attributes;
            if(_.isUndefined(this.custom_image_attributes.url)) {
              this.$spinner.show();
              $.ajax({
                    type:'POST',
                    url:window.ajaxurl,
                    data:{
                        action:'wpb_single_image_src',
                        content: this.custom_image_attributes.id,
                        size: 'large'
                    },
                    dataType:'html',
                    context:this
                }).done(function (url) {
                        this.custom_image_attributes.url = url;
                        this.appendCustomImageHtml();
                    });
            } else {
                this.appendCustomImageHtml();
                this.save();
            }

            return false;
        },
        appendCustomImageHtml: function() {
            this.$spinner.hide();
          $('.vc_teaser-custom-image-view', this.$el).html(_.template($('#vc_teaser-custom-image').html(), this.custom_image_attributes));
        },
        setCustomImageBlock: function() {
            var $vc_image = $('.vc_image', this.$el);
            $vc_image.html(_.template($('#vc_teaser-custom-image-block').html(), {}, template_options));
            if(_.isObject(this.custom_image_attributes) && !_.isUndefined(this.custom_image_attributes.id)) {
                this.setCustomTeaserImage();
            } else {
                this.save();
            }
        },
        triggerFeaturedImageChanges: function(event, xhr, settings) {
            if(_.isString(settings.data) && settings.data.match(/action=set\-post\-thumbnail/)) {
                this.setFeaturedImageBlock(_.isObject(xhr.responseJSON) ? xhr.responseJSON.data : '');
            }
        },
        setFeaturedImageBlock: function(data){
            var $vc_image = $('.vc_image', this.$el),
                $image = '';
            if($vc_image.hasClass('vc_image-featured')) {
                $image = $(data).find('img').length ? $(data).find('img') : $('<div>Featured image not set</div>');
                $('.vc_image', this.$el).html('').append($image);
            }
        },
        updateTitle: function(e) {
            var title = $(e.currentTarget).val();
            if(_.isEmpty(title)) title = '<span class="vc_empty">' + window.i18nVcTeaser.empty_title + '</span>';
            $('#vc_teaser-title-control > span').html(title);
        },
        save: function() {
            var data = [],
                that = this;
            $('.vc_teaser-control', this.$el).each(function(){
                var $block = $(this),
                    block_data = {name: $block.data('control')};
                if(block_data.name === 'image') {
                    block_data.image = that.current_image_mode !== 'featured' ? that.getCustomTeaserImage() : that.current_image_mode;
                } else if(block_data.name == 'text') {
                    block_data.mode = that.current_text_mode;
                    if(block_data.mode === 'custom') {
                        block_data.text = that.custom_text;
                    }
                }
                if($block.find('.vc_link-controls').length) {
                    var $active = $('.vc_active-link', $block);
                    if($active.length) block_data.link = $active.data('link');
                }
                data.push(block_data);
            });
            this.$data_field.val(JSON.stringify(data));
        },
        parse: function() {
            var value = this.$data_field.val(),
                data = !_.isEmpty(value) ? $.parseJSON(value) : [];
            if(_.isEmpty(value)) {
              data = [{link: "post", name: "title"}, {name: 'image'}, {name: 'text'}];
              this.$data_field.val(JSON.stringify(data));
            }
            _.each(data, function(block_data){
                if(_.isString(block_data.name)) {
                    var $control = $('.vc_teaser-btn-' + block_data.name, this.$toolbar).prop('checked', true);
                    if(block_data.name == 'image' && !_.isUndefined(block_data.image)) {
                        if(block_data.image !== 'featured') {
                            this.custom_image_attributes = {id: block_data.image};
                            block_data.mode = 'custom';
                        } else {
                            block_data.mode = 'featured';
                        }
                    } else if(block_data.name == 'text') {
                        if(block_data.mode === 'custom') {
                          this.custom_text = block_data.text;
                        }
                    }
                    this.createControl(block_data);
                    this.$spinner.hide();

                }
            }, this);
            this.$spinner.hide();
        }
    });
    $(function(){
        if ($('#vc_teaser').is('div')) {
            vc.teaser = new VCTeaser();
        }
    });
})(window.jQuery);