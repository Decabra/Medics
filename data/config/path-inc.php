<?php
$website_name = settings('website_name');
$website_url = settings('website_url');
$favicon_url = settings('favicon_url');
$site_protocol = settings('site_protocol') . '://';
$admin_p_url = $site_protocol . settings('admin_p_url');
$portal_p_url = $site_protocol . settings('portal_p_url');
$dash_p_url = $site_protocol . settings('dash_p_url');
$block_scripts = settings('block_scripts');
$sub_title = settings('sub_title');
$hf_link = $website_url . '/';
$session = new Session(["name" => "__med_sess", "login_page_url" => $portal_p_url, "logout_success_url" => $portal_p_url, "login_success_url" => $dash_p_url]);
if ($site_protocol == 'http://') $session->setSecureOnly(false);

?>
