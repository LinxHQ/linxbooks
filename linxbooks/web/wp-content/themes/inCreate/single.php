<?php
get_header();
if (get_post_type() == 'portfolio') {
	get_template_part( '/includes/templates/single-folio' );
} else {
	get_template_part('/includes/templates/single');   
}
?>