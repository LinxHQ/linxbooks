<?php

/**
 * This is the model class for table "resource_assigned_lists".
 *
 * The followings are the available columns in table 'resource_assigned_lists':
 * @property integer $resource_assigned_list_id
 * @property integer $resource_id
 * @property integer $resource_user_list_id
 */
class ResourceAssignedList extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ResourceAssignedList the static model class
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
		return 'lb_project_resource_assigned_lists';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('resource_id, resource_user_list_id', 'required'),
			array('resource_id, resource_user_list_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('resource_assigned_list_id, resource_id, resource_user_list_id', 'safe', 'on'=>'search'),
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
				'user_list' => array(self::BELONGS_TO, 'ResourceUserList', 'resource_user_list_id'),
				'resource' => array(self::BELONGS_TO, 'Resource', 'resource_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'resource_assigned_list_id' => 'Resource Assigned List',
			'resource_id' => 'Resource',
			'resource_user_list_id' => 'Resource User List',
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

		$criteria->compare('resource_assigned_list_id',$this->resource_assigned_list_id);
		$criteria->compare('resource_id',$this->resource_id);
		$criteria->compare('resource_user_list_id',$this->resource_user_list_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function save($runValidation=true, $attributes=NULL)
	{
		$isNewRecord = $this->isNewRecord;
	
		// check perm
		$resource = Resource::model()->findByPk($this->resource_id);
		if ($resource && !Permission::checkPermission($resource, Permission::PERMISSION_RESOURCE_LINK_UPDATE))
		{
			$this->addError('resource_id', 'You are not authorized to perform this action');
			return false;
		}
		
		// add some auto fields for new record
		if ($isNewRecord)
		{
			// check duplicate
			$dup = ResourceAssignedList::model()->find('resource_id =:resource_id AND resource_user_list_id =:resouce_user_list_id',
					array(':resource_id'=>$this->resource_id,
							':resouce_user_list_id'=>$this->resource_user_list_id));
			if ($dup) {
				// no saving
				return true;
			}
		}
	
		$result = parent::save($runValidation, $attributes);
	
		return $result;
	}
	
	public function delete()
	{
		// check perm
		$resource = Resource::model()->findByPk($this->resource_id);
		if ($resource && !Permission::checkPermission($resource, Permission::PERMISSION_RESOURCE_LINK_UPDATE))
		{
			$this->addError('resource_id', 'You are not authorized to perform this action');
			return false;
		}
		
		return parent::delete();
	}
	
	public function deleteAllAssignment($resource_id)
	{
		$assign = $this->getAssignedList($resource_id, true);
		foreach ($assign as $a_)
		{
			$a_->delete();
		}
	}
	
	/**
	 * Get assigned lists of a resource,'
	 * 
	 * @param string $resource_id Resource ID
	 * @param boolean	$get_data whether to return array of models or CActiveDataProvider.
	 * 								Default is false, which means return CActiveDataProvider
	 * @return mixed $result 
	 */
	public function getAssignedList($resource_id, $get_data = false)
	{
		$dataProvider = new CActiveDataProvider('ResourceAssignedList', array(
				'criteria' => array(
						'condition' => "resource_id = " . $resource_id,
						'with' => array(
							'user_list'
						),
				),
		));
	
		if ($get_data === true){
			$dataProvider->setPagination(false);
			return $dataProvider->getData();
		}
	
		else return $dataProvider;
	}
}