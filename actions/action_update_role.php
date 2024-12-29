<?php
session_start();


require('../database/person.php');

$person_id = $_POST['person_id'];
$role = $_POST['role'];
$person_role = $_POST['person_role'];

try {
    include_once('../database/init.php');

    
    $flag=addToEmployee($person_id,$person_role);

    $flag2=deleteRole($person_id,$person_role);
    $flag3=updateRole($person_id, $role,$person_role);
    
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