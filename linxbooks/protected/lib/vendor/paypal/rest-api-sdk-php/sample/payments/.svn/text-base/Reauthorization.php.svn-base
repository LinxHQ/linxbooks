<?php
// ##Reauthorization Sample
// Sample showing how to do a reauthorization
// API used: v1/payments/authorization/{authorization_id}/reauthorize
require __DIR__ . '/../bootstrap.php';
use PayPal\Api\Authorization;
use PayPal\Api\Amount;
use PayPal\Exception\PPConnectionException;

// ###Reauthorization
// Retrieve a authorization id from authorization object
// by making a `Payment Using PayPal` with intent
// as `authorize`. You can reauthorize a payment only once 4 to 29
// days after 3-day honor period for the original authorization
// expires.
$authorization = Authorization::get('7GH53639GA425732B', $apiContext);

$amount = new Amount();
$amount->setCurrency("USD");
$amount->setTotal("1.00");

$authorization->setAmount($amount);
try{
	$reauthorization = $authorization->reauthorize($apiContext);
}catch (PPConnectionException $ex){
	echo "Exception: " . $ex->getMessage() . PHP_EOL;
	var_dump($ex->getData());
	exit(1);
}
?>
<html>
<body>
	<div>
		Reauthorize:
		<?php echo $reauthorization->getId();?>
	</div>
	<pre>
		<?php var_dump($reauthorization->toArray());?>
	</pre>
	<a href='../index.html'>Back</a>
</body>
</html>