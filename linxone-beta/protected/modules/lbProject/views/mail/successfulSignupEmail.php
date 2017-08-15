<?php
?>
<p><?php echo Yii::t('mail','Hello') . "."; ?></p>
<p><?php echo Yii::t('mail','Welcome to') . " " . Yii::app()->name; ?> </p>

<p><?php echo Yii::t('mail',"Your registration is successful. You may start to login already. However, you're still required to activate your account by clicking the link below") . ":";?> 
</p>

<p><a href="<?php echo $activation_url ?>"><?php echo Yii::t('mail','Activate my account now') . "."; ?></a></p>

<p><?php echo Yii::app()->params['emailSignature'] ?></p>