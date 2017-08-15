<?php

$search_name = isset($_POST['search_name']) ? $_POST['search_name'] : '';
$result = LbQuotation::model()->searchQuotation($search_name);
$result_arr = array();
?>
<ul id="country-list">
<?php
foreach($result as $value) {
?>
    <li class="li_search" onClick="selectValue('<?php echo $value['lb_quotation_no']; ?>');">
<?php 
    echo "<p href='#' style='cursor:pointer' onclick='link(".$value['lb_record_primary_key'].",\"".$value['lb_quotation_no']."\")'>";
    echo $value['lb_quotation_no'];
    echo "</p>";
?></li>
<?php } ?>
</ul>