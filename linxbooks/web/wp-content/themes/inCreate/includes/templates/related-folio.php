<!-- Related Items -->
<?php
global $ht_options;
$the_term = wp_get_post_terms( $post->ID, 'portfolio-category' );
$term_id = $the_term[0]->term_id;
$thumbnail_size = 'portfolio-thumbnail';

$args = array(
    'showposts'                 => 10,
    'post_type'                 => 'portfolio',
    'post__not_in'              => array($post->ID),
    'order_by'                  => 'rand',
    'ignore_sticky_posts'       =>1,
    'tax_query' => array(
                        array('taxonomy' => 'portfolio-category',
                              'field' => 'id',
                              'terms' => $term_id
                             )
                        )
            );

$temp = $wp_query;
$wp_query = new WP_Query($args);
if ($wp_query->have_posts()) :
?>
<div class="clearfix">
    <div class="f_portfolio">
        <div class="intro_content">
            <div class="inner">
                <h3><?php if( empty( $ht_options['related_folio_title'] ) ) { _e("Related Items", "highthemes"); } else { echo $ht_options['related_folio_title']; }?></h3>
                <p><?php if( !empty( $ht_options['related_folio_desc'] ) ) { echo $ht_options['related_folio_desc']; } ?></p>
                <div class="carousel-nav-wrapper">
                    <div class="prev-holder prev-9585458">
                        <i class="fa-angle-left"></i>
                    </div><!-- portfolio carousel left -->
                    <div class="next-holder next-9585458">
                        <i class="fa-angle-right"></i>
                    </div><!-- portfolio carousel right --> 
                </div>     
            </div><!-- .inner -->                 
        </div><!-- .intro_content -->
        <div class="f_items">
            <div class="portfolio_carousel">
                <div class="anyClass">
                    <ul>
                    <?php
                    $i=1;
                    while ($wp_query->have_posts()) : $wp_query->the_post();
                        $video_link      =   get_post_meta($post->ID, '_video_link', true);
                        $thumb           =   wp_get_attachment_image_src( get_post_thumbnail_id(), $thumbnail_size); 
                        $large_image_url =   wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');
                        $post_images     =   array();                                             
                    ?>
                        <li>
                            <img src="<?php echo esc_attr($thumb[0]);?>" alt="<?php the_title_attribute();?>" >
                            <div class="f_hover">
                                <div class="f_links">
                                    <a class="tbutton small" href="<?php echo $large_image_url[0];?>" data-gal="lightbox[folio]"><span><i class="arrow_expand"></i></span></a>
                                    <a class="tbutton small" href="<?php the_permalink();?>"><span><?php _e("More Details", "highthemes");?></span></a>
                                </div>
                                <h5> <a href="<?php the_permalink();?>"><?php the_title();?></a> </h5>
                            </div>
                        </li><!-- portfolio item -->
                   <?php  endwhile;?>

                    </ul>
                </div>
            </div><!-- portfolio carousel -->

        </div>
    </div><!-- end f portfolio -->
</div><!-- row -->
<?php 
endif;
$wp_query = null; $wp_query = $temp;
?>