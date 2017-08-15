<?php
/* @var $this AccountInvitationController */
/* @var $model AccountInvitation */
/* @var $form CActiveForm */

$linx_app_account_subscriptions = AccountSubscription::model()->findSubscriptions(Yii::app()->user->id);
$model_langguage = lbLangUser::model();
$model_account_profile = AccountProfile::model();
$langgage['en']='English';
$langgage['vi']='Tiếng Việt';
?>

<div class="form">

<?php 

$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'issue-form',
		'htmlOptions' => array('class'=>'well','onsubmit'=>"checkEmail();"),
                'enableClientValidation'=>true,
                'clientOptions'=>array(
                    'validateOnSubmit'=>true,
                ),

));

// list of projects user created
// can only invite to own project
//$active_projects = array(0 => '') + Project::model()->getProjectsCreatedBy(Yii::app()->user->id, 'datasourceArray');
?>
    <?php echo CHtml::errorSummary($model);?> 
    <p class="note">Fields with <span class="required">*</span> are required.</p>
<fieldset>


        <?php echo $form->dropDownListRow($model, 'account_invitation_subscription_id', $linx_app_account_subscriptions, array('options' => array(Yii::app()->user->linx_app_selected_subscription=>array('selected'=>true)))); ?>     
    <?php echo $form->textFieldRow($model_account_profile,'account_profile_given_name',array('style'=> 'width: 500px;','maxlength'=>255)); ?>
	<?php echo $form->textFieldRow($model,'account_invitation_to_email',array('style'=> 'width: 500px;','maxlength'=>255, 'hint'=>'Multiple emails separated by comma.')); ?>
	<?php echo $form->textAreaRow($model, "account_invitation_message", array('style'=> 'width: 600px; height: 150px;')); ?>
	<?php echo $form->checkboxRow($model, 'account_invitation_type'); ?>
        <?php echo $form->dropDownListRow($model_langguage, 'lb_language_name', $langgage, array('options' => array())); ?>    
    <br /> 
    <?php 
        echo Yii::t('lang','Roles :')."<br />";
        $roles = Roles::model()->search();
        $arr_roles = array();
        foreach($roles->data as $result_roles){
            $arr_roles[$result_roles['lb_record_primary_key']] = $result_roles['role_name'];
        }
        echo Select2::multiSelect("roles", '', $arr_roles, 
            array(
                'required' => 'required',
                'select2Options' => array(
                  'placeholder' => 'Please select a roles',
                  // 'maximumSelectionSize' => 4,
                ),
            )
        );
     ?>

</fieldset>
	<div class="form-actions">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Invite' :'Save',array('onclick'=>'return checkEmail();')); ?>
          
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->


<script language="javascript">

function checkEmail() {

    var email = document.getElementById('AccountInvitation_account_invitation_to_email');
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
// Chuỗi cần cắt 
    var chuoi = email.value; 
    var mang = chuoi.split(","); 
    // Giá trị sau khi cắt 
    var success=true;
    // Độ dài chuỗi hiện tại 
    var count=0; 

    for(var i = 0; i < mang.length; i++) 
    { 
        
        if (!filter.test(mang[i])) {
            alert('Please provide a valid email address');
    
            success=false;
        }
    }
    return success;
}
</script>