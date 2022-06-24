<?php
require __dir__ . '/config/app.php';
require __dir__ . '/vendor/autoload.php';

use xenice\theme\Theme;



Theme::instance('app\\'.THEME_KEY.'\Loader');