<?php

use App\Controller\{ArticleController, SigninController, SignoutController, SignupController, UserController};

$router->map('GET', '/', function() {
    $articleController = new ArticleController();
    $articleController->index();
});
$router->map('POST', '/article/new', function() {
    $articleController = new ArticleController();
    $articleController->new();
});
$router->map('GET', '/article/show', function() {
    $articleController = new ArticleController();
    $articleController->show();
});
$router->map('PUT', '/article/edit', function() {
    $articleController = new ArticleController();
    $articleController->edit();
});
$router->map('DELETE', '/article/delete', function() {
    $articleController = new ArticleController();
    $articleController->delete();
});
$router->map('GET|POST', '/signup', function () {
    $signupController = new SignupController();
    $signupController->index();
});
$router->map('GET|POST', '/signin', function () {
    $signinController = new SigninController();
    $signinController->index();
});
$router->map('GET|POST', '/signout', function () {
    $signoutController = new SignoutController();
    $signoutController->index();

});
$router->map('GET', '/user', function () {
    $UserController = new UserController();
    $UserController->index();
});

$router->map('GET', '/user/show', function () {
    $UserController = new UserController();
    $UserController->show();
});

$router->map('PUT', '/user/edit', function () {
    $UserController = new UserController();
    $UserController->edit();
});
$router->map('DELETE', '/user/delete', function () {
    $UserController = new UserController();
    $UserController->delete();
});


