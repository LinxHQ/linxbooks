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
	<title>Login <?php echo Yii::app()->name; ?></title>
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
                            <div class="login-content">
                                <div class="head"><?php  echo Yii::app()->name; ?></div>
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
                                        <?php 
                                            $config_social = LbConfigLoginSocial::model()->findAll();
                                            if($config_social[0]['action'] == 1){
                                        ?>
                                        <table style="width: 100%; margin: -19px 0px 10px 0px;">
                                            <tr>
                                              <td style="width: 43%" ><div style="border: 1px solid black;"></div></td>
                                              <td style="width: 2%"><span > <h4>Or</h4></span></td>
                                              <td style="width: 43%"><div style="border: 1px solid black;"></div></td>
                                            </tr>
                                        </table>
                                        <div style="margin-bottom: -50px;">
                                            <?php
                                                if (Yii::app()->user->hasFlash('error')) {
//                                                        echo '<div class="error">'.Yii::app()->user->getFlash('error').'</div>';
                                                } else if(Yii::app()->user->hasFlash('success')){
                                                        echo '<div style="background-color: #99FF33; padding: 5px; border-radius: 5px;" class="success">'.Yii::app()->user->getFlash('success').'</div>';
                                                }
                                            ?>
                                            <br />
                                            <?php
                                                $this->widget('ext.eauth.EAuthWidget', array('action' => 'site/login'));
                                            ?>
                                        </div>
                                        <?php } ?>
                                        <?php echo $form->error($model,'error'); ?>
					<div class="p-container">
								<!--<label class="checkbox"><input type="checkbox" name="checkbox" checked><i></i>Remember Me</label>-->
                                                                <?php //echo $form->checkBoxRow($model,'rememberMe'); ?>
								<input type="submit" value="LOGIN" >
							<div class="clear"> </div>
                                            <?php echo CHtml::link('Reset Password', array('accountPasswordReset/create'),array('style'=>'font-size: 13px;color: #858282;')); ?>
					</div>
                                        
                                    <?php $this->endWidget(); ?>
                            </div>
			</div>
			<!--//End-login-form-->
		  <!-----start-copyright---->
   					<div class="copy-right">
						<p>Copyright ©, <?php  echo Yii::app()->name; ?>. All Rights Reserved. LinxHQ Pte Ltd</p> 
					</div>
				<!-----//end-copyright---->
		 		
</body>
</html>
