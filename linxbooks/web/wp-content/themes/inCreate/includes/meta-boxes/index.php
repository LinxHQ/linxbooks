<?php 
add_action( 'admin_init', 'ht_default_metaboxes' );

// slogan page
function ht_default_metaboxes() {
	global $prefix;

	/**
	 * Post Categories
	 */
	$categories = array();
	$categories_obj = get_categories('hide_empty=0');
	foreach ($categories_obj as $highcat) {
	    $categories[$highcat->cat_ID] = $highcat->cat_name;
	}

	/**
	 * Revolution Slider
	 */
	$rev_sliders =  array( 'none' => __('none', "highthemes" ));
	if ( class_exists('RevSlider') ) {
	    $rev = new RevSlider();
	    $arrSliders = $rev->getArrSliders();
	    foreach ( (array) $arrSliders as $revSlider ) { 
	        $rev_sliders[ $revSlider->getAlias() ] = $revSlider->getTitle();
	    }
	}

	/**
	 * Portfolio Categories
	 */
	$terms_array = array();
	$terms = ht_create_terms_list('portfolio-category');
	if(isset($terms) && is_array($terms)){
	    foreach($terms as $term){
	        $terms_array[$term['slug']]  = $term['name'];
	    }
	}


	/**
	 * Page Metabox
	 */
	require_once HT_THEME_INC_DIR . 'meta-boxes/page-metabox.php';


	/**
	 * Portfolio Metabox
	 */
	require_once HT_THEME_INC_DIR . 'meta-boxes/portfolio-metabox.php';


	/**
	 * Post Metabox
	 */
	require_once HT_THEME_INC_DIR . 'meta-boxes/post-metabox.php';


	/**
	 * Sidebar
	 */
	require_once HT_THEME_INC_DIR . 'meta-boxes/sidebar-metabox.php';		

}

?>