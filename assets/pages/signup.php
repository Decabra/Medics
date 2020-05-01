<main id="sign-up" class="fx-row">
   <section class="login-signup-body  p-2 fx-row-nowrap justify-center">
      <div class="login-signup-section fx-row-nowrap fx-col fx-col-2">
         <?php if (is_string($resp)) { ?>
         <div class="alert alert-danger"><?php echo $resp; ?></div>
         <?php } else if($resp === true) {?>
         <div class="alert alert-success">You have registered successfully!</div>
         <?php } ?>
         <h1>Sign up</h1>
         <form method="post" class="fx-row-nowrap fx-col fx-col-2">
            <input type="text" name="name" placeholder="Name" class="string-field" value="<?php if($resp !== true) echo $name; ?>" required>
            <input type="text" name="username" placeholder="Username" class="string-field" value="<?php if($resp !== true) echo $username; ?>" required>
            <input type="text" name="email" placeholder="E-mail" class="string-field" value="<?php if($resp !== true) echo $email; ?>" required>
            <input type="password" name="password" placeholder="Password" class="string-field" value="" required>
            <input type="password" name="confirm_pass" placeholder="Confirm Password" class="password" value="" required>
            <button type="submit" class="login-btn">Sign up</button>
         </form>
      </div>
   </section>
</main>
