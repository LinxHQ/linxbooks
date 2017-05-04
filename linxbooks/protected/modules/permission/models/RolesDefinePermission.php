<?php

/**
 * This is the model class for table "lb_roles_define_permission".
 *
 * The followings are the available columns in table 'lb_roles_define_permission':
 * @property integer $role_define_permission_id
 * @property integer $define_permission_id
 * @property integer $role_id
 * @property integer $define_permission_status
 * @property integer $module_id
 */
class RolesDefinePermission extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_roles_define_permission';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('define_permission_id, role_id, define_permission_status', 'required'),
			array('define_permission_id, role_id, define_permission_status', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('role_define_permission_id, define_permission_id, role_id, define_permission_status', 'safe', 'on'=>'search'),
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
			'role_define_permission_id' => 'Role Define Permission',
			'define_permission_id' => 'Define Permission',
			'role_id' => 'Role',
			'define_permission_status' => 'Define Permission Status',
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

		$criteria->compare('role_define_permission_id',$this->role_define_permission_id);
		$criteria->compare('define_permission_id',$this->define_permission_id);
		$criteria->compare('role_id',$this->role_id);
		$criteria->compare('define_permission_status',$this->define_permission_status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RolesDefinePermission the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function CheckDefinePerRole($role_id,$define_permission_id)
        {
            $criteria=new CDbCriteria;
            $criteria->condition = 'role_id = '.  intval($role_id);
            $criteria->condition .= ' AND define_permission_id = '.  intval($define_permission_id);
            $defineRole =  new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
            
            if($defineRole->totalItemCount>0)
                return true;
            return false;
        }
}
