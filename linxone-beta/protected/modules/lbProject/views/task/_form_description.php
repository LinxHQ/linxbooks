<?php
/* @var $model Task */
$form_id = 'task-description-form-' . $model->task_id;
$container_id = "form-container-" . $form_id ;
$form_action = Yii::app()->createUrl('task/ajaxUpdateDescription', array('id' => $model->task_id, 'ajax' => 1));
$form = $this->beginWidget('CActiveForm', array(
	'id' => $form_id,
	'action' => $form_action,
	'enableAjaxValidation' => false,
)); 

$this->widget('application.extensions.cleditor.ECLEditor', array(
		'model' => $model,
		'attribute' => 'task_description', //Model attribute name. Nome do atributo do modelo.
		'options'=>array(
			'width' => 700,
			'height' => 150,
			'controls' => 'bold italic underline strikethrough | font size color highlight removeformat | bullets numbering | outdent indent | link unlink',
		),
		'htmlOptions' => array('value' => $model->task_description, 'style' => 'width: 700px; height: 150px;'),
));

echo $form->hiddenField($model, 'task_id', array('value' => $model->task_id));
echo CHtml::hiddenField('task_description_before_update', $model->task_description, array('id' => 'task-description-before-update-' . $model->task_id));

// submit button and post-submission processing
echo '<br/>';
echo CHtml::ajaxSubmitButton('Save',
		$form_action,
		array(
				'id' => 'ajax-link' . uniqid(),
				'update' => '#task-description-content-' . $model->task_id),
		array('live' => false));

echo CHtml::link(
		'Cancel',
		'#', // Yii URL
		array('onclick' => 'js: 
			$("#task-description-content-' . $model->task_id . '").html($("#task-description-before-update-' . $model->task_id . '"));
			return false;')
);

$this->endWidget(); 
