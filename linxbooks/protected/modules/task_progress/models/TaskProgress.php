<?php

/**
 * This is the model class for table "task_progress".
 *
 * The followings are the available columns in table 'task_progress':
 * @property integer $tp_id
 * @property integer $task_id
 * @property integer $account_id
 * @property string $tp_percent_completed
 * @property string $tp_days_completed
 * @property string $tp_last_update
 * @property integer $tp_last_update_by
 */
class TaskProgress extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'task_progress';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('task_id, account_id', 'required'),
			array('task_id, account_id, tp_last_update_by', 'numerical', 'integerOnly'=>true),
			array('tp_percent_completed', 'length', 'max'=>3),
			//array('tp_days_completed', 'length', 'max'=>2),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('tp_id, task_id, account_id, tp_percent_completed, tp_days_completed, tp_last_update, tp_last_update_by', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'tp_id' => 'Tp',
			'task_id' => 'Task',
			'account_id' => 'Account',
			'tp_percent_completed' => 'Tp Percent Completed',
			'tp_days_completed' => 'Tp Days Completed',
			'tp_last_update' => 'Tp Last Update',
			'tp_last_update_by' => 'Tp Last Update By',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('tp_id',$this->tp_id);
		$criteria->compare('task_id',$this->task_id);
		$criteria->compare('account_id',$this->account_id);
		$criteria->compare('tp_percent_completed',$this->tp_percent_completed,true);
		$criteria->compare('tp_days_completed',$this->tp_days_completed,true);
		$criteria->compare('tp_last_update',$this->tp_last_update,true);
		$criteria->compare('tp_last_update_by',$this->tp_last_update_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TaskProgress the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getTaskProgress($task_id,$account_id)
        {
            $task_progress = TaskProgress::model()->find('task_id = '.intval($task_id).' AND account_id='.intval($account_id).' ORDER BY tp_last_update DESC, tp_id DESC');
            return $task_progress;
        }
        
        public function AddTaskProgress($task_id,$account_id,$percent_completed=0,$days_completed=0)
        {
            $user_id = Yii::app()->user->id;
            
            $task_progress = new TaskProgress();
            
            $task_progress->tp_id="";
            $task_progress->task_id=$task_id;
            $task_progress->account_id=$account_id;
            $task_progress->tp_days_completed=$days_completed;
            $task_progress->tp_percent_completed=$percent_completed;
            $task_progress->tp_last_update_by = intval($user_id);
            $task_progress->tp_last_update = date('Y-m-d H:i:s');
            
            if($task_progress->save())
                return true;
            return false;
        }
        
        /**
         * % công việc xong thực sự
         * @param type $task_id
         * @return type
         */
        public function calculateCompleted($task_id)
        {
            $completed_task = 0;
            $task_assignee_arr= TaskAssignees::model()->findAll('task_id='.  intval($task_id));
            foreach ($task_assignee_arr as $assignee_task) {
                $account_id = $assignee_task->account_id;
                $task_progress = $this->getTaskProgress($task_id,$account_id);
                $task_progress_plan = TaskResourcePlan::model()->getTaskResourcePlan($task_id, $account_id);
                
                $tp_percent_completed = 0;$trp_work_load=0;
                if(count($task_progress)==1)
                       $tp_percent_completed = $task_progress->tp_percent_completed;
                if(count($task_progress_plan)==1)
                    $trp_work_load = $task_progress_plan->trp_work_load;
                    
                
                $completed_task += ($tp_percent_completed)*($trp_work_load);
            }
            
            return $completed_task/100;
        }
        
        /**
         * % công việc cần xong theo như kế hoạch nhân sự
         * @param type $task_id
         * @return type float
         */
        public function calculatePlanned($task_id)
        {
            $planned = 0;
            $task_assignee_arr= TaskAssignees::model()->findAll('task_id='.  intval($task_id));
            foreach ($task_assignee_arr as $assignee_task) {
                $account_id = $assignee_task->account_id;
                $task_progress_plan = TaskResourcePlan::model()->getTaskResourcePlan($task_id, $account_id);
                
                //Tính % thời gian đãn trãi qua theo kế hoạch
                $date_current = date('Y-m-d');
                $data_plan_start = date('Y-m-d');
                $date_plan_end = date('Y-m-d');
                $trp_work_load = 0;
                if(count($task_progress_plan)==1)
                {
                    $data_plan_start = $task_progress_plan->trp_start;
                    $date_plan_end = $task_progress_plan->trp_end;
                    $trp_work_load = $task_progress_plan->trp_work_load;
                }
                
                if($date_plan_end <= $data_plan_start)
                {
                    $lapsed_plan = 0;
                }
                else
                {
                    //Sô ngày đã làm theo ke hoach.
                    $actual = (strtotime($date_current)-strtotime($data_plan_start))/(60 * 60 * 24);
                    //Số ngày dự kiến theo ke hoach.
                    $est = (strtotime($date_plan_end)-strtotime($data_plan_start))/(60 * 60 * 24);

                    // % thoi gian da trai qua cua nhan su theo ke hoach
                    $lapsed_plan =$actual/$est;

                    if($lapsed_plan>1)
                        $lapsed_plan=100;
                    elseif($lapsed_plan<0)
                        $lapsed_plan=0;
                    else
                        $lapsed_plan=$lapsed_plan*100;
                }
                //END
                
                $planned += $trp_work_load*$lapsed_plan;
                
            }
            $planned = $planned/100;
            
            return round($planned,1);
            
        }
        
        /**
         * % thời gian đã trãi qua của task
         * @param type $task_id
         * @return type
         */
        public function calculateLapsed($task_id)
        {
            $lapsed = 0;
            $task = Tasks::model()->findByPk($task_id);
            $date_current = date('Y-m-d');
            $date_start = $task->task_start_date;
            $date_end = $task->task_end_date;
            

            if(($date_end < $date_start) || ($date_start > $date_current))
            {
                $lapsed = 0;
            }
            elseif($date_end == $date_start)
            {
                $lapsed = 100;
            }
            else
            {
                //Sô ngày đã làm.
                $actual = (strtotime($date_current)-strtotime($date_start))/(60 * 60 * 24);
                //Số ngày dự kiến
                $est = (strtotime($date_end)-strtotime($date_start))/(60 * 60 * 24);
                
                // % thoi gian da trai qua cua task
                $lapsed =$actual/$est;
                
                if($lapsed>1)
                    $lapsed=100;
                elseif($lapsed<0)
                    $lapsed=0;
                else
                    $lapsed=$lapsed*100;
            }
            
            return round($lapsed,1);
            
        }
       
        /**
         * Lấy background của completed
         * @param type $task_id
         * @return string
         */
        public function getProgressColor($task_id)
        {
            $completed = $this->calculateCompleted($task_id);
            $planned = $this->calculatePlanned($task_id);
            $color = "#ea9999";
            if($completed>$planned)
                $color = "#9fc5f8";
            return $color;
        }
        
        /**
         * tong hop cua cac open task ma da duoc gan cho nhan vien nay
         */
        
        public function getTaskOpenByAccount($account_id)
        {
            //Lấy danh sách các project user được gán. (Cần table liên kết giữa account và project)
            $project_arr = Projects::model()->findAll();
            
            return $project_arr;
            
        }
}
