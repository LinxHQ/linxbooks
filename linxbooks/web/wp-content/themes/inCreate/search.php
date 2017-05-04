<?php
get_header();

// variables
global $ht_options;

$ht_sidebar_status   =  ht_sidebar_layout(1);
$post_excerpt_length =  ($ht_options['post_excerpt_length']) ? $ht_options['post_excerpt_length'] : 300;
$blog_layout = 'large-thumbnails';
$span = ( $ht_sidebar_status == 'no-sidebar' ) ? 'grid_12'. $blog_layout : 'grid_9 ' . $blog_layout;
$masonry_class ='';

?>
<section id="page-section-<?php the_ID(); ?>" class="row clearfix mbs">
            <div class="post-area posts <?php echo $span;?>">
             <?php
                if (have_posts()) :
                    while ( have_posts() ) : the_post();

                    if(get_post_type() =='post') {
                        if(get_post_format() !='') {
                            include(locate_template('includes/templates/content-'.get_post_format().'.php'));
                        } else {
                            include(locate_template('includes/templates/content.php'));
                        }                        
                    } else if (get_post_type() =='page' || get_post_type() =='portfolio' ) {
                            include(locate_template('includes/templates/content.php'));
                    }else { 
                        continue;
                    }
                endwhile;
             ?>
            <?php  else:  ?>
                <?php get_template_part( 'includes/templates/no-results' ); ?>
            <?php endif; ?>
             <div class="navi">
                    <?php 
                    if($ht_options['pagenavi_status']) {
                         wp_pagenavi();   
                    } else {
                    ?>
                    <div class="prev fl"><?php previous_posts_link('<i class="fa-angle-left"></i> '.__('Previous','highthemes'),''); ?></div>
                    <div class="next fr"><?php next_posts_link(__('Next','highthemes').' <i class="fa-angle-right"></i>',''); ?></div>    
                    <?php } ?>
                </div> <!-- .navi -->
            </div> <!-- .post-area -->
            <?php if( $ht_sidebar_status != 'no-sidebar') get_sidebar(); ?>

</section>       
<?php get_footer();?>