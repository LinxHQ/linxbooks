<?php 
/* @var $this TaskController -- DO NOT USE THIS */
/* @var $comment TaskComment */
/* @var $task Task */
/* @var $project Project */
/* @var $form CActiveForm */
/* @var $task_id Task::id */
/* @var $replies array of replies TaskComment */
/* @var $task_comment_documents Array of documents, indexed by task_comment_id */
/* @var $is_reply YES or NO */

// get task model if not available
if (!isset($task))
{
	$task = Task::model()->findByPk($comment->task_id);
}

// get project model if not available
if (!isset($project))
{
	$project = Project::model()->findByPk($task->project_id);
}

if (isset($debug)) echo $debug;
$new_reply_ajax_link = CHtml::ajaxLink(
		'Click to Reply',
		array('taskComment/create'
				, 'task_id' => $comment->task_id
				, 'task_comment_id' => $comment->task_comment_id
				, 'is_reply' => 1
				, 'ajax' => 1), // Yii URL
		array('update' => '#comment-thread-reply-form-' . $comment->task_comment_id), // jQuery selector
		array('id' => 'ajax-id-'.uniqid(), 'class' => 'blur-summary')
);
?>
<div id="comment-thread-<?php echo $comment->task_comment_id; ?>" class="comment-root-<?php echo $comment->task_comment_id; ?> comment-container" 
	style="height: auto; padding-bottom: 5px;">

		<div id="comment-root-<?php echo $comment->task_comment_id; ?>" class="comment-container" style="width: 100%;">
			<?php
			$this->renderPartial("/taskComment/_view", array(
						'task' => $task,
						'project' => $project,
						'comment' => $comment, 
						'replies'=>isset($replies) ? $replies : array(),
						'task_comment_documents' => (isset($task_comment_documents) ? $task_comment_documents: array())));
			?>
		</div>
<?php 
// if this has no parent, which means it is a parent, then allow showing replies and form
if ($comment->task_comment_parent_id == 0)
{
?>

	<div id="comment-reply-thread-<?php echo $comment->task_comment_id; ?>" style="padding-left: 40px;">
		<?php
		/**
		 * Thread goes here
		 * by default lazy load only first 5
		 */
		if (isset($replies)) 
		{
			foreach ($replies as $a_reply)
			{
				echo '<div class="comment-container" id="reply-container-' . $a_reply->task_comment_id . '">';
				$this->renderPartial("/taskComment/_view", array(
						'comment' => $a_reply,
						'task_comment_documents' => (isset($task_comment_documents) ? $task_comment_documents: array())));
				echo '</div>';
			}
		}
		// end replies thread
		?>
	</div>
	<div id="new-reply-form-link-holder-<?php echo $comment->task_comment_id; ?>" style="display: none">
	<?php 
	if ($task->task_status != TASK_STATUS_COMPLETED && !$project->isArchived())
	{
		echo $new_reply_ajax_link;
	}
	?>
	</div>
	
	<?php
	/**
	 * Reply form
	 */
	echo '<div id="comment-thread-reply-form-'. $comment->task_comment_id .'" class="" style="margin-left: 40px;">';
	if (isset($replies) && count($replies))
	{
		echo $new_reply_ajax_link;
		
	} // end if showing reply AT THE BOTTOM OF THREAD, if this parent comment has replies
	echo '</div>'; // #comment-thread-reply-form-<task_comment_id>
} // end if this is a parent
?>
</div> <!-- End div #comment -->
