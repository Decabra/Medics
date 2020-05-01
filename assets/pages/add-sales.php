<section id="pms-add-sales" class="">
   <div class="pms-field-section m-l-3">
      <div class="pms-field-header fx-row justify-between align-center p-1">
         <h2 class="field-label">Point of Sale</h2>
         <a href="/?back-to-sales"><i class="material-icons mat-click">close</i></a>
      </div>
      <div class="pms-field-wrapper p-3">
<?php if (is_string($resp)) { ?>
<div class="alert alert-danger"><?php echo $resp; ?></div>
<?php } else if($resp === true) {?>
<div class="alert alert-success"><?php echo $resp_success_msg; ?></div>
<?php } ?>
<form method="post">
           <div class="pms-field-body fx-row-nowrap fx-col p-2">
              <label for="s-customer">Customer</label>
              <input type="text" name="customer_name" id="s-customer" class="string-entry" value="<?php if($resp !== true) echo $customer_name; ?>" required>
              <label for="s-date">Date (dd-mm-yyyy)</label>
              <input type="text" name="sale_date" id="s-date" class="string-entry" value="<?php if($resp !== true) echo $sale_date; ?>" required>
              <label for="s-discount">Discount</label>
              <input type="text" name="discount" id="s-discount" class="string-entry" value="<?php if($resp !== true) echo $discount; ?>" required>
              <label for="s-sub">Sub Total</label>
              <input type="text" name="sub_total" id="s-sub" class="string-entry" value="<?php if($resp !== true) echo $sub_total; ?>" required>
              <label for="s-net">Net Total</label>
              <input type="text" name="net_total" id="s-net" class="string-entry" value="<?php if($resp !== true) echo $net_total; ?>" required>
              <label for="s-receive">Amount Received</label>
              <input type="text" name="received_amount" id="s-receive" class="string-entry" value="<?php if($resp !== true) echo $received_amount; ?>" required>
              <label for="s-due">Due Amount</label>
              <input type="text" name="due_amount" id="s-due" class="string-entry" value="<?php if($resp !== true) echo $due_amount; ?>" required>
              <button type="submit" class="login-btn submit-btn">Submit</button>
           </div>
</form>
      </div>
   </div>
</section>
