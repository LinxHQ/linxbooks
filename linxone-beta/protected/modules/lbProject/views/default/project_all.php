<style type="text/css">
	.add_color{
		color: white !important;
	}
</style>
<?php 
	if(isset($_GET['id'])){
		$project_id = $_GET['id'];
		echo '<input type="hidden" id="project_id" value="'.$project_id.'">';
	}
	$list_project = Project::model()->findAll();
	foreach($list_project as $result_project){
		echo '<div style="margin-top: 10px;"></div>';
		echo '<div id="'.$result_project['project_id'].'" class="task_item" lc_task_id="" style="height: 58px;margin: -10px 0px -10px 0px;">
	        <div class="media-body" style=" float: left;width: 50%; height: 55px;">';
            // $project_members = ProjectMember::model()->getProjectMembers($result_project['project_id']);
            // $member_count = 0;
            // foreach ($project_members as $p_m) {
            //     if ($member_count > 7) {
            //         echo "...";
            //         break;
            //     }
            //     // echo AccountProfile::model()->getProfilePhoto($p_m->account_id);
            //     $member_count++;
            // }
            $project_members_Manager = ProjectMember::model()->getProjectManager($result_project['project_id']);
            $full_name_Manager = AccountProfile::model()->getFullName($project_members_Manager['account_id']);
            if($full_name_Manager){
            	echo ' <a href="#" data-toggle="tooltip" title="'.$full_name_Manager.'"><img width="55" data-toggle="tooltip" src="'.Yii::app()->baseUrl.'/images/lincoln-default-profile-pic.png" class="img-circle"></a> ';
            }
            echo '<a class="color" href="'.Yii::app()->getBaseUrl().'/index.php/lbProject/default/view/id/'.$result_project['project_id'].'"> '.$result_project['project_name'].'</a>';

	        echo '<div style="display: block; width: auto; margin-left: 55px;">
	                <span class="blur-summary"></span>
	            </div>
	        </div>';
	        $list_member_in_project = ProjectMember::model()->findAll('project_member_is_manager IN ('.PROJECT_MEMBER_IS_NOT_MANAGER.') AND project_id IN ('.$result_project['project_id'].')');
	     //    echo '<div>';
		    //     foreach($list_member_in_project as $result_list_member_in_project) {
		    //     	$full_name_Members = AccountProfile::model()->getFullName($result_list_member_in_project['account_id']);
		    //     	// echo AccountProfile::model()->getProfilePhoto($result_list_member_in_project['account_id']);
		    //     	// <img width="30" src="/linxbooks/images/lincoln-default-profile-pic.png" class="img-circle" alt="'.$full_name_Members.'">
		    //     	echo ' <a href="#" data-toggle="tooltip" title="'.$full_name_Members.'"><img width="30" data-toggle="tooltip" src="'.Yii::app()->baseUrl.'/images/lincoln-default-profile-pic.png" class="img-circle"></a> ';
		    //     }
		    // echo '</div>';
	        echo '<div style="float:right;">
	            <div style="float: left; text-align: center; margin-left: -39px; margin-top: 15px;">
	                <div style="display: inline">
	                    <p>'.date("d-m-Y", strtotime($result_project['project_start_date'])).'</p>
	                </div><br>
	            </div>

	            
	            <div style="float: left;margin-left: 10px; text-align: right; margin-top: 14px;">';
	            	$this->widget('bootstrap.widgets.TbBadge', array(
	                    'type' => 'warning', // 'success', 'warning', 'important', 'info' or 'inverse'
	                    'label' => Task::model()->countTasks($result_project['project_id'], false, 2) .  Yii::t('lang',' Issue'),
	                ));
	                echo "&nbsp&nbsp";
	                $this->widget('bootstrap.widgets.TbBadge', array(
	                    'type' => 'success', // 'success', 'warning', 'important', 'info' or 'inverse'
	                    'label' => Task::model()->countTasks($result_project['project_id'], false, 1) .  Yii::t('lang',' Task'),
	                ));
	                echo "&nbsp&nbsp";
	                $this->widget('bootstrap.widgets.TbBadge', array(
	                    'type' => 'important', // 'success', 'warning', 'important', 'info' or 'inverse'
	                    'label' => Task::model()->countTasks($result_project['project_id'], false, 3) .  Yii::t('lang',' Implementations'),
	                ));  
	            echo '</div>
	            <div style="float: left; margin-left: 10px; text-align: right; margin-top: 15px;">
	                <a href="'.Yii::app()->baseUrl.'/lbProject/default/update/id/'.$result_project['project_id'].' "><i class="icon-wrench"></i></a>
	                <a href="'.Yii::app()->getBaseUrl().'/index.php/lbProject/projectMember/create/project_id/'.$result_project['project_id'].'"><img width="17" src="https://cdn1.iconfinder.com/data/icons/users-and-groups/38/user-group-add-512.png" /></a>
	                
	            </div>

	        </div>
	    </div>';
	    ?>
<?php
	echo "<hr />";
	}
 ?>
 
<script type="text/javascript">
$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();
	var project_id = $("#project_id").val();
	if(project_id){
		$("#"+project_id+"").css( "background-color", "rgb(91, 183, 91)" );
		$("#"+project_id+"").css( "padding", "10px" );
		$("#"+project_id+"").css( "color", "white" );
		$("#"+project_id+" .test").css("color", "white !important");
		$("#"+project_id+" .icon-wrench").addClass("icon-white");
		$("#"+project_id+" .color").addClass("add_color");
		// $("#"+project_id+" .badge").addClass("icon-white");
		$("#"+project_id+" .badge").removeClass("badge-success");
		// $("#"+project_id+" .badge").addClass("badge-info");
		// $("#task-main-body").css('visibility','hidden');
	}
});
</script>