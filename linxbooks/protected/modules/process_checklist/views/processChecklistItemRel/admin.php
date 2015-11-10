<?php
/* @var $this ProcessChecklistItemRelController */
/* @var $model ProcessChecklistItemRel */

$this->breadcrumbs=array(
	'Process Checklist Item Rels'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List ProcessChecklistItemRel', 'url'=>array('index')),
	array('label'=>'Create ProcessChecklistItemRel', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#process-checklist-item-rel-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Process Checklist Item Rels</h1>

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

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'process-checklist-item-rel-grid',
	'dataProvider'=>$model->search(),
        'type' => 'striped bordered condensed',
	'filter'=>$model,
	'columns'=>array(
		'pcir_id',
		'pc_id',
		'pcir_name',
		'pcir_order',
		'pcir_entity_type',
		'pcir_entity_id',
		/*
		'pcir_status',
		'pcir_status_update_by',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
