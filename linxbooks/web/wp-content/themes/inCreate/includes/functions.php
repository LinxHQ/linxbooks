<?php

/**
 * Custom javascript & css
 */
include( get_template_directory() . '/styles/custom-css.php' );
include( get_template_directory() . '/scripts/custom-js.php' );

/**
 * Needed scripts & styles
 */
function ht_scripts_styles() {
     global $ht_options, $wp_styles;

    /*
     * Adds JavaScript to pages with the comment form to support
     * sites with threaded comments (when in use).
     */
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );    
    }
    
    // Needed scripts
    wp_enqueue_script( 'modernizr' , HT_THEME_JS_URL . 'modernizr.js', array('jquery') );
    wp_enqueue_script( 'jquery.tools', HT_THEME_JS_URL .'jquery.tools.min.js', array('jquery') , '', true);
    wp_enqueue_script( 'flex-js', HT_THEME_JS_URL .'jquery.flexslider.js', array('jquery') , '', true);
    wp_enqueue_script( 'prettyPhoto', HT_THEME_JS_URL .'jquery.prettyPhoto.js', array('jquery') , '', true);
    wp_enqueue_script( 'jquery.fitvid', HT_THEME_JS_URL .'jquery.fitvids.js', array('jquery'), '', true );   
    wp_enqueue_script( 'jquery.masonry', HT_THEME_JS_URL .'jquery.masonry.min.js', array('jquery'), '', true ); 
    wp_enqueue_script( 'quicksand-js', HT_THEME_JS_URL .'jquery.quicksand.js', array('jquery') , '', true);
    wp_enqueue_script( 'scripts-js', HT_THEME_JS_URL .'scripts.js', array('jquery') , '', true);
    wp_enqueue_script( 'custom-js', HT_THEME_JS_URL .'custom.js', array('jquery') , '', true);


    // Needed css files
    wp_enqueue_style( 'ht-bootstrap', get_template_directory_uri() .'/styles/bootstrap.min.css' );
    wp_enqueue_style( 'ht-icons', get_template_directory_uri() .'/styles/icons.css' );
    wp_enqueue_style( 'ht-animate', get_template_directory_uri() .'/styles/animate.css' );

    // Main css
    wp_enqueue_style( 'ht-style', get_stylesheet_uri() );
    if( $ht_options['dark_skin'] ){
        wp_enqueue_style( 'ht-dark-skin', get_template_directory_uri() .'/styles/dark.css' );
    }    
    wp_enqueue_style( 'ht-responsive', get_template_directory_uri() .'/styles/responsive.css' );


}

add_action( 'wp_enqueue_scripts', 'ht_scripts_styles' );

/**
 * Display related posts for posts.
 */
if( ! function_exists('ht_related_post') ){
    function ht_related_post() {
        global $post, $wpdb;
        $backup = $post;  // backup the current object
        $tags = wp_get_post_tags($post->ID);
        $tagIDs = array();
        if ($tags) {
            $tagcount = count($tags);
            for ($i = 0; $i < $tagcount; $i++) {
                $tagIDs[$i] = $tags[$i]->term_id;
            }
            $args=array(
                'tag__in' => $tagIDs,
                'post__not_in' => array($post->ID),
                'showposts'=>2,
                'ignore_sticky_posts'=>1
            );
            $my_query = new WP_Query($args);
            if( $my_query->have_posts() ) { $related_post_found = true; ?>
            <div class="related_posts clearfix">

                <h3 class="col-title mb"><?php _e('Related Posts','highthemes'); ?></h3>
                
                    <?php
                    $i=1;
                    while ($my_query->have_posts()) : $my_query->the_post();

                        $post_id = get_the_ID();
                        $post_thumbnail = get_the_post_thumbnail($post_id, 'post-thumbnail');

                        if(!$post_thumbnail){
                            $post_thumbnail = '<img alt="image" src="'.get_template_directory_uri() .'/images/empty_thumb.gif" />';
                        }
                        ?>
                        <div class="grid_6">
                            <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
                                <?php echo $post_thumbnail;?>
                                <span> <?php the_title(); ?></span>
                            </a>
                            
                        </div>
                        <?php
                        $i++;
                    endwhile;
                    ?>
            </div>

                <?php
            }
        }

        wp_reset_query();

        ?>

        <?php

    }

}
/**
 * Comments template. this function used to make a custom template for comments
 */
if( ! function_exists('custom_comment') ){
    function custom_comment($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
        ?>
<li <?php comment_class('clearfix'); ?> id="div-comment-<?php comment_ID() ?>">
    <div class="comment-entry clearfix" id="comment-<?php comment_ID(); ?>">
        <div class="thumb">
            <?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?>
            <div class="reply"><?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?></div>
        </div>
        <h5 class="entry-title">
        <?php ($comment->comment_author_url == 'http://Website' || $comment->comment_author_url == '') ? comment_author() : comment_author_link(); ?><span class="date"><?php comment_date('d. M, Y'); ?></span>
        </h5>
        <?php
            if($comment->comment_approved == '0'){
                echo '<strong><em>'.__('Your comment is awaiting moderation.', 'highthemes').'</em></strong>';
            }
        ?>
        <?php comment_text() ?>
    </div>
</li>
        <?php
    }

}

/**
 * Comment form template
 */
if( ! function_exists('ht_comment_form') ){
    function ht_comment_form($form_options) {
        global $user_identity, $post_id;
        if(!isset($commenter['comment_author'])){$commenter['comment_author'] = 'Name';}
        if(!isset($commenter['comment_author_email'])){$commenter['comment_author_email'] = 'Email';}
        if(!isset($commenter['comment_author_url'])){$commenter['comment_author_url'] = 'Website';}
        $commenter = wp_get_current_commenter();
        $req = get_option( 'require_name_email' );
        $aria_req = ( $req ? " aria-required='true'" : '' );

        // Fields Array
        $fields = array(

            'author' =>
            '<div class="personal-data"><p>' .
                ( $req ? '<span class="required">*</span>' : '' ) .
                '<label for="fullname">'.__('Full name','highthemes').'</label><input id="fullname" class="txt" name="author" type="text"  size="30"' . $aria_req . '  />' .
                '</p>',

            'email' =>
            '<p>' .
                ( $req ? '<span class="required">*</span>' : '' ) .
                '<label for="email">'.__('Email','highthemes').'</label><input  id="email" name="email" class="txt" type="text"  size="30"' . $aria_req . ' />' .
                '</p>',

            'url' =>
            '<p>'  .
                '<label for="url">'.__('Website URL','highthemes').'</label><input name="url" class="txt" size="30" id="url" type="text"  />' .
                '</p>
        </div>',

        );

        // Form Options Array
        $form_options = array(
            // Include Fields Array
            'fields' => apply_filters( 'comment_form_default_fields', $fields ),

            // Template Options
            'comment_field' =>

            '<div class="form-data"><p>' .
                '<label for="form_message">'. __('Comment','highthemes').'</label><textarea  name="comment" id="form_message" aria-required="true" rows="8" cols="45" ></textarea>' .
                '</p></div>',

            'must_log_in' =>
            '<p class="must-log-in">' .
                sprintf( __( 'You must be', 'highthemes') .' <a href="%s">'.__('logged in','highthemes') . '</a> '.__('to post a comment.', 'highthemes' ),
                    wp_login_url( apply_filters( 'the_permalink', get_permalink($post_id) ) ) ) .
                '</p>',

            'logged_in_as' =>
            '<p class="logged-in-as">' .
                sprintf( __( 'Logged in as', 'highthemes') .' <a href="%1$s">%2$s</a>. <a href="%3$s" title="' . __('Log out of this account', 'highthemes') .'">'.__('Log out?', 'highthemes') . '</a>',
                    admin_url('profile.php'), $user_identity, wp_logout_url( apply_filters('the_permalink', get_permalink($post_id)) ) ) .
                '</p>',

            'comment_notes_before' =>
            '',

            'comment_notes_after' => '',

            // Rest of Options
            'id_form' => 'form-comment',
            'id_submit' => 'submit',
            'title_reply' => __( 'Leave a Reply', 'highthemes' ),
            'title_reply_to' => __( 'Leave a Reply to', 'highthemes' ) .' %s',
            'cancel_reply_link' => __( '<span>Cancel reply</span>', 'highthemes' ),
            'label_submit' => __( 'Post Comment' , 'highthemes'),
        );

        return $form_options;
    }
}
add_filter('comment_form_defaults', 'ht_comment_form');

/**
 * Author bio box
 */
if( ! function_exists('ht_author_bio') ){
    function ht_author_bio() { ?>
    <div id="author-info">
        <div class="border-style">
            <div class="inner"><span class="fl"><?php echo get_avatar( get_the_author_meta('email'), '60' ); ?></span>
                <p>
                    <strong class="author-name">
                        <?php the_author_link(); ?>
                    </strong>
                    <?php if(get_the_author_meta('description') == '') {
                    echo __('The author didn\'t add any Information to his profile yet. ', 'highthemes');
                } else {
                    the_author_meta('description');
                } ?>
                </p>
                <div class="fix"></div>
            </div>
        </div>
    </div>
        <?php
    }

}

/**
 * Get post format icons based on font awesome
 */
function ht_post_format_icon($post_format) {
    // using font awesome
    switch($post_format) {
        case 'video':
            return 'play-circle';
            break;

        case 'link':
            return 'link';
            break;

        case 'audio':
            return 'volume-up';
            break;

        case 'gallery':
            return 'picture';
            break;

        case 'quote':
            return 'quote-left';
            break;

        default:
            return 'file-text';

    }
}

/**
 * Page header
 */
function ht_get_header_type($page_id) {
    global $post;
    
    if ( is_post_type_archive( 'product' ) ) {
            $post   = get_post( woocommerce_get_page_id( 'shop' ) );
            $header_type = get_post_meta( $post->ID, '_ht_header_type', true);

    } else if ( !empty($post) && !is_home() && !is_search() && !is_archive() && !is_404() ) {
        $header_type = get_post_meta( $page_id, '_ht_header_type', true);
        if(empty($header_type)) $header_type = 'title';
    } else {
        $header_type = 'title';
    }

    return $header_type;

}


/**
 * Social icons list
 */
if( !function_exists('ht_social_icons_list') ) {
    function ht_social_icons_list() {
        global $ht_options;

        $target = ($ht_options['social_menu_target'] == 1) ? '_blank' : '_self' ;

        $output  = '';
        if($ht_options['twitter_id']) {
            $output .= '<a class="bottomtip" target="'.$target.'" title="Twitter" href="' . $ht_options['twitter_id'] . '"><i class="fa-twitter"></i></a>';
        } 

        if($ht_options['facebook_id']) { 
            $output .= '<a class="bottomtip" target="'.$target.'" title="Facebook" href="' . $ht_options['facebook_id'] . '"><i class="fa-facebook"></i></a></li>';
        } 

        if($ht_options['gplus_id']) { 
            $output .= '<a class="bottomtip" target="'.$target.'" title="Google Plus" href="' . $ht_options['gplus_id'] . '"><i class="fa-google-plus"></i></a>';
        } 

        if($ht_options['flickr_id']) { 
            $output .= '<a class="bottomtip" target="'.$target.'" title="Flickr" href="' . $ht_options['flickr_id'] . '"><i class="fa-flickr"></i></a>';
        } 

        if($ht_options['rss_id']) { 
            $output .= '<a class="bottomtip" target="'.$target.'" title="RSS" href="' . $ht_options['rss_id'] . '"><i class="fa-rss"></i></a>';
        } 

        if($ht_options['linkedin_id']) { 
            $output .= '<a class="bottomtip" target="'.$target.'" title="LinkedIn" href="' . $ht_options['linkedin_id'] . '"><i class="fa-linkedin"></i></a>';
        } 

        if($ht_options['dribbble_id']) { 
            $output .= '<a class="bottomtip" target="'.$target.'" title="Dribbble" href="' . $ht_options['dribbble_id'] . '"><i class="fa-dribbble"></i></a>';
        } 

        if($ht_options['github_id']) { 
            $output .= '<a class="bottomtip" target="'.$target.'" title="Github" href="' . $ht_options['github_id'] . '"><i class="fa-github"></i></a>';
        } 

        if($ht_options['tumblr_id']) { 
            $output .= '<a class="bottomtip" target="'.$target.'" title="Tumblr" href="' . $ht_options['tumblr_id'] . '"><i class="fa-tumblr"></i></a>';
        } 

        if($ht_options['dropbox_id']) { 
            $output .= '<a class="bottomtip" target="'.$target.'" title="Dropbox" href="' . $ht_options['dropbox_id'] . '"><i class="fa-dropbox"></i></a>';
        } 

        if($ht_options['skype_id']) { 
            $output .= '<a class="bottomtip" target="'.$target.'" title="Skype" href="' . $ht_options['skype_id'] . '"><i class="fa-skype"></i></a>';
        } 

        if($ht_options['youtube_id']) { 
            $output .= '<a class="bottomtip" target="'.$target.'" title="Youtube" href="' . $ht_options['youtube_id'] . '"><i class="fa-youtube"></i></a>';
        } 

        if($ht_options['instagram_id']) { 
            $output .= '<a class="bottomtip" target="'.$target.'" title="Instagram" href="' . $ht_options['instagram_id'] . '"><i class="fa-instagram"></i></a>';
        } 

        if($ht_options['pinterest_id']) { 
            $output .= '<a class="bottomtip" target="'.$target.'" title="Pinterest" href="' . $ht_options['pinterest_id'] . '"><i class="fa-pinterest"></i></a>';
        } 

        if($ht_options['xing_id']) { 
            $output .= '<a class="bottomtip" target="'.$target.'" title="Xing" href="' . $ht_options['xing_id'] . '"><i class="fa-xing"></i></a>';
        }         

        if($ht_options['email_id']) { 
            $output .= '<a class="bottomtip" target="'.$target.'" title="Email" href="mailto:' . $ht_options['email_id'] . '"><i class="fa-envelope"></i></a>';
        } 

        return $output;
       
    }  
}

/**
 * WooCommerce Banners
 */
if( ! function_exists('ht_woocommerce_ads') ){
    function ht_woocommerce_ads() {
        global $ht_options;

        $out = '';
        $i = 0;
        if( $ht_options['woo_ad_banner1'] ){
            $i++;
            $out .= '
            <div class="woo-ad">
                <a href="'.$ht_options['woo_ad_url1'].'">
                    <img src="'.$ht_options['woo_ad_banner1'].'" alt="" />
                </a>
            </div>';
        }
        if( $ht_options['woo_ad_banner2'] ){
            $i++;
            $out .= '
            <div class="woo-ad">
                <a href="'.$ht_options['woo_ad_url2'].'">
                    <img src="'.$ht_options['woo_ad_banner2'].'" alt="" />
                </a>
            </div>';
        }
        if( $ht_options['woo_ad_banner3'] ){
            $i++;
            $out .= '
            <div class="woo-ad">
                <a href="'.$ht_options['woo_ad_url3'].'">
                    <img src="'.$ht_options['woo_ad_banner3'].'" alt="" />
                </a>
            </div>';
        } 

        if($i === 1) {
            $out  = '<div class="woo-ads clearfix col-1">'.$out.'</div>';
        } elseif ($i ==2){
            $out  = '<div class="woo-ads clearfix col-2">'.$out.'</div>';

        } elseif($i == 3) {
            $out  = '<div class="woo-ads clearfix col-3">'.$out.'</div>';

        }
        return $out;
    }
}


/**
 *  Tweak wp_title to make it more useful
 */
if( ! function_exists('ht_filter_wp_title') ){
    function ht_filter_wp_title( $title, $separator ) {
        if ( is_feed() )
            return $title;

        global $paged, $page;

        if ( is_search() ) {
            $title = sprintf( __( 'Search results for','highthemes').' %s', '"' . get_search_query() . '"' );
            if ( $paged >= 2 )
                $title .= " $separator " . sprintf( __( 'Page','highthemes' ) . ' %s', $paged );
            $title .= " $separator " . get_bloginfo( 'name', 'highthemes' );
            return $title;
        }

        $title .= get_bloginfo( 'name', 'highthemes' );

        $site_description = get_bloginfo( 'description', 'highthemes' );
        if ( $site_description && ( is_home() || is_front_page() ) )
            $title .= " $separator " . $site_description;

        if ( $paged >= 2 || $page >= 2 )
            $title .= " $separator " . sprintf( __( 'Page','highthemes' ) . ' %s', max( $paged, $page ) );

        return $title;
    }

}
add_filter( 'wp_title', 'ht_filter_wp_title', 10, 2 );



/**
 * Register widget areas, Default sidebar & footer blocks
 */
function the_widgets_init() {
    if ( !function_exists('register_sidebars') )
        return;

    register_sidebars(1,array('name' => __('Default Sidebar','highthemes'), 'description'=>__('Used in blog, pages, etc. If you don\'n assign a custom sidebar to a page, this will be used. ', 'highthemes'), 'id'=>'default-sidebar', 'before_widget' =>
    '<div id="%1$s" class="%2$s widget">','after_widget' => '</div>','before_title' => '<h3 class="col-title">','after_title' => '</h3>'));

    register_sidebars(1,array('name' => __('Default Shop Sidebar','highthemes'), 'description'=>__('This sidebar will be used for shop main pages if WooCommerce is activated.', 'highthemes'),'id'=>'shop-sidebar', 'before_widget' =>
    '<div id="%1$s" class="%2$s widget">','after_widget' => '</div>','before_title' => '<h3 class="col-title">','after_title' => '</h3>'));
    
    register_sidebars(1,array('name' => __('Archive Page Sidebar','highthemes'), 'description'=>__('If you put widgets inside this sidebar, it will be used instead of default sidebar for posts archive page.', 'highthemes'), 'id'=>'archive-sidebar', 'before_widget' =>
    '<div id="%1$s" class="%2$s widget">','after_widget' => '</div>','before_title' => '<h3 class="col-title">','after_title' => '</h3>'));

    register_sidebars(1,array('name' => __('Portfolio Archive Sidebar','highthemes'), 'description'=>__('Portfolio archive page uses this sidebar. ', 'highthemes'), 'id'=>'archive-folio-sidebar', 'before_widget' =>
    '<div id="%1$s" class="%2$s widget">','after_widget' => '</div>','before_title' => '<h3 class="col-title">','after_title' => '</h3>'));
    
    register_sidebar(array( 'name'=>'Footer 1', 'id'=> 'footer-1', 'description'=>__('The first footer widgetized area ', 'highthemes'),'before_widget' =>
    '<div id="footer%1$s" class="%2$s widget">','after_widget'  => '</div>','before_title'  => '<h3 class="col-title">','after_title' => '</h3>' ));

    register_sidebar(array( 'name'=>'Footer 2', 'id'=> 'footer-2','description'=>__('The second footer widgetized area ', 'highthemes'),'before_widget' =>
    '<div id="footer%1$s" class="%2$s widget">','after_widget'  => '</div>','before_title'  => '<h3 class="col-title">','after_title' => '</h3>' ));

    register_sidebar(array( 'name'=>'Footer 3', 'id'=> 'footer-3','before_widget' =>
    '<div id="footer%1$s" class="%2$s widget">','after_widget'  => '</div>','description'=>__('The third footer widgetized area ', 'highthemes'),'before_title'  => '<h3 class="col-title">','after_title' => '</h3>' ));

    register_sidebar(array( 'name'=>'Footer 4', 'id'=> 'footer-4','description'=>__('The fourth footer widgetized area ', 'highthemes'),'before_widget' =>
    '<div id="footer%1$s" class="%2$s widget">','after_widget'  => '</div>','before_title'  => '<h3 class="col-title">','after_title' => '</h3>' ));
}
add_action( 'init', 'the_widgets_init' );



/**
 * Defining images sizes
 */
set_post_thumbnail_size( 500, 200, true);
add_image_size('blog-post-thumbnail', 750, 340, true);
add_image_size('portfolio-thumbnail', 500, 500, true);
add_image_size('gallery-thumbnail', 700, 700, true);
add_image_size('full-width', 1060, 9999); 
add_image_size('blog-recent-thumbnail', 245, 145, true); 

add_image_size('small-thumb', 60, 60, true);  

/**
 *  Register post formats
 */
add_theme_support('post-formats', array('link', 'quote', 'video','audio'));

/**
 * Enable posts thumbnail
 */
add_theme_support('post-thumbnails', array('post', 'slideshow', 'portfolio'));

/**
 *  Enable automatic feed links
 */
add_theme_support('automatic-feed-links');

/**
 * Register navigation menus
 */
register_nav_menu( 'nav', __('Primary Navigation of '.THEMENAME,'highthemes') );
register_nav_menu( 'footer-nav', __('Footer Navigation of '.THEMENAME,'highthemes') );


/**
 *  Add excerpt to pages
 */
add_post_type_support( 'page', 'excerpt' );

/**
 * Content width
 */
if ( ! isset( $content_width ) )
    $content_width = 1060;