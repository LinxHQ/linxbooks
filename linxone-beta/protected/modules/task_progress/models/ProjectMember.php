<?php

/**
 * This is the model class for table "project_members".
 *
 * The followings are the available columns in table 'project_members':
 * @property integer $project_member_id
 * @property integer $project_id
 * @property integer $account_id
 * @property string $project_member_start_date
 * @property integer $project_member_is_manager
 */
class ProjectMember extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'project_members';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('project_id, account_id, project_member_start_date, project_member_is_manager', 'required'),
			array('project_id, account_id, project_member_is_manager', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('project_member_id, project_id, account_id, project_member_start_date, project_member_is_manager', 'safe', 'on'=>'search'),
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
                    'projects' => array(self::BELONGS_TO, 'Projects', 'project_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'project_member_id' => 'Project Member',
			'project_id' => 'Project',
			'account_id' => 'Account',
			'project_member_start_date' => 'Project Member Start Date',
			'project_member_is_manager' => 'Project Member Is Manager',
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

		$criteria->compare('project_member_id',$this->project_member_id);
		$criteria->compare('project_id',$this->project_id);
		$criteria->compare('account_id',$this->account_id);
		$criteria->compare('project_member_start_date',$this->project_member_start_date,true);
		$criteria->compare('project_member_is_manager',$this->project_member_is_manager);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProjectMember the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
         * 
         * @param type $account_id
         * @return \CActiveDataProvider
         */
        public function getProjectByMember($account_id)
        {
            $criteria = new CDbCriteria();
            $criteria->with = array('projects');
            $criteria->compare('account_id', intval($account_id));
            
            $dataProvider=new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
            ));
            
            return $dataProvider;
        }
        
}
