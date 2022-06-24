<?php

namespace xenice\util;

use xenice\theme\Theme;

class Str
{

    public function __construct()
    {
    }
    
	public function randstr($len, $type = '')
	{
	    if($type == "upper"){
	        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	    }
	    elseif($type == "uppernum"){
	        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	    }
	    else{
            $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	    }
        mt_srand(10000000*(double)microtime());  
        for ($i = 0, $str = '', $lc = strlen($chars)-1; $i < $len; $i++) {  
            $str .= $chars[mt_rand(0, $lc)];  
        }  
        return $str;
	}

    public function encodeUrl($str)
    {
        $data = base64_encode($str);
        $data = str_replace(array('+','/','='),array('-','_',''),$data);
        return $data;
    }

    public function decodeUrl($str) 
    {
        $data = str_replace(array('-','_'),array('+','/'),$str);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }
}