<?php
define('THEME_NAME', wp_get_theme()->get('Name'));
define( 'THEME_DIR', get_template_directory());
define( 'THEME_URL', get_template_directory_uri());
define( 'THEME_VER', wp_get_theme()->get('Version'));
define( 'STATIC_DIR', THEME_DIR . '/static');
define( 'STATIC_URL', THEME_URL . '/static');
define( 'VIEW_SLUG', 'app/web/view');
define( 'VIEW_DIR', THEME_DIR . '/' . VIEW_SLUG);

// options
define('OPTIONS_FILE', __dir__ . '/options.php');

// cache
define('CACHE_MODE','memcached');
define('CACHE_FILE',THEME_DIR . '/cache/cachefile.txt');