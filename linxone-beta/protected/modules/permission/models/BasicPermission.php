<?php

/**
 * This is the model class for table "lb_basic_permission".
 *
 * The followings are the available columns in table 'lb_basic_permission':
 * @property integer $basic_permission_id
 * @property string $basic_permission_name
 * @property string $basic_permission_description
 * @property integer $basic_permission_hidden
 */
class BasicPermission extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_basic_permission';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('basic_permission_name, basic_permission_description, basic_permission_hidden', 'required'),
			array('basic_permission_hidden', 'numerical', 'integerOnly'=>true),
			array('basic_permission_name', 'length', 'max'=>100),
			array('basic_permission_description', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('basic_permission_id, basic_permission_name, basic_permission_description, basic_permission_hidden', 'safe', 'on'=>'search'),
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
			'basic_permission_id' => 'Basic Permission',
			'basic_permission_name' => 'Basic Permission Name',
			'basic_permission_description' => 'Basic Permission Description',
			'basic_permission_hidden' => 'Basic Permission Hidden',
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

		$criteria->compare('basic_permission_id',$this->basic_permission_id);
		$criteria->compare('basic_permission_name',$this->basic_permission_name,true);
		$criteria->compare('basic_permission_description',$this->basic_permission_description,true);
		$criteria->compare('basic_permission_hidden',$this->basic_permission_hidden);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BasicPermission the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
         * Hàm này lấy quyền của user
         * @param type $module_name
         * @param type $per_value
         * @param type $user_id
         * @return boolean
         */
        public function checkPerModule($module_name,$per_value,$user_id=FALSE) {
            if(!$user_id)
                $user_id = Yii::app()->user->id;
            $result_per = false;
            $modules = Modules::model()->getOneModules($module_name);
            $permission = BasicPermission::model()->find('basic_permission_name = "'.$per_value.'"');
            
            if($modules && $permission)
            {
                // Kiểm tra quyền user được gán vào roles
                $roles = AccountRoles::model()->findAll('accout_id = '.  intval($user_id));
                    foreach ($roles as $roleItem) {
                        $check_permisson_roles = RolesBasicPermission::model()->find('role_id = '.  intval($roleItem->role_id).
                                                                        ' AND module_id = '.  intval($modules->lb_record_primary_key).
                                                                        ' AND basic_permission_id = '.  intval($permission->basic_permission_id).
                                                                        ' AND basic_permission_status = 1');
                        if($check_permisson_roles && count($check_permisson_roles)>0)
                            $result_per = true;
                    }
                // END Roles

                // Kiểm tra gan quyền trực tiếp cho user
                    $check_permisson = AccountBasicPermission::model()->find('account_id = '.  intval($user_id).
                                                                        ' AND module_id = '. intval($modules->lb_record_primary_key).
                                                                        ' AND basic_permission_id = '.intval($permission->basic_permission_id));
                    if($check_permisson)
                    {
                        if($check_permisson->basic_permission_status==1)
                            $result_per = true;
                        else
                            $result_per = false;
                    }
                //End modules
            }
            
            return $result_per;
        }
        
        public function checkModules($module_name,$per_value,$created_by=false) {
            $user_id = Yii::app()->user->id;
            $canAdd = BasicPermission::model()->checkPerModule($module_name, 'add');
            $canEditOwn = BasicPermission::model()->checkPerModule($module_name, 'update own');
            $canEditAll = BasicPermission::model()->checkPerModule($module_name, 'update all');
            $canDeleteOwn = BasicPermission::model()->checkPerModule($module_name, 'delete own');
            $canDeleteAll = BasicPermission::model()->checkPerModule($module_name, 'delete all');
            $canViewOwn = BasicPermission::model()->checkPerModule($module_name, 'view own');
            $canViewAll = BasicPermission::model()->checkPerModule($module_name, 'view all');
            $canListOwn = BasicPermission::model()->checkPerModule($module_name, 'list own');
            $canListAll = BasicPermission::model()->checkPerModule($module_name, 'list all');
            
            $ownSub = AccountSubscription::model()->checkIsSubscriptionOwner(LBApplication::getCurrentlySelectedSubscription());
            
            $result = false;
            if($ownSub)
            {
                $result=true;
                if($per_value=="list")
                {
                    $result = FALSE;
                }
            }
            else
            {
                if($per_value=="add")
                {
                    $result = $canAdd;
                }
                else if($per_value=="update")
                {
                    if($canEditAll)
                        $result = true;
                    elseif($canEditOwn && $user_id==$created_by)
                        $result=true;
                }
                else if($per_value=="delete")
                {
                    if($canDeleteAll)
                        $result = true;
                    elseif($canDeleteOwn && $user_id==$created_by)
                        $result=true;
                }
                else if($per_value=="view")
                {
                    if($canViewAll)
                        $result = true;
                    elseif($canViewOwn && $user_id==$created_by)
                        $result=true;
                }
                else if($per_value=="list")
                {
                    $result = -1;
                    if($canListAll)
                        $result = false;
                    else if($canListOwn)
                        $result = Yii::app()->user->id;
                }
                
            }
            
            return $result;
        }
        
}
