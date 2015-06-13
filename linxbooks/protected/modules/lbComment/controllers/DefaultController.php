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
                                    'index','insertComment','deleteComment','updateComment'
                                     
                            ),
                            'users'=>array('@'),
                        ),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('@'),
			),
			array('allow',  // deny all users
				'users'=>array('*'),
                                'actions'=> array('GetPublicPDF'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
        
	public function actionIndex()
	{
		$this->renderPartial('index');
	}
        
        public function actioninsertComment()
        {
            $model =new LbComment();
            $item_id = false;
            $lb_comment_description = false;
            if(isset($_POST['item_id']) &&  $_POST['item_id'] > 0)
                $item_id = $_POST['item_id'];
            $module_name = false;
            if(isset($_POST['module_name']))
                $module_name = $_POST['module_name'];
            $date = date('Y-m-d');
            if(isset($_POST['comment']))
                $lb_comment_description = $_POST['comment'];
            $id_comment = $model->addComment($module_name, $lb_comment_description,$item_id,$date,0);
            
            if($id_comment)
            {
                $customer = AccountProfile::model()->getProfile($id_comment->lb_account_id);
              
                $response = array();
                $response['success'] = YES;
                $response['account_profile_given_name'] = $customer->account_profile_given_name;
                $response['account_profile_surname'] = $customer->account_profile_surname;
                
                $response['lb_comment_date'] = $id_comment->lb_comment_date;
                $response['lb_comment_description'] = nl2br($id_comment->lb_comment_description);
                $response['lb_module_name'] = $id_comment->lb_module_name;
                $response['lb_item_module_id'] = $id_comment->lb_item_module_id;
                $response['lb_parent_comment_id'] = $id_comment->lb_parent_comment_id;
                $response['lb_record_primary_key'] = $id_comment->lb_record_primary_key;
                LBApplication::renderPlain($this, array('content'=>  CJSON::encode($response)));
            }
            
        }
        
        public function actiondeleteComment()
        {
            $model = new LbComment;
            
            if($model->deleteByPk ($_REQUEST['id']))
            {
             $response = array();
             $response['success'] = YES;
            LBApplication::renderPlain($this, array('content'=>  CJSON::encode($response)));
       
            }
        }
    
        public function actionupdateComment()
        {
            $description = false;
              if(isset($_POST['id_comment']))
                  $id_commment = $_POST['id_comment'];
              if(isset($_POST['description']))
                  $description = $_POST['description'];
              
              $model = LbComment::model()->findByPk($id_commment);
              $model->lb_comment_description = $description;
              $date = date('Y-m-d');
              $model->lb_comment_date = $date;
              if($model->update())
              {
                   $response = array();
                   $response['success'] = YES;
                   $response['lb_comment_description']=  nl2br($model->lb_comment_description);
                   $response['lb_comment_date']=  $model->lb_comment_date;
                   LBApplication::renderPlain($this, array('content'=>  CJSON::encode($response)));
              
              }
        }

}
