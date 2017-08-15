<?php

/**
 * This is the model class for table "resource_user_lists".
 *
 * The followings are the available columns in table 'resource_user_lists':
 * @property integer $resource_user_list_id
 * @property integer $account_subscription_id
 * @property string $resource_user_list_name
 * @property integer $resource_user_list_created_by
 * @property string $resource_user_list_created_date
 */
class ResourceUserList extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ResourceUserList the static model class
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
		return 'lb_project_resource_user_lists';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('account_subscription_id, resource_user_list_name, resource_user_list_created_by, resource_user_list_created_date', 'required'),
			array('account_subscription_id, resource_user_list_created_by', 'numerical', 'integerOnly'=>true),
			array('resource_user_list_name', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('resource_user_list_id, account_subscription_id, resource_user_list_name, resource_user_list_created_by, resource_user_list_created_date', 'safe', 'on'=>'search'),
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
				'assigned_list' => array(self::HAS_MANY, 'ResourceAssignedList', 'resource_user_list_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'resource_user_list_id' => 'Resource User List',
			'account_subscription_id' => 'Account Subscription',
			'resource_user_list_name' => 'List Name',
			'resource_user_list_created_by' => 'Resource User List Created By',
			'resource_user_list_created_date' => 'Resource User List Created Date',
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

		$criteria->compare('resource_user_list_id',$this->resource_user_list_id);
		$criteria->compare('account_subscription_id',$this->account_subscription_id);
		$criteria->compare('resource_user_list_name',$this->resource_user_list_name,true);
		$criteria->compare('resource_user_list_created_by',$this->resource_user_list_created_by);
		$criteria->compare('resource_user_list_created_date',$this->resource_user_list_created_date,true);

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
			if (!Permission::checkPermission($this, Permission::PERMISSION_RESOURCE_LINK_LIST_CREATE))
			{
				$this->addError('resource_user_list_name', 'You are not authorized to perform this action');
				return false;
			}
			
			$this->resource_user_list_created_by = Yii::app()->user->id;
			$this->resource_user_list_created_date = date('Y-m-d H:i:s');
		} else {
			// check perm
			if (!Permission::checkPermission($this, Permission::PERMISSION_RESOURCE_LINK_LIST_UPDATE))
			{
				$this->addError('resource_user_list_name', 'You are not authorized to perform this action');
				return false;
			}
		}
	
		$result = parent::save($runValidation, $attributes);
	
		return $result;
	}
	
	public function delete()
	{
		// check perm
		if (!Permission::checkPermission($this, Permission::PERMISSION_RESOURCE_LINK_LIST_DELETE))
		{
			$this->addError('resource_user_list_name', 'You are not authorized to perform this action');
			return false;
		}
		
		return parent::delete();
	}
	
	/**
	 * GET lists
	 * @param unknown $account_subscription_id
	 * @param string $type Type of returned data: dataProvider (default), modelArray, datasourceArray, datasourceJson
	 */
	public function getLists($account_subscription_id, $type = 'dataProvider')
	{
		$this->unsetAttributes();
		$this->account_subscription_id = $account_subscription_id;
		$result = $this->search();
		$result->setSort(array('defaultOrder'=>'resource_user_list_name'));
		
		switch ($type)
		{
			case 'dataProvider':
				return $result;
			case 'modelArray':
				$result->setPagination(false);
				return $result->getData();
			case 'datasourceArray':
				$result->setPagination(false);
				$array_models =  $result->getData();
				$result_ds = array();
				foreach ($array_models as $model)
				{
					$result_ds[$model->resource_user_list_id] = $model->resource_user_list_name;
				}
				return $result_ds;
			case 'datasourceJson':
				$result->setPagination(false);
				$array_models =  $result->getData();
				$result_ds = array();
				foreach ($array_models as $model)
				{
					$result_ds[$model->resource_user_list_id] = $model->resource_user_list_name;
				}
				return CJSON::encode($result_ds);
			default:
				return $result;
		}
	}
}