<div class="form_public_pdf">
    <?php echo CHtml::beginForm('', 'post', array('class'=>'form-horizontal','id'=>'form_get_public_pdf_invoice')); ?>
        <div class="control-group">
            <?php echo CHtml::label("To*", 'email_to', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textField('email_to','',array('class'=>'span4'));?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Content", 'email_content',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textArea('email_content','',array('style'=>'height:50px;','class'=>'span4'));?>
            </div>
        </div>
        <div class="progress progress-striped" id="email_progress" style="display: none;">
            <div class="bar"></div>
        </div>
        <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit',
                                                                      'htmlOptions'=>array(
                                                                          'onclick'=>'send_share_pdf();return false;',
                                                                          'class'=>'btn btn-success'), 
                                                                           'label'=>'<i class="icon-ok icon-white"></i> &nbsp; Share',
                                                                            'encodeLabel'=>false)); ?>
    <?php echo CHtml::endForm();?>
    
</div>



<iframe src="<?php echo Yii::app()->createAbsoluteUrl('lbInvoice/p/'.$p); ?>" width="100%" height="280"></iframe>
<script type="text/javascript">
    function send_share_pdf(){
        var data = $('#form_get_public_pdf_invoice').serialize();
        var email_to = $('#email_to').val();
        var email_subject = $('#email_subject').val();

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
       
        if(email_to=="" || email_subject=="")
        {
            alert('Please fill in the required fields.');
            return false;
        }
        if(ismail_to==false){
            alert('Email To is Invalid');
            return false;
        }

        $('#email_progress').css('display','block');
        $('.bar').css('width', '20%');
        $.ajax({
            type:'POST',
            url:'<?php echo Yii::app()->createAbsoluteUrl("lbInvoice/default/AjaxSendEmailInvoiceSharePDF/",array('p'=>$p)); ?>',
            data:data,
            success:function(data){
                $('.bar').css('width', '100%');
                setTimeout(function(){
                    $('#modal-get-public-pdf-form').modal('hide');
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

