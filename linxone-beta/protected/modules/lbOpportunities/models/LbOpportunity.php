<?php

/**
 * This is the model class for table "lb_opportunity".
 *
 * The followings are the available columns in table 'lb_opportunity':
 * @property integer $opportunity_id
 * @property string $opportunity_name
 * @property integer $customer_id
 * @property integer $opportunity_status_id
 * @property integer $value
 * @property string $deadline
 * @property string $note
 * @property integer $opportunity_document_id
 * @property integer $created_by
 * @property string $created_date
 * @property integer $industry
 * @property string $star_rating
 */
class LbOpportunity extends CLBActiveRecord
{
	public $from_date;
    public $to_date;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_opportunity';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('opportunity_name', 'required'),
			array('customer_id, opportunity_status_id, value, opportunity_document_id, created_by, industry', 'numerical', 'integerOnly'=>true),
			array('opportunity_name', 'length', 'max'=>255),
			array('star_rating', 'length', 'max'=>2),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('opportunity_id, opportunity_name, customer_id, opportunity_status_id, value, deadline, note, opportunity_document_id, created_by, created_date, industry, star_rating', 'safe', 'on'=>'search'),
			array('from_date, to_date', 'safe'),
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
			'opportunity_id' => 'Opportunity',
			'opportunity_name' => 'Opportunity Name',
			'customer_id' => 'Customer',
			'opportunity_status_id' => 'Opportunity Status',
			'value' => 'Value',
			'deadline' => 'Deadline',
			'note' => 'Note',
			'opportunity_document_id' => 'Opportunity Document',
			'created_by' => 'Created By',
			'created_date' => 'Created Date',
			'industry' => 'Industry',
			'star_rating' => 'Star Rating',
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

		$criteria->compare('opportunity_id',$this->opportunity_id);
		$criteria->compare('opportunity_name',$this->opportunity_name,true);
		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('opportunity_status_id',$this->opportunity_status_id);
		$criteria->compare('value',$this->value);
		$criteria->compare('deadline',$this->deadline,true);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('opportunity_document_id',$this->opportunity_document_id);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('industry',$this->industry);
		$criteria->compare('star_rating',$this->star_rating,true);
		if ($this->from_date && $this->to_date) {
			$criteria->compare('deadline','>='.$this->from_date);
        	$criteria->compare('deadline','<='.$this->to_date);
        }
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function searchOppByColumn($column_id)
	{
		$criteria=new CDbCriteria;
		// $criteria->compare('opportunity_status_id',$column_id);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbOpportunity the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
