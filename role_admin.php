<?php
  session_start();

  $msg = $_SESSION['msg'];
  unset($_SESSION['msg']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Painel de Administração</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="styles.css">
</head>
<body id="admin-page">
<header>
  <a href="index.html">
    <img src="images/logo.png" alt="Logo">
  </a>
</header>

<div class="main-container">
  <!-- Coluna 1: 30% da largura -->
  <section id="register-role">
    <h2>Registrar Função</h2>
    <form action="action_admin.php" method="post">
      <label for="email">E-mail do Usuário:</label>
      <input type="email" name="email" placeholder="Digite o e-mail" required>
      <label for="role">Selecione a Função:</label>
      <select name="role" required>
        <option value="">Selecione uma função</option>
        <option value="labtech">Técnico de Laboratório</option>
        <option value="secretary">Secretário</option>
        <option value="nurse">Enfermeiro</option>
        <option value="doctor">Médico</option>
      </select>

      <button type="submit">Registrar Função</button>
    </form>
  </section>

  <!-- Coluna 2: 70% da largura -->
  <section id="some-other-section">
    <!-- Conteúdo adicional, como listagem ou outra funcionalidade -->
    <h2>Outras Funcionalidades</h2>
    <p>Aqui você pode adicionar mais funcionalidades ou informações.</p>
  </section>
</div>


<footer>
  <p>&copy; 2024 - Painel de Administração</p>
</footer>

</body>
</html>
