<?php

/**
 * This is the model class for table "lb_pastoral_care".
 *
 * The followings are the available columns in table 'lb_pastoral_care':
 * @property integer $lb_record_primary_key
 * @property integer $lb_people_id
 * @property integer $lb_pastoral_care_type
 * @property integer $lb_pastoral_care_pastor_id
 * @property string $lb_pastoral_care_date
 * @property string $lb_pastoral_care_remark
 */
class LbPastoralCare extends CLBActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_pastoral_care';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lb_people_id, lb_pastoral_care_type, lb_pastoral_care_pastor_id, lb_pastoral_care_date', 'required'),
			array('lb_people_id, lb_pastoral_care_type, lb_pastoral_care_pastor_id', 'numerical', 'integerOnly'=>true),
			array('lb_pastoral_care_remark', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lb_record_primary_key, lb_people_id, lb_pastoral_care_type, lb_pastoral_care_pastor_id, lb_pastoral_care_date, lb_pastoral_care_remark', 'safe', 'on'=>'search'),
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
			'lb_pastoral_care_type' => 'Pastoral Care Type',
			'lb_pastoral_care_pastor_id' => 'Pastoral Care Pastor',
			'lb_pastoral_care_date' => 'Pastoral Care Date',
			'lb_pastoral_care_remark' => 'Pastoral Care Remark',
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
	public function search($date_time_pc=false)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('lb_record_primary_key',$this->lb_record_primary_key);
		$criteria->compare('lb_people_id',$this->lb_people_id);
		$criteria->compare('lb_pastoral_care_type',$this->lb_pastoral_care_type);
		$criteria->compare('lb_pastoral_care_pastor_id',$this->lb_pastoral_care_pastor_id);
		if($date_time_pc){
			$criteria->compare('lb_pastoral_care_date',$date_time_pc);
		} else {
			$criteria->compare('lb_pastoral_care_date',$this->lb_pastoral_care_date,true);
		}
		$criteria->compare('lb_pastoral_care_remark',$this->lb_pastoral_care_remark,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbPastoralCare the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
