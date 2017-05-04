<?php
require_once('config.php');
 
// check for rights
if ( !is_user_logged_in() || !current_user_can('edit_posts') )
    wp_die(__("You are not allowed to be here",'highthemes'));
global  $ht_options;
?>
<!DOCTYPE html>
<html>
<head>
<title></title>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/includes/shortcodes/tinymce/tinymce.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/styles/icons.css">
<script language="javascript" type="text/javascript" src="<?php echo get_template_directory_uri() ?>/includes/shortcodes/tinymce/tinymce.js"></script>    

<script language="javascript" type="text/javascript" src="<?php echo get_template_directory_uri() ?>/scripts/jquery.tools.min.js"></script>    
<script language="javascript" type="text/javascript" src="<?php echo get_template_directory_uri() ?>/includes/shortcodes/tinymce/tinymce_custom.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo get_template_directory_uri() ?>/framework/assets/js/custom.js"></script>    

</head>

<body>
<div id="shortcode-content">

<div class="clearfix tab-set tab-horizontal tab-left">
    <ul class="tab-titles">
        <li data-id="general" class="current"><?php _e("General", "highthemes");?></li>
        <li data-id="icon"><?php _e("Icon", "highthemes");?></li>
        <li data-id="button"><?php _e("Button", "highthemes");?></li>
    </ul>
    <div class="tab-content clearfix" id="general">
        <label for="style_shortcode"><?php _e('Select Custom Shortcode:','highthemes'); ?></label>
        <div class="field-content">
            <select id="style_shortcode" name="style_shortcode" style="width: 200px" title="<?php echo $ht_options['accent_color'];?>">
            <option value="0"><?php _e('No Style','highthemes'); ?></option>
            <optgroup label="<?php _e('Misc','highthemes'); ?>">
                <option value="ht_code_sc"><?php _e('Code','highthemes'); ?></option>
                <option value="ht_fancy_title"><?php _e('Fancy Title','highthemes'); ?></option>
                <option value="ht_highlight"><?php _e('Highlight','highthemes'); ?></option>
                <option value="ht_lightbox"><?php _e('Image/Video With Lightbox Effect','highthemes'); ?></option>
                <option value="ht_pre"><?php _e('Pre','highthemes'); ?></option>
                <option value="ht_tooltip"><?php _e('Tooltip','highthemes'); ?></option>
                <option value="ht_video"><?php _e('Video','highthemes'); ?></option>
            </optgroup>


            <optgroup label="<?php _e('Lists', 'highthemes');?>">
                <option value="ht_dashed_list"><?php _e('Dashed List','highthemes'); ?></option>
                <option value="ht_dotted_list"><?php _e('Dotted List','highthemes'); ?></option>
                <option value="ht_icon_list"><?php _e('Icon List','highthemes'); ?></option>
                <option value="ht_line_list"><?php _e('Line list','highthemes'); ?></option>
            </optgroup>

            <optgroup label="<?php _e('Pricing Table','highthemes'); ?>">
                <option value="ht_pricing_2col"><?php _e('Pricing Table 2 Columns','highthemes'); ?></option>
                <option value="ht_pricing_3col"><?php _e('Pricing Table 3 Columns','highthemes'); ?></option>
                <option value="ht_pricing_4col"><?php _e('Pricing Table 4 Columns','highthemes'); ?></option>
            </optgroup>

            <optgroup label="<?php _e('DropCap','highthemes'); ?>">
                <option value="ht_dropcap_with_background"><?php _e('Drop Cap With Background','highthemes'); ?></option>
                <option value="ht_dropcap_text_only"><?php _e('Drop Cap Text Only','highthemes'); ?></option>
                <option value="ht_dropcap_border_bordered"><?php _e('Drop Cap Bordered','highthemes'); ?></option>
            </optgroup>
            
            <optgroup label="<?php _e('Callout / Pullquote','highthemes'); ?>">
                <option value="ht_callout_left"><?php _e('Left Aligned','highthemes'); ?></option>
                <option value="ht_callout_right"><?php _e('Right Aligned','highthemes'); ?></option>
                <option value="ht_pullquote"><?php _e('Pullquote','highthemes'); ?></option>
            </optgroup>
            </select>
        </div>
    </div> <!-- #general -->

    <div class="tab-content clearfix" id="icon">
            <label for="icon_class"><?php _e('Select the icon','highthemes');?></label>
            <div class="field-content">
               <fieldset>
                   <legend><?php _e("Icons",'highthemes'); ?></legend>
                   <input type="hidden" id="icon_class" value="icon">
                   <div class="panel-icon">
                       <?php
                       $icons = ht_font_awesome_list();
                       foreach($icons as $icon) {
                            $icon = trim($icon);
                            echo '<i title="'.$icon.'" class="'.$icon.'"></i>' ."\n";
                        }
                        ?>
                    </div>
               </fieldset> 
            </div>

            <label for="icon_color"><?php _e('Icon color','highthemes');?></label>
            <div class="field-content">
            <select type="text" id="icon_color" name="icon_color" >
                <option value="accent"><?php _e('Accent','highthemes');?></option>
                <option value="#5486da"><?php _e('Blueberry','highthemes');?></option>
                <option value="#9AD147"><?php _e('Android Green','highthemes');?></option>
                <option value="#5200FF"><?php _e('Blue','highthemes');?></option>
                <option value="#09F"><?php _e('Azure','highthemes');?></option>
                <option value="#F00"><?php _e('Red','highthemes');?></option>
                <option value="#2FEFF7"><?php _e('Aqua','highthemes');?></option>
                <option value="#A58080"><?php _e('Blast-off Bronze','highthemes');?></option>
                <option value="#809FA5"><?php _e('Gray','highthemes');?></option>
                <option value="#3DE4B5"><?php _e('Caribbean green','highthemes');?></option>
                <option value="custom"><?php _e('Custom','highthemes');?></option>
            </select>
            </div>

            <label for="icon_custom_color"><?php _e('Icon Custom Color','highthemes');?></label>
            <div class="field-content">
            <input class="color-field" value="#333333" type="text" id="icon_custom_color" name="icon_custom_color" size="20" />
                <div class="colorpicker"></div>
            </div>

            <label for="icon_tooltip"><?php _e('Icon Tooltip','highthemes');?></label>
            <div class="field-content">
                <input type="text" id="icon_tooltip" name="icon_tooltip" >
            </div>

            <label for="icon_link"><?php _e('Icon Link','highthemes');?></label>
            <div class="field-content">
                <input type="text" id="icon_link" name="icon_link" >
            </div>

            <label for="icon_target"><?php _e('Open link in new tab?','highthemes');?></label>
            <div class="field-content">
                <input type="checkbox" id="icon_target" name="icon_target" >
            </div>
    </div>
    <!-- #icon -->

    <!-- #button -->
    <div class="tab-content clearfix" id="button">
            <label for="button_title"><?php _e('Text','highthemes');?></label>
            <div class="field-content">
                <input type="text" id="button_title" name="button_title" >
            </div>

            <label for="button_color"><?php _e('Color','highthemes');?></label>
            <div class="field-content">
                <select id="button_color" name="button_color" >
                    <option value="accent"><?php _e("Accent", "highthemes"); ?></option>
                    <option value=""><?php _e("Blueberry","highthemes"); ?></option>
                    <option value="color2"><?php _e("Android green","highthemes"); ?></option>
                    <option value="color3"><?php _e("Blue","highthemes"); ?></option>
                    <option value="color4"><?php _e("Azure","highthemes"); ?></option>
                    <option value="color5"><?php _e("Red","highthemes"); ?></option>
                    <option value="color6"><?php _e("Aqua","highthemes"); ?></option>
                    <option value="color7"><?php _e("Blast-off bronze","highthemes"); ?></option>
                    <option value="color8"><?php _e("Gray","highthemes"); ?></option>
                    <option value="color9"><?php _e("Caribbean green","highthemes"); ?></option>
                    <option value="custom"><?php _e("Custom","highthemes"); ?></option>
                </select>
            </div>

            <label for="button_custom_color"><?php _e('Button Custom Color','highthemes');?></label>
            <div class="field-content">
                <input class="color-field" value="#eeeeee" type="text" id="button_custom_color" name="button_custom_color" size="20" />
                <div class="colorpicker"></div>
            </div>

            <label for="button_type"><?php _e('Type','highthemes');?></label>
            <div class="field-content">
                <select type="text" id="button_type" name="button_type" >
                    <option value="normal"><?php _e('Normal','highthemes');?></option>
                    <option value="fancy"><?php _e('Fancy','highthemes');?></option>
                </select>
            </div>

            <label for="button_size"><?php _e('Size','highthemes');?></label>
            <div class="field-content">
                <select id="button_size" name="button_size">
                    <option value="small"><?php _e("Small", "highthemes"); ?></option>
                    <option value="medium"><?php _e("Medium","highthemes"); ?></option>
                    <option value="large"><?php _e("Large","highthemes"); ?></option>
                </select>
            </div>

            <label for="button_icon_name"><?php _e('Select an icon (Optional)','highthemes');?></label>
            <div class="field-content">
               <fieldset>
                   <legend><?php _e("Icons",'highthemes'); ?></legend>
                   <input type="hidden" id="icon_class" value="">
                   <div class="panel-icon">
                       <?php
                       $icons = ht_font_awesome_list();
                       foreach($icons as $icon) {
                            $icon = trim($icon);
                            echo '<i title="'.$icon.'" class="'.$icon.'"></i>' ."\n";
                        }
                        ?>
                    </div>
               </fieldset> 
            </div>

            <label for="button_link"><?php _e('Link','highthemes');?></label>
            <div class="field-content">
                <input type="text" id="button_link" name="button_link" >
            </div>

            <label for="button_target"><?php _e('Target','highthemes');?></label>
            <div class="field-content">
                <input type="checkbox" id="button_target" name="button_target" >
            </div>
    </div>
    <!-- #button -->

</div> <!-- .tab-horizontal -->


<!-- <form onsubmit="insertLink();return false;" action="#"> -->
<form name="ht_shortcodes" action="#">
<div class="mceActionPanel">
    <div style="float: left">
        <p class="submit">
            <input onClick="InsertShortcodes();" type="button" id="ht-submit" class="button-primary" value="Insert Shortcode" name="submit" />
        </p>
    </div>
    
</div>
</form>
</div>
</body>
</html>