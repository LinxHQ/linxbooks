<?php

/**
 * This is the model class for table "lb_vendor_tax".
 *
 * The followings are the available columns in table 'lb_vendor_tax':
 * @property integer $lb_record_primary_key
 * @property integer $lb_vendor_id
 * @property integer $lb_vendor_tax_id
 * @property string $lb_vendor_tax_value
 * @property string $lb_vendor_tax_total
 * @property string $lb_vendor_type
 */
class LbVendorTax extends CLBActiveRecord
{
    
        const LB_VENDOR_ITEM_TYPE_TAX = 'TAX';
        const LB_VENDOR_INVOICE_ITEM_TYPE_TAX = 'INVOICE_TAX';
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_vendor_tax';
	}
        
       
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lb_vendor_id,lb_vendor_invoice_id, lb_vendor_tax_id, lb_vendor_tax_value, lb_vendor_tax_total, lb_vendor_type', 'required'),
			array('lb_vendor_id, lb_vendor_invoice_id,lb_vendor_tax_id', 'numerical', 'integerOnly'=>true),
			array('lb_vendor_tax_value, lb_vendor_tax_total', 'length', 'max'=>10),
			array('lb_vendor_type', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lb_record_primary_key,lb_vendor_invoice_id, lb_vendor_id, lb_vendor_tax_id, lb_vendor_tax_value, lb_vendor_tax_total, lb_vendor_type', 'safe', 'on'=>'search'),
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
			'lb_vendor_tax_id' => 'Lb Vendor Tax',
			'lb_vendor_tax_value' => 'Lb Vendor Tax Value',
			'lb_vendor_tax_total' => 'Lb Vendor Tax Total',
			'lb_vendor_type' => 'Lb Vendor Type',
			'lb_tax_name' => 'Lb Tax Name',
			'lb_vendor_invoice_id' => 'Lb Invoice',
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
		$criteria->compare('lb_vendor_tax_id',$this->lb_vendor_tax_id);
		$criteria->compare('lb_vendor_tax_value',$this->lb_vendor_tax_value,true);
		$criteria->compare('lb_vendor_tax_total',$this->lb_vendor_tax_total,true);
		$criteria->compare('lb_vendor_type',$this->lb_vendor_type,true);
		$criteria->compare('lb_tax_name',$this->lb_tax_name,true);
		$criteria->compare('lb_vendor_invoice_id',$this->lb_vendor_invoice_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbVendorTax the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
         * Thêm tax mặt định khi tạo một vendor mới
         * @param type $record_id = {vendor_id|vendor_invoice_id}
         * @param type $type = {vendor|supplier invoice}
         */
        public function addLineTaxVendor($record_id,$type)
        {
            $default_tax = LbTax::model()->getDefaultTax();
            $model = new LbVendorTax();
            if($type == LbVendorTax::LB_VENDOR_ITEM_TYPE_TAX)
            {
                $model->lb_vendor_id = $record_id;
                $model->lb_vendor_invoice_id = 0;
                
            }
            if($type == LbVendorTax::LB_VENDOR_INVOICE_ITEM_TYPE_TAX)
            {
                $model->lb_vendor_invoice_id = $record_id;
                $model->lb_vendor_id = 0;
            }
            $model->lb_vendor_type = $type;
            $model->lb_vendor_tax_id = ($default_tax !== null ? $default_tax->lb_record_primary_key : '0');
            $model->lb_tax_name = ($default_tax !== null ? $default_tax->lb_tax_name : '0');
            $model->lb_vendor_tax_value=($default_tax !== null ? $default_tax->lb_tax_value : '0');
            $model->lb_vendor_tax_total=0;
            
            return $model->insert();
        }
        
        /**
         * Lấy danh sách các tax của verdon hoặc của supplier invoice
         * @param type $record_id
         * @param type $type
         * @return \CActiveDataProvider
         */
        public function getTaxByVendor($record_id,$type,$return_type = self::LB_QUERY_RETURN_TYPE_ACTIVE_DATA_PROVIDER)
        {
            $criteria = new CDbCriteria();
            if($type == self::LB_VENDOR_ITEM_TYPE_TAX)
                $criteria->compare('lb_vendor_id', $record_id);
            if($type == self::LB_VENDOR_INVOICE_ITEM_TYPE_TAX)
                $criteria->compare('lb_vendor_invoice_id', $record_id);
            $criteria->compare('lb_vendor_type', $type);
            $criteria->order = "";
            
            $dataProvider = new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
            ));
            
            return $this->getResultsBasedForReturnType($dataProvider, $return_type);
        }
        
        public function ajaxUpdateTaxes($lb_tax_name,$lb_tax_value,$key,$tax_id,$id,$type = false)
        {
            $tax = $this->findAllByPk($key);
            if($type)
            {
                $pk = LbVendorTotal::model()->getIdVendorTotalByItem($id,LbVendorTotal::LB_VENDOR_ITEM_TYPE_TOTAL);
                $tax[0]->lb_vendor_id = $id;
                $tax[0]->lb_vendor_type = LbVendorTax::LB_VENDOR_ITEM_TYPE_TAX;
                $subtotal = LbVendorTotal::model()->find("lb_vendor_id = ".$id);
            }else
            {
                $pk = LbVendorTotal::model()->getIdVendorTotalByItem($id,LbVendorTotal::LB_VENDOR_INVOICE_TOTAL);
                $tax[0]->lb_vendor_invoice_id = $id;
                $tax[0]->lb_vendor_type = LbVendorTax::LB_VENDOR_INVOICE_ITEM_TYPE_TAX;
                $subtotal = LbVendorTotal::model()->find("lb_vendor_invoice_id = ".$id);
            }
            $totalManage = LbVendorTotal::model()->findByPk($pk);
            
      
            $tax[0]->lb_vendor_tax_value= $lb_tax_value;
            $tax[0]->lb_tax_name = $lb_tax_name;
            $tax[0]->lb_vendor_tax_id = $tax_id;
            
            
            $total = $subtotal['lb_vendor_total_last_discount'];
            $taxtotal = floatval(($total*$lb_tax_value)/100);
            $tax[0]->lb_vendor_tax_total = $taxtotal;
            $tax[0]->save();
          
            //update last tax
            //update last tax
            if(isset($_GET['type']))
                $last_tax = LbVendorTotal::model()->getVendorTotal($id,LbVendorTotal::LB_VENDOR_ITEM_TYPE_TOTAL)->lb_vendor_total_last_discount+LbVendorTax::model()->calculateTax($id, LbVendorTax::LB_VENDOR_ITEM_TYPE_TAX);
            else
                $last_tax = LbVendorTotal::model()->getVendorTotal($id,LbVendorTotal::LB_VENDOR_INVOICE_TOTAL)->lb_vendor_total_last_discount+LbVendorTax::model()->calculateTax($id, LbVendorTax::LB_VENDOR_INVOICE_ITEM_TYPE_TAX);
           $totalManage->lb_vendor_last_tax = $last_tax;
           $totalManage->lb_vendor_last_outstanding = $last_tax - $totalManage->lb_vendor_last_paid;
           $totalManage->update();
       
            
        }
        
        public function calculateTax($id,$return_type)
        {
            
            $invoice_line_items = $this->getTaxByVendor($id, $return_type,
				LbVendorItem::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);
           
            // calculate sub total
            $subtotal = 0;
            foreach($invoice_line_items as $item)
            {
                $subtotal += $item->lb_vendor_tax_total;
                
            }
          
           return $subtotal;
         
        }
        
        public function updateTax($tax_id,$total)
        {
            $tax = $this->findByPk($tax_id);
            $tax->lb_vendor_tax_total = $total;
            $tax->save();
        }
        
      
}
