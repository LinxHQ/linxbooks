<?php

/**
 * This is the model class for table "lb_vendor".
 *
 * The followings are the available columns in table 'lb_vendor':
 * @property integer $lb_record_primary_key
 * @property integer $lb_vendor_supplier_id
 * @property integer $lb_vendor_supplier_address
 * @property integer $lb_vendor_supplier_attention_id
 * @property string $lb_vendor_no
 * @property integer $lb_vendor_category
 * @property string $lb_vendor_date
 * @property string $lb_vendor_notes
 * @property string $lb_vendor_subject
 * @property integer $lb_vendor_status
 * @property integer $lb_vendor_company_id
 * @property integer $lb_vendor_company_address_id
 * @property string $lb_vendor_due_date
 * @property string $lb_vendor_encode
 */
class LbVendor extends CLBActiveRecord
{
    	const LB_PO_STATUS_CODE_DRAFT = 'DRAFT';
    	const LB_PO_STATUS_CODE_SEND = 'SEND';
        const LB_PO_STATUS_CODE_OPEN = 'OPEN';
        const LB_PO_STATUS_CODE_ACCEPTED = 'acepted';
        const LB_VENDOR_STATUS_CODE_WRITTEN_OFF = 'Written Off';
        const LB_PO_STATUS_CODE_APPROVED = 'APPROVED';
        const LB_PO_STATUS_CODE_REJECTED = 'REJECTED';
        const LB_VENDOR_NUMBER_MAX_LENGTH = 11;
        
    
    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_vendor';
	}
        
        public function __construct($scenario = 'insert') {
            parent::__construct($scenario);

            $this->lb_vendor_no = 0;
            $this->lb_vendor_no = $this->formatVendorNextNumFormatted($this->lb_vendor_no);
            $this->lb_vendor_date = date('Y-m-d');
            $this->lb_vendor_due_date = date('Y-m-d');
            $this->lb_vendor_status = self::LB_PO_STATUS_CODE_DRAFT;
            $this->lb_vendor_encode = $this->setBase64_decodePO();
            
            $this->lb_vendor_notes = '';
            
        }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lb_vendor_no', 'required'),
			array('lb_vendor_supplier_id, lb_vendor_supplier_address, lb_vendor_supplier_attention_id, lb_vendor_category', 'numerical', 'integerOnly'=>true),
			array('lb_vendor_no', 'length', 'max'=>100),
                        array('lb_vendor_date,lb_vendor_due_date,lb_vendor_status,  lb_vendor_notes, lb_vendor_subject', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lb_record_primary_key, lb_vendor_supplier_id, lb_vendor_supplier_address, lb_vendor_supplier_attention_id, lb_vendor_no, lb_vendor_category, lb_vendor_date, lb_vendor_notes, lb_vendor_subject, lb_vendor_status, lb_vendor_due_date', 'safe', 'on'=>'search'),
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
			'lb_vendor_supplier_id' => 'Customer',
			'lb_vendor_supplier_address' => 'Lb Vendor Supplier Address',
			'lb_vendor_supplier_attention_id' => 'Lb Vendor Supplier Attention',
			'lb_vendor_no' => 'Lb Vendor No',
			'lb_vendor_category' => 'Lb Vendor Category',
			'lb_vendor_date' => 'Lb Vendor Date',
			'lb_vendor_due_date' => 'Lb Vendor Due Date',
			'lb_vendor_notes' => 'Lb Vendor Notes',
			'lb_vendor_subject' => 'Lb Vendor Subject',
			'lb_vendor_status' => 'Lb Vendor Status',
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
		$criteria->compare('lb_vendor_supplier_id',$this->lb_vendor_supplier_id);
		$criteria->compare('lb_vendor_supplier_address',$this->lb_vendor_supplier_address);
		$criteria->compare('lb_vendor_supplier_attention_id',$this->lb_vendor_supplier_attention_id);
		$criteria->compare('lb_vendor_no',$this->lb_vendor_no);
		$criteria->compare('lb_vendor_category',$this->lb_vendor_category);
//		$criteria->compare('lb_vendor_date',$this->lb_vendor_date);
//		$criteria->compare('lb_vendor_due_date',$this->lb_vendor_due_date,true);
		$criteria->compare('lb_vendor_notes',$this->lb_vendor_notes,true);
		$criteria->compare('lb_vendor_subject',$this->lb_vendor_subject,true);
		$criteria->compare('lb_vendor_status',$this->lb_vendor_status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbVendor the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
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
                $next_number = $nextNo->lb_next_po_number;
            }
            
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randstring = '';
            for ($i = 0; $i < 10; $i++) {
                $randstring .= $characters[rand(0, strlen($characters)-1)];
            }
            $randstring.=$next_number.'po';
            return base64_encode($randstring);
        }
        
         public function getDisplayPOStatus($status)
        {
        if($status==self::LB_PO_STATUS_CODE_DRAFT)
            return 'Draft';
        if($status==self::LB_PO_STATUS_CODE_SEND)
            return 'send';
        if($status==self::LB_PO_STATUS_CODE_ACCEPTED)
            return 'accepted';
        if($status==self::LB_PO_STATUS_CODE_OPEN)
            return 'open';
        if($status==self::LB_VENDOR_STATUS_CODE_WRITTEN_OFF)
            return 'Written Off';
        if($status==self::LB_PO_STATUS_CODE_APPROVED)
            return 'approved';
        if($status==self::LB_PO_STATUS_CODE_REJECTED)
            return 'rejected';
       
        }
        
         public function confirm()
        {
            // don't do anything if invoice is already confirmed, to avoid
            // increasing invoice number by mistake
            if ($this->lb_vendor_status == self::LB_PO_STATUS_CODE_DRAFT)
            {
                $this->lb_vendor_no = $this->formatVendorNextNumFormatted($this->getVendorNextNum());
                $this->lb_vendor_status = $this::LB_PO_STATUS_CODE_APPROVED;
                return $this->save();
                return $this->getVendorNextNum();
            }

            return false;
        }
        
        
        public function formatVendorNextNumFormatted($invoice_number_int) {
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
		$next_invoice_number = "VD-".$created_year;
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
        
        public function getVendorNextNum() {
		
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
				$next_po_number = $nextInvoiceNo->lb_next_po_number;
		} else {
			$nextInvoiceNo = $last_used;
			$next_invoice_number = $nextInvoiceNo->lb_next_po_number;
		}

        // advance next invoice number
        $nextInvoiceNo->lb_next_po_number++;
        $nextInvoiceNo->save();
		
        return $next_invoice_number;
		//trigger_error('Not Implemented!', E_USER_WARNING);
	}
        
        
        public function getVendor($status=false,$pageSize=5,$user_id=false)
        {
            $criteria  = new CDbCriteria();
            if($status)
                $criteria->compare('lb_vendor_status',"$status");
            
            $dataProvider = $this->getFullRecordsDataProvider($criteria, null, $pageSize, $user_id);
            
        
            return $dataProvider;
 
        }
        
        
        
	
       
}
