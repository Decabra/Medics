<?php
   function load_head()
   {
       global $hf_link, $favicon_url;
       ob_start();
   ?>
<link rel="stylesheet" type="text/css" href="<?php echo $hf_link; ?>assets/css/flexer.css">
<link rel="stylesheet" type="text/css" href="<?php echo $hf_link; ?>assets/css/style.css">
<link rel="stylesheet" type="text/css" href="<?php echo $hf_link; ?>assets/css/new-style.css">
<!-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet"> -->
<link rel="icon" href="<?php echo $favicon_url; ?>" type="image/png">
<style>
  /* fallback */
@font-face {
  font-family: 'Material Icons';
  font-style: normal;
  font-weight: 400;
  src: url(<?php echo $hf_link; ?>assets/fonts/flUhRq6tzZclQEJ-Vdg-IuiaDsNc.woff2) format('woff2');
}

.material-icons {
  font-family: 'Material Icons';
  font-weight: normal;
  font-style: normal;
  font-size: 24px;
  line-height: 1;
  letter-spacing: normal;
  text-transform: none;
  display: inline-block;
  white-space: nowrap;
  word-wrap: normal;
  direction: ltr;
  -webkit-font-feature-settings: 'liga';
  -webkit-font-smoothing: antialiased;
}
/* latin */
@font-face {
  font-family: 'Roboto';
  font-style: normal;
  font-weight: 400;
  font-display: swap;
  src: local('Roboto'), local('Roboto-Regular'), url(<?php echo $hf_link; ?>assets/fonts/KFOmCnqEu92Fr1Mu4mxK.woff2) format('woff2');
  unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
}
</style>
<script type="text/javascript" src="<?php echo $hf_link; ?>/assets/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $hf_link; ?>/assets/js/main.js"></script>
<script type="text/javascript" src="<?php echo $hf_link; ?>/assets/js/new-js.js"></script>
<?php
   $header = ob_get_contents();
   ob_end_clean();
   return $header;
   ?>
<?php
   }
   ?>
<?php
   function load_footer()
   {
       global $hf_link;
       ob_start();
   ?>
<?php
   $footer = ob_get_contents();
   ob_end_clean();
   return $footer;
   ?>
<?php
   }
   ?>
