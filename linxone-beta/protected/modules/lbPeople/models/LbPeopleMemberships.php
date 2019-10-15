<?php

/**
 * This is the model class for table "lb_people_memberships".
 *
 * The followings are the available columns in table 'lb_people_memberships':
 * @property integer $lb_record_primary_key
 * @property integer $lb_people_id
 * @property integer $lb_membership_type
 * @property string $lb_membership_start_date
 * @property string $lb_membership_end_date
 * @property integer $lb_membership_confirm
 * @property string $lb_membership_remark
 */
class LbPeopleMemberships extends CLBActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_people_memberships';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lb_people_id, lb_membership_type, lb_membership_start_date, lb_membership_end_date, lb_membership_confirm', 'required'),
			array('lb_people_id, lb_membership_type, lb_membership_confirm', 'numerical', 'integerOnly'=>true),
			array('lb_membership_remark', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lb_record_primary_key, lb_people_id, lb_membership_type, lb_membership_start_date, lb_membership_end_date, lb_membership_confirm, lb_membership_remark', 'safe', 'on'=>'search'),
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
			'lb_people_id' => 'Lb People',
			'lb_membership_type' => 'Membership Type',
			'lb_membership_start_date' => 'Membership Start Date',
			'lb_membership_end_date' => 'Membership End Date',
			'lb_membership_confirm' => 'Membership Confirm',
			'lb_membership_remark' => 'Membership Remark',
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
		$criteria->compare('lb_people_id',$this->lb_people_id);
		$criteria->compare('lb_membership_type',$this->lb_membership_type);
		$criteria->compare('lb_membership_start_date',$this->lb_membership_start_date,true);
		$criteria->compare('lb_membership_end_date',$this->lb_membership_end_date,true);
		$criteria->compare('lb_membership_confirm',$this->lb_membership_confirm);
		$criteria->compare('lb_membership_remark',$this->lb_membership_remark,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbPeopleMemberships the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
