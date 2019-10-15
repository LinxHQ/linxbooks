<?php
/* @var $this DefaultController */

$this->breadcrumbs=array(
	$this->module->id,
);

$m = $this->module->id;
$canAdd = BasicPermission::model()->checkModules($m, 'add');
$canList = BasicPermission::model()->checkModules($m, 'list');
$canview = BasicPermission::model()->checkModules($m, 'view');
$canEdit = BasicPermission::model()->checkModules($m, 'update');
$canviewOwn = BasicPermission::model()->checkModules($m, 'view',Yii::app()->user->id);
// echo $canviewOwn;
// exit();
?>
<?php 

    echo '<div id="lb-container-header">';
                echo '<div class="lb-header-right"><h3>'.Yii::t('lang','Leave').'</h3></div>';
    echo '</div>';

?>
<br><br>
<?php

    $this->widget('bootstrap.widgets.TbTabs', array(
                    'type'=>'tabs', // 'tabs' or 'pills'
                    'encodeLabel'=>false,
                    'id'=>'tabs-leave',
                    'tabs'=> 
                    array(
                                array('id'=>'tab1','label'=>'<strong>'.Yii::t('lang','Applications').'</strong>',
                                                    'content'=>$this->renderPartial('lbLeave.views.leaveApplication.admin',array(
                                                      'model'=> $modelApplication
                                                    ),true),'active'=>true,
                                                ),
                                array('id'=>'tab2','label'=>'<strong>'.Yii::t('lang','Package').'</strong>', 
                                                'content'=> $this->renderPartial('lbLeave.views.leavePackage.admin', array(
                                                        'model'=>$modelPackage,
                                                        'modelitempackage'=>$modelPackageItem,
                                                ),true),
                                                'active'=>false),
                                array('id'=>'tab3','label'=>'<strong>'.Yii::t('lang','In-Lieu').'</strong>', 
                                                'content'=> $this->renderPartial('lbLeave.views.leaveInLieu.admin', array(
                                                        'model'=>$modelInLieu,
                                                ),true),
                                                'active'=>false),
                                array('id'=>'tab4','label'=>'<strong>'.Yii::t('lang','Assignment').'</strong>', 
                                                'content'=> $this->renderPartial('lbLeave.views.leaveAssignment.admin', array(
                                                        'model'=>$modelAssignment,
                                                ),true),
                                                'active'=>false),
                                array('id'=>'tab5','label'=>'<strong>'.Yii::t('lang','Report').'</strong>', 
                                                'content'=> $this->renderPartial('lbLeave.views.default.view_leave_report', array(
                                                        'model'=>$report,
                                                ),true),
                                                'active'=>false),
                                
                            )
    ));
?>
<script type="text/javascript">
    var canviewOwn = '<?php echo $canviewOwn; ?>';
    var canview = '<?php echo $canview; ?>';
    if((canviewOwn==0)&&(canview==0)){
        $('#tabs-leave').remove();
        // $('#tab2').remove();
        // $('#tab3').remove();
        // $('#tab4').remove();
        // $('#tab5').remove();
    }
</script>
<style type="text/css" media="screen">
    #tab2 {
        padding-top: 15px;
    }
</style>