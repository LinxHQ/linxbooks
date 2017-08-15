<?php
/* @var $this ProjectController */
/* @var $results array of progress */

/*
 * results structure:
 * $results[$date_str][$project->project_id]['project'] = model project
 * $results[$date_str][$project->project_id]['task_comments'] = array of task comment models
 * $results[$date_str][$project->project_id]['issue_comments'] = ...
 * $results[$date_str][$project->project_id]['implementation_comments'] = ...
 */

$float = '';
echo '<div id="progress-container">';
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
				echo '<div id="project-progress-container" style="display: block; content: \'\'; clear: both;">';
				echo '<div class="progress-tile">';
				echo '<h4 class="project-name">' . 
					Utilities::workspaceLink($activities_array['project']->project_name,
							$activities_array['project']->getProjectURL()) . '</h4>';
				
				// TASKS COMMENTS
				if (isset($activities_array['task_comments']))
				{
					echo '<h4>Task Activities</h4>';
					echo '<div style="height: 20px;">&nbsp;</div>';
					foreach ($activities_array['task_comments'] as $task_comment)
					{
						echo '<div class="progress-activity-container">';
						
						// show description
						echo '<div class="progress-activity-description-right">';
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
						echo ' at ';
						echo Utilities::displayFriendlyTime($task_comment->task_comment_last_update);
						
						echo '<br/>';
						echo Utilities::getSummary($task_comment->task_comment_content, true, 300);
						echo '</td>'; // end description text
						echo '</tr>';
						echo '</table>';
						
						echo '</div>'; // end .progress-activity-description-
						
						echo '</div>'; // end .progress-activity-container
					}
				}
				
				// ISSUES
				if (isset($activities_array['issue_comments']))
				{
					echo '<h4>Issue Activities</h4>';
					echo '<div style="height: 20px;">&nbsp;</div>';
					foreach ($activities_array['issue_comments'] as $issue_comment)
					{
						echo '<div class="progress-activity-container">';
				
						// show description
						echo '<div class="progress-activity-description-right">';
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
						echo ' at ' . Utilities::displayFriendlyTime($issue_comment->issue_comment_last_update);
						
						echo '<br/>';
						echo Utilities::getSummary($issue_comment->issue_comment_content, true, 300) . '<br/>';
						echo '</td>'; // end description text
						echo '</tr>';
						echo '</table>';
						echo '</div>'; // end .progress-activity-description-
				
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