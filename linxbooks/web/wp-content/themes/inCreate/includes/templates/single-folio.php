<?php
global $ht_options;

// Getting the portfolio layout
$portfolio_single_layout = get_post_meta( get_the_ID(), '_ht_portfolio_single_layout', true);
?>
<section>
    <div class="container">
		<?php
		switch ($portfolio_single_layout) {
			case 'image_left':
			case 'image_right':
				get_template_part( '/includes/templates/single-folio-image' );
				break;

			case 'image_sidebar':
				get_template_part( '/includes/templates/single-folio-sidebar' );
				break;								

			default:
				get_template_part( '/includes/templates/single-folio-image' );
				break;
		}
		?>
    </div><!-- .container -->                      
</section><!-- .blog -->
<!-- Sections -->
<?php get_footer();?>