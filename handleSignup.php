<?php
if(!empty($_POST["name"]) && !empty($_POST["email"])  && !empty($_POST["password"]) ){
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $extension= pathinfo($_FILES["image"]["name"],PATHINFO_EXTENSION);
    $file_name="images/users/".Date("YmdHis").".".$extension;
    move_uploaded_file($_FILES["image"]["tmp_name"],$file_name);


    require_once("classes.php");
    users::signup($name,$email,$password,$file_name);

}else{
    header("location:signup.php?msg=empty_field(s)");
}
