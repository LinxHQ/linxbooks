<?php
/**
 *
 * HighThemes Options Framework
 * twitter : http://twitter.com/theHighthemes
 * General Helper Functions
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }



/**
 * Retrive a list of files, contained inthto a folder.   
 */     
function ht_list_files_into( $folder )
{
    $files = array();
    
    if ( file_exists($folder) && $handle = opendir($folder) ) {                                
       while ( false !== ($file = readdir($handle ) ) ) { 
            if ( $file == ".." || $file == "." || $file[0] == '.' || $file[0] == 'error_log' ) {
                continue;
            }

           $files[] = $file;
       }
    
       closedir($handle); 
    } 
    
    return $files;
}      

/**
 * Generate styles
 */
function ht_build_style($bg_image = '', $bg_color = '', $bg_image_repeat = '', $bg_pos ='', $font_color = '', $padding_top = '', $padding_bottom = '', $margin_bottom = '', $text_align='') {
        $has_image = false;
        $style = '';
        if((int)$bg_image > 0 && ($image_url = wp_get_attachment_url( $bg_image, 'large' )) !== false) {
            $has_image = true;
            $style .= "background-image: url(".$image_url.");";
        }
        if(!empty($bg_color)) {
            $style .= 'background-color: '.$bg_color.';';
        }
        if(!empty($bg_pos)) {
            $style .= 'background-position: '.$bg_pos.';';
        }        
        if(!empty($bg_image_repeat) && $has_image) {
            if($bg_image_repeat === 'contain') {
                $style .= "background-repeat:no-repeat;background-size: contain;";
            } elseif($bg_image_repeat === 'no-repeat') {
                $style .= 'background-repeat: no-repeat;';
            }
        }
        if( !empty($font_color) ) {
            $style .= 'color: '.$font_color.';';
        }
        if( $padding_top != '' ) {
            $style .= 'padding-top: '. $padding_top.'px;';
        }
        if( $padding_bottom != '' ) {
            $style .= 'padding-bottom: '. $padding_bottom.'px;';
        }        
        if( $margin_bottom != '' ) {
            $style .= 'margin-bottom: '.$margin_bottom.'px;';
        }
        if( $text_align != '' ) {
            $style .= 'text-align: '.$text_align.';';
        }        
        return $style;
    }


/**
 *  Include custom favicon
 */
if( ! function_exists('ht_favicon') ){
    function ht_favicon($url = "")
    {
        $link = "";
        if($url)
        {
            $type = "image/x-icon";
            if(strpos($url,'.png' )) $type = "image/png";
            if(strpos($url,'.gif' )) $type = "image/gif";

            $link = '<link rel="shortcut icon" href="'.$url.'" type="'.$type.'">';
        }
        return $link;
    }
}

/**
 * Create list of available terms for $taxonomy
 *
 * @param $taxonomy
 * @return mixed
 */
if( ! function_exists('ht_create_terms_list') ){
    function ht_create_terms_list($taxonomy)
    {
        global $wpdb;
        $sql = "SELECT term_id FROM $wpdb->term_taxonomy WHERE taxonomy = '$taxonomy'";
        $res = $wpdb->get_results($sql,'ARRAY_A');

        if(count($res)>0){
            $term_ids = '';
            foreach ( $res as $col=>$value ){
                $term_ids .= $value['term_id'] . ",";
            }

            $term_ids = substr($term_ids, 0, strlen($term_ids)-1);
            $term_res = $wpdb->get_results("SELECT * from $wpdb->terms WHERE term_id IN ($term_ids) ORDER BY term_id",'ARRAY_A');

            return $term_res;
        } else {
            return false;
        }

    }

}

/**
 * Get image url of a certain featured image
 */
if( ! function_exists('ht_get_featured_image_url') ){
    function ht_get_featured_image_url ($post_id) {
        $image_id = get_post_thumbnail_id($post_id, 'full'); 
        $image_url = wp_get_attachment_image_src($image_id,'full');  
        $image_url = $image_url[0];
        return $image_url;
    }

}

/**
 * Custom excerpt with custom length and ellipsis
 */
if( ! function_exists('ht_excerpt') ){
    function ht_excerpt($length, $ellipsis) {
        $text = get_the_content();
        $text = preg_replace('`\[[^\]]*\]`','',$text);
        $text = strip_tags($text);
        if(strlen($text) <= $length) {

            return $text;
        }
        else {
            $text = substr($text, 0, $length);
            $text = substr($text, 0, strripos($text, " "));
            $text = $text.$ellipsis;
            return $text;
        }
    }

}

/**
 * New excerpt more
 */
if( ! function_exists('new_excerpt_more') ){
    function new_excerpt_more($more) {
        return ' ...';
    }
}
add_filter('excerpt_more', 'new_excerpt_more');

/**
 * Twitter like time
 */
if( ! function_exists('ht_days_date') ){
    function ht_days_date($date){

        $days = round((date('U') - $date) / (60*60*24));
        if ($days==0) {
            _e("Published today", "highthemes");
        }
        elseif ($days==1) {
            _e("1 day ago", "highthemes");
        }
        else {
            echo $days . __(" days ago", "highthemes");
        }
    }
}

/**
 * Embed video from youtube, dailymotion, vimeo and your own host
 */
if( ! function_exists('embed_video') ){
    function embed_video($external_video='', $width=0, $height=0, $mp4='', $webm='', $flv='', $ogv='', $poster='', $preload = 'none', $autoplay='', $loop='' ) {     
        
        $output = '';
        global $content_width;

        // if youtube, vimeo, ....
        if( $external_video ) {

            if ($width) {
                $video_w = $width;
            } else {
                $video_w = $content_width;
            }

            if ($height) {
                $video_h = $height;
            } else {
                $video_h = $width/1.61; //1.61 golden ratio
            } 
            
            global $wp_embed;
            $output = $wp_embed->run_shortcode('[embed width="'.$video_w.'" height="'.$video_h.'"]'.$external_video.'[/embed]');

        // html5 video
        } elseif( !empty($mp4) || !empty($webm) || !empty($flv) || !empty($ogv) ){
            
            $src_attribute = '';
            
            if( $mp4 ) $src_attribute .='mp4="'.$mp4.'"';
            if( $webm ) $src_attribute .=' webm="'.$webm.'"';
            if( $ogv ) $src_attribute .=' ogv="'.$ogv.'"';
            if( $flv ) $src_attribute .=' flv="'.$flv.'"';
            
            if ($width) {
                $video_w = $width;
            } else {
                $video_w = $content_width;
            }

            if ($height) {
                $video_h = $height;
            } else {
                $video_h = $width/1.61; //1.61 golden ratio
            }   

            $poster_attribute = $preload_attribute = $autoplay_attribute = $loop_attribute = '';

            if ($poster) {
                $poster_attribute = ' poster="'.htmlspecialchars($poster).'"';
            } 
            $preload_attribute = ' preload="'.$preload.'"';

            if ($autoplay =='on') {
                $autoplay_attribute = ' autoplay="on"';
            }

            if ($loop == 'on') {
                $loop_attribute = ' loop="on"';
            }

            $other_atts = $poster_attribute . $preload_attribute . $autoplay_attribute . $loop_attribute;

            global $wp_embed;
            $output = do_shortcode('[video '.$src_attribute. $other_atts.' width="'.$video_w.'" height="'.$video_h.'"]');

        } else {
            $output = __('please enter a video url', 'highthemes');

        }

 return $output;

    }

}


/*
* Set the layout sidebar alignment.
*/
if( ! function_exists('ht_sidebar_layout') ){
    function ht_sidebar_layout($flag=0){
        global $post, $ht_options;
        
        if( is_woocommerce_activated() ) {
            if( is_shop() || is_product_category() || is_product_tag()  ){
                $post   = get_post( woocommerce_get_page_id( 'shop' ) );
                $sidebar_position = get_post_meta( $post->ID, '_ht_sidebar_alignment',  true );
                return $sidebar_position;
            }
        }

        if ( !empty($post) && !is_home() && !is_search() && !is_archive() && !is_404() && !is_author() ) {

            // if regular page or post - get sidebar position
            $sidebar_position = get_post_meta( $post->ID, '_ht_sidebar_alignment',  true );

            // if no selection of sidebar
            if( empty($sidebar_position) ) {
                $sidebar_position = $ht_options['sidebar_layout'];
            }

        } elseif ( is_404() ) {

            // set sidebar position to disabled for 404
            $sidebar_position = 'no-sidebar';
        } else {

            $sidebar_position = $ht_options['sidebar_layout'];
        }   


        return $sidebar_position;

    }

}


/**
 * is WooCommerce activated
 */
if ( ! function_exists( 'is_woocommerce_activated' ) ) {
    function is_woocommerce_activated() {
        if ( class_exists( 'woocommerce' ) ) { return true; } else { return false; }
    }
}

/**
 * Convert hexadecimal color to rgb
 */
if( ! function_exists('hex_to_rgb') ){
    function hex_to_rgb($color) {
        $without_hash = substr($color, 1);
        $r = substr($without_hash, 0, 2);
        $g = substr($without_hash, 2, 2);
        $b = substr($without_hash, 4, 2);

        return hexdec($r) . "," . hexdec($g) . "," . hexdec($b);
    }

}

/**
 * Font-Awesome Icons
 */
if( !function_exists('ht_font_awesome_list') ) {
    function ht_font_awesome_list() {
        require HT_FRAMEWORK_PATH . 'assets/php/font-awesome-icons.php';

        $icons_arr = array();
        $icons_arr = explode(",", $icons);

        return $icons_arr;
    }   
}



/**
 *  Enable shortcodes on text widgets
 */
add_filter('widget_text', 'do_shortcode');

/**
 * Just search posts, pages, portfolio
 */




/**
 * check the current post for the existence of a short code  
 */
 
// 
if( !function_exists('ht_has_shortcode') ) {
    function ht_has_shortcode($shortcode = '') {  
      
        $post_to_check = get_post(get_the_ID());  
      
        // false because we have to search through the post content first  
        $found = false;  
      
        // if no short code was provided, return false  
        if (!$shortcode) {  
            return $found;  
        }  
        // check the post content for the short code  
        if ( stripos($post_to_check->post_content, '[' . $shortcode) !== false ) {  
            // we have found the short code  
            $found = true;  
        }  
      
        // return our final results  
        return $found;  
    }
}

/**
 * Shorten text to closest complete word from provided text
 */
if( !function_exists('ht_shorten_text') ) {
    function ht_shorten_text ($textblock, $textlen) {

        if ($textblock) {
        //$output = substr(get_the_excerpt(), 0,$textlen);
        //$temp = wordwrap(get_the_excerpt(),$textlen,'[^^^]'); $output= strtok($temp,'[^^^]');
        $output = substr(substr($textblock, 0, $textlen), 0, strrpos(substr($textblock, 0, $textlen), ' '));  
        return $output;
        }
    }
}


/**
 * Get Parent page ID from a Page ID
 */
if( !function_exists('ht_get_parent_page_id') ) {
    function ht_get_parent_page_id($id) {
        global $post;
        // Check if page is a child page (any level)
        if ($post->ancestors) {

            //  Grab the ID of top-level page from the tree
            return end($post->ancestors);
        } else {

            // Page is the top level, so use  it's own id
            return $post->ID;
        }
    }
}

/**
 * Get the page id by slug
 */
if( !function_exists('ht_get_page_id') ) {
    function ht_get_page_id($page_slug) {
        $page_id = get_page_by_path($page_slug);
        if ($page_id) :
            return $page_id->ID;
        else :
            return null;
        endif;
    }    
}




/**
 * Lighten a colour
 * $colour = '#ae64fe';
 * $brightness = 0.5; // 50% brighter
 * $newColour = ht_color_brightness($colour,$brightness);
 * Darken a colour
 * $colour = '#ae64fe';
 * $brightness = -0.5; // 50% darker
 * $newColour = ht_color_brightness($colour,$brightness);
 */
if( !function_exists('ht_color_brightness') ) {
    function ht_color_brightness($hex, $percent) {
        // Work out if hash given
        $hash = '';
        if (stristr($hex,'#')) {
            $hex = str_replace('#','',$hex);
            $hash = '#';
        }
        /// HEX TO RGB
        $rgb = array(hexdec(substr($hex,0,2)), hexdec(substr($hex,2,2)), hexdec(substr($hex,4,2)));
        //// CALCULATE
        for ($i=0; $i<3; $i++) {
            // See if brighter or darker
            if ($percent > 0) {
                // Lighter
                $rgb[$i] = round($rgb[$i] * $percent) + round(255 * (1-$percent));
            } else {
                // Darker
                $positive_percent = $percent - ($percent*2);
                $rgb[$i] = round($rgb[$i] * $positive_percent) + round(0 * (1-$positive_percent));
            }
            // In case rounding up causes us to go to 256
            if ($rgb[$i] > 255) {
                $rgb[$i] = 255;
            }
        }
        //// RBG to Hex
        $hex = '';
        for($i=0; $i < 3; $i++) {
            // Convert the decimal digit to hex
            $hex_digit = dechex($rgb[$i]);
            // Add a leading zero if necessary
            if(strlen($hex_digit) == 1) {
            $hex_digit = "0" . $hex_digit;
            }
            // Append to the hex string
            $hex .= $hex_digit;
        }
        return $hash.$hex;
    }    
}



function ht_string_( $before = '', $string = '', $after = '', $echo = true )
{
    $html = '';
    
    if( $string != '' AND !is_null( $string ) )
        $html = $before . $string . $after;
    
    if( $echo )
        echo $html;
    
    return $html;
}  

?>