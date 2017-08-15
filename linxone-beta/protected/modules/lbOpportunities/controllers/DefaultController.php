<?php

class DefaultController extends CLBController
{
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}
	public function accessRules()
	{
		return array(
			// ),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','SortingColumn', 'AddColumn', 'Board', 'List', 'SwitchOpportunity','LoadListContact',
					'LoadListStaff','SaveAllOpportunities', 'SaveAllFiles','FileSizeConvert','SearchList','ViewDetailOpportunity','LoadComment','SaveAllUpdateOpportunity','SaveComment','ExportExcelView','ExportExcelSearch','PostComment', 'SearchOpportunities', 'DeleteOpportunity', 'SaveCustomerPopup',
                                    'LoadCustomers'),
				'users'=>array('@'),
			),
		);
	}
	// load board
	public function actionBoard()
	{
		$model=new LbOpportunityStatus('search');
		LBApplication::render($this, 'board',array(
			'model'=>$model,
		));
	}
	// load list opportunity
	public function actionList()
	{
		$model=new LbOpportunity('search');
		LBApplication::render($this, 'list',array(
			'model'=>$model,
		));
	}
	// search list Opportunities
	public function actionSearchOpportunities()
    {
        $date_from = false;
        $date_to = false;
        $category_id=1;
        // date from
        if(isset($_POST['date_from']))
            $date_from = $_POST['date_from'];
        // date to
        if(isset ($_POST['date_to']))
            $date_to = $_POST['date_to'];
        $model = new LbOpportunity();
      	
      	// redirect ve list
        LBApplication::renderPartial($this,'list',  array('model'=>$model,'category_id'=>$category_id,'date_from'=>$date_from,'date_to'=>$date_to));  
    }
    // load list contact khi add Opportunities
	public function actionLoadListContact(){
            $customer_id = $_REQUEST['customer_id'];
            $list_contact = LbCustomerContact::model()->findAll('lb_customer_id IN ('.$customer_id.')');
            foreach ($list_contact as $row) {
                echo '<option value="'. $row['lb_record_primary_key'] .'">'.$row['lb_customer_contact_first_name'].' '.$row['lb_customer_contact_last_name'].'</option>';
            }
	}
	// sorting column
	public function actionSortingColumn(){
		$list_order = $_REQUEST['list_order'];
		$list = explode(',' , $list_order);
		foreach ($list as $key => $value) {
			$column=LbOpportunityStatus::model()->findByPk($value);
			$column->listorder=$key;
			$column->update(); // save the change to databases
		}
	}
	// sorting Opportunity
	public function actionSwitchOpportunity(){
		$task_id = $_REQUEST['id_task'];
		$column_id = $_REQUEST['id_column'];
		$opportunities=LbOpportunity::model()->findByPk($task_id);
		$opportunities->opportunity_status_id=$column_id;
		$opportunities->update(); // save the change to databases
	}
        public function actionLoadCustomers(){
            LBApplication::renderPartial($this, 'load_list_customer',array());
        }
        // Save tao nhanh Customer
        public function actionSaveCustomerPopup(){
            $name_customer_popup = $_REQUEST['name_customer_popup'];
            $website_customer_popup = $_REQUEST['website_customer_popup'];
            $customer_popup = new LbCustomer;
            // save add contact
            $customer_popup->lb_customer_name=$name_customer_popup;
            $customer_popup->lb_customer_is_own_company=0;
            $customer_popup->lb_customer_website_url=$website_customer_popup;
            $customer_popup->save();
            
        }
        // Save tao nhanh Customer
        // 
        // add Opportunity tab board
	public function actionSaveAllOpportunities() {
		if(isset($_REQUEST['task_name'])){
			$task_name = $_REQUEST['task_name'];
		}else {
			$task_name = "";
		}
		if(isset($_REQUEST['customer_id'])){
			$customer_id = $_REQUEST['customer_id'];
		} else {
			$customer_id = "";
		}
		if(isset($_REQUEST['status'])){
			$status = $_REQUEST['status'];
		} else {
			$status = "";
		}
		if(isset($_REQUEST['task_value'])){
			$task_value = $_REQUEST['task_value'];
		} else {
			$task_value = "";
		}
		if(isset($_REQUEST['task_note'])){
			$task_note = $_REQUEST['task_note'];
		} else {
			$task_note = "";
		}
		if(isset($_REQUEST['contact_id'])){
			$contact_id = $_REQUEST['contact_id'];
		} else {
			$contact_id = "";
		}
		if(isset($_REQUEST['view_deadline_task'])){
			$view_deadline_task = $_REQUEST['view_deadline_task'];
			$view_deadline_task = date("Y-m-d", strtotime($view_deadline_task));
		} else {
			$view_deadline_task = "0000-00-00";
		}
		if(isset($_REQUEST['industry'])){
			$industry = $_REQUEST['industry'];
		} else {
			$industry = "";
		}
		if(isset($_REQUEST['task_staf'])){
			$task_staf = $_REQUEST['task_staf'];
		} else {
			$task_staf = "";
		}
		$today = date("Y-m-d");
		if($view_deadline_task == "1970-01-01"){
			$view_deadline_task = "0000-00-00";
		}
		if($task_name != "" && $status != ""){
		    $user_id = Yii::app()->user->id;
		    $opportunity=new LbOpportunity;
                    $opportunity->opportunity_name=$task_name;
                    $opportunity->customer_id=$customer_id;
                    $opportunity->opportunity_status_id=$status;
                    $opportunity->value=$task_value;
                    $opportunity->note=$task_note;
                    $opportunity->created_date=$today;
                    $opportunity->deadline=$view_deadline_task;
                    $opportunity->industry=$industry;
                    $opportunity->created_by=$user_id;
                    $opportunity->save(); // save the change to databases
                    // get opportunity_id after insert 
		    $opportunity_id = $opportunity->opportunity_id;
		    if($contact_id != ""){
			    foreach ($contact_id as $key => $value) {
			    	$contact_entry = new LbOpportunityEntry;
			        // save add contact
					$contact_entry->opportunity_id=$opportunity_id;
					$contact_entry->entry_id=$value;
					$contact_entry->entry_type="contact";
					$contact_entry->save();
			    }
			}
			if($task_staf != ""){
				foreach ($task_staf as $key => $value) {
					$contact_entry = new LbOpportunityEntry;
			        // save add staff
					$contact_entry->opportunity_id=$opportunity_id;
					$contact_entry->entry_id=$value;
					$contact_entry->entry_type="employee";
					$contact_entry->save();
			    }
			}
		    echo $opportunity_id;
		} else {
			echo "failure";
		}
	}

	// upload and save images
	public function actionSaveAllFiles() {
		if (isset($_FILES['my_file'])) {
	        $myFile = $_FILES['my_file'];
	        $fileCount = count($myFile["name"]);
	        $opportunity_id = $_POST['opportunities_id'];
	        for ($i = 0; $i < $fileCount; $i++) {
	            $target_file = Yii::app()->basePath.'/modules/lbOpportunities/document_upload/'. basename($opportunity_id.'_'.$myFile["name"][$i]);
                if (!file_exists($target_file)) {
                    $file_name = $myFile["name"][$i];
                    $tmp_name = $myFile["tmp_name"][$i];
                    $file_type = $myFile["type"][$i];
                    // echo $file_size = FileSizeConvert($myFile["size"][$i]);
                    $file_size = $myFile["size"][$i];
                    $file_error = $myFile["error"][$i];
                    // $today = date("Y-m-d H:i:s");
                    move_uploaded_file($tmp_name, $target_file);
                    $document_save = new LbOpportunityDocument;
			        // save add document
					$document_save->opportunity_id=$opportunity_id;
					$document_save->opportunity_document_name=$file_name;
					$document_save->opportunity_document_type=$file_type;
					$document_save->opportunity_document_size=$file_size;
					$document_save->save();
                }
	        }
	        echo '{"status": "Success"}';
	        
	    }
	}
	// add column
	public function actionAddColumn(){
		// para truyen tu view sang, su dung ajax jquery
		$column_name = $_REQUEST['column_name'];
		$column_color = $_REQUEST['color_picker'];
		// call model
        $contact = new LbOpportunityStatus;
        // save add column
		$contact->column_name=$column_name;
		$contact->column_color=$column_color;
		$contact->save();
	}
	// delete column
	public function actionDeleteColumn(){
		// para truyen tu view sang, su dung ajax jquery
		$column_id = $_REQUEST['column_id'];
		// find record dua vao $column_id
		$delete_column=LbOpportunityStatus::model()->findByPk($column_id);
		// delete the row from the database table
		$delete_column->delete();
	}
	// view detail Opportunities
	public function actionViewDetailOpportunity(){
		$model=new LbOpportunity('search');
		LBApplication::render($this, 'view_detail_opportunity',array(
			'model'=>$model,
		));
	}
	// update Opportunity
	public function actionSaveAllUpdateOpportunity()
	{
		// $opportunity_id = Yii::app()->db->getLastInsertID();
		if($_REQUEST['opportunity_id'] != ""){
			$opportunity_id = $_REQUEST['opportunity_id'];
		}
		if($_REQUEST['name'] != ""){
			$name = $_REQUEST['name'];
		}
		if($_REQUEST['customer_id'] != ""){
			$customer_id = $_REQUEST['customer_id'];
		}
		if($_REQUEST['industry'] != ""){
			$industry = $_REQUEST['industry'];
		} else {
            $industry = "";
        }
		if($_REQUEST['value'] != ""){
			$values = $_REQUEST['value'];
		}
		if($_REQUEST['deadline'] != ""){
			$deadline = $_REQUEST['deadline'];
            $deadline = date("Y-m-d", strtotime($deadline));
		}
		if($_REQUEST['status'] != ""){
			$status = $_REQUEST['status'];
		}
		if($_REQUEST['note'] != ""){
			$note = $_REQUEST['note'];
		} else {
            $note = "";
        }
		if($_REQUEST['contact'] != ""){
			$contact = $_REQUEST['contact'];
		}
		if($_REQUEST['staff'] != ""){
			$staff = $_REQUEST['staff'];
		}
		if($_REQUEST['invoice'] != ""){
			$invoice = $_REQUEST['invoice'];
		}
		if($_REQUEST['quotation'] != ""){
			$quotation = $_REQUEST['quotation'];
		}
		$today = date("Y-m-d");

		LbOpportunityEntry::model()->deleteAll('opportunity_id IN ('.$opportunity_id.')');
        if(isset($invoice)){
            foreach ($invoice as $key => $value) {
            	$model_entry = new LbOpportunityEntry;
		        // save add invoice
				$model_entry->opportunity_id=$opportunity_id;
				$model_entry->entry_id=$value;
				$model_entry->entry_type= "invoice";
				$model_entry->save();
            }
        }
        if(isset($quotation)){
            foreach ($quotation as $key => $value) {
		        // save add quotation
		        $model_entry = new LbOpportunityEntry;
				$model_entry->opportunity_id=$opportunity_id;
				$model_entry->entry_id=$value;
				$model_entry->entry_type= "quotation";
				$model_entry->save();
            }
        }
        if(isset($staff)){
            foreach ($staff as $key => $value) {
		        // save add staff
		        $model_entry = new LbOpportunityEntry;
				$model_entry->opportunity_id=$opportunity_id;
				$model_entry->entry_id=$value;
				$model_entry->entry_type= "employee";
				$model_entry->save();
            }
        }
        if(isset($contact)){
            foreach ($contact as $key => $value) {
		        // save add contact
		        $model_entry = new LbOpportunityEntry;
				$model_entry->opportunity_id=$opportunity_id;
				$model_entry->entry_id=$value;
				$model_entry->entry_type= "contact";
				$model_entry->save();
            }
        }

        $opportunity=LbOpportunity::model()->findByPk($opportunity_id);
		$opportunity->opportunity_name=$name;
		$opportunity->customer_id=$customer_id;
		$opportunity->opportunity_status_id=$status;
		$opportunity->value=$values;
		$opportunity->deadline=$deadline;
		$opportunity->note=$note;
		$opportunity->industry=$industry;
		$opportunity->update(); // save the change to databases
	}
	// export excel list Opportunities
	public function actionExportExcelView()
	{
		LBApplication::renderPartial($this,'export_excel_view',  array());
	}
	// post comment Opportunities
	public function actionPostComment()
	{
		// para truyen tu view sang
	    $opportunity_id = $_REQUEST['opportunity_id'];
        $comment_content = $_REQUEST['comment_content'];
        $today = date("Y-m-d H:i:s");
        $user_id = Yii::app()->user->id;

        // call model
        $comment = new LbOpportunityComment;
        
        // Save
		$comment->opportunity_id=$opportunity_id;
		$comment->comment_content=$comment_content;
		$comment->created_date=$today;
		$comment->created_by=$user_id;
		$comment->save();
	}
	// load comment ajax
	public function actionLoadComment(){
        LBApplication::renderPartial($this,'load_comment_opportunity',  array());
    }
    // add Industry
    public function actionSaveIndustry()
    {
    	// para truyen tu view sang
    	$industry_name = $_REQUEST['industry_name'];
    	// call model
        $industry = new LbOpportunityIndustry;
        // Save
		$industry->industry_name=$industry_name;
		$industry->save();
    }
    public function actionDeleteOpportunity() {
        // para truyen tu view sang, su dung ajax jquery
        $opportunity_id = $_REQUEST['opportunity_id'];
        // xoa contact, invoice, quotation, empoyee thuoc opportunity
        LbOpportunityEntry::model()->deleteAll('opportunity_id IN ('.$opportunity_id.')');
        // xoa document thuoc opportunity
        LbDocument::model()->deleteAll('lb_document_parent_id IN ('.$opportunity_id.')');
        LbOpportunity::model()->deleteAll(array("condition"=>"opportunity_id='$opportunity_id'"));
    }
}