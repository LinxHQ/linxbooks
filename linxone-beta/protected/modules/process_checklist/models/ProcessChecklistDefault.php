<?php

/**
 * This is the model class for table "process_checklist_default".
 *
 * The followings are the available columns in table 'process_checklist_default':
 * @property integer $pcdi_id
 * @property integer $pc_id
 * @property string $pcdi_name
 * @property integer $pcdi_order
 */
class ProcessChecklistDefault extends CLBActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'process_checklist_default';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pc_id, pcdi_name, pcdi_order', 'required'),
			array('pc_id, pcdi_order', 'numerical', 'integerOnly'=>true),
			array('pcdi_name', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('pcdi_id, pc_id, pcdi_name, pcdi_order', 'safe', 'on'=>'search'),
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
			'pcdi_id' => 'Pcdi',
			'pc_id' => 'Pc',
			'pcdi_name' => 'Name',
			'pcdi_order' => 'Pcdi Order',
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

		$criteria->compare('pcdi_id',$this->pcdi_id);
		$criteria->compare('pc_id',$this->pc_id);
		$criteria->compare('pcdi_name',$this->pcdi_name,true);
		$criteria->compare('pcdi_order',$this->pcdi_order);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProcessChecklistDefault the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getPCheckListDefaultByCheckList($pc_id)
        {
            $criteria=new CDbCriteria;
            
            $criteria->compare('pc_id',$pc_id);
            $criteria->order='pcdi_order ASC';

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
}
