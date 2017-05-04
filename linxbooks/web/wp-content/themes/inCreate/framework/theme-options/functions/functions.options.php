<?php
/**
 *
 * HighThemes Options Framework
 * twitter : http://twitter.com/theHighthemes
 *
 */

add_action('init', 'of_options');

if (!function_exists('of_options')) {
    function of_options()
    {
        global $ht_google_fonts;
        //Access the WordPress Categories via an Array
        $of_categories      = array();  
        $of_categories_obj  = get_categories('hide_empty=0');
        foreach ($of_categories_obj as $of_cat) {
            $of_categories[$of_cat->cat_ID] = $of_cat->cat_name;}
        $categories_tmp     = array_unshift($of_categories, "Select a category:");    
           
        //Access the WordPress Pages via an Array
        $of_pages           = array();
        $of_pages_obj       = get_pages('sort_column=post_parent,menu_order');

        foreach ($of_pages_obj as $of_page) {
            $of_pages[$of_page->ID] = $of_page->post_name; }
        $of_pages_tmp       = array_unshift($of_pages, "Select a page:");       
    
        //Stylesheets Reader
        $alt_stylesheet_path = LAYOUT_PATH;
        $alt_stylesheets = array();
        
        if ( is_dir($alt_stylesheet_path) ) 
        {
            if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) 
            { 
                while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) 
                {
                    if(stristr($alt_stylesheet_file, ".css") !== false)
                    {
                        $alt_stylesheets[] = $alt_stylesheet_file;
                    }
                }    
            }
        }


        //Background Images Reader
        $bg_images_path = get_stylesheet_directory(). '/images/bg/'; // change this to where you store your bg images
        $bg_images_url = get_template_directory_uri().'/images/bg/'; // change this to where you store your bg images
        $bg_images = array();
        
        if ( is_dir($bg_images_path) ) {
            if ($bg_images_dir = opendir($bg_images_path) ) { 
                while ( ($bg_images_file = readdir($bg_images_dir)) !== false ) {
                    if(stristr($bg_images_file, ".png") !== false || stristr($bg_images_file, ".jpg") !== false) {
                        natsort($bg_images); //Sorts the array into a natural order
                        $bg_images[] = $bg_images_url . $bg_images_file;
                    }
                }    
            }
        }


        //More Options
        $uploads_arr = wp_upload_dir();

        // Image Alignment radio box
        $of_options_thumb_align = array("alignleft" => "Left", "alignright" => "Right", "aligncenter" => "Center");

        // Image Links to Options
        $of_options_image_link_to = array("image" => "The Image", "post" => "The Post");


        /*-----------------------------------------------------------------------------------*/
        /* The Options Array */
        /*-----------------------------------------------------------------------------------*/

        // Set the Options Array
        global $of_options;
        $of_options = array();

         
        // include theme options
        global $ht_theme_options;
        foreach($ht_theme_options as $theme_option) {
            require_once( HT_THEME_INC_DIR . 'theme-options/' . $theme_option . '.php');
        } 



        // TODO: must be a function


        // Backup Options
        $of_options[] = array("name" => __("Backup Options", "highthemes"),
            "type" => "heading");

        $of_options[] = array("name" => __("Backup and Restore Options", "highthemes"),
            "id" => "of_backup",
            "std" => "",
            "type" => "backup",
            "desc" => __('You can use the two buttons below to backup your current options, and then restore it back at a later time. This is useful if you want to experiment on the options but would like to keep the old settings in case you need it back.', "highthemes"),
        );

        $of_options[] = array("name" => __("Transfer Theme Options Data", "highthemes"),
            "id" => "of_transfer",
            "std" => "",
            "type" => "transfer",
            "desc" => __('You can tranfer the saved options data between different installs by copying the text inside the text box. To import data from another install, replace the data in the text box with the one from another install and click "Import Options"', "highthemes"),
        );
    }
}
?>