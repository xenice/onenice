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
    private $data = []; // save keys

	public function __construct()
	{
	    $this->dir = THEME_DIR . '/cache/cachefile/';
	    is_dir($this->dir) || mkdir($this->dir);
	    $file = $this->dir . 'keys';
		if(is_file($file)){
			$this->data = unserialize(file_get_contents($file));
		}
	}
	
	public function __destruct()
	{
	    file_put_contents($this->dir . 'keys',  serialize($this->data));
	}
	
    public function set($key, $value, $time = 0)
    {
        $this->data[$key] = $time;
		file_put_contents($this->dir . md5($key),  serialize($value));
    }
    
    public function get($key)
    {
        if(isset($this->data[$key])){
            $time = $this->data[$key];
            $file = $this->dir . md5($key);
            if(($time == 0 || $time > time()) && is_file($file)){
                return unserialize(file_get_contents($file));
            }
            else{
                unset($this->data[$key]);
                unlink($file);
            }
        }
        return '';
    }
    
    public function keys()
    {
        return array_keys($this->data);
    }
    
    public function clear()
    {
        $this->deleteDir($this->dir);
    }
    
    private function deleteDir($dir) 
    {
        $dh=opendir($dir);
        while ($file=readdir($dh)) {
            if($file!="." && $file!="..") {
                $fullpath=$dir."/".$file;
                if(!is_dir($fullpath)) {
                  unlink($fullpath);
                } else {
                  deldir($fullpath);
                }
            }
        }
        closedir($dh);
        return rmdir($dir);

    }
}