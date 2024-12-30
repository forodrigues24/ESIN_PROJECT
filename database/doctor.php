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
        EmployeeSchedule es
    LEFT JOIN 
        Doctor d ON es.employee_id = d.employee_id
    LEFT JOIN 
        Person p ON p.person_id = d.employee_id
    LEFT JOIN 
        Appointment a ON a.doctor_id = d.employee_id AND a.appointment_date = es.date
    WHERE 
        d.specialty = ?  
    AND 
        es.date = ?  
');

    // Substituindo os pontos de interrogação pelos valores reais
    $stmt->execute(array($especialidade,$data));

    // Obtendo os resultados
    return $stmt->fetchAll();
}

?>
