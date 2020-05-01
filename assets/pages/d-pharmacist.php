<section id="pms-add-pharmacists">
   <div class="pms-field-section m-l-3">
      <div class="pms-field-header fx-row justify-between align-center p-1">
         <h2 class="field-label">Add/Edit Pharmacist</h2>
         <a href="<?php echo $hf_link; ?>pharmacists"><i class="material-icons mat-click">close</i></a>
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
               <label for="p-username">Username</label>
               <input type="text" name="username" id="p-username" class="string-entry" value="<?php if($resp !== true) echo $username; ?>" required>
               <label for="p-email">Email</label>
               <input type="text" name="email" id="p-email" class="string-entry" value="<?php if($resp !== true) echo $email; ?>" required>
               <label for="p-address">Address</label>
               <input type="text" name="address" id="p-address" class="string-entry" value="<?php if($resp !== true) echo $address; ?>" required>
               <label for="p-phone">Phone</label>
               <input type="text" name="phone" id="p-phone" class="string-entry" value="<?php if($resp !== true) echo $phone; ?>" required>
               <?php if($enter_pass) { ?>
               <label for="p-pass">Password</label>
               <input type="password" name="password" id="p-pass" class="string-entry" required>
               <label for="p-confirm-pass">Confirm Password</label>
               <input type="password" name="confirm_pass" id="p-confirm-pass" class="string-entry" required>
               <?php } ?>
               <button type="submit" class="login-btn submit-btn">Submit</button>
            </div>
         </form>
      </div>
   </div>
</section>
