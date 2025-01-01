<?php

session_start();

// Para usar funções destes ficheiros
require_once('../database/person.php');
require_once('../database/appointment.php');
require_once('../functions/findPossibleSchedules.php');
require_once('../database/doctor.php');

// Pega o ID do médico e o horário
$medico_id = key($_POST['horario']); // Pega a chave (ID do médico)
$horario = $_POST['horario'][$medico_id]; // Pega o valor (horário)
$patient_id = $_SESSION['person_id']; // Pega o ID do paciente, ou seja, o ID da pessoa que está a marcar a consulta
$appointment_data = $_SESSION['appointment_data']; // Pega a data da consulta


try {

    // Conexão com o banco de dados
    include_once('../database/init.php');

    // Marca a consulta e verifica se foi bem sucedido 
    $flag=marcarConsulta($medico_id, $horario, $patient_id, $appointment_data);
    if($flag) {
        $_SESSION['msg'] = 'Consulta Adicionada';
    }
    else{
        $_SESSION['msg'] = 'Erro ao Adicionar a Consulta';
    }

    // Atualiza a informação do médico escolhido e obtém os horários possíveis
    $data = obterMedicos($data, $especialidade);
    $timestamps = $_SESSION['timestamps'];
    $grouped=findPossibleSchedules($data,$timestamps);
    $_SESSION['appointments']=fetchAppointments($_SESSION['person_id']);
    $_SESSION['horarios_possiveis'] = $grouped;
    
    unset($_SESSION['horarios_possiveis']);
    header('Location: ../marcarconsultas.php');
    die();
  } catch (PDOException $e) {  // Em caso de erro
    $_SESSION['msg'] = 'Error: ' . $e->getMessage();
  }
  
  header('Location: ../marcarconsultas.php');

?>
