<?php
namespace app\pro\ajax;


class Ajax extends \app\web\ajax\Ajax
{
	public function __construct()
	{
	    parent::__construct();
	    LikeAjax::instance();
	}
}