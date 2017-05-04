<?php

/**
 * Highthemes Google Map
 */

class ht_google_map extends WP_Widget {

	public function __construct() {
		global  $theme_name;
        wp_enqueue_script( "google-map", "http://maps.google.com/maps/api/js?sensor=false");

        $widget_ops = array('classname' => 'ht_google_map',
            'description' => __( 'Google Maps Widget','highthemes') );

		parent::__construct(
			'ht_google_map', 
			'Highthemes - ' . __('Google Map','highthemes'), 
			 $widget_ops // Args
		);
	}


    // display the widget in the theme
    function widget( $args, $instance ) {
        extract($args);

        $instance['g_map_title'] = strip_tags(stripslashes($instance['g_map_title']));
        $instance['g_map_info_bubble'] = stripslashes($instance['g_map_info_bubble']);
        $instance['g_map_zoom'] = stripslashes($instance['g_map_zoom']);
        $instance['g_map_lat'] = stripslashes($instance['g_map_lat']);
        $instance['g_map_lng'] = stripslashes($instance['g_map_lng']);
        $instance['g_map_type'] = stripslashes($instance['g_map_type']);

        $title = apply_filters('widget_title',$instance['g_map_title'], $instance, $this->id_base);

        echo $before_widget;
        wp_enqueue_script( "google-map", "http://maps.google.com/maps/api/js?sensor=false");
        $location = "['<div class=\"gmap-info\">". $instance['g_map_info_bubble'] ."</div>', ". $instance['g_map_lat'] .", ". $instance['g_map_lng'] ."]";

        $unique = uniqid();
$out = <<<EOF
<div id="google_map_{$unique}" class="google-map" style="height: 230px;" >
</div>
  <script type="text/javascript">
  (function(){
    // Define your locations: HTML content for the info window, latitude, longitude
    var locations = [
        $location
    ];
    
    // Setup the different icons and shadows
    var iconURLPrefix = 'http://maps.google.com/mapfiles/ms/icons/';
    
    var icons = [
      iconURLPrefix + 'red-dot.png',
      iconURLPrefix + 'green-dot.png',
      iconURLPrefix + 'blue-dot.png',
      iconURLPrefix + 'orange-dot.png',
      iconURLPrefix + 'purple-dot.png',
      iconURLPrefix + 'pink-dot.png',      
      iconURLPrefix + 'yellow-dot.png'
    ]
    var icons_length = icons.length;
    
    
    var shadow = {
      anchor: new google.maps.Point(15,33),
      url: iconURLPrefix + 'msmarker.shadow.png'
    };

    var map = new google.maps.Map(document.getElementById('google_map_{$unique}'), {
      zoom: {$instance['g_map_zoom']},
      center: new google.maps.LatLng(locations[0][1], locations[0][2]),
      mapTypeId: google.maps.MapTypeId.{$instance['g_map_type']},
      mapTypeControl: false,
      streetViewControl: false,
      panControl: true,
      zoomControlOptions: {
         position: google.maps.ControlPosition.LEFT_BOTTOM
      }
    });

    var infowindow = new google.maps.InfoWindow({
      maxWidth: 600
    });

    var marker;
    var markers = new Array();
    
    var iconCounter = 0;
    
    // Add the markers and infowindows to the map
    for (var i = 0; i < locations.length; i++) {  
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map,
        icon : icons[iconCounter],
        shadow: shadow
      });

      markers.push(marker);

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locations[i][0]);
          infowindow.open(map, marker);
        }
      })(marker, i));
      
      iconCounter++;
      // We only have a limited number of possible icon colors, so we may have to restart the counter
      if(iconCounter >= icons_length){
        iconCounter = 0;
      }
     
    }
        function AutoCenter() {
      //  Create a new viewpoint bound
      var bounds = new google.maps.LatLngBounds();
      //  Go through each...
      jQuery.each(markers, function (index, marker) {
        bounds.extend(marker.position);
      });
      //  Fit these bounds to the map
      map.fitBounds(bounds);
    }
    if( locations.length > 1 ) {
        AutoCenter();     
    }


})();    
  </script> 
EOF;
        echo '<h3 class="col-title">'.$title.'</h3>';
        echo $out;
        echo $after_widget;

        //end
    }

    // update the widget when new options have been entered
    function update( $new_instance, $old_instance ) {

        $instance = $old_instance;

        $instance['g_map_title']       = strip_tags($new_instance['g_map_title']);
        $instance['g_map_info_bubble'] = $new_instance['g_map_info_bubble'];
        $instance['g_map_zoom']        = $new_instance['g_map_zoom'];
        $instance['g_map_lat']         = $new_instance['g_map_lat'];
        $instance['g_map_lng']         = $new_instance['g_map_lng'];
        $instance['g_map_type']        = $new_instance['g_map_type'];

        return $instance;
    }

    // print the widget option form on the widget management screen
    function form( $instance ) {

        // combine provided fields with defaults
        $instance          = wp_parse_args( (array) $instance, array( 'g_map_title' => __('Google Map','highthemes'), 'g_map_zoom' => 14 ));
        $g_map_title       = $instance['g_map_title'];
        $g_map_info_bubble = $instance['g_map_info_bubble'];
        $g_map_zoom        = $instance['g_map_zoom'];
        $g_map_lat         = $instance['g_map_lat'];
        $g_map_lng         = $instance['g_map_lng'];
        $g_map_type        = $instance['g_map_type'];


        // print the form fields
        ?>

    <div class="google-map-details">
        <p><label for="<?php echo $this->get_field_id('g_map_title'); ?>">
            <?php _e('Title:','highthemes'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('g_map_title'); ?>" name="<?php echo $this->get_field_name('g_map_title'); ?>" type="text" value="<?php echo
            esc_attr($g_map_title); ?>" /></p>

        <p><label for="<?php echo $this->get_field_id('g_map_zoom'); ?>">
            <?php _e('Zoom Level: (1-19)','highthemes'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('g_map_zoom'); ?>" name="<?php echo $this->get_field_name('g_map_zoom'); ?>" type="text" value="<?php echo
            esc_attr($g_map_zoom); ?>" /></p>

        <p><label for="<?php echo $this->get_field_id('g_map_lat'); ?>">
            <?php _e('Latitude:','highthemes'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('g_map_lat'); ?>" name="<?php echo $this->get_field_name('g_map_lat'); ?>" type="text" value="<?php echo
            esc_attr($g_map_lat); ?>" /></p>

        <p><label for="<?php echo $this->get_field_id('g_map_lng'); ?>">
            <?php _e('Longitude:','highthemes'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('g_map_lng'); ?>" name="<?php echo $this->get_field_name('g_map_lng'); ?>" type="text" value="<?php echo
            esc_attr($g_map_lng); ?>" /></p>

        <p><label for="<?php echo $this->get_field_id('g_map_type'); ?>">
            <?php _e('Map Type:','highthemes'); ?></label>
            <select class="widefat" name="<?php echo $this->get_field_name('g_map_type'); ?>" id="<?php echo $this->get_field_id('g_map_type'); ?>">
                <option <?php if($g_map_type == 'ROADMAP')echo 'selected="selected"' ; ?> value="ROADMAP"><?php _e("ROADMAP", "highthemes");?></option>
                <option <?php if($g_map_type == 'SATELLITE')echo 'selected="selected"' ; ?> value="SATELLITE"><?php _e("SATELLITE", "highthemes");?></option>
                <option <?php if($g_map_type == 'HYBRID')echo 'selected="selected"' ; ?> value="HYBRID"><?php _e("HYBRID", "highthemes");?></option>
                <option <?php if($g_map_type == 'TERRAIN')echo 'selected="selected"' ; ?> value="TERRAIN"><?php _e("TERRAIN", "highthemes");?></option>
            </select>
        </p>

        <p><label for="<?php echo $this->get_field_id('g_map_info_bubble'); ?>">
            <?php _e('Info Bubble Content:','highthemes'); ?></label>
            <textarea cols="36" rows="5" name="<?php echo $this->get_field_name('g_map_info_bubble'); ?>" id="<?php echo $this->get_field_id('g_map_info_bubble'); ?>"><?php echo
            esc_attr($g_map_info_bubble); ?></textarea>
        </p>


    </div>
    <?php
    }
}

