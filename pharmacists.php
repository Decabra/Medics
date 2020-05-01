<?php
require_once ("./data/config/auto-load.php");

$session->restricted_page();
$page_title = 'Pharmacists';
require_once ("./assets/inc/header.php");
if(is_admin()) {
require_once ("./assets/pages/pharmacists.php");
}else {
echo '<div class="alert alert-danger">You don\'t have permission to view this page</div>';
}
require_once ("./assets/inc/footer.php");

mysqli_close($con);
?>
