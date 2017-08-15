<?php
/* @var $this ProjectController */
/* @var $model Project */

/**
$this->breadcrumbs=array(
	'Projects'=>array('index'),
	'Manage',
);**/

$this->menu=array(
	array('label'=>'Create Project', 'url'=>array('project/create'), 'ajax' => array('update' => '#content')),
	//array('label'=>'List Project', 'url'=>array('index'), 'ajax' => array('update' => '#content'))
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#project-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Projects</h1>

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<!--  div class="search-form" style="display:none">
<?php //$this->renderPartial('_search',array(
	//'model'=>$model,
//)); 
?>
</div--><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'project-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'project_id',
		'project_name',
		'project_owner_id',
		'project_start_date',
		'project_description',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
