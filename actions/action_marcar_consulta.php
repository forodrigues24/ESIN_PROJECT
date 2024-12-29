<?php

session_start();
require_once('../database/person.php');
require_once('../database/appointment.php');
require_once('../functions/findPossibleSchedules.php');
require_once('../database/doctor.php');

// Pega o ID do médico e o horário
$medico_id = key($_POST['horario']); // Pega a chave (ID do médico)
$horario = $_POST['horario'][$medico_id]; // Pega o valor (horário)
$patient_id = $_SESSION['person_id'];
$appointment_data = $_SESSION['appointment_data'];


try {
    $dbh = new PDO('sqlite:../sql/database.db');
    $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $flag=marcarConsulta($medico_id, $horario, $patient_id, $appointment_data);
    if($flag) {
        $_SESSION['msg'] = 'Consulta Adicionada';
    }
    else{
        $_SESSION['msg'] = 'Erro ao Adicionar a Consulta';
    }

    $data = obterMedicos($data, $especialidade);
    $timestamps = $_SESSION['timestamps'];
    $grouped=findPossibleSchedules($data,$timestamps);

    $_SESSION['appointments']=fetchAppointments($_SESSION['person_id']);
    $_SESSION['horarios_possiveis'] = $grouped;
    
    unset($_SESSION['horarios_possiveis']);
    header('Location: ../marcarconsultas.php');
    die();
  } catch (PDOException $e) {
    $_SESSION['msg'] = 'Error: ' . $e->getMessage();
  }
  
  header('Location: ../enfermeira.php');

?>
