<?php

define('BOOKS_STORAGE','data/books.txt');
// list -> listAction
$action = requestGet('action','list').'Action';

function formBookIsValid(){
    $title = requestPost('title');
    $price = requestPost('price');
            
    //logic for check form
    return (!empty($title) && !empty($price));
}


if(!function_exists($action)){
    //$controllerFile = 'list';
    setFlash('Function is not exist'); 
    redirect("/index.php");
}
$content =$action();


function listAction(){
    $books = loadBooks();

    ob_start();
    require 'books_list.phtml';
    return ob_get_clean();
}


function createAction(){
    if($_POST){
        //validation
        if(formBookIsValid()){
            $book = $_POST;
            $book['id'] = rand(10000, 99999); 
            $book = serialize($book);
            file_put_contents(BOOKS_STORAGE,$book.PHP_EOL, FILE_APPEND);
            setFlash("Book was created");
            redirect("/index.php");   
        }
    }    
    echo "just page";
    ob_start();
    require 'books_create.phtml';
    return ob_get_clean();
}


function editAction(){
    $id = requestGet('id');
    if(!$id){
        setFlash('id is not correct');
        redirect("/index.php");    
    }    
    $books = loadBooks();
    $bookFound = false;
    //& to edit
    foreach($books as &$book){
        if($id == $book['id']){
            $bookFound = true;
            break;
        }
    }
    if(!$bookFound){
        setFlash('Book was not found');
        redirect("/index.php");
    }
    
    if($_POST){
        $book['title'] = $_POST['title'];
        $book['price'] = $_POST['price'];   
        fopen(BOOKS_STORAGE,'w');
        fclose();
        
        foreach($books as $b){
            file_put_contents(BOOKS_STORAGE,serialize($b).PHP_EOL,FILE_APPEND);
        }
        setFlash('Book was edited');
        redirect("/index.php");
    }
    //можно добавить проверку id
    ob_start();
    require 'books_edit.phtml';
    return ob_get_clean();
}


function deleteAction(){
    $id = requestGet('id');
    if(!$id){
        setFlash('id is not correct');
        redirect("/index.php");    
    }    
    $books = loadBooks();
    
    foreach($books as $key => $book){
        if($id == $book['id']){
            unset($books[$key]);
            setFlash('Book was deleted');
            break;
        }
    }  
    fopen(BOOKS_STORAGE,'w');
    fclose();
    
    foreach($books as $b){
        file_put_contents(BOOKS_STORAGE,serialize($b).PHP_EOL,FILE_APPEND);
    }
    redirect("/index.php");
}


function loadBooks(){
    $serializedBooks = file(BOOKS_STORAGE);
    $books = [];

    foreach($serializedBooks as $b){
        $books[] = unserialize($b);
    }
    return $books;
}