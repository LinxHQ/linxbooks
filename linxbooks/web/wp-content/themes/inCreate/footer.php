</div><!-- ./page-content -->
<?php global $ht_options; wp_reset_query();?>
<footer id="footer">
    <?php  if( $ht_options['footer'] ){  ?>
    <div class="row pad_foot clearfix">
<?php if($ht_options['footer_columns']==1){ ?>
                <div class="grid_12">
                    <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer-1') ) : ?>
                    <?php endif; ?>
                </div><!-- .grid_12 -->
                <?php } elseif($ht_options['footer_columns']==2){ ?>
                <div class="grid_6">
                    <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer-1') ) : ?>
                    <?php endif; ?>
                </div><!-- .grid_6 -->
                <div class="grid_6">
                    <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer-2') ) : ?>
                    <?php endif; ?>
                </div><!-- .grid_6 -->
                <?php } elseif($ht_options['footer_columns']==3){ ?>
                <div class="grid_4">
                    <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer-1') ) : ?>
                    <?php endif;?>
                </div><!-- .grid_4 -->
                <div class="grid_4">
                    <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer-2') ) : ?>
                    <?php endif;?>
                </div><!-- .grid_4 -->
                <div class="grid_4">
                    <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer-3') ) : ?>
                    <?php endif;?>
                </div><!-- .grid_4 -->
                <?php } elseif($ht_options['footer_columns']==4) { ?>
                <div class="grid_3">
                    <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer-1') ) : ?>
                    <?php endif;?>
                </div><!-- .grid_3 -->
                <div class="grid_3">
                    <?php   if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer-2') ) : ?>
                    <?php endif;?>
                </div><!-- .grid_3 -->
                <div class="grid_3">
                    <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer-3') ) : ?>
                    <?php endif;?>
                </div><!-- .grid_3 -->
                <div class="grid_3">
                    <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer-4') ) : ?>
                    <?php endif;?>
                </div><!-- .grid_3 -->
                <?php } //end column numbers ?>
    </div><!-- row -->
    <?php } ?>
    <?php if( $ht_options['sub_footer'] ){ ?>

    <div class="footer-last">
        <div class="row clearfix">
            <span class="copyright"><?php echo stripslashes($ht_options['footer_text']); ?></span>
            <div id="toTop" class="toptip" title="Back to Top"><i class="fa-angle-up"></i></div><!-- Back to top -->

            <div class="foot-menu">
                <?php wp_nav_menu( array('menu_class' => '', 'depth' =>1, 'menu_id' => 'footer-menu',  'menu' => 'footer-nav',  'container' => 'ul','theme_location' => 'footer-nav', 'container_id' => 'nav' ) );  ?>
            </div><!-- end foot menu -->
        </div><!-- end row -->
    </div><!-- end last footer -->
    <?php } ?>


</footer><!-- end footer -->

</div><!-- end layout -->
</div><!-- end frame -->
<?php echo stripslashes($ht_options['google_analytics']); ?>
<?php echo $ht_options['before_body']; ?>
<?php wp_footer(); ?>
</body>
</html>