<div id="list-task-project-header">
<?php 
    foreach($taskModel->data as $task):
?>
    <div class="two-column-news-block">
        <div class="profile-photo-column" style="width: 40px;">
            <?php echo (isset($task->comments[0]->task_comment_owner_id) ? AccountProfile::model()->getProfilePhoto($task->comments[0]->task_comment_owner_id,0,35)
								: AccountProfile::model()->getProfilePhoto($task->task_owner_id,0,35)) ?>
        </div>
        <div class="news-column" style="width: 380px; font-size: 13px;">
            <?php echo ($task->task_no) ? "<span class='blur'>#".$task->task_no."</span> " : ""; ?>
            <?php echo Utilities::workspaceLink($task->task_name, $task->getTaskURL()); ?>
            <br>
            <?php echo "<span class='blur-summary'>" . $task->getSummary()  . "</span>"; ?>
        </div>
    </div>
<?php endforeach; ?>
    <?php if(count($taskModel->data)<=0) echo YII::t('core','No results found.'); ?>
</div>

