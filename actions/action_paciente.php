<?php
session_start();

// Para utilizar funções destes ficheiros
require_once('../database/doctor.php');
require_once('../functions/findPossibleSchedules.php');

// Obtém informação do formulário
$data = $_POST['data'];          // Data escolhida
$_SESSION['appointment_data'] = $data;
$especialidade = $_POST['especialidade'];  // Especialidade escolhida



try {

    // Conexão com o banco de dados
    include_once('../database/init.php');

    // Obtém os médicos dessa especialidade, disponíveis nessa data
    $data = obterMedicos($data, $especialidade);

    // Mostra os horários possíveis dos médicos
    $timestamps = $_SESSION['timestamps'];
    $grouped = findPossibleSchedules($data, $timestamps);

    // Caso não haja nenhuma vaga
    $_SESSION['horarios_possiveis'] = $grouped;
    if (empty($_SESSION['horarios_possiveis'])) {
        $_SESSION['msg'] = "Não há consultas disponíveis desta especialidade para este dia.";
    }
    header('Location: ../marcarconsultas.php');
    die();
} catch (PDOException $e) { // Em caso de erro
    $_SESSION['msg'] = 'Error: ' . $e->getMessage();
}

header('Location: ../loginpage.php');
