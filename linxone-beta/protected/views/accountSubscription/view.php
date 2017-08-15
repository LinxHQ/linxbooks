<?php
/* @var $this AccountSubscriptionController */
/* @var $model AccountSubscription */

?>

<h1>View AccountSubscription #<?php echo $model->account_subscription_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'account_subscription_id',
		'account_id',
		'account_subscription_package_id',
		'account_subscription_start_date',
		'account_subscription_end_date',
		'account_subscription_status_id',
	),
)); ?>
