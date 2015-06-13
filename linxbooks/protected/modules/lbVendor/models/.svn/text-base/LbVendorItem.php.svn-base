<?php

/**
 * This is the model class for table "lb_vendor_item".
 *
 * The followings are the available columns in table 'lb_vendor_item':
 * @property integer $lb_record_primary_key
 * @property string $lb_vendor_type
 * @property integer $lb_vendor_id
 * @property string $lb_vendor_item_description
 * @property string $lb_vendor_item_price
 * @property string $lb_vendor_item_quantity
 * @property string $lb_vendor_item_amount
 */
class LbVendorItem extends CLBActiveRecord
{
    
        const LB_VENDOR_ITEM_TYPE_LINE = 'LINE';
	
	
        const LB_VENDOR_INVOICE_ITEM_TYPE_LINE = 'LINE_INVOICE';

        /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_vendor_item';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lb_vendor_type, lb_vendor_invoice_id,lb_vendor_id, lb_vendor_item_description, lb_vendor_item_price, lb_vendor_item_quantity, lb_vendor_item_amount', 'required'),
			array('lb_record_primary_key, lb_vendor_id,lb_vendor_invoice_id', 'numerical', 'integerOnly'=>true),
			array('lb_vendor_type', 'length', 'max'=>100),
//			array('lb_vendor_item_price, lb_vendor_item_quantity, lb_vendor_item_amount', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lb_record_primary_key, lb_vendor_type,lb_vendor_invoice_id, lb_vendor_id, lb_vendor_item_description, lb_vendor_item_price, lb_vendor_item_quantity, lb_vendor_item_amount', 'safe', 'on'=>'search'),
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
			'lb_vendor_type' => 'Lb Vendor Type',
			'lb_vendor_id' => 'Lb Vendor',
			'lb_vendor_item_description' => 'Lb Vendor Item Description',
			'lb_vendor_item_price' => 'Lb Vendor Item Price',
			'lb_vendor_item_quantity' => 'Lb Vendor Item Quantity',
			'lb_vendor_item_amount' => 'Lb Vendor Item Amount',
			'lb_vendor_invoice_id' => 'Lb Vendor Invoice Id',
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
		$criteria->compare('lb_vendor_type',$this->lb_vendor_type,true);
		$criteria->compare('lb_vendor_id',$this->lb_vendor_id);
		$criteria->compare('lb_vendor_item_description',$this->lb_vendor_item_description,true);
		$criteria->compare('lb_vendor_item_price',$this->lb_vendor_item_price,true);
		$criteria->compare('lb_vendor_item_quantity',$this->lb_vendor_item_quantity,true);
		$criteria->compare('lb_vendor_item_amount',$this->lb_vendor_item_amount,true);
		$criteria->compare('lb_vendor_invoice_id',$this->lb_vendor_invoice_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbVendorItem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
         * 
         * @param type $record_id = {vendor_id|vendor_invoice_id}
         * @param type $type = {vendor|supplier invoice}
         */
        public function addLineItemVendor($record_id,$type)
        {
         
            $vendorItem = new LbVendorItem();
            if($type == LbVendorItem::LB_VENDOR_ITEM_TYPE_LINE)
            {
                $vendorItem->lb_vendor_id = $record_id;
                $vendorItem->lb_vendor_invoice_id = 0;
            }
            if($type == LbVendorItem::LB_VENDOR_INVOICE_ITEM_TYPE_LINE)
            {
                $vendorItem->lb_vendor_id = 0;
                $vendorItem->lb_vendor_invoice_id = $record_id;
            }
            $vendorItem->lb_vendor_type = $type;
            $vendorItem->lb_vendor_item_quantity = 1;
            $vendorItem->lb_vendor_item_price = 0;
            $vendorItem->lb_vendor_item_amount = 0;
            $vendorItem->lb_vendor_item_description = "";
            if($vendorItem->insert())
                return $vendorItem->lb_record_primary_key;
            
           
        }
        
        /**
         * 
         * @param type $record_id
         * @param type $type
         * @return \CActiveDataProvider
         */
        public function getItemByVendor($record_id,$type=  self::LB_VENDOR_ITEM_TYPE_LINE)
        {
            $criteria = new CDbCriteria();
            $criteria->compare('lb_vendor_id', $record_id);
            $criteria->compare('lb_vendor_type', $type);
            
            $dataProvider = new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
            ));
            
            return $dataProvider;
        }
       
        public function getItemByVendorInvoice($record_id,$type=  self::LB_VENDOR_INVOICE_ITEM_TYPE_LINE)
        {
            $criteria = new CDbCriteria();
            $criteria->compare('lb_vendor_invoice_id', $record_id);
            $criteria->compare('lb_vendor_type', $type);
            
            $dataProvider = new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
            ));
            
            return $dataProvider;
        }
        
      
       public function getVendorItems($record_id,$type, $return_type = self::LB_QUERY_RETURN_TYPE_ACTIVE_DATA_PROVIDER)
	{
		$criteria = new CDbCriteria();
                if($type == LbVendorItem::LB_VENDOR_INVOICE_ITEM_TYPE_LINE)
                    $criteria->compare('lb_vendor_invoice_id', $record_id);
                if($type == LbVendorItem::LB_VENDOR_ITEM_TYPE_LINE)
                    $criteria->compare('lb_vendor_id', $record_id);
                $criteria->compare('lb_vendor_type', $type);
		$criteria->order = "";
		
		$dataProvider = new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
		
		return $this->getResultsBasedForReturnType($dataProvider, $return_type);
	}
        
       
        
       
}
