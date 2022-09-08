<?php
/**
 * Usage routes
 *
 * Static
 * 1. $router->get('/tests', [\namespace\Controller::class, 'method']);
 * 2. $router->get('/tests', function() {});
 *
 * Dynamic for variables
 * 1. $router->get('/tests/:id', [\namespace\Controller::class, 'method']);
 * 2. $router->get('/tests/:id', function() {});
 *
 * Available request methods
 * $router->get(route, callback);
 * $router->post(route, callback);
 * $router->patch(route, callback);
 * $router->put(route, callback);
 * $router->delete(route, callback);
 */


$router = new \Classes\Router($_SERVER['SERVER_NAME'] == ('localhost' || '127.0.0.1') ? PATH_DIR : '/');

//Default pages
$router->get('/', [\Controllers\HomeController::class, 'index']);
$router->get('/about', [\Controllers\HomeController::class, 'about']);
$router->get('/contact', [\Controllers\HomeController::class, 'contact']);
$router->post('/contact', [\Controllers\HomeController::class, 'contact']);

//Blog
$router->get('/blog', [\Controllers\BlogController::class, 'index']);
$router->get('/blog/:id', [\Controllers\BlogController::class, 'read']);
$router->get('/blog/comments/:id', [\Controllers\BlogController::class, 'getComments']);
$router->post('/blog/comment-create', [\Controllers\BlogController::class, 'createComment']);

//Events
$router->get('/events', [\Controllers\EventController::class, 'index']);

//Auth
$router->post('/auth/login', [\Controllers\AuthController::class, 'login']);
$router->post('/auth/register', [\Controllers\AuthController::class, 'register']); 
$router->get('/auth/logout', [\Controllers\AuthController::class, 'logout']);
$router->post('/auth/passwordreset', [\Controllers\AuthController::class, 'authHandlePasswordReset']);
$router->get('/settings', [\Controllers\AuthController::class, 'settings']);
$router->post('/settings', [\Controllers\AuthController::class, 'settings']);

//Admin
$router->get('/admin', [\Controllers\Admin\AdminController::class, 'handleRequest']);

//Admin-event
$router->get('/admin/events', [\Controllers\Admin\EventsController::class, 'index']);
$router->post('/admin/events/create', [\Controllers\Admin\EventsController::class , 'create']);
$router->post('/admin/events/update', [\Controllers\Admin\EventsController::class, 'update']);
$router->post('/admin/events/delete', [\Controllers\Admin\EventsController::class, 'delete']);

//Admin-Blog
$router->get('/admin/blogs', [\Controllers\Admin\BlogsController::class, 'index']);
$router->post('/admin/blogs/create', [\Controllers\Admin\BlogsController::class, 'create']);
$router->post('/admin/blogs/update', [\Controllers\Admin\BlogsController::class, 'update']);
$router->post('/admin/blogs/delete', [\Controllers\Admin\BlogsController::class, 'delete']);


//Admin-User
$router->get('/admin/users', [\Controllers\Admin\UsersController::class, 'index']);
$router->post('/admin/users/update', [\Controllers\Admin\UsersController::class, 'update']);
$router->post('/admin/users/delete', [\Controllers\Admin\UsersController::class, 'delete']);

$router->run();
