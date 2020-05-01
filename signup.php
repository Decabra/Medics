<?php
require_once ("./data/config/auto-load.php");
//regsiter start
$name = isset($_POST["name"]) ? filterData($_POST["name"]) : '';
$username = isset($_POST["username"]) ? filterData($_POST["username"]) : '';
$email = isset($_POST["email"]) ? filterData($_POST["email"]) : '';
$password = isset($_POST["password"]) ? filterData($_POST["password"]) : '';
$confirm_pass = isset($_POST["confirm_pass"]) ? filterData($_POST["confirm_pass"]) : '';

$resp = false;
if (isset($_POST["name"]) && isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["confirm_pass"]))
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
    elseif (empty($password))
    {
        $resp = "The password has been left blank.";
    }
    elseif (empty($confirm_pass))
    {
        $resp = "The confirm password has been left blank.";
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

    if ($resp === false)
    {
        $stmt = mysqli_stmt_init($con);
        $stmt = mysqli_prepare($con, "SELECT COUNT(user_id) as id FROM users WHERE user_name = ? LIMIT 1");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $load_user = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
        $confirm_user = mysqli_fetch_array($load_user);

        $stmt = mysqli_stmt_init($con);
        $stmt = mysqli_prepare($con, "SELECT COUNT(user_id) as id FROM users WHERE user_email = ? LIMIT 1");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $load_user = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
        $confirm_email = mysqli_fetch_array($load_user);
        if ($confirm_user['id'] > 0.99)
        {
            $resp = "A user with that username already exists.";
        }
        else if ($confirm_email['id'] > 0.99)
        {
            $resp = "A user with that email already exists.";
        }
        else if (strlen($password) < 8 || !preg_match("#[0-9]+#", $password) || !preg_match("#[A-Z]+#", $password) || !preg_match("#[a-z]+#", $password))
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
            $acc_type='admin';
            $stmt = mysqli_stmt_init($con);
            $stmt = mysqli_prepare($con, "INSERT INTO users (user_name,user_email,name,password_hash,registration_ip,acc_type) VALUES (?,?,?,?,?,?)");
            //printf("Error: %s.\n", mysqli_error($stmt));
            mysqli_stmt_bind_param($stmt, "ssssss", $username, $email, $name, $password_hash, $registration_ip,$acc_type);
            mysqli_stmt_execute($stmt);
            //printf("Error: %s.\n", mysqli_stmt_error($stmt));
            $change = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            if ($change)
            {
                $resp = true;
            }
            else
            {
                $resp = "Error in sign up process. Please try again later!";
            }

        }

    }
}
//resgister end
$page_title = 'Sign Up';
require_once ("./assets/inc/front-header.php");
require_once ("./assets/pages/signup.php");
require_once ("./assets/inc/front-footer.php");

mysqli_close($con);
?>
