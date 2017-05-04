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
        'label'      => __('More Images (slideshow)','highthemes'),
        'desc'       => __('You can add more images to be shown in slideshow. Please note that you need to upload the first image as a featured image from the right sidebar','highthemes'),  
        'id'         => $prefix.'slider_images',  
        'type'       => 'multi-image' ,
        "dependency" => Array("element" =>  'post-formats-select input.post-format:checked', "value" =>  "0")
    ), 
  

    array(
        'label'      =>__('Featured image on single page', 'highthemes'),
        'desc'       =>__('You can enable/disable featured image on this page using this option.', 'highthemes'),
        'id'         =>$prefix.'disable_post_image',
        'type'       =>'select',
        'options'    =>array(
            ''           => __("Select An Option", "highthemes"),
            'true'       => __("Enable", "highthemes"),
            'false'      => __("Disable", "highthemes")          
        
        ),
        "dependency" => Array("element" =>  'post-formats-select input.post-format:checked', "value" =>  "0")
    ),

    array(
        'label'      => __('External Link for Link Post Format ', 'highthemes'),
        'desc'       => __('Paste an external link address, if you\'ve chosen "link" post format type. ', 'highthemes'),
        'id'         => $prefix.'link_post_format',
        'type'       => 'text',
        "dependency" => Array("element" =>  'post-formats-select input.post-format:checked', "value" =>  "link")
    ),

    array(
        'label'      => __('Quote Source: ', 'highthemes'),
        'desc'       => __('Enter the source name of the quote ', 'highthemes'),
        'id'         => $prefix.'format_quote_source_name',
        'type'       => 'text',
        "dependency" => Array("element" =>  'post-formats-select input.post-format:checked', "value" =>  "quote")

    ),

    array(
        'label'      => __('Quote Source Link: ', 'highthemes'),
        'desc'       => __('Enter the URL of the quote source. ', 'highthemes'),
        'id'         => $prefix.'format_quote_source_url',
        'type'       => 'text',
        "dependency" => Array("element" =>  'post-formats-select input.post-format:checked', "value" =>  "quote")

    ),
    array(
        'label'      => __('SoundCloud Audio Link', 'highthemes'),
        'desc'       => __('Enter the address of musice from SoundCloud', 'highthemes'),
        'id'         => $prefix.'sound_link',
        'type'       => 'text',
        "dependency" => Array("element" =>  'post-formats-select input.post-format:checked', "value" =>  "audio")
    ),
    array(
        'label'      => __('Embed External Video ', 'highthemes'),
        'desc'       => __('Vimeo, Youtube, Dailymotion, etc..', 'highthemes'),
        'id'         => $prefix.'video_link',
        'type'       => 'text',
        "dependency" => Array("element" =>  'post-formats-select input.post-format:checked', "value" =>  "video")
    ),

    array(
        'label'      => __('MP4 Video Url: ', 'highthemes'),
        'desc'       => __('Enter your video url in .mp4 format.', 'highthemes'),
        'id'         => $prefix.'video_mp4',
        'type'       => 'text',
        "dependency" => Array("element" =>  'post-formats-select input.post-format:checked', "value" =>  "video")
    ),

    array(
        'label'      => __('WebM Video URL: ', 'highthemes'),
        'desc'       => __('Enter your video url in .webm format.', 'highthemes'),
        'id'         => $prefix.'video_webm',
        'type'       => 'text',
        "dependency" => Array("element" =>  'post-formats-select input.post-format:checked', "value" =>  "video")
    ),

        array(
        'label'      => __('OGV Video URL: ', 'highthemes'),
        'desc'       => __('Enter your video url in .ogv format.', 'highthemes'),
        'id'         => $prefix.'video_ogv',
        'type'       => 'text',
        "dependency" => Array("element" =>  'post-formats-select input.post-format:checked', "value" =>  "video")
    ),

        array(
        'label'      => __('FLV Video URL: ', 'highthemes'),
        'desc'       => __('Enter your video url in .flv format.', 'highthemes'),
        'id'         => $prefix.'video_flv',
        'type'       => 'text',
        "dependency" => Array("element" =>  'post-formats-select input.post-format:checked', "value" =>  "video")
    )
);
ht_register_metabox( 'ht_post_options_cb', __( 'HighThemes Post Options', 'highthemes' ), 'post', $options_args, 'normal', 'high' );  
?>