<?php
session_start();

function fetchExamTech($employee_id)
{
    global $dbh;
    $stmt = $dbh->prepare('
        SELECT 
            et.exam_id,
            et.lab,
            a.appointment_date AS exam_date,
            e.schedule AS exam_schedule,
            p.name AS pacient_name,
            d.name AS doctor_name,
            n.name AS nurse_name
        FROM ExamTech et
        LEFT JOIN Appointments a ON et.appointment = a.appointment_id
        LEFT JOIN Exam e ON et.exam_id = e.appointment
        LEFT JOIN Pacient p ON a.pacient_id = p.pacient_id
        LEFT JOIN Doctor d ON a.doctor_id = d.doctor_id
        LEFT JOIN Nurse n ON a.nurse_id = n.nurse_id
        WHERE et.tech_id = ?
        ORDER BY datetime(e.schedule)
    ');
    $stmt->execute(array($tech_id));
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

try {
    // Conexão com o banco de dados
    $dbh = new PDO('sqlite:../sql/database.db');
    $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtém o ID do paciente da sessão
    $employee_id = $_SESSION['user_id'];

    // Busca os agendamentos do paciente logado
    $exams = fetchExamTech($employee_id);
} catch (PDOException $e) {
    $_SESSION['msg'] = "Erro ao acessar o banco de dados: " . $e->getMessage();
    header("Location: profile.php");
    die();
}
?>