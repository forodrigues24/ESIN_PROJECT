<?php
function isPhoneUsed($phone, $id)
{
    global $dbh;
    $stmt = $dbh->prepare('SELECT COUNT(*) FROM Person WHERE phone_number = ? AND person_id != ?');
    $stmt->execute([$phone, $id]);
    $result = $stmt->fetchColumn();
    return $result > 0;
}


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


function checkRole($patient_id) {
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
    $roles = ['Admin', 'Doctor', 'Nurse', 'Secretary', 'LabTech'];
    
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


function fetchAppointments($patient_id)
{   
    global $dbh;
    $stmt = $dbh->prepare('
        SELECT 
            a.appointment_id,
            dp.name AS doctor_name,
            np.name AS nurse_name,
            s.date AS consultation_day,
            s.start_time AS consultation_start_time,
            a.report AS consultation_report
        FROM 
            Appointment a
        JOIN 
            Schedule s ON a.schedule = s.schedule_id
        JOIN 
            Doctor d ON a.doctor_id = d.employee_id
        JOIN 
            Person dp ON d.employee_id = dp.person_id
        LEFT JOIN 
            Nurse n ON a.nurse_id = n.employee_id
        LEFT JOIN 
            Person np ON n.employee_id = np.person_id
        WHERE 
            a.patient_id = ?
        ORDER BY 
            s.date DESC, s.start_time DESC
    ');
    $stmt->execute(array($patient_id));
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

try {
    // Conexão com o banco de dados
    $dbh = new PDO('sqlite:../sql/database.db');
    $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $patient_id = $_SESSION['user_id'];

    // Busca os agendamentos do paciente logado
    $appointments = fetchAppointments($patient_id);
} catch (PDOException $e) {
    $_SESSION['msg'] = "Erro ao acessar o banco de dados: " . $e->getMessage();
    header("Location:../profile.php");
    die();
}

?>