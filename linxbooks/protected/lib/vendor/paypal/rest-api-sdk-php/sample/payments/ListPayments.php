<?php

// #GetPaymentList
// This sample code demonstrate how you can
// retrieve a list of all Payment resources
// you've created using the Payments API.
// Note various query parameters that you can
// use to filter, and paginate through the
// payments list.
// API used: GET /v1/payments/payments

require __DIR__ . '/../bootstrap.php';
use PayPal\Api\Payment;


// ### Retrieve payment
// Retrieve the PaymentHistory object by calling the
// static `get` method on the Payment class, 
// and pass a Map object that contains
// query parameters for paginations and filtering.
// Refer the method doc for valid values for keys
// (See bootstrap.php for more on `ApiContext`)
try {
	$payments = Payment::all(array('count' => 10, 'start_index' => 5), $apiContext);	
} catch (\PPConnectionException $ex) {
	echo "Exception:" . $ex->getMessage() . PHP_EOL;
	var_dump($ex->getData());
	exit(1);
}
?>
<html>
<body>
	<div>Got <?php echo $payments->getCount(); ?> matching payments </div>
	<pre><?php var_dump($payments->toArray());?></pre>
	<a href='../index.html'>Back</a>
</body>
</html>
