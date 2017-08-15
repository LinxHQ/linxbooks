<?php

/**
 * This is the model class for table "documents".
 *
 * The followings are the available columns in table 'documents':
 * @property integer $document_id
 * @property string $document_real_name
 * @property string $document_encoded_name
 * @property string $document_description
 * @property string $document_date
 * @property integer $document_revision
 * @property integer $document_root_revision_id
 * @property integer $document_owner_id
 * @property integer $document_parent_id
 * @property string $document_parent_type
 * @property string $document_is_temp
 * @property string $document_type
 */

define('DOCUMENT_PARENT_TYPE_TASK_COMMENT', 'TASK_COMMENT');
define('DOCUMENT_PARENT_TYPE_TASK', 'TASK');
define('DOCUMENT_PARENT_TYPE_PROJECT', 'PROJECT');
define('DOCUMENT_PARENT_TYPE_ISSUE_COMMENT', 'ISSUE_COMMENT');
define('DOCUMENT_PARENT_TYPE_WIKI_PAGE', 'WIKI_PAGE');
define('DOCUMENT_PARENT_TYPE_IMPLEMENTATION', 'IMPLEMENTATION');
define('DOCUMENT_IS_NOT_TEMP', 0);

class Documents extends CActiveRecord
{	
	public $document_temp_name; // document's temp name in temp folder
	public $document_task_id; // to hold task id
	public $document_comment_id; // to hold comment id
	public $document_project_id; 
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Documents the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_project_documents';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('document_real_name, document_encoded_name, document_date, document_revision, document_root_revision_id, document_owner_id', 'required'),
			array('document_revision, document_root_revision_id, document_owner_id, document_parent_id, document_is_temp', 'numerical', 'integerOnly'=>true),
			array('document_real_name, document_encoded_name, document_description, document_type', 'length', 'max'=>255),
			array('document_project_id, document_real_name, document_temp_name', 'safe'),
			array('document_parent_type', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('document_real_name, document_encoded_name, document_description, document_date, document_revision, document_root_revision_id, document_owner_id, document_parent_id, document_parent_type, document_type', 'safe', 'on'=>'search'),
			array('document_real_name, document_date', 'safe', 'on'=>'getDocuments'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'document_real_name' => YII::t('core','Document Real Name'),
			'document_encoded_name' => YII::t('core','Document Encoded Name'),
			'document_description' => YII::t('core','Document Description'),
			'document_date' => YII::t('core','Document Date'),
			'document_revision' => YII::t('core','Document Revision'),
			'document_root_revision_id' => YII::t('core','Document Root Revision'),
			'document_owner_id' => YII::t('core','Document Owner'),
			'document_parent_id' => YII::t('core','Document Parent'),
			'document_parent_type' => YII::t('core','Document Parent Type'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		//$criteria->compare('document_id',$this->document_id);
		$criteria->compare('document_real_name',$this->document_real_name,true);
		$criteria->compare('document_encoded_name',$this->document_encoded_name,true);
		$criteria->compare('document_description',$this->document_description,true);
		$criteria->compare('document_date',$this->document_date,true);
		$criteria->compare('document_revision',$this->document_revision);
		$criteria->compare('document_root_revision_id',$this->document_root_revision_id);
		$criteria->compare('document_owner_id',$this->document_owner_id);
		$criteria->compare('document_parent_id',$this->document_parent_id);
		$criteria->compare('document_parent_type',$this->document_parent_type,true);
		$criteria->compare('document_type',$this->document_parent_type,true);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function save($runValidation=true, $attributes=NULL)
	{
		$uploaded_date = date('Y-m-d H:i:s');
		$this->document_date = $uploaded_date;
		if ($this->document_encoded_name === null)
		{
			$this->document_encoded_name = $this->encodeDocumentName();
		}
		$this->document_revision = 0;
		$this->document_root_revision_id = 0;
		$this->document_owner_id = Yii::app()->user->id;
		
		// check permission
		if ($this->isNewRecord)
		{
			if (!Permission::checkPermission($this, PERMISSION_DOCUMENT_CREATE))
				return false;
		} else {
			if (!Permission::checkPermission($this, PERMISSION_DOCUMENT_UPDATE))
				return false;
		}
		
		return parent::save($runValidation=true, $attributes=NULL);
	}
	
	/**
	 * If document type is provided in the db, use it
	 * Otherwise, guess from extension or other means
	 */
	public function guessDocumentType()
	{
		// search supported type 
		$supported_types = $this::supportedTypes();
		$doc_type = 'unknown';
		
		if ($this->document_type == null || $this->document_type == '')
		{
			if (file_exists($this->getDocumentPath()))
			{
				// guess file type
				$finfo = finfo_open(FILEINFO_MIME_TYPE);
				$this->document_type = finfo_file($finfo, $this->getDocumentPath());
				finfo_close($finfo);
				$this->save();
			}
		}
		
		foreach ($supported_types as $type)
		{
			if (strstr($this->document_type, $type)) 
			{
				$doc_type = $type;
				break;
			}
		}
		
		return $doc_type;
		
	}
	
	/**
	 * return document icon based on its type
	 */
	public function getDocumentIcon()
	{
		$icon_filename = $this->guessDocumentType() . '.png';
		$icon_folder_url = Yii::app()->baseUrl . '/images/fileicons/32px/';
		$icon_file_path = $this->getApplicationRootDir() . 'images/fileicons/32px/' . $icon_filename;
		$icon_url = $icon_folder_url . $icon_filename;
		
		if (file_exists($icon_file_path))
		{
			return $icon_url ;
		} else {
			return $icon_folder_url . '_blank.png';
		}
	}
	
	/**
	 * return supported types
	 */
	public static function supportedTypes()
	{
		return array('png', 'jpeg', 'jpg', 'doc', 'xls', 'ppt', 'pptx', 'bmp', 'pdf', 'txt', 'rtf', 'zip',
				'msword', 'msexcel', 'docx', 'odt', 'xlsx', 'ods', 'sxc', 'xml', 'gzip', 'tar', 'bzip', 'rar',
                                'uml','umlj', 'dia','csv');
	}
	
	/**
	 * Get documents under a project
	 * this could be documents uploaded to project's tasks, issues, wiki or implementations
	 * Mostly used for displaying in grid view. But can be used for other purposes too.
	 * 
	 * @param integer $project_id
	 * @param array $parent_types_array 
	 * 			array of parent type codes as values e.g (DOCUMENT_PARENT_TYPE_TASK, DOCUMENT_PARENT_TYPE_ISSUE)
	 * 			If null, will look into tasks, task comments, issues, issue comments, implementations and wikis
	 * @param string $oder
	 * @return CActiveDataProvider $dataProvider data provider
	 */
	public function getDocuments($project_id, $parent_types_array = null, $order = 'document_date DESC')
	{
                // if not valid member, disallow
                if (!ProjectMember::model()->isValidMember($project_id, Yii::app()->user->id))
                {
                    return;
                }
                
		if ($parent_types_array == null)
		{
			$parent_types_array = array(
                            DOCUMENT_PARENT_TYPE_PROJECT,
                            DOCUMENT_PARENT_TYPE_TASK, DOCUMENT_PARENT_TYPE_TASK_COMMENT,
					DOCUMENT_PARENT_TYPE_ISSUE_COMMENT, DOCUMENT_PARENT_TYPE_WIKI_PAGE,
					DOCUMENT_PARENT_TYPE_IMPLEMENTATION);
		}
		
		// check if current user is project manager
		// if project manager, no assginment filtering is needed
		// otherwise, each filter must include a check to see if this user is assigned to that entity.
		$is_pm = ProjectMember::model()->isProjectManager($project_id, Yii::app()->user->id);
		$account_id = Yii::app()->user->id;
		
		$conditions = array();
		// for each parent type,
		// get documents
		foreach ($parent_types_array as $parent_type)
		{
			$assigned_check = '';
			switch($parent_type)
			{
                                case DOCUMENT_PARENT_TYPE_PROJECT:
                                    $conditions[] = "(t.document_parent_id = $project_id AND t.document_parent_type = '$parent_type')"; 
					
                                    break;
				case DOCUMENT_PARENT_TYPE_TASK:
					// if not PM, check if user is assigned to this task that this document belongs to.
					/**if (!$is_pm)
					{
						$assigned_check = " AND t1.task_id IN (SELECT task_id FROM task_assignees t1ta1
								WHERE account_id = $account_id) ";
					}**/
					$conditions[] = "(t.document_parent_id in 
										(SELECT task_id FROM ".Task::model()->tableName()." t1 
										WHERE t1.project_id = $project_id $assigned_check) 
									AND t.document_parent_type = '$parent_type')";
					break;
					
				case DOCUMENT_PARENT_TYPE_TASK_COMMENT:
					// if not PM, check if user is assigned to this task that this document belongs to.
					/**if (!$is_pm)
					{
						$assigned_check = " AND tc.task_id IN (SELECT task_id FROM task_assignees tc1ta1
						WHERE tc1ta1.account_id = $account_id) ";
					}**/
					$conditions[] = "(t.document_parent_id in 
										(SELECT task_comment_id FROM ".TaskComment::model()->tableName()." tc, ".Task::model()->tableName()." t1
										WHERE tc.task_id = t1.task_id AND t1.project_id = $project_id $assigned_check) 
									AND t.document_parent_type = '$parent_type')";
					break;
					
				case DOCUMENT_PARENT_TYPE_WIKI_PAGE:
					$conditions[] = "(t.document_parent_id in 
										(SELECT wiki_page_id FROM ".WikiPage::model()->tableName()." wp 
										WHERE wp.project_id = $project_id)
									AND t.document_parent_type = '$parent_type')";
					break;
				
				default:
					// do nothing
			}
			
		}
		
		$condition_clause = implode('OR', $conditions);
		
		$criteria=new CDbCriteria;
		//$criteria->compare('document_id',$this->document_id);
		$criteria->condition = $condition_clause; // MUST be before compare(), 
                if($this->document_real_name!="")
                {
                    $keyword_document_name = explode(',', $this->document_real_name);
                    foreach ($keyword_document_name as $value)
                    {
                        $criteria->compare('t.document_real_name', $value,true); // append to condition param
                    }
                }
                
		$criteria->order = $order;
		
		$dataProvider = new CActiveDataProvider($this, array(
			'criteria'=> $criteria,
		));
		
		return $dataProvider;
	}
	
	/**
	 * move file to new location
	 * filename in actual location will be encoded.
	 */
	public function moveToActualLocation()
	{
		$destination = '';
		$src = $this->getTempFolderPath() . $this->document_temp_name;
		
		if ($this->document_parent_type == DOCUMENT_PARENT_TYPE_TASK_COMMENT
				|| $this->document_parent_type == DOCUMENT_PARENT_TYPE_TASK)
		{
			// find destination to comment's task's folder
			$task = Task::model()->findByPk($this->document_task_id);
			$destination = $this->getTaskFolderPath($task);
		} else if ($this->document_parent_type == DOCUMENT_PARENT_TYPE_PROJECT) {
			$destination = $this->getProjectFolderPath($this->document_project_id);
		} else if ($this->document_parent_type == DOCUMENT_PARENT_TYPE_WIKI_PAGE) {
			$destination = $this->getWikiPageFolderPath($this->document_project_id);
		} 
		
		$destination .= '/' . $this->document_encoded_name;
		
		// move file to new location
		// filename in actual location will be encoded.
		return rename($src, $destination);
	}
	
	/**
	 * Actually delete this document's file in the file system on the server
	 */
	public function deleteFile()
	{
		if (file_exists($this->getDocumentPath()))
			return unlink($this->getDocumentPath());
		
		return true;
	}
	
	public function delete()
	{
		// check permission
		if (!Permission::checkPermission($this, PERMISSION_DOCUMENT_DELETE))
			return false;
		
		$this->deleteFile(); // remove file from file system
		return parent::delete();
	}
        
        /**
         * Check if this doc is an image.
         * 
         * @param type $doc_id
         * @return boolean
         */
        public function isImage($doc_id = 0)
        {
            $doc = $this;
            if ($doc_id > 0)
            {
                $doc = Documents::model()->findByPk($doc_id);
            }
            
            if ($doc !== null)
            {
                $doc_path = $doc->getDocumentPath();
                if (file_exists($doc_path) && !is_dir($doc_path) &&
                        filesize($doc_path))
                {
                    if (exif_imagetype($doc_path))
                        return true;
                }
            }
            
            return false;
        }
        
        /**
         * Get image type of this image doc
         * 
         * @param type $doc_id
         * @return string type of image according to Constants in : http://www.php.net//manual/en/function.exif-imagetype.php
         */
        public function getImageType($doc_id = 0)
        {
            $doc = $this;
            if ($doc_id > 0)
            {
                $doc = Documents::model()->findByPk($doc_id);
            }
            
            if ($doc !== null)
            {
                return exif_imagetype($doc->getDocumentPath());
            }
            
            return '';
        }

	public function findAllCommentDocuments($parent_id, $parent_type, $limit = 10)
	{
		$this->getDbCriteria()->mergeWith(array(
				'condition' => "document_parent_id = " . $parent_id . " AND document_parent_type = '" . $parent_type . "'",
				'order' => 'document_real_name ASC',
				'limit' => $limit,
		));
	
		return $this->findAll();
	}
	
	/**
	 * 
	 * @param unknown $wiki_page_id
	 * @return array all Document models belong to wiki page
	 */
	public function findAllWikiPageAttachments($wiki_page_id)
	{
		$this->getDbCriteria()->mergeWith(array(
				'condition' => "document_parent_id = " . $wiki_page_id . 
								" AND document_parent_type = '" . DOCUMENT_PARENT_TYPE_WIKI_PAGE . "'",
				'order' => 'document_real_name ASC, document_date DESC',
		));
		
		return $this->findAll();
	}
	
	/**
	 * 
	 * @param unknown $implementation_id
	 * @return array all Document models
	 */
	public function findAllImplementationAttachments($implementation_id)
	{
		$this->getDbCriteria()->mergeWith(array(
				'condition' => "document_parent_id = " . $implementation_id .
				" AND document_parent_type = '" . DOCUMENT_PARENT_TYPE_IMPLEMENTATION . "'",
				'order' => 'document_real_name ASC',
		));
		
		return $this->findAll();
	}
	
	public function searchByKeyword($keyword)
	{
		$parent_types = array(DOCUMENT_PARENT_TYPE_TASK_COMMENT, DOCUMENT_PARENT_TYPE_WIKI_PAGE);
		
		$account_id = Yii::app()->user->id;
		
		// is user the master account
		/**
		$subscription_id = AccountSubscription::model()->findSubscriptions($account_id, true);
		if (Account::model()->isMasterAccount($subscription_id, $account_id))
		{
			
		}**/
		
		// get all projects user is involved with
		// and get all task comments of tasks that user is assigned to
		$account_tasks_comments = array();
		$account_tasks_comments_ids = array('-10');
		$projects_wiki_pages_ids = array('-10');
		$active_projects = Project::model()->getActiveProjects($account_id,'datasourceArray');
		foreach ($active_projects as $project_id=>$project_name)
		{
			// get all tasks user is assigned to
			$tasks = Task::model()->getAccountTasks($account_id, $project_id, TASK_STATUS_ACTIVE, 'modelArray');
			
			// get comments
			foreach ($tasks as $task)
			{
				$task_comments = TaskComment::model()->getTaskComments($task->task_id);
				$account_tasks_comments += $task_comments;
				
				foreach ($task_comments as $task_cmt)
				{
					$account_tasks_comments_ids[] = $task_cmt->task_comment_id;
				}
			}
			
			// get all wikis
			$wiki_pages = WikiPage::model()->getProjectWikiPages($project_id, -1, 
					'wiki_page_date DESC, wiki_page_title ASC', true);
			foreach ($wiki_pages as $wiki)
			{
				$projects_wiki_pages_ids[] = $wiki->wiki_page_id;
			}
			// TODO:
			// get all issues user is assigned to
			// get all implementation user is assigned to
		}// end getting task comments
		
		// search in task comments;
		$task_documents = $this->findAll('document_parent_type = :parent_type 
				AND document_parent_id in ('.implode(',', $account_tasks_comments_ids).') AND LOWER(document_real_name) LIKE "%'.$keyword.'%"',
				array(':parent_type' => DOCUMENT_PARENT_TYPE_TASK_COMMENT));
		
		// search in wiki
		$project_wiki_documents = $this->findAll('document_parent_type = :parent_type 
				AND document_parent_id in ('.implode(',', $projects_wiki_pages_ids).') AND LOWER(document_real_name) LIKE "%'.$keyword.'%"',
				array(':parent_type' => DOCUMENT_PARENT_TYPE_WIKI_PAGE));
		/**
		$project_wiki_documents = $this->findAll('document_parent_type = :parent_type
				AND document_real_name LIKE "%'.$keyword.'%"',
				array(':parent_type' => DOCUMENT_PARENT_TYPE_WIKI_PAGE));**/
		
		return $task_documents + $project_wiki_documents;
		//return $project_wiki_documents;
	}
	
	/**
	 * Document is stored in the hard drive using encoded name
	 * so as to allow document with the same real name to exist
	 */
	public function encodeDocumentName() 
	{
		return md5($this->document_date . $this->document_real_name);
	}
	
	/**
	 * Obtain the full server path to this document, including its encoded name
	 */
	public function getDocumentPath()
	{
		$path = '';
		if ($this->document_parent_type == DOCUMENT_PARENT_TYPE_TASK_COMMENT)
		{
			$taskComment = TaskComment::model()->findByPk($this->document_parent_id);
			if ($taskComment)
			{
				$task = Task::model()->findByPk($taskComment->task_id);
				if ($task)
				{
					$path = $this->getTaskFolderPath($task);
					$path .= $this->document_encoded_name;
					return $path;
				}
			}
		} else if ($this->document_parent_type == DOCUMENT_PARENT_TYPE_WIKI_PAGE) {
			$wikiPage = WikiPage::model()->findByPk($this->document_parent_id);
			$path = $this->getWikiPageFolderPath($wikiPage->project_id);
			$path .= $this->document_encoded_name;
			return $path;	
		} else if ($this->document_parent_type == DOCUMENT_PARENT_TYPE_PROJECT) {
			$path = $this->getProjectFolderPath($this->document_parent_id);
			$path .= $this->document_encoded_name;
			return $path;	
		}
		
		return '';
	}
	
	/**
	 * Get path to project's folder, absolute from system root /
	 * @param	string	 	$project_id	Project ID
	 * @return	string		$path	path with trailing slashes
	 */
	public function getProjectFolderPath($project_id)
	{
		$folder_path = $this->getApplicationRootDir() . Yii::app()->params['documentRootDir'] . 'p_' . $project_id . '/';
		
		// if folder doesn't exist, create
		if (!file_exists($folder_path))
		{
			mkdir($folder_path);
		}
		
		return $folder_path;
	}
	
	/**
	 * Get path to task's folder, absolute from system root /
	 * @param Task $task	Task Model
	 * @return string $path	path with  trailing slashes
	 */
	public function getTaskFolderPath($task)
	{
		$folder_path = $this->getProjectFolderPath($task->project_id) . $task->task_id . '/';
		// if folder doesn't exist, create
		if (!file_exists($folder_path))
		{
			mkdir($folder_path);
		}
		
		return $folder_path;
	}
	
	public function getWikiPageFolderPath($project_id)
	{
		$folder_path = $this->getProjectFolderPath($project_id) . 'wiki/';
		
		// if folder doesn't exist, create
		if (!file_exists($folder_path))
		{
			mkdir($folder_path);
		}
		
		return $folder_path;
	}
	
	/**
	 * Get absolute path to temp upload folder
	 * @return	string	$path	Path with trailing slash
	 */
	public function getTempFolderPath()
	{
		$path = $this->getApplicationRootDir() . Yii::app()->params['documentRootDir'] . 'temp_upload/';
		
		return $path;
	}
	
	/**
	 * Get absolute path to application root
	 * @return	string	$path	Path with trailing slash
	 */
	public function getApplicationRootDir()
	{
		$path = pathinfo(Yii::app()->request->scriptFile);
		
		return $path['dirname'] . '/';
	}
        
        /**
         * 
         * Return the name of the document entity (task name, or issue name, or implementation name, etc.)
         * @param type $doc_id
         * @return string entity name
         */
        public function getDocumentEntityName($doc_id = NULL)
        {
            $document = $this;
            if ($doc_id)
            {
                $document = Documents::model()->findByPk($doc_id);
            }
            
            // for each case, retrieve data accordingly
            $parent_id = $document->document_parent_id;
            switch ($document->document_parent_type) 
            {
                case DOCUMENT_PARENT_TYPE_TASK_COMMENT:
                    // get task comment
                    $taskComment = TaskComment::model()->findByPk($parent_id);
                    
                    // get task
                    if ($taskComment && $taskComment->task_id)
                    {
                        $task = Task::model()->findByPk($taskComment->task_id);
                        if ($task) {
                            return $task->getURLEncodedTaskName();
                        }
                    }
                    break;
                case DOCUMENT_PARENT_TYPE_WIKI_PAGE:
                    // get wiki page
                    $wikiPage = WikiPage::model()->findByPk($parent_id);
                    if ($wikiPage)
                    {
                        return $wikiPage->getURLEncodedWikiPageTitle();
                    }
                    break;
                default :
                    return '';
            }
        }
        
        /**
         * GET the url of the document entity (task, issue, impl, wiki,...)
         * @param type $doc_id
         * @return array URL of entity
         */
        public function getDocumentEntityURL($doc_id = null) 
        {            
            $document = $this;
            if ($doc_id)
            {
                $document = Documents::model()->findByPk($doc_id);
            }
            
            // for each case, retrieve data accordingly
            $parent_id = $document->document_parent_id;
            switch ($document->document_parent_type) 
            {
                case DOCUMENT_PARENT_TYPE_TASK_COMMENT:
                    // get task comment
                    $taskComment = TaskComment::model()->findByPk($parent_id);
                    
                    // get task
                    if ($taskComment && $taskComment->task_id)
                    {
                        $task = Task::model()->findByPk($taskComment->task_id);
                        if ($task) {
                            return $task->getTaskURL();
                        }
                    }
                    break;
                case DOCUMENT_PARENT_TYPE_WIKI_PAGE:
                    // get wiki page
                    $wikiPage = WikiPage::model()->findByPk($parent_id);
                    if ($wikiPage)
                    {
                        return $wikiPage->getWikiPageURL();
                    }
                    break;
                default :
                    return array('#');
            }
        }
}