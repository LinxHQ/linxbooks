<?php

class DefaultController extends CLBController
{
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
                                'actions'=>array('cronInvoiceUpdateStatus'),
                                'users'=>array('*'),
                            ),
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','ajaxGetTax','ajaxGetTotals',
                    'chooseItemTemplate',
                ),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','ajaxUpdateField','dashboard','_search_employee','EnterPayment',
                                    'Payment','ListPayment','ajaxDeletePayment','_search_Payment','printPDF_employee',
                                    'printPDF_payment','printPDF_AllPayment','printPDF_EnterPayment','printPDF_DetailSalaryEmployee',
                                    'ajaxDropDownSalary','HistorySalary'
                                    ),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				//'actions'=>array('admin','delete','ajaxDeleteItem'),
                                'actions'=>array('delete','ajaxDeleteItem','AjaxDeleteBenefit'),
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
		$this->render('index');
	}
        
        public function actionDashboard()
	{
		$model=new LbEmployee('search');
		

		LBApplication::render($this, 'dashboard',array(
			'model'=>$model,
                        
		));
	}
        
        public function actionView($id)
	{
                $model=$this->loadModel($id);
                LBApplication::render($this,'update',array(
                    'id'=>$id,
                    'model'=>$model
                ));
//		$this->redirect(array('update','id'=>$id));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new LbEmployee;
                $salaryModel = new LbEmployeeSalary();
                $benefitModel = new LbEmployeeBenefits();
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
                
		if(isset($_POST['LbEmployee']))
		{
                  
                    
                    $employee_birthday=date('Y-m-d', strtotime($_POST['LbEmployee']['employee_birthday']));
                    
                    $model->attributes=$_POST['LbEmployee'];
                    $model->employee_birthday=$employee_birthday;
                    $model->employee_note = $_POST['LbEmployee']['employee_note'];
                    $model->employee_bank = $_POST['LbEmployee']['employee_bank'];
                    
                    if($model->save())
                    {
                        $salary_name = $_POST['salary_name'];
                        $salary_amount = $_POST['salary_amount'];
                        $total_salary=0;
                        for($i=0; $i<count($salary_amount); $i++)
                        {
                            $salary = new LbEmployeeSalary();
                            $salary->salary_name=$salary_name[$i];
                            $salary->salary_amount=$salary_amount[$i];
                            $salary->employee_id=$model->lb_record_primary_key;
                            if($salary->save())
                            {
                                $total_salary +=$salary->salary_amount;
                            }
                        }
                        
                        //save benefit
                        $benefit_name = $_POST['benefit_name'];
                        $benefit_amount = $_POST['benefit_amount'];
                        $total_benefit=0;
                        for($i=0; $i<count($benefit_amount); $i++)
                        {
                            $benefit = new LbEmployeeBenefits();
                            $benefit->benefit_name=$benefit_name[$i];
                            $benefit->benefit_amount=$benefit_amount[$i];
                            $benefit->employee_id=$model->lb_record_primary_key;
                            if($benefit->save())
                            {
                                $total_benefit +=$benefit->benefit_amount;
                            }
                        }
                        
                    
                        $this->redirect(array('update','id'=>$model->lb_record_primary_key));
		
                    }
               }
                
		$this->render('create',array(
			'model'=>$model,
                        'salaryModel'=>$salaryModel,
                        'benefitModel'=>$benefitModel
		));
	}
//        public function actionajaxDropDownSalary(){
//           $salaryModel = new LbEmployeeSalary();
//           $tax_id = $_POST['tax_id'];         
//           $this->render('dropDownSalary',array('salaryModel'=>$salaryModel,'tax_id'=>$tax_id));
//       }
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

		if(isset($_POST['LbEmployee']))
		{
                    
			$model->attributes=$_POST['LbEmployee'];
                        
                        $employee_birthday=date('Y-m-d', strtotime($_POST['LbEmployee']['employee_birthday']));
                    
                        $model->employee_birthday=$employee_birthday;
                        $model->employee_note = $_POST['LbEmployee']['employee_note'];
                        $model->employee_bank = $_POST['LbEmployee']['employee_bank'];
                        
			if($model->save())
                        {
                            
                            $salary_name = $_POST['salary_name'];
                            $salary_amount = $_POST['salary_amount'];
                            $salary_id = $_POST['lb_record_primary_key'];
                            
                            for($i=0; $i<count($salary_name); $i++)
                            {
                                $salary = new LbEmployeeSalary();
                                if(isset($salary_id[$i]) && $salary_id[$i] > 0)
                                    $salary = LbEmployeeSalary::model()->findByPk($salary_id[$i]);
                                $salary->salary_name=$salary_name[$i];
                                $salary->salary_amount=$salary_amount[$i];
                                $salary->employee_id=$model->lb_record_primary_key;
                                
                                $salary->save();
                                
                            }
                            
                            //update benefit
                            $benefit_name = $_POST['benefit_name'];
                            $benefit_amount = $_POST['benefit_amount'];
                            $benefit_id = $_POST['key_benefits'];
                            
                            for($i=0; $i<count($benefit_name); $i++)
                            {
                                $benefit = new LbEmployeeBenefits();
                                if($benefit_id[$i] > 0)
                                    $benefit = LbEmployeeBenefits::model()->findByPk($benefit_id[$i]);
                                $benefit->benefit_name=$benefit_name[$i];
                                $benefit->benefit_amount=$benefit_amount[$i];
                                $benefit->employee_id=$model->lb_record_primary_key;
                                
                                $benefit->save();
                                
                            }
    
		
                        }
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
                //Delete employee
		$this->loadModel($id)->delete();
                
                //delete benefit
                LbEmployeeSalary::model()->deleteAll('employee_id = '.$id);
                
                //delete salary
                LbEmployeeBenefits::model()->deleteAll('employee_id = '.$id);
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	public function actionAjaxDeleteItem($id,$employee_id)
        {            
            $invoiceItem = LbEmployeeSalary::model()->findByPk($id);
            $invoiceItem->delete();
            $this->redirect(array('update','id'=>$employee_id));
        }
        public function actionAjaxDeleteBenefit($id,$employee_id){
            $benefit = LbEmployeeBenefits::model()->findByPk($id);
            $benefit->delete();
            $this->redirect(array('update','id'=>$employee_id));
        }
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new LbEmployee('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['LbEmployee']))
			$model->attributes=$_GET['LbEmployee'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return LbEmployee the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=LbEmployee::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param LbEmployee $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='lb-employee-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
       public function action_search_employee()
       {
             $name = $_GET['name'];
             
             LBApplication::renderPartial($this, '_search_employee',array(
			'name'=>$name,
                      
                       
		));
       }
//       public function action_search_employee()
//       {
//             $name = $_GET['name'];
//             $date=$_GET['date_value'];
//             LBApplication::renderPartial($this, '_search_employee',array(
//			'name'=>$name,
//                        'date'=>$date
//                       
//		));
//       }
       public function action_search_Payment()
       {
             $type=false;
             
             $employee_id = isset($_GET['employee_id']) ? $_GET['employee_id'] : 0;
            if(isset($employee_id) && $employee_id > 0){
                $employee = LbEmployee::model()->getInfoEmployee($employee_id);
                $name = $employee->employee_name;          
            }
            else{
                $name = $_GET['name'];
            }
               
          //   $name = $_GET['name'];
             $date=$_GET['date'];
             $model = LbEmployee::model()->searchEmployeeByName($name);
             if(isset($_GET['type']))
             {
                 LBApplication::renderPartial($this, '_search_enter_Payment',array(
			'name'=>$name,
                        'date'=>$date,
                        'model'=>$model
		));
             }
             else
                LBApplication::renderPartial($this, '_search_Payment',array(
			'name'=>$name,
                        'date'=>$date,
		));
       }
       
   /*    public function actionEnterPayment()
       {
           $employee_id = isset($_GET['employee_id']) ? $_GET['employee_id'] : 0;
           LBApplication::render($this, 'form_enter_payment',array('employee_id'=>$employee_id) );
       }*/
        public function actionEnterPayment()
       {
           $employee_id = isset($_GET['employee_id']) ? $_GET['employee_id'] : 0;
          
            if(isset($employee_id) && $employee_id > 0){
                 $date = isset($_GET['date']) ? $_GET['date'] : '';
                $employee = LbEmployee::model()->getInfoEmployee($employee_id);  
                $name = $employee->employee_name;
                 $model = LbEmployee::model()->searchEmployeeByName($name);
                LBApplication::render($this, 'form_payment', array(
                    'employee_id'=>$employee_id,
                    'model'=>$model,
                ));
            }else{
                LBApplication::render($this, 'form_enter_payment','' );
            }
       }
 /*      public function actionPayment()
       {
           $employeePayment = $_POST['LbEmployeePayment'];
           
           for($i=0;$i<count($employeePayment);$i++)
           {
               if(isset($employeePayment[$i]['employee_id']))
               {
                   
                   $datepay=  date_format(date_create($_POST['datePaid']),'Y-m-d');
                   $month = date('m', strtotime($datepay));
                   $year = date('Y', strtotime($datepay));
                   
                   $model = new LbEmployeePayment();
                   $model->attributes=$employeePayment[$i];
                   $model->payment_note=$employeePayment[$i]['payment_note'];
                   $model->payment_month=$month;
                   $model->payment_year=$year;
                   $model->payment_date=  date('Y-m-d');
                   $model->payment_created_by=  Yii::app()->user->id;
                   
                    $model->save();
                    //upodate status payment
                    if($model->caculatorAmount($employeePayment[$i]['employee_id']) > 0)
                        $model->payment_status=2;
                    else
                        $model->payment_status = 1;
                    $model->save();
               }
           }
       }
  */
        public function actionPayment()
       {
           $employeePayment = $_POST['LbEmployeePayment'];
           foreach ($employeePayment as $key => $value)
        //   for($i=0;$i<count($employeePayment);$i++)
           {
               if(isset($value['employee_id']))
               {
                   
                   $datepay=  date_format(date_create($_POST['datePaid']),'Y-m-d');
                   $month = date('m', strtotime($datepay));
                   $year = date('Y', strtotime($datepay));
                   
                   $model = new LbEmployeePayment();
                   $model->attributes=$value;
                   $model->payment_note=$value['payment_note'];
                   $model->payment_month=$month;
                   $model->payment_year=$year;
                   $model->payment_date=  date('Y-m-d');
                   $model->payment_created_by=  Yii::app()->user->id;
                   
                    $model->save();
                    //upodate status payment
                    if($model->caculatorAmount($value['employee_id']) > 0)
                        $model->payment_status=2;
                    else
                        $model->payment_status = 1;
                    $model->save();
               }
           }
       }
            
       public function actionListPayment()
       {
            LBApplication::render($this, 'form_list_payment',array() );
       }
       
       public function actionajaxDeletePayment($id)
       {
           $paymentItem = LbEmployeePayment::model()->findByPk($id);
           $paymentItem->delete();
       }
       public function actionprintPDF_employee(){
           $criteria = new CDbCriteria();
           $html2pdf = Yii::app()->ePdf->HTML2PDF();
           $model = LbEmployee::model()->findAll($criteria);
           $html2pdf->WriteHTML($this->renderPartial('PDFEmployee',array('model'=>$model),true));
           $html2pdf->Output('Employee.pdf','I');
       }
       
       public function actionprintPDF_DetailSalaryEmployee(){
           $employee_id = isset($_GET['employee_id']) ? $_GET['employee_id'] : 0;
           
           $html2pdf = Yii::app()->ePdf->HTML2PDF();
           $model = new LbEmployee();
           $html2pdf->WriteHTML($this->renderPartial('PDFSalaryEmployee',array('model'=>$model,'employee_id'=>$employee_id),true));
           $html2pdf->Output('SalaryEmployee.pdf','I');
       }
        public function actionprintPDF_AllPayment(){
           $employee_name = isset($_GET['employee_name']) ? $_GET['employee_name'] : "";
           $month_year = isset($_GET['month_year']) ? $_GET['month_year'] : 0;
           
         
           $html2pdf = Yii::app()->ePdf->HTML2PDF();
           $model = new LbEmployeePayment();
           $html2pdf->WriteHTML($this->renderPartial('PDFAllPayment',array('model'=>$model,'month_year'=>$month_year,'employee_name'=> $employee_name),true));
           $html2pdf->Output('AllPayment.pdf','I');
       }
       public function actionprintPDF_EnterPayment(){
           $employee_name = isset($_GET['employee_name']) ? $_GET['employee_name'] : "";
           $month_year = isset($_GET['month_year']) ? $_GET['month_year'] : 0;
           $html2pdf = Yii::app()->ePdf->HTML2PDF();
           $model = new LbEmployeePayment();
           $html2pdf->WriteHTML($this->renderPartial('PDFEnterPayment',array('model'=>$model,'month_year'=>$month_year,'employee_name'=> $employee_name),true));
           $html2pdf->Output('EnterPayment.pdf','I');
       }
       
}
