<?php
/* @var $this WikiPageController */
/* @var $model WikiPage */

$project = Project::model()->findByPk($project_id);

if ($project && $project->project_id > 0)
{
	echo '<div id="project-name-container" class="container-header">';
	echo '<h3>';
	echo Utilities::workspaceLink(
			$project->project_name,
			array(
					'project/view',
					'id' => $project->project_id,
					'tab' => $model->wiki_page_is_home ? 'wikihome' : 'wiki',
            )
	);
	echo '</h3>';
	echo '</div><br/><br/>';
}
?>
<div style="display: table">

<?php $this->widget('bootstrap.widgets.TbButton', 
    		array('buttonType'=>'link',
				//'ajaxOptions' => array('update' => '#wiki-content', 'id' => 'ajax-link' . uniqid()),
				'htmlOptions' => array('live' => false, 'data-workspace' => 1), 
				//'linkOptions' => array(),
				'url' => array('wikiPage/view', 'id' => $model->wiki_page_id),
				'type'=>'', 
				'label'=>'Back to View',
			)); ?>
<div style="margin: 10px; display: inline" id="wiki-page-form-auto-save-message-top"></div>
</div>

<?php echo $this->renderPartial('_form', 
		array('model'=>$model,
			'attachments'=>$attachments,
			'project_id' => $project_id, 
			//'project_name' => $project_name,
			'is_category' => $is_category,
			'is_template' => $is_template,
			'page_tree' => $page_tree,
			'update' => YES)); 
?>