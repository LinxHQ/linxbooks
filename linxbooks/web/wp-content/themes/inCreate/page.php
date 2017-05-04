<?php
// getting the page type
$ht_page_type     = get_post_meta( get_the_ID(), '_ht_page_type', true);

get_header();

// load variables
global $ht_options;

if($ht_page_type == 'blog') {
    get_template_part('includes/templates/tpl-blog');
    exit;
} elseif($ht_page_type == 'masonry-blog') {
    get_template_part('includes/templates/tpl-masonry-blog');
    exit;
} elseif($ht_page_type == 'masonry-portfolio') {
    get_template_part('includes/templates/tpl-masonry-portfolio');
    exit;
} elseif ($ht_page_type == 'portfolio') {

    //select portfolio layout
    $ht_portfolio_layout = get_post_meta( get_the_ID(), '_ht_portfolio_layout', true);

   if($ht_portfolio_layout == '2c') {
        get_template_part('includes/templates/tpl-portfolio-2col-filtered');
        exit;

    } elseif($ht_portfolio_layout == '3c') {
        get_template_part('includes/templates/tpl-portfolio-3col-filtered');
        exit;

    } elseif($ht_portfolio_layout == '4c' ) {
        get_template_part('includes/templates/tpl-portfolio-4col-filtered');
        exit;
    } else {
        get_template_part('includes/templates/tpl-portfolio-3col-filtered');
        exit;

    }

} else { // if general page
   
        if(have_posts()):
            while (have_posts()) :the_post();
                $ht_sidebar_status = ht_sidebar_layout();  
                $row_class = 'row clearfix mbs';
                $span = ( $ht_sidebar_status == 'no-sidebar' ) ? '' : 'grid_9' ;
                $no_top_margin = get_post_meta( get_the_ID(), '_ht_disable_top_margin', true);
                $no_top_margin =  ($no_top_margin) ? 'no-top-margin' : '';


        ?>              
    <div id="page-section-<?php the_ID(); ?>" <?php post_class($row_class); ?> >
        <div class="<?php echo $span;?>">
            <div class="entry clearfix">
                <?php
                the_content();
                if( $ht_options['pages_comment'] && !is_front_page() ) {
                    comments_template( '', true );
                }
                ?>
            </div><!-- .entry -->   
        </div><!-- .grid_9 or .grid_12 -->
        <?php if($ht_sidebar_status != 'no-sidebar') { get_sidebar(); }?>
    </div><!-- .row -->

    <?php endwhile;?>
    <?php else: ?>
        <?php get_template_part( 'includes/templates/no-results' ); ?>
    <?php endif; ?>
<?php get_footer(); }?>