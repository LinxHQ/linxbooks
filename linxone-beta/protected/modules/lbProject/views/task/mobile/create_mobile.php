<?php
/* @var $this TaskController */
/* @var $model Task */

if (!isset($project_name) || $project_name == '')
{
	if (isset($project_id)){
		$project = Project::model()->findByPk($_GET['project_id']);
		$project_name = $project->project_name;
	}
}

?>

<h3><?php echo $project_name; ?></h3>

<?php echo $this->renderPartial('mobile/_form_mobile', array('model'=>$model, 'project_id' => $project_id)); ?>