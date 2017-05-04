<?php
/* Portfolio */
        /*-----------------------------------------------------------------------------------*/

        $of_options[] = array("name" => __("Portfolio Settings", "highthemes"),
            "type" => "heading");

        $of_options[] = array("name" => __("Portfolio Archive Page Layout", "highthemes"),
            "desc" => __("Select the portfolio archive page template", "highthemes"),
            "id" => "folio_archive_layout",
            "std" => '3col',
            "type" => "select",
            "options" =>array("2col"=>"2 Column", "3col"=>"3 Column", "4col" =>'4 Column')
        );

        $of_options[] = array("name" => __("Portfolio Slug", "highthemes"),
            "desc" => __("Default Portfolio slug is 'portfolio', if you would like to change it, enter your desired slug here. It will appear in portfolio items' urls. Note that if you change it you will need to open admin panel, change permalink structure to default, save website and then revert it to previous state. ", "highthemes"),
            "id" => "folio_slug",
            "std" => "",
            "type" => "text");

        $of_options[] = array("name" => __("Portfolio Category Slug", "highthemes"),
            "desc" => __("Default Portfolio category slug is 'portfolio-category', if you would like to change it, enter your desired slug here. It will appear in portfolio categories' urls. Note that if you change it you will need to open admin panel, change permalink structure to default, save website and then revert it to previous state. ", "highthemes"),
            "id" => "folio_cat_slug",
            "std" => "",
            "type" => "text");
        
        $of_options[] = array("name" => __("Related Items Title", "highthemes"),
            "desc" => __("Default title is Related Items, you can change it here.", "highthemes"),
            "id" => "related_folio_title",
            "std" => "",
            "type" => "text");

        $of_options[] = array("name" => __("Related Items Description", "highthemes"),
            "desc" => __("Enter a short description for portfolio related items.", "highthemes"),
            "id" => "related_folio_desc",
            "std" => "",
            "type" => "textarea");        

        $of_options[] = array("name" => __("Disable Related Items", "highthemes"),
            "desc" => __("Check this box to disable related items for portfolio single page.", "highthemes"),
            "id" => "disable_related_folio",
            "std" => 0,
            "type" => "checkbox");