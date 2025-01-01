<?php
session_start();

// Para utilizar funções destes ficheiros
require_once('../database/person.php');
require_once('../database/appointment.php');

require_once('../database/schedule.php');


// Obtém os dados do formulário
$email = $_POST['email'];
$password = $_POST['password'];


try {

  // Conexão ao banco de dados
  include_once('../database/init.php');

  // Realiza o login e verifica se teve sucesso
  $userData = loginSuccess($email, $password);
  
  if ($userData) { // Caso o login tenha sido bem sucedido
    $_SESSION['person_id']=$userData['person_id'];
    $_SESSION['role_user']=checkRole($_SESSION['person_id']);

    // Confirma a informação deste perfil
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

  } else { // Caso o login não tenha sido bem sucedido
    $_SESSION['msg'] = 'Invalid username or password!';
  }
} catch (PDOException $e) { // Em caso de erro
  $_SESSION['msg'] = 'Error: ' . $e->getMessage();
}

header('Location: ../loginpage.php');
