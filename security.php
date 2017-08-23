<?php

//если есть get параметр logout то удаляем из массива сессии от юзера 
if(requestGet('logout') == 1){
    unset($_SESSION['user']);
    setFlash('Logged out');
    redirect("/index.php");
}

$users = loadUsers();
if(requestGet('login') == 1){
    if($_POST){
        if(formLoginIsValid()){
            foreach($users as $user){
                //проверяем есть ли юзер в файле с тем кто введён в форме если да доступ открыт
                if($user['email'] == requestPost('email') && $user['password'] == requestPost('password')){
                    $_SESSION['user'] = $user['email'];
                    setFlash('Logged in');
                    //перенаправляем на страницу доступа
                    redirect("/index.php");
                }
            }
            setFlash("User not found");
            
            //redirect to same page - GET
            redirect("/index.php/login_form.phtml");
            }
                $msg = ("Form invalid");
    }
}

include 'login_page.phtml';
?>