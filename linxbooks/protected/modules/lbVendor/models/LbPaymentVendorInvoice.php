<?php

/**
 * This is the model class for table "lb_payment_item".
 *
 * The followings are the available columns in table 'lb_payment_item':
 * @property string $lb_record_primary_key
 * @property string $lb_payment_id
 * @property string $lb_invoice_id
 * @property string $lb_payment_item_description
 * @property string $lb_payment_item_note
 * @property string $lb_payment_item_amount
 */
class LbPaymentVendorInvoice extends CLBActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'lb_payment_vendor_invoice';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('lb_payment_id, lb_vendor_invoice_id', 'required'),
            array('lb_payment_id, lb_vendor_invoice_id', 'length', 'max'=>11),
            array('lb_payment_item_note', 'length', 'max'=>255),
            array('lb_payment_item_amount', 'length', 'max'=>10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('lb_record_primary_key, lb_payment_id,lb_vendor_invoice_id, lb_payment_item_note, lb_payment_item_amount', 'safe', 'on'=>'search'),
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
//            'payment'=>array(self::BELONGS_TO,'LbPayment','lb_payment_id'),
//            'invoice'=>array(self::BELONGS_TO,'LbInvoice','lb_vendor_invoice_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'lb_record_primary_key' => 'Lb Record Primary Key',
            'lb_payment_id' => 'Lb Payment',
            'lb_vendor_invoice_id' => 'Lb Invoice Vendor',
            'lb_payment_item_note' => 'Lb Payment Item Note',
            'lb_payment_item_amount' => 'Lb Payment Item Amount',
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

        $criteria->compare('lb_record_primary_key',$this->lb_record_primary_key,true);
        $criteria->compare('lb_payment_id',$this->lb_payment_id,true);
        $criteria->compare('lb_vendor_invoice_id',$this->lb_vendor_invoice_id,true);
        $criteria->compare('lb_payment_item_note',$this->lb_payment_item_note,true);
        $criteria->compare('lb_payment_item_amount',$this->lb_payment_item_amount,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return LbPaymentItem the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    /**
     * No need: use LbInvoiceTotal model
     * Get total paid amount of an invoice
     * 
     * @param int $invoice_id
     * @return double $paid_amount
     */
    public function getInvoicePaidAmount($invoice_id)
    {
        // No need: use LbInvoiceTotal model
        /**
        $paid_amount = 0;
        
        $model = new LbPaymentItem;
        $model->lb_invoice_id = $invoice_id;
        
        $dp = $model->search();
        $dp->setPagination(false);
        $payment_items = $dp->getData();
        
        // get total 
        foreach ($payment_items as $paymentItem)
        {
            $paid_amount += $paymentItem->lb_payment_item_amount;
        }
        
        return $paid_amount;
         * 
         */
    }
    
    public function getAllPaymentInvoice($lb_payment_id=false)
    {
        $criteria = new CDbCriteria();
        $criteria->condition = "lb_payment_id = $lb_payment_id";
       
        return LbPaymentVendorInvoice::model()->findAll($criteria);
    }
    
    public function calculateInvoicetotalPaid($invoice_id){
        $paymentItem = LbPaymentVendorInvoice::model()->findAll('lb_vendor_invoice_id = '.  intval($invoice_id));
        $total_paid = 0;
        foreach ($paymentItem as $data) {
            $total_paid += $data->lb_payment_item_amount;
        }
       
        return $total_paid;
    }
    
    public function getOustandingVendorInvoice($lb_payment_id=false,$lb_vendor_invoice_id=false)
    {
        
    }
    
//    public function getAllPaymentItemVendorInvoice($lb_vendor_invoice_id)
//    {
//        $criteria = new CDbCriteria();
//        $criteria->condition = "b_vendor_invoice_id = $lb_vendor_invoice_id";
//       
//        return LbPaymentVendorInvoice::model()->findAll($criteria);
//    }
}
