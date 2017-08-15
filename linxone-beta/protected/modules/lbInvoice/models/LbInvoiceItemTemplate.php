<?php
/**
 * Created by Lion and Lamb Soft Pte Ltd.
 * User: josephpnc
 * Date: 11/11/13
 * Time: 5:02 PM
 */

/**
 * This is the model class for table "lb_invoice_item_templates".
 *
 * The followings are the available columns in table 'lb_invoice_item_templates':
 * @property integer $lb_record_primary_key
 * @property string $lb_item_title
 * @property string $lb_item_description
 * @property string $lb_item_unit_price
 */
class LbInvoiceItemTemplate extends CLBActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'lb_invoice_item_templates';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('lb_item_description', 'required'),
            array('lb_item_unit_price', 'length', 'max'=>10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('lb_record_primary_key, lb_item_title, lb_item_description, lb_item_unit_price', 'safe', 'on'=>'search'),
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
            'lb_item_description' => 'Description',
            'lb_item_unit_price' => 'Unit Price',
            'lb_item_title' => 'Title'
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
        $criteria->compare('lb_item_description',$this->lb_item_description,true);
        $criteria->compare('lb_item_unit_price',$this->lb_item_unit_price,true);
        $criteria->compare('lb_item_title',$this->lb_item_title,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return LbInvoiceItemTemplate the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Override save function to check for item template with same description
     *
     * @param bool $runValidation
     * @param null $attributes
     * @return bool
     */
    public function save($runValidation = true, $attributes = null)
    {
        if ($this->itemExists())
            return false;

        return parent::save($runValidation, $attributes);
    }

    /**
     * Get all invoice item templates of current subscription
     *
     * @param string $sort
     * @param const $return_type
     * @return array|CActiveDataProvider
     */
    public function getInvoiceItemTemplates($sort = '', $return_type = self::LB_QUERY_RETURN_TYPE_ACTIVE_DATA_PROVIDER)
    {
        $criteria=new CDbCriteria;

        $criteria->compare('lb_item_description',$this->lb_item_description,true);
        $criteria->compare('lb_item_title',$this->lb_item_title,true);

        $criteria->order = ( $sort ? $sort : 'lb_item_title ASC, lb_item_description ASC');
        $dataProvider = $this->getFullRecordsDataProvider($criteria);

        return $this->getResultsBasedForReturnType($dataProvider, $return_type);
    }

    /**
     * check if item exists
     * logic: exact match of title and description
     *
     * @return bool
     */
    protected function itemExists()
    {
        $items = LbInvoiceItemTemplate::model()->findAll('lb_item_title = :title AND lb_item_description = :description',
            array(':title'=>$this->lb_item_title, ':description'=>$this->lb_item_description)
        );

        if (count($items))
            return true;

        return false;
    }
}
