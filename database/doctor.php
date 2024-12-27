<?php

function obterMedicos($data, $especialidade)
{
    global $dbh;

    // A consulta SQL com as correções
    $stmt = $dbh->prepare('
        SELECT 
            d.employee_id AS id, 
            p.name AS nome, 
            d.specialty AS especialidade,
            a.time_block AS horario,
            es.start_time AS entrada,
            es.end_time AS saida
        FROM 
            Appointment a
        JOIN 
            Doctor d ON a.doctor_id = d.employee_id
        JOIN 
            Person p ON p.person_id = d.employee_id
        LEFT JOIN 
            EmployeeSchedule es ON d.employee_id = es.employee_id AND es.date = ?  -- Corrigido o LEFT JOIN
        WHERE 
            d.specialty = ?  -- Corrigido a condição de especialidade
        AND 
            a.appointment_date = ?  -- Corrigido a data de agendamento
    ');

    // Substituindo os pontos de interrogação pelos valores reais
    $stmt->execute(array($data, $especialidade, $data));

    // Obtendo os resultados
    return $stmt->fetchAll();
}

?>
