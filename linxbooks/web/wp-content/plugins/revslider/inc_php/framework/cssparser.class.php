<?php

	class UniteCssParserRev{
		
		private $cssContent;
		
		public function __construct(){
			
		}
		
		/**
		 * 
		 * init the parser, set css content
		 */
		public function initContent($cssContent){
			$this->cssContent = $cssContent;
		}		
		
		
		/**
		 * 
		 * get array of slide classes, between two sections.
		 */
		public function getArrClasses($startText = "",$endText="",$explodeonspace=false){
			
			$content = $this->cssContent;
			
			//trim from top
			if(!empty($startText)){
				$posStart = strpos($content, $startText);
				if($posStart !== false)
					$content = substr($content, $posStart,strlen($content)-$posStart);
			}
			
			//trim from bottom
			if(!empty($endText)){
				$posEnd = strpos($content, $endText);
				if($posEnd !== false)
					$content = substr($content,0,$posEnd);
			}
			
			//get styles
			$lines = explode("\n",$content);
			$arrClasses = array();
			foreach($lines as $key=>$line){
				$line = trim($line);
				if(strpos($line, "{") === false)
					continue;
				//skip unnessasary links
				if(strpos($line, ".caption a") !== false)
					continue;
					
				if(strpos($line, ".tp-caption a") !== false)
					continue;
					
				//get style out of the line
				$class = str_replace("{", "", $line);
				$class = trim($class);
				
				//skip captions like this: .tp-caption.imageclass img
				if(strpos($class," ") !== false){
					if(!$explodeonspace){
						continue;
					}else{
						$class = explode(',', $class);
						$class = $class[0];
					}
				}
				//skip captions like this: .tp-caption.imageclass:hover, :before, :after
				if(strpos($class,":") !== false)
					continue;
				
				$class = str_replace(".caption.", ".", $class);
				$class = str_replace(".tp-caption.", ".", $class);
				
				$class = str_replace(".", "", $class);
				$class = trim($class);
				$arrWords = explode(" ", $class);
				$class = $arrWords[count($arrWords)-1];
				$class = trim($class);
				
				$arrClasses[] = $class;	
			}
			
			sort($arrClasses);
			
			return($arrClasses);
		}
		
		public static function parseCssToArray($css){
			
			while(strpos($css, '/*') !== false){
				if(strpos($css, '*/') === false) return false;
				$start = strpos($css, '/*');
				$end = strpos($css, '*/') + 2;
				$css = str_replace(substr($css, $start, $end - $start), '', $css);
			}
			
			preg_match_all( '/(?ims)([a-z0-9\s\.\:#_\-@]+)\{([^\}]*)\}/', $css, $arr);

			$result = array();
			foreach ($arr[0] as $i => $x){
				$selector = trim($arr[1][$i]);
				if(strpos($selector, '{') !== false || strpos($selector, '}') !== false) return false;
				$rules = explode(';', trim($arr[2][$i]));
				$result[$selector] = array();
				foreach ($rules as $strRule){
					if (!empty($strRule)){
						$rule = explode(":", $strRule);
						if(strpos($rule[0], '{') !== false || strpos($rule[0], '}') !== false || strpos($rule[1], '{') !== false || strpos($rule[1], '}') !== false) return false;
						
						//put back everything but not $rule[0];
						$key = trim($rule[0]);
						unset($rule[0]);
						$values = implode(':', $rule);
						
						$result[$selector][trim($key)] = trim(str_replace("'", '"', $values));
					}
				}
			}   
			return($result);
		}
		
		public static function parseDbArrayToCss($cssArray, $nl = "\n\r"){
			$css = '';
			foreach($cssArray as $id => $attr){
				$stripped = '';
				if(strpos($attr['handle'], '.tp-caption') !== false){
					$stripped = trim(str_replace('.tp-caption', '', $attr['handle']));
				}
				$styles = json_decode(str_replace("'", '"', $attr['params']), true);
				$css.= $attr['handle'];
				if(!empty($stripped)) $css.= ', '.$stripped;
				$css.= " {".$nl;
				if(is_array($styles)){
					foreach($styles as $name => $style){
						$css.= $name.':'.$style.";".$nl;
					}
				}
				$css.= "}".$nl.$nl;
				
				//add hover
				$setting = json_decode($attr['settings'], true);
				if(@$setting['hover'] == 'true'){
					$hover = json_decode(str_replace("'", '"', $attr['hover']), true);
					if(is_array($hover)){
						$css.= $attr['handle'].":hover";
						if(!empty($stripped)) $css.= ', '.$stripped.':hover';
						$css.= " {".$nl;
						foreach($hover as $name => $style){
							$css.= $name.':'.$style.";".$nl;
						}
						$css.= "}".$nl.$nl;
					}
				}
			}
			return $css;
		}
		
		public static function parseArrayToCss($cssArray, $nl = "\n\r", $do_short = true){
			$css = '';
			foreach($cssArray as $id => $attr){
				if($do_short){
					$stripped = '';
					if(strpos($attr['handle'], '.tp-caption') !== false){
						$stripped = trim(str_replace('.tp-caption', '', $attr['handle']));
					}
				}
				$styles = (array)$attr['params'];
				$css.= $attr['handle'];
				if($do_short){
					if(!empty($stripped)) $css.= ', '.$stripped;
				}
				$css.= " {".$nl;
				
				if(is_array($styles) && !empty($styles)){
					foreach($styles as $name => $style){
						if($name == 'background-color' && strpos($style, 'rgba') !== false){ //rgb && rgba
							$rgb = explode(',', str_replace('rgba', 'rgb', $style));
							unset($rgb[count($rgb)-1]);
							$rgb = implode(',', $rgb).')';
							$css.= $name.':'.$rgb.";".$nl;
						}
						$css.= $name.':'.$style.";".$nl;
					}
				}
				$css.= "}".$nl.$nl;
				
				//add hover
				$setting = (array)$attr['settings'];
				if(@$setting['hover'] == 'true'){
					$hover = (array)$attr['hover'];
					if(is_array($hover)){
						$css.= $attr['handle'].":hover";
						if(!empty($stripped)) $css.= ', '.$stripped.":hover";
						$css.= " {".$nl;
						foreach($hover as $name => $style){
							if($name == 'background-color' && strpos($style, 'rgba') !== false){ //rgb && rgba
								$rgb = explode(',', str_replace('rgba', 'rgb', $style));
								unset($rgb[count($rgb)-1]);
								$rgb = implode(',', $rgb).')';
								$css.= $name.':'.$rgb.";".$nl;
							}
							$css.= $name.':'.$style.";".$nl;
						}
						$css.= "}".$nl.$nl;
					}
				}
			}
			return $css;
		}
		
		
		public static function parseStaticArrayToCss($cssArray, $nl = "\n"){
			$css = '';
			foreach($cssArray as $class => $styles){
				$css.= $class." {".$nl;
				if(is_array($styles) && !empty($styles)){
					foreach($styles as $name => $style){
						$css.= $name.':'.$style.";".$nl;
					}
				}
				$css.= "}".$nl.$nl;
			}
			return $css;
		}
		
		public static function parseDbArrayToArray($cssArray, $handle = false){
			
			if(!is_array($cssArray) || empty($cssArray)) return false;
			
			foreach($cssArray as $key => $css){
				if($handle != false){
					if($cssArray[$key]['handle'] == '.tp-caption.'.$handle){
						$cssArray[$key]['params'] = json_decode(str_replace("'", '"', $css['params']));
						$cssArray[$key]['hover'] = json_decode(str_replace("'", '"', $css['hover']));
						$cssArray[$key]['settings'] = json_decode(str_replace("'", '"', $css['settings']));
						return $cssArray[$key];
					}else{
						unset($cssArray[$key]);
					}
				}else{
					$cssArray[$key]['params'] = json_decode(str_replace("'", '"', $css['params']));
					$cssArray[$key]['hover'] = json_decode(str_replace("'", '"', $css['hover']));
					$cssArray[$key]['settings'] = json_decode(str_replace("'", '"', $css['settings']));
				}
			}
			
			return $cssArray;
		}
		
		public static function compress_css($buffer){
			/* remove comments */
			$buffer = preg_replace("!/\*[^*]*\*+([^/][^*]*\*+)*/!", "", $buffer) ;
			/* remove tabs, spaces, newlines, etc. */
			$arr = array("\r\n", "\r", "\n", "\t", "  ", "    ", "    ");
			$rep = array("", "", "", "", " ", " ", " ");
			$buffer = str_replace($arr, $rep, $buffer);
			/* remove whitespaces around {}:, */
			$buffer = preg_replace("/\s*([\{\}:,])\s*/", "$1", $buffer);
			/* remove last ; */
			$buffer = str_replace(';}', "}", $buffer);
			
			return $buffer;
		}
		
	}

?>