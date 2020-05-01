<?php
class Cookie
{
    private $cookie, $value, $max_age, $path, $domain, $http_only, $secure_only, $same_site;
    public function __construct($name, $value = '', $max_age = '', $path = '/', $domain = '', $http_only = true, $secure_only = true, $same_site = 'Lax')
    {
        $domain = (empty($domain) && isset($_SERVER["HTTP_HOST"])) ? $_SERVER["HTTP_HOST"] : $domain;
        $max_age = empty($max_age) ? time() + 3600 : $max_age;
        $this->setValue($value);
        $this->setMaxAge($max_age);
        $this->setPath($path);
        $this->setDomain($domain);
        $this->setHttpOnly($http_only);
        $this->setSecureOnly($secure_only);
        $this->setSameSiteRestriction($same_site);

        if (class_exists("\Delight\Cookie\Cookie"))
        {
            $this->cookie = new \Delight\Cookie\Cookie($name, $this->getValue() , $this->getMaxAge() , $this->getPath() , $this->getDomain() , $this->getHttpOnly() , $this->getSecureOnly() , $this->getSameSiteRestriction());
        }
        else
        {
            throw new \Exception("Delight im cookie class is missing!");
        }
    }

    // setters
    public function setValue($value)
    {
        $this->value = $value;
        $this->getCookie()
            ->setValue($this->value);
    }
    public function setMaxAge($max_age)
    {
        $this->max_age = $max_age;
        $this->getCookie()
            ->setMaxAge($this->max_age);
    }
    public function setPath($path)
    {
        $this->path = $path;
        $this->getCookie()
            ->setPath($this->path);
    }
    public function setDomain($domain)
    {
        $this->domain = $domain;
        $this->getCookie()
            ->setDomain($this->domain);
    }
    public function setHttpOnly($http_only)
    {
        $this->http_only = $http_only;
        $this->getCookie()
            ->setHttpOnly($this->http_only);
    }
    public function setSecureOnly($secure_only)
    {
        $this->secure_only = $secure_only;
        $this->getCookie()
            ->setSecureOnly($this->secure_only);
    }
    public function setSameSiteRestriction($same_site)
    {
        $this->same_site = $same_site;
        $this->getCookie()
            ->setSameSiteRestriction($this->same_site);
    }

    // getters
    private function getCookie()
    {
        return $this->cookie;
    }

    public function getValue()
    {
        return $this->value;
    }
    public function getMaxAge()
    {
        return $this->max_age;
    }
    public function getPath()
    {
        return $this->path;
    }
    public function getDomain()
    {
        return $this->domain;
    }
    public function getHttpOnly()
    {
        return $this->http_only;
    }
    public function getSecureOnly()
    {
        return $this->secure_only;
    }
    public function getSameSiteRestriction()
    {
        return $this->same_site;
    }
    public function save()
    {
        $this->getCookie()
            ->save();
    }
    public function delete()
    {
        $this->getCookie()
            ->delete();
    }
    public static function exists($name)
    {
        return \Delight\Cookie\Cookie::exists($name);
    }
    public static function get($name, $value = '')
    {
        return ($value === '') ? \Delight\Cookie\Cookie::get($name) : \Delight\Cookie\Cookie::get($name, $value);
    }
    public static function parse($cookieHeader)
    {
        return \Delight\Cookie\Cookie::parse($cookieHeader);
    }
}
?>
