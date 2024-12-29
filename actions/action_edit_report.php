<?php
session_start();

require_once('../database/appointment.php');
require_once('../database/schedule.php');
require_once('../functions/findPossibleSchedules.php');


$_SESSION['report_clicked']=False;
$appointment_id=$_POST['appointment_id'];
$_SESSION['current_report_id']=$_POST['appointment_id'];

try {
    $dbh = new PDO('sqlite:../sql/database.db');
    $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $report=obterRelatorioConsulta($appointment_id);
    if (trim($report) === "") {
        $_SESSION['report_empty'] = true;  
    } else {
        $_SESSION['report_empty'] = false;
    }
    $_SESSION['report_written']=$report;
    header('Location: ../doutor.php');
    die();
  } catch (PDOException $e) {
    $_SESSION['msg'] = 'Error: ' . $e->getMessage();
  }
  
  header('Location: ../doutor.php');

header('Location: ../doutor.php');
