<?php

/**
 * This is the model class for table "lb_expenses_invoice".
 *
 * The followings are the available columns in table 'lb_expenses_invoice':
 * @property integer $lb_record_primary_key
 * @property integer $lb_expenses_id
 * @property integer $lb_invoice_id
 */
class LbExpensesInvoice extends CLBActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_expenses_invoice';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lb_expenses_id, lb_invoice_id', 'required'),
			array('lb_expenses_id, lb_invoice_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lb_record_primary_key, lb_expenses_id, lb_invoice_id', 'safe', 'on'=>'search'),
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
			'lb_expenses_id' => Yii::t('lang','Expenses'),
			'lb_invoice_id' => Yii::t('lang','Invoice'),
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
		$criteria->compare('lb_expenses_id',$this->lb_expenses_id);
		$criteria->compare('lb_invoice_id',$this->lb_invoice_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbExpensesInvoice the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getExpensesInvoice($expenses_id, $invoice_id=false)
        {
            $this->lb_expenses_id = $expenses_id;
            if ($invoice_id)
                $this->lb_invoice_id = $invoice_id;
            $dp = $this->search();
            $dp->setPagination(false);
            return $dp->getData();
        }
}
