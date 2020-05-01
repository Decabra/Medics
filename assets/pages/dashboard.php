<!-- Dashboard Start -->
<section  id="dashboard" class="display-body">
   <div class="box-container fx-row ">
      <div class="box fx-col-4 m-r-1 p-0">
         <a href="#" class="fx-row h-full">
            <section class="box-sec ">
               <i class="material-icons">local_hospital</i>
            </section>
            <div class="fx-row fx-col justify-center align-center fx-col-1 p-0">
               <h1><?php echo $total_drugs; ?></h1>
               <p>All Drugs</p>
            </div>
         </a>
      </div>
      <div class="box fx-col-4 m-r-1 p-0">
         <a href="#" class="fx-row h-full">
            <section class="box-sec ">
               <i class="material-icons">local_hospital</i>
            </section>
            <div class="fx-row fx-col justify-center align-center fx-col-1 p-0">
               <h1><?php echo $total_quantity; ?></h1>
               <p>Total Quantity</p>
            </div>
         </a>
      </div>
      <div class="box fx-col-4 m-r-1 p-0">
         <a href="#" class="fx-row h-full">
            <section class="box-sec ">
               <i class="material-icons">local_hospital</i>
            </section>
            <div class="fx-row fx-col justify-center align-center fx-col-1 p-0">
               <h1><?php echo $out_of_stock; ?></h1>
               <p>Out of Stock</p>
            </div>
         </a>
      </div>
      <div class="box fx-col-4 p-0">
         <a href="#" class="fx-row h-full">
            <section class="box-sec ">
               <i class="material-icons">local_hospital</i>
            </section>
            <div class="fx-row fx-col justify-center align-center fx-col-1 p-0">
               <h1><?php echo $expired_drugs; ?></h1>
               <p>Expired Drugs</p>
            </div>
         </a>
      </div>
   </div>
   <!-- dash section Start -->
   <section class=" m-t-5 fx-row">
      <div class="fx-col-1">
         <header class="pms-menu-header fx-row align-center p-1">
            <h2 class="menu-heading">Expiration Notice</h2>
         </header>
         <!-- dash Table Start -->
         <div class="invoice md-main-table">
            <!-- dash Table Head -->
            <div class="tb-head fx-row-nowrap">
               <div class="tb-th fx-col-3">Name</div>
               <div class="tb-th fx-col-3">Category</div>
               <div class="tb-th fx-col-3">Store Box</div>
               <div class="tb-th fx-col-3">Action</div>
            </div>
            <!--dash Table Body -->
            <div class="tb-body">

<?php foreach ($expire_soon_arr as $expire_soon_drug) { ?>
               <div class="tb-row fx-row-nowrap">
                  <div class="tb-data fx-col-3">
                     <span class="tb-key" > <b>Name: </b> </span>
                     <span class="tb-val" ><?php echo $expire_soon_drug["name"] ?></span>
                  </div>
                  <div class="tb-data fx-col-3">
                     <span class="tb-key" > <b>Category: </b> </span>
                     <span class="tb-val" ><?php echo $expire_soon_drug["category"] ?></span>
                  </div>
                  <div class="tb-data fx-col-3">
                     <span class="tb-key" > <b>Store Box: </b> </span>
                     <span class="tb-val" ><?php echo $expire_soon_drug["store_box"] ?></span>
                  </div>
                  <div class="tb-data fx-col-3">
                     <span class="tb-key" > <b>Action: </b> </span>
                     <span class="tb-val" ><a href="<?php echo $hf_link ?>drug?action=edit&id=<?php echo $expire_soon_drug["id"]; ?>">Edit</a></span>
                  </div>
               </div>
<?php } ?>

            </div>
         </div>
      </div>
      <div class="fx-col-1">
         <header class="pms-menu-header fx-row align-center p-1">
            <h2 class="menu-heading">Expired Drugs</h2>
         </header>
         <!-- dash Table Start -->
         <div class="invoice md-main-table">
            <!-- dash Table Head -->
            <div class="tb-head fx-row-nowrap">
               <div class="tb-th fx-col-3">Name</div>
               <div class="tb-th fx-col-3">Category</div>
               <div class="tb-th fx-col-3">Store Box</div>
               <div class="tb-th fx-col-3">Action</div>
            </div>
            <!--dash Table Body -->
            <div class="tb-body">
<?php foreach ($expired_drugs_arr as $expired_drug) { ?>
               <div class="tb-row fx-row-nowrap">
                  <div class="tb-data fx-col-3">
                     <span class="tb-key" > <b>Name: </b> </span>
                     <span class="tb-val" ><?php echo $expired_drug["name"] ?></span>
                  </div>
                  <div class="tb-data fx-col-3">
                     <span class="tb-key" > <b>Category: </b> </span>
                     <span class="tb-val" ><?php echo $expired_drug["category"] ?></span>
                  </div>
                  <div class="tb-data fx-col-3">
                     <span class="tb-key" > <b>Store Box: </b> </span>
                     <span class="tb-val" ><?php echo $expired_drug["store_box"] ?></span>
                  </div>
                  <div class="tb-data fx-col-3">
                     <span class="tb-key" > <b>Action: </b> </span>
                     <span class="tb-val" ><a href="<?php echo $hf_link ?>drug?action=edit&id=<?php echo $expired_drug["id"]; ?>">Edit</a></span>
                  </div>
               </div>
<?php } ?>
            </div>
         </div>
      </div>
   </section>
   <section class=" m-t-5 fx-row">
      <div class="fx-col-1">
         <header class="pms-menu-header fx-row align-center p-1">
            <h2 class="menu-heading">Out of Stock</h2>
         </header>
         <!-- dash Table Start -->
         <div class="invoice md-main-table">
            <!-- dash Table Head -->
            <div class="tb-head fx-row-nowrap">
               <div class="tb-th fx-col-3">Name</div>
               <div class="tb-th fx-col-3">Category</div>
               <div class="tb-th fx-col-3">Store Box</div>
               <div class="tb-th fx-col-3">Action</div>
            </div>
            <!--dash Table Body -->
            <div class="tb-body">

<?php foreach ($out_of_stock_arr as $out_of_stock_drug) { ?>
               <div class="tb-row fx-row-nowrap">
                  <div class="tb-data fx-col-3">
                     <span class="tb-key" > <b>Name: </b> </span>
                     <span class="tb-val" ><?php echo $out_of_stock_drug["name"] ?></span>
                  </div>
                  <div class="tb-data fx-col-3">
                     <span class="tb-key" > <b>Category: </b> </span>
                     <span class="tb-val" ><?php echo $out_of_stock_drug["category"] ?></span>
                  </div>
                  <div class="tb-data fx-col-3">
                     <span class="tb-key" > <b>Store Box: </b> </span>
                     <span class="tb-val" ><?php echo $out_of_stock_drug["store_box"] ?></span>
                  </div>
                  <div class="tb-data fx-col-3">
                     <span class="tb-key" > <b>Action: </b> </span>
                     <span class="tb-val" ><a href="<?php echo $hf_link ?>drug?action=edit&id=<?php echo $out_of_stock_drug["id"]; ?>">Edit</a></span>
                  </div>
               </div>
<?php } ?>

            </div>
         </div>
      </div>
      <div class="fx-col-1">
         <header class="pms-menu-header fx-row align-center p-1">
            <h2 class="menu-heading">Latest Sales</h2>
         </header>
         <!-- dash Table Start -->
         <div class="invoice md-main-table">
            <!-- dash Table Head -->
            <div class="tb-head fx-row-nowrap">
               <div class="tb-th fx-col-3">Customer Name</div>
               <div class="tb-th fx-col-4">Date</div>
               <div class="tb-th fx-col-5">Amount</div>
               <div class="tb-th fx-col-4">Action</div>
            </div>
            <!--dash Table Body -->
            <div class="tb-body">
<?php $s_data = mysqli_query($con, "SELECT id,customer_name,sale_date,received_amount FROM sales ORDER BY created_at DESC LIMIT 2");
while($sale_data=mysqli_fetch_array($s_data)) {
 ?>
               <div class="tb-row fx-row-nowrap">
                  <div class="tb-data fx-col-3">
                     <span class="tb-key" > <b>Customer Name: </b> </span>
                     <span class="tb-val" ><?php echo $sale_data["customer_name"]; ?></span>
                  </div>
                  <div class="tb-data fx-col-4">
                     <span class="tb-key" > <b>Date: </b> </span>
                     <span class="tb-val" ><?php echo $sale_data["sale_date"]; ?></span>
                  </div>
                  <div class="tb-data fx-col-5">
                     <span class="tb-key" > <b>Amount: </b> </span>
                     <span class="tb-val" ><?php echo $currency_symbol.$sale_data["received_amount"]; ?></span>
                  </div>
                  <div class="tb-data fx-col-4">
                     <span class="tb-key" > <b>Action: </b> </span>
                     <span class="tb-val" ><a href="<?php echo $hf_link;?>add-sales?action=edit&id=<?php echo $sale_data["id"]; ?>">Edit</a></span>
                  </div>
               </div>
<?php } ?>
            </div>
         </div>
      </div>
   </section>
</section>
<!-- Dashboard Ends -->
