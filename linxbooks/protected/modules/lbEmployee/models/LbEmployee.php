<?php

/**
 * This is the model class for table "lb_employee".
 *
 * The followings are the available columns in table 'lb_employee':
 * @property integer $lb_record_primary_key
 * @property string $employee_name
 * @property string $employee_address
 * @property string $employee_birthday
 * @property integer $employee_phone_1
 * @property integer $employee_phone_2
 * @property string $employee_email_1
 * @property string $employee_email_2
 * @property string $employee_code
 * @property string $employee_tax
 * @property string $employee_bank
 * @property string $employee_note
 */
class LbEmployee extends CLBActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_employee';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('employee_name,employee_address, employee_birthday, employee_phone_1, employee_email_1', 'required'),
			array('employee_phone_1, employee_phone_2', 'numerical', 'integerOnly'=>true),
			array('employee_name, employee_email_1, employee_email_2, employee_code, employee_tax', 'length', 'max'=>255),
                    	array('lowest_salary,employee_salary', 'length', 'max'=>10),

			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lb_record_primary_key, employee_name, employee_address, employee_birthday, employee_phone_1, employee_phone_2, employee_email_1,lowest_salary, employee_email_2, employee_code, employee_tax, employee_bank, employee_note', 'safe', 'on'=>'search'),
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
			'employee_name' => 'Name',
			'employee_address' => 'Address',
			'employee_birthday' => 'Birthday',
			'employee_phone_1' => 'Phone 1',
			'employee_phone_2' => 'Phone 2',
			'employee_email_1' => 'Email 1',
			'employee_email_2' => 'Email 2',
			'employee_code' => 'Code',
			'employee_tax' => 'Tax',
			'employee_bank' => 'Bank',
			'employee_note' => 'Note',
			'lowest_salary' => 'Lowest Salary',
			'employee_salary' => 'Salary',
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
	public function search($type=false)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
                
		$criteria->compare('lb_record_primary_key',$this->lb_record_primary_key);
		$criteria->compare('employee_name',$this->employee_name,true);
		$criteria->compare('employee_address',$this->employee_address,true);
		$criteria->compare('employee_birthday',$this->employee_birthday,true);
		$criteria->compare('employee_phone_1',$this->employee_phone_1);
		$criteria->compare('employee_phone_2',$this->employee_phone_2);
		$criteria->compare('employee_email_1',$this->employee_email_1,true);
		$criteria->compare('employee_email_2',$this->employee_email_2,true);
		$criteria->compare('employee_code',$this->employee_code,true);
		$criteria->compare('employee_tax',$this->employee_tax,true);
		$criteria->compare('employee_bank',$this->employee_bank,true);
		$criteria->compare('employee_note',$this->employee_note,true);
		$criteria->compare('lowest_salary',$this->lowest_salary,true);
                
                if(isset($type)&& $type !="")
                {
                    
                    $criteria->join='LEFT JOIN lb_employee_payment ON t.lb_record_primary_key=lb_employee_payment.employee_id';
                    
                    $criteria->condition = 't.employee_salary>0';
                }
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbEmployee the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchEmployeeByName($search_name=false,$page=10,$user_id=false)
        {
            
            $criteria = new CDbCriteria();
            
            
            if($search_name)
            {
                $criteria->condition = 't.employee_name LIKE "%'.$search_name.'%"';

            }
            $dataProvider = new CActiveDataProvider($this,array('criteria'=>$criteria),$page,$user_id);

            return $dataProvider;

        }
        
        public function getInfoEmployee($employee_id)
        {
            $infoEmployee = LbEmployee::model()->findByPk($employee_id);
            return $infoEmployee;
        }
}
