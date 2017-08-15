<?php

/**
 * This is the model class for table "lb_opportunity_comment".
 *
 * The followings are the available columns in table 'lb_opportunity_comment':
 * @property integer $id
 * @property integer $opportunity_id
 * @property string $comment_content
 * @property string $created_date
 * @property integer $created_by
 */
class LbOpportunityComment extends CLBActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_opportunity_comment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('opportunity_id, comment_content, created_date, created_by', 'required'),
			array('opportunity_id, created_by', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, opportunity_id, comment_content, created_date, created_by', 'safe', 'on'=>'search'),
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
			'comment_content' => 'Comment Content',
			'created_date' => 'Created Date',
			'created_by' => 'Created By',
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
		$criteria->compare('comment_content',$this->comment_content,true);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('created_by',$this->created_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbOpportunityComment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
