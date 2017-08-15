<?php

/**
 * This is the model class for table "lb_customer_addresses".
 *
 * The followings are the available columns in table 'lb_customer_addresses':
 * @property integer $lb_record_primary_key
 * @property integer $lb_customer_id
 * @property string $lb_customer_address_line_1
 * @property string $lb_customer_address_line_2
 * @property string $lb_customer_address_city
 * @property string $lb_customer_address_state
 * @property string $lb_customer_address_country
 * @property string $lb_customer_address_postal_code
 * @property string $lb_customer_address_website_url
 * @property string $lb_customer_address_phone_1
 * @property string $lb_customer_address_phone_2
 * @property string $lb_customer_address_fax
 * @property string $lb_customer_address_email
 * @property string $lb_customer_address_note
 * @property integer $lb_customer_address_is_active
 * @property integer $lb_customer_address_is_billing
 */
class LbCustomerAddress extends CLBActiveRecord
{
	const LB_CUSTOMER_ADDRESS_IS_ACTIVE = 1;
	const LB_CUSTOMER_ADDRESS_IS_NOT_ACTIVE = 0;
        public static $dropdownActive = array(
            self::LB_CUSTOMER_ADDRESS_IS_ACTIVE=>'ACTIVE',
            self::LB_CUSTOMER_ADDRESS_IS_NOT_ACTIVE=>'NOT ACTIVE'
       );

        var $record_title_column_name = 'lb_customer_address_line_1';
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_customer_addresses';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lb_customer_id, lb_customer_address_line_1, lb_customer_address_is_active', 'required'),
			array('lb_customer_id, lb_customer_address_is_active, lb_customer_address_is_billing,lb_customer_address_phone_1,lb_customer_address_phone_2, lb_customer_address_fax', 'numerical', 'integerOnly'=>true),
			array('lb_customer_address_line_1, lb_customer_address_line_2, lb_customer_address_website_url, lb_customer_address_note', 'length', 'max'=>255),
			array('lb_customer_address_city, lb_customer_address_state, lb_customer_address_country, lb_customer_address_email', 'length', 'max'=>100),
			array('lb_customer_address_postal_code', 'length', 'max'=>20),
			array('lb_customer_address_phone_1, lb_customer_address_phone_2, lb_customer_address_fax', 'length', 'max'=>50),
                        array('lb_customer_address_email','email'),
                        //array('lb_customer_address_email','unique'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lb_record_primary_key, lb_customer_id, lb_customer_address_line_1, lb_customer_address_line_2, lb_customer_address_city, lb_customer_address_state, lb_customer_address_country, lb_customer_address_postal_code, lb_customer_address_website_url, lb_customer_address_phone_1, lb_customer_address_phone_2, lb_customer_address_fax, lb_customer_address_email, lb_customer_address_note, lb_customer_address_is_active', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'lb_record_primary_key' => 'Customer Address',
			'lb_customer_id' => Yii::t('lang','Customer'),
			'lb_customer_address_line_1' => Yii::t('lang','Address Line').' 1',
			'lb_customer_address_line_2' => Yii::t('lang','Address Line').' 2',
			'lb_customer_address_city' => Yii::t('lang','City'),
			'lb_customer_address_state' => Yii::t('lang','State/Province'),
			'lb_customer_address_country' => Yii::t('lang','Country'),
			'lb_customer_address_postal_code' => Yii::t('lang','Postal Code'),
			'lb_customer_address_website_url' => Yii::t('lang','Website Url'),
			'lb_customer_address_phone_1' => Yii::t('lang','Phone').' 1',
			'lb_customer_address_phone_2' => Yii::t('lang','Phone').' 2',
			'lb_customer_address_fax' => Yii::t('lang','Fax'),
			'lb_customer_address_email' => Yii::t('lang','Email'),
			'lb_customer_address_note' => Yii::t('lang','Note'),
			'lb_customer_address_is_active' => Yii::t('lang','Is Active'),
			'lb_customer_address_is_billing' => Yii::t('lang','Billing Address'),
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
		$criteria->compare('lb_customer_id',$this->lb_customer_id);
		$criteria->compare('lb_customer_address_line_1',$this->lb_customer_address_line_1,true);
		$criteria->compare('lb_customer_address_line_2',$this->lb_customer_address_line_2,true);
		$criteria->compare('lb_customer_address_city',$this->lb_customer_address_city,true);
		$criteria->compare('lb_customer_address_state',$this->lb_customer_address_state,true);
		$criteria->compare('lb_customer_address_country',$this->lb_customer_address_country,true);
		$criteria->compare('lb_customer_address_postal_code',$this->lb_customer_address_postal_code,true);
		$criteria->compare('lb_customer_address_website_url',$this->lb_customer_address_website_url,true);
		$criteria->compare('lb_customer_address_phone_1',$this->lb_customer_address_phone_1,true);
		$criteria->compare('lb_customer_address_phone_2',$this->lb_customer_address_phone_2,true);
		$criteria->compare('lb_customer_address_fax',$this->lb_customer_address_fax,true);
		$criteria->compare('lb_customer_address_email',$this->lb_customer_address_email,true);
		$criteria->compare('lb_customer_address_note',$this->lb_customer_address_note,true);
		$criteria->compare('lb_customer_address_is_active',$this->lb_customer_address_is_active);
		$criteria->compare('lb_customer_address_is_billing',$this->lb_customer_address_is_billing);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbCustomerAddress the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * Get customer addresses
	 * 
	 * @param int $customer_id
	 * @param string $return_type default is CActiveDataProvider
	 */
	public function getAddresses($customer_id, $return_type = self::LB_QUERY_RETURN_TYPE_ACTIVE_DATA_PROVIDER)
	{
		// set search condition 
		$criteria=new CDbCriteria;
		$criteria->compare('lb_customer_id',$customer_id);
		$criteria->order= 'lb_customer_address_line_1 ASC';
		
		$dataProvider = new CActiveDataProvider('LbCustomerAddress', array(
				'criteria'=> $criteria,
		));
		
		return $this->getResultsBasedForReturnType($dataProvider, $return_type);
	}
	
	/**
	 * 
	 * @param int $customer_id
	 * @param const $return_type
	 * @return Ambigous <CActiveDataProvider, multitype:, array>
	 */
	public function getActiveAddresses($customer_id, $return_type = self::LB_QUERY_RETURN_TYPE_ACTIVE_DATA_PROVIDER)
	{
		// set search condition 
		$criteria=new CDbCriteria;
		$criteria->compare('lb_customer_id',$customer_id);
		$criteria->compare('lb_customer_address_is_active',self::LB_CUSTOMER_ADDRESS_IS_ACTIVE);
		$criteria->order= 'lb_customer_address_line_1 ASC';
		
		$dataProvider = new CActiveDataProvider('LbCustomerAddress', array(
				'criteria'=> $criteria,
		));
		
		return $this->getResultsBasedForReturnType($dataProvider, $return_type);
	}
	
	/**
	 * Format this address 
	 * Each line as an array item
	 * 
	 * @return array	$address_array;
	 */
	public function formatAddressLines()
	{
		$address_array = array();
        $address_array['lb_record_primary_key'] = $this->lb_record_primary_key;
		$address_array['success'] = 'Saved';
		$address_array['formatted_address_line_1'] =
			$this->lb_customer_address_line_1
			. ($this->lb_customer_address_line_2 ? ". {$this->lb_customer_address_line_2}" : '');
		$address_array['formatted_address_line_2'] =
			($this->lb_customer_address_state ? "{$this->lb_customer_address_state}," : '')
			. ($this->lb_customer_address_city ? " {$this->lb_customer_address_city}," : '')
			. ($this->lb_customer_address_country ? " {$this->lb_customer_address_country}" : '')
			. ($this->lb_customer_address_postal_code ? " {$this->lb_customer_address_postal_code}" : '');
		$address_array['formatted_address_line_3'] =
			($this->lb_customer_address_phone_1 ? "Phone: {$this->lb_customer_address_phone_1}," : '').
			($this->lb_customer_address_fax ? " Fax: {$this->lb_customer_address_fax}" : '');
		$address_array['formatted_address_line_4'] =
			($this->customer->lb_customer_website_url ? " {$this->customer->lb_customer_website_url}" : '');
		
		return $address_array;
	}
        
         public function getAddressesByCustomer($customer_id)
	{
		// set search condition 
		$criteria=new CDbCriteria;
		$criteria->compare('lb_customer_id',$customer_id);
		
		
		
		
		return $this->findAll($criteria);
	}
}
