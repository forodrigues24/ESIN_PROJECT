<?php

// Recebendo os dados do formulário
session_start();

$person_id = $_POST['person_id'];
$time_block_1 = $_POST['time_block_1'];
$time_block_2 = $_POST['time_block_2'];
$data = $_SESSION['data']; // A data da sessão deve estar previamente definida


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

try {
    // Conectando-se ao banco de dados
    $dbh = new PDO('sqlite:../sql/database.db');
    $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Chama a função para adicionar o agendamento
    $sucess = addSchedule($person_id, $data, $time_block_1, $time_block_2);
    // Verifica se o agendamento foi adicionado com sucesso
    if ($sucess) {
        $_SESSION['msg'] = 'Horário adicionado com sucesso!';

        $semHorario = obterPessoasSemHorario($data);
        $comHorario = obterPessoasComHorario($data);
        $roles = findRole($semHorario);
        foreach ($semHorario as $key => $person) {
            $semHorario[$key]['role'] = $roles[$key]['role'];
        }

        $roles2 = findRole($comHorario);
        foreach ($comHorario as $key => $person) {
            $comHorario[$key]['role'] = $roles2[$key]['role'];
        }

        $_SESSION['semHorario'] = $semHorario;
        $_SESSION['comHorario'] = $comHorario;

    } else {
        $_SESSION['msg'] = 'Falha ao adicionar o horário!';
    }


    // Redireciona para a página de secretaria após o processo
    header('Location: ../secretaria.php');
    die();
} catch (PDOException $e) {
    // Caso haja erro na conexão com o banco, exibe a mensagem de erro
    $_SESSION['msg'] = 'Erro: ' . $e->getMessage();
    header('Location: ../loginpage.php');
    die();
}
