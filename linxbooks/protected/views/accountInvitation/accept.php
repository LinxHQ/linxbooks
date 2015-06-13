<?php 
/** @var BootActiveForm $form */
/** @var model AccountInvitation model */
/** $account */

$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'form-account-invitation-accept',
    'htmlOptions' => array('class'=>'well'),
)); 

//$account = new Account();
$accountProfile = new AccountProfile();
?>
<p>
You're accepting this invitation using email address <?php echo $model->account_invitation_to_email; ?>. Please enter your password below. Upon completion, you may login using this email address and password. Have fun!
</p>
<?php echo $form->errorSummary($account); ?>
<?php echo $form->errorSummary($accountProfile); ?>

<?php echo $form->hiddenField($account, 'account_email'); ?>
<?php //echo $form->passwordField($account, 'account_password'); ?>
<?php echo $form->passwordFieldRow($account, 'account_password', array('class'=>'span3')); ?>
<?php echo $form->textFieldRow($accountProfile, 'account_profile_surname', array('class'=>'span3')); ?>
<?php echo $form->textFieldRow($accountProfile, 'account_profile_given_name', array('class'=>'span3')); ?>
<?php //echo $form->checkboxRow($model, 'checkbox'); ?>
<br/>
<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'Accept')); ?>
 
<?php $this->endWidget(); ?>