<?php

/**
 * This is the model class for table "lb_people_volunteers".
 *
 * The followings are the available columns in table 'lb_people_volunteers':
 * @property integer $lb_record_primary_key
 * @property integer $lb_volunteers_active
 * @property integer $lb_entity_id
 * @property string $lb_entity_type
 */
class LbPeopleVolunteers extends CLBActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_people_volunteers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lb_volunteers_active', 'required'),
			array('lb_volunteers_active, lb_entity_id', 'numerical', 'integerOnly'=>true),
			array('lb_entity_type', 'length', 'max'=>30),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lb_record_primary_key, lb_volunteers_active, lb_entity_id, lb_entity_type', 'safe', 'on'=>'search'),
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
			'lb_volunteers_active' => 'Volunteers Active',
			'lb_entity_id' => 'Assign Volunteers',
			'lb_entity_type' => 'Entity Type',
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
		$criteria->compare('lb_volunteers_active',$this->lb_volunteers_active);
		$criteria->compare('lb_entity_id',$this->lb_entity_id);
		$criteria->compare('lb_entity_type',$this->lb_entity_type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbPeopleVolunteers the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
