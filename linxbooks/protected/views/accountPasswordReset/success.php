<?php
?>
<h3>Reset Password</h3>

<?php 
if ($type == 'password')
{
	echo '<p>Password reset successfully. You may now log in with your new password</p>';
} else {
	echo "<p>Form submitted. You'll receive an email from us. Please follow the instructions given in that email to reset your password. Thanks!</p>";
}
?>
