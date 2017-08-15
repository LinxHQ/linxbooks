<?php

/**
 * This is the model class for table "resources".
 *
 * The followings are the available columns in table 'resources':
 * @property integer $resource_id
 * @property integer $account_subscription_id
 * @property integer $project_id
 * @property string $resource_title
 * @property string $resource_url
 * @property string $resource_description
 * @property integer $resource_created_by
 * @property string $resource_created_date
 * @property string $resource_space
 */
class Resource extends CActiveRecord
{
	const RESOURCE_SPACE_PRIVATE = 'PRIVATE';
	const RESOURCE_SPACE_PUBLIC = 'PUBLIC';
	public $resource_assigned_lists;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Resource the static model class
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
		return 'lb_project_resources';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('account_subscription_id, resource_url, resource_created_by, resource_created_date, resource_space', 'required'),
			array('account_subscription_id, resource_created_by, project_id', 'numerical', 'integerOnly'=>true),
			array('resource_url, resource_description, resource_title', 'length', 'max'=>255),
			array('resource_space', 'length', 'max'=>60),
			array('resource_assigned_lists', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('resource_id, account_subscription_id, project_id, resource_title, resource_url, resource_description, resource_created_by, resource_created_date, resource_space', 'safe', 'on'=>'search'),
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
				'assigned_lists' => array(self::HAS_MANY, 'ResourceAssignedList', 'resource_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'resource_id' => 'Resource',
			'account_subscription_id' => 'Account Subscription',
			'resource_title' => 'Title',
			'resource_url' => 'URL',
			'resource_description' => 'Description',
			'resource_created_by' => 'Resource Created By',
			'resource_created_date' => 'Resource Created Date',
			'resource_space' => 'Availability',
			'resource_assigned_lists'=>'Lists',
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

		$criteria->compare('resource_id',$this->resource_id);
		$criteria->compare('account_subscription_id',$this->account_subscription_id);
		$criteria->compare('resource_url',$this->resource_url,true);
		$criteria->compare('resource_description',$this->resource_description,true);
		$criteria->compare('resource_created_by',$this->resource_created_by);
		$criteria->compare('resource_created_date',$this->resource_created_date,true);
		$criteria->compare('resource_space',$this->resource_space);
		$criteria->compare('project_id',$this->project_id);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function save($runValidation=true, $attributes=NULL)
	{
		$isNewRecord = $this->isNewRecord;
		
		// add some auto fields for new record
		if ($isNewRecord)
		{
			// check perm
			if (!Permission::checkPermission($this, Permission::PERMISSION_RESOURCE_LINK_CREATE))
			{
				$this->addError('resource_title', 'You are not authorized to perform this action');
				return false;
			}
			
			$this->resource_created_by = Yii::app()->user->id;
			$this->resource_created_date = date('Y-m-d H:i:s');
		} else {
			// check perm
			if (!Permission::checkPermission($this, Permission::PERMISSION_RESOURCE_LINK_UPDATE))
			{
				$this->addError('resource_title', 'You are not authorized to perform this action');
				return false;
			}
		}
		
		// if resource space is not selected, assume it's private
		if ($this->resource_space == null)
		{
			$this->resource_space = Resource::RESOURCE_SPACE_PRIVATE;
		}
		
		// clean up params
		$this->resource_url = $this->stripURLHttpPart();
		
		$result = parent::save($runValidation, $attributes);
		
		return $result;
	}
	
	public function delete()
	{
		// check perm
		if (!Permission::checkPermission($this, Permission::PERMISSION_RESOURCE_LINK_DELETE))
		{
			$this->addError('resource_title', 'You are not authorized to perform this action');
			return false;
		}
		
		return parent::delete();
	}
	
	/**
	 * Get CActiveDataProvider that contains all links, of a project
	 * @param integer $project_id, if < 0, get everything for this subscription
	 * @param integer $list_id, if <= 0, get everything for this subscription, and project
	 * @param string $order	order of result, default  ''
	 * @param string $get_data default to false, if true, return array of model instead of CActiveDataProvider
	 */
	public function getResources($project_id, $list_id = 0, $order = 'resource_title ASC', $get_data = false)
	{
		$subscriptions_ids = array();
		// if currently selected sub is available
		// only load its links
		if (Utilities::getCurrentlySelectedSubscription())
		{
			$subscriptions_ids[]=Utilities::getCurrentlySelectedSubscription();
		} else {
			// find subscription
			$subscriptions = AccountSubscription::model()->findSubscriptions(Yii::app()->user->id);
			if (count($subscriptions) < 1) return;
				
			foreach ($subscriptions as $sub_id => $sub)
			{
				$subscriptions_ids[] = $sub_id;
			}
		}
	
		// only show link under this subscription.
		$condition = " account_subscription_id in (". implode(',', $subscriptions_ids) .") ";
	
		if ($project_id > 0)
		{
			$condition .= " AND project_id = $project_id";
		}
		
		// filter by list?
		$join='';
		if ($list_id)
		{
			$join .= " INNER JOIN resource_assigned_lists ON (resource_assigned_lists.resource_id=t.resource_id".
					" AND resource_assigned_lists.resource_user_list_id = $list_id)";
		}
	
		$criteria = array(
				'select' => '*',
				'condition' =>  $condition ,
				'join'=>$join,
				'order' => $order,
		);
		$dataProvider = new CActiveDataProvider('Resource');
		$dataProvider->setCriteria($criteria);
	
		if ($get_data == true)
		{
			$dataProvider->setPagination(false);
			return $dataProvider->getData();
		}
	
		return $dataProvider;
	}
	
	/**
	 * search for resources by keyword
	 * @param string $keyword
	 * @return array Array of Resource models found.
	 */
	public function searchByKeyword($keyword)
	{
		$keyword = strtolower($keyword); // convert to lower case
		$results = array();
	
		// get all resources that this user is allowed to see
		$resources = $this->getResources(0,0,'resource_title ASC', true);
	
		foreach ($resources as $link)
		{
			if (mb_strpos(strtolower($link->resource_title), $keyword) !== false
					|| mb_strpos(strtolower($link->resource_url), $keyword) !== false
					|| mb_strpos(strtolower($link->resource_description), $keyword) !== false)
			{
				$results[] = $link;
			}
		}
	
		return $results;
	}
	
	/**
	 * count number of occurences of a $needle in this resource
	 *
	 * @param string $needle
	 * @param number $resource_id
	 */
	public function countMatches($needle, $resource_id = 0)
	{
		$needle = strtolower($needle);
		$resource = $this;
		if ($resource_id > 0)
		{
			$resource = $this->findByPk($resource_id);
		}
	
		$count = 0;
		$count += substr_count(strtolower($resource->resource_title), $needle);
		$count += substr_count(strtolower($resource->resource_url), $needle);
		$count += substr_count(strtolower($resource->resource_description), $needle);
	
		return $count;
	}
	
	/**
	 * As a security measure
	 * This helps check if this resource is matched with currently viewed subscription.
	 *
	 * @return boolean
	 */
	public function matchedCurrentSubscription()
	{
		$current_subscription = Utilities::getCurrentlySelectedSubscription();
	
		if ($current_subscription == $this->account_subscription_id)
			return true;
	
		return false;
	}
	
	public function getDisplayTitle($resource_id = 0)
	{
		$resource = $this;
		if ($resource_id > 0)
		{
			$resource = Resource::model()->findByPk($resource_id);
		}
		
		$str = '';
		if ($resource->resource_title)
		{
			$str .= $resource->resource_title . ' ';
		}
		
		return $str . $resource->resource_url;
	}
	
	/**
	 * Get link that forwards to resource's website
	 */
	public function getGoURL($resource_id = 0)
	{
		$resource = $this;
		if ($resource_id > 0)
		{
			$resource = Resource::model()->findByPk($resource_id);
		}
		
		$resource->resource_url = $resource->stripURLHttpPart();
		$url = urlencode($resource->resource_url);
		
		return array(Utilities::getCurrentlySelectedSubscription()."/resource/go?url=$url");
	}
	
	/**
	 * strip away the "http://" part
	 * 
	 * @param unknown $resource_id
	 * @return string stripped url
	 */
	public function stripURLHttpPart($resource_id = 0)
	{
		$resource = $this;
		if ($resource_id > 0)
		{
			$resource = Resource::model()->findByPk($resource_id);
		}
		
		$url = str_replace(array('http://','https://'), '', $resource->resource_url);
		return trim($url);
	}
}