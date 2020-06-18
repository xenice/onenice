<?php
/**
 * @name        Xenice Cache File
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-08-16
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace xenice\cache;

class File
{
    private $data = [];

	public function __construct()
	{
	    $this->file = THEME_DIR . '/cache/cachefile.txt';
		if(is_file($this->file)){
			$this->data = unserialize(file_get_contents($this->file));
		}
	}
	
    public function set($key, $value, $time = 3600)
    {
        $arr['value'] = $value;
        $arr['time'] = time() + $time;
        $this->data[$key] = $arr;
		file_put_contents($this->file,  serialize($this->data));
    }
    
    public function get($key)
    {
        if(isset($this->data[$key])){
            $arr= $this->data[$key];
            
            if($arr['time'] > time()){
                return $arr['value'];
            }
            else{
                unset($this->data[$key]);
            }
        }
        return '';
    }
}