<?php
/* @var $this WikiPageController */
/* @var $model WikiPage */
/* @var $project_id integer */

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
/**
echo CHtml::ajaxLink(
	$project_name,
	array('project/view', 'id' => $project_id), // Yii URL
	array('update' => '#content'), // jQuery selector
	array('id' => 'ajax-id-'.uniqid())
); **/
?>

<div style="display: table">

	<?php 
	if ($is_category == YES)
	{
		echo '<h4 style="display: inline">New Category</h4>';
	} else if ($is_template == YES) {
		echo '<h4 style="display: inline">New Template</h4>';
	} else {
		echo '<h4 style="display: inline">New Page</h4>';
	}
	?>
	<br/><br/>
	<div class="wiki-action-submenu" style="margin-left: 15px; display: inline" id="wiki-page-form-auto-save-message-top"></div>
</div>
<?php echo $this->renderPartial('_form', array(
		'model'=>$model, 
		'project_id' => $project_id, 
		'project_name' => $project_name,
		'is_category' => $is_category,
		'is_template' => $is_template,
		'wiki_page_parent_id' => isset($wiki_page_parent_id) ? $wiki_page_parent_id : 0,
		'page_tree' => $page_tree)); ?>