<?php
session_start();
require_once('../database/person.php');


// get username and password from HTTP parameters
$email = $_POST['email'];
$password = $_POST['password'];

// check if username and password are correct
function loginSuccess($email, $password)
{
  global $dbh;
  $stmt = $dbh->prepare('SELECT * FROM Person WHERE email_address = ? AND password = ?');
  $stmt->execute(array($email, hash('sha256', $password)));
  return $stmt->fetch();
}



try {
  $dbh = new PDO('sqlite:../sql/database.db');
  $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $userData = loginSuccess($email, $password);
  if ($userData) {
    $_SESSION['person_id']=$userData['person_id'];
    $_SESSION['role']=checkRole($_SESSION['person_id']);
    $_SESSION['email'] = $email;
    $_SESSION['name'] = $userData['name'];
    $_SESSION['age'] = $userData['age'];
    $_SESSION['address'] = $userData['address'];
    $_SESSION['phone_number'] = $userData['phone_number'];
    $_SESSION['msg'] = 'Login Sucessfull!';
    $_SESSION['password']= $userData['password'];
    $_SESSION['appointments']=fetchAppointments($_SESSION['person_id']);
    
    header('Location: ../index.php');
    die();

  } else {
    $_SESSION['msg'] = 'Invalid username or password!';
  }
} catch (PDOException $e) {
  $_SESSION['msg'] = 'Error: ' . $e->getMessage();
}

header('Location: ../loginpage.php');
