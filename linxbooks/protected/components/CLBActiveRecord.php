<?php

/**
 * Lion and Lamb Soft Pte Ltd (c) 2013
 *
 * @author    joseph
 * @version   1.0
 * @copyright Lion and Lamb Soft Pte Ltd
 */
class CLBActiveRecord extends CActiveRecord {
    // Attributes
    /**
     * Datasource for dropdownList or activeDropdownList
     *
     * @var    const $LB_QUERY_RETURN_TYPE_DROPDOWN_ARRAY
     * @access public
     */
    const LB_QUERY_RETURN_TYPE_DROPDOWN_ARRAY = 'DropdownArray';

    /**
     * XXX
     *
     * @var    const $LB_QUERY_RETURN_TYPE_ACTIVE_DATA_PROVIDER
     * @access public
     */
    const LB_QUERY_RETURN_TYPE_ACTIVE_DATA_PROVIDER = 'ActiveDataProvider';

    /**
     * XXX
     *
     * @var    const $LB_QUERY_RETURN_TYPE_MODELS_ARRAY
     * @access public
     */
    const LB_QUERY_RETURN_TYPE_MODELS_ARRAY = 'ModelArray';

    /**
     * XXX
     *
     * @var    const $LB_QUERY_RETURN_TYPE_DATASOURCE_JSON
     * @access public
     */
    const LB_QUERY_RETURN_TYPE_DATASOURCE_JSON = 'DataSourceJSON';

    /**
     * The object that represents the core entity record of this model in the database
     * 
     * @var LbCoreEntity
     */
    private $coreEntity = null;
    
    /**
     * the value of the primary key of this record in the database
     *
     * @var    int $lb_record_primary_key
     * @access public
     */
    var $lb_record_primary_key;

    /**
     * Usually use this for dropdown box's item name
     *
     * @var    string $record_title_column_name
     * @access public
     */
    var $record_title_column_name;
    
    /**
     * Name of the module that this model belongs to
     * 
     * @var string
     */
    var $module_name = '';
    
    const RECORD_LOCKED_FROM_DELETION = 1;
    const RECORD_NOT_LOCKED_FROM_DELETION = 0;
    const CURRENCY_SYMBOL = '$';
    
    const LB_NUMBER_MAX_LENGTH = 11;

    public function __construct($scenario = 'insert')
    {
    	parent::__construct($scenario);
    	
    	//$defaultControllerName = get_class($this) . 'Controller';
    	//echo $defaultControllerName . '-';
    	//$defaultController = new $defaultControllerName($this->getEntityType());
    	if ($this->module_name == null)
	    	$this->module_name = $this->getEntityType();
    }
    
    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return LbCoreEntity the static model class
     */
    public static function model($className=__CLASS__)
    {
    	return parent::model($className);
    }

    /**
     * besides deleting record
     * deletes its core entity as well
     *
     * @return bool|void
     */
    public function delete()
    {
        $id = $this->lb_record_primary_key;
        $coreEntity = $this->getCoreEntity();
        $result = parent::delete();
        if ($result)
        {
            $coreEntity->delete();
        }

        return $result;
    }
    
    /**
     * Get entity type of this model. It's the class name of this model, 
     * with first character being converted to lowercase
     * 
     * @return string
     */
    public function getEntityType()
    {
    	return lcfirst(get_class($this));
    }
    
    /**
     * Get core entity of this object, that contains core information 
     * such as creation date, subscription, etc.
     */
    public function getCoreEntity()
    {
    	if ($this->coreEntity == null)
    	{
    		$this->coreEntity = LbCoreEntity::model()->getCoreEntity($this->getEntityType(), $this->lb_record_primary_key);
    	}
    	return $this->coreEntity;
    } 
    
    /**
     * Get all records of this entity type, that is 
     * already joined with core information such as creation date, subscription id
     * from LbCoreEntity
     * 
     * @param CDbCriteria $criteria additional criteria
     * @param array	$params	params for binding with param in $criteria
     * @return array array of models
     */
    public function getFullRecords($criteria = null, $params = null)
    {
    	$criteria=$this->getFullRecordCommonCriteria($criteria);
    	
    	return $this->findAll($criteria, $params);
    }
    
    /**
     * Get all records of this entity type, that is
     * already joined with core information such as creation date, subscription id
     * from LbCoreEntity
     *
     * @param CDbCriteria $criteria additional criteria
     * @param array	$params	params for binding with param in $criteria
     * @return CActiveDataProvider results as data provider 
     */
    public function getFullRecordsDataProvider($criteria = null, $params = null, $pageSize=20, $user_id=false)
    {
    	$criteria=$this->getFullRecordCommonCriteria($criteria,$user_id);
    	 
    	return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array(
                            'pageSize'=>$pageSize,
                        ),
		));
    }
    
    /**
     * Get criteria necessary to get a full record, which includes all ownership info.
     * 
     * @param string $criteria
     * @return Ambigous <string, CDbCriteria>
     */
    private function getFullRecordCommonCriteria($criteria = null,$user_id=false)
    {
    	if ($criteria == null)
	    	$criteria=new CDbCriteria();
    	
    	$criteria->join = "LEFT JOIN lb_core_entities c ON lb_entity_type = '" . $this->getEntityType() . "'" .
    			" AND c.lb_entity_primary_key = t.lb_record_primary_key";
        if($user_id)
            $criteria->join.=' AND c.lb_created_by = '.$user_id;
        
        $criteria->compare('c.lb_subscription_id', LBApplication::getCurrentlySelectedSubscription());
        
    	
    	return $criteria;
    }
    
    // Associations
    // Operations
    /**
     * get friendly url for viewing record array('subscription/module/entity_type/id-title?param1=val1&...')
     * 
     * @param  string $title a title to represent this record (for friendliness)
     * @param  array $params extra params if any
     * @return array url in array format
     * @access public
     */
    function getViewURL($title, $params = null,$id=false) {
    	// clean the title 
    	$title = LBApplication::getURLEncodedString($title);
    	
    	$url = '/'.LBApplication::getCurrentlySelectedSubscription() .'/'
    			. $this->module_name . "/{$this->lb_record_primary_key}-$title";
        if($id)
        {
            $url = '/'.LBApplication::getCurrentlySelectedSubscription() .'/'
    			. $this->module_name . "/{$id}-$title";
        };
    	
    	// add params if available
    	if (is_array($params) && count($params))
    	{
    		$url .= '?';
    		foreach ($params as $param_=>$val)
    		{
    			$url .= "$param_=$val&";
    		}
    	}
    	
    	return array($url);
        //trigger_error('Not Implemented!', E_USER_WARNING);
    }

    /**
     * get normalized friendly url for viewing record
     * 
     * @param  string $title title that represents this record (friendliness)
     * @param  array $params extra params
     * @return string the url
     * @access public
     */
    function getViewURLNormalized($title, $params = null) {
    	return CHtml::normalizeUrl($this->getViewURL($title, $params));
        //trigger_error('Not Implemented!', E_USER_WARNING);
    }

    /**
     * get friendly url for creating record
     * 
     * @return array url array array('subscription_id/module/entity_type/new');
     * @access public
     */
    function getCreateURL($params = null) {
    	$url ='/'.LBApplication::getCurrentlySelectedSubscription() . '/' . $this->module_name
    			. '/create';
    	
    	// add params if available
    	if (is_array($params) && count($params))
    	{
    		$url .= '?';
    		foreach ($params as $param_=>$val)
    		{
    			$url .= "$param_=$val&";
    		}
    	}
    	 
    	return array($url);
        //trigger_error('Not Implemented!', E_USER_WARNING);
    }

    /**
     * get normalized friendly url for creating new record
     * 
     * @return string url
     * @access public
     */
    function getCreateURLNormalized($params = null) {
    	return CHtml::normalizeUrl($this->getCreateURL($params));
        //trigger_error('Not Implemented!', E_USER_WARNING);
    }

    /**
     * get friendly url for deleting record
     * 
     * @param  int $id record id
     * @return array url in array format
     * @access public
     */
    function getDeleteURL($id) {
    	return array('/'.LBApplication::getCurrentlySelectedSubscription() . '/'
    			. $this->module_name . '/delete/' . $id);
        //trigger_error('Not Implemented!', E_USER_WARNING);
    }

    /**
     * get normalized friendly url for deleting record
     * 
     * @param  int $id record id
     * @return string url
     * @access public
     */
    function getDeleteURLNormalized($id) {
    	return CHtml::normalizeUrl($this->getDeleteURL($id));
        //trigger_error('Not Implemented!', E_USER_WARNING);
    }
    
    /**
     * Get the url of the index page of this module.
     * @return array url in array format
     * @access public
     */
    function getIndexURL()
    {
    	return array('/'.LBApplication::getCurrentlySelectedSubscription() . '/'
    			. $this->module_name . '/index');
    }
    
    /**
     * Get the normlized url of index page of this module.
     * @return string url
     * @access public
     */
    function getIndexURLNormalized()
    {
    	return CHtml::normalizeUrl($this->getIndexURL());
    }
    
    /**
     * Get the url of the admin page of this module.
     * @return array url in array format
     * @access public
     */
    function getAdminURL()
    {
    	return array('/'.LBApplication::getCurrentlySelectedSubscription() . '/'
    			. $this->module_name . '/admin');
    }
    
    
    /**
     * Get the normlized url of admin page of this module.
     * @return string url
     * @access public
     */
    function getAdminURLNormalized()
    {
    	return CHtml::normalizeUrl($this->getAdminURL());
    }
    
    /**
     * Get the url of the home page of this module.
     * @return array url in array format
     * @access public
     */
    function getHomeURL()
    {
    	return array('/'.LBApplication::getCurrentlySelectedSubscription() . '/'
    			. $this->module_name . '/admin');
    }
    
    
    /**
     * Get the normlized url of home page of this module.
     * @return string url
     * @access public
     */
    function getHomeURLNormalized()
    {
    	return CHtml::normalizeUrl($this->getHomeURL());
    }
    
    /**
     * Get the url of any action we want
     * 
     * @param unknown $action
     * @param array $params
     * @return multitype:string
     */
    function getActionURL($action, $params = null)
    {
    	$url = '/'.LBApplication::getCurrentlySelectedSubscription() . '/'
    			. $this->module_name . '/'.$action;
    	
    	// add params if available
    	if (is_array($params) && count($params))
    	{
    		$url .= '?';
    		foreach ($params as $param_=>$val)
    		{
    			$url .= "$param_=$val&";
    		}
    	}
    	
    	return array($url);
    }
    
    /**
     * Get the normlized url of action
     * 
     * @param unknown $action
     * @param array $params
     * 
     * @return string url
     * @access public
     */
    function getActionURLNormalized($action, $params = null)
    {
    	return CHtml::normalizeUrl($this->getActionURL($action, $params));
    }

    /**
     * check if this record is really with the subscription that it claims to be
     * 
     * 
     * @return boolean true or false
     * @access public
     */
    function isMatchedCurrentSubscription() {
    	$current_subscription = LBApplication::getCurrentlySelectedSubscription();
    	
    	if ($current_subscription == $this->getSubscriptionID())
    		return true;
    	
    	return false;
    	
        //trigger_error('Not Implemented!', E_USER_WARNING);
    }

    /**
     * Get the user id of the owner of the subscription that this model belongs to
     * This method is useful for determining ownership of a record.
     * 
     * @return int Account ID of the owner
     * @access public
     */
    function getSubscriptionOwnerAccountID() {
    	$coreEntity = $this->getCoreEntity();
    	
    	if ($coreEntity)
    	{
    		$subscription_id = $coreEntity->lb_subscription_id;
    		$accountSubscription = AccountSubscription::model()->findByPk($subscription_id);
    		
    		// return user account id
    		if ($accountSubscription)
    			return $accountSubscription->account_id;
    	}
    	
    	return 0;
    }

    /**
     * Save record to the database (update/add)
     * Basically, this parent method covers basic fields that the children shouldn't need to care.
     * These are: created date, created by, last update date, last updated by, subscription id, etc.
     * 
     * @return boolean success or failure of the operation
     * @access public
     */
    function save($runValidation = true, $attributes = NULL) {
    	$new_record = $this->isNewRecord;
    	$now = date('Y-m-d H:i:s');
    	
    	$result = parent::save($runValidation, $attributes);
    	
    	if ($result)
    	{
    		/**
    		 * set values for new record in CoreEntity
    		 */
    		$coreEntity = $this->getCoreEntity();
    		if ($new_record || $coreEntity === null)
    		{
    			$coreEntity = new LbCoreEntity();
    			$coreEntity->lb_entity_type = $this->getEntityType();
    			$coreEntity->lb_entity_primary_key = $this->lb_record_primary_key;
    			$coreEntity->lb_created_by = Yii::app()->user->id;
    			$coreEntity->lb_created_date = $now;
    		} else {
    			
    		}
    		
    		$coreEntity->lb_last_updated_by = Yii::app()->user->id;
    		$coreEntity->lb_last_update = $now;
    		$coreEntity->lb_subscription_id = LBApplication::getCurrentlySelectedSubscription();
    		$coreEntity->lb_locked_from_deletion = self::RECORD_NOT_LOCKED_FROM_DELETION;
    		$coreEntity->save();
    	}
    	
    	return $result;
    }

    /**
     * XXX
     * 
     * @param  string $permission_code XXX
     * @return boolean XXX
     * @access public
     */
    function checkPermission($permission_code) {
        trigger_error('Not Implemented!', E_USER_WARNING);
    }

    /**
     * Return the id of the user who created this record
     * 
     * @return int user account id of creator
     * @access public
     */
    function getCreatedBy() {
    	$coreEntity = $this->getCoreEntity();
    	if ($coreEntity)
    	{
    		return $coreEntity->lb_created_by;
    	}
    	
    	return 0;
        //trigger_error('Not Implemented!', E_USER_WARNING);
    }

    /**
     * get created date of this record
     * 
     * @param  string $date_format 'Y-m-d H:i:s'
     * @return string date time of creation
     * @access public
     */
    function getCreatedDate($date_format = LBApplication::DATE_FORMAT_SQL_DATETIME) {
    	$coreEntity = $this->getCoreEntity();
    	if ($coreEntity)
    	{
    		return LBApplication::formatDisplayDate($coreEntity->lb_created_date, $date_format);
    	}
    	 
    	return '';
    	
        //trigger_error('Not Implemented!', E_USER_WARNING);
    }

    /**
     * get user id of the person who last updated this record
     * 
     * @return int user id
     * @access public
     */
    function getLastUpdatedBy() {
    	$coreEntity = $this->getCoreEntity();
    	if ($coreEntity)
    	{
    		return $coreEntity->lb_last_updated_by;
    	}
    	
    	return 0;
        //trigger_error('Not Implemented!', E_USER_WARNING);
    }

    /**
     * get the date of last update
     * 
     * @param   $date_format by default is SQL Datetime format 'Y-m-d H:i:s'
     * @return string formated date 
     * @access public
     */
    function getLastUpdate($date_format = LBApplication::DATE_FORMAT_SQL_DATETIME) {
    	$coreEntity = $this->getCoreEntity();
    	if ($coreEntity)
    	{
    		return LBApplication::formatDisplayDate($coreEntity->lb_last_update, $date_format);
    	}
    	
    	return '';
        //trigger_error('Not Implemented!', E_USER_WARNING);
    }

    /**
     * Get the ID of the subscription that this record belongs to
     * 
     * @return int subscription id
     * @access public
     */
    function getSubscriptionID() {
    	$coreEntity = $this->getCoreEntity();
    	 
    	if ($coreEntity)
    	{
    		return $coreEntity->lb_subscription_id;
    	}
    	 
    	return 0;
    	
        //trigger_error('Not Implemented!', E_USER_WARNING);
    }

    /**
     * Check if this record is locked from deletion or not
     * 
     * @return null if no record found. binary if found, use const param for this: 
     * 			CLBActiveRecord::RECORD_LOCKED_FROM_DELETION, RECORD_NOT_LOCKED_FROM_DELETION
     * 
     * @access public
     */
    function getLockedFromDeletion() {
    	$coreEntity = $this->getCoreEntity();
    	
    	if ($coreEntity)
    	{
    		return $coreEntity->lb_locked_from_deletion;
    	}
    	
    	return null;
    	
        //trigger_error('Not Implemented!', E_USER_WARNING);
    }

    /**
     * set locked status of this record
     * 
     * @param  binary $locked_from_deletion lock it or not to lock it. Check class const: 
     * 										RECORD_LOCKED_FROM_DELETION,
     * 										RECORD_NOT_LOCKED_FROM_DELETION
     * @return void nothing to return
     * @access public
     */
    function setLockedFromDeletion($locked_from_deletion) {
    	$coreEntity = $this->getCoreEntity();
    	 
    	if ($coreEntity)
    	{
    		$coreEntity->lb_locked_from_deletion == $locked_from_deletion;
    		$coreEntity->save();
    	}
    	
        //trigger_error('Not Implemented!', E_USER_WARNING);
    }

    /**
     * Based on requested return type, return the data
     * 
     * @param CActiveDataProvider $dataProvider
     * @param mixed $return_type
     */
    function getResultsBasedForReturnType($dataProvider, $return_type = self::LB_QUERY_RETURN_TYPE_ACTIVE_DATA_PROVIDER)
    {
    	switch($return_type)
    	{
    		case self::LB_QUERY_RETURN_TYPE_ACTIVE_DATA_PROVIDER:
    			return $dataProvider;
    			
    		case self::LB_QUERY_RETURN_TYPE_MODELS_ARRAY:
    			$dataProvider->setPagination(false);
    			return $dataProvider->getData();
    			
    		case self::LB_QUERY_RETURN_TYPE_DATASOURCE_JSON:
                return $this->getResultsAsDatasourceJSON($dataProvider);
    			
    		case self::LB_QUERY_RETURN_TYPE_DROPDOWN_ARRAY:
                return $this->getResultsAsDropDownArray($dataProvider);
    			
    		default:
    			return $dataProvider;
    	}
    }

    /**
     * Return result as datasource for json
     *
     * @param $dataProvider
     * @return array
     */
    public function getResultsAsDatasourceJSON($dataProvider)
    {
        $dataProvider->setPagination(false);
        $data = $dataProvider->getData();
        $json_result = array();
        foreach ($data as $item)
        {
            $json_result[$item->lb_record_primary_key] = $item->{$this->record_title_column_name};
        }
        return CJSON::encode($json_result);
    }

    /**
     * Get results as an array of data as dropdown source
     *
     * @param $dataProvider
     * @return array (primary key => title column's value,...)
     */
    public function getResultsAsDropDownArray($dataProvider)
    {
        $dataProvider->setPagination(false);
        $data = $dataProvider->getData();
        $dropdown_array = array();
        foreach ($data as $item)
        {
            $dropdown_array[$item->lb_record_primary_key] = $item->{$this->record_title_column_name};
        }
        return $dropdown_array;
    }
    function getPDFURL($id){
       //$title = $this->customer->lb_customer_name;
       return array('/'.LBApplication::getCurrentlySelectedSubscription() .'/'
                .$this->module_name . '/pdf/' . $id);

    }
    function getPDFURLNormalied($id){
        return CHtml::normalizeUrl($this->getPDFURL($id));
    }
    function getViewURLById($id,$title, $params = null) {
    	// clean the title 
    	$title = LBApplication::getURLEncodedString($title);
    	
    	$url = '/'.LBApplication::getCurrentlySelectedSubscription() .'/'
    			. $this->module_name . "/{$id}-$title";
    	
    	// add params if available
    	if (is_array($params) && count($params))
    	{
    		$url .= '?';
    		foreach ($params as $param_=>$val)
    		{
    			$url .= "$param_=$val&";
    		}
    	}
    	
    	return array($url);
        //trigger_error('Not Implemented!', E_USER_WARNING);
    }
    
    function getViewURLByIdNormalized($id,$title, $params = null)
    {
    	return CHtml::normalizeUrl($this->getViewURLById($id,$title, $params = null));
    }
    
        function getViewInvoiceURL($id,$title, $params = null) {
    	// clean the title 
    	$title = LBApplication::getURLEncodedString($title);
    	
    	$url = '/'.LBApplication::getCurrentlySelectedSubscription() .'/'
    			. $this->module_name . "/{$id}-$title";
    	
    	// add params if available
    	if (is_array($params) && count($params))
    	{
    		$url .= '?';
    		foreach ($params as $param_=>$val)
    		{
    			$url .= "$param_=$val&";
    		}
    	}
    	
    	return array($url);
        //trigger_error('Not Implemented!', E_USER_WARNING);
    }
    
    // Associations
    // Operations
    /**
     * get friendly url for viewing record array('subscription/module/entity_type/id-title?param1=val1&...')
     * 
     * @param  string $title a title to represent this record (for friendliness)
     * @param  array $params extra params if any
     * @return array url in array format
     * @access public
     */
    function getViewParamModuleURL($title, $params = null,$id=false,$modules) {
    	// clean the title 
    	$title = LBApplication::getURLEncodedString($title);
    	
    	$url = '/'.LBApplication::getCurrentlySelectedSubscription() .'/'
    			. $modules . "/{$this->lb_record_primary_key}-$title";
        if($id)
        {
            $url = '/'.LBApplication::getCurrentlySelectedSubscription() .'/'
    			. $modules . "/{$id}-$title";
        };
    	// add params if available
    	if (is_array($params) && count($params))
    	{
    		$url .= '?';
    		foreach ($params as $param_=>$val)
    		{
    			$url .= "$param_=$val&";
    		}
    	}
    	
    	return array($url);
        //trigger_error('Not Implemented!', E_USER_WARNING);
    }
    
    /**
     * Get one records of this entity type, that is 
     * already joined with core information such as creation date, subscription id
     * from LbCoreEntity
     * 
     * @param CDbCriteria $criteria additional criteria
     * @param array	$params	params for binding with param in $criteria
     * @return array array of models
     */
    public function getOneRecords($criteria = null, $params = null)
    {
    	$criteria=$this->getFullRecordCommonCriteria($criteria);
    	
    	return $this->find($criteria, $params);
    }
    
    /**
     * Get the url of any action module we want
     * 
     * @param unknown $action
     * @param array $params
     * @return multitype:string
     */
    function getActionModuleURL($controller,$action, $params = null)
    {
    	$url = '/'.LBApplication::getCurrentlySelectedSubscription() . '/'
    			. $this->module_name .'/'.$controller.'/'.$action;
    	
    	// add params if available
    	if (is_array($params) && count($params))
    	{
    		$url .= '?';
    		foreach ($params as $param_=>$val)
    		{
    			$url .= "$param_=$val&";
    		}
    	}
    	
    	return array($url);
    }
    
    /**
     * Get the normlized url of action module
     * 
     * @param unknown $action
     * @param array $params
     * 
     * @return string url
     * @access public
     */
    function getActionModuleURLNormalized($controller,$action, $params = null)
    {
    	return CHtml::normalizeUrl($this->getActionModuleURL($controller,$action, $params));
    }
    
    function getViewModuleURL($controller,$id,$title, $params = null) {
    	// clean the title 
    	$title = LBApplication::getURLEncodedString($title);
    	
    	$url = '/'.LBApplication::getCurrentlySelectedSubscription() .'/'
    			. $this->module_name ."/".$controller."/{$id}-$title";
    	
    	// add params if available
    	if (is_array($params) && count($params))
    	{
    		$url .= '?';
    		foreach ($params as $param_=>$val)
    		{
    			$url .= "$param_=$val&";
    		}
    	}
    	
    	return array($url);
        //trigger_error('Not Implemented!', E_USER_WARNING);
    }
    
    function getViewModuleURLNormalized($controller,$id,$title, $params = null)
    {
        return CHtml::normalizeUrl($this->getViewModuleURLNormalized($controller, $id, $title, $params));
    }
    
    function formatNumberNextNumFormatted($number_int,$value_default='Draft')
    {
        if($number_int==0)
        {
            return $value_default;
        }
            // get int value of next number
            // get its length
            $number_len = strlen($number_int);

        // prefix with "I-yyyy"
        $created_year = date('Y');
                $next_quotation_number = "Q-".$created_year;
                $preceding_zeros_count = self::LB_NUMBER_MAX_LENGTH - strlen($created_year) - $number_len;
                while($preceding_zeros_count > 0)
                {
                        $next_number .= '0';
                        $preceding_zeros_count--;
                }
                $next_number .= $number_int;

                return $next_number;
    }
    
}
