<?php

try {
    spl_autoload_register(function($className){
        // var_dump($className);
        require_once __DIR__ . '/../src/' . str_replace('\\', '/', $className) . '.php';
    });



    $route = $_GET['route'] ?? '';

    $routes = require __DIR__ . '/../src/routes.php';

    $isFoundRoute = false;
    foreach ($routes as $pattern => $controllerAndAction) {
        preg_match($pattern, $route, $matches);
        if (!empty($matches)) {
            $isFoundRoute = true;
            break;
        }
    }

    if (!$isFoundRoute) {
        throw new \TestProject\Exceptions\NotFoundException();
    }

    unset($matches[0]);

    $controllerName = $controllerAndAction[0];
    $actionName = $controllerAndAction[1];

    $controller = new $controllerName();
    $controller->$actionName(...$matches);
} catch (\TestProject\Exceptions\DbException $e) {
    $view = new \TestProject\View\View(__DIR__ . '/../templates/errors');
    $view->renderHTML('500.php', ['error' => $e->getMessage()], 500);
} catch (\TestProject\Exceptions\NotFoundException $e) {
    $view = new \TestProject\View\View(__DIR__ . '/../templates/errors');
    $view->renderHTML('404.php', ['error' => $e->getMessage()], 404);
}

?>