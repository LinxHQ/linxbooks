<?php
get_header();

// variables
global $ht_options;

$ht_subblog_category = 	get_post_meta(get_the_ID(), '_ht_subblog_category', true);
$ht_sidebar_status   = 	ht_sidebar_layout();
$post_excerpt_length = 	($ht_options['post_excerpt_length']) ? $ht_options['post_excerpt_length'] : 300;
$blog_layout         = 	get_post_meta( get_the_ID(), '_ht_blog_layout', true );
$ht_page_type        = get_post_meta( get_the_ID(), '_ht_page_type', true);
$masonry_class       = ($ht_page_type == 'masonry-blog') ? 'masonry-brick' : '';
switch ($blog_layout) {
	case 'large_thumb':
		$blog_layout = 'large-thumbnails';
		break;
	case 'medium_thumb':
		$blog_layout = ' m_thumbnails';
		break;
	case 'small_thumb':
		$blog_layout = ' m_thumbnails s_thumbnails';
		break;				
	
	default:
		$blog_layout = ' large-thumbnails';
		break;
}

// sidebar status
$span = ( $ht_sidebar_status == 'no-sidebar' ) ? 'grid_12'. $blog_layout : 'grid_9 ' . $blog_layout;?>
<section id="page-section-<?php the_ID(); ?>" <?php post_class('row clearfix mbs'); ?>>
			<div class="post-area posts <?php echo $span;?>">
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
					if($blog_layout == 'large-thumbnails') {
						if(get_post_format() !='') {
							include(locate_template('includes/templates/content-'. get_post_format() .'.php'));
						} else {
							include(locate_template('includes/templates/content.php'));
						}						
					} else {
						if(get_post_format() !='') {
							include(locate_template('includes/templates/m-content-'.get_post_format().'.php'));
						} else {
							include(locate_template('includes/templates/m-content.php'));
						}							
					}

	
				endwhile;
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
				</div> <!-- .navi -->
			</div> <!-- .post-area -->
			<?php if( $ht_sidebar_status != 'no-sidebar') get_sidebar(); ?>
</section>       
<?php get_footer();?>