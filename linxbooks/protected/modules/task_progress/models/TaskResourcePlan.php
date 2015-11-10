<?php

/**
 * This is the model class for table "task_resource_plan".
 *
 * The followings are the available columns in table 'task_resource_plan':
 * @property integer $trp_id
 * @property integer $task_id
 * @property integer $account_id
 * @property string $trp_start
 * @property string $trp_end
 * @property integer $trp_work_load
 * @property string $trp_effort
 */
class TaskResourcePlan extends CActiveRecord
{
    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'task_resource_plan';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('task_id, account_id, trp_start, trp_end, trp_work_load, trp_effort', 'required'),
			array('task_id, account_id, trp_work_load', 'numerical', 'integerOnly'=>true),
			//array('trp_effort', 'length', 'max'=>2),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('trp_id, task_id, account_id, trp_start, trp_end, trp_work_load, trp_effort', 'safe', 'on'=>'search'),
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
			'trp_id' => 'Trp',
			'task_id' => 'Task',
			'account_id' => 'Account',
			'trp_start' => 'Trp Start',
			'trp_end' => 'Trp End',
			'trp_work_load' => 'Trp Work Load',
			'trp_effort' => 'Trp Effort',
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

		$criteria->compare('trp_id',$this->trp_id);
		$criteria->compare('task_id',$this->task_id);
		$criteria->compare('account_id',$this->account_id);
		$criteria->compare('trp_start',$this->trp_start,true);
		$criteria->compare('trp_end',$this->trp_end,true);
		$criteria->compare('trp_work_load',$this->trp_work_load);
		$criteria->compare('trp_effort',$this->trp_effort,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TaskResourcePlan the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function addTaskResourcePlan($task_id,$account_id)
        {
            $tr_plan = new TaskResourcePlan();
            
            $tr_plan->task_id = $task_id;
            $tr_plan->account_id = $account_id;
            $tr_plan->trp_start = date('Y-m-d');
            $tr_plan->trp_end = date('Y-m-d');
            $tr_plan->trp_work_load = 0;
            $tr_plan->trp_effort = 0;
            
            if($tr_plan->save())
                return true;
            
            return false;
        }


//        public function updateTaskResourcePlan($trp_id,$trp_start="",$trp_end="",$trp_work_load,$trp_effort)
//        {
//            $tr_plan = TaskResourcePlan::model()->findByPk($trp_id);
//            
//            $tr_plan->trp_start = $trp_start;
//            $tr_plan->trp_end = $trp_end;
//            $tr_plan->trp_work_load = $trp_work_load;
//            $tr_plan->trp_effort = $trp_effort;
//            
//            if($tr_plan->save())
//                return true;
//            
//            return false;
//        }
        
        public function getTaskResourcePlan($task_id,$account_id)
        {
            $tr_plan = TaskResourcePlan::model()->find('task_id = '.  intval($task_id).' AND account_id = '.intval($account_id));
            
            return $tr_plan;
        }
        
        static function getDataWorkLoad()
        {
            $work_load = array();
            for($i=0;$i<=100;$i=$i+5)
                $work_load[$i]=$i.'%';
            
            return $work_load;
        }
        
        /**
         * Tính tổng số task trong 1 dự án được gán cho nhân viên và đã được lên kế hoạch
         * @param type $project_id
         * @param type $accout_id
         */
        public function calculatePlannedTask($project_id,$account_id)
        {
            $criteria=new CDbCriteria;
            $criteria->join = "JOIN tasks ts ON ts.task_id = t.task_id";
            $criteria->compare('ts.project_id', $project_id);
            $criteria->compare('t.account_id', $account_id);
            $criteria->compare('t.trp_work_load', 0,false,'>');
            $criteria->compare('t.trp_effort', 0, false, '>');
            
            $dataProvider = new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
            ));
            
            return $dataProvider->totalItemCount;
        }
        
        /**
         * Tính tổng số task trong 1 dự án được gán cho nhân viên và chưa được lên kế hoạch
         * @param type $project_id
         * @param type $accout_id
         */
        public function calculateUnplannedTask($project_id,$account_id)
        {
            $total_task = Tasks::model()->calculateTaskOneProject($project_id, $account_id);
            $total_plan = $this->calculatePlannedTask($project_id, $account_id);
            
            $total_unplan = $total_task-$total_plan;
            
            return $total_unplan;
        }
}
