<?php

/**
 * This is the model class for table "lb_sys_translate".
 *
 * The followings are the available columns in table 'lb_sys_translate':
 * @property integer $lb_record_primary_key
 * @property string $lb_tranlate_en
 * @property string $lb_translate_vn
 */
class Translate extends CLBActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_sys_translate';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lb_tranlate_en, lb_translate_vn', 'required'),
			array('lb_record_primary_key', 'numerical', 'integerOnly'=>true),
			array('lb_tranlate_en, lb_translate_vn', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lb_record_primary_key, lb_tranlate_en, lb_translate_vn', 'safe', 'on'=>'search'),
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
			'lb_tranlate_en' => 'English',
			'lb_translate_vn' => 'Vietnamese',
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
		$criteria->compare('lb_tranlate_en',$this->lb_tranlate_en,true);
		$criteria->compare('lb_translate_vn',$this->lb_translate_vn,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Translate the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getArrayTranslate()
        {
            $model = Translate::model()->findAll();
            $arr = array();
            foreach ($model as $item) {
                $arr[$item->lb_tranlate_en] = $item->lb_translate_vn;
            }
            
            return $arr;
        }
}
