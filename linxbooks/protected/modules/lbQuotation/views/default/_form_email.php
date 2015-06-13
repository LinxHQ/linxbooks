<div class="form_email">
<p class="note">Fields with <span class="required">*</span> are required.</p>
<?php echo CHtml::beginForm('', 'post', array('class'=>'form-horizontal','id'=>'form_senEmail_quotation')); ?>
    <div class="control-group">
        <?php echo CHtml::label("From*", 'email_from_quotation', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('email_from_quotaiton','',array('class'=>'span4'));?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("To*", 'email_to_quotation', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('email_to_quotation','',array('class'=>'span4'));?>
        </div>
    </div>
<!--    <div class="control-group">
        <?php echo CHtml::label("Cc", 'email_cc_quotation', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('email_cc_quotation','',array('class'=>'span4'));?>
        </div>
    </div>-->
    <div class="control-group">
        <?php echo CHtml::label("Subject*", 'email_subject_quotation', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('email_subject_quotation','',array('class'=>'span4'));?>
        </div>
    </div>
    <div>
        <?php echo CHtml::label("File Attach", 'email_attach_quotation', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('email_attach_quotation',$model->lb_quotation_no.'.pdf',array('class'=>'span4','readonly'=>'true'));?>
            <?php echo CHtml::link(CHtml::image(Yii::app()->baseUrl.'/images/icons/preview_pdf.png', '#', array('width'=>'32','style'=>'float:right','data-toggle'=>"tooltip",'title'=>"Preview PDF")),
                                    $this->createUrl('PDFQuotation',array('id'=>$model->lb_record_primary_key)),array('target'=>'_blank','data-toggle'=>"tooltip",'title'=>"Generate PDF",'class'=>'lb-side-link-invoice')) ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Content", 'email_content_quotation'); ?>
        <?php echo CHtml::textArea('email_content_quotation','',array('style'=>'width:515px;height:100px;'));?>
    </div>
    <div class="progress progress-striped" id="email_progress" style="display: none;">
        <div class="bar"></div>
    </div>
    <?php //echo CHtml::button('<i class="icon-ok icon-white"></i> &nbsp; Send', array('onclick'=>'send_invoice();return false;','class'=>'btn btn-success','encodeLabel'=>false))?>
    <?php //echo $this->module_name;?>
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit','htmlOptions'=>array('onclick'=>'send_quotation();return false;','class'=>'btn btn-success'), 'label'=>'<i class="icon-ok icon-white"></i> &nbsp; Save','encodeLabel'=>false)); ?>
<?php echo CHtml::endForm();?>
</div>
<script type="text/javascript">
    function send_quotation(){
        var data = $('#form_senEmail_quotation').serialize();
        var email_from = $('#email_from_quotaiton').val();
        var email_to = $('#email_to_quotation').val();
        var email_subject = $('#email_subject_quotation').val();

        var i;
        var element_to = email_to.split(',');
        var ismail_to=true;
        for(i=0;i<element_to.length;i++)
        {
            if(isEmail(element_to[i])==false)
            {
                ismail_to = false;
            }
        }
       
        if(email_from=="" || email_to=="" || email_subject=="")
        {
            alert('Please fill in the required fields.');
            return false;
        }
        if(isEmail(email_from)==false){
            alert('Email From is Invalid');
            return false;
        }
        if(ismail_to==false){
            alert('Email To is Invalid');
            return false;
        }

        $('#email_progress').css('display','block');
        $('.bar').css('width', '40%');
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl("ajaxSendEmailQuotation",array('id'=>$model->lb_record_primary_key)); ?>',
            data:data,
            success:function(response)
            {
                var responseJSON = jQuery.parseJSON(response);
                $('.bar').css('width', '100%');
                $('#quotation_status .editable').html(responseJSON.lb_quotation_status);
                $('#quotation_status_container').html(responseJSON.lb_quotation_status);
                
                setTimeout(function(){
                    $('#modal-holder-<?php echo $model->lb_record_primary_key; ?>').modal('hide');
                },1000);
            },
            error: function(data){
                alert('Error occured.please try again.');
                $('#email_progress').css('display','none');
            },
            dataType:'html'
        })
    }
    function isEmail(email) {
                            var isValid = false;
                            var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                            if(regex.test(email)) {
                                    isValid = true;
                            }
                            return isValid;
                    }
</script>