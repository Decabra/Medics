<?php
$sess_response = $session->initiate('verify_password');
$session_username=filterData(Session::get('user_name'));

$previous_url = isset($_SESSION["previous_url"]) ? $_SESSION["previous_url"] : '';

$current_url = $_SERVER["REQUEST_URI"];

$_SESSION["previous_url"] = isset($_SESSION["current_url"]) && $_SESSION["current_url"] == $current_url ? $_SESSION["previous_url"] : (isset($_SESSION["current_url"]) ? $_SESSION["current_url"] : '');

$_SESSION["current_url"] = !empty($_SESSION["current_url"]) && $_SESSION["current_url"] == $current_url ? $_SESSION["current_url"] : $current_url;

if (!empty($previous_url) && (strpos($previous_url, '/customers') !== false || strpos($previous_url, '/sales') !== false) && isset($_GET["back-to-sales"]))
{

    header('Location: ' . $previous_url);
    exit;

}

?>
