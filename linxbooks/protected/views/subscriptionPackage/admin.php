<?php
/* @var $this SubscriptionPackageController */
/* @var $model SubscriptionPackage */

$this->breadcrumbs=array(
	'Subscription Packages'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List SubscriptionPackage', 'url'=>array('index')),
	array('label'=>'Create SubscriptionPackage', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#subscription-package-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Subscription Packages</h1>

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
	'id'=>'subscription-package-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'subscription_package_id',
		'subscription_package_name',
		'subscription_package_status',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
