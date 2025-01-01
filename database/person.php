<?php

// Inserir a pessoa através do registro

function insertUser($name,$age,$email,$address,$phone,$password) {
    global $dbh;
    $stmt = $dbh->prepare('INSERT INTO Person (name,age,email_address,address,phone_number,password) VALUES (?, ?,?,?,?,?)');
    $stmt->execute(array($name,$age,$email,$address,$phone, hash('sha256', $password)));
}

// Inserir a pessoa como paciente assim que se regista

function insertPatient($id) {
    global $dbh;
    $stmt = $dbh->prepare('INSERT INTO Patient (patient_id) VALUES (?)');
    $stmt->execute(array($id));
}


// Obter os dados da pessoa pelo o id

function getPersonData($id)
{
    global $dbh;

    try {
        $query = 'SELECT * FROM Person WHERE person_id = ?';
        $stmt = $dbh->prepare($query);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Handle errors
        $_SESSION['msg'] = 'Error: ' . $e->getMessage();
        header('Location: ../admin.php'); // Redirect with an error message
        exit();
    }
}

// Obter os dados da pessoa pelo email

function getPersonDataByEmail($email)
{
    global $dbh;

    try {
        $query = 'SELECT person_id FROM Person WHERE email_address LIKE ?';
        $stmt = $dbh->prepare($query);

        $emailSearch = "%" . $email . "%";

        $stmt->execute([$emailSearch]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Tratar erros
        $_SESSION['msg'] = 'Error: ' . $e->getMessage();
        header('Location: ../admin.php'); 
        exit();
    }
}

// Verificar se os dados de login estão na base de dados

function loginSuccess($email, $password)
{
    global $dbh;
    $stmt = $dbh->prepare('SELECT * FROM Person WHERE email_address = ? AND password = ?');
    $stmt->execute(array($email, hash('sha256', $password)));
    return $stmt->fetch();
}

// Verificar se o telemóvel já foi usado

function isPhoneUsed($phone, $id)
{
    global $dbh;
    $stmt = $dbh->prepare('SELECT COUNT(*) FROM Person WHERE phone_number = ? AND person_id != ?');
    $stmt->execute([$phone, $id]);
    $result = $stmt->fetchColumn();
    return $result > 0;
}

// Alterar os dados da pessoa

function updateUser($id, $name, $age, $address, $phone, $password)
{
    global $dbh;

    // Se a senha foi fornecida, valida e faz o hash
    if (!empty($password)) {

        // Valida a senha: comprimento mínimo, maiúsculas, números, símbolos
        if (
            strlen($password) < 8 ||
            !preg_match('/[A-Z]/', $password) ||
            !preg_match('/[0-9]/', $password) ||
            !preg_match('/[\W_]/', $password)
        ) {
            $_SESSION['msg'] = 'Password must have at least 8 characters, one uppercase letter, one number, and one special character.';
            header('Location: ../edit_profile.php');
            exit();
        }

        // Realiza o hash da senha
        $hashedPassword = hash('sha256', $password);
        $stmt = $dbh->prepare('UPDATE Person SET name = ?, age = ?, address = ?, phone_number = ?, password = ? WHERE person_id = ?');
        $stmt->execute([$name, $age, $address, $phone, $hashedPassword, $id]);
    } else {
        // Se não for fornecida nova senha, apenas atualiza as outras informações
        $stmt = $dbh->prepare('UPDATE Person SET name = ?, age = ?, address = ?, phone_number = ? WHERE person_id = ?');
        $stmt->execute([$name, $age, $address, $phone, $id]);
    }
}

// Verificar a função da pessoa. Se não der patient, é porque é funcionário. Todos os funcionários já se presume que são patients.

function checkRole($patient_id)
{
    global $dbh;

    // Verifica se o patient_id existe na tabela Employee
    $stmt = $dbh->prepare('SELECT COUNT(*) FROM Employee WHERE employee_id = ?');
    $stmt->execute([$patient_id]);
    $result = $stmt->fetchColumn();

    // Se o employee_id não for encontrado na tabela Employee, verifica nas outras tabelas
    if ($result == 0) {
        return 'patient';  // Se não existir em Employee, assume-se que é um paciente
    }

    // Se encontrado em Employee, agora verifica nas tabelas de funções
    $roles = ['Admin', 'Doctor', 'Nurse', 'Secretary'];

    foreach ($roles as $role) {
        // Verifica se o employee_id existe em cada tabela de função
        $stmt = $dbh->prepare("SELECT COUNT(*) FROM $role WHERE employee_id = ?");
        $stmt->execute([$patient_id]);
        $roleExists = $stmt->fetchColumn();

        // Se encontrar o ID em alguma das tabelas de funções, retorna o papel
        if ($roleExists > 0) {
            return strtolower($role);  // Retorna o nome do papel encontrado (ex: 'admin', 'doctor', etc.)
        }
    }
}


// Obter todos os ids que existem na base de dados

function getAllPersonIds()
{
    global $dbh;

    try {
        $query = 'SELECT person_id FROM Person ORDER BY person_id';
        $stmt = $dbh->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    } catch (PDOException $e) {
        $_SESSION['msg'] = 'Error: ' . $e->getMessage();
        header('Location: ../admin.php'); 
        exit();
    }
}


// Apagar uma certa função. Torna para paciente

function deleteRole($person_id, $person_role)
{
    global $dbh;
    
   
    try {
        
        switch ($person_role) {
            case 'doctor':
                $stmt = $dbh->prepare('DELETE FROM Doctor WHERE employee_id = ?');
                $stmt->execute([$person_id]);

                break;

            case 'nurse':
                // Remove o papel de 'nurse'
                $stmt = $dbh->prepare('DELETE FROM Nurse WHERE employee_id = ?');
                $stmt->execute([$person_id]);
                break;

            case 'secretary':
                // Remove o papel de 'secretary'
                $stmt = $dbh->prepare('DELETE FROM Secretary WHERE employee_id = ?');
                $stmt->execute([$person_id]);
                break;
        
            case 'admin':
                // Remove o papel de 'admin'
                $stmt = $dbh->prepare('DELETE FROM Admin WHERE employee_id = ?');
                $stmt->execute([$person_id]);
                break;
        }
        
        $_SESSION['msg'] = 'Papel atualizado com sucesso!';
        return True;

    } catch (PDOException $e) {
        // Tratar erros
        $_SESSION['msg'] = 'Erro ao atualizar o papel: ' . $e->getMessage();
        header('Location: ../admin.php'); // Redireciona com uma mensagem de erro
        return False;

        exit();
    }
}

// Remover da tabela dde funcionários.

function removeEmployee($person_id)
{
    global $dbh;

    try {
        $stmt = $dbh->prepare('DELETE FROM Employee WHERE employee_id = ?');
        $stmt->execute([$person_id]);
        
        return true;
    } catch (PDOException $e) {
        error_log('Erro ao remover da tabela Employee: ' . $e->getMessage());
        return false;
    }
}

// Adicionar à tabela de funcionários
function addToEmployee($person_id, $person_role)
{
    global $dbh;

    try {
        if ($person_role == 'patient') {
            // Tenta inserir o person_id na tabela Employee
            $stmt = $dbh->prepare('INSERT INTO Employee(employee_id) VALUES (?)');
            $stmt->execute([$person_id]); 
            return true; // Retorna verdadeiro em caso de sucesso
        }
        return false; // Retorna falso se o papel não for 'patient'
    } catch (PDOException $e) {
        
        error_log('Erro ao adicionar à tabela Employee: ' . $e->getMessage());
        return false; 
    }
}

// Atualiza o papel de um certo funcionário

function updateRole($person_id, $role, $person_role)
{
    
    global $dbh;

    try {
        switch ($role) {
            case 'doctor':
                $stmt = $dbh->prepare('INSERT INTO Doctor (employee_id) VALUES (?)');
                $stmt->execute([$person_id]);

                break;

            case 'nurse':
                $stmt = $dbh->prepare('INSERT INTO Nurse (employee_id) VALUES (?)');
                $stmt->execute([$person_id]);
                break;

            case 'secretary':
                $stmt = $dbh->prepare('INSERT INTO Secretary (employee_id) VALUES (?)');
                $stmt->execute([$person_id]);
                break;

         
            case 'admin':
                $stmt = $dbh->prepare('INSERT INTO Admin (employee_id) VALUES (?)');
                $stmt->execute([$person_id]);
                break;
        }

        $_SESSION['msg'] = 'Papel atualizado com sucesso!';
        return True;
        exit();
    } catch (PDOException $e) {
        $_SESSION['msg'] = 'Erro ao atualizar o papel: ' . $e->getMessage();
        return False;
    }
}

function fetchUserProfile($email)
{
    global $dbh;
    $stmt = $dbh->prepare('
        SELECT 
            person_id,
            name,
            age,
            email_address,
            address,
            phone_number
        FROM Person
        WHERE email_address = ?
    ');
    $stmt->execute(array($email));
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
