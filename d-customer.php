<?php
require_once ("./data/config/auto-load.php");

$session->restricted_page();

$action = isset($_GET["action"]) ? filterData($_GET["action"]) : '';
$id = isset($_GET["id"]) ? filterData($_GET["id"]) : '';
if ($action == 'edit')
{
    $stmt = mysqli_stmt_init($con);
    $stmt = mysqli_prepare($con, "SELECT name,phone,email,address,gender,due_balance FROM customer WHERE added_by= ? AND id=?");
    mysqli_stmt_bind_param($stmt, "si", $session_username, $id);
    mysqli_stmt_execute($stmt);
    $edi_data = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    $edit_data = mysqli_fetch_array($edi_data);
}
else if ($action == 'delete')
{
    $stmt = mysqli_prepare($con, "DELETE FROM customer WHERE added_by= ? AND id=?");
    mysqli_stmt_bind_param($stmt, "si", $session_username, $id);
    mysqli_stmt_execute($stmt);
    $deleted = mysqli_stmt_affected_rows($stmt);
    mysqli_stmt_close($stmt);
    if ($deleted)
    {
        Session::set('response', ['class' => 'alert-success', 'message' => 'Customer has been deleted successfully!']);
        redirect_to($hf_link . 'customers');
    }
    else
    {
        $resp = "Error in deleting customer. Please try again later!";
    }
}

$name = isset($_POST["name"]) ? filterData($_POST["name"]) : ($action == 'edit' ? $edit_data["name"] : '');
$email = isset($_POST["email"]) ? filterData($_POST["email"]) : ($action == 'edit' ? $edit_data["email"] : '');
$address = isset($_POST["address"]) ? filterData($_POST["address"]) : ($action == 'edit' ? $edit_data["address"] : '');
$phone = isset($_POST["phone"]) ? filterData($_POST["phone"]) : ($action == 'edit' ? $edit_data["phone"] : '');
$gender = isset($_POST["gender"]) ? filterData($_POST["gender"]) : ($action == 'edit' ? $edit_data["gender"] : '');
$due_balance = isset($_POST["due_balance"]) ? filterData($_POST["due_balance"]) : ($action == 'edit' ? $edit_data["due_balance"] : '');

$resp = false;
if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["address"]) && isset($_POST["phone"]) && isset($_POST["gender"]) && isset($_POST["due_balance"]))
{
    $fbalance = is_numeric($due_balance) ? number_format($due_balance, 2, '.', '') : -1;

    if (empty($name))
    {
        $resp = "Enter your name.";
    }
    elseif (empty($email))
    {
        $resp = "The email has been left blank.";
    }
    elseif (empty($address))
    {
        $resp = "Address has been left blank.";
    }
    elseif (empty($phone))
    {
        $resp = "Phone number has been left blank.";
    }
    elseif (empty($gender))
    {
        $resp = "Gender has been left blank.";
    }
    elseif ($due_balance === "")
    {
        $resp = "Due balance has been left blank.";
    }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        $resp = "The email is not valid.";
    }
    elseif (!preg_match("/^[-0-9]+$/", $phone))
    {
        $resp = "Enter a valid phone number";
    }
    else if (!is_numeric($fbalance) || $fbalance < 0)
    {
        $resp = "Enter a valid due balance";
    }

    if ($resp === false)
    {

        $stmt = mysqli_stmt_init($con);
        $stmt = mysqli_prepare($con, "SELECT COUNT(id) as num,id FROM customer WHERE name = ? LIMIT 1");
        mysqli_stmt_bind_param($stmt, "s", $name);
        mysqli_stmt_execute($stmt);
        $f_data = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
        $record = mysqli_fetch_array($f_data);

        if ($record['num'] > 0.99 && $record['id'] != $id)
        {
            $resp = "A customer with that name already exists.";
        }
        else
        {
            $updated_at = date("Y-m-d H:i:s");
            $stmt = mysqli_stmt_init($con);
            if ($action == 'edit')
            {
                $resp_success_msg = $name . ' record has been updated successfully!';
                $stmt = mysqli_prepare($con, "UPDATE customer SET name=?,phone=?,email=?,address=?,gender=?,due_balance=?,updated_at=? WHERE added_by= ? AND id=?");
                mysqli_stmt_bind_param($stmt, "sssssdssi", $name, $phone, $email, $address, $gender, $fbalance, $updated_at, $session_username, $id);
            }
            else
            {
                $resp_success_msg = $name . ' customer has been added successfully!';
                $stmt = mysqli_stmt_init($con);
                $stmt = mysqli_prepare($con, "INSERT INTO customer (added_by,name,phone,email,address,gender,due_balance) VALUES (?,?,?,?,?,?,?)");
                mysqli_stmt_bind_param($stmt, "ssssssd", $session_username, $name, $phone, $email, $address, $gender, $fbalance);
            }

            mysqli_stmt_execute($stmt);
            $change = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            if ($change)
            {
                //$resp=true;
                Session::set('response', ['class' => 'alert-success', 'message' => $resp_success_msg]);
                redirect_to($hf_link . 'customers');
            }
            else
            {
                $resp = "Error in saving record. Please try again later!";
            }
        }

    }

}

$page_title = 'Add/Edit Customer';
require_once ("./assets/inc/header.php");
require_once ("./assets/pages/d-customer.php");
require_once ("./assets/inc/footer.php");

mysqli_close($con);
?>
