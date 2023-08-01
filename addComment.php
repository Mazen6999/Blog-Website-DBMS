<?php
session_start();
if (empty($_SESSION["user"])) {
    header("location:403.php");
}

require_once("classes.php");
$user = unserialize($_SESSION["user"]);

    $author_id=$_GET["user_id"];
    echo("<br>");
    var_dump($_GET["post_id"]);
    $parent_post_id=$_GET["post_id"];
    $body=$_POST["body"];
    echo("<br>");
    var_dump($_POST["body"]);

$user->addComment($parent_post_id,$author_id,$body);
if($user->role == "user"){
header("location:profile.php?comment_added");}
if($user->role == "admin"){
    header("location:admin.php?comment_added");}
