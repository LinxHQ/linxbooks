<?php

/**
 * This is the model class for table "lb_talent_course_skills".
 *
 * The followings are the available columns in table 'lb_talent_course_skills':
 * @property integer $lb_record_primary_key
 * @property integer $lb_talent_course_id
 * @property integer $lb_skill_id
 */
class LbTalentCourseSkills extends CLBActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_talent_course_skills';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lb_talent_course_id, lb_skill_id', 'required'),
			array('lb_talent_course_id, lb_skill_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lb_record_primary_key, lb_talent_course_id, lb_skill_id', 'safe', 'on'=>'search'),
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
			'lb_talent_course_id' => 'Lb Talent Course',
			'lb_skill_id' => 'Skill',
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
		$criteria->compare('lb_talent_course_id',$this->lb_talent_course_id);
		$criteria->compare('lb_skill_id',$this->lb_skill_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbTalentCourseSkills the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getSkillIdByCourse($course_id){
		$criteria = new CDbCriteria();
		$criteria->compare ('lb_talent_course_id', intval($course_id));
	    
	   $skill_name_arr = $this->getFullRecords($criteria);
	   $skills_name = "";
	   foreach($skill_name_arr as $result_skill_name_arr){
	   		$skill_name = LbTalentSkills::model()->getSkillName($result_skill_name_arr['lb_skill_id']);
	   		foreach($skill_name as $result_skill_name){
	   			$skills_name .= $result_skill_name->attributes['lb_skill_name'].", ";
	   		}
	   }
	   return $skills_name;
	}
}
