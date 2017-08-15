<?php
/*
 * Sample bootstrap file.
 */

// Include the composer autoloader
if(!file_exists(__DIR__ .'/vendor/autoload.php')) {
	echo "The 'vendor' folder is missing. You must run 'composer update' to resolve application dependencies.\nPlease see the README for more information.\n";
	exit(1);
}
require __DIR__ . '/vendor/autoload.php';
define("PP_CONFIG_PATH", __DIR__);

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;

// ### Api Context
// Pass in a `PayPal\Rest\ApiContext` object to authenticate 
// the call. You can also send a unique request id 
// (that ensures idempotency). The SDK generates
// a request id if you do not pass one explicitly. 
$apiContext = new ApiContext(new OAuthTokenCredential(
		'EBWKjlELKMYqRNQ6sYvFo64FtaRLRR5BdHEESmha49TM',
		'EO422dn3gQLgDbuwqTjzrFgFtaRLRR5BdHEESmha49TM'));
// Uncomment this step if you want to use per request 
// dynamic configuration instead of using sdk_config.ini
/*
$apiContext->setConfig(array(
	'mode' => 'sandbox',
	'http.ConnectionTimeOut' => 30,
	'log.LogEnabled' => true,
	'log.FileName' => '../PayPal.log',
	'log.LogLevel' => 'FINE'
));
*/

/**
 * ### getBaseUrl function
 * // utility function that returns base url for
 * // determining return/cancel urls
 * @return string
 */
function getBaseUrl() {

	$protocol = 'http';
	if ($_SERVER['SERVER_PORT'] == 443 || (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on')) {
		$protocol .= 's';
		$protocol_port = $_SERVER['SERVER_PORT'];
	} else {
		$protocol_port = 80;
	}

	$host = $_SERVER['HTTP_HOST'];
	$port = $_SERVER['SERVER_PORT'];
	$request = $_SERVER['PHP_SELF'];
	return dirname($protocol . '://' . $host . ($port == $protocol_port ? '' : ':' . $port) . $request);
}
