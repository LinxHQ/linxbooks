
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <script src="js/jquery.min.js"></script>
        <script src="js/jquery.blockUI.js"></script>
        <script src="js/bootstrap-datepicker.js"></script>
        <link rel="stylesheet"href="css/main.css" />
        <link rel="stylesheet"href="css/datepicker.css" />
        <link rel="stylesheet"href="css/bootstrap.min.css" />
        <meta charset="UTF-8">

</head> 
<?php
$langgage = '<select style="padding:3px;" id="language">'
        . '<option value="en">English</option>'
        . '<option value="vi">Tiếng Việt</option>'
        . '</select>';
echo '<div class="lb_div_install">';
echo '<div id = "headerInstall" class="lb_header_install">';
echo '<h1 align="center"  class="lb_install_title"><b>Install Linxbooks</b></h1>';
//echo '<pre style="padding:0px;">';

//echo ($_SERVER['SERVER_NAME']);
echo '</div >';
  echo '<div class="form-loading lb_install_loading"  hidden="true">';
  echo ' <img src="images/loading.gif'.'" alt="Smiley face"><span> Loading...</span> ';
echo '</div>';
echo '<div id = "setup-db" class="lb_div_setup" >';
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

echo '<div  class="lb_setup_install"></div>';


//setup account

echo '<div id = "setup-account" class="lb_setup_content">';
    //Titel setup db
    echo '<div class="lb_setup_title">';
    echo '<h2><b>Setup Account</b></h2>';
    echo '</div >';
    
    //body setup db
    
    echo '<div id="body-setup" class="lb_setup_body">';
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
            echo '<tr><td style="width:150px; " ><span class="lbl">Language:</span></td>'
                    . '<td >'.$langgage.'</td>'
                . '</tr>';
            echo '<tr><td style="width:150px; " ><span class="lbl">Financial year:</span></td>'
                    . '<td ><input type="text" id="financial_year" style="width:220px !important;" value='.date('d/m').'/><br>&nbsp&nbsp<span  class="error" id="err_financial_year" style="color:#b20000"></span></td>'
                . '</tr>';
        echo '</table>';
    echo '</div>';

echo '</div>';
echo '<div class="lb_setup_install"></div>';
//Set currency
echo '<div id = "setup-currency" class="lb_setup_content">';
    //Titel setup currency
    echo '<div class="lb_setup_title">';
    echo '<h2><b>Setup Currency</b></h2>';
    echo '</div >';
    
    //body setup currency
    
    echo '<div id="body-setup" class="lb_setup_body">';
        echo '<table>';
//            echo '<tr><td style="width:150px; "><span class="lbl">Default Currency:</span></td>'
//                    . '<td ><input  type="text"  id="default_currency" value = "USD" /><br>&nbsp&nbsp<span  class="error" id="err_default_currency" style="color:#b20000"></span></td>'
//                . '</tr>';
            echo '<tr><td style="width:150px;"><span class="lbl">Currency Symbol:</span></td>'
                    . '<td><input type="text" value = "$" id="currency_symbol"/><br>&nbsp&nbsp<span class="error" id="err_currency_symbol" style="color:#b20000"></span></td>'
                . '</tr>';
            echo '<tr><td style="width:150px; " ><span class="lbl">Thousand Separator:</span></td>'
                    . '<td  id="user_name"><input  type="text" value = "," id="thousand_separator"/><br>&nbsp&nbsp<span  class="error" id="err_thousand_separator" style="color:#b20000"></span></td>'
                . '</tr>';
            echo '<tr><td style="width:150px; " ><span class="lbl">Decimal Separator:</span></td>'
                    . '<td  id="user_name"><input  type="text" value = "." id="decimal_separator"/><br>&nbsp&nbsp<span  class="error" id="err_decimal_separator" style="color:#b20000"></span></td>'
                . '</tr>';
        echo '</table>';
    echo '</div>';

echo '</div>';

echo '<div class="lb_setup_install"></div>';
// set Tax
echo '<div id = "setup-tax" class="lb_setup_content">';
    //title setup tax
    echo '<div class="lb_setup_title">';
    echo '<h2><b>Setup Tax</b></h2>';
    echo '</div>';
    //body setup tax
    echo '<div id="body-setup" class="lb_setup_body">';
        echo '<table>';
            echo '<tr><td style="width:150px; "><span class="lbl">Tax Name:</span></td>'
                    . '<td ><input  type="text"  id="tax_name" /><br>&nbsp&nbsp<span  class="error" id="err_tax_name" style="color:#b20000"></span></td>'
                . '</tr>';
            echo '<tr><td style="width:150px;"><span class="lbl">Tax Value(%):</span></td>'
                    . '<td><input type="text" id="tax_value"/><br>&nbsp&nbsp<span class="error" id="err_tax_value" style="color:#b20000"></span></td>'
                . '</tr>';
            echo '<tr><td></td>'
                . '<td><input type="checkbox" id="check_box_tax"> Add as a default tax</td>'
                . '</tr>';
        echo '</table>';
    echo '</div>';
echo '</div>';


echo '<div class="lb_setup_install"></div>';
    
//Set My Company
echo '<div id = "setup-company" class="lb_setup_content">';
    //Titel setup company
    echo '<div class="lb_setup_title">';
    echo '<h2><b>Setup My Company</b></h2>';
    echo '</div >';
    
    //body setup company
    
    echo '<div id="body-setup" class="lb_setup_body">';
        echo '<table>';
            echo '<tr><td style="width:150px; "><span class="lbl">Name:</span></td>'
                    . '<td ><input  type="text"  id="company_name" value = "" /><br>&nbsp&nbsp<span  class="error" id="err_company_name" style="color:#b20000"></span></td>'
                . '</tr>';
            echo '<tr><td style="width:150px;"><span class="lbl">Registration:</span></td>'
                    . '<td><input type="text" value = "" id="company_registration"/><br>&nbsp&nbsp<span class="error" id="err_company_registration" style="color:#b20000"></span></td>'
                . '</tr>';
            echo '<tr><td style="width:150px; " ><span class="lbl">Website:</span></td>'
                    . '<td  id="user_name"><input  type="text" value = "" id="company_website"/><br>&nbsp&nbsp<span  class="error" id="err_company_website" style="color:#b20000"></span></td>'
                . '</tr>';
            echo '<tr><td style="width:150px; " ><span class="lbl">Address Line 1:</span></td>'
                    . '<td  id="user_name"><input  type="text" value = "" id="company_address_line_1"/><br>&nbsp&nbsp<span  class="error" id="err_company_address_line_1" style="color:#b20000"></span></td>'
                . '</tr>';
            echo '<tr><td style="width:150px; " ><span class="lbl">Address Line 2:</span></td>'
                    . '<td  id="user_name"><input  type="text" value = "" id="company_address_line_2"/><br>&nbsp&nbsp<span  class="error" id="err_company_address_line_2" style="color:#b20000"></span></td>'
                . '</tr>';
            echo '<tr><td style="width:150px; " ><span class="lbl">City:</span></td>'
                    . '<td  id="user_name"><input  type="text" value = "" id="company_city"/><br>&nbsp&nbsp<span  class="error" id="err_company_city" style="color:#b20000"></span></td>'
                . '</tr>';
            echo '<tr><td style="width:150px; " ><span class="lbl">State/Province:</span></td>'
                    . '<td  id="user_name"><input  type="text" value = "" id="company_state"/><br>&nbsp&nbsp<span  class="error" id="err_company_state" style="color:#b20000"></span></td>'
                . '</tr>';
            echo '<tr><td style="width:150px; " ><span class="lbl">Country:</span></td>'
                    . '<td  id="user_name"><input  type="text" value = "" id="company_country"/><br>&nbsp&nbsp<span  class="error" id="err_company_country" style="color:#b20000"></span></td>'
                . '</tr>';
            echo '<tr><td style="width:150px; " ><span class="lbl">Postal Code:</span></td>'
                    . '<td  id="user_name"><input  type="text" value = "" id="company_postal_code"/><br>&nbsp&nbsp<span  class="error" id="err_company_postal_code" style="color:#b20000"></span></td>'
                . '</tr>';
            echo '<tr><td style="width:150px; " ><span class="lbl">Phone:</span></td>'
                    . '<td  id="user_name"><input  type="text" value = "" id="company_phone"/><br>&nbsp&nbsp<span  class="error" id="err_company_phone" style="color:#b20000"></span></td>'
                . '</tr>';
            echo '<tr><td style="width:150px; " ><span class="lbl">Fax:</span></td>'
                    . '<td  id="user_name"><input  type="text" value = "" id="company_fax"/><br>&nbsp&nbsp<span  class="error" id="err_company_fax" style="color:#b20000"></span></td>'
                . '</tr>';
            
        echo '</table>';
    echo '</div>';

echo '</div>';


//button
echo '';
echo '<div id ="footer-button" class="lb_install_button">';
   echo '<button id = "save" onclick = "start_install(); return false;">Save</button>&nbsp';
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
    width:313px; height:28px !important;
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
        $(document).ready(function(){
            $('#financial_year').datepicker({
               format:'d/m',
            });
        });
        function start_install()
        {
            
            var hostName = document.getElementById('hostName').value;
            var dbName = document.getElementById('dbName').value;
            var dbUser = document.getElementById('dbUser').value;
            var dbPass = document.getElementById('dbPass').value;
            var err = 0;
            var yourSelect = document.getElementById("language");
            var lang = yourSelect.options[yourSelect.selectedIndex].value;
            
            //information account
            var account_email = document.getElementById('account_email').value;
            var account_pass = document.getElementById('account-pass').value;
            var confirmPass = document.getElementById('confirm_pass').value;
            var financial_year = document.getElementById('financial_year').value;
            //information currency
         //   var currency = document.getElementById('default_currency').value;
            var currency_symbol = document.getElementById('currency_symbol').value;
            var thousand_separator = document.getElementById('thousand_separator').value;
            var decimal_separator = document.getElementById('decimal_separator').value;
            //information my company
            var company_name = document.getElementById('company_name').value;
            var company_resgis = document.getElementById('company_registration').value;
            var company_website = document.getElementById('company_website').value;
            var company_address_1 = document.getElementById('company_address_line_1').value;
            var company_address_2 = document.getElementById('company_address_line_2').value;
            var company_city = document.getElementById('company_city').value;
            var company_state = document.getElementById('company_state').value;
            var company_country = document.getElementById('company_country').value;
            var company_postal = document.getElementById('company_postal_code').value;
            var company_phone = document.getElementById('company_phone').value;
            var company_fax = document.getElementById('company_fax').value;
            //information tax
            var tax_name = document.getElementById('tax_name').value;
            var tax_value = document.getElementById('tax_value').value;
            var tax_checkbox = document.getElementById('check_box_tax').checked;         
           // var tax_checkbox = $('#check_box_tax').prop('checked');
           
            var comp = financial_year.split('/');
            var financial_day = parseInt(comp[0],10);
            var financial_month = parseInt(comp[1],10);
         //   alert(financial_month);
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
                if(account_pass !== confirmPass)
                {
                   document.getElementById('err_confirm_pass').innerHTML = 'These passwords do not match. Try again?'; 
                   err++;
                }
                else if (account_pass.length < 6 ||(account_pass.match(/[a-z]/g) === null || account_pass.match(/[0-9]/g) === null)) {
                document.getElementById('err_confirm_pass').innerHTML ='Password must contains at least 6 characters, with the combination of small letters (a-z) and digits (0-9)';
                err++;
            }
                else  document.getElementById('err_confirm_pass').innerHTML = ''; 
            }
            //check financial
            if((financial_year.trim()).length <= 0){
                document.getElementById('err_financial_year').innerHTML = "Financial year field is required";
                err++;
            }
            if((financial_year.trim()).length > 0)
                document.getElementById('err_financial_year').innerHTML = '';
            //check information tax
            if((tax_name.trim()).length <= 0){
               // alert("Tax name field is required.");
                document.getElementById('err_tax_name').innerHTML = "Tax name field is required.";
                err++;
            }
            if((tax_name.trim()).length > 0)
                document.getElementById('err_tax_name').innerHTML = '';
            if((tax_value.trim()).length <=0){
                document.getElementById('err_tax_value').innerHTML = "Tax value field required";
                err++;
            }
            //check information my company
             if((company_name.trim()).length <= 0){
                document.getElementById('err_company_name').innerHTML = "Name field is required";
                err++;
            }
            if((company_resgis.trim()).length <= 0){
                document.getElementById('err_company_registration').innerHTML = "Registration field is required";
                err++;
            }
            if((company_website.trim()).length <= 0){
                document.getElementById('err_company_website').innerHTML = "Website field is required";
                err++;
            }
            if((company_address_1.trim()).length <= 0){
                document.getElementById('err_company_address_line_1').innerHTML = "Address line 1 field is required";
                err++;
            }
            if((company_city.trim()).length <= 0){
                document.getElementById('err_company_city').innerHTML = "City field is required";
                err++;
            }
//            if((company_state.trim()).length <= 0){
//                document.getElementById('company_state').innerHTML = "State field is required";
//            }
            if((company_country.trim()).length <= 0){
                document.getElementById('err_company_country').innerHTML = "Country field is required";
                err++;
            }
            if((company_postal.trim()).length <= 0){
                document.getElementById('err_company_postal_code').innerHTML = "Postal Code field is required";
                err++;
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
            if(err === 0)
            {
                $.blockUI({
                    message:'<h1><img src="images/loading_in.gif" />Please wait...</h1>'
                });
                 $.ajax({
                    type:'POST',
                    url:'setup.php',
                    data:{hostName:hostName,dbName:dbName,dbUser:dbUser,dbPass: dbPass,account_email: account_email,
                       account_pass: account_pass,lang:lang,financial_day:financial_day,financial_month:financial_month,
                       currency_symbol:currency_symbol, thousand_separator:thousand_separator,decimal_separator:decimal_separator,
                       company_name:company_name,company_resgis:company_resgis,company_website:company_website,company_address_1:company_address_1,
                       company_address_2:company_address_2,company_city:company_city,company_state:company_state,company_country:company_country,
                       company_postal:company_postal,company_phone:company_phone,company_fax:company_fax,tax_name:tax_name,tax_value:tax_value,tax_checkbox:tax_checkbox
                       },
                        
                     success:function(response){
                        var obj = jQuery.parseJSON( response );
                        
                        if(obj.success === 1)
                        {
                            $.unblockUI();
                            window.location = "index.php/site/login";
                        }
                       if(obj.success === 0)
                        {
                            $.blockUI({
                                message:'<div class="install-error">'+obj.err+'</div>',
                                onOverlayClick: $.unblockUI
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
            $('#tax_name').val('');
            $('#tax_value').val('');
            $('#check_box_tax').val('');
            $('#company_name').val('');
            $('#company_registration').val('');
            $('#company_website').val('');
            $('#company_address_line_1').val('');
            $('#company_address_line_2').val('');
            $('#company_city').val('');
            $('#company_state').val('');
            $('#company_country').val('');
            $('#company_postal_code').val('');
            $('#company_phone').val('');
            $('#company_fax').val('');
                        
            document.getElementById('err_dbname').innerHTML = '';
            document.getElementById('err_username').innerHTML = '';
            document.getElementById('err_host').innerHTML = '';
            document.getElementById('err_account-pass').innerHTML = '';
            document.getElementById('err_confirm_pass').innerHTML = '';
            document.getElementById('err_account_email').innerHTML = '';
            document.getElementById('err_tax_name').innerHTML = '';
            document.getElementById('err_tax_value').innerHTML = '';
            document.getElementById('err_company_name').innerHTML = '';
            document.getElementById('err_company_registration').innerHTML = '';
            document.getElementById('err_company_website').innerHTML = '';
            document.getElementById('err_company_address_line_1').innerHTML = '';
            document.getElementById('err_company_address_line_2').innerHTML = '';
            document.getElementById('err_company_city').innerHTML = '';
            document.getElementById('err_company_state').innerHTML = '';
            document.getElementById('err_company_country').innerHTML = '';
            document.getElementById('err_company_postal_code').innerHTML = '';
            
        }
  
  </script>
 