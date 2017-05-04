
var UniteSettingsRev = new function(){
	
	var arrControls = {};
	var colorPicker;
	
	var t=this;
	
	this.getSettingsObject = function(formID){		
		var obj = new Object();
		var form = document.getElementById(formID);
		var name,value,type,flagUpdate;
		
		//enabling all form items connected to mx
		var len = form.elements.length;
		for(var i=0; i<len; i++){
			var element = form.elements[i];
			
			if(element.name == "##NAME##[]") continue; //ignore dummy from multi text
			
			name = element.name;
			value = element.value;
			
			type = element.type;
			if(jQuery(element).hasClass("wp-editor-area"))
				type = "editor";
			
			//trace(name + " " + type);
			
			flagUpdate = true;
			
			switch(type){
				case "checkbox":
					value = form.elements[i].checked;
				break;
				case "radio":
					if(form.elements[i].checked == false) 
						flagUpdate = false;				
				break;
				case "editor":
					value = tinyMCE.get(name).getContent();
				break;
				case "select-multiple":
					value = jQuery(element).val();
					if(value)
						value = value.toString();
				break;
			}
			
			if(flagUpdate == true && name != undefined){
				if(name.indexOf('[]') > -1){
					name = name.replace('[]', '');
					if(typeof obj[name] !== 'object') obj[name] = [];
					
					obj[name][Object.keys(obj[name]).length] = value;
				}else{
					obj[name] = value;
				}
			}
		}
		return(obj);
	}
	
	/**
	 * on selects change - impiment the hide/show, enabled/disables functionality
	 */
	var onSettingChange = function(){

		var controlValue = this.value.toLowerCase();
		var controlName = this.name;
		
		if(!arrControls[this.name]) return(false);
		
		jQuery(arrControls[this.name]).each(function(){
						
			var childInput = document.getElementById(this.name);
			var childRow = document.getElementById(this.name + "_row");
			var value = this.value.toLowerCase();
			var isChildRadio = (childInput && childInput.tagName == "SPAN" && jQuery(childInput).hasClass("radio_wrapper"));
			
			switch(this.type){
				case "enable":
				case "disable":
					
					if(childInput){		//disable
						if(this.type == "enable" && controlValue != this.value || this.type == "disable" && controlValue == this.value){
							childRow.className = "disabled";
							
							if(childInput){
								childInput.disabled = true;
								childInput.style.color = "";
							}
							
							if(isChildRadio)
								jQuery(childInput).children("input").prop("disabled","disabled").addClass("disabled");							
						}
						else{		//enable
							childRow.className = "";
							
							if(childInput)
								childInput.disabled = false;
							
							if(isChildRadio)
								jQuery(childInput).children("input").prop("disabled","").removeClass("disabled");
							
							//color the input again
							if(jQuery(childInput).hasClass("inputColorPicker")) g_picker.linkTo(childInput);							
		 				}
						
					}
				break;
				case "show":
					if(controlValue == this.value) jQuery(childRow).show();									
					else jQuery(childRow).hide();					
				break;
				case "hide":
					if(controlValue == this.value) jQuery(childRow).hide();									
					else jQuery(childRow).show();
				break;
			}
		});
	}
	
	
	/**
	 * combine controls to one object, and init control events.
	 */
	var initControls = function(){
				
		//combine controls
		for(key in g_settingsObj){
			var obj = g_settingsObj[key];
			
			for(controlKey in obj.controls){
				arrControls[controlKey] = obj.controls[controlKey];				
			}
		}
		
		//init events
		jQuery(".settings_wrapper select").change(onSettingChange);
		jQuery(".settings_wrapper input[type='radio']").change(onSettingChange);
		
	}
	
	
	//init color picker
	var initColorPicker = function(){
		var colorPickerWrapper = jQuery('#divColorPicker');
		
		colorPicker = jQuery.farbtastic('#divColorPicker');
		
		jQuery(".inputColorPicker").focus(function(){
			colorPicker.linkTo(this);
			colorPickerWrapper.show();
			var input = jQuery(this);
			var offset = input.offset();
			
			var offsetView = jQuery("#viewWrapper").offset();
			
			colorPickerWrapper.css({
				"left":offset.left + input.width()+20-offsetView.left,
				"top":offset.top - colorPickerWrapper.height() + 100-offsetView.top
			});
			
			if (jQuery(input.data('linkto'))) {
				
				var oldval = jQuery(this).val();
				jQuery(this).data('int',setInterval(function() {
					if(input.val() != oldval){
						oldval = input.val();
						jQuery('#css_preview').css(input.data('linkto'), oldval);
						jQuery('input[name="css_'+input.data('linkto')+'"]').val(oldval);
					}
				} ,200));
			}
			
		}).blur(function() {
			clearInterval(jQuery(this).data('int'));
		
		}).click(function(){
            
			return(false);	//prevent body click
		}).change(function(){
			colorPicker.linkTo(this);
			colorPicker.setColor(jQuery(this).val());
		});
		
		colorPickerWrapper.click(function(){
			return(false);	//prevent body click
		});
		
		jQuery("body").click(function(){
			colorPickerWrapper.hide();
		});
	}
	
	/**
	 * close all accordion items
	 */
	var closeAllAccordionItems = function(formID){
		jQuery("#"+formID+" .unite-postbox .inside").slideUp("fast");
		jQuery("#"+formID+" .unite-postbox h3").addClass("box_closed");
	}
	
	/**
	 * init side settings accordion - started from php
	 */
	t.initAccordion = function(formID){
		var classClosed = "box_closed";
		jQuery("#"+formID+" .unite-postbox h3").click(function(){
			var handle = jQuery(this);
			
			//open
			if(handle.hasClass(classClosed)){
				closeAllAccordionItems(formID);
				handle.removeClass(classClosed).siblings(".inside").slideDown("fast");
			}else{	//close
				handle.addClass(classClosed).siblings(".inside").slideUp("fast");
			}
			
		});
	}
	
	/**
	 * image search
	 */
	var initImageSearch = function(){
		
		jQuery(".button-image-select").click(function(){
			var settingID = this.id.replace("_button","");
			UniteAdminRev.openAddImageDialog("Choose Image",function(urlImage, imageID){
				//update input:
				jQuery("#"+settingID).val(urlImage);
				
				//update preview image:
				var urlShowImage = UniteAdminRev.getUrlShowImage(imageID,100,70,true);
				jQuery("#" + settingID + "_button_preview").html('<div style="width:100px;height:70px;background:url(\''+urlShowImage+'\'); background-position:center center; background-size:cover;"></div>');
				
			});
		});
		
		jQuery(".button-image-remove").click(function(){
			var settingID = this.id.replace("_button_remove","");
			jQuery("#"+settingID).val('');
			
			jQuery("#" + settingID + "_button_preview").html('');
		});
		
		jQuery(".button-image-select-video").click(function(){
			UniteAdminRev.openAddImageDialog("Choose Image",function(urlImage, imageID){
				
				//update input:
				jQuery("#input_video_preview").val(urlImage);
				
				//update preview image:
				var urlShowImage = UniteAdminRev.getUrlShowImage(imageID,200,150,true);
				jQuery("#video-thumbnail-preview").attr('src', urlShowImage);
				
			});
		});
		
		jQuery(".button-image-remove-video").click(function(){
			jQuery("#input_video_preview").val('');

			if(jQuery('#video_block_vimeo').css('display') != 'none')
				jQuery("#button_vimeo_search").trigger("click");
			
			if(jQuery('#video_block_youtube').css('display') != 'none')
				jQuery("#button_youtube_search").trigger("click");
			
		});
		
	}
	
	
	
	/**
	 * init the settings function, set the tootips on sidebars.
	 */
	var init = function(){
		
		//init tipsy
		jQuery(".list_settings li .setting_text").tipsy({
			gravity:"e",
	        delayIn: 70
		});
		
		jQuery(".tipsy_enabled_top").tipsy({
			gravity:"s",
	        delayIn: 70
		});
		
		jQuery(".button-primary").tipsy({
			gravity:"s",
	        delayIn: 70
		});
		
		//init controls
		initControls();
		
		initColorPicker();
		
		initImageSearch();
		
		//init checklist
		jQuery(".settings_wrapper .input_checklist").each(function(){
			var select = jQuery(this);
			var ominWidth = select.data("minwidth");
						
			if (ominWidth==undefined) ominWidth="none"
				
			select.dropdownchecklist({
					zIndex:1000,
					minWidth:ominWidth,
					onItemClick: function(checkbox,selector) {

									for (var i=0;i<20;i++) 
										if (checkbox.val()=="notselectable"+i) {
											//console.log(checkbox.val());
											checkbox.attr("checked",false);
										}
									
					}
				});
			
			select.parent().find('input').each(function() {
				var option = jQuery(this);

				for (var i=0;i<20;i++) 
					if (option.val()=="notselectable"+i) option.parent().addClass("dropdowntitleoption");
			})

		});
		
	}
	
	
	
	//call "constructor"
	jQuery(document).ready(function(){
		init();
	});
	
} // UniteSettings class end


