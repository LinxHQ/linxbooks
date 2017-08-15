<?php
?>
<p><?php echo Yii::t('mail', 'Hello');?></p>
<br/>
<p><?php 
    echo Yii::t('mail', "You're invited to join") . " " . Yii::app()->name . ','; 
    echo Yii::t('mail', 'by');
    echo Yii::app()->user->account_profile_short_name . ' (' . Yii::app()->user->account_email . ')';
    echo Yii::t('mail', 'Please click the link below to in order to accept') . ':';
    ?>
</p>
<br/>
<p><a href="<?php echo $invitation_accept_url; ?>"><?php echo Yii::t('mail', 'Accept Invitation'); ?></a></p>
<br/>
<p>Message:</p>

<p><?php echo $invitation_message; ?></p>
<br/>
<p><?php echo Yii::app()->params['emailSignature'] ?></p>
<br/>
<p>

    <?php echo Yii::t('mail', 'Please DO NOT reply to this email') . '.'; ?>
    <br/>
LinxCircle.com (c) <?php echo date('Y'); ?>, LixHQ Pte Ltd.
</p>