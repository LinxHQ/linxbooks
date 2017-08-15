<?php
/* @var $this DefaultController */

?>

<h1><?php echo Yii::t('lang','Configuration'); ?></h1>
<?php
    
    $this->widget('bootstrap.widgets.TbTabs', array(
                    'type'=>'tabs', // 'tabs' or 'pills'
                    'encodeLabel'=>false,
                    'tabs'=> 
                    array(
                                array('id'=>'tab1','label'=>'<strong>'.Yii::t('lang','Genera').'</strong>',
                                                    'content'=>$this->renderPartial('_form_genera',array(
                                                    ),true),'active'=>false,
                                                ),
                                array('id'=>'tab2','label'=>'<strong>'.Yii::t('lang','Tax').'</strong>', 
                                                'content'=> $this->renderPartial('_form_tax', array(
                                                        'taxModel'=>$taxModel,
                                                ),true),
                                                'active'=>false),
                                array('id'=>'tab3','label'=>'<strong>'.Yii::t('lang','Invoice Number').'</strong>',
                                                'content'=> $this->renderPartial('_form_invoice_number', array(
                                                //'nextID'=>$nextID,
                                                ),true),
                                                'active'=>false),
                                array('id'=>'tab4','label'=>'<strong>'.Yii::t('lang','Default Note').'</strong>',
                                                'content'=>  $this->renderPartial('_form_default_note', array(
                                                ),true),
                                                'active'=>false),
                                array('id'=>'tab5','label'=>'<strong>'.Yii::t('lang','List').'</strong>',
                                                'content'=>  $this->renderPartial('item', array('list'=>$list,'list_name'=>$list_name
                                                ),true),
                                                'active'=>true),
                                
                            )
    ));
?>
