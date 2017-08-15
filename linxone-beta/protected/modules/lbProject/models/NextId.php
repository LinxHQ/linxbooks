<?php

/**
 * This is the model class for table "next_ids".
 *
 * The followings are the available columns in table 'next_ids':
 * @property integer $next_id
 * @property integer $subcription_id
 * @property string $task_next
 * @property string $issue_next
 * @property string $implementation_next
 */
class NextId extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return NextId the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'next_ids';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('subcription_id', 'required'),
			array('next_id, subcription_id', 'numerical', 'integerOnly'=>true),
			array('task_next, issue_next, implementation_next', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('next_id, subcription_id, task_next, issue_next, implementation_next', 'safe', 'on'=>'search'),
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
			'next_id' => 'Next',
			'subcription_id' => 'Subcription',
			'task_next' => 'Task Next',
			'issue_next' => 'Issue Next',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('next_id',$this->next_id);
		$criteria->compare('subcription_id',$this->subcription_id);
		$criteria->compare('task_next',$this->task_next,true);
		$criteria->compare('issue_next',$this->issue_next,true);
                $criteria->compare('implementation_next', $this->implementation_next,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function addNextId($type){
            $subscript_id = Yii::app()->user->linx_app_selected_subscription;
            $LastNextId = $this->model()->find('subcription_id='.intval($subscript_id));
            if(count($LastNextId)<=0)
            {
                $NextId = new NextId();
                $NextId->next_id = "";
                $NextId->subcription_id = $subscript_id;
                $NextId->issue_next =1;
                $NextId->task_next = 1;
                $NextId->implementation_next =1;
                $NextId->save();
                $LastNextId = $this->model()->find('subcription_id='.intval($subscript_id));
            }
            if($type=="issue")
                $LastNextId->issue_next++;
            elseif($type=="task")
                $LastNextId->task_next++;
            elseif($type=="implementation")
                $LastNextId->implementation_next++;
            
            if($LastNextId->save())
                return true;
            return false;
            
        }
        
        public function getNextId($type){
            $subscript_id = Yii::app()->user->linx_app_selected_subscription;
            $LastNextId = $this->model()->find('subcription_id='.intval($subscript_id));
            if(count($LastNextId)<=0)
            {
                $NextId = new NextId();
                $NextId->next_id = "";
                $NextId->subcription_id = $subscript_id;
                $NextId->issue_next =1;
                $NextId->task_next = 1;
                $NextId->implementation_next = 1;
                $NextId->save();
                $LastNextId = $this->model()->find('subcription_id='.intval($subscript_id));
            }
            if($type=="issue")
                return $LastNextId->issue_next;
            elseif($type=="task")
                return $LastNextId->task_next;
            elseif($type=="implementation")
                return $LastNextId->implementation_next;
        }
}