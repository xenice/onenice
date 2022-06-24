<?php

namespace app\web\model\pointer;

use xenice\theme\Theme;
use xenice\model\pointer\UserPointer;

class User extends UserPointer
{
    public function __construct($mix)
    {
        parent::__construct($mix);
    }
    
	public function avatar($size = 32)
	{
	    return get_avatar($this->id(), $size, '', '', ['class'=>'rounded-circle']);
	}

}