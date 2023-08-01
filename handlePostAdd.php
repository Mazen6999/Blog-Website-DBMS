<?php
    session_start();
    if(empty($_SESSION["user"])){
        header("location:403.php"); 
    }
    if(!empty($_POST["body"])){
    $title = $_POST["title"];
    $body = $_POST["body"];
    require_once("classes.php");
    $user= unserialize($_SESSION["user"]);
    $file_name=NULL;

    if(!empty($_FILES["image"]["name"])){
    $extension= pathinfo($_FILES["image"]["name"],PATHINFO_EXTENSION);
    $file_name="images/users/".Date("YmdHis").".".$extension;
    move_uploaded_file($_FILES["image"]["tmp_name"],$file_name);
    }
    $author_id=$user->id;
    $rslt=$user->addPost($author_id,$title,$body,$file_name);

    header("location:addPost.php?msg=Post_Added_Succesfully"); 
    }else{
        header("location:addPost.php?msg=No_body"); 
    }

?>