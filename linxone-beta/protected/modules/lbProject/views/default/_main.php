<?php 
	$list_project = Project::model()->findAll('project_status IN (1)');
	// echo "<pre>";
	// print_r($list_project); exit;
	foreach($list_project as $result_project){

		echo '<div class="media task_item" lc_task_id="" style="height: 30px">
	        <div class="media-body" style=" float: left;width: 620px; height: 55px;">';
	           //  echo "<p style='margin-bottom: -35px;'>".CHtml::link(
            //     Utilities::workspaceLink($result_project['project_name'], array("default/view", "id" => $result_project['project_id'])),
            //     // array('default/view', 'id' => $result_project['project_id']) // Yii URL
            //     array('id' => 'ajax-id-' . uniqid(), 'data-workspace' => '1', 'style' => 'color: #5DA028')
            // )."</p>";
	        echo "<p id='project_name' style='margin-bottom: -35px;'><a href='?tab=task&id_project=".$result_project['project_id']." ' '>".$result_project['project_name']."</a></p>";
	        

	        echo '<div style="display: block; width: auto; margin-left: 55px;">
	                <span class="blur-summary"></span>
	            </div>
	        </div>
	      
	        <div >
	            <div style="float: left; text-align: center">
	                <div style="display: inline">
	                    <p>'.date("d-m-Y", strtotime($result_project['project_start_date'])).'</p>
	                </div><br>
	            </div>
	            
	            <div style=" float: left; margin-left: 10px; text-align: right;">';
	                $this->widget('bootstrap.widgets.TbBadge', array(
	                    'type' => 'success', // 'success', 'warning', 'important', 'info' or 'inverse'
	                    'label' => Task::model()->countTasks($result_project['project_id'], false, 1) . ' tasks',
	                ));
	                echo "&nbsp&nbsp";
	                $this->widget('bootstrap.widgets.TbBadge', array(
	                    'type' => 'warning', // 'success', 'warning', 'important', 'info' or 'inverse'
	                    'label' => Task::model()->countTasks($result_project['project_id'], false, 2) . ' issues',
	                ));  
	                echo "&nbsp&nbsp";
	                $this->widget('bootstrap.widgets.TbBadge', array(
	                    'type' => 'important', // 'success', 'warning', 'important', 'info' or 'inverse'
	                    'label' => Task::model()->countTasks($result_project['project_id'], false, 3) . ' implementations',
	                ));  
	            echo '</div>
	            <div style=" float: left; margin-left: 10px; text-align: right;">
	                <a href="'.Yii::app()->baseUrl.'/lbProject/default/update/id/'.$result_project['project_id'].' "><i class="icon-wrench"></i></a>
	            </div>

	        </div>
	    </div>';
	    echo "<hr />";
	}
 ?>