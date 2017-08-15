<?php
/* @var $this TaskController */
/* @var $model Task */
/* @var $form CActiveForm */

$priorityItems = ListItem::model()->getItemsForList(TASK_PRIORITY_LIST_NAME);
$pririty_items_array = array();
foreach ($priorityItems as $item)
{
	$pririty_items_array[$item->system_list_item_id] = $item->system_list_item_name;
}

/**
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'task-form',
	'enableAjaxValidation'=>false,
));**/ 
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'task-form',
	//'htmlOptions' => array(),
	'enableAjaxValidation'=>false,
        'htmlOptions' => array('enctype' => 'multipart/form-data','class'=>''),
	'action' => array('task/create', 'project_id' => $project_id),
));

// Chosen plugin
echo '<link href="'.Yii::app()->baseUrl.'/js/chosen/chosen.min.css" rel="stylesheet">';
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/chosen/chosen.jquery.min.js', CClientScript::POS_BEGIN);
// end chosen plugin

// MultiFule plugin if not loaded yet
if(!isset(Yii::app()->clientScript->scriptMap['jquery.multifile.js'])) {
  Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.multifile.js', CClientScript::POS_BEGIN);
}

?>
	<?php echo $form->errorSummary($model); ?>
	<?php echo $form->hiddenField($model,'project_id', array('value' => $project_id)); ?>
	<?php 
        echo $form->textFieldRow($model,'task_name',array('size'=>60,'maxlength'=>255, 'class' => 'span8')); 
        echo $form->labelEx($model,'task_type');
        echo $form->dropDownList($model, 'task_type', $model->getTaskTypesList());
        ?>
	<?php echo $form->labelEx($model,'task_description'); ?>
	<?php 
		//echo $form->textArea($model,'task_description',array('rows'=>10,'cols'=>80)); 
		$this->widget('application.extensions.cleditor.ECLEditor', array(
        	'model'=>$model,
        	'attribute'=>'task_description', //Model attribute name. Nome do atributo do modelo.
        	'options'=>array(
            	'width'=>'700',
            	'height'=> 300,
            	'useCSS'=>true,
        	),
        	'value'=> $model->task_description, //If you want pass a value for the widget. I think you will. Se você precisar passar um valor para o gadget. Eu acho irá.
    ));
	?>
        <?php echo $form->dropdownListRow($model,'task_priority', $pririty_items_array); ?>
	<?php 
	// SELECT ASSIGNEES
	$project_members = ProjectMember::model()->getProjectMembers($project_id, true);
	echo $form->labelEx($model, 'task_assignees');
	echo CHtml::dropDownList('task_project_members_list', Yii::app()->user->id, 
		CHtml::listData($project_members, 'account_id', function($member){
			return AccountProfile::model()->getShortFullName($member->account_id);
		}),
		array('id'=>'task_project_members_list', 'multiple'=>'true','class'=>'span8') );
	echo $form->hiddenField($model, 'task_assignees');
        
        echo '<br/><br/><label>'.YII::t('core','Attach document(s)').':</label>';
        // multi-files upload 
        $this->widget('CMultiFileUpload', array(
                'name' => 'task_documents',
                'accept' => implode('|', Documents::supportedTypes()),// 'jpeg|jpg|gif|png|bmp|zip|doc|docx', // useful for verifying files
                'duplicate' => 'Duplicated file.', // useful, i think
                'denied' => 'Invalid file type, we only allow: ' . implode('|', Documents::supportedTypes()), // useful, i think
            ));
	?>
	
	<div class="" style="margin-top: 20px;">
	<?php 
	$this->widget('bootstrap.widgets.TbButton',
		array('buttonType' => 'submit',
                                'type'=>'primary',
				//'ajaxOptions' => array(
				//		'success' => 'function(data){
				//			$("#content").html(data);
				//		}',
				//		'id' => 'ajax-link' . uniqid()),
				'htmlOptions' => array('live' => false),
				'url' => array('task/create'),
				'label' => YII::t('core','Submit'),
	));
	//echo CHtml::ajaxSubmitButton('Save','', 
	//			array('update' => '#ajax-content', 'id' => 'ajax-link' . uniqid()),
	//			array('live' => false)); ?>
	</div>

<?php $this->endWidget(); ?>
<script language="javascript">
var selectedAssignees = new Array();
$("#task_project_members_list").chosen();
$('#task_project_members_list').on('change', function(evt, params) {
	var selected_vals = '';
    if(params.selected)
    {
    	selectedAssignees.push(params.selected);
    } else if (params.deselected) {
		idx = selectedAssignees.indexOf(params.deselected);
		if (selectedAssignees[idx] == params.deselected)
			selectedAssignees.splice(idx,1);
    }
    $.each(selectedAssignees,function(index,value) 
    	{
    		selected_vals += value + ','; 
		});
	$("#Task_task_assignees").val(selected_vals);
		
});
</script>