<?php
class UIController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/plain_ajax_content';

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
						'actions'=>array('index','view', 'actionDropdown'),
						'users'=>array('@'),
				),
				array('deny',  // deny all users
						'users'=>array('*'),
				),
		);
	}
	
	public function actionActionDropdown($name)
	{
		switch ($name)
		{
			case "othertasks":
				$this->widget('bootstrap.widgets.TbButtonGroup', array(
			        'type'=> '', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
			        'encodeLabel' => false,
			        'buttons'=>array(
			            array('label'=>'Other Tasks', 
			            	'items'=>array(
			                	array('label'=>'Action', 'buttonType' => 'ajaxLink', 'url'=>'project/admin', 'ajaxOptions' => array('#update' => '#content')),
			                	array('label'=>'Another action with a very long name to see where it goes', 'url'=>'#'),
			                	array('label'=>'Something else', 'url'=>'#'),
			                	'---',
			                	array('label'=>'<b>Separate link</b>', 'url'=>'#'),
            			)),
        			),
    			));
				break;
			case "myprojects":
				break;
			default:
				break;
		}
	}
	
	public function actionDropdownSource($name, $type = 'array')
	{
		switch ($name)
		{
			case 'myprojects':
				break;
			case 'mytasks':
				;
			default:
				break;
		}
	}
}