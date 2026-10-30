<?php
session_start();
include('validate.php');
require('../db/connection.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $errors=[]; 
    foreach($validates as $validate_name=> $validate_value){
        $value=filter_input(
            INPUT_POST,
            $validate_name,
            $validate_value['filters'],
            $validate_value['myoption']  ?? null
        );

        if(empty($_POST[$validate_name])){
            $errors[$validate_name]= 'you must fill '.$validate_name;
        }else if($value==false){
            $errors[$validate_name]= $validate_value['error'];
        }
    }
    if($errors){
        $_SESSION['errors']=$errors;
        header("Location:../register.php");
        exit();
    }
    $name=$_POST['name'];
    $email=$_POST['email'];
    $hashpassword=password_hash($_POST['password'],PASSWORD_DEFAULT);
    $phone=$_POST['phone'];
    $check = "SELECT * FROM users WHERE email = '$email'";
$checkResult = mysqli_query($connect, $check);

if (mysqli_num_rows($checkResult) > 0) {
    $_SESSION['errors'] = ['This email already exists'];
    header("Location: ../register.php");
    exit();
}

    $query="INSERT INTO users(name,email,password,phone) VALUES('$name','$email','$hashpassword','$phone')";
    $result=mysqli_query($connect,$query);
    if($result){
        $_SESSION['successRegister']="register success";
        header("Location:../login.php");
        exit();
    }else{
        header("Location:../register.php");
    }
      
}else{
    header("Location:../register.php");
}    