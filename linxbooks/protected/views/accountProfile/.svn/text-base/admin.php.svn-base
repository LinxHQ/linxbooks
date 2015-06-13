<?php
/* @var $this AccountProfileController */
/* @var $model AccountProfile */

$this->breadcrumbs=array(
	'Account Profiles'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List AccountProfile', 'url'=>array('index')),
	array('label'=>'Create AccountProfile', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#account-profile-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Account Profiles</h1>

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
	'id'=>'account-profile-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'account_profile_id',
		'account_id',
		'account_profile_surname',
		'account_profile_given_name',
		'account_profile_preferred_display_name',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
