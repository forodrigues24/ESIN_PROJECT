<?php
session_start();
require_once('../database/doctor.php');
require_once('../functions/findPossibleSchedules.php');

$data = $_POST['data'];          // Data escolhida
$_SESSION['appointment_data'] = $data;
$especialidade = $_POST['especialidade'];  // Especialidade escolhida



try {
    $dbh = new PDO('sqlite:../sql/database.db');
    $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $data = obterMedicos($data, $especialidade);
    
    $timestamps = $_SESSION['timestamps'];
    $grouped=findPossibleSchedules($data,$timestamps);
   


    $_SESSION['horarios_possiveis'] = $grouped;

    header('Location: ../marcarconsultas.php');
    die();

} catch (PDOException $e) {
    $_SESSION['msg'] = 'Error: ' . $e->getMessage();
}

header('Location: ../loginpage.php');
