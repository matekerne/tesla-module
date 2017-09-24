<?php

spl_autoload_register(function($class) {
    $paths = array(
        '/',
      	'/components',
      	'/models',
      	'/controllers',
      	'/modules/tesla/models',
      	'/modules/tesla/controllers'
    );
    foreach ($paths as $path) {
      	$path_to_file = ROOT . $path . '/' . $class . '.php';
        $file = preg_replace('/\\\+/', '/', $path_to_file);
        if (file_exists($file)) {
            include_once $file;
        }
    }
});