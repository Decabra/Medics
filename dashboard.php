<?php
require_once ("./data/config/auto-load.php");

$session->restricted_page();

$d_data = mysqli_query($con, "SELECT id,name,category,store_box,quantity,expiry_date FROM medicine ORDER BY created_at DESC");
$total_drugs = 0;
$total_quantity = 0;
$out_of_stock = 0;
$expired_drugs = 0;
$out_of_stock_arr = [];
$expired_drugs_arr = [];
$expire_soon_arr = [];
$expire_soon_count = 0;
$limit=2;
while ($drugs = mysqli_fetch_array($d_data))
{
  $is_expired=false;
    $total_quantity += $drugs["quantity"];
    if ($drugs["quantity"] == 0)
    {
        if($out_of_stock < $limit) $out_of_stock_arr[$out_of_stock] = $drugs;
        $out_of_stock++;
    }
    $expiry_time = strtotime($drugs["expiry_date"]);
    $current_time = time();
    if ($expiry_time < $current_time)
    {
        if($expired_drugs < $limit) $expired_drugs_arr[$expired_drugs] = $drugs;
        $expired_drugs++;
        $is_expired=true;
    }
    if ($expiry_time < ($current_time + 864000) && !$is_expired)
    {
        if($expire_soon_count < $limit) $expire_soon_arr[$expire_soon_count] = $drugs;
        $expire_soon_count++;
    }
    $total_drugs++;
}
$currency_symbol=settings("currency_symbol");
$page_title = 'Dashboard';
require_once ("./assets/inc/header.php");
require_once ("./assets/pages/dashboard.php");
require_once ("./assets/inc/footer.php");

mysqli_close($con);
?>
