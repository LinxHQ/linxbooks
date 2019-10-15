<?php
/* @var $this CategoryController */
/* @var $model LbCatalogCategories */

$this->breadcrumbs=array(
	'Lb Catalog Categories'=>array('index'),
	$model->lb_record_primary_key,
);

$this->menu=array(
	array('label'=>'List LbCatalogCategories', 'url'=>array('index')),
	array('label'=>'Create LbCatalogCategories', 'url'=>array('create')),
	array('label'=>'Update LbCatalogCategories', 'url'=>array('update', 'id'=>$model->lb_record_primary_key)),
	array('label'=>'Delete LbCatalogCategories', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->lb_record_primary_key),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LbCatalogCategories', 'url'=>array('admin')),
);
?>

<h1>View LbCatalogCategories #<?php echo $model->lb_record_primary_key; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'lb_record_primary_key',
		'lb_category_name',
		'lb_category_description',
		'lb_category_status',
		'lb_category_created_date',
		'lb_category_created_by',
		'lb_category_parent',
	),
)); ?>
