jQuery(document).ready(function ($) {
    

    if( typeof jQuery.wp === 'object' && typeof jQuery.wp.wpColorPicker === 'function' ){
            $('input.color-field').wpColorPicker({
                palettes: ['#27CCC0', '#78cd6e', '#29c1e7', '#ae81f9', '#f78224', '#FF4629']
            });
        }
        else {
           $( '.colorpicker' ).farbtastic( 'input.color-field' );
        }


/**
 * Meta fields toggle for pages
 *
 */
 function ht_dependency_check(){
    var page_meta_box_elements = $('.ht-metaboxes-wrapper > .ht-meta-option '),
        dep_elements = new Array();
        page_meta_box_elements.each(function(){
            dep_elements.push($(this).attr('data-element'));
        });
        var unique_elements = [];
        $.each(dep_elements, function(i, el){
            if($.inArray(el, unique_elements) === -1) unique_elements.push(el);
        });
        page_meta_box_elements.each(function(){
            var $that = $(this);
            var dep_values = $(this).attr('data-values');
            var dep_values_array = dep_values.split(" ");
            var dep_element = $(this).attr('data-element');

            if(dep_element.length > 0 ){
                $that.css('display', 'none');
                $("#"+dep_element).live('change keyup', function(){
                    var the_value = $(this).val();
                    // if dependency value was array
                    if(dep_values_array.length > 1) {
                        var in_array = false;
                        for(i=0;i<dep_values_array.length;i++){
                           if(the_value == dep_values_array[i]) {
                                in_array = true;
                            }                            
                        }
                        if(in_array) {
                            $that.fadeIn();
                        } else {
                            $that.fadeOut();

                        }


                    } else {
                       if(the_value == dep_values) {
                            $that.fadeIn();
                        } else {
                            $that.fadeOut();
                        } 
                    }
                    

                });

            } 

        });

        $(unique_elements).each(function(){
            $('#'+this).trigger('change');
        });;

 }
 
   ht_dependency_check();


/**
 * Upload Multiple Image
 * 
 */

 function ht_upload_muliple_image() {

    $('.ht_upload_image').click(function () {

        var fieldID = $(this).attr('id'),
            activeFileUploadContext = $(this).parent(),
            wp_version = parseFloat($(this).data('version'));

        if (wp_version >= 3.5) {

            custom_file_frame = null;
            custom_file_frame = wp.media.frames.customHeader = wp.media({

                title: $(this).data('title'),
                editing: true,
                multiple: true,
                library: {
                    type: 'image'
                },

            });

            custom_file_frame.on("select", function () {

                // Grab the selected attachment.
                var selection = custom_file_frame.state().get('selection').toJSON();
                var thumbnailURLS = [],
                    imageURLS = [],
                    imageWidths = [],                   
                    imageIDS = [];

                selection.map(function (attach) {
                    if(attach.width > 150 ) {
                        thumbnailURLS.push(attach.sizes.thumbnail.url);
                    } else {
                        thumbnailURLS.push(attach.url);
                    }
                    imageURLS.push(attach.url);
                    imageIDS.push(attach.id);
                    imageWidths.push(attach.width);

                });
                if (thumbnailURLS.length > 0) {
                    var html = '';
                    for (var i = 0; i < thumbnailURLS.length; i++) {

                        html = html + '\
                                <li> \
                                    <input type="hidden" name="' + fieldID + '[]" value="' + imageIDS[i] + '" />\
                                    <img width="150" height="150" class="thumbnail" src="' + thumbnailURLS[i] + '" />\
                                    <br/>\
                                    <a href="#" style="text-decoration: none" class="remove-image">[X]</a>\
                                </li> \
                            ';
                    }
                    $('#' + fieldID + '-holder.image-holder').append(html);
                }


            });
            custom_file_frame.open();

        } else {


            var fieldID = $(this).attr('id');
            tb_show('', 'media-upload.php?type=image&TB_iframe=true');
            window.send_to_editor = function (html) {

                var imgurl = $('img', html).attr('src');
                var thumbSize = imgurl.match(/\.(jpg|jpeg|png|gif)$/i);
                var imgSize = imgurl.match(/-(\d+)x(\d+)\.(jpg|jpeg|png|gif)$/i);
                var imgID = html.match(/wp-image-(\d+)/);

                if (imgSize) {
                    imgurl = imgurl.replace(imgSize[0], '.' + imgSize[3]);
                }
                var thumbNail = imgurl.replace(thumbSize[0], '-150x150' + thumbSize[0]);

                if (thumbNail && imgID[1]) {
                    $('#' + fieldID + '-holder.image-holder').append('<li><input type="hidden" name="' + fieldID + '[]" value="' + imgID[1] + '" /><img width="150" height="150" class="thumbnail" src="' + thumbNail + '" /><br/><a href="#" style="text-decoration: none" class="remove-image">[X]</a></li>');
                }

                tb_remove();
            }


        } // end wp version check


    }); // end button click

    // remove the selected image
    $('.image-holder a').live('click', function (event) {
        event.preventDefault();
        $(this).parent().remove();

        return false;
    });


    } // end function



/**
 * Upload Single Image
 * 
 */
    function ht_upload_image() {

        $('.ht_upload_image_single').click(function () {

            var fieldID = $(this).attr('id'),
                activeFileUploadContext = $(this).parent(),
                wp_version = parseFloat($(this).data('version'));

            if (wp_version >= 3.5) {

                custom_file_frame = null;
                custom_file_frame = wp.media.frames.customHeader = wp.media({

                    title: $(this).data('title'),
                    library: {
                        type: 'image'
                    },
      
                });

                custom_file_frame.on("select", function () {
                    
                    var attachment = custom_file_frame.state().get("selection").first();

                    var imgurl    = attachment.attributes.url;
                    var thumbSize = imgurl.match(/\.(jpg|jpeg|png|gif)$/i);
                    var imgSize   = imgurl.match(/-(\d+)x(\d+)\.(jpg|jpeg|png|gif)$/i);
                    var imgID     = attachment.id;

                    if (imgSize) {
                        imgurl = imgurl.replace(imgSize[0], '.' + imgSize[3]);
                    }
                    var thumbNail = imgurl.replace(thumbSize[0], '-150x150' + thumbSize[0]);

                    var img = new Image();
                    img.src = imgurl;
                    if (img.width > 150) {
                    $('.image-holder-single img', activeFileUploadContext).attr('src', thumbNail);

                    } else {
                    $('.image-holder-single img', activeFileUploadContext).attr('src', imgurl);

                    }
                    // Update value of the targetfield input with the attachment url.
                    $('input[type=hidden]#' + fieldID).val(attachment.id);
                    $('.image-holder-single', activeFileUploadContext).show();
                    $('.remove-image', activeFileUploadContext).show();


                });
                custom_file_frame.open();

            } else {

                tb_show('', 'media-upload.php?type=image&TB_iframe=true');

                window.send_to_editor = function (html) {
                    var imgurl = $('img', html).attr('src');
                    var thumbSize = imgurl.match(/\.(jpg|jpeg|png|gif)$/i);
                    var imgSize = imgurl.match(/-(\d+)x(\d+)\.(jpg|jpeg|png|gif)$/i);
                    var imgID = html.match(/wp-image-(\d+)/);

                    if (imgSize) {
                        imgurl = imgurl.replace(imgSize[0], '.' + imgSize[3]);
                    }
                    var thumbNail = imgurl.replace(thumbSize[0], '-150x150' + thumbSize[0]);

                    if (thumbNail && imgID[1]) {
                        $('#' + fieldID + '.image-holder-single img').attr('src', thumbNail);
                    }
                    $('#' + fieldID + '.image-holder-single').show();
                    $('#' + fieldID + '.image-holder-single .remove-image').show();

                    $('input[type=hidden]#' + fieldID + '').val(imgID[1]);

                    tb_remove();
                }

            } // end wp version check

            return false;

        }); // end button click

        // remove the image
        $('.image-holder-single a').live('click', function (event) {

            var activeFileUploadContext = $(this).parents('td');
            var image_holder = $(this).closest('.image-holder-single');

            var relid = $(this).data('relid');

            event.preventDefault();

            $('input[type=hidden]#' + relid).val('');
            $(image_holder).fadeOut('slow');
            $(this).fadeOut('slow');

        });



    } // end function


    ht_upload_image();
    ht_upload_muliple_image();

});// end jquery