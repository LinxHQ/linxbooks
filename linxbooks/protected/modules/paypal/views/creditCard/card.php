<?php
$this->pageTitle=Yii::app()->name . ' - Credit Card';
$this->breadcrumbs=array(
	'Card',
);
?>

<h1>Credit Card</h1>

<div class="form">
    <?php 
    $form=$this->beginWidget('CActiveForm', array(
	'id'=>'card-form',
	'enableClientValidation'=>FALSE,
//	'clientOptions'=>array(
//		'validateOnSubmit'=>true,
//	),
));  
    ?>
<!--<form action="" method="POST" id="payment-form">-->
  <span class="payment-errors"></span>

  <table id="tbl_credit_card">
      <?php
      if (!isset($card_saved) || $card_saved == '') {
      ?>
      <tr>
          <td>First Name: </td>
          <td><input type="text" size="20" id="first_name" name="first_name"/></td>
      </tr>
      <tr>
          <td>Last Name: </td>
          <td><input type="text" size="20" id="last_name" name="last_name"/></td>
      </tr>
      <tr>
          <td>Credit Card Number *: </td>
          <td><input type="text" size="20" id="card_number" name="card_number"/></td>
      </tr>
      <tr>
          <td>Payment Types *: </td>
          <td>
              <select id="payment_type" class="" name="payment_type">
                    <option value=" ">Select a card</option>
                    <option value="visa">Visa</option>
                    <option value="mastercard">Master Card</option>
                    <option value="amex">American Express</option>
                    <option value="discover">Discover</option>
              </select>
          </td>
      </tr>
      <tr>
          <td>Expiration Date (MM/YYYY) *: </td>
          <td>
                <input type="text" size="2" id="exp_month" name="exp_month"/>
                <span> / </span>
                <input type="text" size="4" id="exp_year" name="exp_year"/>
          </td>
      </tr>
      <tr>
          <td>CSC *: </td>
          <td><input type="text" size="4" id="csc" name="csc"/></td>
      </tr>
      <?php
      } else {
      ?>
          <input type="hidden" size="4" id="card_id" name="card_id" value="<?php echo $card_saved;?>"/>
      <?php
      }
      ?>
      <tr>
          <td>Total: </td>
          <td>
              <input type="text" readonly="true" size="4" id="total_dis" name="total_dis" value="<?php echo $total.' USD';?>"/>
              <input type="hidden" id="total" name="total" value="<?php echo $total;?>"/>
          </td>
      </tr>
      <tr><td colspan="2"  align="center"><button type="submit">Submit Card</button></td></tr>
  </table>
  
<!--</form>-->
<?php $this->endWidget(); ?>
</div>
