<?php
session_start();
require '../db/connection.php';
if(isset($_GET['id'])){
    $id=$_GET['id'];
    $query="DELETE FROM posts WHERE id=$id";
    $result=mysqli_query($connect,$query);
    if($result){
        $_SESSION['successDelete']="Post deleted successfully";
        header("Location:../index.php");
        exit();
    }
    $_SESSION['error']="the post is not deleted ";
    header("Location:../index.php");
    exit();
}