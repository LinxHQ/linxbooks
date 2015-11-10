<?php

/**
 * This is the model class for table "lb_employee_benefits".
 *
 * The followings are the available columns in table 'lb_employee_benefits':
 * @property integer $lb_record_primary_key
 * @property integer $employee_id
 * @property string $benefit_name
 * @property string $benefit_tax
 * @property string $benefit_amount
 */
class LbEmployeeBenefits extends CLBActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_employee_benefits';
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
			array('employee_id', 'numerical', 'integerOnly'=>true),
			array('benefit_name', 'length', 'max'=>255),
			array('benefit_tax, benefit_amount', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lb_record_primary_key, employee_id, benefit_name, benefit_tax, benefit_amount', 'safe', 'on'=>'search'),
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
			'benefit_name' => 'Benefit Name',
			'benefit_tax' => '',
			'benefit_amount' => 'Benefit Amount',
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
		$criteria->compare('benefit_name',$this->benefit_name,true);
		$criteria->compare('benefit_tax',$this->benefit_tax,true);
		$criteria->compare('benefit_amount',$this->benefit_amount,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbEmployeeBenefits the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function deleteBenefitByEmployee($employee_id)
        {
            $benefitItem = LbEmployeeBenefits::model()->findAll('employee_id = '.$employee_id);
            $benefitItem->delete();
        }
        
        public function caculatorBenefitByEmployee($employee_id)
        {
            $total = 0;
      
            if($employee_id)
            {
                $allBenefit = $this->findAll('employee_id='.$employee_id);
                
                if(count($allBenefit) > 0)
                {
                    foreach($allBenefit as $Benefit)
                        $total +=$Benefit['benefit_amount'];
                }
            }
         
            return $total;
        }
         public function totalBenefit(){
            $criteria = new CDbCriteria();
            $record = LbEmployeeBenefits::model()->findAll($criteria);
            $total = 0;
            foreach ($record as $value){
                $total +=$value['benefit_amount'];
            }
            return $total;
        }
         public function getBenefitsByEmployee($employee_id=false)
        {
            $salaryManage = array();
            if($employee_id)
                $salaryManage = LbEmployeeBenefits::model ()->findAll ('employee_id ='.$employee_id);
            return $salaryManage;
        }
}
