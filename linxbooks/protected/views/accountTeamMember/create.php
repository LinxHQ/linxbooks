<?php
/* @var $this AccountTeamMemberController */
/* @var $model AccountTeamMember */

$this->breadcrumbs=array(
	'Account Team Members'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List AccountTeamMember', 'url'=>array('index')),
	array('label'=>'Manage AccountTeamMember', 'url'=>array('admin')),
);
?>

<h1>Create AccountTeamMember</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>