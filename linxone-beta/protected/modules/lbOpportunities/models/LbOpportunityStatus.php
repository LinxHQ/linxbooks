<?php

/**
 * This is the model class for table "lb_opportunity_status".
 *
 * The followings are the available columns in table 'lb_opportunity_status':
 * @property integer $id
 * @property string $column_name
 * @property integer $listorder
 * @property string $column_color
 */
class LbOpportunityStatus extends CLBActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_opportunity_status';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('column_name, column_color', 'required'),
			array('listorder', 'numerical', 'integerOnly'=>true),
			array('column_name', 'length', 'max'=>255),
			array('column_color', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, column_name, listorder, column_color', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'column_name' => 'Column Name',
			'listorder' => 'Listorder',
			'column_color' => 'Column Color',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('column_name',$this->column_name,true);
		$criteria->compare('listorder',$this->listorder);
		$criteria->compare('column_color',$this->column_color,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function searchStatus($status_id)
	{
		$criteria = new CDbCriteria();
	    if($status_id)
	       $criteria->compare ('id', intval($status_id));
	    
	   return $this->find($criteria);
	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbOpportunityStatus the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
