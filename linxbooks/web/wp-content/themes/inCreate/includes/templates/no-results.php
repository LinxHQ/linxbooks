<?php if ( is_search() ) : ?>
		<div class="post-area no-result">
		    <div class="entry clearfix">
				<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'highthemes' ); ?></p>
		        <h4><?php _e('Search','highthemes'); ?></h4>
		        <?php get_search_form(); ?>
		    </div><!-- .entry  -->
		</div><!-- .post-area  -->
<?php else : ?>
		<div class="post-area no-result">
		    <div class="entry clearfix">
		        <p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'highthemes' ); ?></p>
		        <h4><?php _e('Search','highthemes'); ?></h4>
		        <?php get_search_form(); ?>
		    </div><!-- .entry  -->                             
		</div><!-- .post-area  -->
<?php endif; ?>