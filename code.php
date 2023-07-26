<?php
session_start();
include('dbcon.php');

function sendemail_verify("$name","$email","$verify_token");
{

}

if(isset($_POST['register_btn']))
{
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $verify_token = md5(rand());

    // Email Exists or Not 
    $check_email_query = "SELECT email FROM users WHERE email='$email' LIMIT 1 ";
    $check_email_query_run = mysqli_query($con, $check_email_query);

    if(mysqli_num_rows($check_email_query_run) > 0)
    {
        $_SESSION['status'] = "Email ID Already Exists";
        header("Location: register.php");
    }
    else
    {
        // Insert User / Registered User Data 
        $query = "INSERT INTO users (name,phone,email,password,verify_token) VALUES ('$name','$phone','$password','$verify_token')";
        $query_run = mysqli_query($con, $query);

        if($query_run)
        {
            sendemail_verify("$name","$email","$verify_token");
            $_SESSION['status'] = "Registration Succcessful.! Please verify your Email Address";
            header("Location: register.php");

        }
        else
        {
            $_SESSION['status'] = "Registeration Failed";
            header("Location: register.php");
        }
    }

}

?>