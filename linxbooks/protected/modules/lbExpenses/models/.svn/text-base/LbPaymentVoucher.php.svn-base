<?php

/**
 * This is the model class for table "lb_payment_voucher".
 *
 * The followings are the available columns in table 'lb_payment_voucher':
 * @property integer $lb_record_primary_key
 * @property string $lb_payment_voucher_no
 * @property string $lb_pv_title
 * @property string $lb_pv_description
 * @property integer $lb_pv_create_by
 * @property string $lb_pv_date
 */
class LbPaymentVoucher extends CLBActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        const LB_PV_NUMBER_MAX_LENGTH = 11;
	public function tableName()
	{
		return 'lb_payment_voucher';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lb_payment_voucher_no, lb_pv_title, lb_pv_description, lb_pv_create_by, lb_pv_date', 'required'),
			array('lb_pv_create_by', 'numerical', 'integerOnly'=>true),
			array('lb_payment_voucher_no', 'length', 'max'=>100),
			array('lb_pv_title, lb_pv_description', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lb_record_primary_key, lb_payment_voucher_no, lb_pv_title, lb_pv_description, lb_pv_create_by, lb_pv_date', 'safe', 'on'=>'search'),
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
			'lb_payment_voucher_no' => 'Lb Payment Voucher No',
			'lb_pv_title' => 'Lb Pv Title',
			'lb_pv_description' => 'Lb Pv Description',
			'lb_pv_create_by' => 'Lb Pv Create By',
			'lb_pv_date' => 'Lb Pv Date',
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
		$criteria->compare('lb_payment_voucher_no',$this->lb_payment_voucher_no,true);
		$criteria->compare('lb_pv_title',$this->lb_pv_title,true);
		$criteria->compare('lb_pv_description',$this->lb_pv_description,true);
		$criteria->compare('lb_pv_create_by',$this->lb_pv_create_by);
		$criteria->compare('lb_pv_date',$this->lb_pv_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbPaymentVoucher the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function createPVno()
        {
                return $this->formatVendorNextNumFormatted($this->getPVNextNum());

        }
        
         public function getPVNextNum() {
		
		$next_invoice_number = 0;
		
		
                $last_used = LbNextId::model()->getOneRecords();
                
		// TODO: if more than 1 record, something is wrong
		if (count($last_used) > 1)
		{
			return 0; // something is wrong
		}
		
		// If no record, probably first time generation
		// generate first record
		if (count($last_used) <= 0)
		{
                $nextInvoiceNo = new LbNextId();
                $nextInvoiceNo->lb_next_invoice_number = 1;
                $nextInvoiceNo->lb_next_quotation_number = 1;
                $nextInvoiceNo->lb_next_payment_number = 1;
                $nextInvoiceNo->lb_next_contract_number=1;
                $nextInvoiceNo->lb_next_po_number=1;
                $nextInvoiceNo->lb_next_supplier_invoice_number=1;
                $nextInvoiceNo->lb_next_supplier_payment_number=1;
			if ($nextInvoiceNo->save())
				$next_po_number = $nextInvoiceNo->lb_next_pv_number;
		} else {
			$nextInvoiceNo = $last_used;
			$next_invoice_number = $nextInvoiceNo->lb_next_pv_number;
		}

        // advance next invoice number
        $nextInvoiceNo->lb_next_pv_number++;
        $nextInvoiceNo->save();
		
        return $next_invoice_number;
		//trigger_error('Not Implemented!', E_USER_WARNING);
	}
        
         public function formatVendorNextNumFormatted($invoice_number_int) {
                
		$invoice_number_len = strlen($invoice_number_int);

                // prefix with "I-yyyy"
                //$invoiceFullRecord = $this->getCoreEntity();
                $created_year = date('Y');
		$next_invoice_number = "PV-".$created_year;
		$preceding_zeros_count = self::LB_PV_NUMBER_MAX_LENGTH - strlen($created_year) - $invoice_number_len;
		while($preceding_zeros_count > 0)
		{
			$next_invoice_number .= '0';
			$preceding_zeros_count--;
		}
		$next_invoice_number .= $invoice_number_int;
		//$this->lb_invoice_no_formatted = $next_invoice_number;
		 
		return $next_invoice_number;
	}

        public function savePaymentVoucher($pv_no=false,$pv_title=false,$pv_date=false,$pv_description=false,$pv_id=false)
        {
            $model = new LbPaymentVoucher();
            
            //company
            $ownCompany = LbCustomer::model()->getOwnCompany();
            $ownCompanyAddress = null;
            if ($ownCompany->lb_record_primary_key)
            {
			// auto assign owner company
			$model->lb_pv_company_id = $ownCompany->lb_record_primary_key;
			
			$own_company_addresses = LbCustomerAddress::model()->getActiveAddresses($ownCompany->lb_record_primary_key,
					$ownCompany::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);
			
			if (count($own_company_addresses))
			{
				$ownCompanyAddress= $own_company_addresses[0];
				// auto assign owner company's address
				$model->lb_pv_company_address_id = $ownCompanyAddress->lb_record_primary_key;
			}
            }
            if($pv_id)
                $model = LbPaymentVoucher::model ()->findByPk ($pv_id);
            if($pv_no)
                $model->lb_payment_voucher_no = $pv_no;
            if($pv_title)
                $model->lb_pv_title =$pv_title;
            if($pv_date)
            {
               

                $model->lb_pv_date = DateTime::createFromFormat('d-m-Y', $pv_date)->format('Y-m-d');
            }
            if($pv_date)
                $model->lb_pv_description = $pv_description;
            $model->lb_pv_create_by = Yii::app()->user->id;
            
            if($pv_id)
            {
                $model->update();
                return $pv_id;
            }
            if($model->insert())
                return $model->lb_record_primary_key;
            
        }
        
        public function getSearchBydate($date_form = false,$date_to=false)
        {
           $criteria=new CDbCriteria;
           if ($date_form && $date_to)
           {
               $date_form = DateTime::createFromFormat('d-m-Y', $date_form)->format('Y-m-d');
               $date_to = DateTime::createFromFormat('d-m-Y', $date_to)->format('Y-m-d');
               $criteria->condition = '(lb_pv_date >= "'.$date_form.'") AND (lb_pv_date <= "'.$date_to.'")';
           }
                
           $criteria->order = 'lb_pv_date ASC';

        return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
        }
        
       
        
        
}
