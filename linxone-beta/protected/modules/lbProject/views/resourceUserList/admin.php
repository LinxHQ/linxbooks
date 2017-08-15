<?php
/* @var $this ResourceUserListController */
/* @var $model ResourceUserList */

?>

<h4>Manage iWiki Lists</h4>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'resource-user-list-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'resource_user_list_id',
		//'account_subscription_id',
		'resource_user_list_name',
		//'resource_user_list_created_by',
		'resource_user_list_created_date',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
