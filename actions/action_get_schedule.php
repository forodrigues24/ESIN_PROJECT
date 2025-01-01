<?php
session_start();

// Para utilizar funções presentes nestes ficheiro
require_once('../database/person.php');
require_once('../database/schedule.php');


if (isset($_POST['data']) && $_POST['data'] !== null) {
  $data = $_POST['data'];
}
$id=$_SESSION['person_id'];

try {

    // Conexão ao banco de dados
    include_once('../database/init.php');

    // Obter horário associado a este ID
    $horario=obterHorarioIdData($id,$data);
    $_SESSION['horario']=$horario;

    // Caso ainda não tenha horário associado
    if ($_SESSION['horario'][0]['Entrada'] == null) {
        $_SESSION['msg2'] ='Horário não disponível. Contacte a secretária.';
    }
    header('Location: ../profile.php');
    die();
  } catch (PDOException $e) { // Em caso de erro
    $_SESSION['msg'] = 'Error: ' . $e->getMessage();
  }
  
  header('Location: ../loginpage.php');
  