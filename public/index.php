<?php
// File: public/index.php
define('APP_PATH', __DIR__ . '/../App');
// Aktifkan error reporting untuk debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Memuat konfigurasi
require_once '../config/config.php';

// Memuat core classes
require_once '../core/Controller.php';
require_once '../core/Model.php';
require_once '../core/Database.php';

// Autoload models
spl_autoload_register(function ($className) {
    $path = "../app/models/" . $className . ".php";
    if (file_exists($path)) {
        require_once $path;
    }
});

// Autoload controllers
spl_autoload_register(function ($className) {
    $path = "../app/controllers/" . $className . ".php";
    if (file_exists($path)) {
        require_once $path;
        // Debugging: Pastikan controller dimuat
        // echo "Loaded controller: $className<br>";
    }
});

// Mendapatkan URL
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '/';
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

// Routing
if ($url[0] == '' || $url[0] == 'dashboard') {
    if (!class_exists('DashboardController')) {
        die("DashboardController class tidak ditemukan.");
    }
    $controller = new DashboardController();
    $controller->index();
} else {
    $controllerName = ucfirst($url[0]) . 'Controller';
    $method = isset($url[1]) ? $url[1] : 'index';
    $params = array_slice($url, 2);

    if (class_exists($controllerName)) {
        $controller = new $controllerName();

        if (method_exists($controller, $method)) {
            call_user_func_array([$controller, $method], $params);
        } else {
            echo "Method <strong>$method</strong> tidak ditemukan dalam controller <strong>$controllerName</strong>.";
        }
    } else {
        echo "Controller <strong>$controllerName</strong> tidak ditemukan.";
    }
}
?>
