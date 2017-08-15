<?php

/**
 * This is the model class for table "lb_bank_account".
 *
 * The followings are the available columns in table 'lb_bank_account':
 * @property integer $lb_record_primary_key
 * @property integer $lb_account_id
 * @property string $lb_bank_account
 */
class LbBankAccount extends CLBActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_bank_account';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lb_account_id, lb_bank_account', 'required'),
			array('lb_account_id', 'numerical', 'integerOnly'=>true),
			array('lb_bank_account', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lb_record_primary_key, lb_account_id, lb_bank_account', 'safe', 'on'=>'search'),
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
			'lb_account_id' => 'Lb Account',
			'lb_bank_account' => 'Lb Bank Account',
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
		$criteria->compare('lb_account_id',$this->lb_account_id);
		$criteria->compare('lb_bank_account',$this->lb_bank_account,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbBankAccount the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getBankAccount($account_id)
        {
                $this->lb_account_id = $account_id;
                $dp = $this->search();
                $dp->setPagination(false);

                return $dp->getData();
        }
}
