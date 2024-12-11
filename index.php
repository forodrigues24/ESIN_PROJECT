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
    
    <!-- Cabeçalho da página -->
    <header>
      <a href="index.php"> <!-- Substitua 'pagina-desejada.html' pela URL de destino -->
        <img src="images/logo.png" alt="Logo">
      </a>

      <nav>
        <ul class="nav-links">
          <li><a href="especialidades.html">Especialidades</a></li>
          <li><a href="sobre.html">Sobre</a></li>
        </ul>
        <div class="profile">
          <?php if (!isset($_SESSION['email'])) { ?>
            <a href="loginpage.php">
              <img src="images/pfp.jpg" alt="Profile">
            </a>
          <?php } else { ?>
            <!-- Redireciona para o painel/perfil se o usuário estiver logado -->
            <a href="profile.php">
              <img src="images/pfp.jpg" alt="Profile">
            </a>
          <?php } ?>
        </div>


        
      </nav>
  </header>
  <h4>
    <?php if (isset($msg)) { ?>
      <?php echo $msg ?>
    <?php } ?>
  </h4> 

    
  </body>
</html>
