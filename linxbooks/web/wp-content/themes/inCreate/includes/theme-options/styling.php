<?php
        /* Style Options */
        /*-----------------------------------------------------------------------------------*/

        $of_options[] = array( "name" => __("Styling Options", "highthemes"),
            "type" => "heading");

        $of_options[] = array("name" => __("Use Dark skin", "highthemes"),
            "desc" => __("Check this box to enable dark skin", "highthemes"),
            "id" => "dark_skin",
            "std" => 0,
            "type" => "checkbox");           

        $of_options[] = array( "name" =>  __("Accent Color", "highthemes"),
            "desc" => __("Change this color to alter the accent color globally for your site. ", "highthemes"),
            "id" => "accent_color",
            "std" => "#0083c1",
            "type" => "color");       
        
        $of_options[] = array("name" => __("Include Latin Characters?", "highthemes"),
            "desc" => __("Check this box to include latin characters for google fonts.", "highthemes"),
            "id" => "latin_chars",
            "std" => 0,
            "type" => "checkbox");               

        $of_options[] = array( "name" => __("Body Font", "highthemes"),
            "desc" => __("Specify the body font properties", "highthemes"),
            "id" => "body_font",
            "std" => array('size' => '13px','face' => 'Droid Sans','color' => '#333333'),
            "type" => "typography");


        $of_options[] = array( "name" => __("Headings Font", "highthemes"),
            "desc" => __("Specify the Headings font properties", "highthemes"),
            "id" => "heading_font",
            "std" => array('face' => 'Oswald','style' => '300'),
            "type" => "typography");

        $of_options[] = array( "name" => __("Sidebar Heading Font", "highthemes"),
            "desc" => __("Specify the Sidebar Heading font properties", "highthemes"),
            "id" => "sidebar_fonts",
            "std" => array('face' => 'Oswald','size' => '14px'),
            "type" => "typography");

         $of_options[] = array( "name" => __("Custom CSS", "highthemes"),
            "desc" => __("Quickly add some CSS to your theme by adding it to this block.", "highthemes"),
            "id" => "custom_css",
            "std" => "",
            "type" => "textarea");
?>