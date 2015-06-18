<?php
/**
 * This is the model class for table "lb_payment".
 *
 * The followings are the available columns in table 'lb_payment':
 * @property string $lb_record_primary_key
 * @property string $lb_payment_user_id
 * @property string $lb_payment_customer_id
 * @property string $lb_payment_no
 * @property string $lb_payment_date
 * @property string $lb_payment_notes
 * @property string $lb_payment_total
 * @property string $lb_payment_method
 */
class LbPayment extends CLBActiveRecord
{
    const LB_PAYMENT_NUMBER_MAX = 11;
    const LB_QUERY_RETURN_TYPE_ACTIVE_DATA_PROVIDER = 'ActiveDataProvider';
    public $method = array(0=>'Master Card',1=>'Visa Card',2=>'Cash',3=>'Check',4=>'Other');
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'lb_payment';
        
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('lb_payment_customer_id, lb_payment_date', 'required'),
            array('lb_payment_customer_id, lb_payment_method','length', 'max'=>11),
            array('lb_payment_no', 'length', 'max'=>100),
            array('lb_payment_notes', 'length', 'max'=>255),
            array('lb_payment_total', 'length', 'max'=>10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('lb_record_primary_key, lb_payment_customer_id, lb_payment_no, lb_payment_method. lb_payment_date, lb_payment_notes, lb_payment_total', 'safe', 'on'=>'search'),
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
            'paymentItem'=>array(self::HAS_MANY,'LbPaymentItem','lb_payment_id')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'lb_record_primary_key' => 'Lb Record Primary Key',
            'lb_payment_customer_id' => Yii::t('lang','Customer'),
            'lb_payment_no' => Yii::t('lang','Payment No'),
            'lb_payment_date' => Yii::t('lang','Payment Date'),
            'lb_payment_notes' => Yii::t('lang','Payment Notes'),
            'lb_payment_total' => Yii::t('lang','Payment Total'),
            'lb_payment_method'=> Yii::t('lang','Payment Method')
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

        $criteria->compare('lb_record_primary_key',$this->lb_record_primary_key,true);
        $criteria->compare('lb_payment_customer_id',$this->lb_payment_customer_id,true);
        $criteria->compare('lb_payment_no',$this->lb_payment_no,true);
        $criteria->compare('lb_payment_date',$this->lb_payment_date,true);
        $criteria->compare('lb_payment_notes',$this->lb_payment_notes,true);
        $criteria->compare('lb_payment_total',$this->lb_payment_total,true);
        $criteria->compare('lb_payment_method', $this->lb_payment_method, true);

        $dataProvider = $this->getFullRecordsDataProvider($criteria);
        
        return $dataProvider;        
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return LbPayment the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public function getPaymentNextNum(){
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
                if ($nextpaymentNo->save())
                        $next_payment_number = $nextInvoiceNo->lb_next_payment_number;
        } else {
                $nextpaymentNo = $last_used[0];
                $next_payment_number = $nextpaymentNo->lb_next_payment_number;
        }
        
        return $next_payment_number;
        //trigger_error('Not Implemented!', E_USER_WARNING);
    }
    
    public function setPaymentNextNum($paymentNextNum)
    {
        $paymentNextNum++;
        $last_used = LbNextId::model()->getFullRecords();
        
        $nextcontractNo = $last_used[0];
        $nextcontractNo->lb_next_payment_number = $paymentNextNum;
        $nextcontractNo->save();
    }

    public function FormatPaymentNo($paymentNextNo){
        
        // R-YYYY
        $createYear = date('Y');
        $next_payment_number = 'R-'.$createYear;
            $preceding_zeros_count = self::LB_PAYMENT_NUMBER_MAX - strlen($createYear) - strlen($paymentNextNo);
            while($preceding_zeros_count > 0)
            {
                    $next_payment_number .= '0';
                    $preceding_zeros_count--;
            }
            $next_payment_number .= $paymentNextNo;
            //$this->lb_invoice_no_formatted = $next_invoice_number;

            return $next_payment_number;
    }
    /**
     * 
     * @param date $year default nam hien tai
     * @return double $totalPayment;
     */
    public function calculateTotalPayment($year=false){
        $criteria = new CDbCriteria();
        if($year)
            $criteria ->condition='YEAR(lb_payment_date) = "'.$year.'"';
        else
            $criteria ->condition='YEAR(lb_payment_date) = "'.date('Y').'"';

        //$dataProvider = new CActiveDataProvider($this,array('criteria'=>$criteria));
        $dataProvider = $this->getFullRecordsDataProvider($criteria);
        
        $totalPayment = 0;
        foreach ($dataProvider->data as $data) {
            $totalPayment+=$data->lb_payment_total;
        }
        return $totalPayment;
        
    }
    
    // My
    public function getPaymentCustomer($Customer_id)
        {
            $criteria=new CDbCriteria;
            $criteria->compare('lb_payment_customer_id',$Customer_id);
             $ct=  new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));

           $cout=$ct->itemCount;

            return $cout;
        }
        
        public function getAllPayment($date_form=false,$date_to=false,$customer_id=false,$month=false,$year=false,$method=false)
    {
        $criteria = new CDbCriteria();
        if($month)
             $criteria->condition = 'YEAR(lb_payment_date) = '.$year.' AND MONTH(lb_payment_date) ='.$month;
        if($date_form)
            $criteria ->compare ('lb_payment_date >',$date_form);
        if($date_to)
            $criteria ->compare ('lb_payment_date <',$date_to);
            
        if($method)
                $criteria ->compare ('lb_payment_method',$method);
        if($customer_id)
                 $criteria ->compare ('lb_payment_customer_id',$customer_id);
        if($month)
                 $criteria->condition = 'YEAR(lb_payment_date) = '.$year.' AND MONTH(lb_payment_date) ='.$month.' AND lb_payment_method='.$method;
//    
        return LbPayment::model()->findAll($criteria);
    }
    public function getPaymentTotalByMonth($year = false,$month=false)
    {
     
        $model = LbPayment::model();
        $paymentTotal = $model->findAll('YEAR(lb_payment_date) = '.$year.' AND MONTH(lb_payment_date) ='.$month);
        $total = 0;
        if(count($paymentTotal) > 0)
        {
            foreach($paymentTotal as $data)
            {
                $total +=$data->lb_payment_total;
            }
        }
        return $total;
    }
    public function getAllPaymentByInvoice($lb_invoice_id=false,$return_type = self::LB_QUERY_RETURN_TYPE_ACTIVE_DATA_PROVIDER)
    {
        $criteria = new CDbCriteria();
        $criteria->select="*,lb_payment.*";
        
        $criteria->join='LEFT JOIN lb_payment  ON t.lb_record_primary_key = lb_payment_item.lb_payment_id';
        
        $criteria->condition = "lb_invoice_id = $lb_invoice_id";
       
       $dataProvider = new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
		
	return $this->getResultsBasedForReturnType($dataProvider, $return_type);
    }
    public function getPaymentById($payment_id)
    {
        $criteria = new CDbCriteria();
       
        
        $criteria->condition = "lb_record_primary_key = $payment_id";
       
         return $this->find($criteria);
    }
    
    public function getMethod($sort = "", $return_type = self::LB_QUERY_RETURN_TYPE_ACTIVE_DATA_PROVIDER)
    {
        $criteria=new CDbCriteria;
        $criteria->order = $sort;
        $dataProvider = $this->getFullRecordsDataProvider($criteria);

        return $this->getResultsBasedForReturnType($dataProvider, $return_type);
    }
    
    public function findPayment($invoice_id=FALSE)
    {
        $criteria=new CDbCriteria;
        if($invoice_id)
            $criteria->condition = "lb_invoice_id = $invoice_id";
        return $this->findAll($criteria);
    }
    public function CaculatorPaymentByInvoice($invoice_id)
    {
    }

}