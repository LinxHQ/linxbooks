<?php
/**
 *  New type for icons
 */
function ht_icon_settings_field($settings, $value) {
   $dependency = vc_generate_dependencies_attributes($settings);
   $out = '<div class="panel-icon">'
         .'<input name="'.$settings['param_name']
                   .'" class="wpb_vc_param_value wpb-textinput icon_class '
                   .$settings['param_name'].' '.$settings['type'].'_field" type="hidden" value="'
                   .$value.'" ' . $dependency . '/>';
   $icons = ht_font_awesome_list();
   foreach($icons as $icon) {
      $icon = trim($icon);
      $out .= '<i title="'.$icon.'" class="'.$icon.'"></i>' ."\n";
    }

    $out .='</div>';
    return $out;
}
add_shortcode_param('icon', 'ht_icon_settings_field', get_template_directory_uri().'/includes/vc_mods/vc_extend/vc.js');

/**
 * Remove Front-End Editor
 */
if(function_exists('vc_disable_frontend')){
  vc_disable_frontend();

}

/**
 * Remove the vc teaser content box
 */
add_action( 'admin_head', 'remove_vc_teaser_box' );
function remove_vc_teaser_box() {
  remove_meta_box('vc_teaser','page','side');
  remove_meta_box('vc_teaser','post','side');
  remove_meta_box('vc_teaser','portfolio','side');

}

/**
 * Change the icons of shortcodes
 */
vc_map_update('vc_toggle', 'name', __("Toggle", "highthemes") );

/**
 * Remove some elements
 */
vc_remove_element("vc_wp_meta");
vc_remove_element("vc_wp_search");
vc_remove_element("vc_wp_recentcomments");
vc_remove_element("vc_wp_calendar");
vc_remove_element("vc_wp_pages");
vc_remove_element("vc_wp_tagcloud");
vc_remove_element("vc_wp_custommenu");
vc_remove_element("vc_wp_text");
vc_remove_element("vc_wp_posts");
vc_remove_element("vc_wp_links");
vc_remove_element("vc_wp_categories");
vc_remove_element("vc_wp_archives");
vc_remove_element("vc_wp_rss");
vc_remove_element("vc_images_carousel");
vc_remove_element("vc_basic_grid");


/**
 * Get the portfolio tax/terms
 */
$portfolio_terms = ht_create_terms_list('portfolio-category');
if($portfolio_terms){
    $terms_array = array();
    foreach($portfolio_terms as $term){
        $terms_array[$term['name']]  = $term['slug'];
    }
}
/**
 * Get the categories
 */
  $categories = array();
  $categories_obj = get_categories('hide_empty=0');
  foreach ($categories_obj as $highcat) {
      $categories[$highcat->cat_name] = $highcat->cat_ID;
  }

/**
 * Nested Shortcodes
 */
class WPBakeryShortCode_ht_team extends WPBakeryShortCodesContainer {}
class WPBakeryShortCode_ht_member extends WPBakeryShortCode {}
class WPBakeryShortCode_Ht_Testimonials extends WPBakeryShortCodesContainer {}
class WPBakeryShortCode_Ht_Testimonial extends WPBakeryShortCode {}
class WPBakeryShortCode_Ht_Client_Logos extends WPBakeryShortCodesContainer {}
class WPBakeryShortCode_Ht_Client_Logo extends WPBakeryShortCode {}
class WPBakeryShortCode_Ht_Features extends WPBakeryShortCodesContainer {}
class WPBakeryShortCode_Ht_Feature extends WPBakeryShortCode {}
class WPBakeryShortCode_Ht_Content_Boxes extends WPBakeryShortCodesContainer {}
class WPBakeryShortCode_Ht_Content_Box extends WPBakeryShortCode {}
class WPBakeryShortCode_Ht_Services extends WPBakeryShortCodesContainer {}
class WPBakeryShortCode_Ht_Service_Item extends WPBakeryShortCode {}


/**
  * Re-defining vc_row
  */ 
vc_map( array(
   "name"                    => __("Row", "highthemes"),
   "base"                    => "vc_row",
   "is_container"            => true,
    'icon'                   => 'icon-wpb-row',
   "show_settings_on_create" => false,
   "description"             => __("Row generator; to create rows, full secsions, parallaxes.","highthemes"),
   "category"                => __('Content', 'highthemes'),
   "params"                  => array(
      array(
         "type" => "checkbox",
         "heading" => __("Full Width Section", "highthemes"),
         "param_name" => "full_width",
         "value" =>Array(__("Yes", "highthemes") => 'yes'),
         "description" => __("Check this box if you would like to make a full width section.", "highthemes")
      ),
      array(
      "type"        => "colorpicker",
      "heading"     => __("Custom Background Color", "wpb"),
      "param_name"  => "bg_color",
      "description" => __("Select your desired custom background color.", "wpb")
    ),
    array(
      "type"        => "attach_image",
      "heading"     => __('Background Image', 'wpb'),
      "param_name"  => "bg_image",
      "description" => __("Select a background image.", "wpb")
    ),
    array(
      "type"       => "dropdown",
      "heading"    => __('Background Repeat', 'wpb'),
      "param_name" => "bg_image_repeat",
      "value"      => array(
                        __("Default", 'wpb')   => '',
                        __('Contain', 'wpb')   => 'contain',
                        __('No Repeat', 'wpb') => 'no-repeat'
                      ),
      "description" => __("Select background image repeat type here.", "wpb"),
      "dependency"  => Array('element' => "bg_image", 'not_empty' => true)
    ),
    array(
       "type"       => "dropdown",
       "heading"    => __("Background Position", "highthemes"),
       "param_name" => "bg_pos",
       "value"      => array(
                        __("Left Top", "highthemes")      => 'left top',
                        __("Left Bottom", "highthemes")   => 'left bottom',
                        __("Left Center", "highthemes")   => 'left center',
                        __("Right Top", "highthemes")     => 'right top',
                        __("Right Bottom", "highthemes")  => 'right bottom',
                        __("Right Center", "highthemes")  => 'right center',
                        __("Center Top", "highthemes")    => 'center top',
                        __("Center Bottom", "highthemes") => 'center bottom',
                        __("Center Center", "highthemes") => 'center center'
                      ),
       "description" => __("Select background image position here.", "highThemes")
    ),      
      array(
         "type"        => "checkbox",
         "heading"     => __("Parallax?", "highthemes"),
         "param_name"  => "parallax",
         "value"       =>Array(__("Yes", "highthemes") => 'yes'),
         "description" => __("Check this box if you would like to have a parallax section.", "highthemes")
      ),  
      array(
         "type"        => "checkbox",
         "heading"     => __("Border?", "highthemes"),
         "param_name"  => "border",
         "value"       =>Array(__("Yes", "highthemes") => 'yes'),
         "description" => __("Check this box if you would like to add border to the section.", "highthemes")
      ),  
      array(
         "type"       => "dropdown",
         "heading"    => __("Text Color", "highthemes"),
         "param_name" => "text_color",
         "value"      => array(
                          __("Dark", "highthemes") => 'dark',
                          __("Light", "highthemes") => 'light'
                        ),
         "description" => __("Select text color here. You should select 'dark' where you have light backgrounds and select 'light' where you have dark backgrounds.", "highThemes")
      ), 
      array(
         "type"       => "dropdown",
         "heading"    => __("Text Align", "highthemes"),
         "param_name" => "text_align",
         "value"      => array(
                          __("Default", "highthemes") => '',
                          __("Left", "highthemes")    => 'left',
                          __("Right", "highthemes")   => 'right',
                          __("Center", "highthemes")  => 'center'
                        ),
         "description" => __("Select text align.", "highThemes")
      ),               
      array(
         "type"        => "textfield",
         "heading"     => __("Top Padding", "highthemes"),
         "param_name"  => "top_padding",
         "description" => __("Insert top padding value. Please just insert a number and don't include any thing else such as 'px' and ...", "highthemes")
      ),
      array(
         "type"        => "textfield",
         "heading"     => __("Bottom Padding", "highthemes"),
         "param_name"  => "bottom_padding",
         "description" => __("Insert bottom padding value. Please just insert a number and don't include any thing else such as 'px' and ...", "highthemes")
      ),   
    array(
      "type"        => "textfield",
      "heading"     => __('Bottom margin', 'wpb'),
      "param_name"  => "margin_bottom",
      "description" => __("Insert bottom margin value. Please just insert a number and don't include any thing else such as 'px' and ...", "wpb")
      ),
      array(
         "type"        => "textfield",
         "heading"     => __("Extra class name", "highthemes"),
         "param_name"  => "el_class",
         "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your custom css codes.", "highthemes")
      )

   ),
"js_view" => 'VcRowView'
) );

// Separator
vc_map( array(
   "name"        => __("Separator", "highthemes"),
   "base"        => "vc_separator",
   "class"       => "",
   "icon"        => "icon-wpb-ui-separator",
   "description" => __("Create horizontal separator.","highthemes"),
   "category"    => __('Content', "highthemes"),
   "params"      => array(
      array(
          "type"       => "dropdown",
          "heading"    => __("Type", "highthemes"),
          "param_name" => "type",
          "value"      => array(
              __("Line","highthemes")         => 'line',
              __("Dotted", "highthemes")      => 'dotted',
              __("Double", "highthemes")      => 'double',
              __("Faded Sides", "highthemes") => 'faded-sides',
          ),
          "description" => __("Select icon size here.", "highThemes")
      ),
      array(
          "type"        => "textfield",
          "heading"     => __("Extra class name", "highthemes"),
          "param_name"  => "el_class",
          "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your custom css codes.", "highthemes")
      ),

    )
));

// Social Icons
vc_map( array(
   "name"        => __("Social Icons", "highthemes"),
   "base"        => "ht_social_icon",
   "class"       => "",
   "icon"        => "icon-wpb-balloon-facebook-left",
   "description" => __("Font Awesome social icon generator.","highthemes"),
   "category"    => __('Content', "highthemes"),
   "params"      => array(
      array(
          "type"       => "dropdown",
          "heading"    => __("Icon", "highthemes"),
          "param_name" => "icon_name",
          "value"      => array(
              __("Twitter","highthemes")      => 'twitter',
              __("Facebook", "highthemes")    => 'facebook',
              __("Dribbble", "highthemes")    => 'dribbble',
              __("Pinterest", "highthemes")   => 'pinterest',
              __("RSS", "highthemes")         => 'rss',
              __("Youtube", "highthemes")     => 'youtube',
              __("Cloud", "highthemes")       => 'cloud',
              __("Flickr", "highthemes")      => 'flickr',
              __("Instagram", "highthemes")   => 'instagram',
              __("Linkedin", "highthemes")    => 'linkedin',
              __("Google Plus", "highthemes") => 'google-plus',
              __("Skype", "highthemes")       => 'skype',
              __("Tumblr", "highthemes")      => 'tumblr',
          ),
          "description" => __("Select icon type here.", "highThemes")
      ),
      array(
          "type"       => "dropdown",
          "heading"    => __("Type", "highthemes"),
          "param_name" => "type",
          "value"      => array(
              __("Rounded","highthemes")   => 'rounded',
              __("Circular", "highthemes") => 'circular',
              __("Simple", "highthemes")   => 'without_border',
          ),
          "description" => __("Select icon type here.", "highThemes")
      ),
      array(
          "type"       => "dropdown",
          "heading"    => __("Style", "highthemes"),
          "param_name" => "style",
          "value"      => array(
              __("With Color","highthemes")  => 'with_color',
              __("Gray Scale", "highthemes") => 'gray_scale',
          ),
          "description" => __("Select icon style here.", "highThemes")
      ),
      array(
          "type"        =>  "textfield",
          "heading"     =>  __("Tooltip Text", "highthemes"),
          "param_name"  =>  "tooltip",
          "description" =>  __("Insert the tooltip text that you want to be shown when the mouse hovers on.", "highthemes")
      ),
      array(
          "type"        => "textfield",
          "heading"     => __("Extra class name", "highthemes"),
          "param_name"  => "el_class",
          "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your custom css codes.", "highthemes")
      ),
    )
));

// HT_Icon

vc_map( array(
   "name"        => __("Icons", "highthemes"),
   "base"        => "ht_icon",
   "class"       => "",
   "icon"        =>'ht-logo',
   "description" => __("Font Awesome icon generator with many options such as link.","highthemes"),
   "category"    => __('Content', "highthemes"),
   "params"      => array(
      array(
         "type"        => "icon",
         "class"       => "",
         "heading"     => __("Icon", "highthemes"),
         "param_name"  => "icon_name",
         "value"       => "",
         "description" => __("Choose an icon from the list.", "highthemes")
      ),
      array(
          "type"       => "dropdown",
          "heading"    => __("Type", "highthemes"),
          "param_name" => "type",
          "value"      => array(
              __("Rounded","highthemes")                    => 'rounded',
              __("Circular", "highthemes")                  => 'circular',
              __("Without Border", "highthemes")            => 'without_border',
              __("Gray Scale Rounded", "highthemes")        => 'gray-scale rounded',
              __("Gray Scale Circular", "highthemes")       => 'gray-scale circular',
              __("Gray Scale Without Border", "highthemes") => 'gray-scale without_border',
          ),
          "description" => __("Select icon type here.", "highThemes")
      ),
      array(
        "type"        => "dropdown",
        "heading"     => __("Color", "highthemes"),
        "param_name"  => "color",
        "description" => __("Select your desired icon color here. Note that you can select <strong>Custom</strong> option to appear a colorpicker to select a custom color", "highthemes"),
        "value"       => array(
                      __("Accent", "highthemes")           => 'accent',
                      __("Blueberry", "highthemes")        => '#5486da',
                      __("Android green", "highthemes")    => '#9AD147',
                      __("Blue", "highthemes")             => '#5200FF',
                      __("Azure", "highthemes")            => '#09F',
                      __("Red", "highthemes")              => '#F00',
                      __("Aqua", "highthemes")             => '#2FEFF7',
                      __("Blast-off bronze", "highthemes") => '#A58080',
                      __("Gray", "highthemes")             => '#809FA5',
                      __("Caribbean green", "highthemes")  => '#3DE4B5',
                      __("Custom", "highthemes")           => 'custom',
        ),
      ),
      array(
         "type"        => "colorpicker",
         "heading"     => __("Custom Icon Color", "highthemes"),
         "param_name"  => "custom_color",
         "value"       => "",
         "description" => __("Select a custom color for icon.", "highthemes"),
         "dependency"  => Array("element" => "color", "value" => "custom")
      ),
      array(
          "type"        =>  "textfield",
          "heading"     =>  __("Tooltip Text", "highthemes"),
          "param_name"  =>  "tooltip",
          "description" =>  __("Insert the tooltip text that you want to be shown when the mouse hovers on.", "highthemes")
      ),
      array(
         "type"        => "textfield",
         "heading"     => __("Link", "highthemes"),
         "param_name"  => "link",
         "value"       => "",
         "description" => __("If you would like that the icon has a link, insert a complete link here. Like: http://example.com", "highthemes")
      ),
      array(
         "type"        => "checkbox",
         "heading"     => __("Open link in new page?", "highthemes"),
         "param_name"  => "target",
         "value"       => Array(__("Yes", "highthemes") => '_blank'),
         "description" => __("If you have a link for the icon, set the target for that link.", "highthemes")
      ),
      array(
      "type"        => "textfield",
      "heading"     => __("Extra class name", "highthemes"),
      "param_name"  => "el_class",
      "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your custom css codes.", "highthemes")
      ),
   )
) );


/*
content_box
-----------------------------------------------------------------*/
vc_map( array(
      "name"        => __("Content Box", "highthemes"),
      "base"        => "ht_content_boxes",
      "class"       => "",
      "icon"        =>'ht-logo',
      "as_parent"   => array('only' => 'ht_content_box'), 
      // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
      "category"    => __('Content', "highthemes"),
      "content_element"         => true,
      "show_settings_on_create" => false,
      "description" =>  __('A box with icon and some styles.','highthemes'),
      "params"      => array(
        array(
           "type"        => "textfield",
           "heading"     => __("Extra class name", "highthemes"),
           "param_name"  => "el_class",
           "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "highthemes")
        ),
      ),
      "js_view"     => 'VcColumnView'
));
vc_map( array(
     "name"     => __("Content Box", "highthemes"),
     "base"     => "ht_content_box",
    // "icon"     => "fa-file-text",
     "as_child" => array('only' => 'ht_content_boxes'),
     "params"   => array(
        array(
             "type"        => "textfield",
             "class"       => "",
             "heading"     => __("Title", "highthemes"),
             "param_name"  => "title",
             "value"       => "",
             "description" => __("Enter the content box title here.", "highthemes")
             ),
        array(
           "type"        => "textarea",
           "heading"     => __("Content", "highthemes"),
           "param_name"  => "content",
           "value"       => "",
           "description" => __("Insert your desired box content here.", "highthemes")
        ),
        array(
           "type"        => "icon",
           "class"       => "",
           "heading"     => __("Icon", "highthemes"),
           "param_name"  => "icon_name",
           "value"       => "",
           "description" => __("Choose an icon from the list.", "highthemes")
        ),
        array(
           "type"        => "textfield",
           "heading"     => __("Link", "highthemes"),
           "param_name"  => "link",
           "value"       => "",
           "description" => __("If you would like that the icon has a link, insert a complete link here. Like: http://example.com", "highthemes")
        ),
        array(
           "type"        => "checkbox",
           "heading"     => __("Open link in new page?", "highthemes"),
           "param_name"  => "target",
           "value"       => Array(__("Yes", "highthemes") => '_blank'),
           "description" => __("If you have a link for the icon, set the target for that link.", "highthemes")
        ),
        array(
           "type"        => "textfield",
           "heading"     => __("Extra class name", "highthemes"),
           "param_name"  => "el_class",
           "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "highthemes")
        ),
      ),
));

//Info Box

vc_map( array(
   "name"        => __("Info Box", "highthemes"),
   "base"        => "ht_info_box",
   "description" => __("Information box generator with different colors.","highthemes"),
   "class"       => "",
   "icon"        =>'ht-logo',
   "category"    => __('Content', "highthemes"),
   "params"      => array(
    array(
         "type"        => "textfield",
         "class"       => "",
         "heading"     => __("Title", "highthemes"),
         "param_name"  => "title",
         "value"       => "",
         "description" => __("Enter the info box title here.", "highthemes")
         ),
     array(
         "type"        => "dropdown",
         "heading"     => __("Type", "highthemes"),
         "param_name"  => "type",
         "value"       => array(
            __("Success", "highthemes") => "success",
            __("Info", "highthemes")    => "info",
            __("Error","highthemes")    => "error",
            __("Warning","highthemes")  => "warning",
          ),
         "description" => __("Select the heading size here. If you select 1, you will get h1 and so forth.", "highthemes")
     ),
      array(
         "type"        => "textarea_html",
         "heading"     => __("Content", "highthemes"),
         "param_name"  => "content",
         "value"       => "",
         "description" => __("Insert your desired box content here.", "highthemes")
      ),
      array(
         "type"        => "textfield",
         "heading"     => __("Extra class name", "highthemes"),
         "param_name"  => "el_class",
         "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "highthemes")
      )
   )
) );

//fancy title
vc_map( array(
   "name"     => __("Fancy Title", "highthemes"),
   "base"     => "ht_fancy_title",
   "class"    => "",
   "description" => __("Creating fancy titles. Options: link, icon, style","highthemes"),
   "icon"        =>'ht-logo',
   "category" => __('Content', "highthemes"),
   "params"   => array(
      array(
         "type"        => "textfield",
         "class"       => "",
         "heading"     => __("Title", "highthemes"),
         "param_name"  => "content",
         "value"       => "",
         "description" => __("Insert the title here.", "highthemes")
      ),      
     array(
         "type"        => "dropdown",
         "heading"     => __("Size", "highthemes"),
         "param_name"  => "size",
         "value"       => array(
            __("H1", "highthemes") => "1",
            __("H2", "highthemes") => "2",
            __("H3","highthemes")  => "3",
            __("H4","highthemes")  => "4",
            __("H5","highthemes")  => "5",
            __("H6","highthemes")  => "6",
          ),
         "description" => __("Select the heading size here. If you select 1, you will get h1 and so forth.", "highthemes")
     ),
     array(
          "type"       => "dropdown",
          "heading"    => __("Type", "highthemes"),
          "param_name" => "type",
          "value"   => array(
            __("Linear", "highthemes")       => "liner",
            __("Double", "highthemes")       => "double",
            __("Double Press","highthemes")  => "doublepress",
            __("Dotted","highthemes")        => "dotted",
            __("Dashed","highthemes")        => "dashed",
            __("Inside Linear","highthemes") => "inside_liner",
            __("Inside Pat","highthemes")    => "inside_pat",
            __("Dotted Line","highthemes")   => "dotted_line",
            __("Dashed Line","highthemes")   => "dashed_line",
            __("Line Line","highthemes")     => "line_line",
          ),
         "description" => __("Select the fancy title style.", "highthemes")
     ),
     array(
          "type"       => "dropdown",
          "heading"    => __("Align", "highthemes"),
          "param_name" => "align",
          "value"   => array(
              __("Left", "highthemes")   => "left",
              __("Center", "highthemes") => "center",
              __("Right","highthemes")   => "right",
          ),
         "description" => __("Select the fancy title style.", "highthemes")
     ),
    array(
      "type"        => "colorpicker",
      "heading"     => __("Color", "highthemes"),
      "param_name"  => "color",
      "description" => __("Select custom color for the title.", "highthemes"),
    ),
      array(
         "type"        => "textfield",
         "heading"     => __("Extra class name", "highthemes"),
         "param_name"  => "el_class",
         "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your custom css codes.", "highthemes")
      )
   )
) );

/*
= Progress Bar
-------------------------------------*/
vc_map( array(
  "name"     => __("Progress Bar", "highthemes"),
  "base"     => "vc_progress_bar",
  "description" => __("Creating progressbars and group of progressbars.","highthemes"),
  "icon"     => "icon-wpb-graph",
  "category" => __('Content', 'highthemes'),
  "params"   => array(
    array(
      "type"        => "textfield",
      "heading"     => __("Main Title", "highthemes"),
      "param_name"  => "title",
      "description" => __("Insert a title for all bars in this widget. Leave blank if no title is needed.", "highthemes")
    ),
    array(
      "type"        => "exploded_textarea",
      "heading"     => __("Graphic values", "highthemes"),
      "param_name"  => "values",
      "description" => __('Input graph values here. The third value is a custom color (this value is also optional) to set a specific background color for desired bar.  Divide values with linebreaks (Enter). Example: 90|Development OR: 90|Development|#FF0088 ', 'highthemes'),
      "value"       => "90|Development,80|Design|#FF0088,70|Marketing"
    ),
    array(
      "type"        => "textfield",
      "heading"     => __("Units", "highthemes"),
      "param_name"  => "units",
      "description" => __("Enter measurement units (if needed) Eg. %, px, points, etc. Graph value and unit will be appended to the graph title.", "highthemes")
    ),
    array(
      "type"        => "colorpicker",
      "heading"     => __("Title custom color", "highthemes"),
      "param_name"  => "custom_title_color",
      "description" => __("Select custom background color for text.", "highthemes"),
      "dependency"  => Array(
            'element' => "title_color",
            'value'   => array('custom')
      )
    ),
    array(
      "type"       => "dropdown",
      "heading"    => __("Bar color", "highthemes"),
      "param_name" => "bgcolor",
      "value"      => array(
            __("Accent", "highthemes")           => 'accent',
            __("Blueberry", "highthemes")        => 'color1',
            __("Android green", "highthemes")    => 'color2',
            __("Blue", "highthemes")             => 'color3',
            __("Azure", "highthemes")            => 'color4',
            __("Red", "highthemes")              => 'color5',
            __("Aqua", "highthemes")             => 'color6',
            __("Blast-off bronze", "highthemes") => 'color7',
            __("Gray", "highthemes")             => 'color8',
            __("Caribbean green", "highthemes")  => 'color9',
            __("Custom", "highthemes")           => 'custom',
      ),
      "description" => __("Select your desired color here. Note that you can select <strong>Custom</strong> option to appear a colorpicker to select a custom color", "highthemes"),
      "admin_label" => true
    ),
    array(
      "type"        => "colorpicker",
      "heading"     => __("Bar custom color", "highthemes"),
      "param_name"  => "custombgcolor",
      "description" => __("Select custom background color for bars.", "highthemes"),
      "dependency"  => Array('element' => "bgcolor", 'value' => array('custom'))
    ),
    array(
      "type"       => "checkbox",
      "heading"    => __("Options", "highthemes"),
      "param_name" => "options",
      "value"      => array(
        __("Add Stripes?", "highthemes")                                      => "striped",
        __("Add animation? Will be visible with striped bars.", "highthemes") => "animated")
    ),
    array(
      "type"        => "textfield",
      "heading"     => __("Extra class name", "highthemes"),
      "param_name"  => "el_class",
      "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "highthemes")
    ),
  )
) );

/* Accordion block
---------------------------------------------------------- */
vc_map( array(
  "name"                    => __("Accordion", "highthemes"),
  "base"                    => "vc_accordion",
  "show_settings_on_create" => false,
  "is_container"            => true,
  "icon"                    => "icon-wpb-ui-accordion",
  "description"             => __("Creating accordion tabs by setting icons, aglignments and colors.","highthemes"),
  "category"                => __('Content', 'highthemes'),
  "params"                  => array(
    array(
      "type"        => "textfield",
      "heading"     => __("Title", "highthemes"),
      "param_name"  => "title",
      "description" => __("Insert the widget title. Leave blank if no title is needed.", "highthemes")
    ),
    array(
      "type"        => "textfield",
      "heading"     => __("Active tab", "highthemes"),
      "param_name"  => "active_tab",
      "description" => __("Enter tab number to be active on load or enter false to collapse all tabs.", "highthemes")
    ),
    array(
      "type"        => 'checkbox',
      "heading"     => __("Allow collapsible all", "highthemes"),
      "param_name"  => "collapsible",
      "description" => __("Select checkbox to allow for all sections to be be collapsible.", "highthemes"),
      "value"       => Array(__("Allow", "highthemes") => 'yes')
    ),
    array(
      "type"        => "textfield",
      "heading"     => __("Extra class name", "highthemes"),
      "param_name"  => "el_class",
      "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your custom css codes.", "highthemes")
    )
  ),
  "custom_markup" => '
  <div class="wpb_accordion_holder wpb_holder clearfix vc_container_for_children">
  %content%
  </div>
  <div class="tab_controls">
  <button class="add_tab" title="'.__("Add accordion section", "highthemes").'">'.__("Add accordion section", "highthemes").'</button>
  </div>
  ',
  'default_content' => '
  [vc_accordion_tab title="'.__('Section 1', "highthemes").'"][/vc_accordion_tab]
  [vc_accordion_tab title="'.__('Section 2', "highthemes").'"][/vc_accordion_tab]
  ',
  'js_view' => 'VcAccordionView'
) );

vc_map( array(
  "name"                      => __("Accordion Section", "highthemes"),
  "base"                      => "vc_accordion_tab",
  "allowed_container_element" => 'vc_row',
  "is_container"              => true,
  "content_element"           => false,
  "params"                    => array(
    array(
      "type"        => "textfield",
      "heading"     => __("Title", "highthemes"),
      "param_name"  => "title",
      "description" => __("Accordion section title.", "highthemes")
    ),
  ),
  'js_view' => 'VcAccordionTabView'
) );


/* HT_Button
---------------------------------------------------------- */
vc_map( array(
  "name"        => __("Button", "highthemes"),
  "base"        => "ht_button",
  "icon"        => "icon-wpb-ui-button",
  "description" => __("Button generator with icon and style options.","highthemes"),
  "category"    => __('Content', 'highthemes'),
  "params"      => array(
    array(
      "type"        => "textfield",
      "heading"     => __("Title", "highthemes"),
      "param_name"  => "title",
      "value"       => __("Button Title", "highthemes"),
      "description" => __("Text on the button.", "highthemes")
    ),
    array(
      "type"        => "dropdown",
      "heading"     => __("Type", "highthemes"),
      "param_name"  => "type",
      "description" => "Select the button size.",
      "value"       => Array(
          __('Normal','highthemes') =>  'normal',
          __('Fancy','highthemes')  =>  'fancy',
        )
    ),
    array(
      "type"        => "dropdown",
      "heading"     => __("Size", "highthemes"),
      "param_name"  => "size",
      "description" => "Select the button size.",
      "value"       => Array(
          __('small','highthemes')  =>  'small',
          __('medium','highthemes') =>  'medium',
          __('large','highthemes')  =>  'large'
        ),
      "dependency" => array("element" => "type", "value" => "normal"),
    ),
    array(
       "type"        => "icon",
       "class"       => "",
       "heading"     => __("Icon", "highthemes"),
       "param_name"  => "icon_name",
       "value"       => "",
       "description" => __("Choose an icon from the list.", "highthemes")
    ),
    array(
      "type"       => "dropdown",
      "heading"    => __("Color", "highthemes"),
      "param_name" => "color",
      "value"      => array(
                      __("Accent", "highthemes")           => 'accent',
                      __("Blueberry", "highthemes")        => '',
                      __("Android green", "highthemes")    => 'color2',
                      __("Blue", "highthemes")             => 'color3',
                      __("Azure", "highthemes")            => 'color4',
                      __("Red", "highthemes")              => 'color5',
                      __("Aqua", "highthemes")             => 'color6',
                      __("Blast-off bronze", "highthemes") => 'color7',
                      __("Gray", "highthemes")             => 'color8',
                      __("Caribbean green", "highthemes")  => 'color9',
                      __("Custom", "highthemes")           => 'custom',
                      ),
      "description" =>  __("Select your desired button text color here.","highthemes"),
    ),
    array(
      "type"        => "colorpicker",
      "heading"     => __("Custom Base Color", "highthemes"),
      "param_name"  => "custom_color",
      "value"       => "",
      "description" => __("Select a custom color as the base color for milestone items.", "highthemes"),
      "dependency"  => Array("element" => "color", "value" => "custom")
    ),
    array(
      "type"        => "textfield",
      "heading"     => __("URL (Link)", "highthemes"),
      "param_name"  => "link",
      "description" => __("If you would like to have a link for the button, insert the full URL here. Example: http://example.com", "highthemes")
    ),
    array(
      "type"       => "checkbox",
      "heading"    => __("Open in a new tab?", "highthemes"),
      "param_name" => "target",
      "value"      => Array(__("Yes", "highthemes") => '_blank'),
    ),
    array(
       "type"        => "textfield",
       "heading"     => __("Extra class name", "highthemes"),
       "param_name"  => "el_class",
       "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your custom css codes.", "highthemes")
    )
  )
));

/* ht_google_map
---------------------------------------------------------- */
vc_map( array(
  "name"        => __("Multi-Locatoin Map", "highthemes"),
  "base"        => "ht_google_map",
  "icon"        => "icon-wpb-map-pin",
  "description" => __("Google map generator to define one or many locations.","highthemes"),
  "category"    => __('Content', 'highthemes'),
  "params"      => array(
    array(
      "type"        => "exploded_textarea",
      "heading"     => __("Map Values", "highthemes"),
      "param_name"  => "values",
      "description" => __('Input google map points values here. Divide values with linebreaks (Enter). Example: 51.466502|-0.283456|text', 'highthemes'),
      "value"       => ""
    ),
    array(
      "type"        => "textfield",
      "heading"     => __("Height", "highthemes"),
      "param_name"  => "height",
      "value"       => "",
      "description" => __("Height of google map. Don't include px.", "highthemes")
    ),

    array(
      "type"        => "textfield",
      "heading"     => __("Zoom", "highthemes"),
      "param_name"  => "zoom",
      "value"       => "",
      "description" => __("Insert a number between 1 and 19", "highthemes")
    ),

    array(
      "type"        => "dropdown",
      "heading"     => __("Map Type", "highthemes"),
      "param_name"  => "type",
      "description" => __("Select google map type here.","highthemes"),
      "value"       => array(
              __("ROADMAP", "highthemes")   => 'ROADMAP',
              __("SATELLITE", "highthemes") => 'SATELLITE',
              __("HYBRID", "highthemes")    => 'HYBRID',
              __("TERRAIN", "highthemes")   => 'TERRAIN'
      )
    ),
    array(
      "type"       => "checkbox",
      "heading"    => __("Full Width Map?", "highthemes"),
      "param_name" => "fullwidth",
      "value"      => Array(__("Yes", "highthemes") => 'yes'),
    ),    
      array(
         "type"        => "textfield",
         "heading"     => __("Extra class name", "highthemes"),
         "param_name"  => "el_class",
         "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your custom css codes.", "highthemes")
      )
  )
));

/* ht_portfolio
---------------------------------------------------------- */
vc_map( array(
  "name"        => __("Portfolio", "highthemes"),
  "base"        => "ht_portfolio",
   "icon"        =>'ht-logo',
  "description" => __("Portfolio generator with Grid and Carousel styles.","highthemes"),
  "category"    => __('Content', 'highthemes'),
  "params"      => array(
        array(
      "type"       => "dropdown",
      "heading"    => __("Layout Type", "highthemes"),
      "param_name" => "layout",
      "value"      => array(
          __("Grid", "highthemes")     => "grid", 
          __("Carousel", "highthemes") => "carousel", 
      ),
      "description" => __("Select the portfolio layout here.","highthemes")
    ), 
    array(
      "type"        => "textfield",
      "heading"     => __("Carousel Title", "highthemes"),
      "param_name"  => "carousel_title",
      "value"       => "",
      "description" => __("Insert the carousel title here.", "highthemes"),
      "dependency"  =>  array("element" =>  "layout", "value"  =>  array("carousel") ),
    ),  
    array(
      "type"        => "textarea",
      "heading"     => __("Carousel Description", "highthemes"),
      "param_name"  => "carousel_desc",
      "description" => __("Enter a short description for the carousel items.", "highthemes")  ,    
      "dependency"  =>  array("element" =>  "layout", "value"  =>  array("carousel") )

    ),      
    array(
      "type"        => "dropdown",
      "heading"     => __("Carousel Alignment", "highthemes"),
      "description" => __("Select the carousel alignment.", "highthemes"),
      "param_name"  => "alignment",
      "value"       => array(
                      __("Left", "highthemes")  => 'left',
                      __("Right", "highthemes") => 'right'
                      ),
    "dependency"  =>  array("element" =>  "layout", "value"  =>  array("carousel") ),

    ),            
    array(
      "type"       => "dropdown",
      "heading"    => __("Columns Count", "highthemes"),
      "param_name" => "columns",
      "value"      => array(
                      __("2 Columns", "highthemes") => '2',
                      __("3 Columns", "highthemes") => '3',
                      __("4 Columns", "highthemes") => '4'
                      ),
      "description" =>  __("Select the columns count","highthemes"),
      "dependency"  =>  array("element" =>  "layout", "value"  =>  array("grid" ) ),

    ),
   
    array(
      "type"        => "textfield",
      "heading"     => __("Items Count", "highthemes"),
      "param_name"  => "items_count",
      "value"       => "",
      "description" => __("Insert the item count here. The deafult value is 9", "highthemes")
    ),

    array(
      "type"        => "checkbox",
      "heading"     => __("Categories", "highthemes"),
      "description" => __("Check the categories you would like to include.","highthemes"),
      "param_name"  => "categories",
      "value"       => $terms_array,
    ),
    array(
      "type"        => "textfield",
      "heading"     => __("Include Item's IDs", "highthemes"),
      "param_name"  => "post_ids",
      "value"       => "",
      "description" => __("Use a comma separated list of portfolio items ids you want to show.", "highthemes")
    ), 
    array(
      "type"        => "textfield",
      "heading"     => __("Exclude Item's IDs", "highthemes"),
      "param_name"  => "exclude_ids",
      "value"       => "",
      "description" => __("Use a comma separated list of portfolio items ids you want not to show.", "highthemes")
    ),    
    array(
      "type"        => "checkbox",
      "heading"     => __("Disable Filters", "highthemes"),
      "param_name"  => "disable_filter",
      "value"       => Array(__("Yes", "highthemes") => 'yes'),
      "description" => __("Check this checkbox if you would like to disable filter.","highthemes"),
      "dependency"  => array("element" =>  "layout", "value"  =>  array("grid" ) ),
    ),  
    array(
      "type"       => "dropdown",
      "heading"    => __("Thumbnail Size", "highthemes"),
      "param_name" => "thumbnail_size",
      "value"      => array( 
          __("Portfolio Thumbnail 600x400 px", "highthemes") => "portfolio-thumbnail", 
          __("Large", "highthemes") => "large", 
          __("Full", "highthemes") => "full" 
                    ),
      "dependency"  =>  array("element" =>  "layout", "value"  =>  array("grid" ) ),
      "description" => __("Select the thumbnail size.","highthemes"),
    ),
    array(
      "type"       => "dropdown",
      "heading"    => __("Order by", "highthemes"),
      "param_name" => "orderby",
      "value"      => array(
        __("Date", "highthemes")          => "date",
        __("ID", "highthemes")            => "ID",
        __("Author", "highthemes")        => "author",
        __("Title", "highthemes")         => "title",
        __("Modified", "highthemes")      => "modified",
        __("Random", "highthemes")        => "rand",
        __("Comment count", "highthemes") => "comment_count",
        __("Menu order", "highthemes")    => "menu_order"
      ),
        "description"                      => sprintf(__('Select how to sort retrieved posts. More at %s.', 'highthemes'), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>')
    ),
    array(
      "type"       => "dropdown",
      "heading"    => __("Order way", "highthemes"),
      "param_name" => "order",
      "value"      => array(
        __("Descending", "highthemes") => "DESC",
        __("Ascending", "highthemes")  => "ASC"
      ),
      "description" => sprintf(__('Designates the ascending or descending order. More at %s.', 'highthemes'), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>')
    ),
      array(
         "type"        => "textfield",
         "heading"     => __("Extra class name", "highthemes"),
         "param_name"  => "el_class",
         "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your custom css codes.", "highthemes")
      )       
  )
));

/* ht_CTA
----------------------------------------------------*/
vc_map( array(
  "name"        => __("Call To Action", "highthemes"),
  "base"        => "ht_cta",
   "icon"        =>'ht-logo',
  "description" => __("Call To Action with button, title and subtitle options.","highthemes"),
  "category"    => __('Content', 'highthemes'),
  "params"      => array(
    array(
      "type"        => "textfield",
      "heading"     => __("Title", "highthemes"),
      "param_name"  => "title",
      "value"       => "",
      "description" => __("Insert the main title for Call To Action.", "highthemes")
    ),
    array(
      "type"        => "textfield",
      "heading"     => __("Sub Title", "highthemes"),
      "param_name"  => "subtitle",
      "value"       => "",
      "description" => __("Insert the sub title.", "highthemes")
    ),
    array(
      "type"        => "dropdown",
      "heading"     => __("Align", "highthemes"),
      "param_name"  => "align",
      "value"       => array(
        __("Right", "highthemes") => "right",
        __("Left", "highthemes")    => "left",
        __("Center","highthemes")    => "center",
      ),
      "description" => __("Select the heading size here. If you select 1, you will get h1 and so forth.", "highthemes")
     ),  
    array(
      "type"        => "dropdown",
      "heading"     => __("Style", "highthemes"),
      "param_name"  => "style",
      "value"       => array(
        __("Dark", "highthemes") => "dark",
        __("light", "highthemes")    => "light",
      ),
      "description" => __("Select the heading size here. If you select 1, you will get h1 and so forth.", "highthemes")
     ),             
    array(
      "type"        => "textfield",
      "heading"     => __("Button Text", "highthemes"),
      "param_name"  => "btn_text",
      "value"       => "",
      "description" => __("If you had a button for CTA, you can insert the button text here.", "highthemes")
    ),
    array(
      "type"        => "textfield",
      "heading"     => __("Button Link", "highthemes"),
      "param_name"  => "btn_link",
      "value"       => "",
      "description" => __("If you had a button for CTA, you can insert the button link here.", "highthemes")
    ),
    array(
         "type"        => "textfield",
         "heading"     => __("Extra class name", "highthemes"),
         "param_name"  => "el_class",
         "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "highthemes")
    )
)
));


/* ht_Services
----------------------------------------------------*/
//Register "container" content element. It will hold all your inner (child) content elements
vc_map( array(
    "name"                    => __("Services", "highthemes"),
    "base"                    => "ht_services",
   "icon"        =>'ht-logo',
    "description"             => __("Defining services items with icon, link and...","highthemes"),
    "as_parent"               => array('only' => 'ht_service_item'), 
    // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
    "content_element"         => true,
    "show_settings_on_create" => true,
    "params"                  => array(
        // add params same as with any other content element
        array(
          "type"        => "dropdown",
          "heading"     => __("Icon Direction", "highthemes"),
          "param_name"  => "icon_direction",
          "description" => __("Select your desired icons direcytion for service items.", "highthemes"),
          "value"       => array(
                  __("Center", "highthemes") => "center",
                  __("Left", "highthemes")   => "left",
          )
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("Extra class name", "highthemes"),
            "param_name"  => "extra_class",
            "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your custom css codes.", "highthemes")
        )
    ),
    "js_view" => 'VcColumnView'
) );
vc_map( array(
    "name"            => __("Service Item", "highthemes"),
    "base"            => "ht_service_item",
    "description"     => __("Defining a service item with icon, link and tooltip option.","highthemes"),
   "icon"        =>'ht-logo',
    "content_element" => true,
    "as_child"        => array('only' => 'ht_services'),
    // Use only|except attributes to limit parent (separate multiple values with comma)
    "params"          => array(
        // add params same as with any other content element
        array(
            "type"        => "textfield",
            "heading"     => __("Service Title", "highthemes"),
            "param_name"  => "title",
            "description" => __("Insert the service title.", "highthemes")
        ),
        array(
            "type"        => "icon",
            "heading"     => __("Service Icon", "highthemes"),
            "param_name"  => "icon",
            "description" => __("Select service icon.", "highthemes")
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("Service Link", "highthemes"),
            "param_name"  => "link",
            "description" => __("Insert the service 'More info' link. If you don't assign any value here, the 'More info' button does not appear.", "highthemes")
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("Service Link Title", "highthemes"),
            "param_name"  => "link_title",
            "description" => __("Change the defualt link title.", "highthemes")
        ),        
        array(
           "type"        => "checkbox",
           "heading"     => __("Open links in new page?", "highthemes"),
           "param_name"  => "target",
           "value"       => Array(__("Yes", "highthemes") => '_blank'),
           "description" => __("Set the target of links for your services.", "highthemes")
        ),
        array(
            "type"        => "textarea",
            "heading"     => __("Service Description", "highthemes"),
            "param_name"  => "description",
            "description" => __("Insert the service description text here.", "highthemes")
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("Extra class name", "highthemes"),
            "param_name"  => "extra_class",
            "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your custom css codes.", "highthemes")
        )
    )
) );
//Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality

/* Team
---------------------------------------------------------- */
vc_map( array(
    "name"                    => __("Team", "highthemes"),
    "base"                    => "ht_team",
   "icon"        =>'ht-logo',
    "description"             => __("Team introduction widget to introduce members.","highthemes"),
    "show_settings_on_create" => true,  
    "content_element"         => true,
    "category"                => __('Content', 'highthemes'),
    "as_parent"               => array('only' => 'ht_member'), 
    "params"                  => array(
      array(
        "type"        => "dropdown",
        "heading"     => __("Columns", "highthemes"),
        "param_name"  => "team_col",
        "description" => __("Select Column", "highthemes"),
        "value"       => array(
                    __("2 Column", "highthemes") => "2",
                    __("3 Column", "highthemes") => "3",
                    __("4 Column", "highthemes") => "4",
        )
      )
  ),
  "js_view" => 'VcColumnView'     
));

vc_map( array(
  "name"            => __("Member", "highthemes"),
  "base"            => "ht_member",
   "icon"        =>'ht-logo',
  "description"     => __("A team member introduction.","highthemes"),
  "content_element" => true,
  "category"        => __('Content', 'highthemes'),
  "as_child"        => array('only' => 'ht_team'),
  "params"          => array(
    array(
      "type"        => "attach_image",
      "heading"     => __('Image', 'highthemes'),
      "param_name"  => "image",
      "description" => __("Upload the member's image", "highthemes")
    ), 
    array(
      "type"        => "textfield",
      "heading"     => __("Name", "highthemes"),
      "param_name"  => "name",
      "description" => __("Enter the member's name", "highthemes")
    ),
    array(
      "type"        => "textfield",
      "heading"     => __("Job", "highthemes"),
      "param_name"  => "job",
      "description" => __("Insert the member's job.", "highthemes")
    ),  
    array(
      "type"        => "exploded_textarea",
      "heading"     => __("Socials List", "highthemes"),
      "param_name"  => "socials",
      "description" => __("Insert every 'icon name' and 'url' in each line and seperate them by pipe line. For example in each line you can have something like this: fa-facebook|http://facebook.com|Facebook", "highthemes")
    ),
    array(
      "type"        => "textarea",
      "heading"     => __("Text", "highthemes"),
      "param_name"  => "content",
      "description" => __("Insert your desired text to introduce the member shortly.", "highthemes")
    ),
      array(
         "type"        => "textfield",
         "heading"     => __("Extra class name", "highthemes"),
         "param_name"  => "el_class",
         "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your custom css codes.", "highthemes")
      )               
  )
));


/* HT_Fancy_Testimonial
---------------------------------------------------------- */

vc_map( array(
    "name"                    => __("Testimonials", "highthemes"),
    "base"                    => "ht_testimonials",
   "icon"        =>'ht-logo',
    "description"             => __("Users' and clients' testimonials manager.","highthemes"),
    "show_settings_on_create" => true,  
    "content_element"         => true,
    "category"                => __('Content', 'highthemes'),
    "as_parent"               => array('only' => 'ht_testimonial'), 
    "params"                  => array(
      array(
        "type"        => "dropdown",
        "heading"     => __("Style", "highthemes"),
        "param_name"  => "style",
        "description" => __("Select your base color style", "highthemes"),
        "value"       => array(
                            __("Light", "highthemes") => "light",
                            __("Dark", "highthemes") => "dark",
        )
      ),
      array(
        "type"        => "dropdown",
        "heading"     => __("Effect", "highthemes"),
        "param_name"  => "effect",
        "description" => __("Select the testimonial effect.", "highthemes"),
        "value"       => array(
                  __("Fancy", "highthemes")   => "fancy",
                  __("General", "highthemes") => "general",
        )
      ),
      array(
        "type"        => "dropdown",
        "heading"     => __("Columns", "highthemes"),
        "param_name"  => "testimonial_col",
        "description" => __("Select Column", "highthemes"),
        "value"       => array(
                    __("1 Column", "highthemes") => "1",
                    __("2 Column", "highthemes") => "2",
                    __("3 Column", "highthemes") => "3",
                    __("4 Column", "highthemes") => "4",
        ),
        "dependency" => array("element" => "effect", "value" => "general")
      ),
      array(
         "type"        => "textfield",
         "heading"     => __("Extra class name", "highthemes"),
         "param_name"  => "el_class",
         "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your custom css codes.", "highthemes")
      )         
  ),
  "js_view" => 'VcColumnView'     
));

vc_map( array(
  "name"            => __("Testimonial", "highthemes"),
  "base"            => "ht_testimonial",
   "icon"        =>'ht-logo',
  "description"     => __("Single testimonial item.","highthemes"),
  "content_element" => true,
  "category"        => __('Content', 'highthemes'),
  "as_child"        => array('only' => 'ht_testimonials'),
  "params"          => array(
    array(
      "type"        => "attach_image",
      "heading"     => __('Image', 'highthemes'),
      "param_name"  => "image",
      "description" => __("Upload the testimonial image", "highthemes")
    ),
    array(
      "type"        => "textfield",
      "heading"     => __("Name", "highthemes"),
      "param_name"  => "name",
      "description" => __("Insert the person's name", "highthemes")
    ),
    array(
      "type"        => "textfield",
      "heading"     => __("Cite", "highthemes"),
      "param_name"  => "cite",
      "description" => __("For example:  / CEO & Creative Directoer, Highthemes", "highthemes")
    ),  
    array(
      "type"        => "textarea",
      "heading"     => __("Text", "highthemes"),
      "param_name"  => "content",
      "description" => ""
    )    
  )
));




/* Client_logo
---------------------------------------------------------- */

vc_map( array(
    "name"                    => __("Client Logos", "highthemes"),
    "base"                    => "ht_client_logos",
   "icon"        =>'ht-logo',
    "description"             => __("Creating a slider of clients' logos.","highthemes"),
    "show_settings_on_create" => true,
    "content_element"         => true,
    "category"                => __('Content', 'highthemes'),
    "as_parent"               => array('only' => 'ht_client_logo'),
    "params"                  => array(
      array(
         "type" => "textfield",
         "heading" => __("Title", "highthemes"),
         "param_name" => "title",
         "description" => __("Insert main title for client logos.", "highthemes")
      ),
      array(
         "type" => "textfield",
         "heading" => __("Extra class name", "highthemes"),
         "param_name" => "el_class",
         "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "highthemes")
      )
    ),
  "js_view" => 'VcColumnView'
));

vc_map( array(
  "name"            => __("Client Logo", "highthemes"),
  "base"            => "ht_client_logo",
   "icon"        =>'ht-logo',
  "description"     => __("Creating a single client's logo.","highthemes"),
  "content_element" => true,
  "category"        => __('Content', 'highthemes'),
  "as_child"        => array('only' => 'ht_client_logos'),
  "params"          => array(
      array(
        "type"        => "attach_image",
        "heading"     => __("Logo URL", "highthemes"),
        "param_name"  => "logo",
        "description" => __("Upload the client logo", "highthemes")
      ),
      array(
        "type"        => "textfield",
        "heading"     => __("Logo Link", "highthemes"),
        "param_name"  => "link",
        "description" => __("Enter your client's logo link here completely. Example: http://example.com", "highthemes")
      ),
      array(
        "type"        => "textfield",
        "heading"     => __("Tooltip Title", "highthemes"),
        "param_name"  => "title",
        "description" => __("This text would appears when the mouse hovers on.", "highthemes")
      ),
      array(
         "type"        => "checkbox",
         "heading"     => __("Open link in new page?", "highthemes"),
         "param_name"  => "target",
         "value"       => Array(__("Yes", "highthemes") => '_blank'),
         "description" => __("If you have a link for client's logo, set the target for that link.", "highthemes")
      ),
      array(
         "type" => "textfield",
         "heading" => __("Extra class name", "highthemes"),
         "param_name" => "el_class",
         "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "highthemes")
      )
  )
));


/* Fancy Features
---------------------------------------------------------- */
vc_map( array(
    "name"                    => __("Features", "highthemes"),
    "base"                    => "ht_features",
   "icon"        =>'ht-logo',
    "description"             => __("Display your features with a fancy effect.","highthemes"),
    "show_settings_on_create" => true,  
    "content_element"         => true,
    "category"                => __('Content', 'highthemes'),
    "as_parent"               => array('only' => 'ht_feature'), 
    "params"                  => array(
      array(
      "type"        => "textfield",
      "heading"     => __("Features Title", "highthemes"),
      "param_name"  => "title",
      "description" => __("Insert the title of features", "highthemes")
      ),
       array(
      "type"       => "dropdown",
      "heading"    => __("Image Alignment", "highthemes"),
      "param_name" => "alignment",
      "value"      => array(
          __("Left", "highthemes")     => "left", 
          __("Right", "highthemes")  => "right"
      ),
      "description" => __("Select the images alignment.","highthemes")
      )
  ),
  "js_view" => 'VcColumnView'     
));

vc_map( array(
  "name"            => __("Feature", "highthemes"),
  "base"            => "ht_feature",
   "icon"        =>'ht-logo',
  "description"     => "",
  "content_element" => true,
  "category"        => __('Content', 'highthemes'),
  "as_child"        => array('only' => 'ht_features'),
  "params"          => array(
    array(
      "type"        => "attach_image",
      "heading"     => __('Image', 'highthemes'),
      "param_name"  => "image",
      "description" => __("Upload the feature's image", "highthemes")
    ), 
    array(
      "type"        => "textfield",
      "heading"     => __("Title", "highthemes"),
      "param_name"  => "title",
      "description" => __("Enter the title of feature", "highthemes")
    ),
    array(
      "type"        => "icon",
      "heading"     => __("Feature Icon", "highthemes"),
      "param_name"  => "icon_name",
      "description" => ""
    ), 
  )
));


/* ht_recent_posts
---------------------------------------------------------- */
vc_map( array(
  "name"        => __("Recent Blog Posts", "highthemes"),
  "base"        => "ht_recent_posts",
   "icon"        =>'ht-logo',
  "description" => __("Showcase of recent blog posts with thumbnails","highthemes"),
  "category"    => __('Content', 'highthemes'),
  "params"      => array(
        array(
      "type"       => "dropdown",
      "heading"    => __("Layout Type", "highthemes"),
      "param_name" => "columns",
      "value"      => array(
          __("4 Columns", "highthemes")     => "4", 
          __("3 Columns", "highthemes")  => "3", 
          __("2 Columns", "highthemes") => "2", 
      ),
      "description" => __("Select the portfolio layout here.","highthemes")
    ), 
    array(
      "type"        => "textfield",
      "heading"     => __("Recent Posts Title", "highthemes"),
      "param_name"  => "title",
      "value"       => '',
      "description" => __("Enter the title of recent posts such as 'blog'", "highthemes")
    ),  
    array(
      "type"       => "dropdown",
      "heading"    => __("Title Alignment", "highthemes"),
      "param_name" => "title_align",
      "value"      => array(
          __("Left", "highthemes")     => "left", 
          __("Right", "highthemes")  => "right",
          __("Center", "highthemes")  => "center"
      ),
      "description" => __("Select the title alignment.","highthemes")
    ),
    array(
      "type"        => "checkbox",
      "heading"     => __("Categories", "highthemes"),
      "description" => __("Check the categories you would like to include.","highthemes"),
      "param_name"  => "categories",
      "value"       => $categories,
    ),
    array(
      "type"        => "textfield",
      "heading"     => __("Include Item's IDs", "highthemes"),
      "param_name"  => "post_ids",
      "value"       => "",
      "description" => __("Use a comma separated list of portfolio items ids you want to show.", "highthemes")
    ), 
    array(
      "type"        => "textfield",
      "heading"     => __("Exclude Item's IDs", "highthemes"),
      "param_name"  => "exclude_ids",
      "value"       => "",
      "description" => __("Use a comma separated list of portfolio items ids you want not to show.", "highthemes")
    ),    
 
    array(
      "type"       => "dropdown",
      "heading"    => __("Order by", "highthemes"),
      "param_name" => "orderby",
      "value"      => array(
        __("Date", "highthemes")          => "date",
        __("ID", "highthemes")            => "ID",
        __("Author", "highthemes")        => "author",
        __("Title", "highthemes")         => "title",
        __("Modified", "highthemes")      => "modified",
        __("Random", "highthemes")        => "rand",
        __("Comment count", "highthemes") => "comment_count",
        __("Menu order", "highthemes")    => "menu_order"
      ),
        "description"                      => sprintf(__('Select how to sort retrieved posts. More at %s.', 'highthemes'), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>')
    ),
    array(
      "type"       => "dropdown",
      "heading"    => __("Order way", "highthemes"),
      "param_name" => "order",
      "value"      => array(
        __("Descending", "highthemes") => "DESC",
        __("Ascending", "highthemes")  => "ASC"
      ),
      "description" => sprintf(__('Designates the ascending or descending order. More at %s.', 'highthemes'), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>')
    ),
      array(
         "type"        => "textfield",
         "heading"     => __("Extra class name", "highthemes"),
         "param_name"  => "el_class",
         "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your custom css codes.", "highthemes")
      )       
  )
));
?>