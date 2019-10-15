<?php

/**
 * This is the model class for table "lb_small_group_people".
 *
 * The followings are the available columns in table 'lb_small_group_people':
 * @property integer $lb_record_primary_key
 * @property integer $lb_small_group_id
 * @property integer $lb_people_id
 * @property integer $lb_position_id
 * @property integer $lb_mem_small_active
 */
class LbSmallGroupPeople extends CLBActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_small_group_people';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lb_small_group_id, lb_people_id, lb_position_id, lb_mem_small_active', 'required'),
			array('lb_small_group_id, lb_people_id, lb_position_id, lb_mem_small_active', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lb_record_primary_key, lb_small_group_id, lb_people_id, lb_position_id, lb_mem_small_active', 'safe', 'on'=>'search'),
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
			'lb_small_group_id' => 'Small Group',
			'lb_people_id' => 'People',
			'lb_position_id' => 'Position',
			'lb_mem_small_active' => 'Active',
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
	public function search($small_group_id)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('lb_record_primary_key',$this->lb_record_primary_key);
		if($small_group_id) {
			$criteria->compare('lb_small_group_id',$small_group_id);
		} else {
			$criteria->compare('lb_small_group_id',$this->lb_small_group_id);
		}
		$criteria->compare('lb_people_id',$this->lb_people_id);
		$criteria->compare('lb_position_id',$this->lb_position_id);
		$criteria->compare('lb_mem_small_active',$this->lb_mem_small_active);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbSmallGroupPeople the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
