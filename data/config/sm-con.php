<?php
$con = mysqli_connect("localhost", "root", "", "medics_main");

/**
 * Determines the client IP address
 *
 */
function getClientIp()
{
    foreach (array(
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
        'HTTP_X_FORWARDED',
        'HTTP_X_CLUSTER_CLIENT_IP',
        'HTTP_FORWARDED_FOR',
        'HTTP_FORWARDED',
        'REMOTE_ADDR'
    ) as $key)
    {
        if (array_key_exists($key, $_SERVER) === true)
        {
            foreach (explode(',', $_SERVER[$key]) as $ip)
            {
                if (filter_var($ip, FILTER_VALIDATE_IP) !== false)
                {
                    return $ip;
                }
            }
        }
    }
}

function settings($config)
{

    global $con;
    $con_f = $con;

    $query = mysqli_query($con_f, "SELECT value FROM settings WHERE name = '{$config}'");
    $data = mysqli_fetch_array($query);
    mysqli_free_result($query);
    return $data['value'];

}

if (settings('system_debug') == 1 && settings('debug_ip') == getClientIp())
{
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}
else
{
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(E_ALL);
}
