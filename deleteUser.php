<?php
session_start();
if (empty($_SESSION["user"])) {
    header("location:403.php");
}
$user_id=$_GET["user_id"];
require_once("classes.php");
$user = unserialize($_SESSION["user"]);
$user->deleteUser($user_id);
header("location:admindashboard.php");