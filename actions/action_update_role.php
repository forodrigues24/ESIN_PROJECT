<?php
session_start();

// Para usar funções destes ficheiros
require('../database/person.php');
require('../database/employee.php');

// Obtém informação do formulário
$person_id = $_POST['person_id'];
$role = $_POST['role'];
$person_role = $_POST['person_role'];
$start_contract = $_POST['start_contract'];
$end_contract = $_POST['end_contract'];
$speciality = $_POST['speciality'];

// Caso já não tenha função
if ($role == 'removerole') {
    if ((int)(!empty($start_contract)) || (int)(!empty($end_contract)) || ($speciality!=='none')) {
        $_SESSION['msg'] = "Nenhuma informação de contrato ou especialidade deve ser enviada ao remover o papel.";
        header('Location: ../admin.php');
        die();
    }
    if ($person_role == 'patient') {
        $_SESSION['msg'] = "A pessoa já é um paciente";
        header('Location: ../admin.php');
        die();
    }
}

// Especialidades só para médicos e enfermeiros
if (isset($speciality) && $speciality !== 'none' && $role !== 'nurse' && $role !== 'doctor') {
    $_SESSION['msg'] = 'Somente médico e enfermeira têm especialidade.';
    header('Location: ../admin.php');
    die();
}

// Fim de contrato tem de ser depois do ínicio
if ($end_contract < $start_contract) {
    $_SESSION['msg'] = 'O fim de contrato deve ser posterior que o inicío.';
    header('Location: ../admin.php');
    die();
}



try {
    // Conexão com o banco de dados
    include_once('../database/init.php');


    // Adiciona ou remove informação das tabelas necessárias
    $flag = addToEmployee($person_id, $person_role);
    $flag2 = deleteRole($person_id, $person_role);

    // Para remover a função
    if ($role !== 'removerole') {
        $flag3 = updateRole($person_id, $role, $person_role);
    } else {
        $flag4 = removeEmployee($person_id);
    }

    // Quando o contrato é necessário
    if (!empty($start_contract) && empty($end_contract)) {
        $_SESSION['msg'] = "O campo 'start_contract' foi preenchido, mas o campo 'end_contract' não foi definido.";
        header('Location: ../admin.php');
        die();
    }
    // Verifica se end_contract está definido e start_contract não está
    elseif (empty($start_contract) && !empty($end_contract)) {
        $_SESSION['msg'] = "O campo 'end_contract' foi preenchido, mas o campo 'start_contract' não foi definido.";
        header('Location: ../admin.php');
        die();
    } elseif (!empty($start_contract) && !empty($end_contract)) {

        $flag = insertContract($person_id, $start_contract, $end_contract);
    }
    if ($speciality !== 'none') {
        $flag2 = insertOrUpdateSpeciality($person_id, $role, $speciality);
    }

    if ($flag) {
        $_SESSION['msg'] = 'O papel foi adicionado';
    }
    unset($_SESSION['search_results']);

    header('Location: ../admin.php');
    die();
} catch (PDOException $e) { // Em caso de erro

    $_SESSION['msg'] = 'Error: ' . $e->getMessage();
    header('Location: ../admin.php');
    die();
}

header('Location: ../admin.php');
die();
