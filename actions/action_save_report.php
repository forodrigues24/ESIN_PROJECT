<?php
session_start();
 
// Para usar funções destes ficheiros
require_once('../database/appointment.php');
require_once('../database/schedule.php');
require_once('../functions/findPossibleSchedules.php');

// Relatório foi enviado
$_SESSION['report_clicked']=True;

// Obtém informação relacionada com o relatório
$appointment_id=$_SESSION['current_report_id'];
$report_content = $_POST['report'];
try {

    // Conexão com o banco de dados
    include_once('../database/init.php');

    // Atualiza o relatório
    $flag=atualizarRelatorio($appointment_id, $report_content);

    // Verifica se tbe sucesso
    if ($flag) {
        $_SESSION['msg'] ='O relatório foi adicionado!';
    }

    else {
        $_SESSION['msg'] ='O relatório não foi adicionado!';
    }

    header('Location: ../doutor.php');
    die();
  } catch (PDOException $e) {
    $_SESSION['msg'] = 'Error: ' . $e->getMessage();
  }
  
  header('Location: ../doutor.php');
