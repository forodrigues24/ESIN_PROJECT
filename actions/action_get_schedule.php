<?php
session_start();
require_once('../database/person.php');
require_once('../database/schedule.php');

if (isset($_POST['data']) && $_POST['data'] !== null) {
  $data = $_POST['data'];
}
$id=$_SESSION['person_id'];

try {
    $dbh = new PDO('sqlite:../sql/database.db');
    $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $horario=obterHorarioIdData($id,$data);
    $_SESSION['horario']=$horario;

    if ($_SESSION['horario'][0]['Entrada'] == null) {
        $_SESSION['msg2'] ='Horário não disponível. Contacte a secretária.';
    }
    header('Location: ../profile.php');
    die();
  } catch (PDOException $e) {
    $_SESSION['msg'] = 'Error: ' . $e->getMessage();
  }
  
  header('Location: ../loginpage.php');
  