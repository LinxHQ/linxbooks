<?php
global 	$ht_options;
function generate_custom_css(){
        $gen = '';
        $gen .= ht_custom_css();       
        $gen .= ht_typo_font();
        $gen .= ht_general_css();
        if(!empty($gen)){
            $wrap_css ='';
            $wrap_css .="<!-- CUSTOM PAGE SECTIONS STYLE -->\n";
            $wrap_css .="<style type=\"text/css\">\n";
            $wrap_css .= $gen;
            $wrap_css .="\n\n</style>\n<!-- END CUSTOM PAGE SECTIONS STYLE -->\n\n";
            echo $wrap_css;
        }
}
add_action('wp_head','generate_custom_css');

function ht_general_css() {
    global $ht_options;
    $css = "";

    if( $ht_options['transparent_header'] ) {
        $css .= '#header .headdown  {'.
                    "\t".'background: none;'.
                    "\t".'border: none;'.
                '}';
        }        
    

    if( $ht_options['layout_type'] =='boxed' || $ht_options['layout_type'] =='boxed-margin' ) {

        if( $ht_options['body_background'] ) {
        $css .= 'body {'.
                    "\t".'background-color: '.$ht_options['body_background'].';'.
                '}';
        }

        $custom_bg_repeat   = ($ht_options['custom_bg_repeat']) ? $ht_options['custom_bg_repeat'] : 'repeat';
        $custom_bg_fixed    = ($ht_options['custom_bg_fixed']) ? 'background-attachment: fixed;': '';
        $custom_bg_cover    = ($ht_options['custom_bg_cover']) ? 'background-size: cover;' : '';
        $custom_bg_position = ($ht_options['custom_bg_position']) ? 'background-position: ' . $ht_options['custom_bg_position'] . ';' : '';

        if( $ht_options['custom_bg'] ) {
            $css .= 'body {'."\n".
                    "\t".'background-image: url('.$ht_options['custom_bg'].');'.
                    "\t".'background-repeat: '. $custom_bg_repeat .';'.
                    $custom_bg_cover .
                    $custom_bg_fixed .
                    $custom_bg_position.

                '}'."\n";                  

        } elseif ( $ht_options['custom_pattern'] && substr($ht_options['custom_pattern'],-6) != '/0.png' ) {
            $css .= 'body {'."\n".
                    "\t".'background-image: url('.$ht_options['custom_pattern'].');'.
                    "\t".'background-repeat: repeat;'.
                '}'."\n";
        }
    }

    if( $ht_options['accent_color'] ) {
         $css .=   '.tbutton.accent,
                    .wbutton,
                    .woocommerce #review_form #respond .form-submit input, 
                    .woocommerce-page #review_form #respond .form-submit input,
                    .widget_shopping_cart_content .button,
                    .woocommerce .widget_price_filter .price_slider_amount .button,
                    .woocommerce-page .widget_price_filter .price_slider_amount .button,
                    .woocommerce span.onsale,
                    .woocommerce-page span.onsale,
                    .woocommerce div.product span.price ins,
                    .woocommerce div.product p.price ins,
                    .woocommerce #content div.product span.price ins,
                    .woocommerce #content div.product p.price ins,
                    .woocommerce-page div.product span.price ins,
                    .woocommerce-page div.product p.price ins,
                    .woocommerce-page #content div.product span.price ins,
                    .woocommerce-page #content div.product p.price ins,
                    .woocommerce-message a.button,
                    .sf-menu > li.current_page_item > a,
                    .woocommerce .show_review_form.button,
                    #form-comment #submit,
                    nav.woocommerce-pagination ul li a:hover,
                    nav.woocommerce-pagination ul li span.current,
                    .wpcf7-submit:hover {'."\n".
                    "\t".'color: #fff;'.
                    "\t".'background-color: '.$ht_options['accent_color'].' ;'."\n".
                    '}'."\n";

         $css .=   'a:hover,
                    .fancy-features-list li.active a, 
                    .fancy-features-list li.active a i,
                    .preve:hover, .nexte:hover,
                    .breadcrumbIn ul li a:hover,
                    .active_link,
                    .foot-menu li a:hover,
                    .post_meta a:hover,
                    .post_more,
                    .languages a:hover,
                    .languages:hover > a,
                    .ht-icon.gray-scale:hover,
                    .other_languages a:hover,
                    .widget_categories ul li:hover,
                    .widget_archive ul li:hover,
                    .services [class^="grid_"]:hover .s_icon,
                    .services div:hover .s_icon i,
                    .services [class^="grid_"]:hover .tbutton:hover,
                    .services div:hover .tbutton:hover,
                    .widget_search .search-box button:hover,
                    #newsletters button:hover,
                    .thumb-list .post-meta,
                    .recent-tweets li i,
                    .f_portfolio .inner a,
                    .portfolio .inner a,
                    .big-slider .flex-direction-nav a:hover i,
                    .f_portfolio .prev-holder:hover,
                    .f_portfolio .next-holder:hover,
                    .projectslider .flex-direction-nav a:hover i,
                    .countdown li p.timeRefDays,
                    .countdown li p.timeRefHours,
                    .countdown li p.timeRefMinutes,
                    .countdown li p.timeRefSeconds,
                    .pricing-table .head h4,
                    .tbutton:hover,
                    .wbutton:hover,
                    .woocommerce #review_form #respond .form-submit input:hover, .woocommerce-page #review_form #respond .form-submit input:hover,
                    #toTop:hover,
                    .page-content .search-box button:hover,
                    .page-content .search-box button:focus,
                    .woocommerce ul.products li.product .price,
                    .woocommerce-page ul.products li.product .price,
                    .woocommerce div.product span.price,
                    .woocommerce div.product p.price,
                    .woocommerce #content div.product span.price,
                    .woocommerce #content div.product p.price,
                    .woocommerce-page div.product span.price,
                    .woocommerce-page div.product p.price,
                    .woocommerce-page #content div.product span.price,
                    .woocommerce-page #content div.product p.price,
                    .woocommerce div.product span.price,
                    .woocommerce div.product p.price,
                    .woocommerce #content div.product span.price,
                    .woocommerce #content div.product p.price,
                    .woocommerce-page div.product span.price,
                    .woocommerce-page div.product p.price,
                    .woocommerce-page #content div.product span.price,
                    .woocommerce-page #content div.product p.price,
                    .product_meta a:hover,
                    .widget ul li.current-menu-item a,
                    .dark-layout .shop_table input[type="submit"]:hover,
                    .dark-layout input[type="reset"]:hover,
                    #form-comment #submit:hover,
                    .tbutton.accent:hover {'."\n".
                    "\t".'color:'.$ht_options['accent_color'].';'."\n".
                    '}'."\n";

         $css .=   '.dark-layout .woocommerce-tabs li a {'."\n".
                    "\t".'color:'.$ht_options['accent_color'].' !important;'."\n".
                    '}'."\n";

         $css .=   '.dark-layout .woocommerce-tabs li.active a {'."\n".
                    "\t".'color: #fff !important;'.
                    "\t".'background-color: '.$ht_options['accent_color'].' !important;'."\n".
                    '}'."\n";

         $css .=   '.tbutton.accent:hover,
                    input[type=text]:focus,textarea:focus,
                    input[type=email]:focus,
                    .wpcf7-text:focus,
                    .wpcf7-number:focus,
                    .wpcf7-date:focus,
                    .wpcf7-select:focus,
                    #toTop:hover,
                    .languages a:hover,
                    .languages:hover > a,
                    .other_languages,
                    #track_input:focus, 
                    #contactForm #senderName:focus,
                    #contactForm #senderEmail:focus,
                    #contactForm #message:focus,
                    #contactForm #sendMessage:hover,
                    #sendOrder:hover,
                    #contactForm #comment-button:hover,
                    .sf-menu > li:hover > a,
                    .sf-menu > li > a:hover,
                    .sf-menu li.current-menu-parent > a,
                    .current_page_item > a,
                    .wp-pagenavi a:hover,
                    .wp-pagenavi .current,
                    .services [class^="grid_"]:hover .tbutton,
                    .services [class^="grid_"]:hover .tbutton:hover,
                    .fancy_testimonial li.active a .testimonial-img-wrap,
                    .widget > ul li.current a,
                    .widget ul li:hover > a,
                    .widget ul ul li:hover > a,
                    .widget ul ul ul li:hover > a,
                    .widget_search .search-box input:focus,
                    #newsletters input:focus,
                    .coupon_input:focus,
                    .flickr a:hover img,
                    .widget_tag_cloud a:hover,
                    .widget_product_tag_cloud a:hover,
                    .filterable li.current a,
                    .filterable li a:hover,
                    .f_portfolio .prev-holder:hover,
                    .f_portfolio .next-holder:hover,
                    .wpb_content_element.wpb_tabs .wpb_tabs_nav li.ui-state-active,
                    .wpb_content_element.wpb_tour .wpb_tabs_nav li.ui-state-active,
                    .load_more_portfolio a:hover,
                    ul.showcomments .reply a:hover,
                    #commentform input:focus,
                    #commentform textarea:focus,
                    #commentform .send-message:hover,
                    .tbutton:hover,
                    .wbutton:hover,
                    .woocommerce #review_form #respond .form-submit input:hover, .woocommerce-page #review_form #respond .form-submit input:hover
                    .featured_table,
                    .ht-icon.gray-scale:hover,
                    .post-area .search-box button:hover,
                    .post-area .search-box button:focus,
                    .woocommerce div.product .woocommerce-tabs ul.tabs li.active,
                    .woocommerce #content div.product .woocommerce-tabs ul.tabs li.active,
                    .woocommerce-page div.product .woocommerce-tabs ul.tabs li.active,
                    .woocommerce-page #content div.product .woocommerce-tabs ul.tabs li.active,
                    #form-comment #submit,
                    .tbutton.accent:hover,
                    nav.woocommerce-pagination ul li a:hover,
                    nav.woocommerce-pagination ul li span.current,
                    .wpcf7-submit:hover {'."\n".
                    "\t".'border-color:'.$ht_options['accent_color'].';'."\n".
                    '}'."\n";

         $css .=    '.tipsy-n .tipsy-arrow:before,
                    .fancy_testimonial li.active:after,
                    .widget > ul li.current a,
                    .widget ul li:hover > a,
                    .widget ul ul li:hover > a,
                    .widget ul ul ul li:hover > a,
                    .widget_categories ul li:hover,
                    .widget_product_categories ul li:hover,
                    .widget_archive ul li:hover,
                    .widget ul li.current-menu-item a,
                    #recentcomments li.recentcomments:hover,
                    .fancy_testimonial ul {'."\n".
                    "\t".'border-bottom-color:'.$ht_options['accent_color']."\n".
                    '}'."\n";

         $css .=    '.tipsy-s .tipsy-arrow:before,
                    .action,
                    .dark_action,
                    .tipsy-e .tipsy-arrow:before {'."\n".
                    "\t".'border-top-color:'.$ht_options['accent_color'].";\n".
                    '}'."\n";

         $css .=    '.tipsy-w .tipsy-arrow:before {'."\n".
                    "\t".'border-right-color:'.$ht_options['accent_color'].";\n".
                    '}'."\n";

         $css .=    '.labele {'."\n".
                    "\t".'border-left-color:'.$ht_options['accent_color'].";\n".
                    '}'."\n";

         $css .=    '.sf-menu li li {'."\n".
                    "\t".'border-top-color:'.ht_color_brightness($ht_options['accent_color'], 0.9).";\n".
                    "\t".'border-bottom-color:'.ht_color_brightness($ht_options['accent_color'], -0.9).";\n".
                    '}'."\n";

         $css .=    '.sf-menu ul li:hover,
                    .sf-menu li .current-menu-item,
                    .sf-menu li .current_page_item
                     {'."\n".
                    "\t".'background-color:'.ht_color_brightness($ht_options['accent_color'], -0.8).";\n".
                    '}'."\n";

         $css .=   '.vc_progress_bar .vc_single_bar.accent .vc_bar,
                    #commentform .send-message:hover,
                    .tbutton,
                    .table tfoot td,
                    .tipsy-inner,
                    #mobilepro,
                    #contactForm #sendMessage:hover, #sendOrder:hover,
                    #contactForm #comment-button:hover,
                    .sf-menu ul li,
                    .sf-menu > li:hover > a, .sf-menu > li > a:hover,
                    .sf-menu > li.current-menu-parent > a,                 
                    ul.mega,
                    .sf-menu .mega li:hover, .sf-menu .mega li.current,
                    .f_blog .f_hover,
                    .post-links a:hover i,
                    .related_posts a span,
                    .related_posts a:hover span,
                    .wp-pagenavi a:hover, 
                    .wp-pagenavi .current,
                    .services [class^="grid_"]:hover .s_icon span,
                    .services [class^="grid_"]:hover .tbutton,
                    .widget_tag_cloud a:hover,
                    .widget_product_tag_cloud a:hover,
                    #wp-calendar td:hover,
                    #wp-calendar tfoot td:hover,
                    #wp-calendar tfoot td:hover a,
                    #wp-calendar td#today,
                    #wp-calendar td#today:hover a,
                    .filterable li.current a, .filterable li a:hover, .load_more_portfolio a:hover,
                    .f_portfolio .f_hover, 
                    .portfolio .f_hover,
                    .project_links a:hover i,
                    .wpb_accordion .wpb_accordion_wrapper .wpb_accordion_section .ui-state-default .ui-icon,
                    .wpb_accordion .wpb_accordion_wrapper .wpb_accordion_section .ui-state-active .ui-icon,
                    h4.wpb_toggle span,
                    .wpb_content_element.wpb_tabs .wpb_tabs_nav li.ui-state-active,
                    .wpb_content_element.wpb_tour .wpb_tabs_nav li.ui-state-active,
                    ul.showcomments .reply a:hover ,
                    .featured_table .recommended,
                    .big-slider h3,
                    .big-slider p,
                    .services [class^="grid_"]:hover span.fa-check,
                    .table th,
                    .woocommerce ul.product_list_widget li ins,
                    .woocommerce-page ul.product_list_widget ins,
                    .woocommerce div.product .woocommerce-tabs ul.tabs li.active,
                    .woocommerce #content div.product .woocommerce-tabs ul.tabs li.active,
                    .woocommerce-page div.product .woocommerce-tabs ul.tabs li.active,
                    .woocommerce-page #content div.product .woocommerce-tabs ul.tabs li.active,
                    .dark-layout .shop_table input[type="submit"]:hover,
                    .dark-layout input[type="reset"]:hover,
                    .woocommerce .widget_price_filter .price_slider_wrapper .ui-widget-content,
                    .woocommerce-page .widget_price_filter .price_slider_wrapper .ui-widget-content,
                    .woocommerce .widget_price_filter .ui-slider .ui-slider-handle,
                    .woocommerce-page .widget_price_filter .ui-slider .ui-slider-handle
                     {'."\n".
                    "\t".'background-color: '.$ht_options['accent_color'].' ;'."\n".
                    '}'."\n";

         $css .=    '@media only screen and (max-width: 959px) {'."\n".
                    "\t".'.sf-menu {'."\n".
                    "\t\t".'background-color:'.$ht_options['accent_color'].';'."\n".
                    "\t".'}'."\n".
                    '}';

         $css .=    '.f_blog .f_hover,
                    .f_portfolio .f_hover, 
                    .portfolio .f_hover,
                    .big-slider h3,
                    .big-slider p,
                    .related_posts a span {'."\n".
                    "\t".'background: rgba('.hex_to_rgb($ht_options['accent_color']).' ,0.7);'."\n".
                    '}'."\n";

         $css .=    '.widget:not(.widget_archive):not(.widget_categories):not(.widget_product_categories) > ul li.current a,
                    .widget:not(.widget_archive):not(.widget_categories):not(.widget_product_categories) ul li:hover > a,
                    .widget_categories li:hover,
                    .widget_archive li:hover,
                    .product-categories li:hover,
                    #recentcomments li.recentcomments:hover,
                    .widget ul li.current-menu-item a,
                    .widget ul ul li:hover > a,
                    .widget ul ul ul li:hover > a {'."\n".
                    "\t".'background: rgba('.hex_to_rgb($ht_options['accent_color']).' ,0.07);'."\n".
                    '}'."\n";

         $css .=    '.table tr:hover, tr.topic-sticky {'."\n".
                    "\t".'background: rgba('.hex_to_rgb($ht_options['accent_color']).' ,0.2);'."\n".
                    '}'."\n";

    }

    if( $ht_options['accent_color'] ) {
        $css .= '::-moz-selection {'."\n".
                "\t".'background: '.$ht_options['accent_color'].';'."\n".
                '}'."\n";

        $css .= '::selection {'."\n".
                "\t".'background: '.$ht_options['accent_color'].';'."\n".
                '}'."\n";
    }


       
    
    return $css;
}

function ht_custom_css () {
    global $ht_options;
  
    if($ht_options['custom_css']){
        return $ht_options['custom_css'];
    }

}


function ht_typo_font(){
    global $ht_options;

    $heading_font    =     $ht_options['heading_font'];
    $body_font       =     $ht_options['body_font'];
    $sidebar_font    =     $ht_options['sidebar_fonts'];
    $navigation_font =     $ht_options['navigation_font'];

    $css = '';

     // heading font
    if($ht_options['heading_font']['face']){
            $add_in = '';
            if ($heading_font['style'] == 'bold italic') {
                $add_in .= "\t".'font-weight: bold;'."\n";
                $add_in .= "\t".'font-style: italic;'."\n";
            } elseif ($heading_font['style'] == 'italic') {
                $add_in .= "\t".'font-style: italic;'."\n";
            } else {
                $add_in .= "\t".'font-weight:'.$heading_font['style'].';';
            }
            $add_in .= "\t".'font-family:"'.$heading_font['face'].'",helvetica,arial,sans-serif;';
            $css .= 'h1,h2,h3,h4,h5,h6{'."\n".
                    $add_in.
                    '}'."\n";
    }

     // sidebar heading font
    if($ht_options['sidebar_fonts']['face']) {
            $add_in = '';
            $add_in .= "\t".'font-family:"'.$ht_options['sidebar_fonts']['face'].'",helvetica, arial, sans-serif;';
            $add_in .= "\t".'font-size:'.$ht_options['sidebar_fonts']['size'].';';
            $css .= '.sidebar h1, .sidebar h2, .sidebar h3, .sidebar h4, .sidebar h5, .sidebar h6{'."\n".
                    $add_in.
                    '}'."\n";
    }

    // sidebar font
    if($ht_options['sidebar_fonts']){
            $add_in = '';
            $add_in .= "\t".'font-size:'.$sidebar_font['size'].';';          
            $add_in .= "\t".'font-family:"'.$sidebar_font['face'].'",helvetica,arial,sans-serif;';        
            $css .= '.sidebar .widget h3.widget-title {'."\n".
                    $add_in.
                    '}'."\n";
    }

    // nav font
    if($ht_options['navigation_font']){
            $add_in = '';
            $add_in .= "\t".'font-size:'.$navigation_font['size'].';';          
            $add_in .= "\t".'color:'.$navigation_font['color'].';';
            $add_in .= "\t".'font-family:"'.$navigation_font['face'].'",helvetica,arial,sans-serif;';
            $css .= '#menu > li > a, #menu > li > a:visited
                    {'."\n".
                    $add_in.
                    '}'."\n";

           
    }


    // body font
    if($ht_options['body_font']){
            $add_in = '';
            $add_in .= "\t".'font-size:'.$body_font['size'].';';          
            $add_in .= "\t".'color:'.$body_font['color'].';';
            $add_in .= "\t".'font-family:"'.$body_font['face'].'",helvetica,arial,sans-serif;';        
            $css .= 'body {'."\n".
                    $add_in.
                    '}'."\n";
    }

    return $css;


}

function ht_include_google_font() {
        global $ht_options;

        $font_heading = $ht_options['heading_font'];
        $font_nav = $ht_options['navigation_font'];
        $font_body = $ht_options['body_font'];
        $font_sidebar = $ht_options['sidebar_fonts'];

        $latin_chars = ($ht_options['latin_chars'] =='1') ? '&subset=latin,latin-ext' : '';



        $face_check = array('arial'=>'Arial',
                'verdana'=>'Verdana, Geneva',
                'trebuchet'=>'Trebuchet',
                'georgia' =>'Georgia',
                'times'=>'Times New Roman',
                'tahoma'=>'Tahoma, Geneva',
                'palatino'=>'Palatino',
                'helvetica'=>'Helvetica' );

        // Heading custom font
        if(!array_key_exists($font_heading['face'], $face_check) ){
            $custom_font = str_replace(" ", "+", $font_heading['face']);

            if($font_heading['face'] == 'Oswald') {
              $custom_font = $custom_font . ":700,400,300";
            }
            wp_enqueue_style( 'custom-heading-fonts', 'http://fonts.googleapis.com/css?family='.$custom_font.$latin_chars);

        }  

        // Navigation custom font
        if(!array_key_exists($font_nav['face'], $face_check) ){
            $custom_font_nav = str_replace(" ", "+", $font_nav['face']);

            if($font_nav['face'] == 'Oswald') {
              $custom_font_nav = $custom_font_nav . ":700,400,300";
            }
            wp_enqueue_style( 'custom-navigation-fonts', 'http://fonts.googleapis.com/css?family='.$custom_font_nav.$latin_chars);

        }                  
        

        // Body custom font
        if(!array_key_exists($font_body['face'], $face_check) ){
            $custom_font_body = str_replace(" ", "+", $font_body['face']);

            if($font_body['face'] == 'Oswald') {
              $custom_font_body = $custom_font_body . ":700,400,300";
            }
            wp_enqueue_style( 'custom-body-fonts', 'http://fonts.googleapis.com/css?family='.$custom_font_body.$latin_chars);

        }  

        // Sidebar custom font
        if(!array_key_exists($font_sidebar['face'], $face_check) ){
            $custom_font_sidebar = str_replace(" ", "+", $font_sidebar['face']);

            if($font_sidebar['face'] == 'Oswald') {
              $custom_font_sidebar = $custom_font_sidebar . ":700,400,300";
            }
            wp_enqueue_style( 'custom-sidebar-fonts', 'http://fonts.googleapis.com/css?family='.$custom_font_sidebar.$latin_chars);

        }          

     
}
add_action('wp_enqueue_scripts', 'ht_include_google_font');
?>