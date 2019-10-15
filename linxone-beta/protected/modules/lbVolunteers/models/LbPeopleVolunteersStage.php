<?php

/**
 * This is the model class for table "lb_people_volunteers_stage".
 *
 * The followings are the available columns in table 'lb_people_volunteers_stage':
 * @property integer $lb_record_primary_key
 * @property integer $lb_people_id
 * @property integer $lb_volunteers_id
 * @property integer $lb_volunteers_type
 * @property integer $lb_volunteers_position
 * @property string $lb_volunteers_start_date
 * @property string $lb_volunteers_end_date
 */
class LbPeopleVolunteersStage extends CLBActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_people_volunteers_stage';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lb_people_id, lb_volunteers_id, lb_volunteers_type, lb_volunteers_position, lb_volunteers_start_date, lb_volunteers_end_date', 'required'),
			array('lb_people_id, lb_volunteers_id, lb_volunteers_type, lb_volunteers_position', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lb_record_primary_key, lb_people_id, lb_volunteers_id, lb_volunteers_type, lb_volunteers_position, lb_volunteers_start_date, lb_volunteers_end_date', 'safe', 'on'=>'search'),
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
			'lb_people_id' => 'People',
			'lb_volunteers_id' => 'Volunteers',
			'lb_volunteers_type' => 'Volunteers Type',
			'lb_volunteers_position' => 'Volunteers Position',
			'lb_volunteers_start_date' => 'Volunteers Start Date',
			'lb_volunteers_end_date' => 'Volunteers End Date',
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
		$criteria->compare('lb_people_id',$this->lb_people_id);
		$criteria->compare('lb_volunteers_id',$this->lb_volunteers_id);
		$criteria->compare('lb_volunteers_type',$this->lb_volunteers_type);
		$criteria->compare('lb_volunteers_position',$this->lb_volunteers_position);
		$criteria->compare('lb_volunteers_start_date',$this->lb_volunteers_start_date,true);
		$criteria->compare('lb_volunteers_end_date',$this->lb_volunteers_end_date,true);
		$criteria->limit = 1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbPeopleVolunteersStage the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
