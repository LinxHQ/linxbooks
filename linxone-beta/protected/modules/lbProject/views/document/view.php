<?php
/* @var $this DocumentController */
/* @var $model Documents */

$this->breadcrumbs=array(
	'Documents'=>array('index'),
	$model->document_id,
);

$this->menu=array(
	array('label'=>'List Documents', 'url'=>array('index')),
	array('label'=>'Create Documents', 'url'=>array('create')),
	array('label'=>'Update Documents', 'url'=>array('update', 'id'=>$model->document_id)),
	array('label'=>'Delete Documents', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->document_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Documents', 'url'=>array('admin')),
);
?>

<h1>View Documents #<?php echo $model->document_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'document_id',
		'document_real_name',
		'document_encoded_name',
		'document_description',
		'document_date',
		'document_revision',
		'document_root_revision_id',
		'document_owner_id',
		'document_parent_id',
		'document_parent_type',
	),
)); ?>
