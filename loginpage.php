<?php
  session_start();

  $msg = $_SESSION['msg'];
  unset($_SESSION['msg']);
?>  

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Login</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="styles.css">
  </head>
  <body id="login-page">
    <header>
      <a href="index.php">
        <img src="images/logo.png" alt="Logo">
      </a>
  
      <nav>
        <ul class="nav-links">
          <li><a href="especialidades.html">Especialidades</a></li>
          <li><a href="sobre.html">Sobre</a></li>
        </ul>
  
        <div class="profile">
          <a href="loginpage.php">
            <img src="images/pfp.jpg" alt="Profile">
          </a>
        </div>
      </nav>
    </header>
    
    <!-- Formulário de login -->
    <form action="action_login.php" method="post">
      <fieldset>
        <h2>Login</h2> <!-- Título dentro do fieldset -->
    
        <label for="email">Email:</label>
        <input type="text" id="email" name="email" required>
        <br><br>
        <label for="password">Senha:</label>
        <input type="password" id="password" name="password" required>
        <br><br>
        <!-- Div para centralizar os botões -->
        <div class="buttons-container">
          <input type="submit" value="Entrar">
          <a href="registpage.php" class="register-button">Registrar-se</a>
        </div>
        <h4>
          <?php if (isset($msg)) { ?>
            <?php echo $msg ?>
          <?php } ?>
        </h4> 
      </fieldset>
    </form>
      
  </body>
</html>
