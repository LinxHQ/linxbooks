<?php /* @var $this Controller */ 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div id="page-wrapper">
<div class="container" id="page">
	<div id="accountmenu">
			<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Signup', 'url'=>array('/account/create'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'My Account', 'url'=>array('/account/view/' . Yii::app()->user->id), 'visible' => !Yii::app()->user->isGuest),
				array('label'=>'Contact', 'url'=>array('/site/contact')),
				array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		));?>
	</div>
	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
		<div id="mainmenu">
		<?php 
		/**
		$this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Home', 'url'=>array('/site/index')),
				array('label'=>'Project', 'url'=>array('/site/page', 'view'=>'about')),
				//array('label'=>'Contact', 'url'=>array('/site/contact')),
				//array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				//array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		));**/ 

		$this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Home', 'url'=>array('/site/index')
					, 'ajax' => false),
				array('label'=>'Project', 'url'=>array('/project/index')
					, 'ajax' => array('update' => '#content')),
				array('label'=>'My Profile', 'url'=>array('/account/view/' . Yii::app()->user->id)
					, 'ajax' => array('update' => '#content')),
				//array('label'=>'Contact', 'url'=>array('/site/contact')),
				//array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				//array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
			),
//			'optionalIndex' => true,
//			'randomID'=>true,
		));
		?>
	</div><!-- mainmenu -->
	</div><!-- header -->

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
		<?php //echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

</div><!-- end page-wrapper -->
</body>
</html>
