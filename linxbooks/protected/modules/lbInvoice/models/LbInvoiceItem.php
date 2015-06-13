<?php

/**
 * This is the model class for table "lb_invoice_items".
 *
 * The followings are the available columns in table 'lb_invoice_items':
 * @property integer $lb_record_primary_key
 * @property integer $lb_invoice_id
 * @property string $lb_invoice_item_type
 * @property string $lb_invoice_item_description
 * @property string $lb_invoice_item_quantity
 * @property string $lb_invoice_item_value
 * @property string $lb_invoice_item_total
 */
class LbInvoiceItem extends CLBActiveRecord
{
	const LB_INVOICE_ITEM_TYPE_LINE = 'LINE';
	const LB_INVOICE_ITEM_TYPE_DISCOUNT = 'DISCOUNT';
	const LB_INVOICE_ITEM_TYPE_TAX = 'TAX';
	
	var $module_name = 'lbInvoice';
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_invoice_items';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lb_invoice_id, lb_invoice_item_type', 'required'),
			array('lb_invoice_id', 'numerical', 'integerOnly'=>true),
			array('lb_invoice_item_type', 'length', 'max'=>60),
			array('lb_invoice_item_description', 'length', 'max'=>255),
			array('lb_invoice_item_quantity, lb_invoice_item_value, lb_invoice_item_total', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lb_record_primary_key, lb_invoice_id, lb_invoice_item_type, lb_invoice_item_description, lb_invoice_item_quantity, lb_invoice_item_value, lb_invoice_item_total', 'safe', 'on'=>'search'),
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
			'lb_invoice_id' => 'Invoice No',
			'lb_invoice_item_type' => 'Lb Invoice Item Type',
			'lb_invoice_item_description' => Yii::t('lang','Item'),
			'lb_invoice_item_quantity' => Yii::t('lang','Quantity'),
			'lb_invoice_item_value' => Yii::t('lang','Unit Price'),
			'lb_invoice_item_total' => Yii::t('lang','Total'),
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
		$criteria->compare('lb_invoice_id',$this->lb_invoice_id);
		$criteria->compare('lb_invoice_item_type',$this->lb_invoice_item_type,true);
		$criteria->compare('lb_invoice_item_description',$this->lb_invoice_item_description,true);
		$criteria->compare('lb_invoice_item_quantity',$this->lb_invoice_item_quantity,true);
		$criteria->compare('lb_invoice_item_value',$this->lb_invoice_item_value,true);
		$criteria->compare('lb_invoice_item_total',$this->lb_invoice_item_total,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbInvoiceItem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function delete()
    {
        $invoice_id = $this->lb_invoice_id;
        $item_type = $this->lb_invoice_item_type;
        $result = parent::delete();

        // post delete
        // have to call it here because we need to make use of the record id
        if ($item_type == LbInvoiceItem::LB_INVOICE_ITEM_TYPE_LINE) {
            $this->onLineItemDeleted($invoice_id);
        } else if ($item_type == LbInvoiceItem::LB_INVOICE_ITEM_TYPE_DISCOUNT) {
            $this->onDiscountDeleted($invoice_id);
        } else if ($item_type == LbInvoiceItem::LB_INVOICE_ITEM_TYPE_TAX) {
            $this->onTaxDeleted($invoice_id);
        }

        return $result;
    }
	
	public function save($runValidation=true,$attributes=false)
	{
        if ($this->lb_invoice_item_type == $this::LB_INVOICE_ITEM_TYPE_LINE) {
            $this->calculateItemTotal();

        } else if ($this->lb_invoice_item_type == $this::LB_INVOICE_ITEM_TYPE_DISCOUNT) {
            // same as line item
            $this->calculateItemTotal();
        } else if ($this->lb_invoice_item_type == $this::LB_INVOICE_ITEM_TYPE_TAX) {
            // tax total is calculated differently
            $this->calculateTaxTotal();
        }

		$result = parent::save($runValidation,$attributes);

        return $result;
	}

    public function afterSave()
    {
        // re-calculate totals
        $invoiceTotal = LbInvoiceTotal::model()->getInvoiceTotal($this->lb_invoice_id);

        if ($this->lb_invoice_item_type == $this::LB_INVOICE_ITEM_TYPE_LINE) {
            $this->onLineItemsChanged();

        } else if ($this->lb_invoice_item_type == $this::LB_INVOICE_ITEM_TYPE_DISCOUNT) {
            $this->onDiscountsChanged();

        } else if ($this->lb_invoice_item_type == $this::LB_INVOICE_ITEM_TYPE_TAX) {
            $this->onTaxesChanged();

        }
    }

    /**
     * actions to be taken after lines items are updated
     */
    public function onLineItemsChanged()
    {
        // re-calculate totals
        $invoiceTotal = LbInvoiceTotal::model()->getInvoiceTotal($this->lb_invoice_id);

        if ($invoiceTotal)
        {
            // calculate subtotal
            $invoiceTotal->calculateInvoiceSubTotal();

            // calculate total after discounts
            $invoiceTotal->calculateInvoiceTotalAfterDiscounts();

            // re-calculate total of individual taxes, this will already be saved to db once done
            $this->calculateAllTaxesTotals();

            // re-calculate invoice total after taxes
            $invoiceTotal->calculateInvoiceTotalAfterTaxes();
            $invoiceTotal->calculateInvoiceTotalOutstanding();
        }
    }

    /**
     * actions to be taken after discounts are updated
     */
    public function onDiscountsChanged()
    {
        // re-calculate totals
        $invoiceTotal = LbInvoiceTotal::model()->getInvoiceTotal($this->lb_invoice_id);

        if ($invoiceTotal)
        {
            // re-calculate total after discounts
            $invoiceTotal->calculateInvoiceTotalAfterDiscounts();

            // re-calculate total of individual taxes, this will already be saved to db once done
            $this->calculateAllTaxesTotals();

            // re-calculate invoice total after taxes
            $invoiceTotal->calculateInvoiceTotalAfterTaxes();
            $invoiceTotal->calculateInvoiceTotalOutstanding();
        }
    }

    /**
     * actions to be taken after taxes are updated
     */
    public function onTaxesChanged()
    {
        // re-calculate totals
        $invoiceTotal = LbInvoiceTotal::model()->getInvoiceTotal($this->lb_invoice_id);

        if ($invoiceTotal)
        {
            // re-calculate invoice total after taxes
            $invoiceTotal->calculateInvoiceTotalAfterTaxes();
            $invoiceTotal->calculateInvoiceTotalOutstanding();
        }
    }

    public function onLineItemDeleted($invoice_id)
    {
        // re-calculate totals
        $invoiceTotal = LbInvoiceTotal::model()->getInvoiceTotal($invoice_id);

        if ($invoiceTotal)
        {
            // calculate subtotal
            $invoiceTotal->calculateInvoiceSubTotal();

            // calculate total after discounts
            $invoiceTotal->calculateInvoiceTotalAfterDiscounts();

            // re-calculate total of individual taxes, this will already be saved to db once done
            $this->calculateAllTaxesTotals();

            // re-calculate invoice total after taxes
            $invoiceTotal->calculateInvoiceTotalAfterTaxes();
            $invoiceTotal->calculateInvoiceTotalOutstanding();
        }
    }

    /**
     * actions to be taken after discounts are deleted
     */
    public function onDiscountDeleted($invoice_id)
    {
        // re-calculate totals
        $invoiceTotal = LbInvoiceTotal::model()->getInvoiceTotal($invoice_id);

        if ($invoiceTotal)
        {
            // re-calculate total after discounts
            $invoiceTotal->calculateInvoiceTotalAfterDiscounts();

            // re-calculate total of individual taxes, this will already be saved to db once done
            $this->calculateAllTaxesTotals();

            // re-calculate invoice total after taxes
            $invoiceTotal->calculateInvoiceTotalAfterTaxes();
            $invoiceTotal->calculateInvoiceTotalOutstanding();
        }
    }

    /**
     * actions to be taken after taxes are deleted
     */
    public function onTaxDeleted($invoice_id)
    {
        // re-calculate totals
        $invoiceTotal = LbInvoiceTotal::model()->getInvoiceTotal($invoice_id);

        if ($invoiceTotal)
        {
            // re-calculate invoice total after taxes
            $invoiceTotal->calculateInvoiceTotalAfterTaxes();
            $invoiceTotal->calculateInvoiceTotalOutstanding();
        }
    }
	
	/**
	 * Get invoice items for an invoice
	 * 
	 * @param int $invoice_id
	 * @param string $return_type
	 * @return CActiveDataProvider|Ambigous based on return type
	 */
	public function getInvoiceItems($invoice_id, $return_type = self::LB_QUERY_RETURN_TYPE_ACTIVE_DATA_PROVIDER)
	{
		$criteria = new CDbCriteria();
		$criteria->compare('lb_invoice_id',$invoice_id,true);
		$criteria->compare('lb_invoice_item_type',self::LB_INVOICE_ITEM_TYPE_LINE);
		$criteria->order = "";
		
		$dataProvider = new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
		
		return $this->getResultsBasedForReturnType($dataProvider, $return_type);
	}

    /**
     * Get Invoice discounts - items that are of discount type
     *
     * @param $invoice_id
     * @param $return_type
     * @return array|CActiveDataProvider|string
     */
    public function getInvoiceDiscounts($invoice_id, $return_type = self::LB_QUERY_RETURN_TYPE_ACTIVE_DATA_PROVIDER)
    {
        $criteria = new CDbCriteria();
        $criteria->compare('lb_invoice_id',$invoice_id,true);
        $criteria->compare('lb_invoice_item_type',self::LB_INVOICE_ITEM_TYPE_DISCOUNT);
        $criteria->order = "";

        $dataProvider = new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));

        return $this->getResultsBasedForReturnType($dataProvider, $return_type);
    }

    /**
     * Get invoice taxes - items that of type Taxes
     *
     * @param $invoice_id
     * @param $return_type
     * @return array|CActiveDataProvider|string
     */
    public function getInvoiceTaxes($invoice_id, $return_type = self::LB_QUERY_RETURN_TYPE_ACTIVE_DATA_PROVIDER)
    {
        $criteria = new CDbCriteria();
        $criteria->compare('lb_invoice_id',$invoice_id,true);
        $criteria->compare('lb_invoice_item_type',self::LB_INVOICE_ITEM_TYPE_TAX);
        $criteria->order = "";

        $dataProvider = new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));

        return $this->getResultsBasedForReturnType($dataProvider, $return_type);
    }
	
	/**
	 * Add a blank invoice item
	 * Usually use when user adds a new row in the line items table on the GUI
	 * 
	 * @param unknown $invoice_id
	 */
	public function addBlankItem($invoice_id)
	{
		$this->lb_invoice_id = $invoice_id;
		$this->lb_invoice_item_quantity = 1;
		$this->lb_invoice_item_value = 0;
		$this->lb_invoice_item_total = 0;
		$this->lb_invoice_item_type = self::LB_INVOICE_ITEM_TYPE_LINE;
		
		return $this->save();
	}

    /**
     * Add a new discount item
     * Usually use when user adds a new discount in discount table on the GUI
     * After that user will enter the value. But we need a blank line (like a form) for them first.
     *
     * @param $invoice_id
     * @return bool
     */
    public function addBlankDiscount($invoice_id)
    {
        $this->lb_invoice_id = $invoice_id;
        $this->lb_invoice_item_description = 'Discount';
        $this->lb_invoice_item_quantity = 1;
        $this->lb_invoice_item_value = 0;
        $this->lb_invoice_item_total = 0;
        $this->lb_invoice_item_type = self::LB_INVOICE_ITEM_TYPE_DISCOUNT;

        return $this->save();
    }

    /**
     * Add a new tax item
     * Usually use when user adds a new discount in discount table on the GUI
     * After that user will enter the value. But we need a blank line (like a form) for them first.
     *
     * @param $invoice_id
     * @return bool
     */
    public function addBlankTax($invoice_id)
    {
        $default_tax = LbTax::model()->getDefaultTax();

        $this->lb_invoice_id = $invoice_id;
        //$this->lb_invoice_item_description = ($default_tax !== null ? $default_tax->lb_tax_name : 'Tax');
        $this->lb_invoice_item_description = ($default_tax !== null ? $default_tax->lb_record_primary_key : 'null');
        $this->lb_invoice_item_quantity = 1;
        $this->lb_invoice_item_value =  ($default_tax !== null ? $default_tax->lb_tax_value : '0');
        $this->lb_invoice_item_total = 0;
        $this->lb_invoice_item_type = self::LB_INVOICE_ITEM_TYPE_TAX;

        return $this->save();
    }

    /**
     * add a tax to this invoice
     *
     * @param $invoice_id invoice id
     * @param $lbTax LbTax model
     * @return bool
     */
    public function addTaxToInvoice($invoice_id, $lbTax)
    {
        $this->lb_invoice_id = $invoice_id;
        $this->lb_invoice_item_type = $this::LB_INVOICE_ITEM_TYPE_TAX;
        $this->lb_invoice_item_description = $lbTax->lb_record_primary_key;
        $this->lb_invoice_item_quantity = 1;
        $this->lb_invoice_item_value = $lbTax->lb_tax_value;
        return $this->save();
    }

	/**
	 * this function calculate item total
	 * and set current object's total to this value
	 * It also returns this value, BUT doesn't save anything to the database
	 *
     * @return int total of an invoice line item
	 */
	public function calculateItemTotal()
	{		
		$item_total = round(floatval($this->lb_invoice_item_quantity),2)
			*round(floatval($this->lb_invoice_item_value),2);
		$this->lb_invoice_item_total = $item_total;

        return $this->lb_invoice_item_total;
	}

    /**
     * calculate tax total,
     * return total, but doesn't save to the database
     *
     * @return int invoice tax total
     *
     */
    public function calculateTaxTotal()
    {
        // get invoice total after discount
        $invoiceTotal = LbInvoiceTotal::model()->getInvoiceTotal($this->lb_invoice_id);
        if ($invoiceTotal)
        {
            $invoice_total_after_discounts = $invoiceTotal->lb_invoice_total_after_discounts;

            // tax is based on this total after discounts;
            $item_total = round(floatval($this->lb_invoice_item_quantity),2)
                *round(floatval($this->lb_invoice_item_value)/100,2)
                *$invoice_total_after_discounts;

            $this->lb_invoice_item_total = $item_total;
        }

        return $this->lb_invoice_item_total;
    }

    /**
     * calculate all taxes totals, save to database
     * This is usually used when there's a change in invoice total after discounts
     *
     * @return null
     */
    public function calculateAllTaxesTotals()
    {
        $invoice_taxes = LbInvoiceItem::model()->getInvoiceTaxes($this->lb_invoice_id, self::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);
        foreach ($invoice_taxes as $tax)
        {
            $tax->calculateTaxTotal();
            $tax->save();
        }
    }
    
     public function getInvoiceTaxById($invoice_id=false,$type=false)
    {
        $criteria = new CDbCriteria();
        if($invoice_id)
            $criteria->compare ('lb_invoice_id', $invoice_id);
        if($type)
            $criteria->compare('lb_invoice_item_type', $type);
        return LbInvoiceItem::model()->find($criteria);
    }
}
