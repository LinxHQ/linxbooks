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
				'actions'=>array('index', 'config', 'create', 'training', 'profileUser', 'deleteCourse', 'deleteSkill', 'getLevel', 'updateCourse', 'updateSkill', 'searchTrainingNeed', 'deleteSkillNeed', 'updateResultCourse', 'deleteAssEmployeeNeed', 'loadSkillEmployee', 'updateStatusNeed'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex(){
        $model=new LbTalentNeed('search');
		LBApplication::render($this, 'index',array(
			'model'=>$model,
		));
    }

    public function actionConfig(){
    	
    	$model_course=new LbTalentCourses;
    	if(isset($_POST['LbTalentCourses'])){
    		$model_course->attributes=$_POST['LbTalentCourses'];
    		$model_course->lb_create_date = date('Y-m-d');
    		if($model_course->save()){
    			$course_id_after_save = $model_course->lb_record_primary_key;
	    		$arr_lb_skill_id = $_POST['lb_skill_id'];
	    		foreach ($arr_lb_skill_id as $key => $value) {
	    			$model_course_skill = new LbTalentCourseSkills;
	    			$model_course_skill->lb_talent_course_id = $course_id_after_save;
	    			$model_course_skill->lb_skill_id = $value;
	    			$model_course_skill->save();
	    		}
	    		
    		}
    	}
    	$model_skill=new LbTalentSkills;
    	if(isset($_POST['LbTalentSkills'])){
    		$model_skill->attributes=$_POST['LbTalentSkills'];
    		$model_skill->lb_create_date = date('Y-m-d');
    		if($model_skill->save())
				$this->redirect(array('config'));
    	}
    	$model_search=new LbTalentSkills('search');
    	LBApplication::render($this, 'config',array(
			'model'=>$model_search,
		));
    }

    public function actionCreate(){
    	
    	$model=new LbTalentNeed;
    	if(isset($_POST['LbTalentNeed']))
		{
			$model->attributes=$_POST['LbTalentNeed'];
			$model->lb_talent_start_date = date('Y-m-d', strtotime($_POST['LbTalentNeed']['lb_talent_start_date']));
			$model->lb_talent_end_date = date('Y-m-d', strtotime($_POST['LbTalentNeed']['lb_talent_end_date']));
			if($model->save())
				$this->redirect(array('index'));
		}

    	$this->render('create',array(
			'model'=>$model,
		));
    }
    public function actionTraining($id){
    	$model_employee_need=new LbTalentEmployeeCourses;
    	if(isset($_POST['LbTalentEmployeeCourses'])){
    		$model_employee_need->lb_employee_id = $_POST['LbTalentEmployeeCourses']['lb_employee_id'];
			$model_employee_need->lb_talent_need_id = $id;
			$model_employee_need->lb_create_date = date('Y-m-d', strtotime($_POST['LbTalentEmployeeCourses']['lb_create_date']));
			$model_employee_need->lb_end_date = date('Y-m-d', strtotime($_POST['LbTalentEmployeeCourses']['lb_end_date']));
			$model_employee_need->lb_course_id = $_POST['LbTalentEmployeeCourses']['lb_course_id'];
			$model_employee_need->save();
    	}

    	$model_need_skill=new LbTalentNeedSkills;
		if(isset($_POST['LbTalentSkills'])){
			$model_need_skill->lb_talent_need_id = $id;
			$model_need_skill->lb_skill_id = $_POST['LbTalentSkills']['lb_skill_name'];
			$model_need_skill->lb_create_date = date('Y-m-d');
			$model_need_skill->save();
		}

    	$model_skill=new LbTalentSkills;
    	// $model_need=new LbTalentNeed;
    	

    	$model_employee_need_search=new LbTalentEmployeeCourses('search');
    	// $this->render('training');
    	LBApplication::render($this, 'training',array(
			'model'=>$model_skill,
			'model_employee_need'=>$model_employee_need,
			'model_employee_need_search'=>$model_employee_need_search,
			// 'model_need'=>$model_need,
			'id_need'=>$id,
		));
    }
    public function actionProfileUser($employee_id, $need_id) {
    	LBApplication::render($this, 'profileUser',array(
			'employee_id'=>$employee_id,
			'need_id'=>$need_id,
		));
    }

    public function actionDeleteCourse() {
    	$course_id = $_REQUEST['course_id'];
		$delete_course=LbTalentCourses::model()->findByPk($course_id);
		if($delete_course->delete())
			LbTalentCourseSkills::model()->deleteAll('lb_talent_course_id IN ('.$course_id.')');
    }
    public function actionDeleteSkill() {
    	$skill_id = $_REQUEST['skill_id'];
		$delete_skill=LbTalentSkills::model()->findByPk($skill_id);
		$delete_skill->delete();
    }
    public function actionGetLevel()
    {
        echo CJSON::encode(Editable::source(UserList::model()->getItemsListCodeById('level_talent', true))); 
    }

    public function actionUpdateCourse()
    {
    	if (isset($_POST['pk']) && isset($_POST['name']) && isset($_POST['value']))
		{
			$id = $_POST['pk'];
			$attribute = $_POST['name'];
			$value = $_POST['value'];
	
			// get model
			$model = LbTalentCourses::model()->findByPk($id);
			// update
			$model->$attribute = $value;
            $model -> save();
			return true;
		}
		return false;
    }

    public function actionUpdateSkill()
    {
    	if (isset($_POST['pk']) && isset($_POST['name']) && isset($_POST['value']))
		{
			$id = $_POST['pk'];
			$attribute = $_POST['name'];
			$value = $_POST['value'];
	
			// get model
			$model = LbTalentSkills::model()->findByPk($id);
			// update
			$model->$attribute = $value;
            $model -> save();
			return true;
		}
	
		return false;
    }

    public function actionUpdateResultCourse()
    {
    	if (isset($_POST['pk']) && isset($_POST['name']) && isset($_POST['value']))
		{
			$id = $_POST['pk'];
			$attribute = $_POST['name'];
			$value = $_POST['value'];
	
			// get model
			$model = LbTalentEmployeeCourses::model()->findByPk($id);
			// update
			$model->$attribute = $value;
			$model->lb_course_status_id = 1;
            $model -> save();
			return true;
		}
	
		return false;
    }
    public function actionSearchTrainingNeed(){
    	$departments_id = $_REQUEST['departments_select'];
    	$year_departments_id = $_REQUEST['year_departments_select'];
    	$level_arr = UserList::model()->getItemsListCodeById('year', true);
    	$year = "";
      	foreach ($level_arr as $key => $value) {
      		if ($key == intval($year_departments_id))
                $year .= $value;
      	}
    	$model = new LbTalentNeed();
    	LBApplication::renderPartial($this,'index',  array('model'=>$model,'departments_id'=>$departments_id,'year'=>$year));
    }

    public function actionDeleteSkillNeed()
    {
    	$skill_need_id = $_REQUEST['skill_need_id'];
		$delete_skill_need=LbTalentNeedSkills::model()->findByPk($skill_need_id);
		$delete_skill_need->delete();
    }
    public function actionDeleteAssEmployeeNeed()
    {
    	$talent_employee_course_id = $_REQUEST['talent_employee_course_id'];
		$delete_employee_need=LbTalentEmployeeCourses::model()->findByPk($talent_employee_course_id);
		$delete_employee_need->delete();
    }
    public function actionLoadSkillEmployee()
    {
    	$employee_id = $_POST['employee_id'];
    	LBApplication::renderPartial($this,'load_skill_employee_need',  array(
    		'employee_id'=>$employee_id
    	));
    }
    public function actionUpdateStatusNeed()
    {
    	$id_need = $_REQUEST['id_need'];
    	$change_status_need_id = $_REQUEST['change_status_need_id'];
    	// get model
		$model = LbTalentNeed::model()->findByPk($id_need);
		// update
		$model->lb_talent_status_id = $change_status_need_id;
        $model -> save();
    }
}
