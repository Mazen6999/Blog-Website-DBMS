<?php
session_start();
require_once("classes.php");

if(!empty($_POST["email"] && !empty($_POST["password"]))){

    $email = $_POST["email"];
    $password = $_POST["password"];
    $user = users::login($email, $password);
    if(empty($user)){
        header("location:index.php?msg=invalid_credentials");
    } else {
        $role = $user->role;
        $_SESSION["user"]= serialize($user);
        if ($role == 'user') {
            header("location:profile.php");
        }else{
            header("location:admin.php");
        }
    }

} else {
    header("location:index.php?msg=empty_field(s)");
}

?>