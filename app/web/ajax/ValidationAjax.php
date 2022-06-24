<?php
namespace app\web\ajax;

use xenice\theme\Ajax;

class ValidationAjax extends Ajax
{
	public function __construct()
	{
	    //if(is_front_page()){
    		$this->action('validation');
    		add_filter('preprocess_comment',[$this,'validationProcess']);
	    //}
	}
    
    public function validation()
    {
        $num1=rand(0,9);
    	$num2=rand(0,9);
    	$_SESSION['validation'] = $num1 + $num2;
    	$str = "$num1 + $num2 = ?";
        $im = imagecreate(100, 30);
        $while=imagecolorallocate($im,255,255,255); 
        $black=imagecolorallocate($im,50,50,50); 
        imagestring($im, 12, 10, 10, $str, $black);
		//imagettftext($im,14, 0, 200, 30, $while, null, $str);
		header('Content-Type:image/png');
		imagepng($im);
        exit;
    }
    
    public function validationProcess($commentdata)
    {
    	$sum=$_POST['sum'];
    	switch($sum){
    		case $_SESSION['validation']:
    		break;
    		case null:
    		wp_die(_t('Sorry, Please enter verification code ') . '<a href="javascript:history.back(-1)">'._t('Go back') .'</a>',_t('Comment failure'));
    		break;
    		default:
    		wp_die(_t('Sorry, Verification code error ') . '<a href="javascript:history.back(-1)">'._t('Go back') .'</a>',_t('Comment failure'));
    	}
    	return $commentdata;
    }
    
}