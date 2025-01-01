<?php

// Obtem todos os timestamps da clinica
function getTimeStamps()
{
  global $dbh;
  $stmt = $dbh->prepare('SELECT * FROM TimeStamps');
  $stmt->execute();
  return $stmt->fetchAll();
}

// Obtêm pessoas a quem ainda não foi atribuido horário para um certo dia

function obterPessoasSemHorario($data)
{
  global $dbh;
  $_SESSION['data'] = $data;
  $stmt = $dbh->prepare('SELECT 
    p.email_address AS employee_email,p.phone_number AS employee_phone,es.start_time AS Entrada,es.end_time AS Saida,p.person_id,p.name AS employee_name
  FROM
    Person p
  JOIN 
    Employee e ON p.person_id = e.employee_id
  LEFT JOIN 
    EmployeeSchedule es ON e.employee_id = es.employee_id AND es.date = ?
  WHERE 
    es.employee_id IS NULL');

  $stmt->execute(array($data));
  return $stmt->fetchAll();
}

// Obtêm pessoas a quem já foi atribuido horário para um certo dia

function obterPessoasComHorario($data)
{
  global $dbh;
  $stmt = $dbh->prepare('SELECT 
    p.email_address AS employee_email,p.phone_number AS employee_phone,es.start_time AS Entrada,es.end_time AS Saida,p.person_id,p.name AS employee_name
  FROM
    Person p
  JOIN 
    Employee e ON p.person_id = e.employee_id
  LEFT JOIN 
    EmployeeSchedule es ON e.employee_id = es.employee_id AND es.date = ?
  WHERE 
    es.employee_id IS NOT NULL');

  $stmt->execute(array($data));
  return $stmt->fetchAll();
}

// Encontra a função de um conjunto de pessoas

function findRole($array)
{
  global $dbh;
  $result = [];

  foreach ($array as $person) {
    $personId = $person['person_id'];
    $stmt = $dbh->prepare('
      SELECT "Enfermeira" AS role FROM Nurse WHERE employee_id = ?
      UNION
      SELECT "Doutor" AS role FROM Doctor WHERE employee_id = ?
      UNION

      SELECT "Secretária" AS role FROM Secretary WHERE employee_id = ?
      UNION
      SELECT "Admin" AS role FROM Admin WHERE employee_id = ?
    ');
    $stmt->execute(array($personId, $personId, $personId,$personId));
    $role = $stmt->fetchColumn();

    $person['role'] = $role;
    $result[] = $person;
  }

  return $result;
}

// Adiciona o horário de trabalho a um funcionário

function addSchedule($person_id, $data, $time_block_1, $time_block_2)
{
  global $dbh;

  try {
    $stmt = $dbh->prepare('
            INSERT INTO EmployeeSchedule (employee_id, date, start_time, end_time)
            VALUES (?, ?, ?, ?)
        ');

    $stmt->execute(array($person_id, $data, $time_block_1, $time_block_2));

 
    if ($stmt->rowCount() > 0) {
      return true;  
    } else {
      return false; 
    }
  } catch (PDOException $e) {
    return "Erro ao adicionar agendamento: " . $e->getMessage();
  }
}

// Atualiza o horário de trabalho de uma pessoa

function updateSchedule($person_id, $data, $time_block_1, $time_block_2)
{
  global $dbh;

  try {
    $stmt = $dbh->prepare('
        UPDATE EmployeeSchedule
        SET start_time = ?, end_time = ?
        WHERE employee_id = ? AND date = ?
    ');

    $stmt->execute(array($time_block_1, $time_block_2, $person_id, $data));

    if ($stmt->rowCount() > 0) {
      return true;  
    } else {
      return false; 
    }
  } catch (PDOException $e) {
    return "Erro ao atualizar agendamento: " . $e->getMessage();
  }
}

// Obtem o horario de trabalho de um funcionario pelo id num certo dia
function obterHorarioIdData($id, $data)
{
  global $dbh;
  
  $stmt = $dbh->prepare('SELECT 
    es.start_time AS Entrada,
    es.end_time AS Saida
  FROM
    Person p
  JOIN 
    Employee e ON p.person_id = e.employee_id
  LEFT JOIN 
    EmployeeSchedule es ON e.employee_id = es.employee_id AND es.date = ?
  WHERE 
    e.employee_id = ?');

  $stmt->execute(array($data, $id));
  
  return $stmt->fetchAll();

}

// Obtem as consultas a que a enfermeira está atribuida

function obterConsultasPorIdData($id, $data)
{
    global $dbh;

    try {
        // Prepara a query para buscar as consultas atribuídas a um enfermeiro específico (nurse_id) em uma data
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
                Doctor doc ON a.doctor_id = doc.employee_id  -- Detalhes do médico
            JOIN 
                Person person_doctor ON doc.employee_id = person_doctor.person_id  -- Nome do médico
            LEFT JOIN 
                Nurse n ON a.nurse_id = n.employee_id  -- Relacionamento com a enfermeira
            WHERE 
                a.nurse_id = ? AND a.appointment_date = ?
        ');

        $stmt->execute(array($id, $data));

        return $stmt->fetchAll();
    } catch (PDOException $e) {
        return "Erro ao buscar consultas: " . $e->getMessage();
    }
}

// Obtem as consultas a que o médico está atribuido

function obterConsultasMedicoPorIdData($id, $data)
{
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
                Doctor doc ON a.doctor_id = doc.employee_id  -- Detalhes do médico
            JOIN 
                Person person_doctor ON doc.employee_id = person_doctor.person_id  -- Nome do médico
            LEFT JOIN 
                Nurse n ON a.nurse_id = n.employee_id  -- Relacionamento com a enfermeira
            WHERE 
                a.doctor_id = ? AND a.appointment_date = ?
            ORDER BY 
                a.time_block ASC  
        ');

        $stmt->execute(array($id, $data));

        return $stmt->fetchAll();
    } catch (PDOException $e) {
        return "Erro ao buscar consultas: " . $e->getMessage();
    }
}





?>
