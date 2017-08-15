<?php
/* @var $this NotificationController */
/* @var $model Notification */

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'linxcircle-app-top-notification-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'notification_id',
		'notification_parent_id',
		'notification_parent_type',
		'notification_created_date',
		'notification_status',
		'notification_sender_account_id',
		/*
		'notification_receivers_account_ids',
		'notification_hash',
		'notification_excerpt',
		'notification_subject',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
