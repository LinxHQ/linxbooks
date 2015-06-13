<?php 

setup();

function setup()
{
    $response = array();
    $mysql_database =$_POST['dbName'];
    $mysql_username =$_POST['dbUser'];
    $mysql_password =$_POST['dbPass'];
    $mysql_host =$_POST['hostName'];

    $account_email = $_POST['account_email'];
    $account_pass = $_POST['account_pass'];
    $filename =dirname(__FILE__).'/sql/linxbooks_new.sql';

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
        addInformation($mysql_host,$mysql_username,$mysql_password,$mysql_database,$account_email,$account_pass);

}

echo json_encode($response);
}



//add information

function addInformation($mysql_host,$mysql_username,$mysql_password,$mysql_database,$account_email,$account_pass)
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