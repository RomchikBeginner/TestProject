<?php

return [
    '~^$~'=>[\TestProject\Controllers\MainController::class, 'main'],
    '~^clients/(\d+)$~' => [\TestProject\Controllers\ClientsController::class, 'view'],
    '~^clients/(\d+)/edit$~' => [\TestProject\Controllers\ClientsController::class, 'edit'],
    '~^clients/add$~' => [\TestProject\Controllers\ClientsController::class, 'add'],
    '~^clients/(\d+)/delete$~' => [\TestProject\Controllers\ClientsController::class, 'delete'],
    '~^clients/register$~' => [\TestProject\Controllers\ClientsController::class, 'signUp'],
    '~^(\d+)$~' => [\TestProject\Controllers\MainController::class, 'page']
];

?>