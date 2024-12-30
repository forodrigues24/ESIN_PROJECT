<?php
session_start();
require_once('../database/person.php');
require_once('../database/schedule.php');


// get username and password from HTTP parameters
$email = $_POST['email'];
$password = $_POST['password'];


try {
  include_once('../database/init.php');


  $userData = loginSuccess($email, $password);
  
  if ($userData) {
    $_SESSION['person_id']=$userData['person_id'];
    $_SESSION['role_user']=checkRole($_SESSION['person_id']);
    

    $_SESSION['email'] = $email;
    $_SESSION['name'] = $userData['name'];
    $_SESSION['age'] = $userData['age'];
    $_SESSION['address'] = $userData['address'];
    $_SESSION['phone_number'] = $userData['phone_number'];
    $_SESSION['msg'] = 'Login Sucessfull!';
    $_SESSION['password']= $userData['password'];
    $_SESSION['appointments']=fetchAppointments($_SESSION['person_id']);
    $_SESSION['timestamps']=getTimeStamps();

    header('Location: ../index.php');
    die();

  } else {
    $_SESSION['msg'] = 'Invalid username or password!';
  }
} catch (PDOException $e) {
  $_SESSION['msg'] = 'Error: ' . $e->getMessage();
}

header('Location: ../loginpage.php');
