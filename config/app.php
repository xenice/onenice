<?php
define('HOME_URL', home_url());
define('THEME_NAME', wp_get_theme()->get('Name'));
define('THEME_DIR', get_template_directory());
define('THEME_URL', get_template_directory_uri());
define('THEME_VER', wp_get_theme()->get('Version'));
define('STATIC_DIR', THEME_DIR . '/static');
define('STATIC_URL', THEME_URL . '/static');
define('VIEW_SLUG', 'app/web/view');
define('VIEW_DIR', THEME_DIR . '/' . VIEW_SLUG);
define('XENICE_DIR', THEME_DIR . '/vendor/xenice');
define('XENICE_URL', THEME_URL . '/vendor/xenice');

// options
define('OPTIONS_FILE', __dir__ . '/options.php');

define('DEBUG', false);