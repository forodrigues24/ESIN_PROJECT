<?php
  // Para a pessoa poder sair da sua conta
  session_start();
  session_destroy();
  header('Location: ../index.php');
?>