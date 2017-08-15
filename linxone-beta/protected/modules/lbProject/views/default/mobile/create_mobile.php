<?php
/* @var $this ProjectController */
/* @var $model Project */

if (!Permission::checkPermission($model, PERMISSION_PROJECT_CREATE))
{
	return false;
}
?>

<?php echo $this->renderPartial('mobile/_form_mobile', array('model'=>$model)); ?>