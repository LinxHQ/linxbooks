<?php
global $ht_options;

$thumbnail_size = 'blog-post-thumbnail';
$video_w = 774;
if ( $ht_sidebar_status == 'no-sidebar' ) {
    $thumbnail_size = 'full-width';
    $video_w = 1060;
}
$thumb      =   wp_get_attachment_image_src( get_post_thumbnail_id(), $thumbnail_size); 
$video_link =   get_post_meta($post->ID, '_ht_video_link', true);
$mp4       	=   get_post_meta($post->ID, '_ht_video_mp4', true);
$webm       =   get_post_meta($post->ID, '_ht_video_webm', true);
$flv        =   get_post_meta($post->ID, '_ht_video_flv', true);
$ogv        =   get_post_meta($post->ID, '_ht_video_ogv', true);

if( $featured_image_status =='' && $ht_options['disable_post_image'] =='1' ) {
    $featured_image_status = 'false';
}
?>
<div <?php post_class($masonry_class); ?>>
    <?php get_template_part('includes/templates/content-meta');?>
    <div class="thumb_f"><?php echo embed_video($video_link, $video_w, '', $mp4, $webm, $flv, $ogv, $thumb[0]); ?></div>
    <div class="post_content clearfix">
       <?php the_content(__('Continue Reading<i class="fa-double-angle-right"></i>','highthemes')) ;?>
       <?php wp_link_pages( );?>
    </div>
</div><!-- post video -->