<?php
        /* Blog Options */
        /*-----------------------------------------------------------------------------------*/
        $of_options[] = array("name" => __("Blog Settings", "highthemes"),
            "type" => "heading");

        $of_options[] = array("name" => __("Disable Featured images at top of posts", "highthemes"),
            "desc" => __("check this box to disable featured images at top of posts. You can always override this option on each post by post options.", "highthemes"),
            "id" => "disable_post_image",
            "std" => 0,
            "type" => "checkbox");

        $of_options[] = array("name" => __("Disable Lightbox for Blog?", "highthemes"),
            "desc" => __("By default, the theme uses PrettyPhoto lightbox for blog post featured images, you can disable it. ", "highthemes"),
            "id" => "blog_lightbox",
            "std" => 0,
            "type" => "checkbox");

        $of_options[] = array("name" => __("Show Full Content on Blog", "highthemes"),
            "desc" => __("Check this box to disable excerpt and show full content on blog page.", "highthemes"),
            "id" => "disable_excerpt",
            "std" => 0,
            "type" => "checkbox");

        $of_options[] = array("name" => __("Posts Excerpt Length", "highthemes"),
            "desc" => __("If you don't check full content checkbox, the blog will show an excerpt of content. You can set its length here.", "highthemes"),
            "id" => "post_excerpt_length",
            "std" => "300",
            "type" => "text");        
