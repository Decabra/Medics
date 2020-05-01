<?php
require_once ("./data/config/auto-load.php");

$session->restricted_page();
$page_title = 'Store';
require_once ("./assets/inc/header.php");
require_once ("./assets/pages/store.php");
require_once ("./assets/inc/footer.php");

mysqli_close($con);
?>
