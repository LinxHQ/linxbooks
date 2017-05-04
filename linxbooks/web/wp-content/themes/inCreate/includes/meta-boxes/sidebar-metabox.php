<?php

// Field Array
$sidebars = sidebar_generator::get_sidebars();
$sidebars_array =array (
        'default-sidebar' => __('Select a Sidebar', 'highthemes')
);

if(is_array($sidebars)){
    foreach($sidebars as $key=>$sidebar){
        $sidebars_array[$key] = $sidebar;
    }
}

$options_args = array(

    array(
        'label'   => __('Sidebar Alignment', 'highthemes'),
        'desc'    => '',
        'id'      => $prefix.'sidebar_alignment',
        'type'    => 'select',
        'options' => array (
            ''                 => __("Select Sidebar Alignment", "highthemes"),
            'right-sidebar' => __("Right Sidebar", "highthemes"),
            'left-sidebar'  => __("Left Sidebar", "highthemes") ,
            'no-sidebar'       => __("No Sidebar", "highthemes")              
        ),
    ),

    array(
        'label'   => __('Custom Sidebar', 'highthemes'),
        'desc'    => __('Select a custom sidebar','highthemes'),
        'id'      => $prefix.'selected_sidebar',
        'type'    => 'select',
        'options' => $sidebars_array,
    )
);

ht_register_metabox( 'ht_custom_sidebar_cb_post', __( 'Sidebar Options', 'highthemes' ), 'post', $options_args, 'side', 'low' );  
ht_register_metabox( 'ht_custom_sidebar_cb_page', __( 'Sidebar Options', 'highthemes' ), 'page', $options_args, 'side', 'low' );  
ht_register_metabox( 'ht_custom_sidebar_cb_portfolio', __( 'Sidebar Options', 'highthemes' ), 'portfolio', $options_args, 'side', 'low' ); 

if( is_woocommerce_activated() ) {
    ht_register_metabox( 'ht_custom_sidebar_cb_product', __( 'Sidebar Options', 'highthemes' ), 'product', $options_args, 'side', 'low' );  

}
