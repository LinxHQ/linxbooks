<?php

class DefaultController extends Controller
{
	public function actionIndex($task_id=2)
	{
            $this->render('index',array('task_id'=>$task_id));
	}
        
        public function actionAddTaskProcess()
        {
            $model_r = false;$model_p=false;
            if(isset($_POST['task_id']))
            {   
                $task_id = $_POST['task_id'];
                $task_assignee = TaskAssignees::model()->findAll('task_id='.  intval($task_id));

                foreach ($task_assignee as $task_assignee_item) {
                    $account_id = $task_assignee_item->account_id;
                    
                    // Kiem tra xem da tao procress mat dinh cho account nay chua?
                    $assign_procress = TaskProgress::model()->getTaskProgress($task_id, $account_id);
                    count($assign_procress);
                    //END
                    
                    // Neu chua co progess mat dinh thi them progress ban dau cho account nay.
                    if(count($assign_procress)<=0)        
                        $model_p=  TaskProgress::model()->AddTaskProgress($task_id, $account_id);
                    
                    
                    // Kiem tra xem da tao resource plan mat dinh cho account nay chua?
                    $resource_plan = TaskResourcePlan::model()->getTaskResourcePlan($task_id, $account_id);
                    //END
                    
                    // Neu chua co resource plan mat dinh thi them resource plan ban dau cho account nay.
                    if(count($resource_plan)<=0)        
                        $model_r= TaskResourcePlan::model()->addTaskResourcePlan($task_id,$account_id);
                }

            }
            if($model_r || $model_p)
                echo '{"status":"success"}';
            else
                echo '{"status":"fail"}';
        }
        
        function actionUpdateScheduleTask()
        {
            if(isset($_POST['task_id']))
            {
                $task_id = $_POST['task_id'];
                $task_start = $_POST['task_start'];
                $task_end = $_POST['task_end'];
                
                $model = Tasks::model()->updateSheduleTask($task_id, $task_start, $task_end);
                
                if($model)
                    echo '{"status":"success"}';
                else
                    echo '{"status":"fail"}';
            }
            else {
                echo '{"status":"fail"}';
            }
        }
        
        function actionAccountResourceReport($account_id)
        {
            $model = ProjectMember::model()->getProjectByMember($account_id);
            
            $this->render('account_resource_report',array(
                                'model'=>$model,
                                'account_id'=>$account_id,
                    ));
        }
}