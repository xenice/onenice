<?php

namespace app\web\model\part;

use xenice\theme\Theme;

trait User
{
    use Model;
    
    public function login()
    {
        return $this->login;
    }
    
    public function adminUrl()
    {
        return get_admin_url();
    }
    
    public function loginUrl()
    {
        return wp_login_url(get_permalink());
    }
    
    public function logoutUrl()
    {
        return wp_logout_url( get_permalink());
    }
    
    public function registerUrl()
    {
        return wp_registration_url(get_permalink());
    }
}