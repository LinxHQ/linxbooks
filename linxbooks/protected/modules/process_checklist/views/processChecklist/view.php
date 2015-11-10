<?php
/* @var $this ProcessChecklistController */
/* @var $model ProcessChecklist */

$this->breadcrumbs=array(
	'Process Checklists'=>array('index'),
	$model->pc_id,
);

$this->menu=array(
	array('label'=>'List ProcessChecklist', 'url'=>array('index')),
	array('label'=>'Create ProcessChecklist', 'url'=>array('create')),
	array('label'=>'Update ProcessChecklist', 'url'=>array('update', 'id'=>$model->pc_id)),
	array('label'=>'Delete ProcessChecklist', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->pc_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ProcessChecklist', 'url'=>array('admin')),
);
?>

<h1>View ProcessChecklist #<?php echo $model->pc_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'pc_id',
		'subcription_id',
		'pc_name',
		'pc_create_date',
		'pc_last_update_by',
		'pc_last_update',
	),
)); ?>
