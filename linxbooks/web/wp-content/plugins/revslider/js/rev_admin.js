var RevSliderAdmin = new function(){
	
		var t = this;
		var g_postTypesWithCats = null;
		
		/**
		 * init "slider" view functionality
		 */
		var initSaveSliderButton = function(ajaxAction){
			
			jQuery("#button_save_slider").click(function(){
					
					//collect data
					var data = {
							params: UniteSettingsRev.getSettingsObject("form_slider_params"),
							main: UniteSettingsRev.getSettingsObject("form_slider_main"),
							template: jQuery('#revslider_template').val() //determinate if we are a template slider or not
						};
						
					//add slider id to the data
					if(ajaxAction == "update_slider"){
						data.sliderid = jQuery("#sliderid").val();
						data.params.custom_css = rev_cm_custom_css.getValue();
						data.params.custom_javascript = rev_cm_custom_js.getValue();
						
						//some ajax beautifyer
						UniteAdminRev.setAjaxLoaderID("loader_update");
						UniteAdminRev.setAjaxHideButtonID("button_save_slider");
						UniteAdminRev.setSuccessMessageID("update_slider_success");
					}
					
					UniteAdminRev.ajaxRequest(ajaxAction ,data);
			});
		}

		
		t.initLayerPreview = function(){
			//preview slider actions
			jQuery("#button_preview_slider-tb").click(function(){
				var sliderID = jQuery("#sliderid").val();
				
				openPreviewSliderDialog(sliderID);
			});
		}
		
		
		/**
		 * update shortcode from alias value.
		 */
		var updateShortcode = function(){
			var alias = jQuery("#alias").val();			
			var shortcode = "[rev_slider "+alias+"]";
			if(alias == "")
				shortcode = "-- wrong alias -- ";
			jQuery("#shortcode").val(shortcode);
		}
		
		/**
		 * change fields of the slider view
		 */
		var enableSliderViewResponsitiveFields = function(enableRes,enableAuto,enableFullScreen,textMode){
			jQuery('input[name="width"]').attr('disabled', false);
			jQuery('input[name="height"]').attr('disabled', false);
			
			if(textMode == 'normal' || textMode == 'full'){
				//jQuery('input[name="width"]').attr('disabled', false);
				//jQuery('input[name="height"]').attr('disabled', false);
				jQuery('#layout-preshow').removeClass('lp-fullscreenalign');
			}else{
				//jQuery('input[name="width"]').attr('disabled', true);
				//jQuery('input[name="height"]').attr('disabled', true);
			}
			
			//enable / disable responsitive fields
			if(enableRes){	
				jQuery("#responsitive_row").removeClass("disabled");
				jQuery("#responsitive_row input").prop("disabled","");
			}else{
				jQuery("#responsitive_row").addClass("disabled");
				jQuery("#responsitive_row input").prop("disabled","disabled");
			}
			
			if(enableAuto){
				jQuery("#auto_height_row").removeClass("disabled");
				jQuery('#layout-preshow').removeClass('lp-fullscreenalign');
			}else{
				jQuery("#auto_height_row").addClass("disabled");
			}
			
			if(enableFullScreen){
				if(jQuery('input[name="full_screen_align_force"]:checked').val() == 'on') jQuery('#layout-preshow').addClass('lp-fullscreenalign');
				
				jQuery("#full_screen_align_force_row").removeClass("disabled");
				jQuery("#fullscreen_offset_container_row").removeClass("disabled");
				
			}else{
				jQuery("#full_screen_align_force_row").addClass("disabled");
				jQuery("#fullscreen_offset_container_row").addClass("disabled");
			}
			
			if(enableFullScreen || enableAuto){
				jQuery("#force_full_width_row").removeClass("disabled");
			}else{
				jQuery("#force_full_width_row").addClass("disabled");
			}
			
			var textWidth = jQuery("#cellWidth").data("text"+textMode);
			var textHeight = jQuery("#cellHeight").data("text"+textMode);
			
			jQuery('#layout-preshow').removeClass('lp-fixed');
			jQuery('#layout-preshow').removeClass('lp-custom'); //responsitive
			jQuery('#layout-preshow').removeClass('lp-autoresponsive'); //fullwidth
			jQuery('#layout-preshow').removeClass('lp-fullscreen');
			
			if(enableRes){
				jQuery('#layout-preshow').addClass('lp-custom');
			}else if(enableAuto){
				jQuery('#layout-preshow').addClass('lp-autoresponsive');
			}else if(enableFullScreen){
				jQuery('#layout-preshow').addClass('lp-fullscreen');
			}else{
				jQuery('#layout-preshow').addClass('lp-fixed');
			}
			
			jQuery("#cellWidth").html(textWidth);
			jQuery("#cellHeight").html(textHeight);
		}
		
		
		/**
		 * init slider view custom controls fields.
		 */
		var initSliderViewCustomControls = function(){
			
			//fixed
			jQuery("#slider_type_1").click(function(){
				enableSliderViewResponsitiveFields(false,false,false,"normal");
			});
			
			//responsitive
			jQuery("#slider_type_2").click(function(){
				enableSliderViewResponsitiveFields(true,false,false,"normal");
			});
			
			//full width
			jQuery("#slider_type_3").click(function(){
				enableSliderViewResponsitiveFields(false,true,false,"full");
			});
			
			//full screen
			jQuery("#slider_type_4").click(function(){
				enableSliderViewResponsitiveFields(false,false,true,"screen");
			});
			
			jQuery('input[name="full_screen_align_force"]').click(function(){
				if(jQuery(this).val() == 'on'){
					//jQuery('input[name="width"]').attr('disabled', true);
					//jQuery('input[name="height"]').attr('disabled', true);
					jQuery('#layout-preshow').addClass('lp-fullscreenalign');
				}else{
					//jQuery('input[name="width"]').attr('disabled', false);
					//jQuery('input[name="height"]').attr('disabled', false);
					jQuery('#layout-preshow').removeClass('lp-fullscreenalign');
				}
			});
			
			jQuery('input[name="auto_height"]').click(function(){
				if(jQuery(this).val() == "on")
					jQuery('#layout-preshow').addClass('lp-autoheight');
				else
					jQuery('#layout-preshow').removeClass('lp-autoheight');
					
			});
			
			jQuery('input[name="force_full_width"]').click(function(){
				if(jQuery(this).val() == "on")
					jQuery('#layout-preshow').addClass('lp-fullwidth');
				else
					jQuery('#layout-preshow').removeClass('lp-fullwidth');
					
			});
			
			jQuery('input[name="full_screen_align_force"]:checked').click();
			jQuery('input[name="auto_height"]:checked').click();
			jQuery('input[name="force_full_width"]:checked').click();
			
		}
		
		
		/**
		 * 
		 * update category by post types
		 */
		var updateCatByPostTypes = function(typeSettingName,catSettingName){

			jQuery("#"+typeSettingName).change(function(){
				var arrTypes = jQuery(this).val();
				
				//replace the categories in multi select
				jQuery("#"+catSettingName).empty();
				jQuery(arrTypes).each(function(index,postType){
					var objCats = g_postTypesWithCats[postType];
					
					var flagFirst = true;
					for(catIndex in objCats){
						var catTitle = objCats[catIndex];
						//add option to cats select
						var opt = new Option(catTitle, catIndex);						
						
						if(catIndex.indexOf("option_disabled") == 0)
							jQuery(opt).prop("disabled","disabled");
						else{
							//select first option:
							if(flagFirst == true){
								jQuery(opt).prop("selected","selected");
								flagFirst = false;
							}
						}
						
						jQuery("#"+catSettingName).append(opt);
						
					}
					
				});					
			});
		}
		
		
		/**
		 * init common functionality of the slider view. 
		 */	
		var initSliderViewCommon = function(){
			initShortcode();
			initSliderViewCustomControls();
			g_postTypesWithCats = jQuery.parseJSON(g_jsonTaxWithCats);
			
			
			updateCatByPostTypes("post_types","post_category");
			
			jQuery("input[name='source_type']").click(function(){ //check for post click
				if(jQuery(this).val() == 'posts'){ //jQuery(this).val() == 'specific_posts' || 
					jQuery('.settings_panel_right').hide();
					jQuery('#toolbox_wrapper').hide();
					
					//hide more elements
					jQuery('#slider_type_row').hide();
					jQuery('#slider_type_row').prev().hide();
					jQuery('#fullscreen_offset_container_row').hide();
					jQuery('#full_screen_align_force_row').hide();
					jQuery('#slider_size_row').hide();
					jQuery('#auto_height_row').hide();
					jQuery('#force_full_width_row').hide();
					jQuery('#responsitive_row').hide();
					jQuery('#responsitive_row').next().hide();
					jQuery('#layout-preshow').hide();
					
				}else{
					jQuery('.settings_panel_right').show();
					jQuery('#toolbox_wrapper').show();
					
					//show more elements
					jQuery('#slider_type_row').show();
					jQuery('#slider_type_row').prev().show();
					jQuery('#fullscreen_offset_container_row').show();
					jQuery('#full_screen_align_force_row').show();
					jQuery('#slider_size_row').show();
					jQuery('#auto_height_row').show();
					jQuery('#force_full_width_row').show();
					jQuery('#responsitive_row').show();
					jQuery('#responsitive_row').next().show();
					jQuery('#layout-preshow').show();
				}
			});
			
			if(jQuery("#source_type_1").is(':checked')){
				jQuery('.settings_panel_right').hide();
				jQuery('#toolbox_wrapper').hide();

				//hide more elements
				jQuery('#slider_type_row').hide();
				jQuery('#slider_type_row').prev().hide();
				jQuery('#fullscreen_offset_container_row').hide();
				jQuery('#full_screen_align_force_row').hide();
				jQuery('#slider_size_row').hide();
				jQuery('#auto_height_row').hide();
				jQuery('#force_full_width_row').hide();
				jQuery('#responsitive_row').hide();
				jQuery('#responsitive_row').next().hide();
				jQuery('#layout-preshow').hide();
			}
			
			jQuery(document).ready(function(){
				jQuery('input[name="slider_type"]:checked').click();
				
				jQuery('select[name="navigation_style"]').change(function(){
					switch(jQuery(this).val()){
						case 'preview1':
						//case 'preview2':
						case 'preview3':
						case 'preview4':
							jQuery('#leftarrow_align_hor_row').hide();
							jQuery('#leftarrow_align_vert_row').hide();
							jQuery('#leftarrow_offset_hor_row').hide();
							jQuery('#leftarrow_offset_vert_row').hide();
							jQuery('#rightarrow_align_hor_row').hide();
							jQuery('#rightarrow_align_vert_row').hide();
							jQuery('#rightarrow_offset_hor_row').hide();
							jQuery('#rightarrow_offset_vert_row').hide();
							jQuery('#navigation_arrows_row').hide();
						break;
						default:
							jQuery('#leftarrow_align_hor_row').show();
							jQuery('#leftarrow_align_vert_row').show();
							jQuery('#leftarrow_offset_hor_row').show();
							jQuery('#leftarrow_offset_vert_row').show();
							jQuery('#rightarrow_align_hor_row').show();
							jQuery('#rightarrow_align_vert_row').show();
							jQuery('#rightarrow_offset_hor_row').show();
							jQuery('#rightarrow_offset_vert_row').show();
							jQuery('#navigation_arrows_row').show();
						break;
					}
				});
				jQuery('select[name="navigation_style"] option:selected').change();
			});
			
		
			/**
			 * Set bullet type and navigation arrows to none if loop_slide is set to off
			 */
			jQuery('body').on('click', 'input[name="loop_slide"]', function(){

				if(jQuery(this).val() == 'noloop'){
					jQuery('#navigaion_type option[value="none"]').attr('selected', true);
					jQuery('#navigation_arrows option[value="none"]').attr('selected', true);
					jQuery('#navigaion_type').change();
					jQuery('#navigation_arrows').change();
					
					UniteAdminRev.showInfo({type: 'info', hideon: '', event: '', content: 'Navigation Bullets and Arrows are now set to none.', hidedelay: 3});
				}
			});
		}
		
		
		/**
		Init Slider Spinner Admin View
		**/				
		this.initSpinnerAdmin = function() {
			jQuery('#use_spinner_row').parent().prepend('<div id="spinner_preview"></div>');
			var spin = jQuery('#spinner_preview');
			var sel = jQuery('#use_spinner');	
			var col = jQuery('#spinner_color');					
			var oldcol = col.val();
			resetSpin(spin);		 
			
			sel.on("change",function() {
				resetSpin(spin,true);
			});	
			setInterval(function() {
				if (oldcol!=col.val()) {
					spinnerColorChange();	
					oldocl=col.val();
				}												
			},300)								
		}
		/**
		CHANGE SPINNER COLOR ON CALL BACK
		**/
		function spinnerColorChange() {
				var col = jQuery('#spinner_color').val();	
				var sel = jQuery('#use_spinner');
				if (sel.val()==0 || sel.val()==5) col ="#ffffff";
				
				var spin = jQuery('#spinner_preview .tp-loader.tp-demo');
				if (spin.hasClass("spinner0") || spin.hasClass("spinner1") || spin.hasClass("spinner2")) {
					spin.css({'backgroundColor':col});
				} else {
					spin.find('div').css({'backgroundColor':col});
				}
		};
		
		/**
		RESET SPINNER DEMO
		**/
		function resetSpin(spin,remove) {
				var sel = jQuery('#use_spinner');
				spin.find('.tp-loader').remove();
				spin.append('<div class="tp-loader tp-demo">'+
													  		'<div class="dot1"></div>'+
													  	    '<div class="dot2"></div>'+
													  	    '<div class="bounce1"></div>'+
															'<div class="bounce2"></div>'+
															'<div class="bounce3"></div>'+
														 '</div>');															 															 
				spin.find('.tp-demo').addClass("spinner"+sel.val());	
				if (sel.val()=='-1' || sel.val()==0 || sel.val()==5) {
					//jQuery('#spinner_color').val("#ffffff");
					jQuery('#spinner_color_row').css({display:"none"});
				} else {
					jQuery('#spinner_color_row').css({display:"block"});
				}
				spinnerColorChange();
				
		};
		
		/**
		 * init "slider->add" view.
		 */
		this.initAddSliderView = function(){
			
			initSliderViewCommon();
			
			jQuery("#title").focus();
			initSaveSliderButton("create_slider");
			
			enableSliderViewResponsitiveFields(false,false,false,"normal"); //show grid settings for fixed
			
			jQuery("#reset_slide_button_row").parent().parent().parent().hide();
			
			
			this.initSpinnerAdmin();
		}
		
		/**
		 * init "slider->template" view.
		 */
		this.initSliderViewTemplate = function(){
			
			jQuery('#source_type_3').click(); //set gallery
			jQuery('#source_type_row').hide(); //hide all Source Types
			jQuery('#source_type_row').prev().hide(); //hide the pre HR row
			
			jQuery('#shortcode_row').hide(); //hide the shortcode
			//jQuery('#alias_row').hide(); //hide the alias
			
			jQuery('#create_slider_text').text('Create Template'); //change text to template
			
		}
		
		
		/**
		 * init "slider->edit" view.
		 */		
		this.initEditSliderView = function(){
			
			initSliderViewCommon();
			
			initSaveSliderButton("update_slider");			
			
			//delete slider action
			jQuery("#button_delete_slider").click(function(){
				
				if(confirm("Do you really want to delete '"+jQuery("#title").val()+"' ?") == false)
					return(true);
				
				var data = {sliderid: jQuery("#sliderid").val()}
				
				UniteAdminRev.ajaxRequest("delete_slider" ,data);
			});
			

			//api inputs functionality:
			jQuery("#api_wrapper .api-input").click(function(){
				jQuery(this).select().focus();
			});
			
			//api button functions:
			jQuery("#link_show_api").click(function(){
				jQuery("#api_wrapper").show();
				jQuery("#link_show_api").addClass("button-selected");
				
				jQuery("#toolbox_wrapper").hide();
				jQuery("#link_show_toolbox").removeClass("button-selected");
			});
			
			jQuery("#link_show_toolbox").click(function(){
				jQuery("#toolbox_wrapper").show();
				jQuery("#link_show_toolbox").addClass("button-selected");
				
				jQuery("#api_wrapper").hide();
				jQuery("#link_show_api").removeClass("button-selected");
			});

			
			//export slider action
			jQuery("#button_export_slider").click(function(){
				var sliderID = jQuery("#sliderid").val();
				var useDummy = jQuery('input[name="export_dummy_images"]').is(':checked');
				var urlAjaxExport = ajaxurl+"?action="+g_uniteDirPlagin+"_ajax_action&client_action=export_slider&dummy="+useDummy+"&nonce=" + g_revNonce;
				urlAjaxExport += "&sliderid=" + sliderID;
				location.href = urlAjaxExport;
			});
			
			//preview slider actions
			jQuery("#button_preview_slider").click(function(){
				var sliderID = jQuery("#sliderid").val();
				openPreviewSliderDialog(sliderID);
			});
			
			//replace url
			jQuery("#button_replace_url").click(function(){
				if(confirm("Are you sure to replace the urls?") == false)
					return(false);
				
				var data = {
						sliderid: jQuery("#sliderid").val(),
						url_from:jQuery("#replace_url_from").val(),
						url_to:jQuery("#replace_url_to").val()
					};
				
				//some ajax beautifyer
				UniteAdminRev.setAjaxLoaderID("loader_replace_url");
				UniteAdminRev.setAjaxHideButtonID("button_replace_url");
				UniteAdminRev.setSuccessMessageID("replace_url_success");
				
				UniteAdminRev.ajaxRequest("replace_image_urls" ,data);
			});
			
			jQuery('input[name="slider_type"]').each(function(){ if(jQuery(this).is(':checked')) jQuery(this).click(); }); //show grid settings for choosen setting
			
			
			jQuery('#reset_slide_button').click(function(){
				if(confirm("Set selected settings on all Slides of this Slider? (This will be saved immediately)") == false)
					return(false);
					
				var data = {
						sliderid: jQuery("#sliderid").val(),
						reset_transitions:jQuery("#reset_transitions").val(),
						reset_transition_duration:jQuery("#reset_transition_duration").val()
					};
					
				//some ajax beautifyer
				//UniteAdminRev.setAjaxLoaderID("reset_slide_loader");
				UniteAdminRev.setAjaxHideButtonID("reset_slide_button");
				//UniteAdminRev.setSuccessMessageID("reset_slide_success");
				
				UniteAdminRev.ajaxRequest("reset_slide_settings" ,data);
			});
			
			jQuery('#reset_transitions option')[0].checked = true;
			jQuery('#reset_transition_duration').val(0);
			
			
			this.initSpinnerAdmin();
		}
		
		
		/**
		 * init shortcode functionality in the slider new and slider edit views.
		 */
		var initShortcode = function(){
			
			//select shortcode text when click on it.
			jQuery("#shortcode").focus(function(){				
				this.select();
			});
			jQuery("#shortcode").click(function(){				
				this.select();
			});
			
			//update shortcode
			jQuery("#alias").change(function(){
				updateShortcode();
			});

			jQuery("#alias").keyup(function(){
				updateShortcode();
			});
		}
		
		
		/**
		 * update slides order
		 */
		var updateSlidesOrder = function(sliderID){
			var arrSlideHtmlIDs = jQuery( "#list_slides" ).sortable("toArray");
			
			//get slide id's from html (li) id's
			var arrIDs = [];
			var orderCounter = 0;
			jQuery(arrSlideHtmlIDs).each(function(index,value){
				var slideID = value.replace("slidelist_item_","");
				arrIDs.push(slideID);
				
				//update order visually
				orderCounter++;
				jQuery("#slidelist_item_"+slideID+" .order-text").text(orderCounter);
			});
			
			//save order
			var data = {arrIDs:arrIDs,sliderID:sliderID};
			
			jQuery("#saving_indicator").show();
			UniteAdminRev.ajaxRequest("update_slides_order" ,data,function(){
				jQuery("#saving_indicator").hide();
			});
			
			jQuery("#select_sortby").val("menu_order");
		}
		
		
		/**
		 * init "sliders list" view 
		 */
		this.initSlidersListView = function(){
			
			//import slide dialog
			jQuery("#button_import_slider").click(function(){
				
				jQuery("#dialog_import_slider").dialog({
					modal:true,
					resizable:false,
					width:600,
					height:350,
					closeOnEscape:true,
					dialogClass:"tpdialogs",
					buttons:{
					"Close":function(){
						jQuery(this).dialog("close");
					}
				},					
				});	//dialog end
				
			});
			
			jQuery(".button_delete_slider").click(function(){
				
				var sliderID = this.id.replace("button_delete_","");
				var sliderTitle = jQuery("#slider_title_"+sliderID).text(); 
				if(confirm("Do you really want to delete '"+sliderTitle+"' ?") == false)
					return(false);
				
				UniteAdminRev.ajaxRequest("delete_slider" ,{sliderid:sliderID});
			});
			
			//duplicate slider action
			jQuery(".button_duplicate_slider").click(function(){
				var sliderID = this.id.replace("button_duplicate_","");
				UniteAdminRev.ajaxRequest("duplicate_slider" ,{sliderid:sliderID});
			});
		
			//preview slider action
			jQuery(".button_slider_preview").click(function(){
				
				var sliderID = this.id.replace("button_preview_","");
				
				openPreviewSliderDialog(sliderID);
			});
			
			//export slider action on slider overview
			jQuery(".export_slider_overview").click(function(){

				var sliderID = this.id.replace("export_slider_","");
				var useDummy = false;//jQuery('input[name="export_dummy_images"]').is(':checked');
				var urlAjaxExport = ajaxurl+"?action="+g_uniteDirPlagin+"_ajax_action&client_action=export_slider&dummy="+useDummy+"&nonce=" + g_revNonce;
				urlAjaxExport += "&sliderid=" + sliderID;
				location.href = urlAjaxExport;
			});
			
			
			jQuery(".export_slider_standalone").click(function(){
			
				var sliderID = this.id.replace("export_slider_standalone_","");
				
				jQuery("#dialog_preview_sliders").dialog({
					modal:true,
					resizable:true,
					minWidth:1100,
					minHeight:500,
					height:800,
					closeOnEscape:true,
					dialogClass:"tpdialogs",
					buttons:{
						"Close":function(){
							jQuery(this).dialog("close");
						}
					},
					open:function(event,ui){
						var form1 = jQuery("#form_preview")[0];
						jQuery("#preview_sliderid").val(sliderID);
						jQuery("#preview_slider_nonce").val(g_revNonce);
						jQuery("#preview_slider_markup").val('true');
						form1.action = g_urlAjaxActions;
						form1.submit();
					},
					close:function(){
						var form1 = jQuery("#form_preview")[0];
						jQuery("#preview_sliderid").val("empty_output");
						jQuery("#preview_slider_markup").val('false');
						form1.action = g_urlAjaxActions;
						form1.submit();
					}
					
				});	
			});
		}
		
		/**
		 * open preview slider dialog
		 */
		var openPreviewSliderDialog = function(sliderID){
			
			jQuery("#dialog_preview_sliders").dialog({
				modal:true,
				resizable:false,
				minWidth:1100,
				minHeight:500,
				closeOnEscape:true,
				dialogClass:"tpdialogs",
				buttons:{
					"Close":function(){
						jQuery(this).dialog("close");
					}
				},
				open:function(event,ui){
					var form1 = jQuery("#form_preview")[0];
					jQuery("#preview_sliderid").val(sliderID);
					jQuery("#preview_slider_markup").val('false');
					jQuery("#preview_slider_nonce").val(g_revNonce);
					form1.action = g_urlAjaxActions;
					form1.submit();
				},
				close:function(){
					var form1 = jQuery("#form_preview")[0];
					jQuery("#preview_sliderid").val("empty_output");
					jQuery("#preview_slider_markup").val('false');
					form1.action = g_urlAjaxActions;
					form1.submit();
				}
				
			});			
		}
		
		/**
		 * get language array from the language list
		 */
		var getLangsFromLangList = function(objList){
			var arrLangs = [];
			objList.find(".icon_slide_lang").each(function(){
				var lang = jQuery(this).data("lang");
				arrLangs.push(lang);
			});
			
			return(arrLangs);
		}
		
		
		/**
		 * filter langs float menu by the list of icons
		 * show only languages in the float menu that not exists in the icons list
		 * return number of available languages
		 */
		var filterFloatMenuByListIcons = function(objList,operation){
			var arrLangs = getLangsFromLangList(objList);
			var numIcons = 0;
			
			jQuery("#langs_float_wrapper li.item_lang").each(function(){
				var objItem = jQuery(this);
				var lang = objItem.data("lang");
				var found = jQuery.inArray(lang,arrLangs);
				
				if(operation != "add")
					jQuery("#langs_float_wrapper li.operation_sap").hide();
								
				if(jQuery.inArray(lang,arrLangs) == -1){
					numIcons++;
					objItem.show();
					if(operation != "add")
						jQuery("#langs_float_wrapper li.operation_sap").show();
				}
				else
					objItem.hide();
			});
			
			return(numIcons);
		}
		
		
		/**
		 * 
		 * init slides view posts related functions
		 */
		t.initSlidesListViewPosts = function(sliderID){
			
			initSlideListGlobals(sliderID);
			
			//init sortby
			jQuery("#select_sortby").change(function(){
				jQuery("#slides_top_loader").show();
				var data = {};
				data.sliderID = sliderID;
				data.sortby = jQuery(this).val();
				UniteAdminRev.ajaxRequest("update_posts_sortby" ,data,function(){
					jQuery("#slides_top_loader").html("Updated, reloading page...");
					location.reload(true);
				});
			});
			
			// delete single slide
			jQuery(".button_delete_slide").click(function(){
				var postID = jQuery(this).data("slideid");
				var data = {slideID:postID,sliderID:sliderID};
				
				if(confirm(g_messageDeleteSlide) == false)
					return(false);
				
				UniteAdminRev.ajaxRequest("delete_slide" ,data);
			});
			
		}
		
		
		/**
		 * init slide list global functions
		 */
		var initSlideListGlobals = function(sliderID){
			
			//set the slides sortable, init save order
			jQuery("#list_slides").sortable({
					axis:"y",
					handle:'.col-handle',
					update:function(){updateSlidesOrder(sliderID)}
			});
			
			
			//publish / unpublish item
			jQuery("#list_slides .icon_state").click(function(){
				var objIcon = jQuery(this);
				var objLoader = objIcon.siblings(".state_loader");
				var slideID = objIcon.data("slideid");
				var data = {slider_id:sliderID,slide_id:slideID};
				
				objIcon.hide();
				objLoader.show();
				UniteAdminRev.ajaxRequest("toggle_slide_state" ,data,function(response){
					objIcon.show();
					objLoader.hide();
					var currentState = response.state;
					
					if(currentState == "published"){
						objIcon.removeClass("state_unpublished").addClass("state_published").prop("title","Unpublish Slide");
					}else{
						objIcon.removeClass("state_published").addClass("state_unpublished").prop("title","Publish Slide");
					}
					
				});
			});
			
			//change image
			jQuery(".col-image .slide_image").click(function(){
				var slideID = this.id.replace("slide_image_","");
				UniteAdminRev.openAddImageDialog(g_messageChangeImage,function(urlImage,imageID){					
					var data = {slider_id:sliderID,slide_id:slideID,url_image:urlImage,image_id:imageID};
					UniteAdminRev.ajaxRequest("change_slide_image" ,data);
				});
			}).tipsy({
				gravity:"s",
		        delayIn: 70
			});
			
		}
		
		
		/**
		 * init "slides list" view 
		 */
		t.initSlidesListView = function(sliderID){
			
			initSlideListGlobals(sliderID);
			
			//quick lang change by lang icon
			jQuery("#list_slides").delegate(".icon_slide_lang, .icon_slide_lang_add","click",function(event){
				
				event.stopPropagation()
				var pos = UniteAdminRev.getAbsolutePos(this);
				var posLeft = pos[0] - 135;
				var posTop = pos[1] - 60;
				
				var objIcon = jQuery(this);
				
				var operation = objIcon.data("operation");
				var isParent = objIcon.data("isparent");
								
				if(operation == "add")
					jQuery("#langs_float_wrapper .item_operation").hide();
				else{
					jQuery("#langs_float_wrapper .item_operation").show();
					
					if(isParent == true)
						jQuery("#langs_float_wrapper .item_operation.operation_delete").hide();	
				}
								
				var objList = objIcon.parents(".list_slide_icons");
				filterFloatMenuByListIcons(objList,operation);
				
				jQuery("#langs_float_wrapper").show().css({left:posLeft,top:posTop});
				jQuery("#langs_float_wrapper").data("iconid",this.id);
			}); 
			
			jQuery("body").click(function(){
				jQuery("#langs_float_wrapper").hide();
			});
			
			//switch the language
			jQuery("#slides_langs_float li a").click(function(){
				var obj = jQuery(this);
				var lang = obj.data("lang");
				
				var iconID = jQuery("#langs_float_wrapper").data("iconid");
				if(!iconID)
					return(true);
				
				var objIcon = jQuery("#"+iconID);
				var objList = objIcon.parents(".list_slide_icons");
				
				//set operation
				var operation = obj.data("operation");
				
				if(operation == undefined || !operation)
					operation = objIcon.data("operation");
				
				if(operation == undefined || !operation)
					operation = "update";
				
				var currentLang = objIcon.data("lang");
				var slideID = objIcon.data("slideid");
				
				if(currentLang == lang)
					return(true);
				
				//show the loader
				if(operation != "preview"){
					objIcon.siblings(".icon_lang_loader").show();
					objIcon.hide();
				}
				
				if(operation == "edit"){
					var urlSlide = g_patternViewSlide.replace("[slideid]",slideID);
					location.href = urlSlide;
					return(true);
				}
				
				if(operation == "preview"){
					openPreviewSlideDialog(slideID,false);
					return(true);
				}
				
				var data = {sliderid:sliderID,slideid:slideID,lang:lang,operation:operation};
				UniteAdminRev.ajaxRequest("slide_lang_operation" ,data,function(response){
					
					objIcon.siblings(".icon_lang_loader").hide();					
					
					//nandle after response
					switch(response.operation){
						case "update":
							objIcon.attr("src",response.url_icon);
							objIcon.attr("title",response.title);
							objIcon.data("lang",lang);	
							objIcon.show();	
						break;
						case "add":
							objIcon.show();
							objIcon.parent().before(response.html);
							
							//hide the add icon if all langs included
							if(response.isAll == true)
								objList.find(".icon_slide_lang_add").hide();
								
						break;
						case "delete":
							objIcon.parent().remove();
							//show the add icon
							objList.find(".icon_slide_lang_add").show();
							
						break;
					}
					
				});
								
			});
						
			//new slide
			jQuery("#button_new_slide, #button_new_slide_top").click(function(){
				var dialogTitle = jQuery("#button_new_slide").data("dialogtitle");
				
				UniteAdminRev.openAddImageDialog(dialogTitle, function(obj){
					var data = {sliderid:sliderID,obj:obj};
					UniteAdminRev.ajaxRequest("add_slide" ,data);
				},true);	//allow multiple selection
				
			});
			
			//new transparent slide
			jQuery("#button_new_slide_transparent, #button_new_slide_transparent_top").click(function(){
				jQuery(this).hide();
				jQuery(".new_trans_slide_loader").show();
				var data = {sliderid:sliderID};
				UniteAdminRev.ajaxRequest("add_slide" ,data);
			});
			
			//duplicate slide
			jQuery(".button_duplicate_slide").click(function(){
				var slideID = this.id.replace("button_duplicate_slide_","");
				var data = {slideID:slideID,sliderID:sliderID};
				UniteAdminRev.ajaxRequest("duplicate_slide" ,data);
			});
			
			//copy / move slides
			jQuery(".button_copy_slide").click(function(){
				if(jQuery(this).hasClass("button-disabled"))
					return(false);
				
				var dialogCopy = jQuery("#dialog_copy_move");
				
				var textClose = dialogCopy.data("textclose");
				var textUpdate = dialogCopy.data("textupdate");
				var objButton = jQuery(this);
				
				var buttons = {};
				buttons[textUpdate] = function(){
					var slideID = objButton.attr("id").replace("button_copy_slide_","");
					var targetSliderID = jQuery("#selectSliders").val();
					var operation = "copy";
					if(jQuery("#radio_move").prop("checked") == "checked")
						operation = "move";
						
					var data = {slideID:slideID,
								sliderID:sliderID,
								targetSliderID:targetSliderID,
								operation:operation};
					
					var objLoader = objButton.siblings(".loader_copy");
					
					objButton.hide();
					objLoader.show();
					
					UniteAdminRev.ajaxRequest("copy_move_slide" ,data);
					jQuery(this).dialog("close");
				};
				
				jQuery("#dialog_copy_move").dialog({
					modal:true,
					resizable:false,
					width:400,
					height:300,
					closeOnEscape:true,
					dialogClass:"tpdialogs",
					buttons:buttons	
				});	//dialog end
				
			});
			
			// delete single slide
			jQuery(".button_delete_slide").click(function(){
				var slideID = jQuery(this).data("slideid");
				var data = {slideID:slideID,sliderID:sliderID};
				if(confirm("Delete this slide?") == false)
					return(false);
				
				var objButton = jQuery(this);				
				var objLoader = objButton.siblings(".loader_delete");
				
				objButton.hide();
				objLoader.show();
				
				UniteAdminRev.ajaxRequest("delete_slide" ,data);
			});
			
			//preview slide from the slides list:
			jQuery("#list_slides .icon_slide_preview").click(function(){
				var slideID = jQuery(this).data("slideid");
				openPreviewSlideDialog(slideID,false);
			});
			
		}
		
		t.saveEditSlide = function(slideID,isDemo){
			if(!isDemo)
				isDemo = false;
				
			var layers = UniteLayersRev.getLayers();
				
			if(JSON && JSON.stringify)
				layers = JSON.stringify(layers);
			
			var data = {
					slideid:slideID,
					layers:layers
				};

			if(!isDemo){ //demo means static captions. This has 
				data.params = UniteSettingsRev.getSettingsObject("form_slide_params");
				
				data.params.slide_bg_color = jQuery("#slide_bg_color").val();
				data.params.slide_bg_external = jQuery("#slide_bg_external").val();
				data.params.bg_fit = jQuery("#slide_bg_fit").val();
				data.params.bg_fit_x = jQuery("input[name='bg_fit_x']").val();
				data.params.bg_fit_y = jQuery("input[name='bg_fit_y']").val();
				data.params.bg_repeat = jQuery("#slide_bg_repeat").val();
				data.params.bg_position = jQuery("#slide_bg_position").val();
				data.params.bg_position_x = jQuery("input[name='bg_position_x']").val();
				data.params.bg_position_y = jQuery("input[name='bg_position_y']").val();
				data.params.bg_end_position_x = jQuery("input[name='bg_end_position_x']").val();
				data.params.bg_end_position_y = jQuery("input[name='bg_end_position_y']").val();
				
				var slideBgSetting = getSlideBgSettings(); //get new background options
				
				if(typeof slideBgSetting === 'object' && !jQuery.isEmptyObject(slideBgSetting)){ //add new background options
					for(key in slideBgSetting){
						data.params[key] = slideBgSetting[key];
					}
				}
				
				//kenburns & pan zoom
				data.params.kenburn_effect = jQuery("input[name='kenburn_effect']:checked").val();
				//data.params.kb_rotation_start = jQuery("input[name='kb_rotation_start']").val();
				//data.params.kb_rotation_end = jQuery("input[name='kb_rotation_end']").val();
				data.params.kb_start_fit = jQuery("input[name='kb_start_fit']").val();
				data.params.kb_end_fit = jQuery("input[name='kb_end_fit']").val();
				
				data.params.bg_end_position = jQuery("select[name='bg_end_position']").val();
				data.params.kb_duration = jQuery("input[name='kb_duration']").val();
				data.params.kb_easing = jQuery("select[name='kb_easing']").val();
				
			}
			
			if(!isDemo){
				UniteAdminRev.setAjaxHideButtonID("button_save_slide,button_save_slide-tb");
				UniteAdminRev.setAjaxLoaderID("loader_update");
				UniteAdminRev.setSuccessMessageID("update_slide_success");
				UniteAdminRev.ajaxRequest("update_slide", data);
			}else{
				UniteAdminRev.setAjaxHideButtonID("button_save_static_slide,button_save_static_slide-tb");
				UniteAdminRev.setAjaxLoaderID("loader_update");
				UniteAdminRev.setSuccessMessageID("update_slide_success");
				UniteAdminRev.ajaxRequest("update_static_slide", data);
			}
		}
		/**
		 * init "edit slide" view
		 */
		this.initEditSlideView = function(slideID,sliderID){
			
			// TOGGLE SOME ACCORDION
			jQuery('.tp-accordion').click(function() {
				
				var tpacc=jQuery(this);
				if (tpacc.hasClass("tpa-closed")) {
						tpacc.parent().parent().parent().find('.tp-closeifotheropen').each(function() {
							jQuery(this).slideUp(300);
							jQuery(this).parent().find('.tp-accordion').addClass("tpa-closed").addClass("box_closed").find('.postbox-arrow2').html("+");								
						})

						tpacc.parent().find('.toggled-content').slideDown(300);
						tpacc.removeClass("tpa-closed").removeClass("box_closed");
						tpacc.find('.postbox-arrow2').html("-");
				} else {
						tpacc.parent().find('.toggled-content').slideUp(300);
						tpacc.addClass("tpa-closed").addClass("box_closed");
						tpacc.find('.postbox-arrow2').html("+");
				
				}
			})
			
			// MAKE MAX WIDTH OF CONTAINERS.
			jQuery('.mw960').each(function() {
				var newmw = jQuery('#divLayers').width();
				if (newmw<960) newmw=960;
				jQuery(this).css({maxWidth:newmw+"px"});
			})
			
			// SORTING AND DEPTH SELECTOR
			jQuery('#button_sort_depth').on('click',function() {
				jQuery('.layer_sortbox').addClass("depthselected");
				jQuery('.layer_sortbox').removeClass("timeselected");
			});
			
			jQuery('#button_sort_time').on('click',function() {			
				jQuery('.layer_sortbox').removeClass("depthselected");
				jQuery('.layer_sortbox').addClass("timeselected");

			});
			
			
			//add slide top link
			jQuery("#link_add_slide").click(function(){
				
				var data = {
						sliderid:sliderID
					};
				jQuery("#loader_add_slide").show();
				UniteAdminRev.ajaxRequest("add_slide_fromslideview" ,data);
			});
			
			//save slide actions
			jQuery("#button_save_slide").click(function(){
				t.saveEditSlide(slideID);
			});
			
			jQuery("#button_save_slide-tb").click(function(){
				t.saveEditSlide(slideID);
			});
			
			//save slide actions
			jQuery("#button_save_static_slide").click(function(){
				t.saveEditSlide(slideID, true);
			});
			
			jQuery("#button_save_static_slide-tb").click(function(){
				t.saveEditSlide(slideID, true);
			});
			
			//change image actions
			jQuery("#button_change_image").click(function(){
				
				UniteAdminRev.openAddImageDialog("Select Slide Image",function(urlImage,imageID){
						if(imageID == undefined)
							imageID = "";
						
						//set visual image 
						jQuery("#divbgholder").css("background-image","url("+urlImage+")");
						
						//update setting input
						jQuery("#image_url").val(urlImage);
						jQuery("#image_id").val(imageID);
						
						jQuery("#radio_back_image").attr('checked', 'checked');
						jQuery("#radio_back_image").click();
						
						if(jQuery('input[name="kenburn_effect"]:checked').val() == 'on'){
							jQuery('input[name="kb_start_fit"]').change();
						}
					}); //dialog
			});	//change image click.
			
			
			// slide options hide / show			
			jQuery("#link_hide_options").click(function(){
				
				if(jQuery("#slide_params_holder").is(":visible") == true){
					jQuery("#slide_params_holder").hide("slow");
					jQuery(this).text("Show Slide Options").addClass("link-selected");
				}else{
					jQuery("#slide_params_holder").show("slow");
					jQuery(this).text("Hide Slide Options").removeClass("link-selected");
				}
				
			});
			
			
			//preview slide actions - open preveiw dialog			
			jQuery("#button_preview_slide").click(function(){				
				openPreviewSlideDialog(slideID,true);
			});
			//preview slide actions - open preveiw dialog			
			jQuery("#button_preview_slide-tb").click(function(){				
				openPreviewSlideDialog(slideID,true);
			});
			
			//init background options
			jQuery("#radio_back_image, #radio_back_trans, #radio_back_solid, #radio_back_external").click(function(){
				var currentType = jQuery("#background_type").val();
				var bgType = jQuery(this).data("bgtype");
				
				if(currentType == bgType)
					return(true);
				
				//disable image button
				if(bgType == "image")
					jQuery("#button_change_image").removeClass("button-disabled");
				else
					jQuery("#button_change_external").addClass("button-disabled");
				
				if(bgType == "solid")
					jQuery("#slide_bg_color").removeClass("disabled").prop("disabled","");
				else
					jQuery("#slide_bg_color").addClass("disabled").prop("disabled","disabled");
				
				if(bgType == "external"){
					jQuery("#slide_bg_external").removeClass("disabled").prop("disabled","");
					jQuery("#button_change_image").removeClass("button-disabled");
				}else{
					jQuery("#slide_bg_external").addClass("disabled").prop("disabled","disabled");
					jQuery("#button_change_external").addClass("button-disabled");
				}
				
				
				jQuery("#background_type").val(bgType);
				
				setSlideBGByType(bgType);
								
			});
			
			jQuery("#button_change_external").click(function(){
				var bgType = jQuery("#radio_back_external:checked").data("bgtype");
				
				if(bgType == "external"){
					jQuery("#slide_bg_external").removeClass("disabled").prop("disabled","");
					jQuery("#button_change_image").removeClass("button-disabled");
					setSlideBGByType(bgType);
					
					
					if(jQuery('input[name="kenburn_effect"]:checked').val() == 'on'){
						jQuery('input[name="kb_start_fit"]').change();
					}
				}
			});
			
			
			//on change bg color event 
			UniteAdminRev.setColorPickerCallback(function(){
				var bgType = jQuery("#background_type").val();
				if(bgType == "solid"){
					var bgColor = jQuery("#slide_bg_color").val();
					jQuery("#divbgholder").css("background-color",bgColor);
				}
					
			});
			
			
			//on change title event
			jQuery("#title").on('input',function(e){
				jQuery(".slide_title").text(jQuery("#title").val());
			});
			
			jQuery(".list_slide_links").sortable({
				update:function(){updateSlidesOrderEdit(sliderID)}
			});
			
			
			/**
			 * update slides order in slide edit
			 */
			var updateSlidesOrderEdit = function(sliderID){
				var arrSlideHtmlIDs = jQuery( ".list_slide_links" ).sortable("toArray");
				
				//get slide id's from html (li) id's
				var arrIDs = [];
				jQuery(arrSlideHtmlIDs).each(function(index,value){
					var slideID = value.replace("slidelist_item_","");
					arrIDs.push(slideID);
				});
				
				//save order
				var data = {arrIDs:arrIDs,sliderID:sliderID};
				
				jQuery("#loader_add_slide").show();
				UniteAdminRev.ajaxRequest("update_slides_order" ,data,function(){
					jQuery("#loader_add_slide").hide();
				});
				
			}
			
			jQuery('.inputDatePicker').datepicker({
				dateFormat : 'dd-mm-yy 00:00'
			});
			
			
			// delete single slide
			jQuery("#button_delete_slide").click(function(){
				var data = {slideID:slideID,sliderID:sliderID};
				
				if(confirm(g_messageDeleteSlide) == false)
					return(false);
				
				UniteAdminRev.ajaxRequest("delete_slide" ,data);
			});
			
			if(jQuery('input[name="load_googlefont"]:checked').val() == 'false'){
				jQuery('#load_googlefont_row').siblings('.spanSettingsStaticText').remove();
				jQuery('#load_googlefont_row').parent().html('<div class="setting_info_small" style="margin-bottom: 5px;">Please use the Punch Fonts Menu to add Fonts</div>');
				
				jQuery('#load_googlefont_row').remove();
				jQuery('#google_font_row').remove();
				jQuery('#load_googlefont').closest('.postbox.unite-postbox').hide();
				
			}
		}//init slide view
		
		
		/**
		 * open preview slide dialog
		 */
		var openPreviewSlideDialog = function(slideID,useParams){

			if(useParams === undefined)
				useParams = true;
			
			var iframePreview = jQuery("#frame_preview");
			var previewWidth = iframePreview.width() + 10;
			var previewHeight = iframePreview.height() + 10;
			var iframe = jQuery("#frame_preview");
			
			jQuery("#dialog_preview").dialog({
					modal:true,
					resizable:false,
					minWidth:previewWidth,
					minHeight:previewHeight,
					closeOnEscape:true,
					dialogClass:"tpdialogs",
					buttons:{
						"Close":function(){
							jQuery(this).dialog("close");
						}
					},
					open:function(event,ui){						
						var form1 = jQuery("#form_preview_slide")[0];
						jQuery("#preview_slide_nonce").val(g_revNonce);
						
						var objData = {
								slideid:slideID,
							};
						
						if(useParams == true){
							objData.params = UniteSettingsRev.getSettingsObject("form_slide_params"),
							objData.params.slide_bg_color = jQuery("#slide_bg_color").val();
							objData.params.slide_bg_external = jQuery("#slide_bg_external").val();
							objData.params.bg_fit = jQuery("#slide_bg_fit").val();
							objData.params.bg_fit_x = jQuery("input[name='bg_fit_x']").val();
							objData.params.bg_fit_y = jQuery("input[name='bg_fit_y']").val();
							objData.params.bg_repeat = jQuery("#slide_bg_repeat").val();
							objData.params.bg_position = jQuery("#slide_bg_position").val();
							objData.params.bg_position_x = jQuery("input[name='bg_position_x']").val();
							objData.params.bg_position_y = jQuery("input[name='bg_position_y']").val();
							objData.params.bg_end_position_x = jQuery("input[name='bg_end_position_x']").val();
							objData.params.bg_end_position_y = jQuery("input[name='bg_end_position_y']").val();
							
							//kenburns & pan zoom
							objData.params.kenburn_effect = jQuery("input[name='kenburn_effect']:checked").val();
							//objData.params.kb_rotation_start = jQuery("input[name='kb_rotation_start']").val();
							//objData.params.kb_rotation_end = jQuery("input[name='kb_rotation_end']").val();
							objData.params.kb_start_fit = jQuery("input[name='kb_start_fit']").val();
							objData.params.kb_end_fit = jQuery("input[name='kb_end_fit']").val();
							
							objData.params.bg_end_position = jQuery("select[name='bg_end_position']").val();
							objData.params.kb_duration = jQuery("input[name='kb_duration']").val();
							objData.params.kb_easing = jQuery("select[name='kb_easing']").val();
							
							objData.layers = UniteLayersRev.getLayers()
						}
						
						var jsonData = JSON.stringify(objData);
						
						jQuery("#preview_slide_data").val(jsonData);
						form1.action = g_urlAjaxActions;
						form1.client_action = "preview_slide";
						form1.submit();
					},
					close:function(){	//destroy the loaded preview
						var form1 = jQuery("#form_preview_slide")[0];
						form1.action = g_urlAjaxActions;
						jQuery("#preview_slide_data").val("empty_output");
						form1.submit();
					}
			});
			
		}
		
		
		/**
		 * set slide background by type (image, solid, bg).
		 */
		var setSlideBGByType = function(bgType){
			switch(bgType){
				case "image":
					var urlImage = jQuery("#image_url").val();
					jQuery("#divbgholder").css("background-image","url('"+urlImage+"')");
					jQuery("#divbgholder").css("background-color","transparent");
					jQuery("#divbgholder").removeClass("trans_bg");
					if(jQuery('input[name="kenburn_effect"]:checked').val() == 'on'){
						jQuery('input[name="kb_start_fit"]').change();
					}
				break;			
				case "trans":
					jQuery("#divbgholder").css("background-image","none");
					jQuery("#divbgholder").css("background-color","transparent");
					jQuery("#divbgholder").addClass("trans_bg");
				break;
				case "solid":
					jQuery("#divbgholder").css("background-image","none");
					jQuery("#divbgholder").removeClass("trans_bg");
					var bgColor = jQuery("#slide_bg_color").val();
					jQuery("#divbgholder").css("background-color",bgColor);
				break;
				case "external":
					var urlImage = jQuery("#slide_bg_external").val();
					jQuery("#divbgholder").css("background-image","url('"+urlImage+"')");
					jQuery("#divbgholder").css("background-color","transparent");
					jQuery("#divbgholder").removeClass("trans_bg");
					if(jQuery('input[name="kenburn_effect"]:checked').val() == 'on'){
						jQuery('input[name="kb_start_fit"]').change();
					}
				break;
			}

		}
		
		var getSlideBgSettings = function(){
			var retParams = new Object;
			
			retParams['bg_fit'] = jQuery('#slide_bg_fit').val();
			if(retParams['bg_fit'] == 'percentage'){
				retParams['bg_fit_x'] = jQuery('input[name="bg_fit_x"]').val();
				retParams['bg_fit_y'] = jQuery('input[name="bg_fit_y"]').val();
			}
			
			retParams['bg_position'] = jQuery('#slide_bg_position').val();
			if(retParams['bg_position'] == 'percentage'){
				retParams['bg_position_x'] = jQuery('input[name="bg_position_x"]').val();
				retParams['bg_position_y'] = jQuery('input[name="bg_position_y"]').val();
			}
			
			retParams['bg_end_position'] = jQuery('#slide_bg_end_position').val();
			if(retParams['bg_end_position'] == 'percentage'){
				retParams['bg_end_position_x'] = jQuery('input[name="bg_end_position_x"]').val();
				retParams['bg_end_position_y'] = jQuery('input[name="bg_end_position_y"]').val();
			}
			
			retParams['bg_repeat'] = jQuery('#slide_bg_repeat').val();
			
			return retParams;
		}
		
		
		/**
		 * global style part
		 */
		 
		var g_codemirrorCssDynamic = null;
		var g_codemirrorCssStatic = null;
		var staticStyles = null;
		var urlStaticCssCaptions = null;
		
		/**
		 * set static captions url for refreshing when needed
		 */
		t.setStaticCssCaptionsUrl = function(url){
			urlStaticCssCaptions = url;
		}
		
		/**
		 * get static captions url for refreshing when needed
		 */
		t.getUrlStaticCssCaptions = function(){
			return urlStaticCssCaptions;
		}
		
		t.initGlobalStyles = function(){
			initGlobalCssAccordion();
			initGlobalCssEditor();
		}
		
		t.setCodeMirrorStaticEditor = function(){
			g_codemirrorCssStatic = CodeMirror.fromTextArea(document.getElementById("textarea_edit_static"), { lineNumbers: true });
		}
		
		t.setCodeMirrorDynamicEditor = function(){
			g_codemirrorCssDynamic = CodeMirror.fromTextArea(document.getElementById("textarea_show_dynamic_styles"), {
				lineNumbers: true,
				readOnly: true
			});
		}
		
		var initGlobalCssAccordion = function(){
			jQuery("#css-static-accordion").accordion({
				heightStyle: "content",
				activate: function(event, ui){
					if(g_codemirrorCssStatic != null) g_codemirrorCssStatic.refresh();
					if(g_codemirrorCssDynamic != null) g_codemirrorCssDynamic.refresh();
				}
			});
		}
		
		var initGlobalCssEditor = function(){
		
			jQuery('#button_edit_css_global').click(function(){
				//if(!UniteLayersRev.getLayerGeneralParamsStatus()) return false; //false if fields are disabled
				
				jQuery("#css-static-accordion").accordion({ active: 1 });
				
				UniteAdminRev.ajaxRequest("get_static_css","",function(response){
					var cssData = response.data;
					
					if(g_codemirrorCssStatic != null)
						g_codemirrorCssStatic.setValue(cssData);
					else{
						jQuery("#textarea_edit_static").val(cssData);
						setTimeout('RevSliderAdmin.setCodeMirrorStaticEditor()',500);
					}
				});
				
				UniteAdminRev.ajaxRequest("get_dynamic_css","",function(response){
					var cssData = response.data;
					
					if(g_codemirrorCssDynamic != null)
						g_codemirrorCssDynamic.setValue(cssData);
					else{
						jQuery("#textarea_show_dynamic_styles").val(cssData);
						setTimeout('RevSliderAdmin.setCodeMirrorDynamicEditor()',500);
					}
				});
				
				jQuery("#css_static_editor_wrap").dialog({
					modal:true,
					resizable:false,
					title:'Global Styles Editor',
					minWidth:700,
					minHeight:500,
					closeOnEscape:true,
					open:function () {
						jQuery(this).closest(".ui-dialog")
						.find(".ui-button").each(function(i) {
						   var cl;
						   if (i==0) cl="revgray";
						   if (i==1) cl="revgreen";
						   if (i==2) cl="revred";
						   jQuery(this).addClass(cl).addClass("button-primary").addClass("rev-uibuttons");						   						   
					   })
					},
					buttons:{
						Save:function(){
							if(!confirm("Really update global styles?")){
								return false;
							}
							
							UniteAdminRev.setErrorMessageID("dialog_error_message");						
							var data;
							if(g_codemirrorCssStatic != null)
								data = g_codemirrorCssStatic.getValue();
							else
								data = jQuery("#textarea_edit_static").val();
							
							UniteAdminRev.ajaxRequest("update_static_css",data,function(response){
								jQuery("#dialog_success_message").show().html(response.message);
								
								if(g_codemirrorCssStatic != null)
									g_codemirrorCssStatic.setValue(response.css);
								else
									jQuery("#textarea_edit_static").val(css);
								
							});
							
							//if(urlStaticCssCaptions)
							//	setTimeout('UniteAdminRev.loadCssFile(RevSliderAdmin.getUrlStaticCssCaptions(),"rs-plugin-static-css");',1000);
								
							jQuery(this).dialog("close");
						},
						"Cancel":function(){
							jQuery(this).dialog("close");
						}
					}
				});
			});
		}
		
}
