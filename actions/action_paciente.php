<?php
session_start();
require_once('../database/doctor.php');
require_once('../functions/findPossibleSchedules.php');

$data = $_POST['data'];          // Data escolhida
$_SESSION['appointment_data'] = $data;
$especialidade = $_POST['especialidade'];  // Especialidade escolhida



try {
    include_once('../database/init.php');

    $data = obterMedicos($data, $especialidade);

    $timestamps = $_SESSION['timestamps'];
    $grouped = findPossibleSchedules($data, $timestamps);



    $_SESSION['horarios_possiveis'] = $grouped;
    if (empty($_SESSION['horarios_possiveis'])) {
        $_SESSION['msg'] = "Não há consultas disponíveis desta especialidade para este dia.";
    }
    header('Location: ../marcarconsultas.php');
    die();
} catch (PDOException $e) {
    $_SESSION['msg'] = 'Error: ' . $e->getMessage();
}

header('Location: ../loginpage.php');
