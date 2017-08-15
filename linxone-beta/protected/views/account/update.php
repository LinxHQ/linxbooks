<?php
/* @var $this AccountController */
/* @var $model Account */

$this->breadcrumbs=array(
	'Accounts'=>array('index'),
	$model->account_id=>array('view','id'=>$model->account_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Account', 'url'=>array('index')),
	array('label'=>'Create Account', 'url'=>array('create')),
	array('label'=>'View Account', 'url'=>array('view', 'id'=>$model->account_id)),
	array('label'=>'Manage Account', 'url'=>array('admin')),
);
?>

<h3>Update Account <?php echo AccountProfile::model()->getShortFullName($model->account_id); ?></h3>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'accountProfileModel' => $accountProfileModel)); ?>