<?php

/**
 * This is the model class for table "lb_quotation_tax".
 *
 * The followings are the available columns in table 'lb_quotation_tax':
 * @property integer $lb_record_primary_key
 * @property integer $lb_quotation_id
 * @property integer $lb_quotation_tax_id
 * @property string $lb_quotation_tax_value
 * @property string $lb_quotation_tax_total
 */
class LbQuotationTax extends CLBActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_quotation_tax';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lb_quotation_id, lb_quotation_tax_id, lb_quotation_tax_value, lb_quotation_tax_total', 'required'),
			array('lb_quotation_id, lb_quotation_tax_id', 'numerical', 'integerOnly'=>true),
			array('lb_quotation_tax_value, lb_quotation_tax_total', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lb_record_primary_key, lb_quotation_id, lb_quotation_tax_id, lb_quotation_tax_value, lb_quotation_tax_total', 'safe', 'on'=>'search'),
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
			'lb_quotation_id' => 'Lb Quotation',
			'lb_quotation_tax_id' => 'Lb Quotation Tax',
			'lb_quotation_tax_value' => 'Lb Quotation Tax Value',
			'lb_quotation_tax_total' => 'Lb Quotation Tax Total',
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
		$criteria->compare('lb_quotation_id',$this->lb_quotation_id);
		$criteria->compare('lb_quotation_tax_id',$this->lb_quotation_tax_id);
		$criteria->compare('lb_quotation_tax_value',$this->lb_quotation_tax_value,true);
		$criteria->compare('lb_quotation_tax_total',$this->lb_quotation_tax_total,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbQuotationTax the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        function addBlankTax($quotation_id)
        {
            $default_tax = LbTax::model()->getDefaultTax();
            
            $this->lb_quotation_id = $quotation_id;
            $this->lb_quotation_tax_id = ($default_tax !== null ? $default_tax->lb_record_primary_key : '0');
            $this->lb_quotation_tax_value = ($default_tax !== null ? $default_tax->lb_tax_value : '0');
            $this->lb_quotation_tax_total = 0;
            
            return $this->save();
        }
        
        /**
         * add a tax to this invoice
         *
         * @param $invoice_id invoice id
         * @param $lbTax LbTax model
         * @return bool
         */
        public function addTaxToQuotation($quotation_id, $lbTax)
        {
            $this->lb_quotation_id = $quotation_id;
            $this->lb_quotation_tax_id = $lbTax->lb_record_primary_key;
            $this->lb_quotation_tax_value = $lbTax->lb_tax_value;
            $this->lb_quotation_tax_total = 0;
            return $this->save();
        }
        
        function getTaxQuotation($quotation_id)
        {
            $criteria = new CDbCriteria;
            
            $criteria->compare('lb_quotation_id', $quotation_id);
            
            return new CActiveDataProvider($this,array('criteria'=>$criteria));
        }
}
