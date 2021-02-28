<?php
/**
 * @name        xenice avatar optimize
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-12-14
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace xenice\optimize;

use xenice\theme\Base;
use xenice\theme\Theme;
use xenice\optimize\lib\Avatar;

class AvatarOptimize
{
    public $avatar;
    
    public function __construct()
    {
        $this->avatar = new Avatar;
    }
    
}