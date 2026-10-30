<?php
session_start();
require_once '../db/connection.php';
if($_SERVER['REQUEST_METHOD']=="POST"){
    $errors=[];
    $titles=$_POST['title'];
    $body=$_POST['body'];
    if(empty($titles)){
        $errors[]="title should be exist";
    }
    if(empty($body)){
        $errors[]="body should be exist";
    }

    $img=$_FILES['image'];
    $img_name=$img['name'];
    $img_tmpName=$img['tmp_name'];
    $img_error=$img['error'];
    $img_size=$img['size']/(1024*1024);
    $ext=pathinfo($img_name,PATHINFO_EXTENSION);
    $img_newName=uniqid().".".$ext;
    $user_id=$_SESSION['user_id'];
    if(empty($img)){
        $errors[]="image should be exist";
    }else if($img_error >0){
        $errors[]="your image is broken";
    }else if(!in_array($ext,['jpg','png','avif','webp'])){
        $errors[]="image should be jpg or png";
    }else if($img_size>5){
        $errors[]="your image size should be less than 5mb";
    }

    if(empty($errors)){
        $query="INSERT INTO posts(title,body,image,user_id) 
        VALUES('$titles','$body','$img_newName','$user_id')";
        $result=mysqli_query($connect,$query);
        if($result){
            $_SESSION['successPost']="post added successfully";
            move_uploaded_file($img_tmpName,"../assets/images/postImage/$img_newName");
            header("location:../index.php");
            exit();
        }
    }
    $_SESSION['errors']=$errors;
    header("location:../addPost.php");
    
}