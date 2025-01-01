<?php
session_start();
require_once('../database/appointment.php');
require_once('../database/person.php');





try {
    // Conexão com o banco de dados
    include_once('../database/init.php');


    // Obtém o ID do paciente da sessão
    $patient_id = $_SESSION['user_id'];

    // Obtém os detalhes do usuário com base no e-mail
    $userProfile = fetchUserProfile($_SESSION['email']);

    // Busca os agendamentos do paciente logado
    $appointments = fetchAppointments($patient_id);
} catch (PDOException $e) {
    $_SESSION['msg'] = "Erro ao acessar o banco de dados: " . $e->getMessage();
    header("Location: profile.php");
    die();
}
?>