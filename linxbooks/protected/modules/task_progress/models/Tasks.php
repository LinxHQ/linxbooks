<?php

/**
 * This is the model class for table "tasks".
 *
 * The followings are the available columns in table 'tasks':
 * @property integer $task_id
 * @property integer $project_id
 * @property string $task_name
 * @property string $task_start_date
 * @property string $task_end_date
 * @property integer $task_owner_id
 * @property string $task_created_date
 * @property integer $task_public_viewable
 * @property integer $task_status
 * @property string $task_last_commented_date
 * @property string $task_description
 * @property integer $task_is_sticky
 * @property integer $task_type
 */
class Tasks extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tasks';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('project_id, task_name, task_created_date', 'required'),
			array('project_id, task_owner_id, task_public_viewable, task_status, task_is_sticky, task_type', 'numerical', 'integerOnly'=>true),
			array('task_name', 'length', 'max'=>255),
			array('task_start_date, task_end_date, task_last_commented_date, task_description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('task_id, project_id, task_name, task_start_date, task_end_date, task_owner_id, task_created_date, task_public_viewable, task_status, task_last_commented_date, task_description, task_is_sticky, task_type', 'safe', 'on'=>'search'),
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
			'task_id' => 'Task',
			'project_id' => 'Project',
			'task_name' => 'Task Name',
			'task_start_date' => 'Task Start Date',
			'task_end_date' => 'Task End Date',
			'task_owner_id' => 'Task Owner',
			'task_created_date' => 'Task Created Date',
			'task_public_viewable' => 'Task Public Viewable',
			'task_status' => 'Task Status',
			'task_last_commented_date' => 'Task Last Commented Date',
			'task_description' => 'Task Description',
			'task_is_sticky' => 'Task Is Sticky',
			'task_type' => 'Task Type',
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

		$criteria->compare('task_id',$this->task_id);
		$criteria->compare('project_id',$this->project_id);
		$criteria->compare('task_name',$this->task_name,true);
		$criteria->compare('task_start_date',$this->task_start_date,true);
		$criteria->compare('task_end_date',$this->task_end_date,true);
		$criteria->compare('task_owner_id',$this->task_owner_id);
		$criteria->compare('task_created_date',$this->task_created_date,true);
		$criteria->compare('task_public_viewable',$this->task_public_viewable);
		$criteria->compare('task_status',$this->task_status);
		$criteria->compare('task_last_commented_date',$this->task_last_commented_date,true);
		$criteria->compare('task_description',$this->task_description,true);
		$criteria->compare('task_is_sticky',$this->task_is_sticky);
		$criteria->compare('task_type',$this->task_type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Tasks the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function updateSheduleTask($task_id,$task_start,$task_end)
        {
            $task = Tasks::model()->findByPk($task_id);
            $task->task_start_date = date('Y-m-d',  strtotime($task_start));
            $task->task_end_date = date('Y-m-d',  strtotime($task_end));
            
            if($task->save())
                return true;
            return false;
            
        }
        
        /**
         * Lấy danh sách các task trong 1 project
         * @param type $project_id
         * @param type $account_id
         * @param type $status
         * @return \CActiveDataProvider
         */
        public function taskProject($project_id,$account_id,$status=false,$order=false,$sort='DESC')
        {
            
            $criteria=new CDbCriteria;
            
            $criteria->join = "LEFT JOIN task_assignees ta ON ta.task_id = t.task_id";
            
            $criteria->compare('project_id', intval($project_id));
            $criteria->compare('ta.account_id', intval($account_id));
            
            if($order)
                $criteria->order = "$order $sort";

            if($status)
                $criteria->compare('task_status', $status);
            
            
            $dataProvider = new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
            )); 
            
            return $dataProvider;
            
        }
        
        /**
         * Tính tổng số task open trong 1 dự án được gán cho nhân viên
         * @param type $project_id
         * @param type $accout_id
         * @param type $status
         */
        public function calculateTaskOneProject($project_id,$account_id)
        {
            $task = $this->taskProject($project_id, $account_id,0);
            
            return $task->totalItemCount;
        }
        
        /**
         * Tổng số task, thời gian bé nhất, thời gian lớn nhất cua tat ca dự án được gán cho nhân viên
         * @param type $project_id
         * @param type $accout_id
         * @param type $status
         */
        public function generalAccountProject($account_id)
        {
            $project_member = ProjectMember::model()->getProjectByMember($account_id);
            
            $total_task = 0;$start_arr = array(); $end_arr = array();
            $i=0;
            foreach ($project_member->data as $project_member_item) {
                $project_id = $project_member_item->project_id;
                $account_id = $project_member_item->account_id;
                
                if($this->getStartTaskProject($project_id,$account_id)!="Null")
                    $start_arr[$i] = $this->getStartTaskProject($project_id,$account_id);
                if($this->getEndTaskProject($project_id, $account_id)!="Null")
                    $end_arr[$i] = $this->getEndTaskProject($project_id, $account_id);
                $total_task+=$this->calculateTaskOneProject($project_id, $account_id);
                $i++;
            }
            
            $generalAP = array();
            
            $generalAP['total_task'] = $total_task;
            
            if(count($start_arr)>0)
                $generalAP['start'] = min($start_arr);
            else
                $generalAP['start'] = 'Null';
            
            if(count($end_arr)>0)
                $generalAP['end'] = max($end_arr);
            else
                $generalAP['end'] = 'Null';

            
            return $generalAP;
        }
        
        /**
         * Lấy thời gian bé nhất trong các open task của 1 project
         * @param type $project_id
         * @param type $account_id
         * @param type $status
         * @return string
         */
        public function getStartTaskProject($project_id,$account_id)
        {
            $task = $this->taskProject($project_id, $account_id,0, 'task_start_date', 'ASC');
            
            if(count($task->data)>0)
            {
                if($task->data[0]->task_start_date=='0000-00-00')
                    return 'Null';
                return date('d-M-Y',  strtotime($task->data[0]->task_start_date));
            }
            else
                return 'Null';
        }
        
        /**
         * Lấy thời gian lơn nhất trong các open task của 1 project
         * @param type $project_id
         * @param type $account_id
         * @param type $status
         * @return string
         */
        public function getEndTaskProject($project_id,$account_id)
        {
            $task = $this->taskProject($project_id, $account_id,0, 'task_start_date', 'DESC');
            
            if(count($task->data)>0)
            {
                if($task->data[0]->task_end_date=='0000-00-00')
                    return 'Null';
                return date('d-M-Y',strtotime($task->data[0]->task_end_date)) ;
            }
            else
                return 'Null';
        }
}
