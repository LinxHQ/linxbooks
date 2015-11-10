<?php

/**
 * This is the model class for table "lb_employee_payment_details".
 *
 * The followings are the available columns in table 'lb_employee_payment_details':
 * @property integer $lb_record_primary_key
 * @property integer $employee_id
 * @property string $payment_date
 * @property string $payment_amount
 * @property integer $payment_created_by
 * @property integer $payment_month
 * @property integer $payment_year
 */
class LbEmployeePaymentDetails extends CLBActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_employee_payment_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('employee_id, payment_date, payment_amount, payment_created_by, payment_month, payment_year', 'required'),
			array('employee_id, payment_created_by, payment_month, payment_year', 'numerical', 'integerOnly'=>true),
			array('payment_amount', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lb_record_primary_key, employee_id, payment_date, payment_amount, payment_created_by, payment_month, payment_year', 'safe', 'on'=>'search'),
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
			'employee_id' => 'Employee',
			'payment_date' => 'Payment Date',
			'payment_amount' => 'Payment Amount',
			'payment_created_by' => 'Payment Created By',
			'payment_month' => 'Payment Month',
			'payment_year' => 'Payment Year',
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
		$criteria->compare('employee_id',$this->employee_id);
		$criteria->compare('payment_date',$this->payment_date,true);
		$criteria->compare('payment_amount',$this->payment_amount,true);
		$criteria->compare('payment_created_by',$this->payment_created_by);
		$criteria->compare('payment_month',$this->payment_month);
		$criteria->compare('payment_year',$this->payment_year);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbEmployeePaymentDetails the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
