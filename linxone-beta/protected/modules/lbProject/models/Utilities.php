<?php
/**
 * This class contains utilities functions
 *
 * @author joseph
 *
 */
require_once 'Mobile_Detect.php';
define('DATE_FORMAT_DD_MM_YYYY_HI_MI', 'd M, Y H:i');

class Utilities
{	
	/**
	 * encode string to utf8 if not already encoded.
	 * 
	 * @param string $string
	 * @return string encoded string
	 */
	public static function encodeToUTF8($string)
	{
		return mb_check_encoding($string, 'UTF-8') ? $string : utf8_encode($string);
	}
	
	public static function getSummary($str, $word_wrap = true, $max_length = 50)
	{
		return Utilities::getShortName($str, $word_wrap, $max_length);
	}

	/**
	 * A function to shorten name, word-wrap is used
	 * 
	 * @param string $str
	 * @param boolean $word_wrap true for word-wrap, false for none. default is true
	 * @param number $max_length
	 * @return Ambigous <string, mixed>
	 */
	public static function getShortName($str, $word_wrap = true, $max_length = 50)
	{
		$result = $str;
		
		if (strlen($str) <= $max_length)
		{	
			$result = $str;
		}
		else if ($word_wrap)
		{
			// short title with word wrap
			$short_title_wr = preg_replace('/\s+?(\S+)?$/', '', substr($str, 0, $max_length));
			if (strlen($str) > strlen($short_title_wr))
			{
				$short_title_wr .= '...';
			}
			
			$result =  $short_title_wr;
		} else {
			$short_title = $str;
			// short title with no word wrap, word may be cut off
			if (strlen($str) > $max_length)
			{
				$short_title = mb_substr($str, 0, $max_length) . '...';
			} 
			
			$result =  $short_title;
		}
		
		return strip_tags($result);
	}
	
	public static function generateManualAjaxLink($label, $ajaxOptions, $htmlOptions)
	{
		if ($htmlOptions == null) $htmlOptions == array();
		$htmlOptions["onClick"] = " {". CHtml::ajax(
						$ajaxOptions,
						$htmlOptions) . "; event.stopPropagation(); return false; }";
		$htmlOptions["id"] = "ajax-id-" . uniqid();
		
		return CHtml::link(
			$label,
			"#",
			$htmlOptions);
	}
	
	/**
	 * @return integer	ID of subscription that is currently open
	 */
	public static function getCurrentlySelectedSubscription()
	{
		if (isset( Yii::app()->user->linx_app_selected_subscription ))
			return Yii::app()->user->linx_app_selected_subscription;
		
		return 0;
	}
	
	/**
	 * Set id of current subscription view
	 * 
	 * @param int $id
	 */
	public static function setCurrentlySelectedSubscription($id)
	{
		if (!isset( Yii::app()->user->linx_app_selected_subscription ))
			return false;
		
		// check if this user is master account
		$is_master = Account::model()->isMasterAccount($id);
		
		// or a member of this subscription
		$master_account_id = AccountSubscription::model()->getSubscriptionOwnerID($id);
		$is_member = AccountTeamMember::model()->isValidMember($master_account_id, Yii::app()->user->id);
		
		if ($is_master || $is_member){
			Yii::app()->user->linx_app_selected_subscription = $id;
			return true;
		}
		
		return false;
	}
	
	/**
	 * @param Controller $controller
	 * Go to home page, usually it's project index page
	 */
	public static function redirectToHome($controller)
	{
		$controller->redirect(array(Utilities::getCurrentlySelectedSubscription().'/'));
	}
	
	public static function isWorkspace()
	{
		return isset($_GET['workspace']) && $_GET['workspace'] == YES;
	}
	
	public static function isAjax()
	{
		return isset($_GET['ajax']) || isset($_POST['ajax']);
	}
	
	public static function mobileViewRequested()
	{
		return isset($_GET['app_mobile_view']) || isset($_POST['app_mobile_view']);
	}
	
	/**
	 * Application wrapper for render and renderPartial
	 * It'll not reload javascript that is already included in header
	 * 
	 * @param unknown $view
	 * @param unknown $data
	 * @param string $return
	 * @param string $processOutput
	 */
	public static function render($controller, $view, $data, $return = false, $processOutput = true)
	{
		// if mobile view is needed, append .mobile to view's name
		if (Yii::app()->params['enableMobileWeb']==YES &&
				( Utilities::mobileViewRequested() 
						|| ( Utilities::isMobile() && !Utilities::isTablet() ) ))
		{
			// use mobile view if not yet selected
			// and if view file exists
			if (strstr($view, '_mobile')===false)
			{
				// Note: cannot always check, because sometimes this controller uses other controller view
				//if (file_exists($controller->getViewPath().'/'.$view.'_mobile.php'))
				//{
				$controller->layout = '//layouts/column1.mobile';
				
				// there are 2 cases of view
				// case 1: just the view name 'viewname', then we make it into 'mobile/viewname_mobile'
				// case 2: full path '//path/to/viewname',
				//			then we need to
				//			- Find the position of the last occurrence of '/' in this path using strrpos
				//			- split path at this position using substr
				//			- get viewname, and update to mobile/viewname_mobile
				//			- append it back
				if (strpos($view, '/')===false)
				{
					$view = 'mobile/' . $view . '_mobile';
				} else {
					$view_name_pos = strrpos($view, '/');
					$viewname = substr($view, $view_name_pos+1);
					$view_path = substr($view, 0, $view_name_pos+1);
					$viewname = 'mobile/' . $viewname . '_mobile';
					$view = $view_path.$viewname;
				}
				//}
			}
		}
		
		if (Utilities::isWorkspace() || Utilities::isAjax())
		{
			Utilities::renderPartial($controller, $view, $data, $return, $processOutput);
		} else {
			$controller->render($view, $data, $return);
		}
	}
	
	public static function isMobile()
	{
		$detect = new Mobile_Detect;
		return $detect->isMobile();
	}
	
	public static function isTablet()
	{
		$detect = new Mobile_Detect;
		return $detect->isTablet();
	}
	
	public static function renderPartial($controller, $view, $data, $return = false, $processOutput = true)
	{
		// For jQuery core, Yii switches between the human-readable and minified
		// versions based on DEBUG status; so make sure to catch both of them
		Yii::app()->clientScript->scriptMap['jquery.js'] = false;
		Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
		Yii::app()->clientScript->scriptMap['jquery-ui.min.js'] = false;
		Yii::app()->clientScript->scriptMap['jquery-ui-i18n.min.js'] = false;
		Yii::app()->clientScript->scriptMap['jquery.tooltip-1.2.6.min.js'] = false;
		Yii::app()->clientScript->scriptMap['bootstrap.js'] = false;
		Yii::app()->clientScript->scriptMap['bootstrap.min.js'] = false;
			
		Yii::app()->clientScript->scriptMap['bootstrap-editable.js'] = false;
		Yii::app()->clientScript->scriptMap['bootstrap-editable.min.js'] = false;
		Yii::app()->clientScript->scriptMap['jquery.yiigridview.js'] = false;
		Yii::app()->clientScript->scriptMap['jquery.gridster.min.js'] = false;
		Yii::app()->clientScript->scriptMap['bootstrap-tooltip.js'] = false;
		Yii::app()->clientScript->scriptMap['jquery.cleditor.min.js'] = false;
		Yii::app()->clientScript->scriptMap['fileuploader.js'] = false;
		Yii::app()->clientScript->scriptMap['jquery.ba-bbq.min.js'] = false;
		Yii::app()->clientScript->scriptMap['bootstrap-datepicker.js'] = false;
		if (isset(Yii::app()->clientScript->scriptMap['lightbox.min.js']))
                {
                    Yii::app()->clientScript->scriptMap['lightbox.min.js'] = false;
                }
		
		// if on mobile
		// skip these scripts as well jquery.mobile-1.3.2.min
		if (Utilities::mobileViewRequested()
				|| ( Utilities::isMobile() && !Utilities::isTablet() ) )
		{
			Yii::app()->clientScript->scriptMap['jquery.mobile-1.3.2.min.js'] = false;
			Yii::app()->clientScript->scriptMap['jquery.mobile-1.3.2.js'] = false;
		}
			
		$controller->renderPartial($view, $data, $return, $processOutput);
	}
	
	/**
	 * Application wrapper for CHtml::link
	 * This function render link with extra attributes that the Application may use, such as data-workspace
	 * 
	 * @param unknown $text
	 * @param string $url
	 * @param unknown $htmlOptions
	 */
	public static function workspaceLink($text, $url = '#', $htmlOptions = array())
	{
		$htmlOptions['data-workspace'] = '1';
		
		return CHtml::link(
			$text,
			$url, // Yii URL
			$htmlOptions
		);
	}
	
	/**
	 * 
	 * @param unknown $email
	 * @return mixed false if filter failed. Data if valid email
	 */
	public static function isValidEmail($email)
	{
		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}
	
	/**
	 * Format date according to input param
	 * 
	 * @param string $date SQL DATE FORMATE
	 * @param string $format
	 */
	public static function formatDisplayDate($date, $format = DATE_FORMAT_DD_MM_YYYY_HI_MI)
	{
		$time = strtotime($date);
		
		return date($format, $time);
	}
	
	/**
	 * This function creates a table of contents for an HTML document using 
	 * it's heading structure, adding ID's to the provided $content string where needed. 
	 * It returns an array with two keys, the Table of Contents, in HTML ul > li format, 
	 * and the content with the headings replaced. 
	 * 
	 * Useful for automatically creating table's of content for long articles.
	 * 
	 * @author Joost de Valk, http://www.westhost.com/contest/php/function/create-table-of-contents/124
	 * @param unknown $content
	 * @return multitype:string mixed array('toc' => $toc, 'content' => $content)
	 */
	public static function createTOC( $content ) {
		preg_match_all( '/<h([1-6])(.*)>([^<]+)<\/h[1-6]>/i', $content, $matches, PREG_SET_ORDER );
	
		global $anchors;
	
		$anchors = array();
		$toc 	 = '<ul class="toc">'."\n";
		$i 		 = 0;
		$lvl	 = 0;
		$startlvl= 0;
		
		foreach ( $matches as $heading ) {
	
			if ($i == 0)
				$startlvl = $heading[1];
			$lvl 		= $heading[1];
	
			$ret = preg_match( '/id=[\'|"](.*)?[\'|"]/i', stripslashes($heading[2]), $anchor );
			if ( $ret && $anchor[1] != '' ) {
				$anchor = stripslashes( $anchor[1] );
				$add_id = false;
			} else {
				$anchor = preg_replace( '/\s+/', '-', preg_replace('/[^a-z\s]/', '', strtolower( $heading[3] ) ) );
				$add_id = true;
			}
	
			if ( !in_array( $anchor, $anchors ) ) {
				$anchors[] = $anchor;
			} else {
				$orig_anchor = $anchor;
				$i = 2;
				while ( in_array( $anchor, $anchors ) ) {
					$anchor = $orig_anchor.'-'.$i;
					$i++;
				}
				$anchors[] = $anchor;
			}
	
			if ( $add_id ) {
				$header_style = '';
				if ($lvl == $startlvl)
				{
					$header_style = 'border-bottom: 1px solid #DCDCDC';
				}
				$content = substr_replace( $content, 
						'<div style="display: table;  width: 100%;'. $header_style . '">
							<h'.$lvl.' id="'.$anchor.'"'.$heading[2].' style="float: left">'.$heading[3].'</h'.$lvl.'>'.
							'<span style="display: table-cell; vertical-align: middle; text-align: right"><a href="#wiki-toc-top">[toc]</a></span></div>', 
						strpos( $content, $heading[0] ), 
						strlen( $heading[0] ) );
			}
	
			$ret = preg_match( '/title=[\'|"](.*)?[\'|"]/i', stripslashes( $heading[2] ), $title );
			if ( $ret && $title[1] != '' )
				$title = stripslashes( $title[1] );
			else
				$title = $heading[3];
			$title 		= trim( strip_tags( $title ) );
	
			if ($i > 0) {
				if ($prevlvl < $lvl) {
					$toc .= "\n"."<ul>"."\n";
				} else if ($prevlvl > $lvl) {
					$toc .= '</li>'."\n";
					while ($prevlvl > $lvl) {
						$toc .= "</ul>"."\n".'</li>'."\n";
						$prevlvl--;
					}
				} else {
					$toc .= '</li>'."\n";
				}
			}
	
			$j = 0;
			$toc .= '<li><a href="#'.$anchor.'">'.$title.'</a>';
			$prevlvl = $lvl;
	
			$i++;
		}
	
		unset( $anchors );
	
		while ( $lvl > $startlvl ) {
			$toc .= "\n</ul>";
			$lvl--;
		}
	
		$toc .= '</li>'."\n";
		$toc .= '</ul>'."\n";
	
		// wrap toc in styled div
		$toc = '<a id="wiki-toc-top"><br/><div class="wiki-toc"><h4></a>'.YII::t('lang','Table of Contents').'</h4>' . $toc . '</div>';
		
		return array(
				'toc' => $toc,
				'content' => $content
		);
	}
	
	/**
	 * Original code, before updating to createTOC
	 * Do NOT user in PRODUCTION
	 * 
	 * @param unknown $content
	 * @return multitype:string mixed
	 */
	public static function create_toc_test( $content ) {
		preg_match_all( '/<h([1-6])(.*)>([^<]+)<\/h[1-6]>/i', $content, $matches, PREG_SET_ORDER );
	
		global $anchors;
	
		$anchors = array();
		$toc 	 = '<ol class="toc">'."\n";
		$i 		 = 0;
	
		foreach ( $matches as $heading ) {
	
			if ($i == 0)
				$startlvl = $heading[1];
			$lvl 		= $heading[1];
	
			$ret = preg_match( '/id=[\'|"](.*)?[\'|"]/i', stripslashes($heading[2]), $anchor );
			if ( $ret && $anchor[1] != '' ) {
				$anchor = stripslashes( $anchor[1] );
				$add_id = false;
			} else {
				$anchor = preg_replace( '/\s+/', '-', preg_replace('/[^a-z\s]/', '', strtolower( $heading[3] ) ) );
				$add_id = true;
			}
	
			if ( !in_array( $anchor, $anchors ) ) {
				$anchors[] = $anchor;
			} else {
				$orig_anchor = $anchor;
				$i = 2;
				while ( in_array( $anchor, $anchors ) ) {
					$anchor = $orig_anchor.'-'.$i;
					$i++;
				}
				$anchors[] = $anchor;
			}
	
			if ( $add_id ) {
				$content = substr_replace( $content, '<h'.$lvl.' id="'.$anchor.'"'.$heading[2].'>'.$heading[3].'</h'.$lvl.'>', strpos( $content, $heading[0] ), strlen( $heading[0] ) );
			}
	
			$ret = preg_match( '/title=[\'|"](.*)?[\'|"]/i', stripslashes( $heading[2] ), $title );
			if ( $ret && $title[1] != '' )
				$title = stripslashes( $title[1] );
			else
				$title = $heading[3];
			$title 		= trim( strip_tags( $title ) );
	
			if ($i > 0) {
				if ($prevlvl < $lvl) {
					$toc .= "\n"."<ol>"."\n";
				} else if ($prevlvl > $lvl) {
					$toc .= '</li>'."\n";
					while ($prevlvl > $lvl) {
						$toc .= "</ol>"."\n".'</li>'."\n";
						$prevlvl--;
					}
				} else {
					$toc .= '</li>'."\n";
				}
			}
	
			$j = 0;
			$toc .= '<li><a href="#'.$anchor.'">'.$title.'</a>';
			$prevlvl = $lvl;
	
			$i++;
		}
	
		unset( $anchors );
	
		while ( $lvl > $startlvl ) {
			$toc .= "\n</ol>";
			$lvl--;
		}
	
		$toc .= '</li>'."\n";
		$toc .= '</ol>'."\n";
	
		return array(
				'toc' => $toc,
				'content' => $content
		);
	}
	
	public static function getDateTimeByUserTimeZone($date_string)
	{
		$tz = new DateTimeZone(Yii::app()->user->timezone);
		$date = new DateTime($date_string);
		$date->setTimeZone($tz);
		return $date;
	}
	
	public static function displayFriendlyDate($date_string, $format = 'd-M-Y')
	{
            $format = YII::t('core',$format);
                if ($date_string == NULL || $date_string == '0000-00-00')
                    return '';
                
		$date = Utilities::getDateTimeByUserTimeZone($date_string);
                $serverDate = Utilities::getDateTimeByUserTimeZone(date('Y-m-d'));
                
                // is it today?
                $returned_date_str = $date->format($format);
                $server_date_str = $serverDate->format($format);
                if ($returned_date_str == $server_date_str)
                {
                    return YII::t('core','Today');
                } 
                
                // is it yesterday?
                $yesterday = date('Y-m-d', strtotime('Yesterday'));
                if ($yesterday == $date->format('Y-m-d'))
                {
                    return YII::t('core','Yesterday');
                }
                
		return $returned_date_str;
	}
	
	public static function displayFriendlyDateTime($date_string, $format = 'd M Y, h:i a')
	{
                $format = YII::t('core',$format); 
		$date = Utilities::getDateTimeByUserTimeZone($date_string);
                $serverDate = Utilities::getDateTimeByUserTimeZone(date('Y-m-d'));
                
                // is it today?
                $returned_date_str = $date->format($format);
                $server_date_str = $serverDate->format($format);
                if ($returned_date_str == $server_date_str)
                {
                    return $date->format('h:i a');
                } 
                
                // is it yesterday?
                $yesterday = date('Y-m-d', strtotime('Yesterday'));
                if ($yesterday == $date->format('Y-m-d'))
                {
                    return YII::t('core','Yesterday').' ' . $date->format('h:i a');
                }
                
		return $date->format($format);
	}
	
	public static function displayFriendlyTime($date_string, $format = 'h:i a')
	{
		$date = Utilities::getDateTimeByUserTimeZone($date_string);
		return $date->format($format);
	}
	
	/**
	 * 
	 * @param string $date_string
	 * @return string converted date string
	 */
	public static function convertDateToUserTimeZone($date_string, $format = 'Y-m-d')
	{
		$date = Utilities::getDateTimeByUserTimeZone($date_string);
		return $date->format($format);
	}
	
	public static function convertDateToServerTimeZone($date_string, $format = 'Y-m-d')
	{
		$server_tz = date_default_timezone_get();
		if ($server_tz == '')
			$server_tz = ini_get('date.timezone');
		$tz = new DateTimeZone($server_tz);
		$date = new DateTime($date_string);
		$date->setTimeZone($tz);
		return $date->format($format);
	}
	
	/**
	 * For dropdown source
	 */
	public static function getTimeZoneListSource()
	{
		$results = array(''=>'Select');
		$timezone_identifiers = DateTimeZone::listIdentifiers();
		foreach ($timezone_identifiers as $tz) {
			$results[$tz] = $tz;
		}
		
		return $results;
	}
        
        /**
         * Convert all URL text in a string into clickable link 
         * It'll still show the full original URL, and add a clickable icon after it
         * 
         * Credit: http://stackoverflow.com/questions/12538358/convert-url-to-links-from-string-except-if-they-are-in-a-attribute-of-a-html-tag
         * 
         * @param type $string
         * @return string the converted string
         */
        public static function convertURLtoLink($string) 
        {
            // first, add http:// in front of url if it doesn't have yet
            //$string = preg_replace('$(www\.[a-z0-9_./?=&#-]+)(?![^<>]*>)$i', 
            //        ' http://$1 ', $string." ");

            // based on that, parse all phrase starts with http or https
            // and add link behind
            $string = preg_replace('$(https?://[a-z0-9_./?=&#-]+)(?![^<>]*>)$i', 
                    ' <a href="$1" target="_blank">$1</a> ', $string." ");
            $string = preg_replace('$(www\.[a-z0-9_./?=&#-]+)(?![^<>]*>)$i', 
                    '<a target="_blank" href="http://$1"  target="_blank">$1</a> ', $string." ");

            return trim($string);
        }
	
	/**
	 * Application Main Links
	 */
	public static function getAppLinkiWiki()
	{
		return array(Utilities::getCurrentlySelectedSubscription() .'/wiki');
	}
	
	public static function getAppLinkiWikiLinks()
	{
		return array(Utilities::getCurrentlySelectedSubscription() . '/wiki', 'tab'=>'lists');
	}
	
	public static function getAppLinkiProjects()
	{
		return array(Utilities::getCurrentlySelectedSubscription() .'/');
	}
	
	public static function getAppLinkProgress()
	{
		return array(Utilities::getCurrentlySelectedSubscription().'/progress');
	}
	
	public static function getAppLinkCaledar()
	{
		return array(Utilities::getCurrentlySelectedSubscription().'/calendar');
	}
	
	//******* END APPLICATION MAIN LINKS **********
}
