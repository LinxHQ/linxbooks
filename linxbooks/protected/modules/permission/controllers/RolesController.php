<?php

class RolesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
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
                array('allow', // allow authenticated user to perform 'create' and 'update' actions
                        'actions'=>array('admin','create','update','AjaxAddLineRole','delete','index','view','deleteRole','assingPermissionRoles',
                            'updateBasicPermissionRoles','reloadRolesBasicPermission','deleteModuleRole', 'updateDefinePerRole'),
                        'users'=>array('@'),
                ),
                array('deny',  // deny all users
                        'users'=>array('*'),
                ),
            );
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Roles;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Roles']))
		{
			$model->attributes=$_POST['Roles'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->role_id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Roles']))
		{
			$model->attributes=$_POST['Roles'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->role_id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new Roles('search');
		$dataProvider->unsetAttributes();  // clear any default values
		if(isset($_GET['Roles']))
			$dataProvider->attributes=$_GET['Roles'];
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Roles('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Roles']))
			$model->attributes=$_GET['Roles'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Roles the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Roles::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Roles $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='roles-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        public function actionAjaxAddLineRole()
        {
            if(isset($_POST['role_name']))
            {
                $role = new Roles();
                $role->role_name = $_POST['role_name'];
                $role->role_description = $_POST['role_description'];
                if($role->save())
                    echo '{"status":"success"}';
                else
                    echo '{"status":"error"}';
            }
        }
        
        public function actionDeleteRole()
        {
            if(isset($_POST['role_id']))
            {
                $model=Roles::model()->findByPk($_POST['role_id']);
                if($model->delete())
                    echo '{"status":"success"}';
                else
                    echo '{"status":"error"}';
            }
        }
        
        public function actionAssingPermissionRoles()
        {
            $result = false;
            
            $permissionBasic = BasicPermission::model()->findAll();
            if(isset($_POST['modules_id']) && isset($_POST['role_id']))
            {
                if(RolesBasicPermission::model()->checkModuleAssignRole($_POST['role_id'], $_POST['modules_id'])==true)
                {
                        echo '{"status":"exist","msg":"module nay da ton tai."}';
                        return;
                }
                else
                {
                    foreach ($permissionBasic as $permissionBasicItem) { 
                        $basisPermissionRole = new RolesBasicPermission();
                        $basisPermissionRole->role_id = $_POST['role_id'];
                        $basisPermissionRole->module_id = $_POST['modules_id'];
                        $basisPermissionRole->basic_permission_id = $permissionBasicItem->basic_permission_id;
                        $basisPermissionRole->basic_permission_status = 0;
                        if($basisPermissionRole->save())
                            $result = true;
                    }
                }
            }
            if($result)
                echo '{"status":"success"}';
            else
                echo '{"status":"fail"}';
        }
        
        public function actionUpdateBasicPermissionRoles()
        {
            if(isset($_POST['permission_id']) && isset($_POST['status']))
            {
                $permission_role = RolesBasicPermission::model()->findByPk($_POST['permission_id']);
                $permission_role->basic_permission_status = $_POST['status'];
                if($permission_role->save())
                    echo '{"status":"success"}';
                else
                    echo '{"status":"fail"}';
            }
        }
        
        public function actionReloadRolesBasicPermission()
        {
            if(isset($_POST['role_id']))
            {
                $role_id = $_POST['role_id'];
                $model = Roles::model()->findByPk($role_id);
                
                $this->renderPartial('_form_basic_permission_role',array('model'=>$model));
            }
        }
        
        public function actionDeleteModuleRole()
        {
            if(isset($_POST['module_id']) && isset($_POST['role_id']))
            {
                $module_id = $_POST['module_id'];
                $role_id = $_POST['role_id'];
                $delete = $modelModuleRole = RolesBasicPermission::model()->deleteAll('module_id = '.intval($module_id).' AND role_id = '.  intval($role_id));
                if($delete)
                    echo '{"status":"success"}';
                else
                    echo '{"status":"fail"}';
            }
        }
        
        public function actionUpdateDefinePerRole()
        {
            if(isset($_POST['role_id']) && isset($_POST['define_per_id']) && isset($_POST['status']))
            {
                $role_id = $_POST['role_id'];
                $define_per_id = $_POST['define_per_id'];
                $status = $_POST['status'];
                $module_id = $_POST['module_id'];
                
                if($status==0)
                {
                    $defineRole = new RolesDefinePermission();
                    $defineRole->role_id = $role_id;
                    $defineRole->define_permission_id = $define_per_id;
                    $defineRole->module_id = $module_id;
                    $defineRole->define_permission_status = 1;
                    if($defineRole->save())
                        echo '{"status":"success"}';
                    else
                        echo '{"status":"fail"}';
                }
                else
                {
                    $defineRole = RolesDefinePermission::model()->find('role_id = '.intval($role_id). ' AND define_permission_id = '.intval($define_per_id));
                    if($defineRole->delete())
                        echo '{"status":"success"}';
                    else
                        echo '{"status":"fail"}';
                }
            }
        }
        
        public function reloadRolesBasicPermission()
        {
            if(isset($_POST['role_id']))
            {
                $role_id = $_POST['role_id'];
                $model = Roles::model()->findByPk($role_id);
                
                $this->renderPartial('_form_define_permission_role',array('model'=>$model));
            }
        }
}
