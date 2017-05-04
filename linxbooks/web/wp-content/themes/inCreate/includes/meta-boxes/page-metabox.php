<?php 
$options_args = array(
    array(
        'label'      => __('Header Type', 'highthemes'),
        'desc'       => __('Choose the header type for this page', 'highthemes'),
        'id'         => $prefix.'header_type',
        'type'       => 'select',
        'options'    => array (
            'title'      =>__('Show Page Title', 'highthemes'),
            'no-title'   =>__('Hide Page Title', 'highthemes') ,
            'rev-slider' =>__('Revolution Slider', 'highthemes')           
        )
    ),
    array(
        'label'      => __('Revolution Slider', 'highthemes'),
        'desc'       => __('Select the revolution slider for this page', 'highthemes'),
        'id'         => $prefix.'rev_slider',
        'type'       => 'select',
        'options'    => $rev_sliders,
        "dependency" => array("element" =>  $prefix.'header_type', "value" => "rev-slider")

    ),    
    array(
        'label'      => __('Overlay Caption Title', 'highthemes'),
        'desc'       => __('By filling this field, you can enable an overlay caption for the slidehsow.', 'highthemes'),
        'id'         => $prefix.'overlay_caption_title',
        'type'       => 'text',
        "dependency" => array("element" =>  $prefix.'header_type', "value" => array("rev-slider"))
    ), 
    array(
        'label'      => __('Overlay Button 1 Title', 'highthemes'),
        'desc'       => __('You can have up to 2 buttons here. Enter the first title. ', 'highthemes'),
        'id'         => $prefix.'overlay_button1_title',
        'type'       => 'text',
        "dependency" => array("element" =>  $prefix.'header_type', "value" => array("rev-slider"))
    ), 
    array(
        'label'      => __('Overlay Button 1 Link URL', 'highthemes'),
        'desc'       => __('You can have up to 2 buttons here. Enter the first link url. ', 'highthemes'),
        'id'         => $prefix.'overlay_button1_link',
        'type'       => 'text',
        "dependency" => array("element" =>  $prefix.'header_type', "value" => array("rev-slider"))
    ),  
    array(
        'label'      => __('Overlay Button 1 Icon', 'highthemes'),
        'desc'       => __('You can have up to 2 buttons here. Enter the first button icon name. ', 'highthemes'),
        'id'         => $prefix.'overlay_button1_icon',
        'type'       => 'text',
        "dependency" => array("element" =>  $prefix.'header_type', "value" => array("rev-slider"))
    ),   

    array(
        'label'      => __('Overlay Button 2 Title', 'highthemes'),
        'desc'       => __('You can have up to 2 buttons here. Enter the second title. ', 'highthemes'),
        'id'         => $prefix.'overlay_button2_title',
        'type'       => 'text',
        "dependency" => array("element" =>  $prefix.'header_type', "value" => array("rev-slider"))
    ), 
    array(
        'label'      => __('Overlay Button 2 Link URL', 'highthemes'),
        'desc'       => __('You can have up to 2 buttons here. Enter the second link url. ', 'highthemes'),
        'id'         => $prefix.'overlay_button2_link',
        'type'       => 'text',
        "dependency" => array("element" =>  $prefix.'header_type', "value" => array("rev-slider"))
    ),  
    array(
        'label'      => __('Overlay Button 2 Icon', 'highthemes'),
        'desc'       => __('You can have up to 2 buttons here. Enter the second button icon name. ', 'highthemes'),
        'id'         => $prefix.'overlay_button2_icon',
        'type'       => 'text',
        "dependency" => array("element" =>  $prefix.'header_type', "value" => array("rev-slider"))
    ),                   
    array(
        'label'      => __('Header Background', 'highthemes'),
        'desc'       => __("Select from the list of available backgrounds, or upload your own here.", 'highthemes'),
        'id'         => $prefix.'header_background',
        'type'       => 'select',
        'options'    => array (
            'default'          => 'Default Background',
            'custom'           => 'Upload Custom Image',
            'breadcrumb1.jpg'  => '1', 
            'breadcrumb2.jpg'  => '2', 
            'breadcrumb3.jpg'  => '3', 
            'breadcrumb4.jpg'  => '4',   
            'breadcrumb5.jpg'  => '5',   
            'breadcrumb6.jpg'  => '6',   
            'breadcrumb7.jpg'  => '7',   
            'breadcrumb8.jpg'  => '8',   
            'breadcrumb9.jpg'  => '9',   
            'breadcrumb10.jpg' => '10',   
            'breadcrumb11.jpg' => '11',   
            'breadcrumb12.jpg' => '12',   
            'breadcrumb13.jpg' => '13',   
            'breadcrumb14.jpg' => '14',   
            'breadcrumb15.jpg' => '15',   
            'breadcrumb16.jpg' => '16',   
            'breadcrumb17.jpg' => '17',   
            'breadcrumb18.jpg' => '18',   
            'breadcrumb19.jpg' => '19',   
            'breadcrumb20.jpg' => '20'
        ),
        "dependency" => array("element" =>  $prefix.'header_type', "value" => "title")
    ), 
    array(
        'label'      => __('Background Color', 'highthemes'),
        'desc'       => __('Header background color can be selected here.', 'highthemes'),
        'id'         => $prefix.'header_bg_color',
        'type'       => 'color',
        "dependency" => array("element" =>  $prefix.'header_background', "value" => "custom")
    ),   
    array(
        'label'      => __('Background Image', 'highthemes'),
        'desc'       => __('Upload your desired Header background image.', 'highthemes'),
        'id'         => $prefix.'header_bg',
        'type'       => 'image',
        "dependency" => array("element" =>  $prefix.'header_background', "value" => "custom")
    ),
    array(
        'label'      => __('Background Repeat', 'highthemes'),
        'desc'       => __("Select background image repeat type.", 'highthemes'),
        'id'         => $prefix.'header_bg_repeat',
        'type'       => 'select',
        'options'    => array (
            'no-repeat'  => __('No Repeat', 'highthemes'), 
            'repeat-x'   => __('Repeat X', 'highthemes') , 
            'repeat-y'   => __('Repeat Y', 'highthemes') , 
            'repeat'     => __('Repeat', 'highthemes')   
        ),
        "dependency" => array("element" =>  $prefix.'header_background', "value" => "custom")
    ), 
    array(
        'label'         => __('Background Position', 'highthemes'),
        'desc'          => __('Set the background image position.', 'highthemes'),
        'id'            => $prefix.'header_bg_position',
        'type'          => 'select',
        'options'       => array(
            'left top'      => __("Left Top", "highthemes"),
            'left bottom'   => __("Left Bottom", "highthemes"),
            'left center'   => __("Left Center", "highthemes"), 
            'right top'     => __("Right Top", "highthemes"),
            'right bottom'  => __("Right Bottom", "highthemes"), 
            'right center'  => __("Right Center", "highthemes"), 
            'center top'    => __("Center Top", "highthemes"),
            'center bottom' => __("Center Bottom", "highthemes"), 
            'center center' => __("Center Center", "highthemes") 
        ),  
        "dependency" => array("element" =>  $prefix.'header_background', "value" => "custom")
    ),     
    array(
        'label'      => __('Background Cover?', 'highthemes'),
        'desc'       => __('If you check this box, the image will completely cover the header.', 'highthemes'),
        'id'         => $prefix.'header_bg_cover',
        'type'       => 'checkbox',
        "dependency" => array("element" =>  $prefix.'header_background', "value" => "custom")
    ), 
    array(
        'label'        => __('Page Type', 'highthemes'),
        'desc'         => __('Select the type of the page, if you want to create special pages like portfolio, etc.', 'highthemes'),
        'id'           => $prefix.'page_type',
        'type'         => 'select',
        'options'      => array(
            'page'              => __("Page", "highthemes"),
            'blog'              => __("Blog", "highthemes") ,
            'masonry-blog'      => __("Masonry Blog", "highthemes"),
            'portfolio'         => __("Portfolio", "highthemes"),
            'masonry-portfolio' => __("Masonry Portfolio", "highthemes") 
      )
    ),
    array(
        'label'        => __('Blog Layout', 'highthemes'),
        'desc'         => __('Select the thumbnail size for blog entries.', 'highthemes'),
        'id'           => $prefix.'blog_layout',
        'type'         => 'select',
        'options'      => array(
            'large_thumb'              => __("Large Thumbnails", "highthemes"),
            'medium_thumb'             => __("Medium Thumbnails", "highthemes"),
            'small_thumb'              => __("Small Thumbnails", "highthemes")
      ),
        "dependency" => array("element" =>  $prefix.'page_type', "value" => "blog")

    ),
    array(
        'label'        => __('Masonry Blog Layout', 'highthemes'),
        'desc'         => __('Select the masonry blog layout.', 'highthemes'),
        'id'           => $prefix.'mblog_layout',
        'type'         => 'select',
        'options'      => array(
            '2c'              => __("2 Columns", "highthemes"),
            '3c'             => __("3 Columns", "highthemes")
      ),
        "dependency" => array("element" =>  $prefix.'page_type', "value" => "masonry-blog")

    ),    
    array(
        'label'      => __('Portfolio Layouts', 'highthemes'),
        'desc'       => __('Select your desired layout for portfolio page.', 'highthemes'),
        'id'         => $prefix.'portfolio_layout',
        'type'       => 'select',
        'options'    => array (
            '2c'         => __("2 Columns", "highthemes"),
            '3c'         => __("3 Columns", "highthemes"),
            '4c'         => __("4 Columns", "highthemes") 
        ),
        "dependency" => array("element" =>  $prefix.'page_type', "value" => "portfolio")
    ) ,

    array(
        'label'      => __('Items per Page', 'highthemes'),
        'desc'       => __('Enter the number of items you would like to display per page', 'highthemes'),
        'id'         => $prefix.'item_number',
        'type'       => 'text',
        "dependency" => array("element" =>  $prefix.'page_type', "value" => array("portfolio", "masonry-portfolio"))
    ),

    array (
        'label'      => __('Sub-Blog Category', 'highthemes'),
        'desc'       => __('Check the categories you wish to show items from in the sub blog', 'highthemes'),
        'id'         => $prefix.'subblog_category',
        'type'       => 'checkbox_group',
        'options'    => $categories,
        "dependency" => array("element" =>  $prefix.'page_type', "value" =>  array("blog", "masonry-blog"))
    ),

    array (
        'label'      => __('Portfolio Category', 'highthemes'),
        'desc'       => __('Check the categories you wish to show items from.', 'highthemes'),
        'id'         => $prefix.'portfolio_category',
        'type'       => 'checkbox_group',
        'options'    => $terms_array,
        "dependency" => array("element" =>  $prefix.'page_type', "value" =>  array("portfolio", "masonry-portfolio"))
    )  

);

ht_register_metabox( 'ht_page_options_cb', __( 'HighThemes Page Options', 'highthemes' ), 'page', $options_args, 'normal' );
?>