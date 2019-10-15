
<?php
/* @var $this TaskController */
/* @var $model Task */
/* @var $task_comment_replies array of of array of TaskComment. key is parent comment id task_comment_replies[parent_id]= array of replies */
/* @var $task_comment_documents Array of documents, key is comment id */
/* @var $outstanding_to_do Array of comments/replies marked as todo but not complted */
$count_project = " <span class='badge'>".count(Project::model()->findAll())."</span>";
    $count_task = " <span class='badge badge badge-warning'>".count(Task::model()->findAll('project_id IN ('.$model->project_id.')'))."</span>";
    $count_document = " <span class='badge badge badge-success'>".count(Documents::model()->findAll('   document_parent_id IN ('.$model->project_id.')'))."</span>";

$new_comment_ajax_link = CHtml::ajaxLink(
                YII::t('lang','Comment or upload document'), array('taskComment/create', 'task_id' => $model->task_id, 'ajax' => 1), // Yii URL
                array('update' => '#form-comment'), // jQuery selector
                array('id' => 'ajax-id-' . uniqid())
);

//test
/**
  $this->widget('editable.EditableField', array(
  'type' => 'textarea',
  'model' => $model,
  'attribute' => 'task_name',
  'url' => $this->createUrl('site/updateUser'),
  'placement' => 'right',
  ));* */
// end test
// print project header
echo "<div class='hidden_navbar' hidden>";
if(!isset($request_mutile_tabs)){
    Utilities::renderPartial($this, "/default/_project_header", array(
        'project_id' => $model->project_id,
        'return_tab' => ($model->task_type == Task::TASK_TYPE_ISSUE ? 'issues' : 'tasks')
    ));
}
echo "</div>";
echo "<div style='margin-top: -22px;'>";
$count_task_name = strlen($model->task_name);
if($count_task_name > 20){
    $result_task_name = mb_substr($model->task_name,  0, 20);
    $task_name = $result_task_name."...";
} else {
    $task_name = $model->task_name;
}
$taskModel = new Task('search');
$taskModel->unsetAttributes();
if(isset($_GET['Task'])) 
{
    $taskModel->attributes=$_GET['Task'];
}
$taskModel->project_id = $model->project_id;
$taskModel->task_status = TASK_STATUS_ACTIVE;
// print_r($taskModel);

$documentModel = new Documents('getDocuments');
$documentModel->unsetAttributes();
if(isset($_GET['Documents'])) 
{
    $documentModel->attributes=$_GET['Documents'];
    //echo $documentModel->document_real_name; return;
}
// $this->widget('bootstrap.widgets.TbTabs', array(
//                     'type'=>'tabs', // 'tabs' or 'pills'
//                     'encodeLabel'=>false,
//                     'tabs'=> 
//                     array(
//                                array('id'=>'tab1','label'=>Yii::t('lang','Dự án'). ' <span class="badge">'.count(Project::model()->findAll()).'</span>',
//                                     'content'=>$this->renderPartial('application.modules.lbProject.views.default.project_all',array(

//                                     ),true),'active'=>false,
//                                 ),
//                                 // array('id'=>'tab2','label'=>Yii::t('lang','Công việc').$count_task, 
                                                
//                                 //                 'active'=>false),
//                                 array('id'=>'tab2','label'=>Yii::t('lang','Công việc'). ' <span class="badge badge-warning">'.count(Task::model()->findAll('project_id IN ('.$model->project_id.')')).'</span>',
//                                     'content'=>$this->renderPartial('application.modules.lbProject.views.default._index_tasks',array(
//                                             'model' => $model,
//                                             'taskModel' => $taskModel
//                                     ),true),'active'=>false,
//                                 ),
//                                 // array('id'=>'tab3','label'=>Yii::t('lang','Văn bản').$count_document, 
                                                
//                                 //                 'active'=>false),
//                                 array('id'=>'tab3','label'=>Yii::t('lang','Văn bản'). ' <span class="badge badge-success">'.count(Documents::model()->findAll('document_parent_id IN ('.$model->project_id.')')).'</span>',
//                                     'content'=>$this->renderPartial('application.modules.lbProject.views.default._index_documents',array(
//                                         'model' => $model,
//                                         'documentModel'=>$documentModel,
//                                     ),true),'active'=>false,
//                                 ),
//                                 array('id'=>'tab4','label'=>Yii::t('lang','Wiki'). ' <span class="badge badge-info">'.count(WikiPage::model()->findAll('project_id IN ('.$model->project_id.')')).'</span>',
//                                     'content'=>$this->renderPartial('application.modules.lbProject.views.default.wiki_all',array(
//                                             'model' => $model,
//                                             'documentModel' => $documentModel,
//                                     ),true),'active'=>false,
//                                 ),
//                                 // array('id'=>'tab4','label'=>Yii::t('lang','Wiki'), 
                                                
//                                 //                 'active'=>false),
//                                 array('id'=>'tab5','label'=>$task_name.'<button style="margin-left: 3px;" class="close closeTab" type="button" >×</button>', 
                                                
//                                                 'active'=>true),
//                             )
//     ));
    
?>
<br/>
<div id="task-title" style="display: block">


</div> <!-- end "task-title" -->
<div id="task-main-body" style="width: 800px; float: left;">
    <h4 style="display: inline; max-width: 800px; font-weight: normal">
<?php
echo "<div style='margin-bottom:8px;'>";
// echo ($model->task_no!="" ?  '<span class="blur">#'.$model->task_no.'</span>' : "")." ";
if (Permission::checkPermission($model, PERMISSION_TASK_UPDATE_GENERAL_INFO)) {
    $this->widget('editable.EditableField', array(
        'type' => 'text',
        'model' => $model,
        'attribute' => 'task_name',
        'url' => $this->createUrl('task/ajaxUpdateField'),
        'placement' => 'right',
    ));
} else {
    echo $model->task_name;
}
echo "</div>";
echo '<div style="clear: both"></div>';

// mark as done, re-open button
// MARK AS DONE BUTTON
$lopen = YII::t('lang','Open');
$ldone = YII::t('lang','Done');
$lstatus = $model->task_status == TASK_STATUS_COMPLETED ? $ldone : $lopen;
if (Permission::checkPermission($model, PERMISSION_TASK_UPDATE_STATUS)) {
 
        echo '<div class="btn-group badge" style="padding-right: 0px;">';
        echo '<a href="#" id="task-btn-status-'.$model->task_id.'" class="btn dropdown-toggle badge" data-toggle="dropdown" '
            . 'style="border: none; background: none; box-shadow: none; padding:0px 8px 0px 0px; color:#ffffff;text-shadow:none; font-size:11.844px">';
        echo $lstatus.'&triangledown;</a>';
            echo '<ul class="dropdown-menu" id="yw1">';
                echo '<li>';
                    echo '<a href="#" style="text-shadow:none;" onclick="updateStatus('.$model->task_id.',1); return false;">'.$ldone.'</a>';
                echo '</li>';
                echo '<li>';
                    echo '<a href="#" style="text-shadow:none;" onclick="updateStatus('.$model->task_id.',0); return false;">'.$lopen.'</a>';  
                echo '</li>';
            echo '</ul>';
        echo '</div>';
        
//    $this->widget('editable.EditableField', array(
//        'type' => 'select',
//        'model' => $model,
//        'attribute' => 'task_status',
//        'title'=>YII::t('core','Select Status'),
//        'url' => $this->createUrl('/task/ajaxUpdateField'),
//        //'source' => Editable::source(Status::model()->findAll(), 'status_id', 'status_text'),
//        //or you can use plain arrays:
//        'source' => array(TASK_STATUS_ACTIVE => $lopen, TASK_STATUS_COMPLETED => $ldone),
//        'placement' => 'right',
//        'htmlOptions' => array('class' => 'badge', 'style' => 'border-bottom: none'),
//    ));
//      $this->widget('bootstrap.widgets.TbButton', array(
//        'buttonType'=>'ajaxSubmit',
//        'ajaxOptions' => array('success' => 'function(data){
//        data = JSON.parse(data);
//        if (data.status == "success")
//        {
//            var btnLabel = (data.task_status == ' . TASK_STATUS_ACTIVE . ' ? "Mark as Done" : "Reopen");
//            $("#task-btn-status-' . $model->task_id . '").html(btnLabel);
//        }
//        }',
//        'id' => 'ajax-link' . uniqid(),
//        'type' => 'POST'),
//        'htmlOptions' => array('live' => false, 'id' => 'task-btn-status-' . $model->task_id, 'class' => 'badge', 'style' => 'border-bottom: none;text-shadow: none;',),
//        'url' => array('task/toggleStatus', 'id' => $model->task_id),
//        'label' => $model->task_status == TASK_STATUS_COMPLETED ? 'Reopen' : 'Mark as Done',
//        'type' => '', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
//      ));
} else {
    echo YII::t('core',"Status").": " . ($model->task_status == TASK_STATUS_ACTIVE ? YII::t('core','Open') : YII::t('lang','Done')) . '<br/>';
}
//echo "&nbsp;";
// show overdue/in-progress label
$lbover="";
if ($model->isOverdue()) {
    // $lbover= LinxUI::getOverdueBadge();
//} else if ($model->isInProgress()) {
//    $lbprogres= '';
//} else if ($model->isDone()) {
//    $lbprogres= LinxUI::getDoneBadge();
}
echo '<span id="status-badge-'.$model->task_id.'" >';
    echo $lbover;
echo '</span>';


    
    


// Task type
$lfeature = YII::t('lang','Feature');
$lissue = YII::t('lang','Issue');
$lforum = YII::t('lang','Forum');
$lother = YII::t('lang','Other');
$label_type = $lfeature;
if($model->task_type==Task::TASK_TYPE_ISSUE)
    $label_type = $lissue;
else if($model->task_type==Task::TASK_TYPE_FORUM)
    $label_type = $lforum;
else if($model->task_type==Task::TASK_TYPE_OTHERS)
    $label_type = $lother;
// echo '<input type="hidden" name="hidden_tab" id="hidden_tab" value="123" />';
 echo '<div id="task-wap-type-'.$model->task_id.'" style="padding-right: 0px;">';
        echo '<a href="#" id="task-type-'.$model->task_id.'" class="btn dropdown-toggle badge" data-toggle="dropdown" '
            . 'style="border: none; background: none; box-shadow: none; padding:0px 8px 0px 0px; color:#ffffff;text-shadow:none; font-size:11.844px">';
        echo $label_type.'&triangledown;</a>';
            echo '<ul class="dropdown-menu" id="yw1">';
                echo '<li>';
                    echo    '<a href="" style="text-shadow:none;" onclick="updateType('.$model->task_id.','.Task::TASK_TYPE_FEATURE.'); return false;">'.$lfeature.'</a>';
                echo '<li>';
                    echo    '<a href="" style="text-shadow:none;" onclick="updateType('.$model->task_id.','.Task::TASK_TYPE_ISSUE.'); return false;">'.$lissue.'</a>';
                echo '</li>';
                echo '<li>';
                    echo    '<a href="" style="text-shadow:none;" onclick="updateType('.$model->task_id.','.Task::TASK_TYPE_FORUM.'); return false;">'.$lforum.'</a>';
                echo '</li>';
                echo '<li>';
                    echo    '<a href="" style="text-shadow:none;" onclick="updateType('.$model->task_id.','.Task::TASK_TYPE_OTHERS.'); return false;">'.$lother.'</a>';
                echo '</li>';
            echo '</ul>';
        echo '</div>';

//$this->widget('editable.EditableField', array(
//    'type' => 'select',
//    'model' => $model,
//    'attribute' => 'task_type',
//    'url' => $this->createUrl('/task/ajaxUpdateField'),
//    //'source' => Editable::source(Status::model()->findAll(), 'status_id', 'status_text'),
//    //or you can use plain arrays:
//    'source' => $model->getTaskTypesList(),
//    'title'=>YII::t('core','Select type'),
//    'placement' => 'right',
//    'htmlOptions' => array('class' => 'badge ' . ($model->task_type == Task::TASK_TYPE_ISSUE ? 'badge-warning' : 'badge-info'),
//        'style' => 'border-bottom: none'),
//));
// end task type
        
// PRIORITY BUTTON
//if ($allowed_update_general_info)
//{
// $issuePriority = SystemListItem::model()->getItem($model->task_priority);
// $issue_priorities_items = SystemListItem::model()->getItemsForList(TASK_PRIORITY_LIST_NAME);
// $issue_priorities_btns = array();
// foreach ($issue_priorities_items as $issue_priority_)
// {
        
// }
// $this->widget('bootstrap.widgets.TbButtonGroup', array(
//                 'type'=>'', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
//                 //'buttonType' => 'ajaxButton',
//                 'buttons'=>array(
//                         array('label'=> ($issuePriority ? $issuePriority->system_list_item_name : 'Priority'),
//                                 'items' => $issue_priorities_btns,
//                                         'htmlOptions' => array('id' => 'btn-issue-priority-action-' . $model->task_id),
//                         ),
//                 ),
// ));
//} else {
//	$status = SystemListItem::model()->getItem($model->issue_priority);
//	echo 'Priority: ' . ($status != null ? $status->system_list_item_name : '');
//}
echo '&nbsp;';
?></h4>
    <div class="comment-container">
        <div id="task-description-container-<?php echo $model->task_id; ?>">
            <br/>
            <?php echo YII::t('lang','Description'); ?> : 
        <?php
        if (Permission::checkPermission($model, PERMISSION_TASK_UPDATE_GENERAL_INFO)) {
            // link to show inline-editable form
            echo CHtml::ajaxLink(
                    '<i class="icon-pencil"></i>', array('task/ajaxUpdateDescription', 'id' => $model->task_id, 'ajax' => 1), // Yii URL
                    array('update' => '#task-description-content-' . $model->task_id), // jQuery selector
                    array('id' => 'ajax-id-' . uniqid())
            );
        }
        ?>
            <div id="task-description-content-<?php echo $model->task_id; ?>">
            <?php
            $converted_description = Utilities::convertURLtoLink($model->task_description);
            echo $converted_description;
            //echo $model->task_description; 
            ?>
            </div>
        </div>

        <div class="footer-container">
            <?php
            echo Utilities::displayFriendlyDate($model->task_created_date);
            echo '&nbsp;'.YII::t('lang','by').'&nbsp;' . AccountProfile::model()->getShortFullName($model->task_owner_id, true);
            ?>&nbsp;-&nbsp;
                <?php
                if (!Permission::checkPermission($model, PERMISSION_TASK_UPDATE_MEMBER)) {
                    $assignees_account_ids = explode(',', $model->task_assignees);
                    foreach ($assignees_account_ids as $assignee_acc_id) {
                        if ($assignee_acc_id > 0) {
                            echo '<a><i class="icon-user"></i>'
                            . AccountProfile::model()->getShortFullName($assignee_acc_id) . '</a>';
                        }
                    }
                } else {
                    echo '<strong>'.YII::t('lang','People').':</strong> <div id="assignees-list" style="display: inline"></div>';
                    $this->widget('editable.EditableField', array(
                        'type' => 'checklist',
                        'model' => $model,
                        'attribute' => 'task_assignees',
                        'placement' => 'right',
                        'emptytext' => YII::t('lang','Update'),
                        'params' => array('ajax_id' => 'bootstrap-x-editable'),
                        'url' => $this->createUrl('taskAssignee/create'),
                        'source' => $this->createUrl('projectMember/dropdownSource', array('id' => $model->project_id)),
                        'options' => array(
                            'display' => "js: function(value, sourceData) {
						var checked, html = '';
						checked = $.grep(sourceData, function(o){
			              return $.grep(value, function(v){ 
			                   return v == o.value; 
			              }).length;
			        	});
			        
				        $.each(checked, function(i, v) { 
				            html+= '<a><i class=\"icon-user\"></i>'+$.fn.editableutils.escape(v.text)+'</a>&nbsp;';
				        });
				
				        $('#assignees-list').html(html);
					}",
                        ),
                    ));
                } // end task members infor
                //
		// task start date and time
                //
		echo '&nbsp;&nbsp;';
                echo '<strong>'.YII::t('lang','Schedule').':</strong> ';
                if (Permission::checkPermission($model, PERMISSION_TASK_UPDATE_STATUS)) {
                    echo '<div style="display: inline">';
                    $this->widget('editable.EditableField', array(
                        'type' => 'date',
                        'model' => $model,
                        'attribute' => 'task_start_date',
                        'url' => array('task/ajaxUpdateField'),
                        'placement' => 'right',
                        'viewformat' => 'dd MM yyyy',
                        'text' => Utilities::displayFriendlyDate($model->task_start_date),
                    ));
                    echo '</div>';
                } else {
                    echo Utilities::displayFriendlyDate($model->task_start_date);
                }

                echo ' to ';

                if (Permission::checkPermission($model, PERMISSION_TASK_UPDATE_STATUS)) {
                    echo '<div style="display: inline">';
                    $this->widget('editable.EditableField', array(
                        'type' => 'date',
                        'model' => $model,
                        'attribute' => 'task_end_date',
                        'url' => array('task/ajaxUpdateField'),
                        'placement' => 'right',
                        'viewformat' => 'dd MM yyyy',
                        'text' => Utilities::displayFriendlyDate($model->task_end_date),
                    ));
                    echo '</div>';
                } else {
                    echo Utilities::displayFriendlyDate($model->task_end_date);
                }
                // end task start date end end date
                //
		// task milestones
                //
		echo '&nbsp;&nbsp;';
                echo '<strong>'.YII::t('lang','Milestone').':</strong> <div id="lc-task-milestones-list" style="display: inline"></div>';
                //echo '<span class="badge badge-success" style="font-size: 7pt">SIT</span>'
                //. '&nbsp;<span class="badge" style="font-size: 7pt">UAT 2</span>'
                //        . '&nbsp;<a href="#" data-value="" class="editable editable-click">Update?</a>'; // demo

                $this->widget('editable.EditableField', array(
                    'type' => 'select',//'checklist',
                    'model' => $model,
                    'attribute' => 'task_milestones',
                    'placement' => 'right',
                    'emptytext' => YII::t('lang','Update'),
                    'params' => array('ajax_id' => 'bootstrap-x-editable'),
                    'url' => $this->createUrl('milestone/milestoneEntity/multiUpdate?entity_type=TASK'),
                    'source' => $this->createUrl('milestone/default/jsonIndex', array('project_id' => $model->project_id, 'milestone_status' => 1)),
                    'options' => array(
                        'display' => "js: function(value, sourceData) {
                                                    var checked, html = '';
                                                    checked = $.grep(sourceData, function(o){
                                                        return $.grep(value, function(v){ 
                                                            return v == o.value; 
                                                        }).length;
                                                    });

                                                    $.each(checked, function(i, v) { 
                                                        html+= $.fn.editableutils.escape(v.text)+',&nbsp;';
                                                    });

                                                    $('#lc-task-milestones-list').html(html);
                                                }",
                    ),
                ));

                // end task milestone
                ?>
        </div>

    </div> <!-- end infor-container div -->

    <div id="form-comment-<?php echo $model->task_id ?>" class="top-new-form well form" style='width: 760px; margin-top: 20px; margin-bottom: 40px'>
            <?php
            if (Permission::checkPermission($model, PERMISSION_TASK_COMMENT_ADD)) {
                // echo $new_comment_ajax_link;
                echo '<a id="ajax-id-'.uniqid().'" href="#" onclick="create_comment_task('.$model->task_id.'); return false;">'.YII::t('lang','Comment or upload document').'</a>';

                // $new_comment_ajax_link = CHtml::ajaxLink(
                //     YII::t('core','Comment or upload document'), array('taskComment/create', 'task_id' => $model->task_id, 'ajax' => 1), // Yii URL
                //     array('update' => '#form-comment'), // jQuery selector
                //     array('id' => 'ajax-id-' . uniqid())
                // );
            }
            ?>
    </div>

    <div id="new-comment-form-link-holder-<?php echo $model->task_id ?>" style="display: none">
            <?php 
                // echo $new_comment_ajax_link; 
                echo '<a id="ajax-id-'.uniqid().'" href="#" onclick="create_comment_task('.$model->task_id.'); return false;">'.YII::t('lang','Comment or upload document').'</a>';
            ?>
    </div>
    
    <div id="comments-thread-<?php echo $model->task_id ?>" class="comments-thread">
            <?php
    // existing comments
            $project = Project::model()->findByPk($model->project_id);
            foreach ($task_comments as $comment) {
                $thread_data = array('comment' => $comment, 'task_id' => $model->task_id);
                $thread_data['task_comment_documents'] = $task_comment_documents;
                $thread_data['task'] = $model;
                $thread_data['project'] = $project;

                if (isset($task_comment_replies[$comment->task_comment_id])) {
                    $thread_data['replies'] = $task_comment_replies[$comment->task_comment_id];
                }
                echo $this->renderPartial('/taskComment/_viewThread', $thread_data);
            }
            ?>
    </div> <!-- comments-thread div -->

</div> <!-- task-main-body -->

<div id="side-menu" class="" style="width: 260px; float: right; border-top: none;">
    <div style="text-align: left; display: block; width: 100%">
<!-- <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.min.js"></script> -->
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap.min.js"></script>    
<script type="text/javascript">
    $(document).ready(function() {
        // $("#task-main-body").show(); //remove respective tab content
        $("#task-main-body").css('visibility','visible');
        var task_id = '<?php echo $model->task_id; ?>'; 
         
        $('#lc-process-checklist').load('<?php echo $this->createUrl('/process_checklist/default/index', array('entity_type' => 'task', 'entity_id' => $model->task_id));
        ?>');

        $('#task-progress').load('<?php echo $this->createUrl('/task_progress/default/index', array('task_id' => $model->task_id, 'ajax' => 1));
    ?>');
            
        if('<?php echo $model->task_status; ?>' != '<?php echo TASK_STATUS_COMPLETED; ?>')
            $("#status-badge-"+task_id).show();
        else
            $("#status-badge-"+task_id).hide();
        
        if('<?php echo $model->task_type; ?>' != '<?php echo Task::TASK_TYPE_ISSUE; ?>')
            $("#task-wap-type-"+task_id).toggleClass('btn-group badge badge-info');
        else
            $("#task-wap-type-"+task_id).toggleClass('btn-group badge badge-warning');
        
        $("#btn-issue-priority-action-"+task_id).removeClass('btn dropdown-toggle btn-group badge badge').addClass('btn-group badge task_bage');;
    });
    $(".closeTab").click(function () {
      var tabContentId = $(this).parent().attr("href");
      $(this).parent().parent().remove(); //remove li of tab
      var project_id = '<?php echo $model->project_id; ?>';
      window.location.href = '<?php echo $this->createUrl("/lbProject/default/view/id/".$model->project_id.""); ?>';///'.$model->project_id.
      // alert(project_id);
      // $('a[href$="#tab2"]').tab('show'); // Select first tab
      // $("#task-main-body").remove(); //remove respective tab content

    });
    function create_comment_task(task_id){
        // alert(task_id);
        $("#form-comment-"+task_id+"").html("Loading...");
        var replay = "replay";
        $.ajax({
            'type':'POST',
            'url':'<?php echo $this->createUrl('taskComment/create'); ?>',
            data:{replay:replay,task_id:task_id},
            success:function(data){
                // alert(data);
                $("#form-comment-"+task_id+"").html(data);
            }
        });
    }
    function loadContent(e){

        var tabId = e.target.getAttribute("href");

        var ctUrl = ''; 

        if(tabId == '#tab1') {
            $("#task-main-body").hide();
            ctUrl = '<?php echo $this->createUrl("/lbProject/default/projectall"); ?>';
        } else if(tabId == '#tab2') {
            $("#task-main-body").hide();
            ctUrl = '<?php echo $this->createUrl("/lbProject/default/taskall"); ?>';
        } else if(tabId == '#tab3') {
            $("#task-main-body").hide();
            ctUrl = '<?php echo $this->createUrl("/lbProject/default/documentall"); ?>';
        } else if (tabId == '#tab4') {
            $("#task-main-body").hide();
            ctUrl = '<?php echo $this->createUrl("/lbProject/default/wikiall"); ?>';
        } else if (tabId == '#tab5') {
            $("#task-main-body").show();
        }

        if(ctUrl != '') {
            // $("#task-main-body").hide(); //remove respective tab content
            $.ajax({
                url      : ctUrl,
                type     : 'POST',
                dataType : 'html',
                cache    : false,
                success  : function(html)
                {
                    jQuery(tabId).html(html);
                },
                error:function(){
                        alert('Request failed');
                }
            });
        }

        preventDefault();
        return false;
    }
    function linxcircleTaskUpdateTodoStatus(el)
    {
        var value = 0;
        if (el.is(":checked"))
            value = 1;
        $.post("<?php echo $this->createUrl('taskComment/ajaxUpdateField'); ?>", {
            ajax_id: 'bootstrap-x-editable',
            name: 'task_comment_to_do_completed',
            pk: el.attr("data-id-value"),
            value: value
        });
    }
    function linxcircleTaskUpdateSticky(el)
    {
        var value = 0;
        if (el.is(":checked"))
            value = 1;
        $.post("<?php echo $this->createUrl('task/ajaxUpdateField'); ?>", {
            ajax_id: 'bootstrap-x-editable',
            name: 'task_is_sticky',
            pk: el.attr("data-id-value"),
            value: value
        });
    }
    function updateStatus(task_id,status){
        $("#task-btn-status-"+task_id).html('Loading...');
        $.ajax({
            'type':'POST',
            'url':'<?php echo $this->createUrl('task/updateStatus',array('id'=>$model->task_id)); ?>',
            data:{status:status},
            success:function(data){
                var respon = jQuery.parseJSON(data);
                if (respon.status == "success")
                {
                    var btnLabel = '';
                    if(respon.task_status == '<?php echo TASK_STATUS_ACTIVE; ?>')
                    {
                        btnLabel = '<?php echo $lopen.'&triangledown;'; ?>';
                        $("#status-badge-"+task_id).show();
                    }
                    else
                    {
                        btnLabel = '<?php echo $ldone.'&triangledown;'; ?>';
                        $("#status-badge-"+task_id).hide();
                    }
                    $("#task-btn-status-"+task_id).html(btnLabel);
                    
                }
            }
                    
        });
    }
    
    function updateType(task_id,type_id){
       $("#task-type-"+task_id).html('Loading...');
       $.ajax({
            'type':'POST',
            'url':'<?php echo $this->createUrl('task/updateType',array('id'=>$model->task_id)); ?>',
            data:{type_id:type_id},
            success:function(data){
                var respon = jQuery.parseJSON(data);
                if (respon.status == "success")
                {
                    $("#task-wap-type-"+task_id).removeClass('btn-group badge badge-warning').addClass('btn-group badge badge-info');
                    var btnLabel = '';
                    if(respon.task_type == '<?php echo Task::TASK_TYPE_FEATURE; ?>')
                        btnLabel = '<?php echo $lfeature.'&triangledown;'; ?>';
                    else if(respon.task_type == '<?php echo Task::TASK_TYPE_ISSUE; ?>')
                    {
                        btnLabel = '<?php echo $lissue.'&triangledown;'; ?>';
                        $("#task-wap-type-"+task_id).removeClass('btn-group badge badge-info').addClass('btn-group badge badge-warning');
                    }
                    else if(respon.task_type == '<?php echo Task::TASK_TYPE_FORUM; ?>')
                        btnLabel = '<?php echo $lforum.'&triangledown;'; ?>';
                    else
                        btnLabel = '<?php echo $lother.'&triangledown;'; ?>';
                    $("#task-type-"+task_id).html(btnLabel);
                }
            }
                    
        });
    }
</script>