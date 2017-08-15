<?php
/* @var $this WikiPageController */
/* @var $model WikiPage */

$this->breadcrumbs=array(
	'Wiki Pages'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List WikiPage', 'url'=>array('index')),
	array('label'=>'Create WikiPage', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#wiki-page-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Wiki Pages</h1>

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
	'id'=>'wiki-page-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'wiki_page_id',
		'account_subscription_id',
		'project_id',
		'wiki_page_title',
		'wiki_page_parent_id',
		'wiki_page_content',
		/*
		'wiki_page_tags',
		'wiki_page_date',
		'wiki_page_updated_by',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
