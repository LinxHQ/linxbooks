<?php

/**
 * This is the model class for table "lb_quotation_discount".
 *
 * The followings are the available columns in table 'lb_quotation_discount':
 * @property integer $lb_record_primary_key
 * @property integer $lb_quotation_id
 * @property string $lb_quotation_discount_description
 * @property string $lb_quotation_discount_value
 * @property string $lb_quotation_discount_total
 */
class LbQuotationDiscount extends CLBActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_quotation_discount';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lb_quotation_id', 'required'),
			array('lb_quotation_id', 'numerical', 'integerOnly'=>true),
			array('lb_quotation_discount_description', 'length', 'max'=>255),
			array('lb_quotation_discount_value, lb_quotation_discount_total', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lb_record_primary_key, lb_quotation_id, lb_quotation_discount_description, lb_quotation_discount_value, lb_quotation_discount_total', 'safe', 'on'=>'search'),
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
			'lb_quotation_discount_description' => 'Lb Quotation Discount Description',
			'lb_quotation_discount_value' => 'Lb Quotation Discount Value',
			'lb_quotation_discount_total' => 'Lb Quotation Discount Total',
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
		$criteria->compare('lb_quotation_discount_description',$this->lb_quotation_discount_description,true);
		$criteria->compare('lb_quotation_discount_value',$this->lb_quotation_discount_value,true);
		$criteria->compare('lb_quotation_discount_total',$this->lb_quotation_discount_total,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbQuotationDiscount the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        function getQuotationDiscounts($quotaiton_id){
            $criteria = new CDbCriteria;
            $criteria->compare('lb_quotation_id', $quotaiton_id);
            
            return new CActiveDataProvider($this,array(
                    'criteria'=>$criteria,
            ));
        }
        function addBlankDiscount($quotation_id){
            $this->lb_quotation_id = $quotation_id;
            $this->lb_quotation_discount_description="Discount";
            $this->lb_quotation_discount_value = 0;
            $this->lb_quotation_discount_total = 0;
            
            return $this->save();
        }
}
