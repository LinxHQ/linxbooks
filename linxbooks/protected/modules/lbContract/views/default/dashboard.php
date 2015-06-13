<?php
/**
 * @var $this DefaultController;
 * @var $model LBContracts;
 */
$m = $this->module->id;
$canList = BasicPermission::model()->checkModules($m, 'list');
$canAdd = BasicPermission::model()->checkModules($m, 'add');
$canView = BasicPermission::model()->checkModules($m, 'view');

if(!$canView)
{
    echo "Have no permission to see this record";
    return;
}
?>
<?php 

    echo '<div id="lb-container-header">';
                echo '<div class="lb-header-right" ><h3>'.Yii::t('lang','Contract Dashboard').'</h3></div>';
                echo '<div class="lb-header-left">';
                        if($canAdd)
                            LBApplicationUI::newButton(Yii::t('lang','New Contract'), array(
                                    'url'=>$this->createUrl('create'),
                            ));
                echo '</div>';
    echo '</div>';
echo '<div style="clear: both;overflow:hidden"><Br>';

?>
<div class="panel">
    <h4><?php echo Yii::t('lang','Outstanding Payments'); ?></h4>
    <?php
        $this->Widget('bootstrap.widgets.TbGridView',array(
            'id'=>'lb_contract_outstanding_gridview',
            'dataProvider'=>  $model->getContractOutstanding(5,$canList),
            'type'=>'striped bordered condensed',
            //'template' => "{items}",
            'columns'=>array(
                array(
                    'name'=>'lb_contract_no',
                    'type'=>'raw',
                    'value'=>'
                            ($data->lb_contract_no) ?
                                    LBApplication::workspaceLink($data->lb_contract_no, $data->getViewURL($data->customer->lb_customer_name) )
                                    :LBApplication::workspaceLink("No customer", $data->getViewURL("No customer") )
                            
                        ',
                    'htmlOptions'=>array('width'=>'130'),
                ),
                array(
                    'name'=>'lb_customer_id',
                    'type'=>'raw',
                    'value'=>'$data->customer->lb_customer_name',
                    'htmlOptions'=>array('width'=>'320'),
                ),
                array(
                    'name'=>'lb_contract_type',
                    'type'=>'raw',
                    'value'=>'$data->lb_contract_type',
                    'htmlOptions'=>array('width'=>'180'),
                ),
               array(
                    'name'=>'lb_contract_date_start',
                    'type'=>'raw',
                    'value'=>'date("d-M-Y",strtotime($data->lb_contract_date_start))',
                    'htmlOptions'=>array('width'=>'110'),
                ),
                array(
                    'name'=>'lb_contract_date_end',
                    'type'=>'raw',
                    'value'=>'date("d-M-Y",strtotime($data->lb_contract_date_end))',
                    'htmlOptions'=>array('width'=>'110'),
                ),
                array(
                    'header'=>Yii::t('lang','Amount'),
                    'type'=>'raw',
                    'value'=>'"$".number_format($data->lb_contract_amount,2)',
                    'htmlOptions'=>array('align'=>'right'),
                ),
            )
        ));
    ?>
</div>

<div class="panel">
    <h4><?php echo Yii::t('lang','Expiring Contracts'); ?></h4>
    <?php
        $this->Widget('bootstrap.widgets.TbGridView',array(
            'id'=>'lb_contract_expiring_gridview',
            'dataProvider'=>  $model->getExpiringContract(5,$canList),
            'type'=>'striped bordered condensed',
            //'template' => "{items}",
            'columns'=>array(
                array(
                    'name'=>'lb_contract_no',
                    'type'=>'raw',
                    'value'=>'
                            ($data->lb_contract_no ?
                                    LBApplication::workspaceLink($data->lb_contract_no, $data->getViewURL($data->customer->lb_customer_name,null,$data->lb_record_primary_key) )
                                    :LBApplication::workspaceLink("No customer", $data->getViewURL("No customer") )
                            )
                        ',
                    'htmlOptions'=>array('width'=>'130'),
                ),
                array(
                    'name'=>'lb_customer_id',
                    'type'=>'raw',
                    'value'=>'$data->customer->lb_customer_name',
                    'htmlOptions'=>array('width'=>'320'),
                ),
                array(
                    'name'=>'lb_contract_type',
                    'type'=>'raw',
                    'value'=>'$data->lb_contract_type',
                    'htmlOptions'=>array('width'=>'180'),
                ),
                array(
                    'name'=>'lb_contract_date_end',
                    'type'=>'raw',
                    'value'=>'date("d-M-Y",strtotime($data->lb_contract_date_end))',
                    'htmlOptions'=>array('width'=>'110'),
                ),
                array(
                    'header'=>'',
                    'name'=>'lb_contract_term',
                    'type'=>'raw',
                    'value'=>'$data->lb_contract_term." days left"',
                    'htmlOptions'=>array('width'=>'100'),
                ),
                array(
                    'header'=>'',
                    'type'=>'raw',
                    'value'=>'"<a href=".Yii::app()->createUrl("lbContract/default/renew",array("id"=>$data->lb_record_primary_key))."><icon class=\'icon-refresh\'></icon> ".Yii::t(\'lang\',\'Renew\')."</a>"',
                ),
            )
        ));
    ?>
</div>
<div class="panel">
    <h4><?php echo Yii::t('lang','Active Contracts');?></h4>
    <?php
        $this->Widget('bootstrap.widgets.TbGridView',array(
            'id'=>'lb_contract_active_gridview',
            'dataProvider'=>  $model->getContract(LbContracts::LB_CONTRACT_STATUS_ACTIVE,5,$canList),
            'type'=>'striped bordered condensed',
            //'template' => "{items}",
            'columns'=>array(
                array(
                    'name'=>'lb_contract_no',
                    'type'=>'raw',
                    'value'=>'
                            ($data->lb_contract_no ?
                                    LBApplication::workspaceLink($data->lb_contract_no, $data->getViewURL($data->customer->lb_customer_name) )
                                    :LBApplication::workspaceLink("No customer", $data->getViewURL("No customer") )
                            )
                        ',
                    'htmlOptions'=>array('width'=>'130'),
                ),
                array(
                    'name'=>'lb_customer_id',
                    'type'=>'raw',
                    'value'=>'$data->customer->lb_customer_name',
                    'htmlOptions'=>array('width'=>'320'),
                ),
                array(
                    'name'=>'lb_contract_type',
                    'type'=>'raw',
                    'value'=>'$data->lb_contract_type',
                    'htmlOptions'=>array('width'=>'180'),
                ),
                array(
                    'name'=>'lb_contract_date_start',
                    'type'=>'raw',
                    'value'=>'date("d-M-Y",strtotime($data->lb_contract_date_start))',
                ),
                array(
                    'name'=>'lb_contract_date_end',
                    'type'=>'raw',
                    'value'=>'date("d-M-Y",strtotime($data->lb_contract_date_end))',
                ),
            )
        ));
    ?>
</div>
<div><a class="more" href="<?php echo $this->createUrl('admin'); ?>"><?php echo Yii::t('lang','see more contracts'); ?></a></div>
</div>
