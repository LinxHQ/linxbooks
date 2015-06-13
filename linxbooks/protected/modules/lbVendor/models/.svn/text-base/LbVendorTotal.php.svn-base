<?php

/**
 * This is the model class for table "lb_vendor_total".
 *
 * The followings are the available columns in table 'lb_vendor_total':
 * @property integer $lb_record_primary_key
 * @property integer $lb_vendor_id
 * @property string $lb_vendor_type
 * @property string $lb_vendor_subtotal
 * @property string $lb_vendor_total_last_discount
 * @property string $lb_vendor_last_tax
 * @property string $lb_vendor_last_paid
 * @property string $lb_vendor_last_outstanding
 */
class LbVendorTotal extends CLBActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        const LB_VENDOR_ITEM_TYPE_TOTAL = "VENDOR_TOTAL";
        const LB_VENDOR_INVOICE_TOTAL = "INVOICE_VD_TOTAL";
	public function tableName()
	{
		return 'lb_vendor_total';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lb_vendor_id,lb_vendor_invoice_id, lb_vendor_type, lb_vendor_subtotal, lb_vendor_total_last_discount, lb_vendor_last_tax, lb_vendor_last_paid, lb_vendor_last_outstanding', 'required'),
			array('lb_vendor_id','lb_vendor_invoice_id', 'numerical', 'integerOnly'=>true),
			array('lb_vendor_type', 'length', 'max'=>100),
			array('lb_vendor_subtotal, lb_vendor_total_last_discount, lb_vendor_last_tax, lb_vendor_last_paid, lb_vendor_last_outstanding', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lb_record_primary_key,lb_vendor_invoice_id, lb_vendor_id, lb_vendor_type, lb_vendor_subtotal, lb_vendor_total_last_discount, lb_vendor_last_tax, lb_vendor_last_paid, lb_vendor_last_outstanding', 'safe', 'on'=>'search'),
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
			'lb_vendor_id' => 'Lb Vendor',
			'lb_vendor_type' => 'Lb Vendor Type',
			'lb_vendor_subtotal' => 'Lb Vendor Subtotal',
			'lb_vendor_total_last_discount' => 'Lb Vendor Total Last Discount',
			'lb_vendor_last_tax' => 'Lb Vendor Last Tax',
			'lb_vendor_last_paid' => 'Lb Vendor Last Paid',
			'lb_vendor_last_outstanding' => 'Lb Vendor Last Outstanding',
			'lb_vendor_invoice_id' => 'Lb Vendor Invoice',
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
		$criteria->compare('lb_vendor_id',$this->lb_vendor_id);
		$criteria->compare('lb_vendor_type',$this->lb_vendor_type,true);
		$criteria->compare('lb_vendor_subtotal',$this->lb_vendor_subtotal,true);
		$criteria->compare('lb_vendor_total_last_discount',$this->lb_vendor_total_last_discount,true);
		$criteria->compare('lb_vendor_last_tax',$this->lb_vendor_last_tax,true);
		$criteria->compare('lb_vendor_last_paid',$this->lb_vendor_last_paid,true);
		$criteria->compare('lb_vendor_last_outstanding',$this->lb_vendor_last_outstanding,true);
		$criteria->compare('lb_vendor_invoice_id',$this->lb_vendor_invoice_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbVendorTotal the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
      
    
      public function  getVendorTotal($id,$type)
       {
        if($type == LbVendorTotal::LB_VENDOR_INVOICE_TOTAL)
            return LbVendorTotal::model()->find('lb_vendor_invoice_id = :vendor_id AND lb_vendor_type = :vendor_type',
                array(':vendor_id'=>$id,':vendor_type'=>$type));
        if($type == LbVendorTotal::LB_VENDOR_ITEM_TYPE_TOTAL)
             return LbVendorTotal::model()->find('lb_vendor_id = :vendor_id AND lb_vendor_type = :vendor_type',
                array(':vendor_id'=>$id,':vendor_type'=>$type));
       }
        
        
        public function addTotalVendor($record_id,$type)
        {
         
            $vendorItem = new LbVendorTotal();
            if($type == self::LB_VENDOR_ITEM_TYPE_TOTAL)
            {
                
                $vendorItem->lb_vendor_id = $record_id;
                $vendorItem->lb_vendor_invoice_id = 0;
            }
            if($type == self::LB_VENDOR_INVOICE_TOTAL)
            {
                $vendorItem->lb_vendor_invoice_id = $record_id;
                $vendorItem->lb_vendor_id = 0;
            }
            $vendorItem->lb_vendor_type = $type;
            $vendorItem->lb_vendor_subtotal = 0;
            $vendorItem->lb_vendor_total_last_discount = 0;
            $vendorItem->lb_vendor_last_tax = 0;
            $vendorItem->lb_vendor_last_paid = 0;
            $vendorItem->lb_vendor_last_outstanding = 0;
          
            if($vendorItem->insert())
                return $vendorItem->lb_record_primary_key;
            else
                return false;
           
        }
        
        public function calculateInvoiceSubTotal($id,$type,$return_type)
        {
            // get invoice items
            $total = new LbVendorTotal();
            $invoice_line_items = LbVendorItem::model()->getVendorItems($id, $type,
				LbVendorItem::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);
           
            // calculate sub total
            $subtotal = 0;
            foreach($invoice_line_items as $item)
            {
                $subtotal += $item->lb_vendor_item_amount;
                
            }
          
            $id= $this->getIdVendorTotalByItem($id, $return_type);
//        
            $total = LbVendorTotal::model()->findByPk($id);
            $total->lb_vendor_subtotal = $subtotal;
            
            $total->update();
            

//          
         
        }
        
       
        public function getIdVendorTotalByItem($record_id,$type) {
            
            if($type == LbVendorTotal::LB_VENDOR_ITEM_TYPE_TOTAL)
                $total = LbVendorTotal::model()->find ("lb_vendor_id = ".$record_id);
            if($type == LbVendorTotal::LB_VENDOR_INVOICE_TOTAL)
                $total = LbVendorTotal::model()->find ("lb_vendor_invoice_id = ".$record_id);
            $id = $total['lb_record_primary_key'];
            
            return $id;
        }
        
        public function totalAfterDiscount($id,$type,$return_type)
        {
           $discount =  LbVendorDiscount::model()->calculateDiscount($id,$type);
          
           $pk = $this->getIdVendorTotalByItem($id,$return_type);
           $total = LbVendorTotal::model()->findByPk($pk);
           
           $subtotal = $total->lb_vendor_subtotal;
           
           //discount
           $discount_end = $subtotal-$discount;
           
           //update last discount
           $total->lb_vendor_total_last_discount= $discount_end;
           
           //total tax
           $total_tax = $discount_end;
           
           //update tax 
           if($type == LbVendorDiscount::LB_VENDOR_INVOICE_ITEM_TYPE_DISCOUNT)
                 $taxAll = LbVendorTax::model()->findAll("lb_vendor_invoice_id =  ".$id );
           else
                $taxAll = LbVendorTax::model()->findAll("lb_vendor_id =  ".$id );
           foreach ($taxAll as $data)
           {
               $tax = new LbVendorTax();
               $tax_value = ($total_tax*$data['lb_vendor_tax_value'])/100;
               $tax->updateTax($data['lb_record_primary_key'],$tax_value);
           }
           //update last tax
           if($type == LbVendorDiscount::LB_VENDOR_INVOICE_ITEM_TYPE_DISCOUNT)
                $last_tax = $discount_end+LbVendorTax::model()->calculateTax($id, LbVendorTax::LB_VENDOR_INVOICE_ITEM_TYPE_TAX);
            else {
                 $last_tax = $discount_end+LbVendorTax::model()->calculateTax($id, LbVendorTax::LB_VENDOR_ITEM_TYPE_TAX);

            }
           $total->lb_vendor_last_tax = $last_tax;
           $total->lb_vendor_last_outstanding = $last_tax - $total->lb_vendor_last_paid;
           $total->update();
          
        }
        
        public function getSubtotalById($type,$id)
        {
            if($type == LbVendorTotal::LB_VENDOR_ITEM_TYPE_TOTAL)
                return $this->find ('lb_vendor_id = '.$id);
            else
                return $this->find ('lb_vendor_invoice_id = '.$id);
            
        }
        
       
        
        public function getTotalVendorByCustomer($customer_id){
        $sql = 'SELECT SUM(lb_vendor_last_outstanding) AS sum
                FROM lb_vendor_total t
                INNER JOIN lb_vendor_invoice i ON i.lb_record_primary_key = t.lb_vendor_invoice_id
                WHERE i.lb_vd_invoice_supplier_id = '.intval($customer_id).' AND i.lb_vd_invoice_no <> "Draft"';
       //$sum = LbInvoiceTotal::model()->findBySql($sql);
       $sum = Yii::app()->db->createCommand($sql)->queryScalar();
       
       return $sum;
        }
       
	
    
    function calculateInvoiceTotalOutstanding(){
        $this->lb_vendor_last_outstanding = $this->lb_vendor_last_tax - $this->lb_vendor_last_paid;
        $this->save();
        return $this->lb_vendor_last_outstanding;
    }
        
    function updateTotal($lb_vendor_invoice_id=false,$discount,$tax)
    {
            $primary_key = LbVendorTotal::model()->find("lb_vendor_invoice_id = ".$lb_vendor_invoice_id);
            $total = LbVendorTotal::model()->findByPk($primary_key['lb_record_primary_key']);
           
           $subtotal = $total['lb_vendor_subtotal'];
          
           $total->lb_vendor_last_tax = $subtotal - $discount+$tax;
           
           $total->update();
        
    }
    
    //total oustanding
    public function totalOustanding($type=false,$id)
    {
        if($type == LbVendorTotal::LB_VENDOR_ITEM_TYPE_TOTAL)
            $totalModel= $this->find('lb_vendor_id = '.$id);
        else
            $totalModel = $this->find('lb_vendor_invoice_id = '.$id);
        return  $totalModel->lb_vendor_last_outstanding ;
    }
    
   
}
