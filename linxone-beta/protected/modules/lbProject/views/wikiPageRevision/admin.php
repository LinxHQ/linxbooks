<?php
/* @var $this WikiPageRevisionController */
/* @var $model WikiPageRevision */

$this->breadcrumbs=array(
	'Wiki Page Revisions'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List WikiPageRevision', 'url'=>array('index')),
	array('label'=>'Create WikiPageRevision', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#wiki-page-revision-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Wiki Page Revisions</h1>

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
	'id'=>'wiki-page-revision-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'wiki_page_revision_id',
		'wiki_page_id',
		'wiki_page_revision_content',
		'wiki_page_revision_date',
		'wiki_page_revision_updated_by',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
