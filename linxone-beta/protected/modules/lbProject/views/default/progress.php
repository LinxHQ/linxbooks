<?php
/* @var $this ProjectController */
/* @var $results array of progress */
/* @var $outstanding_todos array of task_comment marked as incompleted todos */

/**
echo '<div id="progress-nav-container" style="width: 80%; margin: 0 auto;">';
$this->widget('bootstrap.widgets.TbMenu', array(
		'type'=>'pills', // '', 'tabs', 'pills' (or 'list')
		'stacked'=>false, // whether this is a stacked menu
		'items'=>array(
				array('label'=>'Activity', 
						'url'=>'#', 
						'linkOptions'=>array('onclick'=>'$("#progress-container").show(); $("#progress-outstanding-todos").hide(); return false;')),
				array('label'=>'To-do', 
						'url'=>'#',
						'linkOptions'=>array('onclick'=>'$("#progress-container").hide(); $("#progress-outstanding-todos").show(); return false;')),
		),
		'htmlOptions'=>array()
));
echo '</div>';
**/

/*
 * results structure:
 * $results[$date_str][$project->project_id]['project'] = model project
 * $results[$date_str][$project->project_id]['task_comments'] = array of task comment models
 * $results[$date_str][$project->project_id]['issue_comments'] = ...
 * $results[$date_str][$project->project_id]['implementation_comments'] = ...
 */

$float = '';
echo '<div id="progress-container" style="width: 80%; margin: 0 auto;">';
foreach ($results as $date_str => $project_array)
{
	// print day
	if (count($project_array))
	{
		echo '<div id="progress-day-container" class="progress-day-container">';
		//echo '<center><h4><a>' . date('d M Y', strtotime($date_str)) . '</a></h4></center><hr/>' ;
		echo '<center><h4><a>' . Utilities::displayFriendlyDate($date_str) . '</a></h4></center><hr/>' ;
		
		// print each project
		foreach ($project_array as $project_id => $activities_array)
		{
			// print activities
			if (count($activities_array))
			{
				if ($float == '') $float = 'left';
				else if ($float == 'left') $float = 'right';
				else if ($float == 'right') $float = 'left';
				
				echo '<div id="project-progress-container" style="display: block; content: \'\'; clear: both;">';
				echo '<div class="progress-tile-'. $float .'">';
				echo '<h4 class="project-name">' . 
					Utilities::workspaceLink($activities_array['project']->project_name,
							$activities_array['project']->getProjectURL()) . '</h4>';
				
				// TASKS COMMENTS
				if (isset($activities_array['task_comments']))
				{
					$this->widget('bootstrap.widgets.TbBadge', array(
							'type'=>'success', // 'success', 'warning', 'important', 'info' or 'inverse'
							'label'=>'Task Activities',
					));
					echo '<div style="height: 20px;">&nbsp;</div>';
					foreach ($activities_array['task_comments'] as $task_comment)
					{
						echo '<div class="progress-activity-container">';
						
						// show description
						echo '<div class="progress-activity-description-' . $float .'">';
						echo '<table border="0" cellspacing="2" cellpadding="2" width="100%">';
						echo '<tr>';
						echo '<td valign="top" width="50">';
						echo AccountProfile::model()->getProfilePhoto($task_comment->task_comment_owner_id);
						echo '</td>'; // end profile photo
						
						echo '<td valign="top">';
						echo '<b>';
						echo AccountProfile::model()->getShortFullName($task_comment->task_comment_owner_id); 
						echo ' commented on ';
						echo Utilities::workspaceLink($task_comment->task->task_name,
								Task::model()->getTaskURL($task_comment->task_id));
						echo '</b>';
						
						echo '<br/>';
						echo Utilities::getSummary($task_comment->task_comment_content, true, 300) . '<br/>';
						
						// show more link for comment that has parent
						if ($task_comment->task_comment_parent_id)
						{
							$popover_id = "task-comment-more-popover-" . $task_comment->task_comment_id;

							echo '<div id="wrapper-' . $popover_id . '">';
							echo CHtml::link(
									'More',
									'#',
									array(
											'class'=>'blur',
											'id'=>$popover_id,
											'rel'=>'popover',
											'data-title'=>'More information',
											'data-is-visible'=>'no',
											'data-html'=>true,
											//'data-content'=>'...',
											'onclick' =>'
												if ($("#' . $popover_id.'").attr("data-is-visible")=="no")
													$.get("'.Yii::app()->createUrl("taskComment/birdview", array('id'=>$task_comment->task_comment_parent_id)).'", function(data){
														$("#' . $popover_id.'").popover({content: data}).popover("show");
														$("#wrapper-' . $popover_id . ' .popover").css("width", "400px");
														$("#' . $popover_id.'").attr("data-is-visible", "yes");
													});
												else
													$("#' . $popover_id.'").attr("data-is-visible", "no");
												return false;',
									)
							);
							echo "</div>";
						}
						
						echo '</td>'; // end description text
						echo '</tr>';
						echo '</table>';
						
						echo '</div>'; // end .progress-activity-description-
						
						// show time
						echo '<div class="progress-activity-time-' . $float .'">';
						echo Utilities::displayFriendlyTime($task_comment->task_comment_last_update);
						//echo date('h:i a', strtotime($task_comment->task_comment_last_update));
						echo '</div>'; // end .progress-activity-time-
						
						echo '</div>'; // end .progress-activity-container
					}
				}
				
				// ISSUES
				if (isset($activities_array['issue_comments']))
				{
					$this->widget('bootstrap.widgets.TbBadge', array(
							'type'=>'warning', // 'success', 'warning', 'important', 'info' or 'inverse'
							'label'=>'Issue Activities',
					));
					echo '<div style="height: 20px;">&nbsp;</div>';
					foreach ($activities_array['issue_comments'] as $issue_comment)
					{
						echo '<div class="progress-activity-container">';
				
						// show description
						echo '<div class="progress-activity-description-' . $float .'">';
						echo '<table border="0" cellspacing="2" cellpadding="2" width="100%">';
						echo '<tr>';
						echo '<td valign="top" width="50">';
						echo AccountProfile::model()->getProfilePhoto($issue_comment->issue_comment_owner_id);
						echo '</td>'; // end profile photo
				
						echo '<td valign="top">';
						echo '<b>';
						echo AccountProfile::model()->getShortFullName($issue_comment->issue_comment_owner_id);
						echo ' commented on ';
						echo Utilities::workspaceLink($issue_comment->issue->issue_name,
								Issue::model()->getIssueURL($issue_comment->issue_id));
						echo '</b>';
				
						echo '<br/>';
						echo Utilities::getSummary($issue_comment->issue_comment_content, true, 300) . '<br/>';
						echo '</td>'; // end description text
						echo '</tr>';
						echo '</table>';
						echo '</div>'; // end .progress-activity-description-
				
						// show time
						echo '<div class="progress-activity-time-' . $float .'">';
						echo Utilities::displayFriendlyTime($issue_comment->issue_comment_last_update);
						//echo date('h:i a', strtotime($issue_comment->issue_comment_last_update));
						echo '</div>'; // end .progress-activity-time-
				
						echo '</div>'; // end .progress-activity-container
					}
				}
				echo '</div>';
				echo '</div>'; // end #project-progress-container
			}
		}
		echo '</div>';
	}
}
echo '</div>'; //end #progress-container

// TO DO LIST
echo '<div id="progress-outstanding-todos" style="display:none; width: 80%; margin: 0 auto;">';
echo '<table class="table">';
foreach ($outstanding_todos as $comment)
{
	echo '<tr>';
	echo '<td>';
	echo '<strong>'.Utilities::workspaceLink($comment->task->project->project_name, 
			$comment->task->project->getProjectURL())
		. '</strong>';
	echo '<br/>';
	echo '<i class="icon-tasks"></i>';
	echo Utilities::workspaceLink($comment->task->task_name,
			$comment->task->getTaskURL());
	echo ':&nbsp;';
	echo $comment->task_comment_content;
	echo '</td>';
	echo '</tr>';
}
echo '</table>'; // end todo table
echo '</div>'; // end todo list div 
// end TO DO LIST