<?php

/**
 * This is the model class for table "lb_opportunity_document".
 *
 * The followings are the available columns in table 'lb_opportunity_document':
 * @property integer $id
 * @property integer $opportunity_id
 * @property string $opportunity_document_name
 * @property string $opportunity_document_type
 * @property string $opportunity_document_size
 */
class LbOpportunityDocument extends CLBActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_opportunity_document';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('opportunity_id, opportunity_document_name, opportunity_document_type, opportunity_document_size', 'required'),
			array('opportunity_id', 'numerical', 'integerOnly'=>true),
			array('opportunity_document_type, opportunity_document_size', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, opportunity_id, opportunity_document_name, opportunity_document_type, opportunity_document_size', 'safe', 'on'=>'search'),
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
			'opportunity_id' => 'Opportunity',
			'opportunity_document_name' => 'Opportunity Document Name',
			'opportunity_document_type' => 'Opportunity Document Type',
			'opportunity_document_size' => 'Opportunity Document Size',
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
		$criteria->compare('opportunity_id',$this->opportunity_id);
		$criteria->compare('opportunity_document_name',$this->opportunity_document_name,true);
		$criteria->compare('opportunity_document_type',$this->opportunity_document_type,true);
		$criteria->compare('opportunity_document_size',$this->opportunity_document_size,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbOpportunityDocument the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
