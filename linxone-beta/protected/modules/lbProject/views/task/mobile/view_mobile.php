<?php
/* @var $this TaskController */
/* @var $model Task */
/* @var $task_comment Parent-level task comments */
/* @var $task_comment_replies array of of array of TaskComment. key is parent comment id task_comment_replies[parent_id]= array of replies*/
/* @var $task_comment_documents Array of documents, key is comment id */
/* @var $outstanding_to_do Array of comments/replies marked as todo but not complted */

// PROJECT NAME AND LINK
$project = Project::model()->findByPk($model->project_id);
echo CHtml::link($project->project_name, 
				$project->getProjectURL(),
				array(
						//'style'=>'color: #60a725; font-size: 18px; text-decoration: none;',
						'data-role'=>'button',
						'data-theme'=>'b',
						'data-icon'=>'back',
						'style'=>'margin-top: -4px;'));

//
// TASK INFO
//
echo '<ul data-role="listview" data-inset="true">';
echo '<li data-role="list-divider" data-theme="a"><span style="color: #60a725; font-size: 18px;">Task:&nbsp;'.$model->task_name.'</span></li>';

echo '<li>';
// Task Desc
if ($model->task_description)
{
	echo '<p style="font-size: 14px; white-space: normal">' . Utilities::encodeToUTF8($model->task_description) . '<br/><br/></p>';
}

// show member pics
$assignees_account_ids = explode(',', $model->task_assignees);
echo '<p>';
foreach ($assignees_account_ids as $assignee_acc_id)
{
	if ($assignee_acc_id > 0)
	{
		echo AccountProfile::model()->getProfilePhoto(trim($assignee_acc_id));
		//echo '<img src="'. AccountProfile::model()->getProfilePhotoURL($assignee_acc_id) . '" border="0"/>';
	}
}
echo '</p>';

// update members
/**
echo '<p style="width: 100%; text-align: right; font-size: 12px;">';
echo CHtml::link('Update Members',array('#'), array('style'=>'color: #CCCCCC; text-decoration: none;'));
echo '</p>';
**/

echo '</li>';
echo '<li data-icon="plus" data-iconpos="right">'.
		CHtml::link('New Comment', array('#'),
				array('onclick'=>
						'$("#new-comment-form-container").slideToggle();
						$("#new-comment-form-container #TaskComment_task_comment_content").focus();
						return false;')).'</li>';
echo '</ul>';
// End Task Info

// NEW
// New comment form
//
echo '<div id="new-comment-form-container" style="display: none; 
		border-radius: 3px; border: 1px solid #CCCCCC;
		padding: 5px; background-color: #FFFFFF">';
echo '<strong>New Comment</strong>';
$formNewComment = $this->beginWidget('CActiveForm', array(
		'id' => 'new-comment-form-' . $model->task_id,
		//'action' => array('taskComment/create', 'ajax' => 1),
		'enableAjaxValidation' => false,
		'htmlOptions' => array('enctype'=>'multipart/form-data', 'data-ajax'=>'true'),
));

echo $formNewComment->hiddenField(new TaskComment, 'task_comment_parent_id', array('value' => 0));
echo $formNewComment->hiddenField(new TaskComment, 'task_id', array('value' => $model->task_id));

// comment content
echo $formNewComment->textArea(new TaskComment, 'task_comment_content');

// notifications, by default notify all
foreach ($assignees_account_ids as $assignee_acc_id)
{
	if ($assignee_acc_id > 0)
	{
		// skip user's own name
		if (Yii::app()->user->id == $assignee_acc_id)
			continue;
		
		echo CHtml::hiddenField('assignee_notify_task_' . $model->task_id .'[' . $assignee_acc_id .']', $assignee_acc_id);
	}
}

echo $formNewComment->label(new TaskComment, 'task_comment_to_do');
// CANNOT use yii activeform for checkbox because it'll create a hidden field
//echo $formNewComment->checkBox(new TaskComment, 'task_comment_to_do',
//		array('data-mini'=>"true", 'value'=>1, 'class'=>"custom"));
echo '<input type="checkbox" name="TaskComment[task_comment_to_do]" id="TaskComment_task_comment_to_do" 
		class="custom" data-mini="true" value="1">';

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
							$("#comments-thread").prepend(data);
						}
						$("#new-comment-form-container").slideToggle();
						$("#new-comment-form-container #TaskComment_task_comment_content").val("");
					}',
					'complete'=>'function() {
						$("#comments-thread").find("[data-role=\'listview\']").listview();
					}'),
				array('id' => 'ajax-link' . uniqid(),'live' => false, 'data-mini'=>'true', 'type'=>'button')); 
echo '</div>';//block b
echo '<div class="ui-block-c">';
echo CHtml::button('Cancel', array(
		'onclick'=>
						'$("#new-comment-form-container").slideToggle();
						return false;',
		'data-mini'=>'true',));
echo '</div>';//block c
echo '</fieldset>';
$this->endWidget();
echo '</div>';
// end new comment form

//
// PRINT MAIN BODY
// Task comments
//
echo '<div id="comments-thread">';
foreach ($task_comments as $parent_comment)
{
	$thread_data = array();
	$thread_data['comment'] = $parent_comment;
	$thread_data['task_comment_replies'] = $task_comment_replies;
	$thread_data['task_id'] = $parent_comment->task_id;
	$thread_data['assignees_account_ids'] = $assignees_account_ids;
	echo $this->renderPartial('//taskComment/mobile/_viewThread_mobile', $thread_data);
} // end show task comments threads.
echo '</div>';