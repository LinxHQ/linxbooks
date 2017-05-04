<?php 
    if( has_post_thumbnail() && $ht_options['disable_post_image'] !='1' ) {
        if( count($post_images) > 0 ) {
?>
    <div class="thumb_f">
        <div class="projectslider clearfix flexslider">
            <ul class="slides">
                <li>
                    <div class="post-image">
                        <a <?php echo $lightbox_status;?> >
                            <img src="<?php echo esc_attr($thumb[0]);?>" alt="<?php the_title_attribute();?>" >
                            <!--<div class="mask <?php echo $zoom;?>"></div>-->
                        </a>
                    </div><!-- .post-image -->                       
                </li>
                <?php
                $img_i = 0;
                foreach( $post_images as $post_image ){
                    if( $ht_options['blog_lightbox'] ) { 
                        $lightbox = '<a href="'.get_permalink().'">';
                    } else {
                        $lightbox = '<a data-gal="lightbox" href="'.$post_large_images[$img_i][0].'">';
                    }
                    echo '
                    <li>
                        <div class="post-image">
                                ' . $lightbox . '
                                <img src="'.$post_image[0].'" />
                                <!--<div class="mask '.$zoom.'"></div>-->
                            </a>
                        </div>
                    </li>';
                    $img_i++;
                }?>  
            </ul>
        </div>
    </div><!-- .thumb_f -->
     <?php 
     //end post_images
     } else {
     ?>
    <div class="thumb_f">
        <a <?php echo $lightbox_status;?> >
            <img src="<?php echo esc_attr($thumb[0]);?>" alt="<?php the_title_attribute();?>" >
            <!--<div class="mask <?php echo $zoom;?>"></div>-->
        </a>
    </div><!-- .thumb_f --> 
    <?php 
        }
    } // end if thumb
    ?>   