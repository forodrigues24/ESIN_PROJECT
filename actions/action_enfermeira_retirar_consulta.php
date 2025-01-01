<?php
session_start();

// Para utilizar funções presentes nestes ficheiro
require_once('../database/appointment.php');
require_once('../database/schedule.php');
require_once('../functions/findPossibleSchedules.php');

// Obtém os valores enviados no formulário
$data = $_POST['appointment_date'];
$appointment_id = $_POST['appointment_id'];
$nurse_id = $_SESSION['person_id'];

try {

    // Conexão ao banco de dados
    include_once('../database/init.php');

    // Remove este perfil de enfermeiro da consulta
    $flag=removeNurse($appointment_id);

    // Determina se foi ou não removida da consulta
    if ($flag) {
        $_SESSION['msg'] ='Foi removida da consulta!';
    }

    else {
        $_SESSION['msg'] ='Não foi removida consulta!';
    }

    // Encontra enfermeiros com disponibilidade para este horário
    findPossibleSchedulesNurse($nurse_id,$data);

    header('Location: ../enfermeira.php');
    die();
  } catch (PDOException $e) { // Em caso de erro
    $_SESSION['msg'] = 'Error: ' . $e->getMessage();
  }
  
  header('Location: ../enfermeira.php');
  