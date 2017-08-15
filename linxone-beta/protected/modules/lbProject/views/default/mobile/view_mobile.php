<?php
/* @var $this ProjectController */
/* @var $model Project */
/* @var $taskModel Task */
/* @var $issueModel Issue */
/* @var $implModel Implementation */
/* @var $documentModel Documents */

//echo '<h2>' . $model->project_name . '</h2>';
// PROJECT NAME AND LINK
$project = Project::model()->findByPk($model->project_id);
echo CHtml::link($project->project_name,
		$project->getProjectURL(),
		array(
				//'style'=>'color: #60a725; font-size: 18px; text-decoration: none;',
				'data-role'=>'button',
				'data-theme'=>'b',
				'data-icon'=>'back'));

//
// TASKS
//
$tasksCActiveDataProvider = $taskModel->search();
$tasksCActiveDataProvider->setPagination(false);
$active_tasks = $tasksCActiveDataProvider->getData();
echo '<ul data-role="listview" data-theme="a" data-inset="true">';
echo '<li data-role="list-divider" data-theme="a" ><h4>Tasks</h4><span class="ui-li-count">'.count($active_tasks).'</span></li>';
if (count($active_tasks))
{
	foreach ($active_tasks as $task)
	{
		echo '<li>';
		echo CHtml::link($task->task_name, $task->getTaskURL());
		$task_todos_count = TaskComment::model()->countTodos($task->task_id);
		if ($task_todos_count)
		{
			echo '<span class="ui-li-count">'.$task_todos_count.'</span>';
		}
		echo '</li>';
	}
} else {
	echo '<li>No active tasks</li>';
}
echo '<li data-icon="plus" data-iconpos="right" style="">'.
		CHtml::link('New Task', Task::model()->getCreateURL($model->project_id), array('style'=>'color: #61a62b; text-align: right;')) .'</li>';
echo '</ul>';
// end Tasks

// ISSUES
$issuesCActiveDataProvider = $issueModel->search();
$issuesCActiveDataProvider->setPagination(false);
$open_issues = $issuesCActiveDataProvider->getData();
echo '<ul data-role="listview" data-inset="true">';
echo '<li data-role="list-divider" data-theme="a"><h4>Issues</h4><span class="ui-li-count">'.count($open_issues).'</span></li>';
if (count($open_issues))
{
	foreach ($open_issues as $issue)
	{
		echo '<li>';
		echo CHtml::link($issue->issue_name, $issue->getIssueURL());
		echo '</li>';
	}
} else {
	echo '<li>No open issues</li>';
}
echo '<li data-icon="plus" data-iconpos="right">'.
		CHtml::link('New Issue', Issue::model()->getCreateURL($model->project_id), array('style'=>'color: #61a62b; text-align: right;')).'</li>';
echo '</ul>';

// IMPLEMENTATIONS
$implCActiveDataProvider = $implModel->search();
$implCActiveDataProvider->setPagination(false);
$pending_impl = $implCActiveDataProvider->getData();
echo '<ul data-role="listview" data-inset="true">';
echo '<li data-role="list-divider" data-theme="a"><h4>Implementations</h4><span class="ui-li-count">'.count($pending_impl).'</span></li>';
if (count($pending_impl))
{
	foreach ($pending_impl as $impl)
	{
		echo '<li>';
		echo CHtml::link($impl->implementation_title, $impl->getImplementationURL());
		echo '</li>';
	}
} else {
	echo '<li>No pending implementations</li>';
}
echo '<li data-icon="plus" data-iconpos="right">'.
		CHtml::link('New Implementation', Implementation::model()->getCreateURL(), array('style'=>'color: #61a62b; text-align: right;')).'</li>';
echo '</ul>';

// WIKIS
echo '<ul data-role="listview" data-inset="true">';
echo '<li data-role="list-divider" data-theme="a"><h4>Wiki</h4></li>';
echo '</ul>';