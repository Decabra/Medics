<!-- Invoice Start -->
<section id="pms-sales-invoice" class="fx-row justify-center">
   <div class="pms-invoice-body fx-row fx-col align-center p-2">
      <h1 class="m-b-1"><?php echo $company_name; ?></h1>
      <h4 class="invoice-info"><?php echo $company_address; ?></h4>
      <h4 class="invoice-info">Tel: <?php echo $company_phone; ?></h4>
      <div class="fx-row m-t-2 justify-between">
         <div class="slot-1">
            <h3 class="invoice-info">PAYMENT TO:</h3>
            <p class="invoice-info"><?php echo $company_name; ?><br><?php echo $company_address; ?><br>Tel: <?php echo $company_phone; ?></p>
         </div>
         <div class="slot-2">
            <h3 class="invoice-info">BILL TO:</h3>
            <p class="invoice-info"><?php echo $customer_name; ?><br><?php echo $address; ?><br>Phone: <?php echo $phone; ?></p>
         </div>
         <div class="slot-3">
            <h3 class="invoice-info">INVOICE INFO:</h3>
            <p class="invoice-info">Invoice # <?php echo $invoice_number; ?><br>Date: <?php echo $invoice_date; ?><br>Invoice Status: <strong>Unpaid</strong> </p>
         </div>
      </div>
      <!-- Invoice Table Start -->
      <div class="invoice md-main-table m-t-2">
         <!-- Invoice Table Head -->
         <div class="tb-head fx-row-nowrap">
            <div class="tb-th fx-col-8">#</div>
            <div class="tb-th fx-col-3">Product</div>
            <div class="tb-th fx-col-5">Unit Price</div>
            <div class="tb-th fx-col-5">Quantity</div>
            <div class="tb-th fx-col-5">Amount</div>
         </div>
         <!--Invoice Table Body -->
         <div class="tb-body">
            <div class="tb-row fx-row-nowrap">
               <div class="tb-data fx-col-8">
                  <span class="tb-key" > <b>#: </b> </span>
                  <span class="tb-val" >3</span>
               </div>
               <div class="tb-data fx-col-3">
                  <span class="tb-key" > <b>Product: </b> </span>
                  <span class="tb-val" >REX</span>
               </div>
               <div class="tb-data fx-col-5">
                  <span class="tb-key" > <b>Unit Price: </b> </span>
                  <span class="tb-val" >$50</span>
               </div>
               <div class="tb-data fx-col-5">
                  <span class="tb-key" > <b>Quantity: </b> </span>
                  <span class="tb-val" >9</span>
               </div>
               <div class="tb-data fx-col-5">
                  <span class="tb-key" > <b>Amount: </b> </span>
                  <span class="tb-val" >$450</span>
               </div>
            </div>
         </div>
      </div>
      <img src="assets/img/bar_code.png" alt="">
      <div class="invoice-compute fx-row justify-between m-t-1">
         <div class="left">
            <div class="compute">
               <p> <strong>Amount Received: </strong><?php echo $currency_symbol.$amount_received; ?></p>
            </div>
            <div class="compute">
               <p> <strong>Amount to be Paid: </strong><?php echo $currency_symbol.$due_amount; ?></p>
            </div>
         </div>
         <div class="right">
            <div class="compute">
               <p> <strong>Sub Total: </strong><?php echo $currency_symbol.$sub_total; ?></p>
            </div>
            <div class="compute">
               <p> <strong>Discount: </strong><?php echo $currency_symbol.$discount; ?></p>
            </div>
            <div class="compute">
               <p> <strong>Net Total: </strong><?php echo $currency_symbol.$net_total; ?></p>
            </div>
         </div>
      </div>
      <div class="invoice-bottom fx-row justify-center m-t-1">
         <a href="<?php echo $hf_link ?>add-sales?action=edit&id=<?php echo $id ?>" class="edit-invoice pms-add-button m-r-1">Edit Invoice
         </a>
         <a href="#" class="invoice-print  pms-add-button">Print Invoice
         </a>
      </div>
   </div>
</section>
<!-- Invoice End -->
