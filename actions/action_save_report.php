<?php
session_start();

require_once('../database/appointment.php');
require_once('../database/schedule.php');
require_once('../functions/findPossibleSchedules.php');


$_SESSION['report_clicked']=True;

$appointment_id=$_SESSION['current_report_id'];
$report_content = $_POST['report'];
try {
    $dbh = new PDO('sqlite:../sql/database.db');
    $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $flag=atualizarRelatorio($appointment_id, $report_content);

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
