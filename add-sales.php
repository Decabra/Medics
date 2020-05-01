<?php
require_once ("./data/config/auto-load.php");

$session->restricted_page();

$action = isset($_GET["action"]) ? filterData($_GET["action"]) : '';
$id = isset($_GET["id"]) ? filterData($_GET["id"]) : '';
if ($action == 'edit')
{
    $stmt = mysqli_stmt_init($con);
    $stmt = mysqli_prepare($con, "SELECT customer_name,sale_date,discount,sub_total,net_total,received_amount,due_amount FROM sales WHERE added_by= ? AND id=?");
    mysqli_stmt_bind_param($stmt, "si", $session_username, $id);
    mysqli_stmt_execute($stmt);
    $edi_data = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    $edit_data = mysqli_fetch_array($edi_data);
}
else if ($action == 'delete')
{
    $stmt = mysqli_prepare($con, "DELETE FROM sales WHERE added_by= ? AND id=?");
    mysqli_stmt_bind_param($stmt, "si", $session_username, $id);
    mysqli_stmt_execute($stmt);
    $deleted = mysqli_stmt_affected_rows($stmt);
    mysqli_stmt_close($stmt);
    if ($deleted)
    {
        Session::set('response', ['class' => 'alert-success', 'message' => 'Sale has been deleted successfully!']);
        redirect_to($hf_link . 'sales');
    }
    else
    {
        $resp = "Error in deleting sale. Please try again later!";
    }
}

$customer_name = isset($_POST["customer_name"]) ? filterData($_POST["customer_name"]) : ($action == 'edit' ? $edit_data["customer_name"] : '');
$sale_date = isset($_POST["sale_date"]) ? filterData($_POST["sale_date"]) : ($action == 'edit' ? $edit_data["sale_date"] : '');
$discount = isset($_POST["discount"]) ? filterData($_POST["discount"]) : ($action == 'edit' ? $edit_data["discount"] : '');
$sub_total = isset($_POST["sub_total"]) ? filterData($_POST["sub_total"]) : ($action == 'edit' ? $edit_data["sub_total"] : '');
$net_total = isset($_POST["net_total"]) ? filterData($_POST["net_total"]) : ($action == 'edit' ? $edit_data["net_total"] : '');
$received_amount = isset($_POST["received_amount"]) ? filterData($_POST["received_amount"]) : ($action == 'edit' ? $edit_data["received_amount"] : '');
$due_amount = isset($_POST["due_amount"]) ? filterData($_POST["due_amount"]) : ($action == 'edit' ? $edit_data["due_amount"] : '');
$customer_name=(empty($customer_name) && isset($_GET["name"])) ? filterData($_GET["name"]) : $customer_name;
$resp = false;
if (isset($_POST["customer_name"]) && isset($_POST["sale_date"]) && isset($_POST["discount"]) && isset($_POST["sub_total"]) && isset($_POST["net_total"]) && isset($_POST["received_amount"]) && isset($_POST["due_amount"]))
{
    $fdiscount = is_numeric($discount) ? number_format($discount, 2, '.', '') : -1;
    $fstotal = is_numeric($sub_total) ? number_format($sub_total, 2, '.', '') : -1;
    $fntotal = is_numeric($net_total) ? number_format($net_total, 2, '.', '') : -1;
    $freceived_amount = is_numeric($received_amount) ? number_format($received_amount, 2, '.', '') : -1;
    $fdue = is_numeric($due_amount) ? number_format($due_amount, 2, '.', '') : -1;

    if (empty($customer_name))
    {
        $resp = "Customer name has been left blank.";
    }
    elseif (empty($sale_date))
    {
        $resp = "Sale date has been left blank.";
    }
    elseif ($discount === "")
    {
        $resp = "Discount has been left blank.";
    }
    elseif ($sub_total === "")
    {
        $resp = "Sub Total has been left blank.";
    }
    elseif ($net_total === "")
    {
        $resp = "Net Total has been left blank.";
    }
    elseif ($received_amount === "")
    {
        $resp = "Received amount has been left blank.";
    }
    elseif ($due_amount === "")
    {
        $resp = "Due Amount has been left blank.";
    }
    else if (!validateDate($sale_date) || strtotime($sale_date) > time())
    {
        $resp = "Enter a valid sale date of format dd-mm-yyyy";
    }
    else if (!is_numeric($fdiscount) || $fdiscount < 0)
    {
        $resp = "Enter a valid discount amount";
    }
    else if (!is_numeric($fstotal) || $fstotal < 0)
    {
        $resp = "Enter a valid sub-total amount";
    }
    else if (!is_numeric($fntotal) || $fntotal < 0)
    {
        $resp = "Enter a valid net-total amount";
    }
    else if (!is_numeric($freceived_amount) || $freceived_amount < 0)
    {
        $resp = "Enter a valid received amount";
    }
    else if (!is_numeric($fdue) || $fdue < 0)
    {
        $resp = "Enter a valid due amount";
    }

    if ($resp === false)
    {

        $updated_at = date("Y-m-d H:i:s");
        $stmt = mysqli_stmt_init($con);
        $edit = false;
        if ($action == 'edit')
        {
            $resp_success_msg = $customer_name . ' sale record has been updated successfully!';
            $edit = true;
            $stmt = mysqli_prepare($con, "UPDATE sales SET customer_name=?,sale_date=?,discount=?,sub_total=?,net_total=?,received_amount=?,due_amount=?,updated_at=? WHERE added_by=? AND id=?");
            mysqli_stmt_bind_param($stmt, "ssdddddssi", $customer_name, $sale_date, $fdiscount, $fstotal, $fntotal, $freceived_amount, $fdue, $updated_at, $session_username, $id);
        }
        else
        {
            $resp_success_msg = $customer_name . ' sale has been added successfully!';
            $stmt = mysqli_stmt_init($con);
            $stmt = mysqli_prepare($con, "INSERT INTO sales (added_by, customer_name,sale_date,discount,sub_total,net_total,received_amount,due_amount) VALUES (?,?,?,?,?,?,?,?)");
            mysqli_stmt_bind_param($stmt, "sssddddd", $session_username, $customer_name, $sale_date, $fdiscount, $fstotal, $fntotal, $freceived_amount, $fdue);
        }

        mysqli_stmt_execute($stmt);
        $change = mysqli_stmt_affected_rows($stmt);
        mysqli_stmt_close($stmt);
        if ($change)
        {
            //$resp=true;
            Session::set('response', ['class' => 'alert-success', 'message' => $resp_success_msg]);
            if ($edit)
            {
                redirect_to($hf_link . 'invoice?id='.$id);
            }
            else
            {
                redirect_to($hf_link . 'sales');

            }
        }
        else
        {
            $resp = "Error in saving record. Please try again later!";
        }

    }

}

$page_title = 'Add Sales';
require_once ("./assets/inc/header.php");
require_once ("./assets/pages/add-sales.php");
require_once ("./assets/inc/footer.php");

mysqli_close($con);
?>
