<?php
global $ht_options;
$sound_link        =   get_post_meta($post->ID, '_ht_sound_link', true);
$embed_code = '';

?>
<div <?php post_class('clearfix'); ?>>
    <?php 
    if( !empty($sound_link) ) {
        $embed_code = wp_oembed_get( $sound_link );
    ?>
    <div class="thumb_f"><?php echo  $embed_code;?></div>
    <?php } ?>
    <div class="content_half">
        <?php get_template_part('includes/templates/content-meta');?>
        <div class="post_content clearfix">
           <?php the_content(__('Continue Reading<i class="fa-double-angle-right"></i>','highthemes')) ;?>
        </div>
    </div>
        
</div><!-- post sound -->