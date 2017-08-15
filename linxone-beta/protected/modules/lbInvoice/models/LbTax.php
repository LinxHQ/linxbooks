<?php

/**
 * This is the model class for table "lb_taxes".
 *
 * The followings are the available columns in table 'lb_taxes':
 * @property integer $lb_record_primary_key
 * @property string $lb_tax_name
 * @property string $lb_tax_value
 * @property integer $lb_tax_is_default
 */
class LbTax extends CLBActiveRecord
{
    const LB_TAX_IS_DEFAULT = 1;
    const LB_TAX_IS_NOT_DEFAULT = 0;
    var $record_title_column_name = 'lb_tax_name';
    var $module_name = 'lbInvoice';

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_taxes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lb_tax_name, lb_tax_value, lb_tax_is_default', 'required'),
			array('lb_tax_is_default', 'numerical', 'integerOnly'=>true),
			array('lb_tax_name', 'length', 'max'=>60),
			array('lb_tax_value', 'length', 'max'=>10),
//                        array('lb_tax_name','unique','message'=>'Tax Name exist'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lb_record_primary_key, lb_tax_name, lb_tax_value, lb_tax_is_default', 'safe', 'on'=>'search'),
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
			'lb_tax_name' => 'Tax Name',
			'lb_tax_value' => 'Tax Value %',
			'lb_tax_is_default' => 'Add as a default tax',
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
		$criteria->compare('lb_tax_name',$this->lb_tax_name,true);
		$criteria->compare('lb_tax_value',$this->lb_tax_value,true);
		$criteria->compare('lb_tax_is_default',$this->lb_tax_is_default);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbTax the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * Get taxes that this subscriber has - usually to generate a dropdown
     * so that users can choose for a specific invoice
     *
     * @param $invoice_id
     * @param $return_type
     * @return array|CActiveDataProvider|string
     */
    public function getTaxes($sort = "", $return_type = self::LB_QUERY_RETURN_TYPE_ACTIVE_DATA_PROVIDER)
    {
        $criteria=new CDbCriteria;
        $criteria->order = $sort;
        $dataProvider = $this->getFullRecordsDataProvider($criteria);

        return $this->getResultsBasedForReturnType($dataProvider, $return_type);
    }

    /**
     * Get the default tax for current subscription
     *
     * @return null if no tax found.
     */
    public function getDefaultTax()
    {
        $taxes = $this->getTaxes("", self::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);

        // if there's only one tax
        // then use that as default
        if (count($taxes) == 1)
            return $taxes[0];

        // else look for default
        foreach($taxes as $tax_item)
        {
            if ($tax_item->lb_tax_is_default == $this::LB_TAX_IS_DEFAULT)
                return $tax_item;
        }

        // none found, return null
        return null;
    }
    
    public function IsNameTax($name_tax,$tax_id=false) {
        
        $criteria=new CDbCriteria;
        
        if($tax_id)
            $criteria->condition='t.lb_record_primary_key != '.  intval($tax_id);

        $taxes = $this->getFullRecordsDataProvider($criteria);
        
        foreach ($taxes->data as $tax_item) {
            if($name_tax==$tax_item->lb_tax_name)
                return false;
        }
        return true;
    }
    
    public function IsTaxExistInvoiceORQuotation($tax_id)
    {
        $tax_invoice = LbInvoiceItem::model()->find('lb_invoice_item_description='.$tax_id);
        $tax_quotation = LbQuotationTax::model()->find('lb_quotation_tax_id='.$tax_id);
        
        if(count($tax_quotation)>0 || count($tax_invoice)>0)
            return true;
        return false;
    }
}
