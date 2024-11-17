<?php

require_once 'libs/router.php';
require_once 'api/controller/product_controller.php';
require_once 'api/controller/category_controller.php';

$router = new Router();

// Productos
#                       endpoint                     verbo            controller                            metodo
$router->addRoute('product',                    'GET',     'ProductApiController',   'productGet');
$router->addRoute('product/:id',                'GET',     'ProductApiController',   'productId');
$router->addRoute('product',                    'POST',    'ProductApiController',   'productAdd');
$router->addRoute('product/:id',                'PUT',     'ProductApiController',   'productUpdate');
$router->addRoute('product/:id',                'DELETE',  'ProductApiController',   'productDelete');

// Categorias
#                       endpoint                     verbo            controller                            metodo
$router->addRoute('category',                   'GET',     'CategoryApiController',   'categoryAll');
$router->addRoute('category',                   'POST',    'CategoryApiController',   'categoryAdd');
$router->addRoute('category/:brand',            'DELETE',  'CategoryApiController',   'categoryDelete');

$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);
