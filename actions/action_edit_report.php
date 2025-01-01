<?php
session_start();

// Para utilizar funções presentes nestes ficheiro
require_once('../database/appointment.php');
require_once('../database/schedule.php');
require_once('../functions/findPossibleSchedules.php');

// Define uma variável de sessão para indicar que o botão de relatório ainda não foi acionado 
$_SESSION['report_clicked']=False;

// Obtém o ID de consulta
$appointment_id=$_POST['appointment_id'];

// Associa ao relatório atual
$_SESSION['current_report_id']=$_POST['appointment_id'];

try {
    // Conexão ao banco de dados
    include_once('../database/init.php');


    $report=obterRelatorioConsulta($appointment_id);

    // Verifica se o relatório está vazio
    if (trim($report) === "") { 
        $_SESSION['report_empty'] = true;  
    } else {
        $_SESSION['report_empty'] = false;
    }

    // Armazena o conteúdo na sessão
    $_SESSION['report_written']=$report;
    header('Location: ../doutor.php');
    die();
  } catch (PDOException $e) { // Em caso de erro
    $_SESSION['msg'] = 'Error: ' . $e->getMessage();
  }
  
  header('Location: ../doutor.php');

header('Location: ../doutor.php');
