<?php
/**
 * Metaboxes
 * 
 * Main functions for the metaboxes manage.     
 */

/**
 * @var array Array with all metaboxes registered on the theme
 */
$ht_metaboxes = array(); 

/**
 * @var array Array with all options of the metaboxes registered on the theme
 */
$ht_metaboxes_options = array();     

 
/**
 * Register all metaboxes registered in the theme.
 *
 * @since 1.0
 */
function ht_register_metaboxes() {
	global $ht_metaboxes;	    
	
	foreach ( $ht_metaboxes as $id => $the_ ) 
		add_meta_box($id, $the_['title'], $the_['callback'], $the_['page'], $the_['context'], $the_['priority'], $the_['callback_args'] );
}
add_action('add_meta_boxes', 'ht_register_metaboxes');
 
/**
 * Add a meta box to an edit form.
 *
 * @since 1.0
 *
 * @param string $id String for use in the 'id' attribute of tags.
 * @param string $title Title of the meta box.
 * @param string $page The type of edit page on which to show the box (post, page, link).             
 * @param array $options_args All options to add into the metabox.
 * @param string $context The context within the page where the boxes should show ('normal', 'advanced').
 * @param string $priority The priority within the context where the boxes should show ('high', 'low').
 */
function ht_register_metabox( $id, $title, $page, $options_args, $context = 'advanced', $priority = 'default', $callback_args = null ) {
	global $ht_metaboxes;
	
	$html = '';
	$post_id = ( isset( $_GET['post'] ) ) ? $_GET['post'] : false;

	foreach ( $options_args as $option_args ){
	
	$meta = get_post_meta($post_id, $option_args['id'], true);
	$d_values =  '';
	$d_element =  '';

	if(isset($option_args['dependency'])) {
		$dependency = $option_args['dependency'];
		if(is_array($dependency['value'])) {
			$d_values = implode(" ", $dependency['value']);
		} else {
			$d_values = $dependency['value'];
		}
		$d_element = $dependency['element'];
	}
        $html .= '<div class="ht-meta-option" data-element="'.$d_element.'" data-values="'.$d_values.'">
                <label class="ht-meta-label" for="'.$option_args['id'].'">'.$option_args['label'].'</label>
                <div class="ht-meta-field">';
		$html .= ht_get_option_of_metabox( $option_args ); 
        $html .= '</div></div>';

	}


	$callback = create_function( '', 'echo stripslashes( \'<div class="ht-metaboxes-wrapper">' . addslashes( $html ) . '</div>\' );' );
	
	$ht_metaboxes[$id] = array(
		'title' => $title,
		'callback' => $callback,
		'page' => $page,
		'options' => $options_args,
		'context' => $context,
		'priority' => $priority,
		'callback_args' => $callback_args
	);
}
 
/**
 * Add an option to a metabox.
 *
 * @since 1.0
 *
 * @param string $id String for use in the 'id' attribute of tags.       
 * @param array $options_args All options to add into the metabox.
 */
function ht_add_options_to_metabox( $id, $options_args ) {
	global $ht_metaboxes;       
	
	foreach( $ht_metaboxes[$id]['options'] as $order => $option )
		$options_args[$order] = $option;
	
	ksort($options_args);       
	
	$html = '';
	foreach ( $options_args as $option_args )
		$html .= ht_get_option_of_metabox( $option_args ); 
	
	$callback = create_function( '', 'echo stripslashes( \'<div class="ht_metaboxes">' . addslashes( $html ) . '</div>\' );' );
	
	$ht_metaboxes[$id]['options'] = $options_args;
	$ht_metaboxes[$id]['callback'] = $callback;
}
 
/**
 * Save the post data of metaboxes.
 *
 * @since 1.0
 *
 * @param int $post_id The id of post
 */
function ht_save_postdata( $post_id ) {
	global $ht_metaboxes_options;

	if ( isset( $_POST['admin_noncename'] ) AND !wp_verify_nonce( $_POST['admin_noncename'], plugin_basename(__FILE__) )) 
		return $post_id;
	
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
		return $post_id;                 
	
	// get post type
	if ( !isset($_GET['post_type']) )
		$post_type = 'post';
	elseif ( in_array( $_GET['post_type'], get_post_types( array('show_ui' => true ) ) ) )
		$post_type = $_GET['post_type'];
	else
		wp_die( __('Invalid post type', 'highthemes') );
	
	if ( 'page' == $post_type ) {
		if ( !current_user_can( 'edit_page', $post_id ) )
		  return $post_id;
	} else {
		if ( !current_user_can( 'edit_post', $post_id ) )
		  return $post_id;
	}                   
	
	// add post metas hidden
	if ( isset( $ht_metaboxes_options[$post_type] ) )
		foreach( $ht_metaboxes_options[$post_type] as $key )
		{
			if( isset( $_POST[$key] ) )
				add_post_meta( $post_id, $key, $_POST[$key], true ) or update_post_meta( $post_id, $key, $_POST[$key] );	         
			else
				delete_post_meta( $post_id, $key );
		}
	
	return;
}                         
add_action('save_post', 'ht_save_postdata');
 
/**
 * Retrieve the html of option to put inside the metabox.
 *
 * @since 1.0
 *
 * @param array $args Set of arguments for generating the html option
 */
function ht_get_option_of_metabox( $args ) {
	global $ht_metaboxes_options;
	
 	$html = '';    

	// default arguments 
	$defaults = array(
		'label'      => '',
		'id'         => '',
		'type'       => 'text',
		'desc'       => '',
		'options'    => array(),
		'text'       => '',
		'std'        => '',
		'dependency' => array()
	);            
	
	$args = wp_parse_args( $args, $defaults );            
    $metapost_name = $args['id'];    
  
	$post_id = ( isset( $_GET['post'] ) ) ? $_GET['post'] : false;
	$option_value = ( $post_id != FALSE ) ? get_post_meta( $post_id, $metapost_name, true ) : $args['std'];
	if ( empty( $option_value ) )
	   $option_value = $args['std'];
	
	// get post type
	if ( !isset($_GET['post_type']) )
		$post_type = 'post';
	elseif ( in_array( $_GET['post_type'], get_post_types( array('show_ui' => true ) ) ) )
		$post_type = $_GET['post_type'];
	else
		wp_die( __('Invalid post type', 'highthemes') );
	
	// save the option in the global array
	$ht_metaboxes_options[$post_type][] = $metapost_name;


	switch($args['type']) :

	case 'paragraph' :
		$html .= ht_string_( '<p>', $args['text'], '</p>', false );
		break;               
    // text
    case 'text':
        $html .= '<input type="text" name="'.$args['id'].'" id="'.$args['id'].'" value="'.$option_value.'" size="30" />
			  <br /><span class="description">'.$args['desc'].'</span>';
        break;
    
    // textarea
    case 'textarea':
        $html .= '<textarea name="'.$args['id'].'" id="'.$args['id'].'" cols="60" rows="4">'.$option_value.'</textarea>
			  <br /><span class="description">'.$args['desc'].'</span>';
        break;
    
    // checkbox
    case 'checkbox':
        $html .= '<input value="1" type="checkbox" name="'.$args['id'].'" id="'.$args['id'].'" '. checked( $option_value, 1, false ) .'/>
			  <label for="'.$args['id'].'">'.$args['desc'].'</label>';
        break;
    
    // checkbox_group
    case 'checkbox_group':

        if(is_array($args['options']) && count($args['options']) >0){
            foreach ($args['options'] as $value=>$label) {
    	$checkbox_group_checked = ( $option_value && in_array($value, $option_value) ) ? ' checked="checked"' : '';

                $html .= '<input type="checkbox" value="'.$value.'" name="'.$args['id'].'[]" id="'.$value.'"'.$checkbox_group_checked.' /> <label for="'.$value.'">'.$label.'</label><br />';
            }
            $html .= '<span class="description">'.$args['desc'].'</span>';
        } else {
            $html .= '<span class="description">Please create a category first.</span>';
        }

        break;
    
    // select
    case 'select':
        $html .= '<select name="'.$args['id'].'" id="'.$args['id'].'">';
        foreach ($args['options'] as $value=>$label) {
            $html .= '<option '. selected( $option_value, $value, false ) . ' value="'.$value.'">'.$label.'</option>';
        }
        $html .= '</select><br /><span class="description">'.$args['desc'].'</span>';
        break;

    //  image  
    case 'image':  
    $wp_version = floatval(get_bloginfo('version'));
    $image_attributes = wp_get_attachment_image_src( $option_value ,'thumbnail');
    
    $visible = ($image_attributes[0] =="") ? 'display:none;' : 'display:block';

    
        $html .= '
        <ul id="'.$args['id'].'" style="'.$visible.'" class="image-holder-single">
            <li>
            <img width="150"  height="150" class="thumbnail" src="'.$image_attributes[0].'" />
            <br/>
            <a href="#" style="text-decoration: none;" data-relid="'.$args['id'].'"" class="remove-image">[X]</a>
            </li>
        </ul>';
   
    
    $html .= '<input type="hidden" name="'.$args['id'].'" id="'.$args['id'].'" value="'.$option_value.'" />
          <input id="'.$args['id'].'" data-title="'.__("Choose an image").'" data-version="'.$wp_version.'" class="ht_upload_image_single button" type="button" value="Upload Image" /> 
          <br />
          <span class="description">'.$args['desc'].'</span>';

    
        break;      
        
    // multi image  
    case 'multi-image':  
    $wp_version = floatval(get_bloginfo('version'));
        $html .= '<span class="description">'.$args['desc'].'</span>';
        $html .='<ul id="'.$args['id'].'-holder" class="image-holder">';

        if(is_array($option_value)){

            foreach ($option_value as $key => $option) {

                $image_attributes = wp_get_attachment_image_src( $option ,'thumbnail');

                if($image_attributes[0]){

                    $html .= '<li>';
                    $html .= '<input type="hidden" name="'.$args['id'].'[]" value="'.$option.'" />';
                    $html .= '<img width="150" height="150" class="thumbnail" src="'.$image_attributes[0].'" /><br/>';
                    $html .= '<a href="#" style="text-decoration: none;" class="remove-image">[X]</a></li>';

                }

            }
        }

        $html .= '</ul>';
        $html .= '<input id="'.$args['id'].'" data-title="'.__("Select Images", "highthemes") .'" data-version="'.$wp_version.'"  class="ht_upload_image button" type="button" value="Upload Image" /> ';
    
    break;  

    // color picker
    case 'color':
        $html .= '<input  class="color-field" name="' . $args['id'] . '" id="' . $args['id'] . '" type="text" value="' . $option_value . '" /><div class="colorpicker"></div><span class="description">' . $args['desc'] . '</span>';


  
        break;

 	endswitch;
 	                                                                       
 	$html = apply_filters( 'ht_metabox_option_' . $args['type'] . '_html', $html );
 	$html = apply_filters( 'ht_metabox_option_html', $html );
 	
 	return $html;
}
?>