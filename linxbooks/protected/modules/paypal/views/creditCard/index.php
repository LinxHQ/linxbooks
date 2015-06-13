<?php $this->pageTitle=Yii::app()->name; ?>

<h2>Package</h2>
<?php 
//var_dump($value);
foreach ($value as $v) {
//    echo '<input type="button" name="" id="'.strtolower($value[$i]['name']).'" value="'.$value[$i]['value'].'$/'.$value[$i]['name'].'" onclick="creditCard('.$i.');"/>&nbsp;&nbsp;';
//    echo '<a href="?r=site/card&id='.$v->subscription_id.'">'.$v->subscription_value.'$/'.$v->subscription_name.'</a>&nbsp;&nbsp;';
    $url = $this->createUrl("/paypal/creditCard/creditCard",array('id'=>$v->subscription_id));
    echo '<a href="'.$url.'">'.$v->subscription_value.'$/'.$v->subscription_name.'</a>&nbsp;&nbsp;';
}
?>