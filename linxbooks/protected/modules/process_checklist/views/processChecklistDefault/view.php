<?php
/* @var $this ProcessChecklistDefaultController */
/* @var $model ProcessChecklistDefault */

$this->breadcrumbs=array(
	'Process Checklist Defaults'=>array('index'),
	$model->pcdi_id,
);

$this->menu=array(
	array('label'=>'List ProcessChecklistDefault', 'url'=>array('index')),
	array('label'=>'Create ProcessChecklistDefault', 'url'=>array('create')),
	array('label'=>'Update ProcessChecklistDefault', 'url'=>array('update', 'id'=>$model->pcdi_id)),
	array('label'=>'Delete ProcessChecklistDefault', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->pcdi_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ProcessChecklistDefault', 'url'=>array('admin')),
);
?>

<h1>View ProcessChecklistDefault #<?php echo $model->pcdi_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'pcdi_id',
		'pc_id',
		'pcdi_name',
		'pcdi_order',
	),
)); ?>
