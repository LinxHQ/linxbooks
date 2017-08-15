<?php
/* @var comment TaskComment ; */
/* @var	task_comment_replies array of replies TaskComment indexed by parent comment's ID */
/* @var task_id Integer task_id, */
/* @var task_comment_documents indexed by task comment ID */
/* @var assignees_account_ids array of assignees accounts ids */

echo '<div id="comment-thread-'.$comment->task_comment_id.'">';

/********************************************************
 * PARENT COMMENTS
 */
echo '<ul data-role="listview" data-inset="true">';

// commenter's info
echo '<li>';
echo "<div style='display: inline; width: 60px; float: left;'>";
echo AccountProfile::model()->getProfilePhoto($comment->task_comment_owner_id);
echo "</div>";
echo "<div style='display: inline; width: auto;'>";
echo '<h2 style="color: #60a725; font-size: 18px;">'.
		AccountProfile::model()->getShortFullName($comment->task_comment_owner_id).'</h2>';
echo '<p>Posted on ' .Utilities::displayFriendlyDateTime($comment->task_comment_last_update) . '</p>';
echo "</div>";
echo '</li>';

// comment content
echo '<li style="background-color: #FFFFFF">';
echo '<div style="font-size: 14px; white-space: normall; font-weight: normal;">' 
		. Utilities::encodeToUTF8($comment->task_comment_content) . '</div>';

// more info about this comment: todo, todo completed, etc.
echo '<p style="color: #CCCCCC;width: 100%; text-align: right; margin: 0">';

if ($comment->isOutstandingTodo())
{
	echo CHtml::link('To-do', array('#'),
			array('style'=>'color: #F89406; text-decoration: none;border: 0;margin: 0;display:inline-table'));
	echo '&nbsp;&nbsp;';
}

// if there's no replies yet, give reply link right at parent comment
$comment_reply_link = CHtml::link('Reply', array('#'),
		array(
				'onclick'=>
					'$("#new-reply-form-container-'.$comment->task_comment_id.'").slideToggle();
					$("#new-reply-form-container-'.$comment->task_comment_id.' #TaskComment_task_comment_content").focus();
					return false;',
				'style'=>'color: #CCCCCC; text-decoration: none;border: 0;margin: 0;display:inline-table'));
if (isset($task_comment_replies) && !isset($task_comment_replies[$comment->task_comment_id]))
{
	
	echo $comment_reply_link;
	
}
echo '</p>'; // end more infor paragraph

echo '</li>';
echo '</ul>'; 
// end PARENT comment

/**********************************************************
 * children comments
 */ 
echo '<div id="comment-replies-thread-'.$comment->task_comment_id.'" style="margin-left: 20px;">';
if (isset($task_comment_replies) && isset($task_comment_replies[$comment->task_comment_id]))
{
	$parent_comment_replies = $task_comment_replies[$comment->task_comment_id];
	foreach ($parent_comment_replies as $reply)
	{
		echo '<ul data-role="listview" data-inset="true">';
		// commenter's info
		echo '<li>';
		echo "<div style='display: inline; width: 60px; float: left;'>";
		echo AccountProfile::model()->getProfilePhoto($reply->task_comment_owner_id);
		echo "</div>";
		echo "<div style='display: inline; width: auto;'>";
		echo '<h2 style="color: #60a725; font-size: 16px;">'.
				Utilities::encodeToUTF8(AccountProfile::model()->getShortFullName($reply->task_comment_owner_id)).'</h2>';
		echo '<p>Posted on ' .Utilities::displayFriendlyDateTime($reply->task_comment_last_update) . '</p>';
		echo "</div>";
		echo '</li>';
			
		// comment content
		echo '<li style="background-color: #FFFFFF">';
		echo '<div style="font-size: 14px; white-space: normal; font-weight: normal">' 
				. Utilities::encodeToUTF8($reply->task_comment_content) . '</div>';
		echo '</li>';
		echo '</ul>';
	}
} 
echo '</div>'; // #comment-replies-thread

// reply link
// show it always after the reply thread so that when new reply is appended
// this link will still be at the bottom of its thead;
if (isset($task_comment_replies) && isset($task_comment_replies[$comment->task_comment_id]))
{
	echo '<p style="width: 100%; text-align: right; font-size: 12px;">';
	echo $comment_reply_link;
	echo '</p>';
}
// end showing replies

/************************************************************
 * REPLY FORM
 */
echo '<div id="new-reply-form-container-'.$comment->task_comment_id.'" style="display: none; 
		border-radius: 3px; border: 1px solid #CCCCCC;
		padding: 5px; background-color: #FFFFFF; margin-left: 20px;">';
echo '<strong>Reply:</strong>';
$formNewComment = $this->beginWidget('CActiveForm', array(
		'id' => 'new-reply-form-' . $comment->task_comment_id,
		//'action' => array('taskComment/create', 'ajax' => 1),
		'enableAjaxValidation' => false,
		'htmlOptions' => array('enctype'=>'multipart/form-data'),
));

echo $formNewComment->hiddenField(new TaskComment, 'task_comment_parent_id', array('value' => $comment->task_comment_id));
echo $formNewComment->hiddenField(new TaskComment, 'task_id', array('value' => $comment->task_id));

// comment content
echo $formNewComment->textArea(new TaskComment, 'task_comment_content');

// notifications, by default notify all
if (isset($assignees_account_ids))
{
	foreach ($assignees_account_ids as $assignee_acc_id)
	{
		if ($assignee_acc_id > 0)
		{
			// skip user's own name
			if (Yii::app()->user->id == $assignee_acc_id)
				continue;
	
			echo CHtml::hiddenField('assignee_notify_task_' . $comment->task_id .'[' . $assignee_acc_id .']', $assignee_acc_id);
		}
	}
}

// submit button
echo '<fieldset class="ui-grid-b">';
echo '<div class="ui-block-a"></div>';
echo '<div class="ui-block-b">';
echo CHtml::ajaxSubmitButton('Save',
		array('taskComment/create', 'ajax' => 1),
		array(
				//'update' => '#ajax-content',
				'beforeSend' => 'function(data){

					} ',
				'success' => 'function(data, status, obj) {
						if (data != null)
						{
							$("#comment-replies-thread-'.$comment->task_comment_id.'").append(data);
						}
						$("#new-reply-form-container-'.$comment->task_comment_id.'").slideToggle();
						$("#new-reply-form-container-'.$comment->task_comment_id.' #TaskComment_task_comment_content").val("");
					}',
				'complete'=>'function() {
						$("#comment-replies-thread-'.$comment->task_comment_id.'").find("[data-role=\'listview\']").listview();
					}'),
		array('id' => 'ajax-link-submit-reply-' . uniqid(),'live' => false, 'data-mini'=>'true'));
echo '</div>';//block b
echo '<div class="ui-block-c">';
echo CHtml::button('Cancel', array(
		'onclick'=>
			'$("#new-reply-form-container-'.$comment->task_comment_id.'").slideToggle();
						return false;',
		 'data-mini'=>'true'));
echo '</div>';//block c
echo '</fieldset>';
$this->endWidget();
echo '</div>'; 
// end reply form div container

echo '</div>'; // end this whole thread "comment-thread-<parent-comment-id>