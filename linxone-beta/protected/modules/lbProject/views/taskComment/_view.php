<?php
/* @var $comment TaskComment model */
/* @var $task Task model */
/* @var $project Project model */
/* @var $task_comment_documents Array of documents, indexed by task_comment_id */
/* @var $replies array of replies. Only available for parent comment */

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

// get permission status
$allowed_edit_comment = ($comment->getAgeInDays() <= 1 
			&& $task->task_status != TASK_STATUS_COMPLETED
			&& !$project->isArchived()
			&& $comment->task_comment_owner_id == Yii::app()->user->id);

// get profile info of commentor
$accountProfile = AccountProfile::model()->getProfile($comment->task_comment_owner_id);
echo "<div id='comment-content-container-{$comment->task_comment_id}'>";
// print photo
echo "<div id='comment-profile-photo-{$comment->task_comment_id}' style='width: 55px; float: left;'>
		{$accountProfile->getProfilePhoto()}</div>";
// print content
echo "<div id='comment-content-{$comment->task_comment_id}' style='display: table'>
		<b>{$accountProfile->getShortFullName()}</b>: ";
echo '<a id="anchor-task-comment-' . $comment->task_comment_id . '"></a>'; // anchor

// convert links in comment content to clickable markup
$converted_task_comment_content = Utilities::convertURLtoLink($comment->task_comment_content);
echo $converted_task_comment_content . '<br/></div>';
//echo $comment->task_comment_content . '<br/></div>';

echo "</div>"; // end div comment-content-container-#

// documents 
if (isset($task_comment_documents) && isset($task_comment_documents[$comment->task_comment_id]))
{ 
	$documents = $task_comment_documents[$comment->task_comment_id]; 
	foreach ($documents as $doc)
	{ 
		// document delete ajax link
		$doc_delete_ajax_link = '';
		if ($allowed_edit_comment)
		{
			$doc_delete_ajax_link = CHtml::ajaxLink(
				'<i class="icon-remove"></i>',
				array('document/ajaxDelete', 'id' => $doc->document_id), // Yii URL
				array('success' => 'function(data){
						if (data == "success") {
						$("#container-document-' . $doc->document_id . '").remove(); // remove doc div container
				}
				}'),
				array('id' => 'ajax-id-'.uniqid())
			);
		}
		echo '<div id="container-document-' . $doc->document_id . '" style="margin-left: 45px; ">';
		echo CHtml::image($doc->getDocumentIcon(), '', array('border' => 0));
		echo CHtml::link($doc->document_real_name, array('document/download', 'id' => $doc->document_id));
                
                // if doc is image, allow preview in popup
                if ($doc->isImage())
                {
                    echo ' ' . LinxUI::imagePreviewLink(
                            array('document/download', 'id' => $doc->document_id), 
                            $doc->document_real_name, 
                            'task_' . $comment->task_id);
                } // end preview image
                
		echo " $doc_delete_ajax_link<br/>";
		echo '</div>';
	}
} 
?>

<div class="footer-container">
	<?php  
	$edit_ajax_link = '';
	$delete_ajax_link = '';
	
	// check permission
	if ($allowed_edit_comment) 
	{
		$edit_ajax_link = CHtml::ajaxLink(
				'<i class="icon-pencil"></i>',
				array('taskComment/ajaxUpdate', 'id' => $comment->task_comment_id), // Yii URL
				array('update' => '#comment-content-' . $comment->task_comment_id), // jQuery selector
				array('id' => 'ajax-id-'.uniqid())
		);

		$delete_ajax_link = CHtml::ajaxLink(
				'<i class="icon-remove"></i>',
				array('taskComment/delete', 'id' => $comment->task_comment_id), // Yii URL
				array(
						'success' =>
						// If has parent, only remove itself from screen
						// If has child(ren), remove the whole thread
						$comment->task_comment_parent_id > 0 ?
						'js: function(data) {
							if (data == "success")
								$("#reply-container-' . $comment->task_comment_id .'").remove();
						}' : 'js: function(data){
							if (data == "success")
								$("#comment-thread-' . $comment->task_comment_id .'").remove();
						}',
						'type' => 'POST'
				), // jQuery selector
				array('id' => 'ajax-id-'.uniqid())
		);
	}
	
	echo YII::t('core',"Posted on")." " . Utilities::displayFriendlyDateTime($comment->task_comment_last_update);
	echo '<div style="float: right">';
	
	// REPLY link if this is a parent comment and there's no reply yet.
	if (!$comment->task_comment_parent_id && isset($replies)
			&& !count($replies))
	{
		echo '<i class="icon-comment"></i>';
		echo CHtml::ajaxLink(
			YII::t('core','Reply'),
			array('taskComment/create'
				, 'task_id' => $comment->task_id
				, 'task_comment_id' => $comment->task_comment_id
				, 'is_reply' => 1
				, 'ajax' => 1), // Yii URL
				array('update' => '#comment-thread-reply-form-' . $comment->task_comment_id), // jQuery selector
				array('id' => 'ajax-id-'.uniqid(), 'class' => 'blur-summary')
		);
		echo '&nbsp;&nbsp;';
	}	
	
	echo '#' . $comment->task_comment_id . '&nbsp;';
	
	// to do item
        $lnotcomplete = YII::t('core','not completed');
        $lcomplete = YII::t('core','completed');
	if ($comment->task_comment_to_do > 0)
	{
		echo ($comment->task_comment_to_do_completed == NO ? '<span class="badge badge-warning">' : '');
		echo YII::t('core','To-do').' '.YII::t('core','Item').': ';
		echo ($comment->task_comment_to_do_completed == NO ? '</span>' : '');
                echo '&nbsp;';
                $ltodo =  ($comment->task_comment_to_do_completed==0) ? $lnotcomplete : $lcomplete;
                echo '<div class="btn-group editable editable-click" style="padding-right: 0px;">';
                echo '<a href="#" id="task_comment-to-do-completed-'.$comment->task_comment_id.'" class="btn dropdown-toggle" data-toggle="dropdown" '
                    . 'style="border: none; background: none; box-shadow: none; padding:0px 8px 0px 0px; color:#08c;text-shadow:none; font-size:11.844px">';
                echo $ltodo.'</a>';
                    echo '<ul class="dropdown-menu" id="yw1" style="list-style:none;">';
                        echo '<li>';
                            echo '<a  href="#" style="text-shadow:none;" onclick="updateTodoComplete('.$comment->task_comment_id.',1); return false;">'.$lcomplete.'</a>';
                        echo '</li>';
                        echo '<li>';
                            echo '<a href="#"  style="text-shadow:none;" onclick="updateTodoComplete('.$comment->task_comment_id.',0); return false;">'.$lnotcomplete.'</a>';  
                        echo '</li>';
                    echo '</ul>';
                echo '</div>';
		
//		$this->widget('editable.EditableField', array(
//				'type' => 'select',
//				'model' => $comment,
//				'attribute' => 'task_comment_to_do_completed',
//				'placement' => 'right',
//				//'emptytext' => 'Update',
//				'params' => array('ajax_id' => 'bootstrap-x-editable'),
//				'url' => $this->createUrl('taskComment/ajaxUpdateField'),
//				'source' => array( 0 => YII::t('core','not completed'), 1 => YII::t('core','completed') ),
//		));
		
		echo ' ';
	}
	echo $edit_ajax_link . ' ' . $delete_ajax_link . '</div>';
	?>
</div>
<script type="text/javascript">
    function updateTodoComplete(comment_id,taskCommentTodo){
       $("#task_comment-to-do-completed-"+comment_id).html("Loading...");
       $.ajax({
            'type':'POST',
            'url':'<?php echo $this->createUrl('taskComment/UpdateTotoComplete'); ?>',
            data:{comment_id:comment_id,TodoComplete:taskCommentTodo},
            success:function(data){
                var respon = jQuery.parseJSON(data);
                if (respon.status == "success")
                {
                    var btnLabel = '';
                    if(respon.todo_complete == '0')
                        btnLabel = '<?php echo $lnotcomplete; ?>';
                    else
                        btnLabel = '<?php echo $lcomplete; ?>'; 
                    $("#task_comment-to-do-completed-"+comment_id).html(btnLabel);
                }
            }
                    
        });
    }
</script>