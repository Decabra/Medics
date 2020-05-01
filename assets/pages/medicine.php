<?php
   function pageData($query)
   {
       global $con, $hf_link;
       ob_start();
       $currency_symbol = settings('currency_symbol');
   ?>
<?php
   while ($data = mysqli_fetch_array($query))
   {
   ?>
<div class="tb-row fx-row-nowrap">
   <div class="tb-data fx-col-8">
      <span class="tb-key" > <b>Name: </b> </span>
      <span class="tb-val" ><?php echo $data["name"]; ?></span>
   </div>
   <div class="tb-data fx-col-9">
      <span class="tb-key" > <b>Company: </b> </span>
      <span class="tb-val" ><?php echo $data["company"]; ?></span>
   </div>
   <div class="tb-data fx-col-8">
      <span class="tb-key" > <b>Category: </b> </span>
      <span class="tb-val" ><?php echo $data["category"]; ?></span>
   </div>
   <div class="tb-data fx-col-8">
      <span class="tb-key" > <b>Store Box: </b> </span>
      <span class="tb-val" ><?php echo $data["store_box"]; ?></span>
   </div>
   <div class="tb-data fx-col-10">
      <span class="tb-key" > <b>Qty: </b> </span>
      <span class="tb-val" ><?php echo $data["quantity"]; ?></span>
   </div>
   <div class="tb-data fx-col-8">
      <span class="tb-key" > <b>Cost price: </b> </span>
      <span class="tb-val" ><?php echo $currency_symbol . $data["cost_price"]; ?></span>
   </div>
   <div class="tb-data fx-col-8">
      <span class="tb-key" > <b>Sale Price: </b> </span>
      <span class="tb-val" ><?php echo $currency_symbol . $data["sale_price"]; ?></span>
   </div>
   <div class="tb-data fx-col-8">
      <span class="tb-key" > <b>Expiry Date: </b> </span>
      <span class="tb-val" ><?php echo $data["expiry_date"]; ?></span>
   </div>
   <div class="tb-data fx-row-nowrap fx-col-6 action justify-even ">
      <span class="tb-key" > <b>Action: </b> </span>
      <span class="tb-val" >
      <a href="<?php echo $hf_link ?>drug?action=edit&id=<?php echo $data["id"]; ?>" class="edit"><i class="material-icons mat-ic">create</i>
      </a>
      </span>
      <span class="tb-val" >
      <a href="<?php echo $hf_link ?>drug?action=delete&id=<?php echo $data["id"]; ?>" class="del"><i class="material-icons mat-ic">delete</i>
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
       $query = "SELECT id,name,company,category,store_box,quantity,cost_price,sale_price,expiry_date FROM medicine WHERE username='{$session_username}' ORDER BY created_at DESC";
       $links = (isset($_GET['links'])) ? $_GET['links'] : 3;
       $url = $hf_link . 'medicine?page=';
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
<!-- Medicine Table Start -->
<div class="medicine md-main-table m-t-2">
   <!-- Medicine Table Head Start -->
   <div class="tb-head fx-row-nowrap">
      <div class="tb-th fx-col-8">Name</div>
      <div class="tb-th fx-col-9">Company</div>
      <div class="tb-th fx-col-8">Category</div>
      <div class="tb-th fx-col-8">Store Box</div>
      <div class="tb-th fx-col-10">Qty</div>
      <div class="tb-th fx-col-8">Cost Price</div>
      <div class="tb-th fx-col-8">Sale Price</div>
      <div class="tb-th fx-col-8">Expiry Date</div>
      <div class="tb-th fx-col-6">Action</div>
   </div>
   <!-- Medicine Table Head End-->
   <!--Medicine Table Body Start -->
   <div class="tb-body">
      <?php
         $limitquery = $pagination->getLimitQuery();
         echo pageData($limitquery);
         ?>
   </div>
   <!--Medicine Table Body End -->
</div>
<!-- Medicine Table End -->
<?php
   }
   else
   { ?>
<div class="medicine md-main-table m-t-2">
   <h3 class="text-center">No Drug Exist!</h3>
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
<div id="pms-drug-container">
   <header class="pms-menu-header fx-row align-center p-1">
      <i class="material-icons mat-ic">local_pharmacy</i>
      <h2 class="menu-heading">All Drugs</h2>
   </header>
   <div class="pms-menu-body p-1">
      <?php
         $resp = \Delight\Cookie\Session::take('response');
         if (!empty($resp))
         { ?>
      <div class="alert <?php echo $resp["class"]; ?>"><?php echo $resp["message"]; ?></div>
      <?php
         } ?>
      <a class="fx-row pms-add-button m-t-1" href="<?php echo $hf_link; ?>drug">
         <i class="material-icons">add_circle_outline</i>
         <h5>Add Drug</h5>
      </a>
      <?php echo basic_runner(); ?>
   </div>
</div>
<!-- Medicine Table Footer Start -->
<!-- <div class="pms-menu-footer m-t-2">
   <ul class="fx-row justify-center">
      <li>
         <a href="#" class="pms-nav-footer">1</a>
      </li>
      <li>
         <a href="#" class="pms-nav-footer">2</a>
      </li>
      <li>
         <a href="#" class="pms-nav-footer">3</a>
      </li>
      <li>
         <a href="#"  class="pms-nav-footer">4</a>
      </li>
      <li>
         <a href="#" class="pms-nav-footer">Next</a>
      </li>
   </ul>
   </div> -->
<!-- Medicine Table Footer End -->
