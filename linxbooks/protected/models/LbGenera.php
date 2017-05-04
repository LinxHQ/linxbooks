<?php

/**
 * This is the model class for table "lb_genera".
 *
 * The followings are the available columns in table 'lb_genera':
 * @property integer $lb_record_primary_key
 * @property string $lb_genera_currency_symbol
 */
class LbGenera extends CLBActiveRecord
{
        var $module_name = 'lbInvoice';
        const LB_QUERY_RETURN_TYPE_ACTIVE_DATA_PROVIDER = 'ActiveDataProvider';
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_genera';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lb_genera_currency_symbol', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lb_record_primary_key, lb_genera_currency_symbol, lb_thousand_separator', 'safe', 'on'=>'search'),
                        array('lb_thousand_separator', 'length', 'max'=>100),
                        array('lb_decimal_symbol', 'length', 'max'=>100),
                        
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
			'lb_genera_currency_symbol' => 'Currency Symbol',
                        'lb_thousand_separator'=>'Thousand Separator',
                        'lb_decimal_symbol'=>'Decimal Symbol',
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
		$criteria->compare('lb_genera_currency_symbol',$this->lb_genera_currency_symbol,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbGenera the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
      
        public function getGeneraSubscription()
        {
          //  $lastGenera = $this->getFullRecords();
          //  if(count($lastGenera)<=0)
          //  {
          //      $genera = new LbGenera();
          //      $genera->lb_genera_currency_symbol = "";
          //      $genera->save();
          //      
          //      $lastGenera = $this->getFullRecords();
          //  }
           $lastGenera = LbGenera::model()->findAll();  
            $generaID = $lastGenera[0]->lb_record_primary_key;
            $dataProvider = LbGenera::model()->findByPk($generaID);
            return $dataProvider;
        }
        public function getGeneraCurrency()
        {
            $lastGenera = $this->getFullRecords();
            if(count($lastGenera)<=0)
            {
                $genera = new LbGenera();
                $genera->lb_genera_currency_symbol = "";
                $genera->save();
                
                $lastGenera = $this->getFullRecords();
            }
            
            $generaID = $lastGenera[0]->lb_record_primary_key;
            $dataProvider = LbGenera::model()->findByPk($generaID)->lb_genera_currency_symbol;
            return $dataProvider;
        }
        public function getCurrency($sort="",$return_type = self::LB_QUERY_RETURN_TYPE_ACTIVE_DATA_PROVIDER){    
        $criteria=new CDbCriteria;
        $criteria->order = $sort;
        $dataProvider = $this->getFullRecordsDataProvider($criteria);
        return $this->getResultsBasedForReturnType($dataProvider,$return_type);    
        }
}
