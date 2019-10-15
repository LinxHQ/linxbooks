<?php
$year_now = date('Y');
$month_now = date('m');
$day_now = date('d');

//$date  = date_format($date, 'g:ia \o\n l jS F Y');
if(isset($_GET['lb_record_primary_key'])){
    $a = $_GET['lb_record_primary_key'];
    $expenses = LbExpenses::model()->findByPK($a);
    $note = $expenses->lb_expenses_note;
    $amount = $expenses->lb_expenses_amount;
    $date = $expenses->lb_expenses_date;
    $expenses_no = $expenses->lb_expenses_no;
    $price = number_format($amount,0,".",".");
    $key = number_format($amount,0,"","");
// print_r($test->data);exit;
}


$date_en= date('F jS Y',strtotime($date));

$expensesPdf =
        '<table style="width:30%;">
        <tr>
            <td></td>
            <td><span style="margin-left:70px;" >Tax code: 0106760635</span></td>
        </tr>
        <tr>
            <td><span></span></td>
            <td><span style="font-weight:bold; margin-left:100px;">From 02-TT</span></td>
        </tr>
        <tr cellspacing="10px">
            <td>Nhà số 7, tổ 10, P. Dịch Vọng Hậu, Q. Cầu Giấy</td>
            <td><span style="margin-left:-30px;">(According to Circular No.200/2014/TT-BTC</span></td>
        </tr>
        <tr>
            <td><span style="margin-left:100px;">TP. Hà Nội</span></td>
            <td><span style="margin-left:-60px;">Dated december 22nd2014 of the Ministry of Finance)</span></td>
        </tr>
       <tr>
            <td><span ></span></td>
            <td><span style="margin-left:100px;">Copy no: 1</span></td>
        </tr>
        <tr>
            <td><span></span></td>
            <td><span style="margin-left:100px;">Book no: PC001</span></td>
        </tr>
        <tr>
            <td><span style="font-size:25px;font-weight:bold; margin-left:180px;">PAYMENT VOUCHER</span></td>
            <td><span style="margin-left:100px;">No.: '.$expenses_no.'</span></td>
        </tr>
        <tr>
            <td><span style="margin-left:250px;">'.$date_en.'</span></td>
            <td><span style="margin-left:100px;">Debit:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$price.'</span></td>
        </tr>
        <tr>
            <td><span></span></td>
            <td><span style="margin-left:100px;">Credit:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$price.'</span></td>
        </tr>
    </table>'.
 '<table width =" 100%" >'
    .'<tr>
        <td><span style="font-weight:bold;">Receiver:</span></td>
        <td><span style="font-weight:bold;">Theo bảng kê thanh toán</span></td>
    </tr>'
    .'<tr>
        <td>Address:</td>
        <td>Nhà số 7, tổ 10, P. Dịch Vọng Hậu, Q. Cầu Giấy, TP. Hà Nội</td>
    </tr>'
    .'<tr>
        <td>Memo:</td>
        <td>'. $note .'</td>
    </tr>'
    .'<tr>
        <td><span style="font-weight:bold;">Amount: </span></td>
        <td><span style="font-weight:bold;">'. $price .' VND</span></td>
    </tr>'
    .'<tr>
        <td>In words: </td>
        <td>'. LbExpenses::model()->convertNumberToWordsEng($key) .' '. LbGenera::model()->getGeneraCurrency().'.</td>
    </tr>'
    .'<tr>
        <td>Enclose: </td>
        <td> 0 original voucher(s).</td>
    </tr>'
        .'<tr>
        <td> '.'<br />'.'<br />'.' </td>'
        . '</tr>'
    .'<tr>
        <td><span></span></td>
        <td><span style="margin-left:400px;">'.$date_en.'</span></td>
    </tr>'
    .'</table>'.
'<table >'
    .'<tr>
        <td><span style="margin-left:40px;">DIRECTOR</span></td>
        <td><span style="margin-left:10px;">CHIEF ACCOUNTANT</span></td>
        <td><span style="margin-left:50px;">CASHIER</span></td>
        <td><span style="margin-left:30px;">PREPARED BY</span></td>
        <td><span style="margin-left:45px;">RECEIVER</span></td>
    </tr>'
    .'<tr style="font-size:12px;">
        <td><span style="margin-left:-10px;">(Signature, full name, seal)</span></td>
        <td><span style="margin-left:15px;">(Signature, full name)</span></td>
        <td><span style="margin-left:15px;">(Signature, full name)</span></td>
        <td><span style="margin-left:15px;">(Signature, full name)</span></td>
        <td><span style="margin-left:15px;">(Signature, full name)</span></td>
    </tr>'
    .'<tr>
        <td> '.'<br />'.'<br />' .'<br />'. '<br />'.'<br />' .'<br />'.' </td>'
        . '</tr>'
        
        
.'</table>'

        .'<div>Received full (in words): '. LbExpenses::model()->convertNumberToWordsEng($key) .' '. LbGenera::model()->getGeneraCurrency().'.</div>';
    

    echo $expensesPdf;
?>


