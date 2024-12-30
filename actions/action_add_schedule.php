<?php
session_start();
require_once('../database/schedule.php');
$person_id = $_POST['person_id'];
$update_flag = $_POST['update_flag'];
$time_block_1 = $_POST['time_block_1'];
$time_block_2 = $_POST['time_block_2'];
$data = $_SESSION['data']; 


try {
  // Conectando-se ao banco de dados
  include_once('../database/init.php');



  if (isset($update_flag) && $update_flag === 'True') {
    $success = updateSchedule($person_id, $data, $time_block_1, $time_block_2);
  
  } else {
    $success = addSchedule($person_id, $data, $time_block_1, $time_block_2);

  }
  // Verifica se o agendamento foi adicionado com sucesso
  if ($success) {
    $_SESSION['msg'] = 'Horário adicionado com sucesso!';

    $semHorario = obterPessoasSemHorario($data);
    $comHorario = obterPessoasComHorario($data);
    $roles = findRole($semHorario);
    
    foreach ($semHorario as $key => $person) {
      $semHorario[$key]['role'] = $roles[$key]['role'];
    }

    $roles2 = findRole($comHorario);
    foreach ($comHorario as $key => $person) {
      $comHorario[$key]['role'] = $roles2[$key]['role'];
    }

    $_SESSION['semHorario'] = $semHorario;
    $_SESSION['comHorario'] = $comHorario;
  } else {
    $_SESSION['msg'] = 'Falha ao adicionar o horário!';
  }


  // Redireciona para a página de secretaria após o processo
  header('Location: ../secretaria.php');
  die();
} catch (PDOException $e) {
  // Caso haja erro na conexão com o banco, exibe a mensagem de erro
  $_SESSION['msg'] = 'Erro: ' . $e->getMessage();
  header('Location: ../loginpage.php');
  die();
}
