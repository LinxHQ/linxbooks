<?php
get_header();

// variables
global $ht_options;

$ht_subblog_category = 	get_post_meta(get_the_ID(), '_ht_subblog_category', true);
$ht_sidebar_status   = 	ht_sidebar_layout();
$post_excerpt_length = 	($ht_options['post_excerpt_length']) ? $ht_options['post_excerpt_length'] : 300;
$ht_page_type        = get_post_meta( get_the_ID(), '_ht_page_type', true);
$masonry_class       = ($ht_page_type == 'masonry-blog') ? 'masonry-brick' : '';
$masonry_layout      = get_post_meta( get_the_ID(), '_ht_mblog_layout', true);

if( $masonry_layout == '2c') {
	$masonry_layout = 'two-column';
} else {
	$masonry_layout = 'three-column';
}

// sidebar status
$span = ( $ht_sidebar_status == 'no-sidebar' ) ? '' : 'grid_9 ';

?>
<section id="page-section-<?php the_ID(); ?>" <?php post_class('row clearfix mbs'); ?>>
		<div id="masonry-container" class="<?php echo $span;?> <?php echo $masonry_layout;?> transitions-enabled centered clearfix">

			<div class="post-area posts <?php if( $ht_sidebar_status == 'no-sidebar' ) echo 'grid_12'; ?>">
			<?php
			if (have_posts()) :
				$ht_subblog_category = ( is_array($ht_subblog_category) ) ? implode(",", $ht_subblog_category) : '';
				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
				$args = array(
					'post_type' => 'post',
					'post_status' => 'publish',
					'orderby' => 'date',
					'paged' => $paged,
					'cat' => $ht_subblog_category

				);
				query_posts($args);
				while ( have_posts() ) : the_post();
					global $more;
					$more = 0;
					if(get_post_format() !='') {
						include(locate_template('includes/templates/content-'. get_post_format() .'.php'));
					} else {
						include(locate_template('includes/templates/content.php'));
					}						

	
				endwhile;
			else:
				get_template_part( 'includes/templates/no-results' );
			endif;
			?>

			</div> <!-- .post-area -->

		</div><!-- .masonry-wrapper -->
					<?php if( $ht_sidebar_status != 'no-sidebar') get_sidebar(); ?>

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
</section>       
<?php get_footer();?>