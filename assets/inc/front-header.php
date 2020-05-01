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
            <a class="logo d-block " href="<?php echo $hf_link; ?>">
               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 731.77 201.77">
                  <title>Medics</title>
                  <g id="Layer_2" data-name="Layer 2">
                     <g id="Layer_1-2" data-name="Layer 1">
                        <path d="M85.72,107.86c-1.89-2-54.43,55.89-68.86,74-7.78-6.29-31.2-65.62-4.22-108.24,13.93-22,40.28-43.12,73.87-57.25C125.83-.16,167.72-.8,175.73.38c2.62,8.93,3.33,66.46-12.85,114.62-10.16,30.21-31.68,72.2-65.38,82.72-34.2,10.67-63.23-2.55-71-7.48C41.56,169.49,87.4,109.67,85.72,107.86Z" style="fill:#9cb53b" />
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
            <ul class="navbar-right fx-row-nowrap justify-fx-end">
               <li class="m-r-2">
                  <a href="<?php echo $hf_link; ?>login" class="log-in">Login</a>
               </li>
               <li class="m-r-2">
                  <a href="<?php echo $hf_link; ?>signup" class="sign-up">Sign up</a>
               </li>
            </ul>
         </nav>
      </header>
