<?php
/* @var $this VendorController */
/* @var $model LbVendor */

$this->breadcrumbs=array(
	'Lb Vendors'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List LbVendor', 'url'=>array('index')),
	array('label'=>'Create LbVendor', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#lb-vendor-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Lb Vendors</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'lb-vendor-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'lb_record_primary_key',
		'lb_vendor_supplier_id',
		'lb_vendor_supplier_address',
		'lb_vendor_supplier_attention_id',
		'lb_vendor_no',
		'lb_vendor_category',
		/*
		'lb_vendor_date',
		'lb_vendor_notes',
		'lb_vendor_subject',
		'lb_vendor_status',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
