<?php
session_start();

// Para usar funções destes ficheiros
require_once('../database/person.php');
require_once('../database/schedule.php');

if (isset($_POST['data']) && $_POST['data'] !== null) {
  $data = $_POST['data'];
}

try {

  // Conexão com o banco de dados
  include_once('../database/init.php');

  // Obter pessoas sem e com horário
  $semHorario=obterPessoasSemHorario($data);
  $comHorario=obterPessoasComHorario($data);

  // Encontrar papel dos perfis
  $roles=findRole($semHorario);
  foreach ($semHorario as $key => $person) {
    $semHorario[$key]['role'] = $roles[$key]['role'];
  }
  $roles2=findRole($comHorario);
  foreach ($comHorario as $key => $person) {
    $comHorario[$key]['role'] = $roles2[$key]['role'];
  }


  $_SESSION['semHorario'] = $semHorario;
  $_SESSION['comHorario'] = $comHorario;


  header('Location: ../secretaria.php');
  die();
} catch (PDOException $e) { // Em caso de erro
  $_SESSION['msg'] = 'Error: ' . $e->getMessage();
}

header('Location: ../loginpage.php');
