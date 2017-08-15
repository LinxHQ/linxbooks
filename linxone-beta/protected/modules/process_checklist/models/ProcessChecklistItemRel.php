<?php

/**
 * This is the model class for table "process_checklist_item_rel".
 *
 * The followings are the available columns in table 'process_checklist_item_rel':
 * @property integer $pcir_id
 * @property integer $pc_id
 * @property string $pcir_name
 * @property integer $pcir_order
 * @property interger $pcir_entity_type
 * @property string $pcir_entity_id
 * @property integer $pcir_status
 * @property integer $pcir_status_update_by
 * @property string $pcir_status_date
 */
class ProcessChecklistItemRel extends CLBActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'process_checklist_item_rel';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pc_id, pcir_entity_type, pcir_entity_id', 'required'),
			array('pc_id, pcir_order, pcir_entity_id, pcir_status, pcir_status_update_by', 'numerical', 'integerOnly'=>true),
			array('pcir_name', 'length', 'max'=>255),
			array('pcir_entity_type', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('pcir_id, pc_id, pcir_name, pcir_order, pcir_entity_type, pcir_entity_id, pcir_status, pcir_status_update_by, pcir_status_date', 'safe', 'on'=>'search'),
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
                    'process_checklist' => array(self::BELONGS_TO,'ProcessChecklist','pc_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pcir_id' => 'Pcir',
			'pc_id' => 'Pc',
			'pcir_name' => 'Name',
			'pcir_order' => 'Pcir Order',
			'pcir_entity_type' => 'Pcir Entity Type',
			'pcir_entity_id' => 'Pcir Entity',
			'pcir_status' => 'Pcir Status',
			'pcir_status_update_by' => 'Pcir Status Update By',
                        'pcir_status_date' => 'Pcir Status Date'
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

		$criteria->compare('pcir_id',$this->pcir_id);
		$criteria->compare('pc_id',$this->pc_id);
		$criteria->compare('pcir_name',$this->pcir_name,true);
		$criteria->compare('pcir_order',$this->pcir_order);
		$criteria->compare('pcir_entity_type',$this->pcir_entity_type);
		$criteria->compare('pcir_entity_id',$this->pcir_entity_id,true);
		$criteria->compare('pcir_status',$this->pcir_status);
		$criteria->compare('pcir_status_update_by',$this->pcir_status_update_by);
                $criteria->compare('pcir_status_date',$this->pcir_status_date);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProcessChecklistItemRel the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function addChecklistItemRel($entity_type, $entity_id, $pc_id)
        {
            $modelPCdefault = ProcessChecklistDefault::model()->getPCheckListDefaultByCheckList($pc_id);
            $result = false;
            foreach ($modelPCdefault->data as $value) {
                $model = new ProcessChecklistItemRel();
                $model->pcir_entity_type = $entity_type;
                $model->pcir_entity_id = $entity_id;
                $model->pc_id = $pc_id;
                $model->pcir_name = $value->pcdi_name;
                $model->pcir_order = $value->pcdi_order;
                $model->pcir_status_date = date('Y-m-d');
                $model->pcir_status_update_by = 0;
                
                if($model->save())
                    $result=true;
            }
            return $result;
        }
        
        /**
         * 
         * @param type $entity_type
         * @param type $entity_id
         * @return \CActiveDataProvider
         */
        public function getPChecklistByEntity($entity_type, $entity_id)
        {
		$criteria=new CDbCriteria;
                
		$criteria->compare('pcir_entity_type',$entity_type);
		$criteria->compare('pcir_entity_id',$entity_id);
                $criteria->group = 'pc_id';
                
		$dataProvider = new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
		));
                
                return $dataProvider;
        }
        
        public function getPchecklistItemRel($entity_type, $entity_id, $pc_id)
        {
		$criteria=new CDbCriteria;
                
		$criteria->compare('pcir_entity_type',$entity_type);
		$criteria->compare('pcir_entity_id',$entity_id);
                $criteria->compare('pc_id',$pc_id);
                $criteria->order="pcir_order ASC";
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		)); 
        }
        
        public function updateProcessChecklistItem($pcir_id,$status)
        {
            $model = ProcessChecklistItemRel::model()->findByPk($pcir_id);
            
            $model->pcir_status = $status;
            
            if($model->save())
                return true;
            return false;
        }
        
        /**
         * besides deleting record
         * deletes its core entity as well
         *
         * @return bool|void
         */
//        public function delete($id)
//        {
//            $delete = ProcessChecklistItemRel::model()->findByPk($pk);
//            if($delete->delete());
//                return true;
//            return false;
//        }
}
