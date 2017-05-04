
/*!
 * VERSION: beta 0.2.3
 * DATE: 2013-07-10
 * UPDATES AND DOCS AT: http://www.greensock.com
 *
 * @license Copyright (c) 2008-2013, GreenSock. All rights reserved.
 * SplitText is a Club GreenSock membership benefit; You must have a valid membership to use
 * this code without violating the terms of use. Visit http://www.greensock.com/club/ to sign up or get more details.
 * This work is subject to the software agreement that was issued with your membership.
 *
 * @author: Jack Doyle, jack@greensock.com
 */
(function(t){"use strict";var e=t.GreenSockGlobals||t,i=function(t){var i,s=t.split("."),r=e;for(i=0;s.length>i;i++)r[s[i]]=r=r[s[i]]||{};return r},s=i("com.greensock.utils"),r=function(t){var e=t.nodeType,i="";if(1===e||9===e||11===e){if("string"==typeof t.textContent)return t.textContent;for(t=t.firstChild;t;t=t.nextSibling)i+=r(t)}else if(3===e||4===e)return t.nodeValue;return i},n=document,a=n.defaultView?n.defaultView.getComputedStyle:function(){},o=/([A-Z])/g,h=function(t,e,i,s){var r;return(i=i||a(t,null))?(t=i.getPropertyValue(e.replace(o,"-$1").toLowerCase()),r=t||i.length?t:i[e]):t.currentStyle&&(i=t.currentStyle,r=i[e]),s?r:parseInt(r,10)||0},l=function(t){return t.length&&t[0]&&(t[0].nodeType&&t[0].style&&!t.nodeType||t[0].length&&t[0][0])?!0:!1},_=function(t){var e,i,s,r=[],n=t.length;for(e=0;n>e;e++)if(i=t[e],l(i))for(s=i.length,s=0;i.length>s;s++)r.push(i[s]);else r.push(i);return r},u=")eefec303079ad17405c",c=/(?:<br>|<br\/>|<br \/>)/gi,p=n.all&&!n.addEventListener,f="<div style='position:relative;display:inline-block;"+(p?"*display:inline;*zoom:1;'":"'"),m=function(t){t=t||"";var e=-1!==t.indexOf("++"),i=1;return e&&(t=t.split("++").join("")),function(){return f+(t?" class='"+t+(e?i++:"")+"'>":">")}},d=s.SplitText=e.SplitText=function(t,e){if("string"==typeof t&&(t=d.selector(t)),!t)throw"cannot split a null element.";this.elements=l(t)?_(t):[t],this.chars=[],this.words=[],this.lines=[],this._originals=[],this.vars=e||{},this.split(e)},g=function(t,e,i,s,o){c.test(t.innerHTML)&&(t.innerHTML=t.innerHTML.replace(c,u));var l,_,p,f,d,g,v,y,T,w,b,x,P,S=r(t),C=e.type||e.split||"chars,words,lines",k=-1!==C.indexOf("lines")?[]:null,R=-1!==C.indexOf("words"),A=-1!==C.indexOf("chars"),D="absolute"===e.position||e.absolute===!0,O=D?"&#173; ":" ",M=-999,L=a(t),I=h(t,"paddingLeft",L),E=h(t,"borderBottomWidth",L)+h(t,"borderTopWidth",L),N=h(t,"borderLeftWidth",L)+h(t,"borderRightWidth",L),F=h(t,"paddingTop",L)+h(t,"paddingBottom",L),U=h(t,"paddingLeft",L)+h(t,"paddingRight",L),X=h(t,"textAlign",L,!0),z=t.clientHeight,B=t.clientWidth,j=S.length,Y="</div>",q=m(e.wordsClass),V=m(e.charsClass),Q=-1!==(e.linesClass||"").indexOf("++"),G=e.linesClass;for(Q&&(G=G.split("++").join("")),p=q(),f=0;j>f;f++)g=S.charAt(f),")"===g&&S.substr(f,20)===u?(p+=Y+"<BR/>",f!==j-1&&(p+=" "+q()),f+=19):" "===g&&" "!==S.charAt(f-1)&&f!==j-1?(p+=Y,f!==j-1&&(p+=O+q())):p+=A&&" "!==g?V()+g+"</div>":g;for(t.innerHTML=p+Y,d=t.getElementsByTagName("*"),j=d.length,v=[],f=0;j>f;f++)v[f]=d[f];if(k||D)for(f=0;j>f;f++)y=v[f],_=y.parentNode===t,(_||D||A&&!R)&&(T=y.offsetTop,k&&_&&T!==M&&"BR"!==y.nodeName&&(l=[],k.push(l),M=T),D&&(y._x=y.offsetLeft,y._y=T,y._w=y.offsetWidth,y._h=y.offsetHeight),k&&(R!==_&&A||(l.push(y),y._x-=I),_&&f&&(v[f-1]._wordEnd=!0)));for(f=0;j>f;f++)y=v[f],_=y.parentNode===t,"BR"!==y.nodeName?(D&&(b=y.style,R||_||(y._x+=y.parentNode._x,y._y+=y.parentNode._y),b.left=y._x+"px",b.top=y._y+"px",b.position="absolute",b.display="block",b.width=y._w+1+"px",b.height=y._h+"px"),R?_?s.push(y):A&&i.push(y):_?(t.removeChild(y),v.splice(f--,1),j--):!_&&A&&(T=!k&&!D&&y.nextSibling,t.appendChild(y),T||t.appendChild(n.createTextNode(" ")),i.push(y))):k||D?(t.removeChild(y),v.splice(f--,1),j--):R||t.appendChild(y);if(k){for(D&&(w=n.createElement("div"),t.appendChild(w),x=w.offsetWidth+"px",T=w.offsetParent===t?0:t.offsetLeft,t.removeChild(w)),b=t.style.cssText,t.style.cssText="display:none;";t.firstChild;)t.removeChild(t.firstChild);for(P=!D||!R&&!A,f=0;k.length>f;f++){for(l=k[f],w=n.createElement("div"),w.style.cssText="display:block;text-align:"+X+";position:"+(D?"absolute;":"relative;"),G&&(w.className=G+(Q?f+1:"")),o.push(w),j=l.length,d=0;j>d;d++)"BR"!==l[d].nodeName&&(y=l[d],w.appendChild(y),P&&(y._wordEnd||R)&&w.appendChild(n.createTextNode(" ")),D&&(0===d&&(w.style.top=y._y+"px",w.style.left=I+T+"px"),y.style.top="0px",T&&(y.style.left=y._x-T+"px")));R||A||(w.innerHTML=r(w).split(String.fromCharCode(160)).join(" ")),D&&(w.style.width=x,w.style.height=y._h+"px"),t.appendChild(w)}t.style.cssText=b}D&&(z>t.clientHeight&&(t.style.height=z-F+"px",z>t.clientHeight&&(t.style.height=z+E+"px")),B>t.clientWidth&&(t.style.width=B-U+"px",B>t.clientWidth&&(t.style.width=B+N+"px")))},v=d.prototype;v.split=function(t){this.isSplit&&this.revert(),this.vars=t||this.vars,this._originals.length=this.chars.length=this.words.length=this.lines.length=0;for(var e=0;this.elements.length>e;e++)this._originals[e]=this.elements[e].innerHTML,g(this.elements[e],this.vars,this.chars,this.words,this.lines);return this.isSplit=!0,this},v.revert=function(){if(!this._originals)throw"revert() call wasn't scoped properly.";for(var t=this._originals.length;--t>-1;)this.elements[t].innerHTML=this._originals[t];return this.chars=[],this.words=[],this.lines=[],this.isSplit=!1,this},d.selector=t.$||t.jQuery||function(e){return t.$?(d.selector=t.$,t.$(e)):n?n.getElementById("#"===e.charAt(0)?e.substr(1):e):e}})(window||{});



/*! ROTATABLE */
// ROTATABLE
(function( $, undefined ) {

$.widget("ui.rotatable", $.ui.mouse, {

    options: {
        handle: false,
        angle: false,

        // callbacks
        start: null,
        rotate: null,
        stop: null
    },

    handle: function(handle) {
        if (handle === undefined) {
            return this.options.handle;
        }
        this.options.handle = handle;
    },

    angle: function(angle) {
        if (angle === undefined) {
            return this.options.angle;
        }
        this.options.angle = angle;
        this.performRotation(this.options.angle);
    },

    _create: function() {
        var handle;
        if (!this.options.handle) {
            handle = $(document.createElement('div'));
            handle.addClass('ui-rotatable-handle');
        }
        else {
            handle = this.options.handle;
        }

        this.listeners = {
            rotateElement: $.proxy(this.rotateElement, this),
            startRotate: $.proxy(this.startRotate, this),
            stopRotate: $.proxy(this.stopRotate, this)
        };

        handle.draggable({ helper: 'clone', start: this.dragStart, handle: handle });
        handle.bind('mousedown', this.listeners.startRotate);
        handle.appendTo(this.element);

        if(this.options.angle != false) {
            this.elementCurrentAngle = this.options.angle;
            this.performRotation(this.elementCurrentAngle);
        }
        else {
            this.elementCurrentAngle = 0;
        }
    },



    _destroy: function() {
        this.element.removeClass('ui-rotatable');
        this.element.find('.ui-rotatable-handle').remove();
    },

    performRotation: function(angle) {
    	
    	var deg = angle * 180 / Math.PI;
        this.element.css('transform','rotate(' + deg + 'deg)');
        this.element.css('-moz-transform','rotate(' + deg + 'deg)');
        this.element.css('-webkit-transform','rotate(' + deg + 'deg)');
        this.element.css('-o-transform','rotate(' + deg + 'deg)');
        
/*        this.element.css('transform','rotate(' + angle + 'rad)');
        this.element.css('-moz-transform','rotate(' + angle + 'rad)');
        this.element.css('-webkit-transform','rotate(' + angle + 'rad)');
        this.element.css('-o-transform','rotate(' + angle + 'rad)');*/
    },

    getElementOffset: function() {
        this.performRotation(0);
        var offset = this.element.offset();
        this.performRotation(this.elementCurrentAngle);
        return offset;
    },

    getElementCenter: function() {
        var elementOffset = this.getElementOffset();
        var elementCentreX = elementOffset.left + this.element.width() / 2;
        var elementCentreY = elementOffset.top + this.element.height() / 2;
        return Array(elementCentreX, elementCentreY);
    },

    dragStart: function(event) {
        if (this.element) {
            return false;
        }
    },

    startRotate: function(event) {
        var center = this.getElementCenter();
        var startXFromCenter = event.pageX - center[0];
        var startYFromCenter = event.pageY - center[1];
        this.mouseStartAngle = Math.atan2(startYFromCenter, startXFromCenter);
        this.elementStartAngle = this.elementCurrentAngle;
        this.hasRotated = false;

        this._propagate("start", event);

        $(document).bind('mousemove', this.listeners.rotateElement);
        $(document).bind('mouseup', this.listeners.stopRotate);

        return false;
    },

    rotateElement: function(event) {
        if (!this.element) {
            return false;
        }

        var center = this.getElementCenter();

        var xFromCenter = event.pageX - center[0];
        var yFromCenter = event.pageY - center[1];
        var mouseAngle = Math.atan2(yFromCenter, xFromCenter);
        var rotateAngle = mouseAngle - this.mouseStartAngle + this.elementStartAngle;

        this.performRotation(rotateAngle);
        var previousRotateAngle = this.elementCurrentAngle;
        this.elementCurrentAngle = rotateAngle;

        // Plugins callbacks need to be called first.
        this._propagate("rotate", event);

        if (previousRotateAngle != rotateAngle) {
            this._trigger("rotate", event, this.ui());
            this.hasRotated = true;
        }

        return false;
    },

    stopRotate: function(event) {
        if (!this.element) {
            return;
        }

        $(document).unbind('mousemove', this.listeners.rotateElement);
        $(document).unbind('mouseup', this.listeners.stopRotate);

        this.elementStopAngle = this.elementCurrentAngle;
        if (this.hasRotated) {
            this._propagate("stop", event);
        }

        setTimeout( function() { this.element = false; }, 10 );
        return false;
    },

    _propagate: function(n, event) {
        $.ui.plugin.call(this, n, [event, this.ui()]);
        (n !== "rotate" && this._trigger(n, event, this.ui()));
    },

    plugins: {},

    ui: function() {
        return {
            element: this.element,
            angle: {
                start: this.elementStartAngle,
                current: this.elementCurrentAngle,
                stop: this.elementStopAngle
            }
        };
    }

});

})(jQuery);

//ver 3.2

var UniteLayersRev = new function(){

	var initTop = 100;
	var initLeft = 100;
	var initSpeed = 300;

	var initTopVideo = 20;
	var initLeftVideo = 20;
	var g_startTime = 500;
	var g_stepTime = 0;
	var g_slideTime;

	var initText = "Caption Text";

	//init system vars"
	//init system vars
	var t = this;
	var initArrFontTypes = [];
	var containerID = "#divLayers";
	var container;
	var arrLayers = {};
	var id_counter = 0;
	var initLayers = null;
	var initDemoLayers = null;
	var initDemoSettings = null;
	var selectedLayerSerial = -1;

	var sortMode = "time";				//can be "depth" or "time"
	var layerGeneralParamsStatus = false;

	//Layer Animations
	var initLayerAnims = [];
	var currentAnimationType = 'customin';

	var curDemoSlideID = 0;

	/**
	 * set init layers object (from db)
	 */
	t.setInitLayersJson = function(jsonLayers){
		initLayers = jQuery.parseJSON(jsonLayers);
	}

	/**
	 * set init demo layers object (from db)
	 */
	t.setInitDemoLayersJson = function(jsonLayers){
		initDemoLayers = jQuery.parseJSON(jsonLayers);
	}

	/**
	 * set init demo settings object (from db)
	 */
	t.setInitDemoSettingsJson = function(jsonLayers){
		initDemoSettings = jQuery.parseJSON(jsonLayers);
	}

	/**
	 * set init layer animations (from db)
	 */
	t.setInitLayerAnim = function(jsonLayersAnims){
		initLayerAnims = jQuery.parseJSON(jsonLayersAnims);
	}

	/**
	 * update init layer animations (from db)
	 */
	t.updateInitLayerAnim = function(layerAnims){
		initLayerAnims = [];
		initLayerAnims = layerAnims;
	}

	/**
	 * set init captions classes array (from the captions.css)
	 */
	t.setInitCaptionClasses = function(jsonClasses){
		initArrCaptionClasses = jQuery.parseJSON(jsonClasses);
	}

	/**
	 * set init font family types array
	 */
	t.setInitFontTypes = function(jsonClasses){
		initArrFontTypes = jQuery.parseJSON(jsonClasses);
	}


	/**
	 * insert button by class and text
	 */
	t.insertButton = function(buttonClass,buttonText){
		if(selectedLayerSerial == -1)
			return(false);

		var html = "<a href='#' class='tp-button "+buttonClass+" small'>"+buttonText+"</a>";

		//jQuery("#layer_caption").val("");
		jQuery("#layer_text").val(jQuery("#layer_text").val()+html);

		t.updateLayerFromFields();

		jQuery("#dialog_insert_button").dialog("close");
	}

	/**
	 * insert template to editor
	 */
	t.insertTemplate = function(text){

		if(selectedLayerSerial == -1)
			return(false);

		jQuery("#layer_text").val(jQuery("#layer_text").val()+'%'+text+'%');

		t.updateLayerFromFields();

		jQuery("#dialog_template_insert").dialog("close");
	}

	t.refreshGridSize = function(){

		var grid_size = jQuery('#rs-grid-sizes option:selected').val();
		var snapto = jQuery('#rs-grid-snapto option:selected').val();
		var wrapper = jQuery('#divLayers');


		if (grid_size==1) {
			wrapper.find('#helpergrid').remove();
			grid_size = 1;
		} else {
				wrapper.css({position:"relative"});
				wrapper.find('#helpergrid').remove();
				wrapper.append('<div id="helpergrid" style="position:absolute;top:0px;left:0px;position:absolute;z-index:0;width:100%;height:100%"></div>');
				var hg = wrapper.find('#helpergrid');
				if (grid_size>4) {
					for (var i=1;i<(wrapper.height()/grid_size);i++) {
						var jump = i*grid_size;
						hg.append('<div class="helplines" style="background-color:#4affff;width:100%;height:1px;position:absolute;left:0px;top:'+jump+'px"></div>');
					}

					for (var i=1;i<(wrapper.width()/grid_size);i++) {
						var jump = i*grid_size;
						hg.append('<div class="helplines" style="background-color:#4affff;height:100%;width:1px;position:absolute;top:0px;left:'+jump+'px"></div>');
					}
				}


		}



		for(var key in arrLayers){
			var layer = getHtmlLayerFromSerial(key);
			//update layer events.
			layer.draggable({
					drag: onLayerDrag,	//set ondrag event
					//grid: [grid_size,grid_size],	//set the grid to 1 pixel
					snap: snapto,
					snapMode:"outer"

				});
		}


	}
	//======================================================
	//	Init Functions
	//======================================================

	/*! INITIALISATION */
	/**
	 * init the layout
	 */
	t.init = function(slideTime){

		if(jQuery().draggable == undefined || jQuery().autocomplete == undefined){
			jQuery("#jqueryui_error_message").show();
		}


		g_slideTime = Number(slideTime);

		container = jQuery(containerID);

		//add all layers from init
		if(initDemoLayers){
			var len = initDemoLayers.length;
			if(len){
				for(var i=0;i<len;i++){
					for(var key in initDemoLayers[i]){
						curDemoSlideID = i;
						addLayer(initDemoLayers[i][key],true,true);
					}
				}
			}else{
				for(var i in initDemoLayers){
					for(var key in initDemoLayers[i]){
						curDemoSlideID = i;
						addLayer(initDemoLayers[i][key],true,true);
					}
				}
			}
		}


		//add all layers from init
		if(initLayers){
			var len = initLayers.length;
			if(len){
				for(var i=0;i<len;i++)
					addLayer(initLayers[i],true);
			}else{
				for(key in initLayers)
					addLayer(initLayers[key],true);
			}
		}

		//disable the properties box
		disableFormFields();

		//init elements
		initMainEvents();
		initSortbox();
		initButtons();
		initHtmlFields();
		initAlignTable();
		scaleImage();
		positionChanged();

		//initScaleImage();
		preparePeviewAnimations();
		initBackgroundFunctions();
		initLoopFunctions();
		prepareAnimateCreator();
		jQuery('.bgsrcchanger').each(function(){
			if(jQuery(this).is(':checked'))
				initSliderMainOptions(jQuery(this));
		});

		jQuery('.bgsrcchanger').click(function() {
			initSliderMainOptions(jQuery(this));
		});

		initDisallowCaptionsOnClick();

		showHideTimeines();


		// OPEN LEFT PANEL TO FULL
		jQuery('.open_right_panel').click(function() {
			var orp = jQuery('.layer_props_wrapper')
			if (orp.hasClass("openeed")) {
				orp.removeClass("openeed");
			} else {
				orp.addClass("openeed");
			}
		})

		jQuery('#rs-grid-sizes, #rs-grid-snapto').change(function() {
			t.refreshGridSize();
		});


		jQuery('select[name="rev_show_the_slides"]').change(function(){
			jQuery('.demo_layer').hide();
			jQuery("#divbgholder").addClass("trans_bg");
			jQuery("#divbgholder").css("background-image","none");
			jQuery("#divbgholder").css("background-color","transparent");
			jQuery("#divbgholder").css("background-position","top center");
			jQuery("#divbgholder").css("background-size","cover"); //100% 100%
			jQuery("#divbgholder").css("background-repeat","no-repeat");


			if(jQuery(this).val() !== 'none'){
				var sv = jQuery(this).val();
				jQuery('.demo_layer_'+sv).show();

				if(typeof initDemoSettings[sv] !== 'undefined'){
					var bgfit = (initDemoSettings[sv]['bg_fit'] == 'percentage') ? initDemoSettings[sv]['bg_fit_x'] + '% ' + initDemoSettings[sv]['bg_fit_y'] + '% ' : initDemoSettings[sv]['bg_fit'];
					var bgpos = (initDemoSettings[sv]['bg_position'] == 'percentage') ? initDemoSettings[sv]['bg_position_x'] + '% ' + initDemoSettings[sv]['bg_position_y'] + '% ' : initDemoSettings[sv]['bg_position'];

					if(initDemoSettings[sv]['bg_fit'] == 'contain'){
						jQuery('#divLayers-wrapper').css('maxWidth', jQuery('#divbgholder').css('minWidth'));
					}else{
						jQuery('#divLayers-wrapper').css('maxWidth', 'none');
					}


					switch(initDemoSettings[sv]['background_type']){
						case "image":
							var urlImage = initDemoSettings[sv]['image'];
							jQuery("#divbgholder").css("background-image","url('"+urlImage+"')");
							jQuery("#divbgholder").css("background-color","transparent");
							jQuery("#divbgholder").css("background-size",bgfit);
							jQuery("#divbgholder").css("background-position",bgpos);
							jQuery("#divbgholder").css("background-repeat",initDemoSettings[sv]['bg_repeat']);
							jQuery("#divbgholder").removeClass("trans_bg");
						break;
						case "trans":
							jQuery("#divbgholder").css("background-image","none");
							jQuery("#divbgholder").css("background-color","transparent");
							jQuery("#divbgholder").addClass("trans_bg");
						break;
						case "solid":
							jQuery("#divbgholder").css("background-image","none");
							jQuery("#divbgholder").removeClass("trans_bg");
							var bgColor = initDemoSettings[sv]['slide_bg_color'];
							jQuery("#divbgholder").css("background-color",bgColor);
						break;
						case "external":
							var urlImage = initDemoSettings[sv]['slide_bg_external'];
							jQuery("#divbgholder").css("background-image","url('"+urlImage+"')");
							jQuery("#divbgholder").css("background-color","transparent");
							jQuery("#divbgholder").css("background-size",bgfit);
							jQuery("#divbgholder").css("background-position",bgpos);
							jQuery("#divbgholder").css("background-repeat",initDemoSettings[sv]['bg_repeat']);
							jQuery("#divbgholder").removeClass("trans_bg");
						break;
					}
				}
			}
		});


	}

	var initDisallowCaptionsOnClick = function(){

		jQuery('.slide_layer.tp-caption a').on('click', function(){
			return false;
		});

	}



	function initSliderMainOptions(jQueryObj){
		var t=jQueryObj;
		jQuery('.bgsrcchanger-div').each(function() {
			if (jQuery(this).attr('id') !="tp-bgimagesettings" || (jQuery(this).attr('id') =="tp-bgimagesettings" && t.data('imgsettings')!="on")) {
				if (jQuery(this).attr('id') =="tp-bgimagesettings")
					jQuery(this).slideUp(200)
				else
					jQuery(this).css({display:"none"});
			}
		});
		jQuery('#'+t.data('callid')).css({display:"block"});
		if (t.data('imgsettings')=="on")
			jQuery('#tp-bgimagesettings').slideDown(200);
	}


	/*! LAYER ANIMATION */
	/******************************
		-	ANIMATION CREATOR	-
	********************************/

	function prepareAnimateCreator() {
		var cic = jQuery('#caption-inout-controll');
		cic.data('direction',0);

		jQuery('#caption-inout-controll').click(function() {
			if (cic.data('direction')==0) {
				cic.data('direction',1);
				jQuery('#revshowmetheinanim').removeClass("reviconinaction");
				jQuery('#revshowmetheoutanim').addClass("reviconinaction");
			} else

			if (cic.data('direction')==1) {
				cic.data('direction',2);
				jQuery('#revshowmetheinanim').addClass("reviconinaction");
				jQuery('#revshowmetheoutanim').addClass("reviconinaction");

			} else

			if (cic.data('direction')==2) {
				cic.data('direction',0);
				jQuery('#revshowmetheinanim').addClass("reviconinaction");
				jQuery('#revshowmetheoutanim').removeClass("reviconinaction");

			}
		});
		startAnimationInCreator();

	}

	function startAnimationInCreator() {
		stopAnimationInPreview();
		animateCreatorIn();
	}

	function killAnimationInCreator() {
		  var nextcaption = jQuery('#caption_custon_anim_preview');
		 punchgs.TweenLite.killTweensOf(nextcaption,false);
	}

	function animateCreatorIn() {


					  var nextcaption = jQuery('#caption_custon_anim_preview');
					  var cic = jQuery('#caption-inout-controll');


					  var transx = jQuery('input[name="movex"]').val();
					  var transy = jQuery('input[name="movey"]').val();
					  var transz = jQuery('input[name="movez"]').val();

					  var rotatex = jQuery('input[name="rotationx"]').val();
					  var rotatey = jQuery('input[name="rotationy"]').val();
					  var rotatez = jQuery('input[name="rotationz"]').val();

					  var scalex = jQuery('input[name="scalex"]').val()/100;
					  var scaley = jQuery('input[name="scaley"]').val()/100;

					  var skewx = jQuery('input[name="skewx"]').val();
					  var skewy = jQuery('input[name="skewy"]').val();
					  var opac = jQuery('input[name="captionopacity"]').val()/100;

					  var tper = jQuery('input[name="captionperspective"]').val();
					  //var tper = 600;

					  var originx = jQuery('input[name="originx"]').val()+"%";
					  var originy = jQuery('input[name="originy"]').val()+"%";
					  var origin = originx+" "+originy;

					  var speed = parseInt(jQuery('input[name="captionspeed"]').val(),0);
					  if (speed<100) speed=100;

					  var easedata = jQuery('#caption-easing-demo').val();
					  speed=speed/1000;


					  var mdelay = (jQuery('input[name="captionsplitdelay"]').val()/100);
					  var $split = jQuery('#caption-split-demo').val();

					  var animobject = nextcaption;
					  if (nextcaption.data('mySplitText') != undefined)
						if ($split !="none") nextcaption.data('mySplitText').revert();

						if ($split == "chars" || $split == "words" || $split == "lines") {
							if (nextcaption.find('a').length>0)
								nextcaption.data('mySplitText',new SplitText(nextcaption.find('a'),{type:"lines,words,chars"}));
							 else
								nextcaption.data('mySplitText',new SplitText(nextcaption,{type:"lines,words,chars"}));
						}

						if ($split == "chars") {
							animobject = nextcaption.data('mySplitText').chars;

						}

						if ($split == "words") {
							animobject = nextcaption.data('mySplitText').words;

						}

						if ($split == "lines") {
							animobject = nextcaption.data('mySplitText').lines;

						}


					  var timedelay=((animobject.length*mdelay) + speed)*1000;


					  punchgs.TweenLite.killTweensOf(animobject,false);

					  if (animobject != nextcaption)
							 punchgs.TweenLite.set(nextcaption, { opacity:1,scaleX:1,scaleY:1,rotationX:0,rotationY:0,rotationZ:0,skewX:0,skewY:0,z:0,x:0,y:0,visibility:'visible',opacity:1,overwrite:"all"});

					  var tl=new punchgs.TimelineLite();

					  tl.staggerFromTo(animobject,speed,
										{ scaleX:scalex,
										  scaleY:scaley,
										  rotationX:rotatex,
										  rotationY:rotatey,
										  rotationZ:rotatez,
										  x:transx,
										  y:transy,
										  z:transz+1,
										  skewX:skewx,
										  skewY:skewy,
										  opacity:opac,
										  transformPerspective:tper,
										  transformOrigin:origin,
										  visibility:'hidden'},

										{
										  x:0,
										  y:0,
										  scaleX:1,
										  scaleY:1,
										  rotationX:0,
										  rotationY:0,
										  rotationZ:0,
										  skewX:0,
										  skewY:0,
										  z:1,
										  visibility:'visible',
										  opacity:1,
										  ease:easedata,
										  overwrite:"all",

										},mdelay);



					setTimeout(function() {
						if (cic.data('direction')==0)
							animateCreatorIn();
						else

						if (cic.data('direction')==1 || cic.data('direction')==2)
							animateCreatorOut()

					},(timedelay)+500)


   }


   function animateCreatorOut() {


					  var nextcaption = jQuery('#caption_custon_anim_preview');
					  var cic = jQuery('#caption-inout-controll');

					  var transx = jQuery('input[name="movex"]').val();
					  var transy = jQuery('input[name="movey"]').val();
					  var transz = jQuery('input[name="movez"]').val();

					   var $split = jQuery('#caption-split-demo').val();

					  var rotatex = jQuery('input[name="rotationx"]').val();
					  var rotatey = jQuery('input[name="rotationy"]').val();
					  var rotatez = jQuery('input[name="rotationz"]').val();

					  var scalex = jQuery('input[name="scalex"]').val()/100;
					  var scaley = jQuery('input[name="scaley"]').val()/100;

					  var skewx = jQuery('input[name="skewx"]').val();
					  var skewy = jQuery('input[name="skewy"]').val();
					  var opac = jQuery('input[name="captionopacity"]').val()/100;

					  var tper = jQuery('input[name="captionperspective"]').val();
					  //var tper = 600;

					  var originx = jQuery('input[name="originx"]').val()+"%";
					  var originy = jQuery('input[name="originy"]').val()+"%";
					  var origin = originx+" "+originy;

					  var speed = parseInt(jQuery('input[name="captionspeed"]').val(),0);
					  if (speed<100) speed=100;

					  var easedata = jQuery('#caption-easing-demo').val();
					  speed=speed/1000;

					  var xx = 258, yy=58;

					   var mdelay = (jQuery('input[name="captionsplitdelay"]').val()/100);

					   var animobject = nextcaption;
					  if (nextcaption.data('mySplitText') != undefined)
						if ($split !="none") nextcaption.data('mySplitText').revert();

						if ($split == "chars" || $split == "words" || $split == "lines") {
							if (nextcaption.find('a').length>0)
								nextcaption.data('mySplitText',new SplitText(nextcaption.find('a'),{type:"lines,words,chars"}));
							 else
								nextcaption.data('mySplitText',new SplitText(nextcaption,{type:"lines,words,chars"}));
						}

						if ($split == "chars")
							animobject = nextcaption.data('mySplitText').chars;


						if ($split == "words")
							animobject = nextcaption.data('mySplitText').words;


						if ($split == "lines")
							animobject = nextcaption.data('mySplitText').lines;

					  var timedelay=((animobject.length*mdelay) + speed)*1000;

					  punchgs.TweenLite.killTweensOf(animobject,false);

					  if (animobject != nextcaption)
							 punchgs.TweenLite.set(nextcaption, { opacity:1,scaleX:1,scaleY:1,rotationX:0,rotationY:0,rotationZ:0,skewX:0,skewY:0,z:0,x:0,y:0,visibility:'visible',opacity:1,overwrite:"all"});

					  var tl=new punchgs.TimelineLite();




					  punchgs.TweenLite.killTweensOf(animobject,false);
					  tl.staggerFromTo(animobject,speed,
										{

										  x:0,
										  y:0,
										  scaleX:1,
										  scaleY:1,
										  rotationX:0,
										  rotationY:0,
										  rotationZ:0,
										  skewX:0,
										  skewY:0,
										  z:1,
										  visibility:'visible',
										  opacity:1
										 },

										{

										  scaleX:scalex,
										  scaleY:scaley,
										  rotationX:rotatex,
										  rotationY:rotatey,
										  rotationZ:rotatez,
										  x:transx,
										  y:transy,
										  z:transz+1,
										  skewX:skewx,
										  skewY:skewy,
										  opacity:opac,
										  transformPerspective:tper,
										  transformOrigin:origin,
										  ease:easedata,
										  overwrite:"all",
										  delay:0.3,

										},mdelay);

					setTimeout(function() {
						if (cic.data('direction')==0)
							animateCreatorIn();
						else

						if (cic.data('direction')==2)
							animateCreatorIn();

						else

						if (cic.data('direction')==1 )
							animateCreatorOut();

					},(timedelay)+500)

   }


	/*********************************
	-	PREPARE THE ANIMATIONS	-
	********************************/

	function preparePeviewAnimations() {

		jQuery('#preview_looper').click(function() {
			var pl = jQuery(this);
			if (pl.hasClass("deactivated")) {
			    pl.removeClass("deactivated");
				pl.data('loop',0);
				pl.find('.replyinfo').html("ON");
			    setInAnimOfPreview();
			} else {
				pl.addClass("deactivated");
				setInAnimOfPreview();
				pl.data('loop',0);
				pl.find('.replyinfo').html("OFF");
			}
		})

		var nextcaption = jQuery('#preview_caption_animateme');
		var startanim = jQuery('#layer_animation');
		var startspeed = jQuery('#layer_speed');
		var startease = jQuery('#layer_easing');
		var endanim = jQuery('#layer_endanimation');
		var endspeed = jQuery('#layer_endspeed');
		var endease = jQuery('#layer_endeasing');



		startanim.on('change',function() {
			setInAnimOfPreview();
		});
		startspeed.on('change',function() {
			setInAnimOfPreview();
		});
		startease.on('change',function() {
			setInAnimOfPreview();
		});

		endanim.on('change',function() {
			setInAnimOfPreview();
		});
		endspeed.on('change',function() {
			setInAnimOfPreview();
		});
		endease.on('change',function() {
			setInAnimOfPreview();
		});
	}


	/******************************
		-	PLAY IN ANIMATION	-
	********************************/

	function stopAnimationInPreview() {
		var nextcaption = jQuery('#preview_caption_animateme');
		punchgs.TweenLite.killTweensOf(nextcaption,false);
		if (nextcaption.data("timer")) clearTimeout(nextcaption.data('timer'));
		if (nextcaption.data("timera")) clearTimeout(nextcaption.data('timera'));
	}

	function setInAnimOfPreview() {
		var nextcaption = jQuery('#preview_caption_animateme');
		var startanim = jQuery('#layer_animation');
		var startspeed = jQuery('#layer_speed');
		var startease = jQuery('#layer_easing');
		var endanim = jQuery('#layer_endanimation');
		var endspeed = jQuery('#layer_endspeed');
		var endease = jQuery('#layer_endeasing');

		var anim = startanim.val();
		var speed = startspeed.val()/1000;
		var easedata = startease.val();


		  var mdelay = (jQuery('input[name="layer_splitdelay"]').val()/100);
		  var $split = jQuery('#layer_split').val();

		  var animobject = nextcaption;
		  if (nextcaption.data('mySplitText') != undefined)
			if ($split !="none") nextcaption.data('mySplitText').revert();

			if ($split == "chars" || $split == "words" || $split == "lines") {
				if (nextcaption.find('a').length>0)
					nextcaption.data('mySplitText',new SplitText(nextcaption.find('a'),{type:"lines,words,chars"}));
				 else
					nextcaption.data('mySplitText',new SplitText(nextcaption,{type:"lines,words,chars"}));
			}

			if ($split == "chars") {
				animobject = nextcaption.data('mySplitText').chars;

			}

			if ($split == "words") {
				animobject = nextcaption.data('mySplitText').words;

			}

			if ($split == "lines") {
				animobject = nextcaption.data('mySplitText').lines;

			}


		  var timedelay=((animobject.length*mdelay) + speed)*1000;

		  punchgs.TweenLite.killTweensOf(nextcaption,false);
		  punchgs.TweenLite.killTweensOf(animobject,false);
		  punchgs.TweenLite.set(nextcaption,{clearProps:"transform"});
		  punchgs.TweenLite.set(animobject,{clearProps:"transform"});

		  if (animobject != nextcaption)
				 punchgs.TweenLite.set(nextcaption, { opacity:1,scaleX:1,scaleY:1,rotationX:0,rotationY:0,rotationZ:0,skewX:0,skewY:0,z:0,x:0,y:0,visibility:'visible',opacity:1,overwrite:"all"});

		  var tl=new punchgs.TimelineLite();


		if (nextcaption.data("timer")) clearTimeout(nextcaption.data('timer'));
		if (nextcaption.data("timera")) clearTimeout(nextcaption.data('timera'));
		var tlop = 0,
		 	tlxx = 198, tlyy = 82, tlzz = 2,
		    tlsc = 1,tlro = 0,
		    sc=1,scX=1,scY= 1,
		    ro=0,roX=0,roY=0,roZ = 0,
			skwX=0, skwY = 0,
			opa = 0,
			trorig = "center,center",
			tper = 300,
			repeatV = 0,
			yoyoV = false,
		    repeatdelayV = 0,
		    calcx = 198,
		    calcy = 82;

		if (anim == null) anim = "fade";

		if (anim == "randomrotate") {

							sc = Math.random()*3+1;
							ro = Math.round(Math.random()*200-100);
							transx = Math.round(Math.random()*200-100);
							transy = Math.round(Math.random()*200-100);
				}
		if (anim == ('lfr') || anim==('skewfromright')) transx = 560;
		if (anim==('lfl') || anim==('skewfromleft')) transx = -100;
		if (anim==('sfl') | anim==('skewfromleftshort')) transx = -50;
		if (anim==('sfr') | anim==('skewfromrightshort')) transx = 50;
		if (anim==('lft')) transy = -50;
		if (anim==('lfb')) transy = 250;
		if (anim==('sft')) transy = -50;
		if (anim==('sfb')) transy = 50;
		if (anim==('skewfromright') || anim==('skewfromrightshort')) skwX = -85;
		if (anim==('skewfromleft') || anim==('skewfromleftshort')) skwX =  85;

		if (anim.split('custom').length>1) {
			var id = anim.split("-")[1];
			var params = new Object;
			params = getCutCustomParams(id);

			var transx = params.movex;
			var transy = params.movey;
			var transz = params.movez;
			var rotatex = params.rotationx;
			var rotatey = params.rotationy;
			var rotatez = params.rotationz;
			var scalex = params.scalex/100;
			var scaley = params.scaley/100;
			var skewx = params.skewx;
			var skewy =params.skewy;
			var opac = params.captionopacity/100;
			var tper = params.captionperspective;
			//var tper = 600;
			var originx = params.originx+"%";
			var originy = params.originy+"%";
			var origin = originx+" "+originy;




			 nextcaption.data('newanim',tl.staggerFromTo(animobject,speed,
										{ scaleX:scalex,
										  scaleY:scaley,
										  rotationX:rotatex,
										  rotationY:rotatey,
										  rotationZ:rotatez,
										  x:transx,
										  y:transy,
										  z:transz+1,
										  skewX:skewx,
										  skewY:skewy,
										  opacity:opac,
										  transformPerspective:tper,
										  transformOrigin:origin,
										  visibility:'hidden'},

										{ x:0,
										  y:0,
										  scaleX:1,
										  scaleY:1,
										  rotationX:0,
										  rotationY:0,
										  rotationZ:0,
										  skewX:0,
										  skewY:0,
										  z:1,
										  visibility:'visible',
										  opacity:1,
										  ease:easedata,
										  overwrite:"all",

								},mdelay));

				nextcaption.data('timera',setTimeout(function() {
			  		if (!jQuery('#preview_looper').hasClass("deactivated") && jQuery('#preview_looper').data('loop')!=2) setOutAnimOfPreview();
			  	},(timedelay)+500));
		} else {

				nextcaption.data('newanim',tl.staggerFromTo(animobject,speed,
								{ scale:sc,
								  rotation:ro,
								  rotationX:0,
								  rotationY:0,
								  rotationZ:0,
								  x:transx,
								  y:transy,
								  opacity:0,
								  z:1,
								  skewX:skwX,
								  skewY:0,
								  transformPerspective:600,
								  transformOrigin:"50% 50%",
								  visibility:'visible'
								 },

								{ scale:1,
								  skewX:0,
								  rotation:0,
								  z:1,
								  x:0,
								  y:0,
								  visibility:'visible',
								  opacity:1,
								  ease:easedata,
								  overwrite:"all",

								},mdelay));
				nextcaption.data('timera',setTimeout(function() {
			  		if (!jQuery('#preview_looper').hasClass("deactivated") && jQuery('#preview_looper').data('loop')!=2) setOutAnimOfPreview();
			  	},(timedelay)+500));
		}

	}

	function getCutCustomParams(id) {
		var params = new Object;
		jQuery.each(initLayerAnims,function(i,curobj) {
			if (parseInt(curobj.id,0) == parseInt(id,0)) params = curobj.params;
		})
		return params;
	}

	/******************************
		-	PLAY OUT ANIMATION	-
	********************************/

	function setOutAnimOfPreview() {

		var nextcaption = jQuery('#preview_caption_animateme');
		var startanim = jQuery('#layer_animation');
		var startspeed = jQuery('#layer_speed');
		var startease = jQuery('#layer_easing');
		var endanim = jQuery('#layer_endanimation');
		var endspeed = jQuery('#layer_endspeed');
		var endease = jQuery('#layer_endeasing');

		var anim = endanim.val();
		var speed = endspeed.val()/1000;
		var easedata = endease.val();
		var xx = 0;
		var yy = 0;
		skwX = 0;


		var mdelay = (jQuery('input[name="layer_endsplitdelay"]').val()/100);
		  var $split = jQuery('#layer_endsplit').val();

		  var animobject = nextcaption;
		  if (nextcaption.data('mySplitText') != undefined)
			if ($split !="none") nextcaption.data('mySplitText').revert();

			if ($split == "chars" || $split == "words" || $split == "lines") {
				if (nextcaption.find('a').length>0)
					nextcaption.data('mySplitText',new SplitText(nextcaption.find('a'),{type:"lines,words,chars"}));
				 else
					nextcaption.data('mySplitText',new SplitText(nextcaption,{type:"lines,words,chars"}));
			}

			if ($split == "chars") {
				animobject = nextcaption.data('mySplitText').chars;

			}

			if ($split == "words") {
				animobject = nextcaption.data('mySplitText').words;

			}

			if ($split == "lines") {
				animobject = nextcaption.data('mySplitText').lines;

			}


		  var timedelay=((animobject.length*mdelay) + speed)*1000;


		  punchgs.TweenLite.killTweensOf(animobject,false);

		  if (animobject != nextcaption)
				 punchgs.TweenLite.set(nextcaption, { opacity:1,scaleX:1,scaleY:1,rotationX:0,rotationY:0,rotationZ:0,skewX:0,skewY:0,z:0,x:0,y:0,visibility:'visible',opacity:1,overwrite:"all"});

		  var tl=new punchgs.TimelineLite();


		if (anim == null) anim = "auto";

		if (			anim==('fadeout') ||
						anim==('ltr') ||
						anim==('ltl') ||
						anim==('str') ||
						anim==('stl') ||
						anim==('ltt') ||
						anim==('ltb') ||
						anim==('stt') ||
						anim==('stb') ||
						anim==('skewtoright') ||
						anim==('skewtorightshort') ||
						anim==('skewtoleft') ||
						anim==('skewtoleftshort'))
					{

				if (anim==('skewtoright') || anim==('skewtorightshort'))
					skwX = 35

				if (anim==('skewtoleft') || anim==('skewtoleftshort'))
					skwX =  -35



				if (anim==('ltr') || anim==('skewtoright'))
					xx=560;
				else if (anim==('ltl') || anim==('skewtoleft'))
					xx=-100;
				else if (anim==('ltt'))
					yy=-50;
				else if (anim==('ltb'))
					yy=250;
				else if (anim==('str') || anim==('skewtorightshort')) {
					xx=50;oo=0;
				} else if (anim==('stl') || anim==('skewtoleftshort')) {
					xx=-50;oo=0;
				} else if (anim==('stt')) {
					yy=-50;oo=0;
				} else if (anim==('stb')) {
					yy=50;oo=0;
				}

				if (anim==('skewtorightshort'))
					xx = 400;

				if (anim==('skewtoleftshort'))
					xx =  0

				nextcaption.data('newanim',tl.staggerTo(animobject,speed,
							{ scale:1,
							  rotation:0,
							  skewX:skwX,
							  opacity:0,
							  x:xx,
							  y:yy,
							  z:2,
							  overwrite:"auto",
							  ease:easedata,
							 },mdelay));
				nextcaption.data('timera',setTimeout(function() {
			  		if (jQuery('#preview_looper').hasClass("deactivated")) 				jQuery('#preview_looper').data('loop',2);
			  		setInAnimOfPreview();
			  	},(timedelay)+500));
		} else

		if (anim.split('custom').length>1) {
			var id = anim.split("-")[1];
			var params = new Object;
			params = getCutCustomParams(id);

			var transx = params.movex;
			var transy = params.movey;
			var transz = params.movez;
			var rotatex = params.rotationx;
			var rotatey = params.rotationy;
			var rotatez = params.rotationz;
			var scalex = params.scalex/100;
			var scaley = params.scaley/100;
			var skewx = params.skewx;
			var skewy =params.skewy;
			var opac = params.captionopacity/100;
			var tper = params.captionperspective;
			//var tper = 600;
			var originx = params.originx+"%";
			var originy = params.originy+"%";
			var origin = originx+" "+originy;

			 nextcaption.data('newanim',tl.staggerFromTo(animobject,speed,
										{ x:0,
										  y:0,
										  scaleX:1,
										  scaleY:1,
										  rotationX:0,
										  rotationY:0,
										  rotationZ:0,
										  skewX:0,
										  skewY:0,
										  transformPerspective:tper,
										  transformOrigin:origin,
										  z:1,
										  visibility:'visible',
										  opacity:1,
										},

										{
										  scaleX:scalex,
										  scaleY:scaley,
										  rotationX:rotatex,
										  rotationY:rotatey,
										  rotationZ:rotatez,
										  x:transx,
										  y:transy,
										  z:transz+1,
										  skewX:skewx,
										  skewY:skewy,
										  opacity:opac,
										  transformPerspective:tper,
										  transformOrigin:origin,
										  ease:easedata,

							 },mdelay));
			  nextcaption.data('timera',setTimeout(function() {
											  		if (jQuery('#preview_looper').hasClass("deactivated")) 				jQuery('#preview_looper').data('loop',2);
											  		setInAnimOfPreview();
			  	},(timedelay)+500));

		} else {
			nextcaption.data('newanim').reverse();
			nextcaption.data('timer',setTimeout(function() {
		  		  if (jQuery('#preview_looper').hasClass("deactivated")) jQuery('#preview_looper').data('loop',2);
				  setInAnimOfPreview();
			},(speed*1000)+1000))
		}
	}



	/*! ALIGN TABLE HANDLING */
	/**
	 * init the align table
	 */
	var initAlignTable = function(){
		jQuery("#align_table a").click(function(){
			var obj = jQuery(this);
			if(jQuery("#align_table").hasClass("table_disabled"))
				return(false);
			if(obj.hasClass("selected"))
				return(false);

			var alignHor = obj.data("hor");
			var alignVert = obj.data("vert");
			jQuery("#align_table a").removeClass("selected");
			obj.addClass("selected");

			jQuery("#layer_align_hor").val(alignHor);
			jQuery("#layer_align_vert").val(alignVert);

			var objLayerXText = jQuery("#layer_left_text");
			var objLayerYText = jQuery("#layer_top_text");

			switch(alignHor){
				case "left":
					objLayerXText.html(objLayerXText.data("textnormal")).css("width","auto");
					jQuery("#layer_left").val("10");
				break;
				case "right":
					objLayerXText.html(objLayerXText.data("textoffset")).css("width","42px");
					jQuery("#layer_left").val("10");
				break;
				case "center":
					objLayerXText.html(objLayerXText.data("textoffset")).css("width","42px");
					jQuery("#layer_left").val("0");
				break;
			}

			switch(alignVert){
				case "top":
					objLayerYText.html(objLayerYText.data("textnormal")).css("width","auto");
					jQuery("#layer_top").val("10");
				break;
				case "bottom":
					objLayerYText.html(objLayerYText.data("textoffset")).css("width","42px");
					jQuery("#layer_top").val("10");
				break;
				case "middle":
					objLayerYText.html(objLayerYText.data("textoffset")).css("width","42px");
					jQuery("#layer_top").val("0");
				break;
			}

			t.updateLayerFromFields();
			updateHtmlLayersFromObject(getSerialFromID(jQuery('.layer_selected').attr('id')),true);
		});

	}


	/**
	 * init general events
	 */
	var initMainEvents = function(){
		//unselect layers on container click
		container.click(unselectLayers);

	}


	/*! INIT HTML FIELDS */
	/**
	 * init events (update) for html properties change.
	 */
	var initHtmlFields = function(){

		//show / hide slide link offset
		jQuery("#layer_slide_link").change(function(){
			showHideOffsetRow();
		});

		//set layers autocompolete
		jQuery("#layer_caption").autocomplete({
			source: initArrCaptionClasses,
			minLength:0,
			close:t.updateLayerFromFields
		}).data("ui-autocomplete")._renderItem = function(ul, item) {
			var listItem = jQuery("<li></li>")
				.data("item.autocomplete", item)
				.append("<a>" + item.label + "</a>")
				.appendTo(ul);

			listItem.attr('original-title', item.value);
			return listItem;
		};

		//open the list on right button
		jQuery( "#layer_captions_down" ).click(function(event){
			event.stopPropagation();

			jQuery("#css_editor_expert").hide();
			jQuery("#css_editor_wrap").hide();

			//if opened - close autocomplete
			if(jQuery('#layer_caption').data("is_open") == true)
				jQuery( "#layer_caption" ).autocomplete("close");
			else   //else open autocomplete
			if(jQuery(this).hasClass("ui-state-active"))
				jQuery( "#layer_caption" ).autocomplete( "search", "" ).data("ui-autocomplete")._renderItem = function(ul, item) {
					var listItem = jQuery("<li></li>")
						.data("item.autocomplete", item)
						.append("<a>" + item.label + "</a>")
						.appendTo(ul);

					listItem.attr('original-title', item.value);
					return listItem;
				};
		});

		//handle autocomplete close
		jQuery('#layer_caption').bind('autocompleteopen', function() {
			jQuery(this).data('is_open',true);

			//handle tooltip
			jQuery('.ui-autocomplete li').tipsy({
		        delayIn: 70,
				html: true,
				gravity:"w",
				//trigger:"manual",
				title: function(){
					    setTimeout(function() {
						    jQuery('.tp-present-caption-small').parent().addClass("tp-present-wrapper-small");
							jQuery('.tp-present-caption-small').parent().parent().addClass("tp-present-wrapper-parent-small");
					    },10)
						return '<div class="tp-present-caption-small"><div class="tp-caption '+this.getAttribute('original-title')+'">example</div></div>';
					}
			});
		});

		jQuery('#layer_caption').bind('autocompleteclose', function() {
			jQuery(this).data('is_open',false);
		});

		//set layers autocompolete
		jQuery( "#font_family" ).autocomplete({
			source: initArrFontTypes,
			minLength:0,
			close:t.updateLayerFromFields
		});

		//open the list on right button
		jQuery("#font_family_down").click(function(event){
			event.stopPropagation();

			//if opened - close autocomplete
			if(jQuery('#font_family').data("is_open") == true)
				jQuery( "#font_family" ).autocomplete("close");
			else   //else open autocomplete
			if(jQuery(this).hasClass("ui-state-active"))
				jQuery( "#font_family" ).autocomplete( "search", "" ).data("ui-autocomplete");
		});

		//handle autocomplete close
		jQuery('#font_family').bind('autocompleteopen', function() {
			jQuery(this).data('is_open',true);
		});

		jQuery('#font_family').bind('autocompleteclose', function() {
			jQuery(this).data('is_open',false);
		});


		jQuery("body").click(function(){
			jQuery( "#layer_caption" ).autocomplete("close");
			jQuery( "#font_family" ).autocomplete("close");
		});

		//set events:
		jQuery("#form_layers select, #layer_proportional_scale").change(function(){
			t.updateLayerFromFields();
		});
		// UPDATE LAYER TEXT FIELD
		jQuery("#layer_text").keyup(function(){				
			updateLayerTextField("",jQuery('#sortlist li.ui-state-hover .tl-fullanim'),jQuery(this).val());			
		});
		
		var pressEnterFields = "#form_layers input, #form_layers textarea";
		jQuery(pressEnterFields).blur(function(){t.updateLayerFromFields();});
		jQuery(pressEnterFields).keypress(function(event){
			if(event.keyCode == 13){
				t.updateLayerFromFields();
			}
		});

		//end time validation
		jQuery("#layer_endtime").blur(validateCurrentLayerTimes).keypress(function(event){
			if(event.keyCode == 13)
				validateCurrentLayerTimes();
		});

		//end speed update
		jQuery("#layer_endspeed").blur(validateCurrentLayerTimes).keypress(function(event){
				updateCurTimer("",jQuery('#sortlist li.ui-state-hover .tl-fullanim'));
		});

		jQuery("#layer_endspeed").blur(function(){
				updateCurTimer("",jQuery('#sortlist li.ui-state-hover .tl-fullanim'));
		});


		jQuery("#delay").keypress(function(event){
			if (Number(jQuery('#delay').val())>0)
					g_slideTime = jQuery('#delay').val();
			updateCurTimer("",jQuery('#sortlist li.ui-state-hover .tl-fullanim'));

		});

		jQuery("#delay").blur(function(){
			if (Number(jQuery('#delay').val())>0)
				g_slideTime = jQuery('#delay').val();
			updateCurTimer("",jQuery('#sortlist li.ui-state-hover .tl-fullanim'));
		});


	}


	/**
	 * init buttons actions
	 */
	var initButtons = function(){

		//set event buttons actions:
		jQuery("#button_add_layer").click(function(){
			if(jQuery(this).data('isstatic') == true){
				addLayerText('static');
			}else{
				addLayerText();
			}
		});

		jQuery("#button_add_layer_image").click(function(){
			if(jQuery(this).data('isstatic') == true){
				UniteAdminRev.openAddImageDialog("Select Static Layer Image",function(urlImage){
					addLayerImage(urlImage, 'static');
				});
			}else{
				UniteAdminRev.openAddImageDialog("Select Layer Image",function(urlImage){
					addLayerImage(urlImage);
				});
			}
		});



		//add youtube actions:
		jQuery("#button_add_layer_video").click(function(){
			if(jQuery(this).data('isstatic') == true){
				UniteAdminRev.openVideoDialog(function(videoData){
					addLayerVideo(videoData, 'static');
				});
			}else{
				UniteAdminRev.openVideoDialog(function(videoData){
					addLayerVideo(videoData);
				});
			}
		});


		// BUILD THE LAYER ANIMATION DIALOG
		jQuery('#add_customanimation_in').click(function() {
			if(!UniteLayersRev.getLayerGeneralParamsStatus()) return false; //false if fields are disabled

			currentAnimationType = 'customin';
			stopAnimationInPreview();
			initLayerAnimationDialog();
			setNewAnimObj();
		});

		// BUILD THE LAYER ANIMATION DIALOG
		jQuery('#add_customanimation_out').click(function() {
			if(!UniteLayersRev.getLayerGeneralParamsStatus()) return false; //false if fields are disabled

			currentAnimationType = 'customout';

			initLayerAnimationDialog();
			setNewAnimObj();
		});

		//build the random animation button
		jQuery('#set-random-animation').click(function(){
			jQuery('input[name="movex"]').val((Math.floor(Math.random() * 101) - 50) * 10);
			jQuery('input[name="movey"]').val((Math.floor(Math.random() * 101) - 50) * 10);
			jQuery('input[name="movez"]').val((Math.floor(Math.random() * 11) - 5) * 10);

			jQuery('input[name="rotationx"]').val((Math.floor(Math.random() * 101) - 50) * 10);
			jQuery('input[name="rotationy"]').val((Math.floor(Math.random() * 101) - 50) * 10);
			jQuery('input[name="rotationz"]').val((Math.floor(Math.random() * 101) - 50) * 10);

			jQuery('input[name="scalex"]').val((Math.floor(Math.random() * 31)) * 10);
			jQuery('input[name="scaley"]').val((Math.floor(Math.random() * 31)) * 10);

			jQuery('input[name="skewx"]').val(Math.floor(Math.random() * 61));
			jQuery('input[name="skewy"]').val(Math.floor(Math.random() * 61));

			jQuery('input[name="captionopacity"]').val(0);
			jQuery('input[name="captionperspective"]').val(600);

			jQuery('input[name="originx"]').val((Math.floor(Math.random() * 41) - 20) * 10);
			jQuery('input[name="originy"]').val((Math.floor(Math.random() * 41) - 20) * 10);

			jQuery("#caption-movex-slider").slider("value",jQuery('input[name="movex"]').val());
			jQuery("#caption-movey-slider").slider("value",jQuery('input[name="movey"]').val());
			jQuery("#caption-movez-slider").slider("value",jQuery('input[name="movez"]').val());
			jQuery("#caption-rotationx-slider").slider("value",jQuery('input[name="rotationx"]').val());
			jQuery("#caption-rotationy-slider").slider("value",jQuery('input[name="rotationy"]').val());
			jQuery("#caption-rotationz-slider").slider("value",jQuery('input[name="rotationz"]').val());
			jQuery("#caption-scalex-slider").slider("value",jQuery('input[name="scalex"]').val());
			jQuery("#caption-scaley-slider").slider("value",jQuery('input[name="scaley"]').val());
			jQuery("#caption-skewx-slider").slider("value",jQuery('input[name="skewx"]').val());
			jQuery("#caption-skewy-slider").slider("value",jQuery('input[name="skewy"]').val());
			jQuery("#caption-opacity-slider").slider("value",jQuery('input[name="captionopacity"]').val());
			jQuery("#caption-perspective-slider").slider("value",jQuery('input[name="captionperspective"]').val());
			jQuery("#caption-originx-slider").slider("value",jQuery('input[name="originx"]').val());
			jQuery("#caption-originy-slider").slider("value",jQuery('input[name="originy"]').val());

			jQuery('input[name="captionspeed"]').val((Math.floor(Math.random() * 11) + 5) * 100);

			transition = jQuery('#caption-easing-demo option');
			var random = Math.floor(transition.length * (Math.random() % 1));

			transition.attr('selected',false).eq(random).attr('selected',true);
		});

		//edit video actions
		jQuery("#button_edit_video").click(function(){
			var objCurrentLayer = getCurrentLayer();
			var objVideoData = objCurrentLayer.video_data;

			//open video dialog
			UniteAdminRev.openVideoDialog(function(videoData){
				//update video layer
				var objLayer = getVideoObjLayer(videoData);
				updateCurrentLayer(objLayer);
				updateHtmlLayersFromObject(selectedLayerSerial);
				updateLayerFormFields(selectedLayerSerial);
				redrawLayerHtml(selectedLayerSerial);
			},
			objVideoData);

		});

		//change image source actions
		jQuery("#button_change_image_source").click(function(){
			UniteAdminRev.openAddImageDialog("Select Layer Image",function(urlImage){
				var objData = {};
				objData.image_url = urlImage;
				updateCurrentLayer(objData);
				redrawLayerHtml(selectedLayerSerial);
			});
		});

		//delete layer actions:
		jQuery("#button_delete_layer").click(function(){
			if(jQuery(this).hasClass("button-disabled"))
				return(false);

			//delete selected layer
			deleteCurrentLayer();
		});

		//delete layer actions:
		jQuery("#button_duplicate_layer").click(function(){
			if(jQuery(this).hasClass("button-disabled"))
				return(false);

			//delete selected layer
			duplicateCurrentLayer();
		});

		//delete all layers actions:
		jQuery("#button_delete_all").click(function(){
			if(confirm("Do you really want to delete all the layers?") == false)
				return(true);

			if(jQuery(this).hasClass("button-disabled"))
				return(false);

			deleteAllLayers();
		});

		//insert button link - open the dialog
		jQuery("#linkInsertButton").click(function(){
			if(jQuery(this).hasClass("disabled"))
				return(false);

			var buttons = {"Cancel":function(){jQuery("#dialog_insert_button").dialog("close")}}
			jQuery("#dialog_insert_button").dialog({
						buttons:buttons,
						minWidth:500,
						dialogClass:"tpdialogs",
						modal:true});

		});

		//insert button link - open the dialog
		jQuery("#linkInsertTemplate").click(function(){
			if(jQuery(this).hasClass("disabled"))
				return(false);

			var buttons = {"Cancel":function(){jQuery("#dialog_template_insert").dialog("close")}}
			jQuery("#dialog_template_insert").dialog({
						buttons:buttons,
						minWidth:500,
						dialogClass:"tpdialogs",
						modal:true});

		});

	}


//======================================================
//		Init Function End
//======================================================


	/**************************************
		-	INIT LAYER ANIMATION DIALOG	-
	**************************************/
	function initLayerAnimationDialog() {
		var curAnimHandle = (currentAnimationType == 'customin') ? jQuery('#layer_animation').val() : jQuery('#layer_endanimation').val();
		var curAnimText = (currentAnimationType == 'customin') ? jQuery('#layer_animation option:selected').text() : jQuery('#layer_endanimation option:selected').text();
		var isOriginal = (curAnimHandle.indexOf('custom') > -1) ? false : true;

		var layerEasing = (currentAnimationType == 'customin') ? jQuery('#layer_easing option:selected').val() : jQuery('#layer_endeasing option:selected').val();
		var layerSpeed = (currentAnimationType == 'customin') ? jQuery('#layer_speed').val() : jQuery('#layer_endspeed').val();

		if(layerEasing == 'nothing') layerEasing = jQuery('#layer_easing option:selected').val();
		jQuery('#caption-easing-demo').val(layerEasing);

		if(parseInt(layerSpeed) == 0) layerSpeed = 600;
		jQuery('input[name="captionspeed"]').val(layerSpeed);

		var cic = jQuery('#caption-inout-controll');
		cic.data('direction',0);
		jQuery('#revshowmetheinanim').addClass("reviconinaction");
		jQuery('#revshowmetheoutanim').removeClass("reviconinaction");

		//set the transition direction to out
		if(currentAnimationType == 'customout') jQuery('#caption-inout-controll').click();

		jQuery("#layeranimeditor_wrap").dialog({
			modal:true,
			resizable:false,
			title:'Layer Animation Editor',
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
			close:function() {
				setInAnimOfPreview();
			},
			buttons:{
				"Save/Change":function(){
					var animObj = createNewAnimObj();

					UniteAdminRev.setErrorMessageID("dialog_error_message");

					jQuery('#current-layer-handle').text(curAnimText);
					jQuery('input[name="layeranimation_save_as"]').val(curAnimText);

					jQuery("#dialog-change-layeranimation").dialog({
						modal: true,
						buttons: {
							'Save as': function() {
								jQuery("#dialog-change-layeranimation-save-as").dialog({
									modal: true,
									buttons: {
										'Save as new': function(){
											var id = checkIfAnimExists(jQuery('input[name="layeranimation_save_as"]').val());
											var update = true;
											if(id !== false){
												update = false;
												if(confirm("Animation already exists, overwrite?")){
													updateAnimInDb(jQuery('input[name="layeranimation_save_as"]').val(), animObj, id);
													update = true;
												}
											}else{
												updateAnimInDb(jQuery('input[name="layeranimation_save_as"]').val(), animObj, false);
											}
											if(update){
												jQuery("#dialog-change-layeranimation-save-as").dialog("close");
												jQuery("#dialog-change-layeranimation").dialog("close");
												jQuery(this).dialog("close");
												jQuery("#layeranimeditor_wrap").dialog("close");
												setInAnimOfPreview();
											}
										}
									}
								});
							},
							Save: function() {
								var id = checkIfAnimExists(jQuery('input[name="layeranimation_save_as"]').val());

								if(id !== false){
									if(confirm("Really overwrite animation?")){
										updateAnimInDb(jQuery('input[name="layeranimation_save_as"]').val(), animObj, id);
										jQuery(this).dialog("close");
										jQuery("#layeranimeditor_wrap").dialog("close");
										setInAnimOfPreview();
									}
								}else{
									updateAnimInDb(jQuery('input[name="layeranimation_save_as"]').val(), animObj, false);
									jQuery(this).dialog("close");
									jQuery("#layeranimeditor_wrap").dialog("close");
									setInAnimOfPreview();
								}
							}
						}
					});
				},
				"Cancel":function(){
					jQuery(this).dialog("close");
					setInAnimOfPreview();
				},
				Delete: function() {

					if(isOriginal){
						alert("Default animations can't be deleted");
					}else{
						if(confirm('Really delete the animation "'+curAnimText+'"?')){
							deleteAnimInDb(curAnimHandle);
							setInAnimOfPreview();
							jQuery("#layeranimeditor_wrap").dialog("close");
						}
					}
				}
			}
		});

		jQuery("#caption-rotationx-slider").slider({
			range: "min",
			min: -980,
			max: 980,
			step:10,
			slide: function(event, ui) {
				jQuery('input[name="rotationx"]').val(ui.value);

			}
		});

		jQuery("#caption-rotationy-slider").slider({
			range: "min",
			min: -980,
			max: 980,
			step:10,
			slide: function(event, ui) {
				jQuery('input[name="rotationy"]').val(ui.value);

			}
		});

		jQuery("#caption-rotationz-slider").slider({
			range: "min",
			min: -980,
			max: 980,
			step:10,
			slide: function(event, ui) {
				jQuery('input[name="rotationz"]').val(ui.value);

			}
		});

		jQuery("#caption-movex-slider").slider({
			range: "min",
			min: -2000,
			max: 2000,
			step:10,
			slide: function(event, ui) {
				jQuery('input[name="movex"]').val(ui.value);

			}
		});

		jQuery("#caption-movey-slider").slider({
			range: "min",
			min: -2000,
			max: 2000,
			step:10,
			slide: function(event, ui) {
				jQuery('input[name="movey"]').val(ui.value);

			}
		});

		jQuery("#caption-movez-slider").slider({
			range: "min",
			min: -2000,
			max: 2000,
			step:10,
			slide: function(event, ui) {
				jQuery('input[name="movez"]').val(ui.value);

			}
		});

		jQuery("#caption-scalex-slider").slider({
			range: "min",
			min: 0,
			max: 800,
			step:10,
			slide: function(event, ui) {
				jQuery('input[name="scalex"]').val(ui.value);

			}
		});

		jQuery("#caption-scaley-slider").slider({
			range: "min",
			min: 0,
			max: 800,
			step:10,
			slide: function(event, ui) {
				jQuery('input[name="scaley"]').val(ui.value);

			}
		});

		jQuery("#caption-skewx-slider").slider({
			range: "min",
			min: -180,
			max: 180,
			step:1,
			slide: function(event, ui) {
				jQuery('input[name="skewx"]').val(ui.value);

			}
		});

		jQuery("#caption-skewy-slider").slider({
			range: "min",
			min: -180,
			max: 180,
			step:1,
			slide: function(event, ui) {
				jQuery('input[name="skewy"]').val(ui.value);

			}
		});

		jQuery("#caption-opacity-slider").slider({
			range: "min",
			min: -0,
			max: 100,
			step:1,
			slide: function(event, ui) {
				jQuery('input[name="captionopacity"]').val(ui.value);

			}
		});

		jQuery("#caption-perspective-slider").slider({
			range: "min",
			min: -3000,
			max: 3000,
			step:1,
			slide: function(event, ui) {
				jQuery('input[name="captionperspective"]').val(ui.value);

			}
		});

		jQuery("#caption-originx-slider").slider({
			range: "min",
			min: -200,
			max: 200,
			step:10,
			slide: function(event, ui) {
				jQuery('input[name="originx"]').val(ui.value);

			}
		});

		jQuery("#caption-originy-slider").slider({
			range: "min",
			min: -200,
			max: 200,
			step:10,
			slide: function(event, ui) {
				jQuery('input[name="originy"]').val(ui.value);

			}
		});
	}

	/**
	 * get the values of custom animation dialog
	 */
	var createNewAnimObj = function(){
		var customAnim = new Object;

		customAnim['movex'] = jQuery('input[name="movex"]').val();
		customAnim['movey'] = jQuery('input[name="movey"]').val();
		customAnim['movez'] = jQuery('input[name="movez"]').val();
		customAnim['rotationx'] = jQuery('input[name="rotationx"]').val();
		customAnim['rotationy'] = jQuery('input[name="rotationy"]').val();
		customAnim['rotationz'] = jQuery('input[name="rotationz"]').val();
		customAnim['scalex'] = jQuery('input[name="scalex"]').val();
		customAnim['scaley'] = jQuery('input[name="scaley"]').val();
		customAnim['skewx'] = jQuery('input[name="skewx"]').val();
		customAnim['skewy'] = jQuery('input[name="skewy"]').val();
		customAnim['captionopacity'] = jQuery('input[name="captionopacity"]').val();
		customAnim['captionperspective'] = jQuery('input[name="captionperspective"]').val();
		customAnim['originx'] = jQuery('input[name="originx"]').val();
		customAnim['originy'] = jQuery('input[name="originy"]').val();

		return customAnim;
	}

	/**
	 * set the values of custom animation dialog
	 */
	var setNewAnimObj = function(){
		var customAnim = new Object;

		var selectedLayer = (currentAnimationType == 'customin') ? jQuery('#layer_animation').val() : jQuery('#layer_endanimation').val();

		if(selectedLayer.indexOf('customin') > -1 || selectedLayer.indexOf('customout') > -1){
			selectedLayer = selectedLayer.replace('customin-', '').replace('customout-', '');

			if(typeof initLayerAnims === 'object' && !jQuery.isEmptyObject(initLayerAnims)){
				for(var key in initLayerAnims){
					if(initLayerAnims[key]['id'] == selectedLayer){
						customAnim = initLayerAnims[key]['params'];
					}
				}
			}
		}

		if(!jQuery.isEmptyObject(customAnim)){
			jQuery('input[name="movex"]').val(customAnim['movex']);
			jQuery('input[name="movey"]').val(customAnim['movey']);
			jQuery('input[name="movez"]').val(customAnim['movez']);
			jQuery('input[name="rotationx"]').val(customAnim['rotationx']);
			jQuery('input[name="rotationy"]').val(customAnim['rotationy']);
			jQuery('input[name="rotationz"]').val(customAnim['rotationz']);
			jQuery('input[name="scalex"]').val(customAnim['scalex']);
			jQuery('input[name="scaley"]').val(customAnim['scaley']);
			jQuery('input[name="skewx"]').val(customAnim['skewx']);
			jQuery('input[name="skewy"]').val(customAnim['skewy']);
			jQuery('input[name="captionopacity"]').val(customAnim['captionopacity']);
			jQuery('input[name="captionperspective"]').val(customAnim['captionperspective']);
			jQuery('input[name="originx"]').val(customAnim['originx']);
			jQuery('input[name="originy"]').val(customAnim['originy']);
		}else{
			jQuery('input[name="movex"]').val(0);
			jQuery('input[name="movey"]').val(0);
			jQuery('input[name="movez"]').val(0);
			jQuery('input[name="rotationx"]').val(0);
			jQuery('input[name="rotationy"]').val(0);
			jQuery('input[name="rotationz"]').val(0);
			jQuery('input[name="scalex"]').val(100);
			jQuery('input[name="scaley"]').val(100);
			jQuery('input[name="skewx"]').val(0);
			jQuery('input[name="skewy"]').val(0);
			jQuery('input[name="captionopacity"]').val(0);
			jQuery('input[name="captionperspective"]').val(600);
			jQuery('input[name="originx"]').val(50);
			jQuery('input[name="originy"]').val(50);
		}

		jQuery("#caption-movex-slider").slider("value",jQuery('input[name="movex"]').val());
		jQuery("#caption-movey-slider").slider("value",jQuery('input[name="movey"]').val());
		jQuery("#caption-movez-slider").slider("value",jQuery('input[name="movez"]').val());
		jQuery("#caption-rotationx-slider").slider("value",jQuery('input[name="rotationx"]').val());
		jQuery("#caption-rotationy-slider").slider("value",jQuery('input[name="rotationy"]').val());
		jQuery("#caption-rotationz-slider").slider("value",jQuery('input[name="rotationz"]').val());
		jQuery("#caption-scalex-slider").slider("value",jQuery('input[name="scalex"]').val());
		jQuery("#caption-scaley-slider").slider("value",jQuery('input[name="scaley"]').val());
		jQuery("#caption-skewx-slider").slider("value",jQuery('input[name="skewx"]').val());
		jQuery("#caption-skewy-slider").slider("value",jQuery('input[name="skewy"]').val());
		jQuery("#caption-opacity-slider").slider("value",jQuery('input[name="captionopacity"]').val());
		jQuery("#caption-perspective-slider").slider("value",jQuery('input[name="captionperspective"]').val());
		jQuery("#caption-originx-slider").slider("value",jQuery('input[name="originx"]').val());
		jQuery("#caption-originy-slider").slider("value",jQuery('input[name="originy"]').val());
	}

	/**
	 * check if anim handle already exists
	 */
	var checkIfAnimExists = function(handle){
		if(typeof initLayerAnims === 'object' && !jQuery.isEmptyObject(initLayerAnims)){
			for(var key in initLayerAnims){
				if(initLayerAnims[key]['handle'] == handle) return initLayerAnims[key]['id'];
			}
		}
		return false;
	}

	/**
	 * update animation in database
	 */
	var deleteAnimInDb = function(handle){
		UniteAdminRev.setErrorMessageID("dialog_error_message");
		handle = jQuery.trim(handle);
		if(handle != ''){
			var animSelect = (currentAnimationType == 'customin') ? jQuery('#layer_animation option') : jQuery('#layer_endanimation option');

			UniteAdminRev.ajaxRequest("delete_custom_anim",handle,function(response){
				jQuery("#dialog_success_message").show().html(response.message);

				//update html select (got from response)
				t.updateInitLayerAnim(response.customfull);
				updateLayerAnimsInput(response.customin, 'customin');
				updateLayerAnimsInput(response.customout, 'customout');
			});
		}
	}

	/**
	 * update animation in database
	 */
	var updateAnimInDb = function(handle, animObj, id){
		UniteAdminRev.setErrorMessageID("dialog_error_message");
		animObj['handle'] = handle;


		if(id === false){ //create new
			//insert in database
			UniteAdminRev.ajaxRequest("insert_custom_anim",animObj,function(response){
				jQuery("#dialog_success_message").show().html(response.message);

				//update html select (got from response)
				t.updateInitLayerAnim(response.customfull);
				updateLayerAnimsInput(response.customin, 'customin');
				updateLayerAnimsInput(response.customout, 'customout');

				selectLayerAnim(handle);
			});

		}else{ //update existing

			//update to database
			UniteAdminRev.ajaxRequest("update_custom_anim",animObj,function(response){
				jQuery("#dialog_success_message").show().html(response.message);

				//update html select (got from response)
				t.updateInitLayerAnim(response.customfull);
				updateLayerAnimsInput(response.customin, 'customin');
				updateLayerAnimsInput(response.customout, 'customout');

				selectLayerAnim(handle);
			});
		}
	}

	/**
	 * update the layer animation inputs
	 */
	var selectLayerAnim = function(handle){
		var animSelect = (currentAnimationType == 'customin') ? jQuery('#layer_animation option') : jQuery('#layer_endanimation option');
		animSelect.each(function(){
			if(jQuery(this).text() == handle)
				jQuery(this).prop('selected', true);
			else
				jQuery(this).prop('selected', false);
		});
	}

	/**
	 * update the layer animation inputs
	 */
	var updateLayerAnimsInput = function(customAnim, type){
		if(type == 'customin'){
			var animSelect = jQuery('#layer_animation');
			var animOption = jQuery('#layer_animation option');
			var current = jQuery('#layer_animation option:selected').val();
		}else{
			var animSelect = jQuery('#layer_endanimation');
			var animOption = jQuery('#layer_endanimation option');
			var current = jQuery('#layer_endanimation option:selected').val();
		}

		animOption.each(function(){
			if(jQuery(this).val().indexOf(type) > -1){
				jQuery(this).remove();
			}
		});

		if(typeof customAnim === 'object' && !jQuery.isEmptyObject(customAnim)){
			for(key in customAnim){
				animSelect.append(new Option(customAnim[key], key));
			}
		}
		animSelect.val(current);
	}

	/**
	 * show / hide offset row accorging the slide link value
	 */
	var showHideOffsetRow = function(){
		var value = jQuery("#layer_slide_link").val();
		var offsetRow = jQuery("#layer_scrolloffset_row");

		if(value == "scroll_under")
			offsetRow.show();
		else
			offsetRow.hide();
	}


	/**
	 * do various form validations
	 */
	var doCurrentLayerValidations = function(){
		if(selectedLayerSerial == -1)
			return(false);

		validateCurrentLayerTimes();
	}


	/**
	 * validate times (start and end times) of the current layer
	 */
	var validateCurrentLayerTimes = function(){
		var currentLayer = getCurrentLayer();
		if(!currentLayer)
			return(false);

		var startTime = currentLayer.time;
		var endTime = jQuery("#layer_endtime").val();
		endTime = jQuery.trim(endTime);

		if(!endTime || endTime == ""){
			unmarkFieldError("#layer_endtime");
			return(false);
		}

		startTime = Number(startTime);
		endTime = Number(endTime);

		if(startTime >= endTime)
			markFieldError("#layer_endtime","Must be greater then start time ("+startTime+")");
		else
			unmarkFieldError("#layer_endtime");
	}

	/**
	 * mark some field as error field and give it a error title
	 */
	var markFieldError = function(field_selector,errorTitle){
		jQuery(field_selector).addClass("field_error");
		if(errorTitle)
			jQuery(field_selector).prop("title",errorTitle);
	}


	/**
	 * unmark field error class and title
	 */
	var unmarkFieldError = function(field_selector){
		jQuery(field_selector).removeClass("field_error");
		jQuery(field_selector).prop("title","");
	}


	/**
	 * get the first style from the styles list (from autocomplete)
	 */
	var getFirstStyle = function(){
		var arrClasses = jQuery( "#layer_caption" ).autocomplete("option","source");
		var firstStyle = "";

		if(arrClasses == null || arrClasses.length == 0)
			return("");

		var firstStyle = arrClasses[0];

		return(firstStyle);
	}


	/**
	 * clear layer html fields, and disable buttons
	 */
	var disableFormFields = function(){

		//clear html form
		jQuery("#form_layers")[0].reset();
		jQuery("#form_layers input, #form_layers select, #form_layers textarea").attr("disabled", "disabled").addClass("setting-disabled");

		jQuery("#button_delete_layer").addClass("button-disabled");
		jQuery("#button_duplicate_layer").addClass("button-disabled");

		jQuery("#form_layers label, #form_layers .setting_text, #form_layers .setting_unit").addClass("text-disabled");

		jQuery("#layer_captions_down").removeClass("ui-state-active").addClass("ui-state-default");
		jQuery("#font_family_down").removeClass("ui-state-active").addClass("ui-state-default");

		jQuery("#linkInsertButton").addClass("disabled");
		jQuery("#linkInsertTemplate").addClass("disabled");

		jQuery("#align_table").addClass("table_disabled");

		if(!jQuery('#preview_looper').hasClass("deactivated")) jQuery('#preview_looper').click();

		layerGeneralParamsStatus = false;
	}

	/**
	 * enable buttons and form fields.
	 */
	var enableFormFields = function(){
		jQuery("#form_layers input, #form_layers select, #form_layers textarea").removeAttr("disabled").removeClass("setting-disabled");

		jQuery("#button_delete_layer").removeClass("button-disabled");
		jQuery("#button_duplicate_layer").removeClass("button-disabled");

		jQuery("#form_layers label, #form_layers .setting_text, #form_layers .setting_unit").removeClass("text-disabled");

		jQuery("#layer_captions_down").removeClass("ui-state-default").addClass("ui-state-active");
		jQuery("#font_family_down").removeClass("ui-state-default").addClass("ui-state-active");

		jQuery("#linkInsertButton").removeClass("disabled");
		jQuery("#linkInsertTemplate").removeClass("disabled");

		jQuery("#align_table").removeClass("table_disabled");

		if(jQuery('#preview_looper').hasClass("deactivated")) jQuery('#preview_looper').click();

		layerGeneralParamsStatus = true;
	}


	/**
	 * update z-index of the layers by order value
	 */
	var updateZIndexByOrder = function(){
		for(var key in arrLayers){
			var layer = arrLayers[key];
			if(layer.order !== undefined){
				var zindex = layer.order+100;
				jQuery("#slide_layer_"+key).css("z-index",zindex);
			}
		};
	}

	/**
	 * get layers array
	 */
	t.getLayers = function(){
		if(selectedLayerSerial != -1){
			t.updateLayerFromFields();
		}
		//update sizes in images
		updateLayersImageSizes();

		return(arrLayers);
	}


	/**
	 * update image sizes
	 */
	var updateLayersImageSizes = function(){

		for (serial in arrLayers){
			var layer = arrLayers[serial];
			if(layer.type == "image"){
				var htmlLayer = getHtmlLayerFromSerial(serial);
				var objUpdate = {};

				objUpdate.width = htmlLayer.width();
				objUpdate.height = htmlLayer.height();
				updateLayer(serial,objUpdate);
			}
		}
	}

	/*! LAYER EVENTS */

	/**
	 * refresh layer events
	 */
	var refreshEvents = function(serial){
		var layer = getHtmlLayerFromSerial(serial);

		var grid_size = jQuery('#rs-grid-sizes option:selected').val();

		//update layer events.
		layer.draggable({
					drag: onLayerDrag,	//set ondrag event
					grid: [grid_size,grid_size],	//set the grid to 1 pixel
/*					stop: function() {
						updateHtmlLayersFromObject(getSerialFromID(jQuery(this).attr("id")),true);
					}*/
				});

		layer.click(function(event){
			if (!isLayerLocked(serial)) {
				
				setLayerSelected(serial);
				event.stopPropagation();
				setInAnimOfPreview();
			}
		});

	}


	/**
	 * get layer serial from id
	 */
	var getSerialFromID = function(layerID){
		var layerSerial = layerID.replace("slide_layer_","");
		return(layerSerial);
	}

	/**
	 * get serial from sortID
	 */
	var getSerialFromSortID = function(sortID){

		var layerSerial = sortID.replace("layer_sort_","");
		return(layerSerial);
	}

	/**
	 * get html layer from serial
	 */
	var getHtmlLayerFromSerial = function(serial, isDemo){
		if(!isDemo)
			isDemo = false;

		if(!isDemo)
			var htmlLayer = jQuery("#slide_layer_"+serial);
		else
			var htmlLayer = jQuery("#demo_layer_"+serial);

		if(htmlLayer.length == 0)
			UniteAdminRev.showErrorMessage("Html Layer with serial: "+serial+" not found!");

		return(htmlLayer);
	}

	/**
	 * get sort field element from serial
	 */
	var getHtmlSortItemFromSerial = function(serial){
		var htmlSortItem = jQuery("#layer_sort_"+serial);
		if(htmlSortItem.length == 0){
			UniteAdminRev.showErrorMessage("Html sort field with serial: "+serial+" not found!");
			return(false);
		}

		return(htmlSortItem);
	}

	/**
	 * get layer object by id
	 */
	var getLayer = function(serial){
		var layer = arrLayers[serial];
		if(!layer)
			UniteAdminRev.showErrorMessage("getLayer error, Layer with serial:"+serial+"not found");

		//modify some data
		layer.speed = Number(layer.speed);
		layer.endspeed = Number(layer.endspeed);

		return layer;
	}

	/**
	 * get current layer object
	 */
	var getCurrentLayer = function(){
		if(selectedLayerSerial == -1){
			UniteAdminRev.showErrorMessage("Selected layer not set");
			return(null);
		}

		return getLayer(selectedLayerSerial);
	}


	/**
	 * set layer object to array
	 */
	var setLayer = function(layerID,layer){
		if(!arrLayers[layerID]){
			UniteAdminRev.showErrorMessage("setLayer error, Layer with ID:"+layerID+"not found");
			return(false);
		}

		arrLayers[layerID] = jQuery.extend({},layer);
	}


	/*! MAKE HTML LAYER */

	/**
	 * make layer html, with params from the object
	 */
	var makeLayerHtml = function(serial,objLayer,isDemo){


		if(!isDemo)
			isDemo = false;

		var type = "text";
		if(objLayer.type)
			type = objLayer.type;

		var zIndex = Number(objLayer.order)+1;

		var style = "z-index:"+zIndex+";position:absolute;";
		var stylerot ="";
		switch(type){
			case 'text':
			case 'image':
				if(parseFloat(objLayer['2d_rotation']) !== 0){
					stylerot += ' -moz-transform: rotate('+objLayer['2d_rotation']+'deg); -ms-transform: rotate('+objLayer['2d_rotation']+'deg); -o-transform: rotate('+objLayer['2d_rotation']+'deg); -webkit-transform: rotate('+objLayer['2d_rotation']+'deg); transform: rotate('+objLayer['2d_rotation']+'deg);';
					stylerot += ' -moz-transform-origin: '+parseFloat(objLayer['2d_origin_x'])+'% '+parseFloat(objLayer['2d_origin_x'])+'%; -ms-transform-origin: '+parseFloat(objLayer['2d_origin_x'])+'% '+parseFloat(objLayer['2d_origin_x'])+'%; -o-transform-origin: '+parseFloat(objLayer['2d_origin_x'])+'% '+parseFloat(objLayer['2d_origin_x'])+'%; -webkit-transform-origin: '+parseFloat(objLayer['2d_origin_x'])+'% '+parseFloat(objLayer['2d_origin_x'])+'%; transform-origin: '+parseFloat(objLayer['2d_origin_x'])+'% '+parseFloat(objLayer['2d_origin_x'])+'%;';
				}
			break;
		}

		if(objLayer.max_width !== 'auto')
			style += ' width: '+objLayer.max_width+';';

		if(objLayer.max_height !== 'auto')
			style += ' height: '+objLayer.max_height+';';

		//if(objLayer.whitespace !== 'normal')
			style += ' white-space: '+objLayer.whitespace+';';

		var static_class = '';

		if(typeof objLayer.special_type !== 'undefined' && objLayer.special_type == 'static') static_class = ' static_layer';

		if(type == "image") style += "line-height:0;";

		if(!isDemo)
			var html = '<div id="slide_layer_' + serial + '" style="' + style + '" class="slide_layer"><div style="'+stylerot+'" class="innerslide_layer tp-caption '+objLayer.style+static_class+'" >';
		else
			var html = '<div id="demo_layer_' + serial + '" style="' + style + ' display: none;" class="demo_layer demo_layer_'+curDemoSlideID+' slide_layer tp-caption '+objLayer.style+static_class+'" >';

		//add layer specific html
		switch(type){
			case "image":
				var addStyle = '';
				if(objLayer.scaleX != "") addStyle += "width: " + objLayer.scaleX + "px; ";
				if(objLayer.scaleY != "") addStyle += "height: " + objLayer.scaleY + "px;";

				html += '<img src="'+objLayer.image_url+'" alt="'+objLayer.alt+'" style="'+addStyle+'"></img>';
			break;
			default:
			case "text":
				html += objLayer.text;
			break;
			case "video":
				var styleVideo = "width:"+objLayer.video_width+"px;height:"+objLayer.video_height+"px;";
				if(typeof (objLayer.video_data) !== "undefined"){
					var useImage = (jQuery.trim(objLayer.video_data.previewimage) != '') ? objLayer.video_data.previewimage : objLayer.video_image_url;
				}else{
					var useImage = objLayer.video_image_url;
				}
				switch(objLayer.video_type){
					case "youtube":
					case "vimeo":
						styleVideo += ";background-image:url("+useImage+");";
					break;
					case "html5":
						if(useImage !== undefined && useImage != "")
							styleVideo += ";background-image:url("+useImage+");";
					break;
				}

				html += "<div class='slide_layer_video' style='"+styleVideo+"'><div class='video-layer-inner video-icon-"+objLayer.video_type+"'>"
				html += "<div class='layer-video-title'>" + objLayer.video_title + "</div>";
				html += "</div></div>";
			break;
		}

		html +="</div>";

		//add cross icon:
		html += "<div class='icon_cross'></div>";
		html += '</div>';
		return(html);
	}


	/**
	 * update layer by data object
	 */
	var updateLayer = function(serial,objData){
		var layer = getLayer(serial);
		if(!layer){
			return(false);
		}
		for(key in objData){
			layer[key] = objData[key];
		}


		setLayer(serial,layer);
	}


	/**
	 * update current layer
	 */
	var updateCurrentLayer = function(objData){
		if(!arrLayers[selectedLayerSerial]){
			UniteAdminRev.showErrorMessage("error! the layer with serial: "+selectedLayerSerial+" don't exists");
			return(false);
		}


		updateLayer(selectedLayerSerial,objData);
	}


	/**
	 * add image layer
	 */
	var addLayerImage = function(urlImage, special_type){

		objLayer = {
			style : "",
			text : "Image " + (id_counter+1),
			type : "image",
			image_url : urlImage
		};

		if(typeof special_type !== 'undefined')
			objLayer['special_type'] = special_type;

		addLayer(objLayer);
	}


	/**
	 * get video layer object from video data
	 */
	var getVideoObjLayer = function(videoData){

		var objLayer = {
				type:"video",
				style : "",
				video_type: videoData.video_type,
				video_width:videoData.width,
				video_height:videoData.height,
				video_data:videoData
			};

		if(objLayer.video_type == "youtube" || objLayer.video_type == "vimeo"){
			objLayer.video_id = videoData.id;
			objLayer.video_title = videoData.title;
			objLayer.video_image_url = videoData.thumb_medium.url;
			objLayer.video_args = videoData.args;
		}

		//set sortbox text
		switch(objLayer.video_type){
			case "youtube":
				objLayer.text = "Youtube: " + videoData.title;
			break;
			case "vimeo":
				objLayer.text = "Vimeo: " + videoData.title;
			break;
			case "html5":
				objLayer.text = "Html5 Video";
				objLayer.video_title = objLayer.text;
				objLayer.video_image_url = "";

				if(videoData.urlPoster != "")
					objLayer.video_image_url = videoData.urlPoster;

			break;
		}

		return(objLayer);
	}


	/**
	 * add video layer
	 */
	var addLayerVideo = function(videoData, special_type){
		var objLayer = getVideoObjLayer(videoData);

		if(typeof special_type !== 'undefined')
			objLayer['special_type'] = special_type;

		addLayer(objLayer);
	}


	/**
	 * add text layer
	 */
	var addLayerText = function(special_type){

		var objLayer = {
			text:initText + (id_counter+1),
			type:"text"
		};

		if(typeof special_type !== 'undefined')
			objLayer['special_type'] = special_type;

		addLayer(objLayer);
	}


	/*! ADD LAYER */
	/**
	 * add layer
	 */
	var addLayer = function(objLayer,isInit,isDemo){

		if(!isInit)
			var isInit = false;

		if(!isDemo)
			var isDemo = false;

		//set init fields (if not set):
		if(objLayer.order == undefined)
			objLayer.order = (id_counter);
		objLayer.order = Number(objLayer.order);

		//set init position
		if(objLayer.type == "video"){
			if(objLayer.left == undefined)
				objLayer.left = initLeftVideo;

			if(objLayer.top == undefined)
				objLayer.top = initTopVideo;

			objLayer = checkUpdateFullwidthVideo(objLayer);

		}else{
			if(objLayer.left == undefined)
				objLayer.left = initLeft;

			if(objLayer.top == undefined)
				objLayer.top = initTop;
		}

		//set Loop Animations
		if(objLayer.loop_animation == undefined)
			objLayer.loop_animation = jQuery("#layer_loop_animation option:selected").val();

		if(objLayer.loop_easing == undefined)
			objLayer.loop_easing = jQuery("#layer_loop_easing").val();

		if(objLayer.loop_speed == undefined)
			objLayer.loop_speed = jQuery("#layer_loop_speed").val();

		if(objLayer.loop_startdeg == undefined)
			objLayer.loop_startdeg = jQuery("#layer_loop_startdeg").val();

		if(objLayer.loop_enddeg == undefined)
			objLayer.loop_enddeg = jQuery("#layer_loop_enddeg").val();

		if(objLayer.loop_xorigin == undefined)
			objLayer.loop_xorigin = jQuery("#layer_loop_xorigin").val();

		if(objLayer.loop_yorigin == undefined)
			objLayer.loop_yorigin = jQuery("#layer_loop_yorigin").val();

		if(objLayer.loop_xstart == undefined)
			objLayer.loop_xstart = jQuery("#layer_loop_xstart").val();

		if(objLayer.loop_xend == undefined)
			objLayer.loop_xend = jQuery("#layer_loop_xend").val();

		if(objLayer.loop_ystart == undefined)
			objLayer.loop_ystart = jQuery("#layer_loop_ystart").val();

		if(objLayer.loop_yend == undefined)
			objLayer.loop_yend = jQuery("#layer_loop_yend").val();

		if(objLayer.loop_zoomstart == undefined)
			objLayer.loop_zoomstart = jQuery("#layer_loop_zoomstart").val();

		if(objLayer.loop_zoomend == undefined)
			objLayer.loop_zoomend = jQuery("#layer_loop_zoomend").val();

		if(objLayer.loop_angle == undefined)
			objLayer.loop_angle = jQuery("#layer_loop_angle").val();

		if(objLayer.loop_radius == undefined)
			objLayer.loop_radius = jQuery("#layer_loop_radius").val();


		//set animation:
		if(objLayer.animation == undefined)
			objLayer.animation = jQuery("#layer_animation option:selected").val();

		//set easing:
		if(objLayer.easing == undefined)
			objLayer.easing = jQuery("#layer_easing").val();

		if(objLayer.split == undefined)
			objLayer.split = jQuery("#layer_split").val();

		if(objLayer.endsplit == undefined)
			objLayer.endsplit = jQuery("#layer_endsplit").val();

		if(objLayer.splitdelay == undefined)
			objLayer.splitdelay = jQuery("#layer_splitdelay").val();

		if(objLayer.endsplitdelay == undefined)
			objLayer.endsplitdelay = jQuery("#layer_endsplitdelay").val();

		if(objLayer.max_height == undefined && isInit)
			objLayer.max_height = jQuery("#layer_max_height").val();

		if(objLayer.max_width == undefined && isInit)
			objLayer.max_width = jQuery("#layer_max_width").val();

		if(objLayer['2d_rotation'] == undefined && isInit)
			objLayer['2d_rotation'] = jQuery("#layer_2d_rotation").val();

		if(objLayer['2d_origin_x'] == undefined)
			objLayer['2d_origin_x'] = jQuery("#layer_2d_origin_x").val();

		if(objLayer['2d_origin_y'] == undefined)
			objLayer['2d_origin_y'] = jQuery("#layer_2d_origin_x").val();

		if(objLayer.parallax_level == undefined)
			objLayer.parallax_level = jQuery("#parallax_level").val();

		if(objLayer.whitespace == undefined)
			objLayer.whitespace = jQuery("#layer_whitespace option:selected").val();




		if(objLayer.static_start == undefined)
			objLayer.static_start = jQuery("#layer_static_start option:selected").val();

		if(objLayer.static_end == undefined)
			objLayer.static_end = jQuery("#layer_static_end option:selected").val();

		//set speed:
		if(objLayer.speed == undefined)
			objLayer.speed = initSpeed;

		if(objLayer.align_hor == undefined)
			objLayer.align_hor = "left";

		if(objLayer.align_vert == undefined)
			objLayer.align_vert = "top";

		//set animation:
		if(objLayer.hiddenunder == undefined)
			objLayer.hiddenunder = "";

		if(objLayer.resizeme == undefined)
			objLayer.resizeme = "true";

		//set image link
		if(objLayer.link == undefined)
			objLayer.link = "";

		//set image link open in
		if(objLayer.link_open_in == undefined)
			objLayer.link_open_in = "same";

		//set slide link:
		if(objLayer.link_slide == undefined)
			objLayer.link_slide = "nothing";

		//set scroll under offset
		if(objLayer.scrollunder_offset == undefined)
			objLayer.scrollunder_offset = "";


		//set style, if empty, add first style from the list
		if(objLayer.style == undefined)
			objLayer.style = jQuery("#layer_caption").val();

		objLayer.style = jQuery.trim(objLayer.style);
		if(isInit == false && objLayer.type == "text" && (!objLayer.style || objLayer.style == "") ){
			objLayer.style = getFirstStyle();
		}

		//add time
		if(objLayer.time == undefined)
			objLayer.time = getNextTime();

		objLayer.time = Number(objLayer.time);	//casting

		//end time:
		if(objLayer.endtime == undefined)
			objLayer.endtime = "";

		if(objLayer.endspeed == undefined)
			objLayer.endspeed = initSpeed;

		//set end animation:
		if(objLayer.endanimation == undefined)
			objLayer.endanimation = jQuery("#layer_endanimation").val();

		//set end easing:
		if(objLayer.endeasing == undefined)
			objLayer.endeasing = jQuery("#layer_endeasing").val();

		//set corners
		if(objLayer.corner_left == undefined)
			objLayer.corner_left = "nothing";

		if(objLayer.corner_right == undefined)
			objLayer.corner_right = "nothing";

		if(objLayer.width == undefined)
			objLayer.width = -1;
		objLayer.width = Number(objLayer.width);

		if(objLayer.height == undefined)
			objLayer.height = -1;
		objLayer.height = Number(objLayer.height);

		//round position
		objLayer.top = Math.round(objLayer.top);
		objLayer.left = Math.round(objLayer.left);

		objLayer.serial = id_counter;

		if(!isDemo)
			arrLayers[id_counter] = jQuery.extend({},objLayer);

		//add html
		var htmlLayer = makeLayerHtml(id_counter,objLayer,isDemo);
		container.append(htmlLayer);



		var objHtmlLayer = getHtmlLayerFromSerial(id_counter,isDemo);

		//update layer position
		updateHtmlLayerPosition(isInit,objHtmlLayer,objLayer,objLayer.top,objLayer.left,objLayer.align_hor,objLayer.align_vert);

		//update corners
		updateHtmlLayerCorners(objHtmlLayer,objLayer);

		//update cross position
		updateCrossIconPosition(objHtmlLayer,objLayer);

		//add layer to sortbox
		if(!isDemo)
			addToSortbox(id_counter,objLayer);

		//refresh draggables
		if(!isDemo)
			refreshEvents(id_counter);

		id_counter++;

		//enable "delete all" button, not event, but anyway :)
		jQuery("#button_delete_all").removeClass("button-disabled");

		//select the layer
		if(isInit == false && !isDemo){

			setLayerSelected(objLayer.serial);
			jQuery("#layer_text").focus();
		}

	}



	/**
	 *
	 * delete layer from layers object
	 */
	var deleteLayerFromObject = function(serial){

		var arrLayersNew = {};
		var flagFound = false;
		for (key in arrLayers){
			if(key != serial)
				arrLayersNew[key] = arrLayers[key];
			else
				flagFound = true;
		}

		if(flagFound == false)
			UniteAdminRev.showErrorMessage("Can't delete layer, serial: "+serial+" not found");

		arrLayers = jQuery.extend({},arrLayersNew);
	}

	/**
	 * delete the layer from html.
	 */
	var deleteLayerFromHtml = function(serial){
		var htmlLayer = getHtmlLayerFromSerial(serial);
		htmlLayer.remove();
	}


	/**
	 * delete all representation of some layer
	 */
	var deleteLayer = function(serial){
		deleteLayerFromObject(serial);
		deleteLayerFromHtml(serial);
		deleteLayerFromSortbox(serial);
	}

	/**
	 *
	 * call "deleteLayer" function with selected serial
	 */
	var deleteCurrentLayer = function(){
		if(selectedLayerSerial == -1)
			return(false);

		deleteLayer(selectedLayerSerial);

		//set unselected
		selectedLayerSerial = -1;

		//clear form and disable buttons
		disableFormFields();
	}


	/**
	 * duplicate layer, set it a little aside of the layer position
	 */
	var duplicateLayer = function(serial){
		var obj = arrLayers[serial];
		var obj2 = jQuery.extend(true, {}, obj);	//duplicate object
		obj2.left += 5;
		obj2.top += 5;
		obj2.order = undefined;
		obj2.time = undefined;

		addLayer(obj2);
		redrawSortbox();
		initDisallowCaptionsOnClick();
	}


	/**
	 * call "duplicateLayer" function with selected serial
	 */
	var duplicateCurrentLayer = function(){
		if(selectedLayerSerial == -1)
			return(false);

		duplicateLayer(selectedLayerSerial);
	}


	/**
	 * delete all layers
	 */
	var deleteAllLayers = function(){

		arrLayers = {};
		container.html("");
		emptySortbox();
		selectedLayerSerial = -1;

		disableFormFields();
		jQuery("#button_delete_all").addClass("button-disabled");

		//add all layers from init
		if(initDemoLayers){
			var len = initDemoLayers.length;
			if(len){
				for(var i=0;i<len;i++){
					for(var key in initDemoLayers[i]){
						curDemoSlideID = i;
						addLayer(initDemoLayers[i][key],true,true);
					}
				}
			}else{
				for(var i in initDemoLayers){
					for(var key in initDemoLayers[i]){
						curDemoSlideID = i;
						addLayer(initDemoLayers[i][key],true,true);
					}
				}
			}

			jQuery('select[name="rev_show_the_slides"] option[value="none"]').attr("selected","selected");
			jQuery("#divbgholder").addClass("trans_bg");
			jQuery("#divbgholder").css("background-image","none");
			jQuery("#divbgholder").css("background-color","transparent");
		}

	}

	/**
	 * update the corners
	 */
	var updateHtmlLayerCorners = function(htmlLayer,objLayer){
		htmlLayer = htmlLayer.find('.innerslide_layer');
		var ncch = htmlLayer.outerHeight();
		var bgcol = htmlLayer.css('backgroundColor');

		switch(objLayer.corner_left){
			case "curved":
				htmlLayer.append("<div class='frontcorner'></div>");
			break;
			case "reverced":
				htmlLayer.append("<div class='frontcornertop'></div>");
			break;
		}

		switch(objLayer.corner_right){
			case "curved":
				htmlLayer.append("<div class='backcorner'></div>");
			break;
			case "reverced":
				htmlLayer.append("<div class='backcornertop'></div>");
			break;
		}


		htmlLayer.find(".frontcorner").css({
            'borderWidth':ncch+"px",
            'left':(0-ncch)+'px',
            'borderRight':'0px solid transparent',
            'borderTopColor':bgcol
		});

		htmlLayer.find(".frontcornertop").css({
            'borderWidth':ncch+"px",
            'left':(0-ncch)+'px',
            'borderRight':'0px solid transparent',
            'borderBottomColor':bgcol
		});

		htmlLayer.find('.backcorner').css({
            'borderWidth':ncch+"px",
            'right':(0-ncch)+'px',
            'borderLeft':'0px solid transparent',
            'borderBottomColor':bgcol
        });

		htmlLayer.find('.backcornertop').css({
             'borderWidth':ncch+"px",
             'right':(0-ncch)+'px',
             'borderLeft':'0px solid transparent',
             'borderTopColor':bgcol
         });

	}

	/**
	 * update the position of html cross
	 */
	var updateCrossIconPosition = function(objHtmlLayer,objLayer){

		var htmlCross = objHtmlLayer.find(".icon_cross");
		var crossWidth = htmlCross.width();
		var crossHeight = htmlCross.height();
		var totalWidth = objHtmlLayer.outerWidth();
		var totalHeight = objHtmlLayer.outerHeight();
		var crossHalfW = Math.round(crossWidth / 2);
		var crossHalfH = Math.round(crossHeight / 2);


		var posx = 0;
		var posy = 0;
		switch(objLayer.align_hor){
			case "left":
				posx = - crossHalfW;
			break;
			case "center":
				posx = (totalWidth - crossWidth) / 2;
			break;
			case "right":
				posx = totalWidth - crossHalfW;
			break;
		}

		switch(objLayer.align_vert){
			case "top":
				posy = - crossHalfH;
			break;
			case "middle":
				posy = (totalHeight - crossHeight) / 2;
			break;
			case "bottom":
				posy = totalHeight - crossHalfH;
			break;
		}

		htmlCross.css({"left":posx+"px","top":posy+"px"});
	}


	/*! UPDATE HTML LAYER POSITION */
	/**
	 * update html layer position
	 */
	var updateHtmlLayerPosition = function(isInit,htmlLayer,objLayer,top,left,align_hor,align_vert){

		//update positions by align
		var width = htmlLayer.outerWidth();
		var height = htmlLayer.outerHeight();


		//get sizes from saved if on get
		if(isInit == true && objLayer.type == "image"){
			if(objLayer.width != -1)
				width = objLayer.width;

			if(objLayer.height != -1)
				height = objLayer.height;
		}

		var totalWidth = container.width();
		var totalHeight = container.height();



		var objCss = {};

		//handle horizontal
		switch(align_hor){
			default:
			case "left":
				objCss["right"] = "auto";
				objCss["left"] = left+"px";

			break;
			case "right":
				objCss["left"] = "auto";
				objCss["right"] = left+"px";
			break;
			case "center":
				var realLeft = (totalWidth - width)/2;
				realLeft = Math.round(realLeft) + left;
				objCss["left"] = realLeft + "px";
				objCss["right"] = "auto";
			break;
		}

		//handle vertical
		switch(align_vert){
			default:
			case "top":
				objCss["bottom"] = "auto";
				objCss["top"] = top+"px";
			break;
			case "middle":
				var realTop = (totalHeight - height)/2;
				realTop = Math.round(realTop)+top;
				objCss["top"] = realTop + "px";
				objCss["bottom"] = "auto";
			break;
			case "bottom":
				objCss["top"] = "auto";
				objCss["bottom"] = top+"px";
			break;
		}


		//objCss["top"] = top+"px";
		//objCss["top"] = top+"px";
		htmlLayer.css(objCss);
	}


	/**
	 * check / update full width video position and size
	 */
	var checkUpdateFullwidthVideo = function(objLayer){

		if(objLayer.type != "video")
			return(objLayer);

		if(typeof (objLayer.video_data) !== "undefined"){
			if(objLayer.video_data && objLayer.video_data.fullwidth && objLayer.video_data.fullwidth == true){
				objLayer.top = 0;
				objLayer.left = 0;
				objLayer.align_hor = "left";
				objLayer.align_vert = "top";
				objLayer.video_width = container.width();
				objLayer.video_height = container.height();
			}
		}
		return(objLayer);
	}


	/*! UPDATE HTML LAYER */
	/**
	 * update html layers from object
	 */
	var updateHtmlLayersFromObject = function(serial,posresets){
		if(!serial)
			serial = selectedLayerSerial

		var objLayer = getLayer(serial);

		if(!objLayer)
			return(false);

		var htmlLayer = getHtmlLayerFromSerial(serial);

		//set class name
		var className = "innerslide_layer tp-caption";
		if(serial == selectedLayerSerial)
			htmlLayer.addClass("layer_selected");			
		className += " "+objLayer.style;
			
		htmlLayer.find('.innerslide_layer').attr("class",className);	
		

		//set html
		var type = "text";
		if(objLayer.type)
			type = objLayer.type;

		//update layer by type:
		switch(type){
			case "image":
			break;
			case "video":	//update fullwidth position
				objLayer = checkUpdateFullwidthVideo(objLayer);
			break;
			default:
			case "text":
				htmlLayer.find('.innerslide_layer').rotatable("destroy");
				htmlLayer.find('.innerslide_layer').html(objLayer.text);
				htmlLayer.find('.innerslide_layer').rotatable({
					angle:htmlLayer.find('.innerslide_layer').data('angle'),
					start:function(event,ui) {

					},
					rotate:function(event,ui) {
						jQuery('#layer_2d_rotation').val(getRotationDegrees(ui.element));
						ui.element.data('angle',ui.angle.current);
					},
					stop:function(event,ui) {
						t.updateLayerFromFields();
					}
				});

				updateHtmlLayerCorners(htmlLayer,objLayer);
			break;
		}

		//set position
		// KRISZTIAN REMOVED THE CALL BASED ON DRAG ISSUES
		if (posresets)
			updateHtmlLayerPosition(false,htmlLayer,objLayer,objLayer.top,objLayer.left,objLayer.align_hor,objLayer.align_vert);

		updateCrossIconPosition(htmlLayer,objLayer);
	}

	/**
	 THE CHANGE OF POSITION FIELD TRIGGERS THE REPOSITIONINNG OF THE LAYER
	**/
	var positionChanged = function() {
		jQuery("#layer_top, #layer_left").change(function() {
			setTimeout(function() {
				updateHtmlLayersFromObject(getSerialFromID(jQuery('.layer_selected').attr('id')),true);
			},19);
		});
	}

	/**
	 * update layer from html fields
	 */
	t.updateLayerFromFields = function(){

		if(selectedLayerSerial == -1){
			//UniteAdminRev.showErrorMessage("No layer selected, can't update.");
			return(false);
		}

		var objUpdate = {};



		objUpdate.style = jQuery("#layer_caption").val();
		objUpdate.text = jQuery("#layer_text").val();
		objUpdate.top = Number(jQuery("#layer_top").val());
		objUpdate.left = Number(jQuery("#layer_left").val());
		
		objUpdate.whitespace = jQuery("#layer_whitespace option:selected").val();		
		objUpdate.max_height = jQuery("#layer_max_height").val();
		objUpdate.max_width = jQuery("#layer_max_width").val();
		objUpdate.parallax_level = jQuery("#parallax_level").val();
		objUpdate['2d_rotation'] = jQuery("#layer_2d_rotation").val();

		objUpdate['2d_origin_x'] = jQuery("#layer_2d_origin_x").val();
		objUpdate['2d_origin_y'] = jQuery("#layer_2d_origin_y").val();
		objUpdate['static_start'] = jQuery("#layer_static_start option:selected").val();
		objUpdate['static_end'] = jQuery("#layer_static_end option:selected").val();
		

		//set Loop Animations
		objUpdate.loop_animation = jQuery("#layer_loop_animation option:selected").val();
		objUpdate.loop_easing = jQuery("#layer_loop_easing").val();
		objUpdate.loop_speed = jQuery("#layer_loop_speed").val();
		objUpdate.loop_startdeg = jQuery("#layer_loop_startdeg").val();
		objUpdate.loop_enddeg = jQuery("#layer_loop_enddeg").val();
		objUpdate.loop_xorigin = jQuery("#layer_loop_xorigin").val();
		objUpdate.loop_yorigin = jQuery("#layer_loop_yorigin").val();
		objUpdate.loop_xstart = jQuery("#layer_loop_xstart").val();
		objUpdate.loop_xend = jQuery("#layer_loop_xend").val();
		objUpdate.loop_ystart = jQuery("#layer_loop_ystart").val();
		objUpdate.loop_yend = jQuery("#layer_loop_yend").val();
		objUpdate.loop_zoomstart = jQuery("#layer_loop_zoomstart").val();
		objUpdate.loop_zoomend = jQuery("#layer_loop_zoomend").val();
		objUpdate.loop_angle = jQuery("#layer_loop_angle").val();
		objUpdate.loop_radius = jQuery("#layer_loop_radius").val();

		objUpdate.animation = jQuery("#layer_animation option:selected").val();
		objUpdate.speed = jQuery("#layer_speed").val();
		objUpdate.align_hor = jQuery("#layer_align_hor").val();
		objUpdate.align_vert = jQuery("#layer_align_vert").val();
		objUpdate.hiddenunder = jQuery("#layer_hidden").is(":checked");
		objUpdate.resizeme = jQuery("#layer_resizeme").is(":checked");
		objUpdate.easing = jQuery("#layer_easing").val();
		objUpdate.split = jQuery("#layer_split").val();
		objUpdate.endsplit = jQuery("#layer_endsplit").val();
		objUpdate.splitdelay = jQuery("#layer_splitdelay").val();
		objUpdate.endsplitdelay = jQuery("#layer_endsplitdelay").val();
		objUpdate.link_slide = jQuery("#layer_slide_link").val();
		objUpdate.scrollunder_offset = jQuery("#layer_scrolloffset").val();
		objUpdate.alt = jQuery("#layer_alt").val();
		objUpdate.scaleX = jQuery("#layer_scaleX").val();
		objUpdate.scaleY = jQuery("#layer_scaleY").val();


		objUpdate.scaleProportional = jQuery("#layer_proportional_scale").is(":checked");

		objUpdate.attrID = jQuery("#layer_id").val();
		objUpdate.attrClasses = jQuery("#layer_classes").val();
		objUpdate.attrTitle = jQuery("#layer_title").val();
		objUpdate.attrRel = jQuery("#layer_rel").val();
		objUpdate.link = jQuery("#layer_image_link").val();
		objUpdate.link_open_in = jQuery("#layer_link_open_in").val();
		objUpdate.link_id = jQuery("#layer_link_id").val();
		objUpdate.link_class = jQuery("#layer_link_class").val();
		objUpdate.link_title = jQuery("#layer_link_title").val();
		objUpdate.link_rel = jQuery("#layer_link_rel").val();


		objUpdate.endtime = jQuery("#layer_endtime").val();
		objUpdate.endanimation = jQuery("#layer_endanimation").val();
		objUpdate.endspeed = jQuery("#layer_endspeed").val();
		objUpdate.endeasing = jQuery("#layer_endeasing").val();

		objUpdate.corner_left = jQuery("#layer_cornerleft").val();
		objUpdate.corner_right = jQuery("#layer_cornerright").val();


		//update object 
		updateCurrentLayer(objUpdate);


		//update html layers
		updateHtmlLayersFromObject();

		//update html sortbox
		updateHtmlSortboxFromObject();

		//update the timeline with the new data
		updateCurrentLayerTimeline();

		UniteCssEditorRev.setCssPreviewLive();

		//event on element for href
		initDisallowCaptionsOnClick();


		var type = "text";
		if(objLayer.type)
			type = objLayer.type;

		switch(type){
			case 'text':
				if (objUpdate.whitespace=="nowrap") {
					jQuery("#layer_max_height").val("auto");
					jQuery("#layer_max_width").val("auto");	
					objUpdate.max_width = "none";
					objUpdate.max_height = "none;"
					
				}				
				jQuery('#slide_layer_' + selectedLayerSerial+' .innerslide_layer').css({'maxWidth': objUpdate.max_width});
				jQuery('#slide_layer_' + selectedLayerSerial+' .innerslide_layer').css({'maxHeight': objUpdate.max_height});
				jQuery('#slide_layer_' + selectedLayerSerial+' .innerslide_layer').css({'whiteSpace': objUpdate.whitespace});	
				jQuery('#slide_layer_' + selectedLayerSerial).css({'width': "auto"});
				jQuery('#slide_layer_' + selectedLayerSerial).css({'height': "auto"});
					
			break;
			case 'image':
				jQuery('#slide_layer_' + selectedLayerSerial+' .innerslide_layer').css({'maxWidth': objUpdate.max_width});
				jQuery('#slide_layer_' + selectedLayerSerial+' .innerslide_layer').css({'maxHeight': objUpdate.max_height});

			break;
		}

		switch(type){
			case 'text':
			case 'image':	

				var rotation = parseFloat(objUpdate['2d_rotation']),
					trorigin = parseFloat(objUpdate['2d_origin_x'])+ '% '+ parseFloat(objUpdate['2d_origin_y'])+'%',
					element = jQuery('#slide_layer_' + selectedLayerSerial+' .innerslide_layer');
					angle = rotation;
				punchgs.TweenLite.set(jQuery('#slide_layer_' + selectedLayerSerial+' .innerslide_layer'),{transformOrigin:trorigin,overwrite:"auto"});
				
				element.css('transform','rotate(' + angle + 'deg)');
				element.css('-moz-transform','rotate(' + angle + 'deg)');
				element.css('-webkit-transform','rotate(' + angle + 'deg)');
				element.css('-o-transform','rotate(' + angle + 'deg)');

			break;
		}

	}


	/**
	 * redraw some layer html
	 */
	var redrawLayerHtml = function(serial){

		var objLayer = getLayer(serial);
		var html = makeLayerHtml(serial,objLayer)
		var htmlInner = jQuery(html).html();
		var htmlLayer = getHtmlLayerFromSerial(serial);

		htmlLayer.html(htmlInner);
		
	}


	/**
	 * update layer parameters from the object
	 */
	var updateLayerFormFields = function(serial){

		var objLayer = arrLayers[serial];



		jQuery("#layer_caption").val(objLayer.style);
		jQuery("#layer_text").val(UniteAdminRev.stripslashes(objLayer.text));
		jQuery("#layer_alt").val(objLayer.alt);


		jQuery("#layer_scaleX").val(objLayer.scaleX);
		jQuery("#layer_scaleY").val(objLayer.scaleY);

		jQuery("#layer_max_height").val(objLayer.max_height);
		jQuery("#layer_max_width").val(objLayer.max_width);
		jQuery("#layer_2d_rotation").val(objLayer['2d_rotation']);
		jQuery("#layer_2d_origin_x").val(objLayer['2d_origin_x']);
		jQuery("#layer_2d_origin_y").val(objLayer['2d_origin_y']);

		jQuery("#layer_static_start option[value='"+objLayer.static_start+"']").attr('selected', 'selected');
		changeEndStaticFunctions();
		jQuery("#layer_static_end option[value='"+objLayer.static_end+"']").attr('selected', 'selected');

		jQuery("#parallax_level").val(objLayer.parallax_level);
		jQuery("#layer_whitespace option[value='"+objLayer.whitespace+"']").attr('selected', 'selected');



		if(objLayer.scaleProportional == "true" || objLayer.scaleProportional == true)
			jQuery("#layer_proportional_scale").prop("checked",true);
		else
			jQuery("#layer_proportional_scale").prop("checked",false);
		jQuery("#layer_top").val(objLayer.top);
		jQuery("#layer_left").val(objLayer.left);

		//set Loop Animations
		jQuery("#layer_loop_animation option[value='"+objLayer.loop_animation+"']").attr('selected', 'selected');
		jQuery("#layer_loop_easing").val(objLayer.loop_easing);
		jQuery("#layer_loop_speed").val(objLayer.loop_speed);
		jQuery("#layer_loop_startdeg").val(objLayer.loop_startdeg);
		jQuery("#layer_loop_enddeg").val(objLayer.loop_enddeg);
		jQuery("#layer_loop_xorigin").val(objLayer.loop_xorigin);
		jQuery("#layer_loop_yorigin").val(objLayer.loop_yorigin);
		jQuery("#layer_loop_xstart").val(objLayer.loop_xstart);
		jQuery("#layer_loop_xend").val(objLayer.loop_xend);
		jQuery("#layer_loop_ystart").val(objLayer.loop_ystart);
		jQuery("#layer_loop_yend").val(objLayer.loop_yend);
		jQuery("#layer_loop_zoomstart").val(objLayer.loop_zoomstart);
		jQuery("#layer_loop_zoomend").val(objLayer.loop_zoomend);
		jQuery("#layer_loop_angle").val(objLayer.loop_angle);
		jQuery("#layer_loop_radius").val(objLayer.loop_radius);

		jQuery("#layer_animation option[value='"+objLayer.animation+"']").attr('selected', 'selected');

		jQuery("#layer_easing").val(objLayer.easing);

		jQuery("#layer_split").val(objLayer.split);
		jQuery("#layer_endsplit").val(objLayer.endsplit);
		jQuery("#layer_splitdelay").val(objLayer.splitdelay);
		jQuery("#layer_endsplitdelay").val(objLayer.endsplitdelay);

		jQuery("#layer_slide_link").val(objLayer.link_slide);
		jQuery("#layer_scrolloffset").val(objLayer.scrollunder_offset);

		jQuery("#layer_speed").val(objLayer.speed);
		jQuery("#layer_align_hor").val(objLayer.align_hor);
		jQuery("#layer_align_vert").val(objLayer.align_vert);

		if(objLayer.hiddenunder == "true" || objLayer.hiddenunder == true)
			jQuery("#layer_hidden").prop("checked",true);
		else
			jQuery("#layer_hidden").prop("checked",false);

		if(objLayer.resizeme == "true" || objLayer.resizeme == true)
			jQuery("#layer_resizeme").prop("checked",true);
		else
			jQuery("#layer_resizeme").prop("checked",false);

		jQuery("#layer_image_link").val(objLayer.link);
		jQuery("#layer_link_open_in").val(objLayer.link_open_in);
		jQuery("#layer_link_id").val(objLayer.link_id);
		jQuery("#layer_link_class").val(objLayer.link_class);
		jQuery("#layer_link_title").val(objLayer.link_title);
		jQuery("#layer_link_rel").val(objLayer.link_rel);


		jQuery("#layer_endtime").val(objLayer.endtime);
		jQuery("#layer_endanimation").val(objLayer.endanimation);
		jQuery("#layer_endeasing").val(objLayer.endeasing);
		jQuery("#layer_endspeed").val(objLayer.endspeed);

		//set advanced params
		jQuery("#layer_cornerleft").val(objLayer.corner_left);
		jQuery("#layer_cornerright").val(objLayer.corner_right);

		//set align table
		var alignClass = "#linkalign_"+objLayer.align_hor+"_"+objLayer.align_vert;
		jQuery("#align_table a").removeClass("selected");
		jQuery(alignClass).addClass("selected");

		jQuery("#layer_id").val(objLayer.attrID);
		jQuery("#layer_classes").val(objLayer.attrClasses);
		jQuery("#layer_title").val(objLayer.attrTitle);
		jQuery("#layer_rel").val(objLayer.attrRel);




		//show / hide go under slider offset row
		showHideOffsetRow();
		showHideLoopFunctions(); //has to be the last thing done to not interrupt settings


	}


	/**
	 * unselect all html layers
	 */
	var unselectHtmlLayers = function(){

			jQuery(containerID + " .slide_layer.layer_selected").each(function() {
				try {
						jQuery(this).resizable("destroy");
						jQuery(this).find('.innerslide_layer').rotatable("destroy");
					} catch(e) {}
			});


		jQuery(containerID + " .slide_layer").removeClass("layer_selected");
	}


	/**
	 * set all layers unselected
	 */
	var unselectLayers = function(){

		unselectHtmlLayers();
		unselectSortboxItems();
		selectedLayerSerial = -1;
		disableFormFields();


		//reset elements
		jQuery("#layer_alt_row").hide();
		jQuery("#layer_scale_title_row").hide();
		jQuery("#layer_max_width_row").hide();
		jQuery("#layer_max_height_row").hide();
		jQuery("#layer_whitespace_row").hide();
		jQuery("#layer_scaleX_row").hide();
		jQuery("#layer_scaleY_row").hide();
		jQuery("#layer_proportional_scale_row").hide();
		jQuery("#button_edit_video_row").hide();
		jQuery("#button_change_image_source_row").hide();
		jQuery("#layer_text").css("height","80px");

		jQuery("#layer_image_link_row").hide();
		jQuery("#layer_link_id_row").hide();
		jQuery("#layer_link_class_row").hide();
		jQuery("#layer_link_title_row").hide();
		jQuery("#layer_link_rel_row").hide();
		jQuery("#layer_link_open_in_row").hide();

	}

	/*! SET LAYER SELECTED */
	/**
	 * set layer selected representation
	 */
	var setLayerSelected = function(serial){




		if(selectedLayerSerial == serial)
			return(false);


		objLayer = getLayer(serial);


		var layer = getHtmlLayerFromSerial(serial);


		//unselect all other layers
		unselectHtmlLayers();

		//set selected class
		layer.addClass("layer_selected");

		setSortboxItemSelected(serial);

		//update selected serial var
		selectedLayerSerial = serial;
		//update bottom fields
		updateLayerFormFields(serial);

		//enable form fields
		enableFormFields();


		//do specific operations depends on type
		switch(objLayer.type){
			case "video":	//show edit video button
				jQuery("#linkInsertButton").addClass("disabled");
				jQuery("#linkInsertTemplate").addClass("disabled");
				jQuery("#button_edit_video_row").show();

				jQuery("#layer_text").css("height","25px");

				jQuery("#layer_2d_rotation_row").hide();
				jQuery("#layer_2d_origin_x_row").hide();
				jQuery("#layer_2d_origin_y_row").hide();
				jQuery("#layer_2d_title_row").hide();
			break;
			case "image":
				//disable the insert button
				jQuery("#linkInsertButton").addClass("disabled");
				jQuery("#linkInsertTemplate").addClass("disabled");

				//show / hide some elements
				jQuery("#layer_alt_row").show();
				jQuery("#layer_scale_title_row").show();
				jQuery("#layer_scaleX_row").show();
				jQuery("#layer_scaleY_row").show();
				//initScaleImage();
				jQuery("#layer_proportional_scale_row").show();
				jQuery("#button_change_image_source_row").show();
				jQuery("#layer_text").css("height","25px");
				jQuery("#layer_image_link_row").show();
				jQuery("#layer_link_open_in_row").show();
				jQuery("#layer_link_id_row").show();
				jQuery("#layer_link_class_row").show();
				jQuery("#layer_link_title_row").show();
				jQuery("#layer_link_rel_row").show();
				jQuery("#layer_2d_rotation_row").show();
				jQuery("#layer_2d_origin_x_row").show();
				jQuery("#layer_2d_origin_y_row").show();


				if(jQuery("#layer_proportional_scale").is(":checked"))
					var aspectratio = true;
				else
					var aspectratio = false;

				layer.resizable({
					aspectRatio:aspectratio,
					handles:"all",
					start:function(event,ui) {
						ui.element.css({width:ui.originalSize.width,height:ui.originalSize.height});

						ui.element.find('img').css({width:"100%",height:"100%"});
						ui.element.find('.innerslide_layer').css({width:"100%",height:"100%"});	
					},
					resize:function(event,ui) {
						jQuery('#layer_scaleX').val(ui.size.width);
						jQuery('#layer_scaleY').val(ui.size.height);
					},
					stop:function(event,ui) {
						t.updateLayerFromFields();
					}
				});

				layer.find('.innerslide_layer').rotatable({
					angle:layer.find('.innerslide_layer').data('angle'),
					start:function(event,ui) {

					},
					rotate:function(event,ui) {
						jQuery('#layer_2d_rotation').val(getRotationDegrees(ui.element));
						ui.element.data('angle',ui.angle.current);
					},
					stop:function(event,ui) {
						t.updateLayerFromFields();
					}
				});


			break;
			default:  //set layer text to default height
				jQuery("#layer_text").css("height","80px");
				jQuery("#layer_max_width_row").show();
				jQuery("#layer_max_height_row").show();
				jQuery("#layer_whitespace_row").show();
				jQuery("#layer_2d_rotation_row").show();
				jQuery("#layer_2d_origin_x_row").show();
				jQuery("#layer_2d_origin_y_row").show();
				layer.resizable({
					handles:"all",
					resize:function(event,ui) {
						var il = ui.element.find('.innerslide_layer');
						
						il.css({"maxWidth":ui.size.width, "maxHeight":ui.size.height});

						jQuery('#layer_max_width').val(ui.size.width+"px");
						jQuery('#layer_max_height').val(ui.size.height+"px");
					},
					stop:function(event,ui) {
						var il = ui.element.find('.innerslide_layer');
						layer.css({width:il.outerWidth(), height:il.outerHeight()});
						il.css({"maxWidth":"auto","maxHeight":"auto"});
						setTimeout(function() {
							il.css({"maxWidth":il.outerWidth(), "maxHeight":il.outerHeight()});						
							jQuery('#layer_max_width').val(il.width()+"px");
							jQuery('#layer_max_height').val(il.height()+"px");
							layer.css({width:il.outerWidth(),height:il.outerHeight()});
							t.updateLayerFromFields();							
						},50)
					}
				});
				layer.find('.innerslide_layer').rotatable({
					angle:layer.find('.innerslide_layer').data('angle'),
					start:function(event,ui) {

					},
					rotate:function(event,ui) {
						jQuery('#layer_2d_rotation').val(getRotationDegrees(ui.element));
						ui.element.data('angle',ui.angle.current);
					},
					stop:function(event,ui) {
						t.updateLayerFromFields();
					}
				});
			break;
		}



		//hide edit video button
		if(objLayer.type != "video"){
			jQuery("#button_edit_video_row").hide();
		}


		//hide image layer related fields
		if(objLayer.type != "image"){
			jQuery("#layer_alt_row").hide();
			jQuery("#layer_scale_title_row").hide();
			jQuery("#layer_scaleX_row").hide();
			jQuery("#layer_scaleY_row").hide();
			jQuery("#layer_proportional_scale_row").hide();
			jQuery("#layer_image_link_row").hide();
			jQuery("#layer_link_open_in_row").hide();
			jQuery("#button_change_image_source_row").hide();
		}

		//show/hide text related layers
		if(objLayer.type == "text"){
			jQuery("#layer_cornerleft_row").show();
			jQuery("#layer_cornerright_row").show();
			jQuery("#layer_resizeme_row").show();
			jQuery("#layer_max_width_row").show();
			jQuery("#layer_max_height_row").show();
			jQuery("#layer_whitespace_row").show();
		}else{
			jQuery("#layer_cornerleft_row").hide();
			jQuery("#layer_cornerright_row").hide();
			jQuery("#layer_resizeme_row").hide();
			jQuery("#layer_max_width_row").hide();
			jQuery("#layer_max_height_row").hide();
			jQuery("#layer_whitespace_row").hide();
		}


		//hide autocomplete
		jQuery( "#layer_caption" ).autocomplete("close");

		//make layer form validations
		doCurrentLayerValidations();

		//update timeline of the layer
		updateCurrentLayerTimeline();

		//set focus to text editor
		//jQuery("#layer_text").focus();
	}


	var  getRotationDegrees = function(obj) {
	    var matrix = obj.css("-webkit-transform") ||
	    obj.css("-moz-transform")    ||
	    obj.css("-ms-transform")     ||
	    obj.css("-o-transform")      ||
	    obj.css("transform");
	    if(matrix !== 'none') {
	        var values = matrix.split('(')[1].split(')')[0].split(',');
	        var a = values[0];
	        var b = values[1];
	        var angle = Math.round(Math.atan2(b, a) * (180/Math.PI));
	    } else { var angle = 0; }
	    return (angle < 0) ? angle +=360 : angle;
	}
	/**
	 *
	 * return if the layer is selected or not
	 */
	var isLayerSelected = function(serial){
		return(serial == selectedLayerSerial);
	}

	/**
	 * hide in html and sortbox
	 */
	var hideLayer = function(serial,skipGlobalButton){
		var htmlLayer = jQuery("#slide_layer_"+serial);
		htmlLayer.hide();
		setSortboxItemHidden(serial);

		if(skipGlobalButton != true){
			if(isAllLayersHidden())
				jQuery("#button_sort_visibility").addClass("e-disabled");
		}
	}


	/**
	 * show layer in html and sortbox
	 */
	var showLayer = function(serial,skipGlobalButton){
		var htmlLayer = jQuery("#slide_layer_"+serial);
		htmlLayer.show();
		setSortboxItemVisible(serial);

		if(skipGlobalButton != true)
			jQuery("#button_sort_visibility").removeClass("e-disabled");

	}


	/**
	 * show all layers
	 */
	var showAllLayers = function(){
		for (serial in arrLayers)
			showLayer(serial,true);
	}

	/**
	 * hide all layers
	 */
	var hideAllLayers = function(){
		for (serial in arrLayers)
			hideLayer(serial,true);
	}

	/**
	 * hide in html and sortbox
	 */
	var lockAllLayers = function(serial){
		for (serial in arrLayers)
			lockLayer(serial);
	}


	/**
	 * show layer in html and sortbox
	 */
	var unlockAllLayers = function(serial){
		for (serial in arrLayers)
			unlockLayer(serial);
	}


	/**
	 * get true / false if the layer is hidden
	 */
	var isLayerVisible = function(serial){
		var htmlLayer = jQuery("#slide_layer_"+serial);
		var isVisible = htmlLayer.is(":visible");
		return(isVisible);
	}

	/**
	 * get true / false if all layers hidden
	 */
	var isAllLayersHidden = function(){
		for(serial in arrLayers){
			if(isLayerVisible(serial) == true)
				return(false);
		}

		return(true);
	}


	/**
	 * get true / false if the layer can be moved
	 */
	var isLayerLocked = function(serial){
		var htmlLayer = jQuery("#slide_layer_"+serial);
		var isLocked = htmlLayer.attr('aria-disabled');

		if(typeof(isLocked) == 'undefined')
			return false;
		else
			return (isLocked == 'false') ? false : true;
	}


	/**
	 * hide in html and sortbox
	 */
	var lockLayer = function(serial){
		setSortboxItemLocked(serial);

		var layer = getHtmlLayerFromSerial(serial);

		
		layer.draggable('disable');

		try{
			layer.resizable("destroy");
		} catch(e) {}
		try{
			layer.find('.innerslide_layer').rotatable("destroy");
		} catch(e) {}
		layer.removeClass("layer_selected");	
	//	setTimeout(function() {
			layer.blur();
			layer.addClass("ui-state-disabled");
			layer.attr('aria-disabled',true);	
			
	//	},10)
		
	}


	/**
	 * show layer in html and sortbox
	 */
	var unlockLayer = function(serial){
		setSortboxItemUnlocked(serial);
		var layer = getHtmlLayerFromSerial(serial);
		layer.attr('aria-disabled',false);				
		layer.draggable('enable');
		
	}







//======================================================
//			Sortbox Functions
//======================================================

	/**
	 * init the sortbox
	 */
	var initSortbox = function(){

		redrawSortbox();

		//set the sortlist sortable
		jQuery( "#sortlist" ).sortable({
				axis:'y',
				update: function(){
					onSortboxSorted();
				}
		});

		//set input time events:
		jQuery("#sortlist").delegate(".sortbox_time","keyup",function(event){
			if(event.keyCode == 13)
				onSortboxTimeChange(jQuery(this));
		});

		jQuery("#sortlist").delegate(".sortbox_time","blur",function(event){
			onSortboxTimeChange(jQuery(this));
		});




		//set click event
		jQuery("#sortlist").delegate("li","mousedown",function(){

			var serial = getSerialFromSortID(this.id);
			setLayerSelected(serial);
		});


		//on show / hide layer icon click - show / hide layer
		jQuery("#sortlist").delegate(".sortbox_eye","mousedown",function(event){

			var sortboxID = jQuery(this).parent().parent().parent().attr("id");
			var serial = getSerialFromSortID(sortboxID);
			if(isLayerVisible(serial))
				hideLayer(serial);
			else
				showLayer(serial);

			//prevnt the layer from selecting
			event.stopPropagation();
		});

		//on show / hide layer icon click - show / hide layer
		jQuery("#sortlist").delegate(".sortbox_lock","mousedown",function(event){

			var sortboxID = jQuery(this).parent().parent().parent().attr("id");
			var serial = getSerialFromSortID(sortboxID);
			if(isLayerLocked(serial))
				unlockLayer(serial);
			else
				lockLayer(serial);

			//prevent the layer from selecting
			event.stopPropagation();
		});


		//show / hide all layers
		jQuery("#button_sort_visibility").click(function(){
			var button = jQuery(this);
			if(button.hasClass("e-disabled")){	//show all
				button.removeClass("e-disabled");
				showAllLayers();
			}else{	//hide all
				button.addClass("e-disabled");
				hideAllLayers();
			}

		});

		//Lock / Unlock all layers
		jQuery("#button_sort_lock").click(function(){
			var button = jQuery(this);
			if(button.hasClass("e-disabled")){	//show all
				button.removeClass("e-disabled");
				unlockAllLayers();
			}else{	//hide all
				button.addClass("e-disabled");
				lockAllLayers();
			}
		});

		//on show / hide layer icon click - show / hide layer
		jQuery("#sortlist").delegate(".till_slideend","mousedown",function(event){

			var sortboxID = jQuery(this).parent().parent().parent().attr("id");
			var serial = getSerialFromSortID(sortboxID);
			var objLayer = getLayer(serial);

			var button = jQuery(this);

			if (button.hasClass("tillendon")) {
				button.removeClass("tillendon")
				// KRIKI

				if (objLayer.realEndTime == g_slideTime) {
					objLayer.realEndTime = g_slideTime - 200;
					button.closest('li').find('.sortbox_timeend').val(g_slideTime-200);
					updateCurrentLayerTimeline();
				}
			} else {
				button.addClass("tillendon");
				objLayer.realEndTime = g_slideTime;
				button.closest('li').find('.sortbox_timeend').val(g_slideTime);
				updateCurrentLayerTimeline();
			}


		});


	}


	/**
	 * set sortbox items selected
	 */
	var setSortboxItemSelected = function(serial){
		var sortItem = getHtmlSortItemFromSerial(serial);
		unselectSortboxItems();

		sortItem.removeClass("ui-state-default").addClass("ui-state-hover");
	}


	/**
	 * set sortbox item hidden mode
	 */
	var setSortboxItemHidden = function(serial){
		var sortItem = getHtmlSortItemFromSerial(serial);
		sortItem.addClass("sortitem-hidden");
	}

	/**
	 * set sortbox item visible mode
	 */
	var setSortboxItemVisible = function(serial){
		var sortItem = getHtmlSortItemFromSerial(serial);
		sortItem.removeClass("sortitem-hidden");
	}

	/**
	 * set sortbox item locked mode
	 */
	var setSortboxItemLocked = function(serial){
		var sortItem = getHtmlSortItemFromSerial(serial);
		sortItem.addClass("sortitem-locked");
	}

	/**
	 * set sortbox item unlocked mode
	 */
	var setSortboxItemUnlocked = function(serial){
		var sortItem = getHtmlSortItemFromSerial(serial);
		sortItem.removeClass("sortitem-locked");
	}




	/**
	 *
	 * add layer to sortbox
	 */
	var addToSortbox = function(serial,objLayer){


		if (objLayer.realEndTime=="undefined" || objLayer.realEndTime==undefined)
			objLayer = getLayerExtendedParams(objLayer);

		var endslideclass = "";
		if (objLayer.endSpeed ==0 || objLayer.endSpeed == undefined || objLayer.realEndTime >= g_slideTime || objLayer.endWithSlide) {
			objLayer.endWithSlide = true;
			var endslideclass = "tillendon";
		}

		var isVisible = isLayerVisible(serial);
		var classLI = "";
		if(isVisible == false)
			classLI = " sortitem-hidden";

		var sortboxText = getSortboxText(objLayer.text);
		var depth = Number(objLayer.order)+1;

		var htmlSortbox = '<li id="layer_sort_'+serial+'" class="ui-state-default'+classLI+'">';
		htmlSortbox += '<div class="sort_content_container">';
		htmlSortbox += '<span style="display:table-cell"><i class="eg-icon-sort"></i></span>';
		htmlSortbox += '<div class="layer_sort_input_depth sortbox-tablecell">';
		htmlSortbox += '<input type="text" class="sortbox_depth" readonly title="Edit Depth" value="'+depth+'">';
		htmlSortbox += '</div>';
		htmlSortbox += '<div class="sortbox-tablecell sort-iconcollection">';
		htmlSortbox += '<span class="sortbox_eye" title="Show / Hide Layer" class="tipsy_enabled_top"><i class="eg-icon-eye"></i><i class="eg-icon-eye-off"></i></span>';
		htmlSortbox += '<span class="sortbox_lock" title="Lock / Unlock Layer" class="tipsy_enabled_top"><i class="eg-icon-lock-open"></i><i class="eg-icon-lock"></i></span>';
		htmlSortbox += '<span class="till_slideend '+endslideclass+'" title="Snap to Slide End / Custom End" class="tipsy_enabled_top"><i class="eg-icon-back-in-time"></i><i class="eg-icon-minus"></i></span>';
		htmlSortbox += '</div>';

		htmlSortbox += '<div style="position:relative;" class="sort-hover-part layer_sort_layer_text_field sortbox-tablecell" <span class="sortbox_text"><i style="margin:0px 10px" class="';

		switch (objLayer.type) {
			case "text":
				htmlSortbox += 'eg-icon-font';
			break;
			case "image":
				htmlSortbox += 'eg-icon-picture-1';
			break;
			case "video":
				htmlSortbox += 'eg-icon-video';
			break;
		}

		htmlSortbox += '"></i><span class="timer-layer-text">'+sortboxText + '</span></span>';
		htmlSortbox += '<div class="timeline">';
		htmlSortbox += '<div class="tl-fullanim"><div class="tl-startanim"></div><div class="tl-endanim"></div></div>';
		htmlSortbox += '</div>';
		htmlSortbox += '</div>';

		htmlSortbox += '<div class="layer_sort_inputs sortbox-tablecell">';
		htmlSortbox += '<input type="text" class="sortbox_time" title="Edit Layer Start" value="'+objLayer.time+'">';


		htmlSortbox += '<input type="text" class="sortbox_timeend" title="Edit Layer End" value="'+objLayer.realEndTime+'">';
		htmlSortbox += '</div>';
		htmlSortbox += '</div>';
		htmlSortbox += '</li>';

		jQuery("#sortlist").append(htmlSortbox);



		var cur = jQuery('#layer_sort_'+serial+" .timeline"),
			dragfull = cur.find('.tl-fullanim');

		setCurTimer(dragfull);


		dragfull.draggable({
			containment:"parent",
			//snap:".tl-fullanim",
			axis:"x",
			stop:function() {
				updateCurTimer("stop",jQuery(this));
			},
			drag:function() {
				updateCurTimer("resize",jQuery(this));
			}
		})

		dragfull.resizable({
			containment:"parent",
			handles:"w,e",
			stop:function() {
				updateCurTimer("stop",jQuery(this));
			},
			resize:function() {
				updateCurTimer("resize",jQuery(this));
			}
			//snap:".tl-fullanim"
		});

		var iwrapper = jQuery('#layer_sort_'+serial+" .layer_sort_inputs");

		iwrapper.find('input').keypress(function(event){
			if(event.keyCode == 13)
				changeTimerInputs();
		}).blur(changeTimerInputs);

	}

	/**
	 check if the Layer should go till Slide End, or should animate our before.
	 if objLayer.endWithSlide == true -> the Layer should not get any "data-end" output !!
	*/
	var checkTillSlideEnd = function(li,objLayer) {
		if ( objLayer.realEndTime >= g_slideTime) {
			objLayer.endWithSlide = true;
			li.find('.till_slideend').addClass("tillendon");
		} else {
			objLayer.endWithSlide = false;
			li.find('.till_slideend').removeClass("tillendon");

		}

	}

	/**
	  on Input Change we need to resize and reposition all available Timer lines
	*/
	var changeTimerInputs = function() {
		var li = jQuery(this).closest("li"),
					sortLayerID = li.attr("id"),
					serial = getSerialFromSortID(sortLayerID);
					objLayer = getLayer(serial),
					iwrapper = jQuery(this).closest('.layer_sort_inputs'),
					times = iwrapper.find('.sortbox_time'),
					timee = iwrapper.find('.sortbox_timeend');

				if (Number(timee.val()) < Number(times.val())) {
					timee.val((parseInt(times.val(),0) + 1000+ objLayer.speed+objLayer.endspeed));
				}

				objLayer.time = Number(times.val());
				objLayer.realEndTime = Number(timee.val());
				checkTillSlideEnd(li,objLayer);
				setCurTimer(li.find('.tl-fullanim'));
				jQuery('#layer_endtime').val((objLayer.realEndTime-objLayer.endSpeedFinal));
	}

	/**
	 * update timeline of current layer
	 */
	var updateCurrentLayerTimeline = function(){

		jQuery('#sortlist').find('.tl-fullanim').each(function() {
			setCurTimer(jQuery(this));
		})

	}

	/**
		Set the Current Timer Line to Position end start/end time should be set as well
	*/
	var setCurTimer = function(timer) {

				var li = timer.closest("li"),
					sortLayerID = li.attr("id"),
					serial = getSerialFromSortID(sortLayerID);
					objLayer = getLayer(serial);

				var tl = li.find('.timeline'),
					tw = tl.width(),
					dragfull = li.find('.tl-fullanim'),
					dragstart =dragfull.find('.tl-startanim'),
					dragend = dragfull.find('.tl-endanim'),
					ft = g_slideTime;
					if (objLayer.realEndTime=="undefined" || objLayer.realEndTime==undefined)
						objLayer = getLayerExtendedParams(objLayer);

					dragfull.css({width:((objLayer.realEndTime - objLayer.time) / ft)*100+"%",
								  left: ((objLayer.time) / ft) *100+"%"});

					dragstart.css({width:(objLayer.speed / ft)*tw+"px" });
					dragend.css({width:(objLayer.endspeed / ft)*tw+"px" });

					checkTillSlideEnd(li,objLayer);

					jQuery('#layer_endtime').val((objLayer.realEndTime-objLayer.endSpeedFinal));
	}

	var updateLayerTextField = function(event,timerobj,txt) {
		
				var li = timerobj.closest("li");	
				txt = getSortboxText(txt);			
				li.find('.timer-layer-text').html(txt);

	}
	/**
		Update the Current Timelines
	*/
	var updateCurTimer = function(event,timer) {

				var li = timer.closest("li"),
					sortLayerID = li.attr("id"),
					serial = getSerialFromSortID(sortLayerID),
					objLayer = getLayer(serial),
					l = timer.position().left,
					w = timer.width(),
					tl = li.find('.timeline'),
					tw = tl.width(),
					dragstart = tl.find('.tl-startanim'),
					dragend = tl.find('.tl-endanim');

				objLayer = getLayerExtendedParams(objLayer);



				if (l+w > tw) timer.css({left:(tw-w)});
				if (l<0) timer.css({left:"0px"});
				if (w > tw) timer.width(tw);

				var	ft = g_slideTime,
					ns = Math.round(((l / tl.width()) * ft)/50)*50,
					ne = ns+Math.round(((w / tl.width()) * ft)/50)*50,
					dif = ne-ns;

				if (ne>ft) {
					ne = ft;
					ns = ne - dif;
				}

				if (ns<0) ns=0;

				li.find('.sortbox_time').val(ns);
				li.find('.sortbox_timeend').val(ne);

				if (event=="stop") {
					timer.css({left:(timer.position().left / tw)*100+"%",
							   width:(timer.width() / tw)*100+"%"
					})
				}


				dragstart.css({width:(objLayer.speed / ft)*tw+"px" });
				dragend.css({width:(objLayer.endspeed / ft)*tw+"px" });

				objLayer.endTimeFinal = ne - objLayer.endSpeedFinal;
				objLayer.endtime = ne - objLayer.endSpeedFinal;
				objLayer.realEndTime = ne;
				objLayer.time = ns;
				objLayer.timeLast = objLayer.endTimeFinal;


				jQuery('#layer_endtime').val((objLayer.realEndTime-objLayer.endSpeedFinal));

				checkTillSlideEnd(li,objLayer);


			}

	/**
		Show / HIde The Timelines
	*/
	var showHideTimeines = function() {
		/* HIDE / SHOW  TIMELINES */

		jQuery('#button_sort_timing').click(function() {
			var bst = jQuery(this);
			if (bst.hasClass("off")) {
				bst.removeClass("off");
				bst.find('.onoff').html('- on');
				punchgs.TweenLite.to(jQuery('#sortlist .timeline'),0.5,{autoAlpha:0.5,overwrite:"auto"});
			} else {
				punchgs.TweenLite.to(jQuery('#sortlist .timeline'),0.5,{autoAlpha:0,overwrite:"auto"});
				bst.addClass("off");
				bst.find('.onoff').html('- off');
			}
		})

	}


	/**
	 *
	 * delete layer from sortbox
	 */
	var deleteLayerFromSortbox = function(serial){
		var sortboxLayer = getHtmlSortItemFromSerial(serial);
		sortboxLayer.remove();
	}

	/**
	 *
	 * unselect all items in sortbox
	 */
	var unselectSortboxItems = function(){
		jQuery("#sortlist li").removeClass("ui-state-hover").addClass("ui-state-default");
	}


	/**
	 * update layers order from sortbox elements
	 */
	var updateOrderFromSortbox = function(){

		var arrSortLayers = jQuery( "#sortlist" ).sortable("toArray");

		for(var i=0;i<arrSortLayers.length;i++){
			var sortID = arrSortLayers[i];
			var serial = getSerialFromSortID(sortID);
			var objUpdate = {order:i};
			updateLayer(serial,objUpdate);

			//update sortbox order input
			var depth = i+1;
			jQuery("#"+sortID+" input.sortbox_depth").val(depth);
		}

		//update z-index of the html window by order
		updateZIndexByOrder();
	}

	/**
	 * shift order among all the layers, push down all order num beyong the given
	 * need to redraw after this function
	 */
	var shiftOrder = function(orderToFree){

		for(key in arrLayers){
			var obj = arrLayers[key];
			if(obj.order >= orderToFree){
				obj.order = Number(obj.order)+1;
				arrLayers[key] = obj;
			}
		}
	}


	/**
	 * get sortbox text from layer html
	 */
	var getSortboxText = function(text){
		sorboxTextSize = 20;
		var textSortbox = UniteAdminRev.stripTags(text);

		//if no content - escape html
		if(textSortbox.length < 2)
			textSortbox = UniteAdminRev.htmlspecialchars(text);

		//short text
		if(textSortbox.length > sorboxTextSize)
			textSortbox = textSortbox.slice(0,sorboxTextSize)+"...";

		return(textSortbox);
	}

	/**
	 *
	 * redraw the sortbox
	 */
	var redrawSortbox = function(mode){

		if(mode == undefined)
			mode = sortMode;

		emptySortbox();

		var layers_array = getLayersSorted("depth");

		if(layers_array.length == 0)
			return(false);

		for(var i=0; i<layers_array.length;i++){
			var objLayer = layers_array[i];

			addToSortbox(objLayer.serial,objLayer);
		}



		if(selectedLayerSerial != -1)
			setSortboxItemSelected(selectedLayerSerial);

	}



	/**
	 * remove all from sortbox
	 */
	var emptySortbox = function(){
		jQuery("#sortlist").html("");
	}

	/**
	 *
	 * update sortbox text from object
	 */
	var updateHtmlSortboxFromObject = function(serial){
		if(!serial)
			serial = selectedLayerSerial;

		var objLayer = getLayer(serial);

		if(!objLayer)
			return(false);

		var htmlSortItem = getHtmlSortItemFromSerial(serial);

		if(!htmlSortItem)
			return(false);

		var sortboxText = getSortboxText(objLayer.text);
		htmlSortItem.children(".sortbox_text").text(sortboxText);
	}

	/**
	 * on sortbox sorted event.
	 */
	var onSortboxSorted = function(){
			updateOrderFromSortbox();

	}


//======================================================
//			Sortbox Functions End
//======================================================


//======================================================
//			Time Functions
//======================================================

	/**
	 * get next available time
	 */
	var getNextTime = function(){
		var maxTime = 0;

		//get max time
		for (key in arrLayers){
			var layer = arrLayers[key];

			layerTime = (layer.time)?Number(layer.time):0;

			if(layerTime > maxTime)
					maxTime = layerTime;
		}

		var outputTime;
		if(maxTime == 0)
			outputTime = g_startTime;
		else
			outputTime = Number(maxTime) + Number(g_stepTime);

		return(outputTime);
	}


	/**
	 * change time on the layer from the sortbox and reorder
	 */
	var onSortboxTimeChange = function(inputBox){

		//update the time by inputbox:
		var timeValue = inputBox.val();
		timeValue = Number(timeValue);
		var sortLayerID = inputBox.parent().parent().parent().attr("id");

		var serial = getSerialFromSortID(sortLayerID);
		var objUpdate = {time:timeValue};

		updateLayer(serial,objUpdate);
		validateCurrentLayerTimes();
	}

	/**
	 * change time on the layer from the sortbox and reorder
	 */
	var onSortboxDepthChange = function(inputBox){

		//update the time by inputbox:
		var depthValue = inputBox.val();
		depthValue = Number(depthValue);
		var order = depthValue-1;

		var sortLayerID = inputBox.parent().attr("id");
		var serial = getSerialFromSortID(sortLayerID);
		var objUpdate = {order:order};

		updateLayer(serial,objUpdate);

		redrawSortbox();

		updateOrderFromSortbox();

	}


	/**
	 * order layers by time
	 * type can be [time] or [order]
	 */
	var getLayersSorted = function(type){

		if(type == undefined)
			type = "time";

		//convert to array
		var layers_array = [];
		for(key in arrLayers){
			var obj = arrLayers[key];
			obj.serial = key;
			layers_array.push(obj);
		}

		if(layers_array.length == 0)
			return(layers_array);

		//sort layers array
		layers_array.sort(function(layer1,layer2){

			switch(type){
				case "time":

					if(Number(layer1.time) == Number(layer2.time)){
						if(layer1.order == layer2.order)
							return(0);

						if(layer1.order > layer2.order)
							return(1);

						return(-1);
					}

					if(Number(layer1.time) > Number(layer2.time))
						return(1);
				break;
				case "depth":
					if(layer1.order == layer2.order)
						return(0);

					if(layer1.order > layer2.order)
						return(1);
				break;
				default:
					trace("wrong sort type: "+type);
				break;
			}

			return(-1);
		});

		return(layers_array);

	}



	/**
	 * reditribute times between the layers sorted from small to big
	 */
	var redistributeTimes = function(){

		//collect times to array:
		var arrTimes = [];
		for(key in arrLayers)
			arrTimes.push(Number(arrLayers[key].time));

		arrTimes.sort(function(a,b){return a-b});	//sort number

		var arrSortLayers = jQuery( "#sortlist" ).sortable("toArray");

		for(var i=0;i<arrSortLayers.length;i++){
			var sortID = arrSortLayers[i];
			var serial = getSerialFromSortID(sortID);

			//update time:
			var newTime = arrTimes[i];
			var objUpdate = {time:newTime};
			updateLayer(serial,objUpdate);

			//update input box:
			jQuery("#"+sortID+" input.sortbox_time").val(newTime);
		}

	}



//======================================================
//				Time Functions End
//======================================================


//======================================================
//				Events Functions
//======================================================

	/**
	 *
	 * on layer drag event - update layer position
	 */
	var onLayerDrag = function(){

		var layerSerial = getSerialFromID(this.id);
		var htmlLayer = jQuery(this);
		var position = htmlLayer.position();
		var objLayer = getLayer(layerSerial);

		var posTop = Math.round(position.top);
		var posLeft = Math.round(position.left);
		var layerWidth = htmlLayer.outerWidth();
		var totalWidth = container.width();
		var layerHeight = htmlLayer.outerHeight();
		var totalHeight = container.height();

		var updateY,updateX;


		setLayerSelected(layerSerial);

		switch(objLayer.align_hor){
			case "left":
				updateX = posLeft;
			break;
			case "right":
				updateX = totalWidth - posLeft - layerWidth;
			break;
			case "center":
				updateX = posLeft - (totalWidth - layerWidth)/2;
				updateX = Math.round(updateX);
			break;
		}

		switch(objLayer.align_vert){
			case "top":
				updateY = posTop;
			break;
			case "bottom":
				updateY = totalHeight - posTop - layerHeight;
			break;
			case "middle":
				updateY = posTop - (totalHeight - layerHeight)/2;
				updateY = Math.round(updateY);
			break;
		}

		var objUpdate = {top:updateY,left:updateX,width:layerWidth,height:layerHeight};
		updateLayer(layerSerial,objUpdate);

		//update the position back with the rounded numbers (improve precision)
		updateHtmlLayerPosition(false,htmlLayer,objLayer,objUpdate.top,objUpdate.left,"left","top");

		//update bottom fields (only if selected)
		if(isLayerSelected(layerSerial))
			updateLayerFormFields(layerSerial);
	}


	/**
	 * move some layer
	 */
	var moveLayer = function(serial,dir,step){
		var layer = getLayer(serial);

		if(!layer)
			return(false);

		switch(dir){
			case "down":
				arrLayers[serial].top += step;
			break;
			case "up":
				arrLayers[serial].top -= step;
			break;
			case "right":
				arrLayers[serial].left += step;
			break;
			case "left":
				arrLayers[serial].left -= step;
			break;
			default:
				UniteAdminRev.showErrorMessage("wrong direction: "+dir);
				return(false);
			break;
		}

		updateHtmlLayersFromObject(serial);

		if(isLayerSelected(serial))
			updateLayerFormFields(serial);
	}


//======================================================
//		Events Functions End
//======================================================

//======================================================
//	Time Line Functions
//======================================================


	/**
	 * get some calculations like real end time
	 */
	var getLayerExtendedParams = function(layer){

		var endSpeed = layer.endspeed;
		if(!endSpeed)
			endSpeed = layer.speed;

		endSpeed = Number(endSpeed);

		var endTime = layer.endtime;


		var realEndTime;

		if(!endTime || endTime == undefined || endTime == ""){	//end time does not given
			endTime = g_slideTime - Number(layer.speed);
			realEndTime = g_slideTime;
		}else{	//end time given
			realEndTime = Number(endTime) + Number(endSpeed);
		}



		layer.endTimeFinal = Number(endTime); 	 //time caption stay - without end transition
		layer.endSpeedFinal = Number(endSpeed);
		layer.realEndTime = Number(realEndTime); //time with end transition

		layer.timeLast = layer.realEndTime - layer.time;	//time that the whole caption last

		return(layer);
	}



	//======================================================
	//	Scale Functions
	//======================================================
		/**
		 * calculate image height/width
		 */

		var scaleImage = function(){
			jQuery("#layer_scaleX").change(function(){
				if(jQuery("#layer_proportional_scale").is(":checked"))
					scaleProportional(true);
				else
					scaleNormal();
			});

			jQuery("#layer_scaleY").change(function(){
				if(jQuery("#layer_proportional_scale").is(":checked"))
					scaleProportional(false);
				else
					scaleNormal();
			});

			jQuery("#layer_proportional_scale").click(function(){
				var serial = selectedLayerSerial;
				var layer = jQuery("#slide_layer_" + serial);


				if(jQuery(this).is(":checked")){
					scaleProportional(true);
					var aspectratio = true;
				}else{
					scaleNormal();
					var aspectratio = false;
				}

				layer.resizable("destroy").resizable({
					aspectRatio:aspectratio,
					resize:function(event,ui) {

						ui.element.find('img').css({width:"100%",height:"100%"});
						jQuery('#layer_scaleX').val(ui.size.width);
						jQuery('#layer_scaleY').val(ui.size.height);
					},
					stop:function(event,ui) {
						t.updateLayerFromFields();
					}
				});



			});


			jQuery("#reset-scale").click(function(){

				resetImageDimensions();
				jQuery("#layer_proportional_scale").attr('checked', false);
				jQuery("#layer_scaleX_text").html(jQuery("#layer_scaleX_text").data("textnormal")).css("width", "10px");
				jQuery("#layer_scaleX").val("");
				jQuery("#layer_scaleY").val("");

				jQuery("#slide_layer_" + selectedLayerSerial + " img").css("width", "");
				jQuery("#slide_layer_" + selectedLayerSerial + " img").css("height", "");
				t.updateLayerFromFields();
			});

		}

		var scaleProportional = function(useX){
			var serial = selectedLayerSerial;

			resetImageDimensions();

			var imgObj = new Image();
			imgObj.src = jQuery("#slide_layer_" + serial + " img").attr("src");

			if(useX){
				var x = parseInt(jQuery("#layer_scaleX").val());
				if(isNaN(x)) x = imgObj.width;
				var y = Math.round(100 / imgObj.width * x / 100 * imgObj.height, 0);
			}else{
				var y = parseInt(jQuery("#layer_scaleY").val());
				if(isNaN(y)) y = imgObj.height;
				var x = Math.round(100 / imgObj.height * y / 100 * imgObj.width, 0);
			}

			jQuery("#slide_layer_" + serial + " img").css("width", x + "px");
			jQuery("#slide_layer_" + serial + " img").css("height", y + "px");

			jQuery("#slide_layer_" + serial).css("width", jQuery("#slide_layer_" + serial + " img").width() + "px");
			jQuery("#slide_layer_" + serial).css("height", jQuery("#slide_layer_" + serial + " img").height() + "px");


			jQuery("#slide_layer_" + serial + " img").css("width", "100%");
			jQuery("#slide_layer_" + serial + " img").css("height", "100%");

			jQuery("#layer_scaleX").val(x);
			jQuery("#layer_scaleY").val(y);
		}

		var scaleNormal = function(){
			var serial = selectedLayerSerial;

			var imgdims = resetImageDimensions();

			jQuery("#slide_layer_" + serial + " img").css("width", jQuery("#layer_scaleX").val() + "px");
			jQuery("#slide_layer_" + serial + " img").css("height", jQuery("#layer_scaleY").val() + "px");

			jQuery("#slide_layer_" + serial).css("width", jQuery("#slide_layer_" + serial + " img").width() + "px");
			jQuery("#slide_layer_" + serial).css("height", jQuery("#slide_layer_" + serial + " img").height() + "px");
			

			
			jQuery("#slide_layer_" + serial + " img").css("width", "100%");
			jQuery("#slide_layer_" + serial + " img").css("height", "100%");
		}

		var resetImageDimensions = function(){
			var imgObj = new Image();
			imgObj.src = jQuery("#slide_layer_" + selectedLayerSerial + " img").attr("src");

			jQuery("#slide_layer_" + selectedLayerSerial).css("width", imgObj.width + "px");
			jQuery("#slide_layer_" + selectedLayerSerial).css("height", imgObj.height + "px");
			
			var imgdims = {width:imgObj.width, height:imgObj.height};
			return imgdims;
		}

	//======================================================
	//	Scale Functions End
	//======================================================

	t.getLayerGeneralParamsStatus = function(){
		return layerGeneralParamsStatus;
	}

	//======================================================
	//	Main Background Image Functions
	//======================================================

	var initBackgroundFunctions = function(){

		jQuery('#slide_bg_fit').change(function(){
			if(jQuery(this).val() == 'percentage'){
				jQuery('input[name="bg_fit_x"]').show();
				jQuery('input[name="bg_fit_y"]').show();

				jQuery('#divbgholder').css('background-size', jQuery('input[name="bg_fit_x"]').val()+'% '+jQuery('input[name="bg_fit_y"]').val()+'%');
			}else{
				jQuery('input[name="bg_fit_x"]').hide();
				jQuery('input[name="bg_fit_y"]').hide();

				jQuery('#divbgholder').css('background-size', jQuery(this).val());
			}


			if(jQuery(this).val() == 'contain'){
				jQuery('#divLayers-wrapper').css('maxWidth', jQuery('#divbgholder').css('minWidth'));
			}else{
				jQuery('#divLayers-wrapper').css('maxWidth', '100%');
			}
		});
		jQuery('#slide_bg_fit').change();

		jQuery('input[name="bg_fit_x"]').change(function(){
			jQuery('#divbgholder').css('background-size', jQuery('input[name="bg_fit_x"]').val()+'% '+jQuery('input[name="bg_fit_y"]').val()+'%');
		});

		jQuery('input[name="bg_fit_y"]').change(function(){
			jQuery('#divbgholder').css('background-size', jQuery('input[name="bg_fit_x"]').val()+'% '+jQuery('input[name="bg_fit_y"]').val()+'%');
		});

		jQuery('#slide_bg_position').change(function(){
			if(jQuery(this).val() == 'percentage'){
				jQuery('input[name="bg_position_x"]').show();
				jQuery('input[name="bg_position_y"]').show();

				jQuery('#divbgholder').css('background-position', jQuery('input[name="bg_fit_x"]').val()+'% '+jQuery('input[name="bg_fit_y"]').val()+'%');
			}else{
				jQuery('input[name="bg_position_x"]').hide();
				jQuery('input[name="bg_position_y"]').hide();

				jQuery('#divbgholder').css('background-position', jQuery(this).val());
			}
		});

		jQuery('input[name="bg_position_x"]').change(function(){
			jQuery('#divbgholder').css('background-position', jQuery('input[name="bg_position_x"]').val()+'% '+jQuery('input[name="bg_position_y"]').val()+'%');
		});

		jQuery('input[name="bg_position_y"]').change(function(){
			jQuery('#divbgholder').css('background-position', jQuery('input[name="bg_position_x"]').val()+'% '+jQuery('input[name="bg_position_y"]').val()+'%');
		});

		jQuery('#slide_bg_repeat').change(function(){
			jQuery('#divbgholder').css('background-repeat', jQuery(this).val());
		});

		jQuery('input[name="kenburn_effect"]').change(function(){
			if(jQuery(this).val() == "on"){
				jQuery('#kenburn_wrapper').show();
				jQuery('#bg-position-lbl').hide();
				jQuery('#bg-start-position-wrapper').children().appendTo(jQuery('#bg-start-position-wrapper-kb'));
				jQuery('#bg-setting-wrap').hide();

				jQuery('#divbgholder').css('background-repeat', '');
				jQuery('#divbgholder').css('background-position', '');
				jQuery('#divbgholder').css('background-size', '');

				jQuery('input[name="kb_start_fit"]').change();

				jQuery('#divLayers-wrapper').css('maxWidth', 'none');

				jQuery('#slide_bg_position').change();
			}else{
				jQuery('#kenburn_wrapper').hide();
				jQuery('#bg-position-lbl').show();
				jQuery('#bg-start-position-wrapper-kb').children().appendTo(jQuery('#bg-start-position-wrapper'));
				jQuery('#bg-setting-wrap').show();

				jQuery('#slide_bg_repeat').change();
				jQuery('#slide_bg_position').change();
				jQuery('#slide_bg_fit').change();

				if(jQuery('#slide_bg_fit').val() == 'contain'){
					jQuery('#divLayers-wrapper').css('maxWidth', jQuery('#divbgholder').css('minWidth'));
				}else{
					jQuery('#divLayers-wrapper').css('maxWidth', '100%');
				}


			}
		});
		jQuery('input[name="kenburn_effect"]:checked').change();


		jQuery('#slide_bg_end_position').change(function(){
			if(jQuery(this).val() == 'percentage'){
				jQuery('input[name="bg_end_position_x"]').show();
				jQuery('input[name="bg_end_position_y"]').show();
			}else{
				jQuery('input[name="bg_end_position_x"]').hide();
				jQuery('input[name="bg_end_position_y"]').hide();
			}
		});


		jQuery('input[name="kb_start_fit"]').change(function(){
			var fitVal = parseInt(jQuery(this).val());
			var limg = new Image();
			limg.onload = function() {
				calculateKenBurnScales(fitVal, limg.width, limg.height, jQuery('#divbgholder'));
			}

			var urlImage = '';
			if(jQuery('#radio_back_image').is(':checked'))
				urlImage = jQuery("#image_url").val();
			else if(jQuery('#radio_back_external').is(':checked'))
				urlImage = jQuery("#slide_bg_external").val();

			if(urlImage != ''){
				limg.src = urlImage;
			}

		});

		var calculateKenBurnScales = function(proc,owidth,oheight,opt) {
		   var ow = owidth;
		   var oh = oheight;


		   var factor = (opt.width() /ow);
		   var factorh = (opt.height() / oh);

		 //  if (factor>=1) {

				var nheight = oh * factor;
				proc = proc + "%";
				var hfactor = "auto"; //(nheight / opt.height())*proc;
			/*} else {

				var nwidth = "auto" //ow * factorh;
				var hfactor = proc+"%";
				proc = "auto";
				//proc = (nwidth / opt.width()) * proc;

			}*/

		   jQuery('#divbgholder').css('background-size', proc+" "+hfactor);
		}


		jQuery(window).resize(function(){
			if(jQuery('input[name="kenburn_effect"]:checked').val() == 'on'){
				var fitVal = parseInt(jQuery('input[name="kb_start_fit"]').val());
				var limg = new Image();
				limg.onload = function() {
					calculateKenBurnScales(fitVal, limg.width, limg.height, jQuery('#divbgholder'));
				}

				var urlImage = '';
				if(jQuery('#radio_back_image').is(':checked'))
					urlImage = jQuery("#image_url").val();
				else if(jQuery('#radio_back_external').is(':checked'))
					urlImage = jQuery("#slide_bg_external").val();

				if(urlImage != ''){
					limg.src = urlImage;
				}

			}
		});
	}

	//======================================================
	//	Main Background Image Functions End
	//======================================================

	var initLoopFunctions = function(){

		jQuery('select[name="layer_loop_animation"]').change(function(){
			showHideLoopFunctions();
		});

		jQuery('#layer_static_start').change(function(){
			changeEndStaticFunctions();
		});
	}

	var showHideLoopFunctions = function(){

		jQuery('select[name="layer_loop_animation"]').each(function(){
			jQuery("#layer_easing_wrapper").hide();
			jQuery("#layer_speed_wrapper").hide();
			jQuery("#layer_degree_wrapper").hide();
			jQuery("#layer_origin_wrapper").hide();
			jQuery("#layer_x_wrapper").hide();
			jQuery("#layer_y_wrapper").hide();
			jQuery("#layer_zoom_wrapper").hide();
			jQuery("#layer_angle_wrapper").hide();
			jQuery("#layer_radius_wrapper").hide();

			switch(jQuery(this).val()){
				case 'none':
				break;
				case 'rs-pendulum':
					jQuery("#layer_easing_wrapper").show();
					jQuery("#layer_speed_wrapper").show();
					jQuery("#layer_degree_wrapper").show();
					jQuery("#layer_origin_wrapper").show();
				break;
				case 'rs-rotate':
					jQuery("#layer_easing_wrapper").show();
					jQuery("#layer_speed_wrapper").show();
					jQuery("#layer_degree_wrapper").show();
					jQuery("#layer_origin_wrapper").show();
				break;
				
				case 'rs-slideloop':
					jQuery("#layer_easing_wrapper").show();
					jQuery("#layer_speed_wrapper").show();
					jQuery("#layer_x_wrapper").show();
					jQuery("#layer_y_wrapper").show();
				break;
				case 'rs-pulse':
					jQuery("#layer_easing_wrapper").show();
					jQuery("#layer_speed_wrapper").show();
					jQuery("#layer_zoom_wrapper").show();
				break;
				case 'rs-wave':
					jQuery("#layer_speed_wrapper").show();
					jQuery("#layer_angle_wrapper").show();
					jQuery("#layer_radius_wrapper").show();
					jQuery("#layer_origin_wrapper").show();
				break;
			}
		});
	}

	var changeEndStaticFunctions = function(){

		jQuery('#layer_static_start').each(function(){
			var cur_att = parseInt(jQuery(this).val());
			var cur_end = jQuery('#layer_static_end option:selected').val();
			var go_max_up_to = parseInt(jQuery('#layer_static_end option:last-child').val());
			var go_up_to = parseInt(jQuery('#layer_static_start option:last-child').val()) + 1;

			jQuery('#layer_static_end').empty();

			for(var cur=cur_att+ 1; cur<=go_max_up_to; cur++){
				jQuery("#layer_static_end").append('<option value="'+cur+'">'+cur+'</option>');
			}

			jQuery("#layer_static_end option[value='"+cur_end+"']").attr('selected', 'selected');
		});
	}

}




