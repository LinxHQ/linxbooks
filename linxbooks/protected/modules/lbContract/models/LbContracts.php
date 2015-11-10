<?php

/**
 * This is the model class for table "lb_contracts".
 *
 * The followings are the available columns in table 'lb_contracts':
 * @property integer $lb_record_primary_key
 * @property integer $lb_customer_id
 * @property integer $lb_address_id
 * @property integer $lb_contact_id
 * @property string $lb_contract_no
 * @property string $lb_contract_notes
 * @property string $lb_contract_date_start
 * @property string $lb_contract_date_end
 * @property string $lb_contract_type
 * @property string $lb_contract_amount
 * @property integer $lb_contract_parent
 * @property integer $lb_contract_status
 * @property integer $lb_contract_term
 */
class LbContracts extends CLBActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        const LB_CONTRACT_STATUS_ACTIVE = "Active";
        const LB_CONTRACT_STATUS_NO_ACTIVE = "Terminated by Customer";
        const LB_CONTRACT_STATUS_HAS_RENEWED = "Renewed";
        const LB_CONTRACT_STATUS_END = "Ended";
        const LB_CONTRACT_NUMBER_MAX = 11;
        
        public static $ContractStatusArray = array(
                                                        self::LB_CONTRACT_STATUS_ACTIVE=>self::LB_CONTRACT_STATUS_ACTIVE,
                                                        self::LB_CONTRACT_STATUS_NO_ACTIVE=>self::LB_CONTRACT_STATUS_NO_ACTIVE,
                                                        self::LB_CONTRACT_STATUS_END=>self::LB_CONTRACT_STATUS_END,
                                                        self::LB_CONTRACT_STATUS_HAS_RENEWED=>self::LB_CONTRACT_STATUS_HAS_RENEWED,
                                                  );
        protected $lb_contract_term;
        protected $lb_amount;

        var $module_name = "lbContract";
	public function tableName()
	{
		return 'lb_contracts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lb_customer_id, lb_contract_no, lb_contract_date_start, lb_contract_date_end, lb_contract_amount', 'required'),
			array('lb_customer_id, lb_address_id, lb_contact_id, lb_contract_parent', 'numerical', 'integerOnly'=>true),
			array('lb_contract_no', 'length', 'max'=>50),
			array('lb_contract_notes', 'length', 'max'=>255),
			array('lb_contract_type', 'length', 'max'=>100),
			array('lb_contract_amount', 'length', 'max'=>10),
                        array('lb_contract_status', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lb_record_primary_key, lb_customer_id, lb_address_id, lb_contact_id, lb_contract_no, lb_contract_notes, lb_contract_date_start, lb_contract_date_end, lb_contract_type, lb_contract_amount, lb_contract_parent, lb_contract_status', 'safe', 'on'=>'search'),
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
			'lb_customer_id' => Yii::t('lang','Customer'),
			'lb_address_id' => Yii::t('lang','Address'),
			'lb_contact_id' => Yii::t('lang','Contact'),
			'lb_contract_no' => Yii::t('lang','Contract No'),
			'lb_contract_notes' => Yii::t('lang','Contract Notes'),
			'lb_contract_date_start' => Yii::t('lang','Start Date'),
			'lb_contract_date_end' => Yii::t('lang','End Date'),
			'lb_contract_type' => Yii::t('lang','Contract Type'),
			'lb_contract_amount' => Yii::t('lang','Contract Amount'),
			'lb_contract_parent' => Yii::t('lang','Contract Parent'),
			'lb_contract_status' => Yii::t('lang','Status'),
                        'lb_contract_term'  =>Yii::t('lang','Term'),
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

		$criteria->compare('lb_record_primary_key',$this->lb_record_primary_key);
		$criteria->compare('lb_customer_id',$this->lb_customer_id);
		$criteria->compare('lb_address_id',$this->lb_address_id);
		$criteria->compare('lb_contact_id',$this->lb_contact_id);
		$criteria->compare('lb_contract_no',$this->lb_contract_no,true);
		$criteria->compare('lb_contract_notes',$this->lb_contract_notes,true);
		$criteria->compare('lb_contract_date_start',$this->lb_contract_date_start,true);
		$criteria->compare('lb_contract_date_end',$this->lb_contract_date_end,true);
		$criteria->compare('lb_contract_type',$this->lb_contract_type,true);
		$criteria->compare('lb_contract_amount',$this->lb_contract_amount,true);
		$criteria->compare('lb_contract_parent',$this->lb_contract_parent);
		$criteria->compare('lb_contract_status',$this->lb_contract_status);
                
                $dataProvider = $this->getFullRecordsDataProvider($criteria,$user_id);
                
                return $dataProvider;

	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbContracts the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function calculateExpiring($data_end)
        {
            $day = (strtotime($data_end)-strtotime(date("Y-m-d")))/(60*60*24);
            return $day;
        }
        
        public function getExpiringContract($pageSize=5,$user_id=false)
        {
            $criteria = new CDbCriteria;
            
            $criteria->select='`t`.*,DATEDIFF( lb_contract_date_end , CURDATE()) AS `lb_contract_term`';
            $criteria->compare('DATEDIFF( lb_contract_date_end , CURDATE()) <','30',false,'AND');
            $criteria->compare('lb_contract_status',"<>".self::LB_CONTRACT_STATUS_HAS_RENEWED);
            $criteria->order="lb_contract_date_end ASC";
            
            $dataProvider = $this->getFullRecordsDataProvider($criteria, null, $pageSize,$user_id);
        
            return $dataProvider;
          

        }
        
        public function getContract($status=false,$pageSize=20,$user_id=false)
        {
            $criteria  = new CDbCriteria;
            if($status)
                $criteria->compare('lb_contract_status',"$status");
            
            $dataProvider = $this->getFullRecordsDataProvider($criteria, null, $pageSize, $user_id);
            
        
            return $dataProvider;
 
        }
        
        public function getTimeOutContract($contract_id)
        {
            $criteria = new CDbCriteria;
            
            $criteria->select='*,DATEDIFF( `t`.`lb_contract_date_end` , `t`.`lb_contract_date_start`) AS `lb_contract_term`';
            $criteria->compare('`t`.lb_record_primary_key',$contract_id);
             
            $contract = LbContracts::model()->find($criteria);
            $today = date('Y-m-d');
            $date = strtotime(date("Y-m-d", strtotime($today))."+ $contract->lb_contract_term day");
            return strftime('%Y-%m-%d',$date) ;
            
            
        }
        
        public function getContractNextNum()
        {
            $next_contract_number = 0;

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
                $next_contract_number = 1;
                $nextcontractNo = new LbNextId();
                $nextcontractNo->lb_next_invoice_number = 1;
                $nextcontractNo->lb_next_quotation_number = 1;
                $nextcontractNo->lb_next_payment_number = 1;
                $nextcontractNo->lb_next_contract_number=1;
                    if ($nextcontractNo->save())
                            $next_contract_number = $nextcontractNo->lb_next_contract_number;
            } else {
                    $nextcontractNo = $last_used[0];
                    $next_contract_number = $nextcontractNo->lb_next_contract_number;
            }

            return $next_contract_number;
            //trigger_error('Not Implemented!', E_USER_WARNING);
    }
    
    public function setContractNextNum($contractNextNo)
    {
        $contractNextNo++;
        $last_used = LbNextId::model()->getFullRecords();
        
        $nextcontractNo = $last_used[0];
        $nextcontractNo->lb_next_contract_number = $contractNextNo;
        $nextcontractNo->save();
    }

    public function FormatContractNo($contractNextNo)
   {
        
        // R-YYYY
        $createYear = date('Y');
        $next_contract_number = 'C-'.$createYear;
            $preceding_zeros_count = self::LB_CONTRACT_NUMBER_MAX - strlen($createYear) - strlen($contractNextNo);
            while($preceding_zeros_count > 0)
            {
                    $next_contract_number .= '0';
                    $preceding_zeros_count--;
            }
            $next_contract_number .= $contractNextNo;
            //$this->lb_invoice_no_formatted = $next_invoice_number;

            return $next_contract_number;
    }
    
    public function getContractIdArrayOutstanding()
    {
        $criteria  = new CDbCriteria;
        $dataProvider = LbContracts::model()->getFullRecordsDataProvider();
        $contract_id_arr = array();
        foreach ($dataProvider->data as $data) {
            $TotalAmountInvoice = LbInvoiceTotal::model()->getTotalAmountInvoiceByContract($data->lb_record_primary_key);
            if($data->lb_contract_amount > $TotalAmountInvoice)
                $contract_id_arr[] = $data->lb_record_primary_key;
        }
        return $contract_id_arr;
    }
        public function getContractCustomer($Customer_id)
        {
            $criteria=new CDbCriteria;
            $criteria->compare('lb_customer_id',$Customer_id);
             return  new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
           
           
        }
    public function getContractOutstanding($pageSize=20,$user_id=false)
    {
        $contract_id_arr = $this->getContractIdArrayOutstanding();
        $where ="";
        if(count($contract_id_arr)>0)
        {
            $contract_id_arr = implode(",", $contract_id_arr);
            $where = ' AND t.lb_record_primary_key IN ('.$contract_id_arr.')';
        }
        $criteria  = new CDbCriteria;
        $criteria->condition='t.lb_contract_status ="'.self::LB_CONTRACT_STATUS_ACTIVE.'"'.$where;

//        $dataProvider = new CActiveDataProvider($this, array(
//                'criteria'=>$criteria,
//                'pagination'=>array(
//                    'pageSize'=>$pageSize,
//                ),
//        ));
        $dataProvider = $this->getFullRecordsDataProvider($criteria, null, 10,$user_id);

     
            return $dataProvider;
           
 
    }
    
    public function countContractByCustomer($customer_id)
    {
        $criteria = new CDbCriteria();
        if($customer_id)
            $criteria->compare ('t.lb_customer_id', intval($customer_id));
        
       return $this->findAll($criteria);
    }
    
}
