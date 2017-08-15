<?php 
    function array_sort_customers($array, $on, $order=SORT_ASC)
    {
        $new_array = array();
        $sortable_array = array();

        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }

            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                break;
                case SORT_DESC:
                    arsort($sortable_array);
                break;
            }

            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
            }
        }

        return $new_array;
    }
//    $list_customer = LbCustomer::model()->findAll();
//    $list_customer = array_sort_customers($list_customer, 'lb_customer_name', SORT_ASC); // DESC
//    echo "<option value=''> - ". Yii::t('lang','Select a Customer')." - </option>";
//    if (sizeof($list_customer) > 0) {
//        echo '<option value="0">- Add new Customer -</option>';
//        foreach ($list_customer as $row) {
//            $company_id = $row['lb_record_primary_key'];
//            echo '<option value="'. $row['lb_record_primary_key'] .'">'. stripcslashes($row['lb_customer_name']) .'</option>';
//        }
//    }
    $customer_arr = LbCustomer::model()->findAll(array('order'=>"`lb_customer_name` ASC"));
           
            $option_customer = '<option >Choose Customer</option> <option value="0">-- Add new --</option>';
            
            foreach ($customer_arr as $data)
            {
                $option_customer .='<option value="'.$data['lb_record_primary_key'].'">'.$data['lb_customer_name'].'</option>';
            }           
?>
