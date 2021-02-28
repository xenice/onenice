<?php
/**
 * @name        xenice social login part
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-12-14
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace xenice\login;

trait Part
{
    protected function get($url)
    {
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, TRUE );
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt ( $ch, CURLOPT_URL, $url );
        $result = curl_exec ( $ch );
        curl_close ( $ch );
        return $result;
    }
    
    public function post($url, $data)
    {
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, TRUE );
        curl_setopt ( $ch, CURLOPT_POST, TRUE );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $ret = curl_exec ( $ch );
        curl_close ( $ch );
        return $ret;
    }
}