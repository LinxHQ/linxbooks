<?php
/* @var $this ProjectMemberController */
/* @var $model ProjectMember */

if (isset($project_id))
{
	$project = Project::model()->findByPk($project_id);
	if ($project)
	{
		$project_name_link = Utilities::workspaceLink($project->project_name, array('project/view',
				'id' => $project_id));
		echo "<h3>$project_name_link</h3>";
	}
}
?>

<h4>Add Members</h4>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'project_id' => isset($project_id) ? $project_id : 0)); ?>