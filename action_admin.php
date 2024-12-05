<?php
  session_start();

  $email = $_POST['email'];
  $role = $_POST['role'];

  // Função para atribuir o papel a um usuário no banco de dados
  function assignRoleToUser($email, $role) {
    global $dbh;
    $stmt = $dbh->prepare("UPDATE users SET role = ? WHERE email = ?");
    $stmt->execute(array($role, $email));
  }

  // Verificar se os campos foram preenchidos corretamente
  if (strlen($email) == 0 || strlen($role) == 0) {
    $_SESSION['msg'] = 'Todos os campos são obrigatórios!';
    header('Location: admin_panel.php');
    die();
  }

  try {
    // Conectar ao banco de dados (exemplo com PDO e SQLite, substitua com seu banco real)
    $dbh = new PDO('sqlite:sql/database.db');
    $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verificar se o usuário com o e-mail fornecido existe
    $stmt = $dbh->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute(array($email));

    if ($stmt->rowCount() > 0) {
      // Atribuir a função ao usuário
      assignRoleToUser($email, $role);

      $_SESSION['msg'] = "Função '$role' atribuída com sucesso ao usuário com e-mail '$email'.";
    } else {
      $_SESSION['msg'] = 'Usuário com esse e-mail não encontrado!';
    }

    // Redirecionar de volta para o painel de administração com a mensagem
    header('Location: admin_panel.php');
    die();
  } catch (PDOException $e) {
    $error_msg = $e->getMessage();
    $_SESSION['msg'] = "Erro ao atribuir função! ($error_msg)";
    header('Location: admin_panel.php');
    die();
  }
?>
