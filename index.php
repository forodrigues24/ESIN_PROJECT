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




  <!-- Slides section -->
  <section class="slides-container">
    <div class="slides">
      <input type="radio" name="common" id="btn1" checked>
      <input type="radio" name="common" id="btn2">
      <input type="radio" name="common" id="btn3">

      <div class="image first">
        <img src="images/bg1.jpeg" alt="bg1">
      </div>
      <div class="image">
        <img src="images/bg2.jpg" alt="bg2">
      </div>
      <div class="image">
        <img src="images/bg3.jpg" alt="bg3">
      </div>

    </div>

    <div class="navigator">
      <label for="btn1" class="bar"></label>
      <label for="btn2" class="bar"></label>
      <label for="btn3" class="bar"></label>
    </div>
  </section>
  
  <!-- Info section -->
  <section class="info-section">
    <div class="info-card">
      <h2>12.450</h2>
      <p><strong>Pacientes atendidos em 2024</strong></p>
    </div>
    <div class="info-card">
      <h2>95%</h2>
      <p><strong>Taxa de satisfação</strong></p>
    </div>
    <div class="info-card">
      <h2>2.150</h2>
      <p><strong>Consultas por mês</strong></p>
    </div>
    <div class="info-card">
      <h2>1,5 M €</h2>
      <p><strong>Investido em Tecnologia Médica</strong></p>
    </div>
  </section>


  <!-- About section -->
  <section class="about-section">
    <h2>Sobre a Mediplus</h2>
    <p>Somos uma clínica dedicada a oferecer os melhores cuidados de saúde para nossos pacientes. Nossa missão é proporcionar um atendimento de excelência, com profissionais qualificados e uma estrutura moderna para garantir o bem-estar e a saúde de todos.
      Oferecemos uma gama de serviços médicos especializados, com foco em tratamentos personalizados. Nosso objetivo é proporcionar a melhor experiência de cuidado, com respeito e humanização.</p>
    <a href="sobre.html">Saiba mais</a>
  </section>

  <!-- Location section -->
  <section class="location-section">
    <h2>Onde estamos</h2>
    <iframe
      src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3105.779496735898!2d-8.6106519!3d41.1270329!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd2464d1d29d0b01%3A0x349f1753d4a48f56!2sCl%C3%ADnica%20Lus%C3%ADadas%20Gaia!5e0!3m2!1spt-PT!2spt!4v1697123456789!5m2!1spt-PT!2spt"
      width="900"
      height="450"
      style="border:0;"
      allowfullscreen=""
      loading="lazy"
      referrerpolicy="no-referrer-when-downgrade">
    </iframe>
    <p>Av. da República 1294, 4430-192 Vila Nova de Gaia</p>
  </section>

  <!-- News section -->
  <section class="news">
    <h2 class="news-header">Notícias</h2>
    <div class="news-item">
      <img src="images/news1.jpg" alt="News Image 1">
      <div class="news-content">
        <h3>Serviços Farmacêuticos da Mediplus somam prémios</h3>
        <p>O trabalho desenvolvido pela equipa de profissionais dos Serviços Farmacêuticos da Mediplusfoi distinguido, no último mês, por diferentes organizações científicas desta área.</p>
        <p id="news-date">06/12/2024</p>
      </div>
    </div>
    <div class="news-item">
      <img src="images/news2.jpg" alt="News Image 2">
      <div class="news-content">
        <h3>Tratamento inovador de taquicardia publicado em revista científica</h3>
        <p>Heart Rythm Case Reports publica artigo sobre a primeira intervenção em Portugal, feita por equipas da Mediplus.</p>
        <p id="news-date">02/12/2024</p>
      </div>
    </div>
    <div class="news-item">
      <img src="images/news3.jpg" alt="News Image 3">
      <div class="news-content">
        <h3>Medicamentos biológicos para intestino com comparticipação no privado</h3>
        <p>Medicamentos biológicos prescritos no setor privado para doenças do intestino passam a ser comparticipados, revela notícia da Lusa.</p>
        <p id="news-date">27/11/2024</p>
      </div>
    </div>
    <div class="news-item">
      <img src="images/news4.jpg" alt="News Image 4">
      <div class="news-content">
        <h3>Mediplus com novo robot para tratamento de arritmias cardíacas</h3>
        <p>Primeiras intervenções com novo sistema de navegação robótica, único no Mundo, realizadas esta semana na Mediplus.</p>
        <p id="news-date">19/11/2024</p>
      </div>
    </div>
    <div class="news-item">
      <img src="images/news5.jpg" alt="News Image 5">
      <div class="news-content">
        <h3>Mediplus ofereceu desfibrilhador a escola de Cerveira</h3>
        <p>Profissionais da Escola Básica e Secundária de Vila Nova de Cerveira também receberam formação especifica em DAE.</p>
        <p id="news-date">07/11/2024</p>
      </div>
    </div>
    <div class="news-item">
      <img src="images/news6.jpg" alt="News Image 6">
      <div class="news-content">
        <h3>Mediplus tem centro especializado em doenças da mama</h3>
        <p>Conheça o Centro da Mama, coordenado por Cristina Frutuoso, em destaque numa reportagem do Diário de Coimbra.</p>
        <p id="news-date">31/10/2024</p>
      </div>
    </div>
  </section>

</body>

</html>


</body>

</html>