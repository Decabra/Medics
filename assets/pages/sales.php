<?php
   function pageData($query)
   {
       global $con, $hf_link;
       ob_start();
       $currency_symbol=settings("currency_symbol");
   ?>
<?php
   while ($data = mysqli_fetch_array($query))
   {
   ?>
               <div class="tb-row fx-row-nowrap">
                  <div class="tb-data fx-col-8">
                     <span class="tb-key" > <b>Customer: </b> </span>
                     <span class="tb-val" ><?php echo $data["customer_name"]; ?></span>
                  </div>
                  <div class="tb-data fx-col-5">
                     <span class="tb-key" > <b>Date: </b> </span>
                     <span class="tb-val" ><?php echo $data["sale_date"]; ?></span>
                  </div>
                  <div class="tb-data fx-col-10">
                     <span class="tb-key" > <b>Sub Total: </b> </span>
                     <span class="tb-val" ><?php echo $currency_symbol.$data["sub_total"]; ?></span>
                  </div>
                  <div class="tb-data fx-col-10">
                     <span class="tb-key" > <b>Discount: </b> </span>
                     <span class="tb-val" ><?php echo $currency_symbol.$data["discount"]; ?></span>
                  </div>
                  <div class="tb-data fx-col-10">
                     <span class="tb-key" > <b>Net Total: </b> </span>
                     <span class="tb-val" ><?php echo $currency_symbol.$data["net_total"]; ?></span>
                  </div>
                  <div class="tb-data fx-col-10">
                     <span class="tb-key" > <b>Received Amount: </b> </span>
                     <span class="tb-val" ><?php echo $currency_symbol.$data["received_amount"]; ?></span>
                  </div>
                  <div class="tb-data fx-col-10">
                     <span class="tb-key" > <b>Due Amount: </b> </span>
                     <span class="tb-val" ><?php echo $currency_symbol.$data["due_amount"]; ?></span>
                  </div>
                  <div class="tb-data fx-row-nowrap fx-col-5 action justify-even">
                     <span class="tb-key" > <b>Action: </b> </span>
                     <span class="tb-val" >
                     <a href="<?php echo $hf_link?>invoice?id=<?php echo $data["id"]; ?>" class="invoice"><i class="material-icons mat-ic">receipt</i>
                     </a>
                     </span>
                     <span class="tb-val" >
                     <a href="<?php echo $hf_link ?>add-sales?action=delete&id=<?php echo $data["id"]; ?>" class="del"><i class="material-icons mat-ic">delete</i>
                     </a>
                     </span>
                  </div>
               </div>
<?php
   } ?>
<?php
   $resp = ob_get_contents();
   ob_end_clean();
   return $resp;
   ?>
<?php
   }
   function basic_runner()
   {
       global $con, $session_username, $hf_link;
       $limit = (isset($_GET['limit']) && ($_GET['limit'] == 'all' || is_numeric($_GET['limit']))) ? filterData($_GET['limit']) : 2;
       $num = isset($_GET['page']) ? filterData($_GET['page']) : 1;
       $query = "SELECT id,customer_name,sale_date,discount,sub_total,net_total,received_amount,due_amount FROM sales WHERE added_by='$session_username' ORDER BY created_at DESC";
       $links = (isset($_GET['links'])) ? $_GET['links'] : 3;
       $url = $hf_link . 'sales?page=';
       $pagination = new Paginator(array(
           "db_con" => $con,
           "query" => $query,
           "limit_per_page" => $limit,
           "page_number" => $num,
           "page_url" => $url,
           "wp" => false,
           "pagination_classes" => 'pms-menu-footer m-t-2',
           "pagination_links_limit" => 3
       ));
       $total = $pagination->getTotalPages();
       $is_exist = (($num > 0 && $num <= $total) || $total == - 1) ? true : false;
       ob_start(); ?>
<?php if ($is_exist)
   { ?>
<div class="fx-row justify-between m-t-2">
   <div class="fx-2">
      <!-- rpr = Record per row -->
      <select id="rpr" class="pms-rpr" name="select-option">
         <option value="" <?php if (!isset($_GET["limit"])) echo "selected"; ?>>Default</option>
         <option value="10" <?php if ($limit == "10") echo "selected"; ?>>10</option>
         <option value="25" <?php if ($limit == "25") echo "selected"; ?>>25</option>
         <option value="50" <?php if ($limit == "50") echo "selected"; ?>>50</option>
         <option value="100" <?php if ($limit == "100") echo "selected"; ?>>100</option>
         <option value="all" <?php if ($limit == "all") echo "selected"; ?>>All</option>
      </select>
      <label for="rpr">Records per row</label>
   </div>
   <div class="fx-2">
      <label for="item">Search: </label>
      <input type="search" name="search-item" placeholder="Enter item" id="item" class="pms-search-item">
   </div>
</div>
<!-- Sales Table Start -->
<div class="pharmacists md-main-table m-t-2">
            <!-- Sales Table Head -->
            <div class="tb-head fx-row-nowrap">
               <div class="tb-th fx-col-8">Customer</div>
               <div class="tb-th fx-col-5">Date</div>
               <div class="tb-th fx-col-10">Sub Total</div>
               <div class="tb-th fx-col-10">Discount</div>
               <div class="tb-th fx-col-10">Net Total</div>
               <div class="tb-th fx-col-10">Received Amount</div>
               <div class="tb-th fx-col-10">Due Amount</div>
               <div class="tb-th fx-col-5">Action</div>
            </div>


   <!-- Sales Table Head End-->
   <!--Sales Table Body Start -->
   <div class="tb-body">
      <?php
         $limitquery = $pagination->getLimitQuery();
         echo pageData($limitquery);
         ?>
   </div>
   <!--Sales Table Body End -->
</div>
<!-- Sales Table End -->
<?php
   }
   else
   { ?>
<div class="pharmacists md-main-table m-t-2">
   <h3 class="text-center">No Sale Exist!</h3>
</div>
<?php
   } ?>
<?php
   if ($is_exist && $total != 1)
   {
       echo $pagination->getPagination();
   }
   ?>
<?php
   $data = ob_get_contents();
   ob_end_clean();
   return $data;
   }
   ?>

<section id="sales">
      <header class="pms-menu-header fx-row align-center p-1">
         <i class="material-icons mat-ic">local_atm</i>
         <h2 class="menu-heading">All Sales</h2>
      </header>

   <div class="pms-menu-body p-1">
      <?php
         $resp = \Delight\Cookie\Session::take('response');
         if (!empty($resp))
         { ?>
      <div class="alert <?php echo $resp["class"]; ?>"><?php echo $resp["message"]; ?></div>
      <?php
         } ?>
      <a class="fx-row pms-add-button m-t-1" href="<?php echo $hf_link; ?>add-sales">
         <i class="material-icons">add_circle_outline</i>
         <h5>Add Sale</h5>
      </a>
      <?php echo basic_runner(); ?>
   </div>
</div>
</section>
