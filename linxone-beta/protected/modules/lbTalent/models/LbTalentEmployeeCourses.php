<?php

/**
 * This is the model class for table "lb_talent_employee_courses".
 *
 * The followings are the available columns in table 'lb_talent_employee_courses':
 * @property integer $lb_record_primary_key
 * @property integer $lb_course_id
 * @property integer $lb_course_status_id
 * @property string $lb_result_course
 * @property string $lb_create_date
 * @property string $lb_end_date
 * @property integer $lb_talent_need_id
 * @property integer $lb_employee_id
 */
class LbTalentEmployeeCourses extends CLBActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_talent_employee_courses';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lb_course_id, lb_create_date, lb_end_date, lb_talent_need_id, lb_employee_id', 'required'),
			array('lb_course_id, lb_course_status_id, lb_talent_need_id, lb_employee_id', 'numerical', 'integerOnly'=>true),
			array('lb_result_course', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lb_record_primary_key, lb_course_id, lb_course_status_id, lb_result_course, lb_create_date, lb_end_date, lb_talent_need_id, lb_employee_id', 'safe', 'on'=>'search'),
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
			'lb_record_primary_key' => 'Lb Record Primary Key',
			'lb_course_id' => 'Lb Course',
			'lb_course_status_id' => 'Course Status',
			'lb_result_course' => 'Result Course',
			'lb_create_date' => 'Lb Create Date',
			'lb_end_date' => 'Lb End Date',
			'lb_talent_need_id' => 'Lb Talent Need',
			'lb_employee_id' => 'Lb Employee',
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
	public function search($talent_need_id = false)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('lb_record_primary_key',$this->lb_record_primary_key);
		$criteria->compare('lb_course_id',$this->lb_course_id);
		$criteria->compare('lb_course_status_id',$this->lb_course_status_id);
		$criteria->compare('lb_result_course',$this->lb_result_course,true);
		$criteria->compare('lb_create_date',$this->lb_create_date,true);
		$criteria->compare('lb_end_date',$this->lb_end_date,true);
		if($talent_need_id)
			$criteria->compare('lb_talent_need_id',$talent_need_id);
		$criteria->compare('lb_employee_id',$this->lb_employee_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbTalentEmployeeCourses the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getAvailableSkillsEmlpyee($employee_id, $status = false)
	{
		$criteria = new CDbCriteria();
		if($employee_id)
			$criteria->compare ('lb_employee_id', intval($employee_id));
			$criteria->compare ('lb_course_status_id', intval($status));
		return $this->getFullRecords($criteria);
	}
}
