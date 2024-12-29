<?php
session_start();

if (isset($_POST['role_change']) && isset($_POST['person_id']) && isset($_POST['old_role'])) {
    $person_id = $_POST['person_id'];
    $old_role = $_POST['old_role']; 
    $new_role = $_POST['role_change'];

    try {
        include_once('../database/init.php');


        $checkAdminQuery = 'SELECT COUNT(*) as admin_count FROM Admin';
        $stmt = $dbh->query($checkAdminQuery);
        $result = $stmt->fetch();

        // Verificar se o perfil é de um admin
        $checkPersonAdminQuery = 'SELECT employee_id FROM Admin WHERE employee_id = ?';
        $stmt = $dbh->prepare($checkPersonAdminQuery);
        $stmt->execute([$person_id]);
        $isPersonAdmin = $stmt->fetch();

        // Verificar se existe pelo menos um admin (para ainda ser possível aceder a esta página)
        if ($result['admin_count'] <= 1 && $isPersonAdmin && $new_role !== 'Admin') {
            $_SESSION['msg'] = 'Erro: Não pode remover o único Admin!';
            header('Location: ../admin.php');
            exit();
        }

        // Remover este perfil de todas as tabelas de funções específicas (exceto se não tinham função anterior)
        if ($old_role !== 'Sem função') {
            $tables = ['Doctor', 'Nurse', 'Secretary', 'Admin', 'LabTech'];
            foreach ($tables as $table) {
                $removeQuery = "DELETE FROM $table WHERE employee_id = ?";
                $stmt = $dbh->prepare($removeQuery);
                $stmt->execute([$person_id]);
            }

            if ($new_role == 'Sem função') {
            $deleteEmployeeQuery = 'DELETE FROM Employee WHERE employee_id = ?';
            $stmt = $dbh->prepare($deleteEmployeeQuery);
            $stmt->execute([$person_id]);
            }
        }

        // Adicionar informação de contrato, caso esta ainda não existisse (sem função prévia)
        if ($old_role === 'Sem função') {
            $start_contract = $_POST['start_contract']; 
            $end_contract = $_POST['end_contract'];   

            $addEmployeeQuery = 'INSERT INTO Employee (employee_id, start_contract, end_contract) VALUES (?, ?, ?)';
            $stmt = $dbh->prepare($addEmployeeQuery);
            $stmt->execute([$person_id, $start_contract, $end_contract]);
        }

            // Adicionar informação necessária nas tabelas de função específica
        if ($new_role !== 'Sem função') {
            switch ($new_role) {
                case 'Médico(a)':
                    $department = $_POST['department']; 
                    $specialty = $_POST['specialty'];   
                    $addDoctorQuery = 'INSERT INTO Doctor (employee_id, department, specialty) VALUES (?, ?, ?)';
                    $stmt = $dbh->prepare($addDoctorQuery);
                    $stmt->execute([$person_id, $department, $specialty]);
                    break;
                case 'Enfermeiro(a)':
                    $department = $_POST['department']; 
                    $specialty = $_POST['specialty'];  
                    $addNurseQuery = 'INSERT INTO Nurse (employee_id, department, specialty) VALUES (?, ?, ?)';
                    $stmt = $dbh->prepare($addNurseQuery);
                    $stmt->execute([$person_id, $department, $specialty]);
                    break;
                case 'Secretário(a)':
                    $addSecretaryQuery = 'INSERT INTO Secretary (employee_id) VALUES (?)';
                    $stmt = $dbh->prepare($addSecretaryQuery);
                    $stmt->execute([$person_id]);
                    break;
                case 'Admin':
                    $addAdminQuery = 'INSERT INTO Admin (employee_id) VALUES (?)';
                    $stmt = $dbh->prepare($addAdminQuery);
                    $stmt->execute([$person_id]);
                    break;
                case 'LabTech':
                    $specialty = $_POST['specialty'];  
                    $addLabTechQuery = 'INSERT INTO LabTech (employee_id, specialty) VALUES (?, ?)';
                    $stmt = $dbh->prepare($addLabTechQuery);
                    $stmt->execute([$person_id, $specialty]);
                    break;
                default:
                    break;
                }

            $_SESSION['msg'] = 'Função atualizada com sucesso!';
            header('Location: ../admin.php');
            exit();
        }


    } catch (PDOException $e) {
        $_SESSION['msg'] = 'Erro: ' . $e->getMessage();
    }

    // Rederigir para a página de admin, com a nova informação
    header('Location: ../admin.php');
    exit();

} else {
    // Pedidos inválidos
    $_SESSION['msg'] = 'Pedido inválido. Por favor, tente novamente.';
    header('Location: ../admin.php');
    exit();
}
?>