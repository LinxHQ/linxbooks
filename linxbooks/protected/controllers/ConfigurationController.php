<?php

$name = 'config.php';
include './protected/modules/lbExpenses/'.$name;

class ConfigurationController extends Controller
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array(
                                        'index','List','updateListName',
                                        'deleteTax','UpdateList',
                                        'createTax',
                                        'updateTax',
                                        'createDefaultNote',
                                        'ajaxLoadDefaultNote',
                                        'list_item',
                                        'ajaxUpdateItem',
                                        'ajaxUpdateFieldTax','deleteList',
                                        'DeleteItem',
                                        'AjaxLoadFormItem','AjaxInsertList',
                                        'addLineTranslate',
                                        'deleteLineTranslate',
                                        'ajaxUpdateField',
                                        'ajaxUpdateDate',
                                    
                                    ),
                            'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
        
	public function actionIndex()
	{
                $taxModel = LbTax::model()->getTaxes();
                
                $list = UserList::model()->getList();
                
                $translate = Translate::model()->search();
                
		$translate=new Translate('search');
		$translate->unsetAttributes();  // clear any default values
		if(isset($_GET['Translate']))
			$translate->attributes=$_GET['Translate'];
                
		LBApplication::render($this,'index',array(
                    'taxModel'=>$taxModel,
                    'list'=>$list,
                    'translate'=>$translate,
                ));
	}
        
        public function actionList()
        {
            $this->renderPartial($this, '_list_item', array(),true);
        }
        
        public function actionDeleteTax($id)
        {
                $taxModel = LbTax::model()->findByPk($id);
                if(!LbTax::model()->IsTaxExistInvoiceORQuotation($id))
                    $taxModel -> delete();
        }

        public function actionCreateTax()
        {
                $model = new LbTax();
                
                if (isset($_POST['LbTax']))
                {
                    $model->attributes=$_POST['LbTax'];
                    
                    $lbtax_arr = $_POST['LbTax'];
                    if(!LbTax::model()->IsNameTax($lbtax_arr['lb_tax_name']))
                    {
                            LBApplication::render($this, '_form_new_tax', array(
                                'model'=>$model,
                                'error'=>'Tax Name Exist',
                            ));
                    }
                    else
                    {
                        $lbtax_arr = $_POST['LbTax'];
                        if($model->save())
                        {
                           $this->redirect($this->createUrl('/'.LBApplication::getCurrentlySelectedSubscription().'/configuration'));
                        }
                    }
                }

            LBApplication::render($this, '_form_new_tax', array(
                'model'=>$model,
                'error'=>'',
            ));
        }
        
        public function actionUpdateTax($id) 
        {
            $model = LbTax::model()->findByPk($id);
            
            if (isset($_POST['LbTax']))
            {
                $model->attributes=$_POST['LbTax'];

                $lbtax_arr = $_POST['LbTax'];
                if(!$tax = LbTax::model()->IsNameTax($lbtax_arr['lb_tax_name'],$id))
                {
                        LBApplication::render($this, '_form_update_tax', array(
                            'model'=>$model,
                            'error'=>'Tax Name Exist',
                        ));
                }
                else
                {
                    if($model->save())
                    {
                        $this->redirect($this->createUrl('/'.LBApplication::getCurrentlySelectedSubscription().'/configuration'));
                    }
                }
            }
            
            LBApplication::render($this, '_form_update_tax', array(
                'model'=>$model,
                'error'=>'',
            ));
        }
        public function actionUpdateList($list) 
        {
            
            
            LBApplication::render($this, '_form_update_list', array(
               'list'=>$list
            ));
        }
        
        public function actionCreateDefaultNote()
        {
            $model = new LbDefaultNote();
            $lastDefaultNote = LbDefaultNote::model()->getFullRecords();
            if(count($lastDefaultNote)>0)
                return false;
            else
            {
                if($model->save())
                {
                    return LBApplication::renderPlain($this, array('content'=>CJSON::encode($model)));
                };
            }
        }
        
        public function actionAjaxLoadDefaultNote()
        {
                LBApplication::renderPartial($this, '_form_default_detail_note', array(
                                //'nextID'=>$nextID,
                        ),false);
        }


        // Uncomment the following methods and override them if needed
	/*
	public function filters() 
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
         * 
	*/
       public function actionlist_item($list)
       {
                $taxModel = LbTax::model()->getTaxes();
                if($list =='expenses_category')
                {
                    $list_item = UserList::model()->getItemsListName($list);
                }
//                else
                    $list_item = UserList::model()->getItemsListName($list);
		$this->render('list_item', array('list'=>$list_item,'list_name'=>$list,'taxModel'=>$taxModel));
                
		
       }
       public function loadModelUserList($id)
       {
                $model = UserList::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
       }
       public function actionDeleteItem($id) {
          
           $this->loadModelUserList($id)->delete();
        
          }
        public function loadModel($id)
	{
		$model =  SystemList::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
        
       public function actionAjaxUpdateItem() 
        {
            $pk = $_POST['pk'];
            $name = $_POST['name'];
            $value = $_POST['value'];
            $model = UserList::model()->findByPk($pk);
            $listCode = $model->system_list_code;
            if($name == 'system_list_item_name') {
                $model->system_list_item_name = $value;
                $model->system_list_item_code = $listCode.'_'.$value;
            }
            $model->update();
//            return false;
            
        }
        
        
        
         function actionAjaxLoadFormItem()
        {
           $model = new UserList();
           $list_code = $_POST['list'];
           if(isset($_POST['item']) && $_POST['item'] !== "")
           {
                    $item = $_POST['item'];
                    $model->system_list_code = $list_code;
                    $model->system_list_item_name = $item;
                    $model->system_list_item_code = $list_code.'_'.$item;
                    $model->system_list_item_active='1';
                    $condition = 'system_list_item_code=:id';
                    if(!$model->getItemByCode($list_code.'_'.$item)) {
                        $model->insert();
                        echo json_encode(array('status'=>'success'));
                    } else {
                        echo json_encode(array('status'=>'failed'));
                    }
           }
           
        }
         function actionAjaxInsertList()
        {
           $model = new UserList();
           
           if(isset($_POST['item']) && $_POST['item'] !== "")
           {
                    $item = $_POST['item'];
                    
                    
                    if($model->insertList($item)) {
                        
                        echo json_encode(array('status'=>'success'));
                    } else {
                        echo json_encode(array('status'=>'failed'));
                    }
           }
           
        }
        
        function actionAddLineTranslate()
        {
            $tranlateModel = new Translate();
            if(isset($_POST['translate_en']) && isset($_POST['translate_vn']))
            {
                $tranlateModel->lb_tranlate_en = $_POST['translate_en'];
                $tranlateModel->lb_translate_vn = $_POST['translate_vn'];
                if($tranlateModel->save())
                    echo json_encode (array('status'=>'success'));
                else 
                    echo json_encode (array('status'=>'failed'));
            }
        }
        
        function actionDeleteLineTranslate($id)
        {
            $translateModel = Translate::model()->findByPk($id);

            if($translateModel->delete())
                echo json_encode (array('status'=>'success'));
            else 
                echo json_encode (array('status'=>'failed'));
        }
	public function actionAjaxUpdateField()
	{
		if (isset($_POST['pk']) && isset($_POST['name']) && isset($_POST['value']))
		{
			$id = $_POST['pk'];
			$attribute = $_POST['name'];
			$value = $_POST['value'];
	
			// get model
			$model = Translate::model()->findByPk($id);
			// update
			$model->$attribute = $value;
			return $model->save();
		}
	
		return false;
	}
        
        public function actiondeleteList()
        {
            $model=new UserList();
            $list="";
            if($_REQUEST['list'])
                $list=$_REQUEST['list'];

            $model->deleteAll('system_list_code = "'.$list.'"');
        }
        
        public function actionupdateListName()
        {
            $list_name="";
            if(isset($_POST['list_name']))
                $list_name=$_POST['list_name'];
            $list_old=$_POST['list_old'];
            $model = UserList::model()->find('system_list_code = "'.$list_name.'" ');
            
            if(count($model) > 0) {
                        
                   echo json_encode(array('status'=>'failed'));
            } else {
                   //update list item theo list name
                   $model_list = UserList::model()->findAll('system_list_code = "'.$list_old.'" ');
                   
                   foreach ($model_list as $data)
                   {
                       $model = UserList::model()->findByPk($data['system_list_item_id']);
                       $model->system_list_code=$list_name;
                       $model->update();
                   }

                   echo json_encode(array('status'=>'success'));
            }
            
            
        }
        public function actionajaxUpdateDate(){
            $pk = $_POST['pk'];
            $date = $_POST['value'];
            $day = date("d",  strtotime($date));
            $month = date("m", strtotime($date));
            $model = UserList::model()->findByPk($pk);
            $model->system_list_item_day = $day;
            $model->system_list_item_month = $month;
            $model->update();
        } 
}
