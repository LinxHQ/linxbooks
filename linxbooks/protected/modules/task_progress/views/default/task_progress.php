<?php
/*@var task_id*/

$completed = TaskProgress::model()->calculateCompleted($task_id);
$lapsed = TaskProgress::model()->calculateLapsed($task_id);
$bg_completed = TaskProgress::model()->getProgressColor($task_id);
TaskProgress::model()->calculatePlanned($task_id);
?>
<div id="task-progress" style="margin-top: 20px;width: 230px;overflow: hidden;">
    <div>
        <div style="float: left;width: 75px;">Completed: </div>
        <div class="progress" style="float: right;width: 150px;">
            <div class="progress-bar bar-computer" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $completed; ?>%; text-align: right; background: <?php echo $bg_completed; ?>">
                <span class="sr-only"><?php echo $completed; ?>%</span>
            </div>
        </div>
    </div>
    <div style="clear: both;">
        <div style="width: 75px;float: left;">Lapsed:</div> 
        <div class="progress" style="float: right;width: 150px;">
            <div class="progress-bar bar-lapsed" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $lapsed; ?>%; text-align: right; background: #9fc5f8;">
                <span class="sr-only"><?php echo $lapsed; ?>%</span>
            </div>
        </div>
    </div>
</div>
