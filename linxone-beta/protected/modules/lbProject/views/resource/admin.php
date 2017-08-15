<?php
/* @var $this ResourceController */
/* @var $model Resource */

$project = Project::model()->findByPk($model->project_id);

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

<h4>Manage iWiki Links</h4>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'resource-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'resource_id',
		//'account_subscription_id',
		'resource_url',
		'resource_description',
		array(
			'type'=>'raw',
			'header'=>'Added by',
			'value'=>'AccountProfile::model()->getShortFullName($data->resource_created_by)'
		),
		//'resource_created_by',
		//'resource_created_date',
		/*
		'resource_space',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
