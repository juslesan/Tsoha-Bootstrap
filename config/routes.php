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
$routes->post('/tyoaiheet/:id/edit', function($id) {
    Tyoaihe_controller::update($id);
});

$routes->post('/tyoaiheet/:id/destroy', function($id) {
    Tyoaihe_controller::destroy($id);
});
$routes->post('/tyoaiheet', function() {
    Tyoaihe_controller::store();
});
$routes->get('/login', function() {
    // Kirjautumislomakkeen esittäminen
    UserController::login();
});
$routes->post('/login', function() {
    // Kirjautumisen käsittely
    UserController::handle_login();
});

$routes->post('/logout', function() {
    UserController::logout();
});

$routes->get('/kurssit', function() {
    Laboratoriokurssi_controller::all();
});

$routes->get('/kurssit/new', function() {
    Laboratoriokurssi_controller::create();
});

$routes->post('/kurssit', function() {
    Laboratoriokurssi_controller::store();
});

$routes->get('/kurssit/:id', function($id) {
    Laboratoriokurssi_controller::show($id);
});
$routes->get('/kurssit/:id/edit', function($id) {
    Laboratoriokurssi_controller::edit($id);
});
$routes->post('/kurssit/:id/edit', function($id) {
    Laboratoriokurssi_controller::update($id);
});

$routes->post('/kurssit/:id/destroy', function($id) {
    Laboratoriokurssi_controller::destroy($id);
});
$routes->get('/kurssit/:id/tyoaiheet', function($id) {
    Laboratoriokurssi_controller::tyoaiheet($id);
});
$routes->post('/kurssit/:id/tyoaiheet', function($id) {
    Laboratoriokurssi_controller::tyoaihe_store($id);
});
$routes->get('/kurssit/:id/tyoaiheet/add', function($id) {
    Laboratoriokurssi_controller::tyoaihe_add($id);
});
$routes->post('/kurssit/:id/tyoaiheet/:tyoaihe_id/destroy', function($id, $tyoaihe_id) {
    Laboratoriokurssi_controller::tyoaihe_destroy($id, $tyoaihe_id);
});


$routes->get('/tyoaiheet/:id/suoritukset', function($id) {
    Suoritus_controller::suoritus_list($id);
});
$routes->post('/tyoaiheet/:id/suoritukset', function($id) {
    Suoritus_controller::store($id);
});
$routes->get('/tyoaiheet/:id/uusisuoritus', function($id) {
    Suoritus_controller::create($id);
});
$routes->get('/tyoaiheet/:tyoaihe_id/suoritukset/:suoritus_id', function($tyoaihe_id, $suoritus_id) {
    Suoritus_controller::show($tyoaihe_id, $suoritus_id);
});
$routes->get('/tyoaiheet/:tyoaihe_id/suoritukset/:suoritus_id/edit', function($tyoaihe_id, $suoritus_id) {
    Suoritus_controller::edit($tyoaihe_id, $suoritus_id);
});
$routes->post('/tyoaiheet/:tyoaihe_id/suoritukset/:suoritus_id/edit', function($tyoaihe_id, $suoritus_id) {
    Suoritus_controller::update($tyoaihe_id, $suoritus_id);
});
$routes->post('/tyoaiheet/:tyoaihe_id/suoritukset/:suoritus_id/destroy', function($tyoaihe_id, $suoritus_id) {
    Suoritus_controller::destroy($tyoaihe_id, $suoritus_id);
});


//$routes->get('/login', function() {
//    HelloWorldController::login();
//});
