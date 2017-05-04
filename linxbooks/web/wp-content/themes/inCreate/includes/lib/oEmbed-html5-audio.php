<?php

wp_embed_register_handler( 'html5_audio', '#^http://.+\.(mp3|ogg|wav)$#i', 'wp_embed_handler_html5_audio' );

function wp_embed_handler_html5_audio( $matches, $attr, $url, $rawattr ) {

	if (preg_match('#^http://.+\.mp3$#i', $url) && preg_match('/Firefox/', $_SERVER["HTTP_USER_AGENT"])) {
		// For religious reasons Firefox does not support MP3 format in HTML5 audio tag, use Flash player instead
		$embed = sprintf(
				'<div style="text-align:center; "><embed type="application/x-shockwave-flash" flashvars="audioUrl=%1$s" src="http://www.google.com/reader/ui/3523697345-audio-player.swf" width="400" height="27" quality="best"></embed></div>',
				esc_attr($matches[0])
				);
	} else if (preg_match('#^http://.+\.mp3$#i', $url) && preg_match('/Opera/', $_SERVER["HTTP_USER_AGENT"])) {
		// Opera also does not support MP3 format in HTML5 audio tag, use Flash player instead
		$embed = sprintf(
				'<div style="text-align:center; "><embed type="application/x-shockwave-flash" flashvars="audioUrl=%1$s" src="http://www.google.com/reader/ui/3523697345-audio-player.swf" width="400" height="27" quality="best"></embed></div>',
				esc_attr($matches[0])
				);
	} else if (preg_match('#^http://.+\.ogg$#i', $url) && preg_match('/MSIE/', $_SERVER["HTTP_USER_AGENT"])) {
		$embed = '[Internet Explorer does not support OGG format]';
	} else if (preg_match('#^http://.+\.wav$#i', $url) && preg_match('/MSIE/', $_SERVER["HTTP_USER_AGENT"])) {
		$embed = '[Internet Explorer does not support WAV format]';
	} else {	
		$embed = sprintf(
				'<div style="text-align:center; "><audio controls preload><source src="%1$s" /><embed type="application/x-shockwave-flash" flashvars="audioUrl=%1$s" src="http://www.google.com/reader/ui/3523697345-audio-player.swf" width="400" height="27" quality="best"></embed></audio></div>',
				esc_attr($matches[0])
				);
	}

	$embed = apply_filters( 'oembed_html5_audio', $embed, $matches, $attr, $url, $rawattr );
	return apply_filters( 'oembed_result', $embed, $url, '' );
}

?>