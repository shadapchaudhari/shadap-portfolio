<?php

require "autoloader.php";
require "Router.php";

$router = new Router();

$baseUrl = "/CODESEED/Frontend/backend";

$router->get($baseUrl.'/', function () {
    echo 'Welcome to the home page!';
});

$router->get($baseUrl.'/contact' , function(){
    echo "Welcome to the contact page";
});
$router->get($baseUrl.'/about', function(){
    echo "About us";
});
$router->get($baseUrl.'/users', function(){
 
    $users = new Users();
    $users->selectAllUsers();
});

$router->get($baseUrl.'/products/kookaboora-bat' , function(){
    $users = new Users();
    $users->selectProduct();
});

$router->get($baseUrl.'/insertContactForm' , function(){
    
    $input = file_get_contents('php://input');
    parse_str($input , $resultArray); 
    $users = new Users();
    $users->insertForm($resultArray);
    $db = new Database();
  
});

$router->listen();