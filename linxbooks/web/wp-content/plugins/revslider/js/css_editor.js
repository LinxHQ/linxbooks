//ver 1.0

var UniteCssEditorRev = new function(){
	
	var t = this;
	var initCssStyles = [];
	var cssPreClass = '.tp-caption';
	var cssCurrentEdit = '';
	var cssCurrentType = 'params';
	var curActiveStyles = new Object;
	var curFullClass = new Object;
	var cssExpertEditor = false;
	var urlCssCaptions = null;
	var isHoverActive = false;
	var showExpertWarning = false;
	var g_codemirrorCssExpert = null;
	
	//======================================================
	//	Init Functions
	//======================================================
	
	/**
	 * set init css styles array
	 */
	t.setInitCssStyles = function(jsonClasses){
		initCssStyles = jQuery.parseJSON(jsonClasses);
	}
	
	/**
	 * set captions url for refreshing when needed
	 */
	t.setCssCaptionsUrl = function(url){
		urlCssCaptions = url;
	}
	
	/**
	 * init the css editor
	 */
	t.init = function(){
		initAccordion();
		initEditorElements();
		initEditorDialog();
	}
	
	/**
	 * init dialog actions
	 */
	var initEditorDialog = function(){

		jQuery("#button_edit_css").click(function(){
			if(!UniteLayersRev.getLayerGeneralParamsStatus()) return false; //false if fields are disabled
			if(jQuery.trim(jQuery('#layer_caption').val()).length == 0) return false; //check if classname is empty
			
			jQuery("#css_preview").attr('style', ''); //clear the preview
			
			jQuery("#css_editor_wrap").dialog({
				modal:true,
				resizable:false,
				title:'Currently editing: '+jQuery('#layer_caption').val(),
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
						   if (i==3) cl="revred";
						   jQuery(this).addClass(cl).addClass("button-primary").addClass("rev-uibuttons");						   						   
				   })
				},
				buttons:{
					"Save/Change":function(){
						UniteAdminRev.setErrorMessageID("dialog_error_message");						
						var data;
						jQuery('#current-class-handle').text(cssCurrentEdit);
						jQuery('input[name="css_save_as"]').val(cssCurrentEdit);
						
						//curActiveStyles update
						setActiveStylesFromExample();
						updateCurFullClass();
						
						jQuery("#dialog-change-css").dialog({
							modal: true,
							buttons: {
								'Save as': function() {
									jQuery("#dialog-change-css-save-as").dialog({
										modal: true,
										buttons: {
											'Save as new': function(){
												var update_name = UniteAdminRev.sanitize_input(jQuery('input[name="css_save_as"]').val());
												if(update_name != ''){
													var id = checkIfHandleExists(update_name);
													var update = true;
													if(id !== false){
														update = false;
														if(confirm("Class already exists, overwrite?")){
															updateStylesInDb(update_name, id);
															update = true;
														}
													}else{
														updateStylesInDb(update_name, false);
														jQuery('#layer_caption').val(update_name);
														UniteLayersRev.updateLayerFromFields();
													}
												
													if(update){
														jQuery("#dialog-change-css").dialog("close");
														jQuery(this).dialog("close");
														jQuery("#css_editor_wrap").dialog("close");
													}
												}else{
													alert('Class must be a valid CSS class name');
												}
											}
										}
									});
								},
								Save: function() {
									var update_name = UniteAdminRev.sanitize_input(jQuery('input[name="layer_caption"]').val());
									var id = checkIfHandleExists(update_name);
									if(update_name != ''){
										if(id !== false){
											if(confirm("Really overwrite Class?")){
												updateStylesInDb(update_name, id);
												jQuery(this).dialog("close");
												jQuery("#css_editor_wrap").dialog("close");
											}
										}else{
											updateStylesInDb(update_name, false);
											UniteLayersRev.updateLayerFromFields();
											jQuery(this).dialog("close");
											jQuery("#css_editor_wrap").dialog("close");
										}
									}else{
										alert('Class must be a valid CSS class name');
									}
								}
							}
						});
					},
					"Cancel":function(){
						jQuery(this).dialog("close");
					},
					"Delete":function(){
						if(confirm("Really delete Class '"+jQuery('#layer_caption').val()+"'? This can't be undone!")){
							var id = checkIfHandleExists(jQuery('#layer_caption').val());
							if(id !== false){
								deleteStylesInDb(jQuery('#layer_caption').val(), id);
							}else{
								alert("This class does not exist.");
							}
							
							jQuery(this).dialog("close");
							jQuery("#css_editor_wrap").dialog("close");
						}
					}
				}
			});
			
			jQuery("#reset-background-color").click(function(){
				jQuery('input[name="css_background-color"]').val('transparent');
				jQuery('input[name="css_background-color"]').css('background-color', '');
				jQuery('input[name="css_background-color"]').css('color', '#000');
				t.setCssPreviewLive();
			});
			
			jQuery("#reset-border-color").click(function(){
				jQuery('input[name="css_border-color-show"]').css('background-color', '');
				jQuery('input[name="css_border-color-show"]').css('color', '#000');
				jQuery('input[name="css_border-color-show"]').val(' ');
				jQuery('input[name="css_border-color"]').val(' ');
				t.setCssPreviewLive();
			});
			
			resetTabsToIdle(); //reset tabs to idle
			setFullClass(); //fill the object for editing
			setActiveStyles(cssCurrentType); //we start with params
			
			resetNoviceFields(); //reset the novice fields
			setNoviceFields(); //set novice fields from cssActiveStyles
			
			setCssPreview(); //fill the preview with styles
			resetSubSlider(); //reset padding and corner sliders
			
			setHoverActive(); //check if cssFullClass has hover enabled
			
			t.setAccordion(); //fill depending on current active accordion
			
			cssCurrentEdit = jQuery('input[name="layer_caption"]').val();
			
			jQuery('.css-edit-enable').hide();
			jQuery('#css_editor_allow').text('');
			
		});	//edit css button click	
	}
	
	/**
	 * register events and functions
	 */
	var initEditorElements = function(){
	
		jQuery("#change-type-idle").click(function(){
			jQuery('.css-edit-enable').hide();
			jQuery('#css_editor_allow').text('');
			
			setActiveStylesFromExample(); //get Styles from example
			updateCurFullClass(); //update curFullClass with curActiveStyles
			
			cssCurrentType = 'params';
			setActiveStyles(cssCurrentType); //fill curActiveStyles
			
			updateEditorFromActiveStyles();
			
			jQuery(".change-type").removeClass('selected');
			jQuery(this).addClass('selected');
		});
		
		jQuery("#change-type-hover").click(function(){
			jQuery('.css-edit-enable').show();
			jQuery('#css_editor_allow').text(':hover');
			
			setActiveStylesFromExample(); //get Styles from example
			updateCurFullClass(); //update curFullClass with curActiveStyles

			cssCurrentType = 'hover';
			setActiveStyles(cssCurrentType, true);  //fill curActiveStyles
	
			updateEditorFromActiveStyles();
			
			jQuery(".change-type").removeClass('selected');
			jQuery(this).addClass('selected');
		});
		
		jQuery('.css_editor-disable-inputs').click(function(){
			if(confirm("Making changes to these settings will probably overwrite advanced settings. Continue?") == true) hideCssExpertWarning();
		});
		
		jQuery("#font-size-slider").slider({
			range: "min",
			min: 6,
			max: 150,
			slide: function(event, ui) {
				jQuery('input[name="css_font-size"]').val(ui.value+'px');
				jQuery(this).children(".ui-slider-handle").text(ui.value+'px');
				t.setCssPreviewLive();
			}
		});
		
		jQuery("#line-height-slider").slider({
			range: "min",
			min: 6,
			max: 180,
			slide: function(event, ui) {
				jQuery('input[name="css_line-height"]').val(ui.value+'px');
				jQuery(this).children(".ui-slider-handle").text(ui.value+'px');
				t.setCssPreviewLive();
			}
		});
		
		jQuery("#font-weight-slider").slider({
			range: "min",
			min: 100,
			max: 900,
			step: 100,
			slide: function(event, ui) {
				jQuery('input[name="css_font-weight"]').val(ui.value);
				jQuery(this).children(".ui-slider-handle").text(ui.value);
				t.setCssPreviewLive();
			}
		});
		
		jQuery("#border-width-slider").slider({
			range: "min",
			min: 0,
			max: 25,
			slide: function(event, ui) {
				jQuery('input[name="css_border-width"]').val(ui.value+'px');
				jQuery(this).children(".ui-slider-handle").text(ui.value+'px');
				t.setCssPreviewLive();
			}
		});
		
		jQuery("#background-transparency-slider").slider({
			range: "min",
			min: 0,
			max: 100,
			slide: function(event, ui) {
				jQuery('input[name="css_background-transparency"]').val(ui.value / 100);
				jQuery(this).children(".ui-slider-handle").text(ui.value+'%');
				t.setCssPreviewLive();
			}
		});
		
		jQuery(".subslider").each(function() {

			var pslider = jQuery(this);       
			var psliderpa = pslider.parent().find('.sub-input');

			psliderpa.on("focus",function() {
				jQuery(".subslider").each(function() {
					jQuery(this).css({visibility:"hidden"});
					jQuery(this).parent().removeClass("activated_padder")
				})
				pslider.css({visibility:'visible'});
				psliderpa.parent().addClass("activated_padder");
			});

			psliderpa.on("change",function() {
				pslider.slider("value",psliderpa.val());
				pslider.children(".ui-slider-handle").text(psliderpa.val()+"px");
			});

			pslider. slider({
				range: "min",
				min: 0,
				max: 150,       
				slide: function(event, ui) {
					psliderpa.val(ui.value);
					jQuery(this).children(".ui-slider-handle").text(ui.value+"px");
					t.setCssPreviewLive();
				}
			});

			// PREPARING THE SLIDER
			pslider.slider("value",psliderpa.val());
			pslider.children(".ui-slider-handle").text(psliderpa.val()+"px");
			pslider.css({visibility:"hidden"});
		});
		
		jQuery('.css_edit_novice').on('change', function() {
			t.setCssPreviewLive();
		});
		
	}
	
	/**
	 * init the accordion
	 */
	var initAccordion = function(){
		jQuery("#css-editor-accordion").accordion({
			heightStyle: "content",
			activate: function(event, ui){
				t.setAccordion();
			}
		});

	}
	
	//======================================================
	//	General Functions
	//======================================================
	
	/**
	 * check for hiding the expert warning
	 */
	jQuery('.css_editor-disable-inputs').click(function(){
		if(confirm("Making changes to these settings will probably overwrite advanced settings. Continue?") == true) hideCssExpertWarning();
	});
	
	/**
	 * reset tab to idle state
	 */
	var resetTabsToIdle = function(){
		cssCurrentType = 'params';
		jQuery(".change-type").removeClass('selected');
		jQuery("#change-type-idle").addClass('selected');
	}
	
	/**
	 * fill temp class with init class if found
	 */
	var setFullClass = function(){
		curFullClass = new Object;
		for(var key in initCssStyles){
			if(initCssStyles[key]['handle'] == cssPreClass+'.'+jQuery("#layer_caption").val()){
				curFullClass = jQuery.extend({},initCssStyles[key]);
				break;
			}
		}
	}
	
	/**
	 * set current active styles object
	 */
	var setActiveStyles = function(setToType, fallbackToIdle){
		curActiveStyles = new Object;
		
		if(typeof curFullClass[setToType] === 'object' && !jQuery.isEmptyObject(curFullClass[setToType])){
			curActiveStyles = curFullClass[setToType];
		}else if(typeof fallbackToIdle !== 'undefined'){ //fall back to idle if i.e. hover does not exist
			curActiveStyles = curFullClass['params'];
		}
		checkBackgroundTransparency();
	};
	
	/**
	 * fill curFullClass with curActiveStyles
	 */
	var updateCurFullClass = function(){
		curFullClass[cssCurrentType] = curActiveStyles;
	};
	
	/**
	 * show the expert warning, novice could overwrite expert
	 */
	var showCssExpertWarning = function(){
		jQuery('.css_editor-disable-inputs').show();
	}
	
	/**
	 * hide the expert warning, novice could overwrite expert
	 */
	var hideCssExpertWarning = function(){
		jQuery('.css_editor-disable-inputs').hide();
		showExpertWarning = false;
	}
	
	/**
	 * reset the subslider (padding and corner sliders)
	 */
	var resetSubSlider = function(){
		jQuery(".subslider").each(function() {

			var pslider = jQuery(this);       
			var psliderpa = pslider.parent().find('.sub-input');
			
			//PREPARING THE SLIDER
			pslider.slider("value",psliderpa.val());
			pslider.children(".ui-slider-handle").text(psliderpa.val()+"px");       
			pslider.css({visibility:"hidden"});
		});
	};
	
	/**
	 * check if hover is enabled/disabled and set the novice param for it
	 */
	var setHoverActive = function(){
		isHoverActive = false;
		jQuery('input[name="css_allow"]').attr('checked', false);
		
		if(typeof curFullClass['settings'] === 'object' && !jQuery.isEmptyObject(curFullClass['settings'])){
			if(typeof curFullClass['settings']['hover'] != 'undefined' && (curFullClass['settings']['hover'] == 'true' || curFullClass['settings']['hover'] === true)){
				isHoverActive = true;
				jQuery('input[name="css_allow"]').attr('checked', true);
			}
		}
	}
	
	/**
	 * check for background-transparency value
	 */
	var checkBackgroundTransparency = function(){
		if(!jQuery.isEmptyObject(curActiveStyles)){
			if('background-color' in curActiveStyles){ //check for transparency and put it into background-transparency
				var transparency = UniteAdminRev.getTransparencyFromRgba(curActiveStyles['background-color']);
				if(transparency !== false)
					curActiveStyles['background-transparency'] = transparency;
				else
					delete curActiveStyles['background-transparency'];
			}
		}
	};
	
	/**
	 * set the accordion entrys
	 */
	t.setAccordion = function(){
		if(g_codemirrorCssExpert != null) g_codemirrorCssExpert.refresh();
		cssExpertEditor = (jQuery("#css-editor-accordion").accordion("option").active == 0) ? false : true;
		if(cssExpertEditor) t.setCssStylesExpert();
		if(!cssExpertEditor) t.setCssStylesNovice();
	}
	
	/**
	 * creates the padding & corner in 1 line
	 */
	var filterCssPadCor = function(id){
		var retObj = [];
		var i = 0;
		var found = 0;
		jQuery(id).each(function(){
			retObj[i] = jQuery(this).val();
			if(retObj[i] != '') found++;
			i++;
		});
		
		switch(found){
			case 0:
				return false; //empty, no entrys found
				break;
			case 1:
				for(key in retObj){
					if(retObj[key] != '') return retObj[key]+'px';
				}
				break;
			case 2:
				var checkVal = 0;
				for(key in retObj){
					if(retObj[key] != '') checkVal+= parseInt(key);
				}
				
				switch(checkVal){
					case 1: // 1 1 x x
						return retObj[0]+'px '+retObj[1]+'px';
						break;
					case 2: // 1 x 1 x
						if(retObj[0] == retObj[2])
							return retObj[0]+'px 0';
						else
							return retObj[0]+'px 0 '+retObj[2]+'px';
						break;
					case 3: // 1 x x 1 || x 1 1 x
						if(retObj[0] != '')
							return retObj[0]+'px '+retObj[3]+'px';
						else
							return retObj[2]+'px '+retObj[1]+'px';
						break;
					case 4: // x 1 x 1
						if(retObj[1] == retObj[3])
							return '0 '+retObj[1]+'px ';
						else
							return '0 '+retObj[1]+'px 0 '+retObj[3]+'px';
					case 5: // x x 1 1
						return retObj[2]+'px '+retObj[3]+'px';
					default:
						return false;
				}
				break;
			case 3:
				if(retObj[3] != ''){
					for(key in retObj){
						if(retObj[key] == '') retObj[key] = '0';
					}
				}
				return retObj[0]+'px '+retObj[1]+'px '+retObj[2]+'px';
				break;
			case 4:
			default:
				return retObj[0]+'px '+retObj[1]+'px '+retObj[2]+'px '+retObj[3]+'px';
				break;
		}
	}
	
	/**
	 * reset all novice fields 
	 */
	var resetNoviceFields = function(){
		jQuery('input[name="css_font-size"]').val('');
		jQuery('input[name="css_line-height"]').val('');
		jQuery('input[name="css_font-weight"]').val('');
		jQuery('input[name="css_font-family"]').val('');
		jQuery('input[name="css_font-style"]').attr('checked', false);
		jQuery('input[name="css_color"]').css('background-color', '');
		jQuery('input[name="css_color"]').val(' ');
		jQuery('input[name="css_background-transparency"]').val('1');
		jQuery('input[name="css_background-color"]').val('transparent');
		jQuery('input[name="css_background-color"]').css('background-color', '');
		jQuery('input[name="css_border-color"]').val(' ');
		jQuery('input[name="css_border-color-show"]').val(' ');
		jQuery('input[name="css_border-color-show"]').css('background-color', '');
		jQuery('input[name="css_border-width"]').val('');
		jQuery('select[name="css_border-style"]').val('none');
		jQuery('select[name="css_text-decoration"]').val('none');
		jQuery('input[name="css_padding[]"]').each(function(){jQuery(this).val('');});
		jQuery('input[name="css_border-radius[]"]').each(function(){jQuery(this).val('');});
		jQuery("#font-size-slider").slider("value", '8');
		jQuery("#font-size-slider").children(".ui-slider-handle").text('8px');
		jQuery("#line-height-slider").slider("value", '0');
		jQuery("#line-height-slider").children(".ui-slider-handle").text('10px');
		jQuery("#font-weight-slider").slider("value", '400');
		jQuery("#font-weight-slider").children(".ui-slider-handle").text('400');
		jQuery("#border-width-slider").slider("value", '0');
		jQuery("#border-width-slider").children(".ui-slider-handle").text('0px');
		jQuery("#background-transparency-slider").slider("value", '100');
		jQuery("#background-transparency-slider").children(".ui-slider-handle").text('100%');
	}
	
	/**
	 * set the novice fields
	 */
	var setNoviceFields = function(){
		showExpertWarning = false;
		
		if('font-size' in curActiveStyles){
			jQuery('input[name="css_font-size"]').val(curActiveStyles['font-size']);
			jQuery("#font-size-slider").slider("value", curActiveStyles['font-size'].replace('px', ''));
			jQuery("#font-size-slider").children(".ui-slider-handle").text(curActiveStyles['font-size']);
		}
		if('line-height' in curActiveStyles){
			jQuery('input[name="css_line-height"]').val(curActiveStyles['line-height']);
			jQuery("#line-height-slider").slider("value", curActiveStyles['line-height'].replace('px', ''));
			jQuery("#line-height-slider").children(".ui-slider-handle").text(curActiveStyles['line-height']);
		}
		if('font-weight' in curActiveStyles){
			jQuery('input[name="css_font-weight"]').val(curActiveStyles['font-weight']);
			jQuery("#font-weight-slider").slider("value", curActiveStyles['font-weight']);
			jQuery("#font-weight-slider").children(".ui-slider-handle").text(curActiveStyles['font-weight']);
		}
		if('border-width' in curActiveStyles){
			if(curActiveStyles['border-width'] !== 0){
				jQuery('input[name="css_border-width"]').val(curActiveStyles['border-width']);
				
				if(curActiveStyles['border-width'].split(' ').length > 1){			
					var firstBorderWidth = curActiveStyles['border-width'].split(' ')[0];
					jQuery("#border-width-slider").slider("value", firstBorderWidth.replace('px', ''));
					jQuery("#border-width-slider").children(".ui-slider-handle").text(firstBorderWidth);
					
					showExpertWarning = true;
				}else{
					jQuery("#border-width-slider").slider("value", curActiveStyles['border-width'].replace('px', ''));
					jQuery("#border-width-slider").children(".ui-slider-handle").text(curActiveStyles['border-width']);
				}
				
			}
		}
		if('background-transparency' in curActiveStyles){
			if(curActiveStyles['border-width'] !== 0){
				jQuery('input[name="css_background-transparency"]').val(curActiveStyles['background-transparency']);
				jQuery("#background-transparency-slider").slider("value", curActiveStyles['background-transparency'] * 100);
				jQuery("#background-transparency-slider").children(".ui-slider-handle").text(Math.floor(curActiveStyles['background-transparency'] * 100) +'%');
			}
		}else if('background-color' in curActiveStyles){
			var bgc_length = curActiveStyles['background-color'].split(',');
			if(bgc_length.length == 4){
				var transparency = jQuery.trim(bgc_length[3].replace(')', ''));
				curActiveStyles['background-transparency'] = transparency;
				jQuery('input[name="css_background-transparency"]').val(transparency);
				jQuery("#background-transparency-slider").slider("value", transparency * 100);
				jQuery("#background-transparency-slider").children(".ui-slider-handle").text(Math.floor(transparency * 100) +'%');
			}
		}
		
		if('font-family' in curActiveStyles)	jQuery('input[name="css_font-family"]').val(curActiveStyles['font-family']);
		if('color' in curActiveStyles)			jQuery('input[name="css_color"]').val(UniteAdminRev.rgb2hex(curActiveStyles['color']));
		if('background-color' in curActiveStyles)jQuery('input[name="css_background-color"]').val(UniteAdminRev.rgb2hex(curActiveStyles['background-color']));
		
		jQuery('input[name="css_font-style"]').attr('checked', false);
		if('font-style' in curActiveStyles){
			if(curActiveStyles['font-style'] == 'italic') jQuery('input[name="css_font-style"]').attr('checked', true);
		}
		
		if('text-decoration' in curActiveStyles){
			jQuery('select[name="css_text-decoration"]').val(curActiveStyles['text-decoration']);
		}
		
		
		if('border-color' in curActiveStyles){
			var borderColor = UniteAdminRev.rgb2hex(curActiveStyles['border-color']);
			if(borderColor.split(' ').length > 1){
				var firstBorderColor = borderColor.split(' ')[0];
				jQuery('input[name="css_border-color"]').val(borderColor);
				jQuery('input[name="css_border-color-show"]').val(firstBorderColor);
				
				showExpertWarning = true;
			}else{
				jQuery('input[name="css_border-color"]').val(borderColor);
				jQuery('input[name="css_border-color-show"]').val(borderColor);
			}
		}
		
		if('border-style' in curActiveStyles){
			if(curActiveStyles['border-style'].split(' ').length > 1){			
				var firstBorderStyle = curActiveStyles['border-style'].split(' ')[0];
				jQuery('select[name="css_border-style"]').val(firstBorderStyle);
				
				showExpertWarning = true;
			}else{
				jQuery('select[name="css_border-style"]').val(curActiveStyles['border-style']);
			}
		}
		
		if('color' in curActiveStyles) jQuery('input[name="css_color"]').css('background-color', UniteAdminRev.rgb2hex(curActiveStyles['color']));
		if('background-color' in curActiveStyles) jQuery('input[name="css_background-color"]').css('background-color', UniteAdminRev.rgb2hex(curActiveStyles['background-color']));
		if('border-color' in curActiveStyles){
			if(borderColor.split(' ').length > 1){
				var firstBorderColor = borderColor.split(' ')[0];
				jQuery('input[name="css_border-color-show"]').css('background-color', UniteAdminRev.rgb2hex(firstBorderColor));
			}else{
				jQuery('input[name="css_border-color-show"]').css('background-color', UniteAdminRev.rgb2hex(borderColor));
			}
		}
		
		if('padding' in curActiveStyles){
			
			var paddings = UniteAdminRev.parseCssMultiAttribute(curActiveStyles['padding']);
			
			var i = 0;
			jQuery('input[name="css_padding[]"]').each(function(){
				if(paddings !== false)
					jQuery(this).val(paddings[i].replace('px', ''));
				else
					jQuery(this).val('');
					
				i++;
			});
		}
		if('padding-top' in curActiveStyles)	jQuery('input[name="css_padding[]"]:eq(0)').val(curActiveStyles['padding-top'].replace('px', ''));
		if('padding-right' in curActiveStyles)	jQuery('input[name="css_padding[]"]:eq(1)').val(curActiveStyles['padding-right'].replace('px', ''));
		if('padding-bottom' in curActiveStyles)	jQuery('input[name="css_padding[]"]:eq(2)').val(curActiveStyles['padding-bottom'].replace('px', ''));
		if('padding-left' in curActiveStyles)	jQuery('input[name="css_padding[]"]:eq(3)').val(curActiveStyles['padding-left'].replace('px', ''));
		
		
		if('border-radius' in curActiveStyles){
			var corners = UniteAdminRev.parseCssMultiAttribute(curActiveStyles['border-radius']);
			var i = 0;
			jQuery('input[name="css_border-radius[]"]').each(function(){ 
				if(corners !== false)
					jQuery(this).val(corners[i].replace('px', ''));
				else
					jQuery(this).val('');
					
				i++;
			});
		}
		if('border-top-left-radius' in curActiveStyles)		jQuery('input[name="css_border-radius[]"]:eq(0)').val(curActiveStyles['border-top-left-radius'].replace('px', ''));
		if('border-top-right-radius' in curActiveStyles)	jQuery('input[name="css_border-radius[]"]:eq(1)').val(curActiveStyles['border-top-right-radius'].replace('px', ''));
		if('border-bottom-right-radius' in curActiveStyles)	jQuery('input[name="css_border-radius[]"]:eq(2)').val(curActiveStyles['border-bottom-right-radius'].replace('px', ''));
		if('border-bottom-left-radius' in curActiveStyles)	jQuery('input[name="css_border-radius[]"]:eq(3)').val(curActiveStyles['border-bottom-left-radius'].replace('px', ''));
		
		if(showExpertWarning){
			showCssExpertWarning();
		}else{
			hideCssExpertWarning();
		}
	}
	
	/**
	 * set the css example preview in dialog
	 */
	var setCssPreview = function(){
		jQuery('#css_preview').attr('styles', ''); //clear all styles from preview
		
		if(typeof curActiveStyles === 'object' && !jQuery.isEmptyObject(curActiveStyles)){
			for(var attr in curActiveStyles){
				if(attr == 'position') continue; //ignore position absolute
				jQuery('#css_preview').css(attr, curActiveStyles[attr]);
			}
		}
	}
	
	
	/**
	 * set the css example preview in dialog on resize
	 */
	t.setCssPreviewLive = function(){
		if(cssExpertEditor){
			setStylesFromExpert();
		}else{
			//add novice styles
			jQuery('#css_preview').attr('style', ''); 
			var borderColor = (jQuery('input[name="css_border-color"]').val() != ' ') ? jQuery('input[name="css_border-color"]').val() : '';
			jQuery('#css_preview').css('font-size', jQuery('input[name="css_font-size"]').val());
			jQuery('#css_preview').css('line-height', jQuery('input[name="css_line-height"]').val());
			jQuery('#css_preview').css('font-weight', jQuery('input[name="css_font-weight"]').val());
			jQuery('#css_preview').css('border-width', jQuery('input[name="css_border-width"]').val());
			jQuery('#css_preview').css('font-family', jQuery('input[name="css_font-family"]').val());
			jQuery('#css_preview').css('color', jQuery('input[name="css_color"]').val());
			jQuery('#css_preview').css('border-color', borderColor);
			jQuery('#css_preview').css('border-style', jQuery('select[name="css_border-style"]').val());
			var italic = (jQuery('input[name="css_font-style"]').is(':checked')) ? 'italic' : '';
			jQuery('#css_preview').css('font-style', italic);
			jQuery('#css_preview').css('text-decoration', jQuery('select[name="css_text-decoration"]').val());
			
			if(jQuery('input[name="css_background-color"]').val() != 'transparent'){
				var rgb = UniteAdminRev.convertHexToRGB(jQuery('input[name="css_background-color"]').val());
				
				var transparency = (jQuery('input[name="css_background-transparency"]').val() != '') ? transparency = jQuery('input[name="css_background-transparency"]').val() : 1;
				jQuery('input[name="css_background-transparency"]').val(transparency);
				jQuery('#css_preview').css('background-color', 'rgba('+rgb[0]+', '+rgb[1]+', '+rgb[2]+', '+transparency+')');
			}else{
				jQuery('#css_preview').css('background-color', jQuery('input[name="css_background-color"]').val());
			}
			
			var padding = '';
			jQuery('input[name="css_padding[]"]').each(function(){
				if(padding != '') padding += ' ';
				padding += (jQuery(this).val() == '') ? '' : parseInt(jQuery(this).val())+'px';
			});
			jQuery('#css_preview').css('padding', padding);
			
			var corners = '';
			jQuery('input[name="css_border-radius[]"]').each(function(){
				if(corners != '') corners += ' ';
				corners += (jQuery(this).val() == '') ? '' : parseInt(jQuery(this).val())+'px';
			});
			jQuery('#css_preview').css('border-radius', corners);
			
			isHoverActive = (jQuery('input[name="css_allow"]').is(':checked')) ? true : false;
			
			setPreviewFromExpert();
			return false;
		}
		
		setActiveStylesFromExample();
		updateCurFullClass();
	}
	
	/**
	 * set styles from expert editor
	 */
	var setStylesFromExpert = function(){
		var cssData = g_codemirrorCssExpert.getValue();
		while(cssData.indexOf("/*") !== -1){
			if(cssData.indexOf("*/") === -1) return false;
			var start = cssData.indexOf("/*");
			var end = cssData.indexOf("*/") + 2;
			cssData = cssData.replace(cssData.substr(start, end - start), '');
		}
		
		//delete all before the }
		if(cssData.indexOf('{') > -1){
			var temp = cssData.substr(0,cssData.indexOf('{'));
			cssData = cssData.replace(temp, '');
		}
		
		//delete all after the }
		if(cssData.indexOf('}') > -1){
			cssData = cssData.substr(0,cssData.indexOf('}'));
		}
		
		cssData = cssData.replace(/{/g, '').replace(/}/g, '').replace(/	/g, '').replace(/\n/g, '');
		
		jQuery('#css_preview').attr('style', cssData);
		if(jQuery('#css_preview').css('position') == 'absolute') jQuery('#css_preview').css('position', '');
		
	}
	
	/**
	 * create curActiveStyles object depending on novice/expert mode
	 */
	var setActiveStylesFromExample = function(){
	
		curActiveStyles = new Object;
		var rawStyles = jQuery('#css_preview').attr('style').split(';');
		
		for(key in rawStyles){
			var temp = new String(rawStyles[key]);
            temp = temp.split(':');
			//alert('now: '+temp[0]+ '||'+temp[1]+ '||'+temp[2]);
			if(jQuery.trim(temp[0]) == '' || jQuery.trim(temp[1]) == '') continue;
			if(temp[0].toLowerCase().indexOf("border") >= 0) continue; //all borders later
			
			var cur_attr = jQuery.trim(temp[0]);
			var cur_style = temp[1];
			
			if(typeof(temp[2]) !== 'undefined'){
				delete temp[0];
				cur_style = temp[1]+':'+temp[2];
			}
			curActiveStyles[cur_attr] = jQuery.trim(cur_style);
		}
		
		//handle borders
		if(jQuery('#css_preview').css('borderTopLeftRadius') != '0px' || jQuery('#css_preview').css('borderTopRightRadius') != '0px' || jQuery('#css_preview').css('borderBottomRightRadius') != '0px' || jQuery('#css_preview').css('borderBottomLeftRadius') != '0px'){
			curActiveStyles['border-radius'] = Math.round(jQuery('#css_preview').css('borderTopLeftRadius').replace('px', ''))+'px '+Math.round(jQuery('#css_preview').css('borderTopRightRadius').replace('px', ''))+'px '+Math.round(jQuery('#css_preview').css('borderBottomRightRadius').replace('px', ''))+'px '+Math.round(jQuery('#css_preview').css('borderBottomLeftRadius').replace('px', ''))+'px';
		}
		
		if(jQuery('#css_preview').css('borderTopWidth') == jQuery('#css_preview').css('borderRightWidth') &&
			jQuery('#css_preview').css('borderTopWidth') == jQuery('#css_preview').css('borderBottomWidth') &&
			jQuery('#css_preview').css('borderTopWidth') == jQuery('#css_preview').css('borderLeftWidth')){
			curActiveStyles['border-width'] = jQuery('#css_preview').css('borderTopWidth');
		}else{
			curActiveStyles['border-width'] = jQuery('#css_preview').css('borderTopWidth')+' '+jQuery('#css_preview').css('borderRightWidth')+' '+jQuery('#css_preview').css('borderBottomWidth')+' '+jQuery('#css_preview').css('borderLeftWidth');
		}
		
		if(jQuery('#css_preview').css('borderTopColor') == jQuery('#css_preview').css('borderRightColor') &&
			jQuery('#css_preview').css('borderTopColor') == jQuery('#css_preview').css('borderBottomColor') &&
			jQuery('#css_preview').css('borderTopColor') == jQuery('#css_preview').css('borderLeftColor')){
			curActiveStyles['border-color'] = jQuery('#css_preview').css('borderTopColor');
		}else{
			curActiveStyles['border-color'] = jQuery('#css_preview').css('borderTopColor')+' '+jQuery('#css_preview').css('borderRightColor')+' '+jQuery('#css_preview').css('borderBottomColor')+' '+jQuery('#css_preview').css('borderLeftColor');
		}
		
		if(jQuery('#css_preview').css('borderTopStyle') == jQuery('#css_preview').css('borderBottomStyle') &&
			jQuery('#css_preview').css('borderTopStyle') == jQuery('#css_preview').css('borderLeftStyle') &&
			jQuery('#css_preview').css('borderTopStyle') == jQuery('#css_preview').css('borderRightStyle')){
			curActiveStyles['border-style'] = jQuery('#css_preview').css('borderTopStyle');
		}else{
			curActiveStyles['border-style'] = jQuery('#css_preview').css('borderTopStyle')+' '+jQuery('#css_preview').css('borderRightStyle')+' '+jQuery('#css_preview').css('borderBottomStyle')+' '+jQuery('#css_preview').css('borderLeftStyle');
		}
		
	}
	
	/**
	 * set the params from expert
	 */
	var setPreviewFromExpert = function(){
		if(typeof curActiveStyles !== 'object' || jQuery.isEmptyObject(curActiveStyles)) return false;
		
		for(var key in curActiveStyles){
			switch(key){ //all but default are values that exist in novice mode, ignore them
				case 'position':
				case 'padding-top':
				case 'padding-right':
				case 'padding-bottom':
				case 'padding-left':
				case 'border-top-left-radius':
				case 'border-top-right-radius':
				case 'border-bottom-right-radius':
				case 'border-bottom-left-radius':
				case 'font-size':
				case 'line-height':
				case 'font-weight':
				case 'border-width':
				case 'font-family':
				case 'color':
				case 'background-color':
				case 'border-style':
				case 'background-transparency':
				case 'padding':
				case 'border-radius':
				case 'border-color':
				case 'font-style':
				case 'text-decoration':
					break;
				default:
					jQuery('#css_preview').css(key, curActiveStyles[key]);
			}
		}
	}
	
	
	/**
	 * insert the styles into the expert editor
	 */
	t.setCssStylesExpert = function(ignoreExample){
		jQuery("#textarea_edit_expert").val('');
		
		var cssData = "{\n"; 
		
		if(typeof ignoreExample === 'undefined') updateActiveStylesWithNovice();
		
		for(var attr in curActiveStyles){
			if(jQuery.trim(curActiveStyles[attr]) == '') continue;
			if(attr == 'background-color' && curActiveStyles[attr] !== 'transparent'){
				if(curActiveStyles[attr].indexOf('rgb') == -1){
					var rgb = UniteAdminRev.convertHexToRGB(curActiveStyles[attr]);
					cssData += '	'+attr+': rgb('+rgb[0]+', '+rgb[1]+', '+rgb[2]+')'+";\n";
					cssData += '	'+attr+': rgba('+rgb[0]+', '+rgb[1]+', '+rgb[2]+', '+curActiveStyles['background-transparency']+')'+";\n";
				}else{
					cssData += '	'+attr+': '+curActiveStyles[attr]+";\n";
				}
			}else{
				if(attr == 'background-transparency') continue;
				cssData += '	'+attr+': '+curActiveStyles[attr]+";\n";
			}
		}

		cssData += "}";
		
		if(g_codemirrorCssExpert != null){
			g_codemirrorCssExpert.setValue(cssData);
		}else{
			jQuery("#textarea_edit_expert").val(cssData);
			t.setCodeMirrorEditor();
		}
		g_codemirrorCssExpert.refresh();
	}
	
	/**
	 * set temp object and call novice update
	 */
	t.setCssStylesNovice = function(ignoreExample){
		resetNoviceFields(); //reset the novice fields
		
		if(typeof ignoreExample === 'undefined') setActiveStylesFromExample()//set styles from example
		
		setNoviceFields(); //set novice fields from cssActiveStyles
		
		setCssPreview(); //fill the preview with styles
		//t.setCssPreviewLive();
	}
	
	/**
	 * update the curActiveStyles from Novice fields
	 */
	var updateActiveStylesWithNovice = function(){
		//remove obsolete padding and corner!
		delete curActiveStyles['padding-top'];
		delete curActiveStyles['padding-right'];
		delete curActiveStyles['padding-bottom'];
		delete curActiveStyles['padding-left'];
		delete curActiveStyles['border-top-left-radius'];
		delete curActiveStyles['border-top-right-radius'];
		delete curActiveStyles['border-bottom-right-radius'];
		delete curActiveStyles['border-bottom-left-radius'];

		var borderColor = (jQuery('input[name="css_border-color"]').val() != ' ') ? jQuery('input[name="css_border-color"]').val() : null;
		
		curActiveStyles['font-size'] = jQuery('input[name="css_font-size"]').val();
		curActiveStyles['line-height'] = jQuery('input[name="css_line-height"]').val();
		curActiveStyles['font-weight'] = jQuery('input[name="css_font-weight"]').val();
		curActiveStyles['font-family'] = jQuery('input[name="css_font-family"]').val();
		curActiveStyles['color'] = jQuery('input[name="css_color"]').val();
		curActiveStyles['background-color'] = jQuery('input[name="css_background-color"]').val();
		curActiveStyles['background-transparency'] = jQuery('input[name="css_background-transparency"]').val();
		curActiveStyles['font-style'] = (jQuery('input[name="css_font-style"]').is(':checked')) ? 'italic' : '';
		curActiveStyles['text-decoration'] = jQuery('select[name="css_text-decoration"]').val();
		
		if(curActiveStyles['font-style'] == '') delete curActiveStyles['font-style'];
		
		//don`t update if expert warning is shown
		if(!showExpertWarning){
			curActiveStyles['border-width'] = jQuery('input[name="css_border-width"]').val();
			curActiveStyles['border-style'] = jQuery('select[name="css_border-style"]').val();
			curActiveStyles['border-radius'] = filterCssPadCor('input[name="css_border-radius[]"]');
			if(borderColor != null)
				curActiveStyles['border-color'] =  borderColor;
			else
				delete curActiveStyles['border-color'];
			
		}
		
		curActiveStyles['padding'] = filterCssPadCor('input[name="css_padding[]"]');
		
		if(curActiveStyles['padding'] === false) delete curActiveStyles['padding'];
		if(curActiveStyles['border-radius'] === false) delete curActiveStyles['border-radius'];
	}
	
	/**
	 * set the expert/novice from curActiveStyles
	 */
	var updateEditorFromActiveStyles = function(){
		cssExpertEditor = (jQuery("#css-editor-accordion").accordion("option").active == 0) ? false : true;
		if(cssExpertEditor) t.setCssStylesExpert(true);
		if(!cssExpertEditor) t.setCssStylesNovice(true);
	}
	
	/**
	 * delete class from db if exists
	 */
	var deleteStylesInDb = function(handle, id){
		UniteAdminRev.setErrorMessageID("dialog_error_message");
		
		UniteAdminRev.ajaxRequest("delete_captions_css",handle,function(response){
			jQuery("#dialog_success_message").show().html(response.message);
		
			//update html select (got as "data" from response)
			updateCaptionsInput(response.arrCaptions);
		});
		
		updateInitCssStyles(handle, id, true);
		
		jQuery('#layer_caption').val('');
		
		curFullClass = new Object;
		curActiveStyles = new Object;
		cssCurrentEdit = '';
		
		//refresh styles
		setTimeout(function() {
			if(urlCssCaptions)
				UniteAdminRev.loadCssFile(urlCssCaptions,"rs-plugin-captions-css");
		},1000);
	}
	
	/**
	 * update styles for class/create new class
	 */
	var updateStylesInDb = function(handle, id){
		
		UniteAdminRev.setErrorMessageID("dialog_error_message");
		
		var temp = new Object;
		jQuery.each(curFullClass, function(i, val){
			var newObj = jQuery.extend(true, {}, val);
			temp[i] = newObj;
		});
		
		temp['handle'] = handle;
		temp['settings'] = new Object;
		temp['settings']['hover'] = isHoverActive;

		
		if(id === false){ //create new
			//insert in database
			UniteAdminRev.ajaxRequest("insert_captions_css",temp,function(response){
				jQuery("#dialog_success_message").show().html(response.message);
			
				//update html select (got as "data" from response)
				updateCaptionsInput(response.arrCaptions);
			});
			
		}else{ //update existing
			
			//update to database
			UniteAdminRev.ajaxRequest("update_captions_css",temp,function(response){
				jQuery("#dialog_success_message").show().html(response.message);
			
				//update html select (got as "data" from response)
				updateCaptionsInput(response.arrCaptions);
			});
			
		}
		updateInitCssStyles(handle, id);
		
		curFullClass = new Object;
		curActiveStyles = new Object;
		cssCurrentEdit = '';
		
		//refresh styles
		setTimeout(function() {
			if(urlCssCaptions)
				UniteAdminRev.loadCssFile(urlCssCaptions,"rs-plugin-captions-css");
		},1000);
		
	}
	
	
	/**
	 * check if class exists and return index
	 */
	var checkIfHandleExists = function(handle){
		for(var key in initCssStyles){
			if(initCssStyles[key]['handle'] == cssPreClass+'.'+handle){
				return key;
			}
		}
		return false;
	}
	
	/**
	 * update the select html, set selected option, and update events.
	 */
	var updateCaptionsInput = function(arrCaptions){
		jQuery("#layer_caption").autocomplete("option","source",arrCaptions);
	}
	
	/**
	 * update css object with new values
	 */
	var updateInitCssStyles = function(handle, id, doDelete){
		var key = false;
		
		for(var i in initCssStyles){
			if(initCssStyles[i]['handle'] == cssPreClass+'.'+handle){
				key = i;
				break;
			}
		}
		
		if(typeof doDelete !== 'undefined'){
			delete initCssStyles[key];
			return true;
		}
		
		if(key === false) key = initCssStyles.length;
		
		if(id === false){
			id = initCssStyles.length;
			initCssStyles[key] = new Object;
			initCssStyles[key]['id'] = id;
			initCssStyles[key]['handle'] = cssPreClass+'.'+handle;
			initCssStyles[key]['params'] = [];
			initCssStyles[key]['hover'] = [];
			initCssStyles[key]['settings'] = [];
		}
		
		initCssStyles[key]['params'] = curFullClass['params'];
		initCssStyles[key]['hover'] = curFullClass['hover'];
		initCssStyles[key]['settings'] = new Object;
		initCssStyles[key]['settings']['hover'] = isHoverActive;
		
		return initCssStyles[key];
	}
	
	
	//======================================================
	//	Codemirror Functions
	//======================================================
	
	/**
	 * set code mirror editor
	 */
	t.setCodeMirrorEditor = function(){
		g_codemirrorCssExpert = CodeMirror.fromTextArea(document.getElementById("textarea_edit_expert"), {
			onChange: function(){ if(cssExpertEditor){ t.setCssPreviewLive(); }},
			lineNumbers: true
		});
		
	}
	
	//======================================================
	//	End of Codemirror Functions
	//======================================================
	
}