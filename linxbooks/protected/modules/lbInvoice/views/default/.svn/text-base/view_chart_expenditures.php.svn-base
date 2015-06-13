<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

        //Da thu
        $total = array();

        //Can thu
        $datatest = array();
        
        //DA chi
        $datatest1 = array();
        
        //Can chi
        $datatest2 = array();
        $thang = array();
        for($i = 1; $i<13;$i++)
        {
            //Da Thu
            $payment = LbPayment::model()->getPaymentTotalByMonth($year,$i);
            array_push($total, intval($payment));
            
            //Can thu
            $oustanding_invoice = LbInvoice::model()->getTotalInvoiceByMonth($year,$i);
            array_push($datatest, intval($oustanding_invoice));
            
            //Da chi=totalEx + totalVendor
            $totalExpenses = LbExpenses::model()->totalExByVDInMonth($i,$year);
            $totalVendor = LbPaymentVendor::model()->totalPaymentVendorInMonth($i,$year);
            array_push($datatest1, ($totalExpenses+$totalVendor));
            
            //Can Chi
           
            $totalVendorInvoice = LbVendorInvoice::model()->getVendorInvoiceMonth($i,$year);
            $totalEx = LbExpenses::model()->getExByMonth($i,$year);
            array_push($datatest2, ($totalVendorInvoice+$totalEx));


            array_push($thang, intval($i));
        }
        
        $this->Widget('highcharts.HighchartsWidget', array(
            'htmlOptions' => array(
//            'style' => 'width: 750px; height: 500px; margin-left:-10px;'
             ),
            
            'options'=>array(
                 'chart'=> array('type'=>'column',
                    'colors'=>array('#058DC7', '#5bb75b', '#ED561B', '#DDDF00'),
                     
                ),
                 'yAxis'=>array(
                     'title'=>array('text'=>'<b>$</b>'),
                   
                      'style' =>array(
                            'fontSize'=> '14px',
                            
                    )
                 ),
                
                 'xAxis'=>array(
                     'title'=>array('text'=>'<b>Month</b>'),
                     'categories'=>$thang,

                      'labels'=>array(
                       
                        'style' =>array(
                            'fontSize'=> '14px',
                            
                        )
                    )
                 ),
                 'plotOptions'=>array(
                    'series'=>array(
                     'pointWidth'=> '13'//width of the column bars irrespective of the chart size
                     ),
                ),
//                'plotOptions'=> array(
//                    'column' => array(
//                        'width'=>'30',
//                        'stacking'=> 'normal',
////                        'dataLabels'=>array(
////                            'enabled'=> true,
////                            'color'=> "(Highcharts.theme && Highcharts.theme.background2) || 'white'",
////                            'style'=>array('textShadow'=> '0 0 10px black') 
////                                
////                            
////                        )
//                    )
//                ),
                'credits'=>array(
                    'enabled'=> false
                ),
                 'series'=>array(
                     array(
                         'name'=>'Payment Received',
                         'data'=>$total,'stack'=> 'male',
//                         'dataLabels'=>array( 
//                            'enabled'=> true,
//                            'background-color'=>'red',
//                            'color'=> 'black',
////                            'align'=> 'right',
////                            'format'=> '{point.y:.1f}', // one decimal
////                            'y'=> 20, // 10 pixels down from the top
//                            'style'=> array(
//                                'fontSize'=> '13px',
//                                'fontFamily'=> 'Verdana, sans-serif',
//                                'width'=>'18'
//                            )
//                        )
                   
                     ),
                     array(
                         'name'=>'Receivable',
                         'data'=>$datatest,'stack'=> 'male',
                         
                     ),
                     array(
                         'name'=>'Bill Paid',
                         'data'=>$datatest1,'stack'=> 'female'
                     ),
                     array(
                         'name'=>'Payable',
                         'data'=>$datatest2,'stack'=> 'female'
                     ),
                 )
                
            )

            )); ?>

