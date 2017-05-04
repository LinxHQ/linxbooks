<?php
// #Execute Payment Sample
// This sample shows how you can complete
// a payment that has been approved by
// the buyer by logging into paypal site.
// You can optionally update transaction
// information by passing in one or more transactions.
// API used: POST '/v1/payments/payment/<payment-id>/execute'.

require __DIR__ . '/../bootstrap.php';
use PayPal\Api\ExecutePayment;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
session_start();
if(isset($_GET['success']) && $_GET['success'] == 'true') {
	
	// Get the payment Object by passing paymentId
	// payment id was previously stored in session in
	// CreatePaymentUsingPayPal.php
	$paymentId = $_SESSION['paymentId'];
	$payment = Payment::get($paymentId, $apiContext);
	
	// PaymentExecution object includes information necessary 
	// to execute a PayPal account payment. 
	// The payer_id is added to the request query parameters
	// when the user is redirected from paypal back to your site
	$execution = new PaymentExecution();
	$execution->setPayer_id($_GET['PayerID']);
	
	//Execute the payment
	// (See bootstrap.php for more on `ApiContext`)
	$payment->execute($execution, $apiContext);

	echo "<html><body><pre>";
	var_dump($payment->toArray());
	echo "</pre><a href='../index.html'>Back</a></body></html>";
	
} else {
	echo "User cancelled payment.";
}