<p>Hello</p>

<br/>
<p>You requested to reset your password @ <?php echo Yii::app()->name; ?>. 
If you did not make this request, please let us know. Otherwise, please follow the instruction below.
</p>

<br/>
<p>
In order to reset your password, click the link below and type in your new password: <br/>
<a href="<?php echo $reset_url; ?>">Click here to reset password.</a></p>

<br/>
<p><?php echo Yii::app()->params['emailSignature'] ?></p>

<br/>
<p>
(c) <?php echo date('Y'); ?>, LinxHQ Pte Ltd, www.linxhq.com.
</p>
