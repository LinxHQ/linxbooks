<?php
$this->breadcrumbs=array(
	'User Subscriptions'=>array('index'),
	'Manage',
);

LBApplicationUI::newButton(Yii::t('lang','New User Subcription'), array(
        'url'=>$this->createUrl('/paypal/userSubscription/create'),
));
echo "<br><br>";
?>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'user-subscription-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
                array(
                    'name'=>'user_id',
                    'type'=>'raw',
                    'value'=>'AccountProfile::model()->getFullName($data->user_id)',
                ),
		array(
                    'name'=>'subscription_id',
                    'type'=>'raw',
                    'value'=>'$data->subcription->subscription_value."$/".$data->subcription->subscription_name',
                ),
		'date_from',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
