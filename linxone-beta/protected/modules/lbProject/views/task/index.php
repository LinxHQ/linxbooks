<?php
/* @var $this TaskController */
/* @var $model Task */
?>

<div id="project-name-container" class="container-header">
<h3><?php 
$project = Project::model()->findByPk($model->project_id);
echo Utilities::workspaceLink(
	($project ? $project->project_name : '-'),
	array('project/view', 'id' => $model->project_id), // Yii URL
	array('id' => 'ajax-id-'.uniqid())
); ?></h3>
</div>
<br/><br/>
<h4>Browse Tasks</h4>

<?php 
// Button groups for switching between statuses
$task_status_list = array(TASK_STATUS_ACTIVE => 'Active', TASK_STATUS_COMPLETED => 'Done');

// radio button for status selection
$status_btns = array();
foreach ($task_status_list as $key => $value)
{
	$this_btn = array();
	$this_btn['label'] = $value;
	$this_btn['buttonType'] = 'ajaxButton';
	$this_btn['ajaxOptions'] = array(
			'success' => 'function(data){
				$("#content").html(data);
				resetWorkspaceClickEvent("content");
			}', 
			'id' => 'ajax-link' . uniqid());
	$this_btn['htmlOptions'] = array('live' => false);
	$this_btn['url'] = array('task/index',
			'status' => $key, 'project_id' => $project->project_id, 'ajax' => 1);
	if (isset($task_status))
	{
		if ($task_status == $key)
			$this_btn['htmlOptions'] = array('class' => 'btn active');
	}
	$status_btns[] = $this_btn;
}

echo '<center>';
$this->widget('bootstrap.widgets.TbButtonGroup', array(
		'type' => '',
		'toggle' => 'radio', // 'checkbox' or 'radio'
		'buttons' => $status_btns,
));
echo '</center>';

// Task Grid
$this->widget('bootstrap.widgets.TbGridView', array(
		'type' => 'striped',
		'dataProvider' => $model->search(),
		'id' => 'browse-tasks-grid-' . (isset($_GET['_']) ? $_GET['_'] : uniqid()),
		'ajaxUpdate' => true,
		'afterAjaxUpdate' => 'function(id, data){resetWorkspaceClickEvent("content");}',
		'template' => '{items}{pager}',
		'htmlOptions' => array('style' => 'padding-top: 0px;'),
		'columns'=>array(
				//array('name'=>'id', 'header'=>'#'),
				array(
						//'name' => 'task_name',
						'name' => '',
						'header' => 'Name',
						'type' => 'raw',
						'value' => '"<div style=\'display: inline; width: 45px; float: left;\'>". 
								(isset($data->comments[0]->task_comment_owner_id) ? 
									AccountProfile::model()->getProfilePhoto($data->comments[0]->task_comment_owner_id) 
									: AccountProfile::model()->getProfilePhoto()) ."</div>" .
					"<div style=\'display: inline; width: auto;\'>" . CHtml::link(
						$data->task_name,
						array("task/view", "id" => $data->task_id),
						array("id" => "ajax-id-" . uniqid(), "data-workspace" => "1")) .
        			"<br/>" .
					"<span class=\'blur-summary\'>" . $data->getSummary()  . "</span></div>"',
				),
				array(
						'name' => 'task_last_commented_date',
						'header'=>'Last Activity',
						'type' => 'html',
						'htmlOptions' => array('width'=>'200px'),
						//'value' => '', // format time
						'sortable' => false),
),
));
/*
 * OLD code for task link
 array("onClick" => " {". CHtml::ajax(
								array(
										"url" => array("task/view", "id" => $data->task_id),
										"success" => "js: function(data){
											$(\'html, body\').animate({ scrollTop: 0 }, 600);
											$(\'#content\').html(data);
										}"),
								array("live" => false, "id"=> "ajax-id-" . uniqid())

						) . " return false; }"
 */