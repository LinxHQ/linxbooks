<?php

/**
 * This is the model class for table "lb_payment_vendor".
 *
 * The followings are the available columns in table 'lb_payment_vendor':
 * @property integer $lb_record_primary_key
 * @property integer $lb_payment_vendor_customer_id
 * @property string $lb_payment_vendor_no
 * @property integer $lb_payment_vendor_method
 * @property string $lb_payment_vendor_date
 * @property string $lb_payment_vendor_notes
 * @property string $lb_payment_vendor_total
 */
class LbPaymentVendor extends CLBActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
    
        const LB_PAYMENT_VENDOR_NUMBER_MAX=11;
        
        public $method = array(0=>'Master Card',1=>'Visa Card',2=>'Cash',3=>'Check',4=>'Other');

	public function tableName()
	{
		return 'lb_payment_vendor';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lb_payment_vendor_customer_id, lb_payment_vendor_no, lb_payment_vendor_method, lb_payment_vendor_date, lb_payment_vendor_notes, lb_payment_vendor_total', 'required'),
			array('lb_payment_vendor_customer_id, lb_payment_vendor_method', 'numerical', 'integerOnly'=>true),
			array('lb_payment_vendor_no', 'length', 'max'=>100),
			array('lb_payment_vendor_notes', 'length', 'max'=>255),
			array('lb_payment_vendor_total', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lb_record_primary_key, lb_payment_vendor_customer_id, lb_payment_vendor_no, lb_payment_vendor_method, lb_payment_vendor_date, lb_payment_vendor_notes, lb_payment_vendor_total', 'safe', 'on'=>'search'),
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
			'lb_payment_vendor_customer_id' => 'Lb Payment Vendor Customer',
			'lb_payment_vendor_no' => 'Lb Payment Vendor No',
			'lb_payment_vendor_method' => 'Method',
			'lb_payment_vendor_date' => 'Lb Payment Vendor Date',
			'lb_payment_vendor_notes' => 'Lb Payment Vendor Notes',
			'lb_payment_vendor_total' => 'Lb Payment Vendor Total',
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
		$criteria->compare('lb_payment_vendor_customer_id',$this->lb_payment_vendor_customer_id);
		$criteria->compare('lb_payment_vendor_no',$this->lb_payment_vendor_no,true);
		$criteria->compare('lb_payment_vendor_method',$this->lb_payment_vendor_method);
		$criteria->compare('lb_payment_vendor_date',$this->lb_payment_vendor_date,true);
		$criteria->compare('lb_payment_vendor_notes',$this->lb_payment_vendor_notes,true);
		$criteria->compare('lb_payment_vendor_total',$this->lb_payment_vendor_total,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbPaymentVendor the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getPaymentVendorNextNum(){
            $next_payment_number = 0;

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
            $nextpaymentNo = new LbNextId();
            $nextpaymentNo->lb_next_invoice_number = 1;
            $nextpaymentNo->lb_next_quotation_number = 1;
            $nextpaymentNo->lb_next_payment_number = 1;
            $nextpaymentNo->lb_next_contract_number=1;
            $nextInvoiceNo->lb_next_expenses_number=1;
            $nextInvoiceNo->lb_next_po_number=1;
            $nextInvoiceNo->lb_next_supplier_invoice_number=1;
            $nextInvoiceNo->lb_next_supplier_payment_number=1;
            $nextInvoiceNo->lb_payment_vendor_number =1;
            $nextpaymentNo->lb_next_=1;
                    if ($nextpaymentNo->save())
                            $next_payment_number = $nextInvoiceNo->lb_payment_vendor_number;
            } else {
                    $nextpaymentNo = $last_used[0];
                    $next_payment_number = $nextpaymentNo->lb_payment_vendor_number;
            }

            return $next_payment_number;
            //trigger_error('Not Implemented!', E_USER_WARNING);
    }
    
    

    public function FormatPaymentVendorNo($paymentNextNo){
        
        // R-YYYY
        $createYear = date('Y');
        $next_payment_number = 'R-'.$createYear;
            $preceding_zeros_count = self::LB_PAYMENT_VENDOR_NUMBER_MAX - strlen($createYear) - strlen($paymentNextNo);
            while($preceding_zeros_count > 0)
            {
                    $next_payment_number .= '0';
                    $preceding_zeros_count--;
            }
            $next_payment_number .= $paymentNextNo;
            //$this->lb_invoice_no_formatted = $next_invoice_number;

            return $next_payment_number;
    }
        
        //Total payment vendor in month/year
        public function totalPaymentVendorInMonth($month=false,$year=false)
        {
            $modelTest =  LbPaymentVendor::model()->findAll('YEAR(lb_payment_vendor_date) = '.$year.' AND MONTH(lb_payment_vendor_date) ='.$month);

            $total = 0;
            foreach($modelTest as $data)
                    $total += $data->lb_payment_vendor_total;
            return $total;
        }
        
        
        
    public function getPaymentVendorInvoice($supplier_id=false,$date_form=false,$date_to=false)
    {
        $criteria = new CDbCriteria();
        if($supplier_id)
        {
            $criteria->join='LEFT JOIN lb_vendor_invoice a ON a.lb_vd_invoice_supplier_id = t.lb_payment_vendor_customer_id';
            
        }
        if($date_form)
        {
            $criteria->addCondition("t.lb_payment_vendor_date >= '".$date_form."'","AND");
        }
        if($date_to)
        {
            $criteria->addCondition("t.lb_payment_vendor_date <= '".$date_to."'","AND");
        }
//        
        if($supplier_id)
        {
        $criteria->addCondition ("a.lb_vd_invoice_supplier_id = $supplier_id","AND");
        }
        $criteria->group = 't.lb_record_primary_key';
        $criteria->order = "t.lb_payment_vendor_customer_id";
        
        return $this->findAll($criteria);
    }
    
    public function getTotalPaidByCustomer($supplier_id=false,$date_form=false,$date_to=false)
    {
        $AllPayment = $this->getPaymentVendorInvoice($supplier_id,$date_form,$date_to);
        $total = 0;
        foreach ($AllPayment as $data)
            $total += $data->lb_payment_vendor_total;
        return $total;
    }
    
    
    
}
