<?php

/* @var $my_tasks_final array of Task models */
// $my_tasks_final[priority: 1,2,3]
//   = array(
//      project_id  => array (0=> project object, 1=> array(task,...)),
//      project_id  => ....
//   )
$subscription_id = Yii::app()->user->linx_app_selected_subscription;

$grid_id = 'linxcircle-my-tasks-grid';
$active_this_saturday = 'btn';
$active_this_month = 'btn';
$active_this_my = 'btn';
$active_this_project = 'btn';
$active_this_all = 'btn';

if($start_by=="this saturday")
    $active_this_saturday = "btn active";
else if($start_by == "last day of this month")
    $active_this_month = "btn active";

$account_id = YII::app()->user->id;
$account_subscrip_id = AccountSubscription::model()->getSubscriptionOwnerID(Yii::app()->user->linx_app_selected_subscription);
$member_array = array();
$account_team_members = AccountTeamMember::model()->getTeamMembers($account_id, true);
foreach ($account_team_members as $m)
{
    $name = AccountProfile::model()->getShortFullName($m->member_account_id);
    $name = mb_check_encoding($name, 'UTF-8') ? $name : utf8_encode($name);

    $member_array[$m->member_account->account_id] = $name;
}

$project_arr = ProjectMember::model()->getProjectByMemberManage($account_id,true);
$project_manager_arr = array();
$project_manager_name = array();
foreach ($project_arr as $project) {
    $project_detail = Project::model()->findByPk($project->project_id);
    if($project_detail)
    {
        if($project_detail->account_subscription_id == Yii::app()->user->linx_app_selected_subscription)
        {
            $project_members = ProjectMember::model()->getProjectMembers($project->project_id, true);
            $dd_array = array();
            foreach ($project_members as $m)
            {
                    $name= AccountProfile::model()->getShortFullName($m->member_account->account_id);
                    $name = Utilities::encodeToUTF8($name);
                    $member_array[$m->member_account->account_id] = $name;
            }
        }
        $project_manager_name[$project_detail->project_id] = $project_detail->project_name;
        $project_manager_arr[$project->project_id] = $project->project_id;
    }
    
}

// Filter
echo '<center>';
echo Yii::t("core",'Start by').": ";
$this->widget('bootstrap.widgets.TbButtonGroup', array(
    'type' => '',
    'toggle' => 'radio', // 'checkbox' or 'radio'
    'buttons' => array(
        array(
            'label' => Yii::t("core",'This Saturday'),
            'buttonType' => 'ajaxButton',
            'ajaxOptions' => array(
                'success' => 'function(data){
				$("#content").html(data);
				resetWorkspaceClickEvent("content");
			}',
                'id' => 'ajax-link' . uniqid()),
            'htmlOptions' => array('live' => false,'class'=>$active_this_saturday),
            'url' => array('task/my',
                'start_by_date' => 'this saturday','member_by'=>$member_by, 'ajax' => 1),
        ),
        array(
            'label' => Yii::t("core",'End').' ' . date('M Y'),
            'buttonType' => 'ajaxButton',
            'ajaxOptions' => array(
                'success' => 'function(data){
				$("#content").html(data);
				resetWorkspaceClickEvent("content");
			}',
                'id' => 'ajax-link' . uniqid()),
            'htmlOptions' => array('live' => false,'class'=>$active_this_month),
            'url' => array('task/my',
                'start_by_date' => 'last day of this month','member_by'=>$member_by, 'ajax' => 1),
        ),
    ),
));
echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
echo Yii::t("core",'Member by').": ";
echo CHtml::dropDownList('member', $member_by, $member_array, array('style'=>'margin-bottom: 2px;','onchange'=>'loadTaskMy(this.value);'));

echo '</center>';
echo '<br>';
//
// HIGH PRIORITY TASK
//
$high_priority_projects = isset($my_tasks_final[Project::PROJECT_PRORITY_HIGH]) ?
        $my_tasks_final[Project::PROJECT_PRORITY_HIGH] : array();
// for each project in this priority, print project name, followed by tasks grid
foreach ($high_priority_projects as $project_id => $data_array) {
    if(!in_array($project_id, $project_manager_arr) && $member_by !=$account_id && $account_id != $account_subscrip_id)
            continue;
    $thisProject = $data_array[0];
    $this_tasks_list = $data_array[1];

    echo '<div style="border-bottom: 5px solid #dcdcdc">';
    echo '<h4 style="display: inline">'. Utilities::workspaceLink(
            $thisProject->project_name,$thisProject->getProjectURL()).'</h4>';
    echo '<div style="float: right">'.$thisProject->getPriorityLabel() . '&nbsp' . '</div>';
    echo '</div>';
    
    // tasks grid
    // end high priority task
    $this->widget('bootstrap.widgets.TbGridView', array(
        'type' => 'striped',
        'dataProvider' => new CArrayDataProvider($this_tasks_list, array(
            'id'=>'id',
            'pagination'=>array(
                'pageSize'=>30,
            ))),
        'id' => "$grid_id-$project_id",
        //'ajaxUpdate' => true,
        'beforeAjaxUpdate' => 'function(id, data){removeWorkspaceClickEvent(null);}',
        'afterAjaxUpdate' => 'function(id, data){addWorkspaceClickEvent(null);}',
        'template' => '{items}{pager}',
        'htmlOptions' => array('style' => 'padding-top: 0px; padding-bottom: 0px;'),
        'columns' => array(
            array(
                'name' => 'task_name',
                'header' => Yii::t("core",'Task'),
                'type' => 'raw',
                'htmlOptions' => array('width' => '400px;'),
                'value' => 'CHtml::link($data["task_name"],Task::model()->getTaskURL($data["task_id"]),array("id" => "ajax-id-" . uniqid(), "data-workspace" => "1"))'
            ),  
            array(
                'header' => '',
                'type'=>'raw',
                'htmlOptions' => array('width' => '200px;'),
                //'value'=>'',
                'value'=>'AccountProfile::model()->getProfilePhoto(explode(",",Task::model()->getTask_assignees($data["task_id"])), false, 30)',
            ),
            array(
                'name' => 'task_start_date',
                'header' => Yii::t("core",'Start'),
                'type' => 'raw',
                'value' => 'Utilities::displayFriendlyDate($data["task_start_date"])',
                'htmlOptions' => array('width' => '100px;')),
            array(
                'name' => 'task_end_date',
                'header' => Yii::t("core",'End Date'),
                'type' => 'raw',
                'value' => '(Task::model()->isOverdue($data["task_id"]) ? '
                . 'LinxUI::getOverdueBadge(Utilities::displayFriendlyDate($data["task_end_date"]))'
                . ':Utilities::displayFriendlyDate($data["task_end_date"]))',
                'htmlOptions' => array('width' => '100px;')),
        )
    ));
} // end foreach - High Priority tasks


//
// NORMAL PRIORITY TASK
//
$normal_priority_projects = isset($my_tasks_final[Project::PROJECT_PRIORITY_NORMAL]) ?
        $my_tasks_final[Project::PROJECT_PRIORITY_NORMAL] : array();

// for each project in this priority, print project name, followed by tasks grid
foreach ($normal_priority_projects as $project_id => $data_array) {
    if(!in_array($project_id, $project_manager_arr) && $member_by !=$account_id && $account_id != $account_subscrip_id)
        continue;
    $thisProject = $data_array[0];
    $this_tasks_list = $data_array[1];

    echo '<div style="border-bottom: 5px solid #dcdcdc">';
    echo '<h4 style="display: inline">'. Utilities::workspaceLink(
            $thisProject->project_name,$thisProject->getProjectURL()).'</h4>';
    echo '<div style="float: right">'.$thisProject->getPriorityLabel() . '&nbsp' . '</div>';
    echo '</div>';
    
    // tasks grid
    // end high priority task
    $this->widget('bootstrap.widgets.TbGridView', array(
        'type' => 'striped',
        'dataProvider' => new CArrayDataProvider($this_tasks_list, array(
            'id'=>'id',
            'pagination'=>array(
                'pageSize'=>30,
            ))),
        'id' => "$grid_id-$project_id",
        //'ajaxUpdate' => true,
        'beforeAjaxUpdate' => 'function(id, data){removeWorkspaceClickEvent(null);}',
        'afterAjaxUpdate' => 'function(id, data){addWorkspaceClickEvent(null);}',
        'template' => '{items}{pager}',
        'htmlOptions' => array('style' => 'padding-top: 0px; padding-bottom: 0px;'),
        'columns' => array(
            array(
                'name' => 'task_name',
                'header' => Yii::t("core",'Task'),
                'type' => 'raw',
                'htmlOptions' => array('width' => '400px;'),
                'value' => 'CHtml::link($data["task_name"],Task::model()->getTaskURL($data["task_id"]),array("id" => "ajax-id-" . uniqid(), "data-workspace" => "1"))'
            ),  
            array(
                'header' => '',
                'type'=>'raw',
                'htmlOptions' => array('width' => '200px;'),
                //'value'=>'',
                'value'=>'AccountProfile::model()->getProfilePhoto(explode(",",Task::model()->getTask_assignees($data["task_id"])), false, 30)',
            ),
            array(
                'name' => 'task_start_date',
                'header' => Yii::t("core",'Start'),
                'type' => 'raw',
                'value' => 'Utilities::displayFriendlyDate($data["task_start_date"])',
                'htmlOptions' => array('width' => '100px;')),
            array(
                'name' => 'task_end_date',
                'header' => Yii::t("core",'End Date'),
                'type' => 'raw',
                'value' => 'Utilities::displayFriendlyDate($data["task_end_date"])',
                'htmlOptions' => array('width' => '100px;')),
        )
    ));
} // end foreach - Normal Priority tasks

//
// LOW PRIORITY TASK
//
$low_priority_projects = isset($my_tasks_final[Project::PROJECT_PRIORITY_LOW])?
        $my_tasks_final[Project::PROJECT_PRIORITY_LOW] : array();

// for each project in this priority, print project name, followed by tasks grid
foreach ($low_priority_projects as $project_id => $data_array) {
    if(!in_array($project_id, $project_manager_arr) && $member_by !=$account_id && $account_id != $account_subscrip_id)
        continue;
    $thisProject = $data_array[0];
    $this_tasks_list = $data_array[1];

    echo '<div style="border-bottom: 5px solid #dcdcdc">';
    echo '<h4 style="display: inline">'. Utilities::workspaceLink(
            $thisProject->project_name,$thisProject->getProjectURL()).'</h4>';
    echo '<div style="float: right">'.$thisProject->getPriorityLabel() . '&nbsp' . '</div>';
    echo '</div>';
    
    // tasks grid
    // end high priority task
    $this->widget('bootstrap.widgets.TbGridView', array(
        'type' => 'striped',
        'dataProvider' => new CArrayDataProvider($this_tasks_list, array(
            'id'=>'id',
            'pagination'=>array(
                'pageSize'=>30,
            ))),
        'id' => "$grid_id-$project_id",
        //'ajaxUpdate' => true,
        'beforeAjaxUpdate' => 'function(id, data){removeWorkspaceClickEvent(null);}',
        'afterAjaxUpdate' => 'function(id, data){addWorkspaceClickEvent(null);}',
        'template' => '{items}{pager}',
        'htmlOptions' => array('style' => 'padding-top: 0px; padding-bottom: 0px;'),
        'columns' => array(
            array(
                'name' => 'task_name',
                'header' => Yii::t("core",'Task'),
                'type' => 'raw',
                'htmlOptions' => array('width' => '400px;'),
                'value' => 'CHtml::link($data["task_name"],Task::model()->getTaskURL($data["task_id"]),array("id" => "ajax-id-" . uniqid(), "data-workspace" => "1"))'
            ),  
            array(
                'header' => '',
                'type'=>'raw',
                'htmlOptions' => array('width' => '200px;'),
                //'value'=>'',
                'value'=>'AccountProfile::model()->getProfilePhoto(explode(",",Task::model()->getTask_assignees($data["task_id"])), false, 30)',
            ),
            array(
                'name' => 'task_start_date',
                'header' => Yii::t("core",'Start'),
                'type' => 'raw',
                'value' => 'Utilities::displayFriendlyDate($data["task_start_date"])',
                'htmlOptions' => array('width' => '100px;')),
            array(
                'name' => 'task_end_date',
                'header' => Yii::t("core",'End Date'),
                'type' => 'raw',
                'value' => 'Utilities::displayFriendlyDate($data["task_end_date"])',
                'htmlOptions' => array('width' => '100px;')),
        )
    ));
} // end foreach - LOW Priority tasks
?>
<script type="text/javascript">
    function loadTaskMy(account_id){
        
        var url = '<?php echo $this->createUrl('my',
                array('start_by_date' => $start_by)); ?>'+'&member_by='+account_id;
                        
        workspaceLoadContent(url);
    }
</script>