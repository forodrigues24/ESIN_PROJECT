<?php
  session_start();

  $msg = $_SESSION['msg'];
  unset($_SESSION['msg']);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Registro</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="styles.css">

  <body id="login-page">
  <header>
    <a href="index.html"> <!-- Substitua 'pagina-desejada.html' pela URL de destino -->
      <img src="images/logo.png" alt="Logo">
    </a>

    <nav>
      <ul class="nav-links">
        <li><a href="especialidades.html">Especialidades</a></li>
        <li><a href="sobre.html">Sobre</a></li>
      </ul>

      <div class="profile">
        <a href="loginpage.html">
          <img src="images/pfp.jpg" alt="Profile">
        </a>
      </div>
    </nav>
  </header>

  <div class="forms">
  <form action="action_register.php" class="registration-form" method="post" autocomplete="off">
    <fieldset>
      <h2>Registrar-se</h2> 
      <h4>
        <?php if (isset($msg)) { ?>
          <msg><?php echo $msg ?></msg>
        <?php } ?>
      </h4> 

      <div class="input-container">
        <label for="name">Nome: *</label>
        <input type="text" id="name" name="name" autocomplete="off" required>
      </div>

      <div class="input-container">
        <label for="age">Idade:</label>
        <input type="number" id="age" name="age" min="0" autocomplete="off">
      </div>

      <div class="input-container">
        <label for="email">Endereço de E-mail: *</label>
        <input type="email" id="email" name="email" autocomplete="off" required>
      </div>

      <div class="input-container">
        <label for="address">Morada:</label>
        <input type="text" id="address" name="address" autocomplete="off">
      </div>

      <div class="input-container">
        <label for="phone">Número de Telefone: *</label>
        <input type="tel" id="phone" name="phone" pattern="[0-9]{9}" title="O número de telefone deve conter 9 dígitos." autocomplete="off" required>
      </div>

      <div class="input-container">
        <label for="password">Senha: *</label>
        <input type="password" id="password" name="password" autocomplete="new-password" required>
      </div>

      <div class="input-container">
        <label for="confirm_password">Confirmar Senha: *</label>
        <input type="password" id="confirm_password" name="confirm_password" autocomplete="new-password" required>
      </div>

      <input type="submit" value="Registrar">
    </fieldset>
  </form>
</div>

</body>

</html>
