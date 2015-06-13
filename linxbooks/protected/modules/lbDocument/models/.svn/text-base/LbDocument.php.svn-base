<?php

/**
 * This is the model class for table "lb_documents".
 *
 * The followings are the available columns in table 'lb_documents':
 * @property integer $lb_record_primary_key
 * @property string $lb_document_parent_type
 * @property integer $lb_document_parent_id
 * @property integer $lb_account_id
 * @property string $lb_document_url
 * @property string $lb_document_name
 * @property string $lb_document_uploaded_datetime
 * @property string $lb_document_encoded_name
 */
class LbDocument extends CLBActiveRecord
{
        var $module_name = 'lbDocument';
        
	const LB_DOCUMENT_PARENT_TYPE_EXPENSES = 'EXPENSES';
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_documents';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lb_document_parent_type, lb_document_parent_id, lb_account_id, lb_document_url, lb_document_name, lb_document_uploaded_datetime, lb_document_encoded_name', 'required'),
			array('lb_document_parent_id, lb_account_id', 'numerical', 'integerOnly'=>true),
			array('lb_document_parent_type, lb_document_name, lb_document_encoded_name, lb_document_url', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lb_record_primary_key, lb_document_parent_type, lb_document_parent_id, lb_account_id, lb_document_url, lb_document_name, lb_document_uploaded_datetime, lb_document_encoded_name', 'safe', 'on'=>'search'),
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
			'lb_record_primary_key' => 'Lb Record Primary Key',
			'lb_document_parent_type' => 'Lb Document Parent Type',
			'lb_document_parent_id' => 'Lb Document Parent',
			'lb_account_id' => 'Lb Account',
                        'lb_document_url'=>'Lb Document Url',
			'lb_document_name' => 'Lb Document Name',
			'lb_document_uploaded_datetime' => 'Lb Document Uploaded Datetime',
			'lb_document_encoded_name' => 'Lb Document Encoded Name',
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

		$criteria->compare('lb_record_primary_key',$this->lb_record_primary_key);
		$criteria->compare('lb_document_parent_type',$this->lb_document_parent_type,true);
		$criteria->compare('lb_document_parent_id',$this->lb_document_parent_id);
		$criteria->compare('lb_account_id',$this->lb_account_id);
                $criteria->compare('lb_document_url',$this->lb_document_url,true);
		$criteria->compare('lb_document_name',$this->lb_document_name,true);
		$criteria->compare('lb_document_uploaded_datetime',$this->lb_document_uploaded_datetime,true);
		$criteria->compare('lb_document_encoded_name',$this->lb_document_encoded_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbDocument the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function save($runValidation=TRUE, $attributes=null)
        {
            $this->lb_account_id = Yii::app()->user->id;
            $this->lb_document_uploaded_datetime = date('Y-m-d H:i:s');

            return parent::save($runValidation, $attributes);
        }
        
        public function getDocumentParentType($parent_type, $parent_id)
        {
                $this->lb_document_parent_type = $parent_type;
                $this->lb_document_parent_id = $parent_id;
                $dp = $this->search();
                $dp->setPagination(false);
                return $dp->getData();
        }
        
        public function getDocumentParentTypeProvider($parent_type, $parent_id)
        {
//                $this->lb_document_parent_type = $parent_type;
//                $this->lb_document_parent_id = $parent_id;
//                $dp = $this->search();
//                $dp->setPagination(false);
//                return $dp->getData();
                $criteria=new CDbCriteria;
                $criteria->compare('lb_document_parent_type',"$parent_type");
                $criteria->compare('lb_document_parent_id',$parent_id);
                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                ));
        }
}
