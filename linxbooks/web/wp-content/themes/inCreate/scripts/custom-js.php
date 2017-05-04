<?php
/************************************************************************
 * Custom JS File
 *************************************************************************/ 

function load_custom_js(){

	$script_out = '';

	$script_out .= '<script type="text/javascript">'."\n";
	$script_out .= 'jQuery(document).ready(function($){'."\n";
	$script_out .= ht_general_js();
	if( is_woocommerce_activated() ){
		$script_out .= ht_woocommerce_js_scripts();
	}	
	$script_out .= '});'."\n";
	$script_out .= "\n".'</script>'."\n\n\n";


	echo $script_out;


}

add_action('wp_footer','load_custom_js',100);

function ht_general_js() {
	global $ht_options;
	$script_out ='';

	$script_out .='var retina = window.devicePixelRatio > 1 ? true : false;';

     if(isset($ht_options['retina_logo_url']) && $ht_options['retina_logo_url'] !='') {
		$script_out .='
		if(retina) {
			$("#header .logo img").attr("src", "'.$ht_options["retina_logo_url"].'");
		}
		';
     }
    $script_out .= '
	if( $("#backsoon")[0] ) {
		$("#backsoon").countdown({
			date: "'.$ht_options['ws_launch_day'].' '.$ht_options['ws_launch_month'].' '.$ht_options['ws_launch_year'].' '.$ht_options['ws_launch_hour'].':00:00",
			format: "on"
		},
		function() {
			// callback function
		});		
	}
    ';


     return $script_out;

}

function ht_woocommerce_js_scripts() {
	$script_out ='     
        $("body").bind("added_to_cart", function(){
            $(".add_to_cart_button.added").text("ADDED").addClass("added_act");  
        });
        ';    

}



?>