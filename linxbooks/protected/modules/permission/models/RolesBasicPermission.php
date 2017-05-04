<?php

/**
 * This is the model class for table "lb_roles_basic_permission".
 *
 * The followings are the available columns in table 'lb_roles_basic_permission':
 * @property integer $role_basic_permission_id
 * @property integer $role_id
 * @property integer $module_id
 * @property integer $basic_permission_id
 * @property integer $basic_permission_status
 */
class RolesBasicPermission extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_roles_basic_permission';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('role_id, module_id, basic_permission_id, basic_permission_status', 'required'),
			array('role_id, module_id, basic_permission_id, basic_permission_status', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('role_basic_permission_id, role_id, module_id, basic_permission_id, basic_permission_status', 'safe', 'on'=>'search'),
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
                    'module' => array(self::BELONGS_TO,'Modules','module_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'role_basic_permission_id' => 'Role Basic Permission',
			'role_id' => 'Role',
			'module_id' => 'Module',
			'basic_permission_id' => 'Basic Permission',
			'basic_permission_status' => 'Basic Permission Status',
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

		$criteria->compare('role_basic_permission_id',$this->role_basic_permission_id);
		$criteria->compare('role_id',$this->role_id);
		$criteria->compare('module_id',$this->module_id);
		$criteria->compare('basic_permission_id',$this->basic_permission_id);
		$criteria->compare('basic_permission_status',$this->basic_permission_status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RolesBasicPermission the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getPermissionByRoles($role_id,$module_id)
        {
            $criteria = new CDbCriteria();
            
            $criteria->condition = "role_id = ".  intval($role_id);
            $criteria->condition .= " AND module_id = ".  intval($module_id);
            
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
        
        public function getModuleByRoles($role_id)
        {
            $criteria = new CDbCriteria();
            
            $criteria->condition = "role_id = ".  intval($role_id);
            $criteria->group = "module_id";
            
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
        
        public function checkModuleAssignRole($role_id,$module_id)
        {
            $moduleRole = $this->getPermissionByRoles($role_id, $module_id);
            
            if(count($moduleRole->data)>0)
            {
                return true;
            }
            return false;
        }
}
