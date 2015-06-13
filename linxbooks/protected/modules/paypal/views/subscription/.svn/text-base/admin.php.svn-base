<?php
$this->breadcrumbs=array(
	'Subscriptions'=>array('index'),
	'Manage',
);

//$this->menu=array(
//	array('label'=>'List Subscription', 'url'=>array('index')),
//	array('label'=>'Create Subscription', 'url'=>array('create')),
//);

LBApplicationUI::newButton(Yii::t('lang','New Subcription'), array(
        'url'=>$this->createUrl('/paypal/subscription/create'),
));
echo "<br><br>";
?>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'subscription-grid',
	'dataProvider'=>$model->search(),
	'columns'=>array(
		'subscription_id',
		'subscription_name',
		'subscription_cycle',
		'subscription_value',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
