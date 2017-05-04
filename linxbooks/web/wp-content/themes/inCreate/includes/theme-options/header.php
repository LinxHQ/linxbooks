<?php

 /* Header Options */
        /*-----------------------------------------------------------------------------------*/


        $of_options[] = array("name" => __("Header Settings", "highthemes"),
            "type" => "heading");

        $of_options[] = array("name" => __("Sticky Header", "highthemes"),
            "desc" => __("You can enable/disable sticky header here.", "highthemes"),
            "id" => "sticky_header",
            "std" => 1,
            "type" => "checkbox");             

        $of_options[] = array("name" => __("Enable Breadcrumb", "highthemes"),
            "desc" => __("You can enable/disable breadcrumb for inner pages.", "highthemes"),
            "id" => "breadcrumb_inner",
            "std" => 0,
            "type" => "checkbox"); 

        $of_options[] = array("name" => __("Disable Top Header", "highthemes"),
            "desc" => __("Check this box to disable top header bar.", "highthemes"),
            "id" => "disable_top_header",
            "std" => 0,
            "type" => "checkbox");

        $of_options[] = array("name" => __("Transparent Header", "highthemes"),
            "desc" => __("Check this box to header background & border", "highthemes"),
            "id" => "transparent_header",
            "std" => 0,
            "type" => "checkbox");        


        $of_options[] = array("name" => __("Top Header Information Text", "highthemes"),
            "desc" => __("Enter your desired text here. It will be shown on top header layout A. e.g. \"Call US: 111 222 333\"", "highthemes"),
            "id" => "top_header_info",
            "std" => "Call us now: 111 222 333",
            "type" => "text");

   
        $of_options[] = array( "name" => __("Navigation Font", "highthemes"),
            "desc" => __("Specify the Navigation font properties", "highthemes"),
            "id" => "navigation_font",
            "std" => array('face' => 'Open Sans','size' => '13px','style' => 'normal', 'color' => '#333333'),
            "type" => "typography");

        $of_options[] = array("name" => __("Disable Top Search", "highthemes"),
            "desc" => __("Check this box to disable top search bar.", "highthemes"),
            "id" => "disable_top_search",
            "std" => 0,
            "type" => "checkbox");