<?php
/* @var $this TaskController */
/* @var $model Task */
/* @var $form TbActiveForm */
?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'calendar-task-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('onclick'=> 'event.stopPropagation();'),
)); ?>

	<?php 
	// START
	echo $form->textFieldRow($model,'task_start_date', 
		array('style'=>'width: 100px;','value'=>date('d M Y', strtotime($model->task_start_date))));
	echo $form->textFieldRow($model,'task_end_date', 
		array('style'=>'width: 100px;','value'=>date('d M Y', strtotime($model->task_end_date ? $model->task_end_date : $model->task_start_date))));
	echo '<br/>';
	echo '<span>Click on the label to change date.</span><br/>';
	?>

	<?php 
	echo Utilities::generateManualAjaxLink(
		'Save',
		array(
			'type'=>'POST',
			'url' => array('task/popoverSchedule','id'=>$model->task_id),
			'success' => 'function(data){$("#linx-calendar").fullCalendar("refetchEvents");return false;}'), 
		array('class'=>'btn'));
	/**
	echo CHtml::ajaxSubmitButton('Save',
		array('task/popoverSchedule', 'id'=>$model->task_id),
		array(
				'id' => 'ajax-link' . uniqid(),
				'success' => 'function(data){$("#linx-calendar").fullcalendar("render");return false;}'),
		array('live' => false)); **/
	?>
	<?php echo CHtml::link('close', '#', array('onclick' => '$(".fc-event-title").popover("destroy");event.stopPropagation();return false;'))?>

<?php 
$this->endWidget(); 
//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap-datepicker.js', CClientScript::POS_END);
?>

	
