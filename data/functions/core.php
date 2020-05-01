<?php
function filterData($input)
{

    global $con;
    $con_f = $con;

    $search = array(
        '@<script[^>]*?>.*?</script>@si',
        '@<[\/\!]*?[^<>]*?>@si',
        '@<style[^>]*?>.*?</style>@siU',
        '@<![\s\S]*?--[ \t\n\r]*>@'
    );

    $wipe = array(

        "+union+",
        "%20union%20",
        "/union/*",
        ' union ',
        "union",
        "sql",
        "mysql",
        "database",
        "cookie",
        "coockie",
        "select",
        "from",
        "where",
        "benchmark",
        "concat",
        "table",
        "into",
        "by",
        "values",
        "exec",
        "shell",
        "truncate",
        "wget",
        "/**/"

    );

    $output = preg_replace($search, '', $input);
    $output = str_replace($wipe, '', $output);

    return mysqli_real_escape_string($con_f, trim($output));

}
function user_data($value = '', $username = '')
{
    global $con, $user_data;
    $username = empty($username) ? Session::get('user_name') : filterData($username);
    if (empty($user_data) && !empty($username))
    {
        $con_f = $con;
        $stmt = mysqli_stmt_init($con_f);
        $stmt = mysqli_prepare($con_f, "SELECT * FROM users WHERE user_name = ? LIMIT 1");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $data = mysqli_stmt_get_result($stmt);
        $user_data = mysqli_fetch_array($data);
        mysqli_stmt_close($stmt);
    }
    return (!empty($value) && isset($user_data[$value])) ? $user_data[$value] : $user_data;
}
function verify_password()
{
    $resp = false;

    if (isset($_POST["username"]) && isset($_POST["password"]))
    {
        if (empty($_POST["username"]))
        {
            $resp = "Username field cannot be empty";
        }
        else if (empty($_POST["password"]))
        {
            $resp = "Password field cannot be empty";
        }
        if ($resp === false)
        {
            $username = $_POST["username"];
            $password_hash = user_data('password_hash', $username);
            if (empty($password_hash))
            {
                $resp = "This username doesn't exist";
            }
            else if (password_verify($_POST["password"], $password_hash))
            {
                $resp = true;
                Session::set('user_name', $username);
            }
            else
            {
                $resp = "Invalid Password";
            }
        }

    }
    return $resp;
}

function redirect_to($location) {
  header('Location: '.$location);
  exit;
}
function validateDate($date, $format = 'd-m-Y')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}
function is_admin() {
return (user_data('acc_type') == 'admin') ? true : false;
}
?>
