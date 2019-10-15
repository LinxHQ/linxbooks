<?php

/**
 * This is the model class for table "lb_small_groups".
 *
 * The followings are the available columns in table 'lb_small_groups':
 * @property integer $lb_record_primary_key
 * @property string $lb_group_name
 * @property string $lb_group_type
 * @property string $lb_group_district
 * @property integer $lb_group_frequency
 * @property string $lb_group_meeting_time
 * @property string $lb_group_since
 * @property string $lb_group_location
 * @property integer $lb_group_active
 */
class LbSmallGroups extends CLBActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_small_groups';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lb_group_name, lb_group_active', 'required'),
			array('lb_group_frequency, lb_group_active', 'numerical', 'integerOnly'=>true),
			array('lb_group_name, lb_group_location', 'length', 'max'=>255),
			array('lb_group_type, lb_group_district', 'length', 'max'=>50),
			array('lb_group_meeting_time, lb_group_since', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lb_record_primary_key, lb_group_name, lb_group_type, lb_group_district, lb_group_frequency, lb_group_meeting_time, lb_group_since, lb_group_location, lb_group_active', 'safe', 'on'=>'search'),
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
			'lb_record_primary_key' => 'Record Primary Key',
			'lb_group_name' => 'Group Name',
			'lb_group_type' => 'Group Type',
			'lb_group_district' => 'Group District',
			'lb_group_frequency' => 'Group Frequency',
			'lb_group_meeting_time' => 'Group Meeting Time',
			'lb_group_since' => 'Group Since',
			'lb_group_location' => 'Group Location',
			'lb_group_active' => 'Group Active',
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
	public function search($localtion_name=false)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('lb_record_primary_key',$this->lb_record_primary_key);
		$criteria->compare('lb_group_name',$this->lb_group_name,true);
		$criteria->compare('lb_group_type',$this->lb_group_type,true);
		$criteria->compare('lb_group_district',$this->lb_group_district,true);
		$criteria->compare('lb_group_frequency',$this->lb_group_frequency);
		$criteria->compare('lb_group_meeting_time',$this->lb_group_meeting_time,true);
		$criteria->compare('lb_group_since',$this->lb_group_since,true);
		if($localtion_name && $localtion_name != "All") {
			$criteria->compare('lb_group_location',$localtion_name);
		} else {
			$criteria->compare('lb_group_location',$this->lb_group_location,true);
		}
		$criteria->compare('lb_group_active',$this->lb_group_active);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbSmallGroups the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
