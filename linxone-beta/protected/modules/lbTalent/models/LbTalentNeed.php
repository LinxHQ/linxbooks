<?php

/**
 * This is the model class for table "lb_talent_need".
 *
 * The followings are the available columns in table 'lb_talent_need':
 * @property integer $lb_record_primary_key
 * @property string $lb_talent_name
 * @property integer $lb_department_id
 * @property integer $lb_talent_status_id
 * @property string $lb_talent_description
 * @property string $lb_talent_start_date
 * @property string $lb_talent_end_date
 */
class LbTalentNeed extends CLBActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_talent_need';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lb_talent_name, lb_department_id, lb_talent_description, lb_talent_start_date, lb_talent_end_date', 'required'),
			array('lb_department_id, lb_talent_status_id', 'numerical', 'integerOnly'=>true),
			array('lb_talent_name', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lb_record_primary_key, lb_talent_name, lb_department_id, lb_talent_status_id, lb_talent_description, lb_talent_start_date, lb_talent_end_date', 'safe', 'on'=>'search'),
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
			'lb_talent_name' => 'Training Need',
			'lb_department_id' => 'Departments',
			'lb_talent_status_id' => 'Talent Status',
			'lb_talent_description' => 'Description',
			'lb_talent_start_date' => 'Start Date',
			'lb_talent_end_date' => 'End Date',
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

		$criteria->compare('lb_record_primary_key',$this->lb_record_primary_key);
		$criteria->compare('lb_talent_name',$this->lb_talent_name,true);
		$criteria->compare('lb_department_id',$this->lb_department_id);
		$criteria->compare('lb_talent_status_id',$this->lb_talent_status_id);
		$criteria->compare('lb_talent_description',$this->lb_talent_description,true);
		$criteria->compare('lb_talent_start_date',$this->lb_talent_start_date,true);
		$criteria->compare('lb_talent_end_date',$this->lb_talent_end_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbTalentNeed the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
