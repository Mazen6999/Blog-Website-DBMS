<?php
session_start();
if (empty($_SESSION["user"])) {
    header("location:403.php");
}

if (!empty($_POST["body"])) {
    $body = $_POST["body"];

    require_once("classes.php");
    $user = unserialize($_SESSION["user"]);

    $user->editPost($_GET["post_id"], $body);


    if ($user->role == "user") {

        echo "<script type='text/javascript'>alert('Post Modified !');location='profile.php';</script>";
    } else {
        echo "<script type='text/javascript'>alert('Post Modified !');location='admin.php';</script>";
    }
} else {

    require_once("classes.php");
    $user = unserialize($_SESSION["user"]);

    if ($user->role == "user") {

        echo "<script type='text/javascript'>alert('no change in body, Post left unmodified !');location='profile.php';</script>";
    } else {
        echo "<script type='text/javascript'>alert('no change in body, Post left unmodified !');location='admin.php';</script>";
    }
}
