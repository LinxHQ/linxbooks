<?php
class CreditCardController extends Controller
{
        /**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
        public function actionIndex()
        {
                $subscription = Subscription::model()->findAll();
		$this->render('index', array('value' => $subscription,));
        }
        
        public function actionPayment()
        {
                $userCard = UserCreditCard::model()->getCreditCard(Yii::app()->user->id);
                
                if ($userCard && $userCard[0]->credit_card_id) {
                    
                }
        }


        public function actionCreditCard()
        {
                if(isset($_POST['card_number']))
		{
//                        $email = $_POST['email'];
                        $card_number = $_POST['card_number'];
                        $payment_type = $_POST['payment_type'];
                        $exp_month = $_POST['exp_month'];
                        $exp_year = $_POST['exp_year'];
                        $csc = $_POST['csc'];
                        $first_name = $_POST['first_name'];
                        $last_name = $_POST['last_name'];
                        $total = $_POST['total'];
                        
                        $listener = new CardForm();
                        $card = $listener->doStoreCreditCardAPI($payment_type, $card_number, $exp_month, $exp_year, $csc, $first_name, $last_name);//self::doSubmitCard($card_number, $payment_type, $exp_month, $exp_year, $csc, $first_name, $last_name, $total);
                        
                        if ($card && Yii::app()->user->id > 0) {
                            
                            $userCard = new UserCreditCard();
                            $userCard->user_id = Yii::app()->user->id;
                            $userCard->credit_card_id = $card;
                            $userCard->save();
                            
                            $submit_card = $listener->doSaleAPI($card, $total);
                            
                            if ($submit_card) {
                                $userSubscription = new UserSubscription();
                                $userSubscription->user_id = Yii::app()->user->id;
                                $userSubscription->subscription_id = $_GET['id'];
                                $userSubscription->date_from = date('Y-m-d');

                                $userSubscription->save();
                            }
                            
                            $this->redirect(array('/site/index'), array('sale'=>$card, 'token'=>$submit_card));
//                            $this->redirect(array('site/index'), array('user_sub'=>$card, 'sub_id'=>$useSubs));
                        }
		}
                if (isset($_POST['card_id']) && Yii::app()->user->id > 0) {
                        $card_id = $_POST['card_id'];
                        $total = $_POST['total'];
                        
                        $listener = new CardForm();
                        $submit_card = $listener->doSaleAPI($card_id, $total);

                        if ($submit_card) {
                            $userSubscription = new UserSubscription();
                            $userSubscription->user_id = Yii::app()->user->id;
                            $userSubscription->subscription_id = $_GET['id'];
                            $userSubscription->date_from = date('Y-m-d');

                            $userSubscription->save();
                        }

                        $this->redirect(array('/site/index'), array('sale'=>$card, 'token'=>$submit_card));
                }
                
                $userCard = UserCreditCard::model()->getCreditCard(Yii::app()->user->id);
                $test = '';
                if ($userCard && $userCard[0]->credit_card_id && Yii::app()->user->id > 0) {
                    $test = $userCard[0]->credit_card_id;
                }
            
                $sub = Subscription::model()->findByPk($_GET['id']);
                
                $this->render('card', array('total'=>$sub->subscription_value, 'card_saved'=>$test));
        }

                /**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}
}
?>
