<?php
// Configuración de la base de datos
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'inventario2');
define('DB_USER', 'root');
define('DB_PASS', '');

// Rutas base
define('BASE_URL', 'http://localhost/Bootstrap/');

// Rutas de controladores por defecto
define('DEFAULT_CONTROLLER', 'usuario');
define('DEFAULT_ACTION', 'login');

// Rutas de directorios
define('ROOT_PATH', dirname(__DIR__));
define('CONTROLLER_PATH', ROOT_PATH . '/controllers/');
define('MODEL_PATH', ROOT_PATH . '/models/');
define('VIEW_PATH', ROOT_PATH . '/views/');
define('PUBLIC_PATH', ROOT_PATH . '/public/');
?> 