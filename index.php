<?php
session_start();

// Cargar configuración y clases base
require_once 'config/config.php';
require_once 'config/database.php';

// Determinar el controlador y la acción a ejecutar
$controllerName = isset($_GET['controller']) ? ucfirst($_GET['controller']) . 'Controller' : ucfirst(DEFAULT_CONTROLLER) . 'Controller';
$actionName = isset($_GET['action']) ? $_GET['action'] : DEFAULT_ACTION;

// Verificar si el controlador existe
$controllerFile = 'controllers/' . $controllerName . '.php';
if (file_exists($controllerFile)) {
    require_once $controllerFile;
    
    // Crear instancia del controlador
    $controller = new $controllerName();
    
    // Verificar si la acción existe
    if (method_exists($controller, $actionName)) {
        // Ejecutar la acción
        $controller->$actionName();
    } else {
        echo "La acción {$actionName} no existe en el controlador {$controllerName}";
    }
} else {
    echo "El controlador {$controllerName} no existe";
}
?> 