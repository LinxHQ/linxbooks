<?php
/* @var $this AccountProfileController */
/* @var $model AccountProfile */

$this->breadcrumbs=array(
	'Account Profiles'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List AccountProfile', 'url'=>array('index')),
	array('label'=>'Manage AccountProfile', 'url'=>array('admin')),
);
?>

<h1>Create AccountProfile</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>