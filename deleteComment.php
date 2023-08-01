<?php
session_start();
if (empty($_SESSION["user"])) {
    header("location:403.php");
}
$comment_id=$_GET["comment_id"];
require_once("classes.php");
$user = unserialize($_SESSION["user"]);
$user->deleteComment($comment_id);
if($user->role == "user"){
    echo"<script type='text/javascript'>alert('Comment Deleted');location='profile.php';</script>";
}else{
    echo"<script type='text/javascript'>alert('Comment Deleted');location='admin.php';</script>";
}