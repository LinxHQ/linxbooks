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
                                    'index'
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
                $subscription = Subscription::model()->findAll();
                $data = UserSubscription::model()->getListUserSub();
                $dataProvider=new CActiveDataProvider('Subscription');
                
		$this->render('index', array(
                                    'subscription' => $subscription,
                                    'data'=>$data,
                                    'dataProvider'=>$dataProvider,
                            ));
        }
}