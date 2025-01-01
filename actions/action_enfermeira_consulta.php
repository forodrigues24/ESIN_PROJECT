<?php
session_start();

// Para utilizar funções presentes nestes ficheiro
require_once('../database/appointment.php');
require_once('../database/schedule.php');
require_once('../functions/findPossibleSchedules.php');

// Obtém os valores enviados no formulário
$appointment_id = $_POST['appointment_id'];
$nurse_id = $_SESSION['person_id'];
$data = $_POST['appointment_date'];


try {

    // Conexão ao banco de dados
    include_once('../database/init.php');

    // Asssocia este perfil de enfermeiro à consulta
    $flag=addNurse($appointment_id, $nurse_id);

    // Determina se foi ou não atribuida à consulta
    if ($flag) {
        $_SESSION['msg'] ='Foi atribuida à consulta!';
    }
    else {
        $_SESSION['msg'] ='Não foi atribuida à consulta!';
    }

    // Encontra enfermeiros com disponibilidade para este horário
    findPossibleSchedulesNurse($nurse_id,$data);

    header('Location: ../enfermeira.php');
    die();
  } catch (PDOException $e) { // Em caso de erro
    $_SESSION['msg'] = 'Error: ' . $e->getMessage();
  }
  
  header('Location: ../enfermeira.php');
  