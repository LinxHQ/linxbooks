<?php
/**
 Plugin Name: Sort Query by Post In
 Plugin URI: http://www.cmurrayconsulting.com/software/wordpress-sort-query-by-post-in/
 Description: Allows post queries to sort the results by the order specified in the <em>post__in</em> parameter. Just set the <em>orderby</em> parameter to <em>post__in</em>! 
 Version: 1.2
 Author: Jacob M Goldman (C. Murray Consulting)
 Author URI: http://www.cmurrayconsulting.com

    Plugin: Copyright 2009 C. Murray Consulting  (email : jake@cmurrayconsulting.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if ( !function_exists('sort_query_by_post_in') ) {

if ( get_bloginfo('version') < 3.0 ) : //a little more tricky pre 3.0 since we have to check the query earlier

	add_filter( 'pre_get_posts', 'sort_query_by_post_in' );
	
	function sort_query_by_post_in($thequery) {
		
		if ( isset($thequery->query['post__in']) && !empty($thequery->query['post__in']) && isset($thequery->query['orderby']) && $thequery->query['orderby'] == 'post__in' ) {
			$GLOBALS['sort_by_post_in'] = "find_in_set(ID, '" . implode( ',', $thequery->query['post__in'] ) . "')";
			add_filter('posts_orderby', create_function('$a','return $GLOBALS["sort_by_post_in"];') );
		}
		
		return $thequery;
	}

else : //simple WordPress 3.0+ version

	add_filter( 'posts_orderby', 'sort_query_by_post_in', 10, 2 );
	
	function sort_query_by_post_in( $sortby, $thequery ) {
		global $wpdb;
		if ( isset($thequery->query['post__in']) && !empty($thequery->query['post__in']) && isset($thequery->query['orderby']) && $thequery->query['orderby'] == 'post__in' ){
			
			$orderby_statement = 'FIELD('.$wpdb->base_prefix.'posts.ID, '.implode(',', $thequery->query['post__in']).')';

			return $orderby_statement;
		}

	}

endif;

}
?>