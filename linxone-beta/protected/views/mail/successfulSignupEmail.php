<?php
?>
<p>Hello.</p>
<p>Welcome to <?php echo Yii::app()->name ?> </p>

<p>Your registration is successful. You may start to login already. However, you're still required to activate your account by clicking the link below: </p>

<p><a href="<?php echo $activation_url ?>">Activate my account now.</a></p>

<p>We may suspend accounts that are not activated within 30 days of their registrations.</p>
<p><?php echo Yii::app()->params['emailSignature'] ?></p>