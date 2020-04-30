<?php

namespace app\web\model;

use xenice\model\UserModel;

class User extends UserModel
{
    use \app\web\model\part\User;
    
    public function __construct()
    {
        parent::__construct();
    }
    

}