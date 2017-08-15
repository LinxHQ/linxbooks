<?php

/**
 * This is the model class for table "lb_vendor_discount".
 *
 * The followings are the available columns in table 'lb_vendor_discount':
 * @property integer $lb_record_primary_key
 * @property integer $lb_vendor_type
 * @property integer $lb_vendor_id
 * @property string $lb_vendor_description
 * @property string $lb_vendor_value
 */
class LbVendorDiscount extends CLBActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
    
        const LB_VENDOR_ITEM_TYPE_DISCOUNT = "DISCOUNT";
        const LB_VENDOR_INVOICE_ITEM_TYPE_DISCOUNT = "INVOICE_DISCOUNT";
       
	public function tableName()
	{
		return 'lb_vendor_discount';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lb_vendor_type,lb_vendor_invoice_id, lb_vendor_id, lb_vendor_description, lb_vendor_value', 'required'),
			array('lb_vendor_type,lb_vendor_invoice_id, lb_vendor_id', 'numerical', 'integerOnly'=>true),
			array('lb_vendor_description', 'length', 'max'=>255),
			array('lb_vendor_value', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lb_record_primary_key,lb_vendor_invoice_id, lb_vendor_type, lb_vendor_id, lb_vendor_description, lb_vendor_value', 'safe', 'on'=>'search'),
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
			'lb_vendor_description' => 'Lb Vendor Description',
			'lb_vendor_value' => 'Lb Vendor Value',
			'lb_vendor_invoice_id' => 'Lb Vendor INVOICE',
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
		$criteria->compare('lb_vendor_type',$this->lb_vendor_type);
		$criteria->compare('lb_vendor_id',$this->lb_vendor_id);
		$criteria->compare('lb_vendor_description',$this->lb_vendor_description,true);
		$criteria->compare('lb_vendor_value',$this->lb_vendor_value,true);
		$criteria->compare('lb_vendor_invoice_id',$this->lb_vendor_invoice_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbVendorDiscount the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
         * Thêm discount mặt định của một vendor hoặc của supplier invoice khi tạo mới
         * @param type $record_id
         * @param type $type
         */
       public function addLineDiscountVendor($record_id,$type)
        {
           $model = new LbVendorDiscount();
           if($type == LbVendorDiscount::LB_VENDOR_ITEM_TYPE_DISCOUNT)
           {
            $model->lb_vendor_id = $record_id;
            $model->lb_vendor_invoice_id = 0;
           }
           if($type == LbVendorDiscount::LB_VENDOR_INVOICE_ITEM_TYPE_DISCOUNT)
           {
            $model->lb_vendor_invoice_id = $record_id;
            $model->lb_vendor_id = 0;
           }
           
            $model->lb_vendor_type = $type;
            $model->lb_vendor_description = "";
            
            $model->lb_vendor_value=0;
            
            $model->insert();
        }
        
        /**
         * Lấy danh sách các tax của verdon hoặc của supplier invoice
         * @param type $record_id
         * @param type $type
         * @return \CActiveDataProvider
         */
        public function getTaxByVendor($record_id,$type)
        {
            $criteria = new CDbCriteria();
            $criteria->compare('lb_vendor_id', $record_id);
            $criteria->compare('lb_vendor_type', $type);
            
            $dataProvider = new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
            ));
            
            return $dataProvider;
        }
        
         public function getVendorDiscounts($id, $type,$return_type = self::LB_QUERY_RETURN_TYPE_ACTIVE_DATA_PROVIDER)
         {
            $criteria = new CDbCriteria();
            if($type == self::LB_VENDOR_ITEM_TYPE_DISCOUNT)
            {
                $criteria->compare('lb_vendor_id',$id,true);
                $criteria->compare('lb_vendor_type',self::LB_VENDOR_ITEM_TYPE_DISCOUNT);
            }
            if($type == self::LB_VENDOR_INVOICE_ITEM_TYPE_DISCOUNT)
            {
                $criteria->compare('lb_vendor_invoice_id',$id,true);
                $criteria->compare('lb_vendor_type',self::LB_VENDOR_INVOICE_ITEM_TYPE_DISCOUNT);
            }
           $criteria->order = "";
            
            $dataProvider = new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
            ));

            return $this->getResultsBasedForReturnType($dataProvider, $return_type);
     
         }
     
     public function addBlankDiscount($vendor_id,$type)
     {
         if($type == LbVendorDiscount::LB_VENDOR_INVOICE_ITEM_TYPE_DISCOUNT)
         {
            $this->lb_vendor_id = 0;
            $this->lb_vendor_invoice_id = $vendor_id;
         }
         if($type == LbVendorDiscount::LB_VENDOR_ITEM_TYPE_DISCOUNT)
         {
             $this->lb_vendor_id = $vendor_id;
            $this->lb_vendor_invoice_id = 0;
         }
        $this->lb_vendor_description = ' ';
        $this->	lb_vendor_value = 0;
        $this->lb_vendor_type = $type;
        
        return $this->insert();
        
    }
    
    public function calculateDiscount($id,$return_type)
    {
            
            $invoice_line_items = $this->getVendorDiscounts($id, $return_type,
				LbVendorItem::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);
           
            // calculate sub total
            $subtotal = 0;
            foreach($invoice_line_items as $item)
            {
                $subtotal += $item->lb_vendor_value;
                
            }
          
           return $subtotal;
         
        }
        
       
}
