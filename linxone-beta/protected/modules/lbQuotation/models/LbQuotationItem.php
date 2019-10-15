<?php

/**
 * This is the model class for table "lb_quotation_item".
 *
 * The followings are the available columns in table 'lb_quotation_item':
 * @property integer $lb_record_primary_key
 * @property integer $lb_quotation_id
 * @property string $lb_quotation_item_description
 * @property string $lb_quotation_item_quantity
 * @property string $lb_quotation_item_price
 * @property string $lb_quotation_item_total
 */
class LbQuotationItem extends CLBActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_quotation_item';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lb_quotation_id, lb_quotation_item_quantity, lb_quotation_item_price, lb_quotation_item_total', 'required'),
			array('lb_quotation_id', 'numerical', 'integerOnly'=>true),
			array('lb_quotation_item_quantity, lb_quotation_item_price, lb_quotation_item_total', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lb_record_primary_key, lb_quotation_id, lb_quotation_item_description, lb_quotation_item_quantity, lb_quotation_item_price, lb_quotation_item_total', 'safe', 'on'=>'search'),
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
			'lb_record_primary_key' => 'Record Primary Key',
			'lb_quotation_id' => Yii::t('lang','Quotation'),
			'lb_quotation_item_description' => 'Quotation Item Description',
			'lb_quotation_item_quantity' => 'Quotation Item Quantity',
			'lb_quotation_item_price' => 'Quotation Item Price',
			'lb_quotation_item_total' => 'Quotation Item Total',
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
		$criteria->compare('lb_quotation_item_description',$this->lb_quotation_item_description,true);
		$criteria->compare('lb_quotation_item_quantity',$this->lb_quotation_item_quantity,true);
		$criteria->compare('lb_quotation_item_price',$this->lb_quotation_item_price,true);
		$criteria->compare('lb_quotation_item_total',$this->lb_quotation_item_total,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbQuotationItem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        function addBlankItem($quotation_id)
        {
            $this->lb_quotation_id = $quotation_id;
            $this->lb_quotation_item_price = 0;
            $this->lb_quotation_item_quantity = 1;
            $this->lb_quotation_item_total = 0;
            
            return $this->save();
        }
        function getquotationItems($quotation_id, $return_type = self::LB_QUERY_RETURN_TYPE_ACTIVE_DATA_PROVIDER)
        {
		$criteria = new CDbCriteria();
		$criteria->compare('lb_quotation_id',$quotation_id,true);
		$criteria->order = "";
		
		$dataProvider = new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=> false,
		));
		
		return $this->getResultsBasedForReturnType($dataProvider, $return_type);
        }
}
