<?php
session_start();
require_once('../database/person.php');
require_once('../database/schedule.php');

if (isset($_POST['data']) && $_POST['data'] !== null) {
  $data = $_POST['data'];
}

try {
  include_once('../database/init.php');


  $semHorario=obterPessoasSemHorario($data);
  $comHorario=obterPessoasComHorario($data);
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
} catch (PDOException $e) {
  $_SESSION['msg'] = 'Error: ' . $e->getMessage();
}

header('Location: ../loginpage.php');
