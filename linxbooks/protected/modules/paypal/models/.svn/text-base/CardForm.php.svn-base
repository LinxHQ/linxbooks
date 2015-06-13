<?php
require Yii::app()->basePath .'/lib/bootstrap.php'; 
//require Yii::app()->basePath .'/lib/vendor/autoload.php'; 
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\CreditCard;
use PayPal\Api\Address;
use PayPal\Api\FundingInstrument;
use PayPal\Api\Payer;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\Payment;
use PayPal\Exception\PPConnectionException;
use PayPal\Api\CreditCardToken;

class CardForm extends CFormModel
{
    
//    const CLIENT_ID = 'AZMv0RDfYnx-i_35TFSj5bcDjwFh1oKrzehOoJBGqWBkRZoU_ncq6-gv0sOd';
//    const SECRET = 'EBK2-hAklAZYfkZMe-tJSmAaEB2NVE6pyd9fCop3NvSTNidcqCm0nzLRrCVP';
    
    const CLIENT_ID = 'AQkquBDf1zctJOWGKWUEtKXm6qVhueUEMvXO_-MCI4DQQ4-LWvkDLIN2fGsd';
    const SECRET = 'EL1tVxAjhT7cJimnz5-Nsx9k2reTKSVfErNQF-CmrwJgxRtylkGTKlU4RvrX';
    
        public $card_number;
	public $payment_type;
	public $exp_month;
        public $exp_year;

//        private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('user_username, user_password', 'required'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
			// password needs to be authenticated
			array('user_password', 'authenticate'),
		);
	}


    public function getTokenAPI()
    {
            $sdkConfig = array(
                    "mode" => "sandbox"
            );
            $cred = new OAuthTokenCredential("AQkquBDf1zctJOWGKWUEtKXm6qVhueUEMvXO_-MCI4DQQ4-LWvkDLIN2fGsd","EL1tVxAjhT7cJimnz5-Nsx9k2reTKSVfErNQF-CmrwJgxRtylkGTKlU4RvrX", $sdkConfig);

//            $cred = new OAuthTokenCredential(self::CLIENT_ID, self::SECRET);
//            $test = $cred->getAccessToken(array('mode' => 'sandbox'));
//            
            return $cred;
    }
    
    public function doStoreCreditCardAPI($payment_type, $card_number, $exp_month, $exp_year, $csc, $first_name, $last_name)
    {
            $apiContext = new ApiContext(new OAuthTokenCredential(self::CLIENT_ID, self::SECRET));

            $card = new CreditCard();
            $card->setType($payment_type);
            $card->setNumber($card_number);
            $card->setExpire_month($exp_month);
            $card->setExpire_year($exp_year);
	    $card->setCvv2($csc);
            $card->setFirst_name($first_name);
            $card->setLast_name($last_name);
            
            try {
                $card->create($apiContext);    //$card->create($apiContext); 
            } catch (\PPConnectionException $ex) {
                echo "Exception:" . $ex->getMessage() . PHP_EOL;
                var_dump($ex->getData());
                exit(1);
            }
            
//            $test = $card->getId();
//            
//            $creditCardToken = new CreditCardToken();
//            $creditCardToken->setCredit_card_id($test);
//
//            $fundingInstrument = new FundingInstrument();
//            $fundingInstrument->setCredit_card($creditCardToken);
//
//            $payer = new Payer();
//            $payer->setPayment_method("credit_card");
//            $payer->setFunding_instruments(array($fundingInstrument));
//
//            $amount = new Amount();
//            $amount->setCurrency("USD");
//            $amount->setTotal($total);
//
//            $transaction = new Transaction();
//            $transaction->setAmount($amount);
//            $transaction->setDescription("creating a direct payment with credit card");
//
//            $payment = new Payment();
//            $payment->setIntent("sale");
//            $payment->setPayer($payer);
//            $payment->setTransactions(array($transaction));
//
//            try {
//                $payment->create($apiContext);    //$card->create($apiContext); 
//            } catch (\PPConnectionException $ex) {
//                echo "Exception:" . $ex->getMessage() . PHP_EOL;
//                var_dump($ex->getData());
//                exit(1);
//            }
            
            return $card->getId();
    }


    public function doSaleAPI($creditCardId, $total) 
    {
            $apiContext = new ApiContext(new OAuthTokenCredential(self::CLIENT_ID, self::SECRET));
            
//            $card = new CreditCard();
//            $card->setType($payment_type);
//            $card->setNumber($card_number);
//            $card->setExpire_month($exp_month);
//            $card->setExpire_year($exp_year);
//	    $card->setCvv2($csc);
//            $card->setFirst_name($first_name);
//            $card->setLast_name($last_name);
            
            $creditCardToken = new CreditCardToken();
            $creditCardToken->setCreditCardId($creditCardId);

            $fundingInstrument = new FundingInstrument();
            $fundingInstrument->setCreditCardToken($creditCardToken);

            $payer = new Payer();
            $payer->setPayment_method("credit_card");
            $payer->setFunding_instruments(array($fundingInstrument));

            $amount = new Amount();
            $amount->setCurrency("USD");
            $amount->setTotal($total);

            $transaction = new Transaction();
            $transaction->setAmount($amount);
            $transaction->setDescription("creating a direct payment with credit card");

            $payment = new Payment();
            $payment->setIntent("sale");
            $payment->setPayer($payer);
            $payment->setTransactions(array($transaction));

            try {
                $payment->create($apiContext);    //$card->create($apiContext); 
            } catch (\PPConnectionException $ex) {
                echo "Exception:" . $ex->getMessage() . PHP_EOL;
                var_dump($ex->getData());
                exit(1);
            }
            
            return $payment->getId();
            
    }
}
?>
