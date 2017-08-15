
<?php

/**
 * This is the model class for table "system_lists".
 *
 * The followings are the available columns in table 'system_lists':
 * @property integer $system_list_item_id
 * @property string $system_list_name
 * @property string $system_list_item_name
 * @property integer $system_list_parent_item_id
 * @property integer $system_list_item_order
 * @property integer $system_list_item_active
 */
class lbLangUser extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SystemLists the static model class
	 */
       
        
        public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_language_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lb_language_name', 'required'),
			array('lb_user_id,invite_id', 'numerical', 'integerOnly'=>true),
			array('lb_language_name', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('lb_user_id,invite_id, lb_language_name,lb_record_primary_key', 'safe', 'on'=>'search'),
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
			'lb_user_id' => 'User Id',
			'lb_language_name'=>'Language Name',
                        'lb_record_primary_key'=>'Lang Id',
                        'invite_id '=>'Invite Id'
                        
                       
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('lb_user_id',$this->lb_user_id);
		$criteria->compare('invite_id',$this->invite_id);
		$criteria->compare('lb_language_name',$this->system_list_name,true);
		$criteria->compare('lb_record_primary_key',$this->lb_record_primary_key,true);
		
               
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * 
	 * @param unknown $list_name
	 * @param string $dropdown_array_source default is false, if true, return simple array with key being
	 * 					the model's id and value is its name
	 */
//        public function getItemsList($system_list_code)
//	{
//             
//		$dataProvider = new CActiveDataProvider($this->system_list_name, array(
//				'criteria'=>array(
//						'condition' => "system_list_code = '" . $system_list_code . "' AND system_list_item_active = 1",
//						'order' => 'system_list_name ASC',
//				)
//		));
//                return $dataProvider;
//                
//        }
	
	
	/**
	 * Get item by record ID
	 * 
	 * @param number $id
	 */
	public function getLangName($user_id)
	{
         
		$user = $this->find('lb_user_id='.$user_id);
                if($user){
                    $langName = $user->lb_language_name;
                    return $langName;
                }
                else
                    return false;
	}
        
        
      
        /**
        * Get list items
        * array returned consists of array(list_item_name_code => list_item_name, ...)
        * @param $list_code
        * @param bool $dropdown_array_source
        * @return array
        */

       
        
        public function updateLang($user_id,$lang)
        {
            $model = $this->find('lb_user_id='.$user_id.' AND invite_id=0');
            if(isset($model))
            {
                $model->lb_language_name = $lang;
                $model->update();
            }
            else
            {
                $model=new lbLangUser();
                $model->lb_language_name = $lang;
                $model->lb_user_id = $user_id;
                $model->insert();
            }
         
                
        }
        
        
        
       
}