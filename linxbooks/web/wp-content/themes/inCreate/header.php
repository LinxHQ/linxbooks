<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?> class="no-js">
<!--<![endif]-->
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <?php global $ht_options; ?>
    <title><?php wp_title( '|', true, 'right' ); ?></title>

    <!-- favicon -->
    <?php if($ht_options['custom_favicon']) { echo ht_favicon($ht_options['custom_favicon']);} ?>
    
    <?php if($ht_options['apple_ipad_logo']): ?>
    <!-- For iPad -->
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $ht_options['apple_ipad_logo']; ?>">
    <?php endif; ?>

    <?php if($ht_options['apple_logo']): ?>
    <!-- For iPhone -->
    <link rel="apple-touch-icon-precomposed" href="<?php echo $ht_options['apple_logo']; ?>">
    <?php endif; ?>    

    <!-- responsive -->
    <?php if( $ht_options['responsive_layout'] =='responsive' ) {?>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=0" />
    <meta name="viewport" content="width=device-width" />
    <?php } ?>


    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=EmulateIE8; IE=EDGE" />
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- RSS feed -->
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php if ( $ht_options['rss_id'] <> "" ) { echo $ht_options['rss_id']; } else { echo get_bloginfo_rss('rss2_url'); } ?>" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
     <?php echo $ht_options['before_head']; ?>
    <?php wp_head(); ?>   
    
</head>
<?php
$dark_layout = '';
if( $ht_options['dark_skin'] ){
   $dark_layout = 'dark-layout';
} 
?>
<body <?php body_class($dark_layout); ?>>
    <div id="frame_">
        <div id="layout" class="<?php echo $ht_options['layout_type']; ?> ">
            <header id="header">
            <?php if(!$ht_options['disable_top_header']) {?>
                <div class="head_up">
                    <div class="row clearfix">
                        <div class="l_ht">
                        <?php echo $ht_options['top_header_info'];?>
                        </div><!-- end text left -->
                        
                        <div class="r_ht">
                        <?php 
                        if( is_woocommerce_activated() ): 
                            global $woocommerce;
                            $total_amount     = $woocommerce->cart->get_cart_total(); 
                            $cart_item_counts = $woocommerce->cart->cart_contents_count;
                            $cart_url         = $woocommerce->cart->get_cart_url();
                            $checkout_url     = $woocommerce->cart->get_checkout_url();
                        ?>                        
                            <div class="shopping_bag">
                                <div class="header_bag">
                                    <a href="<?php echo $cart_url;?>"><i class="icon_bag_alt"></i><span> <?php echo $cart_item_counts;?> <?php _e("item(s)", "highthemes");?> / <?php echo $total_amount;?></span></a>
                                </div><!-- .header_bag -->
                                <div class="view_cart_mini">
                                    <div class="view_cart">
                                    <?php if ( sizeof( $woocommerce->cart->get_cart() ) > 0 ) {?>
                                        <ul class="cart_list">
                                        <?php
                                            foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $values ) {
                                                $_product = $values['data'];
                                                if ( $_product->exists() && $values['quantity'] > 0 ) {
                                                    ?>
                                            <li class="clearfix">
                                                <?php
                                                $thumbnail = apply_filters( 'woocommerce_in_cart_product_thumbnail', $_product->get_image(), $values, $cart_item_key );
                                                printf('<a href="%s">%s</a>', esc_url( get_permalink( apply_filters('woocommerce_in_cart_product_id', $values['product_id'] ) ) ), $thumbnail );
                                                ?>                                                
                                                <div class="cart_list_product_title">
                                                    <?php
                                                    if ( ! $_product->is_visible() || ( ! empty( $_product->variation_id ) && ! $_product->parent_is_visible() ) )
                                                        echo apply_filters( 'woocommerce_in_cart_product_title', $_product->get_title(), $values, $cart_item_key );
                                                    else
                                                        printf('<a href="%s">%s</a>', esc_url( get_permalink( apply_filters('woocommerce_in_cart_product_id', $values['product_id'] ) ) ), apply_filters('woocommerce_in_cart_product_title', $_product->get_title(), $values, $cart_item_key ) );

                                                    // Meta data
                                                    echo $woocommerce->cart->get_item_data( $values );

                                                    // Backorder notification
                                                    if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $values['quantity'] ) )
                                                        echo '<p class="backorder_notification">' . __( 'Available on backorder', 'woocommerce' ) . '</p>';
                                                    
                                                    if ( $_product->is_sold_individually() ) {
                                                        $product_quantity = sprintf( '1', $cart_item_key );
                                                    } else {
                                                        $product_quantity = esc_attr( $values['quantity'] );
                                                    }
                                                    ?>                                       
                                                    <div class="cart_list_product_quantity"><?php _e("Quantity", "highthemes");?>: <?php echo $product_quantity;?> / <?php
                                                    echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf('<a href="%s" class="remove toptip" title="%s">[x]</a>', esc_url( $woocommerce->cart->get_remove_url( $cart_item_key ) ), __( 'Remove this item', 'woocommerce' ) ), $cart_item_key );
                                                    ?>
                                                    </div><!-- .cart_list_prodcut_quantity -->
                                                </div>
                                            </li>
                                            <?php
                                                    }
                                                }
                                            ?>
                                        </ul><!-- .cart_list-->
                                        <span class="total_checkout fll"><?php _e("Cart subtotal", "highthemes");?></span>
                                        <span class="amount_total flr">
                                        <?php
                                        echo $total_amount;
                                        
                                        ?>
                                        </span>
                                        <div class="tac" style="clear:both">
                                            <a href="<?php echo $cart_url;?>" class="tbutton mt small"><span><?php _e("View Cart", "highthemes");?></span></a>   
                                            <a href="<?php echo $checkout_url;?>" class="tbutton mt small"><span><i class="icon_cart_alt mi"></i><?php _e("Checkout", "highthemes");?></span></a>
                                        </div>
                                        <?php } else { // end check if cart    ?>
                                        <p>
                                            <?php _e("Your cart is empty!", "highthemes");?>
                                        </p>
                                        <?php }?>
                                    </div>
                                </div>
                            </div>
                        <?php endif // if woocommerc is activated;?>
                        <?php 
                        if( function_exists('icl_get_languages') ){
                            $langs = icl_get_languages('skip_missing=1');
                            if($langs) {
                                $current_lang = '';
                                foreach ($langs as $key => $lang) {
                                    if($lang['active']){
                                        $current_lang = $lang;
                                        unset($langs[$key]);
                                    }
                                }
                        ?>
                            <div class="languages">
                            <?php if ( $current_lang ) {
                               echo '<a title="'.$lang['native_name'].'" href="'. $current_lang['url'] .'"><span>'. strtoupper($current_lang['language_code']) .'</span></a>';
                            }?>
                                
                                <div class="other_languages">
                                <?php
                                    foreach ($langs as $key => $lang) {
                                        echo '<a title="'.$lang['native_name'].'" href="'. $lang['url'] .'"><span>'. strtoupper($lang['language_code']) .'</span></a>';
                                    }
                                ?>
                                </div><!-- end other -->
                            </div><!-- end languages -->
                        <?php } }// end wpml ?>
                            <div class="social social_head">
                               <?php echo ht_social_icons_list();?>
                            </div><!-- end social -->

                        </div><!-- end social and bag -->
                    </div><!-- row -->
                </div><!-- head -->
            <?php }?>
            <?php 
            $sticky_header = '';
            if( $ht_options['sticky_header'] ) {
                $sticky_header = 'my_sticky';
            }
            ?>
                <div class="headdown <?php echo $sticky_header;?>">
                    <div class="row clearfix">
                        <div class="logo">
                            <a title="<?php bloginfo("description");?>" href="<?php echo home_url();?>">
                                <?php if ($ht_options['logo_url']) { ?>
                                <img src="<?php echo $ht_options['logo_url'];?>" alt="<?php bloginfo('description'); ?>"/>
                                <?php } else { ?>
                                <img  src="<?php echo get_template_directory_uri();?>/images/logo.png" alt="Logo"/>
                                <?php }?>
                            </a>
                        </div>
                        <?php if(!$ht_options['disable_top_search']) {?>
                        <div class="search">
                            <div class="search_icon"><i class="icon_search icon_close"></i></div>
                            <div class="s_form">
                                <form action="<?php echo home_url(); ?>/" id="search" method="get">
                                    <input id="inputhead" name="s" type="text" onfocus="if (this.value=='<?php _e("Start Searching...", "highthemes");?>') this.value = '';" onblur="if (this.value=='') this.value = '<?php _e("Start Searching...", "highthemes");?>';" value="<?php _e("Start Searching...", "highthemes");?>" placeholder="<?php _e("Start Searching...", "highthemes");?>">
                                    <button type="submit"><i class="icon_search"></i></button>
                                </form><!-- end form -->
                            </div>
                        </div>
                        <?php }?>
                <?php wp_nav_menu( array('menu_class' => 'sf-menu', 'menu_id' => 'menu',  'menu' => 'default',  'container' => 'nav','theme_location' => 'nav', 'container_id' => 'nav' ) );  ?>
                <!-- end nav -->
                    </div><!-- row -->
                </div><!-- headdown -->
            </header><!-- end header -->


        <?php 
        $ht_header_type = '';
        if($post){
            $ht_header_type = ht_get_header_type(get_the_ID());       
        }
        ?> 
        <?php if ( is_page_template('tpl-under-construction.php') ) {?>
        <?php } elseif( $ht_header_type =='rev-slider' ) { ?>
        <div class="sliderr" id="main-slideshow">
        <?php
        if(function_exists('putRevSlider')) {
           putRevSlider(get_post_meta(get_the_ID(), '_ht_rev_slider', true));
        }
        ?>
        </div>  
        <?php 
        $overlay_caption_title = get_post_meta( get_the_ID(), '_ht_overlay_caption_title', true );
        $overlay_button1_title = get_post_meta( get_the_ID(), '_ht_overlay_button1_title', true );
        $overlay_button1_link  = get_post_meta( get_the_ID(), '_ht_overlay_button1_link', true );
        $overlay_button1_icon  = get_post_meta( get_the_ID(), '_ht_overlay_button1_icon', true );
        $overlay_button2_title = get_post_meta( get_the_ID(), '_ht_overlay_button2_title', true );
        $overlay_button2_link  = get_post_meta( get_the_ID(), '_ht_overlay_button2_link', true );
        $overlay_button2_icon  = get_post_meta( get_the_ID(), '_ht_overlay_button2_icon', true );

        if( !empty($overlay_button1_title) || !empty($overlay_button2_title) || !empty($overlay_caption_title) )  {?>
        <div class="intro_p tac">
            <div class="row inner clearfix">
            <?php if( !empty($overlay_caption_title) ) {?>
                <h2><?php echo $overlay_caption_title;?></h2>
            <?php }?>
            <?php if( !empty($overlay_button1_title) ) {?>
                <a href="<?php echo $overlay_button1_link;?>" class="tbutton large">
                <?php if( !empty($overlay_button1_icon) ) {?><i class="<?php echo $overlay_button1_icon;?>"></i><?php }?>
                <span><?php echo $overlay_button1_title;?></span></a>
            <?php } ?>
            <?php if( !empty($overlay_button2_title) ) {?>
                <a href="<?php echo $overlay_button2_link;?>" class="tbutton large m_left">
                <?php if( !empty($overlay_button2_icon) ) {?><i class="<?php echo $overlay_button2_icon;?>"></i><?php }?>
                <span><?php echo $overlay_button2_title;?></span></a>
            <?php } ?>            
            </div><!-- End row -->
        </div><!-- End intro p -->     
        <?php }?>        
        <?php } else if ( $ht_header_type =='title' ) {
            $header_bg_repeat = $header_bg_position = $header_bg_cover = '';

            if(is_page() || is_single() ) {
                $header_centered    = get_post_meta( get_the_ID(), '_ht_header_centered', true );
            }
            $header_background  = get_post_meta( get_the_ID(), '_ht_header_background', true );

            if( empty($header_background) || $header_background =='default'  ) {
                $header_bg    =  'background-image:url('.get_template_directory_uri().'/images/assets/breadcrumb1.jpg); background-repeat: no-repeat;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size:cover; background-size: cover;' ;

            } elseif ( $header_background == 'custom' ) {

                $header_bg          = get_post_meta( get_the_ID(), '_ht_header_bg', true );
                $header_bg_repeat   = get_post_meta( get_the_ID(), '_ht_header_bg_repeat', true );
                $header_bg_position = get_post_meta( get_the_ID(), '_ht_header_bg_position', true );
                $header_bg_cover    = get_post_meta( get_the_ID(), '_ht_header_bg_cover', true );
                $header_bg          = ( !empty($header_bg) ) ?  wp_get_attachment_image_src( $header_bg, 'full')  : '';
                $header_bg          = ( !empty($header_bg) ) ?  'background-image:url(' . $header_bg[0] . ');' : '';
                $header_bg_repeat   = ( !empty($header_bg) ) ?  'background-repeat:' . $header_bg_repeat . ';' : '';
                $header_bg_position = ( !empty($header_bg) ) ?  'background-position:' . $header_bg_position . ';' : '';
                $header_bg_cover    = ( !empty($header_bg) && !empty($header_bg_cover) ) ?  'background-repeat:no-repeat;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size:cover; background-size: cover;' : '';                

            } else {
                $header_bg    =  'background-image:url('.get_template_directory_uri().'/images/assets/'.$header_background.'); background-repeat: no-repeat;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size:cover; background-size: cover;' ;

            }
            
            $header_centered    = ( !empty($header_centered) ) ?  ' centered' : '';
        

            $styles = 
                      $header_bg.
                      $header_bg_repeat.
                      $header_bg_position.
                      $header_bg_cover;

        ?>

            <div class="breadcrumb-place" style="<?php echo $styles;?>">
                <div class="row clearfix">
                    <h3 class="page-title">
                    <?php
                    if( is_woocommerce_activated() ) {
                        if( is_shop() ) {
                                 woocommerce_page_title(); 
                        }

                    }
                    if ( is_page() || is_single() ) the_title();
                    else if ( is_category() ) _e("Category : ",'highthemes'). single_cat_title('', true);
                    else if ( is_tag() ) _e("Tag : ",'highthemes').single_tag_title('', true);
                    else if ( is_year() ) echo get_the_date( _x( 'Y', 'yearly archives date format', 'highthemes' ) );
                    else if ( is_month() )  echo get_the_date( _x( 'F Y', 'monthly archives date format', 'highthemes' ) );
                    else if ( is_day() )  echo get_the_date();
                    else if ( is_author() ) echo get_the_author();
                    else if ( is_search() ) printf( __('Search results for','highthemes') . " %s", '"' . get_search_query() . '"' );
                    else if ( is_tax() ) {
                        global $wp_query;
                        $term = $wp_query->get_queried_object();
                        echo $term->name;
                    } 
                    ?>
                    </h3>
                    <?php
                    if( !is_woocommerce_activated() ) {
                       if($ht_options['breadcrumb_inner']){ ?>
                                <?php if (class_exists('simple_breadcrumb')) { $bc = new simple_breadcrumb; } ?>
                    <?php }
                    } else {
                        if(( is_woocommerce() || is_cart()  ||  is_checkout() || is_account_page() ) and ($ht_options['breadcrumb_inner'])) {
                                woocommerce_breadcrumb();
                        } else if ($ht_options['breadcrumb_inner']) {
                            ?>
                            <div id="breadcrumb" class="<?php echo $header_centered;?>">
                                <?php if (class_exists('simple_breadcrumb')) { $bc = new simple_breadcrumb; } ?>
                            </div>
                        <?php }
                    }
                    ?>
                </div><!-- row -->
            </div><!-- end breadcrumb place -->
        <?php } else if ( $ht_header_type =='no-title' ) {  } ?>   
            <?php if(is_404()){?>
          
            <div class="error_page">
                <div class="row clearfix">
                    <div class="CLE">
                        <i class="icon_dislike errori"></i>
                        <h2 class="tac mtt"> <?php _e("PAGE NOT FOUND", "highthemes");?> <small> <?php _e("The page you are looking for might have been removed.","highthemes");?> </small></h2>
                        <a href="<?php echo home_url();?>" class="tbutton medium"><span><i class="icons-arrow-left mi"></i> <?php _e("Back To Homepage", "highthemes");?></span></a>
                    </div>
                </div><!-- row -->
            </div><!-- end 404 place -->
            <?php }?>

            <?php 
            if( is_single() && get_post_type() == 'portfolio' ) { 
                $portfolio_single_layout = get_post_meta( get_the_ID(), '_ht_portfolio_single_layout', true);
                if($portfolio_single_layout == 'image_left' || $portfolio_single_layout == 'image_right'){
            ?> 
                <div  class="hidden-x page-content no-sidebar">
                <?php } else { ?>
                <div  class="hidden-x page-content <?php echo ht_sidebar_layout();?>">
                <?php }?>
                
            <?php } else {?>
            <div  class="hidden-x page-content <?php echo ht_sidebar_layout();?> ">
            <?php }?>