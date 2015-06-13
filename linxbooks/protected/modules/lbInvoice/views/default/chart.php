
    <!-- ########### Chart Expenditures############## -->
    <?php 

    $date = date('Y');?>

    <div class="col-lg-4" style="float:right;">
        <div class="panel-header"><?php echo Yii::t('lang','All Time Revenue'); ?></div>
        <div class="panel-body">
            <div class="info_title">
                2010 - <?php echo date('Y');?>
            </div>
            <div class="info_content">
                <?php
                    $status = '("'.LbInvoice::LB_INVOICE_STATUS_CODE_OPEN.'","'.  LbInvoice::LB_INVOICE_STATUS_CODE_OVERDUE.'","'.LbInvoice::LB_INVOICE_STATUS_CODE_PAID.'")';
                    echo LbInvoice::CURRENCY_SYMBOL.number_format($model->calculateInvoiceTotalAmount($status),2);
                ?>
            </div>
        </div>
    </div>
    <div class="col-lg-4" style="float:right;">
        <div class="panel-header"><?php echo Yii::t('lang','Year To Date Revenue'); ?></div>
        <div class="panel-body">
            <div class="info_title">
                <?php echo $data = date('Y');?>
            </div>
            <div class="info_content">
                <?php //
                    $status = '("'.LbInvoice::LB_INVOICE_STATUS_CODE_OPEN.'","'.  LbInvoice::LB_INVOICE_STATUS_CODE_OVERDUE.'","'.LbInvoice::LB_INVOICE_STATUS_CODE_PAID.'")';
                    echo LbInvoice::CURRENCY_SYMBOL.number_format($model->calculateInvoiceTotalAmount($status,$data),2); 
                ?>
            </div>
        </div>
    </div>
    <div class="col-lg-4" style="float:right;">
        <div class="panel-header"><?php echo Yii::t('lang','Cash Collected'); ?></div>
        <div class="panel-body">
            <div class="info_title">
                <?php echo date('Y');?>
            </div>
            <div class="info_content">
                <?php echo LbInvoice::CURRENCY_SYMBOL.number_format($model->calculateInvoiceTotalPaymentByYear(),2); ?>
            </div>
        </div>
    </div>
    <div class="col-lg-4" style="float:right;">
        <div class="panel-header"><?php echo Yii::t('lang','Outstanding'); ?></div>
        <div class="panel-body">
            <div class="info_title">
                <?php echo '<br/>';?>
            </div>
            <div class="info_content strong">
                <?php
                    $status = '("'.LbInvoice::LB_INVOICE_STATUS_CODE_OPEN.'","'.  LbInvoice::LB_INVOICE_STATUS_CODE_OVERDUE.'")'; 
                    echo LbInvoice::CURRENCY_SYMBOL.number_format($model->calculateInvoiceTotalOutstanding($status,false),2);
                ?>
            </div>
        </div>
    </div>
     <div class="panel-header-title" style="padding-top:124px;">
            <div class="panel-header-title-right">
                <button class="btn" id="btn_year_<?php echo $date-2; ?>" onclick="chart_expenditures(<?php echo $date-2;?>);"><?php echo $date-2 ?></button>
                <button class="btn" id="btn_year_<?php echo $date-1;?>" onclick="chart_expenditures(<?php echo $date-1;?>);"><?php echo $date-1 ?></button>
                <button class="btn" id="btn_year_<?php echo $date;?>" onclick="chart_expenditures(<?php echo $date;?>);"><?php echo $date ?></button>
            </div>
        </div>

        <br /> 
        <div id="graph_ex" >

        </div>


<script lang="Javascript">
    $(document).ready(function(){
        document.getElementById("btn_year_<?php echo date('Y')?>").style.background='#5bb75b';
        $('#graph_ex').load('<?php echo LbInvoice::model()->getActionURLNormalized('view_chart_expenditures') ?>',{year:<?php echo date('Y')?>});
        
    });
    
    function chart_expenditures(year)
    {
        document.getElementById("btn_year_<?php echo date('Y')?>").style.background='#f5f5f5';
        document.getElementById("btn_year_<?php echo date('Y')-1?>").style.background='#f5f5f5';
        document.getElementById("btn_year_<?php echo date('Y')-2?>").style.background='#f5f5f5';
        document.getElementById("btn_year_"+year).style.background='#5bb75b';
       
        $('#graph_ex').load('<?php echo $this->createUrl('/lbInvoice/default/view_chart_expenditures'); ?>',{year : year });
         
    
    }
    
</script>

<style>
    .chart-wrapper {
    float: left;
    /*padding-bottom: 40%;*/
    position: relative;
    
}
.highcharts-title
{
    display: none;
}

    </style>