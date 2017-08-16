<?php
?>
<p>Hello</p>
<br/>
<p>You're invited to join <?php echo Yii::app()->name; ?>, 
by <?php echo Yii::app()->user->account_profile_short_name . ' (' . Yii::app()->user->account_email . ')'; ?>. Please click the link below to in order to accept:</p>
<br/>
<p><a href="<?php echo $invitation_accept_url; ?>">Accept Invitation</a></p>
<br/>
<p>Message:</p>

<p><?php echo $invitation_message; ?></p>
<br/>
<p><?php echo Yii::app()->params['emailSignature'] ?></p>
<br/>
<p>
Please DO NOT reply to this email.<br/>
(c) <?php echo date('Y'); ?>, LinxHQ Pte Ltd www.linxhq.com.
</p>
