<?php

/**
 * This is the model class for table "lb_invoices".
 *
 * The followings are the available columns in table 'lb_invoices':
 * @property integer $lb_record_primary_key
 * @property string $lb_invoice_group
 * @property integer $lb_generated_from_quotation_id
 * @property string $lb_invoice_no
 * @property string $lb_invoice_date
 * @property string $lb_invoice_due_date
 * @property integer $lb_invoice_company_id
 * @property integer $lb_invoice_company_address_id
 * @property integer $lb_invoice_customer_id
 * @property integer $lb_invoice_customer_address_id
 * @property integer $lb_invoice_attention_contact_id
 * @property string $lb_invoice_subject
 * @property string $lb_invoice_note
 * @property string $lb_invoice_status_code
 */
class LbInvoice extends LbInvoiceGeneric
{
    var $invoice_paid_amount = 0;
    
	public function __construct($scenario = 'insert')
	{
		parent::__construct($scenario);
		
		// initiate invoice number
		$this->lb_invoice_no = 0 ; // a draft only. $this->getInvoiceNextNum();
		$this->lb_invoice_no = $this->formatInvoiceNextNumFormatted($this->lb_invoice_no);
		$this->lb_invoice_status_code = self::LB_INVOICE_STATUS_CODE_DRAFT;

		// invoice date
		$this->lb_invoice_date = date('Y-m-d');
		$this->lb_invoice_due_date = date('Y-m-d');
		
		// invoice group
		$this->lb_invoice_group = self::LB_INVOICE_GROUP_INVOICE;
                
                // invoice base64_decode
                $this->lb_invoice_encode = $this->setBase64_decodeInvoice();
                
                // set invoice note
                $lastDefaultNote = LbDefaultNote::model()->getFullRecords();
                if(count($lastDefaultNote)>0)
                    $this->lb_invoice_note = $lastDefaultNote[0]->lb_default_note_invoice;
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
				'lb_record_primary_key' => 'ID',
				'lb_invoice_group' => Yii::t('lang','Group'),
				'lb_generated_from_quotation_id' => Yii::t('lang','From Quotation'),
				'lb_invoice_no' => Yii::t('lang','Invoice No'),
				'lb_invoice_date' => Yii::t('lang','Start Date'),
				'lb_invoice_due_date' => Yii::t('lang','Due Date'),
				'lb_invoice_company_id' => Yii::t('lang','Company'),
				'lb_invoice_company_address_id' => Yii::t('lang','Company Address'),
				'lb_invoice_customer_id' => Yii::t('lang','Customer'),
				'lb_invoice_customer_address_id' => Yii::t('lang','Customer Address'),
				'lb_invoice_attention_contact_id' => Yii::t('lang','Attention'),
				'lb_invoice_subject' => Yii::t('lang','Subject'),
				'lb_invoice_note' => Yii::t('lang','Note'),
				'lb_invoice_status_code' => Yii::t('lang','Status'),
                                'lb_invoice_encode' => Yii::t('lang','Invoice Encode'),
                                'lb_invoice_internal_note'=>Yii::t('lang','Internal Note')
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbInvoice the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * delete invoice
     * line items, discounts, taxes, totals, trails, ...
     * @return bool|void
     */
    public function delete()
    {
        // delete invoice
        $id = $this->lb_record_primary_key;
        $result = parent::delete();
        if ($result)
        {
            // delete line items
            $line_items = LbInvoiceItem::model()->getInvoiceItems($id, self::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);
            foreach($line_items as $l_item)
            {
                $l_item->delete();
            }

            // delete discounts
            $discounts = LbInvoiceItem::model()->getInvoiceDiscounts($id, self::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);
            foreach($discounts as $disc)
            {
                $disc->delete();
            }

            // delete taxes
            $taxes = LbInvoiceItem::model()->getInvoiceTaxes($id, self::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);
            foreach($taxes as $tx)
            {
                $tx->delete();
            }

            // delete totals
            $total = LbInvoiceTotal::model()->getInvoiceTotal($id);
            if ($total)
            {
                $total->delete();
            }
            
            // delete invoice in contract
            $invoiceByContract = LbContractInvoice::model()->find('lb_invoice_id='.intval($id));
            if(count($invoiceByContract)>0)
                $invoiceByContract->delete();
        }
    }
	
	/**
	 * Save an unconfirmed copy. This record has almost nothing
	 *
	 * @param string $runValidation
	 * @param string $attributes
	 * @return boolean
	 */
	public function saveUnconfirmed($runValidation=true,$attributes=NULL)
	{
		//$this->lb_invoice_group = self::LB_INVOICE_GROUP_INVOICE;
		return parent::saveUnconfirmed($runValidation,$attributes);
	}

    /**
     * Confirm an invoice
     * Assign a unique invoice number to it,
     * Change its status
     * Save to the database
     *
     * @return boolean $status true for success, false for failure or already confirmed.
     */
    public function confirm()
    {
        // don't do anything if invoice is already confirmed, to avoid
        // increasing invoice number by mistake
        if ($this->lb_invoice_status_code == self::LB_INVOICE_STATUS_CODE_DRAFT)
        {
            $this->lb_invoice_no = $this->formatInvoiceNextNumFormatted($this->getInvoiceNextNum());
            $this->lb_invoice_status_code = $this::LB_INVOICE_STATUS_CODE_OPEN;
            return $this->save();
            return $this->getInvoiceNextNum();
        }

        return false;
    }
	
	/**
	 * Check permission for action related to this model
	 *
	 * @param  string $permission_code refer to const variable of this class
	 * @return boolean action allowed or not
	 * @access public
	 */
	function checkPermission($permission_code) {
		trigger_error('Not Implemented!', E_USER_WARNING);
	}
	
	/**
	 * Get invoices 
	 *
	 * @param  string $invoice_status_code status code of required invoices, default is ALL
	 * @param  int $customer_id customer id if any
	 * @param  string $return_type return type of results, default LB_QUERY_RETURN_TYPE_ACTIVE_DATA_PROVIDER
	 * @param  string $sort order of sql result
	 * @return mixed depends on return type
	 * @access public
	 */
	function getInvoices($invoice_status_code = 'ALL', $customer_id = 0, 
			$return_type = self::LB_QUERY_RETURN_TYPE_ACTIVE_DATA_PROVIDER, $sort = '') {
		trigger_error('Not Implemented!', E_USER_WARNING);
	}
	
	/**
	 * XXX
	 *
	 * @return double XXX
	 * @access public
	 */
	function getOutstandingAmount() {
		trigger_error('Not Implemented!', E_USER_WARNING);
	}
	
	/**
	 * Retrieve invoice next number
     * Return it for usage
     * Advance it by +1 and save to the database
	 *
	 * @return string invoice number to use
	 * @access public
	 */
	public function getInvoiceNextNum() {
		$next_invoice_number = 0;
		
		// get last used number
		/**
		$criteria=new CDbCriteria(); 
		$criteria->join = "LEFT JOIN lb_core_entities ON lb_entity_type = '" . $this->getEntityType() . "'" .
				" AND lb_entity_primary_key = t.lb_record_primary_key" .
				" AND lb_subscription_id = " . LBApplication::getCurrentlySelectedSubscription();
		**/
		
		//$last_used = LbNextId::model()->getFullRecords();
                //$last_used = LbNextId::model()->findAll();
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
				$next_invoice_number = $nextInvoiceNo->lb_next_invoice_number;
		} else {
			$nextInvoiceNo = $last_used;
			$next_invoice_number = $nextInvoiceNo->lb_next_invoice_number;
		}

        // advance next invoice number
        $nextInvoiceNo->lb_next_invoice_number++;
        $nextInvoiceNo->save();
		
		return $next_invoice_number;
		//trigger_error('Not Implemented!', E_USER_WARNING);
	}
	
	/**
	 * Get next invoice number that is already formatted
	 * Such as preceded with "I" and zeros
     *
     * If invoice status is invoice number is zero, return 'Draft'
	 * 
	 * @param int	$invoice_number_int int value of invoice number
	 * @return string $formatted_invoice_no
	 */
	public function formatInvoiceNextNumFormatted($invoice_number_int) {
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
		$next_invoice_number = "I-".$created_year;
		$preceding_zeros_count = self::LB_INVOICE_NUMBER_MAX_LENGTH - strlen($created_year) - $invoice_number_len;
		while($preceding_zeros_count > 0)
		{
			$next_invoice_number .= '0';
			$preceding_zeros_count--;
		}
		$next_invoice_number .= $invoice_number_int;
		//$this->lb_invoice_no_formatted = $next_invoice_number;
		 
		return $next_invoice_number;
	}
	
	/**
	 * No need: use LbInvoiceTotal model
	 *
         * @param  int  $invoice_id
	 * @return double $paid_amount
	 * @access public
	 */
	function getPaid($invoice_id = 0) {
            // No need: use LbInvoiceTotal model
	}
	
	/**
	 * No need: use LbInvoiceTotal model
	 *
	 * @return double XXX
	 * @access public
	 */
	function getOutstanding($invoice_id = 0) {
            // No need: use LbInvoiceTotal model
            
	}
	
	/**
	 * XXX
	 *
	 * @return void XXX
	 * @access public
	 */
	function writeOff() {
		trigger_error('Not Implemented!', E_USER_WARNING);
	}
	
	/**
	 * XXX
	 *
	 * @access public
	 */
	function getPDF() {
		trigger_error('Not Implemented!', E_USER_WARNING);
	}
	
	/**
	 * XXX
	 *
	 * @return boolean XXX
	 * @access private
	 */
	/**
	function _checkPermission<<permission_code>>() {
		trigger_error('Not Implemented!', E_USER_WARNING);
	}**/
        
         /**
	 * XXX
	 *
	 * @access public
	 */
        function getMoveInvoiceNum($invoice_number,$move_type=false){
            $criteria = new CDbCriteria;
            $criteria->join='LEFT JOIN lb_customers a ON a.lb_record_primary_key = t.lb_invoice_customer_id';
            if($move_type=="next")
            {
                $criteria->condition='lb_invoice_no > "'.$invoice_number.' " AND lb_invoice_no <> "Draft" AND lb_invoice_group="INVOICE"';
                $criteria->order='lb_invoice_no ASC';
            }
            elseif($move_type=="previous"){
                $criteria->condition='lb_invoice_no < "'.$invoice_number.' " AND lb_invoice_no <> "Draft" AND lb_invoice_group="INVOICE"';
                $criteria->order='lb_invoice_no DESC';
            }
            elseif ($move_type=='last')
            {
                $criteria->condition='lb_invoice_no > "'.$invoice_number.' " AND lb_invoice_no <> "Draft" AND lb_invoice_group="INVOICE"';
                $criteria->order='lb_invoice_no DESC';
            }
            elseif ($move_type=='first')
            {
                $criteria->condition='lb_invoice_no < "'.$invoice_number.' " AND lb_invoice_no <> "Draft" AND lb_invoice_group="INVOICE"';
                $criteria->order='lb_invoice_no ASC';
            }
                
        $model = LbInvoice::model()->find($criteria);
        $data = array();
        if(count($model)>0){
            $data[0] = $model->lb_record_primary_key;
            if($model->customer)
                $data[1] = $model->customer->lb_customer_name;
            else
                $data[1] = "No customer";
        }
        return $data;
                //$model = LbInvoice::model()->find('lb_record_primary_key >'.intval($invoice_id).' ORDER BY lb_record_primary_key');
        }
        
    function getInvoiceAmountByCustomer($customer_id){
        $criteria = new CDbCriteria();
        $criteria->join='INNER JOIN lb_invoice_totals i ON i.lb_invoice_id = t.lb_record_primary_key';
        $criteria->condition='lb_invoice_customer_id = '. intval($customer_id).' AND lb_invoice_no <> "Draft" AND i.lb_invoice_total_outstanding > 0';

        $dataProvider = new CActiveDataProvider($this,array('criteria'=>$criteria));

        return $dataProvider;
    }
    public function getInvoicePaidByCustomer($customer_id){
        $criteria = new CDbCriteria();
        $criteria->join = "INNER JOIN lb_payment_item i ON t.lb_record_primary_key = i.lb_invoice_id";
        $criteria->condition = "t.lb_invoice_customer_id = ".intval($customer_id);
        return LbInvoice::model()->with('customerAddress')->findAll($criteria);
        
    }
    
    public function setBase64_decodeInvoice()
    {
        $last_used = LbNextId::model()->getFullRecords();
        if(count($last_used)<=0)
            $next_invoice_number = 0;
        else
        {
            $nextNo = $last_used[0];
            $next_invoice_number = $nextNo->lb_next_quotation_number;
        }
        
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < 10; $i++) {
            $randstring .= $characters[rand(0, strlen($characters)-1)];
        }
        $randstring.=$next_invoice_number;
        return base64_encode($randstring);
    }
    
     public function InvoiceUpdateStatus($id=false)
     {
        if($id)
        {
            $invoiceTotal = LbInvoiceTotal::model()->getInvoiceTotal($id);
            if($invoiceTotal->lb_invoice_total_outstanding==0)
            {
                $invoice = LbInvoice::model()->findByPk($id);
                $invoice->lb_invoice_status_code = LbInvoice::LB_INVOICE_STATUS_CODE_PAID;
                $invoice->save();
                return $invoice->lb_invoice_status_code;
            }
        }
    }
    
    /**
     * lay cac record invoice theo dieu kien cac status.
     * @param array $status value: LB_INVOICE_STATUS_CODE_DRAFT, LB_INVOICE_STATUS_CODE_OPEN, LB_INVOICE_STATUS_CODE_PAID
     *                              LB_INVOICE_STATUS_CODE_OVERDUE, LB_INVOICE_STATUS_CODE_WRITTEN_OFF
     * @param date $year
     * @param int $pageSize Song iten trong 1 pages gridview default = 10
     * @return CActiveProvider data
     * @access public
     */
    public function getInvoiceByStatus($status,$year=false,$pageSize=10,$user_id=false)
    {
        $criteria = new CDbCriteria();
        $criteria->condition = 'lb_invoice_status_code IN '.$status;
        $criteria->order = 'lb_invoice_due_date DESC';
        if($year)
            $criteria->condition = 'lb_invoice_status_code IN '.$status.' AND YEAR(lb_invoice_date) = "'.$year.'"';
        
        $dataProvider = $this->getFullRecordsDataProvider($criteria,null,$pageSize,$user_id);
        return $dataProvider;
    }
    
    /**
     * Tinh total admount cua tat ca cac invoice co status Overdua, Paid, Open.
     * @param array $status value: LB_INVOICE_STATUS_CODE_DRAFT, LB_INVOICE_STATUS_CODE_OPEN, LB_INVOICE_STATUS_CODE_PAID
     *                              LB_INVOICE_STATUS_CODE_OVERDUE, LB_INVOICE_STATUS_CODE_WRITTEN_OF
     * @param date $year 
     * @return double $totalAmount
     * @access public
     */
    public function calculateInvoiceTotalAmount($status,$year=false)
    {
        $model = $this->getInvoiceByStatus($status,$year);
        $totalAmount = 0;
        foreach ($model->data as $data) {
            $totalAmount+=$data->total_invoice->lb_invoice_total_after_taxes;
        }
        return $totalAmount;
    }
    
    /**
     * Tinh total cua tat ca cac invoice co status Overdua, Paid, Open, chua tra.
     * @param array $status value: LB_INVOICE_STATUS_CODE_DRAFT, LB_INVOICE_STATUS_CODE_OPEN, LB_INVOICE_STATUS_CODE_PAID
     *                              LB_INVOICE_STATUS_CODE_OVERDUE, LB_INVOICE_STATUS_CODE_WRITTEN_OF
     * @param date $year 
     * @return double $totalAmount
     * @access public
     */
    public function calculateInvoiceTotalOutstanding($status,$year=false)
    {
        $model = $this->getInvoiceByStatus($status,$year);
        $totalAmount = 0;
        foreach ($model->data as $data) {
            $totalAmount+=$data->total_invoice->lb_invoice_total_outstanding;
        }
        return $totalAmount;
    }
    
    /**
     * Tinh total invoice payment theo date year
     * @param date $year defaul nam hien tai
     * @return double $totalPayment
     * @access public
     */
    public function calculateInvoiceTotalPaymentByYear($year=false)
    {
        return LbPayment::model()->calculateTotalPayment($year);
    }
    
    /*
     * Lay tat cac cac record Invoice cua 1 address
     * @param int $address_id
     * @return dataProvider
     * @access public
     */
    
    public function getInvoiceByAddress($address_id)
    {
        $criteria = new CDbCriteria();
        $criteria->condition="lb_invoice_customer_address_id=".intval($address_id);
        
        $dateProvider = new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
        ));
        return $dateProvider;
    }
    
    /*
     * Lay tat ca cac invoice cua 1 contact
     * @param int $contact_id 
     * @return $dataProvider
     * @access public
     */
    public function getInvoiceByContact($contact_id)
    {
        $criteria = new CDbCriteria();
        $criteria->condition="lb_invoice_attention_contact_id=".intval($contact_id);
        
        $dateProvider = new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
        ));
        return $dateProvider;
    }
    
    /*
     * Lay tat cac invoice cua 1 khach hang
     * @param int $customer_id
     * @return $dataProvider
     * @access public
     */
    function getInvoiceAllByCustomer($customer_id){
        $criteria = new CDbCriteria();
        $criteria->join='INNER JOIN lb_invoice_totals i ON i.lb_invoice_id = t.lb_record_primary_key';
        $criteria->condition='lb_invoice_customer_id = '. intval($customer_id);

        $dataProvider = new CActiveDataProvider($this,array('criteria'=>$criteria));

        return $dataProvider;
    }
    
    /*
     *Hien thi status theo dinh dang.
     * @param string $status
     * @return $dataProvider
     * @access public
     */
    public function getDisplayInvoiceStatus($status)
    {
        if($status==self::LB_INVOICE_STATUS_CODE_DRAFT)
            return 'Draft';
        if($status==self::LB_INVOICE_STATUS_CODE_OPEN)
            return 'Open';
        if($status==self::LB_INVOICE_STATUS_CODE_OVERDUE)
            return 'Overdue';
        if($status==self::LB_INVOICE_STATUS_CODE_WRITTEN_OFF)
            return 'Written Off';
        if($status==self::LB_INVOICE_STATUS_CODE_PAID)
            return 'Paid';
    }
    
    public function getInvoiceCustomer($Customer_id)
   {
       $criteria=new CDbCriteria;
       $criteria->compare('lb_invoice_customer_id',$Customer_id);
        $ct=  new CActiveDataProvider($this, array(
               'criteria'=>$criteria,
       ));
       $cout=$ct->itemCount;

       return $cout;

   }
   
   public function getInvoiceByQuotation($quotation_id)
   {
        $criteria = new CDbCriteria();
        $criteria->condition = 'lb_quotation_id = '.$quotation_id;
        
        $dataProvider = $this->getFullRecordsDataProvider($criteria);
        return $dataProvider;
   }
       
   function getInvoiceByCustomerDate($customer_id,$date_form)
    {
        $criteria = new CDbCriteria();
        $criteria->join='INNER JOIN lb_invoice_totals i ON i.lb_invoice_id = t.lb_record_primary_key';
        $criteria->condition='lb_invoice_customer_id = '. intval($customer_id).' AND lb_invoice_no <> "Draft" AND i.lb_invoice_total_outstanding > 0';

        if($date_form)
                $criteria ->compare ('t.lb_invoice_date <',"$date_form");
        return LbInvoice::model()->with('customerAddress')->findAll($criteria);
       
    }
    
     public function getInvoicePaidByCustomerDate($customer_id=false,$invoice_id=false){
        $criteria = new CDbCriteria();
        $criteria->join = "INNER JOIN lb_payment_item i ON t.lb_record_primary_key = i.lb_invoice_id";
        $criteria->condition = "t.lb_invoice_customer_id = ".intval($customer_id);
        if($invoice_id)
            $criteria->compare ("t.lb_record_primary_key", $invoice_id);
        return LbInvoice::model()->with('customerAddress')->findAll($criteria);
        
    }
    public function getInvoiceMonth($customer_id=false,$date_form=false,$date_to=FALSE,$month=false,$year=false)
   {
        
        $criteria = new CDbCriteria();
        $criteria->condition=' lb_invoice_no <> "Draft" ';
        
        if($date_form)
            $criteria->addBetweenCondition("lb_invoice_date", $date_form, $date_to, "AND");
        if($customer_id)
            $criteria->compare ('lb_invoice_customer_id', $customer_id);
       
        return LbInvoice::model()->findAll($criteria);
   }
    public function getInvoiceStatement($customer_id=false,$contact_id=false,$address_id=false,$invoice_status=false,$date_form=false,$date_to=false,$orderBy=false)
    {
        $criteria = new CDbCriteria();
//        $criteria->condition='lb_invoice_customer_id = '. intval($customer_id);
        if($invoice_status)
            $criteria->condition = 'lb_invoice_status_code IN '.$invoice_status.' AND lb_invoice_customer_id = '.$customer_id;
        if($contact_id)
            $criteria->compare ("lb_invoice_attention_contact_id", $contact_id);
        if($address_id)
            $criteria->compare ("lb_invoice_customer_address_id", $address_id);
        $criteria->addBetweenCondition("lb_invoice_date", $date_form, $date_to, "AND");
        $criteria->order="lb_invoice_customer_address_id ASC";
        
        return LbInvoice::model()->findAll($criteria);
    }
    
    public function getTotalInvoiceByMonth($year=false,$month=false)
    {
        $status='("'.LbInvoice::LB_INVOICE_STATUS_CODE_OPEN.'","'.LbInvoice::LB_INVOICE_STATUS_CODE_OVERDUE.'")'; 
        $model = LbInvoice::model()->findAll('YEAR(lb_invoice_date) = '.$year.' AND MONTH(lb_invoice_date) ='.$month.' AND lb_invoice_status_code IN '.$status.'');
        $total = 0;
        foreach ($model as $value)
        {
            $totalArr = LbInvoiceTotal::model()->find('lb_invoice_id = '.$value->lb_record_primary_key);
            $total +=$totalArr->lb_invoice_total_outstanding;
        }
        return $total;
    }
    
    public function searchInvoiceByName($search_name=false,$page=10,$user_id=false)
    {
        if(isset($_REQUEST['search_name']))
            $search_name = $_REQUEST['search_name'];
        $status='("'.LbInvoice::LB_INVOICE_STATUS_CODE_DRAFT.'","'.LbInvoice::LB_INVOICE_STATUS_CODE_OPEN.'","'.LbInvoice::LB_INVOICE_STATUS_CODE_OVERDUE.'")'; 
        $criteria = new CDbCriteria();
        $criteria->select='t.*,';
        $criteria->select .='i.lb_customer_name';
        $criteria->order = 'lb_invoice_due_date DESC';
        $criteria->join='LEFT JOIN lb_customers i ON i.lb_record_primary_key = t.lb_invoice_customer_id';
        $criteria->condition = 'lb_invoice_status_code IN '.$status;
        if($search_name)
        {
            $criteria->condition .= ' AND (lb_invoice_no LIKE "%'.$search_name.'%" OR i.lb_customer_name LIKE "%'.$search_name.'%")';
          
        }
        $dataProvider = new CActiveDataProvider($this,array('criteria'=>$criteria),$page,$user_id);

        return $dataProvider;

    }
    
}
