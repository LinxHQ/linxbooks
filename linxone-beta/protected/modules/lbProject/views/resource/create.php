<?php
/* @var $this ResourceController */
/* @var $model Resource */

$project = Project::model()->findByPk($project_id);

if ($project && $project->project_id > 0)
{
	echo '<div id="project-name-container" class="container-header">';
	echo '<h3>';
	echo Utilities::workspaceLink(
			$project->project_name, 
			CHtml::normalizeUrl($project->getProjectURL()).'?tab=wiki'
			);
	echo '</h3>';
	echo '</div><br/><br/>';
}
?>

<h4>New Link</h4>

<?php echo $this->renderPartial('_form', 
		array('model'=>$model,'project_id'=>$project_id)); ?>