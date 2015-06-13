<?php

/**
 * This is the model class for table "lb_quotation".
 *
 * The followings are the available columns in table 'lb_quotation':
 * @property integer $lb_record_primary_key
 * @property integer $lb_company_id
 * @property integer $lb_company_address_id
 * @property integer $lb_quotation_customer_id
 * @property integer $lb_quotation_customer_address_id
 * @property integer $lb_quotation_attention_id
 * @property string $lb_quotation_no
 * @property string $lb_quotation_date
 * @property string $lb_quotation_due_date
 * @property string $lb_quotation_subject
 * @property string $lb_quotation_note
 * @property integer $lb_quotation_status
 * @property string $lb_quotation_encode
 * @property string $lb_quotation_internal_note
 */
class LbQuotation extends CLBActiveRecord
{
        var $module_name = 'lbQuotation';
        
	const LB_QUOTATION_STATUS_CODE_DRAFT = 'Q-DRAFT';
	const LB_QUOTATION_STATUS_CODE_READY = 'Q-READY';
	const LB_QUOTATION_STATUS_CODE_APPROVED = 'Q-APPROVED';
	const LB_QUOTATION_STATUS_CODE_SENT = 'Q-SENT';
        const LB_QUOTATION_STATUS_CODE_ACCEPTED = 'Q_ACCEPTED';
        const LB_QUOTATION_STATUS_CODE_REJECTED = 'Q_REJECTED';
        const LB_QUOTATION_STATUS_CODE_UNSUCCESSFUL = 'Q-UNSUCCESSFUL';
        const LB_QUOTATION_NUMBER_MAX_LENGTH = 11;
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_quotation';
	}
        
        public function __construct($scenario = 'insert') 
        {
            parent::__construct($scenario);
            
            $this->lb_quotation_no = 0;
            $this->lb_quotation_no = $this->formatQuotationNextNumFormatted($this->lb_quotation_no);
            $this->lb_quotation_status = self::LB_QUOTATION_STATUS_CODE_DRAFT;
            $this->lb_company_id = 5;
            
            $this->lb_quotation_date = date('Y-m-d');
            $this->lb_quotation_due_date = date('Y-m-d');
            
            $this->lb_quotation_encode = $this->setBase64_decodeQuotation();
            
            // set invoice note
            $lastDefaultNote = LbDefaultNote::model()->getFullRecords();
            if(count($lastDefaultNote)>0)
                $this->lb_quotation_note = $lastDefaultNote[0]->lb_default_note_quotation;
        }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lb_quotation_no, lb_quotation_date, lb_quotation_due_date,lb_quotation_status', 'required'),
			array('lb_company_id, lb_company_address_id, lb_quotation_customer_id, lb_quotation_customer_address_id, lb_quotation_attention_id', 'numerical', 'integerOnly'=>true),
			array('lb_quotation_no', 'length', 'max'=>50),
                        array('lb_quotation_status', 'length', 'max'=>20),
			array('lb_quotation_subject, lb_quotation_encode', 'length', 'max'=>255),
                        array('lb_quotation_note, lb_quotation_internal_note', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lb_record_primary_key, lb_company_id, lb_company_address_id, lb_quotation_customer_id, lb_quotation_customer_address_id, lb_quotation_attention_id, lb_quotation_no, lb_quotation_date, lb_quotation_due_date, lb_quotation_subject, lb_quotation_note, lb_quotation_status, lb_quotation_encode', 'safe', 'on'=>'search'),
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
                    'owner'=>array(self::BELONGS_TO,'LbCustomer','lb_company_id'),
                    'ownerAddress'=>array(self::BELONGS_TO,'LbCustomerAddress','lb_company_address_id'),
                    'customer'=>array(self::BELONGS_TO,'LbCustomer','lb_quotation_customer_id'),
                    'customerAddress'=>array(self::BELONGS_TO,'LbCustomerAddress','lb_quotation_customer_address_id'),
                    'customerContact'=>array(self::BELONGS_TO,'LbCustomerContact','lb_quotation_attention_id'),
                    'quotationTotal'=>array(self::HAS_ONE, 'LbQuotationTotal','lb_quotation_id'),
                    'core_entities'=>array(self::HAS_ONE, 'LbCoreEntity', 'lb_entity_primary_key'),
                    
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'lb_record_primary_key' => 'Record Primary Key',
			'lb_company_id' => Yii::t('lang','Company'),
			'lb_company_address_id' => Yii::t('lang','Company Address'),
			'lb_quotation_customer_id' => Yii::t('lang','Customer'),
			'lb_quotation_customer_address_id' => Yii::t('lang','Quotation Customer Address'),
			'lb_quotation_attention_id' => Yii::t('lang','Quotation Attention'),
			'lb_quotation_no' => Yii::t('lang','Quotation No'),
			'lb_quotation_date' => Yii::t('lang','Date'),
			'lb_quotation_due_date' => Yii::t('lang','Due Date'),
			'lb_quotation_subject' => Yii::t('lang','Subject'),
			'lb_quotation_note' => Yii::t('lang','Quotation Note'),
			'lb_quotation_status' => Yii::t('lang','Status'),
			'lb_quotation_encode' => Yii::t('lang','Quotation Encode'),
                        'lb_quotation_internal_note'=>Yii::t('lang','Internal Note'),
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
	public function search($user_id=false,$status_id=true)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('lb_record_primary_key',$this->lb_record_primary_key);
		$criteria->compare('lb_company_id',$this->lb_company_id);
		$criteria->compare('lb_company_address_id',$this->lb_company_address_id);
		$criteria->compare('lb_quotation_customer_id',$this->lb_quotation_customer_id);
		$criteria->compare('lb_quotation_customer_address_id',$this->lb_quotation_customer_address_id);
		$criteria->compare('lb_quotation_attention_id',$this->lb_quotation_attention_id);
		$criteria->compare('lb_quotation_no',$this->lb_quotation_no,true);
		$criteria->compare('lb_quotation_date',$this->lb_quotation_date,true);
		$criteria->compare('lb_quotation_due_date',$this->lb_quotation_due_date,true);
		$criteria->compare('lb_quotation_subject',$this->lb_quotation_subject,true);
		$criteria->compare('lb_quotation_note',$this->lb_quotation_note,true);
		$criteria->compare('lb_quotation_status',$this->lb_quotation_status);
		$criteria->compare('lb_quotation_encode',$this->lb_quotation_encode,true);
                if($status_id)
                    $criteria->compare ('lb_quotation_status', $status_id, true);
                $criteria->order='lb_quotation_due_date ASC';
                
                $dataProvider = $this->getFullRecordsDataProvider($criteria,null,20,$user_id);
                return $dataProvider;

//		return new CActiveDataProvider($this, array(
//			'criteria'=>$criteria,
//                        'pagination'=>array(
//                            'pageSize'=>20,
//                        ),
//		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbQuotation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
	public function saveUnconfirmed($runValidation=true,$attributes=NULL)
	{
		//$this->lb_invoice_no = '0';
		//$this->lb_invoice_date = date('Y-m-d');
		//$this->lb_invoice_due_date = date('Y-m-d');
		
		return parent::save($runValidation,$attributes);
	}
        
        function getNextQuotationNumber()
        {
            $next_quotation_number = 0;
            
            $last_used = LbNextId::model()->getOneRecords();
            
            if(count($last_used)>1){
                return false;
            }
            if(count($last_used)<=0)
            {
                $nextQuotationNo = new LbNextId();
                $nextQuotationNo->lb_next_quotation_number=1;
                $nextQuotationNo->lb_next_invoice_number = 1;
                $nextQuotationNo->lb_next_payment_number = 1;
                $nextQuotationNo->lb_next_contract_number = 1;
                $nextQuotationNo->lb_next_po_number=1;
                $nextQuotationNo->lb_next_supplier_invoice_number=1;
                $nextQuotationNo->lb_next_supplier_payment_number=1;
                if($nextQuotationNo->save())
                {
                    $next_quotation_number = $nextQuotationNo->lb_next_quotation_number;
                }
            }
            else
            {
                $nextQuotationNo = $last_used;
                $next_quotation_number = $nextQuotationNo->lb_next_quotation_number;
            }
            
            $nextQuotationNo->lb_next_quotation_number++;
            $nextQuotationNo->save();
            return  $next_quotation_number;
        }
        
        function formatQuotationNextNumFormatted($quotation_number_int)
        {
            if($quotation_number_int==0)
            {
                return "Draft";
            }
                // Confirmed invoice

		// get int value of next quotation number
		// get its length
		$quotation_number_len = strlen($quotation_number_int);

            // prefix with "I-yyyy"
            $created_year = date('Y');
                    $next_quotation_number = "Q-".$created_year;
                    $preceding_zeros_count = self::LB_QUOTATION_NUMBER_MAX_LENGTH - strlen($created_year) - $quotation_number_len;
                    while($preceding_zeros_count > 0)
                    {
                            $next_quotation_number .= '0';
                            $preceding_zeros_count--;
                    }
                    $next_quotation_number .= $quotation_number_int;
                    //$this->lb_invoice_no_formatted = $next_invoice_number;

                    return $next_quotation_number;
        }
        function confirm()
        {
            // don't do anything if quotation is already confirmed, to avoid
            // increasing quotation number by mistake
            if ($this->lb_quotation_status == self::LB_QUOTATION_STATUS_CODE_DRAFT)
            {
                $this->lb_quotation_no = $this->formatQuotationNextNumFormatted($this->getNextQuotationNumber());
                $this->lb_quotation_status = self::LB_QUOTATION_STATUS_CODE_APPROVED;
                if($this->save()){
                    return $this->lb_quotation_no;
                }
            }

            return false;
        }
        function setBase64_decodeQuotation()
        {
            $last_used = LbNextId::model()->getFullRecords();
            if(count($last_used)<=0)
            {
                $next_quotation_number=0;
            }
            else
            {
                $nextQuotationNo = $last_used[0];
                $next_quotation_number = $nextQuotationNo->lb_next_quotation_number;
            }
            
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randstring = '';
            for ($i = 0; $i < 10; $i++) {
                $randstring .= $characters[rand(0, strlen($characters)-1)];
            }
            $randstring.=$next_quotation_number;
            return base64_encode($randstring);
        }
        function delete() {
            $quotation_id = $this->lb_record_primary_key;
            $result = parent::delete();
            if($result)
            {
                $quotation_item = LbQuotationItem::model()->getquotationItems($quotation_id);
                foreach ($quotation_item->data as $item)
                {
                    $item->delete();
                }
                
                $quotation_discount = LbQuotationDiscount::model()->getQuotationDiscounts($quotation_id);
                foreach ($quotation_discount->data as $discount) {
                    $discount->delete();
                }
                
                $quotation_tax = LbQuotationTax::model()->getTaxQuotation($quotation_id);
                foreach ($quotation_tax->data as $tax) {
                    $tax->delete();
                }
                
                $quotation_total = LbQuotationTotal::model()->getQuotationTotal($quotation_id);
                $quotation_total->delete();
            }
        }
        /**
         * Once a customer is (re)set
         * address and attention must be reset too
         *
         * @param $customer_id
         */
        function setCustomer($customer_id)
        {
            $this->lb_quotation_customer_id = $customer_id;
            $this->lb_quotation_customer_address_id = 0;
            $this->lb_quotation_attention_id = 0;
            return $this->save();
        }
        
        function getMoveIQuotationNum($quotation_number,$move_type=false){
            $criteria = new CDbCriteria;
            $criteria->join='LEFT JOIN lb_customers a ON a.lb_record_primary_key = t.lb_quotation_customer_id';
            if($move_type=="next")
            {
                $criteria->condition='lb_quotation_no > "'.$quotation_number.' " AND lb_quotation_no <> "Draft"';
                $criteria->order='lb_quotation_no ASC';
            }
            elseif($move_type=="previous"){
                $criteria->condition='lb_quotation_no < "'.$quotation_number.' " AND lb_quotation_no <> "Draft"';
                $criteria->order='lb_quotation_no DESC';
            }
            elseif ($move_type=='last')
            {
                $criteria->condition='lb_quotation_no > "'.$quotation_number.' " AND lb_quotation_no <> "Draft"';
                $criteria->order='lb_quotation_no DESC';
            }
            elseif ($move_type=='first')
            {
                $criteria->condition='lb_quotation_no < "'.$quotation_number.' " AND lb_quotation_no <> "Draft"';
                $criteria->order='lb_quotation_no ASC';
            }
                
            $model = LbQuotation::model()->find($criteria);
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
        /**
         * 
         * @param array $status value: LB_QUOTATION_STATUS_CODE_DRAFT, LB_QUOTATION_STATUS_CODE_READY, LB_QUOTATION_STATUS_CODE_APPROVED,
         *              LB_QUOTATION_STATUS_CODE_SENT, LB_QUOTATION_STATUS_CODE_ACCEPTED, LB_QUOTATION_STATUS_CODE_REJECTED, LB_QUOTATION_STATUS_CODE_UNSUCCESSFUL
         * @param int $pageSize Song iten trong 1 pages gridview default = 10
         * @return CActiveDataProvide data record quotation
         * @access public
         */
        public function getQuotationByStatus($status,$pageSize=NULL,$user_id=false)
        {
            $criteria = new CDbCriteria();
            $criteria->condition = 'lb_quotation_status IN '.$status;
            $criteria->order="lb_quotation_due_date DESC";
            
            $dataProvider = $this->getFullRecordsDataProvider($criteria,null,$pageSize,$user_id);
            
            
            return $dataProvider;
        }
        
        public function getDisplayQuotationStatus($status)
        {
            if($status==self::LB_QUOTATION_STATUS_CODE_DRAFT)
                return 'Draft';
            if($status==self::LB_QUOTATION_STATUS_CODE_SENT)
                return 'Sent';
            if($status==self::LB_QUOTATION_STATUS_CODE_READY)
                return 'READY';
            if($status==self::LB_QUOTATION_STATUS_CODE_REJECTED)
                return 'Rejected';
            if($status==self::LB_QUOTATION_STATUS_CODE_UNSUCCESSFUL)
                return 'Unsuccessful';
            if($status==self::LB_QUOTATION_STATUS_CODE_APPROVED)
                return 'Approved';
            if($status==self::LB_QUOTATION_STATUS_CODE_ACCEPTED)
                return 'Accepted';
        }
        
        public function getArrayStatusQuotation()
        {
            $arr = array();
            $arr[self::LB_QUOTATION_STATUS_CODE_DRAFT] = 'Draft';
            $arr[self::LB_QUOTATION_STATUS_CODE_SENT] = 'Send';
            $arr[self::LB_QUOTATION_STATUS_CODE_READY] = 'Approved';
            $arr[self::LB_QUOTATION_STATUS_CODE_REJECTED] = 'Accepted';
            $arr[self::LB_QUOTATION_STATUS_CODE_REJECTED] = 'Rejected';
            
            return $arr;
        }
        
         public function searchQuotationByName($search_name=false,$page=10,$user_id=false)
        {
             if(isset($_REQUEST['search_name']))
                $search_name = $_REQUEST['search_name'];
            $status='("'.LbQuotation::LB_QUOTATION_STATUS_CODE_DRAFT.'","'.LbQuotation::LB_QUOTATION_STATUS_CODE_SENT.'")'; 
            $criteria = new CDbCriteria();
            $criteria->select='t.*,';
            $criteria->select .='i.lb_customer_name';
            $criteria->order = 'lb_quotation_due_date DESC';
            $criteria->join='LEFT JOIN lb_customers i ON i.lb_record_primary_key = t.lb_quotation_customer_id';
            $criteria->condition = 'lb_quotation_status IN '.$status;
            if($search_name)
            {
                $criteria->condition .= ' AND (lb_quotation_no LIKE "%'.$search_name.'%" OR i.lb_customer_name LIKE "%'.$search_name.'%")';
          
            }

            $dataProvider = new CActiveDataProvider($this,array('criteria'=>$criteria),$page,$user_id);

            return $dataProvider;
        }
        
}
