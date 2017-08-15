<?php
/* @var $this ProcessChecklistItemRelController */
/* @var $model ProcessChecklistItemRel */

$this->breadcrumbs=array(
	'Process Checklist Item Rels'=>array('index'),
	$model->pcir_id,
);

$this->menu=array(
	array('label'=>'List ProcessChecklistItemRel', 'url'=>array('index')),
	array('label'=>'Create ProcessChecklistItemRel', 'url'=>array('create')),
	array('label'=>'Update ProcessChecklistItemRel', 'url'=>array('update', 'id'=>$model->pcir_id)),
	array('label'=>'Delete ProcessChecklistItemRel', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->pcir_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ProcessChecklistItemRel', 'url'=>array('admin')),
);
?>

<h1>View ProcessChecklistItemRel #<?php echo $model->pcir_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'pcir_id',
		'pc_id',
		'pcir_name',
		'pcir_order',
		'pcir_entity_type',
		'pcir_entity_id',
		'pcir_status',
		'pcir_status_update_by',
	),
)); ?>
