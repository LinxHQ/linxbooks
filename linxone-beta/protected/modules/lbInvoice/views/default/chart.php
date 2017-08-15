
    <!-- ########### Chart Expenditures############## -->
    <?php 

    $date = date('Y');?>

     <div class="panel-header-title" style="padding-top:51px;">
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