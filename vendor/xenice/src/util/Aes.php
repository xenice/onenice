<?php

namespace xenice\util;

use xenice\theme\Theme;

class Aes
{
    private $passwords = [
        'default'=>'',
    ];
    
    public function __construct()
    {
        $this->passwords['default'] = take('aes_default_key');
    }
    
    public function password()
    {
        return Theme::use('str')->randstr(16);
    }
    
    public function encrypt($str, $password)
    {
        return $this->base64UrlEncode(openssl_encrypt($str, 'AES-128-CBC',$password,OPENSSL_RAW_DATA,$password));
    }
    
    public function decrypt($str, $password)
    {
        return openssl_decrypt($this->base64UrlDecode($str), 'AES-128-CBC', $password, OPENSSL_RAW_DATA,$password);
    }
    
    public function encryptArray($arr, $password)
    {
        return $this->encrypt(json_encode($arr), $password);
    }
    
    public function decryptArray($str, $password)
    {
        $str = $this->decrypt($str, $password);
        return json_decode($str, true);
    }
    
    public function encode($str, $key = 'default')
    {
        $password = $this->passwords[$key];
        return $this->encrypt($str, $password);
    }
    
    public function decode($str, $key = 'default')
    {
        $password = $this->passwords[$key];
        return $this->decrypt($str, $password);;
    }
    
    public function encodeArray($arr, $key = 'default')
    {
        return $this->encode(json_encode($arr), $key);
    }
    
    public function decodeArray($str, $key = 'default')
    {
        $str = $this->decode($str, $key);
        return json_decode($str, true);
    }
    
	public function base64UrlEncode($data) 
	{ 
  		return rtrim(strtr(base64_encode($data), '+/', '-_'), '='); 
	} 
	
	public function base64UrlDecode($data)
	{ 
  		return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT)); 
	}
}