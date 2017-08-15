<?php

/**
 * This is the model class for table "lb_employee_payment".
 *
 * The followings are the available columns in table 'lb_employee_payment':
 * @property integer $lb_record_primary_key
 * @property integer $employee_id
 * @property string $payment_date
 * @property string $payment_paid
 * @property string $payment_oustanding
 * @property integer $payment_status
 * @property string $payment_note
 * @property integer $payment_created_by
 */
class LbEmployeePayment extends CLBActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public $status_payment=array(1=>'Complete',2=>'Oustanding');
	public function tableName()
	{
		return 'lb_employee_payment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('employee_id', 'required'),
			array('employee_id, payment_status, payment_created_by', 'numerical', 'integerOnly'=>true),
			array('payment_paid, payment_oustanding', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lb_record_primary_key, employee_id, payment_date, payment_paid, payment_oustanding, payment_status, payment_note, payment_created_by', 'safe', 'on'=>'search'),
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
			'payment_paid' => 'Payment Paid',
			'payment_oustanding' => 'Payment Oustanding',
			'payment_status' => 'Payment Status',
			'payment_note' => 'Payment Note',
			'payment_created_by' => 'Payment Created By',
			'payment_month' => 'Month',
			'payment_year' => 'Year',
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
	public function search($name=false,$month=false,$year=false)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('lb_record_primary_key',$this->lb_record_primary_key);
		$criteria->compare('employee_id',$this->employee_id);
		$criteria->compare('payment_date',$this->payment_date,true);
		$criteria->compare('payment_paid',$this->payment_paid,true);
		$criteria->compare('payment_oustanding',$this->payment_oustanding,true);
		$criteria->compare('payment_status',$this->payment_status);
		$criteria->compare('payment_note',$this->payment_note,true);
		$criteria->compare('payment_created_by',$this->payment_created_by);
                if($name)
                {
                    $criteria->join='LEFT JOIN lb_employee ON t.employee_id=lb_employee.lb_record_primary_key';
                    
                    $criteria->condition = 'lb_employee.employee_name LIKE "%'.$name.'%" OR t.payment_status LIKE "%'.$name.'%"';
                }
                
                if($month)
                    $criteria->compare('payment_month',$month);
                if($year)
                    $criteria->compare('payment_year',$year);
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbEmployeePayment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getPaidByEmployee($employee_id=false,$month=false,$year=false)
        {
            $paid = 0;
            $q = LbEmployeePayment::model()->findAll('employee_id='.$employee_id);
            if($month)
                $q = LbEmployeePayment::model()->findAll('employee_id='.$employee_id.' AND payment_month='.$month);
            if($year)
                $q = LbEmployeePayment::model()->findAll('employee_id='.$employee_id.' AND payment_year='.$year);
            if($month && $year)
                $q = LbEmployeePayment::model()->findAll('employee_id='.$employee_id.' AND payment_month='.$month.' AND payment_year='.$year);
          
            if(count($q)>0)
            {
                foreach ($q as $data)
                    $paid +=$data->payment_paid;
            }
            return $paid;
        }
        public function getOustandingByEmployee($employee_id)
        {
            $paid = 0;
            $q = LbEmployeePayment::model()->findAll('employee_id='.$employee_id);
            
            if(count($q)>0)
            {
                foreach ($q as $data)
                    $paid +=$data->payment_oustanding;
            }
            return $paid;
        }
        
        public function caculatorAmount($employee_id=false)
        {
            $paid = $this->getPaidByEmployee($employee_id);
            $salary = LbEmployeeSalary::model()->totalSalaryEmployee($employee_id)-LbEmployeeBenefits::model()->caculatorBenefitByEmployee($employee_id);
            $oustanding = $salary-$paid;
            return $oustanding;
        }
        
        public function getEmployeePayment($employee_id=false,$payment_id)
        {
            $infoPayment = array();
            if($employee_id)
            {
                $infoPayment = LbEmployeePayment::model()->find('employee_id='.$employee_id);
            }
            if($payment_id)
                $infoPayment = $this->findByPk ($payment_id);
            return $infoPayment;
        }
        public function getAllByMonthYear($month=false,$year=false){
            $criteria = new CDbCriteria();
            if($month){
                $criteria->compare('payment_month', $month);
            }
            if($year){
                $criteria->compare('payment_year', $year);
            }
            $criteria->group = 'employee_id';
            
            return LbEmployeePayment::model()->findAll($criteria);
        }
        public function getCountEmployeeMonthYear($month=false, $year=false){
            $criteria = new CDbCriteria();
            if($month){
                $criteria->compare('payment_month', $month);
            }
            if($year){
                $criteria->compare('payment_year', $year);
            }
           // $a = LbEmployeePayment::model()->findAll($criteria);
            $count = LbEmployeePayment::model()->count($criteria);
            return $count;
        }
        public function getMonthByEmployeeAndYear($employee_id = false, $year = false){
            $criteria = new CDbCriteria();
            if($employee_id){
                $criteria->compare('employee_id', $employee_id);
            }
            if($year){
                $criteria->compare('payment_year', $year);
            }
            $criteria->group = 'payment_month';
            return LbEmployeePayment::model()->findAll($criteria);
        }
        public function getPaidByMonth($month = false, $employee_id = false, $year = false){
            $criteria = new CDbCriteria();
            $paid = 0;
            $a = LbEmployeePayment::model()->findAll('payment_month='.$month);
            if($employee_id){
                $a = LbEmployeePayment::model()->findAll('payment_month='.$month.' AND employee_id='.$employee_id);
            }
            if($year){
                $a = LbEmployeePayment::model()->findAll('payment_month='.$month.' AND payment_year='.$year);
            }
            if($employee_id && $year){
                $a = LbEmployeePayment::model()->findAll('payment_month='.$month.' AND employee_id='.$employee_id.' AND payment_year='.$year);
            }
            if(count($a)>0){
                foreach ($a as $value) {
                    $paid+=$value->payment_paid;
                }
            }
            return $paid;
        }
        public function getInfoPayment($payment_id){
            $InfoPayment = LbEmployeePayment::model()->findByPk($payment_id);
            return $InfoPayment;
        }
        public function getAllByMonthYearAndEmployee($employee_name=false,$month=false,$year=false){
            $criteria = new CDbCriteria();
            if($employee_name){
                 $criteria->join='LEFT JOIN lb_employee ON t.employee_id=lb_employee.lb_record_primary_key';
                    
                 $criteria->condition = 'lb_employee.employee_name LIKE "%'.$employee_name.'%" OR t.payment_status LIKE "%'.$employee_name.'%"';
               
            }
            if($month){
                $criteria->compare('payment_month', $month);
            }
            if($year){
                $criteria->compare('payment_year', $year);
            }
            
            return LbEmployeePayment::model()->findAll($criteria);
        }
        public function getAllPaymentByMonthYearAndEmployee($employee_name=false,$month=false,$year=false){
            $criteria = new CDbCriteria();
            if($employee_name){
                 $criteria->join='LEFT JOIN lb_employee ON t.employee_id=lb_employee.lb_record_primary_key';
                    
                 $criteria->condition = 'lb_employee.employee_name LIKE "%'.$employee_name.'%" OR t.payment_status LIKE "%'.$employee_name.'%"';
               
            }
            if($month){
                $criteria->compare('payment_month', $month);
            }
            if($year){
                $criteria->compare('payment_year', $year);
            }
            $criteria->group = 'employee_id';
            return LbEmployeePayment::model()->findAll($criteria);
        }
        public function getAllPaymentByDateMonthYearAndEmployee($employee_name=false,$month=false,$year=false,$date=false){
            $criteria = new CDbCriteria();
            if($employee_name){
                 $criteria->join='LEFT JOIN lb_employee ON t.employee_id=lb_employee.lb_record_primary_key';
                    
                 $criteria->condition = 'lb_employee.employee_name LIKE "%'.$employee_name.'%" OR t.payment_status LIKE "%'.$employee_name.'%"';
               
            }
            if($month){
                $criteria->compare('payment_month', $month);
            }
            if($year){
                $criteria->compare('payment_year', $year);
            }
            if($date){
                $criteria->compare('payment_date',$date);
            }
            $criteria->group = 'employee_id';
            return LbEmployeePayment::model()->findAll($criteria);
        }
        public function totalPaidByDate($month=false,$employee_id,$year=false,$date=false){
            $criteria = new CDbCriteria();
            $total = 0;
            if($month){
                $criteria->compare('payment_month', $month);
            }
            if($year){
                $criteria->compare('payment_year', $year);
            }
            if($employee_id){
                $criteria->compare('employee_id', $employee_id);
            }
            $a=  LbEmployeePayment::model()->findAll($criteria);
            if(count($a)>0){
                foreach ($a as $value) {
                 //   $total+=$value->payment_paid;
                    $payment_date = strtotime($value->payment_date);
                    if($payment_date < strtotime($date)){
                        $total+=$value->payment_paid;
                    }
                }
            }
            return $total;
        }
		 public function getAllPayment(){
		            $criteria = new CDbCriteria();
		            $criteria->group = 'payment_year';
		            $data = LbEmployeePayment::model()->findAll($criteria);
		           
		            return $data;
		        }
        public function getAllEmployeePayment(){
            $criteria = new CDbCriteria();
            $criteria->group = 'employee_id';
            $data = LbEmployeePayment::model()->findAll($criteria);
           
            return $data;
        }
}
