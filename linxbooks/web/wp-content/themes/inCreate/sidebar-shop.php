<?php global $ht_options; ?>
<div class="grid_3 sidebar">
	<?php
	wp_reset_query();
	$sidebar = 'shop-sidebar';
	ht_generated_dynamic_sidebar($sidebar);
	?>
</div><!-- .sidebar -->

