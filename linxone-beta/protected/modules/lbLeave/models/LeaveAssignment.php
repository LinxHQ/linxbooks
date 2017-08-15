<?php

/**
 * This is the model class for table "leave_assignment".
 *
 * The followings are the available columns in table 'leave_assignment':
 * @property integer $assignment_id
 * @property string $assignment_leave_name
 * @property integer $assignment_leave_type_id
 * @property integer $assignment_account_id
 * @property integer $assignment_year
 * @property double $assignment_total_days
 */
class LeaveAssignment extends CLBActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'leave_assignment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('assignment_leave_name, assignment_account_id, assignment_year', 'required'),
			array('assignment_leave_type_id, assignment_account_id, assignment_year', 'numerical', 'integerOnly'=>true),
			array('assignment_total_days', 'numerical'),
			array('assignment_leave_name', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('assignment_id, assignment_leave_name, assignment_leave_type_id, assignment_account_id, assignment_year, assignment_total_days', 'safe', 'on'=>'search'),
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
			'assignment_id' => 'Assignment',
			'assignment_leave_name' => 'Assignment Leave Name',
			'assignment_leave_type_id' => 'Assignment Leave Type',
			'assignment_account_id' => 'Assignment Account',
			'assignment_year' => 'Assignment Year',
			'assignment_total_days' => 'Assignment Total Days',
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
	public function search($type_name=false)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('assignment_id',$this->assignment_id);
		$criteria->compare('assignment_leave_type_id',$this->assignment_leave_type_id);
		$criteria->compare('assignment_account_id',$this->assignment_account_id);
		$criteria->compare('assignment_year',$this->assignment_year);
		$criteria->compare('assignment_total_days',$this->assignment_total_days);
		if($type_name)
			$criteria->compare('assignment_leave_name',$type_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LeaveAssignment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
