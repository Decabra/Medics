</div>
</div>
</main>
<footer id="footer">
   <?php echo load_footer() ?>
   <div class="foot-content">
      <?php
         $year=date('Y');
         if($year == '2019') { ?>
      <h5 class="foot-caption">Copyright &copy; 2019 <a href="<?php echo $website_url; ?>"><?php echo $website_name; ?></a>. All right reserved</h5>
      <?php } else { ?>
      <h5 class="foot-caption">Copyright &copy; 2019-<?php echo $year;?> <a href="<?php echo $website_url; ?>"><?php echo $website_name; ?></a>. All right reserved</h5>
      <?php } ?>
   </div>
</footer>
</body>
</html>
