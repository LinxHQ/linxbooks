<?php

/**
 * This is the model class for table "lb_vendor_invoice".
 *
 * The followings are the available columns in table 'lb_vendor_invoice':
 * @property integer $lb_record_primary_key
 * @property integer $lb_vd_invoice_supplier_id
 * @property integer $lb_vd_invoice_supplier_address_id
 * @property integer $lb_vd_invoice_supplier_attention_id
 * @property string $lb_vd_invoice_no
 * @property integer $lb_vd_invoice_category
 * @property string $lb_vd_invoice_date
 * @property string $lb_vd_invoice_notes
 * @property string $lb_vd_invoice_subject
 */
class LbVendorInvoice extends CLBActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        const LB_VD_STATUS_CODE_DRAFT = "draft";
        const LB_VENDOR_NUMBER_MAX_LENGTH = 11;
        const LB_VD_CODE_DRAFT = 'DRAFT';
    	const LB_VD_CODE_SEND = 'SEND';
        const LB_VD_CODE_OPEN = 'OPEN';
        const LB_VD_CODE_OVERDUE = 'OVERDUE';
        const LB_VD_CODE_ACCEPTED = 'acepted';
        const LB_VD_CODE_WRITTEN_OFF = 'Written Off';
        
      
        public function tableName()
	{
		return 'lb_vendor_invoice';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lb_vd_invoice_supplier_id, lb_vd_invoice_supplier_address_id, lb_vd_invoice_supplier_attention_id, lb_vd_invoice_category', 'required'),
			array('lb_vd_invoice_supplier_id, lb_vd_invoice_supplier_address_id, lb_vd_invoice_supplier_attention_id, lb_vd_invoice_category', 'numerical', 'integerOnly'=>true),
			array('lb_vd_invoice_no', 'length', 'max'=>100),
			array('lb_vd_invoice_date,lb_vd_invoice_due_date, lb_vd_invoice_notes, lb_vd_invoice_subject', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lb_record_primary_key, lb_vd_invoice_due_date,lb_vd_invoice_supplier_id,lb_vendor_id, lb_vd_invoice_supplier_address_id, lb_vd_invoice_supplier_attention_id, lb_vd_invoice_no, lb_vd_invoice_category, lb_vd_invoice_date, lb_vd_invoice_notes, lb_vd_invoice_subject', 'safe', 'on'=>'search'),
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
        

        
    public function addSupplier()
    {
            $this->lb_vd_invoice_no = 0;
            $this->lb_vd_invoice_no = $this->formatNumberNextNumFormatted($this->lb_vd_invoice_no);
            $this->lb_vd_invoice_date = date('Y-m-d');
            $this->lb_vd_invoice_due_date = date('Y-m-d');
            $this->lb_vd_invoice_status = self::LB_VD_STATUS_CODE_DRAFT;
            $this->lb_vd_invoice_encode = $this->setBase64_decodePO();
            
            $this->lb_vd_invoice_notes = '';
           
            
            $ownCompany = LbCustomer::model()->getOwnCompany();
            $ownCompanyAddress = null;
            $customerCompany = new LbCustomer;
            $customerCompany->lb_customer_name = 'Click to choose customer';
		
            // get own company address
            if ($ownCompany->lb_record_primary_key)
            {
		// auto assign owner company
		$this->lb_vd_invoice_company_id = $ownCompany->lb_record_primary_key;
		$own_company_addresses = LbCustomerAddress::model()->getActiveAddresses($ownCompany->lb_record_primary_key,
		$ownCompany::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);
		if (count($own_company_addresses))
		{
			$ownCompanyAddress= $own_company_addresses[0];
				// auto assign owner company's address
                        $this->lb_vd_invoice_company_address_id = $ownCompanyAddress->lb_record_primary_key;
		}
	    }
            if($this->insert())
                return $this->lb_record_primary_key;
            return false;
           
    }
   
        
         public function setBase64_decodePO()
        {
            $last_used = LbNextId::model()->getFullRecords();
            if(count($last_used)<=0)
            {
                $next_number=0;
            }
            else
            {
                $nextNo = $last_used[0];
                $next_number = $nextNo->lb_next_supplier_invoice_number;
            }
            
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randstring = '';
            for ($i = 0; $i < 10; $i++) {
                $randstring .= $characters[rand(0, strlen($characters)-1)];
            }
            $randstring.=$next_number.'po';
            return base64_encode($randstring);
        }
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'lb_record_primary_key' => 'Lb Record Primary Key',
			'lb_vd_invoice_supplier_id' => 'Lb Vd Invoice Supplier',
			'lb_vd_invoice_supplier_address_id' => 'Lb Vd Invoice Supplier Address',
			'lb_vd_invoice_supplier_attention_id' => 'Lb Vd Invoice Supplier Attention',
			'lb_vd_invoice_no' => 'Lb Vd Invoice No',
			'lb_vd_invoice_category' => 'Lb Vd Invoice Category',
			'lb_vd_invoice_date' => 'Lb Vd Invoice Date',
			'lb_vd_invoice_due_date' => 'Due Date',
			'lb_vd_invoice_notes' => 'Lb Vd Invoice Notes',
			'lb_vd_invoice_subject' => 'Lb Vd Invoice Subject',
			
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
		$criteria->compare('lb_vd_invoice_supplier_id',$this->lb_vd_invoice_supplier_id);
		$criteria->compare('lb_vd_invoice_supplier_address_id',$this->lb_vd_invoice_supplier_address_id);
		$criteria->compare('lb_vd_invoice_supplier_attention_id',$this->lb_vd_invoice_supplier_attention_id);
		$criteria->compare('lb_vd_invoice_no',$this->lb_vd_invoice_no,true);
		$criteria->compare('lb_vd_invoice_category',$this->lb_vd_invoice_category);
		$criteria->compare('lb_vd_invoice_date',$this->lb_vd_invoice_date,true);
		$criteria->compare('lb_vd_invoice_due_date',$this->lb_vd_invoice_due_date,true);
		$criteria->compare('lb_vd_invoice_notes',$this->lb_vd_invoice_notes,true);
		$criteria->compare('lb_vd_invoice_subject',$this->lb_vd_invoice_subject,true);
		$criteria->compare('lb_vendor_id',$this->lb_vendor_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbVendorInvoice the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function loadModel($id)
	{
		$model=  LbVendorInvoice::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
        
        public function getDisplayInvoiceStatus($status)
        {
        if($status==self::LB_VD_STATUS_CODE_DRAFT)
            return 'Draft';
        if($status==self::LB_VD_CODE_SEND)
            return 'send';
        if($status==self::LB_VD_CODE_ACCEPTED)
            return 'accepted';
        if($status==self::LB_VD_CODE_OPEN)
            return 'open';
        if($status==self::LB_VD_CODE_WRITTEN_OFF)
            return 'Written Off';
        if($status==self::LB_VD_CODE_OVERDUE)
            return 'Overdue';
       
        }
        
        public function confirm()
        {
            // don't do anything if invoice is already confirmed, to avoid
            // increasing invoice number by mistake
            if ($this->lb_vd_invoice_status == self::LB_VD_STATUS_CODE_DRAFT)
            {
//                $this->	lb_vd_invoice_no = $this->formatVINextNumFormatted($this->getVINextNum());
                $this->lb_vd_invoice_status = $this::LB_VD_CODE_OPEN;
                return $this->save();
                return $this->getVINextNum();
            }

            return false;
        }
        
        public function formatVINextNumFormatted($invoice_number_int) {
                // draft invoice
                if ($invoice_number_int == 0)
                {
                    return 'Draft';
                }

                // Confirmed invoice

                        // get int value of next invoice number
                        // get its length
		$invoice_number_len = strlen($invoice_number_int);

                // prefix with "I-yyyy"
                //$invoiceFullRecord = $this->getCoreEntity();
                $created_year = date('Y');
		$next_invoice_number = "SI-".$created_year;
		$preceding_zeros_count = self::LB_VENDOR_NUMBER_MAX_LENGTH - strlen($created_year) - $invoice_number_len;
		while($preceding_zeros_count > 0)
		{
			$next_invoice_number .= '0';
			$preceding_zeros_count--;
		}
		$next_invoice_number .= $invoice_number_int;
		//$this->lb_invoice_no_formatted = $next_invoice_number;
		 
		return $next_invoice_number;
	}
        
        public function getVINextNum() {
		
		$next_invoice_number = 0;
		
		
                $last_used = LbNextId::model()->getOneRecords();
                
		// TODO: if more than 1 record, something is wrong
		if (count($last_used) > 1)
		{
			return 0; // something is wrong
		}
		
		// If no record, probably first time generation
		// generate first record
		if (count($last_used) <= 0)
		{
                $nextInvoiceNo = new LbNextId();
                $nextInvoiceNo->lb_next_invoice_number = 1;
                $nextInvoiceNo->lb_next_quotation_number = 1;
                $nextInvoiceNo->lb_next_payment_number = 1;
                $nextInvoiceNo->lb_next_contract_number=1;
                $nextInvoiceNo->lb_next_po_number=1;
                $nextInvoiceNo->lb_next_supplier_invoice_number=1;
                $nextInvoiceNo->lb_next_supplier_payment_number=1;
                    if ($nextInvoiceNo->save())
				$next_po_number = $nextInvoiceNo->lb_next_supplier_invoice_number;
                } else {
			$nextInvoiceNo = $last_used;
			$next_invoice_number = $nextInvoiceNo->lb_next_supplier_invoice_number;
		}

        // advance next invoice number
        $nextInvoiceNo->lb_next_supplier_invoice_number++;
        $nextInvoiceNo->save();
		
        return $next_invoice_number;
		//trigger_error('Not Implemented!', E_USER_WARNING);
	}
         public function getVendorInvoiceByVendor($vendor_id)
        {
          
            $criteria = new CDbCriteria();
            $criteria->condition = 'lb_vendor_id = '.$vendor_id;

            $dataProvider = $this->getFullRecordsDataProvider($criteria);
            return $dataProvider;
       
        }
        
        function getInvoiceAmountByCustomer($customer_id)
        {
            $criteria = new CDbCriteria();
            $criteria->join='INNER JOIN lb_vendor_total i ON i.lb_vendor_invoice_id = t.lb_record_primary_key';
            $criteria->condition='lb_vd_invoice_supplier_id = '. intval($customer_id).' AND lb_vd_invoice_no <> "Draft" AND i.lb_vendor_last_outstanding > 0 AND t.lb_vd_invoice_supplier_id > 0';
           
            $dataProvider = new CActiveDataProvider($this,array('criteria'=>$criteria));

            return $dataProvider;
        }
        
        
        public function getInvoicePaidByCustomer($customer_id){
        $criteria = new CDbCriteria();
        $criteria->join = "INNER JOIN lb_payment_vendor_invoice i ON t.lb_record_primary_key = i.lb_vendor_invoice_id";
        $criteria->condition = "t.lb_vd_invoice_supplier_id = ".intval($customer_id);
        $criteria->order = "t.lb_record_primary_key ASC";
        $criteria->group = 't.lb_record_primary_key';
        return LbVendorInvoice::model()->findAll($criteria);
        
    }
    
    //vendor invoice chua thanh toan
    public function getVendorInvoiceMonth($month=false,$year=false)
    {
        $status='("'.  LbVendorInvoice::LB_VD_CODE_OPEN.'","'.LbVendorInvoice::LB_VD_CODE_OVERDUE.'")'; 

        $modelInvoiceVendor = LbVendorInvoice::model()->findAll('YEAR(lb_vd_invoice_date) = '.$year.' AND MONTH(lb_vd_invoice_date) ='.$month.' AND lb_vd_invoice_status IN '.$status);
        $total = 0;
        foreach($modelInvoiceVendor as $value)
        {
            $total += LbVendorTotal::model()->totalOustanding(LbVendorTotal::LB_VENDOR_INVOICE_TOTAL,$value->lb_record_primary_key);
        }
        return $total;
    }
    
    public function getVendorInvoice($pageSize=10)
        {
            $criteria  = new CDbCriteria();
            
            $dataProvider = $this->getFullRecordsDataProvider($criteria, null, $pageSize);
            
        
            return $dataProvider;
 
        }
        
       
}
