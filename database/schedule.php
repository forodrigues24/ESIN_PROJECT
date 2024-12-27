<?php

function getTimeStamps()
{
  global $dbh;
  $stmt = $dbh->prepare('SELECT * FROM TimeStamps');
  $stmt->execute();
  return $stmt->fetchAll();
}


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
      SELECT "Técnico de Lab" AS role FROM LabTech WHERE employee_id = ?
      UNION
      SELECT "Secretária" AS role FROM Secretary WHERE employee_id = ?
      UNION
      SELECT "Admin" AS role FROM Admin WHERE employee_id = ?
    ');
    $stmt->execute(array($personId, $personId, $personId, $personId, $personId));
    $role = $stmt->fetchColumn();

    $person['role'] = $role;
    $result[] = $person;
  }

  return $result;
}


function addSchedule($person_id, $data, $time_block_1, $time_block_2)
{
  global $dbh;

  // Iniciar transação para garantir a consistência dos dados
  try {
    // Prepara a query para inserir um novo agendamento
    $stmt = $dbh->prepare('
            INSERT INTO EmployeeSchedule (employee_id, date, start_time, end_time)
            VALUES (?, ?, ?, ?)
        ');

    // Executa a query com os dados fornecidos
    $stmt->execute(array($person_id, $data, $time_block_1, $time_block_2));

    // Verifica se a inserção foi bem-sucedida
    if ($stmt->rowCount() > 0) {
      return true;  // Inserção bem-sucedida
    } else {
      return false; // Nenhuma linha foi afetada
    }
  } catch (PDOException $e) {
    // Em caso de erro, retorna uma mensagem de erro
    return "Erro ao adicionar agendamento: " . $e->getMessage();
  }
}

function updateSchedule($person_id, $data, $time_block_1, $time_block_2)
{
  global $dbh;

  try {
    // Prepara a query para atualizar o horário de término
    $stmt = $dbh->prepare('
        UPDATE EmployeeSchedule
        SET start_time = ?, end_time = ?
        WHERE employee_id = ? AND date = ?
    ');

    // Executa a query com os dados fornecidos
    $stmt->execute(array($time_block_1, $time_block_2, $person_id, $data));

    // Verifica se a atualização foi bem-sucedida
    if ($stmt->rowCount() > 0) {
      return true;  // Atualização bem-sucedida
    } else {
      return false; // Nenhuma linha foi afetada
    }
  } catch (PDOException $e) {
    // Em caso de erro, retorna uma mensagem de erro
    return "Erro ao atualizar agendamento: " . $e->getMessage();
  }
}

?>
