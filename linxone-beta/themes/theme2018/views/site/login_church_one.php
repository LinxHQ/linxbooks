<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>
<html lang="en">
    <head>
    <title>Login <?php echo Yii::app()->name; ?></title>
    <meta charset="utf-8">
    <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    <link href="<?php echo Yii::app()->baseUrl; ?>/css/login-church-one.css" rel='stylesheet' type='text/css' />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    <!--webfonts-->
    <link href="http://allfont.net/allfont.css?fonts=latin-modern-mono-light-cond-10-" rel="stylesheet" type="text/css" />
    <!--//webfonts-->
</head>
<body>
<br><br><br>
<!--ChurchOne Header-->
<header class="sansserif">
    <h1 style="font-size:3vw"> Church<span style="color:rgb(108,108,108)">One</span>
    </h1>
</header>
<br>
<!--Log in form here-->
<div style="margin: 0 auto; width: 26%; height: 170px; border-left: 7px solid #FFC600; border-right: 7px solid #FFC600; border-top: 7px solid #FFC600; position: relative;">
    <br><br>
    <div style="position: absolute; width: 100%; height: 200%; text-align: center;">
        <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                'id'=>'login-form',
            'type'=>'horizontal',
                'enableClientValidation'=>true,
                'clientOptions'=>array(
                        'validateOnSubmit'=>false,
                ),
        )); ?>
            <br><br> <br>
            <!-- username--> 
            <label for="username" id="usern">
                <!-- Username <input type="text" name="LoginForm[username]" id="LoginForm_username" /> -->
                Username <input name="LoginForm[username]" id="LoginForm_username" type="text">
            </label>
            <br> <br> <br>
            <!-- password--> 
            <label for="password" id="passw">
                Password <input name="LoginForm[password]" id="LoginForm_password" type="password">
            </label>
            <br> <br>
    
            <?php

                $config_social = LbConfigLoginSocial::model()->findAll();
                if($config_social[0]['action'] == 1){
                    if (Yii::app()->user->hasFlash('error')) {

                    } else if(Yii::app()->user->hasFlash('success')){
                        echo '<div style="background-color: #99FF33; padding: 5px; border-radius: 5px;" class="success">'.Yii::app()->user->getFlash('success').'</div>';
                    }

                    $this->widget('ext.eauth.EAuthWidget', array('action' => 'site/login'));
                }
            ?>

            <?php echo $form->error($model,'error'); ?>
            <!-- button-->
            <button class="button" type="submit"> LOGIN </button>
            <div class="clear"> </div>
            <!--reset password link--> 
            <?php echo CHtml::link('Reset Password', array('accountPasswordReset/create'),array('style'=>'color:rgb(108,108,108);')); ?>
        <?php $this->endWidget(); ?>
    </div>
</div>
<div style="margin: 0 auto; width: 26%; height: 170px; border-left: 7px solid #7F7F7F; border-right: 7px solid #7F7F7F; border-bottom: 7px solid #7F7F7F;"></div>

<div class="copy-right">
    <br>
    <p>Copyright ©, <?php  echo Yii::app()->name; ?>. All Rights Reserved. LinxHQ Pte Ltd</p> 
</div>
</body>
</html>

