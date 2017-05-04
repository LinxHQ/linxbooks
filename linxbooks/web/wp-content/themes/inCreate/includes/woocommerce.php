<?php

//
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_loop_rating', 11 );


// This theme supports woocommerce
add_theme_support( 'woocommerce' );


if ( version_compare( WOOCOMMERCE_VERSION, "2.1" ) >= 0 ) {
add_filter( 'woocommerce_enqueue_styles', '__return_false' );
} else {
define( 'WOOCOMMERCE_USE_CSS', false );
}

// Redefine woocommerce_output_related_products()
function woocommerce_output_related_products() {
    global $ht_options;
    $ht_sidebar_status = ht_sidebar_layout();  
    if( $ht_sidebar_status == 'no-sidebar'){
        woocommerce_related_products(array(
                                        'posts_per_page' => 4,
                                        'columns'        => 4,
                                        'orderby'        => 'rand')
                                    ); // Display 4 products in rows of 4

    } else {
        woocommerce_related_products(array(
                                        'posts_per_page' => 3,
                                        'columns'        => 3,
                                        'orderby'        => 'rand')); // Display 3 products in rows of 3

    }
}

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
function ht_redefine_upsell_display(){
    woocommerce_upsell_display('-1', 3);
}
add_action( 'woocommerce_after_single_product_summary', 'ht_redefine_upsell_display', 15 );


/**
 * Hook in on activation
 */
global $pagenow;
if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php' ) add_action( 'init', 'ht_woocommerce_image_dimensions', 1 );

/**
 * Define image sizes
 */
function ht_woocommerce_image_dimensions() {
    $catalog = array(
        'width'  => '208', // px
        'height' => '208',	// px
        'crop'   => 0 // true
    );

    $single = array(
        'width'  => '685', // px
        'height' => '400', // px
        'crop'   => 0 // true
    );

    $thumbnail = array(
        'width'  => '122', // px
        'height' => '122', // px
        'crop'   => true // false
    );

// Image sizes
    update_option( 'shop_catalog_image_size', $catalog ); // Product category thumbs
    update_option( 'shop_single_image_size', $single ); // Single product image
    update_option( 'shop_thumbnail_image_size', $thumbnail ); // Image gallery thumbs
}


/*
 * Redefining WooCommerce CSS styles
 */
function ht_woo_style() {
    wp_register_style( 'ht-woocommerce', get_template_directory_uri() . '/woocommerce/style/woocommerce.css', null, 1.0, 'screen' );
    wp_enqueue_style( 'ht-woocommerce' );
}
add_action( 'wp_enqueue_scripts', 'ht_woo_style' );

// Some customizations on woo pages.
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

// Adding our own wrapper start & end
add_action('woocommerce_before_main_content', 'my_theme_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'my_theme_wrapper_end', 10);

function my_theme_wrapper_start() {
    global $woocommerce, $ht_optoins;
    $sidebar_status =  ht_sidebar_layout();
    if($sidebar_status == 'no-sidebar'){
        // Change number or products per row 
        add_filter('loop_shop_columns', 'loop_columns');
        if (!function_exists('loop_columns')) {
            function loop_columns() {
                return 4;
            }
        }       
        echo '<div class="row clearfix mbs">';
        if( is_shop() ) echo ht_woocommerce_ads();
        echo '<div class="no-sidebar">';
    } else {
        echo '<div class="row clearfix mbs ">';
        if( is_shop() ) echo ht_woocommerce_ads(); 
        echo '<div class="grid_9">';
    }

}
function my_theme_wrapper_end() {
   echo '</div>';
}

// sidebar
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
add_action('woocommerce_sidebar', 'ht_woocommerce_sidebar', 10);

function ht_woocommerce_sidebar(){
    $sidebar_status =  ht_sidebar_layout();
    if($sidebar_status != 'no-sidebar'){
        wc_get_template( 'global/sidebar.php' );
    }
    echo '</div>';
}

remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);


add_filter('woocommerce_breadcrumb_defaults', 'ht_woo_breadcrumb');
function ht_woo_breadcrumb($defaults){
    $defaults['delimiter'] = '';
    $defaults['before'] = '<li>';
    $defaults['after'] = '  </li>';
    $defaults['wrap_before'] = '
    <div class="breadcrumbIn">
    <ul>
       ';
    $defaults['wrap_after'] = '</ul></div>';
    return $defaults;
}



//
add_filter('add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');

function woocommerce_header_add_to_cart_fragment( $fragments ) {
    global $woocommerce;
    ob_start();
    ?>
    <a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'woothemes'); ?>"><?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?> - <?php echo $woocommerce->cart->get_cart_total(); ?></a>
    <?php
    $fragments['a.cart-contents'] = ob_get_clean();
    return $fragments;
}



?>