<?php

/**
 * This is the model class for table "leave_in_lieu".
 *
 * The followings are the available columns in table 'leave_in_lieu':
 * @property integer $leave_in_lieu_id
 * @property string $leave_in_lieu_name
 * @property string $leave_in_lieu_day
 * @property double $leave_in_lieu_totaldays
 * @property integer $account_create_id
 */
class LeaveInLieu extends CLBActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'leave_in_lieu';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('leave_in_lieu_name, leave_in_lieu_day, leave_in_lieu_totaldays', 'required'),
			array('account_create_id', 'numerical', 'integerOnly'=>true),
			array('leave_in_lieu_totaldays', 'numerical'),
			array('leave_in_lieu_name', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('leave_in_lieu_id, leave_in_lieu_name, leave_in_lieu_day, leave_in_lieu_totaldays, account_create_id', 'safe', 'on'=>'search'),
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
			// 'leave_in_lieu_id' => 'Leave In Lieu',
			'leave_in_lieu_name' => 'Leave In Lieu',
			'leave_in_lieu_day' => 'Date',
			'leave_in_lieu_totaldays' => 'Total of Days',
			// 'account_create_id' => 'Account Create',
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

		$criteria->compare('leave_in_lieu_id',$this->leave_in_lieu_id);
		$criteria->compare('leave_in_lieu_name',$this->leave_in_lieu_name,true);
		$criteria->compare('YEAR(leave_in_lieu_day)',$this->leave_in_lieu_day,true);
		$criteria->compare('leave_in_lieu_totaldays',$this->leave_in_lieu_totaldays);
		$criteria->compare('account_create_id',$this->account_create_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LeaveInLieu the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
