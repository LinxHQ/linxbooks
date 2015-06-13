<?php
/* @var $this DefaultController */
?>

<h1>Configuration</h1>
<?php

    $this->widget('bootstrap.widgets.TbTabs', array(
                    'type'=>'tabs', // 'tabs' or 'pills'
                    'encodeLabel'=>false,
                    'tabs'=> 
                    array(
                                array('id'=>'tab1','label'=>'<strong>'.Yii::t('lang','Genera').'</strong>',
                                                    'content'=>$this->renderPartial('_form_genera',array(
                                                    ),true),'active'=>true,
                                                ),
                                array('id'=>'tab2','label'=>'<strong>'.Yii::t('lang','Tax').'</strong>', 
                                                'content'=> $this->renderPartial('_form_tax', array(
                                                        'taxModel'=>$taxModel,
                                                ),true),
                                                'active'=>false),
                                array('id'=>'tab3','label'=>'<strong>'.Yii::t('lang','Invoice Number').'</strong>',
                                                'content'=> $this->renderPartial('_form_invoice_number', array(
                                                
                                                ),true),
                                                'active'=>false),
                                array('id'=>'tab4','label'=>'<strong>'.Yii::t('lang','Default Note').'</strong>',
                                                'content'=>  $this->renderPartial('_form_default_note', array(
                                                ),true),
                                                'active'=>false),
                                array('id'=>'tab5','label'=>'<strong>'.Yii::t('lang','List').'</strong>',
                                                'content'=> $this->renderPartial('_list_item', array('list'=>$list
                                                ),true),
                                                'active'=>false),
                                array('id'=>'tab6','label'=>'<strong>'.Yii::t('lang','Translate').'</strong>',
                                                'content'=> $this->renderPartial('_list_translate', array('translate'=>$translate
                                                ),true),
                                                'active'=>false),
                                array('id'=>'tab7','label'=>'<strong>'.Yii::t('lang','System').'</strong>',
                                                'content'=> $this->renderPartial('permission.views.default.index', array(),true),
                                                'active'=>false),
                                 
                                
                            )
    ));
?>
