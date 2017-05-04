<?php

$timebeforerevote = 120;

add_action('wp_ajax_nopriv_post-like', 'ht_post_love');
add_action('wp_ajax_post-like', 'ht_post_love');
add_action('wp_enqueue_scripts', 'ht_love_script');




function ht_love_script(){
	wp_enqueue_script('love_post', HT_FRAMEWORK_URL.'assets/js/post-like.js', array('jquery'), '1.0', 1 );
	wp_localize_script('love_post', 'ajax_var', array(
		'url' => admin_url('admin-ajax.php'),
		'nonce' => wp_create_nonce('ajax-nonce')
	));
}
function ht_post_love()
{
	$nonce = $_POST['nonce'];
 
    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
        die ( 'Busted!');
		
	if(isset($_POST['post_like']))
	{
		$ip = $_SERVER['REMOTE_ADDR'];
		$post_id = $_POST['post_id'];
		
		$meta_IP = get_post_meta($post_id, "voted_IP");

		$voted_IP = $meta_IP[0];
		if(!is_array($voted_IP))
			$voted_IP = array();
		
		$meta_count = get_post_meta($post_id, "votes_count", true);

		if(!ht_has_voted($post_id))
		{
			$voted_IP[$ip] = time();

			update_post_meta($post_id, "voted_IP", $voted_IP);
			update_post_meta($post_id, "votes_count", ++$meta_count);
			
			echo $meta_count;
		}
		else
			echo "already";
	}
	exit;
}

function ht_has_voted($post_id)
{
	global $timebeforerevote;

	$meta_IP = get_post_meta($post_id, "voted_IP");
	if($meta_IP){
		$voted_IP = $meta_IP[0];
		if(!is_array($voted_IP))
			$voted_IP = array();
		$ip = $_SERVER['REMOTE_ADDR'];
		
		if(in_array($ip, array_keys($voted_IP)))
		{
			$time = $voted_IP[$ip];
			$now = time();
			
			if(round(($now - $time) / 60) > $timebeforerevote)
				return false;
				
			return true;
		}		
	}

	
	return false;
}

function ht_get_post_love($post_id)
{
	$output = '';
	$vote_count = get_post_meta($post_id, "votes_count", true);
	$vote_count = ($vote_count == '') ? '0' : $vote_count;
	if( ht_has_voted($post_id) )
		$output .= '<a class="post-rate voted small-tooltip" href="#">
					<span class="tooltip-sc"><i class="fa-heart"></i></span><span class="tool-tip"><span class="tooltip-body">'.$vote_count.'</span><span class="tooltip-tip"></span></span>
					</a>';
	else
		$output .= '<a class="post-rate small-tooltip" href="#" data-post_id="'.$post_id.'">
					<span class="tooltip-sc"><i class="fa-heart qtip like"></i></span><span class="tool-tip"><span class="tooltip-body">'.$vote_count.'</span><span class="tooltip-tip"></span></span>
					</a>';
	

	return $output;
}
?>