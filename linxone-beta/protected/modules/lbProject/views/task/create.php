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

$project_name_link = Utilities::workspaceLink($project_name, array('project/view', 
		'id' => $project_id));

/**CHtml::ajaxLink(
	$project_name,
	array('project/view', 'id' => $project_id), // Yii URL
	array('update' => '#content'), // jQuery selector
	array('id' => 'ajax-id-'.uniqid())
);**/
?>

<div id="project-name-container" class="container-header">
	<h3><?php echo $project_name_link; ?></h3>
</div>
<h4>New Task</h4>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'project_id' => $project_id)); ?>