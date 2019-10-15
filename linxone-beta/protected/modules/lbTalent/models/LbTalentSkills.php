<?php

/**
 * This is the model class for table "lb_talent_skills".
 *
 * The followings are the available columns in table 'lb_talent_skills':
 * @property integer $lb_record_primary_key
 * @property string $lb_skill_name
 * @property integer $lb_parent_id
 * @property integer $lb_level_id
 * @property string $lb_create_date
 */
class LbTalentSkills extends CLBActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_talent_skills';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lb_skill_name, lb_create_date', 'required'),
			array('lb_parent_id, lb_level_id', 'numerical', 'integerOnly'=>true),
			array('lb_skill_name', 'length', 'max'=>255),
			array('lb_skill_name', 'implodeParams'), //define custom validator to implode checked values into string
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lb_record_primary_key, lb_skill_name, lb_parent_id, lb_level_id, lb_create_date', 'safe', 'on'=>'search'),
		);
	}

	public function implodeParams($attribute) 
	{
	    if(is_array($this->$attribute)) {
	        $this->$attribute = implode(',', $this->$attribute);  //in db it is stored as string e.g. '1,3,4'
	    }
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
			'lb_skill_name' => 'Skill Name',
			'lb_parent_id' => 'Parent',
			'lb_level_id' => 'Level',
			'lb_create_date' => 'Lb Create Date',
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
		$criteria->compare('lb_skill_name',$this->lb_skill_name,true);
		$criteria->compare('lb_parent_id',$this->lb_parent_id);
		$criteria->compare('lb_level_id',$this->lb_level_id);
		$criteria->compare('lb_create_date',$this->lb_create_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbTalentSkills the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getSkillName($skill_id=false) {
		$criteria=new CDbCriteria;
		if($skill_id){
			$criteria->compare('t.lb_record_primary_key',$skill_id);
		}
		return $this->find($criteria);
	}
}
