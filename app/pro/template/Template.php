<?php

namespace app\pro\template;

use xenice\theme\Theme;

class template extends \xenice\view\Template
{
    
    public function socialLogin()
    {
        $str = '';
        $aurl = admin_url('admin-ajax.php');
        $rurl = $this->rurl();
        if(take('enable_qq_login')){
            $url = $aurl;
            $str .= '<a href="'.$url.'?action=qq&rurl='.$rurl.'" class="btn btn-qq" title="'._t('QQ Login').'"><i class="fa fa-qq"></i></a>';
        }
        if(take('enable_wechat_login')){
            $url = $aurl;
            $url .= '?action=wechat';
            $url = 'https://open.weixin.qq.com/connect/qrconnect?appid='.take('wechat_app_id').'&redirect_uri='.$url.'&response_type=code&scope=snsapi_login&state=MBT_weixin_login#wechat_redirect';
            $str .= '<a href="'.$url.'" class="btn btn-weixin" title="'._t('WeChat Login').'"><i class="fa fa-weixin"></i></a>';
        }
        if(take('enable_weibo_login')){
            $url = $aurl;
            $str .= '<a href="'.$url.'?action=weibo&rurl='.$rurl.'" class="btn btn-weibo" title="'._t('Weibo Login').'"><i class="fa fa-weibo"></i></a>';
        }
        
        if($str){
            return '<div class="login-ways"><span>'._t('Log in other ways: ').'</span>'.$str.'</div>';
        }
    }
    
    protected function rurl()
    {  
        $pageURL = 'http';
        $pageURL .= (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on")?"s":"";
        $pageURL .= "://";
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        return $pageURL;      
    }
}