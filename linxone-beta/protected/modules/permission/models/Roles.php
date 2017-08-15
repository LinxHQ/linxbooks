<?php

/**
 * This is the model class for table "lb_roles".
 *
 * The followings are the available columns in table 'lb_roles':
 * @property integer $lb_record_primary_key
 * @property string $role_name
 * @property string $role_description
 * @property integer $role_module_home
 * @property string $role_module_home_action
 */
class Roles extends CLBActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_roles';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('role_name', 'required'),
			array('role_name', 'length', 'max'=>100),
			array('role_description,role_module_home_action', 'length', 'max'=>255),
                        array('role_module_home','numerical', 'integerOnly'=>true),
                        array('role_description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lb_record_primary_key, role_name, role_description', 'safe', 'on'=>'search'),
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
			'lb_record_primary_key' => Yii::t('lang','Role'),
			'role_name' => Yii::t('lang','Name'),
			'role_description' => Yii::t('lang','Description'),
                        'role_module_home_action'=>Yii::t('lang','Module Action'),
                        'role_module_home'=>Yii::t('lang','Module Home')
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
		$criteria->compare('role_name',$this->role_name,true);
		$criteria->compare('role_description',$this->role_description,true);
                $criteria->compare('role_module_home',$this->role_module_home);
                $criteria->compare('role_module_home_action',$this->role_module_home_action,true);

                $dataProvider = $this->getFullRecordsDataProvider($criteria);
                return $dataProvider;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Roles the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
    public function getRoles()
    {
        $criteria = new CDbCriteria;
        $dataProvider = $this->getFullRecords($criteria);
        return $dataProvider;
    }
}
