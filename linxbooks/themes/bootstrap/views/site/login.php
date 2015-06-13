<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>
<!DOCTYPE html>
<html>
	
<head>
	<title>Login-Linxbooks</title>
		<meta charset="utf-8">
                <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
                <link href="<?php echo Yii::app()->baseUrl; ?>/css/login.css" rel='stylesheet' type='text/css' />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
		<!--webfonts-->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:600italic,400,300,600,700' rel='stylesheet' type='text/css'>
		<!--//webfonts-->
</head>
<body>
	
				 <!-----start-main---->
				<div class="login-form">
                                <div class="head">LinxBooks</div>
                                <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                                            'id'=>'login-form',
                                        'type'=>'horizontal',
                                            'enableClientValidation'=>true,
                                            'clientOptions'=>array(
                                                    'validateOnSubmit'=>false,
                                            ),
                                    )); ?>
   
					<li>
						<!--<input type="text" class="text" value="USERNAME" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'USERNAME';}" ><a href="#" class=" icon user"></a>-->
                                                <i class="icon user"></i>
                                                <?php echo $form->textFieldRow($model,'username',array('value'=>'Username','onfocus'=>'this.value = "";',
                                                        'onblur'=>'if (this.value == "") {this.value ="Username";}'
                                                    )); ?>
					</li>
					<li>
						<!--<input type="password" value="Password" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Password';}"><a href="#" class=" icon lock"></a>-->
                                                <i class="icon lock"></i>
                                                <?php echo $form->passwordFieldRow($model,'password',array('value'=>'Password','onfocus'=>'this.value = "";',
                                                        'onblur'=>'if (this.value == "") {this.value ="Password";}'
                                                    )); ?>
					</li>
                                        <?php echo $form->error($model,'error'); ?>
					<div class="p-container">
								<!--<label class="checkbox"><input type="checkbox" name="checkbox" checked><i></i>Remember Me</label>-->
                                                                <?php echo $form->checkBoxRow($model,'rememberMe'); ?>
								<input type="submit" value="LOGIN" >
							<div class="clear"> </div>
					</div>
                                        <?php echo CHtml::link('Reset Password', array('accountPasswordReset/create'),array('style'=>'    font-size: 14px;left: 325px;position: relative;top: 3px;color: #858282;')); ?>
                                    <?php $this->endWidget(); ?>
			</div>
			<!--//End-login-form-->
		  <!-----start-copyright---->
   					<div class="copy-right">
						<p>Copyright © 2015, LinxBooks. All Rights Reserved. LinxHQ Pte Ltd</p> 
					</div>
				<!-----//end-copyright---->
		 		
</body>
</html>
