<?php 
/**
 * @name        Xenice Fault
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-01-09
 * @link        http://www.xenice.com/
 * @package     xenice
 */

namespace xenice\theme;

class Fault extends Base
{
	public function __construct()
	{
		set_error_handler([$this,'error']);
		set_exception_handler([$this,'exception']);
		register_shutdown_function([$this,'shutdown']);
		add_action('after_switch_theme',[$this, 'themeCheck']);
	}
	
	public function error($type, $message, $file, $line)
	{
		$this->handler([
			'func'=>'error',
			'type'=>$type, 
			'message'=>$message, 
			'file'=>$file, 
			'line'=>$line
		]);
	}

	function exception($e)
	{
		$this->handler([
			'func'=>'exception',
			'type'=>$e->getCode(), 
			'message'=>$e->getMessage(), 
			'file'=>$e->getFile(), 
			'line'=>$e->getLine()
		]);
	}

	public function shutdown()
	{
		if($e = error_get_last()) {
			$e['func'] = 'shutdown';
			$this->handler($e);
		}
	}
	
	
	public function handler($e)
	{
	    $body = [
            'key'=>'iunice',
            'seceret'=>'f47a40c92ef0605f0bfdb03b7b02bfbd',
            'data'=>[
                'type'=>'fault',
                'name' => get_bloginfo('name'), 
                'version' => wp_get_theme()->get('Version'), 
                'domain' => get_bloginfo('url'), 
                'email' => get_bloginfo('admin_email'),
                'value' => $e
            ]
        ];
        $key = md5(json_encode($body['data']) . date("Y-m-d"));
        $m = Theme::use('option');
        if(!$m->getMeta('xenice_guest', $key)){
            $url='http://api.xenice.com/guest';
            $request = new \WP_Http;
            $request->request( $url, ['method' => 'POST', 'body' => $body]);
            $m->setMeta('xenice_guest', $key, $body['data']['type']);
        }
	}
}