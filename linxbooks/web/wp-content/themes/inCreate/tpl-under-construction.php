<?php
/*
Template Name: Under Construction
*/

get_header();

// load variables
global $ht_options;
 
        if(have_posts()):
            while (have_posts()) :the_post();
        ?>     
            <div class="under_construction">
                <div class="row clearfix">
                    <div class="UCP">
                        <h2 class="tac mbf"> <?php the_title();?> </h2>
    
                        <ul id="backsoon" class="countdown clearfix">
                            <li>
                                <span class="days">00</span>
                                <p class="timeRefDays"><?php _e("days", "highthemes");?></p>
                            </li>
                            <li>
                                <span class="hours">00</span>
                                <p class="timeRefHours"><?php _e("hours", "highthemes");?></p>
                            </li>
                            <li>
                                <span class="minutes">00</span>
                                <p class="timeRefMinutes"><?php _e("mins", "highthemes");?></p>
                            </li>
                            <li>
                                <span class="seconds">00</span>
                                <p class="timeRefSeconds"><?php _e("sec", "highthemes");?></p>
                            </li>
                        </ul> <!-- end timer -->
                    </div>
                </div><!-- row -->
            </div><!-- end 404 place --> 
    <?php endwhile;?>
    <?php else: ?>
        <?php get_template_part( 'includes/templates/no-results' ); ?>
    <?php endif; ?>
<?php get_footer(); ?>