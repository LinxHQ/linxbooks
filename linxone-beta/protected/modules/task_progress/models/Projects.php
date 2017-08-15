<?php

/**
 * This is the model class for table "projects".
 *
 * The followings are the available columns in table 'projects':
 * @property integer $project_id
 * @property string $project_name
 * @property integer $project_owner_id
 * @property string $project_start_date
 * @property string $project_description
 * @property integer $project_status
 * @property integer $account_subscription_id
 * @property string $project_latest_activity_date
 * @property integer $project_simple_view
 * @property integer $project_priority
 */

class Projects extends CActiveRecord
{
    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'projects';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('project_name', 'required'),
			array('project_owner_id, project_status, account_subscription_id, project_simple_view, project_priority', 'numerical', 'integerOnly'=>true),
			array('project_name', 'length', 'max'=>255),
			array('project_description', 'length', 'max'=>1000),
			array('project_latest_activity_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('project_id, project_name, project_owner_id, project_start_date, project_description, project_status, account_subscription_id, project_latest_activity_date, project_simple_view, project_priority', 'safe', 'on'=>'search'),
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
			'project_id' => 'Project',
			'project_name' => 'Project Name',
			'project_owner_id' => 'Project Owner',
			'project_start_date' => 'Project Start Date',
			'project_description' => 'Project Description',
			'project_status' => 'Project Status',
			'account_subscription_id' => 'Account Subscription',
			'project_latest_activity_date' => 'Project Latest Activity Date',
			'project_simple_view' => 'Project Simple View',
			'project_priority' => 'Project Priority',
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

		$criteria->compare('project_id',$this->project_id);
		$criteria->compare('project_name',$this->project_name,true);
		$criteria->compare('project_owner_id',$this->project_owner_id);
		$criteria->compare('project_start_date',$this->project_start_date,true);
		$criteria->compare('project_description',$this->project_description,true);
		$criteria->compare('project_status',$this->project_status);
		$criteria->compare('account_subscription_id',$this->account_subscription_id);
		$criteria->compare('project_latest_activity_date',$this->project_latest_activity_date,true);
		$criteria->compare('project_simple_view',$this->project_simple_view);
		$criteria->compare('project_priority',$this->project_priority);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Projects the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

        
}
