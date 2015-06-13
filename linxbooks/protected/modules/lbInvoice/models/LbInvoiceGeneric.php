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
 * @property string $lb_invoice_internal_note
 * @property string $lb_invoice_encode
 * @property integer $lb_quotation_id Description
 */
class LbInvoiceGeneric extends CLBActiveRecord
{
	var $module_name = 'lbInvoice';
	var $lb_invoice_no_formatted = '';
	
	// Attributes
	/**
	 * Different invoice status codes
	 * Format:
	 * 	- for quotations: Q-<Code>
	 *  - for invoices: I-<code>
     *
     * Invoice:
     *
     *  DRAFT -> OPEN -> AWAITING PAYMENT
     *
     *  - When created, invoice is set to status DRAFT, no invoice number is assigned yet.
     *  - When an invoice is confirmed, its status is set to OPEN, a unique number is assigned.
     *  - Once invoice is sent to customer, status can be set to AWAITING_PAYMENT
     *  - If invoice is paid but not full paid, status is PARTIALLY_PAID
     *  - Fully paid invoice status is FULL_PAID
     *  - Invoice status is set to OVER_DUE if it's already awaiting payment, and not yet FULLY_PAID
	 */
    const LB_INVOICE_STATUS_CODE_DRAFT = 'I_DRAFT';
    const LB_INVOICE_STATUS_CODE_OPEN = 'I_OPEN';
    //const LB_INVOICE_STATUS_CODE_AWAITING_PAYMENT = 'I_AWAITING_PAYMENT';
	//const LB_INVOICE_STATUS_CODE_OUTSTANDING = 'I_PARTIALLY_PAID';
	const LB_INVOICE_STATUS_CODE_PAID = 'I_PAID';
	const LB_INVOICE_STATUS_CODE_OVERDUE = 'I_OVERDUE';
	const LB_INVOICE_STATUS_CODE_WRITTEN_OFF = 'I_WRITTEN_OFF';

	//const LB_QUOTATION_STATUS_CODE_DRAFT = 'Q-DRAFT';
	const LB_QUOTATION_STATUS_CODE_READY = 'Q-READY';
	const LB_QUOTATION_STATUS_CODE_APPROVED = 'Q-APPROVED';
	const LB_QUOTATION_STATUS_CODE_SENT = 'Q-SENT';
	const LB_QUOTATION_STATUS_CODE_UNSUCCESSFUL = 'Q-UNSUCCESSFUL';
	
	const LB_INVOICE_GROUP_QUOTATION = 'QUOTATION';
	const LB_INVOICE_GROUP_INVOICE = 'INVOICE';
	
	/**
	 * maximum length of an invoice number
	 * 
	 * @var unknown
	 */
	const LB_INVOICE_NUMBER_MAX_LENGTH = 11;
	
	/**
	* XXX
	 *
	 * @var    const $LB_PERM_CREATE_INVOICE
	 * @access public
	 */
	 const LB_PERM_CREATE_INVOICE = 'PermCreateInvoice';
	
	 /**
	 * XXX
	*
	* @var    const $LB_PERM_DELETE_INVOICE
	* @access public
	*/
	const LB_PERM_DELETE_INVOICE = 'PermDeleteInvoice';
	
	/**
	* XXX
	*
	* @var    const $LB_PERM_UPDATE_INVOICE
	* @access public
	*/
	const LB_PERM_UPDATE_INVOICE = 'PermUpdateInvoice';
	
	/**
	* XXX
	 *
	 * @var    const $LB_PERM_VIEW_INVOICE
	* @access public
	*/
	const LB_PERM_VIEW_INVOICE = 'PermViewInvoice';
	

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_invoices';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('lb_invoice_group, lb_invoice_no, lb_invoice_date', 'required'),
				array('lb_generated_from_quotation_id, lb_invoice_company_id, lb_invoice_company_address_id, lb_invoice_customer_id, lb_invoice_customer_address_id, lb_invoice_attention_contact_id, lb_quotation_id', 'numerical', 'integerOnly'=>true),
				array('lb_invoice_group, lb_invoice_status_code', 'length', 'max'=>60),
				array('lb_invoice_no', 'length', 'max'=>50),
				array('lb_invoice_subject', 'length', 'max'=>255),
                                array('lb_invoice_encode', 'length', 'max'=>300),
				array('lb_invoice_due_date, lb_invoice_note', 'safe'),
				array('lb_invoice_no_formatted, lb_invoice_internal_note', 'safe'),
				// The following rule is used by search().
				// Please remove those attributes that should not be searched.
				array('lb_record_primary_key, lb_invoice_group, lb_generated_from_quotation_id, lb_invoice_no, lb_invoice_date, lb_invoice_due_date, lb_invoice_company_id, lb_invoice_company_address_id, lb_invoice_customer_id, lb_invoice_customer_address_id, lb_invoice_attention_contact_id, lb_invoice_subject, lb_invoice_note, lb_invoice_status_code, lb_invoice_encode, lb_quotation_id', 'safe', 'on'=>'search'),
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
				'owner'=>array(self::BELONGS_TO,'LbCustomer','lb_invoice_company_id'),
				'ownerAddress'=>array(self::BELONGS_TO,'LbCustomerAddress','lb_invoice_company_address_id'),
				'customer'=>array(self::BELONGS_TO,'LbCustomer','lb_invoice_customer_id'),
				'customerAddress'=>array(self::BELONGS_TO,'LbCustomerAddress','lb_invoice_customer_address_id'),
                                'customerContact'=>array(self::BELONGS_TO,'LbCustomerContact','lb_invoice_attention_contact_id'),
                                'payment'=>array(self::HAS_MANY,'LbPaymentItem','lb_invoice_id'),
                                'total_invoice'=>array(self::HAS_ONE,'LbInvoiceTotal','lb_invoice_id'),
                                'core_entities'=>array(self::HAS_ONE,'LbCoreEntity','lb_entity_primary_key'),
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
	public function search($user_id=false,$status_id=false)
	{
		// Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('lb_record_primary_key',$this->lb_record_primary_key);
		$criteria->compare('lb_invoice_group',$this->lb_invoice_group,true);
		$criteria->compare('lb_generated_from_quotation_id',$this->lb_generated_from_quotation_id);
		$criteria->compare('lb_invoice_no',$this->lb_invoice_no,true);
		$criteria->compare('lb_invoice_date',$this->lb_invoice_date,true);
		$criteria->compare('lb_invoice_due_date',$this->lb_invoice_due_date,true);
		$criteria->compare('lb_invoice_company_id',$this->lb_invoice_company_id);
		$criteria->compare('lb_invoice_company_address_id',$this->lb_invoice_company_address_id);
		$criteria->compare('lb_invoice_customer_id',$this->lb_invoice_customer_id);
		$criteria->compare('lb_invoice_customer_address_id',$this->lb_invoice_customer_address_id);
		$criteria->compare('lb_invoice_attention_contact_id',$this->lb_invoice_attention_contact_id);
		$criteria->compare('lb_invoice_subject',$this->lb_invoice_subject,true);
		$criteria->compare('lb_invoice_note',$this->lb_invoice_note,true);
		$criteria->compare('lb_invoice_status_code',$this->lb_invoice_status_code,true);
                $criteria->compare('lb_invoice_encode', $this->lb_invoice_encode, true);
                $criteria->compare('lb_quotation_id', $this->lb_quotation_id, true);
                if($status_id)
                    $criteria->compare('lb_invoice_status_code',$status_id,true);
                $criteria->order = 'lb_invoice_due_date DESC';

                $dataProvider = $this->getFullRecordsDataProvider($criteria,null, 20,$user_id);
                return $dataProvider;
                
//		return new CActiveDataProvider($this, array(
//			'criteria'=>$criteria,
//                        'pagination'=>array(
//                            'pageSize'=>20,
//                        ),
//		));
 
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
		//$this->lb_invoice_no = '0';
		//$this->lb_invoice_date = date('Y-m-d');
		//$this->lb_invoice_due_date = date('Y-m-d');
		
		return parent::save($runValidation,$attributes);
	}
	
	/**
	 * Get number of days that this invoice/quotation is overdue
	 * counted from Due Date
	 *
	 * @return int number of days, 0 if not overdue
	 * @access public
	 */
	function getDaysOverdue() {
		$due_date = $this->lb_invoice_due_date;
		$due_date_time = strtotime($due_date);
		$now = time();
		
		// Due date is in the past
		// that means this record is overdue
		if ($due_date_time < $now)
		{
			$over_due = $now = $due_date_time;
			$number_of_days = $over_due/24*60*60;
			
			return $number_of_days;
		}
		
		return 0;
	}
	
	/**
	 * get status name of this invoice/quotation
	 * not the status code.
	 * This function retrieve the code and search for this display text.
	 *
	 * @return string dispay text of status
	 * @access public
	 */
	function getStatusName() {
		trigger_error('Not Implemented!', E_USER_WARNING);
	}
	
	/**
	 * XXX
	 *
	 * @return double XXX
	 * @access public
	 */
	function getSubTotal() {
		trigger_error('Not Implemented!', E_USER_WARNING);
	}
	
	/**
	 * XXX
	 *
	 * @return double XXX
	 * @access public
	 */
	function getDiscountTotal() {
		trigger_error('Not Implemented!', E_USER_WARNING);
	}
	
	/**
	 * XXX
	 *
	 * @return double XXX
	 * @access public
	 */
	function getTotalAfterDiscount() {
		trigger_error('Not Implemented!', E_USER_WARNING);
	}
	
	/**
	 * XXX
	 *
	 * @return double XXX
	 * @access public
	 */
	function getTaxTotal() {
		trigger_error('Not Implemented!', E_USER_WARNING);
	}
	
	/**
	 * XXX
	 *
	 * @return double XXX
	 * @access public
	 */
	function getTotalAfterTax() {
		trigger_error('Not Implemented!', E_USER_WARNING);
	}
	
	/**
	 * XXX
	 *
	 * @return array XXX
	 * @access public
	 */
	function getTaxes() {
		trigger_error('Not Implemented!', E_USER_WARNING);
	}
	
	/**
	 * XXX
	 *
	 * @return array XXX
	 * @access public
	 */
	function getDiscounts() {
		trigger_error('Not Implemented!', E_USER_WARNING);
	}
	
	/**
	 * XXX
	 *
	 * @return string XXX
	 * @access public
	 */
	function getPublicURL() {
		trigger_error('Not Implemented!', E_USER_WARNING);
	}

    /**
     * Once a customer is (re)set
     * address and attention must be reset too
     *
     * @param $customer_id
     */
    function setCustomer($customer_id)
    {
        $this->lb_invoice_customer_id = $customer_id;
        $this->lb_invoice_customer_address_id = 0;
        $this->lb_invoice_attention_contact_id = 0;
        return $this->save();
    }
    
    public function getArrayStatusInvoice()
    {
        $arr = array();
        $arr[self::LB_INVOICE_STATUS_CODE_DRAFT] = 'Draft';
        $arr[self::LB_INVOICE_STATUS_CODE_OPEN] = 'Open';
        $arr[self::LB_INVOICE_STATUS_CODE_OVERDUE] = 'Overdue';
        $arr[self::LB_INVOICE_STATUS_CODE_PAID] = 'Paid';
        $arr[self::LB_INVOICE_STATUS_CODE_WRITTEN_OFF] = 'Written off';
        
        return $arr;
    }
}
