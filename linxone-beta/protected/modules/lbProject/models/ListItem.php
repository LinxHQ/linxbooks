<?php

/**
 * This is the model class for table "system_lists".
 *
 * The followings are the available columns in table 'system_lists':
 * @property integer $system_list_item_id
 * @property string $system_list_name
 * @property string $system_list_item_name
 * @property integer $system_list_parent_item_id
 * @property integer $system_list_item_order
 * @property integer $system_list_item_active
 */
class ListItem extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SystemLists the static model class
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
		return 'lb_project_list_items';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('system_list_name, system_list_item_name', 'required'),
			array('system_list_parent_item_id, system_list_item_order, system_list_item_active', 'numerical', 'integerOnly'=>true),
			array('system_list_name, system_list_item_name', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('system_list_item_id, system_list_name, system_list_item_name, system_list_parent_item_id, system_list_item_order, system_list_item_active', 'safe', 'on'=>'search'),
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
			'system_list_item_id' => 'System List Item',
			'system_list_name' => 'System List Name',
			'system_list_item_name' => 'System List Item Name',
			'system_list_parent_item_id' => 'System List Parent Item',
			'system_list_item_order' => 'System List Item Order',
			'system_list_item_active' => 'System List Item Active',
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

		$criteria->compare('system_list_item_id',$this->system_list_item_id);
		$criteria->compare('system_list_name',$this->system_list_name,true);
		$criteria->compare('system_list_item_name',$this->system_list_item_name,true);
		$criteria->compare('system_list_parent_item_id',$this->system_list_parent_item_id);
		$criteria->compare('system_list_item_order',$this->system_list_item_order);
		$criteria->compare('system_list_item_active',$this->system_list_item_active);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * 
	 * @param unknown $list_name
	 * @param string $dropdown_array_source default is false, if true, return simple array with key being
	 * 					the model's id and value is its name
	 */
	public function getItemsForList($list_name, $dropdown_array_source = false)
	{
		$dataProvider = new CActiveDataProvider('ListItem', array(
				'criteria'=>array(
						'condition' => "system_list_name = '" . $list_name . "' AND system_list_item_active = 1",
						'order' => 'system_list_item_order ASC',
				)
		));
		
		if ($dropdown_array_source)
		{
			$arr = array();
			$dataProvider->setPagination(false);
			$data = $dataProvider->getData();
			foreach ($data as $item)
			{
				$arr[$item->system_list_item_id] = $item->system_list_item_name;
			}
			
			return $arr;
		}
		
		// to get list of object
		$dataProvider->setPagination(false);
		return $dataProvider->getData();
		
		//return $dataProvider;
	}
	
	public function getItemByCode($item_code)
	{
		return $this->find('system_list_item_code = :code', array('code' => $item_code));
	}
	
	public function getItemIdByCode($item_code)
	{
		$model = $this->getItemByCode($item_code);
		return $model->system_list_item_id;
	}
	
	/**
	 * Get item by record ID
	 * 
	 * @param number $id
	 */
	public function getItem($id = 0)
	{
		if ($id == 0)
			$id = $this->system_list_item_id;
		
		return $this->findByPk($id);
	}
}