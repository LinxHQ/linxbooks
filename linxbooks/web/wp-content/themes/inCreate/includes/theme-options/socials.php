<?php 
/* Social Media */
/*-----------------------------------------------------------------------------------*/
$of_options[] = array("name" => __("Social Media","highthemes"),
"type" => "heading");

$of_options[] = array(  "name"      => "Social menu target",
"desc"      => "Choose the social links target",
"id"        => "social_menu_target",
"std"       => 0,
"on"        => "New Window",
"off"       => "Same Window",
"type"      => "switch"
);        

$of_options[] = array("name" => __("RSS Feed", "highthemes"),
"desc" => __("Enter your rss feed url here", "highthemes"),
"id" => "rss_id",
"std" => get_bloginfo_rss('rss2_url'),
"type" => "text");
$of_options[] = array("name" => __("Twitter Profile", "highthemes"),
"desc" => __("Enter your Twitter Profile URL.", "highthemes"),
"id" => "twitter_id",
"std" => "",
"type" => "text");
$of_options[] = array("name" => __("Facebook Profile", "highthemes"),
"desc" => __("Enter your facebook profile url here", "highthemes"),
"id" => "facebook_id",
"std" => "",
"type" => "text");
$of_options[] = array("name" => __("Google Plus Profile", "highthemes"),
"desc" => __("Enter your Google plus profile url here", "highthemes"),
"id" => "gplus_id",
"std" => "",
"type" => "text");
$of_options[] = array("name" => __("Flickr Profile", "highthemes"),
"desc" => __("Enter your flickr profile url here", "highthemes"),
"id" => "flickr_id",
"std" => "",
"type" => "text");

$of_options[] = array("name" => __("LinkedIn Profile", "highthemes"),
"desc" => __("Enter your linkedin profile url here", "highthemes"),
"id" => "linkedin_id",
"std" => "",
"type" => "text");


$of_options[] = array("name" => __("Dribbble Profile", "highthemes"),
"desc" => __("Enter your Dribbble profile url here", "highthemes"),
"id" => "dribbble_id",
"std" => "",
"type" => "text");


$of_options[] = array("name" => __("Github Profile", "highthemes"),
"desc" => __("Enter your github profile url here", "highthemes"),
"id" => "github_id",
"std" => "",
"type" => "text");


$of_options[] = array("name" => __("Tumblr Profile", "highthemes"),
"desc" => __("Enter your Tumblr profile url here", "highthemes"),
"id" => "tumblr_id",
"std" => "",
"type" => "text");


$of_options[] = array("name" => __("Skype Profile", "highthemes"),
"desc" => __("Enter your skype profile url here", "highthemes"),
"id" => "skype_id",
"std" => "",
"type" => "text");


$of_options[] = array("name" => __("Dropbox Profile", "highthemes"),
"desc" => __("Enter your dropbox profile url here", "highthemes"),
"id" => "dropbox_id",
"std" => "",
"type" => "text");

$of_options[] = array("name" => __("Instagram Profile", "highthemes"),
"desc" => __("Enter your instagram profile url here", "highthemes"),
"id" => "instagram_id",
"std" => "",
"type" => "text");

$of_options[] = array("name" => __("YouTube Profile", "highthemes"),
"desc" => __("Enter your YouTube profile url here", "highthemes"),
"id" => "youtube_id",
"std" => "",
"type" => "text");

$of_options[] = array("name" => __("Pinterest Profile", "highthemes"),
"desc" => __("Enter your Pinterest profile url here", "highthemes"),
"id" => "pinterest_id",
"std" => "",
"type" => "text");

$of_options[] = array("name" => __("Xing Profile", "highthemes"),
"desc" => __("Enter your Xing profile url here", "highthemes"),
"id" => "xing_id",
"std" => "",
"type" => "text");

$of_options[] = array("name" => __("Email Profile", "highthemes"),
"desc" => __("Enter your email address here.", "highthemes"),
"id" => "email_id",
"std" => "",
"type" => "text");
