<?php
 
class RevSlider_Widget extends WP_Widget {
	
    public function __construct(){
    	
        // widget actual processes
     	$widget_ops = array('classname' => 'widget_revslider', 'description' => __('Displays a revolution slider on the page',REVSLIDER_TEXTDOMAIN) );
        parent::__construct('rev-slider-widget', __('Revolution Slider',REVSLIDER_TEXTDOMAIN), $widget_ops);
    }
 
    /**
     * 
     * the form
     */
    public function form($instance) {
		try {
            $slider = new RevSlider();
            $arrSliders = $slider->getArrSlidersShort();
        }catch(Exception $e){}            
          
		if(empty($arrSliders))
			echo __("No sliders found, Please create a slider",REVSLIDER_TEXTDOMAIN);
		else{
			
			$field = "rev_slider";
			$fieldPages = "rev_slider_pages";
			$fieldCheck = "rev_slider_homepage";
			$fieldTitle = "rev_slider_title";
			
	    	$sliderID = UniteFunctionsRev::getVal($instance, $field);
	    	$homepage = UniteFunctionsRev::getVal($instance, $fieldCheck);
	    	$pagesValue = UniteFunctionsRev::getVal($instance, $fieldPages);
	    	$title = UniteFunctionsRev::getVal($instance, $fieldTitle);
	    	
			$fieldID = $this->get_field_id( $field );
			$fieldName = $this->get_field_name( $field );
			
			$select = UniteFunctionsRev::getHTMLSelect($arrSliders,$sliderID,'name="'.$fieldName.'" id="'.$fieldID.'"',true);
			
			$fieldID_check = $this->get_field_id( $fieldCheck );
			$fieldName_check = $this->get_field_name( $fieldCheck );
			$checked = "";
			if($homepage == "on")
				$checked = "checked='checked'";

			$fieldPages_ID = $this->get_field_id( $fieldPages );
			$fieldPages_Name = $this->get_field_name( $fieldPages );
			
			$fieldTitle_ID = $this->get_field_id( $fieldTitle );
			$fieldTitle_Name = $this->get_field_name( $fieldTitle );
			
		?>
			<label for="<?php echo $fieldTitle_ID?>"><?php _e("Title",REVSLIDER_TEXTDOMAIN)?>:</label>
			<input type="text" name="<?php echo $fieldTitle_Name?>" id="<?php echo $fieldTitle_ID?>" value="<?php echo $title?>" class="widefat">
			
			<br><br>
			
			<?php _e("Choose Slider",REVSLIDER_TEXTDOMAIN)?>: <?php echo $select?>
			<div style="padding-top:10px;"></div>
			
			<label for="<?php echo $fieldID_check?>"><?php _e("Home Page Only",REVSLIDER_TEXTDOMAIN)?>:</label>
			<input type="checkbox" name="<?php echo $fieldName_check?>" id="<?php echo $fieldID_check?>" <?php echo $checked?> >
			<br><br>
			<label for="<?php echo $fieldPages_ID?>"><?php _e("Pages: (example: 2,10)",REVSLIDER_TEXTDOMAIN)?></label>
			<input type="text" name="<?php echo $fieldPages_Name?>" id="<?php echo $fieldPages_ID?>" value="<?php echo $pagesValue?>">
			
			<div style="padding-top:10px;"></div>
		<?php
		}	//else
		 
    }
 
    /**
     * 
     * update
     */
    public function update($new_instance, $old_instance) {
    	
        return($new_instance);
    }

    
    /**
     * 
     * widget output
     */
    public function widget($args, $instance) {
    	
		$sliderID = UniteFunctionsRev::getVal($instance, "rev_slider");
		$title = UniteFunctionsRev::getVal($instance, "rev_slider_title");
		
		$homepageCheck = UniteFunctionsRev::getVal($instance, "rev_slider_homepage");
		$homepage = "";
		if($homepageCheck == "on")
			$homepage = "homepage";
		
		$pages = UniteFunctionsRev::getVal($instance, "rev_slider_pages");
		if(!empty($pages)){
			if(!empty($homepage))
				$homepage .= ",";
			$homepage .= $pages;
		}
				
		if(empty($sliderID))
			return(false);
			
		//widget output
		$beforeWidget = UniteFunctionsRev::getVal($args, "before_widget");
		$afterWidget = UniteFunctionsRev::getVal($args, "after_widget");
		$beforeTitle = UniteFunctionsRev::getVal($args, "before_title");
		$afterTitle = UniteFunctionsRev::getVal($args, "after_title");
		
		echo $beforeWidget;
		
		if(!empty($title))
			echo $beforeTitle.$title.$afterTitle;
		
		RevSliderOutput::putSlider($sliderID,$homepage);
		
		echo $afterWidget;						
    }
 
}


?>