<?php
global $ht_options;
?>
<div class="row clearfix mbt">
<?php 
if (have_posts()) : the_post(); 
    $ht_sidebar_status = ht_sidebar_layout();  

    $thumbnail_size          =   'full-width';              
    $extra_info              =   get_post_meta($post->ID, '_ht_extra_info', true);
    $terms                   =   get_the_terms( $post->ID, 'portfolio-category' );
    $thumb                   =   wp_get_attachment_image_src( get_post_thumbnail_id(), $thumbnail_size); 
    $large_image_url         =   wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');
    $slider_images           =   get_post_meta( get_the_ID(), '_ht_slider_images', true);
    $post_images             =   array();
    $lightbox_status         =   'rel="prettyPhoto" href="' . $large_image_url[0] .'"';
    $disable_project_details =   get_post_meta( get_the_ID(), '_ht_disable_project_details', true);

    // get video
    $video_link =   get_post_meta($post->ID, '_ht_video_link', true);
    $mp4        =   get_post_meta($post->ID, '_ht_video_mp4', true);
    $webm       =   get_post_meta($post->ID, '_ht_video_webm', true);
    $flv        =   get_post_meta($post->ID, '_ht_video_flv', true);
    $ogv        =   get_post_meta($post->ID, '_ht_video_ogv', true);
    $video_w    =   774;

    if( is_array($slider_images) ) {

        foreach ( $slider_images as $slider_image ) {
            $post_images[] = wp_get_attachment_image_src( $slider_image , $thumbnail_size);
            $post_large_images[] = wp_get_attachment_image_src( $slider_image , 'large');
        }
    }                            

?>
<div class="grid_9 <?php if($ht_sidebar_status == 'left-sidebar') echo 'omega'; else echo 'alpha';?>">
        <?php 
        if( !empty($video_link) || !empty($mp4) || !empty($webm) || !empty($flv)  || !empty($ogv) ) {
            echo embed_video($video_link, $video_w, '', $mp4, $webm, $flv, $ogv, $large_image_url[0]); 
        }
        elseif( has_post_thumbnail() ) {
            if( count($post_images) > 0 ) {
        ?> 
        <div class="clearfix mbt project_preview">
            <div class="projectslider clearfix flexslider">
                <ul class="slides">
                    <li><img src="<?php echo esc_attr($thumb[0]);?>" alt="<?php the_title_attribute();?>" /></li>
                    <?php
                        $img_i = 0;
                        foreach( $post_images as $post_image ) {
                            echo '
                            <li>
                                <img alt="" src="'.$post_image[0].'" />
                            </li>';
                            $img_i++;
                        }
                    ?>                   
                </ul>
            </div>
        </div>
        <?php 
        } else {
        ?>
        <div class="clearfix mbt project_preview">
            <img src="<?php echo esc_attr($thumb[0]);?>" alt="<?php the_title_attribute();?>" >
        </div>
        <?php 
            }
        }
        ?> 
        <?php $grid_class = ( empty($disable_project_details) ) ? 'grid_6' : 'grid_12';?>
        <div style="margin-bottom: 5px;" class="<?php echo $grid_class;?> project_description alpha">
        <?php 
        the_content() ;
        wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'highthemes' ), 'after' => '</div>' ) );
        ?>
        </div><!-- project description -->
        <?php if($grid_class =='grid_6') {?>
        <div class="project-details grid_6 <?php if($ht_sidebar_status == 'left-sidebar') echo 'alpha'; else echo 'omega';?>">
            <h3 class="col-title mb"> <?php _e("Project Details", "highthemes");?> </h3>
            <?php

            $info_block_lines = array();
            if(!empty($extra_info)) {
                $extra_info = explode(PHP_EOL,$extra_info);
                foreach ($extra_info as $line) {
                    $new_line = array();
                    $color_index = 2;
                    $data = explode("|", $line);
                    $new_line['title'] = isset($data[0]) ? $data[0] : false;
                    $new_line['value'] = isset($data[1]) ? $data[1] : false;

                    $info_block_lines[] = $new_line;
                }
            }

            ?> 


            <div class="info_block clearfix">
                <div class="grid_6 alpha">
                    <span> <?php _e("Categories:", "highthemes");?> </span>
                </div><!-- alpha -->
                <div class="grid_6 omega">
                <?php
                if( $terms) {
                    foreach( $terms as $term=>$value ) {
                        $term_link =  get_term_link($value->slug, 'portfolio-category');
                        $term_name =  $value->name;
                        echo '<span><a href="'.$term_link.'" >'.$term_name.'</a></span>';
                    }            
                }

                ?>
                    </div><!-- omega -->
            </div><!-- info block -->
            <?php 
            if( count($info_block_lines)>0 ) {
                   
                    foreach ( $info_block_lines as $info_line ) {
                        $info_block = '<div class="info_block clearfix">';
                        $info_block .= '<div class="grid_6 alpha">
                                            <span> '. $info_line['title'] .' </span>
                                        </div><!-- alpha -->';
                        $info_block .= '<div class="grid_6 omega">
                                            <span> '.$info_line['value'].' </span>
                                        </div><!-- omega -->';
                        $info_block .='</div><!-- info block -->';
                       echo $info_block;
                   }
                    
                }
             ?>
                

            </div><!-- grid6 -->
            <?php }?>
<div class="project_links clearfix">
                <span class="fll"><?php previous_post_link('%link', __('<i class="fa-angle-left"></i>', 'highthemes')); ?></span>
                <span class="flr"><?php next_post_link('%link', __('<i class="fa-angle-right"></i>', 'highthemes')); ?></span>
                </div>
            <div class="clearfix mbf"></div>
            <!-- related post -->
            <?php
            if($ht_options['disable_related_folio'] !="1"){
                get_template_part( 'includes/templates/related-folio' );
            }
            ?>  
</div><!-- grid9 -->
        <?php if($ht_sidebar_status != 'no-sidebar') { get_sidebar(); }?>
</div><!-- row-->
     
<?php  else:  ?>
<?php get_template_part( 'includes/templates/no-results' ); ?>
<?php endif; ?>
