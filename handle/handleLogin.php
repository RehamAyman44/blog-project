<?php
session_start();
require '../db/connection.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email=$_POST['email'];
    $password=$_POST['password'];
    $errors=[];
    
    if(!empty($password) &&!empty($email)){
        $query="SELECT * FROM users where email= '$email'";
        $result=mysqli_query($connect,$query);
        if(mysqli_num_rows($result)==1){
            $user=mysqli_fetch_assoc($result);
            $oldpassword=$user['password'];
            $user_id=$user['id'];
            $user_name=$user['name'];

            $verify=password_verify($password,$oldpassword);
            if($verify){
                $_SESSION['user_id']=$user_id;
                $_SESSION['successLogin']= "welcome " . $user_name;
                header("Location: ../index.php");
                exit();
            }else{
                $_SESSION['error']="wrong password";
                header("Location: ../Login.php");
                exit();
            }
            
        }else{
            $_SESSION['error']="wrong email";
            header("Location: ../Login.php");
            exit();
        }
    }$_SESSION['error']="wrong credentials";
    header("Location: ../Login.php");
    exit();    
}else{
    header("Location: ../Login.php");
}