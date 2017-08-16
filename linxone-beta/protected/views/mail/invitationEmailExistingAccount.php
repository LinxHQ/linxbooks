<?php
// this view is for invitation email that is sent to an existing account, to join another team on LinxCircle.
?>
<p>Hello</p>
<br/>
<p>You're invited to join a team at <?php echo Yii::app()->name; ?>, 
by <?php echo Yii::app()->user->account_profile_short_name . ' (' . Yii::app()->user->account_email . ')'; ?>. 
Since you already have an account with us, simply log on and navigate to My Account page to accept this invitation.</p>
<br/>
<p>Message from <?php echo Yii::app()->user->account_profile_short_name . ' (' . Yii::app()->user->account_email . ')'; ?>:</p>

<p><?php echo $invitation_message; ?></p>
<br/>
<p><?php echo Yii::app()->params['emailSignature'] ?></p>
<br/>
<p>
Please DO NOT reply to this email.<br/>
(c) <?php echo date('Y'); ?>, LinxHQ Pte Ltd, www.linxhq.com.
</p>
