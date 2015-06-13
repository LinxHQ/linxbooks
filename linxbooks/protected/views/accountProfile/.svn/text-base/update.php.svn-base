<?php
/* @var $this AccountProfileController */
/* @var $model AccountProfile */

$this->breadcrumbs=array(
	'Account Profiles'=>array('index'),
	$model->account_profile_id=>array('view','id'=>$model->account_profile_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List AccountProfile', 'url'=>array('index')),
	array('label'=>'Create AccountProfile', 'url'=>array('create')),
	array('label'=>'View AccountProfile', 'url'=>array('view', 'id'=>$model->account_profile_id)),
	array('label'=>'Manage AccountProfile', 'url'=>array('admin')),
);
?>

<h3>Update Profile <?php echo $model->getShortFullName(); ?></h3>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>