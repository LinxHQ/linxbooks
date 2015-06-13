<?php

/**
 * This is the model class for table "lb_pv_expenses".
 *
 * The followings are the available columns in table 'lb_pv_expenses':
 * @property integer $lb_record_primary_key
 * @property integer $lb_payment_voucher_id
 * @property integer $lb_expenses_id
 */
class LbPvExpenses extends CLBActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_pv_expenses';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lb_payment_voucher_id, lb_expenses_id', 'required'),
			array('lb_payment_voucher_id, lb_expenses_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lb_record_primary_key, lb_payment_voucher_id, lb_expenses_id', 'safe', 'on'=>'search'),
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
			'lb_payment_voucher_id' => 'Lb Payment Voucher',
			'lb_expenses_id' => 'Lb Expenses',
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
	public function search($id)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('lb_record_primary_key',$this->lb_record_primary_key);
		$criteria->compare('lb_payment_voucher_id',$this->lb_payment_voucher_id);
		$criteria->compare('lb_expenses_id',$this->lb_expenses_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbPvExpenses the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function listPV($id)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
                $criteria->condition = "lb_payment_voucher_id = ".$id;
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
       
        public function getExpensesPV($expenses_id,$id)
        {
            $model = $this->find('lb_expenses_id = '.$expenses_id.' AND lb_payment_voucher_id = '.$id);
            if(count($model) > 0)
                return true;
            return false;
        }
          public function getExpensesPVById($expenses_id)
        {
            $model = $this->find('lb_expenses_id = '.$expenses_id);
            if(count($model) > 0)
                return true;
            return false;
        }
}
