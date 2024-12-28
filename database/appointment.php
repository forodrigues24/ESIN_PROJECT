<?php
    
function marcarConsulta($medico_id, $horario, $patient_id, $appointment_data)
{
    // Acesso ao banco de dados - Presumindo que a variável $dbh esteja definida
    global $dbh;

    try {
        // Iniciar transação para garantir a consistência dos dados
        $stmt = $dbh->prepare('
            INSERT INTO Appointment (patient_id, doctor_id, time_block, appointment_date,report) 
            VALUES (?, ?, ?, ?,?)
        ');

        $stmt->execute(array($patient_id, $medico_id, $horario, $appointment_data,''));
        return True;
    } catch (PDOException $e) {
        // Em caso de erro, retorna uma mensagem de erro
        return "Erro ao adicionar agendamento: " . $e->getMessage();
    }
}
function consultasSemEnfermeira($data) {
    global $dbh;

    try {
        // Preparar a consulta SQL para buscar as consultas sem enfermeira
        $stmt = $dbh->prepare('
        SELECT 
            a.appointment_id AS appointment_id,
            a.appointment_date AS date, 
            a.time_block AS time, 
            person_doctor.name AS doctor_name,
            doc.specialty AS doctor_specialty,
            p.name AS patient_name,
            p.age AS patient_age
        FROM 
            Appointment a
        JOIN 
            Patient pt ON a.patient_id = pt.patient_id
        JOIN 
            Person p ON pt.patient_id = p.person_id  -- Nome do paciente
        JOIN 
            Doctor doc ON a.doctor_id = doc.employee_id
        JOIN 
            Person person_doctor ON doc.employee_id = person_doctor.person_id  -- Nome do médico
        LEFT JOIN 
            Nurse n ON a.nurse_id = n.employee_id
        WHERE 
            a.nurse_id IS NULL AND a.appointment_date = ?
    ');
        
        // Executar a consulta
        $stmt->execute(array($data));
         
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        // Em caso de erro, retorna uma mensagem de erro
        return "Erro ao buscar consultas sem enfermeira: " . $e->getMessage();
    }
}

    
function addNurse($appointment_id, $nurse_id)
{
    // Acesso ao banco de dados - Presumindo que a variável $dbh esteja definida
    global $dbh;

    try {
        // Atualizar o campo nurse_id da consulta existente
        $stmt = $dbh->prepare('
            UPDATE Appointment 
            SET nurse_id = ? 
            WHERE appointment_id = ?
        ');

        $stmt->execute(array($nurse_id, $appointment_id));
        return True;
    } catch (PDOException $e) {
        // Em caso de erro, retorna uma mensagem de erro
        return "Erro ao adicionar enfermeira: " . $e->getMessage();
    }
}

function removeNurse($appointment_id)
{
    // Acesso ao banco de dados - Presumindo que a variável $dbh esteja definida
    global $dbh;

    try {
        // Atualizar o campo nurse_id para NULL da consulta existente
        $stmt = $dbh->prepare('
            UPDATE Appointment 
            SET nurse_id = NULL 
            WHERE appointment_id = ?
        ');

        $stmt->execute(array($appointment_id));
        return true;  // Retorna true se a operação for bem-sucedida
    } catch (PDOException $e) {
        // Em caso de erro, retorna uma mensagem de erro
        return "Erro ao remover enfermeira: " . $e->getMessage();
    }
}



?>