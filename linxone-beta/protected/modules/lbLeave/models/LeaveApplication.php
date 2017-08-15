<?php

/**
 * This is the model class for table "leave_application".
 *
 * The followings are the available columns in table 'leave_application':
 * @property integer $leave_id
 * @property string $leave_startdate
 * @property string $leave_enddate
 * @property string $leave_reason
 * @property string $leave_approver
 * @property string $leave_ccreceiver
 * @property string $leave_name
 * @property string $leave_status
 * @property string $leave_type_name
 * @property string $leave_date_submit
 * @property integer $account_id
 * @property integer $leave_name_approvers_by
 * @property string $leave_list_day
 * @property string $leave_sum_day
 */
class LeaveApplication extends CLBActiveRecord
{

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'leave_application';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('leave_startdate, leave_enddate, leave_reason, leave_approver, leave_type_name', 'required'),
			array('account_id, leave_name_approvers_by,leave_startminute,leave_starthour,leave_endhour,leave_endminute', 'numerical', 'integerOnly'=>true),
			array('leave_approver, leave_ccreceiver, leave_name, leave_status, leave_type_name,leave_list_day', 'length', 'max'=>255),
			array('leave_sum_day', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('leave_id, leave_startdate, leave_enddate, leave_reason, leave_approver, leave_ccreceiver, leave_name, leave_status, leave_type_name, leave_date_submit, account_id, leave_name_approvers_by,leave_startminute,leave_starthour,leave_endhour,leave_endminute,leave_list_day,leave_sum_day', 'safe', 'on'=>'search'),
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
			'leave_id' => 'ID',
			'leave_type_name' => 'Type Leave',
			'leave_reason' => 'Reason',
			'leave_startdate' => 'Start',
			'leave_enddate' => 'End',
			
			'leave_approver' => 'Approver',
			'leave_ccreceiver' => 'CC-Receiver',
			'leave_name' => 'Leave Name',
			'leave_status' => 'Status',
			
			'leave_date_submit' => 'Leave Date Submit',
			'account_id' => 'Account',
			'leave_name_approvers_by' => 'Leave Name Approvers By',
			'leave_startminute'=>'',
			'leave_starthour'=>'',
			'leave_list_day'=>'',
			'leave_sum_day'=>''
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

		$criteria->compare('leave_id',$this->leave_id);
		$criteria->compare('leave_startdate',$this->leave_startdate,true);
		$criteria->compare('YEAR(leave_enddate)',$this->leave_enddate,true);
		$criteria->compare('leave_reason',$this->leave_reason,true);
		$criteria->compare('leave_approver',$this->leave_approver,true);
		$criteria->compare('leave_ccreceiver',$this->leave_ccreceiver,true);
		$criteria->compare('leave_name',$this->leave_name,true);
		$criteria->compare('leave_status',$this->leave_status,true);
		$criteria->compare('leave_type_name',$this->leave_type_name,true);
		$criteria->compare('leave_date_submit',$this->leave_date_submit,true);
		$criteria->compare('account_id',$this->account_id);
		$criteria->compare('leave_name_approvers_by',$this->leave_name_approvers_by);
		$criteria->compare('leave_list_day',$this->leave_list_day,true);
		$criteria->compare('leave_sum_day',$this->leave_sum_day,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LeaveApplication the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}



}
