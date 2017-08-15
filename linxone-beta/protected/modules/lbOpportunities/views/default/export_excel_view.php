<?php 
	require('/../../../../lib/PHPExcel-1.8/Classes/PHPExcel.php');
	$PHPExcel = new PHPExcel();
	$PHPExcel->setActiveSheetIndex(0);
	$PHPExcel->getActiveSheet()->setTitle('Email List');
	$PHPExcel->getActiveSheet()->setCellValue('A1', 'STT');
	$PHPExcel->getActiveSheet()->setCellValue('B1', 'Name');
	$PHPExcel->getActiveSheet()->setCellValue('C1', 'Customer');
	$PHPExcel->getActiveSheet()->setCellValue('D1', 'Industry');
	$PHPExcel->getActiveSheet()->setCellValue('E1', 'Value');
	$PHPExcel->getActiveSheet()->setCellValue('F1', 'Deadline');
	$PHPExcel->getActiveSheet()->setCellValue('G1', 'Status');
	 
	$stt=0; $rowNumber = 2;$total_value = ""; $total_value_status_won = "";
    $list_opportunity = LbOpportunity::model()->findAll();
	foreach($list_opportunity as $result_list_opportunity){
		$total_value += $result_list_opportunity['value'];
        $list_customer = LbCustomer::model()->findAll('lb_record_primary_key IN ('.$result_list_opportunity['customer_id'].')');
        $customer_name = "";
        foreach($list_customer as $result_list_customer){
            $customer_name .= $result_list_customer['lb_customer_name'];
        }
        $list_status = LbOpportunityStatus::model()->findAll('id IN ('.$result_list_opportunity['opportunity_status_id'].')');
        $status_name = "";
        foreach($list_status as $result_list_status){
            $status_name .= $result_list_status['column_name'];
        }
        if($status_name == "Won"){
			$total_value_status_won += $result_list_opportunity['value'];
		}
        $list_industry = LbOpportunityIndustry::model()->findAll('id IN ('.$result_list_opportunity['industry'].')');
        $industry_name = "";
        foreach($list_industry as $result_list_industry){
            $industry_name .= $result_list_industry['industry_name'];
        }
	    $stt++;
	    // A1, A2, A3, ...
	    $PHPExcel->getActiveSheet()->setCellValue('A' . $rowNumber, ($stt));
	     
	    // B1, B2, B3, ...
	    $PHPExcel->getActiveSheet()->setCellValue('B' . $rowNumber, $result_list_opportunity['opportunity_name']);
	 
	    // C1, C2, C3, ...
	    $PHPExcel->getActiveSheet()->setCellValue('C' . $rowNumber, $customer_name);

	    $PHPExcel->getActiveSheet()->setCellValue('D' . $rowNumber, $industry_name);
	    $PHPExcel->getActiveSheet()->setCellValue('E' . $rowNumber, $result_list_opportunity['value']);
	    $PHPExcel->getActiveSheet()->setCellValue('F' . $rowNumber, $result_list_opportunity['deadline']);
	    $PHPExcel->getActiveSheet()->setCellValue('G' . $rowNumber, $status_name);
	     
	    // Tăng row lên để khỏi bị lưu đè
	    $rowNumber++;
	}
	$PHPExcel->getActiveSheet()->setCellValue('H' . $rowNumber, "Total Value : ".$total_value);
	$PHPExcel->getActiveSheet()->setCellValue('I' . $rowNumber, "Total Value Status Won : ".$total_value_status_won);
	$objWriter = PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel5');
	 
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="Export_Excel_Opportunities.xls"');
	header('Cache-Control: max-age=0');
	if (isset($objWriter)) {
	    $objWriter->save('php://output');
	}

 ?>