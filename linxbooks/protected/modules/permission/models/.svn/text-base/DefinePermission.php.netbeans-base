<?php

/**
 * This is the model class for table "lb_define_permission".
 *
 * The followings are the available columns in table 'lb_define_permission':
 * @property integer $define_permission_id
 * @property integer $module_id
 * @property string $define_permission_name
 * @property string $define_description
 * @property integer $define_permission_hidden
 */
class DefinePermission extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_define_permission';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('module_id, define_permission_name', 'required'),
			array('module_id, define_permission_hidden', 'numerical', 'integerOnly'=>true),
			array('define_permission_name', 'length', 'max'=>100),
			array('define_description', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('define_permission_id, module_id, define_permission_name, define_description, define_permission_hidden', 'safe', 'on'=>'search'),
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
			'define_permission_id' => 'Define Permission',
			'module_id' => 'Module',
			'define_permission_name' => 'Define Permission Name',
			'define_description' => 'Define Description',
			'define_permission_hidden' => 'Define Permission Hidden',
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

		$criteria->compare('define_permission_id',$this->define_permission_id);
		$criteria->compare('module_id',$this->module_id);
		$criteria->compare('define_permission_name',$this->define_permission_name,true);
		$criteria->compare('define_description',$this->define_description,true);
		$criteria->compare('define_permission_hidden',$this->define_permission_hidden);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DefinePermission the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getDefinePerModule($module_id)
        {
            $criteria=new CDbCriteria;
            $criteria->condition = 'module_id = '.  intval($module_id);
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
        
        public function checkFunction($module_name,$function_name,$user_id=false)
        {
            if(!$user_id)
                $user_id = YII::app()->user->id;
            $result_per = false;
            $modules = Modules::model()->find('module_directory = "'.$module_name.'"');
            
            if($modules)
            {
                $define_permission = DefinePermission::model()->find('define_permission_name = "'.$function_name.'" AND module_id = "'.$modules->lb_record_primary_key.'"');
                if($define_permission)
                {
                    // Kiểm tra quyền user được gán vào roles
                    $roles = AccountRoles::model()->findAll('accout_id = '.  intval($user_id));
                    foreach ($roles as $roleItem) {
                        $check_define_roles = RolesDefinePermission::model()->find('role_id = '.  intval($roleItem->role_id).
                                                                            ' AND define_permission_id = '.  intval($define_permission->define_permission_id));
                        if($check_define_roles)
                            $result_per = true;
                    }
                    // END role
                    
                    // Kiểm tra quyền trức tiếp user
                    $check_define_permission = AccountDefinePermission::model()->find('account_id = '.intval($user_id).
                                                                                    ' AND define_permission_id = '.intval($define_permission->define_permission_id));
                    if($check_define_permission)
                    {
                        $result_per = true;
                    }
                    //END
                }
            }
            
            return $result_per;
        }
}
