<section id="pms-add-drug">
      <div class="pms-field-section m-l-3">
         <div class="pms-field-header fx-row justify-between align-center p-1">
            <h2 class="field-label">Add/Edit Drug</h2>
            <a href="<?php echo $hf_link; ?>medicine"><i class="material-icons mat-click">close</i></a>
         </div>
         <div class="pms-field-wrapper p-3">
<?php if (is_string($resp)) { ?>
<div class="alert alert-danger"><?php echo $resp; ?></div>
<?php } else if($resp === true) {?>
<div class="alert alert-success"><?php echo $resp_success_msg; ?></div>
<?php } ?>
<form method="post">
            <div class="pms-field-body fx-row-nowrap fx-col p-2">
                 <label for="d-name">Name</label>
                 <input type="text" name="name" id="d-name" class="string-entry" value="<?php if($resp !== true) echo $name; ?>" required>
                 <label for="d-company">Company</label>
                 <input type="text" name="company" id="d-company" class="string-entry" value="<?php if($resp !== true) echo $company; ?>" required>
                 <label for="d-Category">Category</label>
                 <input type="text" name="category" id="d-category" class="string-entry" value="<?php if($resp !== true) echo $category; ?>" required>
                 <label for="d-store">Store Box</label>
                 <input type="text" name="store" id="d-store" class="string-entry" value="<?php if($resp !== true) echo $store; ?>" required>
                 <label for="d-qty">Quantity</label>
                 <input type="text" name="quantity" id="d-qty" class="string-entry" value="<?php if($resp !== true) echo $quantity; ?>" required>
                 <label for="d-cost">Cost Price</label>
                 <input type="text" name="cost" id="d-cost" class="string-entry" value="<?php if($resp !== true) echo $cost; ?>" required>
                 <label for="d-sale">Sale Price</label>
                 <input type="text" name="sale" id="d-sale" class="string-entry" value="<?php if($resp !== true) echo $sale; ?>" required>
                 <label for="d-ex-date">Expiry Date (dd-mm-yyyy)</label>
                 <input type="text" name="expiry" id="d-ex-date" class="string-entry" value="<?php if($resp !== true) echo $expiry; ?>" required>
                 <button type="submit" class="login-btn submit-btn">Submit</button>
            </div>
</form>
         </div>
      </div>
   </section>
