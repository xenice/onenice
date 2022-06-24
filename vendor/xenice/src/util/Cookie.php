<?php

namespace xenice\util;

use xenice\theme\Theme;

class Cookie
{
    protected $expire;
    
    public function __construct()
    {
        $this->expire = time()+3600*24*30;
    }
    
    public function hashKey($data, $key = '')
    {
        if(!$key){
            $key = Theme::use('option')->getValue('key32');
        }
        $algo = function_exists( 'hash' ) ? 'sha256' : 'sha1';
        return hash_hmac( $algo, $data, $key);
    }
    
    public function setHash($data, $key = '')
    {
        $key = $this->hashKey($data,$key);
        setcookie($hash, true, $this->expire, '/');
    }
	
	public function getHash($data, $key = '')
    {
        return $_COOKIE[$key]??'';
    }
    
	public function checkHash($data, $key = '')
    {
        $key = $this->hashKey($data, $key);
        return isset($_COOKIE[$key]);
    }

}