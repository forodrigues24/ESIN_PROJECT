<?php

// Função para marcar consulta
function marcarConsulta($medico_id, $horario, $patient_id, $appointment_data)
{
    global $dbh;

    try {
        $stmt = $dbh->prepare('
            INSERT INTO Appointment (patient_id, doctor_id, time_block, appointment_date,report) 
            VALUES (?, ?, ?, ?,?)
        ');

        $stmt->execute(array($patient_id, $medico_id, $horario, $appointment_data,''));
        return True;
    } catch (PDOException $e) {
        return "Erro ao adicionar agendamento: " . $e->getMessage();
    }
}

// Função para ver as consultas que não têm enfermeira atribuída

function consultasSemEnfermeira($data) {
    global $dbh;

    try {
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
        
        $stmt->execute(array($data));
         
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        return "Erro ao buscar consultas sem enfermeira: " . $e->getMessage();
    }
}

// Função para adicionar a enfermeira a uma consulta

function addNurse($appointment_id, $nurse_id)
{
    global $dbh;

    try {
        $stmt = $dbh->prepare('
            UPDATE Appointment 
            SET nurse_id = ? 
            WHERE appointment_id = ?
        ');

        $stmt->execute(array($nurse_id, $appointment_id));
        return True;
    } catch (PDOException $e) {
        return "Erro ao adicionar enfermeira: " . $e->getMessage();
    }
}

// Função para retirar a enfermeira da consulta

function removeNurse($appointment_id)
{
    global $dbh;

    try {
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

// Função para atualizar o relatório da consulta

function atualizarRelatorio($appointment_id, $report_content) {
    global $dbh;

    try {
        $stmt = $dbh->prepare('
            UPDATE Appointment 
            SET report = ? 
            WHERE appointment_id = ?
        ');

        $stmt->execute(array($report_content, $appointment_id));
        
        return true;  // Retorna true se a operação for bem-sucedida
    } catch (PDOException $e) {
        return "Erro ao atualizar relatório: " . $e->getMessage();
    }
}

// Função para obter o relatório atual da consulta

function obterRelatorioConsulta($appointment_id) {
    global $dbh;

    try {
        $stmt = $dbh->prepare('
            SELECT report 
            FROM Appointment 
            WHERE appointment_id = ? 
        ');

        $stmt->execute(array($appointment_id));

        return $stmt->fetchColumn();
        
    } catch (PDOException $e) {
        return "Erro ao buscar relatório da consulta: " . $e->getMessage();
    }
}

// Obter as consultas de um paciente usando o seu id
function fetchAppointments($patient_id)
{
    global $dbh;
    $stmt = $dbh->prepare('
        SELECT 
            a.appointment_id,
            dp.name AS "Doutor",
            np.name AS "Enfermeiro",
            a.appointment_date AS "Data da Consulta",
            a.time_block AS "Hora",
            a.report AS "Relatório"
        FROM 
            Appointment a
        JOIN 
            TimeStamps USING(time_block)
        JOIN 
            Doctor d ON a.doctor_id = d.employee_id
        JOIN 
            Person dp ON d.employee_id = dp.person_id
        LEFT JOIN 
            Nurse n ON a.nurse_id = n.employee_id
        LEFT JOIN 
            Person np ON n.employee_id = np.person_id
        WHERE 
            a.patient_id = ?
        ORDER BY 
            a.appointment_date DESC, a.time_block DESC
    ');
    $stmt->execute(array($patient_id));
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>