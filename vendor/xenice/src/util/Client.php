<?php
namespace xenice\util;

class Client
{
    public function ip()
    {
    	if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {$ip = $_SERVER["HTTP_X_FORWARDED_FOR"]; }
    	else if (isset($_SERVER["HTTP_CLIENT_IP"])) {$ip = $_SERVER["HTTP_CLIENT_IP"]; }
    	else if (isset($_SERVER["REMOTE_ADDR"])) {$ip = $_SERVER["REMOTE_ADDR"];}
    	else {$ip = "Unknown"; }
    	return $ip; 
    }
    
    public function isMobile()
    { 
        if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
        {
            return true;
        } 
        if (isset ($_SERVER['HTTP_VIA']))
        { 
            return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
        } 
        if (isset ($_SERVER['HTTP_USER_AGENT']))
        {
            $clientkeywords = array ('nokia',
                'sony',
                'ericsson',
                'mot',
                'samsung',
                'htc',
                'sgh',
                'lg',
                'sharp',
                'sie-',
                'philips',
                'panasonic',
                'alcatel',
                'lenovo',
                'iphone',
                'ipod',
                'blackberry',
                'meizu',
                'android',
                'netfront',
                'symbian',
                'ucweb',
                'windowsce',
                'palm',
                'operamini',
                'operamobi',
                'openwave',
                'nexusone',
                'cldc',
                'midp',
                'wap',
                'mobile'
                ); 
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
            {
                return true;
            } 
        } 
        if (isset ($_SERVER['HTTP_ACCEPT']))
        { 
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
            {
                return true;
            } 
        } 
        return false;
    }
    
    public function os()
    {
    	if(!isset($_SERVER['HTTP_USER_AGENT'])){
    		return "unknow";
    	}
    	
    	$os = $_SERVER['HTTP_USER_AGENT'];
    	if(stripos($os, "windows phone")!==false){
    		$os = 'Windows Phone';
    	}
    	elseif(stripos($os, "win")!==false){
    		$os = 'Windows';
    	}
    	elseif(stripos($os, "mac")!==false){
    		$os = 'MAC';
    	}
    	elseif(stripos($os, "android")!==false){
    		$os = 'Android';
    	}
    	elseif(stripos($os, "linux")!==false){
    		$os = 'Linux';
    	}
    	elseif(stripos($os, "unix")!==false){
    		$os = 'Unix';
    	}
    	elseif(stripos($os, "bsd")!==false){
    		$os = 'BSD';
    	}
    	else {
    		$os = 'Other';
    	}
    	return $os;  
    }

}