<?php 

function insertContract($id,$start_contract,$end_contract)
{
    global $dbh;

    try {
        $query = 'UPDATE Employee SET start_contract = ?, end_contract = ? WHERE employee_id = ?';
        $stmt = $dbh->prepare($query);
        $stmt->execute([$start_contract, $end_contract, $id]);
        return True;
        exit();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Handle errors
        $_SESSION['msg'] = 'Error: ' . $e->getMessage();
        return False;
        exit();
    }
}

function insertOrUpdateSpeciality($id, $role, $speciality)
{
    global $dbh;

    try {
        // Verificar se o funcionário já existe na tabela correspondente
        if ($role === 'doctor') {
            $checkQuery = 'SELECT * FROM Doctor WHERE employee_id = ?';
        } elseif ($role === 'nurse') {
            $checkQuery = 'SELECT * FROM Nurse WHERE employee_id = ?';
        } 

        $stmt = $dbh->prepare($checkQuery);
        $stmt->execute([$id]);
        $exists = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($exists) {
            // Caso exista, fazer um UPDATE
            if ($role === 'doctor') {
                $updateQuery = 'UPDATE Doctor SET specialty = ? WHERE employee_id = ?';
            } elseif ($role === 'nurse') {
                $updateQuery = 'UPDATE Nurse SET specialty = ? WHERE employee_id = ?';
            }

            $stmt = $dbh->prepare($updateQuery);
            $stmt->execute([$speciality, $id]);
        } else {
            // Caso não exista, fazer um INSERT
            if ($role === 'doctor') {
                $insertQuery = 'INSERT INTO Doctor (employee_id, specialty) VALUES (?, ?)';
            } elseif ($role === 'nurse') {
                $insertQuery = 'INSERT INTO Nurse (employee_id, specialty) VALUES (?, ?)';
            }

            $stmt = $dbh->prepare($insertQuery);
            $stmt->execute([$id, $speciality]);
        }

        return true;
    } catch (PDOException $e) {
        // Lidar com erros
        $_SESSION['msg'] = 'Erro: ' . $e->getMessage();
        return false;
    } catch (Exception $e) {
        // Lidar com outros erros
        $_SESSION['msg'] = 'Erro: ' . $e->getMessage();
        return false;
    }
}

?>