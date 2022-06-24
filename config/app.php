<?php
define('HOME_URL', home_url('', empty($_SERVER['HTTPS'])?'http':'https'));
define('THEME_NAME', wp_get_theme()->get('Name'));
define('THEME_URI', wp_get_theme()->get('ThemeURI'));
//define('THEME_KEY', explode(' ', THEME_NAME)[1]??'web');
define('THEME_KEY', 'pro');
define('THEME_DIR', get_template_directory());
define('THEME_URL', get_template_directory_uri());
define('THEME_VER', wp_get_theme()->get('Version'));
define('STATIC_DIR', THEME_DIR . '/static');
define('STATIC_URL', THEME_URL . '/static');
define('VIEW_SLUG', 'app/web/view');
define('VIEW_DIR', THEME_DIR . '/' . VIEW_SLUG);
define('XENICE_DIR', THEME_DIR . '/vendor/xenice');
define('XENICE_URL', THEME_URL . '/vendor/xenice');
define('AJAX_URL', admin_url('admin-ajax.php'));

// ex
define('VIEW_SLUG_EX', 'app/'.THEME_KEY.'/view');
define('VIEW_DIR_EX', THEME_DIR . '/' . VIEW_SLUG_EX);
define('STATIC_DIR_EX', STATIC_DIR . '/' . THEME_KEY);
define('STATIC_URL_EX', STATIC_URL . '/' . THEME_KEY);

define('CACHE', true);