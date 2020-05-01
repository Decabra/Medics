<?php
require_once ("./data/config/auto-load.php");

$session->restricted_page();
$username = isset($_POST["username"]) ? $_POST["username"] : '';
$page_title = 'Login';
require_once ("./assets/inc/front-header.php");
require_once ("./assets/pages/login.php");
require_once ("./assets/inc/front-footer.php");

mysqli_close($con);

?>
