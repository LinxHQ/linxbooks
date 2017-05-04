<?php
 /* Background Patterns & Colors */
        /*-----------------------------------------------------------------------------------*/

        $of_options[] = array( "name" => __("Backgrounds", "highthemes"),
            "type" => "heading");

        $of_options[] = array( "name" =>  __("Body Background Color", "highthemes"),
            "desc" => __("Pick a background color for the theme.", "highthemes"),
            "id" => "body_background",
            "std" => "#545454",
            "type" => "color");

        $of_options[] = array( "name" => __("Background Patterns", "highthemes"),
            "desc" => __("Select a background pattern from the list.", "highthemes"),
            "id" => "custom_pattern",
            "std" => $bg_images_url."01.png",
            "type" => "tiles",
            "options" => $bg_images,
        );

        $of_options[] = array("name" => __("Upload Background Image", "highthemes"),
            "desc" => __("Upload a Cutsom Background Image", "highthemes"),
            "id" => "custom_bg",
            "std" => "",
            "type" => "media");

        $of_options[] = array("name" => __("Background Repeat", "highthemes"),
            "desc" => __("Select background repeat option", "highthemes"),
            "id" => "custom_bg_repeat",
            "std" => "",
            "type" => "select",
            'options'    => array (
                'no-repeat'  => __('No Repeat', 'highthemes'), 
                'repeat-x'   => __('Repeat X', 'highthemes') , 
                'repeat-y'   => __('Repeat Y', 'highthemes') , 
                'repeat'     => __('Repeat', 'highthemes')   
                )
        );

        $of_options[] = array("name" => __("Background Position", "highthemes"),
            "desc" => __("Select the background image position.", "highthemes"),
            "id" => "custom_bg_position",
            "std" => "",
            "type" => "select",
            'options'    => array (
                'left top'      => __("Left Top", "highthemes"),
                'left bottom'   => __("Left Bottom", "highthemes"),
                'left center'   => __("Left Center", "highthemes"), 
                'right top'     => __("Right Top", "highthemes"),
                'right bottom'  => __("Right Bottom", "highthemes"), 
                'right center'  => __("Right Center", "highthemes"), 
                'center top'    => __("Center Top", "highthemes"),
                'center bottom' => __("Center Bottom", "highthemes"), 
                'center center' => __("Center Center", "highthemes")   
                )
        );  

        $of_options[] = array("name" => __("Fullscreen Background", "highthemes"),
            "desc" => __("Check this box to make the page background fullscreen.", "highthemes"),
            "id" => "custom_bg_cover",
            "std" => 0,
            "type" => "checkbox");       


        $of_options[] = array("name" => __("Fixed Background?", "highthemes"),
            "desc" => __("Check this box if you would like to have a fixed background image while scrolling.", "highthemes"),
            "id" => "custom_bg_fixed",
            "std" => 0,
            "type" => "checkbox");                     
                