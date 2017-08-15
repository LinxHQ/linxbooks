<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.1/jquery.form.js"></script> 
<a href="#" onclick="hiden_show_social();"><?php echo Yii::t('lang','Hide - Show Social Login') ?></a> <br><br>

<div id="form_hide_show_social" hidden>
    <?php 
        $config_social = LbConfigLoginSocial::model()->findAll();
        if($config_social[0]['action'] == 0){
            
            echo "<b>".Yii::t('lang','Social Login is Off')."</b> <br />";
            echo '<input type="radio" name="radioName" value="1" />'; echo Yii::t('lang','Turn on Social Login').'  <br /> <br />';
        } else if($config_social[0]['action'] == 1){
            echo "<b>".Yii::t('lang','Social Login is On')."</b> <br />";
            echo '<input type="radio" name="radioName" value="0" />'; echo Yii::t('lang','Turn off Social Login').'  <br /> <br />';
        }
    ?>
    <br /> <br /><a href="#" class="btn btn-success" onclick="save_hide_show_social();"><?php echo Yii::t('lang','Save') ?></a>
</div> <br>
<a href="#" onclick="hiden_show_social_id();"><?php echo Yii::t('lang','Config ID Social') ?></a> <br><br>
<div id="config_id_social" hidden>
    <label for="api_id">App API : </label>
    <input type="text" value="" id="api_id" />
    <label for="api_secret">App Secret : </label>
    <input type="text" value="" id="api_secret" />
    <br />
    <select id="server_social">
        <option value="facebook">Facebook</option>
        <option value="google">Google</option>
    </select>
    
    
    <br /><br /><a href="#" class="btn btn-success" onclick="config_social_id();"><?php echo Yii::t('lang','Save') ?></a>
</div>

<h1><?php echo Yii::t('lang','Social Login User List') ?></h1>
<table border="1" width="100%" align="center">
    <thead>
        <tr>
            <th>#</th>
            <th><?php echo Yii::t('lang','Name') ?></th>
            <th><?php echo Yii::t('lang','Active') ?></th>
        </tr>
    </thead>
    <tbody align="center">
        <?php
            $account_social = Account::model()->findAll('check_user_activated IN ("0")');
            $stt=0;
            foreach($account_social as $result){
                $stt++;
                echo "<tr align='center'>
                        <td>".$stt."</td>
                        <td>".$result['account_email']."</td>
                        <td><input type='checkbox' name='check_list' id='check_list' value=".$result['account_id']."></td>
                    </tr>";
            } ?>
    </tbody>
</table>
<br /><a href="#" class="btn btn-success" onclick="active_users();"><?php echo Yii::t('lang','Save') ?></a>


<script type="text/javascript">
    function get_ID_checked(id_check, str_check) {
        var inputs = document.getElementsByName(id_check);
        var user_id = '';
        for (var i = 0; i < inputs.length; i++) {
            if (inputs[i].type == 'checkbox' && inputs[i].checked == true) {
                user_id += '&'+str_check+'[]='+inputs[i].value;
            }
        }
        return user_id;
    }
    function active_users(){
        var checklist_id = get_ID_checked('check_list', 'user_id');
        $.ajax({
            'url': "<?php echo $this->createUrl('/configuration/activateuser'); ?>",
            data: checklist_id,
            'success':function(data)
            {
                alert('');
                alert('<?php echo Yii::t('lang','Active Users Successfully') ?>');
                window.location.assign("<?php echo Yii::app()->baseUrl ?>/1/configuration");
            }
        });
    }
    function hiden_show_social(){
        $("#form_hide_show_social").toggle(1000);
    }
    function hiden_show_social_id(){
        $("#config_id_social").toggle(1000);
    }
    function save_hide_show_social(){
            var value = $('input[name=radioName]:checked', '#form_hide_show_social').val();
            $.ajax({
                'url': "<?php echo $this->createUrl('/configuration/configsocial'); ?>",
                data: {value:value},
                'success':function(data)
                {
                    alert('<?php echo Yii::t('lang','Successfully') ?>');
                    window.location.assign("<?php echo Yii::app()->baseUrl ?>/1/configuration");
                }
            });
    }
    function config_social_id(){
        var api_id = $("#api_id").val();
        var api_secret = $("#api_secret").val();
        var server_social = $("#server_social").val();
        $.ajax({
            'url': "<?php echo $this->createUrl('/configuration/configidsocial'); ?>",
            data: {api_id:api_id, api_secret:api_secret, server_social:server_social},
            'success':function(data)
            {
                alert('<?php echo Yii::t('lang','Successfully') ?>');
                window.location.assign("<?php echo Yii::app()->baseUrl ?>/1/configuration");
            }
        });
    }
</script>