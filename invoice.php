<?php
require_once ("./data/config/auto-load.php");

$session->restricted_page();
$id = isset($_GET["id"]) ? filterData($_GET["id"]) : 0;

$stmt = mysqli_stmt_init($con);
$stmt = mysqli_prepare($con, "SELECT customer_name,sale_date,discount,sub_total,net_total,received_amount,due_amount FROM sales WHERE added_by= ? AND id=?");
mysqli_stmt_bind_param($stmt, "si", $session_username, $id);
mysqli_stmt_execute($stmt);
$edi_data = mysqli_stmt_get_result($stmt);
mysqli_stmt_close($stmt);
$sale_data = mysqli_fetch_array($edi_data);

$stmt = mysqli_stmt_init($con);
$stmt = mysqli_prepare($con, "SELECT name,phone,email,address,gender,due_balance FROM customer WHERE name= ?");
mysqli_stmt_bind_param($stmt, "s", $sale_data["customer_name"]);
mysqli_stmt_execute($stmt);
$edi_data = mysqli_stmt_get_result($stmt);
mysqli_stmt_close($stmt);
$customer_data = mysqli_fetch_array($edi_data);

$customer_name = isset($customer_data["name"]) ? $customer_data["name"] : '';
$address = isset($customer_data["address"]) ? $customer_data["address"] : '';
$phone = isset($customer_data["phone"]) ? $customer_data["phone"] : '';
$invoice_number = $id;
$invoice_date = isset($sale_data["sale_date"]) ? $sale_data["sale_date"] : '';
$amount_received = isset($sale_data["received_amount"]) ? $sale_data["received_amount"] : '';
$due_amount = isset($sale_data["due_amount"]) ? $sale_data["due_amount"] : '';
$discount = isset($sale_data["discount"]) ? $sale_data["discount"] : '';
$sub_total = isset($sale_data["sub_total"]) ? $sale_data["sub_total"] : '';
$net_total = isset($sale_data["net_total"]) ? $sale_data["net_total"] : '';
$company_name=settings("company_name");
$company_phone=settings("company_phone");
$company_address=settings("company_address");
$currency_symbol=settings("currency_symbol");

$page_title = 'Invoice';
require_once ("./assets/inc/header.php");
require_once ("./assets/pages/invoice.php");
require_once ("./assets/inc/footer.php");

mysqli_close($con);
?>
