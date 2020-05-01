<?php
require_once ("./data/config/auto-load.php");

$session->restricted_page();

if(is_admin()) {

$action = isset($_GET["action"]) ? filterData($_GET["action"]) : '';
$id = isset($_GET["id"]) ? filterData($_GET["id"]) : '';
if ($action == 'edit')
{
    $stmt = mysqli_stmt_init($con);
    $stmt = mysqli_prepare($con, "SELECT user_name,user_email,name,address,phone FROM users WHERE acc_type='pharmacist' AND user_id=? LIMIT 1");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $edi_data = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    $edit_data = mysqli_fetch_array($edi_data);
}
else if ($action == 'delete')
{
    $stmt = mysqli_prepare($con, "DELETE FROM users WHERE acc_type='pharmacist' AND user_id=?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $deleted = mysqli_stmt_affected_rows($stmt);
    mysqli_stmt_close($stmt);
    if ($deleted)
    {
        Session::set('response', ['class' => 'alert-success', 'message' => 'Pharmacist has been deleted successfully!']);
        redirect_to($hf_link . 'pharmacists');
    }
    else
    {
        $resp = "Error in deleting pharmacist. Please try again later!";
    }
}

$name = isset($_POST["name"]) ? filterData($_POST["name"]) : ($action == 'edit' ? $edit_data["name"] : '');
$username = isset($_POST["username"]) ? filterData($_POST["username"]) : ($action == 'edit' ? $edit_data["user_name"] : '');
$email = isset($_POST["email"]) ? filterData($_POST["email"]) : ($action == 'edit' ? $edit_data["user_email"] : '');
$password = isset($_POST["password"]) ? filterData($_POST["password"]) : '';
$confirm_pass = isset($_POST["confirm_pass"]) ? filterData($_POST["confirm_pass"]) : '';
$address = isset($_POST["address"]) ? filterData($_POST["address"]) : ($action == 'edit' ? $edit_data["address"] : '');
$phone = isset($_POST["phone"]) ? filterData($_POST["phone"]) : ($action == 'edit' ? $edit_data["phone"] : '');
$enter_pass = ($action != 'edit' && $action != 'delete');
$resp = false;
if (isset($_POST["name"]) && isset($_POST["username"]) && isset($_POST["email"]) && (($enter_pass && isset($_POST["password"]) && isset($_POST["confirm_pass"])) || !$enter_pass) && isset($_POST["address"]) && isset($_POST["phone"]))
{

    if (empty($name))
    {
        $resp = "Enter your name.";
    }
    elseif (empty($username))
    {
        $resp = "The username has been left blank.";
    }
    elseif (empty($email))
    {
        $resp = "The email has been left blank.";
    }
    elseif ($enter_pass && empty($password))
    {
        $resp = "The password has been left blank.";
    }
    elseif ($enter_pass && empty($confirm_pass))
    {
        $resp = "The confirm password has been left blank.";
    }
    elseif (empty($address))
    {

        $resp = "Address has been left blank.";

    }
    elseif (empty($phone))
    {
        $resp = "Phone number has been left blank.";
    }
    elseif (strlen($username) > 32)
    {
        $resp = "The username length is limited to 32 characters.";
    }
    elseif (preg_match('/[^a-z_\-0-9]/i', $username))
    {
        $resp = "The username cannot contain special characters.";
    }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        $resp = "The email is not valid.";
    }
    elseif (!preg_match("/^[-0-9]+$/", $phone))
    {
        $resp = "Enter a valid phone number";
    }

    if ($resp === false)
    {
        $stmt = mysqli_stmt_init($con);
        $stmt = mysqli_prepare($con, "SELECT COUNT(user_id) as num,user_id as id FROM users WHERE user_name = ? LIMIT 1");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $load_user = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
        $confirm_user = mysqli_fetch_array($load_user);

        $stmt = mysqli_stmt_init($con);
        $stmt = mysqli_prepare($con, "SELECT COUNT(user_id) as num,user_id as id FROM users WHERE user_email = ? LIMIT 1");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $load_user = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
        $confirm_email = mysqli_fetch_array($load_user);
        if ($confirm_user['num'] > 0.99 && ((!$enter_pass && $confirm_user['id'] != $id) || $enter_pass))
        {
            $resp = "A pharmacist with that username already exists.";
        }
        else if ($confirm_email['num'] > 0.99 && ((!$enter_pass && $confirm_email['id'] != $id) || $enter_pass))
        {
            $resp = "A pharmacist with that email already exists.";
        }
        else
        {
            $updated_at = date("Y-m-d H:i:s");
            $change = false;
            $inner = false;
            if ($action == 'edit')
            {
                $resp_success_msg = $name . ' record has been updated successfully!';
                $stmt = mysqli_stmt_init($con);
                $stmt = mysqli_prepare($con, "UPDATE users SET user_name=?,user_email=?,name=?,address=?,phone=?,updated_at=? WHERE acc_type='pharmacist' AND user_id=?");
                mysqli_stmt_bind_param($stmt, "ssssssi", $username, $email, $name, $address, $phone, $updated_at, $id);
                $inner = true;
            }
            else
            {
                if (strlen($password) < 8 || !preg_match("#[0-9]+#", $password) || !preg_match("#[A-Z]+#", $password) || !preg_match("#[a-z]+#", $password))
                {
                    $resp = "Password must contain 8 characters including one number, uppercase and lowercase.";
                }
                elseif (strlen($password) > 32)
                {
                    $resp = "The password length is limited to 32 characters.";
                }
                elseif ($password != $confirm_pass)
                {
                    $resp = "The password doesn't match with the repeating field.";
                }
                else
                {
                    //All set now insert into database
                    $password_hash = password_hash($password, PASSWORD_DEFAULT, array(
                        'cost' => 12
                    ));
                    $registration_ip = getClientIp();
                    $account_type = 'pharmacist';
                    $resp_success_msg = $name . ' pharmacist has been added successfully!';
                    $stmt = mysqli_stmt_init($con);
                    $stmt = mysqli_prepare($con, "INSERT INTO users (user_name,user_email,name,password_hash,registration_ip,acc_type,referby,address,phone) VALUES (?,?,?,?,?,?,?,?,?)");
                    mysqli_stmt_bind_param($stmt, "sssssssss", $username, $email, $name, $password_hash, $registration_ip, $account_type, $session_username, $address, $phone);
                    $inner = true;
                }
            }
            if ($inner)
            {
                mysqli_stmt_execute($stmt);
                $change = mysqli_stmt_affected_rows($stmt);
                mysqli_stmt_close($stmt);
                if ($change)
                {
                    //$resp=true;
                    Session::set('response', ['class' => 'alert-success', 'message' => $resp_success_msg]);
                    redirect_to($hf_link . 'pharmacists');
                }
                else
                {
                    $resp = "Error in saving record. Please try again later!";
                }
            }
        }

    }

}

}

$page_title = 'Add/Edit Pharmacist';
require_once ("./assets/inc/header.php");
if(is_admin()) {
require_once ("./assets/pages/d-pharmacist.php");
}else {
echo '<div class="alert alert-danger">You don\'t have permission to view this page</div>';
}
require_once ("./assets/inc/footer.php");

mysqli_close($con);
?>
