<?php

/**
 * This is the model class for table "lb_modules".
 *
 * The followings are the available columns in table 'lb_modules':
 * @property integer $lb_record_primary_key
 * @property string $module_name
 * @property string $module_text
 * @property string $modules_description
 * @property integer $module_hidden
 * @property integer $module_order
 * @property string $module_directory
 */
class Modules extends CLBActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_modules';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('module_name, module_directory, module_hidden, module_order', 'required'),
			array('module_hidden, module_order', 'numerical', 'integerOnly'=>true),
			array('module_name, module_text', 'length', 'max'=>100),
			array('modules_description', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lb_record_primary_key, module_name, module_text, modules_description, module_hidden, module_order, module_directory', 'safe', 'on'=>'search'),
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
                    'basic_account' => array(self::HAS_MANY,'AccountBasicPermission','module_id'),
                    'basic_role' => array(self::HAS_MANY,'RolesBasicPermission','module_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'lb_record_primary_key' => Yii::t('lang','Module'),
			'module_name' => Yii::t('lang','Module Name'),
			'module_text' => Yii::t('lang','Module Text'),
			'modules_description' => Yii::t('lang','Description'),
			'module_hidden' => Yii::t('lang','Hidden'),
			'module_order' => Yii::t('lang','Module Order'),
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
		$criteria->compare('module_name',$this->module_name,true);
		$criteria->compare('module_text',$this->module_text,true);
		$criteria->compare('modules_description',$this->modules_description,true);
		$criteria->compare('module_hidden',$this->module_hidden);
		$criteria->compare('module_order',$this->module_order);

                $dataProvider = $this->getFullRecordsDataProvider($criteria);
                return $dataProvider;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Modules the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function install()
        {
            
        }
        
        /**
        * Utility function to read the 'directories' under 'path'
        *
        * This function is used to read the modules or locales installed on the file system.
        * @param string The path to read.
        * @return array A named array of the directories (the key and value are identical).
        */
	function readDirs($path) {
		$dirs = array();
		$d = dir(Yii::app()->getBasePath()."/$path");
		while (false !== ($name = $d->read())) {
			if(is_dir(Yii::app()->getBasePath()."/{$path}/{$name}") && $name != '.' && $name != '..' && $name != 'CVS' && $name != '.svn') {
				$dirs[$name] = $name;
			}
		}
		$d->close();
		return $dirs;
	}
        
        public function checkHiddenModule($mod_directory)
        {
            $user_id = YII::app()->user->id;
            
            // Kiểm tra tai khoản admin
            $ownSub = AccountSubscription::model()->checkIsSubscriptionOwner(LBApplication::getCurrentlySelectedSubscription());
            //END
            
            $criteria=new CDbCriteria;
            $criteria->condition = 'module_directory = "'.$mod_directory.'" AND module_hidden = 1';
            
            $module = $this->getOneRecords($criteria);
            
            $basic_account = array();
            if($module)
            {
                // Kierm tra user da duoc gan module nay chua
                $checkModule = false;
                $basic_account = AccountBasicPermission::model()->findAll('module_id = "'.$module->lb_record_primary_key.'" AND account_id = '.  intval($user_id));
                if(count($basic_account)>0)
                    $checkModule = true;

                // Kiem tra uer da duoc gan role ma co module nay chua
                $checkModuleRole = false;
                $role = AccountRoles::model()->findAll('accout_id='.  intval($user_id));
                foreach ($role as $roleItem){
                    $basic_role = RolesBasicPermission::model()->findAll('role_id='.intval($roleItem->role_id).' AND module_id = '.intval($module->lb_record_primary_key));
                    if(count($basic_role)>0)
                    {
                        $checkModuleRole=true;
                    }
                }
                
            }
            // Kiem tra user co dc xem modules nay ko
//            $assignModulesUser = AccountBasicPermission::model()->findAll('account_id = '.intval($user_id).' AND module_id='.intval($dataProvider->data->module_id));
            if(count($module)>0 && $ownSub)
                return true;
            else if(count($module)>0 && ($checkModule==true || $checkModuleRole==true))
                return true;
            return false;
            
        }
        
        public function getModules()
        {
            $criteria=new CDbCriteria;
            $module = $this->getFullRecords($criteria);
            
            return $module;
        }
        
        public function getOneModules($module_name)
        {
            $criteria=new CDbCriteria;
            $criteria->condition = 'module_directory = "'.$module_name.'"';
            $module = $this->getOneRecords($criteria);
            
            return $module;
        }
        
        
}
