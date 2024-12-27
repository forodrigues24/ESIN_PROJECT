<?php
session_start();
require_once('../database/person.php');

if (isset($_POST['funcao']) && $_POST['funcao'] !== null && isset($_POST['data']) && $_POST['data'] !== null) {
  $funcao = $_POST['funcao'];
  $data = $_POST['data'];

}



function obterPessoasFuncao($funcao,$data)
{
  global $dbh;
  $stmt = $dbh->prepare('SELECT 
    p.name AS employee_name,
    es.date,
    es.start_time,
    es.end_time
FROM
    ?
JOIN
    Employee e USING(employee_id)
JOIN 
    EmployeeSchedule es USING(employee_id)
JOIN 
    Person p ON e.employee_id = p.person_id
WHERE 
    es.date = ?
ORDER BY 
    p.name, es.date');

  $stmt->execute(array($funcao,$data));
  return $stmt->fetch();
}



try {
  $dbh = new PDO('sqlite:../sql/database.db');
  $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $userData = obterPessoasFuncao($funcao,$data);
  echo  $userData;
  die();

} catch (PDOException $e) {
  $_SESSION['msg'] = 'Error: ' . $e->getMessage();
}

header('Location: ../loginpage.php');
