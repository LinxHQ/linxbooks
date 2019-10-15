<?php

/**
 * This is the model class for table "lb_people".
 *
 * The followings are the available columns in table 'lb_people':
 * @property integer $lb_record_primary_key
 * @property string $lb_given_name
 * @property string $lb_family_name
 * @property integer $lb_title
 * @property integer $lb_people_believer
 * @property integer $lb_gender
 * @property string $lb_birthday
 * @property integer $lb_nationality
 * @property integer $lb_marital_status
 * @property integer $lb_ethnic
 * @property string $lb_nric
 * @property integer $lb_religion
 * @property string $lb_company_name
 * @property string $lb_company_position
 * @property string $lb_company_occupation
 * @property string $lb_baptism_church
 * @property string $lb_baptism_no
 * @property string $lb_baptism_date
 * @property string $lb_local_address_street
 * @property string $lb_local_address_street2
 * @property integer $lb_local_address_mobile
 * @property integer $lb_local_address_phone
 * @property integer $lb_local_address_phone_2
 * @property integer $lb_local_address_level
 * @property string $lb_local_address_unit
 * @property integer $lb_local_address_postal_code
 * @property string $lb_local_address_email
 * @property integer $lb_local_address_country
 * @property string $lb_overseas_address_street
 * @property string $lb_overseas_address_street2
 * @property integer $lb_overseas_address_mobile
 * @property integer $lb_overseas_address_phone
 * @property integer $lb_overseas_address_phone2
 * @property integer $lb_overseas_address_level
 * @property string $lb_overseas_address_unit
 * @property integer $lb_overseas_address_postal_code
 * @property string $lb_overseas_address_email
 * @property integer $lb_overseas_address_country
 */
class LbPeople extends CLBActiveRecord
{
	public $lb_small_group_id;
	public $lb_group_type;
	public $lb_volunteers_id;
	public $lb_volunteers_position;
	public $lb_volunteers_type;
	public $lb_people_id;
	public $lb_pastoral_care_date;
	public $lb_pastoral_care_type;
	public $lb_pastoral_care_pastor_id;
	public $lb_pastoral_care_remark;
	public $lb_document_parent_type;
	public $lb_document_parent_id;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_people';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lb_given_name, lb_family_name', 'required'),
			array('lb_title, lb_people_believer, lb_gender, lb_nationality, lb_marital_status, lb_ethnic, lb_religion, lb_local_address_mobile, lb_local_address_phone, lb_local_address_phone_2, lb_local_address_level, lb_local_address_postal_code, lb_local_address_country, lb_overseas_address_mobile, lb_overseas_address_phone, lb_overseas_address_phone2, lb_overseas_address_level, lb_overseas_address_postal_code, lb_overseas_address_country', 'numerical', 'integerOnly'=>true),
			array('lb_given_name, lb_family_name, lb_baptism_church, lb_local_address_unit, lb_overseas_address_unit', 'length', 'max'=>50),
			array('lb_nric, lb_company_occupation, lb_baptism_no, lb_local_address_email, lb_overseas_address_email', 'length', 'max'=>30),
			array('lb_company_name, lb_company_position, lb_local_address_street, lb_local_address_street2, lb_overseas_address_street, lb_overseas_address_street2', 'length', 'max'=>255),
			array('lb_birthday, lb_baptism_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lb_record_primary_key, lb_given_name, lb_family_name, lb_title, lb_people_believer, lb_gender, lb_birthday, lb_nationality, lb_marital_status, lb_ethnic, lb_nric, lb_religion, lb_company_name, lb_company_position, lb_company_occupation, lb_baptism_church, lb_baptism_no, lb_baptism_date, lb_local_address_street, lb_local_address_street2, lb_local_address_mobile, lb_local_address_phone, lb_local_address_phone_2, lb_local_address_level, lb_local_address_unit, lb_local_address_postal_code, lb_local_address_email, lb_local_address_country, lb_overseas_address_street, lb_overseas_address_street2, lb_overseas_address_mobile, lb_overseas_address_phone, lb_overseas_address_phone2, lb_overseas_address_level, lb_overseas_address_unit, lb_overseas_address_postal_code, lb_overseas_address_email, lb_overseas_address_country', 'safe', 'on'=>'search'),
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
			'lb_record_primary_key' => 'Record Primary Key',
			'lb_given_name' => 'Given Name',
			'lb_family_name' => 'Family Name',
			'lb_title' => 'Title',
			'lb_people_believer' => 'People Believer',
			'lb_gender' => 'Gender',
			'lb_birthday' => 'Birthday',
			'lb_nationality' => 'Nationality',
			'lb_marital_status' => 'Marital Status',
			'lb_ethnic' => 'Ethnic',
			'lb_nric' => 'Nric',
			'lb_religion' => 'Religion',
			'lb_company_name' => 'Company Name',
			'lb_company_position' => 'Company Position',
			'lb_company_occupation' => 'Company Occupation',
			'lb_baptism_church' => 'Baptism Church',
			'lb_baptism_no' => 'Baptism No',
			'lb_baptism_date' => 'Baptism Date',
			'lb_local_address_street' => 'Local Address Street',
			'lb_local_address_street2' => 'Local Address Street2',
			'lb_local_address_mobile' => 'Local Address Mobile',
			'lb_local_address_phone' => 'Local Address Phone',
			'lb_local_address_phone_2' => 'Local Address Phone 2',
			'lb_local_address_level' => 'Local Address Level',
			'lb_local_address_unit' =>  'Local Address Unit',
			'lb_local_address_postal_code' => 'Local Address Postal Code',
			'lb_local_address_email' => 'Local Address Email',
			'lb_local_address_country' => 'Local Address Country',
			'lb_overseas_address_street' => 'Overseas Address Street',
			'lb_overseas_address_street2' => 'Overseas Address Street2',
			'lb_overseas_address_mobile' => 'Overseas Address Mobile',
			'lb_overseas_address_phone' => 'Overseas Address Phone',
			'lb_overseas_address_phone2' => 'Overseas Address Phone2',
			'lb_overseas_address_level' => 'Overseas Address Level',
			'lb_overseas_address_unit' => 'Overseas Address Unit',
			'lb_overseas_address_postal_code' => 'Overseas Address Postal Code',
			'lb_overseas_address_email' => 'Overseas Address Email',
			'lb_overseas_address_country' => 'Overseas Address Country',
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
	public function search($info_people=false)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('lb_record_primary_key',$this->lb_record_primary_key);
		$criteria->compare('lb_given_name',$this->lb_given_name,true);
		$criteria->compare('lb_family_name',$this->lb_family_name,true);
		$criteria->compare('lb_title',$this->lb_title);
		$criteria->compare('lb_people_believer',$this->lb_people_believer);
		$criteria->compare('lb_gender',$this->lb_gender);
		$criteria->compare('lb_birthday',$this->lb_birthday,true);
		$criteria->compare('lb_nationality',$this->lb_nationality);
		$criteria->compare('lb_marital_status',$this->lb_marital_status);
		$criteria->compare('lb_ethnic',$this->lb_ethnic);
		$criteria->compare('lb_nric',$this->lb_nric,true);
		$criteria->compare('lb_religion',$this->lb_religion);
		$criteria->compare('lb_company_name',$this->lb_company_name,true);
		$criteria->compare('lb_company_position',$this->lb_company_position,true);
		$criteria->compare('lb_company_occupation',$this->lb_company_occupation,true);
		$criteria->compare('lb_baptism_church',$this->lb_baptism_church,true);
		$criteria->compare('lb_baptism_no',$this->lb_baptism_no,true);
		$criteria->compare('lb_baptism_date',$this->lb_baptism_date,true);
		$criteria->compare('lb_local_address_street',$this->lb_local_address_street,true);
		$criteria->compare('lb_local_address_street2',$this->lb_local_address_street2,true);
		$criteria->compare('lb_local_address_mobile',$this->lb_local_address_mobile);
		$criteria->compare('lb_local_address_phone',$this->lb_local_address_phone);
		$criteria->compare('lb_local_address_phone_2',$this->lb_local_address_phone_2);
		$criteria->compare('lb_local_address_level',$this->lb_local_address_level);
		$criteria->compare('lb_local_address_unit',$this->lb_local_address_unit,true);
		$criteria->compare('lb_local_address_postal_code',$this->lb_local_address_postal_code);
		$criteria->compare('lb_local_address_email',$this->lb_local_address_email,true);
		$criteria->compare('lb_local_address_country',$this->lb_local_address_country);
		$criteria->compare('lb_overseas_address_street',$this->lb_overseas_address_street,true);
		$criteria->compare('lb_overseas_address_street2',$this->lb_overseas_address_street2,true);
		$criteria->compare('lb_overseas_address_mobile',$this->lb_overseas_address_mobile);
		$criteria->compare('lb_overseas_address_phone',$this->lb_overseas_address_phone);
		$criteria->compare('lb_overseas_address_phone2',$this->lb_overseas_address_phone2);
		$criteria->compare('lb_overseas_address_level',$this->lb_overseas_address_level);
		$criteria->compare('lb_overseas_address_unit',$this->lb_overseas_address_unit,true);
		$criteria->compare('lb_overseas_address_postal_code',$this->lb_overseas_address_postal_code);
		$criteria->compare('lb_overseas_address_email',$this->lb_overseas_address_email,true);
		$criteria->compare('lb_overseas_address_country',$this->lb_overseas_address_country);

		if($info_people){
			$criteria->condition .= ' lb_given_name LIKE "%'.$info_people.'%" 
						OR lb_local_address_email LIKE "%'.$info_people.'%" 
						OR lb_nric LIKE "%'.$info_people.'%" 
						OR lb_local_address_mobile LIKE "%'.$info_people.'%"';
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchLeaderByName($leader_name=false,$page=10)
    {

    	// SELECT * FROM `lb_people` LEFT JOIN `lb_small_group_people` ON `lb_small_group_people`.`lb_people_id` = `lb_people`.`lb_record_primary_key` WHERE `lb_people`.`lb_given_name` LIKE "%s%" AND `lb_small_group_people`.`lb_position_id` = 1 

        if(isset($_REQUEST['leader_name']))
            $leader_name = $_REQUEST['leader_name'];

        $criteria = new CDbCriteria();
        $criteria->select = 't.*,';
        $criteria->select .= 's.*';
        $criteria->join = 'LEFT JOIN lb_small_group_people s ON s.lb_people_id = t.lb_record_primary_key ';
        $criteria->condition = 't.lb_given_name LIKE "%'.$leader_name.'%" AND s.lb_position_id = 1';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
            	'pageSize' => 10,
            ),
        ));

    }

    public function searchPeopleNameVolunteers($volunteer_people_name=false,$page=10)
    {

    	// SELECT * FROM `lb_people` LEFT JOIN `lb_small_group_people` ON `lb_small_group_people`.`lb_people_id` = `lb_people`.`lb_record_primary_key` WHERE `lb_people`.`lb_given_name` LIKE "%s%" AND `lb_small_group_people`.`lb_position_id` = 1 

        if(isset($_REQUEST['volunteer_people_name']))
            $volunteer_people_name = $_REQUEST['volunteer_people_name'];

        $criteria = new CDbCriteria();
        $criteria->select = 't.*,';
        $criteria->select .= 's.*';
        $criteria->join = 'LEFT JOIN lb_people_volunteers_stage s ON s.lb_people_id = t.lb_record_primary_key ';
        $criteria->condition = 't.lb_given_name LIKE "%'.$volunteer_people_name.'%"';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
            	'pageSize' => 10,
            ),
        ));

    }

    public function searchPeopleNamePastoralCare($people_name_pc=false,$page=10)
    {
    	// SELECT * FROM `lb_people` LEFT JOIN `lb_pastoral_care` ON `lb_pastoral_care`.`lb_people_id` = `lb_people`.`lb_record_primary_key` WHERE `lb_people`.`lb_given_name` LIKE "%t%" AND `lb_pastoral_care`.`lb_pastoral_care_type` > 0

        if(isset($_REQUEST['people_name_pc']))
            $people_name_pc = $_REQUEST['people_name_pc'];

        $criteria = new CDbCriteria();
        $criteria->select = 't.*,';
        $criteria->select .= 'p.*';
        $criteria->join = 'LEFT JOIN lb_pastoral_care p ON p.lb_people_id = t.lb_record_primary_key ';
        $criteria->condition = 't.lb_given_name LIKE "%'.$people_name_pc.'%" AND p.lb_pastoral_care_type > 0';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
            	'pageSize' => 10,
            ),
        ));

    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbPeople the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
