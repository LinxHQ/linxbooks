<?php 
	$list_task = Task::model()->findAll();
	foreach($list_task as $result_list_task){
		if($result_list_task['task_type'] == 1){
			$task_type = '<div style="padding-right: 8px;" class="btn-group badge badge-info">Feature</div>';
		} else if ($result_list_task['task_type'] == 2){
			$task_type = '<div style="padding-right: 8px;" class="btn-group badge badge-warning">Issue</div>';
		} else if ($result_list_task['task_type'] == 3){
			$task_type = '<div style="padding-right: 8px;" class="btn-group badge badge-info">Forum</div>';
		}

		if($result_list_task['task_status'] == 0){
			$task_status = '<div style="padding-right: 8px;" class="badge">Open</div>';
		} else if($result_list_task['task_status'] == 1){
			$task_status = '<div style="padding-right: 8px;" class="badge">Done</div>';
		}
		echo '
			<div class="media task_item" style="" lc_task_id="4318">
                <div class="media-body" style=" float: left;width: 700px;">
                            <div style="display: inline; width: 55px; float: left;">
						<a style="display: inline-block;" rel="tooltip" title="You" href="">'.AccountProfile::model()->getProfilePhoto($result_list_task['task_owner_id']).'</a></div> 
				<div style="display: block; width: auto; margin-left: 55px;">
                                        <a data-workspace="1" href="'.Yii::app()->getBaseUrl().'/index.php/lbProject/task/view/id/'.$result_list_task['task_id'].'">'.$result_list_task['task_name'].'</a>                                        <br>
                                        <span class="blur-summary">'.TaskComment::model()->getTaskCommentsDetail($result_list_task['task_id']).'</span>
                                        <br /><span class="blur-summary">'.$task_status.'&nbsp;'.$task_type.'</span>
                                    </div> 
                    
                </div>
              
                <div style="float: left; text-align: center">
                        <div style="display: inline">'.Utilities::displayFriendlyDate($result_list_task['task_end_date']).'</div>                        <br>
                </div>
                
              <div style=" float: left;width: 250px; text-align: right;">
                    <div style="width: 100%; clear: both; float: right;">
                        <a style="display: inline-block;" rel="tooltip" href="">'.AccountProfile::model()->getProfilePhoto(explode(",",Task::model()->getTask_assignees($result_list_task['task_id'])), false, 30).'</a><br>
                    </div>
                </div>
                
            </div><hr />';
	}
 ?>