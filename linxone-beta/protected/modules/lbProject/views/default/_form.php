<?php
/* @var $this ProjectController */
/* @var $model Project */
/* @var $form CActiveForm */

if (!Permission::checkPermission($model, PERMISSION_PROJECT_CREATE))
{
	return false;
}
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'project-form',
	'enableAjaxValidation'=>false,
)); 

if (!Project::canCreateMoreProject())
{
    echo '<div class="flash-error">' . 
            Yii::t('core','Your subscription has exceeded its max number of projects allowed') . '. ' .
                            Yii::t('core','Please contact admin to upgrade') . ': ' . CHtml::link(Yii::app()->params['contactEmail'],'mailto:'.Yii::app()->params['contactEmail'])
            . "</div>\n";
}

?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php 
	// if this account is linked to more than 2 subscriptions
	// must choose which subscription to create this project in
	$accountSubscriptions = AccountSubscription::model()->findSubscriptions(Yii::app()->user->id,true);//Yii::app()->user->account_subscriptions;
	
	if ($accountSubscriptions) 
	{		
		if (count($accountSubscriptions) > 1)
		{
			// show choices
			echo $form->dropDownListRow($model,'account_subscription_id', $accountSubscriptions);
		} else if (count($accountSubscriptions) == 1) {
			// else hide it by default since there's nothing to select
			// TODO: back end needs to validate that user has right.
			reset($accountSubscriptions);
			$first_key = key($accountSubscriptions);
			echo $form->hiddenField($model,'account_subscription_id', array('value' => $first_key));
		}
	}
        else
            echo $form->hiddenField($model,'account_subscription_id', array('value' => Utilities::getCurrentlySelectedSubscription()));
	// END choosing account subscriptions
	?>
	
	<?php echo $form->textFieldRow($model,'project_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php 
		
		//echo $form->labelEx($model,'project_start_date'); 
		
		echo $form->hiddenField($model,'project_start_date', array('value' => $model->project_start_date != null ? $model->project_start_date :date('Y-m-d')));
		/**
		$this->widget('zii.widgets.jui.CJuiDatePicker', array(
				'model'=>$model,
				'attribute'=>'project_start_date',
				'name'=>'project_start_date_date_picker',
				//'value' => date('d M Y'),//( $model->project_start_date != null ? $model->project_start_date : date('d M Y')) ,
				// additional javascript options for the date picker plugin
				'options'=>array(
						'showAnim'=>'fold',
						'showButtonPanel'=>true,
						'autoSize'=>true,
						'dateFormat'=>'yy-mm-dd',
						//'defaultDate'=> date('Y-m-d'),
						'altField' => '#Project_project_start_date',
						'altFormat' => 'yy-mm-dd',
						'onSelect'=>'function(dateStr){alert("he");}'
				),
		));**/
		?>
	<?php 
        echo $form->textAreaRow($model,'project_description',array('cols'=>60,'rows'=> 4, 'style' => 'width: 600px; height: 250px;')); 
        echo $form->dropdownListRow($model,'project_priority', $model::getPriorityArray());
        
        /**echo $form->checkBoxRow($model, 'project_simple_view', 
			array('hint'=>'Use only Tasks, Documents, and Wikis. You can still change this later on.')); 
        **/
        $hint = Yii::t('core','Use milestone view. This allows you to group tasks/issues into milestones, with just a drag & drop. You may still change this setting later.');
        echo $form->checkBoxRow($model, 'project_ms_method', 
			array('hint'=>$hint));
        ?>
	<div class="form-actions">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->