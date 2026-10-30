<?php
session_start();
require_once '../db/connection.php';
if($_SERVER['REQUEST_METHOD']=="POST" && isset($_GET['id'])){
    $errors=[];
    $titles=$_POST['title'];
    $body=$_POST['body'];
    $id=$_GET['id'];
    if(empty($titles)){
        $errors[]="title should be exist";
    }
    if(empty($body)){
        $errors[]="body should be exist";
    }
    $query="SELECT image FROM posts WHERE id=$id";
    $result=mysqli_query($connect,$query);
    $oldImage=mysqli_fetch_assoc($result)['image'];

    if(isset($_FILES['image']) && $_FILES['image']['name']){
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
    
    }else{
        $img_newName=$oldImage;     
    }

    if(empty($errors)){
        $query="update posts set title='$titles',body='$body',image='$img_newName' where id=$id";
        $result=mysqli_query($connect,$query);
        if($result){
            $_SESSION['successPostUpdate']="post updated successfully";
            if($img){
                move_uploaded_file($img_tmpName,"../assets/images/postImage/$img_newName");
                unlink("../assets/images/postImage/" .$oldImage);
            }
            header("location:../index.php");
            exit();
        }
    }
    $_SESSION['errors']=$errors;
    header("location:../editPost.php");
    
}