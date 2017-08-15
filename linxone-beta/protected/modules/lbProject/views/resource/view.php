<?php
/* @var $this ResourceController */
/* @var $model Resource */

if ($model->project_id > 0)
{
	$project = Project::model()->findByPk($model->project_id);

	// print header
	Utilities::renderPartial($this, "//project/_project_header",
	array('project_id' => $model->project_id, 'return_tab' => 'wiki'));

	echo '<br/><br/>';
}
?>

<h4>Link <?php echo $model->resource_url; ?></h4>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'resource_id',
		//'account_subscription_id',
		'resource_url',
		'resource_description',
		'resource_created_by',
		'resource_created_date',
		'resource_space',
	),
)); ?>
