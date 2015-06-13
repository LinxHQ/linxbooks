<?php

/**
 * This is the model class for table "lb_quotation_total".
 *
 * The followings are the available columns in table 'lb_quotation_total':
 * @property integer $lb_record_primary_key
 * @property integer $lb_quotation_id
 * @property string $lb_quotation_subtotal
 * @property string $lb_quotation_total_after_discount
 * @property string $lb_quotation_total_after_tax
 * @property string $lb_quotation_total_after_total
 */
class LbQuotationTotal extends CLBActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_quotation_total';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lb_quotation_id','required'),
			array('lb_quotation_id', 'numerical', 'integerOnly'=>true),
			array('lb_quotation_subtotal, lb_quotation_total_after_discount, lb_quotation_total_after_tax, lb_quotation_total_after_total', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lb_record_primary_key, lb_quotation_id, lb_quotation_subtotal, lb_quotation_total_after_discount, lb_quotation_total_after_tax, lb_quotation_total_after_total', 'safe', 'on'=>'search'),
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
			'lb_quotation_subtotal' => 'Lb Quotation Subtotal',
			'lb_quotation_total_after_discount' => 'Lb Quotation Total After Discount',
			'lb_quotation_total_after_tax' => 'Lb Quotation Total After Tax',
			'lb_quotation_total_after_total' => 'Lb Quotation Total After Total',
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
		$criteria->compare('lb_quotation_subtotal',$this->lb_quotation_subtotal,true);
		$criteria->compare('lb_quotation_total_after_discount',$this->lb_quotation_total_after_discount,true);
		$criteria->compare('lb_quotation_total_after_tax',$this->lb_quotation_total_after_tax,true);
		$criteria->compare('lb_quotation_total_after_total',$this->lb_quotation_total_after_total,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbQuotationTotal the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        function createBlankTotal($quotation_id)
        {
            $this->lb_quotation_id = $quotation_id;
            $this->lb_quotation_subtotal = 0;
            $this->lb_quotation_total_after_discount=0;
            $this->lb_quotation_total_after_tax = 0;
            $this->lb_quotation_total_after_total = 0;
            
            return $this->save();
        }
        function calculateQuotationSubtotal($id)
        {
            // get quotatin items
            $quotation_line_items = LbQuotationItem::model()->getquotationItems($id, self::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);

            // calculate sub total
            $subtotal = 0;
            foreach($quotation_line_items as $item)
            {
                $subtotal += $item->lb_quotation_item_total;
            }
            
            $quotation_total = $this->model()->find('lb_quotation_id='.$id);
            $quotation_total->lb_quotation_subtotal = $subtotal;
            $quotation_total->save();
        }
        
        function calculateQuotationTotalDiscount($id)
        {
            $quotation_line_discount = LbQuotationDiscount::model()->getQuotationDiscounts($id);
            
            $totalDiscount = 0;
            foreach ($quotation_line_discount->data as $discount) {
                $totalDiscount += $discount->lb_quotation_discount_total;
            }
            
            $quotation_total = $this->model()->find('lb_quotation_id='.$id);
            $quotation_total->lb_quotation_total_after_discount = $totalDiscount;
            $quotation_total->save();
        }
        
        function calculateQuotationAfterTotal($id)
        {
            $arterTotal = 0;
            
            $quotation_total = $this->model()->find('lb_quotation_id='.$id);
            
            $subToal = $quotation_total->lb_quotation_subtotal;
            $totalDiscount = $quotation_total->lb_quotation_total_after_discount;
            $totalTax = $quotation_total->lb_quotation_total_after_tax;
            
            $arterTotal = ($subToal - $totalDiscount)+$totalTax;
            
            $quotation_total->lb_quotation_total_after_total = $arterTotal;
            $quotation_total->save();
        }
        
        function calculateQuotationAfterTotalTax($id)
        {
            $quotation_line_tax = LbQuotationTax::model()->getTaxQuotation($id);
            $afterTotalTax = 0;
            foreach ($quotation_line_tax->data as $tax)
            {
                $afterTotalTax+=$tax->lb_quotation_tax_total;
            }
            
            $quotation_total = $this->model()->find('lb_quotation_id='.$id);
            $quotation_total->lb_quotation_total_after_tax = $afterTotalTax;
            $quotation_total->save();
        }
        
        
        public function  getQuotationTotal($quotation_id)
        {
            return LbQuotationTotal::model()->find('lb_quotation_id='.$quotation_id);
        }

}
