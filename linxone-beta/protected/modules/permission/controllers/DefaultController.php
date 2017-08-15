<?php

class DefaultController extends CLBController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
        
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			//'postOnly + delete', // we only allow deletion via POST request
		);
	}
        
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
                        array('allow',
                            'actions'=>array(
                                    'index','viewModules','installModule','deleteModule','updateStatusModule','AssingPermissionAccount',
                                    'UpdateBasicPermissionAccount','deleteModuleAccount','updateDefinePerAccount','ReloadAccountBasicPermission',
                                    'reloadAccountDefinePermission','AssignRoleAccount','ReloadRoleAccount','DeleteRoleAccount','sortGridView'
                                
                            ),
                            'users'=>array('@'),
                        ),
			array('allow',  // deny all users
                                'actions'=> array(''),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	public function actionIndex()
	{
		$this->render('index');
	}
        public function actionViewModules()
        {
            $model=new Modules('search');
            $model->unsetAttributes();  // clear any default values
            if(isset($_GET['Modules']))
                    $model->attributes=$_GET['Modules'];

            $this->render('_form_view_modules',array(
                'model'=>$model,
            ));
        }
        
        /**
         * Chuc nang: cai dat cac module vao he thong
         * @param type $mod_name
         * @return boolean
         */
        public function actionInstallModule($mod_name){
            $ok = @include_once( Yii::app()->getBasePath().'/modules/'.$mod_name.'/setup.php' );
            
            // Kiem tra ton tai file setup trong module
            if(!$ok)
            {
                $this->render ('_view_error',array('msg'=>'Module setup file could not be found.'));
                return false;
            }
            
            // Kiem tra da dat ten module chua
            if(!$config['mod_name'])
            {
                $this->render ('_view_error',array('msg'=>'Module does not have a valid setup module name defined.'));
                return false;
            }
            $modelMol = Modules::model()->findAll();
                    
            $module = new Modules();
            $module->module_directory = $mod_name;
            $module->module_name = $config['mod_name'];
            $module->module_text = (isset($config['mod_ui_name'])) ? $config['mod_ui_name'] : $config['mod_name'];
            $module->modules_description = $config['mod_description'];
            $module->module_hidden = 0;
            $module->module_order = count($modelMol)+1;
            if($module->save())
            {
                if(isset($config['mod_permission_define']) && count($config['mod_permission_define'])>0)
                {
                    foreach ($config['mod_permission_define'] as $defineItem) {
                        $definepermission = new DefinePermission();
                        $definepermission->module_id = $module->lb_record_primary_key;
                        $definepermission->define_permission_name=$defineItem;
                        $definepermission->save();
                    }
                }
                $this->redirect($this->createUrl('viewModules'));
            }
        }
        
        public function actionDeleteModule()
        {
            if(isset($_POST['module_id']))
            {
                $module_id = $_POST['module_id'];
                $module = Modules::model()->findByPk($module_id);
                if($module->delete())
                {
                    $definePermission = DefinePermission::model()->deleteAll('module_id = '. intval($module_id));
                    $roleBasic = RolesBasicPermission::model()->deleteAll('module_id = '.  intval($module_id));
                    $roleDefine = RolesDefinePermission::model()->deleteAll('module_id = '.intval($module_id));
                    $accountBasic = AccountBasicPermission::model()->deleteAll('module_id = '. intval($module_id));
                    $accountDefine = AccountDefinePermission::model()->deleteAll('module_id = '. intval($module_id));
                    echo '{"status":"success"}';
                }
                else
                    echo '{"status":"fail"}';
            }
        }
        
        public function actionUpdateStatusModule()
        {
            if(isset($_POST['modules_id']) && isset($_POST['status']))
            {
                $module_id = $_POST['modules_id'];
                $status = $_POST['status'];
                
                $module = Modules::model()->findByPk($module_id);
                $module->module_hidden = $status;
                if($module->save())
                    echo '{"status":"success"}';
                else {
                    echo '{"status":"fail"}';
                }
            }
        }
        
        public function actionAssingPermissionAccount()
        {
            $result = false;
            
            $permissionBasic = BasicPermission::model()->findAll();
            if(isset($_POST['modules_id']) && isset($_POST['account_id']))
            {
                if(AccountBasicPermission::model()->checkModuleAssignAccount($_POST['account_id'], $_POST['modules_id'])==true)
                {
                        echo '{"status":"exist","msg":"Module already exists."}';
                        return;
                }
                else
                {
                    foreach ($permissionBasic as $permissionBasicItem) { 
                        $basisPermissionAccount = new AccountBasicPermission();
                        $basisPermissionAccount->account_id = $_POST['account_id'];
                        $basisPermissionAccount->module_id = $_POST['modules_id'];
                        $basisPermissionAccount->basic_permission_id = $permissionBasicItem->basic_permission_id;
                        $basisPermissionAccount->basic_permission_status = 0;
                        if($basisPermissionAccount->save())
                            $result = true;
                    }
                }
            }
            if($result)
                echo '{"status":"success"}';
            else
                echo '{"status":"fail"}';
        }
        
        public function actionReloadAccountBasicPermission()
        {
            if(isset($_POST['account_id']))
            {
                $acount_id = $_POST['account_id'];
                
                $this->renderPartial('permission.views.account._form_basic_permission_account',array('account_id'=>$acount_id));
            }
        }
        
        public function ActionReloadAccountDefinePermission()
        {
            if(isset($_POST['account_id']))
            {
                $account_id = $_POST['account_id'];
                
                $this->renderPartial('permission.views.account._form_define_permission_account',array('account_id'=>$account_id));
            }
        }
        
        public function actionUpdateBasicPermissionAccount()
        {
            if(isset($_POST['permission_id']) && isset($_POST['status']))
            {
                $permission_acount = AccountBasicPermission::model()->findByPk($_POST['permission_id']);
                $permission_acount->basic_permission_status = $_POST['status'];
                if($permission_acount->save())
                    echo '{"status":"success"}';
                else
                    echo '{"status":"fail"}';
            }
        }
        
        public function actionDeleteModuleAccount()
        {
            if(isset($_POST['module_id']) && isset($_POST['account_id']))
            {
                $module_id = $_POST['module_id'];
                $account_id = $_POST['account_id'];
                $delete = $modelModuleRole = AccountBasicPermission::model()->deleteAll('module_id = '.intval($module_id).' AND account_id = '.  intval($account_id));
                if($delete)
                    echo '{"status":"success"}';
                else
                    echo '{"status":"fail"}';
            }
        }
        
        public function actionUpdateDefinePerAccount()
        {
            if(isset($_POST['account_id']) && isset($_POST['define_per_id']) && isset($_POST['status']))
            {
                $acount_id = $_POST['account_id'];
                $define_per_id = $_POST['define_per_id'];
                $status = $_POST['status'];
                $module_id = $_POST['module_id'];
                
                if($status==0)
                {
                    $defineAcount = new AccountDefinePermission();
                    $defineAcount->account_id = $acount_id;
                    $defineAcount->define_permission_id = $define_per_id;
                    $defineAcount->module_id = $module_id;
                    if($defineAcount->save())
                        echo '{"status":"success"}';
                    else
                        echo '{"status":"fail"}';
                }
                else
                {
                    $defineAccount = AccountDefinePermission::model()->find('account_id = '.intval($acount_id). ' AND define_permission_id = '.intval($define_per_id));
                    if($defineAccount->delete())
                        echo '{"status":"success"}';
                    else
                        echo '{"status":"fail"}';
                }
            } 
        }
        
        public function actionReloadRoleAccount()
        {
            if(isset($_POST['account_id']))
            {
                $account_id = $_POST['account_id'];
                
                $this->renderPartial('permission.views.account._form_account_role',array('account_id'=>$account_id));
            }
        }
        
        public function actionAssignRoleAccount()
        {
            if(isset($_POST['account_id']) && isset($_POST['role_id']))
            {
                $account_id = $_POST['account_id'];
                $role_id = $_POST['role_id'];
                
                $roleAccount = new AccountRoles();
                $roleAccount->accout_id = $account_id;
                $roleAccount->role_id = $role_id;
                if($roleAccount->save())
                    echo '{"status":"success"}';
                else
                    echo '{"status":"fail"}';
            }
        }
        
        public function actionDeleteRoleAccount()
        {
            if(isset($_POST['role_account_id']))
            {
                $model = AccountRoles::model()->findByPk ($_POST['role_account_id']);
                if($model->delete())
                {
                    echo '{"status":"success"}';
                }
                else{
                    echo '{"status":"fail"}'; 
                }
            }
        }
        
        public function actionSortGridView()
        {
            if (isset($_POST['items']) && is_array($_POST['items'])) {
                $i = 1;
                foreach ($_POST['items'] as $item) {
                    $model = Modules::model()->findByPk($item);
                    $model->module_order = $i;
                    $model->save();
                    $i++;
                }
            }
        }
}