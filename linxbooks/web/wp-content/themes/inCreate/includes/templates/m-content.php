<?php
global $ht_options;
$thumbnail_size = 'portfolio-thumbnail';
if ( $ht_sidebar_status == 'no-sidebar' ) {
    $thumbnail_size = 'full-width';
}
$post_images           =   array();
$zoom                  =   'zoom';
$featured_image_status =   get_post_meta($post->ID, '_ht_disable_post_image', true);
$thumb                 =   wp_get_attachment_image_src( get_post_thumbnail_id(), $thumbnail_size); 
$large_image_url       =   wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');
$slider_images         =   get_post_meta( get_the_ID(), '_ht_slider_images', true);
$post_excerpt_length   =   ($ht_options['post_excerpt_length']) ? $ht_options['post_excerpt_length'] : 300;


if( $featured_image_status =='' && $ht_options['disable_post_image'] =='1' ) {
    $featured_image_status = 'false';
}

$lightbox_status = '';
if( $ht_options['blog_lightbox'] ) {
    $lightbox_status = 'href="'. get_permalink() .'"';
    $zoom = '';
} else {
    $lightbox_status = 'data-gal="lightbox" href="' . $large_image_url[0] .'"';
}

if( is_array($slider_images) ) {
    foreach ( $slider_images as $slider_image ) {
        $post_images[] = wp_get_attachment_image_src( $slider_image , $thumbnail_size);
        $post_large_images[] = wp_get_attachment_image_src( $slider_image , 'large');
    }
}
if(get_post_type() =='page' || get_post_type() =='portfolio') {
?>
<article <?php post_class('page-search'); ?>>
    <div class="post-content">
        <div class="content-inner">
          <h2 class="post-title">
                <a title="<?php the_title_attribute();?>" href="<?php the_permalink();?>"><?php the_title();?></a>
            </h2>
            <span class="search-post-type"><?php echo strtoupper(get_post_type());?></span>
            <p><?php echo ht_excerpt(200, '...');?></p>
        </div> <!-- .content-inner --> 
    </div><!-- .post-content -->
</article><!-- .post -->

<?php } else {?>

<div <?php post_class('clearfix post'); ?>>
    <?php 
    // include post thumbnail
    include(locate_template('includes/templates/post-thumbnail.php'));
    if ($featured_image_status)
        $extra_content_class = 'no-img';
    else
        $extra_content_class = '';
    ?>
    <div class="content_half <?php echo $extra_content_class; ?>">
        <?php get_template_part('includes/templates/content-meta');?>
        <div class="post_content clearfix">
            <?php if($ht_options['disable_excerpt'] != '1') { ?>
                <p>
                    <?php echo ht_excerpt($post_excerpt_length, '...'); ?>
                </p>
            <?php } else { the_content(__('Continue Reading<i class="fa-double-angle-right"></i>','highthemes')) ; } ?>
        </div>        
    </div>
</div><!-- post image -->
<?php }?>