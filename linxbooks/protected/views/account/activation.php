<?php
?>
<h1>Account Activation</h1>
<?php 
if ($activation_status) {
	echo "Account activated! You may now log in to enjoy our amazing features.";
	//echo "<br/>$activation_message";
} else {
	echo "$activation_message";
	//echo "<br/>$activation_message";
	//echo "<br/>" . $account->account_email . $account->account_created_date;
}