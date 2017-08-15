<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/style_js_modules_lbOpportunities/css/style.css">
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/style_js_modules_lbOpportunities/css/spectrum.css">
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/css/style_js_modules_lbOpportunities/js/script.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/css/style_js_modules_lbOpportunities/js/spectrum.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.1/jquery.form.js"></script>

<div id="add_industry">
	<?php echo Yii::t('lang','Industry') ?> : <input type="text" name="industry_name" id="industry_name">
	<br>
	<button class="btn btn-success"  type="submit" onclick="save_add_industry()"><?php echo Yii::t('lang','New Industry') ?></button>
</div> <br>

<script type="text/javascript">
	function save_add_industry(){
	var industry_name = $("#industry_name").val();
	var test = "<?php echo $this->createUrl('/lbOpportunities/Default/SaveIndustry'); ?>";
    $.ajax({
        type:"POST",
        url:test,
        data: {industry_name:industry_name},
        success:function(data){
            alert('"An industry" was successfully added.');
            window.location.assign("<?php echo $this->createUrl('/lbOpportunities/default/board?tab=board'); ?>");
        }
    });
}
</script>