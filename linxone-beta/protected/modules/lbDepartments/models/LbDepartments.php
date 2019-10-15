<?php

/**
 * This is the model class for table "lb_departments".
 *
 * The followings are the available columns in table 'lb_departments':
 * @property integer $lb_record_primary_key
 * @property string $lb_department_name
 * @property string $lb_department_no
 * @property integer $lb_department_phone
 * @property integer $lb_department_fax
 * @property string $lb_department_address
 * @property string $lb_department_city
 * @property string $lb_department_state
 * @property string $lb_department_description
 * @property integer $lb_department_parent_id
 * @property string $lb_department_create_date
 */
class LbDepartments extends CLBActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_departments';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lb_department_name, lb_department_no, lb_department_phone, lb_department_fax, lb_department_address, lb_department_city, lb_department_state, lb_department_description, lb_department_parent_id, lb_department_create_date', 'required'),
			array('lb_department_phone, lb_department_fax, lb_department_parent_id', 'numerical', 'integerOnly'=>true),
			array('lb_department_name', 'length', 'max'=>255),
			array('lb_department_no', 'length', 'max'=>50),
			array('lb_department_city, lb_department_state', 'length', 'max'=>30),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lb_record_primary_key, lb_department_name, lb_department_no, lb_department_phone, lb_department_fax, lb_department_address, lb_department_city, lb_department_state, lb_department_description, lb_department_parent_id, lb_department_create_date', 'safe', 'on'=>'search'),
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
			'lb_department_name' => 'Lb Department Name',
			'lb_department_no' => 'Lb Department No',
			'lb_department_phone' => 'Lb Department Phone',
			'lb_department_fax' => 'Lb Department Fax',
			'lb_department_address' => 'Lb Department Address',
			'lb_department_city' => 'Lb Department City',
			'lb_department_state' => 'Lb Department State',
			'lb_department_description' => 'Lb Department Description',
			'lb_department_parent_id' => 'Lb Department Parent',
			'lb_department_create_date' => 'Lb Department Create Date',
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
		$criteria->compare('lb_department_name',$this->lb_department_name,true);
		$criteria->compare('lb_department_no',$this->lb_department_no,true);
		$criteria->compare('lb_department_phone',$this->lb_department_phone);
		$criteria->compare('lb_department_fax',$this->lb_department_fax);
		$criteria->compare('lb_department_address',$this->lb_department_address,true);
		$criteria->compare('lb_department_city',$this->lb_department_city,true);
		$criteria->compare('lb_department_state',$this->lb_department_state,true);
		$criteria->compare('lb_department_description',$this->lb_department_description,true);
		$criteria->compare('lb_department_parent_id',$this->lb_department_parent_id);
		$criteria->compare('lb_department_create_date',$this->lb_department_create_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbDepartments the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
