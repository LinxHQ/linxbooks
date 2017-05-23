<?php
/* @var $this LbExpensesController */
/* @var $model LbExpenses */


$m = $this->module->id;
$canAdd = BasicPermission::model()->checkModules($m, 'add');
$canList = BasicPermission::model()->checkModules($m, 'list');
?>
<?php
/**
 * PHPExcel
 *
 * Copyright (c) 2006 - 2015 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2015 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    ##VERSION##, ##DATE##
 */

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once YII::app()->basePath.'/lib/PHPExcel-1.8/Classes/PHPExcel.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");


$row=1;
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$row,'EXPENSES REPORT');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$row.':H'.$row);
$objPHPExcel->getActiveSheet()
    ->getStyle('A'.$row)
    ->getAlignment()
    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle("A".$row)->getFont()->setBold(true);

$row=$row+1;
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$row,'From: '.$date_from.' To: '.$date_to);
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$row.':H'.$row);
$objPHPExcel->getActiveSheet()
    ->getStyle('A'.$row)
    ->getAlignment()
    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle("A".$row)->getFont()->setBold(true);

//HEADER COLUNM
$row=$row+2;
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$row,'No.');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$row,'Date');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$row,'Expenses No');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$row,'Category');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$row,'Note');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$row,'Total');


$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':F'.$row)->applyFromArray(
    array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '43CD80')
        )
    )
);

########## BODY #####################
$i=0;
$dataProvider = $model->search($canList,false);
foreach ($dataProvider->data as $data) {
   $date = $data->lb_expenses_date ? date("d M, Y", strtotime($data->lb_expenses_date)) : "";
   $expense_no = $data->lb_expenses_no;
   $category = (count(UserList::model()->getItem($data->lb_category_id)))>0 ?(UserList::model()->getItem($data->lb_category_id)->system_list_item_name): "";
   $note = $data->lb_expenses_note;
   $total = "$".number_format($data->lb_expenses_amount,2);

$row ++;$i++;
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$row,$i);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$row,$date);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$row,$expense_no);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$row,$category);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$row,$note);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$row,$total);
}
// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Expenses report');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="expense_report.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
ob_end_clean();
$objWriter->save('php://output');
exit;

