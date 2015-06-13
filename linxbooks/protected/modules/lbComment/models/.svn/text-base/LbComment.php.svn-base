<?php

/**
 * This is the model class for table "lb_comment".
 *
 * The followings are the available columns in table 'lb_comment':
 * @property integer $lb_record_primary_key
 * @property string $lb_module_name
 * @property string $lb_comment_description
 * @property integer $lb_item_module_id
 * @property integer $lb_account_id
 * @property string $lb_comment_date
 * @property integer $lb_parent_comment_id
 */
class LbComment extends CLBActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_comment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lb_module_name, lb_comment_description, lb_item_module_id, lb_account_id, lb_comment_date, lb_parent_comment_id', 'required'),
			array('lb_item_module_id, lb_account_id, lb_parent_comment_id', 'numerical', 'integerOnly'=>true),
			array('lb_module_name', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lb_record_primary_key, lb_module_name, lb_comment_description, lb_item_module_id, lb_account_id, lb_comment_date, lb_parent_comment_id', 'safe', 'on'=>'search'),
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
			'lb_module_name' => 'Lb Module Name',
			'lb_comment_description' => 'Lb Comment Description',
			'lb_item_module_id' => 'Lb Item Module',
			'lb_account_id' => 'Lb Account',
			'lb_comment_date' => 'Lb Comment Date',
			'lb_parent_comment_id' => 'Lb Parent Comment',
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
		$criteria->compare('lb_module_name',$this->lb_module_name,true);
		$criteria->compare('lb_comment_description',$this->lb_comment_description,true);
		$criteria->compare('lb_item_module_id',$this->lb_item_module_id);
		$criteria->compare('lb_account_id',$this->lb_account_id);
		$criteria->compare('lb_comment_date',$this->lb_comment_date,true);
		$criteria->compare('lb_parent_comment_id',$this->lb_parent_comment_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbComment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function addComment($lb_module_name,$lb_comment_description=false,$lb_item_module_id=0,$lb_comment_date,$lb_parent_comment_id=0)
        {
            $model = new LbComment();
            $model->lb_account_id = Yii::app()->user->id;
            $model->lb_comment_date = $lb_comment_date;
            if($lb_comment_description)
                $model->lb_comment_description = $lb_comment_description;
            $model->lb_module_name = $lb_module_name;
            if($lb_item_module_id)
                $model->lb_item_module_id = $lb_item_module_id;
            else 
                $model->lb_item_module_id = 0;
            $model->lb_parent_comment_id = $lb_parent_comment_id;
            
            if($model->insert())
                return LbComment::model()->findByPk($model->lb_record_primary_key);
            
        }
        
        public function getComment($lb_module_name=false,$lb_item_module_id=false,$lb_parent_comment_id=false)
        {
            $model = LbComment::model()->findAll('lb_module_name = "'.$lb_module_name.'" AND lb_item_module_id = '.$lb_item_module_id
                    .' AND lb_parent_comment_id = '.$lb_parent_comment_id.' ORDER BY lb_comment_date DESC');
            
            return $model;
        }
        
        public function deleteComment($id)
        {
            
        }
}
