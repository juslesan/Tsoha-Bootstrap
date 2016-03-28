<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});
$routes->get('/tyoaiheet', function() {
    HelloWorldController::tyoaiheet();
});
$routes->get('/tyoaiheet/1', function() {
    HelloWorldController::tyoaihe();
});
$routes->get('/tyoaiheet/1/edit', function() {
HelloWorldController::edit();
});

//$routes->get('/login', function() {
//    HelloWorldController::login();
//});
