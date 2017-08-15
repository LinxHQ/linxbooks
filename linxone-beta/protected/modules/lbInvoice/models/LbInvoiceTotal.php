<?php

/**
 * This is the model class for table "lb_invoice_totals".
 *
 * The followings are the available columns in table 'lb_invoice_totals':
 * @property integer $lb_record_primary_key
 * @property integer $lb_invoice_id
 * @property integer $lb_invoice_revision_id
 * @property string $lb_invoice_subtotal
 * @property string $lb_invoice_total_after_discounts
 * @property string $lb_invoice_total_after_taxes
 * @property string $lb_invoice_total_paid
 * @property string $lb_invoice_total_outstanding
 */
class LbInvoiceTotal extends CLBActiveRecord
{
	var $module_name = 'lbInvoice';
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_invoice_totals';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lb_invoice_id, lb_invoice_revision_id', 'required'),
			array('lb_invoice_id, lb_invoice_revision_id', 'numerical', 'integerOnly'=>true),
			array('lb_invoice_subtotal, lb_invoice_total_after_discounts, lb_invoice_total_after_taxes, lb_invoice_total_paid, lb_invoice_total_outstanding', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lb_record_primary_key, lb_invoice_id, lb_invoice_revision_id, lb_invoice_subtotal, lb_invoice_total_after_discounts, lb_invoice_total_after_taxes, lb_invoice_total_paid, lb_invoice_total_outstanding', 'safe', 'on'=>'search'),
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
			'lb_invoice_id' => 'Lb Invoice',
			'lb_invoice_revision_id' => 'Lb Invoice Revision',
			'lb_invoice_subtotal' => 'Lb Invoice Subtotal',
			'lb_invoice_total_after_discounts' => 'Lb Invoice Total After Discounts',
			'lb_invoice_total_after_taxes' => 'Lb Invoice Total After Taxes',
			'lb_invoice_total_paid' => 'Lb Invoice Total Paid',
			'lb_invoice_total_outstanding' => 'Lb Invoice Total Outstanding',
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
		$criteria->compare('lb_invoice_revision_id',$this->lb_invoice_revision_id);
		$criteria->compare('lb_invoice_subtotal',$this->lb_invoice_subtotal,true);
		$criteria->compare('lb_invoice_total_after_discounts',$this->lb_invoice_total_after_discounts,true);
		$criteria->compare('lb_invoice_total_after_taxes',$this->lb_invoice_total_after_taxes,true);
		$criteria->compare('lb_invoice_total_paid',$this->lb_invoice_total_paid,true);
		$criteria->compare('lb_invoice_total_outstanding',$this->lb_invoice_total_outstanding,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbInvoiceTotal the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * Create a total record for this invoice
     * Basically everything is set zero
     *
     * @param $invoice_id
     */
    public function createBlankTotal($invoice_id)
    {
        $this->lb_invoice_id = $invoice_id;
        $this->lb_invoice_revision_id = 0; // latest version
        $this->lb_invoice_subtotal = 0;
        $this->lb_invoice_total_after_discounts = 0;
        $this->lb_invoice_total_after_taxes = 0;
        $this->lb_invoice_total_outstanding = 0;
        $this->lb_invoice_total_paid = 0;
        return $this->save();
    }

    /**
     * get Total row for this invoice
     *
     * @param $invoice_id
     * @return $invoiceTotal LbInvoiceTotal model
     */
    public function  getInvoiceTotal($invoice_id)
    {
        return LbInvoiceTotal::model()->find('lb_invoice_id = :invoice_id AND lb_invoice_revision_id = 0',
            array(':invoice_id'=>$invoice_id));
    }

    /**
     * Calculate invoice subtotal (total of all line items),
     * save, and return value
     *
     * @return double invoice sub total
     */
    public function calculateInvoiceSubTotal()
    {
        // get invoice items
        $invoice_line_items = LbInvoiceItem::model()->getInvoiceItems(
            $this->lb_invoice_id, self::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);

        // calculate sub total
        $subtotal = 0;
        foreach($invoice_line_items as $item)
        {
            $subtotal += $item->lb_invoice_item_total;
        }
        $this->lb_invoice_subtotal = $subtotal;
        $this->save();

        return $this->lb_invoice_subtotal;
    }

    /**
     * Calculate invoice total after discounts
     * save, and return total after discounts
     *
     * @return string total after discount
     */
    public function calculateInvoiceTotalAfterDiscounts()
    {
        $invoice_discounts = LbInvoiceItem::model()->getInvoiceDiscounts(
            $this->lb_invoice_id, self::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);

        // calculate discount total, and invoice total after discount
        $discount_total = 0;
        foreach($invoice_discounts as $disc)
        {
            $discount_total += $disc->lb_invoice_item_total;
        }
        $this->lb_invoice_total_after_discounts = $this->lb_invoice_subtotal - $discount_total;
        $this->save();

        return $this->lb_invoice_total_after_discounts;
    }

    /**
     * Calculate invoice total after taxes (subtotal - discount - taxes)
     * save, and return value
     *
     * @return int total after taxes
     */
    public function calculateInvoiceTotalAfterTaxes()
    {
        // get all taxes
        $invoice_taxes = LbInvoiceItem::model()->getInvoiceTaxes(
            $this->lb_invoice_id, self::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);

        // calculate tax total, and invoice total after tax
        $tax_total = 0;
        foreach($invoice_taxes as $tax)
        {
            $tax_total += $tax->lb_invoice_item_total;
        }
        $this->lb_invoice_total_after_taxes = $this->lb_invoice_total_after_discounts + $tax_total;
        $this->save();

        return $this->lb_invoice_total_after_taxes;
    }

    /**
     * calculate all totals
     * each will save to db by itself
     * So after calling this method, the database should be updated properly
     */
    public function calculateAllTotals()
    {
        $this->calculateInvoiceSubTotal();
        $this->calculateInvoiceTotalAfterDiscounts();
        $this->calculateInvoiceTotalAfterTaxes();
    }
       /**
     * 
     * 
     *
     * @return int total invoice by customer
     */
    public function getTotalInvoiceByCustomer($customer_id){
        $sql = 'SELECT SUM(lb_invoice_total_outstanding) AS sum
                FROM lb_invoice_totals t
                INNER JOIN lb_invoices i ON i.lb_record_primary_key = t.lb_invoice_id
                WHERE i.lb_invoice_customer_id = '.intval($customer_id).' AND i.lb_invoice_no <> "Draft"';
       //$sum = LbInvoiceTotal::model()->findBySql($sql);
       $sum = Yii::app()->db->createCommand($sql)->queryScalar();
       
       return $sum;
    }
    
           /**
     * 
     * 
     *
     * @return int total invoice paid
     */
    public function calculateInvoicetotalPaid($invoice_id){
        $paymentItem = LbPaymentItem::model()->findAll('lb_invoice_id = '.  intval($invoice_id));
        $total_paid = 0;
        foreach ($paymentItem as $data) {
            $total_paid += $data->lb_payment_item_amount;
        }
        $this->lb_invoice_total_paid = $total_paid;
        $this->save();
        return $this->lb_invoice_total_paid;
    }
            /**
     * 
     * 
     *
     * @return int total invoice standings
     */
    function calculateInvoiceTotalOutstanding(){
        $this->lb_invoice_total_outstanding = $this->lb_invoice_total_after_taxes - $this->lb_invoice_total_paid;
        $this->save();
        return $this->lb_invoice_total_outstanding;
    }
                /**
     * 
     * 
     *@type_total {Total Paid, Total, Total Outstanding}
     * @return int total customer
     */
    function getTotalCustomer($customer_id,$type_total){
        $criteria = new CDbCriteria();
        $criteria->join='INNER JOIN lb_invoices i ON i.lb_record_primary_key = t.lb_invoice_id';
        $criteria->condition='i.lb_invoice_customer_id='.intval($customer_id);
        $model = $this->model()->findAll($criteria);
        
        $total_paid=0;$total=0;$total_due=0;
        if($type_total=="Total Paid")
        {
            foreach ($model as $data) {
                $total_paid+=$data->lb_invoice_total_paid;
            }
            return $total_paid;
        }
        
        if($type_total=="Total")
        {
            foreach ($model as $data) {
                $total+=$data->lb_invoice_total_after_taxes;
            }
            return $total;
        }
        
        if($type_total=="Total Due")
        {
            foreach ($model as $data) {
                $total_due+=$data->lb_invoice_total_outstanding;
            }
            return $total_due;
        }
    }
    /**
     * Tinh total amount invoice cua contract
     * @param int $contract_id
     * @return float totalAmountInvoiceContract
     */
    public function getTotalAmountInvoiceByContract($contract_id)
    {
        $contractInvoice_arr = LbContractInvoice::model()->getContractInvoice($contract_id);
        $totalAmountInvoice = 0;
        foreach ($contractInvoice_arr->data as $dataContractInvoice) {
            $totalModel = LbInvoiceTotal::model()->find('lb_invoice_id='.intval($dataContractInvoice['lb_invoice_id']));
            if(count($totalModel)>0)
                $totalAmountInvoice+=$totalModel->lb_invoice_total_after_taxes;
        }
        return $totalAmountInvoice;
    }
    function adddotstring($str,$thousand,$decimal) {
 
        $len = strlen($str);
        $result ="";
        $a = substr($str, $len-2, 2);
      
        $kq = "";
        if($len <= 6)
            $result = substr ($str, 0,$len);
        else
        {
            
            $kq = substr($str, 0, $len - 3);
            $strkq = strlen($kq); 

            while($strkq > 3)
            {
                if($strkq == strlen($kq))
                {
                    $result = substr($kq,$strkq-3,3);
                    $strkq = $strkq - 3;

                }
                else
                {
                    $result = substr($kq,$strkq-3,3).$thousand.$result;
                    $strkq = $strkq - 3;
                }
            }
            if($strkq > 0 )
            {
                $result = substr($kq,0,$strkq).$thousand.$result;
            }
            $result = $result.$decimal.$a;
        }
        return $result;
    }
    
     public function getInvoiceById($invoice_id=false)
    {
        $criteria = new CDbCriteria();
    
        if($invoice_id)
            $criteria->compare ('lb_invoice_id', $invoice_id);

        return LbInvoiceTotal::model()->find($criteria);
    }
}
