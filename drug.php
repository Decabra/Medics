<?php
require_once ("./data/config/auto-load.php");

$session->restricted_page();

$action = isset($_GET["action"]) ? filterData($_GET["action"]) : '';
$id = isset($_GET["id"]) ? filterData($_GET["id"]) : '';
if ($action == 'edit')
{
    $stmt = mysqli_stmt_init($con);
    $stmt = mysqli_prepare($con, "SELECT name,company,category,store_box,quantity,cost_price,sale_price,expiry_date FROM medicine WHERE username=? AND id=? LIMIT 1");
    mysqli_stmt_bind_param($stmt, "si", $session_username, $id);
    mysqli_stmt_execute($stmt);
    $edi_data = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    $edit_data = mysqli_fetch_array($edi_data);
}
else if ($action == 'delete')
{
    $stmt = mysqli_prepare($con, "DELETE FROM medicine WHERE username=? AND id=?");
    mysqli_stmt_bind_param($stmt, "si", $session_username, $id);
    mysqli_stmt_execute($stmt);
    $deleted = mysqli_stmt_affected_rows($stmt);
    mysqli_stmt_close($stmt);
    if ($deleted)
    {
        Session::set('response', ['class' => 'alert-success', 'message' => 'Drug has been deleted successfully!']);
        redirect_to($hf_link . 'medicine');
    }
    else
    {
        $resp = "Error in deleting drug. Please try again later!";
    }
}
$name = isset($_POST["name"]) ? filterData($_POST["name"]) : ($action == 'edit' ? $edit_data["name"] : '');
$company = isset($_POST["company"]) ? filterData($_POST["company"]) : ($action == 'edit' ? $edit_data["company"] : '');
$category = isset($_POST["category"]) ? filterData($_POST["category"]) : ($action == 'edit' ? $edit_data["category"] : '');
$store = isset($_POST["store"]) ? filterData($_POST["store"]) : ($action == 'edit' ? $edit_data["store_box"] : '');
$quantity = isset($_POST["quantity"]) ? filterData($_POST["quantity"]) : ($action == 'edit' ? $edit_data["quantity"] : '');
$cost = isset($_POST["cost"]) ? filterData($_POST["cost"]) : ($action == 'edit' ? $edit_data["cost_price"] : '');
$sale = isset($_POST["sale"]) ? filterData($_POST["sale"]) : ($action == 'edit' ? $edit_data["sale_price"] : '');
$expiry = isset($_POST["expiry"]) ? filterData($_POST["expiry"]) : ($action == 'edit' ? $edit_data["expiry_date"] : '');

$resp = false;
if (isset($_POST["name"]) && isset($_POST["company"]) && isset($_POST["category"]) && isset($_POST["store"]) && isset($_POST["quantity"]) && isset($_POST["cost"]) && isset($_POST["expiry"]) && isset($_POST["sale"]))
{
    if (empty($name))
    {
        $resp = "Enter drug name.";
    }
    elseif (empty($company))
    {
        $resp = "Company has been left blank.";
    }
    elseif (empty($category))
    {
        $resp = "Category has been left blank.";
    }
    elseif (empty($store))
    {
        $resp = "Store has been left blank.";
    }
    elseif (empty($quantity))
    {
        $resp = "Quantity has been left blank.";
    }
    elseif (empty($cost))
    {
        $resp = "Cost has been left blank.";
    }
    elseif (empty($expiry))
    {
        $resp = "Expiry has been left blank.";
    }
    elseif (empty($sale))
    {
        $resp = "Sale has been left blank.";
    }
    else if (!validateDate($expiry))
    {
        $resp = "Enter a valid expiry date of format dd-mm-yyyy";
    }
    else
    {

        $stmt = mysqli_stmt_init($con);
        $stmt = mysqli_prepare($con, "SELECT COUNT(id) as num,id FROM medicine WHERE name = ? AND company = ? LIMIT 1");
        mysqli_stmt_bind_param($stmt, "ss", $name, $company);
        mysqli_stmt_execute($stmt);
        $load_data = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
        $record = mysqli_fetch_array($load_data);

        $fcost = is_numeric($cost) ? number_format($cost, 2, '.', '') : -1;
        $fsale = is_numeric($sale) ? number_format($sale, 2, '.', '') : -1;

        if ($record['num'] > 0.99 && $record['id'] != $id)
        {
            $resp = '"' . $name . '" drug for the company "' . $company . '" is already in record.';

        }
        else if (!is_numeric($quantity) || $quantity < 0)
        {
            $resp = "Enter a valid quantity";
        }
        else if (!is_numeric($fcost) || $fcost < 0)
        {
            $resp = "Enter a valid cost price";
        }
        else if (!is_numeric($fsale) || $fsale < 0)
        {
            $resp = "Enter a valid sale price";
        }
        else
        {

            $updated_at = date("Y-m-d H:i:s");
            $stmt = mysqli_stmt_init($con);
            if ($action == 'edit')
            {
                $resp_success_msg = $name . ' record has been updated successfully!';
                $stmt = mysqli_prepare($con, "UPDATE medicine SET name=?,company=?,category=?,store_box=?,quantity=?,cost_price=?,sale_price=?,expiry_date=?,updated_at=? WHERE username=? AND id=?");
                mysqli_stmt_bind_param($stmt, "ssssiddsssi", $name, $company, $category, $store, $quantity, $fcost, $fsale, $expiry, $updated_at, $session_username, $id);
            }
            else
            {
                $resp_success_msg = $name . ' drug has been added successfully!';
                $stmt = mysqli_prepare($con, "INSERT INTO medicine (username,name,company,category,store_box,quantity,cost_price,sale_price,expiry_date) VALUES (?,?,?,?,?,?,?,?,?)");
                mysqli_stmt_bind_param($stmt, "sssssidds", $session_username, $name, $company, $category, $store, $quantity, $fcost, $fsale, $expiry);
            }
            //printf("Error: %s.\n", mysqli_error($stmt));
            mysqli_stmt_execute($stmt);
            //printf("Error: %s.\n", mysqli_stmt_error($stmt));
            $change = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            if ($change)
            {
                //$resp=true;
                Session::set('response', ['class' => 'alert-success', 'message' => $resp_success_msg]);
                redirect_to($hf_link . 'medicine');
            }
            else
            {
                $resp = "Error in saving record. Please try again later!";
            }

        }

    }

}

$page_title = 'Add/Edit Drug';
require_once ("./assets/inc/header.php");
require_once ("./assets/pages/drug.php");
require_once ("./assets/inc/footer.php");

mysqli_close($con);
?>
