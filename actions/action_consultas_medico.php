<?php
session_start();

// Para utilizar funções presentes nestes ficheiro
require_once('../database/appointment.php');
require_once('../database/schedule.php');
require_once('../functions/findPossibleSchedules.php');

$_SESSION['report_clicked']=True;

if (isset($_POST['data'])) {
    $data = $_POST['data'];
}
$id = $_SESSION['person_id'];

try {
    include_once('../database/init.php');


    // Obter as consultas e o horário de trabalho
    $dados=obterConsultasMedicoPorIdData($id, $data);
    
    if (empty($dados)) { // Caso não tenha consultas
        $_SESSION['msg'] = 'Não tem consultas para este dia';
    } 

    // Dados ficam gravados
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
