<?php

if(isset($_GET['lb_record_primary_key'])){
    $a = $_GET['lb_record_primary_key'];
    $expenses = LbExpenses::model()->findByPK($a);
    $note = $expenses->lb_expenses_note;
    $date = $expenses->lb_expenses_date;
    $amount = $expenses->lb_expenses_amount;
    $expenses_no = $expenses->lb_expenses_no;
    $price = number_format($amount,0,".",".");
    $key = number_format($amount,0,"","");
    $space = "        ";
   
// print_r($test->data);exit;
}
$year_now = date('Y',strtotime($date));
$month_now = date('m',strtotime($date));
$day_now = date('d',strtotime($date));

$expensesPdf =
        '<table style="width:30%;">
        <tr>
            <td></td>
            <td><span style="margin-left:70px;" >Mã số thuế: 0106760635</span></td>
        </tr>
        <tr>
            <td><span>Công ty TNHH KYDON Việt Nam</span></td>
            <td><span style="font-weight:bold; margin-left:100px;">Mẫu số 02-TT</span></td>
        </tr>
        <tr cellspacing="10px">
            <td>Nhà số 7, tổ 10, P. Dịch Vọng Hậu, Q. Cầu Giấy, TP. Hà Nội</td>
            <td >(Ban hành theo Thông tư số 133/2016/TT-BTC</td>
        </tr>
        <tr>
            <td><span></span></td>
            <td><span style="margin-left:30px;">ngày 26/08/2006 của Bộ trưởng BTC)</span></td>
        </tr>
        <tr>
            <td><span ></span></td>
            <td><span style="margin-left:100px;">Liên số: 1</span></td>
        </tr>
        <tr>
            <td><span></span></td>
            <td><span style="margin-left:100px;">Quyển số: PC001</span></td>
        </tr>
        <tr>
            <td><span style="font-size:25px;font-weight:bold; margin-left:280px;">PHIẾU CHI</span></td>
            <td><span style="margin-left:100px;">Số phiếu: '.$expenses_no.'</span></td>
        </tr>
        <tr>
            <td><span style="margin-left:250px;">NGÀY '. $day_now .' THÁNG '. $month_now .' NĂM '. $year_now .'</span></td>
            <td><span style="margin-left:100px;">Nợ:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$price.'</span></td>
        </tr>
        <tr>
            <td><span></span></td>
            <td><span style="margin-left:100px;">Có:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$price.'</span></td>
        </tr>
    </table>'.
 '<table width =" 100%" >'
    .'<tr>
        <td><span style="font-weight:bold;">Họ, tên người nhận tiền:</span></td>
        <td><span style="font-weight:bold;">Theo bảng kê thanh toán</span></td>
    </tr>'
    .'<tr>
        <td>Đơn vị :</td>
        <td>KYDON - Công ty TNHH Kydon Việt Nam</td>
    </tr>'
    .'<tr>
        <td>Địa chỉ:</td>
        <td>Nhà số 7, tổ 10, P. Dịch Vọng Hậu, Q. Cầu Giấy, TP. Hà Nội</td>
    </tr>'
    .'<tr>
        <td>Lý do chi:</td>
        <td>'. $note .'</td>
    </tr>'
    .'<tr>
        <td><span style="font-weight:bold;">Số tiền: </span></td>
        <td><span style="font-weight:bold;">'. $price .' VND</span></td>
    </tr>'
    .'<tr>
        <td>Bằng chữ: </td>
        <td>'. LbExpenses::model()->convertNumberToWords($key) .' đồng chẵn.</td>
    </tr>'
    .'<tr>
        <td>Kèm theo: </td>
        <td>. . . . .chứng từ gốc.</td>
    </tr>'
        .'<tr>
        <td> '.'<br />'.' </td>'
        . '</tr>'
    .'<tr>
        <td><span></span></td>
        <td><span style="margin-left:300px;">Ngày '. $day_now .' Tháng '. $month_now .' Năm '. $year_now .'</span></td>
    </tr>'
    .'</table>'.
'<table >'
    .'<tr>
        <td><span style="margin-left:15px;">TỔNG GIÁM ĐỐC</span></td>
        <td><span style="margin-left:15px;">PHỤ TRÁCH KẾ TOÁN</span></td>
        <td><span style="margin-left:35px;">THỦ QUỸ</span></td>
        <td><span style="margin-left:35px;">NGƯỜI LẬP PHIẾU</span></td>
        <td><span style="margin-left:35px;">NGƯỜI NHẬN TIỀN</span></td>
    </tr>'
    .'<tr>
        <td><span>(Ký, họ tên, đóng dấu)</span></td>
        <td><span style="margin-left:45px;">(Ký, họ tên)</span></td>
        <td><span style="margin-left:25px;">(Ký, họ tên)</span></td>
        <td><span style="margin-left:60px;">(Ký, họ tên)</span></td>
        <td><span style="margin-left:60px;">(Ký, họ tên)</span></td>
    </tr>'
    .'<tr>
        <td> '.'<br />' .'<br />'. '<br />'.'<br />' .'<br />'.' </td>'
        . '</tr>'
        
        
.'</table>'

        .'<div>Đã nhận đủ số tiền(viết bằng chữ): '. LbExpenses::model()->convertNumberToWords($key) .' đồng chẵn.</div>';
    

    echo $expensesPdf;
?>


