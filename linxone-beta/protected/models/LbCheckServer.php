<?php

/**
 * This is the model class for table "lb_check_server".
 *
 * The followings are the available columns in table 'lb_check_server':
 * @property integer $lb_record_primary_key
 * @property integer $lb_server_number
 * @property string $lb_server_name
 */
class LbCheckServer extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_check_server';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lb_server_number, lb_server_name', 'required'),
			array('lb_server_number', 'numerical', 'integerOnly'=>true),
			array('lb_server_name', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lb_record_primary_key, lb_server_number, lb_server_name', 'safe', 'on'=>'search'),
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
			'lb_server_number' => 'Lb Server Number',
			'lb_server_name' => 'Lb Server Name',
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
		$criteria->compare('lb_server_number',$this->lb_server_number);
		$criteria->compare('lb_server_name',$this->lb_server_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbCheckServer the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function checkServer()
	{
		$model = new LbCheckServer();
		$checkServer = $model->findByPk(1);
		if($checkServer->lb_server_number == 1 && $checkServer->lb_server_name == "linxone") {
			return $checkServer->lb_server_name;
		} else if($checkServer->lb_server_number == 2 && $checkServer->lb_server_name == "church-one") {
			return $checkServer->lb_server_name;
		}
		return false;
	}
}
