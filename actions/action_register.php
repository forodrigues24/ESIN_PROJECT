<?php
  session_start();
  require_once('../database/person.php');

  $name = $_POST['name'];
  $age = $_POST['age'];
  $email = $_POST['email'];
  $address = $_POST['address'];
  $phone = $_POST['phone'];
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];

  if ($password !== $confirm_password) {
    // Redireciona para a página de registro com uma mensagem de erro
    $_SESSION['msg'] = 'Passwords dont match';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    die();
  }

  if (
    strlen($password) < 8 ||                // Verifica o comprimento
    !preg_match('/[A-Z]/', $password) ||    // Pelo menos uma letra maiúscula
    !preg_match('/[0-9]/', $password) ||    // Pelo menos um número
    !preg_match('/[\W_]/', $password)       // Pelo menos um símbolo
) {
    $_SESSION['msg'] = 'Password must have at least 8 characters, one uppercase letter, one number, and one special character.';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    die();
}
 
  try {
    include_once('../database/init.php');


    insertUser($name,$age,$email,$address,$phone,$password);
    $id=getPersonDataByEmail($email)['person_id'];
    insertPatient($id);
    
    $_SESSION['msg'] = 'Registration successful!';
    header('Location: ../index.php');
  } catch (PDOException $e) {
    $error_msg = $e->getMessage();

    if (strpos($error_msg, 'UNIQUE')) {
      $_SESSION['msg'] = 'Email already exists!';
    } else {
      $_SESSION['msg'] = "Registration failed! ($error_msg)";
    }
    header('Location: ' . $_SERVER['HTTP_REFERER']);
  }
?>