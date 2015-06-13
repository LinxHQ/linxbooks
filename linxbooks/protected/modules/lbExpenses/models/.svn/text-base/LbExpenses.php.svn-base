<?php

/**
 * This is the model class for table "lb_expenses".
 *
 * The followings are the available columns in table 'lb_expenses':
 * @property integer $lb_record_primary_key
 * @property integer $lb_category_id
 * @property string $lb_expenses_no
 * @property string $lb_expenses_amount
 * @property string $lb_expenses_date
 * @property integer $lb_expenses_recurring_id
 * @property integer $lb_expenses_bank_account_id
 * @property string $lb_expenses_note
 * @property string $from_date
 * @property string $to_date
 */
class LbExpenses extends CLBActiveRecord
{
        public $from_date;
        public $to_date;

        const LB_EXPENSES_NUMBER_MAX = 11;
    
        var $module_name = "lbExpenses";
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_expenses';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lb_category_id, lb_expenses_no, lb_expenses_amount, lb_expenses_date', 'required'),
			array('lb_category_id, lb_expenses_recurring_id, lb_expenses_bank_account_id', 'numerical', 'integerOnly'=>true),
			array('lb_expenses_no', 'length', 'max'=>50),
			
			array('lb_expenses_note', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lb_record_primary_key, lb_category_id, lb_expenses_no, lb_expenses_amount, lb_expenses_date, lb_expenses_recurring_id, lb_expenses_bank_account_id, lb_expenses_note', 'safe', 'on'=>'search'),
                        array('from_date, to_date', 'safe'),
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
                    'customer'=>array(self::BELONGS_TO,'LbCustomer','lb_customer_id'),
                    'customer_address'=>array(self::BELONGS_TO,'LbCustomerAddress','lb_address_id'),
                    'customer_contact'=>array(self::BELONGS_TO,'LbCustomerContact','lb_contact_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'lb_record_primary_key' => 'Lb Record Primary Key',
			'lb_category_id' => Yii::t('lang','Category'),
			'lb_expenses_no' => Yii::t('lang','Expenses No'),
			'lb_expenses_amount' => Yii::t('lang','Amount'),
			'lb_expenses_date' => Yii::t('lang','Date'),
			'lb_expenses_recurring_id' => Yii::t('lang','Recurring'),
			'lb_expenses_bank_account_id' => Yii::t('lang','Bank Account'),
			'lb_expenses_note' => Yii::t('lang','Note'),
                        'from_date' => Yii::t('lang','From'),
                        'to_date' => Yii::t('lang','To'),
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
	public function search($user_id=false)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

                $conditions = array();
//		$criteria->compare('lb_record_primary_key',$this->lb_record_primary_key);
                if ($this->lb_category_id)
                {
                    $conditions[] = '(lb_category_id = '.intval($this->lb_category_id).')';
//                    $criteria->compare('lb_category_id', $this->lb_category_id, true);
                }
                if ($this->from_date && $this->to_date)
                {
                    $conditions[] = '(lb_expenses_date >= "'.$this->from_date.'") AND (lb_expenses_date <= "'.$this->to_date.'")';
                }
                if (count($conditions) > 0)
                    $criteria->condition = implode (' AND ', $conditions);
                $criteria->order = 'lb_expenses_date ASC';
//		$criteria->compare('lb_expenses_no',$this->lb_expenses_no,true);
//		$criteria->compare('lb_expenses_amount',$this->lb_expenses_amount,true);
//		$criteria->compare('lb_expenses_date',$this->lb_expenses_date,true);
//		$criteria->compare('lb_expenses_recurring_id',$this->lb_expenses_recurring_id);
//		$criteria->compare('lb_expenses_bank_account_id',$this->lb_expenses_bank_account_id);
//		$criteria->compare('lb_expenses_note',$this->lb_expenses_note,true);

//                return new CActiveDataProvider($this, array(
//			'criteria'=>$criteria,
//		));
		$dataProvider = $this->getFullRecordsDataProvider($criteria,null,20,$user_id);
                
                return $dataProvider;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbExpenses the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getExpenses($category_id=false)
        {
            $criteria = new CDbCriteria;
            
            if ($category_id)
                $criteria->compare('lb_category_id', "$category_id");
            
            $criteria->order="lb_expenses_no ASC";
            
            $dataProvider = $this->getFullRecordsDataProvider($criteria);
            
            return $dataProvider;
        }
        
        public function getExpensesNextNum()
        {
                $next_expenses_number = 0;

                $last_used = LbNextId::model()->getFullRecords();

                // TODO: if more than 1 record, something is wrong
                if (count($last_used) > 1)
                {
                        return 0; // something is wrong
                }

                // If no record, probably first time generation
                // generate first record
                if (count($last_used) <= 0)
                {
                    $next_expenses_number = 1;
                    $nextexpensesNo = new LbNextId();
                    $nextexpensesNo->lb_next_invoice_number = 1;
                    $nextexpensesNo->lb_next_quotation_number = 1;
                    $nextexpensesNo->lb_next_payment_number = 1;
                    $nextexpensesNo->lb_next_contract_number = 1;
                    $nextexpensesNo->lb_next_expenses_number = 1;
                        if ($nextexpensesNo->save())
                                $next_expenses_number = $nextexpensesNo->lb_next_expenses_number;
                } else {
                        $nextexpensesNo = $last_used[0];
                        $next_expenses_number = $nextexpensesNo->lb_next_expenses_number;
                }

                return $next_expenses_number;
                //trigger_error('Not Implemented!', E_USER_WARNING);
        }
        
        public function FormatExpensesNo($expensesNextNo)
        {

                // E-YYYY
                $createYear = date('Y');
                $next_expenses_number = 'E-'.$createYear;
                    $preceding_zeros_count = self::LB_EXPENSES_NUMBER_MAX - strlen($createYear) - strlen($expensesNextNo);
                    while($preceding_zeros_count > 0)
                    {
                            $next_expenses_number .= '0';
                            $preceding_zeros_count--;
                    }
                    $next_expenses_number .= $expensesNextNo;
                    //$this->lb_invoice_no_formatted = $next_invoice_number;

                    return $next_expenses_number;
        }
        
        public function setExpensesNextNum($expensesNextNo)
        {
                $expensesNextNo++;
                $last_used = LbNextId::model()->getFullRecords();

                $nextexpensesNo = $last_used[0];
                $nextexpensesNo->lb_next_expenses_number = $expensesNextNo;
                $nextexpensesNo->save();
        }
         //Total expenses da chi
        public function totalExByVDInMonth($month=false,$year=false)
        {
            $paymentModel = LbPaymentVoucher::model()->findAll('YEAR(lb_pv_date) = '.$year.' AND MONTH(lb_pv_date) ='.$month);
            $total = 0;
            foreach($paymentModel as $value)
            {
               $total += $this->getAmountExByPV($value->lb_record_primary_key); 
            }
            return $total;
        }
        public function getExpensesByPk($expenses_id)
        {
            $model = LbExpenses::model()->findByPk($expenses_id);
            return $model;
        }
        
        public function getAmountExByPV($pv_id)
        {
            $pvexpenses = LbPvExpenses::model()->findAll('lb_payment_voucher_id = '.$pv_id);
            $total = 0;
            foreach($pvexpenses as $data)
            {
                $modelExpenses = LbExpenses::model()->find('lb_record_primary_key = '.$data->lb_expenses_id);
                $total += $modelExpenses->lb_expenses_amount;
            }
            return $total;
        }
        
        //total expenses can chi trong thang
        public function getExByMonth($month=false,$year=false)
        {
            $modelEx = LbExpenses::model()->findAll('YEAR(lb_expenses_date) = '.$year.' AND MONTH(lb_expenses_date) ='.$month);
            $total = 0;
            foreach($modelEx as $data)
            {
                if(LbPvExpenses::model()->getExpensesPVById($data->lb_record_primary_key) == false)
                    $total += $data->lb_expenses_amount;
            }
            return $total;
        }
}
