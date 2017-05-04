<?php
 /* WooCommerce Settings */
        /*-----------------------------------------------------------------------------------*/


        $of_options[] = array("name" => __("WooCommerce", "highthemes"),
            "type" => "heading");


        $of_options[] = array( 
                        "std" => __("You can upload up to 3 advertisement banner for shop page.", "highthemes"),
                        "type"      => "info"
                ); 

        $of_options[] = array("name" => __("Upload Banner 1", "highthemes"),
            "desc" => __("Upload ad banner 1", "highthemes"),
            "id" => "woo_ad_banner1",
            "std" => "",
            "type" => "upload");

        $of_options[] = array("name" => __("Ad Banner 1 URL", "highthemes"),
            "desc" => '',
            "id" => "woo_ad_url1",
            "std" => "#",
            "type" => "text");        

        $of_options[] = array("name" => __("Upload Banner 2", "highthemes"),
            "desc" => __("Upload ad banner 2", "highthemes"),
            "id" => "woo_ad_banner2",
            "std" => "",
            "type" => "upload");        

        $of_options[] = array("name" => __("Ad Banner 2 URL", "highthemes"),
            "desc" => '',
            "id" => "woo_ad_url2",
            "std" => "#",
            "type" => "text");   
     
        $of_options[] = array("name" => __("Upload Banner 3", "highthemes"),
            "desc" => __("Upload ad banner 3", "highthemes"),
            "id" => "woo_ad_banner3",
            "std" => "",
            "type" => "upload");

        $of_options[] = array("name" => __("Ad Banner 3 URL", "highthemes"),
            "desc" => '',
            "id" => "woo_ad_url3",
            "std" => "#",
            "type" => "text");   
        
