<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<script language="javascript">
	var BASE_URL = '<?php echo Yii::app()->baseUrl; ?>';
	</script>
	
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/main-mobile.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/linx-mobile-app.min.css">
	
	<script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.min.js" type="text/javascript"></script>
	<script type="text/javascript">
	$(document).bind("mobileinit", function () {
	    $.mobile.ajaxEnabled = false;
	});
	</script>
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile.structure-1.3.2.min.css" />
	<!--  link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.css" /-->
	<script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>
	<script src="<?php echo Yii::app()->baseUrl; ?>/js/jqm-datebox-1.4.0.core.min.js" type="text/javascript"></script>
	<script src="<?php echo Yii::app()->baseUrl; ?>/js/jqm-datebox-1.4.0.mode.calbox.min.js" type="text/javascript"></script>
</head>

<body>

<div data-role="page" data-theme="a">	
    <?php 
    // SIDE MENU
    if (!Yii::app()->user->isGuest)
    {
    	echo '<div data-role="panel" id="linx-app-menu-panel" data-display="push">';
    	echo '<ul data-role="listview">';
	   	echo '<li>' . CHtml::link('Projects', array('project/index')) . '</li>';
	   	echo '<li>' . CHtml::link('Progress', array('project/progress')) . '</li>';
	   	//echo '<li>' . CHtml::link('Wiki', array('wikiPage/index')) . '</li>';
	   	echo '</ul>';
	   	echo '</div><!-- /panel -->';
    }
    ?>
		
	<div data-role="header" data-theme="b" role="banner" style="border-top: solid 5px #5DA028; padding-top: 5px;">
	  	<center><img src="<?php echo Yii::app()->baseUrl ?>/images/linxlogo_mobile.png" height="28"/></center>
	 	<a href="#linx-app-menu-panel" data-iconpos="notext" data-theme="b" 
	 		data-role="button" data-icon="bars" title=" Navigation" data-wrapperels="span"
	 		style="margin-top: 4px;"> </a>
	</div>


			<?php 
			$linx_app_menu_subscription_items = array();
			if (!Yii::app()->user->isGuest)
			{
				$linx_app_account_subscriptions = AccountSubscription::model()->findSubscriptions(Yii::app()->user->id);
				
				foreach ($linx_app_account_subscriptions as $sub_id=>$subscription)
				{
					$label = $subscription;
					if (isset(Yii::app()->user->linx_app_selected_subscription)
							&& $sub_id == Yii::app()->user->linx_app_selected_subscription)
						$label .= ' <i class="icon-ok"></i>';
					
					$linx_app_menu_subscription_items[] = array('label'=>$label, 
							'url'=>array('site/subscription', 'id' => $sub_id), 'visible' => !Yii::app()->user->isGuest);
				}
			}?>
	
	<?php echo $content; ?>
	
	</div> <!--  datarole page -->
</body>
</html>