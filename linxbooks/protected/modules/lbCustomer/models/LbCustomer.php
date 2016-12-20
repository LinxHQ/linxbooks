<?php

/**
 * This is the model class for table "lb_customers".
 *
 * The followings are the available columns in table 'lb_customers':
 * @property integer $lb_record_primary_key
 * @property string $lb_customer_name
 * @property string $lb_customer_registration
 * @property string $lb_customer_tax_id
 * @property string $lb_customer_website_url
 * @property integer $lb_customer_is_own_company
 */
class LbCustomer extends CLBActiveRecord
{
	var $record_title_column_name = 'lb_customer_name';
	
	//var $module_name = 'lbCustomer';
	const LB_CUSTOMER_IS_OWN_COMPANY = 1;
	const LB_CUSTOMER_IS_NOT_OWN_COMPANY = 0;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_customers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lb_customer_name, lb_customer_is_own_company', 'required'),
			array('lb_customer_is_own_company', 'numerical', 'integerOnly'=>true),
			array('lb_customer_name, lb_customer_website_url', 'length', 'max'=>255),
			array('lb_customer_registration, lb_customer_tax_id', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lb_record_primary_key, lb_customer_name, lb_customer_registration, lb_customer_tax_id, lb_customer_website_url, lb_customer_is_own_company', 'safe', 'on'=>'search'),
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
                    'payment'=>array(self::HAS_MANY,'LbPayment','lb_payment_customer_id'),
                    'paymentVendor'=>array(self::HAS_MANY,'LbPaymentVendor','lb_payment_vendor_customer_id'),
                    );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'lb_record_primary_key' => 'ID',
			'lb_customer_name' => Yii::t('lang', 'Name'),
			'lb_customer_registration' => Yii::t('lang', 'Registration'),
			'lb_customer_tax_id' => Yii::t('lang', 'Tax Code'),
			'lb_customer_website_url' => Yii::t('lang', 'Website'),
			'lb_customer_is_own_company' => Yii::t('lang', 'Own Company'),
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
              
		$criteria->compare('t.lb_record_primary_key',$this->lb_record_primary_key);
		$criteria->compare('lb_customer_name',$this->lb_customer_name,true);
		$criteria->compare('lb_customer_registration',$this->lb_customer_registration,true);
		$criteria->compare('lb_customer_tax_id',$this->lb_customer_tax_id,true);
		$criteria->compare('lb_customer_website_url',$this->lb_customer_website_url,true);
		$criteria->compare('lb_customer_is_own_company',$this->lb_customer_is_own_company);
                
                $dataProvider = $this->getFullRecordsDataProvider($criteria,null,20,$user_id);
                
                return $dataProvider;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbCustomer the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function afterSave()
	{
        if ($this->lb_customer_is_own_company == self::LB_CUSTOMER_IS_OWN_COMPANY)
    		$this->resetOwnCompany($this->lb_record_primary_key);
		parent::afterSave();
	}
	
	public function getCompanies($sort = 'lb_customer_name ASC', $return_type = self::LB_QUERY_RETURN_TYPE_ACTIVE_DATA_PROVIDER)
	{
		$criteria=new CDbCriteria;
		$criteria->order = $sort;
		$dataProvider = $this->getFullRecordsDataProvider($criteria);
		
		return $this->getResultsBasedForReturnType($dataProvider, $return_type);
	}
	
	/**
	 * Get the owner company of this subscription
	 * 
	 * @return LbCustomer	the model for own company record
	 */
	public function getOwnCompany()
	{
		$criteria=new CDbCriteria();
		$criteria->compare('lb_customer_is_own_company', self::LB_CUSTOMER_IS_OWN_COMPANY);
		$results = $this->getFullRecords($criteria);
		
		if (count($results))
		{
			return $results[0];
		}
		
		// no own company
		// show some message
		$ownCompany = new LbCustomer();
		$ownCompany->lb_customer_name = 'Your company information is not setup';
		return $ownCompany;
	}
	
	/**
	 * This function is called by save()
	 * If user choose another company as his own company (ie subscription's owner company),
	 * we'll have to reset. Because we only allow one own company per subscription.
	 * 
	 * @param unknown $company_id
	 */
	private function resetOwnCompany($company_id)
	{
		$criteria=new CDbCriteria();
		$results = $this->getFullRecords($criteria);
		
		// set all companies of this subscription to be NOT OWN COMPANY
		$newOwnCompany=null;
		foreach ($results as $company)
		{
                        if($company->lb_record_primary_key != $company_id)
                        {
                            // remove own company flag by default
                            $company->lb_customer_is_own_company = self::LB_CUSTOMER_IS_NOT_OWN_COMPANY;
                            $company->save();
                        }
			
		}
//                // set own company if applicable
//                $model = LbCustomer::model()->findByPk($company_id);
//                $model->lb_customer_is_own_company = self::LB_CUSTOMER_IS_OWN_COMPANY;
//                $model->save();
	}
        public function getCompaniesByPayment($sort = 't.lb_customer_name ASC', $return_type = self::LB_QUERY_RETURN_TYPE_ACTIVE_DATA_PROVIDER,$customer_id=false,$date_from=false,$date_to=false,$user_id=false){
               
            $criteria = new CDbCriteria();
            //$criteria -> join = 'INNER JOIN lb_payment p ON p.lb_payment_customer_id = t.lb_record_primary_key';
            $criteria -> with = array('payment');
            
            if($customer_id)
                $criteria->compare ('t.lb_record_primary_key', intval($customer_id));
            if($date_from)
                $criteria ->compare ('payment.lb_payment_date >',"$date_from");
            if($date_to)
                $criteria ->compare ('payment.lb_payment_date <',"$date_to");
            
            $criteria->order = $sort;
            $criteria->group = 't.lb_record_primary_key';
            
            $dataProvider = $this->getFullRecordsDataProvider($criteria,NULL,FALSE,$user_id);
            
            return $this->getResultsBasedForReturnType($dataProvider, $return_type);
        }
        
         public function customerInformation($customer_id)
       {
            $criteria = new CDbCriteria();
            if($customer_id)
               $criteria->compare ('t.lb_record_primary_key', intval($customer_id));
            
           return $this->find($criteria);

       }
       
       public function isCustomer($customer_id)
       {
           $customer_arr=  $this->getCompanies($sort = 'lb_customer_name ASC',
                            LbCustomer::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);
           $customer = false;
           foreach ($customer_arr as $data)
           {
               if($data['lb_record_primary_key'] == $customer_id)
                   $customer = true;
           }
           return $customer;
       }
       
       public function getCompaniesByPaymentVendor($sort = 't.lb_customer_name ASC', $return_type = self::LB_QUERY_RETURN_TYPE_ACTIVE_DATA_PROVIDER,$customer_id=false,$date_from=false,$date_to=false,$user_id=false){
               
            $criteria = new CDbCriteria();
            //$criteria -> join = 'INNER JOIN lb_payment p ON p.lb_payment_customer_id = t.lb_record_primary_key';
            $criteria -> with = array('paymentVendor');
            
            if($customer_id)
                $criteria->compare ('t.lb_record_primary_key', intval($customer_id));
            if($date_from)
                $criteria ->compare ('paymentVendor.lb_payment_vendor_date >',"$date_from");
            if($date_to)
                $criteria ->compare ('paymentVendor.lb_payment_vendor_date <',"$date_to");
            
            $criteria->order = $sort;
            $criteria->group = 't.lb_record_primary_key';
            
            $dataProvider = $this->getFullRecordsDataProvider($criteria,NULL,FALSE,$user_id);
            
            return $this->getResultsBasedForReturnType($dataProvider, $return_type);
        }
    public function searchCustomer($search_name,$page=10,$user_id=false)
    {
        $criteria=new CDbCriteria();    
        $criteria->select='t.*,';
        $criteria->select .='i.lb_customer_address_line_1, i.lb_customer_address_line_2';
        
        $criteria->join='LEFT JOIN lb_customer_addresses i ON t.lb_record_primary_key = i.lb_customer_id';
            $criteria->condition .= ' lb_customer_name LIKE "%'.$search_name.'%" OR i.lb_customer_address_line_1 LIKE "%'.$search_name.'%" OR i.lb_customer_address_line_2 LIKE "%'.$search_name.'%"';
      //  $search_name = $_REQUEST['search_name'];      
       //$criteria->condition .= ' lb_customer_name LIKE "%'.$search_name.'%" OR lb_customer_registration LIKE "%'.$search_name.'%"';
        $dataProvider = new CActiveDataProvider($this,array('criteria'=>$criteria),$page,$user_id);
        return $dataProvider;

    }
   
    
}
