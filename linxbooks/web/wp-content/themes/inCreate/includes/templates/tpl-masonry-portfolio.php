<?php
global $ht_options;

// Portfolio features
$ht_portfolio_category =    get_post_meta( get_the_ID(), '_ht_portfolio_category', true );

// The number of items to show
$ht_item_number        =    get_post_meta( get_the_ID(), '_ht_item_number', true );

// Thumbnail size
$thumbnail_size        =    'large';

// Sets a default item number
if( !is_numeric( $ht_item_number ) || !isset( $ht_item_number ) ) {
    $ht_item_number = -1;
}

// Sets sidebar alignment
$ht_sidebar_status = ht_sidebar_layout();
$span = 'grid_12';

?>
<div class="row clearfix mb">
    <div id="masonry-container" class="four-column transitions-enabled centered clearfix">

        <div class="<?php echo $span;?>">
                <?php
                // if not password protected page
                if( !post_password_required() ) {
                    $ht_portfolio_category = ( is_array($ht_portfolio_category) ) ? $ht_portfolio_category : '';

                    // getting the number of posts per page
                    $posts_per_page = (int) $ht_item_number;
                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                    $args = array(
                        'paged'                 => $paged,
                        'posts_per_page'        => $posts_per_page,
                        'post_type'             => 'portfolio',
                        'order_by'              => 'date',
                        'tax_query' => array(
                            array(
                                'taxonomy'  => 'portfolio-category',
                                'field'     => 'slug',
                                'terms'     => $ht_portfolio_category
                            )
                        )
                    );

                    $temp = $wp_query;
                    $wp_query = new WP_Query($args);
                    if ($wp_query->have_posts()) :
                        if( is_array($ht_portfolio_category) ) {
                            foreach( $ht_portfolio_category as $index=>$value ) {
                                $term_details = get_term_by( 'slug', $value, 'portfolio-category');
                                if(!isset($term_details->name)) continue;
                                $term_array[$value] = $term_details->name;
                                }
                        }

                ?>
                <ul class="portfolio clearfix">
                    <?php
                        $i=1;
                        $terms_name = '';

                        while( $wp_query->have_posts() ) : $wp_query->the_post();
                            
                               
                            // Item terms
                            $terms = get_the_terms( get_the_ID(), 'portfolio-category' );
                            
                            // Builds space separated list of temrs for filtering items.
                            foreach( $terms as $term=>$value ) {
                                $terms_name .= " ".$value->slug . " ";
                            }

                            $filter_list =  $terms_name;
                            $terms_name  =  "";

                            $video_link =   get_post_meta($post->ID, '_ht_video_link', true);
                            $mp4        =   get_post_meta($post->ID, '_ht_video_mp4', true);
                            $webm       =   get_post_meta($post->ID, '_ht_video_webm', true);
                            $flv        =   get_post_meta($post->ID, '_ht_video_flv', true);
                            $ogv        =   get_post_meta($post->ID, '_ht_video_ogv', true);                        

                            // Getting the items featured images
                            $thumb                 =   wp_get_attachment_image_src( get_post_thumbnail_id(), $thumbnail_size); 
                            $large_image_url       =   wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');

                            $lightbox_attr = ' data-gal="lightbox[folio]" ';


                            if( !empty($video_link) || !empty($mp4) || !empty($webm) || !empty($flv)  || !empty($ogv) ) {
                                
                                // if external video
                                if( !empty($video_link) ){
                                    $large_image_url[0] = $video_link;
                                    $lightbox_attr = ' data-gal="lightbox[folio]" ';
                                } else {
                                    $large_image_url[0] = get_permalink();
                                    $lightbox_attr = '';
                                }                            
                                
                            }       

                            // Lightbox 
                            $uid = uniqid();

                        ?>            

                    <li id="folio-<?php the_ID();?>" class="post masonry-brick" data-id="id-<?php echo $i;?>" data-type="<?php echo $filter_list;?>">
                        <img src="<?php echo esc_attr($thumb[0]);?>" alt="<?php the_title_attribute();?>" >
                        <div class="f_hover">
                            <div class="f_links">
                            <?php if( $lightbox_attr ){?>
                            <a class="tbutton small" href="<?php echo $large_image_url[0];?>" <?php echo $lightbox_attr;?>><span><i class="arrow_expand"></i></span></a>
                            <?php }?>
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
                    <?php } ?>
                    </div>
                    <?php
                    $wp_query = null; $wp_query = $temp;
                    wp_reset_query();
                } //password protected check?>
                   </div><!-- grid_12 -->
                </div><!-- masonry -->

</div> <!-- .section -->  
<?php get_footer(); ?>