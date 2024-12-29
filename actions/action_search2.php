<?php
session_start();
require_once('../database/person.php');

// get input from HTTP parameters
$email = $_POST['search-email'];



try {

    $dbh = new PDO('sqlite:../sql/database.db');
    $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $ids = getPersonDataByEmail($email);
    foreach ($ids as $id) {
        $id_role = checkRole($id); 
        $personData = getPersonData($id); 
        $personData['role'] = $id_role;
        $idData[] = $personData;
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
