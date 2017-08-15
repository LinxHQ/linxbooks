<?php

/**
 * This is the model class for table "leave_package_item".
 *
 * The followings are the available columns in table 'leave_package_item':
 * @property integer $item_id
 * @property integer $item_leave_package_id
 * @property integer $item_leave_type_id
 * @property double $item_total_days
 */
class LeavePackageItem extends CLBActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'leave_package_item';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('item_leave_type_id, item_total_days', 'required'),
			array('item_leave_package_id, item_leave_type_id', 'numerical', 'integerOnly'=>true),
			array('item_total_days', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('item_id, item_leave_package_id, item_leave_type_id, item_total_days', 'safe', 'on'=>'search'),
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
			'item_id' => 'Item',
			'item_leave_package_id' => 'Item Leave Package',
			'item_leave_type_id' => 'Item Leave Type',
			'item_total_days' => 'Item Total Days',
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

		$criteria->compare('item_id',$this->item_id);
		$criteria->compare('item_leave_package_id',$this->item_leave_package_id);
		$criteria->compare('item_leave_type_id',$this->item_leave_type_id);
		$criteria->compare('item_total_days',$this->item_total_days);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LeavePackageItem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
