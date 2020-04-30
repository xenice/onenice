<?php
namespace app\web\ajax;

use xenice\theme\Base;

class Ajax extends Base
{
	public function __construct()
	{
	    LoginAjax::instance();
		ValidationAjax::instance();
	}
}