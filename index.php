<?php
//Единая точка входа
session_start();

require "functions.php";
$msg = getFlash('msg');

//redirect to same page - GET
global $my_uri;
$my_uri = str_replace('C:\xampp\htdocs','',__FILE__);
$my_uri = str_replace('\\','/',$my_uri);

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