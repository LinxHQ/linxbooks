<?php
/* @var $this SystemListItemController */
/* @var $model SystemListItem */

$this->breadcrumbs=array(
	'System List Items'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List SystemListItem', 'url'=>array('index')),
	array('label'=>'Create SystemListItem', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#system-list-item-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage System List Items</h1>

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
	'id'=>'system-list-item-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'system_list_item_id',
		'system_list_name',
		'system_list_item_name',
		'system_list_parent_item_id',
		'system_list_item_order',
		'system_list_item_active',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
