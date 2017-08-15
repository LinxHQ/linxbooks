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

		echo '<div id="'.$result_project['project_id'].'" class="media task_item" lc_task_id="" style="height: 50px">
	        <div class="media-body" style=" float: left;width: 620px; height: 55px;">';
            $project_members = ProjectMember::model()->getProjectMembers(431, true);
            $member_count = 0;
            foreach ($project_members as $p_m) {
                if ($member_count > 7) {
                    echo "...";
                    break;
                }
                echo AccountProfile::model()->getProfilePhoto($p_m->account_id);
                $member_count++;
            }
            // echo Utilities::workspaceLink($result_project['project_name'], array("default/view", "id" => $result_project['project_id']));
            echo '<a class="color" href="'.Yii::app()->getBaseUrl().'/index.php/lbProject/default/view/id/'.$result_project['project_id'].'">'.$result_project['project_name'].'</a>';

	        echo '<div style="display: block; width: auto; margin-left: 55px;">
	                <span class="blur-summary"></span>
	            </div>
	        </div>
	      
	        <div >
	            <div style="float: left; text-align: center; margin-left: -39px; margin-top: 15px;">
	                <div style="display: inline">
	                    <p>'.date("d-m-Y", strtotime($result_project['project_start_date'])).'</p>
	                </div><br>
	            </div>
	            
	            <div style="float: left;margin-left: 10px; text-align: right; margin-top: 14px;">';
	            	$this->widget('bootstrap.widgets.TbBadge', array(
	                    'type' => 'warning', // 'success', 'warning', 'important', 'info' or 'inverse'
	                    'label' => Task::model()->countTasks($result_project['project_id'], false, 2) . ' issues',
	                ));
	                echo "&nbsp&nbsp";
	                $this->widget('bootstrap.widgets.TbBadge', array(
	                    'type' => 'success', // 'success', 'warning', 'important', 'info' or 'inverse'
	                    'label' => Task::model()->countTasks($result_project['project_id'], false, 1) . ' tasks',
	                ));
	                echo "&nbsp&nbsp";
	                $this->widget('bootstrap.widgets.TbBadge', array(
	                    'type' => 'important', // 'success', 'warning', 'important', 'info' or 'inverse'
	                    'label' => Task::model()->countTasks($result_project['project_id'], false, 3) . ' implementations',
	                ));  
	            echo '</div>
	            <div style="float: left; margin-left: 10px; text-align: right; margin-top: 15px;">
	                <a href="'.Yii::app()->baseUrl.'/lbProject/default/update/id/'.$result_project['project_id'].' "><i class="icon-wrench"></i></a>
	            </div>

	        </div>
	    </div>';
	    echo "<hr />";
	}
 ?>
<script type="text/javascript">
$(document).ready(function(){
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