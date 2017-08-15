<?php
/* @var $this ResourceController */
/* @var $model Resource */
/* @var $form CActiveForm */

// Chosen plugin
echo '<link href="'.Yii::app()->baseUrl.'/js/chosen/chosen.min.css" rel="stylesheet">';
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/chosen/chosen.jquery.min.js', CClientScript::POS_BEGIN);
// end chosen plugin


$form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'resource-form',
	'enableAjaxValidation'=>false,
)); 

?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php 
	// subscription id
	echo $form->hiddenField($model,'account_subscription_id',
		array('value'=>Utilities::getCurrentlySelectedSubscription()));

	// project id
	if (isset($project_id) && $project_id > 0)
	{
		echo $form->hiddenField($model,'project_id', array('value' => $project_id));
	}
 	?>
	
	<?php echo $form->textFieldRow($model,'resource_title',array('style'=>'width: 400px;','maxlength'=>255)); ?>
	<?php echo $form->textFieldRow($model,'resource_url',array('style'=>'width: 400px;','maxlength'=>255)); ?>
	<?php echo $form->error($model,'resource_url'); ?>

	<?php 
	echo $form->textAreaRow($model,'resource_description',
			array('style'=>'width: 400px; height: 100px;','maxlength'=>255)); ?>

	<?php echo $form->radioButtonListRow($model,'resource_space',
			array(Resource::RESOURCE_SPACE_PRIVATE=>'Private (only available to your company)',
				Resource::RESOURCE_SPACE_PUBLIC=>'Public')); 

	// SELECT LISTs
	$resource_lists = ResourceUserList::model()->getLists(Utilities::getCurrentlySelectedSubscription(),'modelArray');
	echo $form->labelEx($model, 'resource_assigned_lists');
	// prepare selected item of the dropdown box if any
	$resource_assigned_lists_array = explode(',', $model->resource_assigned_lists);
	$selected_items = array();
	foreach ($resource_assigned_lists_array as $assigned_list_id)
	{
		$selected_items[$assigned_list_id] = array('selected'=>'selected');
	}
	echo CHtml::dropDownList('resource_assigned_lists', 0,
				CHtml::listData($resource_lists, 'resource_user_list_id', 'resource_user_list_name'),
				array('id'=>'resource_assigned_lists', 'multiple'=>'true','class'=>'span8',
					'options'=> $selected_items));
	echo $form->hiddenField($model, 'resource_assigned_lists');
	 
	echo '<br/>';
	echo '<div class="form-actions">';
	$this->widget('bootstrap.widgets.TbButton',
			array('buttonType' => 'submit',
					'htmlOptions' => array('live' => false),
					'type' => 'primary',
					'label' => 'Submit',
			));
	//echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); 
	echo '</div>';
	?>

<?php $this->endWidget(); ?>
<script language="javascript">
var selectedLists = new Array(<?php echo $model->resource_assigned_lists; ?>);
$("#resource_assigned_lists").chosen();
$('#resource_assigned_lists').on('change', function(evt, params) {
	var selected_vals = '';
    if(params.selected)
    {
    	selectedLists.push(params.selected);
    } else if (params.deselected) {
		idx = selectedLists.indexOf(parseInt(params.deselected));
		if (selectedLists[idx] == params.deselected)
			selectedLists.splice(idx,1);
    }
    $.each(selectedLists,function(index,value) 
    	{
    		selected_vals += value + ','; 
		});
	$("#Resource_resource_assigned_lists").val(selected_vals);
});
<?php 
echo $model->isNewRecord ? '$("#Resource_resource_space_0").attr("checked", "checked");' : '';
?>
</script>