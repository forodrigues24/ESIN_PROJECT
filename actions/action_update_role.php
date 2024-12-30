<?php
session_start();


require('../database/person.php');
require('../database/employee.php');

$person_id = $_POST['person_id'];
$role = $_POST['role'];
$person_role = $_POST['person_role'];





try {
    // Conexão com o banco de dados
    $dbh = new PDO('sqlite:../sql/database.db');
    $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $flag=addToEmployee($person_id,$person_role);

    $flag2=deleteRole($person_id,$person_role);
    $flag3=updateRole($person_id, $role,$person_role);

    if (isset($_POST['start_contract']) && !empty($_POST['start_contract']) &&
        isset($_POST['end_contract']) && !empty($_POST['end_contract'])) {
        
        $start_contract = $_POST['start_contract'];
        $end_contract = $_POST['end_contract'];

    } else {
        echo "As datas de início e fim do contrato devem ser preenchidas.";
        exit;
    }

    if ($flag) {
        $_SESSION['msg'] = 'O papel foi adicionado';
    } 
    unset($_SESSION['search_results']);

    header('Location: ../admin.php');
    exit();
} catch (PDOException $e) {
    
    $_SESSION['msg']= 'Error: ' . $e->getMessage();
    header('Location: ../admin.php');


}

exit();




?>