<?php
/* @var $this AccountSubscriptionController */
/* @var $model AccountSubscription */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#account-subscription-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h2>Manage Subscriptions</h2>

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
	'type' => 'striped',
	'dataProvider'=>$model->search(),
	'columns'=>array(
		'subscription_name',
		array(
                    'name'=>'account_id',
                    'type'=>'raw',
                    'value'=>'AccountProfile::model()->getFullName(1)',
                ),
		'account_subscription_start_date',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
                        'template'=>'{update}',
		),
	),
)); ?>
