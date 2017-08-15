<?php

/**
 * This is the model class for table "lb_next_ids".
 *
 * The followings are the available columns in table 'lb_next_ids':
 * @property integer $lb_record_primary_key
 * @property integer $lb_next_invoice_number
 * @property integer $lb_next_quotation_number
 * @property integer $lb_next_expenses_number
 * @property integer $lb_next_po_number
 * @property integer $lb_next_supplier_invoice_number
 * @property integer $lb_next_supplier_payment_number
 */
class LbNextId extends CLBActiveRecord
{
	var $module_name = 'lbInvoice';
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_next_ids';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lb_next_invoice_number, lb_next_quotation_number, lb_next_payment_number','required'),
			array('lb_next_invoice_number, lb_next_quotation_number, lb_next_payment_number ,lb_next_contract_number, lb_next_expenses_number, lb_next_po_number, lb_next_supplier_invoice_number, lb_next_supplier_payment_number', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lb_record_primary_key, lb_next_invoice_number, lb_next_quotation_number, lb_next_payment_number, lb_next_contract_number, lb_next_expenses_number', 'safe', 'on'=>'search'),
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
			'lb_next_invoice_number' => 'Next Invoice Number',
			'lb_next_quotation_number' => 'Next Quotation Number',
                        'lb_next_payment_number' => 'Next Payment Number',
                        'lb_next_contract_number'=>'Next Contract Number',
                        'lb_next_expenses_number'=>'Next Expenses Number',
                        'lb_next_po_number'=>'Next PO Number',
                        'lb_next_supplier_invoice_number'=>'Next Supplier Invoice',
                        'lb_next_supplier_payment_number'=>'Next Supplier Payment Number'
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
		$criteria->compare('lb_next_invoice_number',$this->lb_next_invoice_number);
		$criteria->compare('lb_next_quotation_number',$this->lb_next_quotation_number);
                $criteria->compare('lb_next_payment_number',$this->lb_next_payment_number);
                $criteria->compare('lb_next_contract_number',$this->lb_next_contract_number);
                $criteria->compare('lb_next_expenses_number',$this->lb_next_expenses_number);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbNextId the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getNextIdSubscription()
        {
            $lastNextID = $this->getFullRecords();
            if(count($lastNextID)<=0)
            {
                $nextInvoiceNo = new LbNextId();
                $nextInvoiceNo->lb_next_invoice_number = 1;
                $nextInvoiceNo->lb_next_quotation_number = 1;
                $nextInvoiceNo->lb_next_payment_number = 1;
                $nextInvoiceNo->lb_next_contract_number=1;
                $nextInvoiceNo->lb_next_expenses_number=1;
                $nextInvoiceNo->lb_next_po_number=1;
                $nextInvoiceNo->lb_next_supplier_invoice_number=1;
                $nextInvoiceNo->lb_next_supplier_payment_number=1;
                $nextInvoiceNo->lb_next_pv_number=1;
		$nextInvoiceNo->save();
                $lastNextID = $this->getFullRecords();
            }
            
            $NextID = $lastNextID[0]->lb_record_primary_key;
            $dataProvider = LbNextId::model()->findByPk($NextID);
            return $dataProvider;
        }
}
