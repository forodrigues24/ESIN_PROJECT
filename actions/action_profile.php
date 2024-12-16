<?php
session_start();

function fetchUserProfile($email)
{
    global $dbh;
    $stmt = $dbh->prepare('
        SELECT 
            person_id,
            name,
            age,
            email_address,
            address,
            phone_number
        FROM Person
        WHERE email_address = ?
    ');
    $stmt->execute(array($email));
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function fetchAppointments($patient_id)
{
    global $dbh;
    $stmt = $dbh->prepare('
        SELECT 
            a.appointment_id,
            a.schedule,
            a.report,
            d.name AS doctor_name,
            n.name AS nurse_name,
            s.name AS secretary_name
        FROM Appointments a
        LEFT JOIN Doctors d ON a.doctor_id = d.doctor_id
        LEFT JOIN Nurses n ON a.nurse_id = n.nurse_id
        LEFT JOIN Secretaries s ON a.secretary_id = s.secretary_id
        WHERE a.patient_id = ?
        ORDER BY datetime(a.schedule)
    ');
    $stmt->execute(array($patient_id));
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

try {
    // Conexão com o banco de dados
    $dbh = new PDO('sqlite:../sql/database.db');
    $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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