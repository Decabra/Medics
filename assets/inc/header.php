<!DOCTYPE html>
<html lang="en" dir="ltr">
   <head>
      <?php if (empty($page_title)) {?>
      <title><?php echo $website_name; ?> | <?php echo $sub_title; ?></title>
      <?php } else { ?>
      <title><?php echo $page_title; ?> | <?php echo $website_name; ?></title>
      <?php } ?>
      <?php echo load_head(); ?>
   </head>
   <body <?php if(!empty($page_title)) echo 'class="page-title"'; ?>>
      <!-- header -->
      <header class="top-bar fx-row-nowrap align-center">
         <div class="left-bar w-200">
            <a class="logo d-block " href="<?php echo $hf_link;?>dashboard">
               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 731.77 201.77">
                  <title>Medics</title>
                  <g id="Layer_2" data-name="Layer 2">
                     <g id="Layer_1-2" data-name="Layer 1">
                        <path d="M85.72,107.86c-1.89-2-54.43,55.89-68.86,74-7.78-6.29-31.2-65.62-4.22-108.24,13.93-22,40.28-43.12,73.87-57.25C125.83-.16,167.72-.8,175.73.38c2.62,8.93,3.33,66.46-12.85,114.62-10.16,30.21-31.68,72.2-65.38,82.72-34.2,10.67-63.23-2.55-71-7.48C41.56,169.49,87.4,109.67,85.72,107.86Z" style="fill:#9cb53b"/>
                        <text transform="translate(197.36 164.45) scale(0.95 1)" style="font-size:170px;fill:#fff;stroke:#fff;stroke-miterlimit:10;font-family:Ubuntu-Regular, Ubuntu;letter-spacing:0.010001440592785706em">
                           Medi
                           <tspan x="393.03" y="0" style="letter-spacing:0.04599935074699531em">cs</tspan>
                        </text>
                     </g>
                  </g>
               </svg>
            </a>
         </div>
         <nav class="right-bar fx-row-nowrap">
            <ul class="navbar-right fx-row-nowrap justify-fx-end align-center">
               <li class="m-r-2">
                  <p class="white">Welcome! <?php echo user_data('name'); ?></p>
               </li>
               <li class="m-r-2"> <a href="<?php echo $dash_p_url; ?>?logout" class="log-in">Logout</a> </li>
            </ul>
         </nav>
      </header>
      <!-- Main -->
      <main id="pms" class="fx-row-nowrap">
      <!-- Side Bar Menu Start -->
      <section class="pms-left-side fx-col-4">
         <div id="pms-sidebar-menu" class=" h-300 p-t-2">
            <ul id="pms-sidebar-nav">
               <li class="<?php if(strpos($_SERVER['REQUEST_URI'], '/dashboard') !== false) echo 'active' ?>" >
                  <a href="<?php echo $hf_link; ?>dashboard" class="pms-nav-menu fx-row-nowrap align-center"  >
                  <i class="material-icons mat-ic">speed</i>
                  <span class="hd-name">Dashboard</span>
                  </a>
               </li>
               <li class="<?php if(strpos($_SERVER['REQUEST_URI'], '/medicine') !== false || strpos($_SERVER['REQUEST_URI'], '/drug') !== false) echo 'active' ?>" >
                  <a href="<?php echo $hf_link; ?>medicine" class="pms-nav-menu fx-row-nowrap align-center"  >
                  <i class="material-icons mat-ic">local_pharmacy</i>
                  <span class="hd-name">Medicine</span>
                  </a>
               </li>
<?php if(is_admin()) { ?>
               <li class="<?php if(strpos($_SERVER['REQUEST_URI'], 'pharmacist') !== false) echo 'active' ?>"  >
                  <a href="<?php echo $hf_link; ?>pharmacists" class="pms-nav-menu fx-row-nowrap align-center" >
                  <i class="material-icons mat-ic">person</i>
                  <span class="hd-name">Pharmacists</span>
                  </a>
               </li>
<?php } ?>
               <li class=" <?php if(strpos($_SERVER['REQUEST_URI'], 'customer') !== false) echo 'active' ?> " >
                  <a href="<?php echo $hf_link; ?>customers" class="pms-nav-menu fx-row-nowrap align-center"  >
                  <i class="material-icons mat-ic">people</i>
                  <span class="hd-name">Customers</span>
                  </a>
               </li>
               <li class="<?php if(strpos($_SERVER['REQUEST_URI'], 'sales') !== false || strpos($_SERVER['REQUEST_URI'], 'invoice') !== false) echo 'active' ?>" >
                  <a href="<?php echo $hf_link; ?>sales" class="pms-nav-menu fx-row-nowrap align-center">
                  <i class="material-icons mat-ic">local_atm</i>
                  <span class="hd-name">Sales</span>
                  </a>
               </li>
            </ul>
         </div>
      </section>
      <!-- Side Bar Menu End -->
      <!-- Menu Body Start -->
      <section id="pms-body" class="pms-right-side fx-col-1 p-1">
