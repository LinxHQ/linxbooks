<?php

/**
 * This is the model class for table "lb_opportunity_entry".
 *
 * The followings are the available columns in table 'lb_opportunity_entry':
 * @property integer $id
 * @property integer $opportunity_id
 * @property integer $entry_id
 * @property string $entry_type
 */
class LbOpportunityEntry extends CLBActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_opportunity_entry';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('opportunity_id, entry_id, entry_type', 'required'),
			array('opportunity_id, entry_id', 'numerical', 'integerOnly'=>true),
			array('entry_type', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, opportunity_id, entry_id, entry_type', 'safe', 'on'=>'search'),
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
			'entry_id' => 'Entry',
			'entry_type' => 'Entry Type',
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
		$criteria->compare('entry_id',$this->entry_id);
		$criteria->compare('entry_type',$this->entry_type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * @param int $opportunity_id
	 * @param string $type
	 * @return Array LbOpportunityEntry
	 * lay ra danh sach contact, empployee, invoice, quotation thuoc 1 opportunity_id
	 */
	public function get_opportunity_entry($opportunity_id, $type)
	{
		$criteria = new CDbCriteria();
        $criteria->compare ('opportunity_id', $opportunity_id);
        $criteria->compare ('entry_type', $type);
        return LbOpportunityEntry::model()->findAll($criteria);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbOpportunityEntry the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
