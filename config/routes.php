<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});
$routes->get('/tyoaiheet', function() {
    Tyoaihe_controller::index();
});
$routes->get('/tyoaiheet/new', function() {
    Tyoaihe_controller::create();
});
$routes->get('/tyoaiheet/:id', function($id) {
    Tyoaihe_controller::show($id);
});
$routes->get('/tyoaiheet/:id/edit', function($id) {
    Tyoaihe_controller::edit($id);
});
$routes->post('/tyoaiheet', function() {
    Tyoaihe_controller::store();
});



//$routes->get('/login', function() {
//    HelloWorldController::login();
//});
