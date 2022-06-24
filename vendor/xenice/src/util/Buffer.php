<?php

namespace xenice\util;

class Buffer
{
    public function __construct()
	{
        header('X-Accel-Buffering: no'); // 告诉nginx禁止缓存响应内容
	}
	
    // Immediate output
    public function flush($str)
	{
	    echo $str;
        ob_flush();
        flush();
	}
	
	// Get output content
	public function get($func)
	{
        ob_start();
        $func();
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
	}
}