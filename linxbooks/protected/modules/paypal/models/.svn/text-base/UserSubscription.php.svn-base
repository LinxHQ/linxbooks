<?php

/**
 * This is the model class for table "user_subscription".
 *
 * The followings are the available columns in table 'user_subscription':
 * @property integer $user_subscription_id
 * @property integer $user_id
 * @property integer $subscription_id
 * @property string $date_from
 */
class UserSubscription extends CLBActiveRecord
{
        var $module_name = 'paypal';
	/**
	 * Returns the static model of the specified AR class.
	 * @return UserSubscription the static model class
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
		return 'lb_user_subscription';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, subscription_id, date_from', 'required'),
			array('user_id, subscription_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_subscription_id, user_id, subscription_id, date_from', 'safe', 'on'=>'search'),
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
                    'subcription'=>array(self::BELONGS_TO,'Subscription','subscription_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_subscription_id' => 'User Subscription',
			'user_id' => 'User',
			'subscription_id' => 'Subscription',
			'date_from' => 'Date From',
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

		$criteria->compare('user_subscription_id',$this->user_subscription_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('subscription_id',$this->subscription_id);
		$criteria->compare('date_from',$this->date_from,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function getListUserSub() {
//            include 'SubscriptionController.php';
//            include 'UsersController.php';
            
                $arr = array();
                $model= UserSubscription::model()->findAll();
                if ($model===null)
                    throw new CHttpException(404,'The requested page does not exist.');
                else {
                    foreach ($model as $m) {
                        $value_arr = array();
                        
                        $sub = Subscription::model()->findByPk($m->subscription_id);
                        $userName = AccountProfile::model()->getFullName($m->user_id);
//                        $sub = SubscriptionController::loadModel($m->subscription_id);
//                        $user = UsersController::loadModel($m->user_id);
                        
                        $value_arr['id'] = $m->user_subscription_id;
                        $value_arr['user_name'] = $userName;
                        $value_arr['subscription'] = $sub->subscription_value.'$/'.$sub->subscription_name;
                        $value_arr['date_from'] = $m->date_from;
                        
                        $arr[] = $value_arr;
                    }
                }
                return $arr;
        }
}