
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <script src="js/jquery.min.js"></script>
        <script src="js/jquery.blockUI.js"></script>
        <link rel="stylesheet"href="css/main.css" />
        
</head> 
<?php

echo '<div style="width:35%;border:1px solid #ccc;margin:auto;background-color:white;margin-top:30px;">';
echo '<div id = "headerInstall" style="padding-bottom:0px; border-bottom: 1px solid Scrollbar">';
echo '<h1 align="center"  style="color: rgb(93, 160, 40); font-family: Comic Sans MS;"><b>Install Linxbooks</b></h1>';
echo '<pre>';

//echo ($_SERVER['SERVER_NAME']);
echo '</div >';
  echo '<div class="form-loading" style="margin-left:343px; margin-top:10px;" hidden="true">';
  echo ' <img src="images/loading.gif'.'" alt="Smiley face"><span> Loading...</span> ';
echo '</div>';
echo '<div id = "setup-db" style="margin-left:38px;padding-bottom:20px;overflow: hidden;" >';
//    echo '<p class="help-block">Fields with <span class="required">*</span> are required.</p>';
    //Titel setup db
    echo '<div style="padding-bottom:10px;">';
    echo '<h2><b>Setup Database</b></h2>';
    echo '</div >';
    
    //body setup db
  
    echo '<div id="body-setup" style="float:left; ">';
        echo '<table>';
            echo '<tr><td style="width:150px;" ><span class="lbl">Hostname:</span></td>'
                    . '<td ><input type="text" id="hostName"  value = "localhost" /><br>&nbsp&nbsp<span id="err_host" style="color:#b20000"></span></td>'
                . '</tr>';
            echo '<tr><td style="width:150px;"><span class="lbl">Database name:</span></td>'
                    . '<td><input  type="text"  value = "" id="dbName" placeholder="Database"/><br>&nbsp&nbsp<span class="error" id="err_dbname" style="color:#b20000"></span></td>'
                . '</tr>';
            echo '<tr><td style="width:150px;" ><span class="lbl">User name:</span></td>'
                    . '<td  id="user_name"><input type="text" placeholder="user name"  value = "" id="dbUser" /><br>&nbsp&nbsp<span class="error" id="err_username" style="color:#b20000"></span></td>'
                . '</tr>';
            echo '<tr><td ><span class="lbl">Password:</span></td>'
                    . '<td ><input type="password" placeholder="password"  value = "" id="dbPass" />&nbsp&nbsp<span class="error" id="err_dbPass" style="color:#b20000"></span></td>'
                . '</tr>';
        echo '</table>';
    echo '</div>';

echo '</div>';

echo '<div align="center" style="overflow:hidden; margin-left:22px; margin-right:12px;   border-bottom: 1px solid Scrollbar"></div>';


//setup account

echo '<div id = "setup-account" style="display:-moz-groupbox;margin-left:28px">';
    //Titel setup db
    echo '<div style="padding-bottom:10px;margin-left:10px">';
    echo '<h2><b>Setup Account</b></h2>';
    echo '</div >';
    
    //body setup db
    
    echo '<div id="body-setup" style="float:left;margin-left:10px">';
        echo '<table>';
            echo '<tr><td style="width:150px; "><span class="lbl">Email:</span></td>'
                    . '<td ><input  type="email"   placeholder="someone@example.com " id="account_email" value = "" /><br>&nbsp&nbsp<span  class="error" id="err_account_email" style="color:#b20000"></span></td>'
                . '</tr>';
            echo '<tr><td style="width:150px;"><span class="lbl">Password:</span></td>'
                    . '<td><input placeholder="password"  type="password" value = "" id="account-pass"/><br>&nbsp&nbsp<span class="error" id="err_account-pass" style="color:#b20000"></span></td>'
                . '</tr>';
            echo '<tr><td style="width:150px; " ><span class="lbl">Confirm Password:</span></td>'
                    . '<td  id="user_name"><input  placeholder="Confirm password" type="password" value = "" id="confirm_pass"/><br>&nbsp&nbsp<span  class="error" id="err_confirm_pass" style="color:#b20000"></span></td>'
                . '</tr>';
           
        echo '</table>';
    echo '</div>';

echo '</div>';


//button
echo '';
echo '<div id ="footer-button" style="text-align:center;margin-bottom:30px;margin-top:20px">';
   echo '<button id = "save" onclick = "start_install()">Save</button>&nbsp';
   echo '<button id="cancel" onclick = "back_install()">Cancel</button>';
echo '</div>';

echo '</div>';

echo '<div id ="footer">';
echo 'Copyright &copy; 2015, LinxBooks. All Rights Reserved. LinxHQ Pte Ltd<br>';
echo '</div>';

?>
</html>
<style>
 
input
{
    width:313px; height:28px;
}

body{
    background-color: inactiveborder;
    background-image: url(images/gray_jean.png);
}
#footer {
    clear: both;
    font-size: 0.8em;
    margin: 0px 20px;
    padding: 10px;
    text-align: center;
    
}
#save , #cancel{
    background-color: #5bb75b;
    background-image: linear-gradient(to bottom, #62c462, #51a351);
    color: #fff;
     height: 28px;
    width: 60px;
     font-weight: bold;
    
}
</style>
<script lang="Javascript">
//	$(document).ready(function(){
//            $("input").focus(function(){
//                $("input").css("border", "solid 2px #5bb75b").fadeIn();
//            });
//        });
//        
        function start_install()
        {
            
            var hostName = document.getElementById('hostName').value;
            var dbName = document.getElementById('dbName').value;
            var dbUser = document.getElementById('dbUser').value;
            var dbPass = document.getElementById('dbPass').value;
            var err = 0;
            
            
            //information account
            var account_email = document.getElementById('account_email').value;
            var account_pass = document.getElementById('account-pass').value;
            var confirmPass = document.getElementById('confirm_pass').value;
            
            
            //check host name
             if((hostName.trim()).length <= 0)
             {
                document.getElementById('err_host').innerHTML = "Username field is required.";
                err++;
            }
            if((hostName.trim()).length > 0)
                document.getElementById('err_host').innerHTML = '';
            
            //check db name
            if((dbName.trim()).length <= 0){
                document.getElementById('err_dbname').innerHTML = "Database name field is required.";
                err++;
            }
            if((dbName.trim()).length > 0)
                document.getElementById('err_dbname').innerHTML = '';
            
            //check database user
            if((dbUser.trim()).length <= 0){
                document.getElementById('err_username').innerHTML = "User name field is required.";
                err++;
            }
            if((dbUser.trim()).length > 0)
                document.getElementById('err_username').innerHTML = '';
            
            //check account pass
            if((account_pass.trim().length <= 5)){
                document.getElementById('err_account-pass').innerHTML = "Password must contains at least 6.";
                err++;
            }
            else
            {
                document.getElementById('err_account-pass').innerHTML = '';
                if(account_pass != confirmPass)
                {
                   document.getElementById('err_confirm_pass').innerHTML = 'These passwords do not match. Try again?'; 
                   err++;
                }
                else if (account_pass.length < 6 ||(account_pass.match(/[a-z]/g) == null || account_pass.match(/[0-9]/g) == null)) {
                document.getElementById('err_confirm_pass').innerHTML ='Password must contains at least 6 characters, with the combination of small letters (a-z) and digits (0-9)';
                err++;
            }
                else  document.getElementById('err_confirm_pass').innerHTML = ''; 
            }
            
           //check email
            if((account_email.trim()).length <= 0)
            {
                document.getElementById('err_account_email').innerHTML = "Email field is required.";      
                err++;
            }
            else if(!isEmail(account_email)){
                        document.getElementById('err_account_email').innerHTML = 'Email is not valid!(Example: abc@gmail.com)';
                        err++;
                    }
                else
                    document.getElementById('err_account_email').innerHTML = '';
            if(err == 0)
            {
                $.blockUI({
                    message:'<h1><img src="images/loading_in.gif" />Please wait...</h1>'
                });
                 $.ajax({
                    type:'POST',
                    url:'setup.php',
                    data:{hostName:hostName,dbName:dbName,dbUser:dbUser,dbPass: dbPass,account_email: account_email,
                       account_pass: account_pass,
                       },
                        
                     success:function(response){
                        var obj = jQuery.parseJSON( response );
                        
                        if(obj.success == 1)
                        {
                            $.unblockUI();
                            window.location = "index.php/site/login";
                        }
                       if(obj.success == 0)
                        {
                            $.blockUI({
                                message:'<div class="install-error">'+obj.err+'</div>',
                                onOverlayClick: $.unblockUI,
                            });
                        }
                    }
                });
                   
            }
               
           
            
            
          
        }
        
        function isEmail(email) {
			var isValid = false;
			var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			if(regex.test(email)) {
				isValid = true;
			}
			return isValid;
        }
        
        function back_install()
        {
            $('#dbName').val('');
            $('#dbUser').val('');
            $('#err_host').val('');
            $('#account_email').val('');
            $('#account-pass').val('');
            $('#confirm_pass').val('');
            $('#confirm_pass').val('');
            document.getElementById('err_dbname').innerHTML = '';
            document.getElementById('err_username').innerHTML = '';
            document.getElementById('err_host').innerHTML = '';
            document.getElementById('err_account-pass').innerHTML = '';
            document.getElementById('err_confirm_pass').innerHTML = '';
            document.getElementById('err_account_email').innerHTML = '';
        }
  
  </script>
 