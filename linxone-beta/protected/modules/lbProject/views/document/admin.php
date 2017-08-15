<?php
/* @var $this DocumentController */
/* @var $model Documents */

$this->breadcrumbs=array(
	'Documents'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Documents', 'url'=>array('index')),
	array('label'=>'Create Documents', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#documents-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Documents</h1>

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
	'id'=>'documents-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'document_id',
		'document_real_name',
		'document_encoded_name',
		'document_description',
		'document_date',
		'document_revision',
		/*
		'document_root_revision_id',
		'document_owner_id',
		'document_parent_id',
		'document_parent_type',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
