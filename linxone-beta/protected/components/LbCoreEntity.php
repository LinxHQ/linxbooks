<?php

/**
 * This is the model class for table "lb_core_entities".
 *
 * The followings are the available columns in table 'lb_core_entities':
 * @property integer $lb_record_primary_key
 * @property string $lb_entity_type
 * @property integer $lb_entity_primary_key
 * @property integer $lb_created_by
 * @property string $lb_created_date
 * @property integer $lb_last_updated_by
 * @property string $lb_last_update
 * @property integer $lb_subscription_id
 * @property integer $lb_locked_from_deletion
 */
class LbCoreEntity extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_core_entities';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lb_entity_type, lb_entity_primary_key, lb_created_by, lb_created_date, lb_last_updated_by, lb_last_update, lb_subscription_id, lb_locked_from_deletion', 'required'),
			array('lb_entity_primary_key, lb_created_by, lb_last_updated_by, lb_subscription_id, lb_locked_from_deletion', 'numerical', 'integerOnly'=>true),
			array('lb_entity_type', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lb_record_primary_key, lb_entity_type, lb_entity_primary_key, lb_created_by, lb_created_date, lb_last_updated_by, lb_last_update, lb_subscription_id, lb_locked_from_deletion', 'safe', 'on'=>'search'),
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
			'lb_record_primary_key' => 'Lb Core Entity',
			'lb_entity_type' => 'Lb Entity Type',
			'lb_entity_primary_key' => 'Lb Entity Primary Key',
			'lb_created_by' => 'Lb Created By',
			'lb_created_date' => 'Lb Created Date',
			'lb_last_updated_by' => 'Lb Last Updated By',
			'lb_last_update' => 'Lb Last Update',
			'lb_subscription_id' => 'Lb Subscription',
			'lb_locked_from_deletion' => 'Lb Locked From Deletion',
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
		$criteria->compare('lb_entity_type',$this->lb_entity_type,true);
		$criteria->compare('lb_entity_primary_key',$this->lb_entity_primary_key);
		$criteria->compare('lb_created_by',$this->lb_created_by);
		$criteria->compare('lb_created_date',$this->lb_created_date,true);
		$criteria->compare('lb_last_updated_by',$this->lb_last_updated_by);
		$criteria->compare('lb_last_update',$this->lb_last_update,true);
		$criteria->compare('lb_subscription_id',$this->lb_subscription_id);
		$criteria->compare('lb_locked_from_deletion',$this->lb_locked_from_deletion);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbCoreEntity the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getCoreEntity($entity_type, $entity_primary_key)
	{
		$coreEntity = LbCoreEntity::model()->find('lb_entity_type = :lb_entity_type AND lb_entity_primary_key = :lb_entity_primary_key',
				array(':lb_entity_type'=>$entity_type, ':lb_entity_primary_key'=>$entity_primary_key));
		 
		return $coreEntity;
	}
}
