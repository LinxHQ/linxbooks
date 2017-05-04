<?php
get_header();

// variables
global $ht_options;

$thumbnail_size = 'portfolio-thumbnail';
$ht_sidebar_status = ht_sidebar_layout();

$folio_archive_layout = '3col';
$folio_archive_layout = $ht_options['folio_archive_layout'];

switch ($folio_archive_layout) {
    case '2col':
        $folio_col = 'grid_6';
        break;
    case '3col':
        $folio_col = 'grid_4';
        break;   
    case '4col':
        $folio_col = 'grid_3';
        break;         
    default:
        $folio_col = 'grid_4';
        break;
}

$span = ( $ht_sidebar_status == 'no-sidebar' ) ? '' : 'grid_9' ;
?>

<div class="row clearfix mb">
    <div class="<?php echo $span;?>">
    <?php if(have_posts()):?>
        <ul class="portfolio clearfix">
        <?php
            $i=1;
            $terms_name = '';

            while( have_posts() ) : the_post();
                
                // Item terms
                $terms = get_the_terms( get_the_ID(), 'portfolio-category' );
                
                $video_link            =   get_post_meta($post->ID, '_ht_video_link', true);
                $video_webm            =   get_post_meta($post->ID, '_ht_video_webm', true);
                $video_ogg             =   get_post_meta($post->ID, '_ht_video_ogg', true);
                $video_flv             =   get_post_meta($post->ID, '_ht_video_flv', true);

                // Getting the items featured images
                $thumb                 =   wp_get_attachment_image_src( get_post_thumbnail_id(), $thumbnail_size); 
                $large_image_url       =   wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');

               
            ?>  
            <li id="folio-<?php the_ID();?>" class="<?php echo $folio_col;?>" data-id="id-<?php echo $i;?>">
                <img src="<?php echo esc_attr($thumb[0]);?>" alt="<?php the_title_attribute();?>" >
                <div class="f_hover">
                    <div class="f_links">
                        <a class="tbutton small" href="<?php echo $large_image_url[0];?>" data-gal="lightbox[folio]"><span><i class="arrow_expand"></i></span></a>
                        <a class="tbutton small" href="<?php the_permalink();?>"><span><?php _e("More Details", "highthemes");?></span></a>
                    </div>
                    <h5> <a href="<?php the_permalink();?>"><?php the_title();?></a> </h5>
                </div>
            </li><!-- portfolio item -->
            <?php
            $i++;
            endwhile;
            ?>
        </ul>

        <?php
            else:
                get_template_part( 'includes/templates/no-results' );
            endif;
        ?>

        <div class="navi">
        <?php 
        if($ht_options['pagenavi_status']) {
             wp_pagenavi();   
        } else {
        ?>
            <div class="prev fl"><?php previous_posts_link('<i class="fa-angle-left"></i> '.__('Previous','highthemes'),''); ?></div>
            <div class="next fr"><?php next_posts_link(__('Next','highthemes').' <i class="fa-angle-right"></i>',''); ?></div>    
        <?php
        } 
        wp_reset_query();
        ?>
        </div>
</div><!-- grid_9 -->
            <!-- sidebar -->
            <?php if( ht_sidebar_layout() != 'no-sidebar') get_sidebar(); ?>

</div> <!-- .section -->  
<?php get_footer(); ?>