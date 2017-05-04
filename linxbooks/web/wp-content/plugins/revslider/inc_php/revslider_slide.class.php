<?php

	class RevSlide extends UniteElementsBaseRev{
		
		private $id;
		private $sliderID;
		private $slideOrder;		
		
		private $imageUrl;
		private $imageID;		
		private $imageThumb;		
		private $imageFilepath;
		private $imageFilename;
		
		private $params;
		private $arrLayers;
		private $arrChildren = null;
		private $slider;
		
		private $static_slide = false;
		
		private $postData;
		private $templateID;
		
		public function __construct(){
			parent::__construct();
		}
		
		/**
		 * 
		 * init slide by db record
		 */
		public function initByData($record){
		
			$this->id = $record["id"];
			$this->sliderID = $record["slider_id"];
			$this->slideOrder = @$record["slide_order"];
			
			$params = $record["params"];
			$params = (array)json_decode($params);
			
			$layers = $record["layers"];
			$layers = (array)json_decode($layers);
			$layers = UniteFunctionsRev::convertStdClassToArray($layers);

			$imageID = UniteFunctionsRev::getVal($params, "image_id");
			
			//get image url and thumb url
			if(!empty($imageID)){
				$this->imageID = $imageID;
				
				$imageUrl = UniteFunctionsWPRev::getUrlAttachmentImage($imageID);
				if(empty($imageUrl))
					$imageUrl = UniteFunctionsRev::getVal($params, "image");
				
				$this->imageThumb = UniteFunctionsWPRev::getUrlAttachmentImage($imageID,UniteFunctionsWPRev::THUMB_MEDIUM);
				
			}else{
				$imageUrl = UniteFunctionsRev::getVal($params, "image");
			}
			
			if(is_ssl()){
				$imageUrl = str_replace("http://", "https://", $imageUrl);
			}
			
			//dmp($imageUrl);exit();
			
			//set image path, file and url
			$this->imageUrl = $imageUrl;
			
			$this->imageFilepath = UniteFunctionsWPRev::getImagePathFromURL($this->imageUrl);
		    $realPath = UniteFunctionsWPRev::getPathContent().$this->imageFilepath;
		    
		    if(file_exists($realPath) == false || is_file($realPath) == false)
		    	$this->imageFilepath = "";
		    
			$this->imageFilename = basename($this->imageUrl);
			
			$this->params = $params;
			$this->arrLayers = $layers;	
			
		}
		
		
		/**
		 * 
		 * init by another slide
		 */
		private function initBySlide(RevSlide $slide){
			
			$this->id = "template";
			$this->templateID = $slide->getID();
			$this->sliderID = $slide->getSliderID();
			$this->slideOrder = $slide->getOrder();
			
			$this->imageUrl = $slide->getImageUrl();
			$this->imageID = $slide->getImageID();
			$this->imageThumb = $slide->getThumbUrl();		
			$this->imageFilepath = $slide->getImageFilepath();
			$this->imageFilename = $slide->getImageFilename();
			
			$this->params = $slide->getParams();
			
			$this->arrLayers = $slide->getLayers();
			
			$this->arrChildren = $slide->getArrChildrenPure();
		}
		
		
		
		/**
		 * 
		 * init slide by post data
		 */
		public function initByPostData($postData, RevSlide $slideTemplate, $sliderID){
			
			$this->postData = $this->postData;
			
			$postID = $postData["ID"];
						
			$arrWildcardsValues = RevOperations::getPostWilcardValues($postID);
			$slideTemplateID = UniteFunctionsRev::getVal($arrWildcardsValues, "slide_template");
						
			if(!empty($slideTemplateID) && is_numeric($slideTemplateID)){
				
					//init by local template, if fail, init by global (slider) template
				try{
					
					$slideTemplateLocal = new RevSlide();
					$slideTemplateLocal->initByID($slideTemplateID);
					$this->initBySlide($slideTemplateLocal);
				}
				catch(Exception $e){
					$this->initBySlide($slideTemplate);
				}
								
			}else{
				//init by global template
				$this->initBySlide($slideTemplate);
				
			}
			
			//set some slide params
			$this->id = $postID;
			$this->params["title"] = UniteFunctionsRev::getVal($postData, "post_title");
			
			if(@$this->params['enable_link'] == "true" && @$this->params['link_type'] == "regular"){
				$link = get_permalink($postID);
				$this->params["link"] = str_replace("%link%", $link, $this->params["link"]);
				$this->params["link"] = str_replace('-', '_REVSLIDER_', $this->params["link"]);
				
				//process meta tags:
				$arrMatches = array();
				preg_match('/%meta:\w+%/', $this->params["link"], $arrMatches);
				
				foreach($arrMatches as $match){
					$meta = str_replace("%meta:", "", $match);
					$meta = str_replace("%","",$meta);
					$meta = str_replace('_REVSLIDER_', '-', $meta);
					$metaValue = get_post_meta($postID,$meta,true);
					$this->params["link"] = str_replace($match,$metaValue,$this->params["link"]);
				}
				
				$this->params["link"] = str_replace('_REVSLIDER_','-',$this->params["link"]);
				
			}
			
			$status = $postData["post_status"];
			
			if($status == "publish")
				$this->params["state"] = "published";
			else
				$this->params["state"] = "unpublished";
			
			//set image
			$thumbID = UniteFunctionsWPRev::getPostThumbID($postID);
			
			if(!empty($thumbID))
				$this->setImageByImageID($thumbID);
			
			//replace placeholders in layers:
			$this->setLayersByPostData($postData, $sliderID);
		}
		
		
		/**
		 * 
		 * replace layer placeholders by post data
		 */
		private function setLayersByPostData($postData,$sliderID){
			
			$postID = $postData["ID"];
			
			$title = UniteFunctionsRev::getVal($postData, "post_title");
			
			$excerpt_limit = $this->getSliderParam($sliderID,"excerpt_limit",55,RevSlider::VALIDATE_NUMERIC);
			$excerpt_limit = (int)$excerpt_limit;
			$excerpt = UniteFunctionsWPRev::getExcerptById($postID, $excerpt_limit);
			
			$alias = UniteFunctionsRev::getVal($postData, "post_name");
			
			$content = UniteFunctionsRev::getVal($postData, "post_content");
			
			$link = get_permalink($postID);
			
			$postDate = UniteFunctionsRev::getVal($postData, "post_date_gmt");
			$postDate = UniteFunctionsWPRev::convertPostDate($postDate);
			
			$dateModified = UniteFunctionsRev::getVal($postData, "post_modified");
			$dateModified = UniteFunctionsWPRev::convertPostDate($dateModified);
			
			$authorID = UniteFunctionsRev::getVal($postData, "post_author");
			$authorName = UniteFunctionsWPRev::getUserDisplayName($authorID);
			
			$postCatsIDs = $postData["post_category"];
			$catlist = UniteFunctionsWPRev::getCategoriesHtmlList($postCatsIDs);
			$taglist = UniteFunctionsWPRev::getTagsHtmlList($postID);
			
			$numComments = UniteFunctionsRev::getVal($postData, "comment_count");
			
			foreach($this->arrLayers as $key=>$layer){
				
				$text = UniteFunctionsRev::getVal($layer, "text");
				
				$text = str_replace("%title%", $title, $text);
				$text = str_replace("%excerpt%", $excerpt, $text);
				$text = str_replace("%alias%", $alias, $text);
				$text = str_replace("%content%", $content, $text);
				$text = str_replace("%link%", $link, $text);
				$text = str_replace("%date%", $postDate , $text);
				$text = str_replace("%date_modified%", $dateModified , $text);
				$text = str_replace("%author_name%", $authorName , $text);
				$text = str_replace("%num_comments%", $numComments , $text);
				$text = str_replace("%catlist%", $catlist , $text);
				$text = str_replace("%taglist%", $taglist , $text);

				//process meta tags:
				$arrMatches = array();
				$text = str_replace('-', '_REVSLIDER_', $text);
				
				preg_match_all('/%meta:\w+%/', $text, $arrMatches);

				foreach($arrMatches as $matched){
					
					foreach($matched as $match) {
					
						$meta = str_replace("%meta:", "", $match);
						$meta = str_replace("%","",$meta);
						$meta = str_replace('_REVSLIDER_', '-', $meta);
						$metaValue = get_post_meta($postID,$meta,true);
						
						$text = str_replace($match,$metaValue,$text);	
					}
				}
				$text = str_replace('_REVSLIDER_','-',$text);

				
				
				


				//replace event's template
				if(UniteEmRev::isEventsExists()){
					$eventData = UniteEmRev::getEventPostData($postID);
					if(!empty($eventData)){
						foreach($eventData as $eventKey=>$eventValue){
							$eventPlaceholder = "%event_".$eventKey."%";
							if($eventKey == 'start_date' || $eventKey == 'end_date') $eventValue = UniteFunctionsWPRev::convertPostDate($eventValue);
							$text = str_replace($eventPlaceholder, $eventValue , $text);
						}
					}
				}
				
				
				//$text = str_replace("location", "maxim" , $text);
				
				$layer["text"] = $text;
				$this->arrLayers[$key] = $layer;
			}						
			
			//$allMeta = get_post_meta($postID);
			//dmp($allMeta);exit();
		}
		
		
		/**
		 * 
		 * init the slider by id
		 */
		public function initByID($slideid){
			if(strpos($slideid, 'static_') !== false){
				$this->static_slide = true;
				$sliderID = str_replace('static_', '', $slideid);
				
				UniteFunctionsRev::validateNumeric($sliderID,"Slider ID");
				
				$sliderID = $this->db->escape($sliderID);
				$record = $this->db->fetch(GlobalsRevSlider::$table_static_slides,"slider_id=$sliderID");
				
				if(empty($record)){
					//create a new static slide for the Slider and then use it
					$slide_id = $this->createSlide($sliderID,"",true);
					
					$record = $this->db->fetch(GlobalsRevSlider::$table_static_slides,"slider_id=$sliderID");
					
					$this->initByData($record[0]);
				}else{
					$this->initByData($record[0]);
				}
			}else{
				UniteFunctionsRev::validateNumeric($slideid,"Slide ID");
				$slideid = $this->db->escape($slideid);
				$record = $this->db->fetchSingle(GlobalsRevSlider::$table_slides,"id=$slideid");
				
				$this->initByData($record);
			}
		}
		
		
		/**
		 * 
		 * init the slider by id
		 */
		public function initByStaticID($slideid){
		
			UniteFunctionsRev::validateNumeric($slideid,"Slide ID");
			$slideid = $this->db->escape($slideid);
			$record = $this->db->fetchSingle(GlobalsRevSlider::$table_static_slides,"id=$slideid");
			
			$this->initByData($record);
		}
		
		
		/**
		 * 
		 * getStaticSlide
		 */
		public function getStaticSlideID($sliderID){
			
			UniteFunctionsRev::validateNumeric($sliderID,"Slider ID");
			
			$sliderID = $this->db->escape($sliderID);
			$record = $this->db->fetch(GlobalsRevSlider::$table_static_slides,"slider_id=$sliderID");
			
			if(empty($record)){
				return false;
			}else{
				return $record[0]['id'];
			}
		}
		
		
		
		/**
		 * 
		 * set slide image by image id
		 */
		private function setImageByImageID($imageID){
			
			$this->imageID = $imageID;
			
			$this->imageUrl = UniteFunctionsWPRev::getUrlAttachmentImage($imageID);
			$this->imageThumb = UniteFunctionsWPRev::getUrlAttachmentImage($imageID,UniteFunctionsWPRev::THUMB_MEDIUM);
			
			if(empty($this->imageUrl))
				return(false);
			
			$this->params["background_type"] = "image";
			
			if(is_ssl()){
				$this->imageUrl = str_replace("http://", "https://", $this->imageUrl);
			}
			
			$this->imageFilepath = UniteFunctionsWPRev::getImagePathFromURL($this->imageUrl);
		    $realPath = UniteFunctionsWPRev::getPathContent().$this->imageFilepath;
		    
		    if(file_exists($realPath) == false || is_file($realPath) == false)
		    	$this->imageFilepath = "";
		    
			$this->imageFilename = basename($this->imageUrl);
		}
		
		/**
		 * 
		 * set children array
		 */
		public function setArrChildren($arrChildren){
			$this->arrChildren = $arrChildren;
		}
		
		
		/**
		 * 
		 * get children array
		 */
		public function getArrChildren(){
			
			$this->validateInited();
			
			if($this->arrChildren === null){
				$slider = new RevSlider();
				$slider->initByID($this->sliderID);
				$this->arrChildren = $slider->getArrSlideChildren($this->id);
			}
			
			return($this->arrChildren);				
		}
		
		/**
		 * 
		 * return if the slide from post
		 */
		public function isFromPost(){
			return !empty($this->postData);
		}
		
		
		/**
		 * 
		 * get post data
		 */
		public function getPostData(){
			return($this->postData);
		}
		
		
		/**
		 * 
		 * get children array as is
		 */
		public function getArrChildrenPure(){
			return($this->arrChildren);
		}
		
		/**
		 * 
		 * return if the slide is parent slide
		 */
		public function isParent(){
			$parentID = $this->getParam("parentid","");
			return(!empty($parentID));
		}
		
		
		/**
		 * 
		 * get slide language
		 */
		public function getLang(){
			$lang = $this->getParam("lang","all");
			return($lang);
		}
		
		/**
		 * 
		 * return parent slide. If the slide is parent, return this slide.
		 */
		public function getParentSlide(){
			$parentID = $this->getParam("parentid","");
			if(empty($parentID))
				return($this);
				
			$parentSlide = new RevSlide();
			$parentSlide->initByID($parentID);
			return($parentSlide);
		}
		
		/**
		 * 
		 * get array of children id's
		 */
		public function getArrChildrenIDs(){
			$arrChildren = $this->getArrChildren();
			$arrChildrenIDs = array();
			foreach($arrChildren as $child){
				$childID = $child->getID();
				$arrChildrenIDs[] = $childID;
			}
			
			return($arrChildrenIDs);
		}
		
		
		/**
		 * 
		 * get array of children array and languages, the first is current language.
		 */
		public function getArrChildrenLangs($includeParent = true){			
			$this->validateInited();
			$slideID = $this->id;
			
			if($includeParent == true){
				$lang = $this->getParam("lang","all");
				$arrOutput = array();
				$arrOutput[] = array("slideid"=>$slideID,"lang"=>$lang,"isparent"=>true);
			}
			
			$arrChildren = $this->getArrChildren();
			
			foreach($arrChildren as $child){
				$childID = $child->getID();
				$childLang = $child->getParam("lang","all");
				$arrOutput[] = array("slideid"=>$childID,"lang"=>$childLang,"isparent"=>false);
			}
			
			return($arrOutput);
		}
		
		/**
		 * 
		 * get children language codes (including current slide lang code)
		 */
		public function getArrChildLangCodes($includeParent = true){
			$arrLangsWithSlideID = $this->getArrChildrenLangs($includeParent);
			$arrLangCodes = array();
			foreach($arrLangsWithSlideID as $item){
				$lang = $item["lang"];
				$arrLangCodes[$lang] = $lang;
			}
			
			return($arrLangCodes);
		}
		
		
		/**
		 * 
		 * get slide ID
		 */
		public function getID(){
			return($this->id);
		}
		
		
		/**
		 * 
		 * get slide order
		 */
		public function getOrder(){
			$this->validateInited();
			return($this->slideOrder);
		}
		
		
		/**
		 * 
		 * get layers in json format
		 */
		public function getLayers(){
			$this->validateInited();
			return($this->arrLayers);
		}
		
		/**
		 * 
		 * modify layer links for export
		 */
		public function getLayersForExport($useDummy = false){
			$this->validateInited();
			$arrLayersNew = array();
			foreach($this->arrLayers as $key=>$layer){
				$imageUrl = UniteFunctionsRev::getVal($layer, "image_url");
				if(!empty($imageUrl))
					$layer["image_url"] = UniteFunctionsWPRev::getImagePathFromURL($layer["image_url"]);
				
				$arrLayersNew[] = $layer;
			}
			
			return($arrLayersNew);
		}
		
		/**
		 * 
		 * get params for export
		 */
		public function getParamsForExport(){
			$arrParams = $this->getParams();
			$urlImage = UniteFunctionsRev::getVal($arrParams, "image");
			if(!empty($urlImage))
				$arrParams["image"] = UniteFunctionsWPRev::getImagePathFromURL($urlImage);
			
			return($arrParams);
		}
		
		
		/**
		 * normalize layers text, and get layers
		 * 
		 */
		public function getLayersNormalizeText(){
			$arrLayersNew = array();
			foreach ($this->arrLayers as $key=>$layer){
				$text = $layer["text"];
				$text = addslashes($text);
				$layer["text"] = $text;
				$arrLayersNew[] = $layer;
			}
			
			return($arrLayersNew);
		}
		

		/**
		 * 
		 * get slide params
		 */
		public function getParams(){
			$this->validateInited();
			return($this->params);
		}

		
		/**
		 * 	
		 * get parameter from params array. if no default, then the param is a must!
		 */
		function getParam($name,$default=null){
			
			if($default === null){
				if(!array_key_exists($name, $this->params))
					UniteFunctionsRev::throwError("The param <b>$name</b> not found in slide params.");
				$default = "";
			}
				
			return UniteFunctionsRev::getVal($this->params, $name,$default);
		}
		
		
		/**
		 * 
		 * get image filename
		 */
		public function getImageFilename(){
			return($this->imageFilename);
		}
		
		
		/**
		 * 
		 * get image filepath
		 */
		public function getImageFilepath(){
			return($this->imageFilepath);
		}
		
		
		/**
		 * 
		 * get image url
		 */
		public function getImageUrl(){
			
			return($this->imageUrl);
		}
		
		
		/**
		 * 
		 * get image id
		 */
		public function getImageID(){
			return($this->imageID);
		}
		
		/**
		 * 
		 * get thumb url
		 */
		public function getThumbUrl(){
			$thumbUrl = $this->imageUrl;
			if(!empty($this->imageThumb))
				$thumbUrl = $this->imageThumb;
				
			return($thumbUrl);
		}
		
		
		/**
		 * 
		 * get the slider id
		 */
		public function getSliderID(){
			return($this->sliderID);
		}
		
		/**
		 * 
		 * get slider param
		 */
		private function getSliderParam($sliderID,$name,$default,$validate=null){
			
			if(empty($this->slider)){
				$this->slider = new RevSlider();
				$this->slider->initByID($sliderID);
			}
			
			$param = $this->slider->getParam($name,$default,$validate);
			
			return($param);
		}
		
		
		/**
		 * 
		 * validate that the slider exists
		 */
		private function validateSliderExists($sliderID){
			$slider = new RevSlider();
			$slider->initByID($sliderID);
		}
		
		/**
		 * 
		 * validate that the slide is inited and the id exists.
		 */
		private function validateInited(){
			if(empty($this->id))
				UniteFunctionsRev::throwError("The slide is not inited!!!");
		}
		
		
		/**
		 * 
		 * create the slide (from image)
		 */
		public function createSlide($sliderID,$obj="",$static = false){
			
			$imageID = null;
			
			if(is_array($obj)){
				$urlImage = UniteFunctionsRev::getVal($obj, "url");
				$imageID = UniteFunctionsRev::getVal($obj, "id");
			}else{
				$urlImage = $obj;
			}
			
			//get max order
			$slider = new RevSlider();
			$slider->initByID($sliderID);
			$maxOrder = $slider->getMaxOrder();
			$order = $maxOrder+1;
			
			$params = array();
			if(!empty($urlImage)){
				$params["background_type"] = "image";
				$params["image"] = $urlImage;
				if(!empty($imageID))
					$params["image_id"] = $imageID;
					
			}else{	//create transparent slide
				
				$params["background_type"] = "trans";
			}
				
			$jsonParams = json_encode($params);
			
			
			$arrInsert = array("params"=>$jsonParams,
			           		   "slider_id"=>$sliderID,
								"layers"=>""
						);
						
			if(!$static)
				$arrInsert["slide_order"] = $order;
			
			if(!$static)
				$slideID = $this->db->insert(GlobalsRevSlider::$table_slides, $arrInsert);
			else
				$slideID = $this->db->insert(GlobalsRevSlider::$table_static_slides, $arrInsert);
			
			return($slideID);
		}
		
		/**
		 * 
		 * update slide image from data
		 */
		public function updateSlideImageFromData($data){
			
			$sliderID = UniteFunctionsRev::getVal($data, "slider_id");
			$slider = new RevSlider();
			$slider->initByID($sliderID);
			
			$slideID = UniteFunctionsRev::getVal($data, "slide_id");
			$urlImage = UniteFunctionsRev::getVal($data, "url_image");
			UniteFunctionsRev::validateNotEmpty($urlImage);
			$imageID = UniteFunctionsRev::getVal($data, "image_id");
			if($slider->isSlidesFromPosts()){
				
				if(!empty($imageID))
					UniteFunctionsWPRev::updatePostThumbnail($slideID, $imageID);
				
			}else{
				$this->initByID($slideID);
								
				$arrUpdate = array();
				$arrUpdate["image"] = $urlImage;			
				$arrUpdate["image_id"] = $imageID;
				
				$this->updateParamsInDB($arrUpdate);
			}
			
			return($urlImage);
		}
		
		
		
		/**
		 * 
		 * update slide parameters in db
		 */
		private function updateParamsInDB($arrUpdate = array()){
			$this->validateInited();
			$this->params = array_merge($this->params,$arrUpdate);
			$jsonParams = json_encode($this->params);
			
			$arrDBUpdate = array("params"=>$jsonParams);
			
			$this->db->update(GlobalsRevSlider::$table_slides,$arrDBUpdate,array("id"=>$this->id));
		}
		
		
		/**
		 * 
		 * update current layers in db
		 */
		private function updateLayersInDB($arrLayers = null){
			$this->validateInited();
			
			if($arrLayers === null)
				$arrLayers = $this->arrLayers;
				
			$jsonLayers = json_encode($arrLayers);
			$arrDBUpdate = array("layers"=>$jsonLayers);
			
			$this->db->update(GlobalsRevSlider::$table_slides,$arrDBUpdate,array("id"=>$this->id));
		} 
		
		
		/**
		 * 
		 * update parent slideID 
		 */
		public function updateParentSlideID($parentID){
			$arrUpdate = array();
			$arrUpdate["parentid"] = $parentID;
			$this->updateParamsInDB($arrUpdate);
		}
		
		
		/**
		 * 
		 * sort layers by order
		 */
		private function sortLayersByOrder($layer1,$layer2){
			$layer1 = (array)$layer1;
			$layer2 = (array)$layer2;
			
			$order1 = UniteFunctionsRev::getVal($layer1, "order",1);
			$order2 = UniteFunctionsRev::getVal($layer2, "order",2);
			if($order1 == $order2)
				return(0);
			
			return($order1 > $order2);
		}
		
		
		/**
		 * 
		 * go through the layers and fix small bugs if exists
		 */
		private function normalizeLayers($arrLayers){
			
			usort($arrLayers,array($this,"sortLayersByOrder"));
			
			$arrLayersNew = array();
			foreach ($arrLayers as $key=>$layer){
				
				$layer = (array)$layer;
				
				//set type
				$type = UniteFunctionsRev::getVal($layer, "type","text");
				$layer["type"] = $type;
				
				//normalize position:
				$layer["left"] = round($layer["left"]);
				$layer["top"] = round($layer["top"]);
				
				//unset order
				unset($layer["order"]);
				
				//modify text
				$layer["text"] = stripcslashes($layer["text"]);
				
				$arrLayersNew[] = $layer;
			}
			
			return($arrLayersNew);
		}  
		
		
		
		/**
		 * 
		 * normalize params
		 */
		private function normalizeParams($params){
			
			$urlImage = UniteFunctionsRev::getVal($params, "image_url");
			
			//init the id if absent
			$params["image_id"] = UniteFunctionsRev::getVal($params, "image_id");
			
			$params["image"] = $urlImage;
			unset($params["image_url"]);
			
			if(isset($params["video_description"]))
				$params["video_description"] = UniteFunctionsRev::normalizeTextareaContent($params["video_description"]);
			
			return($params);
		}
		
		
		/**
		 * 
		 * update slide from data
		 * @param $data
		 */
		public function updateSlideFromData($data, $slideSettings){
			
			$slideID = UniteFunctionsRev::getVal($data, "slideid");
			$this->initByID($slideID);						
			
			//treat params
			$params = UniteFunctionsRev::getVal($data, "params");
			$params = $this->normalizeParams($params);
			
			//modify the values according the settings
			$params = $slideSettings->setStoredValues($params);
			
			//preserve old data that not included in the given data
			$params = array_merge($this->params,$params);
			
			//treat layers
			$layers = UniteFunctionsRev::getVal($data, "layers");
			
			if(gettype($layers) == "string"){
				$layersStrip = stripslashes($layers);
				$layersDecoded = json_decode($layersStrip);
				if(empty($layersDecoded))
					$layersDecoded = json_decode($layers);
				
				$layers = UniteFunctionsRev::convertStdClassToArray($layersDecoded);
			}
			
			if(empty($layers) || gettype($layers) != "array")
				$layers = array();
			
			$layers = $this->normalizeLayers($layers);
			
			$arrUpdate = array();
			$arrUpdate["layers"] = json_encode($layers);
			$arrUpdate["params"] = json_encode($params);
			
			$this->db->update(GlobalsRevSlider::$table_slides,$arrUpdate,array("id"=>$this->id));
			
			//RevOperations::updateDynamicCaptions();
		}
		
		
		/**
		 * 
		 * update slide from data
		 * @param $data
		 */
		public function updateStaticSlideFromData($data){
			
			$slideID = UniteFunctionsRev::getVal($data, "slideid");
			$this->initByStaticID($slideID);
			
			//treat layers
			$layers = UniteFunctionsRev::getVal($data, "layers");
			
			if(gettype($layers) == "string"){
				$layersStrip = stripslashes($layers);
				$layersDecoded = json_decode($layersStrip);
				if(empty($layersDecoded))
					$layersDecoded = json_decode($layers);
				
				$layers = UniteFunctionsRev::convertStdClassToArray($layersDecoded);
			}
			
			if(empty($layers) || gettype($layers) != "array")
				$layers = array();
			
			$layers = $this->normalizeLayers($layers);
			
			$arrUpdate = array();
			$arrUpdate["layers"] = json_encode($layers);
			
			$this->db->update(GlobalsRevSlider::$table_static_slides,$arrUpdate,array("id"=>$this->id));
			
			//RevOperations::updateDynamicCaptions();
		}
		
		
		
		/**
		 * 
		 * delete slide by slideid
		 */
		public function deleteSlide(){
			$this->validateInited();
			
			$this->db->delete(GlobalsRevSlider::$table_slides,"id='".$this->id."'");
		}
		
		
		/**
		 * 
		 * delete slide children
		 */
		public function deleteChildren(){
			$this->validateInited();
			$arrChildren = $this->getArrChildren();
			foreach($arrChildren as $child)
				$child->deleteSlide();
		}
		
		
		/**
		 * 
		 * delete slide from data
		 */
		public function deleteSlideFromData($data){
			
			$sliderID = UniteFunctionsRev::getVal($data, "sliderID");
			$slider = new RevSlider();
			$slider->initByID($sliderID); 			

			$isPost = $slider->isSlidesFromPosts();
			
			if($isPost == true){	//delete post	
				
				$postID = UniteFunctionsRev::getVal($data, "slideID");
				UniteFunctionsWPRev::deletePost($postID);
				
			}else{		//delete slide
				
				$slideID = UniteFunctionsRev::getVal($data, "slideID");
				$this->initByID($slideID);
				$this->deleteChildren();
				$this->deleteSlide();
								
			}
			
			//RevOperations::updateDynamicCaptions();
			
		}
		
		
		/**
		 * 
		 * set params from client
		 */
		public function setParams($params){
			$params = $this->normalizeParams($params);
			$this->params = $params;
		}
		
		
		/**
		 * 
		 * set layers from client
		 */
		public function setLayers($layers){
			$layers = $this->normalizeLayers($layers);
			$this->arrLayers = $layers;
		}
		
		
		/**
		/* toggle slide state from data
		 */
		public function toggleSlideStatFromData($data){
			
			$sliderID = UniteFunctionsRev::getVal($data, "slider_id");
			$slider = new RevSlider();
			$slider->initByID($sliderID);
			
			$slideID = UniteFunctionsRev::getVal($data, "slide_id");
						
			if($slider->isSlidesFromPosts()){
				$postData = UniteFunctionsWPRev::getPost($slideID);
				
				$oldState = $postData["post_status"];
				$newState = ($oldState == UniteFunctionsWPRev::STATE_PUBLISHED)?UniteFunctionsWPRev::STATE_DRAFT:UniteFunctionsWPRev::STATE_PUBLISHED;
				
				//update the state in wp
				UniteFunctionsWPRev::updatePostState($slideID, $newState);
				
				//return state:
				$newState = ($newState == UniteFunctionsWPRev::STATE_PUBLISHED)?"published":"unpublished";
				
			}else{
				$this->initByID($slideID);
				
				$state = $this->getParam("state","published");
				$newState = ($state == "published")?"unpublished":"published";
				
				$arrUpdate = array();
				$arrUpdate["state"] = $newState;
				
				$this->updateParamsInDB($arrUpdate);
				
			}
						
			return($newState);
		}
		
		
		/**
		 * 
		 * updatye slide language from data
		 */
		private function updateLangFromData($data){
						
			$slideID = UniteFunctionsRev::getVal($data, "slideid");
			$this->initByID($slideID);
			
			$lang = UniteFunctionsRev::getVal($data, "lang");
			
			$arrUpdate = array();
			$arrUpdate["lang"] = $lang;
			$this->updateParamsInDB($arrUpdate);
			
			$response = array();
			$response["url_icon"] = UniteWpmlRev::getFlagUrl($lang);
			$response["title"] = UniteWpmlRev::getLangTitle($lang);
			$response["operation"] = "update";
			
			return($response);
		}
		
		
		/**
		 * 
		 * add language (add slide that connected to current slide) from data
		 */
		private function addLangFromData($data){
			$sliderID = UniteFunctionsRev::getVal($data, "sliderid");
			$slideID = UniteFunctionsRev::getVal($data, "slideid");
			$lang = UniteFunctionsRev::getVal($data, "lang");
			
			//duplicate slide
			$slider = new RevSlider();
			$slider->initByID($sliderID);
			$newSlideID = $slider->duplicateSlide($slideID);
					
			//update new slide
			$this->initByID($newSlideID);
			
			$arrUpdate = array();
			$arrUpdate["lang"] = $lang;
			$arrUpdate["parentid"] = $slideID;
			$this->updateParamsInDB($arrUpdate);
						
			$urlIcon = UniteWpmlRev::getFlagUrl($lang);
			$title = UniteWpmlRev::getLangTitle($lang);
			
			$newSlide = new RevSlide();
			$newSlide->initByID($slideID);
			$arrLangCodes = $newSlide->getArrChildLangCodes();
			$isAll = UniteWpmlRev::isAllLangsInArray($arrLangCodes);
			
			$html = "<li>
								<img id=\"icon_lang_".$newSlideID."\" class=\"icon_slide_lang\" src=\"".$urlIcon."\" title=\"".$title."\" data-slideid=\"".$newSlideID."\" data-lang=\"".$lang."\">
								<div class=\"icon_lang_loader loader_round\" style=\"display:none\"></div>								
							</li>";
			
			$response = array();
			$response["operation"] = "add";
			$response["isAll"] = $isAll;
			$response["html"] = $html;
			
			return($response);
		}
		
		
		/**
		 * 
		 * delete slide from language menu data
		 */
		private function deleteSlideFromLangData($data){
			
			$slideID = UniteFunctionsRev::getVal($data, "slideid");
			$this->initByID($slideID);
			$this->deleteSlide();
			
			$response = array();
			$response["operation"] = "delete";
			return($response);
		}
		
		
		/**
		 * 
		 * add or update language from data
		 */
		public function doSlideLangOperation($data){
			
			$operation = UniteFunctionsRev::getVal($data, "operation");
			switch($operation){
				case "add":
					$response = $this->addLangFromData($data);	
				break;
				case "delete":
					$response = $this->deleteSlideFromLangData($data);
				break;
				case "update":
				default:
					$response = $this->updateLangFromData($data);
				break;
			}
			
			return($response);
		}
		
		/**
		 * 
		 * get thumb url
		 */
		public function getUrlImageThumb(){
			
			//get image url by thumb
			if(!empty($this->imageID)){
				$urlImage = UniteFunctionsWPRev::getUrlAttachmentImage($this->imageID, UniteFunctionsWPRev::THUMB_MEDIUM);
			}else{
				//get from cache
				if(!empty($this->imageFilepath)){
					$urlImage = UniteBaseClassRev::getImageUrl($this->imageFilepath,200,100,true);
				}
				else 
					$urlImage = $this->imageUrl;
			}
			
			if(empty($urlImage))
				$urlImage = $this->imageUrl;
			
			return($urlImage);
		}
		
		/**
		 * 
		 * replace image url's among slide image and layer images
		 */
		public function replaceImageUrls($urlFrom, $urlTo){
			
			$this->validateInited();
						
			$urlImage = UniteFunctionsRev::getVal($this->params, "image");
			
			if(strpos($urlImage, $urlFrom) !== false){
				$imageNew = str_replace($urlFrom, $urlTo, $urlImage);
				$this->params["image"] = $imageNew; 
				$this->updateParamsInDB();
			}
			
			
			// update image url in layers
			$isUpdated = false;
			foreach($this->arrLayers as $key=>$layer){
				$type =  UniteFunctionsRev::getVal($layer, "type");
				if($type == "image"){
					$urlImage = UniteFunctionsRev::getVal($layer, "image_url");
					if(strpos($urlImage, $urlFrom) !== false){
						$newUrlImage = str_replace($urlFrom, $urlTo, $urlImage);
						$this->arrLayers[$key]["image_url"] = $newUrlImage;
						$isUpdated = true;
					}
				}
			}
			
			if($isUpdated == true)
				$this->updateLayersInDB();
			
		}
		
		/**
		 * 
		 * replace transition styles on all slides
		 */
		public function changeTransition($transition){
			$this->validateInited();
			
			$this->params["slide_transition"] = $transition;
			$this->updateParamsInDB();
		}
		
		/**
		 * 
		 * replace transition duration on all slides
		 */
		public function changeTransitionDuration($transitionDuration){
			$this->validateInited();
			
			$this->params["transition_duration"] = $transitionDuration;
			$this->updateParamsInDB();
		}
		
		public function isStaticSlide(){
			return $this->static_slide;
		}
	}
	
?>