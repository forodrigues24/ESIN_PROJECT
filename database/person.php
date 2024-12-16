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
