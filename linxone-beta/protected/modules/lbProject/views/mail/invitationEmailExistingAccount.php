<?php
// this view is for invitation email that is sent to an existing account, to join another team on LinxCircle.
?>
<p><?php echo Yii::t('mail', 'Hello'); ?></p>
<br/>
<p><?php 
    echo Yii::t('mail', "You're invited to join a team at"). " ". Yii::app()->name . ",";
    echo Yii::t('mail', 'by') . " ";
    echo Yii::app()->user->account_profile_short_name . ' (' . Yii::app()->user->account_email . ').'; 
    echo Yii::t('mail', 'Since you already have an account with us, simply log on and navigate to My Team page to accept this invitation') . ".";
    ?>
</p>
<br/>
<p>Message from <?php echo Yii::app()->user->account_profile_short_name . ' (' . Yii::app()->user->account_email . ')'; ?>:</p>

<p><?php echo $invitation_message; ?></p>
<br/>
<p><?php echo Yii::app()->params['emailSignature'] ?></p>
<br/>
<p>
    <?php echo Yii::t('mail', "Please DO NOT reply to this email") . "."; ?>
<br/>
LinxCircle.com (c) <?php echo date('Y'); ?>, LinxHQ Pte Ltd.
</p>