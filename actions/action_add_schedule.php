<?php
session_start();

// Para utilizar funções presentes neste ficheiro
require_once('../database/schedule.php'); 

// Obtém os valores enviados pelo formulário
$person_id = $_POST['person_id']; 
$update_flag = $_POST['update_flag'];
$time_block_1 = $_POST['time_block_1'];
$time_block_2 = $_POST['time_block_2'];
$data = $_SESSION['data']; 


$time_1 = strtotime($time_block_1);
$time_2 = strtotime($time_block_2);

// Verificando se a hora de entrada é menor que a de saída
if ($time_1 >= $time_2) {
    $_SESSION['msg'] = 'Hora de entrada tem de ser menor que a de saída.';
    header('Location: ../secretaria.php');
    die();
}


try {
  // Conectando-se ao banco de dados
  include_once('../database/init.php');

  // Atualiza ou associa o horário a esse perfil
  if (isset($update_flag) && $update_flag === 'True') {
    $success = updateSchedule($person_id, $data, $time_block_1, $time_block_2);
  
  } else {
    $success = addSchedule($person_id, $data, $time_block_1, $time_block_2);

  }
  // Verifica se o agendamento foi adicionado com sucesso
  if ($success) {
    $_SESSION['msg'] = 'Horário adicionado com sucesso!';

    // Obtém as pessoas sem horário e as pessoas com horário
    $semHorario = obterPessoasSemHorario($data);
    $comHorario = obterPessoasComHorario($data);

    // Obtém os papéis das pessoas sem horário
    $roles = findRole($semHorario);
    
    foreach ($semHorario as $key => $person) {
      $semHorario[$key]['role'] = $roles[$key]['role'];
    }

    // Obtém os papéis das pessoas com horário
    $roles2 = findRole($comHorario);
    foreach ($comHorario as $key => $person) {
      $comHorario[$key]['role'] = $roles2[$key]['role'];
    }


    $_SESSION['semHorario'] = $semHorario;
    $_SESSION['comHorario'] = $comHorario;
  } else { // Em caso de erro
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
