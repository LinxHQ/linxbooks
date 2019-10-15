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
				'actions'=>array('index','create','departmentsManager','departmentsEmployee', 'update', 'view'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex(){
        $this->render('index');
    }
    public function actionDepartmentsManager(){
        $this->render('departments_manager');
    }
    public function actionDepartmentsEmployee(){
        $this->render('departments_employee');
    }

    public function actionCreate(){
    	$this->render('create');
    }

    public function actionUpdate(){
    	$this->render('update');
    }

    public function actionView(){
    	$this->render('view');
    }
}
