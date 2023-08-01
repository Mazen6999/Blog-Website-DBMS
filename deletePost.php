<?php
session_start();
if (empty($_SESSION["user"])) {
    header("location:403.php");
}
$post_id=$_GET["post_id"];
require_once("classes.php");
$user = unserialize($_SESSION["user"]);
$user->deletePost($post_id);
if($user->role == "user"){
    echo"<script type='text/javascript'>alert('Post Deleted');location='profile.php';</script>";
}else{
    echo"<script type='text/javascript'>alert('Post Deleted');location='admin.php';</script>";
}
