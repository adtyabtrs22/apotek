<?php
spl_autoload_register(function($class) {
    // Autoload controllers
    if (file_exists('App/controllers/' . $class . '.php')) {
        include 'App/controllers/' . $class . '.php';
    }
    // Autoload models
    elseif (file_exists('App/models/' . $class . '.php')) {
        include 'App/models/' . $class . '.php';
    }
});
?>