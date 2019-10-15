<?php
/* @var $this TaskCommentController */
/* @var $comment TaskComment */
/* @var $form CActiveForm */
/* @var $task_id integer */
/* @var $is_update YES or NO */
/* @var $task_assignees array of TaskAssignee models */
require_once (YII::app()->modulePath.'/task_progress/css/style.php');
require_once (YII::app()->modulePath.'/task_progress/js/jquery.sglide.2.1.2.min.js.php');

$uniqID_ = uniqid();

$form_action = array('taskComment/create', 'ajax' => 1);
if (isset($is_update) && $is_update == YES)
{
	// we are updating a comment,
	$form_action = array('taskComment/ajaxUpdate', 'id' => $comment->task_comment_id, 'ajax' => 1);
} else {
	$is_update = NO;
}

$form_id = 'task-comment-form-' . (isset($comment->task_comment_id) ? $comment->task_comment_id : '0');
$container_id = "form-container-" . $form_id ;

// style for div container
// if this is a new parent comment
// give a bigger height for the holder
// but if this is a reply, give a shorter holder
if (isset($is_child) && $is_child)
{
	$div_container_style = "padding: 5px; min-height: 20px;";
} else {
	$div_container_style = "padding: 10px; min-height: 40px;";
}
?>

<div id="<?php echo $container_id?>"
		class="form" 
		style="margin-bottom: 5px; margin-top: 5px;<?php echo $div_container_style; ?>">
<?php 
$form = $this->beginWidget('CActiveForm', array(
	'id' => $form_id,
	'action' => $form_action,
	'enableAjaxValidation' => false,
	'htmlOptions' => array('enctype'=>'multipart/form-data'),
)); 

if (!isset($task_id))
{
	$task_id = $comment->task_id;
}
$taskComment_ = new TaskComment;
//echo $form->textArea($taskComment_,'task_comment_content', array('rows' => 5, 'cols' => 80)); 

// task progress section
// $task_progress = TaskProgress::model()->getTaskProgress($task_id, Yii::app()->user->id);
// if ($task_progress === null)
// {
//     $task_progress = TaskProgress::model()->initTaskProgress($task_id, Yii::app()->user->id);
// }
?>
<!--Task progress slider-->
<div style='display: inline-block; width: 100%'>
<li style="list-style: none;">
                                <div style="width: 50px; float: left;margin-top: -3px;">
                                    <?php 
                                    echo AccountProfile::model()->getProfilePhoto(Yii::app()->user->id, false, 40);
                                    ?>
                                </div>
                                
                                <div style="width: 56%; background: none repeat scroll 0 0 #ccc; float: left;">
                                    
                                    <?php echo CHtml::hiddenField('tp_account_'.Yii::app()->user->id, Yii::app()->user->id, array('class'=>'span1'));  ?>
                                    <div id="tp_assignee_<?php echo Yii::app()->user->id; ?>" ></div>
                                </div>
                                
                                <div id="percentage_<?php echo Yii::app()->user->id; ?>" style="width: 5%; float: left;margin-top: 5px; margin-left: 5px;"></div>
                                
                                <div style="width: 24%; float: left;padding-left: 20px;"><?php echo YII::t('core','Days Spent') ?>:
                                    
                                </div>
                            </li>
</div>   
<!-- end task progress section -->
<?php
$this->widget('application.extensions.cleditor.ECLEditor', array(
		'model' => $taskComment_,
		'attribute' => 'task_comment_content', //Model attribute name. Nome do atributo do modelo.
		'options'=>array(
			'width' => 700,
			'height' => 150,
			'useCSS'=>true,
			'controls' => 'source | bold italic underline strikethrough | font size color highlight removeformat | bullets numbering | outdent indent | link unlink',
		),
		'htmlOptions' => array('value' => ($is_update == YES ? $comment->task_comment_content : $taskComment_->task_comment_content)),
));

echo $form->hiddenField($taskComment_, 'task_comment_parent_id', 
		array('value' => ($is_update == YES ? $comment->task_comment_parent_id : $comment->task_comment_id)));
echo $form->hiddenField($taskComment_, 'task_id', array('value' => $task_id));
?>
	
	<?php 
	echo '<br/>';
	echo YII::t('core','Notification').': ';
	//echo CHtml::checkBox('assignee_notify[]', true, array('value' => '-1')) . ' Everyone&nbsp;';
	//echo count($task_assignees);
	if (isset($task_assignees))
	{		
                // avoid duplicate in task_Assignees
                // this measure is to mitigate a bug found earlier and already fixed.
                // but remnant data may still exist
                $task_assignees_account_ids_used = array();
		foreach ($task_assignees as $assignee_)
		{
			// skip user's own name
			if (Yii::app()->user->id == $assignee_->account_id)
				continue;
                        
                        // check duplicate
                        // this should already be fixed, but remnant data may remain
                        // so we put here for extra measure
                        if (in_array($assignee_->account_id, $task_assignees_account_ids_used))
                                continue;
                        $task_assignees_account_ids_used[] = $assignee_->account_id;
			
			// get profile name
			$assigneeProfile = AccountProfile::model()->getProfile($assignee_->account_id);
			if ($assigneeProfile)
			{
				if ($assigneeProfile->getShortFullName())
				{
					echo CHtml::checkBox('assignee_notify_task_' . $task_id .'[' . $assignee_->task_assignee_id .']', true,
							array('value' => $assignee_->account_id)) . '&nbsp;' . $assigneeProfile->getShortFullName() . '&nbsp;';
				}
			}
			
		}
	}
	/**
	echo CHtml::checkBox('assignee_notify[]', true, array('value' => '22')) . ' Nguyen Van Dung&nbsp;';
	echo CHtml::checkBox('assignee_notify[]', true, array('value' => '12')) . ' Vu Thi Luyen&nbsp;';
	echo CHtml::checkBox('assignee_notify[]', true, array('value' => '34')) . ' Pham Thi Hong Nhung&nbsp;';
	**/
	echo '<br/>';
	/**
	echo 'Privacy: ';
	echo CHtml::checkBox('TaskComment[task_comment_internal]', true, array('value' => '1')) . ' Internal Only&nbsp;';
	echo '<br/>';
	**/
	echo YII::t('core','To-do').': ';
	
	$todoHtmlOtions = array();
	if (isset($comment) && $comment->task_comment_to_do > 0 && $is_update == YES)
	{
		$todoHtmlOtions = array('checked' => 'checked');
	}
	echo $form->checkBox($taskComment_, 'task_comment_to_do', $todoHtmlOtions);
			
	echo "<br/>";
	//echo "Documents: ";

	/**
	$this->widget('CMultiFileUpload',array(
			//'model' => $taskComment_,
			'name' => 'task_comment_documents',
			'accept' => 'jpg|png|doc|pdf|xls|xlsx|docx|ppt|pptx',
			'max' => 5,
			'remove' => Yii::t('ui','Remove'),
			'denied' => 'File type is not allowed', //message that is displayed when a file type is not allowed
			'duplicate' => 'Document already selected', //message that is displayed when a file appears twice
			'htmlOptions' => array('size' => 25),
	));*/
	//echo $form->fileField($taskComment_, 'task_comment_documents[]');
	$this->widget('ext.EAjaxUpload.EAjaxUpload',
			array(
					'id'=>'uploadFile',
					'config' => array(
							'action' => Yii::app()->createUrl('lbProject/document/ajaxTempUpload'),
							'allowedExtensions' => Documents::model()->supportedTypes(), //array("jpg","jpeg","gif","exe","mov" and etc...
							'sizeLimit' => 10*1024*1024, // maximum file size in bytes
                                                        'label'=>YII::t('core','Upload a file'),
							//'minSizeLimit' => 10*1024*1024, // minimum file size in bytes
							'onComplete'=>"js:function(id, fileName, responseJSON){ handlePostTempUpload(id, fileName, responseJSON); }",
					//'messages'=>array(
					//                  'typeError'=>"{file} has invalid extension. Only {extensions} are allowed.",
					//                  'sizeError'=>"{file} is too large, maximum file size is {sizeLimit}.",
					//                  'minSizeError'=>"{file} is too small, minimum file size is {minSizeLimit}.",
					//                  'emptyError'=>"{file} is empty, please select files again without it.",
					//                  'onLeave'=>"The files are being uploaded, if you leave now the upload will be cancelled."
					//                 ),
					//'showMessage'=>"js:function(message){ alert(message); }"
					)
	));

		// if we are adding new parent comment,
		// this should be appended to top of the whole comments thread
		if (!isset($is_reply) || $is_reply == 0)
		{
			$success_new_parent = '';
			if ($is_update == YES)
			{
				// updating a parent comment
				$success_new_parent = '$("#comment-root-' . $comment->task_comment_id . '").html(data)';
			} else {
				// this NOT a reply. this is a new comment added from top form
				// prepend new parent comment to comment thread
				$success_new_parent = '$("#comments-thread-'.$task_id.'").prepend(data);';
				// reset new parent comment area to ajax link
				$success_new_parent .= '$("#form-comment-'.$task_id.'").html($("#new-comment-form-link-holder-'.$task_id.'").html());';
			}
		} else {
			$success_new_parent = '';
			if ($is_update == YES) 
			{
				// updating a child comment
				$success_new_parent = '$("#reply-container-' . $comment->task_comment_id . '").html(data)';
			} else {
				// This is a reply comemnt added from reply form
				$success_new_parent = '$("#comment-reply-thread-' . $comment->task_comment_id . '").append(data);';
				$success_new_parent .= '$("#comment-thread-reply-form-' . $comment->task_comment_id . '").html($("#new-reply-form-link-holder-' . $comment->task_comment_id . '").html());';
			}
		}
		// submit button and post-submission processing
		$btnSave = CHtml::ajaxSubmitButton(YII::t('core','Save'),
				$form_action, 
				array(
					//'update' => '#ajax-content', 
					'id' => 'ajax-link' . uniqid(),
					'beforeSend' => 'function(data){
						$("#form-container-task-comment-form-buttons-' . $uniqID_ . '")
							.append("<img src=\"'. Yii::app()->baseUrl .'/images/loading.gif\"/>");
					} ',
					'success' => 'function(data, status, obj) {
						' . $success_new_parent . '
						$("#' . $form_id . ' #TaskComment_task_comment_content").val("");
					}'),
				array('live' => false)); 

		// cancel button and post-cancel processing
		$cancel_ajax_option = array();
		if (isset($is_reply) && $is_reply == 1)
		{
			// REPLY COMMENT TYPE
			
			if ($is_update == YES)
			{
				// CANCEL UPDATE
				// reset the comment being updated
				$cancel_ajax_option = array('success' => '
					function(data) {
						var el = $("#comment-content-' . $comment->task_comment_id .'");
						if (el.length > 0) el.html(data);
					}'
					);
			} else {
				// CANCEL ADD NEW
				// update new comment form at the bottom of a comment replies thread
				$cancel_ajax_option = array('update' => '#comment-thread-reply-form-' . $comment->task_comment_id);
			}
		} else {
			if ($is_update == YES)
			{
				// CANCEL UPDATE
				// RESET parent comment 
				$cancel_ajax_option = array('update' => '#comment-content-' . $comment->task_comment_id);
			}
			else {
				// CANCEL ADD NEW
				// resset new comment form 
				$cancel_ajax_option = array('update' => '#form-comment-'.$task_id.''); // update new comment form on top
			}
			$is_reply = 0;
		}
		
		$btnCancel = CHtml::ajaxLink(
				YII::t('core','Cancel'),
				array($is_update ? 'taskComment/cancelUpdate' : 'taskComment/cancelCreate',
							'task_id' => $task_id, 
							'is_reply' => $is_reply,
							'comment_id' => $comment->task_comment_id,
							'is_update' => $is_update,
							'ajax' => 1,
				), // Yii URL
				$cancel_ajax_option, 
				array('id' => 'ajax-id-cancel-' . uniqid())
		);

		
		echo "<div id='form-container-task-comment-form-buttons-$uniqID_'>$btnSave $btnCancel</div>";

$this->endWidget(); 
?>
</div> <!-- end div form-container -->
		
<script language="javascript">
function handlePostTempUpload(id, fileName, responseJSON)
{
	//responseJSONParsed = JSON.parse(responseJSON);
	uploadedFileName = '';// the final name stored in server
	if (responseJSON != null && responseJSON.filename != null)
	{
		uploadedFileName = responseJSON.filename;
		uploadedFileName_ = uploadedFileName.replace(/\./g, '_');

		// sanitize original name (uploaded name is already sanitized)
		fileName = sanitizeFileName(fileName);
		
		var el = '<input type="hidden" name="temp_uploaded_file_names[]" value="' + uploadedFileName + '" id="id-temp-uploaded-file-name-' + id + '"/>';
		el += '<input type="hidden" name="' + uploadedFileName_ + '_original_name" value="' + fileName + '" id="'+ uploadedFileName_ + '_original_name"/>';
		$("#<?php echo $form_id ?>").append(el);
	}
}

function sanitizeFileName(name)
{
	name = name.replace(/\'/g, '');
	name = name.replace(/\"/g, '');
	return name;
}

$(document).ready(function(){
    var acc_id = <?php echo Yii::app()->user->id; ?>;
    if ( $("#tp_assignee_"+acc_id) != null )
    {
        $("#tp_assignee_"+acc_id).sGlide({
                startAt	: $("#tp_assignee_startAt_"+acc_id).val(),
                pill	: false,
                width	: 500,
                height  :32,
                drop:function(o)
                {
                    var val = Math.round(o.percent);
                    $('#percentage_'+acc_id).html(val+'%');
                    $('#tp_assignee_startAt_'+acc_id).val(val);
                    //updateTaskProcess(account_id,stt,o.percent);
                }
            }); 
        $(".slider_knob").css({background: '#777'});
    }
});
</script>

<style type="text/css">
    .qq-upload-button {
        display: block;
        width: 105px;
        padding: 7px 0;
        text-align: left;
        background: none;
        border-bottom: none;
        color: #08c;
    }
</style>