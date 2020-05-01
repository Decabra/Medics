<?php
class ManageSession
{

    public function __construct()
    {
        if (!class_exists("\Delight\Cookie\Session"))
        {
            throw new \Exception("Delight im cookie class is missing!");
        }

    }

    public static function start($value = '')
    {
        if (Session::id()) return;
        return ($value === '') ? \Delight\Cookie\Session::start() : \Delight\Cookie\Session::start($value);
    }

    public static function regenerate($value = '')
    {
        return ($value === '') ? \Delight\Cookie\Session::regenerate() : \Delight\Cookie\Session::regenerate($value);
    }

    public static function id()
    {
        return \Delight\Cookie\Session::id();
    }

    public static function set($key, $value)
    {
        return \Delight\Cookie\Session::set($key, $value);
    }

    public static function get($key, $value = '')
    {
        return ($value === '') ? \Delight\Cookie\Session::get($key) : \Delight\Cookie\Session::get($key, $value);
    }

    public static function has($key)
    {
        return \Delight\Cookie\Session::has($key);
    }

    public static function delete($key)
    {
        return \Delight\Cookie\Session::delete($key);
    }

    public static function take($key, $value = '')
    {
        return ($value === '') ? \Delight\Cookie\Session::take($key) : \Delight\Cookie\Session::take($key, $value);
    }

    public static function destroy()
    {
        session_unset();
        session_destroy();
        Session::start('Strict');
    }

}

?>
