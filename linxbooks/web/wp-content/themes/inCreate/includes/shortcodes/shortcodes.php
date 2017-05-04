<?php
/**
 *
 * HighThemes Options Framework
 * twitter : http://twitter.com/theHighthemes
 *
 */

/**
 * Separator
 */
if( ! function_exists( 'ht_separator' ) ) {
    function ht_separator( $atts, $content = null ) {
        extract(shortcode_atts(array(
			'type'     => '',
			'el_class' =>  ''
        ), $atts));

        return '<hr class="'.$type.' '.$el_class.'">';
    }
}
add_shortcode( 'ht_separator', 'ht_separator' );

/**
 * Testimonials (fancy, general)
 */
if( ! function_exists( 'ht_testimonials' ) ) {
    function ht_testimonials( $atts, $content = null ) {
        extract(shortcode_atts(array(
            'style'           => 'light', // dark, lignt
            'effect'          =>  '', // fancy, general
            'testimonial_col' =>  '',
            'el_class'        =>  ''
        ), $atts));

        $out = $final_content = $style_class = $new_content = '';

        switch ($testimonial_col) {
            case '1':
                $testimonial_col_new = '12';
                break;
            
            case '2':
                $testimonial_col_new = '6';
                break;

            case '3':
                $testimonial_col_new = '4';
                break;
            
            case '4':
                $testimonial_col_new = '3';
                break;
        }

        if( $effect == 'general' ) {
            $out .= '<div id="testimonials" class="testimonial-wrapper m_zero"><ul>';
            $new_content .= str_replace('[ht_testimonial','[ht_testimonial effect="'.$effect.'"',$content);
            $out .=  str_replace("grid_", "grid_".$testimonial_col_new."", do_shortcode($new_content));
            $out .= '</ul></div>';
                            
        } else {
            if($style == 'dark') $style_class = 'rev_testimonials';
            $new_content = explode('[/ht_testimonial]', $content);
            array_pop($new_content);
            for ($i=0; $i < count($new_content); $i++) { 
                $new_content[$i] = str_replace('[ht_testimonial', '[ht_testimonial id="'.$i.'"' , $new_content[$i]) . '[/ht_testimonial]';
                $final_content .= $new_content[$i];
            }
            
            $out   = '';
            $out  .= '<div class="clearfix"><div class="fancy_testimonial" data-gen="bigEntrance"><div class="inner_list"><ul>';
            preg_match_all('/image="([^"]*)"/i',$content,$matches);
            $image_src = $matches[1];
            $num       = count($image_src);            
            for ($i=0; $i < $num; $i++) {
                $thumb = wp_get_attachment_image_src( $image_src[$i], 'thumbnail'); 
                $out  .='<li><a href="#t_'.$i.'"><span class="testimonial-img-wrap"><img src="'.$thumb[0].'" alt=""></a></span></li>';
            }
            $out  .= '</ul></div></div></div>';
            $out  .= '<div class="'.$style_class.' fancy_testimonial_testimonial" data-gen="bigEntrance">';
            $new_content = str_replace('[ht_testimonial','[ht_testimonial effect="'.$effect.'"',$final_content);
            $out  .=  do_shortcode($new_content);
            $out  .= '</div>';
        }

        return $out;
    }
}
add_shortcode( 'ht_testimonials', 'ht_testimonials' );


if( ! function_exists( 'ht_testimonial' ) ) {
    function ht_testimonial( $atts, $content = null ) {
        extract(shortcode_atts(array(
            'name'         => '',
            'cite'         => '',
            'image'        => '',
            'effect'       => '',
            'id'           =>  ''
        ), $atts));

        $out  = '';

        if( $effect == 'general' ) {
            $thumb_image = wp_get_attachment_image_src( $image, 'thumbnail');
            $out .= '<li class="grid_ testimonial-s">';
            $out .=     '<div class="testimonial"><p>'.$content.'</p><div class="testimonial-arrow"></div></div>';
            $out .=     '<p><img width="32" height="32" class="client-avat" src="'.$thumb_image[0].'" alt="#"><span class="testimonial-details">';
            $out .=     '<strong class="testimonial-name">'.$name.' </strong> '.$cite.'</span></p>';
            $out .= '</li>';
        } else {
            $out .= '<div class="h_slider"><span class="t_'.$id.'"><i class="icon_quotations"></i>';
            $out .= $content;
            $out .= '<i class="icon_quotations"></i> <small> '.$name.' </small></span></div>';
        }
        
        return $out;
    }
}
add_shortcode( 'ht_testimonial', 'ht_testimonial' );


/**
 * Team member
 */

if( ! function_exists( 'ht_team' ) ) {
    function ht_team( $atts, $content = null ) {
        extract(shortcode_atts(array(
            'team_col' => '3',
            'el_class' => ''
        ), $atts));

    switch ($team_col) {
        case '2':
            $team_col_real = '6';
            break;
        
        case '3':
            $team_col_real = '4';
            break;

        case '4':
            $team_col_real = '3';
            break;            
    }
    $out  = '';
    $out .= '<div class="clearfix '.$el_class.' mbs"><div class="team2 mbs clearfix">';
    $out .=     str_replace("grid_", "grid_".$team_col_real."", do_shortcode($content));
    $out .= '</div></div>'; 

    return $out;
    
    }
}
add_shortcode( 'ht_team', 'ht_team' );


if( ! function_exists( 'ht_member' ) ) {
    function ht_member( $atts, $content = null ) {
        extract(shortcode_atts(array(
            'image'   => '',
            'name'    => '', 
            'job'     => '',
            'socials' => ''
        ), $atts));

        $large_image        = wp_get_attachment_image_src( $image, 'large');
        $socials_lines      = explode(",", $socials);
        $socials_lines_data = array();
        foreach ($socials_lines as $line) {
            $new_line = array();
            $data = explode("|", $line);
            $new_line['icon'] = isset($data[0]) ? $data[0] : 0;
            $new_line['link'] = isset($data[1]) ? $data[1] : 0;
            $new_line['name'] = isset($data[2]) ? $data[2] : '';

            $socials_lines_data[] = $new_line;
        }

        $socials_icons = '';
        foreach($socials_lines_data as $line) {

            $socials_icons .= '<a href="'.$line['link'].'" class="toptip" original-title="'.$line['name'].'"><i class="'.$line['icon'].'"></i></a>';
        }            

        $out  = '';
        $out .= '<div class="grid_"><div class="one-staff">';
        $out .=     '<img src="'.$large_image[0].'" />';
        $out .=     '<h6>'.$name.'</h6><small>'.$job.'</small>';
        $out .=     '<div class="teaminfo">'.$content.'</div>';
        $out .=     '<div class="social tt-metro-social clearfix">'.$socials_icons.'</div>';
        $out .= '</div></div>';

        return $out;

    }
}
add_shortcode( 'ht_member', 'ht_member' );


/**
 * Custom Lists
 */
if( ! function_exists( 'ht_list' ) ) {
    function ht_list( $atts, $content = null ) {
        extract(shortcode_atts(array(
            'type'  => 'bullet-list',
            'decimal'   =>  '',
        ), $atts));
        $numeric_class = (($decimal == 'yes') or ($decimal == 'true')) ? 'numeric' : '' ;
        return str_replace('<ul>', '<ul class="'.$type.' '.$numeric_class.'">', do_shortcode($content));
    }
}
add_shortcode( 'ht_list', 'ht_list' ); 


/**
 * Icon Lists
 */
if (!function_exists('ht_list_icon')) {
    function ht_list_icon ($atts, $content = null) {
        extract(shortcode_atts(array(
            'type'     => '',
            'icon'     => 'fa-heart',
            'icon_color'=>'',
            'el_class' =>  ''
        ),$atts));

    global $ht_options;
    $css_style = $css_class = '';
    if ($icon_color == 'accent')
        $css_style = 'color:'.$ht_options['accent_color'].';';
    elseif ($icon_color == 'custom')
        $css_style = 'color:'.$custom_icon_color.';';

    $new_list = str_replace('<li>', '<li><i style="'.$css_style.'" class="'.$icon.' '.$css_class.'"></i>', $content);
    return str_replace('<ul>', '<ul class="the-list '.$el_class.'">', do_shortcode($new_list));
    }
}
add_shortcode( 'ht_list_icon', 'ht_list_icon' );


/**
 * Buttons
 */
if( ! function_exists( 'ht_button' ) ) {
    function ht_button( $atts, $content = null ) {
        extract(shortcode_atts(array(
			'title'        =>  '',
			'color'        =>  '',
			'custom_color' =>	'',
			'type'         =>	'', // normal, fancy
			'size'         =>  'small',
			'icon_name'    =>	'',
			'link'         =>  '#',
			'target'       =>  '',
			'el_class'     =>  ''
        ), $atts));

        global $ht_options;
        $out = $css_style = '';
        
		if ($type == 'fancy') {
			$out .= '<span class="fancy-btn">';
			switch($color) {
				case ('accent'):
					$color_code = $ht_options['accent_color'];
					break;
				case (''):
					$color_code = '#5486da';
					break;
				case ('color2'):
					$color_code = '#9AD147';
					break;
				case ('color3'):
					$color_code = '#5200FF';
					break;
				case ('color4'):
					$color_code = '#9AD147';
					break;
				case ('color5'):
					$color_code = '#09F';
					break;
				case ('color6'):
					$color_code = '#F00';
					break;
				case ('color7'):
					$color_code = '#2FEFF7';
					break;
				case ('color8'):
					$color_code = '#A58080';
					break;
				case ('color9'):
					$color_code = '#809FA5';
					break;
				case ('custom'):
					$color_code = $custom_color;
					break;
			}
	        $out .= '<a class="tbutton large '.$el_class.'" href="'.$link.'" target="'.$target.'" style="border:1px solid '.$color_code.'; color:'.$color_code.';">';
	        $out .= 	'<span>';
	        $out .= 		(($icon_name != '') and (isset($icon_name))) ? '<i class="'.$icon_name.'" style="border-right: 1px solid "'.$color_code.';"></i>' : '';
	        $out .= 		$title;
	        $out .=		'</span>';
	        $out .= '</a>';
	        $out .= '</span>';
		} else {
	        $out .= '<a class="tbutton '.$color.' '.$size.' '.$el_class.'" href="'.$link.'" target="'.$target.'">';
	        $out .= 	'<span>';
	        $out .= 		(($icon_name != '') and (isset($icon_name))) ? '<i class="'.$icon_name.'"></i>' : '';
	        $out .= 		$title;
	        $out .=		'</span>';
	        $out .= '</a>';
		}
        return $out;
    }
}
add_shortcode( 'ht_button', 'ht_button' );

/**
 * Font Awesome Social Icons
 */
if( ! function_exists( 'ht_social_icon' ) ) {
    function ht_social_icon( $atts, $content = null ) {
        extract(shortcode_atts(array(
			'icon_name' => '',
			'type'      => '',
			'style'     => '',
			'tooltip'   => '',
			'link'      => '#',
			'el_class'  => ''
        ), $atts));

        $out = '';
        $icon_name = 'fa-'.$icon_name;
        $out .= '<a class="toptip social '.$type.' '.$style.' '.$el_class.'" href="'.$link.'" original-title="'.$tooltip.'"><i class="'.$icon_name.'"></i></a>';
        return $out;
    }
}
add_shortcode( 'ht_social_icon', 'ht_social_icon' );

/**
 * Font Awesome Icons
 */
if( ! function_exists( 'ht_icon' ) ) {
    function ht_icon( $atts, $content = null ) {
        extract(shortcode_atts(array(
			'icon_name'    => '',
			'type'         => '', // Rounded, Circular, Simple(without_border)
			'color'        => '',
			'custom_color' => '',
			'tooltip'      => '',
			'link'         => '',
			'target'       => '',
			'el_class'     => ''
        ), $atts));

        global $ht_options;
        $out = $css_style = '';

        if ($color == 'accent') {
        	$color = $ht_options['accent_color'];
        } elseif ($color == 'custom') {
        	$color = $custom_color;
        }

        if (($type == 'rounded') or ($type == 'circular')) {
        	$css_style = 'background-color:'.$color.';';
        } elseif ($type == 'without_border') {
        	$css_style = 'color:'.$color.';';
        }

        $out .= '<a class="toptip ht-icon '.$type.' '.$el_class.'" style="'.$css_style.'" target="'.$target.'" href="'.$link.'" title="'.$tooltip.'">';
        $out .= '<i class="'.$icon_name.'"></i>';
        $out .= '</a>';
        return $out;
    }
}
add_shortcode( 'ht_icon', 'ht_icon' );


/**
 * Content Box: Icon base
 */
if( ! function_exists( 'ht_content_boxes' ) ) {
    function ht_content_boxes( $atts, $content = null ) {
        #echo '<pre>';print_r($atts);echo '</pre>';
        extract(shortcode_atts(array(
            'el_class'   =>  ''
        ), $atts));

        global $ht_options;
        preg_match_all('/icon_name="([^"]*)"/i', $content, $matches);
        $col_num = count($matches[0]);
        $out = '';
        $out .= '<div class="content-boxes '.$el_class.' child'.$col_num.'">';
        $out .= do_shortcode($content);
        $out .= '</div>';
        return $out;
    }
}
add_shortcode( 'ht_content_boxes', 'ht_content_boxes' );

if( ! function_exists( 'ht_content_box' ) ) {
    function ht_content_box( $atts, $content = null ) {
        #echo '<pre>';print_r($atts);echo '</pre>';
        extract(shortcode_atts(array(
            'title'     =>  '',
            'link'      =>  '',
            'target'    =>  '',
            'icon_name' =>  '',
            'el_class'  =>  ''
        ), $atts));

        global $ht_options;
        $out = '';
        $out .= '<div class="content-box '.$el_class.'">
                    <div class="grid_2 cb-icon"><i class="'.$icon_name.'"></i></div>
                    <div class="grid_10 cb-content">
                        <h5> <a href="'.$link.'" target="'.$target.'">'.$title.'</a> </h5>
                        <p>'.$content.'</p>
                    </div>
                </div>';
        return $out;
    }
}
add_shortcode( 'ht_content_box', 'ht_content_box' );

/**
 * Information Box: alert messages
 */
if( ! function_exists( 'ht_info_box' ) ) {
    function ht_info_box( $atts, $content = null ) {
        extract(shortcode_atts(array(
            'title'    =>  '',
            'type'     =>  '',
            'el_class' =>  ''
        ), $atts));
            
            switch ($type) {
                case 'success':
                    $icon = 'check';
                    break;

                case 'info':
                    $icon = 'flag';
                    break;

                case 'error':
                    $icon = 'power-off';
                    break;

                case 'warning':
                    $icon = 'exclamation-triangle';
                    break;                                                        

            }
            
            $out = '';
            $out .= '<div class="notification-box notification-box-'.$type.' '.$el_class.'">';
            $out .=     '<p><i class="fa-'.$icon.'"></i>'.$content.'</p>';
            $out .=     '<a href="#" class="notification-close notification-close-'.$type.'"><i class="fa-times"></i></a>';
            $out .= '</div>';            

        return $out;
    }
}
add_shortcode( 'ht_info_box', 'ht_info_box' );


/**
 * Call To Action Box
 */
if( ! function_exists( 'ht_cta' ) ) {
    function ht_cta( $atts, $content = null ) {
        extract(shortcode_atts(array(
            'title'                 =>  '',
            'subtitle'              =>  '',
            'align'                 =>  'right',
            'style'                 =>  'light', 
            'btn_text'              =>  '',
            'btn_link'              =>  '',
            'el_class'              =>  ''
             ), $atts));

        $out =  $action_style = '';
        if ( $align == 'left' ) {
            $action_align = 'rev';
            $action_btn   = 'fll';
        } elseif ( $align == 'center' ) {
            $action_align = 'tac';
            $action_btn   = 'mtf';
        } else {
            $action_align = '';
            $action_btn   = 'flr';
        }
        if( $style == 'dark' ) {
            $action_style = 'dark_action';
        }
        $out .= '<div class="action mbf '.$action_align.' '.$action_style.' clearfix">';
        $out .=    '<div class="inner">';
        if ( $align == 'left' || $align == 'right' || $align == '' ) {
        $out .=        '<a class="tbutton '.$action_btn.' medium" href="'.$btn_link.'"><span>'.$btn_text.'</span></a>'; 
        }
        $out .=        '<div class="matn">';
        $out .=            '<h4>'.$title.'</h4>';
        $out .=            '<p>'.$subtitle.'</p>';
        $out .=        '</div>';
        if ( $align == 'center' ) {
        $out .=        '<a class="tbutton '.$action_btn.' medium" href="'.$btn_link.'"><span>'.$btn_text.'</span></a>'; 
        }        
        $out .=    '</div>';
        $out .= '</div>';

        return $out;

    }
}
add_shortcode( 'ht_cta', 'ht_cta' );


/**
 * Tooltip
 */
if( ! function_exists( 'ht_tooltip' ) ) {
    function ht_tooltip( $atts, $content = null ) {
        extract(shortcode_atts(array(
            'trigger'      => '',
        ), $atts));
        $out = '';
        $out .= '<span class="tooltip-sc">'.$content.'</span>';
        $out .= '<span class="tool-tip">';
        $out .= '<span class="tooltip-body">'.$trigger.'</span>';
        $out .= '<span class="tooltip-tip"></span>';
        $out .= '</span>';

        return $out;
    }
}
add_shortcode( 'ht_tooltip', 'ht_tooltip' );


/**
 * Video
 */
if( ! function_exists( 'ht_embed_video' ) ) {
    function ht_embed_video( $atts) {
        extract(shortcode_atts(array(
            'url'               => 'youtube, vimeo, dailymotion',
            'splash_image'      => '',
            'width'             => '550',
            'height'            => '',
            'mp4'               => '',
            'webm'              => '',
            'flv'               => '',
            'ogv'               => '',
            'preload'           => 'none',
            'autoplay'          => '',
            'loop'              => '0'
         
        ), $atts));

        return  embed_video($url, $width, $height, $mp4, $webm, $flv, $ogg, $splash_image, $preload, $autoplay, $loop);
    }
}
add_shortcode( 'ht_video', 'ht_embed_video' );


/**
 * <code>
 */
if( ! function_exists( 'ht_code' ) ) {
    function ht_code( $atts, $content = null ) {
        return '<code class="code">'.$content.'</code>';
    }
}
add_shortcode( 'ht_code', 'ht_code' );

/**
 * <pre></pre>
 */
if( ! function_exists( 'ht_pre' ) ) {
    function ht_pre( $atts, $content = null ) {
        return '<pre class="pre">'.$content.'</pre>';
    }

}
add_shortcode( 'ht_pre', 'ht_pre' );

/**
 * Drop Caps
 */
if( ! function_exists( 'ht_drop_cap' ) ) {
    function ht_drop_cap( $atts, $content = null ) {
        extract(shortcode_atts(array(
			'type'   => '', // text-only, bordered, with-background
			'color'  => '',
			'radius' => '', // square, rounded1, rounded2, circular
        ), $atts));

        global $ht_options;

        $css_style = $element_class = '';
        $color = ($color == 'accent') ? $ht_options['accent_color'] : $color ;

        switch ($type) {
        	case 'with-background':
        		$css_style .= 'background-color:'.$color.';';
                $element_class .= 'dropcap ';
        		break;
        	case 'text-only':
        		$css_style .= 'color:'.$color.';';
                $element_class .= 'dropcap-txt ';
        		break;
        	case 'bordered':
        		$css_style .= 'color:'.$color.';';
        		$css_style .= 'border:1px solid '.$color.';';
                $element_class .= 'dropcap-border ';
        		break;
        	default:
        		break;
        }

        switch ($radius) {
            case 'square':
                $element_class .= '';
                break;
            case 'rounded1':
                $element_class .= 'four-radius';
                break;
            case 'rounded2':
                $element_class .= 'ten-radius';
                break;
            case 'circular':
                $element_class .= 'circle-radius';
                break;
            default:
                break;
        }

            return '<span class="'.$element_class.'" style="'.$css_style.'" >'.$content.'</span>';
    }
}
add_shortcode( 'ht_dropcap', 'ht_drop_cap' );


/**
 * Callout Right
 */
if( ! function_exists( 'ht_callout_right' ) ) {
    function ht_callout_right( $atts, $content = null ) {
        extract(shortcode_atts(array(
            'style'  =>  '',
        ),$atts));

        return '<div class="blockquote right">'.$content.'</div>';
    }
}
add_shortcode( 'ht_callout_right', 'ht_callout_right' );


/**
 * Callout Left
 */
if( ! function_exists( 'ht_callout_left' ) ) {
    function ht_callout_left( $atts, $content = null ) {
        extract(shortcode_atts(array(
            'style'  =>  '',
        ),$atts));

        return '<div class="blockquote left">'.$content.'</div>';
    }
}
add_shortcode( 'ht_callout_left', 'ht_callout_left' );


/**
 * Pullquote
 */
if( ! function_exists( 'ht_pullquote' ) ) {
    function ht_pullquote( $atts, $content = null ) {
        extract(shortcode_atts(array(
            'cite'      => '',
            'style'  =>  '',
        ), $atts));

        return '<div class="blockquote">'.$content.'</div>';
    }
}
add_shortcode( 'ht_pullquote', 'ht_pullquote' );


/**
 * Text Highlight
 */
if( ! function_exists( 'ht_highlight' ) ) {
    function ht_highlight ($atts, $content = null) {
        extract(shortcode_atts(array(
            'text_color' => '',
            'bg_color'   => '',
        ), $atts));

        $css_class = $css_style = $out = '';

        $css_style = 'background-color:'.$bg_color.'; color:'.$text_color.';';

        $out = '<span class ="highlight-text" style="'.$css_style.'">';
        $out .= do_shortcode($content);
        $out .= '</span>';
        return $out;
    }
}
add_shortcode( 'ht_highlight', 'ht_highlight');


/**
 * Lightbox Effect
 */
if( ! function_exists( 'ht_lightbox' ) ) {
    function ht_lightbox ($atts, $content = null) {
        extract(shortcode_atts(array(
            'big_image_url' => '',
            'type'          => '',
            'image_url'     => '',
            'align'         => '', // left , right
            'video_url'     =>  '',
            'el_class'      => '',
        ), $atts));

        $content = str_replace("&#215;", "x", $content);
        $out = '';
        $css_align_class = ($align == 'right') ? 'fr' : 'fl' ;
        if ($type == "image") {
            $out .= '<a class="'.$css_align_class.'" href="'.$big_image_url.'" data-gal="lightbox"><img src="'.$content.'"></a>';
        } elseif ($type == "video") {
            $out .= '<a class="'.$css_align_class.'" data-gal="lightbox" href="'.$video_url.'"><img src="'.$content.'"></a>';
        }

        return $out;
    }
}
add_shortcode( 'ht_lightbox', 'ht_lightbox' );


/**
 * Client Logoes
 */
if( ! function_exists( 'ht_client_logos' ) ) {
    function ht_client_logos( $atts, $content = null ) {
        extract(shortcode_atts(array(
            'title'    =>  '',
            'el_class' =>  ''
        ), $atts));

        $out = '';
        preg_match_all('/logo="([^"]*)"/i',$content,$matches);
        $col_num = count($matches[0]);


        if ($title!="") {
        	$out .= '<div class="tac '.$el_class.' client-logos">';
        	$out .=     '<h3 class="block_title">'.$title.'</h3>';
        	$out .=     '<span class="after_line"></span></div>';
        }
        $out .= '<ul class="'.$el_class.'">';
        $new_content = str_replace('[ht_client_logo', '[ht_client_logo col_num="'.$col_num.'"', $content);
        $out .=     do_shortcode($new_content);
        $out .= '</ul>';

        return $out;
    }
}
add_shortcode( 'ht_client_logos', 'ht_client_logos' );

if( ! function_exists( 'ht_client_logo' ) ) {
    function ht_client_logo( $atts, $content = null ) {
        extract(shortcode_atts(array(
            'logo'    => '',
            'link'    => '#',
            'title'   => '',
            'target'  => '',
            'col_num' => '6',
            'el_class'=>''
        ), $atts));

        $grid_num = (($col_num == 5) or ($col_num > 6)) ? '2' : (12/$col_num) ;
        $large_logo = wp_get_attachment_image_src( $logo, 'large');

        $out = '';
        $out .= '<li class="grid_'.$grid_num.' '.$el_class.'">';
        $out .=     '<a href="'.$link.'" target="'.$target.'">';
        $out .=         '<img class="toptip" original-title="'.$title.'" src="'.$large_logo[0].'" />';
        $out .=     '</a>';
        $out .= '</li>';
        return $out;
    }
}
add_shortcode( 'ht_client_logo', 'ht_client_logo' );


/**
 * Google Map 
 */
if( ! function_exists( 'ht_google_map' ) ) {
    function ht_google_map( $atts, $content = null ) {
        extract(shortcode_atts(array(
            'values'  =>'',
            'height' => '230',
            'zoom'   => '10', // 1-19
            'type'   => 'ROADMAP', // ROADMAP, SATELLITE, HYBRID, TERRAIN
            'el_class'   =>  '',
            'fullwidth' => false
        ), $atts));
        wp_enqueue_script( "google-map", "http://maps.google.com/maps/api/js?sensor=false");
        $unique = uniqid();

        $gmap_lines = explode(",", $values);
        $max_value = 0.0;
        $gmap_lines_data = array();
        foreach ($gmap_lines as $line) {
            $new_line = array();
            $text_info = 2;
            $data = explode("|", $line);
            $new_line['lat'] = isset($data[0]) ? $data[0] : 0;
            $new_line['lng'] = isset($data[1]) ? $data[1] : 0;
            $new_line['text_info'] = isset($data[2]) ? $data[2] : '';

            $gmap_lines_data[] = $new_line;
        }

        $location = '';
        foreach($gmap_lines_data as $line) {
        
            $location .= "['<div class=\"gmap-info\">". $line['text_info'] ."</div>', ". $line['lat'] .", ". $line['lng'] ."],";

        }  

        $fullwidth = ( $fullwidth == 'yes' )  ? 'full-screen-gmap' : '';


   

        $out = <<<EOF
<div id="google_map_{$unique}" class="google-map $fullwidth" style="height:{$height}px;" >
</div>
  <script type="text/javascript">
  (function(){
    // Define your locations: HTML content for the info window, latitude, longitude
    var locations = [
        $location
    ];
    
    // Setup the different icons and shadows
    var iconURLPrefix = 'http://maps.google.com/mapfiles/ms/icons/';
    
    var icons = [
      iconURLPrefix + 'red-dot.png',
      iconURLPrefix + 'green-dot.png',
      iconURLPrefix + 'blue-dot.png',
      iconURLPrefix + 'orange-dot.png',
      iconURLPrefix + 'purple-dot.png',
      iconURLPrefix + 'pink-dot.png',      
      iconURLPrefix + 'yellow-dot.png'
    ]
    var icons_length = icons.length;
    
    
    var shadow = {
      anchor: new google.maps.Point(15,33),
      url: iconURLPrefix + 'msmarker.shadow.png'
    };

    var map = new google.maps.Map(document.getElementById('google_map_{$unique}'), {
      zoom: {$zoom},
      center: new google.maps.LatLng(locations[0][1], locations[0][2]),
      mapTypeId: google.maps.MapTypeId.{$type},
      mapTypeControl: false,
      streetViewControl: false,
      panControl: true,
      zoomControlOptions: {
         position: google.maps.ControlPosition.LEFT_BOTTOM
      }
    });

    var infowindow = new google.maps.InfoWindow({
      maxWidth: 600
    });

    var marker;
    var markers = new Array();
    
    var iconCounter = 0;
    
    // Add the markers and infowindows to the map
    for (var i = 0; i < locations.length; i++) {  
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map,
        icon : icons[iconCounter],
        shadow: shadow
      });

      markers.push(marker);

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locations[i][0]);
          infowindow.open(map, marker);
        }
      })(marker, i));
      
      iconCounter++;
      // We only have a limited number of possible icon colors, so we may have to restart the counter
      if(iconCounter >= icons_length){
        iconCounter = 0;
      }
     
    }
        function AutoCenter() {
      //  Create a new viewpoint bound
      var bounds = new google.maps.LatLngBounds();
      //  Go through each...
      jQuery.each(markers, function (index, marker) {
        bounds.extend(marker.position);
      });
      //  Fit these bounds to the map
      map.fitBounds(bounds);
    }
    if( locations.length > 1 ) {
        AutoCenter();     
    }


})();    
  </script> 
EOF;

return $out;

    }
}
add_shortcode( 'ht_google_map', 'ht_google_map' );


/**
 * Services
 */
if (!function_exists('ht_services')) {
    function ht_services($atts, $content = null) {
        extract(shortcode_atts(array(
            'icon_direction' =>  '',
            'extra_class'       =>  ''
        ), $atts));

        global $ht_options;

        preg_match_all('/icon="([^"]*)"/i',$content,$matches);
        $col_num = count($matches[0]);

        $out  = '';
        $direction_class = ($icon_direction == 'left') ? 'set_two' : '' ;
        $out .= '<div class="services '.$direction_class.' '.$extra_class.'">';
        $new_content = str_replace('[ht_service_item', '[ht_service_item col_num="'.$col_num.'"', $content);
        $out .=     do_shortcode($new_content);
        $out .= '</div>'; // services
        return $out;
    }
}
add_shortcode( 'ht_services', 'ht_services' );

/**
 * Service item
 */
if (!function_exists('ht_service_item')) {
    function ht_service_item($atts, $content = null) {
        extract(shortcode_atts(array(
            'title'       => '',
            'icon'        => '',
            'link'        => '',
            'link_title'  => 'More Details',
            'target'      => '',
            'description' => '',
            'col_num'     => '2',
            'extra_class'    => ''
        ), $atts));

        global $ht_options;
        $out   = '';
        $grid_num = (($col_num == 5) or ($col_num > 6)) ? 2 : (12 / $col_num);
        $out .= '<div class="grid_'.$grid_num.' '.$extra_class.'">';
        $out .=     '<div class="s_icon">';
        $out .=         '<i class="'.$icon.'"></i><span class="fa-check"></span>';
        $out .=     '</div>';
        $out .=         '<div class="s_info">';
        $out .=         '<h3>'.$title.'</h3>';
        if($description != "")
            $out .=         '<p>'.$description.'</p>';
        if($link != "")
            $out .=         '<a class="tbutton small" href="'.$link.'" target="'.$target.'"><span>'.$link_title.'</span></a>';
        $out .=     '</div>';
        $out .= '</div>';

        return $out;
    }
}
add_shortcode( 'ht_service_item', 'ht_service_item' );

/**
 * Pricing table
 */
if( ! function_exists( 'ht_pricing_table' ) ) {
    function ht_pricing_table( $atts, $content = null ) {
        extract(shortcode_atts(array(
            'cols' => '4'
        ), $atts));

        switch ($cols) {
            case '2':
                $pricing_col = '6';
                break;
            
            case '3':
                $pricing_col = '4';
                break;

            case '4':
                $pricing_col = '3';
                break;            
        }        
        $out = '';
        $out .= '<div class="pricing clearfix mbs">';
        $out .=     str_replace("grid_", "grid_".$pricing_col."", do_shortcode($content));
        $out .= '</div>';

        return $out;
    }
}
add_shortcode( 'ht_pricing_table', 'ht_pricing_table' );


if( ! function_exists( 'ht_pricing_col' ) ) {
    function ht_pricing_col( $atts, $content = null ) {
        extract(shortcode_atts(array(
            'title'          =>  'standard',
            'price'          =>  '',
            'sign'           =>  '$',
            'special'        =>  'no',
            'interval'       =>  '',
            'special_reason' =>  '',
            'btn_title'      => 'Title',
            'btn_link'       => '#',
        ), $atts));

        global $ht_options;
        $out =  $title_css = $title_class = '';

        $out .=  '<div class="grid_">';
        if($special != 'no') {
        $out .=    '<div class="pricing-table featured_table">';
        $out .=        '<div class="recommended">'.$special_reason.'</div>';
        } else {
        $out .=    '<div class="pricing-table">'; 
        }
        $out .=        '<div class="head blues">';
        $out .=            '<h4>'.$title.'</h4>';
        $out .=            '<h1>'.html_entity_decode($sign) . $price.'</h1>';
        $out .=            '<span>'.$interval.'</span>';
        $out .=        '</div>';
        $out .=        '<div class="price-content">';
        $out .=            do_shortcode($content);
        if($special != 'no') {
        $out .=            '<a href="'.$btn_link.'" class="tbutton medium"><span>'.$btn_title.'</span></a>';
        } else {
        $out .=            '<a href="'.$btn_link.'" class="tbutton color8 medium"><span>'.$btn_title.'</span></a>';            
        }
        $out .=        '</div>';
        $out .=    '</div>';
        $out .=  '</div>';

        return $out;
    }
}
add_shortcode( 'ht_pricing_col', 'ht_pricing_col' );


/**
 * Grid columns
 */
if( ! function_exists( 'ht_one_half' ) ) {
    function ht_one_half( $atts, $content = null ) {
        extract(shortcode_atts(array(
            'last'      => 'no',
        ), $atts));
        $content = preg_replace('#^<\/p>|<p>$#', '', $content);
        $class = ($last == 'yes') ? 'last' : '';
        if ($last == 'yes') {
            return '<div class="grid_6 '.$class.'">' . do_shortcode($content) . '</div><div class="clear"></div>';
        } else {
            return '<div class="grid_6 '.$class.'">' . do_shortcode($content) . '</div>';
        }
    }
}
add_shortcode( 'one_half', 'ht_one_half' );


if( ! function_exists( 'ht_one_third' ) ) {
    function ht_one_third( $atts, $content = null ) {
        extract(shortcode_atts(array(
            'last'      => 'no',
        ), $atts));
        $content = preg_replace('#^<\/p>|<p>$#', '', $content);
        $class = ($last == 'yes') ? 'last' : '';
        if ($last == 'yes') {
            return '<div class="grid_4 '.$class.'">' . do_shortcode($content) . '</div><div class="clear"></div>';
        } else {
            return '<div class="grid_4 '.$class.'">' . do_shortcode($content) . '</div>';
        }
    }
}
add_shortcode( 'one_third', 'ht_one_third' );


if( ! function_exists( 'ht_one_fourth' ) ) {
    function ht_one_fourth( $atts, $content = null ) {
        extract(shortcode_atts(array(
            'last'      => 'no',
        ), $atts));
        $content = preg_replace('#^<\/p>|<p>$#', '', $content);
        $class = ($last == 'yes') ? 'last' : '';
        if ($last == 'yes') {
            return '<div class="grid_3 '.$class.'">' . do_shortcode($content) . '</div><div class="clear"></div>';
        } else {
            return '<div class="grid_3 '.$class.'">' . do_shortcode($content) . '</div>';
        }
    }
}
add_shortcode( 'one_fourth', 'ht_one_fourth' );


if( ! function_exists( 'ht_one_sixth' ) ) {
    function ht_one_sixth( $atts, $content = null ) {
        extract(shortcode_atts(array(
            'last'      => 'no',
        ), $atts));
        $content = preg_replace('#^<\/p>|<p>$#', '', $content);
        $class = ($last == 'yes') ? 'last' : '';
        if ($last == 'yes') {
            return '<div class="grid_2 '.$class.'">' . do_shortcode($content) . '</div><div class="clear"></div>';
        } else {
            return '<div class="grid_2 '.$class.'">' . do_shortcode($content) . '</div>';
        }
    }
}
add_shortcode( 'one_sixth', 'ht_one_sixth' );


if( ! function_exists( 'ht_two_third' ) ) {
    function ht_two_third( $atts, $content = null ) {
        extract(shortcode_atts(array(
            'last'      => 'no',
        ), $atts));
        $content = preg_replace('#^<\/p>|<p>$#', '', $content);
        $class = ($last == 'yes') ? 'last' : '';
        if ($last == 'yes') {
            return '<div class="grid_8 '.$class.'">' . do_shortcode($content) . '</div><div class="clear"></div>';
        } else {
            return '<div class="grid_8 '.$class.'">' . do_shortcode($content) . '</div>';
        }
    }
}
add_shortcode( 'two_third', 'ht_two_third' );


if( ! function_exists( 'ht_three_fourth' ) ) {
    function ht_three_fourth( $atts, $content = null ) {
        extract(shortcode_atts(array(
            'last'      => 'no',
        ), $atts));
        $content = preg_replace('#^<\/p>|<p>$#', '', $content);
        $class = ($last == 'yes') ? 'last' : '';
        if ($last == 'yes') {
            return '<div class="grid_9 '.$class.'">' . do_shortcode($content) . '</div><div class="clear"></div>';
        } else {
            return '<div class="grid_9 '.$class.'">' . do_shortcode($content) . '</div>';
        }
    }
}
add_shortcode( 'three_fourth', 'ht_three_fourth' );

if( ! function_exists( 'ht_five_sixth' ) ) {
    function ht_five_sixth( $atts, $content = null ) {
        extract(shortcode_atts(array(
            'last'      => 'no',
        ), $atts));
        $content = preg_replace('#^<\/p>|<p>$#', '', $content);
        $class = ($last == 'yes') ? 'last' : '';
        if ($last == 'yes') {
            return '<div class="grid_10 '.$class.'">' . do_shortcode($content) . '</div><div class="clear"></div>';
        } else {
            return '<div class="grid_10 '.$class.'">' . do_shortcode($content) . '</div>';
        }
        
    }
}
add_shortcode( 'five_sixth', 'ht_five_sixth' );


/**
 * Fancy heading titles
 */
if( ! function_exists( 'ht_fancy_title' ) ) {
    function ht_fancy_title( $atts, $content = null ) {
        extract(shortcode_atts(array(
            'size'      => '', // 1-6
            'type'      => '', // liner, double, doublepress, dotted, dashed, inside_liner, inside_pat, dotted_line, dashed_line, line_line 
            'align'     => 'left',
            'color'     => '', 
            'el_class'  => ''
        ), $atts));


        $out = '';

        $heading_title = '<h'.$size.' class="col-title '.$el_class.'">'. $content .'</h'.$size.'>';
        $heading_title_inline_dotted = '<h'.$size.' style="border-bottom: 1px dotted '.$color.'" class="col-title inline '.$el_class.'">'. $content .'</h'.$size.'>';
        $heading_title_inline_dashed = '<h'.$size.' style="border-bottom: 1px dashed '.$color.'" class="col-title inline '.$el_class.'">'. $content .'</h'.$size.'>'; 
        $heading_title_inline_line = '<h'.$size.' style="border-bottom: 2px solid '.$color.'" class="col-title inline '.$el_class.'">'. $content .'</h'.$size.'>';                
        $heading_title_inside_liner = '<h'.$size.' style="border-bottom-color: '.$color.'" class="col-ten '.$el_class.'"><span>'. $content .'</span></h'.$size.'>';
        $heading_title_inside_pat = '<h'.$size.' class="col-eleven '.$el_class.'"><span>'. $content .'</span></h'.$size.'>';
        
        switch ($type) {
            case 'inside_liner':
                $heading_out = $heading_title_inside_liner;        
                break;

            case 'inside_pat':
                $heading_out = $heading_title_inside_pat;        
                break;
                                            
            case 'double':
                $heading_out = ' '.$heading_title.' <span style="border-bottom-color: '.$color.'" class="liner double"></span>';        
                break;

            case 'doublepress':
                $heading_out = ' '.$heading_title.' <span style="border-bottom-color: '.$color.'; border-top-color: '.$color.'" class="liner doublepress"></span>';        
                break; 

            case 'dotted':
                $heading_out = ' '.$heading_title.' <span style="border-bottom-color: '.$color.'" class="liner dotted"></span>';        
                break; 

            case 'dashed':
                $heading_out = ' '.$heading_title.' <span style="border-bottom-color: '.$color.'" class="liner dashed"></span>';        
                break;

            case 'dashed_line':
                $heading_out = ' '.$heading_title_inline_dashed.' <span class="liner"></span>';        
                break;                   

            case 'dotted_line':
                $heading_out = ' '.$heading_title_inline_dotted.' <span class="liner"></span>';        
                break;                                                            
            
            case 'line_line':
                $heading_out = ' '.$heading_title_inline_line.' <span class="liner"></span>';        
                break;    

            default:
                $heading_out = ' '.$heading_title.' <span style="border-bottom-color: '.$color.'" class="liner"></span>';        
                break;   
        }            
                
        switch ($align) {
            case 'center':
                $out .= '<div class="tac">'.$heading_out.'</div>';        
                break;

            case 'right':
                $out .= '<div class="tar">'.$heading_out.'</div>';        
                break;            
            
            default:
                $out .= $heading_out;        
                break;
        }

/*        $fancy_title_icon = '';
        if ( $icon_name != '' ) $fancy_title_icon = '<i class="'.$icon_name.'"></i>';
        $out = '';
        $out .= '<div class="fancy-title '.$el_class.'">';
        if (($link != '') and ($link != '#')) {
            $out .= '<h'.$size.'>'.$fancy_title_icon.'<a href="'.$link.'" target="'.$target.'">'. $content .'</a></h'.$size.'>';
        } else {
            $out .= '<h'.$size.'>'.$fancy_title_icon.''. $content .'</h'.$size.'>';
        }

        if( $type == '' ) {
            $out .=     '<div class="divider-container"><div class="divider-none"></div></div>';
        } else {
            $out .=     '<div class="divider-container"><div class="divider-'.$type.'"></div></div>';            
        }
        $out .= '</div>';*/

        return $out;
    }
}
add_shortcode( 'ht_fancy_title', 'ht_fancy_title' ); 


// remove default shortcode
remove_shortcode('gallery', 'gallery_shortcode');

/**
 * Re-declare Wordpress gallery shortcode
 */
function ht_gallery_shortcode($attr) {
    $post = get_post();

    static $instance = 0;
    $instance++;

    if ( ! empty( $attr['ids'] ) ) {
        // 'ids' is explicitly ordered, unless you specify otherwise.
        if ( empty( $attr['orderby'] ) )
            $attr['orderby'] = 'post__in';
        $attr['include'] = $attr['ids'];
    }

    // Allow plugins/themes to override the default gallery template.
    $output = apply_filters('post_gallery', '', $attr);
    if ( $output != '' )
        return $output;

    // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
    if ( isset( $attr['orderby'] ) ) {
        $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
        if ( !$attr['orderby'] )
            unset( $attr['orderby'] );
    }

    extract(shortcode_atts(array(
        'order'      => 'ASC',
        'orderby'    => 'menu_order ID',
        'id'         => $post ? $post->ID : 0,
        'itemtag'    => 'li',
        'icontag'    => 'div',
        'captiontag' => 'h5',
        'columns'    => 3,
        'size'       => 'thumbnail',
        'include'    => '',
        'exclude'    => ''
    ), $attr, 'gallery'));

    $id = intval($id);
    if ( 'RAND' == $order )
        $orderby = 'none';

    if ( !empty($include) ) {
        $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

        $attachments = array();
        foreach ( $_attachments as $key => $val ) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    } elseif ( !empty($exclude) ) {
        $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    } else {
        $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    }

    if ( empty($attachments) )
        return '';

    if ( is_feed() ) {
        $output = "\n";
        foreach ( $attachments as $att_id => $attachment )
            $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
        return $output;
    }

    $itemtag = tag_escape($itemtag);
    $captiontag = tag_escape($captiontag);
    $icontag = tag_escape($icontag);
    $valid_tags = wp_kses_allowed_html( 'post' );
    if ( ! isset( $valid_tags[ $itemtag ] ) )
        $itemtag = 'dl';
    if ( ! isset( $valid_tags[ $captiontag ] ) )
        $captiontag = 'dd';
    if ( ! isset( $valid_tags[ $icontag ] ) )
        $icontag = 'dt';

    $columns = intval($columns);


    switch ($columns) {
        case 1:
            $span ='span12';
            $size ='full-width';
            break;
        case 2:
            $span ='grid_6';
            $size = 'portfolio-thumbnail';
            break;
        case 3:
            $span ='grid_4';
            $size='portfolio-thumbnail';
            break;
        case 4:
            $span ='grid_3';
            $size='portfolio-thumbnail';

            break;
        
        default:
            $span ='grid_3';
            $size='portfolio-thumbnail';

            break;
    }
    $itemwidth = $columns > 0 ? floor(100/$columns) : 100;
    $float = is_rtl() ? 'right' : 'left';

    $selector = "gallery-{$instance}";

    $gallery_style = $gallery_div = '';
    if ( apply_filters( 'use_default_gallery_style', true ) )
        $gallery_style = "
        <style type='text/css'>
            #{$selector} {
                margin: auto;
            }
            #{$selector} .gallery-item {
                float: {$float};
                margin-top: 10px;
                text-align: center;
                margin-bottom: 20px;
                
            }
            #{$selector} .gallery-item.span12 {
            margin-left: 0;
                
            }   
            #{$selector} .post-image {
            display: block;
            position: relative;
            overflow: hidden;
            }
            #{$selector} .gallery-item img {
                width: 100%;
                height: auto;
            }            
            #{$selector} .gallery-caption {
                margin-left: 0;
                margin-top:10px;
            }
            /* see gallery_shortcode() in wp-includes/media.php */
        </style>";
    $size_class = sanitize_html_class( $size );
    $gallery_div = "<ul id='$selector' class='portfolio gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";
    $output = apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );

    $i = 0;
    foreach ( $attachments as $id => $attachment ) {
        if ( ! empty( $attr['link'] ) && 'file' === $attr['link'] ) {
            $image_full_url = wp_get_attachment_image_src($id, 'large');            
            $image_output = '<div class="post-image">';
            $image_output .= wp_get_attachment_image( $id, $size, false );
            $image_output .= '
                                <div class="f_hover">
                                    <div class="f_links">
                                        <a class="tbutton small" href="'.$image_full_url[0].'" data-gal="lightbox[folio]"><span><i class="arrow_expand"></i></span></a>
                                    </div>';
            if ( $captiontag && trim($attachment->post_excerpt) ) {
                $image_output .= "
                    <{$captiontag} class='wp-caption-text gallery-caption'>
                    " . wptexturize($attachment->post_excerpt) . "
                    </{$captiontag}>";
            }                                    
            $image_output .= '</div></div>';            
        }

        elseif ( ! empty( $attr['link'] ) && 'none' === $attr['link'] )
            $image_output = wp_get_attachment_image( $id, $size, false );
        else {
            $image_output = '<div class="post-image">';
            $image_output .= wp_get_attachment_image( $id, $size, false );
            $image_output .= '
                                <div class="f_hover">
                                    <div class="f_links">
                                        <a class="tbutton small" href="'.get_attachment_link( $id ).'"><span>'.__("More Details", "highthemes").'</span></a>
                                    </div>';
            if ( $captiontag && trim($attachment->post_excerpt) ) {
                $image_output .= "
                    <{$captiontag} class='wp-caption-text gallery-caption'>
                    " . wptexturize($attachment->post_excerpt) . "
                    </{$captiontag}>";
            }                                    
            $image_output .= '</div></div>';              
        } 
        

        

        $image_meta  = wp_get_attachment_metadata( $id );

        $orientation = '';
        if ( isset( $image_meta['height'], $image_meta['width'] ) )
            $orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';
        $last_item ='';
        if ( $columns > 0 && ++$i % $columns == 0 && $columns !==1 )
            $last_item .= 'last-item';

        $output .= "<{$itemtag} class='gallery-item $span $last_item'>";
        $output .= "
            <{$icontag} class='gallery-icon {$orientation}'>
                $image_output
            </{$icontag}>";
        
        $output .= "</{$itemtag}>";

    }

    $output .= "
            <br style='clear: both;' />
        </ul>\n";

    return $output;
}
add_shortcode( 'gallery', 'ht_gallery_shortcode' );


/**
 * Portfolio Shortcode
 */
if( ! function_exists( 'ht_portfolio' ) ) {
    function ht_portfolio( $atts, $content = null ) {
        extract(shortcode_atts(array(
            'columns'        => '4',
            'alignment'      => 'left',
            'items_count'    => '9',
            'post_ids'       => '',
            'exclude_ids'    => '',
            'categories'     => '',
            'thumbnail_size' => 'portfolio-thumbnail',
            'orderby'        => 'date',
            'order'          => 'ASC',
            'disable_filter' => 'no',
            'layout'         => 'grid',
            'carousel_title' => '',
            'carousel_desc'  => '',
            'el_class'       =>  ''
        ), $atts));


        $filter = ($disable_filter == 'yes') ? 'no' : 'yes' ;
        $out = '';
        // number of columns
        $columns = ( $columns == "2" || $columns == "3" || $columns == "4"  ) ? $columns : "4";
        $span_col = 'grid_4';
        switch ($columns) {
            case "2":
                $span_col = 'grid_6';
                break;
            case "3":
                $span_col = 'grid_4';
                break;
            case "4":
                $span_col = 'grid_3';
                break;                                
            
            default:
                $span_col = 'grid_4';
                break;
        }
        // number of items
        if(is_numeric($items_count)){
            $items_count = $items_count;
        } else {
            $items_count = -1;
        }

        // includedd items
        if( !empty($post_ids) ) {
            $post_ids = explode(",", $post_ids);
        }

        // excludes items
        if( !empty($exclude_ids) ) {
            $exclude_ids = explode(",", $exclude_ids);
        } 

        // categories
        if( !empty($categories) ) {
            $categories = explode(",", $categories);
        } else {
            $categories = '';
        }


        // order
        $order = (strtolower($order)=='desc') ? 'DESC' : 'ASC' ;

        // order by
        $orderby = (empty($orderby)) ? 'date' : $orderby;

        // filter
        $filter = ($filter == 'no') ? false : true;

        // aloignment
        $alignment = ($alignment == 'left') ? 'desc-left' : 'desc-right';        

        $args = array(
            'posts_per_page'        => $items_count,
            'post_type'             => 'portfolio',
            'orderby'              => $orderby,
            'order'                =>$order
           
        );
        if( !empty($categories) ) {
            $args['tax_query'] = array(
                array(
                    'taxonomy'  => 'portfolio-category',
                    'field'     => 'slug',
                    'terms'     => $categories
                )
            );

        }
        if( isset($post_ids) && is_array($post_ids) ){
            $args['post__in'] = $post_ids;
        }
        if( isset($exclude_ids) && is_array($exclude_ids) ){
            $args['post__not_in'] = $exclude_ids;
        }        
        $folio_query = new WP_Query($args);
        if ($folio_query->have_posts()) :

            if( is_array($categories) ) {

                // getting the list of terms
                foreach( $categories as $index=>$value ) {
                    $term_details = get_term_by( 'slug', $value, 'portfolio-category');
                    if(!isset($term_details->name)) continue;
                    $term_array[$value] = $term_details->name;
                }

            }

        /*===================================
        =            If Carousel            =
        ===================================*/
        
        
        if($layout =='carousel') {
            $u = uniqid();
            $out .= '
                <div class="f_portfolio '.$alignment.'">
                    ';    

                $carousel_desc = ( empty($carousel_desc) ) ? '' : '<p>' . $carousel_desc . '</p>' ;            
            
                $out .= '
                    <div class="intro_content">
                        <div class="inner">
                            <h3> '.$carousel_title.' </h3>
                            '.$carousel_desc.'
                            <div class="carousel-nav-wrapper">
                                <div class="prev-holder prev-'.$u.'">
                                    <i class="fa-angle-left"></i>
                                </div><!-- portfolio carousel left -->
                                <div class="next-holder next-'.$u.'">
                                    <i class="fa-angle-right"></i>
                                </div><!-- portfolio carousel right --> 
                            </div>     

                        </div><!-- .inner -->                 
                                      
                    </div><!-- .intro_content -->
                    ';                
            
            $out .= '
                    <div class="f_items">
                        <div class="portfolio_carousel">
                            <div class="anyClass" style="">
                                <ul>
                    ';

            while( $folio_query->have_posts() ) : $folio_query->the_post();


                // Get the video
                $video_link  =  get_post_meta( get_the_ID(), '_ht_video_link', true );

                // Getting the items featured images
                $thumb                 =   wp_get_attachment_image_src( get_post_thumbnail_id(), $thumbnail_size); 
                $large_image_url       =   wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');

                // Lightbox 
                $lightbox_status = '';
                if( trim($video_link) != '') {
                    $lightbox_status = 'href="'. get_permalink() .'"';
                    if($video_link =='') {
                        $video_status = '';
                    }                            
                } else {
                        $lightbox_status = 'rel="prettyPhoto[folio]" href="' . $large_image_url[0] .'"';
                }

                $out .= '<li id="post-'.get_the_ID().'" class="folio-item">';
                                                                                           
                $out .='
                        <img src="'. esc_attr($thumb[0]).'" alt="'.the_title_attribute('echo=0').'" >
                        <div class="f_hover">
                            <div class="f_links">
                                <a data-gal="lightbox[folio]" href="'.$large_image_url[0].'" class="tbutton small"><span><i class="arrow_expand"></i></span></a>
                                <a href="'. get_permalink() .'" class="tbutton small"><span>'.__("More Details", "highthemes").'</span></a>
                            </div>
                            <h5> <a href="'. get_permalink() .'">'.get_the_title().'</a> </h5>
                        </div>                        
                ';
                   
                $out .='</li> <!-- .folio-item -->';

                    endwhile;                    

            $out .='        </ul>
                        </div>

                    </div><!-- portfolio carousel -->
                </div>

                ';
               
            $out .='
            </div><!-- portfolio.carousel -->
                ';  


        } else {
      
        /*===================================
        =            If Grid or Masonry     =
        ===================================*/            

            $out .='
            <div class="portfolio-wrapper ">
            ';
                
            if($filter) {
                // filters
                 $out .= '

                <div class="clearfix mbf">
                    <div class="filterable">
                        <ul class="filter">
                            <li class="all current"><a href="#">' . __("All", "highthemes") . '</a></li>';
                        
                            if( count($term_array)>0 ) {
                                $n=1;
                                foreach( $term_array as $term_slug=>$term_name ) { 
                                 $out .= '<li class="' . $term_slug .'"><a href="#"  title="">' . $term_name . '</a></li>';
                                 $n++; 
                                }
                            }
                                    
                    $out .='</ul>
                        </div>
                    </div>';



            } 
                // outputing items

                $out .= '<ul class="portfolio clearfix">';

                $i=1;
                $terms_name = '';

                while( $folio_query->have_posts() ) : $folio_query->the_post();
                    
                    // Item terms
                    $terms = get_the_terms( get_the_ID(), 'portfolio-category' );
                    
                    // Builds space separated list of temrs for filtering items.
                    foreach( $terms as $term=>$value ) {
                        $terms_name .= " ".$value->slug . " ";
                    }

                    $filter_list =  $terms_name;
                    $terms_name  =  "";

                // Getting the items featured images
                    $video_link =   get_post_meta(get_the_ID(), '_ht_video_link', true);
                    $mp4        =   get_post_meta(get_the_ID(), '_ht_video_mp4', true);
                    $webm       =   get_post_meta(get_the_ID(), '_ht_video_webm', true);
                    $flv        =   get_post_meta(get_the_ID(), '_ht_video_flv', true);
                    $ogv        =   get_post_meta(get_the_ID(), '_ht_video_ogv', true);                        

                    // Getting the items featured images
                    $thumb                 =   wp_get_attachment_image_src( get_post_thumbnail_id(), $thumbnail_size); 
                    $large_image_url       =   wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');

                    $lightbox_attr = ' data-gal="lightbox[folio]" ';
                    if( !empty($video_link) || !empty($mp4) || !empty($webm) || !empty($flv)  || !empty($ogv) ) {
                        
                        // if external video
                        if( !empty($video_link) ){
                            $large_image_url[0] = $video_link;
                            $lightbox_attr = ' data-gal="lightbox[folio]" ';
                        } else {
                            $large_image_url[0] = get_permalink();
                            $lightbox_attr = '';
                        }                            
                        
                    }            
                    $lightbox_icon = '';
                    if( $lightbox_attr ){
                        $lightbox_icon = '<a class="tbutton small" href="'.$large_image_url[0].'" data-gal="lightbox[folio]"><span><i class="arrow_expand"></i></span></a>';
                    }             

                $out .='<li id="folio-'.get_the_ID().'" class="'.$span_col.'" data-id="id-'.$i.'" data-type="'.$filter_list.'">';

                    $out .= '<img src="'. esc_attr($thumb[0]) . '" alt="' . the_title_attribute('echo=0') . '" >
                    <div class="f_hover">
                        <div class="f_links">
                            '.$lightbox_icon.'
                            <a class="tbutton small" href="'.get_permalink().'"><span>'. __("More Details", "highthemes") .'</span></a>
                        </div>
                        <h5> <a href="'.get_permalink().'">'.get_the_title().'</a> </h5>
                    </div>
                </li><!-- portfolio item -->
                ';        

                $i++;
                    endwhile;
                $out .='</ul>';

                wp_reset_postdata();

                $out .='</div> <!-- .portfolio -->';

            }// end grid & masonry

                        else:
                            $out = 'no item found';
                        endif;                            
               

        return $out;
    }
}
add_shortcode( 'ht_portfolio', 'ht_portfolio' );


/**
 * Fancy Features
 */

if( ! function_exists( 'ht_features' ) ) {
    function ht_features( $atts, $content = null ) {
        extract(shortcode_atts(array(
            'el_class'   =>  '',
            'title'      =>'',
            'alignment' =>'left'
        ), $atts));

    $atts = array();
    $title = (empty($title)) ? '' : '<h3>' . $title . '</h3>';

    // getting the parameters
    $pattern = '/\[(\[?)(ht_feature)(?![\w-])([^\]\/]*(?:\/(?!\])[^\]\/]*)*?)(?:(\/)\]|\](?:([^\[]*+(?:\[(?!\/\2\])[^\[]*+)*+)\[\/\2\])?)(\]?)/';
    preg_match_all($pattern, $content, $matches, PREG_SET_ORDER);

    // getting the attributes
    foreach ($matches as $match) {
        $atts[] = shortcode_parse_atts($match[3]);
    }  

    $out  = '';
    $out .= '<div class="fancy-features '.$el_class.' clearfix">'; 

    if( $alignment == 'left' || $alignment == ''){
        $out .= '<div class="fancy-features-image grid_6">';
        $i = 0;
        foreach ($atts as $index => $feature) {
            $image_id = $feature['image'];
            $image_source = wp_get_attachment_image_src( $image_id, 'large');
            
            $out .='<div class="h_slider">
                    <img class="custom_'.$i.'" src="'.$image_source[0].'" alt="" />
                    </div>';
            $i++;

        }
        $out .= '</div>';
    }
    $out .= '<div class="fancy-features-list grid_6"><div class="inner_list">';
    $out .= $title;
    $out .='<ul>';
    $z = 0;
    foreach ($atts as $index => $feature) {
        $out .='<li>
                <a href="#custom_'.$z.'"><i class="'.$feature['icon_name'].'"></i>
                '.$feature['title'].'</a>
                </li>';
        $z++;

    }
    $out .= '</ul>
            </div>
            </div><!-- fancy-features-list -->';
    
    if( $alignment == 'right'){
        $out .= '<div class="fancy-features-image grid_6">';
        $i = 0;
        foreach ($atts as $index => $feature) {
            $image_id = $feature['image'];
            $image_source = wp_get_attachment_image_src( $image_id, 'large');
            
            $out .='<div class="h_slider">
                    <img class="custom_'.$i.'" src="'.$image_source[0].'" alt="" />
                    </div>';
            $i++;

        }
        $out .= '</div>';
    }                
    $out .= '</div>'; 

    return $out;
    
    }
}
add_shortcode( 'ht_features', 'ht_features' );


if( ! function_exists( 'ht_feature' ) ) {
    function ht_feature( $atts, $content = null ) {
        extract(shortcode_atts(array(
            'image'   => '',
            'title'    => '',
            'icon_name' =>'icon_box-checked' 
        ), $atts));
        $out = '';
    return $out;

    }
}
add_shortcode( 'ht_feature', 'ht_feature' );

/**
 * Recent Posts
 */
if( ! function_exists( 'ht_recent_posts' ) ) {
    function ht_recent_posts( $atts, $content = null ) {
        extract(shortcode_atts(array(
            'columns'        => '4',
            'title'          => '',
            'title_align'    => 'center',
            'post_ids'       => '',
            'exclude_ids'    => '',
            'categories'     => '',
            'orderby'        => 'date',
            'order'          => 'desc',
            'el_class'       =>  ''
        ), $atts));


        $out = '';
        $thumbnail_size = 'blog-recent-thumbnail';

        // includedd items
        if( !empty($post_ids) ) {
            $post_ids = explode(",", $post_ids);
        }

        // excludes items
        if( !empty($exclude_ids) ) {
            $exclude_ids = explode(",", $exclude_ids);
        } 

        // categories
        if( !empty($categories) ) {
            $categories = explode(",", $categories);
        } else {
            $categories = '';
        }

        // order
        $order = (strtolower($order)=='asc') ? 'asc' : 'desc' ;

        // order by
        $orderby = (empty($orderby)) ? 'date' : $orderby;

        $args = array(
        'posts_per_page'      => $columns,
        'ignore_sticky_posts' => 1,
        'post_type'           => 'post',
        'orderby'             => $orderby,
        'order'               =>$order
           
        );

        if( !empty($categories) ) {
            $args['category__in'] = $categories;
        }
        
        if( isset($post_ids) && is_array($post_ids) ){
            $args['post__in'] = $post_ids;
        }
        if( isset($exclude_ids) && is_array($exclude_ids) ){
            $args['post__not_in'] = $exclude_ids;
        }   

        switch ($title_align) {
            case 'center':
                $title_align = 'tac';
                break;
            case 'left':
                $title_align = 'tal';
                break;
            case 'right':
                $title_align = 'tar';
                break;                                
            
            default:
                $title_align = 'tac';
                break;
        }
        // set grid columns     
        switch ($columns) {
            case '2':
                $grid = 'grid_6';
                break;
            case '3':
                $grid = 'grid_4';
                break;
            case '4':
                $grid = 'grid_3';
                break;                            
            default:
                $grid = 'grid_3';
                break;
        }   

        $line = '';
        if($title_align =='tac') {
            $line = '<span class="after_line"></span>';
        }
        // start the query     
        $blog_query = new WP_Query($args);
        if ($blog_query->have_posts()) :
            $out .='
            <div class="recent-blog-posts">';

            // outputing items
            if( !empty($title) ) {
                $out .= '<div class="'.$title_align.'"><h3 class="block_title">'.$title.'</h3>'.$line.'</div>';
            }            
            $i=1;
            while( $blog_query->have_posts() ) : $blog_query->the_post();
                
                // Get the video
                $video_link  = '';                

                // Getting the items featured images
                $thumb             =   wp_get_attachment_image_src( get_post_thumbnail_id(), $thumbnail_size); 
                $large_image_url   =   wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');
                $slider_images     =   get_post_meta( get_the_ID(), '_ht_slider_images', true);
                $post_images       =   array();
                $post_large_images =   array();

                // external link
                $ex_link   = get_post_meta(get_the_ID(), '_ht_link_post_format', TRUE);
                $permalink = ( !empty($ex_link) ) ? $ex_link :  get_permalink();                

                if( is_array($slider_images) ) {
                    foreach ( $slider_images as $slider_image ) {
                        $post_images[] = wp_get_attachment_image_src( $slider_image , $thumbnail_size);
                        $post_large_images[] = wp_get_attachment_image_src( $slider_image , 'large');
                    }
                }

                $out .= '<div id="post-'.get_the_ID().'" class="'.$grid.' f_blog">';

                if( count($post_images) > 0 ) {

                     $out .='
                        <div class="f_thumb">
                            <div class="projectslider clearfix flexslider">
                                <ul class="slides">
                                    <li>
                                        <img  src="'.esc_attr($thumb[0]).'" alt="'.the_title_attribute('echo=0').'" >
                                    </li>';
                                    $img_i = 0;
                                    foreach( $post_images as $post_image ){
                                        $out .='
                                        <li>
                                            <img src="'.$post_image[0].'" />
                                        </li>';
                                        $img_i++;
                                    }   
                        $out .='</ul>
                            </div> 
                        </div> ';
                    
                    } elseif ( has_post_thumbnail( get_the_ID() ) || get_post_format( get_the_ID() ) =='video' ) {
                        
                        if( get_post_format( get_the_ID() ) =='video'  ) {
                            $video_link =   get_post_meta( get_the_ID(), '_ht_video_link', true);
                            $webm       =   get_post_meta( get_the_ID(), '_ht_video_webm', true);
                            $flv        =   get_post_meta( get_the_ID(), '_ht_video_flv', true);
                            $mp4        =    get_post_meta( get_the_ID(), '_ht_video_mp4', true);
                            $ogv        =   get_post_meta( get_the_ID(), '_ht_video_ogv', true);                    
                            $video_link =   embed_video($video_link, 500, 144, $mp4, $webm, $flv, $ogv, $large_image_url[0]); 

                            $out .='<div class="f_thumb">
                                    '.$video_link.'
                                    </div> <!-- .f_thumb --> ';
                        } else {
                            // no video
                            $out .='<div class="f_thumb">
                                        <img src="'. esc_attr($thumb[0]).'" alt="'.the_title_attribute('echo=0').'" >
                                        <div class="f_hover"><a href="'.get_permalink().'"><i class="icon_link_alt"></i></a></div>
                                </div> <!-- .f_thumb --> ';  
                            }  
                    }                                                                                     
                        
                $out .='<h4><a href="'.$permalink.'">'.get_the_title().'</a></h4>';
                $out .='
                <div class="f_meta">
                    <span><i class="icon_profile mi"></i> '. get_the_author_link() .'</span>
                    <span><i class="icon_clock_alt mi"></i> '.get_the_time(get_option('date_format')).'</span>
                </div>';
                $out .='</div> <!-- .f_blog -->';

                $i++;
                endwhile;
                wp_reset_postdata();

                $out .='</div> <!-- .recent-blog-posts -->';
            else:
                $out = __('No Items Found.', 'highthemes');
            endif;                            

        return $out;
    }
}
add_shortcode( 'ht_recent_posts', 'ht_recent_posts' );

?>