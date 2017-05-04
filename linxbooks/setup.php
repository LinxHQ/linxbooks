<?php 

setup();

function setup()
{
    $response = array();
    $mysql_database =$_POST['dbName'];
    $mysql_username =$_POST['dbUser'];
    $mysql_password =$_POST['dbPass'];
    $mysql_host =$_POST['hostName'];
	$lang='en';
    if($_POST['lang'])
        $lang=$_POST['lang'];
    $account_email = $_POST['account_email'];
    $account_pass = $_POST['account_pass'];
    $filename =dirname(__FILE__).'/sql/linxbooks.sql';
    /* @var $financial_day type */
    $financial_day = $_POST['financial_day'];
    $financial_month = $_POST['financial_month'];
    //value currency
   // $currency = $_POST['currency'];
    $currency_symbol = $_POST['currency_symbol'];
    $thousand_separator = $_POST['thousand_separator'];
    $decimal_separator = $_POST['decimal_separator'];
    //value tax
    $tax_name = $_POST['tax_name'];
    $tax_value = $_POST['tax_value'];
    $checkbox = $_POST['tax_checkbox'];
    if($checkbox == true){
        $tax_checkbox = 1;
    }else{
        $tax_checkbox = 0;
    }
    //value my company
    $company_name = $_POST['company_name'];
    $company_regis = $_POST['company_resgis'];
    $company_website = $_POST['company_website'];
    $company_address_1 = $_POST['company_address_1'];
    $compnay_address_2 = $_POST['company_address_2'];
    $company_city = $_POST['company_city'];
    $company_state = $_POST['company_state'];
    $company_country = $_POST['company_country'];
    $company_postal = $_POST['company_postal'];
    $company_phone = $_POST['company_phone'];
    $company_fax = $_POST['company_fax'];
    
    //connect database
   $connect = @mysql_connect($mysql_host, $mysql_username, $mysql_password);

   if(!$connect)
   {
        $response['err'] = "Database connection failed";
        $response['success'] = false;
        echo json_encode($response);
        return;
   }
   else if($connect){
    //import database
//    $sql = "CREATE DATABASE ".$mysql_database;

//    if(mysql_query($sql) == 1)
//    {
//        mysql_select_db($mysql_database) or die('Error selecting MySQL database: ' . mysql_error());
        if(!mysql_select_db($mysql_database))
        {
            $response_arr = array();
            $response_arr['success'] = false;
            $response_arr['err'] = "Error selecting MySQL database: Unknown database \"".$_POST['dbName']."\"";
           echo json_encode($response_arr);
           return;
        }
        $templine = '';
        $lines = file($filename);
        foreach ($lines as $line)
        {
            if (substr($line, 0, 2) == '--' || $line == '')
                continue;
            $templine .= $line;
            if (substr(trim($line), -1, 1) == ';')
            {
                mysql_query($templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
                $templine = '';
            }
        }
        $response['success'] = 1;
        $file = fopen(dirname(__FILE__).'/protected/config/db.php','r+');

        
        $string = '<?php
            $dbConfig["connectionString"] = "mysql:host='.$mysql_host.';dbname='.$mysql_database.'";
            $dbConfig["username"] = "'.$mysql_username.'";
            $dbConfig["password"] = "'.$mysql_password.'";

        ?>';

        fwrite($file,$string);

        //create account 
        addInformation($mysql_host,$mysql_username,$mysql_password,$mysql_database,$account_email,$account_pass,$lang,$financial_day,$financial_month,$currency_symbol,
                         $thousand_separator,$decimal_separator,$tax_name,$tax_value,$tax_checkbox,$company_name,$company_regis,$company_website,$company_address_1,
                        $compnay_address_2,$company_city,$company_country,$company_postal,$company_state,$company_phone,$company_fax);

}

echo json_encode($response);
}



//add information

function addInformation($mysql_host,$mysql_username,$mysql_password,$mysql_database,$account_email,$account_pass,$lang,$financial_day,$financial_month,$currency_symbol,
                         $thousand_separator,$decimal_separator,$tax_name,$tax_value,$tax_checkbox,$company_name,$company_regis,$company_website,$company_address_1,
                        $compnay_address_2,$company_city,$company_country,$company_postal,$company_state,$company_phone,$company_fax)
{
    $conn=mysql_connect($mysql_host, $mysql_username, $mysql_password) or die('Error connecting to MySQL server: ' . mysql_error());
    mysql_select_db($mysql_database,$conn);
    $sql = "INSERT INTO lb_sys_accounts(account_email,account_password,account_created_date,account_status) VALUES ('".$account_email."','".hashPassword($account_pass)."','".Date("Y-m-d H:i:s")."',1)";
    if(mysql_query($sql))
    {
         $sql = "Select * from lb_sys_accounts";
         $result = mysql_query($sql);  
         $row = mysql_fetch_array($result);
         $id = $row['account_id'];
         $sql = "INSERT INTO lb_sys_account_profiles(account_id,account_profile_given_name) VALUES (".$id.",'Admin')";
         mysql_query($sql);
         
         // add subcription
         $sql1 = "INSERT INTO lb_sys_account_subscriptions(account_id,account_subscription_package_id,account_subscription_start_date,account_subscription_status_id,subscription_name) VALUES (".$id.",0,'".Date("Y-m-d H:i:s")."',1,'My Company')";
         mysql_query($sql1);   

	$sql2 = "INSERT INTO lb_language_user(lb_user_id,lb_language_name) VALUES (".$id.",'".$lang."')";
         mysql_query($sql2);
      //  $sql3 = "INSERT INTO lb_user_list(system_list_code,system_list_item_day,system_list_item_month) VALUES ('financial_year','".$financial_day."','".$financial_month."')";
        $sql3 = "INSERT INTO lb_user_list(system_list_code,system_list_item_code,system_list_item_name,system_list_item_active,system_list_item_day,system_list_item_month) VALUES ('financial_year','financial_year','Financial Year',1,'".$financial_day."','".$financial_month."')";
	    mysql_query($sql3);
        $sql4 = "INSERT INTO lb_genera(lb_genera_currency_symbol, lb_thousand_separator, lb_decimal_symbol) VALUE ('".$currency_symbol."','".$thousand_separator."','".$decimal_separator."')";
        mysql_query($sql4);
        $sql5 = "INSERT INTO lb_taxes(lb_tax_name, lb_tax_value, lb_tax_is_default) VALUE ('".$tax_name."','".$tax_value."','".$tax_checkbox."')";
        mysql_query($sql5);
        $sql6 = "INSERT INTO lb_customers(lb_customer_name, lb_customer_registration, lb_customer_website_url) VALUE ('".$company_name."','".$company_regis."','".$company_website."')";
        if(mysql_query($sql6)){
            $q = "Select * from lb_customers";
            $r = mysql_query($q);
            $row1 = mysql_fetch_array($r);
            $customer_id = $row1['lb_record_primary_key'];
            $sql7 = "INSERT INTO lb_customer_addresses (lb_customer_id, lb_customer_address_line_1, lb_customer_address_2, lb_customer_address_city, lb_customer_address_state, lb_customer_address_country, lb_customer_address_postal_code, lb_customer_address_phone_1, lb_customer_address_fax) VALUE ('".$customer_id."','".$company_address_1."','".$compnay_address_2."','".$company_city."','".$company_state."','".$company_country."','".$company_postal."','".$company_phone."','".$company_fax."')";
            mysql_query($sql7);
        }
    }
}
function hashPassword($password)
{
    return crypt($password, generateSalt());
                
}
	
	/**
	 * Generate a random salt in the crypt(3) standard Blowfish format.
	 *
	 * @param int $cost Cost parameter from 4 to 31.
	 *
	 * @throws Exception on invalid cost parameter.
	 * @return string A Blowfish hash salt for use in PHP's crypt()
	 */
 function generateSalt($cost = 13)
{
	if (!is_numeric($cost) || $cost < 4 || $cost > 31) {
		throw new Exception("cost parameter must be between 4 and 31");
	}
		
	$rand = array();
	for ($i = 0; $i < 8; $i += 1) {
		$rand[] = pack('S', mt_rand(0, 0xffff));
	}
		
	$rand[] = substr(microtime(), 2, 6);
	$rand = sha1(implode('', $rand), true);
	$salt = '$2a$' . str_pad((int) $cost, 2, '0', STR_PAD_RIGHT) . '$';
	$salt .= strtr(substr(base64_encode($rand), 0, 22), array('+' => '.'));
		
	return $salt;
}
 