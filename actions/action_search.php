<?php
session_start();

// Para usar funções deste ficheiro
require_once('../database/person.php');

// get input from HTTP parameters
$role = $_POST['role'];

try {

    // Conexão com o banco de dados
    include_once('../database/init.php');
    
     // Obtém os ID's de todos os perfis
    $ids = getAllPersonIds();

    if ($role=='patient') {
        foreach ($ids as $id) {
            $id_role = checkRole($id);
            $personData = getPersonData($id);
            $personData['role'] = $id_role;
            $idData[] = $personData;
            $_SESSION['search_results'] = $idData;
            $_SESSION['msg'] = 'Resultados encontrados com sucesso.';
            
        }
        header('Location: ../admin.php');
        die();
        
    }
    foreach ($ids as $id) {
        $id_role = checkRole($id);
        if ($id_role == $role) {

            $personData = getPersonData($id);
            $personData['role'] = $id_role;
            $idData[] = $personData;
        }
    }

    $_SESSION['search_results'] = $idData;
    
    if (empty($_SESSION['search_results'])) {
        $_SESSION['msg'] = 'Nenhum resultado encontrado.';
    } else {
        $_SESSION['msg'] = 'Resultados encontrados com sucesso.';
    }
    header('Location: ../admin.php');
} catch (PDOException $e) {
    // Handle errors
    $_SESSION['msg'] = 'Error: ' . $e->getMessage();
    header('Location: ../admin.php'); // Go back to the template with the error message
    exit();
}

header('Location: ../admin.php');
