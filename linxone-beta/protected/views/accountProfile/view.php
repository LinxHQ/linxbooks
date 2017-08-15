<?php
/* @var $this AccountProfileController */
/* @var $model AccountProfile */

$this->breadcrumbs=array(
	'Account Profiles'=>array('index'),
	$model->account_profile_id,
);

$this->menu=array(
	array('label'=>'List AccountProfile', 'url'=>array('index')),
	array('label'=>'Create AccountProfile', 'url'=>array('create')),
	array('label'=>'Update AccountProfile', 'url'=>array('update', 'id'=>$model->account_profile_id)),
	array('label'=>'Delete AccountProfile', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->account_profile_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AccountProfile', 'url'=>array('admin')),
);
?>

<h1>View AccountProfile #<?php echo $model->account_profile_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'account_profile_id',
		'account_id',
		'account_profile_surname',
		'account_profile_given_name',
		'account_profile_preferred_display_name',
	),
)); ?>
