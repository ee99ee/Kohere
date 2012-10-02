<?php defined('SYSPATH') OR die('No direct access allowed.');

return array
(
    'cache' => false,
    'debug' => false,
    'force_compile' => false,
    'error_reporting' => null,
    'php_handling' => 0, //a number between 0 and 3, chechk smarty for SMARTY_PHP_* constants
    'template_dir' => APPPATH.'views'.DIRECTORY_SEPARATOR,
    'compile_dir' => APPPATH.'cache'.DIRECTORY_SEPARATOR.'compile'.DIRECTORY_SEPARATOR,
    'plugin_dir' => array(), //you can put in multiple paths for smarty to load plugins from
    'cache_dir' => APPPATH.'cache'.DIRECTORY_SEPARATOR,
    'auto_render_template' => false,
);
