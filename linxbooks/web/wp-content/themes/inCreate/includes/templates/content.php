<?php
global $ht_options;
$thumbnail_size = 'blog-post-thumbnail';
if ( $ht_sidebar_status == 'no-sidebar' ) {
     $thumbnail_size     = 'full-width';
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
        $post_images[]       = wp_get_attachment_image_src( $slider_image , $thumbnail_size);
        $post_large_images[] = wp_get_attachment_image_src( $slider_image , 'large');
    }
}
if(get_post_type() =='page' || get_post_type() =='portfolio') {
?>
<div <?php post_class('post'); ?>>
    <?php 
    $post_format_icon = 'icon_document_alt ';
    if( get_post_type() =='page' ) {
        $post_format_icon = 'icon_document_alt';
    } else {
        $post_format_icon = 'icon_star_alt ';
    }
    ?>
    <div class="meta_box">
        <div class="post_format"><i class="<?php echo $post_format_icon;?>"></i></div>
        <h3> <a title="<?php the_title_attribute();?>" href="<?php the_permalink();?>"><?php the_title();?></a></h3>
        <div class="post_meta">
            <span><i class="icon_clock_alt"></i> <?php the_time(get_option('date_format'));?></span>
        </div><!-- meta more -->
    </div><!-- meta box -->
    <div class="post_content clearfix">
        <p>
            <?php echo ht_excerpt($post_excerpt_length, '...'); ?>
        </p>
    </div>
</div><!-- .post -->

<?php } else {?>

<div <?php post_class($masonry_class); ?>>
    <?php 
    // include post meta
    get_template_part('includes/templates/content-meta');

    // include post thumbnail
    if( !is_search() ) {
        include(locate_template('includes/templates/post-thumbnail.php'));        
    }
    
    ?>
    <div class="post_content clearfix">
        <?php if($ht_options['disable_excerpt'] != '1') { ?>
        <p>
            <?php echo ht_excerpt($post_excerpt_length, '...'); ?>
        </p>
        <?php } else { the_content(__('Continue Reading<i class="fa-double-angle-right"></i>','highthemes')) ; } ?>
    </div>
</div>
<?php }?>