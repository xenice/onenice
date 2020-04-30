<?php
/**
 * @name        xenice user table optimize
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-12-14
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace xenice\optimize;

use xenice\theme\Base;
use xenice\theme\Theme;
use xenice\optimize\lib\Client;

class UserTableOptimize
{
    public function __construct()
    {
        add_action( 'wp_login', [$this,'wpLogin']);
        add_action('user_register', [$this,'register']);
        Theme::bind('social_login',[$this,'login']);
        Theme::bind('social_register',[$this,'register']);
        if(is_admin()){
            add_filter('manage_users_columns', [$this,'addColumns']);
            add_action('manage_users_custom_column',  [$this,'showColumns'], 10, 3);
            add_filter( "manage_users_sortable_columns", [$this,'sortColumns']);
            add_action( 'pre_user_query', [$this,'query']); 
        }
    }
    
    function register($user_id)
    {
        $client =  new Client;
        $data = [
	        'registered_os'=>$client->os(),
	        'registered_ip'=>$client->ip(),
	        'register_way'=>''
	    ];
	    Theme::new('user_pointer', $user_id)->setValue($data);
    }
    
    function login($user_id)
    {
        $client =  new Client;
        $data = [
	        'last_login_time'=>date('Y-m-d H:i:s',time()),
	        'last_login_os'=>$client->os(),
	        'last_login_ip'=>$client->ip(),
	        'last_login_way'=>''
	    ];
	    Theme::new('user_pointer', $user_id)->setValue($data);
    } 
    
    function wpLogin($login)
    {
        $user = get_userdatabylogin( $login );
        $this->login($user->ID);
    }
    
    function addColumns($columns)
    {  
        $columns = [
            'cb'=>'<input type="checkbox" />',
            'username'=>__('Username'),
            'user_nicename'=>_t('Nicename'),
            'email'=>__('Email'),
            'user_registered'=>_t('Registered'),
            'last_login'=>_t('Last Login'),
            'role'=>__('Role'),
            'posts'=>__('Posts')
        ];
        return $columns;  
    }
    
    function showColumns($value, $column_name, $user_id)
    {
        $user = get_userdata( $user_id );
        $login = get_user_meta( $user->ID, 'xenice_value', true);
        if ( 'user_nicename' == $column_name )  
            return $user->nickname;  
        //if ( 'user_url' == $column_name )  
        //    return '<a href="'.$user->user_url.'" target="_blank">'.$user->user_url.'</a>';  
        if('user_registered' == $column_name ){
            $str = get_date_from_gmt($user->user_registered); 
            empty($login['registered_ip']) || $str .= '<br/>' . $login['registered_ip'];
            empty($login['registered_os']) || $str .= ' ' . $login['registered_os'];
            return $str;
        }
        
        if('last_login' == $column_name ){
            $str = '';
            empty($login['last_login_time']) || $str .= $login['last_login_time'];
            empty($login['last_login_ip']) || $str .= '<br/>' . $login['last_login_ip'];
            empty($login['last_login_os']) || $str .= ' ' . $login['last_login_os'];
            
            return $str;
        }
        return $value;
    }
    
    function sortColumns($sortable_columns)
    {
        $sortable_columns['user_registered'] ='user_registered'; 
        return $sortable_columns;  
    }
    
    function query($obj)
    { 

        if(!isset($_REQUEST['orderby']) || $_REQUEST['orderby']=='user_registered' ){  
            if( !in_array($_REQUEST['order'],array('asc','desc')) ){  
                $_REQUEST['order'] = 'desc';  
            }  
            $obj->query_orderby = "ORDER BY user_registered ".$_REQUEST['order']."";  
        }
    }  
}