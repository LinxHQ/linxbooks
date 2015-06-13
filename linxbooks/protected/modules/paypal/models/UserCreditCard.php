<?php

/**
 * This is the model class for table "user_credit_card".
 *
 * The followings are the available columns in table 'user_credit_card':
 * @property integer $user_credit_card_id
 * @property integer $user_id
 * @property string $credit_card_id
 */
class UserCreditCard extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_user_credit_card';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, credit_card_id', 'required'),
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('credit_card_id', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_credit_card_id, user_id, credit_card_id', 'safe', 'on'=>'search'),
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
			'user_credit_card_id' => 'ID',
			'user_id' => 'User',
			'credit_card_id' => 'Credit Card',
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

		$criteria->compare('user_credit_card_id',$this->user_credit_card_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('credit_card_id',$this->credit_card_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserCreditCard the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
         * Get array of credit card models, of a user
         * 
         * @param $user_id
         * @return array 
         */
        public function getCreditCard($user_id) 
        {
                $this->user_id = $user_id;
                $dp = $this->search();
                $dp->setPagination(false);
                return $dp->getData();
        }
}
