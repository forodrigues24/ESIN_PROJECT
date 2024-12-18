<?php
session_start();


function fetchAppointments($patient_id)
{   
    global $dbh;
    $stmt = $dbh->prepare('
        SELECT 
            a.appointment_id,
            dp.name AS doctor_name,
            np.name AS nurse_name,
            sp.name AS secretary_name,
            s.day AS consultation_day,
            s.start_time AS consultation_start_time,
            a.report AS consultation_report
        FROM 
            Appointment a
        JOIN 
            Schedule s ON a.schedule = s.schedule_id
        JOIN 
            Doctor d ON a.doctor_id = d.employee_id
        JOIN 
            Person dp ON d.employee_id = dp.person_id
        LEFT JOIN 
            Nurse n ON a.nurse_id = n.employee_id
        LEFT JOIN 
            Person np ON n.employee_id = np.person_id
        LEFT JOIN 
            Secretary sec ON a.secretary_id = sec.employee_id
        LEFT JOIN 
            Person sp ON sec.employee_id = sp.person_id
        WHERE 
            a.patient_id = ?
        ORDER BY 
            s.day, s.start_time
    ');
    $stmt->execute(array($patient_id));
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

try {
    // Conexão com o banco de dados
    $dbh = new PDO('sqlite:../sql/database.db');
    $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $patient_id = $_SESSION['user_id'];

    // Busca os agendamentos do paciente logado
    $appointments = fetchAppointments($patient_id);
} catch (PDOException $e) {
    $_SESSION['msg'] = "Erro ao acessar o banco de dados: " . $e->getMessage();
    header("Location:../ profile.php");
    die();
}

?>