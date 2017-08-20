<?php
    function requestPost($key, $default = null){
        return isset($_POST[$key]) ? $_POST[$key] : $default;
    }

    function requestGet($key, $default = null){
        return isset($_GET[$key]) ? $_GET[$key] : $default;
    }

   function formLoginIsValid(){
        $email = requestPost('email');
        $password = requestPost('password');
            
        //logic for check form
        return (!empty($email) && !empty($password));
    }

    function redirect($to){
        header("Location:{$to}");
        exit;
    } 

    function setFlash($message){
        $_SESSION['message'] = $message;
    }
    
    function getFlash($message){
        if(empty($_SESSION['message'])) return null;
        
        $message = $_SESSION['message'];
        unset($_SESSION['message']);
        return $message;
    }

    function loadUsers(){
        $usersSerialized = file('users/users.txt');
        $users = [];
        foreach($usersSerialized as $u){
            $users[] = unserialize($u);
        }
        return $users;
    }