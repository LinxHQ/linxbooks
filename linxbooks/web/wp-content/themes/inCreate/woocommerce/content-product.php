<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop;
$attachment_ids = $product->get_gallery_attachment_ids();

$second_image = '';
if ( $attachment_ids[0] ) {
    $second_image  = wp_get_attachment_image( $attachment_ids[0],  'shop_catalog', '', array('class' => 'product_img_hover') );
}

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
    $woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
    $woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 3 );

// Ensure visibility
if ( ! $product->is_visible() )
    return;

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] )
    $classes[] = 'first';
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
    $classes[] = 'last';



if( $woocommerce_loop['columns'] == '4' ){
    $classes[] = 'grid_3';
} else {
    $classes[] = 'grid_4';

}

?>
<li <?php post_class( $classes ); ?>>
    <?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
        <div class="thumbnail-container">
            <a href="<?php the_permalink(); ?>">
            <?php
            do_action( 'woocommerce_before_shop_loop_item_title' );
            echo $second_image;
            ?>
            </a>
        </div>
    <div class="woo-item-details clearfix">
        <a href="<?php the_permalink(); ?>"><h3><?php the_title(); ?></h3></a>
        <?php
        /**
         * woocommerce_after_shop_loop_item_title hook
         *
         * @hooked woocommerce_template_loop_price - 10
         */
        do_action( 'woocommerce_after_shop_loop_item_title' );
        ?>
    </div>
    <div class="product_meta clearfix">
        <?php
        /**
         * woocommerce_before_shop_loop_item_title hook
         *
         * @hooked woocommerce_show_product_loop_sale_flash - 10
         * @hooked woocommerce_template_loop_product_thumbnail - 10
         */
        do_action( 'woocommerce_after_shop_loop_item' );
        ?>
        <a class="f_btn" href="<?php echo get_permalink( $product->id );?>"><span><i class="icon_menu"></i> <?php _e("Details", "highthemes");?></span></a>
    </div>    
</li>