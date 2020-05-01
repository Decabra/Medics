<?php
class Session extends ManageSession
{
    private $default_args, $args;
    private $short_lived, $cookie, $cookie_only, $strict_mode, $http_only, $secure_only, $same_site;
    private $trans_id, $sid_length, $sid_bits, $hash_func, $entropy_file, $entropy_length;
    private $name, $domain, $max_age, $include_subdomains;
    private $ajax_exit_keyword, $ajax_success_keyword;
    private $login_page_url, $logout_url, $login_success_url, $logout_success_url;
    private $redirect_after_logout, $redirect_after_login, $redirect_to_current;
    private $remember_me, $remember_me_max_age;
    private $restrict_to_ip, $restrict_to_device, $restrict_to_refresh;

    public function __construct($args = '')
    {
        $this->setDefaultArgs(array(
            "max_age" => 30,
            "name" => '',
            "include_subdomains" => true,
            "domain" => '',
            "ajax_exit_keyword" => 'exit',
            "ajax_success_keyword" => 'true',
            "login_page_url" => 'login',
            "logout_url" => 'logout',
            "login_success_url" => 'dashboard',
            "logout_success_url" => 'login',
            "redirect_after_logout" => true,
            "redirect_after_login" => true,
            "redirect_to_current" => true,
            "remember_me" => false,
            "remember_me_max_age" => 2880,
            "restrict_to_ip" => false,
            "restrict_to_device" => true,
            "restrict_to_refresh" => false
        ));
        $this->args = $args;
        $this->setMaxAge($this->get_arg('max_age'));
        $this->setName($this->get_arg('name'));
        $this->setIncludeSubdomains($this->get_arg('include_subdomains'));
        $this->setDomain($this->get_arg('domain'));
        $this->setAjaxExitKeyword($this->get_arg('ajax_exit_keyword'));
        $this->setAjaxSuccessKeyword($this->get_arg('ajax_success_keyword'));
        $this->setLoginPageUrl($this->get_arg('login_page_url'));
        $this->setLogoutUrl($this->get_arg('logout_url'));
        $this->setLoginSuccessUrl($this->get_arg('login_success_url'));
        $this->setLogoutSuccessUrl($this->get_arg('logout_success_url'));
        $this->setRedirectAfterLogout($this->get_arg('redirect_after_logout'));
        $this->setRedirectAfterLogin($this->get_arg('redirect_after_login'));
        $this->setRedirectToCurrent($this->get_arg('redirect_to_current'));
        $this->setRememberMeMaxAge($this->get_arg('remember_me_max_age'));
        $this->setRememberMe($this->get_arg('remember_me'));
        $this->setRestrictToIp($this->get_arg('restrict_to_ip'));
        $this->setRestrictToDevice($this->get_arg('restrict_to_device'));
        $this->setRestrictToRefresh($this->get_arg('restrict_to_refresh'));
        $this->setSettings();
    }

    // setters
    private function setDefaultArgs($default_args)
    {
        $this->default_args = $default_args;
    }
    // for settings
    public function setName($name)
    {
        $this->name = $name;
        if (!empty($name)) session_name($name);
    }
    public function setShortLived($short_lived)
    {
        $this->short_lived = $short_lived;
        if ($short_lived) ini_set('session.cookie_lifetime', 0);
    }
    public function setCookie($cookie)
    {
        $this->cookie = $cookie;
        ini_set('session.use_cookies', boolval($cookie));
    }
    public function setCookieOnly($cookie_only)
    {
        $this->cookie_only = $cookie_only;
        ini_set('session.use_only_cookies', boolval($cookie_only));
    }
    public function setStrictMode($strict_mode)
    {
        $this->strict_mode = $strict_mode;
        ini_set('session.use_strict_mode', boolval($strict_mode));
    }
    public function setHttpOnly($http_only)
    {
        $this->http_only = $http_only;
        ini_set('session.cookie_httponly', boolval($http_only));
    }
    public function setSecureOnly($secure_only)
    {
        $this->secure_only = $secure_only;
        ini_set('session.cookie_secure', boolval($secure_only));
    }
    public function setSameSite($same_site)
    {
        $this->same_site = $same_site;
        ini_set('session.cookie_samesite', $same_site);
    }
    public function setTransId($trans_id)
    {
        $this->trans_id = $trans_id;
        ini_set('session.use_trans_sid', boolval($trans_id));
    }
    public function setSidLength($sid_length)
    {
        $this->sid_length = $sid_length;
        ini_set('session.sid_length', intval($sid_length));
    }
    public function setSidBits($sid_bits)
    {
        $this->sid_bits = $sid_bits;
        ini_set('session.sid_bits_per_character', intval($sid_bits));
    }
    public function setHashFunc($hash_func)
    {
        $this->hash_func = $hash_func;
        ini_set('session.hash_function', $hash_func);
    }
    public function setEntropyFile($entropy_file)
    {
        $this->entropy_file = $entropy_file;
        ini_set('session.entropy_file', $entropy_file);
    }
    public function setEntropyLength($entropy_length)
    {
        $this->entropy_length = $entropy_length;
        ini_set('session.entropy_length', intval($entropy_length));
    }
    public function setDomain($domain)
    {
        $domain = $this->getFinalDomain($domain);
        $this->domain = (!$this->is_subdomain($domain) && $this->getIncludeSubdomains()) ? '.' . $domain : $domain;
        ini_set('session.cookie_domain', $this->domain);
    }
    public function setMaxAge($max_age)
    {
        $this->max_age = intval($max_age) * 60;
    }
    public function setIncludeSubdomains($include_subdomains)
    {
        $this->include_subdomains = $include_subdomains;
    }

    public function setAjaxExitKeyword($ajax_exit_keyword)
    {
        $this->ajax_exit_keyword = $ajax_exit_keyword;
    }
    public function setAjaxSuccessKeyword($ajax_success_keyword)
    {
        $this->ajax_success_keyword = $ajax_success_keyword;
    }

    public function setLoginPageUrl($login_page_url)
    {
        $this->login_page_url = $this->getFullUrl($login_page_url);
    }
    public function setLogoutUrl($logout_url)
    {
        $this->logout_url = $this->getUrlPart($logout_url);
    }

    public function setLoginSuccessUrl($login_success_url)
    {
        $this->login_success_url = $this->getFullUrl($login_success_url);
    }
    public function setLogoutSuccessUrl($logout_success_url)
    {
        $this->logout_success_url = $this->getFullUrl($logout_success_url);
    }
    public function setRedirectAfterLogout($redirect_after_logout)
    {
        $this->redirect_after_logout = $redirect_after_logout;
    }
    public function setRedirectAfterLogin($redirect_after_login)
    {
        $this->redirect_after_login = $redirect_after_login;
    }
    public function setRedirectToCurrent($redirect_to_current)
    {
        $this->redirect_to_current = $redirect_to_current;
    }
    public function setRememberMe($remember_me)
    {
        $this->remember_me = $remember_me;
        if ($remember_me) $this->setMaxAge($this->getRememberMeMaxAge());
    }
    public function setRememberMeMaxAge($remember_me_max_age)
    {
        $this->remember_me_max_age = intval($remember_me_max_age);
    }

    public function setRestrictToIp($restrict_to_ip)
    {
        $this->restrict_to_ip = $restrict_to_ip;
    }
    public function setRestrictToDevice($restrict_to_device)
    {
        $this->restrict_to_device = $restrict_to_device;
    }
    public function setRestrictToRefresh($restrict_to_refresh)
    {
        $this->restrict_to_refresh = $restrict_to_refresh;
    }

    //getters
    public function getName()
    {
        return $this->name;
    }
    public function getShortLived()
    {
        return $this->short_lived;
    }
    public function getCookie()
    {
        return $this->cookie;
    }
    public function getCookieOnly()
    {
        return $this->cookie_only;
    }
    public function getStrictMode()
    {
        return $this->strict_mode;
    }
    public function getHttpOnly()
    {
        return $this->http_only;
    }
    public function getSecureOnly()
    {
        return $this->secure_only;
    }
    public function getSameSite()
    {
        return $this->same_site;
    }
    public function getTransId()
    {
        return $this->trans_id;
    }
    public function getSidLength()
    {
        return $this->sid_length;
    }
    public function getSidBits()
    {
        return $this->sid_bits;
    }
    public function getHashFunc()
    {
        return $this->hash_func;
    }
    public function getEntropyFile()
    {
        return $this->entropy_file;
    }
    public function getEntropyLength()
    {
        return $this->entropy_length;
    }
    public function getDomain()
    {
        return $this->domain;
    }
    public function getMaxAge()
    {
        return $this->max_age;
    }
    public function getIncludeSubdomains()
    {
        return $this->include_subdomains;
    }

    public function getAjaxExitKeyword()
    {
        return $this->ajax_exit_keyword;
    }
    public function getAjaxSuccessKeyword()
    {
        return $this->ajax_success_keyword;
    }
    public function getLoginPageUrl()
    {
        return $this->login_page_url;
    }
    public function getLogoutUrl()
    {
        return $this->logout_url;
    }
    public function getLoginSuccessUrl()
    {
        return $this->login_success_url;
    }
    public function getLogoutSuccessUrl()
    {
        return $this->logout_success_url;
    }

    public function getRedirectAfterLogout()
    {
        return $this->redirect_after_logout;
    }
    public function getRedirectAfterLogin()
    {
        return $this->redirect_after_login;
    }
    public function getRedirectToCurrent()
    {
        return $this->redirect_to_current;
    }
    public function getRememberMe()
    {
        return $this->remember_me;
    }
    public function getRememberMeMaxAge()
    {
        return $this->remember_me_max_age;
    }
    public function getRestrictToIp()
    {
        return $this->restrict_to_ip;
    }
    public function getRestrictToDevice()
    {
        return $this->restrict_to_device;
    }
    public function getRestrictToRefresh()
    {
        return $this->restrict_to_refresh;
    }
    // private
    private function get_default_arg($arg)
    {
        return isset($this->default_args[$arg]) ? $this->default_args[$arg] : '';
    }
    private function get_arg($arg)
    {
        return isset($this->args[$arg]) ? $this->args[$arg] : $this->get_default_arg($arg);
    }
    private function setSettings()
    {
        $this->setShortLived(true);
        $this->setCookie(true);
        $this->setCookieOnly(true);
        $this->setStrictMode(true);
        $this->setHttpOnly(true);
        $this->setSecureOnly(true);
        $this->setSameSite('Strict');
        $this->setTransId(false);
        $this->setSidLength(100);
        $this->setSidBits(6);
        $this->setHashFunc('bcrypt');
        $this->setEntropyFile('/dev/urandom');
        $this->setEntropyLength(512);

    }

    private function getFirstCreatedTime()
    {
        $first_created_time = $this->get('sess_first_initiated_time');
        return ($first_created_time) ? time() - $first_created_time : 0;
    }
    private function getCreatedTime()
    {
        $created_time = $this->get('sess_initiated_time');
        return ($created_time) ? time() - $created_time : 0;
    }
    private function getLastActivityTime()
    {
        $last_activity = $this->get('sess_last_activity');
        return ($last_activity) ? time() - $last_activity : 0;
    }
    private function isUrl($url)
    {
        $url_part1 = substr($url, 0, 4);
        $url_part2 = substr($url, 0, 3);
        $url_part3 = substr($url, 0, 2);

        return ($url_part1 == "http" || $url_part1 == "www." || $url_part2 == "://" || $url_part3 == "//") ? true : false;
    }
    private function getProtocol()
    {
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . '://';
    }
    private function getFinalDomain($domain = '')
    {
        return (empty($domain) && isset($_SERVER["HTTP_HOST"])) ? $_SERVER["HTTP_HOST"] : $domain;
    }

    private function getHost()
    {
        return $this->getProtocol() . $this->getFinalDomain();
    }

    private function getGrabDomain($url)
    {
        return (strpos("/", $this->getFinalDomain($url)) !== false) ? explode("/", str_replace(["http://", "https://", "://", "//", "www."], '', $url)) [0] : '';
    }
    private function getUrlPart($url)
    {
        return ltrim(ltrim(str_replace(["http://", "https://", "://", "//", "www.", $this->getFinalDomain() , $this->getGrabDomain($url) ], '', $url) , '/') , '?');
    }

    private function getFullUrl($url_part)
    {
        $url = (strpos($url_part, $this->getFinalDomain()) !== false) ? ltrim(str_replace(["http://", "https://", "://", "//", "www.", $this->getFinalDomain() ], '', $url_part) , '/') : $url_part;
        if ($this->isUrl($url)) return $url;
        return $this->getHost() . '/' . $url;
    }
    private function getCurrentUrl()
    {
        $url_part = explode('?', $_SERVER['REQUEST_URI'], 2);
        return $this->getHost() . $url_part[0];
    }
    private function is_subdomain($domain = '')
    {
        $explode = explode('.', $this->getFinalDomain($domain));
        return isset($explode[2]) ? true : false;
    }
    private function getClientIp()
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
    private function is_ajax()
    {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
        {
            return true;
        }
        return false;
    }

    private function is_expired()
    {
        $resp = false;
        if ($this->getLastActivityTime() > $this->getMaxAge())
        {
            $resp = true;
        }
        return $resp;
    }
    private function is_old()
    {
        $resp = false;
        if ($this->getCreatedTime() > $this->getMaxAge())
        {
            $resp = true;
        }
        return $resp;
    }
    private function is_limit_reached()
    {
        $resp = false;
        $in_seconds = $this->getRememberMeMaxAge() * 60;
        if ($this->getFirstCreatedTime() > $in_seconds)
        {
            $resp = true;
        }
        return $resp;
    }
    private function redirect_to_login_page()
    {
        if ($this->getCurrentUrl() != $this->getLoginPageUrl())
        {
            if ($this->getRedirectToCurrent())
            {
                $this->set('sess_redirect_to', $this->getCurrentUrl());
            }
            @header('Location: ' . $this->getLoginPageUrl());
            exit;
        }
    }

    private function redirect_to_login_success()
    {
        if ($this->getCurrentUrl() == $this->getLoginPageUrl())
        {
            @header('Location: ' . $this->getLoginSuccessUrl());
            exit;
        }
    }
    private function restrict_to_ip()
    {
        $restrict_ip = $this->getRestrictToIp();
        $session_initiated_ip = $this->get('sess_restrict_ip');
        $client_ip = $this->getClientIp();
        if ($session_initiated_ip !== $client_ip)
        {
            if ($restrict_ip === true || is_array($restrict_ip) && !in_array($client_ip, $restrict_ip, true))
            {
                $this->logout();
            }
        }
    }

    private function restrict_to_device()
    {
        $restrict_device = $this->getRestrictToDevice();
        $session_initiated_device = $this->get('sess_restrict_device');
        $client_device = $this->getClientIp();
        if ($session_initiated_device !== $client_device)
        {
            if ($restrict_device === true || is_array($restrict_device) && !in_array($client_device, $restrict_device, true))
            {
                $this->logout();
            }
        }
    }
    private function alive()
    {
        if ($this->is_initiated() && !$this->is_expired())
        {
            if ($this->is_limit_reached()) $this->logout();
            $final_time = time() + $this->getMaxAge();
            if ($this->is_old())
            {
                $this->regenerate();
                $this->set('sess_initiated_time', time());
            }
            $this->set('sess_last_activity', $final_time);
        }
    }

    private function logout()
    {
        $this->destroy();
        $logout_key = $this->getLogoutUrl();
        if ($this->getRedirectToCurrent() && !isset($_GET[$logout_key]))
        {
            $this->set('sess_redirect_to', $this->getCurrentUrl());
        }
        if ($this->getRedirectAfterLogout())
        {
            if (!$this->is_ajax())
            {
                @header('Location: ' . $this->getLogoutSuccessUrl());
                exit;
            }
            else
            {
                die($this->getAjaxExitKeyword());
            }
        }

    }
    public function getSettings()
    {
        $settings = [];
        $settings["session_name"] = $this->getName();
        $settings["short_lived"] = $this->getShortLived();
        $settings["cookie"] = $this->getCookie();
        $settings["cookie_only"] = $this->getCookieOnly();
        $settings["strict_mode"] = $this->getStrictMode();
        $settings["http_only"] = $this->getHttpOnly();
        $settings["secure_only"] = $this->getSecureOnly();
        $settings["same_site"] = $this->getSameSite();
        $settings["trans_id"] = $this->getTransId();
        $settings["sid_length"] = $this->getSidLength();
        $settings["sid_bits"] = $this->getSidBits();
        $settings["hash_func"] = $this->getHashFunc();
        $settings["entropy_file"] = $this->getEntropyFile();
        $settings["entropy_length"] = $this->getEntropyLength();

        return $settings;
    }

    public function restricted_page()
    {
        if ($this->is_initiated())
        {
            $this->redirect_to_login_success();
            $logout_key = $this->getLogoutUrl();
            if (!$this->is_expired() && !isset($_GET[$logout_key]))
            {
                $this->alive();
            }
            else
            {
                $this->logout();
            }
        }
        else
        {
            $this->redirect_to_login_page();
        }

    }

    public function is_initiated()
    {
        $initiated = $this->get('sess_initiated');
        return $initiated ? true : false;
    }

    public function initiate($func = '', ...$parameters)
    {
        $this->start('Strict');
        $response = false;
        if (!$this->is_initiated() && !empty($func))
        {
            if (is_callable($func))
            {
                $response = call_user_func($func, $parameters);
                if ($response === true)
                {

                    $this->set('sess_initiated', true);
                    $this->set('sess_first_initiated_time', time());
                    $this->set('sess_initiated_time', time());
                    if ($this->restrict_to_ip() !== false) $this->set('sess_restrict_ip', $this->getClientIp());

                    $redirect_url = $this->take('sess_redirect_to');
                    if ($this->getRedirectAfterLogin())
                    {
                        if (!$this->is_ajax())
                        {
                            $redirect_to = ($this->getRedirectToCurrent() && $redirect_url) ? $redirect_url : $this->getLoginSuccessUrl();
                            @header('Location: ' . $redirect_to);
                            exit;
                        }
                        else
                        {
                            $redirect_to = ($this->getRedirectToCurrent() && $redirect_url) ? $redirect_url : $this->getAjaxSuccessKeyword();
                            echo $redirect_to;
                        }
                    }
                }
            }
        }
        return $response;
    }

}

?>
