<?php

require_once 'lib/Router.php';
require_once 'lib/ThrowableErrors.php';

$router = new Router();
$router::$BASEPATH = '/api/';

$router->addRoute(
    method: 'GET', 
    path: 'agencies', 
    handler: fn () => true
);