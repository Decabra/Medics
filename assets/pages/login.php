<main id="login" class="fx-row">
   <section class="login-signup-body p-4 fx-row-nowrap justify-center">
      <div class="login-signup-section fx-row-nowrap fx-col fx-col-3 fx-col-3">
         <?php if (is_string($sess_response)) { ?>
         <div class="alert alert-danger"><?php echo $sess_response; ?></div>
         <?php } ?>
         <h1>Log in</h1>
         <form method="post">
            <input class="string-field" type="text" name="username" placeholder="Username" value="<?php echo $username; ?>" required>
            <input class="password" type="password" name="password" placeholder="Password" value="" required>
            <button class="login-btn" type="submit">Log in</button>
         </form>
      </div>
   </section>
</main>
