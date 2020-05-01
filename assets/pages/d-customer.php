   <section id="pms-add-customers">
   <div class="pms-field-section m-l-3">
         <div class="pms-field-header fx-row justify-between align-center p-1">
            <h2 class="field-label">Add/Edit Customer</h2>
         <a href="<?php echo $hf_link; ?>customers"><i class="material-icons mat-click">close</i></a>
         </div>
         <div class="pms-field-wrapper p-3">
         <?php if (is_string($resp)) { ?>
         <div class="alert alert-danger"><?php echo $resp; ?></div>
         <?php } else if($resp === true) {?>
         <div class="alert alert-success"><?php echo $resp_success_msg; ?></div>
         <?php } ?>
         <form method="post">
            <div class="pms-field-body fx-row-nowrap fx-col p-2">
               <label for="p-name">Name</label>
               <input type="text" name="name" id="p-name" class="string-entry" value="<?php if($resp !== true) echo $name; ?>" required>
               <label for="p-email">Email</label>
               <input type="text" name="email" id="p-email" class="string-entry" value="<?php if($resp !== true) echo $email; ?>" required>
               <label for="p-address">Address</label>
               <input type="text" name="address" id="p-address" class="string-entry" value="<?php if($resp !== true) echo $address; ?>" required>
               <label for="p-phone">Phone</label>
               <input type="text" name="phone" id="p-phone" class="string-entry" value="<?php if($resp !== true) echo $phone; ?>" required>
               <label for="c-gender">Gender</label>
               <select id="c-gender" class="string-entry" name="gender">
                  <option value="male" <?php if($resp !== true && $gender == "male") echo "selected"; ?>>Male</option>
                  <option value="female" <?php if($resp !== true && $gender == "female") echo "selected"; ?>>Female</option>
                  <option value="other" <?php if($resp !== true && $gender == "other") echo "selected"; ?>>Other</option>
               </select>
               <label for="p-due">Due Balance</label>
               <input type="text" name="due_balance" id="p-due" class="string-entry" value="<?php if($resp !== true) echo $due_balance; ?>" required>
               <button type="submit" class="login-btn submit-btn">Submit</button>
            </div>
         </form>
         </div>
      </div>
   </section>
