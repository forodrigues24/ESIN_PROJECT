<?php
session_start();
require_once('../database/person.php');

if (isset($_POST['data']) && $_POST['data'] !== null) {
  $data = $_POST['data'];
}



function obterPessoasSemHorario($data)
{
  global $dbh;
  $_SESSION['data']=$data;
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
  $_SESSION['data']=$data;
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
    $stmt->execute(array($personId, $personId, $personId,$personId, $personId));
    $role = $stmt->fetchColumn();

    $person['role'] = $role;
    $result[] = $person;
  }

  return $result;
}


try {
  $dbh = new PDO('sqlite:../sql/database.db');
  $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $semHorario=obterPessoasSemHorario($data);
  $comHorario=obterPessoasComHorario($data);
  $roles=findRole($semHorario);
  foreach ($semHorario as $key => $person) {
    $semHorario[$key]['role'] = $roles[$key]['role'];
  }

  $roles2=findRole($comHorario);
  foreach ($comHorario as $key => $person) {
    $comHorario[$key]['role'] = $roles2[$key]['role'];
  }


  $_SESSION['semHorario'] = $semHorario;
  $_SESSION['comHorario'] = $comHorario;


  header('Location: ../secretaria.php');
  die();
} catch (PDOException $e) {
  $_SESSION['msg'] = 'Error: ' . $e->getMessage();
}

header('Location: ../loginpage.php');
