<?php

/**
 * This is the model class for table "lb_customer_contacts".
 *
 * The followings are the available columns in table 'lb_customer_contacts':
 * @property integer $lb_record_primary_key
 * @property integer $lb_customer_id
 * @property string $lb_customer_contact_first_name
 * @property string $lb_customer_contact_last_name
 * @property string $lb_customer_contact_office_phone
 * @property string $lb_customer_contact_office_fax
 * @property string $lb_customer_contact_mobile
 * @property string $lb_customer_contact_email_1
 * @property string $lb_customer_contact_email_2
 * @property string $lb_customer_contact_note
 * @property integer $lb_customer_contact_is_active
 */
class LbCustomerContact extends CLBActiveRecord
{
	const LB_CUSTOMER_CONTACT_IS_ACTIVE = 1;
	const LB_CUSTOMER_CONTACT_IS_NOT_ACTIVE = 0;
        
        public static $dropdownActiveContact = array(
            self::LB_CUSTOMER_CONTACT_IS_ACTIVE=>'ACTIVE',
            self::LB_CUSTOMER_CONTACT_IS_NOT_ACTIVE=>'NOT ACTIVE'
       );
        
    var $record_title_column_name = 'lb_customer_contact_first_name';
    public $lb_customer_contract_name;

    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_customer_contacts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lb_customer_contact_first_name, lb_customer_contact_last_name, lb_customer_contact_is_active', 'required'),
			array('lb_customer_id, lb_customer_contact_is_active', 'numerical', 'integerOnly'=>true),
			array('lb_customer_contact_first_name, lb_customer_contact_last_name, lb_customer_contact_office_phone, lb_customer_contact_office_fax, lb_customer_contact_mobile', 'length', 'max'=>50),
			array('lb_customer_contact_email_1, lb_customer_contact_email_2', 'length', 'max'=>100),
                        array('lb_customer_contact_email_1, lb_customer_contact_email_2','email','message'=>'Email is not valid'),
                        array('lb_customer_contact_email_1, lb_customer_contact_email_2','unique','message'=>'Email already exists'),
			array('lb_customer_contact_note', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lb_record_primary_key, lb_customer_id, lb_customer_contact_first_name, lb_customer_contact_last_name, lb_customer_contact_office_phone, lb_customer_contact_office_fax, lb_customer_contact_mobile, lb_customer_contact_email_1, lb_customer_contact_email_2, lb_customer_contact_note, lb_customer_contact_is_active', 'safe', 'on'=>'search'),
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
			'lb_record_primary_key' => Yii::t('lang', 'Contact'),
			'lb_customer_id' => Yii::t('lang','Customer'),
			'lb_customer_contact_first_name' => Yii::t('lang','First Name'),
			'lb_customer_contact_last_name' => Yii::t('lang','Last Name'),
			'lb_customer_contact_office_phone' => Yii::t('lang','Office Phone'),
			'lb_customer_contact_office_fax' => Yii::t('lang','Office Fax'),
			'lb_customer_contact_mobile' => Yii::t('lang','Mobile'),
			'lb_customer_contact_email_1' => Yii::t('lang','Email'),
			'lb_customer_contact_email_2' => Yii::t('lang','Email').' 2',
			'lb_customer_contact_note' => Yii::t('lang','Note'),
			'lb_customer_contact_is_active' => Yii::t('lang','Is Active'),
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
		$criteria->compare('lb_customer_contact_first_name',$this->lb_customer_contact_first_name,true);
		$criteria->compare('lb_customer_contact_last_name',$this->lb_customer_contact_last_name,true);
		$criteria->compare('lb_customer_contact_office_phone',$this->lb_customer_contact_office_phone,true);
		$criteria->compare('lb_customer_contact_office_fax',$this->lb_customer_contact_office_fax,true);
		$criteria->compare('lb_customer_contact_mobile',$this->lb_customer_contact_mobile,true);
		$criteria->compare('lb_customer_contact_email_1',$this->lb_customer_contact_email_1,true);
		$criteria->compare('lb_customer_contact_email_2',$this->lb_customer_contact_email_2,true);
		$criteria->compare('lb_customer_contact_note',$this->lb_customer_contact_note,true);
		$criteria->compare('lb_customer_contact_is_active',$this->lb_customer_contact_is_active);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbCustomerContact the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * Get customer contacts
	 *
	 * @param int $customer_id
	 * @param string $return_type default is CActiveDataProvider
	 */
	public function getContacts($customer_id, $return_type = self::LB_QUERY_RETURN_TYPE_ACTIVE_DATA_PROVIDER)
	{
		// set search condition
		$criteria=new CDbCriteria;
		$criteria->compare('lb_customer_id',$customer_id);
		$criteria->order= 'lb_customer_contact_first_name ASC, lb_customer_contact_last_name ASC';
	
		$dataProvider = new CActiveDataProvider('LbCustomerContact', array(
				'criteria'=> $criteria,
		));
	
		return $this->getResultsBasedForReturnType($dataProvider, $return_type);
	}

    /**
     * OVER RIDE PARENT's METHOD
     *   so that we can display first name, followed by last name
     *
     * Get results as an array of data as dropdown source
     *
     * @param $dataProvider
     * @return array (primary key => title column's value,...)
     */
    public function getResultsAsDropDownArray($dataProvider)
    {
        $dataProvider->setPagination(false);
        $data = $dataProvider->getData();
        $dropdown_array = array();
        foreach ($data as $item)
        {
            $dropdown_array[$item->lb_record_primary_key] = $item->lb_customer_contact_first_name
                . " " . $item->lb_customer_contact_last_name;
        }
        return $dropdown_array;
    }
    
    public function getResultsAsFindAll()
    {
        $criteria=new CDbCriteria;
        $criteria->select="lb_record_primary_key, CONCAT(lb_customer_contact_first_name,' ',lb_customer_contact_last_name) AS lb_customer_contract_name";
        $criteria->order= 'lb_customer_contact_first_name ASC, lb_customer_contact_last_name ASC';

        return LbCustomerContact::model()->findAll($criteria);;
    }
}
