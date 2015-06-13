<?php

$this->widget('bootstrap.widgets.TbTabs', array(
                    'type'=>'pills', // 'tabs' or 'pills'
                    'encodeLabel'=>false,
                    'tabs'=> 
                    array(
                                array('id'=>'tab1','label'=>'<strong>'.Yii::t('lang','package').'</strong>',
                                                    'content'=>LBApplication::renderPartial($this,'paypal.views.creditCard.index',array(
                                                        'value' => $subscription,
                                                    ),true),'active'=>true,
                                    ),
                                array('id'=>'tab2','label'=>'<strong>'.Yii::t('lang','Subcriptions').'</strong>',
                                                    'content'=>'Loading....','active'=>false,
                                                ),
                                array('id'=>'tab3','label'=>'<strong>'.Yii::t('lang','User Subcription').'</strong>', 
                                                'content'=>'Loading.....','active'=>false),
                            ),
                    'events'=>array('shown'=>'js:loadContent')
    ));

?>
<script type="text/javascript">

function loadContent(e){

    var tabId = e.target.getAttribute("href");
    var ctUrl = ''; 

    if(tabId == '#tab2') {
        ctUrl = '<?php echo $this->createUrl('/paypal/subscription/admin'); ?>';
    } else if(tabId == '#tab3') {
        ctUrl = '<?php echo $this->createUrl('/paypal/userSubscription/admin'); ?>';
    }

    if(ctUrl != '') {
        $.ajax({
            url      : ctUrl,
            type     : 'POST',
            dataType : 'html',
            cache    : false,
            success  : function(html)
            {
                jQuery(tabId).html(html);
            },
            error:function(){
                    alert('Request failed');
            }
        });
    }
    return false;
}
</script>