<?php
namespace WPROG2\FinalProject\public;

header('Content-Type: application/json; charset=utf-8');


$http_requests = $_SERVER["REQUEST_URI"];
$router = new Router($http_requests);
$envSetter = new EnvSetter(__DIR__ . '/../.env');
$envSetter->load();
