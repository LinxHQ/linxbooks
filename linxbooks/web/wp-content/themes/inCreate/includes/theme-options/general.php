<?php
 /* General Settings */
        /*-----------------------------------------------------------------------------------*/


        $of_options[] = array("name" => __("General Settings", "highthemes"),
            "type" => "heading");

        $url = HT_FRAMEWORK_URL . 'assets/images/';
        $of_options[] = array("name" => __("Main Sidebar Layout", "highthemes"),
            "desc" => __("Select main content and sidebar alignment. Select from left, right or full-width layout.<br /> You can override this option on each single post and page.", "highthemes"),
            "id" => "sidebar_layout",
            "std" => "right-sidebar",
            "type" => "images",
            "options" => array(
                'no-sidebar' => $url . '1col.png',
                'right-sidebar' => $url . '2cr.png',
                'left-sidebar' => $url . '2cl.png')
        );

        $of_options[] = array( "name" => __("Layout Type", "highthemes"),
            "desc" => __("You can select the site main layout here.", "highthemes"),
            "id" => "layout_type",
            "std" => "wide",
            "type" => "select",
            "folds" => "1",
            "options" => array("full"=>"Wide", "boxed"=>"Boxed", "boxed-margin" => "Boxed with Margin"));


        $of_options[] = array( "name" => __("Responsive Layout?", "highthemes"),
            "desc" => __("By default, the theme adapts to the screen size of the visitor and uses a layout best suited.
                        You can disable this behavior so the theme will only show the default layout without adaptation", "highthemes"),
            "id" => "responsive_layout",
            "std" => "responsive",
            "type" => "select",
            "options" => array("responsive"=>"Responsive Layout", "fixed"=>"Fixed Layout"));

        $of_options[] = array("name" => __("Tracking Code", "highthemes"),
            "desc" => __("Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.", "highthemes"),
            "id" => "google_analytics",
            "std" => "",
            "type" => "textarea");

        $of_options[] = array("name" => __("Upload Logo", "highthemes"),
            "desc" => __("Upload your logo here, or insert the URL directly", "highthemes"),
            "id" => "logo_url",
            "std" => "",
            "type" => "upload");

        $of_options[] = array("name" => __("Logo (Retina Version @2x)", "highthemes"),
            "desc" => __("Please choose an image file for the retina version of the logo. It should be 2x the size of main logo.", "highthemes"),
            "id" => "retina_logo_url",
            "std" => "",
            "type" => "upload");        

     
        $of_options[] = array("name" => __("Upload Favicon", "highthemes"),
            "desc" => __("Upload a 16px x 16px Png, Gif, Ico image that will represent your website's favicon.", "highthemes"),
            "id" => "custom_favicon",
            "std" => "",
            "type" => "upload");


        $of_options[] = array("name" => __("Upload iPhone Icon ", "highthemes"),
            "desc" => __("Icon for Apple iPhone (57px x 57px)", "highthemes"),
            "id" => "apple_logo",
            "std" => "",
            "type" => "upload");      

        $of_options[] = array("name" => __("Upload iPad Icon ", "highthemes"),
            "desc" => __("Icon for Apple iPad (72px x 72px)", "highthemes"),
            "id" => "apple_ipad_logo",
            "std" => "",
            "type" => "upload");                   

        $of_options[] = array(  "name"      => "Comments on Pages?",
                        "desc"      => __("Enable/Disable Comments on pages", "highthemes"),
                        "id"        => "pages_comment",
                        "std"       => 0,
                        "type"      => "switch"
                );    

        $of_options[] = array(  "name"      => "Page Navi Pagination?",
                        "desc" => __("By default, the theme uses wp-pagenavi, you can turn it off here. ", "highthemes"),
                        "id"        => "pagenavi_status",
                        "std"       => 1,
                        "type"      => "switch"
                );  
        $of_options[] = array( 
                        "std" => __("If you're website is under construction yet, you can setup a page with a launch date. Select the launch date here. Then go to pages > add new, and create a page with \"Under Construction\" Template.", "highthemes"),
                        "type"      => "info"
                ); 

        $of_options[] = array( "name" => __("Website Launch Year", "highthemes"),
            "desc" => "",
            "id" => "ws_launch_year",
            "std" => "2014",
            "type" => "select",
            "options" => array("2014", "2015", "2016", "2017", "2018", "2019", "2020", "2021", "2022", "2023", "2024", "2025"));

        $of_options[] = array( "name" => __("Website Launch Month", "highthemes"),
            "desc" =>"",
            "id" => "ws_launch_month",
            "std" => "January",
            "type" => "select",
            "options" => array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"));

        $of_options[] = array( "name" => __("Website Launch Day", "highthemes"),
            "desc" => '',
            "id" => "ws_launch_day",
            "std" => "01",
            "type" => "select",
            "options" => array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"
                                , "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31"));

        $of_options[] = array( "name" => __("Website Launch Hour", "highthemes"),
            "desc" => '',
            "id" => "ws_launch_hour",
            "std" => "24",
            "type" => "select",
            "options" => array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"
                                , "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24"));


        $of_options[] = array(  "name"      => "Footer?",
                        "desc" => __("Enable/Disable Footer", "highthemes"),
                        "id"        => "footer",
                        "std"       => 1,
                        "type"      => "switch"
                );   

        $of_options[] = array(  "name"      => "Sub-Footer?",
                        "desc" => __("Enable/Disable Sub-Footer", "highthemes"),
                        "id"        => "sub_footer",
                        "std"       => 1,
                        "type"      => "switch"
                );   


        $of_options[] = array("name" => __("Footer Text", "highthemes"),
            "desc" => __("Enter a copyright or something else at the very bottom of the pages.", "highthemes"),
            "id" => "footer_text",
            "std" => "Powered by HighThemes. All rights reserved.",
            "type" => "textarea");    

        $of_options[] = array( "name" => __("Footer Columns", "highthemes"),
            "desc" => __("Specify the number of footer columns", "highthemes"),
            "id" => "footer_columns",
            "std" => "4",
            "type" => "select",
            "options" => array("4"=>"4 Columns", "3"=>"3 Columns", "2"=>"2 Columns", "1"=>"1 Columns"));

        $of_options[] = array("name" => __("Space Before &lt;/head&gt;", "highthemes"),
            "desc" => __("Add code before the &lt;/head&gt; tag.", "highthemes"),
            "id" => "before_head",
            "std" => "",
            "type" => "textarea");

        $of_options[] = array("name" => __("Space Before &lt;/body&gt;", "highthemes"),
            "desc" => __("Add code before the &lt;/body&gt; tag.", "highthemes"),
            "id" => "before_body",
            "std" => "",
            "type" => "textarea");

