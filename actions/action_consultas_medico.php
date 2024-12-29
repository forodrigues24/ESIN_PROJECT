<?php
session_start();

require_once('../database/appointment.php');
require_once('../database/schedule.php');
require_once('../functions/findPossibleSchedules.php');

$_SESSION['report_clicked']=True;

if (isset($_POST['data'])) {
    $data = $_POST['data'];
}
$id = $_SESSION['person_id'];

try {
    // Conexão com o banco de dados
    $dbh = new PDO('sqlite:../sql/database.db');
    $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obter as consultas e o horário de trabalho
    $dados=obterConsultasMedicoPorIdData($id, $data);
    
    if (empty($dados)) {
        $_SESSION['msg'] = 'Não tem consultas para este dia';
    } 


    $_SESSION['consultas_doutor']= $dados;


    header('Location: ../doutor.php');
    exit();
} catch (PDOException $e) {
    $_SESSION['msg'] = 'Error: ' . $e->getMessage();
} catch (Exception $e) {
    $_SESSION['msg'] = 'Error: ' . $e->getMessage();
}

header('Location: ../doutor.php');
exit();
