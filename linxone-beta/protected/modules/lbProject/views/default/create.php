<?php
/* @var $this ProjectController */
/* @var $model Project */

if (!Permission::checkPermission($model, PERMISSION_PROJECT_CREATE))
{
	return false;
}
?>

<h4>Create Project</h4>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>