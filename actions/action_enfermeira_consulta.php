<?php
session_start();

require_once('../database/appointment.php');
require_once('../database/schedule.php');

require_once('../functions/findPossibleSchedules.php');


$appointment_id = $_POST['appointment_id'];
$nurse_id = $_SESSION['person_id'];
$data = $_POST['appointment_date'];


try {
    include_once('../database/init.php');

    $flag=addNurse($appointment_id, $nurse_id);
    if ($flag) {
        $_SESSION['msg'] ='Foi atribuida à consulta!';
    }

    else {
        $_SESSION['msg'] ='Não foi atribuida à consulta!';
    }
    findPossibleSchedulesNurse($nurse_id,$data);

    header('Location: ../enfermeira.php');
    die();
  } catch (PDOException $e) {
    $_SESSION['msg'] = 'Error: ' . $e->getMessage();
  }
  
  header('Location: ../enfermeira.php');
  