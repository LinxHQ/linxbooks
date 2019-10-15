<?php

/**
 * This is the model class for table "lb_catalog_products".
 *
 * The followings are the available columns in table 'lb_catalog_products':
 * @property integer $lb_record_primary_key
 * @property string $lb_product_name
 * @property string $lb_product_sku
 * @property integer $lb_product_status
 * @property string $lb_product_description
 * @property string $lb_product_price
 * @property string $lb_product_special_price
 * @property string $lb_product_special_price_from_date
 * @property string $lb_product_special_price_to_date
 * @property string $lb_product_tax
 * @property integer $lb_product_qty
 * @property integer $lb_product_qty_out_of_stock
 * @property integer $lb_product_qty_min_order
 * @property integer $lb_product_qty_max_order
 * @property integer $lb_product_qty_notify
 * @property integer $lb_product_stock_availability
 * @property string $lb_product_created_date
 * @property string $lb_product_updated_date
 * @property integer $lb_product_create_by
 * @property string $lb_product_available_color
 * @property string $lb_product_dimension
 * @property string $lb_product_weight
 * @property string $lb_product_sort_description
 */
class LbCatalogProducts extends CLBActiveRecord
{
    var $module_name = 'lbCatalog';
    public $search_ids = false;
    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_catalog_products';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lb_product_name, lb_product_sku, lb_product_status, lb_product_price, lb_product_qty, lb_product_created_date, lb_product_updated_date, lb_product_create_by', 'required'),
			array('lb_product_status, lb_product_qty, lb_product_qty_out_of_stock, lb_product_qty_min_order, lb_product_qty_max_order, lb_product_qty_notify, lb_product_stock_availability, lb_product_create_by', 'numerical', 'integerOnly'=>true),
			array('lb_product_name', 'length', 'max'=>100),
			array('lb_product_sku', 'length', 'max'=>30),
                        array('lb_product_available_color, lb_product_dimension', 'length', 'max'=>50),
			array('lb_product_description,lb_product_sort_description', 'length', 'max'=>255),
			array('lb_product_price, lb_product_special_price', 'length', 'max'=>14),
                        array('lb_product_tax', 'length', 'max'=>5),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lb_record_primary_key, lb_product_name, lb_product_sku, lb_product_status, lb_product_description, lb_product_price, lb_product_special_price, lb_product_special_price_from_date, lb_product_special_price_to_date, lb_product_tax, lb_product_qty, lb_product_qty_out_of_stock, lb_product_qty_min_order, lb_product_qty_max_order, lb_product_qty_notify, lb_product_stock_availability, lb_product_created_date, lb_product_updated_date, lb_product_create_by', 'safe', 'on'=>'search'),
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
			'lb_product_name' => Yii::t('lang','Name'),
			'lb_product_sku' => Yii::t('lang','SKU'),
			'lb_product_status' => Yii::t('lang','Status'),
			'lb_product_description' => Yii::t('lang','Description'),
			'lb_product_price' => Yii::t('lang','Price'),
			'lb_product_special_price' => Yii::t('lang','Special Price'),
			'lb_product_special_price_from_date' => Yii::t('lang','Special Price From Date'),
			'lb_product_special_price_to_date' => Yii::t('lang','Special Price To Date'),
			'lb_product_tax' => Yii::t('lang','Tax'),
			'lb_product_qty' => Yii::t('lang','Quantity'),
			'lb_product_qty_out_of_stock' => Yii::t('lang','Qty for status to be out of stock'),
			'lb_product_qty_min_order' => Yii::t('lang','Min. Qty allowed in order'),
			'lb_product_qty_max_order' => Yii::t('lang','Max. Qty allowed in order'),
			'lb_product_qty_notify' => Yii::t('lang','Notify for Qty below'),
			'lb_product_stock_availability' => Yii::t('lang','Stock availability'),
			'lb_product_created_date' => Yii::t('lang','Created Date'),
			'lb_product_updated_date' => Yii::t('lang','Updated Date'),
			'lb_product_create_by' => Yii::t('lang','Create By'),
                        'lb_product_available_color' => Yii::t('lang','Available colors'),
                        'lb_product_dimension' => Yii::t('lang','Dimension'),
                        'lb_product_weight' => Yii::t('lang','Weight'),
                        'lb_product_sort_description'=>Yii::t('lang','Sort Description')
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
	public function search($user_id=false)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('lb_record_primary_key',$this->lb_record_primary_key);
		$criteria->compare('lb_product_name',$this->lb_product_name,true);
		$criteria->compare('lb_product_sku',$this->lb_product_sku,true);
		$criteria->compare('lb_product_status',$this->lb_product_status);
		$criteria->compare('lb_product_description',$this->lb_product_description,true);
		$criteria->compare('lb_product_price',$this->lb_product_price,true);
		$criteria->compare('lb_product_special_price',$this->lb_product_special_price,true);
		$criteria->compare('lb_product_special_price_from_date',$this->lb_product_special_price_from_date,true);
		$criteria->compare('lb_product_special_price_to_date',$this->lb_product_special_price_to_date,true);
		$criteria->compare('lb_product_tax',$this->lb_product_tax,true);
		$criteria->compare('lb_product_qty',$this->lb_product_qty);
		$criteria->compare('lb_product_qty_out_of_stock',$this->lb_product_qty_out_of_stock);
		$criteria->compare('lb_product_qty_min_order',$this->lb_product_qty_min_order);
		$criteria->compare('lb_product_qty_max_order',$this->lb_product_qty_max_order);
		$criteria->compare('lb_product_qty_notify',$this->lb_product_qty_notify);
		$criteria->compare('lb_product_stock_availability',$this->lb_product_stock_availability);
		$criteria->compare('lb_product_created_date',$this->lb_product_created_date,true);
		$criteria->compare('lb_product_updated_date',$this->lb_product_updated_date,true);
		$criteria->compare('lb_product_create_by',$this->lb_product_create_by);
                if($this->search_ids)
                    $criteria->addInCondition('t.lb_record_primary_key', $this->search_ids);

		$dataProvider = $this->getFullRecordsDataProvider($criteria,null,20,$user_id);
                
                return $dataProvider;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbCatalogProducts the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getCategory(){
            $category = LbCatalogCategoryProduct::model()->findAll('lb_product_id='.intval($this->lb_record_primary_key));
            $result = array();
            foreach ($category as $item) {
                $result[] = $item->lb_category_id;
            }
            return $result;
        }
        
        public function getDate(){
            
        }
        
        public function delete() {
            $result = parent::delete();
            if($result){
                LbCatalogCategoryProduct::model ()->deleteAll ('lb_product_id='. intval($this->lb_record_primary_key));
                LbDocument::model()->deleteAll('lb_document_parent_type= "'.$this->module_name.'" AND lb_document_parent_id='. intval($this->lb_record_primary_key));
            }
        }
}
