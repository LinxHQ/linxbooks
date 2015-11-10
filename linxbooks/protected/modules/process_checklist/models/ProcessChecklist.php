<?php

/**
 * This is the model class for table "process_checklist".
 *
 * The followings are the available columns in table 'process_checklist':
 * @property integer $pc_id
 * @property integer $subcription_id
 * @property string $pc_name
 * @property string $pc_created_date
 * @property integer $pc_last_update_by
 * @property string $pc_last_update
 * @property string $pc_created_by
 */
class ProcessChecklist extends CLBActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'process_checklist';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('subcription_id, pc_name, pc_created_date, pc_last_update_by, pc_last_update, pc_created_by', 'required'),
			array('subcription_id', 'numerical', 'integerOnly'=>true),
			array('pc_name', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('pc_id, subcription_id, pc_name, pc_created_date, pc_last_update_by, pc_last_update, pc_created_by', 'safe', 'on'=>'search'),
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
			'pc_id' => 'Pc',
			'subcription_id' => 'Subcription',
			'pc_name' => 'Name',
			'pc_created_date' => 'Pc Created Date',
			'pc_last_update_by' => 'Pc Last Update By',
			'pc_last_update' => 'Pc Last Update',
                        'pc_created_by'=>'Pc Created Date'
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

		$criteria->compare('pc_id',$this->pc_id);
		$criteria->compare('subcription_id',$this->subcription_id);
		$criteria->compare('pc_name',$this->pc_name,true);
		$criteria->compare('pc_created_date',$this->pc_created_date,true);
		$criteria->compare('pc_last_update_by',$this->pc_last_update_by);
		$criteria->compare('pc_last_update',$this->pc_last_update,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProcessChecklist the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getPchecklist($subcription_id=false)
        {
		$criteria=new CDbCriteria;
                
                if($subcription_id)
                    $criteria->compare('subcription_id',$subcription_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
        }
        
}
