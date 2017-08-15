<?php
/* @var $this DefaultController */
?>

<h1><?php echo Yii::t('lang','Configuration'); ?></h1>
<?php
// neu co get tab7 thi tro ve tab 7
    if(isset($_GET['tab7'])){
        $tab7 = true;
    } else {
        $tab7 = false;
    }
    
    // neu ko co tab7 thi tab 1 se dc tro toi
    if (!isset($_GET['tab7'])){
        $tab1 = true;
    }else {
        $tab1 = false;
    }
    
    $this->widget('bootstrap.widgets.TbTabs', array(
                    'type'=>'tabs', // 'tabs' or 'pills'
                    'encodeLabel'=>false,
                    'tabs'=> 
                    array(
                                array('id'=>'tab1','label'=>'<strong>'.Yii::t('lang','General').'</strong>',
                                                    'content'=>$this->renderPartial('_form_genera',array(
                                                    ),true),'active'=>$tab1,
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
                                array('id'=>'tab7','label'=>'<strong>'.Yii::t('lang','Config Opportunities').'</strong>',
                                                'content'=> $this->renderPartial('_form_column', array('translate'=>$translate
                                                ),true),
                                                'active'=>$tab7),
                                array('id'=>'tab8','label'=>'<strong>'.Yii::t('lang','Config Social').'</strong>',
                                                'content'=> $this->renderPartial('_form_social', array('translate'=>$translate
                                                ),true),
                                                'active'=>$tab7),
                                array('id'=>'tab9','label'=>'<strong>'.Yii::t('lang','Add new Industry').'</strong>',
                                                'content'=> $this->renderPartial('_form_add_industry', array('translate'=>$translate
                                                ),true),
                                                'active'=>false),
                                array('id'=>'tab10','label'=>'<strong>'.Yii::t('lang','System').'</strong>',
                                                'content'=> $this->renderPartial('permission.views.default.index', array(),true),
                                                'active'=>false),
                                 
                                
                            )
    ));
?>
