<?php
//Единая точка входа
session_start();

//redirect to same page
$uri = pathinfo($_SERVER['REQUEST_URI']);
$uri = $uri['dirname'];

require "functions.php";
$msg = getFlash('msg');

$controller = requestGet('controller','books');

$controllerFile = "{$controller}.php";
if(!file_exists($controllerFile)){
    $controllerFile = 'books.php';
}

require $controllerFile;

//показываем список книг всегда, кроме того когда логинимся
if(requestGet('login')!=1){
    include "layout.phtml";
}
?>