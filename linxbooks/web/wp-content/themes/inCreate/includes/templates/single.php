<?php
global $ht_options;
$ht_sidebar_status = ht_sidebar_layout();  
$span              = ( $ht_sidebar_status == 'no-sidebar' ) ? 'grid_12' : 'grid_9' ;
?>
<div id="section-<?php the_ID(); ?>" <?php post_class('row clearfix mbs'); ?>>
    <div class="post-area <?php echo $span;?>">
<?php
if ( have_posts() ) : 

    while ( have_posts() ) : the_post();

        if( get_post_format() == 'video' ) {
            get_template_part('includes/templates/content', 'video');

        } elseif( get_post_format() == 'link' ) {
            get_template_part('includes/templates/content', 'link');

        } elseif( get_post_format() == 'quote' ) {
            get_template_part('includes/templates/content', 'quote');
        } elseif( get_post_format() == 'audio' ) {
            get_template_part('includes/templates/content', 'audio');

        } else {
            $thumbnail_size = 'blog-post-thumbnail';
            if ( $ht_sidebar_status == 'no-sidebar' ) {
                $thumbnail_size = 'full-width';
            }


            $featured_image_status =   get_post_meta($post->ID, '_ht_disable_post_image', true);

            $thumb                 =   wp_get_attachment_image_src( get_post_thumbnail_id(), $thumbnail_size); 
            $large_image_url       =   wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');
            $slider_images         =   get_post_meta( get_the_ID(), '_ht_slider_images', true);

            $post_images           =   array();
            $zoom                  = 'zoom';
            $post_excerpt_length   = ($ht_options['post_excerpt_length']) ? $ht_options['post_excerpt_length'] : 300;


            if( $featured_image_status =='' && $ht_options['disable_post_image'] =='1' ) {
                $featured_image_status = 'false';
            }

            $lightbox_status = '';
            if( $ht_options['blog_lightbox'] ) {
                $lightbox_status = 'href="'. get_permalink() .'"';
                $zoom = '';
            } else {
                $lightbox_status = 'rel="prettyPhoto" href="' . $large_image_url[0] .'"';
            }

            if( is_array($slider_images) ) {
                foreach ( $slider_images as $slider_image ) {
                    $post_images[] = wp_get_attachment_image_src( $slider_image , $thumbnail_size);
                    $post_large_images[] = wp_get_attachment_image_src( $slider_image , 'large');
                }
            }
?>

<div <?php post_class(); ?>>
    <?php 
    // include post meta
    get_template_part('includes/templates/content-meta');

    // include post thumbnail
    if( $featured_image_status != 'false') {
        include(locate_template('includes/templates/post-thumbnail.php'));
    }
    ?>
    <div class="post_content clearfix">
        <?php  the_content(__('Continue Reading<i class="fa-double-angle-right"></i>','highthemes')) ;  ?>
        <?php wp_link_pages( );?>
    </div>

</div>
<?php
}// end post format check
?>
<div class="post_share tac">
    <div><?php _e("Share with your friends:", "highthemes"); ?> </div>
    <div class="tws"><a href="https://twitter.com/share" class="twitter-share-button" data-count="horizontal"><?php _e("Tweet", "highthemes");?></a></div>
    <div id="fb-root"></div>
    <div class="fb-like" data-href="<?php the_permalink();?>" data-width="80" data-layout="button_count" data-show-faces="false" data-send="false"></div>
    <div class="gp"><g:plusone size="medium"></g:plusone></div>
</div>
<div class="post-links clearfix">
    <span class="fll"><?php next_post_link(' %link', '<i class="fa-angle-left"></i> %title'); ?> </span>
    <span class="flr"><?php previous_post_link('%link', '%title  <i class="fa-angle-right"></i>'); ?> </span>
</div>
<?php 
ht_related_post();
wp_enqueue_script( 'twitter-facebook', HT_THEME_JS_URL .'twitter-facebook.js', array('jquery'), '', true ); 

endwhile;
    else:  
        get_template_part( 'includes/templates/no-results' );
    endif;
// If comments are open or we have at least one comment, load up the comment template
if ( comments_open() || '0' != get_comments_number() ){
?>
<div id="post-comments">
<?php comments_template( '', true ); ?>
</div>
<?php } ?>               
</div><!-- .post-area -->
<?php if( $ht_sidebar_status != 'no-sidebar') get_sidebar(); ?>
</div>
<!-- Sections -->
<?php get_footer();?>