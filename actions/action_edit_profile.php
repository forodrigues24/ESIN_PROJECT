<?php
session_start();
require_once('../database/person.php');

// Obtém os dados do formulário
$id=$_SESSION['person_id'];
$email = $_SESSION['email']; 
$name = $_POST['name'];
$age = $_POST['age'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];


if (!empty($password) && $password !== $confirm_password) {
    $_SESSION['msg'] = 'Passwords do not match';
    header('Location: ../edit_profile.php');
    exit();
}

// Valida os campos antes de atualizar
if (empty($name)) {
    $name = $_SESSION['name'];
}

if (empty($age)) {
    $age = $_SESSION['age'];
}

if (empty($address)) {
    $address = $_SESSION['address'];
}

if (empty($phone)) {
    $phone = $_SESSION['phone_number'];
}



try {
    $dbh = new PDO('sqlite:../sql/database.db');
    $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verifica se o número de telefone já está em uso por outro usuário
    if (isPhoneUsed($phone, $_SESSION['id'])) {
        $_SESSION['msg'] = 'The phone number is already in use by another user.';
        header('Location: ../edit_profile.php');
        exit();
    }

    // Atualiza o perfil do usuário
    updateUser($_SESSION['id'], $name, $age, $address, $phone, $password);

    $_SESSION['msg'] = 'Profile updated successfully!';
    $_SESSION['name'] = $name;
    $_SESSION['age'] =$age;
    $_SESSION['address'] =$address;
    $_SESSION['phone_number'] =$phone;
    $_SESSION['password'] =$password;
    header('Location: ../profile.php');
    exit();

} catch (PDOException $e) {
    // Se ocorrer um erro, captura a mensagem de erro e redireciona
    $error_msg = $e->getMessage();
    $_SESSION['msg'] = "Profile update failed! ($error_msg)";
    header('Location: ../edit_profile.php');
    exit();
}
